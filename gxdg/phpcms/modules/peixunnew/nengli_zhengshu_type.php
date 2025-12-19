<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);

/**
 * 证书类型字典管理
 */
class nengli_zhengshu_type extends admin
{
    private $db;

    public function __construct()
    {
        $this->db = pc_base::load_model('opinion2_model');
        $this->db->table_name = 'v9_nengli_zhengshu_type';
        pc_base::load_app_func('global');
        setcookie('zq_hash', $_SESSION['pc_hash']);
    }

    /**
     * 列表页
     */
    public function init()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $leibie = isset($_GET['leibie']) ? safe_replace(trim($_GET['leibie'])) : '';
        $leibie = addslashes($leibie);
        $status = isset($_GET['status']) ? intval($_GET['status']) : -1;
        $keyword = isset($_GET['keyword']) ? safe_replace(trim($_GET['keyword'])) : '';
        $keyword = addslashes($keyword);

        $conditions = array();
        if ($leibie !== '') {
            $conditions[] = "leibie='{$leibie}'";
        }
        if ($status >= 0) {
            $conditions[] = "status={$status}";
        }
        if ($keyword !== '') {
            $conditions[] = "typename LIKE '%{$keyword}%'";
        }
        $where = !empty($conditions) ? implode(' AND ', $conditions) : '';

        $this->leibie = $leibie;
        $this->status = $status;
        $this->keyword = $keyword;

        $this->db->table_name = 'v9_nengli_zhengshu_type';
        $list = $this->db->listinfo($where, 'paixu DESC,id DESC', $page, 20);
        $pages = $this->db->pages;

        $this->list = $list;
        $this->pages = $pages;
        include $this->admin_tpl('nengli_zhengshu_type_list');
    }

    /**
     * 添加页
     */
    public function add()
    {
        include $this->admin_tpl('nengli_zhengshu_type_add');
    }

    /**
     * 保存新增
     */
    public function addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $typename = isset($_POST['info']['typename']) ? addslashes(trim($_POST['info']['typename'])) : '';
            $leibie = isset($_POST['info']['leibie']) ? addslashes(trim($_POST['info']['leibie'])) : '';
            $jigou = isset($_POST['info']['jigou']) ? addslashes(trim($_POST['info']['jigou'])) : '';
            $youxiaoqi = isset($_POST['info']['youxiaoqi']) ? intval($_POST['info']['youxiaoqi']) : 0;
            $status = isset($_POST['info']['status']) ? intval($_POST['info']['status']) : 1;
            $paixu = isset($_POST['info']['paixu']) ? intval($_POST['info']['paixu']) : 0;
            $beizhu = isset($_POST['info']['beizhu']) ? addslashes(trim($_POST['info']['beizhu'])) : '';

            if ($typename == '') {
                showmessage('请输入证书名称', HTTP_REFERER);
            }

            $data = array(
                'typename' => $typename,
                'leibie' => $leibie,
                'jigou' => $jigou,
                'youxiaoqi' => $youxiaoqi,
                'status' => $status,
                'paixu' => $paixu,
                'addtime' => time(),
                'beizhu' => $beizhu
            );

            $this->db->table_name = 'v9_nengli_zhengshu_type';
            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=peixunnew&c=nengli_zhengshu_type&a=init');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    /**
     * 编辑页
     */
    public function edit()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_nengli_zhengshu_type';
        $info = $this->db->get_one(array('id' => $id));
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        $this->info = $info;
        include $this->admin_tpl('nengli_zhengshu_type_edit');
    }

    /**
     * 保存编辑
     */
    public function editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $typename = isset($_POST['info']['typename']) ? addslashes(trim($_POST['info']['typename'])) : '';
            $leibie = isset($_POST['info']['leibie']) ? addslashes(trim($_POST['info']['leibie'])) : '';
            $jigou = isset($_POST['info']['jigou']) ? addslashes(trim($_POST['info']['jigou'])) : '';
            $youxiaoqi = isset($_POST['info']['youxiaoqi']) ? intval($_POST['info']['youxiaoqi']) : 0;
            $status = isset($_POST['info']['status']) ? intval($_POST['info']['status']) : 1;
            $paixu = isset($_POST['info']['paixu']) ? intval($_POST['info']['paixu']) : 0;
            $beizhu = isset($_POST['info']['beizhu']) ? addslashes(trim($_POST['info']['beizhu'])) : '';

            if ($id <= 0) {
                showmessage('参数错误', HTTP_REFERER);
            }
            if ($typename == '') {
                showmessage('请输入证书名称', HTTP_REFERER);
            }

            $data = array(
                'typename' => $typename,
                'leibie' => $leibie,
                'jigou' => $jigou,
                'youxiaoqi' => $youxiaoqi,
                'status' => $status,
                'paixu' => $paixu,
                'beizhu' => $beizhu
            );

            $this->db->table_name = 'v9_nengli_zhengshu_type';
            $result = $this->db->update($data, array('id' => $id));
            if ($result !== false) {
                showmessage('保存成功', '?m=peixunnew&c=nengli_zhengshu_type&a=init');
            } else {
                showmessage('保存失败', HTTP_REFERER);
            }
        }
    }

    /**
     * 删除
     */
    public function delete()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_nengli_zhengshu_type';
        $info = $this->db->get_one(array('id' => $id));
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        $result = $this->db->delete(array('id' => $id));
        if ($result) {
            showmessage('删除成功', '?m=peixunnew&c=nengli_zhengshu_type&a=init');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }
}
