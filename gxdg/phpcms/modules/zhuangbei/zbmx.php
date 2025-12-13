<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class zbmx extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		$this->db->table_name = 'mj_beizhuang_zidian';
		pc_base::load_app_func('global');
	}
	
	public function init() {
		
		if($_GET['doty']!=""){
		
	    if(intval($_GET['pici'])<1){
			$dotime=-99;
			}else{
			$dotime=intval($_GET['pici']);	
				}
			
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$zbmx = $this->db->listinfo("pid=0 and dotime=$dotime ",$order = 'px asc',$page, $pages = '300');
		$pages = $this->db->pages;
		
		include $this->admin_tpl('zbmx_list_sub');			
			
			}else{
		
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$zbmx = $this->db->listinfo('pid=0 and dotime=0',$order = 'px asc',$page, $pages = '300');
		$pages = $this->db->pages;
		
		include $this->admin_tpl('zbmx_list');
			}
	}
	
	///////////////////////////////////////////////////////////////////////////////////
	function addlm()
	{
		
		if($_POST['nodosave']!=""){
			showmessage("关闭窗口","?index.php?m=zhuangbei&c=zhuangbei&a=setobj&objid=".$_POST['objid'],3000,'showme');
		}
		
		if(isset($_POST['dosubmit'])) {			
            
			//showmessage('操作完毕','index.php?m=zhuangbei&c=zbmx');
		}
		
		include $this->admin_tpl('add_lm');
	}	
	///////////////////////////////////////////////////////////////////////////////////
	
	function add()
	{
		if(isset($_POST['dosubmit'])) {
			
		//$seting=str_replace("\r\n","|",$_POST['seting']);
		//加入字段操作
		//$sql = "ALTER TABLE `mj_fujing_fz` ADD `$field` VARCHAR( 255 )  NULL DEFAULT ''";
		//$this->db->query($sql);
		///此处处理树形节点路径，不需要递归
		$lmpid=intval($_POST['lm']['pid']);
		$lmrs=$this->db->get_one("id=$lmpid",'paths,id');
		if($lmrs){
			$_POST['lm']['paths']=$lmrs['paths'].",".$lmrs['id'];
			}else{
			$_POST['lm']['paths']=0;	
				}
		
		    $this->db->insert($_POST['lm']);  
			showmessage('操作完毕','index.php?m=zhuangbei&c=zbmx');
		}
		
		include $this->admin_tpl('add_zbmx');
	}
	
	function addsub()
	{
		if(isset($_POST['dosubmit'])) {
			
		//$seting=str_replace("\r\n","|",$_POST['seting']);
		//加入字段操作
		//$sql = "ALTER TABLE `mj_fujing_fz` ADD `$field` VARCHAR( 255 )  NULL DEFAULT ''";
		//$this->db->query($sql);
		///此处处理树形节点路径，不需要递归
		$lmpid=intval($_POST['lm']['pid']);
		$lmrs=$this->db->get_one("id=$lmpid",'paths,id');
		if($lmrs){
			$_POST['lm']['paths']=$lmrs['paths'].",".$lmrs['id'];
			}else{
			$_POST['lm']['paths']=0;	
				}
		 	$_POST['lm']['dotime']=intval($_POST['dotime']);
			
			//print_r($_POST);exit;
				
		    $newid=$this->db->insert($_POST['lm'],true);
			//写回OLDID，兼容
			$this->db->update("oldid=$newid","id=$newid");  
			  
			showmessage('操作完毕',$_POST['forward']);
		}
		
		include $this->admin_tpl('add_zbmxsub');
	}	
	
	function edit()
	{
		
		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
			//此处需要重新生成树形路由
		$lmpid=intval($_POST['lm']['pid']);
		$lmrs=$this->db->get_one("id=$lmpid",'paths,id');
		if($lmrs){
			$_POST['lm']['paths']=$lmrs['paths'].",".$lmrs['id'];
			}else{
			$_POST['lm']['paths']=0;	
				}			
			
			$this->db->update($_POST['lm'],array('id'=>intval($_POST['id'])));
			
			showmessage('操作完毕','index.php?m=zhuangbei&c=zbmx');
		}
		$zbmx = $this->db->get_one("id=$id",'*');
		if(!$zbmx){showmessage('无此类目','index.php?m=zhuangbei&c=zbmx');}
		
		include $this->admin_tpl('edit_zbmx');
	}
	function show()
	{
		$id=$_REQUEST['id'];
		
		$zbmx = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('show_zbmx');
	}
	//更新排序
 	public function listorder() {
		if(isset($_POST['dopx'])) {
			foreach($_POST['px'] as $id => $px) {
				$id = intval($id);
				$this->db->update(array('px'=>$px),array('id'=>$id));
			}
			showmessage("操作完成",HTTP_REFERER);
		} 
	}
	
	
	
	function lmdelete()
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


