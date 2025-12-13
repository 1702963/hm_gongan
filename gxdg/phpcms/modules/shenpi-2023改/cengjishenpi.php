<?php
set_time_limit(0);
ini_set("display_errors", "On"); 
//error_reporting(7);

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class cengjishenpi extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		
		$this->db->table_name = 'mj_dd_cengji';
		pc_base::load_app_func('global');
	}
	
	public function init() { //主列表	
	if($_SESSION['roleid']==9){
	$where="isdel=1 and userid=".$_SESSION['userid'];
	}
	if($_SESSION['roleid']==5){
	$where="isdel=1 and bmshid=".$_SESSION['userid'];
	}
	if($_SESSION['roleid']==2){
	$where="isdel=1 and zrshid=".$_SESSION['userid'];
	}
	if($_SESSION['roleid']==3){
	$userid=$_SESSION['userid'];
	$where="isdel=1 and (fgshid=$userid or ldshid=$userid)";
	}
	$this->db->table_name = 'mj_dd_cengji';
	$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,$order = 'id desc',$page, $pages = '12');
		$pages = $this->db->pages;
		
		
		
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumens[$v['id']]=$v['name'];  
			 }

		//岗位映射
		  $this->db->table_name = 'mj_gangwei';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gangweis[$v['id']]=$v['gwname'];  
			 }			   
 
 		//邦定辅助岗位
		$this->db->table_name = 'mj_gangweifz';
		$rowss = $this->db->select("",'id,gwname','','id asc');
		
		foreach($rowss as $aaa){
			$fzgangweis[$aaa['id']]=$aaa['gwname'];
			}
		//邦定层级
		$this->db->table_name = 'mj_cengji';
		$rowss = $this->db->select("",'id,cjname','','id asc');
		
		foreach($rowss as $aaa){
			$cengjis[$aaa['id']]=$aaa['cjname'];
			}	
		//绑定领导
		$this->db->table_name = 'mj_admin';
		$lds = $this->db->select("roleid in (5,3,2)",'userid,username','','userid asc');
		
		foreach($lds as $aaa){
			$ld[$aaa['userid']]=$aaa['username'];
			}	
		//审核状态
		$zt=array(1=>'未审核',2=>'不同意',9=>'同意');	
			
		include $this->admin_tpl('renyuan_cengji');
	}


public function show() { //主列表	
	$id=$_GET['id'];
	$this->db->table_name = 'mj_dd_cengji';
	$info = $this->db->get_one("id=$id",'*');
		
		
		
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumens[$v['id']]=$v['name'];  
			 }

		//岗位映射
		  $this->db->table_name = 'mj_gangwei';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gangweis[$v['id']]=$v['gwname'];  
			 }			   
 
 		//邦定辅助岗位
		$this->db->table_name = 'mj_gangweifz';
		$rowss = $this->db->select("",'id,gwname','','id asc');
		
		foreach($rowss as $aaa){
			$fzgangweis[$aaa['id']]=$aaa['gwname'];
			}
			//邦定层级
		$this->db->table_name = 'mj_cengji';
		$rowss = $this->db->select("",'id,cjname','','id asc');
		
		foreach($rowss as $aaa){
			$cengjis[$aaa['id']]=$aaa['cjname'];
			}
		//绑定领导
		$this->db->table_name = 'mj_admin';
		$lds = $this->db->select("roleid in (5,3,2,9)",'userid,username','','userid asc');
		
		foreach($lds as $aaa){
			$ld[$aaa['userid']]=$aaa['username'];
			}	
		//审核状态
		$zt=array(1=>'未审核',2=>'不同意',9=>'同意');	
		
		if($info['fj']){
		$images=explode("|",$info['fj']);
		}
		
		include $this->admin_tpl('renyuan_cengji_show');
	}
