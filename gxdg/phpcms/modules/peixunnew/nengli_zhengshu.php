<?php
ini_set("display_errors", "On");
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

/**
 * 个人能力证书管理
 */
class nengli_zhengshu extends admin
{
    private $db;

    public function __construct()
    {
        $this->db = pc_base::load_model('opinion2_model');
        $this->db->table_name = 'v9_nengli_zhengshu';
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

        $fjid = isset($_GET['fjid']) ? intval($_GET['fjid']) : 0;
        $fjname = isset($_GET['fjname']) ? addslashes(trim($_GET['fjname'])) : '';
        $type_id = isset($_GET['type_id']) ? intval($_GET['type_id']) : 0;
        $status = isset($_GET['status']) ? intval($_GET['status']) : -1;

        $where = "1=1";
        if ($fjid > 0) {
            $where .= " AND nz.fjid={$fjid}";
        }
        if ($fjname !== '') {
            $where .= " AND fj.xingming LIKE '%{$fjname}%'";
        }
        if ($type_id > 0) {
            $where .= " AND nz.type_id={$type_id}";
        }
        if ($status >= 0) {
            $where .= " AND nz.status={$status}";
        }

        $this->fjid = $fjid;
        $this->fjname = $fjname;
        $this->type_id = $type_id;
        $this->status = $status;

        $db_config = pc_base::load_config('database');
        pc_base::load_sys_class('db_factory', '', 0);
        $dbb = db_factory::get_instance($db_config)->get_database('gxdgdb');

        $count_sql = "SELECT COUNT(*) AS cnt FROM fujing.v9_nengli_zhengshu nz "
            . "LEFT JOIN fujing.v9_fujing fj ON nz.fjid=fj.id "
            . "LEFT JOIN fujing.v9_nengli_zhengshu_type nt ON nz.type_id=nt.id "
            . "WHERE {$where}";
        $dbb->query($count_sql);
        $count_row = $dbb->fetch_next();
        $total = isset($count_row['cnt']) ? intval($count_row['cnt']) : 0;

        $page = max(intval($page), 1);
        $offset = $pagesize * ($page - 1);
        $pages = pages($total, $page, $pagesize);

        $sql = "SELECT nz.*, nt.typename, fj.xingming AS fjname, fj.dwid "
            . "FROM fujing.v9_nengli_zhengshu nz "
            . "LEFT JOIN fujing.v9_nengli_zhengshu_type nt ON nz.type_id=nt.id "
            . "LEFT JOIN fujing.v9_fujing fj ON nz.fjid=fj.id "
            . "WHERE {$where} "
            . "ORDER BY nz.id DESC "
            . "LIMIT {$offset}, {$pagesize}";
        $dbb->query($sql);

        $list = array();
        while ($row = $dbb->fetch_next()) {
            if (isset($row['inputtime']) && $row['inputtime'] > 0) {
                $row['inputtime_show'] = date("Y-m-d H:i", $row['inputtime']);
            }
            if (isset($row['updatetime']) && $row['updatetime'] > 0) {
                $row['updatetime_show'] = date("Y-m-d H:i", $row['updatetime']);
            }
            $list[] = $row;
        }

        $this->list = $list;
        $this->pages = $pages;

        // 证书类型列表（用于筛选展示）
        $this->db->table_name = 'v9_nengli_zhengshu_type';
        $this->type_list = $this->db->select('', 'id,typename', '', 'paixu DESC,id DESC');

        include $this->admin_tpl('nengli_zhengshu_list');
    }

    /**
     * 添加页
     */
    public function add()
    {
        $this->db->table_name = 'v9_nengli_zhengshu_type';
        $type_list = $this->db->select('status=1', 'id,typename', '', 'paixu DESC,id DESC');
        $this->type_list = $type_list;

        include $this->admin_tpl('nengli_zhengshu_add');
    }

