<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class yanlian_canyu extends admin
{
    var $db;

    public function __construct()
    {
        $this->db = pc_base::load_model('opinion2_model');
        $this->db->table_name = 'v9_yanlian_canyu';
        pc_base::load_app_func('global');
        setcookie('zq_hash', $_SESSION['pc_hash']);
    }

    /**
     * 参与人列表
     */
    public function init()
    {
        // 分页参数
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
        $pagesize = 20;

        // 筛选条件
        $yanlian_type = isset($_GET['yanlian_type']) ? intval($_GET['yanlian_type']) : 0;
        $yanlian_id = isset($_GET['yanlian_id']) ? intval($_GET['yanlian_id']) : 0;
        $fengzu = isset($_GET['fengzu']) ? intval($_GET['fengzu']) : 0;

        $conditions = array();
        $conditions[] = "c.isok=1";
        $count_conditions = array();
        $count_conditions[] = "isok=1";

        if ($yanlian_type > 0) {
            $conditions[] = "c.yanlian_type = $yanlian_type";
            $count_conditions[] = "yanlian_type = $yanlian_type";
        }
        if ($yanlian_id > 0) {
            $conditions[] = "c.yanlian_id = $yanlian_id";
            $count_conditions[] = "yanlian_id = $yanlian_id";
        }
        if ($fengzu > 0) {
            $conditions[] = "c.fengzu = $fengzu";
            $count_conditions[] = "fengzu = $fengzu";
        }

        $where = implode(' AND ', $conditions);
        $count_where = implode(' AND ', $count_conditions);

        $this->yanlian_type = $yanlian_type;
        $this->yanlian_id = $yanlian_id;
        $this->fengzu = $fengzu;

        // 查询列表
        $this->db->table_name = 'v9_yanlian_canyu';
        $total = $this->db->count($count_where);
        $page = max(intval($page), 1);
        $offset = $pagesize * ($page - 1);
        $pages = pages($total, $page, $pagesize);

        $sql = "(SELECT c.id, c.yanlian_type, c.yanlian_id, c.fengzu, c.fjid, c.biaoxianbiao, c.pingjia_score, c.inputtime, "
            . "dy.title AS yanlian_title, '对抗训练' AS yanlian_type_name, fj.xingming AS fjname "
            . "FROM fujing.v9_yanlian_canyu c "
            . "INNER JOIN fujing.v9_fujing fj ON c.fjid=fj.id "
            . "INNER JOIN fujing.v9_duikang_yanlian dy ON c.yanlian_id=dy.id "
            . "WHERE $where AND c.yanlian_type=1) "
            . "UNION ALL "
            . "(SELECT c.id, c.yanlian_type, c.yanlian_id, c.fengzu, c.fjid, c.biaoxianbiao, c.pingjia_score, c.inputtime, "
            . "zy.title AS yanlian_title, '专项悬链' AS yanlian_type_name, fj.xingming AS fjname "
            . "FROM fujing.v9_yanlian_canyu c "
            . "INNER JOIN fujing.v9_fujing fj ON c.fjid=fj.id "
            . "INNER JOIN fujing.v9_zhuanxiang_yanlian zy ON c.yanlian_id=zy.id "
            . "WHERE $where AND c.yanlian_type=2) "
            . "ORDER BY id DESC "
            . "LIMIT $offset, $pagesize";
        $result = $this->db->query($sql);
        $list = $this->db->fetch_array($result);

//        var_dump($list);die;
        // 处理数据
        foreach ($list as &$item) {
            // 处理时间格式
            if ($item['inputtime'] > 0) {
                $item['inputtime_show'] = date("Y-m-d H:i", $item['inputtime']);
            }
        }
        unset($item);

        // 加载演练列表
        $this->db->table_name = 'v9_duikang_yanlian';
        $duikang_list = $this->db->select('isok=1', 'id,title');
        $this->db->table_name = 'v9_zhuanxiang_yanlian';
        $zhuanxiang_list = $this->db->select('isok=1', 'id,title');

        $yanlian_list = array();
        if ($duikang_list) {
            foreach ($duikang_list as $item) {
                $yanlian_list[] = array('id' => $item['id'], 'title' => '【对抗训练】' . $item['title'], 'type' => 1);
            }
        }
        if ($zhuanxiang_list) {
            foreach ($zhuanxiang_list as $item) {
                $yanlian_list[] = array('id' => $item['id'], 'title' => '【专项悬链】' . $item['title'], 'type' => 2);
            }
        }

        $this->yanlian_list = $yanlian_list;
        $this->fengzu_list = array(1 => '红方', 2 => '蓝方');
        $this->list = $list;
        $this->pages = $pages;


//        var_dump($this->list);die;
        include $this->admin_tpl('yanlian_canyu_list');
    }

    /**
     * 添加参与人
     */
    public function add($yanlian_type = 1, $yanlian_id = 0)
    {
        $yanlian_type = isset($_GET['yanlian_type']) ? intval($_GET['yanlian_type']) : intval($yanlian_type);
        $yanlian_id = isset($_GET['yanlian_id']) ? intval($_GET['yanlian_id']) : intval($yanlian_id);

        // 加载演练列表（分类型存储，避免id冲突）
        $this->db->table_name = 'v9_duikang_yanlian';
        $duikang_list = $this->db->select('isok=1', 'id,title,bmid');
        $this->db->table_name = 'v9_zhuanxiang_yanlian';
        $zhuanxiang_list = $this->db->select('isok=1', 'id,title,bmid');

        // 按类型分组的演练列表（用于JS联动）
        $yanlian_by_type = array(1 => array(), 2 => array());
        if ($duikang_list) {
            foreach ($duikang_list as $item) {
                $yanlian_by_type[1][] = array('id' => $item['id'], 'title' => $item['title']);
            }
        }
        if ($zhuanxiang_list) {
            foreach ($zhuanxiang_list as $item) {
                $yanlian_by_type[2][] = array('id' => $item['id'], 'title' => $item['title']);
            }
        }

        // 用于编辑页面的映射
        $yanlian_map = array();
        if ($duikang_list) {
            foreach ($duikang_list as $item) {
                $yanlian_map['1_' . $item['id']] = array('title' => $item['title'], 'type' => 1);
            }
        }
        if ($zhuanxiang_list) {
            foreach ($zhuanxiang_list as $item) {
                $yanlian_map['2_' . $item['id']] = array('title' => $item['title'], 'type' => 2);
            }
        }

        $yanlian_info = array();
        if ($yanlian_id > 0 && $yanlian_type > 0) {
            if ($yanlian_type == 1) {
                $this->db->table_name = 'v9_duikang_yanlian';
            } else {
                $this->db->table_name = 'v9_zhuanxiang_yanlian';
            }
            $yanlian_info = $this->db->get_one(array('id' => $yanlian_id));
        }

        // 加载辅警列表
        $this->db->table_name = 'v9_fujing';
        $fjlist = $this->db->select('status=1 AND isok=1', 'id,xingming,gzz,dwid', '', 'xingming asc');

        $this->yanlian_type = $yanlian_type;
        $this->yanlian_id = $yanlian_id;
        $this->yanlian_list = $yanlian_map;
        $this->yanlian_by_type = $yanlian_by_type;
        $this->fjlist = $fjlist;
        $this->yanlian_info = $yanlian_info;
        $this->fengzu_list = array(1 => '红方', 2 => '蓝方');
        include $this->admin_tpl('yanlian_canyu_add');
    }

    /**
     * 搜索辅警（AJAX接口）
     */
    public function searchfujing()
    {
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
        if (!$keyword) {
            echo json_encode(array('status' => 0, 'msg' => '请输入搜索关键词'));
            exit;
        }

        $keyword = addslashes($keyword);

        $this->db->table_name = 'v9_fujing';
        $where = " (xingming LIKE '%{$keyword}%' OR gzz LIKE '%{$keyword}%') AND status=1 AND isok=1 ";
        $list = $this->db->select($where, 'id,xingming,gzz,dwid', '20', 'xingming asc');

        if ($list) {
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
            $yanlian_type = intval($_POST['info']['yanlian_type']);
            $yanlian_id = intval($_POST['info']['yanlian_id']);
            $fengzu = intval($_POST['info']['fengzu']);
            $fjid = isset($_POST['info']['fjid']) ? intval($_POST['info']['fjid']) : 0;
            $pingjia_score = isset($_POST['info']['pingjia_score']) ? floatval($_POST['info']['pingjia_score']) : 0;
            $biaoxianbiao = isset($_POST['info']['biaoxianbiao']) ? addslashes($_POST['info']['biaoxianbiao']) : '';

            if (!$yanlian_type || !$yanlian_id || !$fjid || !$fengzu) {
                showmessage('演练、分组和人员不能为空', 'index.php?m=peixunnew&c=yanlian_canyu&a=init');
            }

            $this->db->table_name = 'v9_yanlian_canyu';

            // 检查重复
            $exists = $this->db->get_one(array('yanlian_type' => $yanlian_type, 'yanlian_id' => $yanlian_id, 'fjid' => $fjid, 'isok' => 1));
            if ($exists) {
                showmessage('该人员已存在于此演练中', 'index.php?m=peixunnew&c=yanlian_canyu&a=init');
            }

            $data = array(
                'yanlian_type' => $yanlian_type,
                'yanlian_id' => $yanlian_id,
                'fengzu' => $fengzu,
                'fjid' => $fjid,
                'biaoxianbiao' => $biaoxianbiao,
                'pingjia_score' => $pingjia_score,
                'inputtime' => time(),
                'adddate' => date('Y-m-d'),
                'addyear' => intval(date('Y')),
                'addmonth' => intval(date('m')),
                'addday' => intval(date('d')),
                'isok' => 1
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', 'index.php?m=peixunnew&c=yanlian_canyu&a=init');
            } else {
                showmessage('添加失败', 'index.php?m=peixunnew&c=yanlian_canyu&a=init');
            }
        }
    }

    /**
     * 编辑参与人
     */
    public function edit()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$id) {
            showmessage('参数错误');
        }

        $this->db->table_name = 'v9_yanlian_canyu';
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

        // 获取演练记录标题
        if ($info['yanlian_type'] == 1) {
            $this->db->table_name = 'v9_duikang_yanlian';
        } else {
            $this->db->table_name = 'v9_zhuanxiang_yanlian';
        }
        $yanlian_info = $this->db->get_one(array('id' => $info['yanlian_id']));
        $info['yanlian_title'] = $yanlian_info ? $yanlian_info['title'] : '';

        $this->fengzu_list = array(1 => '红方', 2 => '蓝方');
        $this->info = $info;
        include $this->admin_tpl('yanlian_canyu_edit');
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

            $fengzu = intval($_POST['info']['fengzu']);
            $pingjia_score = isset($_POST['info']['pingjia_score']) ? floatval($_POST['info']['pingjia_score']) : 0;
            $biaoxianbiao = isset($_POST['info']['biaoxianbiao']) ? addslashes($_POST['info']['biaoxianbiao']) : '';

            if (!$fengzu) {
                showmessage('分组不能为空', 'index.php?m=peixunnew&c=yanlian_canyu&a=init');
            }

            $data = array(
                'fengzu' => $fengzu,
                'biaoxianbiao' => $biaoxianbiao,
                'pingjia_score' => $pingjia_score
            );

            $this->db->table_name = 'v9_yanlian_canyu';
            $result = $this->db->update($data, array('id' => $id));
            if ($result) {
                showmessage('修改成功', 'index.php?m=peixunnew&c=yanlian_canyu&a=init');
            } else {
                showmessage('修改失败', 'index.php?m=peixunnew&c=yanlian_canyu&a=init');
            }
        }
    }

    /**
     * 删除参与人
     */
    public function del()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$id) {
            showmessage('参数错误');
        }

        $this->db->table_name = 'v9_yanlian_canyu';
        $result = $this->db->update(array('isok' => 0), array('id' => $id));
        if ($result) {
            showmessage('删除成功', 'index.php?m=peixunnew&c=yanlian_canyu&a=init');
        } else {
            showmessage('删除失败', 'index.php?m=peixunnew&c=yanlian_canyu&a=init');
        }
    }
}

?>
