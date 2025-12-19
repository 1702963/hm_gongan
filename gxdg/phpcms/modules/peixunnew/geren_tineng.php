<?php
defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('admin', 'admin', 0);

class geren_tineng extends admin
{
    private $db;

    public function __construct()
    {
        $this->db = pc_base::load_model('opinion2_model');
        $this->db->table_name = 'v9_geren_tineng';
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

        $this->fjid = $fjid;
        $this->dwid = $dwid;
        $this->year = $year;

        // 查询总数
        $this->db->table_name = 'v9_geren_tineng';
        $total = $this->db->count($count_where);
        $page = max(intval($page), 1);
        $offset = $pagesize * ($page - 1);
        $pages = pages($total, $page, $pagesize);

        // 查询列表
        $sql = "SELECT c.*, fj.xingming AS fjname, fj.gzz AS fj_gzz "
            . "FROM fujing.v9_geren_tineng c "
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
            // 1000米跑转换为分秒显示
            if ($item['paoliang'] > 0) {
                $min = floor($item['paoliang'] / 60);
                $sec = $item['paoliang'] % 60;
                $item['paoliang_show'] = $min . "'" . str_pad($sec, 2, '0', STR_PAD_LEFT) . "\"";
            } else {
                $item['paoliang_show'] = '-';
            }
        }

        // 加载部门列表
        $bumen_db = pc_base::load_model('bumen_model');
        $bumen_list = $bumen_db->select('', 'id,name');

        $this->list = $list;
        $this->pages = $pages;
        $this->total = $total;
        $this->bumen_list = $bumen_list;
        include $this->admin_tpl('geren_tineng_list');
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
        include $this->admin_tpl('geren_tineng_add');
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

        $keyword = safe_replace($keyword);

        $keyword = addslashes($keyword);
        $this->db->table_name = 'v9_fujing';
        $where = " (xingming LIKE '%{$keyword}%' OR sfz LIKE '%{$keyword}%') AND status=1 AND isok=1 ";
        $list = $this->db->select($where, 'id,xingming,sex,sfz,dwid', '20', 'xingming asc');

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

            // 1000米跑：分秒转换为总秒数
            $paoliang_min = isset($_POST['info']['paoliang_min']) ? intval($_POST['info']['paoliang_min']) : 0;
            $paoliang_sec = isset($_POST['info']['paoliang_sec']) ? intval($_POST['info']['paoliang_sec']) : 0;
            $paoliang = $paoliang_min * 60 + $paoliang_sec;

            $fuwocheng = isset($_POST['info']['fuwocheng']) ? intval($_POST['info']['fuwocheng']) : null;
            $yangwoqizuo = isset($_POST['info']['yangwoqizuo']) ? intval($_POST['info']['yangwoqizuo']) : null;
            $yintixiangshang = isset($_POST['info']['yintixiangshang']) ? intval($_POST['info']['yintixiangshang']) : null;
            $lidingtiaoyan = isset($_POST['info']['lidingtiaoyan']) ? intval($_POST['info']['lidingtiaoyan']) : null;
            $zongfen = isset($_POST['info']['zongfen']) ? floatval($_POST['info']['zongfen']) : null;
            $beizhu = isset($_POST['info']['beizhu']) ? addslashes($_POST['info']['beizhu']) : '';

            if (!$fjid) {
                showmessage('请选择辅警', 'index.php?m=peixunnew&c=geren_tineng&a=add');
            }

            $this->db->table_name = 'v9_geren_tineng';

