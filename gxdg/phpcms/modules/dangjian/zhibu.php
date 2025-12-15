<?php
// 安全修复: 线上环境禁止开启 display_errors，避免暴露错误信息和服务器路径
// ini_set("display_errors", "On");
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class zhibu extends admin
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
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 查询是否已有党支部简介记录
        $this->db->table_name = 'v9_zhibu_jianjie';
        $info = $this->db->get_one('', '*', '', 'id DESC');

        // 如果是POST提交保存
        if (isset($_POST['dosubmit'])) {
            $jianjie = trim($_POST['info']['jianjie']);
            $fujian = trim($_POST['info']['fujian']);

            $data = array(
                'jianjie' => $jianjie,
                'fujian' => $fujian,
                'updatetime' => time()
            );

            if ($info && $info['id']) {
                // 更新现有记录
                $result = $this->db->update($data, " id=" . $info['id']);
                if ($result) {
                    showmessage('修改成功', '?m=dangjian&c=zhibu&a=init');
                } else {
                    showmessage('修改失败', HTTP_REFERER);
                }
            } else {
                // 新增记录
                $data['addtime'] = time();
                $result = $this->db->insert($data);
                if ($result) {
                    showmessage('添加成功', '?m=dangjian&c=zhibu&a=init');
                } else {
                    showmessage('添加失败', HTTP_REFERER);
                }
            }
            exit;
        }

        // 处理附件图片URL（支持JSON格式多图片）
        if ($info && !empty($info['fujian'])) {
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

        $this->info = $info ? $info : array('jianjie' => '', 'fujian' => '');
        include $this->admin_tpl('zhibu_jianjie_form');
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
        $upload_path = 'uploadfile/dangjian/zhibu/' . date('Ymd') . '/';
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

    // ==================== 党支部成员基本信息 ====================

    // 党支部成员列表
    public function baseinfo()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 使用 JOIN 查询党支部成员列表，关联辅警表获取详细信息
        $db_config = pc_base::load_config('database');
        pc_base::load_sys_class('db_factory', '', 0);
        $dbb = db_factory::get_instance($db_config)->get_database('gxdgdb');

        // 显式指定数据库名 fujing
        $sql = "SELECT zb.*, zb.id as zb_id, fj.*
                FROM fujing.v9_zhibu_chengyuan zb
                INNER JOIN fujing.v9_fujing fj ON zb.fujing_id = fj.id
                ORDER BY zb.id DESC";
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

        include $this->admin_tpl('zhibu_chengyuan_list');
    }

    // 添加党支部成员页面
    public function baseinfo_add()
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

        $this->xueli = $xueli;
        $this->gangwei = $gangwei;
        $this->zhiwu = $zhiwu;
        $this->cengji = $cengji;
        $this->select_categorys = $select_categorys;

        include $this->admin_tpl('zhibu_chengyuan_add');
    }

    // 搜索辅警的AJAX接口（复用）
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

    // 获取辅警详细信息的AJAX接口（复用）
    public function getfujinginfo()
    {
        $id = intval($_POST['id']);
        if (!$id) {
            echo json_encode(array('status' => 0, 'msg' => '参数错误'));
            exit;
        }

        // 查询辅警信息
        $this->db->table_name = 'v9_fujing';
        $info = $this->db->get_one(" id=$id ", '*');
        if (!$info) {
            echo json_encode(array('status' => 0, 'msg' => '辅警信息不存在'));
            exit;
        }

        // 处理照片URL
        if (!empty($info['thumb'])) {
            if (strpos($info['thumb'], 'http://') !== 0 && strpos($info['thumb'], 'https://') !== 0) {
                $upload_url = pc_base::load_config('system', 'upload_url');
                $thumb_path = str_replace('uploadfile/', '', $info['thumb']);
                $info['thumb'] = $upload_url . $thumb_path;
            }
        }

        // 处理时间格式 - 将Unix时间戳转换为日期格式
        // 处理出生日期：如果是时间戳则转换，如果已经是日期格式则保持
        if (!empty($info['shengri'])) {
            // 判断是否为纯数字（时间戳）
            if (is_numeric($info['shengri']) && $info['shengri'] > 0) {
                $info['shengri'] = date('Y-m-d', $info['shengri']);
            }
            // 如果已经是日期格式字符串，则不处理
        }

        if (!empty($info['rdzztime']) && $info['rdzztime'] > 0) {
            $info['rdzztime'] = date('Y-m-d', $info['rdzztime']);
        } else {
            $info['rdzztime'] = '';
        }

        if (!empty($info['scgztime']) && $info['scgztime'] > 0) {
            $info['scgztime'] = date('Y-m-d', $info['scgztime']);
        } else {
            $info['scgztime'] = '';
        }

        echo json_encode(array('status' => 1, 'data' => $info));
        exit;
    }

    // 保存添加的党支部成员信息
    public function baseinfo_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $fujing_id = intval($_POST['fujing_id']);

            if (!$fujing_id) {
                showmessage('请选择辅警', HTTP_REFERER);
            }

            // 检查是否已存在
            $this->db->table_name = 'v9_zhibu_chengyuan';
            $exists = $this->db->get_one(" fujing_id=$fujing_id ");
            if ($exists) {
                showmessage('该辅警已经是党支部成员，请勿重复添加', HTTP_REFERER);
            }

            // 插入数据
            $data = array(
                'fujing_id' => $fujing_id
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=zhibu&a=baseinfo');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 删除党支部成员
    public function baseinfo_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 删除党支部成员记录
        $this->db->table_name = 'v9_zhibu_chengyuan';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=zhibu&a=baseinfo');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // ==================== 三会一课 ====================

    // 三会一课列表
    public function three()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 查询三会一课记录
        $this->db->table_name = 'v9_sanhui_yike';
        $list = $this->db->select('', '*', '', 'id DESC');

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

            // 处理参会人员名称显示（已存储为姓名字符串，逗号分隔）
            if (!empty($item['canhui_renyuan'])) {
                // 将逗号替换为顿号
                $item['canhui_renyuan_show'] = str_replace(',', '、', $item['canhui_renyuan']);
            } else {
                $item['canhui_renyuan_show'] = '';
            }
        }

        $this->list = $list;
        include $this->admin_tpl('sanhui_list');
    }

    // 添加三会一课
    public function three_add()
    {
        // 加载辅警列表
        $this->db->table_name = 'v9_fujing';
        $fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
        $this->fjlist = $fjlist;

        include $this->admin_tpl('sanhui_add');
    }

    // 保存添加三会一课
    public function three_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            // 获取参会人员（已经是逗号分隔的字符串）
            $canhui_renyuan = isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '';
            $theme = trim($_POST['info']['theme']);
            $content = trim($_POST['info']['content']);
            $meeting_time = strtotime($_POST['info']['meeting_time']);
            $fujian = trim($_POST['info']['fujian']);

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 插入数据
            $this->db->table_name = 'v9_sanhui_yike';
            $data = array(
                'canhui_renyuan' => $canhui_renyuan,
                'theme' => $theme,
                'content' => $content,
                'meeting_time' => $meeting_time,
                'fujian' => $fujian,
                'addtime' => time(),
                'updatetime' => time()
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=zhibu&a=three');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑三会一课
    public function three_edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 查询记录
        $this->db->table_name = 'v9_sanhui_yike';
        $info = $this->db->get_one(" id=$id ", '*');
        if (!$info) {
            showmessage('记录不存在', HTTP_REFERER);
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

        // 加载辅警列表
        $this->db->table_name = 'v9_fujing';
        $fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
        $this->fjlist = $fjlist;

        $this->info = $info;
        include $this->admin_tpl('sanhui_edit');
    }

    // 保存编辑三会一课
    public function three_editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            // 获取参会人员（已经是逗号分隔的字符串）
            $canhui_renyuan = isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '';
            $theme = trim($_POST['info']['theme']);
            $content = trim($_POST['info']['content']);
            $meeting_time = strtotime($_POST['info']['meeting_time']);
            $fujian = trim($_POST['info']['fujian']);

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_sanhui_yike';
            $data = array(
                'canhui_renyuan' => $canhui_renyuan,
                'theme' => $theme,
                'content' => $content,
                'meeting_time' => $meeting_time,
                'fujian' => $fujian,
                'updatetime' => time()
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result) {
                showmessage('修改成功', '?m=dangjian&c=zhibu&a=three');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除三会一课
    public function three_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_sanhui_yike';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=zhibu&a=three');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // 上传三会一课附件图片
    public function upload_sanhui_image()
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
        $upload_path = 'uploadfile/dangjian/sanhui/' . date('Ymd') . '/';
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

    // ==================== 党支部品牌创建 ====================

    // 党支部品牌创建列表
    public function brand()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 查询品牌创建记录
        $this->db->table_name = 'v9_zhibu_pinpai';
        $list = $this->db->select('', '*', '', 'id DESC');

        // 处理数据
        foreach ($list as &$item) {
            // 处理时间格式
            if ($item['create_time'] > 0) {
                $item['create_time_show'] = date("Y-m-d", $item['create_time']);
            }

            // 处理LOGO图片URL（支持JSON格式多图片）
            if (!empty($item['logo'])) {
                $upload_url = pc_base::load_config('system', 'upload_url');

                // 尝试解析JSON格式
                $logo_array = json_decode($item['logo'], true);
                if (is_array($logo_array)) {
                    // 处理JSON数组中的每个URL
                    foreach ($logo_array as &$url) {
                        if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                            $logo_path = str_replace('uploadfile/', '', $url);
                            $url = $upload_url . $logo_path;
                        }
                    }
                    $item['logo'] = json_encode($logo_array);
                } else {
                    // 兼容旧格式：单个URL字符串
                    if (strpos($item['logo'], 'http://') !== 0 && strpos($item['logo'], 'https://') !== 0) {
                        $logo_path = str_replace('uploadfile/', '', $item['logo']);
                        $item['logo'] = $upload_url . $logo_path;
                    }
                }
            }
        }

        $this->list = $list;
        include $this->admin_tpl('brand_list');
    }

    // 添加党支部品牌创建
    public function brand_add()
    {
        include $this->admin_tpl('brand_add');
    }

    // 保存添加党支部品牌创建
    public function brand_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $theme = trim($_POST['info']['theme']);
            $create_time = strtotime($_POST['info']['create_time']);
            $logo = trim($_POST['info']['logo']);
            $jianjie = trim($_POST['info']['jianjie']);
            $liangdian = trim($_POST['info']['liangdian']);

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 插入数据
            $this->db->table_name = 'v9_zhibu_pinpai';
            $data = array(
                'theme' => $theme,
                'create_time' => $create_time,
                'logo' => $logo,
                'jianjie' => $jianjie,
                'liangdian' => $liangdian,
                'addtime' => time(),
                'updatetime' => time()
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=zhibu&a=brand');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑党支部品牌创建
    public function brand_edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 查询记录
        $this->db->table_name = 'v9_zhibu_pinpai';
        $info = $this->db->get_one(" id=$id ", '*');
        if (!$info) {
            showmessage('记录不存在', HTTP_REFERER);
        }

        // 处理时间格式
        if ($info['create_time'] > 0) {
            $info['create_time_show'] = date("Y-m-d", $info['create_time']);
        }

        // 处理LOGO图片URL（支持JSON格式多图片）
        if (!empty($info['logo'])) {
            $upload_url = pc_base::load_config('system', 'upload_url');

            // 尝试解析JSON格式
            $logo_array = json_decode($info['logo'], true);
            if (is_array($logo_array)) {
                // 处理JSON数组中的每个URL
                foreach ($logo_array as &$url) {
                    if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                        $logo_path = str_replace('uploadfile/', '', $url);
                        $url = $upload_url . $logo_path;
                    }
                }
                $info['logo'] = json_encode($logo_array);
            } else {
                // 兼容旧格式：单个URL字符串
                if (strpos($info['logo'], 'http://') !== 0 && strpos($info['logo'], 'https://') !== 0) {
                    $logo_path = str_replace('uploadfile/', '', $info['logo']);
                    $info['logo'] = $upload_url . $logo_path;
                }
            }
        }

        $this->info = $info;
        include $this->admin_tpl('brand_edit');
    }

    // 保存编辑党支部品牌创建
    public function brand_editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            $theme = trim($_POST['info']['theme']);
            $create_time = strtotime($_POST['info']['create_time']);
            $logo = trim($_POST['info']['logo']);
            $jianjie = trim($_POST['info']['jianjie']);
            $liangdian = trim($_POST['info']['liangdian']);

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_zhibu_pinpai';
            $data = array(
                'theme' => $theme,
                'create_time' => $create_time,
                'logo' => $logo,
                'jianjie' => $jianjie,
                'liangdian' => $liangdian,
                'updatetime' => time()
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result) {
                showmessage('修改成功', '?m=dangjian&c=zhibu&a=brand');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除党支部品牌创建
    public function brand_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_zhibu_pinpai';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=zhibu&a=brand');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // 上传品牌LOGO图片
    public function upload_brand_image()
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
        $upload_path = 'uploadfile/dangjian/brand/' . date('Ymd') . '/';
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

    // ==================== 党课模块 ====================

    // 党课管理（单记录模式）
    public function dangke()
    {
        // 查询是否已有党课记录
        $this->db->table_name = 'v9_dangke';
        $info = $this->db->get_one('', '*', '', 'id DESC');

        // 如果是POST提交保存
        if (isset($_POST['dosubmit'])) {
            $neirong = trim($_POST['info']['neirong']);
            $fujian = trim($_POST['info']['fujian']);

            $data = array(
                'neirong' => $neirong,
                'fujian' => $fujian,
                'updatetime' => time()
            );

            if ($info && $info['id']) {
                // 更新现有记录
                $result = $this->db->update($data, " id=" . $info['id']);
                if ($result) {
                    showmessage('修改成功', '?m=dangjian&c=zhibu&a=dangke');
                } else {
                    showmessage('修改失败', HTTP_REFERER);
                }
            } else {
                // 新增记录
                $data['addtime'] = time();
                $result = $this->db->insert($data);
                if ($result) {
                    showmessage('添加成功', '?m=dangjian&c=zhibu&a=dangke');
                } else {
                    showmessage('添加失败', HTTP_REFERER);
                }
            }
            exit;
        }

        // 处理附件图片URL（支持JSON格式多图片）
        if ($info && !empty($info['fujian'])) {
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

        $this->info = $info ? $info : array('neirong' => '', 'fujian' => '');
        include $this->admin_tpl('dangke_form');
    }

    // 上传党课附件图片
    public function upload_dangke_image()
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
        $upload_path = 'uploadfile/dangjian/dangke/' . date('Ymd') . '/';
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

    // ==================== 组织生活会模块 ====================

    // 组织生活会管理（单记录模式）
    public function shenghuohui()
    {
        // 查询是否已有组织生活会记录
        $this->db->table_name = 'v9_shenghuohui';
        $info = $this->db->get_one('', '*', '', 'id DESC');

        // 如果是POST提交保存
        if (isset($_POST['dosubmit'])) {
            $neirong = trim($_POST['info']['neirong']);
            $fujian = trim($_POST['info']['fujian']);

            $data = array(
                'neirong' => $neirong,
                'fujian' => $fujian,
                'updatetime' => time()
            );

            if ($info && $info['id']) {
                // 更新现有记录
                $result = $this->db->update($data, " id=" . $info['id']);
                if ($result) {
                    showmessage('修改成功', '?m=dangjian&c=zhibu&a=shenghuohui');
                } else {
                    showmessage('修改失败', HTTP_REFERER);
                }
            } else {
                // 新增记录
                $data['addtime'] = time();
                $result = $this->db->insert($data);
                if ($result) {
                    showmessage('添加成功', '?m=dangjian&c=zhibu&a=shenghuohui');
                } else {
                    showmessage('添加失败', HTTP_REFERER);
                }
            }
            exit;
        }

        // 处理附件图片URL（支持JSON格式多图片）
        if ($info && !empty($info['fujian'])) {
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

        $this->info = $info ? $info : array('neirong' => '', 'fujian' => '');
        include $this->admin_tpl('shenghuohui_form');
    }

    // 上传组织生活会附件图片
    public function upload_shenghuohui_image()
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
        $upload_path = 'uploadfile/dangjian/shenghuohui/' . date('Ymd') . '/';
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

    // ==================== 培养发展党员情况模块 ====================

    // 培养发展党员情况列表
    public function peiyangfazhan()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 查询培养发展党员情况记录
        $this->db->table_name = 'v9_peiyangfazhan';
        $list = $this->db->select('', '*', '', 'id DESC');

        // 处理数据
        foreach ($list as &$item) {
            // 处理时间格式
            if ($item['meeting_time'] > 0) {
                $item['meeting_time_show'] = date("Y-m-d", $item['meeting_time']);
            }

            // 处理参会人员名称显示
            if (!empty($item['canhui_renyuan'])) {
                $item['canhui_renyuan_show'] = str_replace(',', '、', $item['canhui_renyuan']);
            } else {
                $item['canhui_renyuan_show'] = '';
            }
        }

        $this->list = $list;
        include $this->admin_tpl('peiyangfazhan_list');
    }

    // 添加培养发展党员情况页面
    public function peiyangfazhan_add()
    {
        include $this->admin_tpl('peiyangfazhan_add');
    }

    // 保存添加的培养发展党员情况
    public function peiyangfazhan_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $theme = trim($_POST['info']['theme']);
            $meeting_time = strtotime($_POST['info']['meeting_time']);
            $content = trim($_POST['info']['content']);
            $jingzhuang_photo = trim($_POST['info']['jingzhuang_photo']);
            $canhui_renyuan = trim($_POST['info']['canhui_renyuan']);

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 插入数据
            $this->db->table_name = 'v9_peiyangfazhan';
            $data = array(
                'theme' => $theme,
                'meeting_time' => $meeting_time,
                'content' => $content,
                'jingzhuang_photo' => $jingzhuang_photo,
                'canhui_renyuan' => $canhui_renyuan,
                'addtime' => time(),
                'updatetime' => time()
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=zhibu&a=peiyangfazhan');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑培养发展党员情况页面
    public function peiyangfazhan_edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_peiyangfazhan';
        $info = $this->db->get_one(" id=$id ");

        if (!$info) {
            showmessage('记录不存在', HTTP_REFERER);
        }

        // 处理时间格式显示
        if ($info['meeting_time'] > 0) {
            $info['meeting_time_show'] = date('Y-m-d', $info['meeting_time']);
        }

        $this->info = $info;
        include $this->admin_tpl('peiyangfazhan_edit');
    }

    // 保存编辑的培养发展党员情况
    public function peiyangfazhan_editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            $theme = trim($_POST['info']['theme']);
            $meeting_time = strtotime($_POST['info']['meeting_time']);
            $content = trim($_POST['info']['content']);
            $jingzhuang_photo = trim($_POST['info']['jingzhuang_photo']);
            $canhui_renyuan = trim($_POST['info']['canhui_renyuan']);

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_peiyangfazhan';
            $data = array(
                'theme' => $theme,
                'meeting_time' => $meeting_time,
                'content' => $content,
                'jingzhuang_photo' => $jingzhuang_photo,
                'canhui_renyuan' => $canhui_renyuan,
                'updatetime' => time()
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result) {
                showmessage('修改成功', '?m=dangjian&c=zhibu&a=peiyangfazhan');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除培养发展党员情况
    public function peiyangfazhan_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_peiyangfazhan';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=zhibu&a=peiyangfazhan');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // 上传个人警装照片
    public function upload_peiyangfazhan_image()
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
        $upload_path = 'uploadfile/dangjian/peiyangfazhan/' . date('Ymd') . '/';
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

    // ==================== 开展警示教育情况模块 ====================

    // 开展警示教育情况列表
    public function jingshijiaoyu()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 查询开展警示教育情况记录
        $this->db->table_name = 'v9_jingshijiaoyu';
        $list = $this->db->select('', '*', '', 'id DESC');

        // 处理数据
        foreach ($list as &$item) {
            // 处理时间格式
            if ($item['meeting_time'] > 0) {
                $item['meeting_time_show'] = date("Y-m-d", $item['meeting_time']);
            }

            // 处理参会人员名称显示
            if (!empty($item['canhui_renyuan'])) {
                $item['canhui_renyuan_show'] = str_replace(',', '、', $item['canhui_renyuan']);
            } else {
                $item['canhui_renyuan_show'] = '';
            }
        }

        $this->list = $list;
        include $this->admin_tpl('jingshijiaoyu_list');
    }

    // 添加开展警示教育情况页面
    public function jingshijiaoyu_add()
    {
        include $this->admin_tpl('jingshijiaoyu_add');
    }

    // 保存添加的开展警示教育情况
    public function jingshijiaoyu_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $theme = trim($_POST['info']['theme']);
            $meeting_time = strtotime($_POST['info']['meeting_time']);
            $content = trim($_POST['info']['content']);
            $jingzhuang_photo = trim($_POST['info']['jingzhuang_photo']);
            $canhui_renyuan = trim($_POST['info']['canhui_renyuan']);

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 插入数据
            $this->db->table_name = 'v9_jingshijiaoyu';
            $data = array(
                'theme' => $theme,
                'meeting_time' => $meeting_time,
                'content' => $content,
                'jingzhuang_photo' => $jingzhuang_photo,
                'canhui_renyuan' => $canhui_renyuan,
                'addtime' => time(),
                'updatetime' => time()
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=zhibu&a=jingshijiaoyu');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑开展警示教育情况页面
    public function jingshijiaoyu_edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_jingshijiaoyu';
        $info = $this->db->get_one(" id=$id ");

        if (!$info) {
            showmessage('记录不存在', HTTP_REFERER);
        }

        // 处理时间格式显示
        if ($info['meeting_time'] > 0) {
            $info['meeting_time_show'] = date('Y-m-d', $info['meeting_time']);
        }

        $this->info = $info;
        include $this->admin_tpl('jingshijiaoyu_edit');
    }

    // 保存编辑的开展警示教育情况
    public function jingshijiaoyu_editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            $theme = trim($_POST['info']['theme']);
            $meeting_time = strtotime($_POST['info']['meeting_time']);
            $content = trim($_POST['info']['content']);
            $jingzhuang_photo = trim($_POST['info']['jingzhuang_photo']);
            $canhui_renyuan = trim($_POST['info']['canhui_renyuan']);

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_jingshijiaoyu';
            $data = array(
                'theme' => $theme,
                'meeting_time' => $meeting_time,
                'content' => $content,
                'jingzhuang_photo' => $jingzhuang_photo,
                'canhui_renyuan' => $canhui_renyuan,
                'updatetime' => time()
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result) {
                showmessage('修改成功', '?m=dangjian&c=zhibu&a=jingshijiaoyu');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除开展警示教育情况
    public function jingshijiaoyu_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_jingshijiaoyu';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=zhibu&a=jingshijiaoyu');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // 上传个人警装照片
    public function upload_jingshijiaoyu_image()
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
        $upload_path = 'uploadfile/dangjian/jingshijiaoyu/' . date('Ymd') . '/';
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

    // ==================== 开展主题党日情况模块 ====================

    // 开展主题党日情况列表
    public function zhutidangri()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 查询开展主题党日情况记录
        $this->db->table_name = 'v9_zhutidangri';
        $list = $this->db->select('', '*', '', 'id DESC');

        // 处理数据
        foreach ($list as &$item) {
            // 处理时间格式
            if ($item['meeting_time'] > 0) {
                $item['meeting_time_show'] = date("Y-m-d", $item['meeting_time']);
            }

            // 处理参会人员名称显示
            if (!empty($item['canhui_renyuan'])) {
                $item['canhui_renyuan_show'] = str_replace(',', '、', $item['canhui_renyuan']);
            } else {
                $item['canhui_renyuan_show'] = '';
            }
        }

        $this->list = $list;
        include $this->admin_tpl('zhutidangri_list');
    }

    // 添加开展主题党日情况页面
    public function zhutidangri_add()
    {
        include $this->admin_tpl('zhutidangri_add');
    }

    // 保存添加的开展主题党日情况
    public function zhutidangri_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $theme = trim($_POST['info']['theme']);
            $meeting_time = strtotime($_POST['info']['meeting_time']);
            $content = trim($_POST['info']['content']);
            $jingzhuang_photo = trim($_POST['info']['jingzhuang_photo']);
            $canhui_renyuan = trim($_POST['info']['canhui_renyuan']);

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 插入数据
            $this->db->table_name = 'v9_zhutidangri';
            $data = array(
                'theme' => $theme,
                'meeting_time' => $meeting_time,
                'content' => $content,
                'jingzhuang_photo' => $jingzhuang_photo,
                'canhui_renyuan' => $canhui_renyuan,
                'addtime' => time(),
                'updatetime' => time()
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=zhibu&a=zhutidangri');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑开展主题党日情况页面
    public function zhutidangri_edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_zhutidangri';
        $info = $this->db->get_one(" id=$id ");

        if (!$info) {
            showmessage('记录不存在', HTTP_REFERER);
        }

        // 处理时间格式显示
        if ($info['meeting_time'] > 0) {
            $info['meeting_time_show'] = date('Y-m-d', $info['meeting_time']);
        }

        $this->info = $info;
        include $this->admin_tpl('zhutidangri_edit');
    }

    // 保存编辑的开展主题党日情况
    public function zhutidangri_editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            $theme = trim($_POST['info']['theme']);
            $meeting_time = strtotime($_POST['info']['meeting_time']);
            $content = trim($_POST['info']['content']);
            $jingzhuang_photo = trim($_POST['info']['jingzhuang_photo']);
            $canhui_renyuan = trim($_POST['info']['canhui_renyuan']);

            if (!$theme) {
                showmessage('请输入主题', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_zhutidangri';
            $data = array(
                'theme' => $theme,
                'meeting_time' => $meeting_time,
                'content' => $content,
                'jingzhuang_photo' => $jingzhuang_photo,
                'canhui_renyuan' => $canhui_renyuan,
                'updatetime' => time()
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result) {
                showmessage('修改成功', '?m=dangjian&c=zhibu&a=zhutidangri');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除开展主题党日情况
    public function zhutidangri_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_zhutidangri';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=zhibu&a=zhutidangri');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // 上传个人警装照片
    public function upload_zhutidangri_image()
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
        $upload_path = 'uploadfile/dangjian/zhutidangri/' . date('Ymd') . '/';
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

    // ==================== 党费收缴 ====================

    // 党费收缴列表
    public function dangfeishoujiao()
    {
        $this->db->table_name = 'v9_dangfeishoujiao';
        $list = $this->db->select('', '*', '', 'id DESC');

        // 处理列表显示数据
        if (is_array($list)) {
            foreach ($list as &$item) {
                // 时间格式化
                if ($item['meeting_time'] > 0) {
                    $item['meeting_time_show'] = date('Y-m-d', $item['meeting_time']);
                } else {
                    $item['meeting_time_show'] = '';
                }

                // 参与人员显示（只显示前3个）
                if (!empty($item['canyu_renyuan'])) {
                    $renyuan_arr = explode(',', $item['canyu_renyuan']);
                    $item['canyu_renyuan_show'] = count($renyuan_arr) > 3
                        ? implode('、', array_slice($renyuan_arr, 0, 3)) . '...'
                        : implode('、', $renyuan_arr);
                } else {
                    $item['canyu_renyuan_show'] = '';
                }

                // 金额格式化
                if ($item['jiaona_jine'] > 0) {
                    $item['jiaona_jine_show'] = number_format($item['jiaona_jine'], 2);
                } else {
                    $item['jiaona_jine_show'] = '0.00';
                }
            }
        }

        $this->list = $list;
        include $this->admin_tpl('dangfeishoujiao_list');
    }

    // 党费收缴添加页面
    public function dangfeishoujiao_add()
    {
        include $this->admin_tpl('dangfeishoujiao_add');
    }

    // 党费收缴添加保存
    public function dangfeishoujiao_addsave()
    {
        $theme = trim($_POST['info']['theme']);
        $meeting_time = trim($_POST['info']['meeting_time']);
        $zhengshou_qingkuang = trim($_POST['info']['zhengshou_qingkuang']);
        $jiaona_jine = trim($_POST['info']['jiaona_jine']);
        $fujian_tupian = trim($_POST['info']['fujian_tupian']);
        $canyu_renyuan = trim($_POST['info']['canyu_renyuan']);

        // 时间转换
        $meeting_time_unix = 0;
        if (!empty($meeting_time)) {
            $meeting_time_unix = strtotime($meeting_time);
        }

        $data = array(
            'theme' => $theme,
            'meeting_time' => $meeting_time_unix,
            'zhengshou_qingkuang' => $zhengshou_qingkuang,
            'jiaona_jine' => $jiaona_jine,
            'fujian_tupian' => $fujian_tupian,
            'canyu_renyuan' => $canyu_renyuan,
            'addtime' => time(),
            'updatetime' => time()
        );

        $this->db->table_name = 'v9_dangfeishoujiao';
        $result = $this->db->insert($data);

        if ($result) {
            showmessage('添加成功', '?m=dangjian&c=zhibu&a=dangfeishoujiao');
        } else {
            showmessage('添加失败', HTTP_REFERER);
        }
    }

    // 党费收缴编辑页面
    public function dangfeishoujiao_edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_dangfeishoujiao';
        $info = $this->db->get_one(" id=$id ");

        if (!$info) {
            showmessage('记录不存在', HTTP_REFERER);
        }

        // 处理时间格式显示
        if ($info['meeting_time'] > 0) {
            $info['meeting_time_show'] = date('Y-m-d', $info['meeting_time']);
        }

        // 处理附件图片URL（支持JSON格式多图片）
        if (!empty($info['fujian_tupian'])) {
            $upload_url = pc_base::load_config('system', 'upload_url');
            $fujian_array = json_decode($info['fujian_tupian'], true);
            if (is_array($fujian_array)) {
                foreach ($fujian_array as &$url) {
                    if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                        $fujian_path = str_replace('uploadfile/', '', $url);
                        $url = $upload_url . $fujian_path;
                    }
                }
                $info['fujian_tupian'] = json_encode($fujian_array);
            }
        }

        $this->info = $info;
        include $this->admin_tpl('dangfeishoujiao_edit');
    }

    // 党费收缴编辑保存
    public function dangfeishoujiao_editsave()
    {
        $id = intval($_POST['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $theme = trim($_POST['info']['theme']);
        $meeting_time = trim($_POST['info']['meeting_time']);
        $zhengshou_qingkuang = trim($_POST['info']['zhengshou_qingkuang']);
        $jiaona_jine = trim($_POST['info']['jiaona_jine']);
        $fujian_tupian = trim($_POST['info']['fujian_tupian']);
        $canyu_renyuan = trim($_POST['info']['canyu_renyuan']);

        // 时间转换
        $meeting_time_unix = 0;
        if (!empty($meeting_time)) {
            $meeting_time_unix = strtotime($meeting_time);
        }

        $data = array(
            'theme' => $theme,
            'meeting_time' => $meeting_time_unix,
            'zhengshou_qingkuang' => $zhengshou_qingkuang,
            'jiaona_jine' => $jiaona_jine,
            'fujian_tupian' => $fujian_tupian,
            'canyu_renyuan' => $canyu_renyuan,
            'updatetime' => time()
        );

        $this->db->table_name = 'v9_dangfeishoujiao';
        $result = $this->db->update($data, " id=$id ");

        if ($result) {
            showmessage('修改成功', '?m=dangjian&c=zhibu&a=dangfeishoujiao');
        } else {
            showmessage('修改失败', HTTP_REFERER);
        }
    }

    // 党费收缴删除
    public function dangfeishoujiao_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_dangfeishoujiao';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=zhibu&a=dangfeishoujiao');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // 上传附件图片
    public function upload_dangfeishoujiao_image()
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
        $upload_path = 'uploadfile/dangjian/dangfeishoujiao/' . date('Ymd') . '/';
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

}


