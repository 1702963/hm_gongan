<?php
// 安全修复: 线上环境禁止开启 display_errors，避免暴露错误信息和服务器路径
// ini_set("display_errors", "On");
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class chengyuan extends admin
{
    var $db;

    public function __construct()
    {
        $this->db = pc_base::load_model('opinion2_model');
        $this->db->table_name = 'v9_fujing';
        pc_base::load_app_func('global');
    }

    public function init()
    {
        // 分页参数
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
        $pagesize = 15;

        // 使用 JOIN 查询班子成员列表，关联辅警表获取详细信息（用于兼容旧数据）
        // 创建独立的数据库连接 dbb 用于 JOIN 查询
        $db_config = pc_base::load_config('database');
        pc_base::load_sys_class('db_factory', '', 0);
        $dbb = db_factory::get_instance($db_config)->get_database('gxdgdb');

        // 查询总数
        $count_sql = "SELECT COUNT(*) as cnt FROM fujing.v9_banzi_chengyuan bz INNER JOIN fujing.v9_fujing fj ON bz.fujing_id = fj.id";
        $dbb->query($count_sql);
        $count_row = $dbb->fetch_next();
        $total = $count_row['cnt'];

        // 计算分页
        $offset = $pagesize * ($page - 1);
        $pages = pages($total, $page, $pagesize, '', array(), 10);

        // 使用 COALESCE 优先使用班子成员表的字段，为空则使用辅警表字段
        $sql = "SELECT bz.id, bz.fujing_id,
                COALESCE(NULLIF(bz.xingming,''), fj.xingming) as xingming,
                COALESCE(NULLIF(bz.sex,''), fj.sex) as sex,
                COALESCE(NULLIF(bz.sfz,''), fj.sfz) as sfz,
                COALESCE(NULLIF(bz.shengri,''), fj.shengri) as shengri,
                COALESCE(bz.age, fj.age) as age,
                COALESCE(NULLIF(bz.tel,''), fj.tel) as tel,
                COALESCE(NULLIF(bz.xueli,''), fj.xueli) as xueli,
                COALESCE(NULLIF(bz.zhuanye,''), fj.zhuanye) as zhuanye,
                COALESCE(NULLIF(bz.xuexiao,''), fj.xuexiao) as xuexiao,
                COALESCE(bz.dwid, fj.dwid) as dwid,
                COALESCE(bz.gangwei, fj.gangwei) as gangwei,
                COALESCE(bz.zhiwu, fj.zhiwu) as zhiwu,
                COALESCE(bz.cengji, fj.cengji) as cengji,
                COALESCE(bz.rdzztime, fj.rdzztime) as rdzztime,
                COALESCE(bz.scgztime, fj.scgztime) as scgztime,
                COALESCE(NULLIF(bz.thumb,''), fj.thumb) as thumb,
                bz.ddanwei, bz.beizhu, bz.addtime, bz.updatetime
                FROM fujing.v9_banzi_chengyuan bz
                INNER JOIN fujing.v9_fujing fj ON bz.fujing_id = fj.id
                ORDER BY bz.id DESC
                LIMIT $offset, $pagesize";
        $dbb->query($sql);

        $this->list = array();
        while ($row = $dbb->fetch_next()) {
            // 处理照片URL
            if (!empty($row['thumb'])) {
                if (strpos($row['thumb'], 'http://') !== 0 && strpos($row['thumb'], 'https://') !== 0) {
                    $upload_url = pc_base::load_config('system', 'upload_url');
                    $thumb_path = str_replace('uploadfile/', '', $row['thumb']);
                    $row['thumb'] = $upload_url . $thumb_path;
                }
            }

            // 处理时间格式
            if ($row['shengri'] != '') {
                $row['shengri_show'] = $row['shengri'];
            }
            if ($row['rdzztime'] > 0) {
                $row['rdzztime_show'] = date("Y-m-d", $row['rdzztime']);
            }
            if ($row['scgztime'] > 0) {
                $row['scgztime_show'] = date("Y-m-d", $row['scgztime']);
            }

            $this->list[] = $row;
        }

        $this->pages = $pages;
        include $this->admin_tpl('banzi_list');
    }

    public function add()
    {
        // 加载辅警列表
        $this->db->table_name = 'v9_fujing';
        $fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming,sfz', '', 'xingming asc');

        // 加载学历数据
        $this->db->table_name = 'v9_xueli';
        $xllist = $this->db->select("", 'id,gwname', '', 'id asc');
        $xueli = array();
        foreach ($xllist as $v) {
            $xueli[$v['id']] = $v['gwname'];
        }

        // 加载岗位数据
        $this->db->table_name = 'v9_gangwei';
        $gwlist = $this->db->select("", 'id,gwname', '', 'id asc');
        $gangwei = array();
        foreach ($gwlist as $v) {
            $gangwei[$v['id']] = $v['gwname'];
        }

        // 加载职务数据
        $this->db->table_name = 'v9_zhiwu';
        $zwlist = $this->db->select("", 'id,zwname', '', 'id asc');
        $zhiwu = array();
        foreach ($zwlist as $v) {
            $zhiwu[$v['id']] = $v['zwname'];
        }

        // 加载层级数据
        $this->db->table_name = 'v9_cengji';
        $cjlist = $this->db->select("", 'id,cjname', '', 'id asc');
        $cengji = array();
        foreach ($cjlist as $v) {
            $cengji[$v['id']] = $v['cjname'];
        }

        // 绑定组织树
        $tree = pc_base::load_sys_class('tree');
        $this->db = pc_base::load_model('bumen_model');
        $result = $this->db->select();
        $array = array();
        foreach ($result as $r) {
            $r['cname'] = $r['name'];
            $r['selected'] = '';
            $array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$cname</option>";
        $tree->init($array);
        $select_categorys = $tree->get_tree(0, $str);

        include $this->admin_tpl('banzi_add');
    }

    // 搜索辅警的AJAX接口
    public function searchfujing()
    {
        $keyword = trim($_POST['keyword']);
        if (!$keyword) {
            echo json_encode(array('status' => 0, 'msg' => '请输入搜索关键词'));
            exit;
        }

        // 安全修复: 对用户输入进行转义，防止 SQL 注入
        $keyword = addslashes($keyword);

        // 搜索辅警（按姓名或身份证号）
        $this->db->table_name = 'v9_fujing';
        $where = " (xingming LIKE '%{$keyword}%' OR sfz LIKE '%{$keyword}%') AND status=1 AND isok=1 ";
        $list = $this->db->select($where, 'id,xingming,sex,sfz,dwid', '20', 'xingming asc');

        if ($list) {
            // 获取单位名称
            foreach ($list as &$item) {
                if ($item['dwid']) {
                    $bumen_db = pc_base::load_model('bumen_model');
                    $bumen = $bumen_db->get_one(array('id' => $item['dwid']));
                    $item['danwei'] = $bumen ? $bumen['name'] : '';
                } else {
                    $item['danwei'] = '';
                }
            }
            echo json_encode(array('status' => 1, 'data' => $list));
        } else {
            echo json_encode(array('status' => 0, 'msg' => '未找到匹配的辅警'));
        }
        exit;
    }

    // 获取辅警详细信息的AJAX接口
    public function getfujinginfo()
    {
        $id = intval($_POST['id']);
        if (!$id) {
            echo json_encode(array('status' => 0, 'msg' => '参数错误'));
            exit;
        }

        // 获取辅警基本信息
        $this->db->table_name = 'v9_fujing';
        $info = $this->db->get_one(" id=$id ", '*');

        if (!$info) {
            echo json_encode(array('status' => 0, 'msg' => '辅警信息不存在'));
            exit;
        }

        // 处理时间格式
        if ($info['shengri'] != '') {
            $info['shengri'] = $info['shengri'];
        }
        if ($info['rdzztime'] != 0) {
            $info['rdzztime'] = date("Y-m-d", $info['rdzztime']);
        } else {
            $info['rdzztime'] = '';
        }
        if ($info['scgztime'] != 0) {
            $info['scgztime'] = date("Y-m-d", $info['scgztime']);
        } else {
            $info['scgztime'] = '';
        }

        // 获取所获荣誉（从表彰表中）
        $this->db->table_name = 'v9_biaozhang';
        $bzlist = $this->db->select(" fjid=$id AND status=9 ", 'title,bztime', '5', 'bztime desc');
        $rongy = '';
        if ($bzlist) {
            $rongy_arr = array();
            foreach ($bzlist as $bz) {
                $bztime = date("Y年", $bz['bztime']);
                $rongy_arr[] = $bztime . ' ' . $bz['title'];
            }
            $rongy = implode("\n", $rongy_arr);
        }
        $info['rongy'] = $rongy;

        // 处理照片URL，如果不是完整URL则拼接域名
        if (!empty($info['thumb'])) {
            if (strpos($info['thumb'], 'http://') !== 0 && strpos($info['thumb'], 'https://') !== 0) {
                $upload_url = pc_base::load_config('system', 'upload_url');
                // 如果 thumb 以 uploadfile/ 开头，则去掉这个前缀
                $thumb_path = str_replace('uploadfile/', '', $info['thumb']);
                $info['thumb'] = $upload_url . $thumb_path;
            }
        }

        echo json_encode(array('status' => 1, 'data' => $info));
        exit;
    }

    // 保存添加的班子成员信息
    public function addbz()
    {
        if (isset($_POST['dosubmit'])) {
            $fujing_id = intval($_POST['fujing_id']);
            $ddanwei = trim($_POST['info']['ddanwei']);
            $beizhu = trim($_POST['info']['beizhu']);

            if (!$fujing_id) {
                showmessage('请选择辅警', HTTP_REFERER);
            }

            // 检查是否已存在
            $this->db->table_name = 'v9_banzi_chengyuan';
            $exists = $this->db->get_one(" fujing_id=$fujing_id ");
            if ($exists) {
                showmessage('该辅警已经是班子成员，请勿重复添加', HTTP_REFERER);
            }

            // 获取辅警完整信息
            $this->db->table_name = 'v9_fujing';
            $fjinfo = $this->db->get_one(" id=$fujing_id ", '*');
            if (!$fjinfo) {
                showmessage('辅警信息不存在', HTTP_REFERER);
            }

            // 插入数据（包含辅警完整信息）
            $this->db->table_name = 'v9_banzi_chengyuan';
            $data = array(
                'fujing_id' => $fujing_id,
                'xingming' => $fjinfo['xingming'],
                'sex' => $fjinfo['sex'],
                'sfz' => $fjinfo['sfz'],
                'shengri' => $fjinfo['shengri'],
                'age' => $fjinfo['age'],
                'tel' => $fjinfo['tel'],
                'xueli' => $fjinfo['xueli'],
                'zhuanye' => $fjinfo['zhuanye'],
                'xuexiao' => $fjinfo['xuexiao'],
                'dwid' => $fjinfo['dwid'],
                'gangwei' => $fjinfo['gangwei'],
                'zhiwu' => $fjinfo['zhiwu'],
                'cengji' => $fjinfo['cengji'],
                'rdzztime' => $fjinfo['rdzztime'],
                'scgztime' => $fjinfo['scgztime'],
                'thumb' => $fjinfo['thumb'],
                'ddanwei' => $ddanwei,
                'beizhu' => $beizhu,
                'addtime' => time(),
                'updatetime' => time(),
                'create_datetime' => date('Y-m-d H:i:s'),
                'create_year' => intval(date('Y')),
                'create_month' => intval(date('m')),
                'create_day' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=chengyuan&a=init');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    public function edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 查询班子成员信息
        $this->db->table_name = 'v9_banzi_chengyuan';
        $bzinfo = $this->db->get_one(" id=$id ");
        if (!$bzinfo) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        // 查询辅警详细信息（用于获取原始数据作为默认值）
        $this->db->table_name = 'v9_fujing';
        $fjinfo = $this->db->get_one(" id={$bzinfo['fujing_id']} ", '*');
        if (!$fjinfo) {
            showmessage('辅警信息不存在', HTTP_REFERER);
        }

        // 合并信息：班子成员表字段优先（如果有值），否则使用辅警表字段
        $info = $fjinfo;
        // 覆盖班子成员表中已有的字段
        $bz_fields = array('xingming', 'sex', 'sfz', 'shengri', 'age', 'tel', 'xueli', 'zhuanye', 'xuexiao', 'dwid', 'gangwei', 'zhiwu', 'cengji', 'rdzztime', 'scgztime', 'thumb', 'ddanwei', 'beizhu');
        foreach ($bz_fields as $field) {
            if (isset($bzinfo[$field]) && ($bzinfo[$field] !== null && $bzinfo[$field] !== '')) {
                $info[$field] = $bzinfo[$field];
            }
        }
        // 保留班子成员表的 id 和 fujing_id
        $info['id'] = $bzinfo['id'];
        $info['fujing_id'] = $bzinfo['fujing_id'];

        // 处理时间格式
        if ($info['shengri'] != '') {
            $info['shengri_show'] = $info['shengri'];
        }
        if ($info['rdzztime'] > 0) {
            $info['rdzztime_show'] = date("Y-m-d", $info['rdzztime']);
        }
        if ($info['scgztime'] > 0) {
            $info['scgztime_show'] = date("Y-m-d", $info['scgztime']);
        }

        // 处理照片URL
        if (!empty($info['thumb'])) {
            if (strpos($info['thumb'], 'http://') !== 0 && strpos($info['thumb'], 'https://') !== 0) {
                $upload_url = pc_base::load_config('system', 'upload_url');
                $thumb_path = str_replace('uploadfile/', '', $info['thumb']);
                $info['thumb'] = $upload_url . $thumb_path;
            }
        }

        // 加载学历数据
        $this->db->table_name = 'v9_xueli';
        $xllist = $this->db->select("", 'id,gwname', '', 'id asc');
        $xueli = array();
        foreach ($xllist as $v) {
            $xueli[$v['id']] = $v['gwname'];
        }

        // 加载岗位数据
        $this->db->table_name = 'v9_gangwei';
        $gwlist = $this->db->select("", 'id,gwname', '', 'id asc');
        $gangwei = array();
        foreach ($gwlist as $v) {
            $gangwei[$v['id']] = $v['gwname'];
        }

        // 加载职务数据
        $this->db->table_name = 'v9_zhiwu';
        $zwlist = $this->db->select("", 'id,zwname', '', 'id asc');
        $zhiwu = array();
        // Bug修复: 原代码错误地遍历空数组 $zhiwu，应遍历查询结果 $zwlist
        foreach ($zwlist as $v) {
            $zhiwu[$v['id']] = $v['zwname'];
        }

        // 加载层级数据
        $this->db->table_name = 'v9_cengji';
        $cjlist = $this->db->select("", 'id,cjname', '', 'id asc');
        $cengji = array();
        foreach ($cjlist as $v) {
            $cengji[$v['id']] = $v['cjname'];
        }

        // 绑定组织树
        $tree = pc_base::load_sys_class('tree');
        $this->db = pc_base::load_model('bumen_model');
        $result = $this->db->select();
        $array = array();
        foreach ($result as $r) {
            $r['cname'] = $r['name'];
            $r['selected'] = $r['id'] == $info['dwid'] ? 'selected' : '';
            $array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$cname</option>";
        $tree->init($array);
        $select_categorys = $tree->get_tree(0, $str);

        include $this->admin_tpl('banzi_edit');
    }

    // 保存编辑的班子成员信息
    public function editbz()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            $info = $_POST['info'];

            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            // 处理时间字段
            $rdzztime = !empty($info['rdzztime']) ? strtotime($info['rdzztime']) : 0;
            $scgztime = !empty($info['scgztime']) ? strtotime($info['scgztime']) : 0;

            // 更新班子成员表（包含所有辅警字段）
            $this->db->table_name = 'v9_banzi_chengyuan';
            $data = array(
                'xingming' => trim($info['xingming']),
                'sex' => trim($info['sex']),
                'sfz' => trim($info['sfz']),
                'shengri' => trim($info['shengri']),
                'age' => intval($info['age']),
                'tel' => trim($info['tel']),
                'xueli' => trim($info['xueli']),
                'zhuanye' => trim($info['zhuanye']),
                'xuexiao' => trim($info['xuexiao']),
                'dwid' => intval($info['dwid']),
                'gangwei' => intval($info['gangwei']),
                'zhiwu' => intval($info['zhiwu']),
                'cengji' => intval($info['cengji']),
                'rdzztime' => $rdzztime,
                'scgztime' => $scgztime,
                'ddanwei' => trim($info['ddanwei']),
                'beizhu' => trim($info['beizhu']),
                'updatetime' => time()
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result) {
                showmessage('修改成功', '?m=dangjian&c=chengyuan&a=init');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除班子成员
    public function del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 删除班子成员记录
        $this->db->table_name = 'v9_banzi_chengyuan';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=chengyuan&a=init');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // ==================== 双重组织生活情况 ====================

    // 双重组织生活列表
    public function shuangchongzuzhi()
    {
        // 分页参数
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

        // 会议类型筛选
        $huiyi_type = isset($_GET['huiyi_type']) ? trim($_GET['huiyi_type']) : '';
        $where = '';
        if ($huiyi_type != '') {
            $where = "huiyi_type = '" . addslashes($huiyi_type) . "'";
        }
        $this->huiyi_type = $huiyi_type;

        // 查询双重组织生活记录
        $this->db->table_name = 'v9_shuangchong_zuzhi';
        $list = $this->db->listinfo($where, 'id DESC', $page, 15);
        $pages = $this->db->pages;

        // 处理数据
        foreach ($list as &$item) {
            // 处理时间格式
            if ($item['meeting_time'] > 0) {
                $item['meeting_time_show'] = date("Y-m-d", $item['meeting_time']);
            }

            // 处理附件图片URL（支持JSON格式多图片）
            if (!empty($item['fujian'])) {
                $upload_url = pc_base::load_config('system', 'upload_url');

                // 尝试解析JSON格式
                $fujian_array = json_decode($item['fujian'], true);
                if (is_array($fujian_array)) {
                    // 处理JSON数组中的每个URL
                    foreach ($fujian_array as &$url) {
                        if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                            $fujian_path = str_replace('uploadfile/', '', $url);
                            $url = $upload_url . $fujian_path;
                        }
                    }
                    $item['fujian'] = json_encode($fujian_array);
                } else {
                    // 兼容旧格式：单个URL字符串
                    if (strpos($item['fujian'], 'http://') !== 0 && strpos($item['fujian'], 'https://') !== 0) {
                        $fujian_path = str_replace('uploadfile/', '', $item['fujian']);
                        $item['fujian'] = $upload_url . $fujian_path;
                    }
                }
            }
        }

        $this->list = $list;
        $this->pages = $pages;
        include $this->admin_tpl('shuangchong_list');
    }

    // 添加双重组织生活
    public function sczz_add()
    {
        // 加载辅警列表
        $this->db->table_name = 'v9_fujing';
        $fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
        $this->fjlist = $fjlist;

        include $this->admin_tpl('shuangchong_add');
    }

    // 保存添加
    public function sczz_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $huiyi_type = trim($_POST['info']['huiyi_type']);
            // 获取参会人员（已经是逗号分隔的字符串）
            $canhui_renyuan = isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '';
            $title = trim($_POST['info']['title']);
            $content = trim($_POST['info']['content']);
            $meeting_time = strtotime($_POST['info']['meeting_time']);
            $fujian = trim($_POST['info']['fujian']);

            if (!$title) {
                showmessage('请输入标题', HTTP_REFERER);
            }

            // 插入数据
            $this->db->table_name = 'v9_shuangchong_zuzhi';
            $data = array(
                'huiyi_type' => $huiyi_type,
                'canhui_renyuan' => $canhui_renyuan,
                'title' => $title,
                'content' => $content,
                'meeting_time' => $meeting_time,
                'fujian' => $fujian,
                'addtime' => time(),
                'updatetime' => time(),
                'create_datetime' => date('Y-m-d H:i:s'),
                'create_year' => intval(date('Y')),
                'create_month' => intval(date('m')),
                'create_day' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=chengyuan&a=shuangchongzuzhi');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑双重组织生活
    public function sczz_edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 查询记录
        $this->db->table_name = 'v9_shuangchong_zuzhi';
        $info = $this->db->get_one(" id=$id ");
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        // 处理时间格式
        if ($info['meeting_time'] > 0) {
            $info['meeting_time_show'] = date("Y-m-d", $info['meeting_time']);
        }

        // 处理附件图片URL（支持JSON格式多图片）
        if (!empty($info['fujian'])) {
            $upload_url = pc_base::load_config('system', 'upload_url');

            // 尝试解析JSON格式
            $fujian_array = json_decode($info['fujian'], true);
            if (is_array($fujian_array)) {
                // 处理JSON数组中的每个URL
                foreach ($fujian_array as &$url) {
                    if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                        $fujian_path = str_replace('uploadfile/', '', $url);
                        $url = $upload_url . $fujian_path;
                    }
                }
                $info['fujian'] = json_encode($fujian_array);
            } else {
                // 兼容旧格式：单个URL字符串
                if (strpos($info['fujian'], 'http://') !== 0 && strpos($info['fujian'], 'https://') !== 0) {
                    $fujian_path = str_replace('uploadfile/', '', $info['fujian']);
                    $info['fujian'] = $upload_url . $fujian_path;
                }
            }
        }

        // 将参会人员字符串转换为数组
        $info['canhui_renyuan_arr'] = array();
        if (!empty($info['canhui_renyuan'])) {
            $info['canhui_renyuan_arr'] = explode(',', $info['canhui_renyuan']);
        }

        // 加载辅警列表
        $this->db->table_name = 'v9_fujing';
        $fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
        $this->fjlist = $fjlist;

        $this->info = $info;
        include $this->admin_tpl('shuangchong_edit');
    }

    // 保存编辑
    public function sczz_editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            $huiyi_type = trim($_POST['info']['huiyi_type']);
            // 获取参会人员（已经是逗号分隔的字符串）
            $canhui_renyuan = isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '';
            $title = trim($_POST['info']['title']);
            $content = trim($_POST['info']['content']);
            $meeting_time = strtotime($_POST['info']['meeting_time']);
            $fujian = trim($_POST['info']['fujian']);

            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            if (!$title) {
                showmessage('请输入标题', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_shuangchong_zuzhi';
            $data = array(
                'huiyi_type' => $huiyi_type,
                'canhui_renyuan' => $canhui_renyuan,
                'title' => $title,
                'content' => $content,
                'meeting_time' => $meeting_time,
                'fujian' => $fujian,
                'updatetime' => time()
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result) {
                showmessage('修改成功', '?m=dangjian&c=chengyuan&a=shuangchongzuzhi');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除双重组织生活
    public function sczz_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_shuangchong_zuzhi';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=chengyuan&a=shuangchongzuzhi');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // 上传附件图片
    public function upload_fujian_image()
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_FILES['file'])) {
            echo json_encode(array('status' => 0, 'msg' => '未选择文件'));
            exit;
        }

        $file = $_FILES['file'];

        // 检查上传错误
        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(array('status' => 0, 'msg' => '上传失败，错误代码：' . $file['error']));
            exit;
        }

        // 检查文件类型（Content-Type 检查，可被伪造，需配合扩展名白名单）
        $allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
        if (!in_array($file['type'], $allowed_types)) {
            echo json_encode(array('status' => 0, 'msg' => '只允许上传图片文件'));
            exit;
        }

        // 安全修复: 扩展名白名单验证，防止上传恶意文件
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($ext, $allowed_exts)) {
            echo json_encode(array('status' => 0, 'msg' => '只允许上传 jpg、jpeg、png、gif 格式的图片'));
            exit;
        }

        // 检查文件大小（限制5MB）
        if ($file['size'] > 5 * 1024 * 1024) {
            echo json_encode(array('status' => 0, 'msg' => '文件大小不能超过5MB'));
            exit;
        }

        // 生成保存路径
        $upload_path = 'uploadfile/dangjian/shuangchong/' . date('Y/md') . '/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // 生成文件名（扩展名已在上方验证）
        $filename = date('YmdHis') . '_' . rand(1000, 9999) . '.' . $ext;
        $filepath = $upload_path . $filename;

        // 移动上传文件
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // 返回成功信息和文件路径
            echo json_encode(array(
                'status' => 1,
                'msg' => '上传成功',
                'url' => $filepath
            ));
        } else {
            echo json_encode(array('status' => 0, 'msg' => '文件保存失败'));
        }
        exit;
    }

    // ==================== 谈心谈话 ====================

    // 谈心谈话列表
    public function tanxintanhua()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 分页参数
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

        // 查询谈心谈话记录
        $this->db->table_name = 'v9_tanxintanhua';
        $list = $this->db->listinfo('', 'id DESC', $page, 15);
        $pages = $this->db->pages;

        // 处理数据
        foreach ($list as &$item) {
            // 处理时间格式
            if ($item['talk_time'] > 0) {
                $item['talk_time_show'] = date("Y-m-d", $item['talk_time']);
            }

            // 处理附件图片URL（支持JSON格式多图片）
            if (!empty($item['fujian'])) {
                $upload_url = pc_base::load_config('system', 'upload_url');

                // 尝试解析JSON格式
                $fujian_array = json_decode($item['fujian'], true);
                if (is_array($fujian_array)) {
                    // 处理JSON数组中的每个URL
                    foreach ($fujian_array as &$url) {
                        if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                            $fujian_path = str_replace('uploadfile/', '', $url);
                            $url = $upload_url . $fujian_path;
                        }
                    }
                    $item['fujian'] = json_encode($fujian_array);
                } else {
                    // 兼容旧格式：单个URL字符串
                    if (strpos($item['fujian'], 'http://') !== 0 && strpos($item['fujian'], 'https://') !== 0) {
                        $fujian_path = str_replace('uploadfile/', '', $item['fujian']);
                        $item['fujian'] = $upload_url . $fujian_path;
                    }
                }
            }
        }

        $this->list = $list;
        $this->pages = $pages;
        include $this->admin_tpl('tanxintanhua_list');
    }

    // 添加谈心谈话
    public function tanxintanhua_add()
    {
        // 加载辅警列表
        $this->db->table_name = 'v9_fujing';
        $fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
        $this->fjlist = $fjlist;

        include $this->admin_tpl('tanxintanhua_add');
    }

    // 保存添加
    public function tanxintanhua_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            // 获取谈话人员（已经是逗号分隔的字符串）
            $tanhua_renyuan = isset($_POST['info']['tanhua_renyuan']) ? trim($_POST['info']['tanhua_renyuan']) : '';
            $theme = trim($_POST['info']['theme']);
            $location = trim($_POST['info']['location']);
            $talk_time = strtotime($_POST['info']['talk_time']);
            $fujian = trim($_POST['info']['fujian']);

            if (!$theme) {
                showmessage('请输入谈话主题', HTTP_REFERER);
            }

            // 插入数据
            $this->db->table_name = 'v9_tanxintanhua';
            $data = array(
                'tanhua_renyuan' => $tanhua_renyuan,
                'theme' => $theme,
                'location' => $location,
                'talk_time' => $talk_time,
                'fujian' => $fujian,
                'addtime' => time(),
                'updatetime' => time(),
                'create_datetime' => date('Y-m-d H:i:s'),
                'create_year' => intval(date('Y')),
                'create_month' => intval(date('m')),
                'create_day' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=chengyuan&a=tanxintanhua');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑谈心谈话
    public function tanxintanhua_edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 查询记录
        $this->db->table_name = 'v9_tanxintanhua';
        $info = $this->db->get_one(" id=$id ");
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        // 处理时间格式
        if ($info['talk_time'] > 0) {
            $info['talk_time_show'] = date("Y-m-d", $info['talk_time']);
        }

        // 处理附件图片URL（支持JSON格式多图片）
        if (!empty($info['fujian'])) {
            $upload_url = pc_base::load_config('system', 'upload_url');

            // 尝试解析JSON格式
            $fujian_array = json_decode($info['fujian'], true);
            if (is_array($fujian_array)) {
                // 处理JSON数组中的每个URL
                foreach ($fujian_array as &$url) {
                    if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                        $fujian_path = str_replace('uploadfile/', '', $url);
                        $url = $upload_url . $fujian_path;
                    }
                }
                $info['fujian'] = json_encode($fujian_array);
            } else {
                // 兼容旧格式：单个URL字符串
                if (strpos($info['fujian'], 'http://') !== 0 && strpos($info['fujian'], 'https://') !== 0) {
                    $fujian_path = str_replace('uploadfile/', '', $info['fujian']);
                    $info['fujian'] = $upload_url . $fujian_path;
                }
            }
        }

        // 加载辅警列表
        $this->db->table_name = 'v9_fujing';
        $fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
        $this->fjlist = $fjlist;

        $this->info = $info;
        include $this->admin_tpl('tanxintanhua_edit');
    }

    // 保存编辑
    public function tanxintanhua_editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            // 获取谈话人员（已经是逗号分隔的字符串）
            $tanhua_renyuan = isset($_POST['info']['tanhua_renyuan']) ? trim($_POST['info']['tanhua_renyuan']) : '';
            $theme = trim($_POST['info']['theme']);
            $location = trim($_POST['info']['location']);
            $talk_time = strtotime($_POST['info']['talk_time']);
            $fujian = trim($_POST['info']['fujian']);

            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            if (!$theme) {
                showmessage('请输入谈话主题', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_tanxintanhua';
            $data = array(
                'tanhua_renyuan' => $tanhua_renyuan,
                'theme' => $theme,
                'location' => $location,
                'talk_time' => $talk_time,
                'fujian' => $fujian,
                'updatetime' => time()
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result) {
                showmessage('修改成功', '?m=dangjian&c=chengyuan&a=tanxintanhua');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除谈心谈话
    public function tanxintanhua_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_tanxintanhua';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=chengyuan&a=tanxintanhua');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // ==================== 一岗双责 ====================

    // 一岗双责列表
    public function yigangshuangze()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 分页参数
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

        // 查询一岗双责记录
        $this->db->table_name = 'v9_yigangshuangze';
        $list = $this->db->listinfo('', 'id DESC', $page, 15);
        $pages = $this->db->pages;

        // 处理数据
        foreach ($list as &$item) {
            // 处理时间格式
            if ($item['content_time'] > 0) {
                $item['content_time_show'] = date("Y-m-d", $item['content_time']);
            }

            // 处理附件图片URL（支持JSON格式多图片）
            if (!empty($item['fujian'])) {
                $upload_url = pc_base::load_config('system', 'upload_url');

                // 尝试解析JSON格式
                $fujian_array = json_decode($item['fujian'], true);
                if (is_array($fujian_array)) {
                    // 处理JSON数组中的每个URL
                    foreach ($fujian_array as &$url) {
                        if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                            $fujian_path = str_replace('uploadfile/', '', $url);
                            $url = $upload_url . $fujian_path;
                        }
                    }
                    $item['fujian'] = json_encode($fujian_array);
                } else {
                    // 兼容旧格式：单个URL字符串
                    if (strpos($item['fujian'], 'http://') !== 0 && strpos($item['fujian'], 'https://') !== 0) {
                        $fujian_path = str_replace('uploadfile/', '', $item['fujian']);
                        $item['fujian'] = $upload_url . $fujian_path;
                    }
                }
            }
        }

        $this->list = $list;
        $this->pages = $pages;
        include $this->admin_tpl('yigangshuangze_list');
    }

    // 添加一岗双责
    public function yigangshuangze_add()
    {
        include $this->admin_tpl('yigangshuangze_add');
    }

    // 保存添加
    public function yigangshuangze_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $theme = trim($_POST['info']['theme']);
            $content = trim($_POST['info']['content']);
            $content_time = strtotime($_POST['info']['content_time']);
            $fujian = trim($_POST['info']['fujian']);

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 插入数据
            $this->db->table_name = 'v9_yigangshuangze';
            $data = array(
                'theme' => $theme,
                'content' => $content,
                'content_time' => $content_time,
                'fujian' => $fujian,
                'addtime' => time(),
                'updatetime' => time(),
                'create_datetime' => date('Y-m-d H:i:s'),
                'create_year' => intval(date('Y')),
                'create_month' => intval(date('m')),
                'create_day' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=chengyuan&a=yigangshuangze');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑一岗双责
    public function yigangshuangze_edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 查询记录
        $this->db->table_name = 'v9_yigangshuangze';
        $info = $this->db->get_one(" id=$id ");
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        // 处理时间格式
        if ($info['content_time'] > 0) {
            $info['content_time_show'] = date("Y-m-d", $info['content_time']);
        }

        // 处理附件图片URL（支持JSON格式多图片）
        if (!empty($info['fujian'])) {
            $upload_url = pc_base::load_config('system', 'upload_url');

            // 尝试解析JSON格式
            $fujian_array = json_decode($info['fujian'], true);
            if (is_array($fujian_array)) {
                // 处理JSON数组中的每个URL
                foreach ($fujian_array as &$url) {
                    if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                        $fujian_path = str_replace('uploadfile/', '', $url);
                        $url = $upload_url . $fujian_path;
                    }
                }
                $info['fujian'] = json_encode($fujian_array);
            } else {
                // 兼容旧格式：单个URL字符串
                if (strpos($info['fujian'], 'http://') !== 0 && strpos($info['fujian'], 'https://') !== 0) {
                    $fujian_path = str_replace('uploadfile/', '', $info['fujian']);
                    $info['fujian'] = $upload_url . $fujian_path;
                }
            }
        }

        $this->info = $info;
        include $this->admin_tpl('yigangshuangze_edit');
    }

    // 保存编辑
    public function yigangshuangze_editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            $theme = trim($_POST['info']['theme']);
            $content = trim($_POST['info']['content']);
            $content_time = strtotime($_POST['info']['content_time']);
            $fujian = trim($_POST['info']['fujian']);

            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_yigangshuangze';
            $data = array(
                'theme' => $theme,
                'content' => $content,
                'content_time' => $content_time,
                'fujian' => $fujian,
                'updatetime' => time()
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result) {
                showmessage('修改成功', '?m=dangjian&c=chengyuan&a=yigangshuangze');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除一岗双责
    public function yigangshuangze_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_yigangshuangze';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=chengyuan&a=yigangshuangze');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // ==================== 践行"四下基层"情况 ====================

    // 四下基层列表
    public function sixiajiceng()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 分页参数
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

        // 查询四下基层记录
        $this->db->table_name = 'v9_sixiajiceng';
        $list = $this->db->listinfo('', 'id DESC', $page, 15);
        $pages = $this->db->pages;

        // 处理数据
        foreach ($list as &$item) {
            // 处理时间格式
            if ($item['activity_time'] > 0) {
                $item['activity_time_show'] = date("Y-m-d", $item['activity_time']);
            }

            // 处理附件图片URL（支持JSON格式多图片）
            if (!empty($item['fujian'])) {
                $upload_url = pc_base::load_config('system', 'upload_url');

                // 尝试解析JSON格式
                $fujian_array = json_decode($item['fujian'], true);
                if (is_array($fujian_array)) {
                    // 处理JSON数组中的每个URL
                    foreach ($fujian_array as &$url) {
                        if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                            $fujian_path = str_replace('uploadfile/', '', $url);
                            $url = $upload_url . $fujian_path;
                        }
                    }
                    $item['fujian'] = json_encode($fujian_array);
                } else {
                    // 兼容旧格式：单个URL字符串
                    if (strpos($item['fujian'], 'http://') !== 0 && strpos($item['fujian'], 'https://') !== 0) {
                        $fujian_path = str_replace('uploadfile/', '', $item['fujian']);
                        $item['fujian'] = $upload_url . $fujian_path;
                    }
                }
            }
        }

        $this->list = $list;
        $this->pages = $pages;
        include $this->admin_tpl('sixiajiceng_list');
    }

    // 添加四下基层记录
    public function sixiajiceng_add()
    {
        include $this->admin_tpl('sixiajiceng_add');
    }

    // 保存添加
    public function sixiajiceng_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $theme = trim($_POST['info']['theme']);
            $location = trim($_POST['info']['location']);
            $activity_time = strtotime($_POST['info']['activity_time']);
            $problem_count = intval($_POST['info']['problem_count']);
            $service_count = intval($_POST['info']['service_count']);
            $fujian = trim($_POST['info']['fujian']);

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 插入数据
            $this->db->table_name = 'v9_sixiajiceng';
            $data = array(
                'theme' => $theme,
                'location' => $location,
                'activity_time' => $activity_time,
                'problem_count' => $problem_count,
                'service_count' => $service_count,
                'fujian' => $fujian,
                'addtime' => time(),
                'updatetime' => time(),
                'create_datetime' => date('Y-m-d H:i:s'),
                'create_year' => intval(date('Y')),
                'create_month' => intval(date('m')),
                'create_day' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=chengyuan&a=sixiajiceng');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑四下基层记录
    public function sixiajiceng_edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 查询记录
        $this->db->table_name = 'v9_sixiajiceng';
        $info = $this->db->get_one(" id=$id ");
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        // 处理时间格式
        if ($info['activity_time'] > 0) {
            $info['activity_time_show'] = date("Y-m-d", $info['activity_time']);
        }

        // 处理附件图片URL（支持JSON格式多图片）
        if (!empty($info['fujian'])) {
            $upload_url = pc_base::load_config('system', 'upload_url');

            // 尝试解析JSON格式
            $fujian_array = json_decode($info['fujian'], true);
            if (is_array($fujian_array)) {
                // 处理JSON数组中的每个URL
                foreach ($fujian_array as &$url) {
                    if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                        $fujian_path = str_replace('uploadfile/', '', $url);
                        $url = $upload_url . $fujian_path;
                    }
                }
                $info['fujian'] = json_encode($fujian_array);
            } else {
                // 兼容旧格式：单个URL字符串
                if (strpos($info['fujian'], 'http://') !== 0 && strpos($info['fujian'], 'https://') !== 0) {
                    $fujian_path = str_replace('uploadfile/', '', $info['fujian']);
                    $info['fujian'] = $upload_url . $fujian_path;
                }
            }
        }

        $this->info = $info;
        include $this->admin_tpl('sixiajiceng_edit');
    }

    // 保存编辑
    public function sixiajiceng_editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            $theme = trim($_POST['info']['theme']);
            $location = trim($_POST['info']['location']);
            $activity_time = strtotime($_POST['info']['activity_time']);
            $problem_count = intval($_POST['info']['problem_count']);
            $service_count = intval($_POST['info']['service_count']);
            $fujian = trim($_POST['info']['fujian']);

            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_sixiajiceng';
            $data = array(
                'theme' => $theme,
                'location' => $location,
                'activity_time' => $activity_time,
                'problem_count' => $problem_count,
                'service_count' => $service_count,
                'fujian' => $fujian,
                'updatetime' => time()
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result) {
                showmessage('修改成功', '?m=dangjian&c=chengyuan&a=sixiajiceng');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除四下基层记录
    public function sixiajiceng_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_sixiajiceng';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=chengyuan&a=sixiajiceng');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

}


