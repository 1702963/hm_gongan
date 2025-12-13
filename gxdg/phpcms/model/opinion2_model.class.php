<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class opinion2_model extends model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'gxdgdb';
		$this->table_name = 'opinion';
		
		//var_dump($this->db_config);
		parent::__construct();
	}
}
?>