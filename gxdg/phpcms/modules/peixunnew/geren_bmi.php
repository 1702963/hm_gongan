<?php
ini_set("display_errors", "On");
defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('admin', 'admin', 0);

class geren_bmi extends admin
{
    private $db;

    public function __construct()
    {
        $this->db = pc_base::load_model('opinion2_model');
        $this->db->table_name = 'v9_fujing';
        pc_base::load_app_func('global');
        setcookie('zq_hash', $_SESSION['pc_hash']);
    }

    /**
     * 列表页
     */
    public function init()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pagesize = 20;

        // 筛选条件
        $where = "c.isok=1";
        $count_where = "isok=1";

        $fjid = isset($_GET['fjid']) ? intval($_GET['fjid']) : 0;
        $dwid = isset($_GET['dwid']) ? intval($_GET['dwid']) : 0;
        $year = isset($_GET['year']) ? intval($_GET['year']) : 0;
        $ceyue = isset($_GET['ceyue']) ? trim($_GET['ceyue']) : '';

        if ($fjid > 0) {
            $where .= " AND c.fjid=$fjid";
            $count_where .= " AND fjid=$fjid";
        }
        if ($dwid > 0) {
            $where .= " AND c.dwid=$dwid";
            $count_where .= " AND dwid=$dwid";
        }
        if ($year > 0) {
            $where .= " AND c.addyear=$year";
            $count_where .= " AND addyear=$year";
        }
        if ($ceyue != '') {
            $ceyue_safe = addslashes($ceyue);
            $where .= " AND c.ceyue='$ceyue_safe'";
            $count_where .= " AND ceyue='$ceyue_safe'";
        }

        $this->fjid = $fjid;
        $this->dwid = $dwid;
        $this->year = $year;
        $this->ceyue = $ceyue;

        // 查询总数
        $this->db->table_name = 'v9_geren_bmi';
        $total = $this->db->count($count_where);
        $page = max(intval($page), 1);
        $offset = $pagesize * ($page - 1);
        $pages = pages($total, $page, $pagesize);

        // 查询列表
        $sql = "SELECT c.*, fj.xingming AS fjname, fj.gzz AS fj_gzz "
            . "FROM fujing.v9_geren_bmi c "
            . "INNER JOIN fujing.v9_fujing fj ON c.fjid=fj.id "
            . "WHERE $where "
            . "ORDER BY c.id DESC "
            . "LIMIT $offset, $pagesize";
        $result = $this->db->query($sql);
        $list = $this->db->fetch_array();

        // 处理数据
        foreach ($list as &$item) {
            if ($item['inputtime'] > 0) {
                $item['inputtime_show'] = date("Y-m-d H:i", $item['inputtime']);
            }
        }

        // 加载部门列表
        $bumen_db = pc_base::load_model('bumen_model');
        $bumen_list = $bumen_db->select('', 'id,name');

