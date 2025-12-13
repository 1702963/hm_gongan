<?php
set_time_limit(0);
ini_set("display_errors", "On"); 
//error_reporting(7);

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class gongzishenpi extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		$this->db2 = pc_base::load_model('opinion_model');
		$this->db->table_name = 'mj_fujing';
		pc_base::load_app_func('global');
	}
	
	public function init() { //主列表		
		include $this->admin_tpl('gongzi_main');
	}

	public function biandonglist() { //层级变动		
		include $this->admin_tpl('cengji_biandong_list');
	}
	
	public function qingkuanglist() { //层级情况		
		include $this->admin_tpl('cengji_qingkuang_list');
	}	
				
	function zlsp() 
	{
        $id=intval($_GET['id']); 
		

		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		//岗位映射
		  $this->db->table_name = 'mj_gangwei';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gangwei[$v['id']]=$v['gwname'];  
			 }			   
 
 
		  $this->db->table_name = 'mj_msgs'; 		  
		  $infos=$this->db->get_one("id=$id","*");
		  
		  if($infos['showuser']==$_SESSION['userid']){ //更新阅读状态
		   $rdt=time();
		   $this->db->update(array('isshow'=>1,'readdt'=>$rdt),array('id'=>$id));
		  }	  
		   
		include $this->admin_tpl('rencai_list');
	}	

	/////////////////////////////////////////////////////
}


