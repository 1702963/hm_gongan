<?php
ini_set("display_errors", "Off");
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class hebeiganyuan_jilu extends admin
{
    var $db;

    public function __construct()
    {
        $this->db = pc_base::load_model('opinion2_model');
        $this->db->table_name = 'v9_peixun_hebei_jilu';
        pc_base::load_app_func('global');
        setcookie('zq_hash', $_SESSION['pc_hash']);
    }

    // 河北干院培训人次记录列表
    public function init()
    {
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

        $jihua_id = isset($_GET['jihua_id']) ? intval($_GET['jihua_id']) : 0;
        $bmid = isset($_GET['bmid']) ? intval($_GET['bmid']) : 0;
        $is_tongguo = isset($_GET['is_tongguo']) ? intval($_GET['is_tongguo']) : -1;
        $is_jieye = isset($_GET['is_jieye']) ? intval($_GET['is_jieye']) : -1;
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

        $conditions = array();
        if ($jihua_id > 0) {
            $conditions[] = "jihua_id = $jihua_id";
        }
        if ($bmid > 0) {
            $conditions[] = "bmid = $bmid";
        }
        if ($is_tongguo >= 0) {
            $conditions[] = "is_tongguo = $is_tongguo";
        }
        if ($is_jieye >= 0) {
            $conditions[] = "is_jieye = $is_jieye";
        }
        if ($keyword != '') {
            $keyword = safe_replace($keyword);
            $keyword = addslashes($keyword);
            $conditions[] = "(mjname LIKE '%{$keyword}%' OR username LIKE '%{$keyword}%')";
        }
        $where = !empty($conditions) ? implode(' AND ', $conditions) : '';

        $this->jihua_id = $jihua_id;
        $this->bmid = $bmid;
        $this->is_tongguo = $is_tongguo;
        $this->is_jieye = $is_jieye;
        $this->keyword = $keyword;

        $this->db->table_name = 'v9_peixun_hebei_jilu';
        $list = $this->db->listinfo($where, 'id DESC', $page, 15);
        $pages = $this->db->pages;

        // 获取培训计划列表
        $this->db->table_name = 'v9_peixun_hebei_jihua';
        $jihua_list = $this->db->select('', 'id,title');
        $jihua_map = array();
        foreach ($jihua_list as $jh) {
            $jihua_map[$jh['id']] = $jh['title'];
        }
        $this->jihua_map = $jihua_map;
        $this->jihua_list = $jihua_list;

        foreach ($list as &$item) {
            if ($item['inputtime'] > 0) {
                $item['inputtime_show'] = date("Y-m-d H:i", $item['inputtime']);
            }
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
        include $this->admin_tpl('hebeiganyuan_jilu_list');
    }

    // 添加培训记录
    public function add()
    {
        $this->db->table_name = 'v9_peixun_hebei_jihua';
        $jihua_list = $this->db->select("status = 1", 'id,title,bmid,btime,etime');
        $this->jihua_list = $jihua_list;

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
        include $this->admin_tpl('hebeiganyuan_jilu_add');
    }

    // 搜索民警的AJAX接口
    public function searchminjing()
    {
        $keyword = trim($_POST['keyword']);
        if (!$keyword) {
            echo json_encode(array('status' => 0, 'msg' => '请输入搜索关键词'));
            exit;
        }

        $keyword = safe_replace($keyword);
        $keyword = addslashes($keyword);

        $this->db->table_name = 'v9_admin';
        $where = " (realname LIKE '%{$keyword}%' OR card LIKE '%{$keyword}%' OR username LIKE '%{$keyword}%') ";
        $list = $this->db->select($where, 'userid,realname,username,card,bmid', '20', 'realname asc');

        if ($list) {
            $this->db->table_name = 'v9_bumen';
            foreach ($list as &$item) {
                if ($item['bmid']) {
                    $bumen = $this->db->get_one(array('id' => $item['bmid']));
                    $item['danwei'] = $bumen ? $bumen['name'] : '';
                } else {
                    $item['danwei'] = '';
                }
                $item['id'] = $item['userid'];
                $item['xingming'] = $item['realname'];
            }
            echo json_encode(array('status' => 1, 'data' => $list, 'type' => 'minjing'));
        } else {
            echo json_encode(array('status' => 0, 'msg' => '未找到匹配的民警'));
        }
        exit;
    }

    // 保存添加
    public function addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $jihua_id = intval($_POST['info']['jihua_id']);
            $bmid = intval($_POST['info']['bmid']);
            $mjid = intval($_POST['info']['mjid']);
            $mjname = trim($_POST['info']['mjname']);
            $username = trim($_POST['info']['username']);
            $suoshu_zuzhi = trim($_POST['info']['suoshu_zuzhi']);
            $suoshu_bumen = trim($_POST['info']['suoshu_bumen']);
            $zhiwu_jibie = trim($_POST['info']['zhiwu_jibie']);
            $yonghu_zu = trim($_POST['info']['yonghu_zu']);
            $gong_xueshi = floatval($_POST['info']['gong_xueshi']);
            $zaixian_xueshi = floatval($_POST['info']['zaixian_xueshi']);
            $zhuanti_xueshi = floatval($_POST['info']['zhuanti_xueshi']);
            $zhuanti_bixue_xueshi = floatval($_POST['info']['zhuanti_bixue_xueshi']);
            $zhuanti_xuanxue_xueshi = floatval($_POST['info']['zhuanti_xuanxue_xueshi']);
            $zhuanti_kecheng = intval($_POST['info']['zhuanti_kecheng']);
            $kecheng_wancheng_lv = trim($_POST['info']['kecheng_wancheng_lv']);
            $kaoshi_jieguo = trim($_POST['info']['kaoshi_jieguo']);
            $is_tongguo = intval($_POST['info']['is_tongguo']);
            $is_tijiao_zuoye = intval($_POST['info']['is_tijiao_zuoye']);
            $is_jieye = intval($_POST['info']['is_jieye']);

            if (!$jihua_id) {
                showmessage('请选择培训计划', HTTP_REFERER);
            }
            if (!$mjid || !$mjname) {
                showmessage('请选择参训民警', HTTP_REFERER);
            }

            // 验证是否为民警
            $this->db->table_name = 'v9_admin';
            $minjing = $this->db->get_one(" userid=$mjid ");
            if (!$minjing) {
                showmessage('只能添加民警，不能添加辅警！', HTTP_REFERER);
            }

            // 检查是否已存在相同记录
            $this->db->table_name = 'v9_peixun_hebei_jilu';
            $exists = $this->db->get_one(" jihua_id=$jihua_id AND mjid=$mjid ");
            if ($exists) {
                showmessage('该民警在此培训计划中已存在记录', HTTP_REFERER);
            }

            $data = array(
                'jihua_id' => $jihua_id,
                'bmid' => $bmid,
                'mjid' => $mjid,
                'username' => $username,
                'mjname' => $mjname,
                'suoshu_zuzhi' => $suoshu_zuzhi,
                'suoshu_bumen' => $suoshu_bumen,
                'zhiwu_jibie' => $zhiwu_jibie,
                'yonghu_zu' => $yonghu_zu,
                'gong_xueshi' => $gong_xueshi,
                'zaixian_xueshi' => $zaixian_xueshi,
                'zhuanti_xueshi' => $zhuanti_xueshi,
                'zhuanti_bixue_xueshi' => $zhuanti_bixue_xueshi,
                'zhuanti_xuanxue_xueshi' => $zhuanti_xuanxue_xueshi,
                'zhuanti_kecheng' => $zhuanti_kecheng,
                'kecheng_wancheng_lv' => $kecheng_wancheng_lv,
                'kaoshi_jieguo' => $kaoshi_jieguo,
                'is_tongguo' => $is_tongguo,
                'is_tijiao_zuoye' => $is_tijiao_zuoye,
                'is_jieye' => $is_jieye,
                'inputtime' => time(),
                'adddate' => date('Y-m-d H:i:s'),
                'addyear' => intval(date('Y')),
                'addmonth' => intval(date('m')),
                'addday' => intval(date('d'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=peixunnew&c=hebeiganyuan_jilu&a=init');
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

        $this->db->table_name = 'v9_peixun_hebei_jilu';
        $info = $this->db->get_one(" id=$id ");
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_peixun_hebei_jihua';
        $jihua_list = $this->db->select('', 'id,title,bmid');
        $this->jihua_list = $jihua_list;

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
        include $this->admin_tpl('hebeiganyuan_jilu_edit');
    }

    // 保存编辑
    public function editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = intval($_POST['id']);
            $jihua_id = intval($_POST['info']['jihua_id']);
            $bmid = intval($_POST['info']['bmid']);
            $username = trim($_POST['info']['username']);
            $suoshu_zuzhi = trim($_POST['info']['suoshu_zuzhi']);
            $suoshu_bumen = trim($_POST['info']['suoshu_bumen']);
            $zhiwu_jibie = trim($_POST['info']['zhiwu_jibie']);
            $yonghu_zu = trim($_POST['info']['yonghu_zu']);
            $gong_xueshi = floatval($_POST['info']['gong_xueshi']);
            $zaixian_xueshi = floatval($_POST['info']['zaixian_xueshi']);
            $zhuanti_xueshi = floatval($_POST['info']['zhuanti_xueshi']);
            $zhuanti_bixue_xueshi = floatval($_POST['info']['zhuanti_bixue_xueshi']);
            $zhuanti_xuanxue_xueshi = floatval($_POST['info']['zhuanti_xuanxue_xueshi']);
            $zhuanti_kecheng = intval($_POST['info']['zhuanti_kecheng']);
            $kecheng_wancheng_lv = trim($_POST['info']['kecheng_wancheng_lv']);
            $kaoshi_jieguo = trim($_POST['info']['kaoshi_jieguo']);
            $is_tongguo = intval($_POST['info']['is_tongguo']);
            $is_tijiao_zuoye = intval($_POST['info']['is_tijiao_zuoye']);
            $is_jieye = intval($_POST['info']['is_jieye']);

            if (!$id) {
                showmessage('参数错误', HTTP_REFERER);
            }

            $this->db->table_name = 'v9_peixun_hebei_jilu';
            $data = array(
                'jihua_id' => $jihua_id,
                'bmid' => $bmid,
                'username' => $username,
                'suoshu_zuzhi' => $suoshu_zuzhi,
                'suoshu_bumen' => $suoshu_bumen,
                'zhiwu_jibie' => $zhiwu_jibie,
                'yonghu_zu' => $yonghu_zu,
                'gong_xueshi' => $gong_xueshi,
                'zaixian_xueshi' => $zaixian_xueshi,
                'zhuanti_xueshi' => $zhuanti_xueshi,
                'zhuanti_bixue_xueshi' => $zhuanti_bixue_xueshi,
                'zhuanti_xuanxue_xueshi' => $zhuanti_xuanxue_xueshi,
                'zhuanti_kecheng' => $zhuanti_kecheng,
                'kecheng_wancheng_lv' => $kecheng_wancheng_lv,
                'kaoshi_jieguo' => $kaoshi_jieguo,
                'is_tongguo' => $is_tongguo,
                'is_tijiao_zuoye' => $is_tijiao_zuoye,
                'is_jieye' => $is_jieye
            );

            $result = $this->db->update($data, " id=$id ");
            if ($result !== false) {
                showmessage('修改成功', '?m=peixunnew&c=hebeiganyuan_jilu&a=init');
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

        $this->db->table_name = 'v9_peixun_hebei_jilu';
        $result = $this->db->delete(" id=$id ");

        if ($result) {
            showmessage('删除成功', '?m=peixunnew&c=hebeiganyuan_jilu&a=init');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

}