    /**
     * 保存新增
     */
    public function addsave()
    {
        if (isset($_POST['dosubmit'])) {
            $info = isset($_POST['info']) ? $_POST['info'] : array();

            $fjid = isset($info['fjid']) ? intval($info['fjid']) : 0;
            $fjname = isset($info['fjname']) ? addslashes(trim($info['fjname'])) : '';
            $bmid = isset($info['bmid']) ? intval($info['bmid']) : 0;
            $type_id = isset($info['type_id']) ? intval($info['type_id']) : 0;
            $zhengshu_no = isset($info['zhengshu_no']) ? addslashes(trim($info['zhengshu_no'])) : '';
            $jigou = isset($info['jigou']) ? addslashes(trim($info['jigou'])) : '';
            $huode_time = isset($info['huode_time']) ? addslashes(trim($info['huode_time'])) : '';
            $youxiao_start = isset($info['youxiao_start']) ? addslashes(trim($info['youxiao_start'])) : '';
            $youxiao_end = isset($info['youxiao_end']) ? addslashes(trim($info['youxiao_end'])) : '';
            $dengji = isset($info['dengji']) ? addslashes(trim($info['dengji'])) : '';
            $chengji = isset($info['chengji']) ? addslashes(trim($info['chengji'])) : '';
            $files = isset($info['files']) ? addslashes(trim($info['files'])) : '';
            $beizhu = isset($info['beizhu']) ? addslashes(trim($info['beizhu'])) : '';
            $status = isset($info['status']) ? intval($info['status']) : 1;
            $bmuser = isset($info['bmuser']) ? addslashes(trim($info['bmuser'])) : '';
            $bmok = isset($info['bmok']) ? intval($info['bmok']) : 0;
            $bmdt = isset($info['bmdt']) ? addslashes(trim($info['bmdt'])) : '';

            if ($fjid <= 0 && $fjname === '') {
                showmessage('请选择辅警', HTTP_REFERER);
            }
            if ($type_id <= 0) {
                showmessage('请选择证书类型', HTTP_REFERER);
            }

            // 获取证书类型名称
            $typename = '';
            $this->db->table_name = 'v9_nengli_zhengshu_type';
            $type_info = $this->db->get_one(array('id' => $type_id));
            if ($type_info) {
                $typename = $type_info['typename'];
            }

            // 尝试获取辅警名称与部门
            if ($fjid > 0) {
                $this->db->table_name = 'v9_fujing';
                $fjinfo = $this->db->get_one(array('id' => $fjid));
                if ($fjinfo) {
                    $fjname = $fjinfo['xingming'];
                    $bmid = isset($fjinfo['dwid']) ? intval($fjinfo['dwid']) : 0;
                }
            }

            $this->db->table_name = 'v9_nengli_zhengshu';
            $data = array(
                'fjid' => $fjid,
                'fjname' => $fjname,
                'bmid' => $bmid,
                'type_id' => $type_id,
                'typename' => $typename,
                'zhengshu_no' => $zhengshu_no,
                'jigou' => $jigou,
                'huode_time' => $huode_time,
                'youxiao_start' => $youxiao_start,
                'youxiao_end' => $youxiao_end,
                'dengji' => $dengji,
                'chengji' => $chengji,
                'files' => $files,
                'beizhu' => $beizhu,
                'status' => $status,
                'bmuser' => $bmuser,
                'bmok' => $bmok,
                'bmdt' => $bmdt,
                'inputtime' => time(),
                'inputuser' => $_SESSION['userid'],
                'adddate' => date('Y-m-d H:i:s'),
                'addyear' => intval(date('Y')),
                'addmonth' => intval(date('m'))
            );

            $result = $this->db->insert($data);
            if ($result) {
                showmessage('添加成功', '?m=peixunnew&c=nengli_zhengshu&a=init');
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

        $this->db->table_name = 'v9_nengli_zhengshu';
        $info = $this->db->get_one(array('id' => $id));
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        $this->db->table_name = 'v9_nengli_zhengshu_type';
        $type_list = $this->db->select('status=1', 'id,typename', '', 'paixu DESC,id DESC');

        $this->info = $info;
        $this->type_list = $type_list;
        include $this->admin_tpl('nengli_zhengshu_edit');
    }

    /**
     * 保存编辑
     */
    public function editsave()
    {
        if (isset($_POST['dosubmit'])) {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $info = isset($_POST['info']) ? $_POST['info'] : array();

            if ($id <= 0) {
                showmessage('参数错误', HTTP_REFERER);
            }

            $fjid = isset($info['fjid']) ? intval($info['fjid']) : 0;
            $fjname = isset($info['fjname']) ? addslashes(trim($info['fjname'])) : '';
            $bmid = isset($info['bmid']) ? intval($info['bmid']) : 0;
            $type_id = isset($info['type_id']) ? intval($info['type_id']) : 0;
            $zhengshu_no = isset($info['zhengshu_no']) ? addslashes(trim($info['zhengshu_no'])) : '';
            $jigou = isset($info['jigou']) ? addslashes(trim($info['jigou'])) : '';
            $huode_time = isset($info['huode_time']) ? addslashes(trim($info['huode_time'])) : '';
            $youxiao_start = isset($info['youxiao_start']) ? addslashes(trim($info['youxiao_start'])) : '';
            $youxiao_end = isset($info['youxiao_end']) ? addslashes(trim($info['youxiao_end'])) : '';
            $dengji = isset($info['dengji']) ? addslashes(trim($info['dengji'])) : '';
            $chengji = isset($info['chengji']) ? addslashes(trim($info['chengji'])) : '';
            $files = isset($info['files']) ? addslashes(trim($info['files'])) : '';
            $beizhu = isset($info['beizhu']) ? addslashes(trim($info['beizhu'])) : '';
            $status = isset($info['status']) ? intval($info['status']) : 1;
            $bmuser = isset($info['bmuser']) ? addslashes(trim($info['bmuser'])) : '';
            $bmok = isset($info['bmok']) ? intval($info['bmok']) : 0;
            $bmdt = isset($info['bmdt']) ? addslashes(trim($info['bmdt'])) : '';

            if ($fjid <= 0 && $fjname === '') {
                showmessage('请选择辅警', HTTP_REFERER);
            }
            if ($type_id <= 0) {
                showmessage('请选择证书类型', HTTP_REFERER);
            }

            $typename = '';
            $this->db->table_name = 'v9_nengli_zhengshu_type';
            $type_info = $this->db->get_one(array('id' => $type_id));
            if ($type_info) {
                $typename = $type_info['typename'];
            }

            if ($fjid > 0) {
                $this->db->table_name = 'v9_fujing';
                $fjinfo = $this->db->get_one(array('id' => $fjid));
                if ($fjinfo) {
                    $fjname = $fjinfo['xingming'];
                    $bmid = isset($fjinfo['dwid']) ? intval($fjinfo['dwid']) : 0;
                }
            }

            $this->db->table_name = 'v9_nengli_zhengshu';
            $data = array(
                'fjid' => $fjid,
                'fjname' => $fjname,
                'bmid' => $bmid,
                'type_id' => $type_id,
                'typename' => $typename,
                'zhengshu_no' => $zhengshu_no,
                'jigou' => $jigou,
                'huode_time' => $huode_time,
                'youxiao_start' => $youxiao_start,
                'youxiao_end' => $youxiao_end,
                'dengji' => $dengji,
                'chengji' => $chengji,
                'files' => $files,
                'beizhu' => $beizhu,
                'status' => $status,
                'bmuser' => $bmuser,
                'bmok' => $bmok,
                'bmdt' => $bmdt,
                'updatetime' => time()
            );

            $result = $this->db->update($data, array('id' => $id));
            if ($result !== false) {
                showmessage('保存成功', '?m=peixunnew&c=nengli_zhengshu&a=init');
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

        $this->db->table_name = 'v9_nengli_zhengshu';
        $info = $this->db->get_one(array('id' => $id));
        if (!$info) {
            showmessage('数据不存在', HTTP_REFERER);
        }

        $result = $this->db->delete(array('id' => $id));
        if ($result) {
            showmessage('删除成功', '?m=peixunnew&c=nengli_zhengshu&a=init');
        } else {
            showmessage('删除失败', HTTP_REFERER);
        }
    }

    /**
     * 辅警搜索接口
     */
    public function searchfujing()
    {
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
        if ($keyword === '') {
            echo json_encode(array('status' => 0, 'msg' => '请输入搜索关键词'));
            exit;
        }

        $keyword = addslashes($keyword);

        $this->db->table_name = 'v9_fujing';
        $where = " (xingming LIKE '%{$keyword}%' OR sfz LIKE '%{$keyword}%') AND status=1 AND isok=1 ";
        $list = $this->db->select($where, 'id,xingming,sex,sfz,dwid', '20', 'xingming ASC');

        if ($list) {
            // 关联部门名称
            $bumen_map = array();
            $this->db->table_name = 'v9_bumen';
            $bumen_list = $this->db->select('', 'id,name');
            if ($bumen_list) {
                foreach ($bumen_list as $bm) {
                    $bumen_map[$bm['id']] = $bm['name'];
                }
            }

            foreach ($list as &$item) {
                $item['danwei'] = (isset($item['dwid']) && isset($bumen_map[$item['dwid']])) ? $bumen_map[$item['dwid']] : '';
            }
            unset($item);

            echo json_encode(array('status' => 1, 'data' => $list));
        } else {
            echo json_encode(array('status' => 0, 'msg' => '未找到匹配的辅警'));
        }
        exit;
    }

    /**
     * 获取辅警详细信息
     */
    public function getfujinginfo()
    {
        $fjid = isset($_POST['fjid']) ? intval($_POST['fjid']) : 0;
        if ($fjid <= 0) {
            echo json_encode(array('status' => 0, 'msg' => '参数错误'));
            exit;
        }

        $this->db->table_name = 'v9_fujing';
        $info = $this->db->get_one(array('id' => $fjid));
        if (!$info) {
            echo json_encode(array('status' => 0, 'msg' => '辅警信息不存在'));
            exit;
        }

        $data = array(
            'xingming' => $info['xingming'],
            'sex' => $info['sex'],
            'sfz' => $info['sfz'],
            'dwid' => isset($info['dwid']) ? $info['dwid'] : 0,
            'tel' => isset($info['tel']) ? $info['tel'] : '',
            'xueli' => isset($info['xueli']) ? $info['xueli'] : '',
            'xuexiao' => isset($info['xuexiao']) ? $info['xuexiao'] : '',
            'zhuanye' => isset($info['zhuanye']) ? $info['zhuanye'] : ''
        );

        echo json_encode(array('status' => 1, 'data' => $data));
        exit;
    }
}
