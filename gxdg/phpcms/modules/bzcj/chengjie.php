<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class chengjie extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		$this->db->table_name = 'mj_chengjie';
		pc_base::load_app_func('global');
	}
	
	public function init() {
		
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$chengjie = $this->db->listinfo('',$order = 'id asc',$page, $pages = '12');
		$pages = $this->db->pages;
	
		
			
		include $this->admin_tpl('chengjie_list');
	}
	
	function add()
	{
		if(isset($_POST['dosubmit'])) {
			
			$this->db->table_name = 'mj_fujing';
			$fj = $this->db->get_one("id=".$_POST['info']['fjid'],'*');
			$_POST['info']['fjname']=$fj['xingming'];
			
			$_POST['info']['userid']=$_SESSION['userid'];
			$_POST['info']['inputtime']=time();
			$_POST['info']['bztime']=strtotime($_POST['bztime']);
			
		$this->db->table_name = 'mj_chengjie';
		$this->db->insert($_POST['info']);
			
			
			showmessage('操作完毕','index.php?m=bzcj&c=chengjie&a=init');
		}
		
		//绑定在职人员
		$this->db->table_name = 'mj_fujing';
		$rss = $this->db->select(" status=1 ",'id,xingming,sfz','','id asc');
		$fujing=array();
		
		foreach($rss as $aaa){
			$fujing[$aaa['id']]=$aaa['xingming']."-".$aaa['sfz'];
			
			}
			
		//绑定审核领导
		$this->db->table_name = 'mj_admin';
		$rss = $this->db->select(" roleid=3 ",'userid,username','','userid asc');
		$lingdao=array();
		
		foreach($rss as $aaa){
			$lingdao[$aaa['userid']]=$aaa['username'];
			
			}	
		include $this->admin_tpl('add_chengjie');
	}
	
	function sh()
	{
		
		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['shtime']=time();
			$this->db->update($_POST['info'],array('id'=>$id));
			echo "<script>alert('操作成功');</script>";
			showmessage('操作完毕','index.php?m=bzcj&c=chengjie','','showme2');
		}
		$chengjie = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('sh_chengjie');
	}
	function show()
	{
		$id=$_REQUEST['id'];
		
		$chengjie = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('show_chengjie');
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