            $data = array(
                'fjid' => $fjid,
                'dwid' => $dwid,
                'paoliang' => $paoliang > 0 ? $paoliang : null,
                'fuwocheng' => $fuwocheng,
                'yangwoqizuo' => $yangwoqizuo,
                'yintixiangshang' => $yintixiangshang,
                'lidingtiaoyan' => $lidingtiaoyan,
                'zongfen' => $zongfen,
                'beizhu' => $beizhu,
                'inputtime' => time(),
                'adddate' => date('Y-m-d'),
                'addyear' => intval(date('Y')),
                'addmonth' => intval(date('m')),
                'addday' => intval(date('d')),
                'isok' => 1
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', 'index.php?m=peixunnew&c=geren_tineng&a=init');
            } else {
                showmessage('添加失败', 'index.php?m=peixunnew&c=geren_tineng&a=add');
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

        $this->db->table_name = 'v9_geren_tineng';
        $info = $this->db->get_one(array('id' => $id));
        if (!$info) {
            showmessage('记录不存在');
        }

        // 处理时间显示
        $info['inputtime_show'] = $info['inputtime'] ? date('Y-m-d H:i', $info['inputtime']) : '';

        // 1000米跑转换为分秒
        if ($info['paoliang'] > 0) {
            $info['paoliang_min'] = floor($info['paoliang'] / 60);
            $info['paoliang_sec'] = $info['paoliang'] % 60;
        } else {
            $info['paoliang_min'] = '';
            $info['paoliang_sec'] = '';
        }

        // 获取辅警姓名
        $this->db->table_name = 'v9_fujing';
        $fjinfo = $this->db->get_one(array('id' => $info['fjid']));
        $info['fjname'] = $fjinfo ? $fjinfo['xingming'] : '';

        // 加载部门列表
        $bumen_db = pc_base::load_model('bumen_model');
        $bumen_list = $bumen_db->select('', 'id,name');

        $this->bumen_list = $bumen_list;
        $this->info = $info;
        include $this->admin_tpl('geren_tineng_edit');
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

            // 1000米跑：分秒转换为总秒数
            $paoliang_min = isset($_POST['info']['paoliang_min']) ? intval($_POST['info']['paoliang_min']) : 0;
            $paoliang_sec = isset($_POST['info']['paoliang_sec']) ? intval($_POST['info']['paoliang_sec']) : 0;
            $paoliang = $paoliang_min * 60 + $paoliang_sec;

            $fuwocheng = isset($_POST['info']['fuwocheng']) ? intval($_POST['info']['fuwocheng']) : null;
            $yangwoqizuo = isset($_POST['info']['yangwoqizuo']) ? intval($_POST['info']['yangwoqizuo']) : null;
            $yintixiangshang = isset($_POST['info']['yintixiangshang']) ? intval($_POST['info']['yintixiangshang']) : null;
            $lidingtiaoyan = isset($_POST['info']['lidingtiaoyan']) ? intval($_POST['info']['lidingtiaoyan']) : null;
            $zongfen = isset($_POST['info']['zongfen']) ? floatval($_POST['info']['zongfen']) : null;
            $beizhu = isset($_POST['info']['beizhu']) ? addslashes($_POST['info']['beizhu']) : '';

            $this->db->table_name = 'v9_geren_tineng';

            $data = array(
                'paoliang' => $paoliang > 0 ? $paoliang : null,
                'fuwocheng' => $fuwocheng,
                'yangwoqizuo' => $yangwoqizuo,
                'yintixiangshang' => $yintixiangshang,
                'lidingtiaoyan' => $lidingtiaoyan,
                'zongfen' => $zongfen,
                'beizhu' => $beizhu
            );

            $result = $this->db->update($data, array('id' => $id));
            if ($result !== false) {
                showmessage('修改成功', 'index.php?m=peixunnew&c=geren_tineng&a=init');
            } else {
                showmessage('修改失败', "index.php?m=peixunnew&c=geren_tineng&a=edit&id=$id");
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

        $this->db->table_name = 'v9_geren_tineng';
        $result = $this->db->update(array('isok' => 0), array('id' => $id));

        if ($result !== false) {
            showmessage('删除成功', 'index.php?m=peixunnew&c=geren_tineng&a=init');
        } else {
            showmessage('删除失败', 'index.php?m=peixunnew&c=geren_tineng&a=init');
        }
    }
}
