<?php
ini_set("display_errors", "On");
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class yewujingzhong extends admin
{
    var $db;

    public function __construct()
    {
        $this->db = pc_base::load_model('opinion2_model');
        $this->db->table_name = 'v9_peixun_yewu_jihua';
        pc_base::load_app_func('global');
        setcookie('zq_hash', $_SESSION['pc_hash']);
    }

    // 业务警种培训计划列表
    public function init()
    {
        // 分页参数
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

        // 筛选条件
        $bmid = isset($_GET['bmid']) ? intval($_GET['bmid']) : 0;
        $status = isset($_GET['status']) ? intval($_GET['status']) : -1;
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

        $conditions = array();
        if ($bmid > 0) {
            $conditions[] = "bmid = $bmid";
        }
        if ($status >= 0) {
            $conditions[] = "status = $status";
        }
        if ($keyword != '') {
            $keyword = addslashes($keyword);
            $conditions[] = "(title LIKE '%{$keyword}%' OR ly_title LIKE '%{$keyword}%')";
        }
        $where = !empty($conditions) ? implode(' AND ', $conditions) : '';

        $this->bmid = $bmid;
        $this->status = $status;
        $this->keyword = $keyword;

        // 查询列表
        $this->db->table_name = 'v9_peixun_yewu_jihua';
        $list = $this->db->listinfo($where, 'id DESC', $page, 15);
        $pages = $this->db->pages;

        // 处理数据
        foreach ($list as &$item) {
            // 处理时间格式
            if ($item['btime'] > 0) {
                $item['btime_show'] = date("Y-m-d", $item['btime']);
            }
            if ($item['etime'] > 0) {
                $item['etime_show'] = date("Y-m-d", $item['etime']);
            }
            if ($item['inputtime'] > 0) {
                $item['inputtime_show'] = date("Y-m-d H:i", $item['inputtime']);
            }
        }

        // 加载部门列表
        $tree = pc_base::load_sys_class('tree');
        $this->db->table_name = 'v9_bumen';
        $bumen_list = $this->db->select('', 'id,parentid,name');
        $bumen_map = array();
        foreach ($bumen_list as $bm) {
            $bumen_map[$bm['id']] = $bm['name'];
        }
        $this->bumen_map = $bumen_map;

        // 构建部门下拉树
        $array = array();
        foreach ($bumen_list as $r) {
            $r['cname'] = $r['name'];
            $r['selected'] = ($r['id'] == $bmid) ? 'selected' : '';
            $array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$cname</option>";
        $tree->init($array);
        $select_bumen = $tree->get_tree(0, $str);

        $this->select_bumen = $select_bumen;
        $this->list = $list;
        $this->pages = $pages;
        include $this->admin_tpl('yewujingzhong_list');
    }

    // 添加培训计划
    public function add()
    {
        // 加载部门列表
        $tree = pc_base::load_sys_class('tree');
        $this->db->table_name = 'v9_bumen';
        $bumen_list = $this->db->select('', 'id,parentid,name');

        $array = array();
        foreach ($bumen_list as $r) {
            $r['cname'] = $r['name'];
            $r['selected'] = '';
            $array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$cname</option>";
        $tree->init($array);
        $select_bumen = $tree->get_tree(0, $str);

        $this->select_bumen = $select_bumen;
        include $this->admin_tpl('yewujingzhong_add');
    }

    // 保存添加
    public function addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $bmid = intval($_POST['info']['bmid']);
            $pxly = trim($_POST['info']['pxly']);
            $title = trim($_POST['info']['title']);
            $ly_title = trim($_POST['info']['ly_title']);
            $yaoqiu = trim($_POST['info']['yaoqiu']);
            $btime = !empty($_POST['info']['btime']) ? strtotime($_POST['info']['btime']) : 0;
            $etime = !empty($_POST['info']['etime']) ? strtotime($_POST['info']['etime']) : 0;
            $bixu = intval($_POST['info']['bixu']);
            $status = intval($_POST['info']['status']);

            if (!$title) {
                showmessage('请输入培训标题', HTTP_REFERER);
            }

            // 插入数据
            $this->db->table_name = 'v9_peixun_yewu_jihua';
            $data = array(
                'bmid' => $bmid,
                'pxly' => $pxly,
                'title' => $title,
                'ly_title' => $ly_title,
                'yaoqiu' => $yaoqiu,
                'btime' => $btime,
                'etime' => $etime,
                'bixu' => $bixu,
                'userid' => $_SESSION['userid'],
                'inputtime' => time(),
                'status' => $status,
                'adddate' => date('Y-m-d H:i:s'),
                'addyear' => intval(date('Y')),
                'addmonth' => intval(date('m')),
                'addday' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=peixunnew&c=yewujingzhong&a=init');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑培训计划
    public function edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 查询记录
        $this->db->table_name = 'v9_peixun_yewu_jihua';
        $info = $this->db->get_one(" id=$id ");
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        // 处理时间格式
        if ($info['btime'] > 0) {
            $info['btime_show'] = date("Y-m-d", $info['btime']);
        }
        if ($info['etime'] > 0) {
            $info['etime_show'] = date("Y-m-d", $info['etime']);
        }

        // 加载部门列表
        $tree = pc_base::load_sys_class('tree');
        $this->db->table_name = 'v9_bumen';
        $bumen_list = $this->db->select('', 'id,parentid,name');

        $array = array();
        foreach ($bumen_list as $r) {
            $r['cname'] = $r['name'];
            $r['selected'] = ($r['id'] == $info['bmid']) ? 'selected' : '';
            $array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$cname</option>";
        $tree->init($array);
        $select_bumen = $tree->get_tree(0, $str);

        $this->select_bumen = $select_bumen;
        $this->info = $info;
        include $this->admin_tpl('yewujingzhong_edit');
    }

    // 保存编辑
    public function editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            $bmid = intval($_POST['info']['bmid']);
            $pxly = trim($_POST['info']['pxly']);
            $title = trim($_POST['info']['title']);
            $ly_title = trim($_POST['info']['ly_title']);
            $yaoqiu = trim($_POST['info']['yaoqiu']);
            $btime = !empty($_POST['info']['btime']) ? strtotime($_POST['info']['btime']) : 0;
            $etime = !empty($_POST['info']['etime']) ? strtotime($_POST['info']['etime']) : 0;
            $bixu = intval($_POST['info']['bixu']);
            $status = intval($_POST['info']['status']);

            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            if (!$title) {
                showmessage('请输入培训标题', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_peixun_yewu_jihua';
            $data = array(
                'bmid' => $bmid,
                'pxly' => $pxly,
                'title' => $title,
                'ly_title' => $ly_title,
                'yaoqiu' => $yaoqiu,
                'btime' => $btime,
                'etime' => $etime,
                'bixu' => $bixu,
                'status' => $status
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result !== false) {
                showmessage('修改成功', '?m=peixunnew&c=yewujingzhong&a=init');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除培训计划
    public function del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_peixun_yewu_jihua';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=peixunnew&c=yewujingzhong&a=init');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

}
