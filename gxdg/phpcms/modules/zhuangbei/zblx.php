<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class zblx extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		$this->db->table_name = 'mj_zblx';
		pc_base::load_app_func('global');
	}
	
	public function init() {
		
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$zblx = $this->db->listinfo('',$order = 'id asc',$page, $pages = '12');
		$pages = $this->db->pages;
		include $this->admin_tpl('zblx_list');
	}
	
	function add()
	{
		if(isset($_POST['dosubmit'])) {
			
			
		
			
			
		
		$this->db->insert($_POST['info']);
			
			
			showmessage('操作完毕','index.php?m=zhuangbei&c=zblx');
		}
		
		include $this->admin_tpl('add_zblx');
	}
	
	function edit()
	{
		
		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
			
			$this->db->update($_POST['info'],array('id'=>$id));
			
			showmessage('操作完毕','index.php?m=zhuangbei&c=zblx');
		}
		$zblx = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('edit_zblx');
	}
	function show()
	{
		$id=$_REQUEST['id'];
		
		$zblx = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('show_zblx');
	}
	//更新排序
 	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $id => $listorder) {
				$id = intval($id);
				$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} 
	}
	
	
	
	function delete()
	{
		$id = $_GET['id'];
		
		if($this->db->delete(array('id'=>$_GET['id']))) {
			
			exit('1');
		} else {
			exit('0');
		}
	}
	function deleteall(){
		
		if(is_array($_POST['id'])){
				foreach($_POST['id'] as $linkid_arr) {
 					//批量删除友情链接
					$this->db->update(array('isdel'=>1),array('id'=>$linkid_arr));
					
					
				}
				showmessage(L('operation_success'),HTTP_REFERER);
		}
		}
}