public function img(){
$url=$_GET['url'];
include $this->admin_tpl('img');
}

	
				
	function gwbd() 
	{		
		
		
		if(isset($_POST['dosubmit'])) {
		$fjid=$_POST['info']['fjid'];
		$this->db->table_name = 'mj_fujing';
			$fj = $this->db->get_one("id=$fjid",'*');
			$_POST['info']['fjname']=$fj['xingming'];
			
			
			$_POST['info']['userid']=$_SESSION['userid'];
			$_POST['info']['inputtime']=time();
			$_POST['info']['type']=1;
			
		$this->db->table_name = 'mj_dd_cengji';
		$this->db->insert($_POST['info']);
		echo "<script>alert('操作成功');</script>";
		showmessage(L('operation_success'),'','','showme');
		}
		
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumens[$v['id']]=$v['name'];  
			 }
		//邦定层级
		$this->db->table_name = 'mj_cengji';
		$rowss = $this->db->select("",'id,cjname','','id asc');
		
		foreach($rowss as $aaa){
			$cengjis[$aaa['id']]=$aaa['cjname'];
			}
		//岗位映射
		  $this->db->table_name = 'mj_gangwei';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gangweis[$v['id']]=$v['gwname'];  
			 }			   
 
 		//邦定辅助岗位
		$this->db->table_name = 'mj_gangweifz';
		$rowss = $this->db->select("",'id,gwname','','id asc');
		
		foreach($rowss as $aaa){
			$fzgangweis[$aaa['id']]=$aaa['gwname'];
			}
 		//邦定本部门领导
		$this->db->table_name = 'mj_admin';
		$lds = $this->db->select("roleid=5 and bmid=".$_SESSION['bmid'],'userid,username','','userid asc');
		
		foreach($lds as $aaa){
			$ld[$aaa['userid']]=$aaa['username'];
			}
 		//绑定在职人员
		if($_SESSION['bmid']){
		$this->db->table_name = 'mj_fujing';
		$rss = $this->db->select(" status=1 and dwid=".$_SESSION['bmid'],'id,xingming,sfz','','id asc');
		$fujing=array();
		$fujing[0]="请选择辅警";
		foreach($rss as $aaa){
			$fujing[$aaa['id']]=$aaa['xingming']."-".$aaa['sfz'];
			
			}	
		}	
		 /* $this->db->table_name = 'mj_msgs'; 		  
		  $infos=$this->db->get_one("id=$id","*");
		  
		  if($infos['showuser']==$_SESSION['userid']){ //更新阅读状态
		   $rdt=time();
		   $this->db->update(array('isshow'=>1,'readdt'=>$rdt),array('id'=>$id));
		  }	*/  
		   
		include $this->admin_tpl('renyuan_cengji_shenqing');
	}	
//部门领导审核
function bmsh() {	
	
		$id=$_REQUEST['id'];
		
		
		
		if(isset($_POST['dosubmit'])) {
		
			
		$this->db->table_name = 'mj_dd_cengji';
		if($_POST['bmstatus']==9){
		$this->db->update(array('bmstatus'=>$_POST['bmstatus'],'bmshtime'=>time(),'fgshid'=>$_POST['fgshid'],'fgstatus'=>1),array('id'=>$id));
		}else{
		$this->db->update(array('bmstatus'=>$_POST['bmstatus'],'bmshtime'=>time()),array('id'=>$id));
		}
		echo "<script>alert('操作成功');</script>";
		showmessage(L('operation_success'),'','','showmebm');
		}
		
		
 		//邦定fg领导
		$this->db->table_name = 'mj_admin';
		$lds = $this->db->select("roleid=3 ",'userid,username','','userid asc');
		
		foreach($lds as $aaa){
			$ld[$aaa['userid']]=$aaa['username'];
			}
 			
	
		   
		include $this->admin_tpl('renyuan_cengji_bmsh');
	}
	
	//分管领导审核
