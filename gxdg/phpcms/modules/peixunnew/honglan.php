<?php
ini_set("display_errors", "Off");
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class honglan extends admin
{
    var $db;

    public function __construct()
    {
        $this->db = pc_base::load_model('opinion2_model');
        $this->db->table_name = 'v9_fujing';
        pc_base::load_app_func('global');
        setcookie('zq_hash', $_SESSION['pc_hash']);
    }

    // 主页 - 数据统计
    public function init()
    {
        include $this->admin_tpl('honglan_main');
    }

}
