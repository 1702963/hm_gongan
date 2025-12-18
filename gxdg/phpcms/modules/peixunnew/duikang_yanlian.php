<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class duikang_yanlian extends admin
{
    var $db;

    public function __construct()
    {
        $this->db = pc_base::load_model('opinion2_model');
        $this->db->table_name = 'v9_duikang_yanlian';
        pc_base::load_app_func('global');
        setcookie('zq_hash', $_SESSION['pc_hash']);
    }

    /**
     * 对抗演练列表
     */
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
            $conditions[] = "(title LIKE '%{$keyword}%' OR pingjia LIKE '%{$keyword}%')";
        }
        $where = !empty($conditions) ? implode(' AND ', $conditions) : '';

        $this->bmid = $bmid;
        $this->status = $status;
        $this->keyword = $keyword;

        // 查询列表
        $this->db->table_name = 'v9_duikang_yanlian';
        $list = $this->db->listinfo($where, 'inputtime DESC', $page, 20);
        $pages = $this->db->pages;

        // 处理数据
        foreach ($list as &$item) {
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
        include $this->admin_tpl('duikang_yanlian_list');
    }

    /**
     * 添加对抗演练
     */
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
        include $this->admin_tpl('duikang_yanlian_add');
    }

    /**
     * 保存添加
     */
    public function addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $bmid = intval($_POST['info']['bmid']);
            $title = addslashes($_POST['info']['title']);
            $content = isset($_POST['info']['content']) ? addslashes($_POST['info']['content']) : '';
            $pingjia = isset($_POST['info']['pingjia']) ? addslashes($_POST['info']['pingjia']) : '';
            $status = isset($_POST['info']['status']) ? intval($_POST['info']['status']) : 1;

            if (!$bmid || !$title) {
                showmessage('部门和标题不能为空', 'index.php?m=peixunnew&c=duikang_yanlian&a=init');
            }

            $data = array(
                'bmid' => $bmid,
                'title' => $title,
                'content' => $content,
                'pingjia' => $pingjia,
                'inputtime' => time(),
                'userid' => $_SESSION['admin_id'] ? $_SESSION['admin_id'] : 0,
                'status' => $status,
                'adddate' => date('Y-m-d'),
                'addyear' => date('Y'),
                'addmonth' => date('m'),
                'addday' => date('d')
            );

            $this->db->table_name = 'v9_duikang_yanlian';
            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', 'index.php?m=peixunnew&c=duikang_yanlian&a=init');
            } else {
                showmessage('添加失败', 'index.php?m=peixunnew&c=duikang_yanlian&a=init');
            }
        }
    }

    /**
     * 编辑对抗演练
     */
    public function edit()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$id) {
            showmessage('参数错误');
        }

        $this->db->table_name = 'v9_duikang_yanlian';
        $info = $this->db->get_one(array('id' => $id));
        if (!$info) {
            showmessage('记录不存在');
        }

        // 处理时间显示
        $info['inputtime_show'] = $info['inputtime'] ? date('Y-m-d', $info['inputtime']) : '';

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
        include $this->admin_tpl('duikang_yanlian_edit');
    }

    /**
     * 保存编辑
     */
    public function editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            if (!$id) {
                showmessage('参数错误');
            }

            $bmid = intval($_POST['info']['bmid']);
            $title = addslashes($_POST['info']['title']);
            $content = isset($_POST['info']['content']) ? addslashes($_POST['info']['content']) : '';
            $pingjia = isset($_POST['info']['pingjia']) ? addslashes($_POST['info']['pingjia']) : '';
            $status = isset($_POST['info']['status']) ? intval($_POST['info']['status']) : 1;

            if (!$bmid || !$title) {
                showmessage('部门和标题不能为空', 'index.php?m=peixunnew&c=duikang_yanlian&a=init');
            }

            $data = array(
                'bmid' => $bmid,
                'title' => $title,
                'content' => $content,
                'pingjia' => $pingjia,
                'status' => $status
            );

            $this->db->table_name = 'v9_duikang_yanlian';
            $result = $this->db->update($data, array('id' => $id));
            if ($result) {
                showmessage('修改成功', 'index.php?m=peixunnew&c=duikang_yanlian&a=init');
            } else {
                showmessage('修改失败', 'index.php?m=peixunnew&c=duikang_yanlian&a=init');
            }
        }
    }

    /**
     * 删除对抗演练
     */
    public function del()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$id) {
            showmessage('参数错误');
        }

        $this->db->table_name = 'v9_duikang_yanlian';
        $result = $this->db->update(array('isok' => 0), array('id' => $id));
        if ($result) {
            showmessage('删除成功', 'index.php?m=peixunnew&c=duikang_yanlian&a=init');
        } else {
            showmessage('删除失败', 'index.php?m=peixunnew&c=duikang_yanlian&a=init');
        }
    }
}
?>