function fgsh() {	
	
		$id=$_REQUEST['id'];
		
		
		
		if(isset($_POST['dosubmit'])) {
		
			
		$this->db->table_name = 'mj_dd_cengji';
		if($_POST['fgstatus']==9){
		$this->db->update(array('fgstatus'=>$_POST['fgstatus'],'fgshtime'=>time(),'zrshid'=>$_POST['zrshid'],'zrstatus'=>1),array('id'=>$id));
		}else{
		$this->db->update(array('fgstatus'=>$_POST['fgstatus'],'fgshtime'=>time()),array('id'=>$id));
		}
		echo "<script>alert('操作成功');</script>";
		showmessage(L('operation_success'),'','','showmefg');
		}
		
		
 		//邦定主任
		$this->db->table_name = 'mj_admin';
		$lds = $this->db->select("roleid=2 ",'userid,username','','userid asc');
		
		foreach($lds as $aaa){
			$ld[$aaa['userid']]=$aaa['username'];
			}
 			
	
		   
		include $this->admin_tpl('renyuan_cengji_fgsh');
	}

	//主任审核
function zrsh() {	
	
		$id=$_REQUEST['id'];
		
		
		
		if(isset($_POST['dosubmit'])) {
		
			
		$this->db->table_name = 'mj_dd_cengji';
		
		if($_POST['zrstatus']==9){
		
			if($_POST['dai']==1){
			$this->db->update(array('zrstatus'=>$_POST['zrstatus'],'zrshtime'=>time(),'ldshid'=>$_POST['ldshid'],'ldstatus'=>9,'ldshtime'=>time(),'dai'=>1),array('id'=>$id));
			//更改辅警部门 岗位信息
			$info = $this->db->get_one("id=$id",'*');
			$this->db->table_name = 'mj_fujing';
			$this->db->update(array('cengji'=>$info['newcj']),array('id'=>$info['fjid']));
			}else{
			$this->db->update(array('zrstatus'=>$_POST['zrstatus'],'zrshtime'=>time(),'ldshid'=>$_POST['ldshid'],'ldstatus'=>1),array('id'=>$id));
			}
		
		}else{
		$this->db->update(array('zrstatus'=>$_POST['zrstatus'],'zrshtime'=>time()),array('id'=>$id));
		}
		
		echo "<script>alert('操作成功');</script>";
		showmessage(L('operation_success'),'','','showmezr');
		}
		
		
 		//邦定主任
		$this->db->table_name = 'mj_admin';
		$lds = $this->db->select("roleid=3 ",'userid,username','','userid asc');
		
		foreach($lds as $aaa){
			$ld[$aaa['userid']]=$aaa['username'];
			}
 			
	
		   
		include $this->admin_tpl('renyuan_cengji_zrsh');
	}
		//局领导审核
function ldsh() {	
	
		$id=$_REQUEST['id'];
		
		
		
		if(isset($_POST['dosubmit'])) {
		
			
		$this->db->table_name = 'mj_dd_cengji';
		$this->db->update(array('ldstatus'=>$_POST['ldstatus'],'ldshtime'=>time()),array('id'=>$id));
		if($_POST['ldstatus']==9){
		//更改辅警部门 岗位信息
		$info = $this->db->get_one("id=$id",'*');
		$this->db->table_name = 'mj_fujing';
		$this->db->update(array('cengji'=>$info['newcj']),array('id'=>$info['fjid']));
		}
		echo "<script>alert('操作成功');</script>";
		showmessage(L('operation_success'),'','','showmeld');
		}
		
		
 		
 			
	
		   
		include $this->admin_tpl('renyuan_cengji_ldsh');
	}
	public function chafj(){
	$fjid=$_GET['fjid'];
	$this->db->table_name = 'mj_fujing';
	$fj = $this->db->get_one("id=$fjid","cengji");
	//岗位
	$this->db->table_name = 'mj_cengji';
	$cj = $this->db->get_one("id=".$fj['cengji'],"cjname");
	
	$fjarr=array('cjid'=>$fj['cengji'],'cjname'=>$cj['cjname']);
	echo json_encode($fjarr);
	
	}
	
	
	function delete()
	{
		$id = $_GET['id'];
		$this->db->table_name = 'mj_dd_cengji';
		if($this->db->update(array('isdel'=>2),array('id'=>$_GET['id']))) {
			
			exit('1');
		} else {
			exit('0');
		}
	}
	/////////////////////////////////////////////////////
}