        $this->list = $list;
        $this->pages = $pages;
        $this->total = $total;
        $this->bumen_list = $bumen_list;
        include $this->admin_tpl('geren_bmi_list');
    }

    /**
     * 添加
     */
    public function add()
    {
        // 加载部门列表
        $bumen_db = pc_base::load_model('bumen_model');
        $bumen_list = $bumen_db->select('', 'id,name');

        $this->bumen_list = $bumen_list;
        include $this->admin_tpl('geren_bmi_add');
    }

    /**
     * 搜索辅警（AJAX接口）
     */
    public function searchfujing()
    {
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
        if (empty($keyword)) {
            echo json_encode(array('status' => 0, 'msg' => '请输入搜索关键词'));
            exit;
        }

        $keyword = addslashes($keyword);
        $this->db->table_name = 'v9_fujing';
        $where = " (xingming LIKE '%{$keyword}%' OR sfz LIKE '%{$keyword}%') AND status=1 AND isok=1 ";
        $list = $this->db->select($where, 'id,xingming,sex,sfz,dwid,shengao,tizhong', '20', 'xingming asc');

        if ($list) {
            // 获取单位名称
            $bumen_db = pc_base::load_model('bumen_model');
            foreach ($list as &$item) {
                if ($item['dwid']) {
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

    /**
     * 保存添加
     */
    public function addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $fjid = isset($_POST['info']['fjid']) ? intval($_POST['info']['fjid']) : 0;
            $dwid = isset($_POST['info']['dwid']) ? intval($_POST['info']['dwid']) : 0;
            $shengao = isset($_POST['info']['shengao']) ? floatval($_POST['info']['shengao']) : 0;
            $tizhong = isset($_POST['info']['tizhong']) ? floatval($_POST['info']['tizhong']) : 0;
            $tizhilv = isset($_POST['info']['tizhilv']) ? floatval($_POST['info']['tizhilv']) : null;
            $yaowei = isset($_POST['info']['yaowei']) ? floatval($_POST['info']['yaowei']) : null;
            $tunwei = isset($_POST['info']['tunwei']) ? floatval($_POST['info']['tunwei']) : null;
            $beizhu = isset($_POST['info']['beizhu']) ? addslashes($_POST['info']['beizhu']) : '';
            $ceyue = isset($_POST['info']['ceyue']) ? trim($_POST['info']['ceyue']) : '';
            $xingbie = isset($_POST['info']['xingbie']) ? trim($_POST['info']['xingbie']) : '';
            $dabiao_tizhong = isset($_POST['info']['dabiao_tizhong']) ? floatval($_POST['info']['dabiao_tizhong']) : null;
            $zengzhong = isset($_POST['info']['zengzhong']) ? floatval($_POST['info']['zengzhong']) : null;
            $yu_dabiao_chae = isset($_POST['info']['yu_dabiao_chae']) ? floatval($_POST['info']['yu_dabiao_chae']) : null;
            $paiming = isset($_POST['info']['paiming']) ? intval($_POST['info']['paiming']) : null;

            if (!$fjid || !$shengao || !$tizhong) {
                showmessage('辅警、身高和体重不能为空', 'index.php?m=peixunnew&c=geren_bmi&a=add');
            }

            // 计算BMI: 体重(kg) / 身高(m)²
            $bmi = round($tizhong / (($shengao / 100) * ($shengao / 100)), 1);

            $this->db->table_name = 'v9_geren_bmi';

            $data = array(
                'fjid' => $fjid,
                'dwid' => $dwid,
                'shengao' => $shengao,
                'tizhong' => $tizhong,
                'bmi' => $bmi,
                'tizhilv' => $tizhilv,
                'yaowei' => $yaowei,
                'tunwei' => $tunwei,
                'beizhu' => $beizhu,
                'ceyue' => $ceyue,
                'xingbie' => $xingbie,
                'dabiao_tizhong' => $dabiao_tizhong,
                'zengzhong' => $zengzhong,
                'yu_dabiao_chae' => $yu_dabiao_chae,
                'paiming' => $paiming,
                'inputtime' => time(),
                'adddate' => date('Y-m-d'),
                'addyear' => intval(date('Y')),
                'addmonth' => intval(date('m')),
                'addday' => intval(date('d')),
                'isok' => 1
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', 'index.php?m=peixunnew&c=geren_bmi&a=init');
            } else {
                showmessage('添加失败', 'index.php?m=peixunnew&c=geren_bmi&a=add');
            }
        }
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$id) {
            showmessage('参数错误');
        }

        $this->db->table_name = 'v9_geren_bmi';
        $info = $this->db->get_one(array('id' => $id));
        if (!$info) {
            showmessage('记录不存在');
        }

        // 处理时间显示
        $info['inputtime_show'] = $info['inputtime'] ? date('Y-m-d H:i', $info['inputtime']) : '';

        // 获取辅警姓名
        $this->db->table_name = 'v9_fujing';
        $fjinfo = $this->db->get_one(array('id' => $info['fjid']));
        $info['fjname'] = $fjinfo ? $fjinfo['xingming'] : '';

        // 加载部门列表
        $bumen_db = pc_base::load_model('bumen_model');
        $bumen_list = $bumen_db->select('', 'id,name');

        $this->bumen_list = $bumen_list;
        $this->info = $info;
        include $this->admin_tpl('geren_bmi_edit');
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

            $shengao = isset($_POST['info']['shengao']) ? floatval($_POST['info']['shengao']) : 0;
            $tizhong = isset($_POST['info']['tizhong']) ? floatval($_POST['info']['tizhong']) : 0;
            $tizhilv = isset($_POST['info']['tizhilv']) ? floatval($_POST['info']['tizhilv']) : null;
            $yaowei = isset($_POST['info']['yaowei']) ? floatval($_POST['info']['yaowei']) : null;
            $tunwei = isset($_POST['info']['tunwei']) ? floatval($_POST['info']['tunwei']) : null;
            $beizhu = isset($_POST['info']['beizhu']) ? addslashes($_POST['info']['beizhu']) : '';
            $ceyue = isset($_POST['info']['ceyue']) ? trim($_POST['info']['ceyue']) : '';
            $xingbie = isset($_POST['info']['xingbie']) ? trim($_POST['info']['xingbie']) : '';
            $dabiao_tizhong = isset($_POST['info']['dabiao_tizhong']) ? floatval($_POST['info']['dabiao_tizhong']) : null;
            $zengzhong = isset($_POST['info']['zengzhong']) ? floatval($_POST['info']['zengzhong']) : null;
            $yu_dabiao_chae = isset($_POST['info']['yu_dabiao_chae']) ? floatval($_POST['info']['yu_dabiao_chae']) : null;
            $paiming = isset($_POST['info']['paiming']) ? intval($_POST['info']['paiming']) : null;

            if (!$shengao || !$tizhong) {
                showmessage('身高和体重不能为空', "index.php?m=peixunnew&c=geren_bmi&a=edit&id=$id");
            }

            // 计算BMI
            $bmi = round($tizhong / (($shengao / 100) * ($shengao / 100)), 1);

            $this->db->table_name = 'v9_geren_bmi';

            $data = array(
                'shengao' => $shengao,
                'tizhong' => $tizhong,
                'bmi' => $bmi,
                'tizhilv' => $tizhilv,
                'yaowei' => $yaowei,
                'tunwei' => $tunwei,
                'beizhu' => $beizhu,
                'ceyue' => $ceyue,
                'xingbie' => $xingbie,
                'dabiao_tizhong' => $dabiao_tizhong,
                'zengzhong' => $zengzhong,
                'yu_dabiao_chae' => $yu_dabiao_chae,
                'paiming' => $paiming
            );

            $result = $this->db->update($data, array('id' => $id));
            if ($result !== false) {
                showmessage('修改成功', 'index.php?m=peixunnew&c=geren_bmi&a=init');
            } else {
                showmessage('修改失败', "index.php?m=peixunnew&c=geren_bmi&a=edit&id=$id");
            }
        }
    }

    /**
     * 删除
     */
    public function del()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$id) {
            showmessage('参数错误');
        }

        $this->db->table_name = 'v9_geren_bmi';
        $result = $this->db->update(array('isok' => 0), array('id' => $id));

        if ($result !== false) {
            showmessage('删除成功', 'index.php?m=peixunnew&c=geren_bmi&a=init');
        } else {
            showmessage('删除失败', 'index.php?m=peixunnew&c=geren_bmi&a=init');
        }
    }
}
