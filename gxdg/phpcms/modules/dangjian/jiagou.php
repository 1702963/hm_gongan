<?php

// 安全修复: 线上环境禁止开启 display_errors，避免暴露错误信息和服务器路径
// ini_set("display_errors", "On");
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class jiagou extends admin
{
    var $db;

    public function __construct()
    {
        $this->db = pc_base::load_model('opinion2_model');
        $this->db->table_name = 'v9_fujing';
        pc_base::load_app_func('global');
    }

    public function menu()
    {
        include $this->admin_tpl('jiagou_menu');
    }


    // ==================== 党员个人信息 ====================

    // 党员个人信息列表
    public function init()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 使用 JOIN 查询党员列表，关联辅警表获取详细信息
        $db_config = pc_base::load_config('database');
        pc_base::load_sys_class('db_factory', '', 0);
        $dbb = db_factory::get_instance($db_config)->get_database('gxdgdb');

        // 显式指定数据库名 fujing
        $sql = "SELECT dy.*, dy.id as dy_id, fj.*
                FROM fujing.v9_dangyuan_info dy
                INNER JOIN fujing.v9_fujing fj ON dy.fujing_id = fj.id
                ORDER BY dy.id DESC";
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

        include $this->admin_tpl('dangyuan_list');
    }

    // 添加党员页面
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

        $this->xueli = $xueli;
        $this->gangwei = $gangwei;
        $this->zhiwu = $zhiwu;
        $this->cengji = $cengji;
        $this->select_categorys = $select_categorys;

        include $this->admin_tpl('dangyuan_add');
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

        // 处理时间格式
        if (!empty($info['shengri'])) {
            if (is_numeric($info['shengri']) && $info['shengri'] > 0) {
                $info['shengri'] = date('Y-m-d', $info['shengri']);
            }
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

    // 保存添加的党员信息
    public function addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $fujing_id = intval($_POST['fujing_id']);

            if (!$fujing_id) {
                showmessage('请选择辅警', HTTP_REFERER);
            }

            // 检查是否已存在
            $this->db->table_name = 'v9_dangyuan_info';
            $exists = $this->db->get_one(" fujing_id=$fujing_id ");
            if ($exists) {
                showmessage('该辅警已经是党员，请勿重复添加', HTTP_REFERER);
            }

            // 插入数据
            $data = array(
                'fujing_id' => $fujing_id,
                'addtime' => time(),
                'updatetime' => time(),
                'create_datetime' => date('Y-m-d H:i:s'),
                'create_year' => intval(date('Y')),
                'create_month' => intval(date('m')),
                'create_day' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=jiagou&a=init');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 删除党员
    public function del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 删除党员记录
        $this->db->table_name = 'v9_dangyuan_info';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=jiagou&a=init');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }


    // ==================== 入党积极分子 ====================

    // 入党积极分子列表
    public function jijifenzi()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 使用 JOIN 查询入党积极分子列表，关联辅警表获取详细信息
        $db_config = pc_base::load_config('database');
        pc_base::load_sys_class('db_factory', '', 0);
        $dbb = db_factory::get_instance($db_config)->get_database('gxdgdb');

        $sql = "SELECT jj.*, jj.id as jj_id, fj.*
                FROM fujing.v9_jijifenzi jj
                INNER JOIN fujing.v9_fujing fj ON jj.fujing_id = fj.id
                ORDER BY jj.id DESC";
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

        include $this->admin_tpl('jijifenzi_list');
    }

    // 添加入党积极分子页面
    public function jijifenzi_add()
    {
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

        include $this->admin_tpl('jijifenzi_add');
    }

    // 保存添加的入党积极分子信息
    public function jijifenzi_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $fujing_id = intval($_POST['fujing_id']);

            if (!$fujing_id) {
                showmessage('请选择辅警', HTTP_REFERER);
            }

            // 检查是否已存在
            $this->db->table_name = 'v9_jijifenzi';
            $exists = $this->db->get_one(" fujing_id=$fujing_id ");
            if ($exists) {
                showmessage('该辅警已经是入党积极分子，请勿重复添加', HTTP_REFERER);
            }

            // 插入数据
            $data = array(
                'fujing_id' => $fujing_id,
                'addtime' => time(),
                'updatetime' => time(),
                'create_datetime' => date('Y-m-d H:i:s'),
                'create_year' => intval(date('Y')),
                'create_month' => intval(date('m')),
                'create_day' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=jiagou&a=jijifenzi');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 删除入党积极分子
    public function jijifenzi_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 删除入党积极分子记录
        $this->db->table_name = 'v9_jijifenzi';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=jiagou&a=jijifenzi');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }


    // ==================== 发展党员情况 ====================

    // 发展党员情况列表
    public function fazhandangyuan()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 使用 JOIN 查询发展党员列表，关联辅警表获取详细信息
        $db_config = pc_base::load_config('database');
        pc_base::load_sys_class('db_factory', '', 0);
        $dbb = db_factory::get_instance($db_config)->get_database('gxdgdb');

        $sql = "SELECT fz.*, fz.id as fz_id, fj.*
                FROM fujing.v9_fazhandangyuan fz
                INNER JOIN fujing.v9_fujing fj ON fz.fujing_id = fj.id
                ORDER BY fz.id DESC";
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

        include $this->admin_tpl('fazhandangyuan_list');
    }

    // 添加发展党员页面
    public function fazhandangyuan_add()
    {
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

        include $this->admin_tpl('fazhandangyuan_add');
    }

    // 保存添加的发展党员信息
    public function fazhandangyuan_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $fujing_id = intval($_POST['fujing_id']);

            if (!$fujing_id) {
                showmessage('请选择辅警', HTTP_REFERER);
            }

            // 检查是否已存在
            $this->db->table_name = 'v9_fazhandangyuan';
            $exists = $this->db->get_one(" fujing_id=$fujing_id ");
            if ($exists) {
                showmessage('该辅警已经是发展党员，请勿重复添加', HTTP_REFERER);
            }

            // 插入数据
            $data = array(
                'fujing_id' => $fujing_id,
                'addtime' => time(),
                'updatetime' => time(),
                'create_datetime' => date('Y-m-d H:i:s'),
                'create_year' => intval(date('Y')),
                'create_month' => intval(date('m')),
                'create_day' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=jiagou&a=fazhandangyuan');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 删除发展党员
    public function fazhandangyuan_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 删除发展党员记录
        $this->db->table_name = 'v9_fazhandangyuan';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=jiagou&a=fazhandangyuan');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }


    // ==================== 预备党员情况 ====================

    // 预备党员情况列表
    public function yubeidangyuan()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 使用 JOIN 查询预备党员列表，关联辅警表获取详细信息
        $db_config = pc_base::load_config('database');
        pc_base::load_sys_class('db_factory', '', 0);
        $dbb = db_factory::get_instance($db_config)->get_database('gxdgdb');

        $sql = "SELECT yb.*, yb.id as yb_id, fj.*
                FROM fujing.v9_yubeidangyuan yb
                INNER JOIN fujing.v9_fujing fj ON yb.fujing_id = fj.id
                ORDER BY yb.id DESC";
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

        include $this->admin_tpl('yubeidangyuan_list');
    }

    // 添加预备党员页面
    public function yubeidangyuan_add()
    {
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

        include $this->admin_tpl('yubeidangyuan_add');
    }

    // 保存添加的预备党员信息
    public function yubeidangyuan_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $fujing_id = intval($_POST['fujing_id']);

            if (!$fujing_id) {
                showmessage('请选择辅警', HTTP_REFERER);
            }

            // 检查是否已存在
            $this->db->table_name = 'v9_yubeidangyuan';
            $exists = $this->db->get_one(" fujing_id=$fujing_id ");
            if ($exists) {
                showmessage('该辅警已经是预备党员，请勿重复添加', HTTP_REFERER);
            }

            // 插入数据
            $data = array(
                'fujing_id' => $fujing_id,
                'addtime' => time(),
                'updatetime' => time(),
                'create_datetime' => date('Y-m-d H:i:s'),
                'create_year' => intval(date('Y')),
                'create_month' => intval(date('m')),
                'create_day' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=jiagou&a=yubeidangyuan');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 删除预备党员
    public function yubeidangyuan_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 删除预备党员记录
        $this->db->table_name = 'v9_yubeidangyuan';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=jiagou&a=yubeidangyuan');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }


    // ==================== 参加政治理论学习培训情况 ====================

    // 理论学习列表
    public function lilunxuexi()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 查询理论学习记录
        $this->db->table_name = 'v9_lilunxuexi';
        $list = $this->db->select('', '*', '', 'id DESC');

        // 处理数据
        foreach ($list as &$item) {
            // 处理时间格式
            if ($item['study_time'] > 0) {
                $item['study_time_show'] = date("Y-m-d", $item['study_time']);
            }

            // 处理图片URL（支持JSON格式多图片）
            if (!empty($item['photos'])) {
                $upload_url = pc_base::load_config('system', 'upload_url');
                $photos_array = json_decode($item['photos'], true);
                if (is_array($photos_array)) {
                    foreach ($photos_array as &$url) {
                        if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                            $photo_path = str_replace('uploadfile/', '', $url);
                            $url = $upload_url . $photo_path;
                        }
                    }
                    $item['photos'] = json_encode($photos_array);
                }
            }
        }

        $this->list = $list;
        include $this->admin_tpl('lilunxuexi_list');
    }

    // 添加理论学习
    public function lilunxuexi_add()
    {
        include $this->admin_tpl('lilunxuexi_add');
    }

    // 保存添加
    public function lilunxuexi_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $canhui_renyuan = isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '';
            $theme = trim($_POST['info']['theme']);
            $study_time = strtotime($_POST['info']['study_time']);
            $content = trim($_POST['info']['content']);
            $photos = trim($_POST['info']['photos']);

            if (!$theme) {
                showmessage('请输入学习主题', HTTP_REFERER);
            }

            // 插入数据
            $this->db->table_name = 'v9_lilunxuexi';
            $data = array(
                'theme' => $theme,
                'study_time' => $study_time,
                'content' => $content,
                'photos' => $photos,
                'canhui_renyuan' => $canhui_renyuan,
                'addtime' => time(),
                'updatetime' => time(),
                'create_datetime' => date('Y-m-d H:i:s'),
                'create_year' => intval(date('Y')),
                'create_month' => intval(date('m')),
                'create_day' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=jiagou&a=lilunxuexi');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑理论学习
    public function lilunxuexi_edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 查询记录
        $this->db->table_name = 'v9_lilunxuexi';
        $info = $this->db->get_one(" id=$id ");
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        // 处理时间格式
        if ($info['study_time'] > 0) {
            $info['study_time_show'] = date("Y-m-d", $info['study_time']);
        }

        // 处理图片URL（支持JSON格式多图片）
        if (!empty($info['photos'])) {
            $upload_url = pc_base::load_config('system', 'upload_url');
            $photos_array = json_decode($info['photos'], true);
            if (is_array($photos_array)) {
                foreach ($photos_array as &$url) {
                    if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                        $photo_path = str_replace('uploadfile/', '', $url);
                        $url = $upload_url . $photo_path;
                    }
                }
                $info['photos'] = json_encode($photos_array);
            }
        }

        $this->info = $info;
        include $this->admin_tpl('lilunxuexi_edit');
    }

    // 保存编辑
    public function lilunxuexi_editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            $canhui_renyuan = isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '';
            $theme = trim($_POST['info']['theme']);
            $study_time = strtotime($_POST['info']['study_time']);
            $content = trim($_POST['info']['content']);
            $photos = trim($_POST['info']['photos']);

            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            if (!$theme) {
                showmessage('请输入学习主题', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_lilunxuexi';
            $data = array(
                'theme' => $theme,
                'study_time' => $study_time,
                'content' => $content,
                'photos' => $photos,
                'canhui_renyuan' => $canhui_renyuan,
                'updatetime' => time()
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result) {
                showmessage('修改成功', '?m=dangjian&c=jiagou&a=lilunxuexi');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除理论学习
    public function lilunxuexi_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_lilunxuexi';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=jiagou&a=lilunxuexi');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // 上传学习照片
    public function upload_lilunxuexi_image()
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

        // 检查文件类型
        $allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
        if (!in_array($file['type'], $allowed_types)) {
            echo json_encode(array('status' => 0, 'msg' => '只允许上传图片文件'));
            exit;
        }

        // 扩展名白名单验证
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
        $upload_path = 'uploadfile/dangjian/lilunxuexi/' . date('Ymd') . '/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // 生成文件名
        $filename = date('YmdHis') . '_' . rand(1000, 9999) . '.' . $ext;
        $filepath = $upload_path . $filename;

        // 移动上传文件
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
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


    // ==================== 党支部活动 ====================

    // 党支部活动列表
    public function dangzhibu()
    {
        setcookie('zq_hash', $_SESSION['pc_hash']);

        // 查询党支部活动记录
        $this->db->table_name = 'v9_dangzhibu';
        $list = $this->db->select('', '*', '', 'id DESC');

        // 处理数据
        foreach ($list as &$item) {
            // 处理时间格式
            if ($item['activity_time'] > 0) {
                $item['activity_time_show'] = date("Y-m-d", $item['activity_time']);
            }

            // 处理图片URL（支持JSON格式多图片）
            if (!empty($item['photos'])) {
                $upload_url = pc_base::load_config('system', 'upload_url');
                $photos_array = json_decode($item['photos'], true);
                if (is_array($photos_array)) {
                    foreach ($photos_array as &$url) {
                        if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                            $photo_path = str_replace('uploadfile/', '', $url);
                            $url = $upload_url . $photo_path;
                        }
                    }
                    $item['photos'] = json_encode($photos_array);
                }
            }
        }

        $this->list = $list;
        include $this->admin_tpl('dangzhibu_list');
    }

    // 添加党支部活动
    public function dangzhibu_add()
    {
        include $this->admin_tpl('dangzhibu_add');
    }

    // 保存添加
    public function dangzhibu_addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $canhui_renyuan = isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '';
            $theme = trim($_POST['info']['theme']);
            $activity_time = strtotime($_POST['info']['activity_time']);
            $content = trim($_POST['info']['content']);
            $photos = trim($_POST['info']['photos']);

            if (!$theme) {
                showmessage('请输入活动主题', HTTP_REFERER);
            }

            // 插入数据
            $this->db->table_name = 'v9_dangzhibu';
            $data = array(
                'theme' => $theme,
                'activity_time' => $activity_time,
                'content' => $content,
                'photos' => $photos,
                'canhui_renyuan' => $canhui_renyuan,
                'addtime' => time(),
                'updatetime' => time(),
                'create_datetime' => date('Y-m-d H:i:s'),
                'create_year' => intval(date('Y')),
                'create_month' => intval(date('m')),
                'create_day' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=dangjian&c=jiagou&a=dangzhibu');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑党支部活动
    public function dangzhibu_edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 查询记录
        $this->db->table_name = 'v9_dangzhibu';
        $info = $this->db->get_one(" id=$id ");
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        // 处理时间格式
        if ($info['activity_time'] > 0) {
            $info['activity_time_show'] = date("Y-m-d", $info['activity_time']);
        }

        // 处理图片URL（支持JSON格式多图片）
        if (!empty($info['photos'])) {
            $upload_url = pc_base::load_config('system', 'upload_url');
            $photos_array = json_decode($info['photos'], true);
            if (is_array($photos_array)) {
                foreach ($photos_array as &$url) {
                    if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                        $photo_path = str_replace('uploadfile/', '', $url);
                        $url = $upload_url . $photo_path;
                    }
                }
                $info['photos'] = json_encode($photos_array);
            }
        }

        $this->info = $info;
        include $this->admin_tpl('dangzhibu_edit');
    }

    // 保存编辑
    public function dangzhibu_editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            $canhui_renyuan = isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '';
            $theme = trim($_POST['info']['theme']);
            $activity_time = strtotime($_POST['info']['activity_time']);
            $content = trim($_POST['info']['content']);
            $photos = trim($_POST['info']['photos']);

            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            if (!$theme) {
                showmessage('请输入活动主题', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_dangzhibu';
            $data = array(
                'theme' => $theme,
                'activity_time' => $activity_time,
                'content' => $content,
                'photos' => $photos,
                'canhui_renyuan' => $canhui_renyuan,
                'updatetime' => time()
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result) {
                showmessage('修改成功', '?m=dangjian&c=jiagou&a=dangzhibu');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除党支部活动
    public function dangzhibu_del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_dangzhibu';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=dangjian&c=jiagou&a=dangzhibu');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // 上传活动照片
    public function upload_dangzhibu_image()
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

        // 检查文件类型
        $allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
        if (!in_array($file['type'], $allowed_types)) {
            echo json_encode(array('status' => 0, 'msg' => '只允许上传图片文件'));
            exit;
        }

        // 扩展名白名单验证
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
        $upload_path = 'uploadfile/dangjian/dangzhibu/' . date('Ymd') . '/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // 生成文件名
        $filename = date('YmdHis') . '_' . rand(1000, 9999) . '.' . $ext;
        $filepath = $upload_path . $filename;

        // 移动上传文件
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
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

    /**
     * 党关系变动情况 - 列表
     */
    public function guanxibiandong() {
        $sxty = isset($_GET['sxty']) ? intval($_GET['sxty']) : 3;

        $this->db->table_name = 'v9_guanxibiandong';
        $list = $this->db->select("sxty = $sxty", '*', '', 'id DESC');

        // 处理数据
        if (is_array($list)) {
            foreach ($list as &$row) {
                $row['biandong_date_show'] = $row['biandong_date'] ? date('Y-m-d', $row['biandong_date']) : '';
            }
        } else {
            $list = array();
        }

        include $this->admin_tpl('guanxibiandong_list');
    }

    /**
     * 党关系变动情况 - 添加页面
     */
    public function guanxibiandong_add() {
        $sxty = isset($_GET['sxty']) ? intval($_GET['sxty']) : 3;
        include $this->admin_tpl('guanxibiandong_add');
    }

    /**
     * 党关系变动情况 - 添加保存
     */
    public function guanxibiandong_addsave() {
        if (!isset($_POST['info']) || empty($_POST['info'])) {
            showmessage('数据不能为空', HTTP_REFERER);
        }

        $info = $_POST['info'];
        $sxty = isset($_POST['sxty']) ? intval($_POST['sxty']) : 3;

        $data = array(
            'sxty' => $sxty,
            'yuan_suozaidi' => isset($info['yuan_suozaidi']) ? trim($info['yuan_suozaidi']) : '',
            'xian_suozaidi' => isset($info['xian_suozaidi']) ? trim($info['xian_suozaidi']) : '',
            'renyuan' => isset($info['renyuan']) ? trim($info['renyuan']) : '',
            'photos' => isset($info['photos']) ? trim($info['photos']) : '',
            'addtime' => time(),
            'updatetime' => time(),
            'create_datetime' => date('Y-m-d H:i:s'),
            'create_year' => intval(date('Y')),
            'create_month' => intval(date('m')),
            'create_day' => intval(date('d'))
        );

        // 处理变动日期
        if (!empty($info['biandong_date'])) {
            $data['biandong_date'] = strtotime($info['biandong_date']);
        } else {
            $data['biandong_date'] = 0;
        }

        $this->db->table_name = 'v9_guanxibiandong';
        $this->db->insert($data);

        showmessage('添加成功', '?m=dangjian&c=jiagou&a=guanxibiandong&sxty=' . $sxty);
    }

    /**
     * 党关系变动情况 - 编辑页面
     */
    public function guanxibiandong_edit() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_guanxibiandong';
        $info = $this->db->get_one("id = $id");

        if (!$info) {
            showmessage('记录不存在', HTTP_REFERER);
        }

        // 格式化日期显示
        $info['biandong_date_show'] = $info['biandong_date'] ? date('Y-m-d', $info['biandong_date']) : '';

        $sxty = $info['sxty'];

        include $this->admin_tpl('guanxibiandong_edit');
    }

    /**
     * 党关系变动情况 - 编辑保存
     */
    public function guanxibiandong_editsave() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if ($id <= 0) {
            showmessage('参数错误', HTTP_REFERER);
        }

        if (!isset($_POST['info']) || empty($_POST['info'])) {
            showmessage('数据不能为空', HTTP_REFERER);
        }

        $info = $_POST['info'];
        $sxty = isset($_POST['sxty']) ? intval($_POST['sxty']) : 3;

        $data = array(
            'yuan_suozaidi' => isset($info['yuan_suozaidi']) ? trim($info['yuan_suozaidi']) : '',
            'xian_suozaidi' => isset($info['xian_suozaidi']) ? trim($info['xian_suozaidi']) : '',
            'renyuan' => isset($info['renyuan']) ? trim($info['renyuan']) : '',
            'photos' => isset($info['photos']) ? trim($info['photos']) : '',
            'updatetime' => time()
        );

        // 处理变动日期
        if (!empty($info['biandong_date'])) {
            $data['biandong_date'] = strtotime($info['biandong_date']);
        } else {
            $data['biandong_date'] = 0;
        }

        $this->db->table_name = 'v9_guanxibiandong';
        $this->db->update($data, "id = $id");

        showmessage('修改成功', '?m=dangjian&c=jiagou&a=guanxibiandong&sxty=' . $sxty);
    }

    /**
     * 党关系变动情况 - 删除
     */
    public function guanxibiandong_del() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $sxty = isset($_GET['sxty']) ? intval($_GET['sxty']) : 3;

        if ($id <= 0) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_guanxibiandong';
        $this->db->delete("id = $id");

        showmessage('删除成功', '?m=dangjian&c=jiagou&a=guanxibiandong&sxty=' . $sxty);
    }

    /**
     * 党关系变动情况 - 图片上传
     */
    public function upload_guanxibiandong_image() {
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(array('status' => 0, 'msg' => '上传失败'));
            exit;
        }

        $file = $_FILES['file'];

        // 扩展名白名单验证
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
        $upload_path = 'uploadfile/dangjian/guanxibiandong/' . date('Ymd') . '/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // 生成文件名
        $filename = date('YmdHis') . '_' . rand(1000, 9999) . '.' . $ext;
        $filepath = $upload_path . $filename;

        // 移动上传文件
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
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

    // ==================== 党员个人党费缴纳情况 ====================

    /**
     * 党费缴纳 - 列表
     */
    public function dangfei() {
        $this->db->table_name = 'v9_dangfei';
        $list = $this->db->select('', '*', '', 'id DESC');

        // 处理数据
        if (is_array($list)) {
            foreach ($list as &$row) {
                $row['pay_time_show'] = $row['pay_time'] ? date('Y-m-d', $row['pay_time']) : '';
            }
        } else {
            $list = array();
        }

        include $this->admin_tpl('dangfei_list');
    }

    /**
     * 党费缴纳 - 添加页面
     */
    public function dangfei_add() {
        include $this->admin_tpl('dangfei_add');
    }

    /**
     * 党费缴纳 - 添加保存
     */
    public function dangfei_addsave() {
        if (!isset($_POST['info']) || empty($_POST['info'])) {
            showmessage('数据不能为空', HTTP_REFERER);
        }

        $info = $_POST['info'];

        $data = array(
            'theme' => isset($info['theme']) ? trim($info['theme']) : '',
            'content' => isset($info['content']) ? trim($info['content']) : '',
            'renyuan' => isset($info['renyuan']) ? trim($info['renyuan']) : '',
            'jiaona_qingkuang' => isset($info['jiaona_qingkuang']) ? trim($info['jiaona_qingkuang']) : '',
            'photos' => isset($info['photos']) ? trim($info['photos']) : '',
            'addtime' => time(),
            'updatetime' => time(),
            'create_datetime' => date('Y-m-d H:i:s'),
            'create_year' => intval(date('Y')),
            'create_month' => intval(date('m')),
            'create_day' => intval(date('d'))
        );

        // 处理时间
        if (!empty($info['pay_time'])) {
            $data['pay_time'] = strtotime($info['pay_time']);
        } else {
            $data['pay_time'] = 0;
        }

        $this->db->table_name = 'v9_dangfei';
        $this->db->insert($data);

        showmessage('添加成功', '?m=dangjian&c=jiagou&a=dangfei');
    }

    /**
     * 党费缴纳 - 编辑页面
     */
    public function dangfei_edit() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_dangfei';
        $info = $this->db->get_one("id = $id");

        if (!$info) {
            showmessage('记录不存在', HTTP_REFERER);
        }

        // 格式化日期显示
        $info['pay_time_show'] = $info['pay_time'] ? date('Y-m-d', $info['pay_time']) : '';

        include $this->admin_tpl('dangfei_edit');
    }

    /**
     * 党费缴纳 - 编辑保存
     */
    public function dangfei_editsave() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if ($id <= 0) {
            showmessage('参数错误', HTTP_REFERER);
        }

        if (!isset($_POST['info']) || empty($_POST['info'])) {
            showmessage('数据不能为空', HTTP_REFERER);
        }

        $info = $_POST['info'];

        $data = array(
            'theme' => isset($info['theme']) ? trim($info['theme']) : '',
            'content' => isset($info['content']) ? trim($info['content']) : '',
            'renyuan' => isset($info['renyuan']) ? trim($info['renyuan']) : '',
            'jiaona_qingkuang' => isset($info['jiaona_qingkuang']) ? trim($info['jiaona_qingkuang']) : '',
            'photos' => isset($info['photos']) ? trim($info['photos']) : '',
            'updatetime' => time()
        );

        // 处理时间
        if (!empty($info['pay_time'])) {
            $data['pay_time'] = strtotime($info['pay_time']);
        } else {
            $data['pay_time'] = 0;
        }

        $this->db->table_name = 'v9_dangfei';
        $this->db->update($data, "id = $id");

        showmessage('修改成功', '?m=dangjian&c=jiagou&a=dangfei');
    }

    /**
     * 党费缴纳 - 删除
     */
    public function dangfei_del() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id <= 0) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_dangfei';
        $this->db->delete("id = $id");

        showmessage('删除成功', '?m=dangjian&c=jiagou&a=dangfei');
    }

    /**
     * 党费缴纳 - 图片上传
     */
    public function upload_dangfei_image() {
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(array('status' => 0, 'msg' => '上传失败'));
            exit;
        }

        $file = $_FILES['file'];

        // 扩展名白名单验证
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
        $upload_path = 'uploadfile/dangjian/dangfei/' . date('Ymd') . '/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // 生成文件名
        $filename = date('YmdHis') . '_' . rand(1000, 9999) . '.' . $ext;
        $filepath = $upload_path . $filename;

        // 移动上传文件
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
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