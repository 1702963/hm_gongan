<?php
ini_set("display_errors", "Off");
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class fujingpeixun_person extends admin
{
    var $db;

    public function __construct()
    {
        $this->db = pc_base::load_model('opinion2_model');
        $this->db->table_name = 'v9_peixun_yewu_jilu';
        pc_base::load_app_func('global');
        setcookie('zq_hash', $_SESSION['pc_hash']);
    }

    // 业务警种培训记录列表
    public function init()
    {
        // 分页参数
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

        // 筛选条件
        $jihua_id = isset($_GET['jihua_id']) ? intval($_GET['jihua_id']) : 0;
        $bmid = isset($_GET['bmid']) ? intval($_GET['bmid']) : 0;
        $guo = isset($_GET['guo']) ? intval($_GET['guo']) : -1;
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

        $conditions = array();
        if ($jihua_id > 0) {
            $conditions[] = "jihua_id = $jihua_id";
        }
        if ($bmid > 0) {
            $conditions[] = "bmid = $bmid";
        }
        if ($guo >= 0) {
            $conditions[] = "guo = $guo";
        }
        if ($keyword != '') {
            $keyword = safe_replace($keyword);
            $keyword = addslashes($keyword);
            $conditions[] = "fjname LIKE '%{$keyword}%'";
        }
        $where = !empty($conditions) ? implode(' AND ', $conditions) : '';

        $this->jihua_id = $jihua_id;
        $this->bmid = $bmid;
        $this->guo = $guo;
        $this->keyword = $keyword;

        // 查询列表
        $this->db->table_name = 'v9_peixun_yewu_jilu';
        $list = $this->db->listinfo($where, 'id DESC', $page, 15);
        $pages = $this->db->pages;

        // 获取培训计划列表（用于显示培训标题）
        $this->db->table_name = 'v9_peixun_yewu_jihua';
        $jihua_list = $this->db->select('', 'id,title');
        $jihua_map = array();
        foreach ($jihua_list as $jh) {
            $jihua_map[$jh['id']] = $jh['title'];
        }
        $this->jihua_map = $jihua_map;
        $this->jihua_list = $jihua_list;

        // 处理数据
        foreach ($list as &$item) {
            if ($item['inputtime'] > 0) {
                $item['inputtime_show'] = date("Y-m-d H:i", $item['inputtime']);
            }
            if ($item['tianbao_time'] > 0) {
                $item['tianbao_time_show'] = date("Y-m-d", $item['tianbao_time']);
            }
            // 培训计划标题
            $item['jihua_title'] = isset($jihua_map[$item['jihua_id']]) ? $jihua_map[$item['jihua_id']] : '-';
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
        include $this->admin_tpl('fujingpeixun_person_list');
    }

    // 添加培训记录
    public function add()
    {
        // 加载培训计划列表（只显示进行中的）
        $this->db->table_name = 'v9_peixun_yewu_jihua';
        $jihua_list = $this->db->select("status = 1", 'id,title,bmid,btime,etime');
        $this->jihua_list = $jihua_list;

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
        include $this->admin_tpl('fujingpeixun_person_add');
    }

    // 搜索辅警的AJAX接口
    public function searchfujing()
    {
        $keyword = trim($_POST['keyword']);
        if (!$keyword) {
            echo json_encode(array('status' => 0, 'msg' => '请输入搜索关键词'));
            exit;
        }

        $keyword = safe_replace($keyword);

        $keyword = addslashes($keyword);

        $this->db->table_name = 'v9_fujing';
        $where = " (xingming LIKE '%{$keyword}%' OR sfz LIKE '%{$keyword}%') AND status=1 AND isok=1 ";
        $list = $this->db->select($where, 'id,xingming,sex,sfz,dwid', '20', 'xingming asc');

        if ($list) {
            // 获取单位名称
            $this->db->table_name = 'v9_bumen';
            foreach ($list as &$item) {
                if ($item['dwid']) {
                    $bumen = $this->db->get_one(array('id' => $item['dwid']));
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

    // 保存添加
    public function addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $jihua_id = intval($_POST['info']['jihua_id']);
            $bmid = intval($_POST['info']['bmid']);
            $fjid = intval($_POST['info']['fjid']);
            $fjname = trim($_POST['info']['fjname']);
            $chengji = trim($_POST['info']['chengji']);
            $guo = intval($_POST['info']['guo']);
            $files = trim($_POST['info']['files']);
            $tianbao_time = !empty($_POST['info']['tianbao_time']) ? strtotime($_POST['info']['tianbao_time']) : 0;

            if (!$jihua_id) {
                showmessage('请选择培训计划', HTTP_REFERER);
            }
            if (!$fjid || !$fjname) {
                showmessage('请选择参训人员', HTTP_REFERER);
            }

            // 检查是否已存在相同记录
            $this->db->table_name = 'v9_peixun_yewu_jilu';
            $exists = $this->db->get_one(" jihua_id=$jihua_id AND fjid=$fjid ");
            if ($exists) {
                showmessage('该人员在此培训计划中已存在记录', HTTP_REFERER);
            }

            // 插入数据
            $data = array(
                'jihua_id' => $jihua_id,
                'bmid' => $bmid,
                'fjid' => $fjid,
                'fjname' => $fjname,
                'inputtime' => time(),
                'chengji' => $chengji,
                'guo' => $guo,
                'files' => $files,
                'tianbao_time' => $tianbao_time,
                'adddate' => date('Y-m-d H:i:s'),
                'addyear' => intval(date('Y')),
                'addmonth' => intval(date('m')),
                'addday' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=peixunnew&c=fujingpeixun_person&a=init');
            } else {
                showmessage('添加失败', HTTP_REFERER);
            }
        }
    }

    // 编辑培训记录
    public function edit()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        // 查询记录
        $this->db->table_name = 'v9_peixun_yewu_jilu';
        $info = $this->db->get_one(" id=$id ");
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        // 处理时间格式
        if ($info['tianbao_time'] > 0) {
            $info['tianbao_time_show'] = date("Y-m-d", $info['tianbao_time']);
        }

        // 处理附件图片URL
        if (!empty($info['files'])) {
            $upload_url = pc_base::load_config('system', 'upload_url');
            $files_array = json_decode($info['files'], true);
            if (is_array($files_array)) {
                foreach ($files_array as &$url) {
                    if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                        $url = $upload_url . str_replace('uploadfile/', '', $url);
                    }
                }
                $info['files'] = json_encode($files_array);
            }
        }

        // 加载培训计划列表
        $this->db->table_name = 'v9_peixun_yewu_jihua';
        $jihua_list = $this->db->select('', 'id,title,bmid');
        $this->jihua_list = $jihua_list;

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
        include $this->admin_tpl('fujingpeixun_person_edit');
    }

    // 保存编辑
    public function editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            $jihua_id = intval($_POST['info']['jihua_id']);
            $bmid = intval($_POST['info']['bmid']);
            $chengji = trim($_POST['info']['chengji']);
            $guo = intval($_POST['info']['guo']);
            $files = trim($_POST['info']['files']);
            $tianbao_time = !empty($_POST['info']['tianbao_time']) ? strtotime($_POST['info']['tianbao_time']) : 0;

            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            // 更新数据
            $this->db->table_name = 'v9_peixun_yewu_jilu';
            $data = array(
                'jihua_id' => $jihua_id,
                'bmid' => $bmid,
                'chengji' => $chengji,
                'guo' => $guo,
                'files' => $files,
                'tianbao_time' => $tianbao_time
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result !== false) {
                showmessage('修改成功', '?m=peixunnew&c=fujingpeixun_person&a=init');
            } else {
                showmessage('修改失败', HTTP_REFERER);
            }
        }
    }

    // 删除培训记录
    public function del()
    {
        $id = intval($_GET['id']);
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_peixun_yewu_jilu';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=peixunnew&c=fujingpeixun_person&a=init');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    // 上传证书图片
    public function upload_image()
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_FILES['file'])) {
            echo json_encode(array('status' => 0, 'msg' => '未选择文件'));
            exit;
        }

        $file = $_FILES['file'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(array('status' => 0, 'msg' => '上传失败，错误代码：' . $file['error']));
            exit;
        }

        $allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
        if (!in_array($file['type'], $allowed_types)) {
            echo json_encode(array('status' => 0, 'msg' => '只允许上传图片文件'));
            exit;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($ext, $allowed_exts)) {
            echo json_encode(array('status' => 0, 'msg' => '只允许上传 jpg、jpeg、png、gif 格式的图片'));
            exit;
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            echo json_encode(array('status' => 0, 'msg' => '文件大小不能超过5MB'));
            exit;
        }

        // 校验图片真实内容
        if (function_exists('getimagesize')) {
            $image_info = @getimagesize($file['tmp_name']);
            if ($image_info === false) {
                echo json_encode(array('status' => 0, 'msg' => '文件内容校验失败，请上传有效图片'));
                exit;
            }
            if (!empty($image_info['mime']) && !in_array($image_info['mime'], $allowed_types)) {
                echo json_encode(array('status' => 0, 'msg' => '图片类型不符合要求'));
                exit;
            }
        }
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo) {
                $real_mime = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);
                if ($real_mime && !in_array($real_mime, $allowed_types)) {
                    echo json_encode(array('status' => 0, 'msg' => '图片类型不符合要求'));
                    exit;
                }
            }
        }

        $upload_path = 'uploadfile/peixun/zhengshu/' . date('Y/md') . '/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $filename = date('YmdHis') . '_' . rand(1000, 9999) . '.' . $ext;
        $filepath = $upload_path . $filename;

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
