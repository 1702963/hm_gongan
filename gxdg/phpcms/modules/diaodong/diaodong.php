<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class diaodong extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		
		pc_base::load_app_func('global');
	}
	//层级
	public function cengji() {
		$this->db->table_name = 'mj_dd_cengji';
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo('',$order = 'id asc',$page, $pages = '12');
		$pages = $this->db->pages;
	
		//邦定层级
		$this->db->table_name = 'mj_cengji';
		$rss = $this->db->select("",'id,cjname','','id asc');
		$cengji=array();
		
		foreach($rss as $aaa){
			$cengji[$aaa['id']]=$aaa['cjname'];
			
			}
			
		include $this->admin_tpl('cengji_list');
	}
	
	function addcengji()
	{
		if(isset($_POST['dosubmit'])) {
			
			$this->db->table_name = 'mj_fujing';
			$fj = $this->db->get_one("id=".$_POST['info']['fjid'],'*');
			$_POST['info']['fjname']=$fj['xingming'];
			$_POST['info']['oldcj']=$fj['cengji'];
			
			$_POST['info']['userid']=$_SESSION['userid'];
			$_POST['info']['inputtime']=time();
			
			
		$this->db->table_name = 'mj_dd_cengji';
		$this->db->insert($_POST['info']);
			
			
			showmessage('操作完毕','index.php?m=diaodong&c=diaodong&a=cengji');
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
			//邦定层级
		$this->db->table_name = 'mj_cengji';
		$rss = $this->db->select("",'id,cjname','','id asc');
		$cengji=array();
		
		foreach($rss as $aaa){
			$cengji[$aaa['id']]=$aaa['cjname'];
			
			}
		include $this->admin_tpl('add_cengji');
	}
	
	function shcj()
	{
		
		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['shtime']=time();
			$this->db->table_name = 'mj_dd_cengji';
			$this->db->update($_POST['info'],array('id'=>$id));
			//审核成功后，变更辅警的层级
			if($_POST['info']['status']==9){
			$this->db->table_name = 'mj_fujing';
			$this->db->update(array('cengji'=>$_POST['cengji']),array('id'=>$_POST['fjid']));
			}
			echo "<script>alert('操作成功');</script>";
			showmessage('操作完毕','index.php?m=bzcj&c=biaozhang','','showme2');
		}
		$this->db->table_name = 'mj_dd_cengji';
		$info = $this->db->get_one("id=$id",'*');
		//邦定层级
		$this->db->table_name = 'mj_cengji';
		$rss = $this->db->select("",'id,cjname','','id asc');
		$cengji=array();
		
		foreach($rss as $aaa){
			$cengji[$aaa['id']]=$aaa['cjname'];
			
			}
		include $this->admin_tpl('sh_cengji');
	}
	function showcj()
	{
		$id=$_REQUEST['id'];
		$this->db->table_name = 'mj_dd_cengji';
		$info = $this->db->get_one("id=$id",'*');
		//邦定层级
		$this->db->table_name = 'mj_cengji';
		$rss = $this->db->select("",'id,cjname','','id asc');
		$cengji=array();
		
		foreach($rss as $aaa){
			$cengji[$aaa['id']]=$aaa['cjname'];
			
			}
		include $this->admin_tpl('show_cengji');
	}
	
	
	function deletecj()
	{
		$id = $_GET['id'];
		$this->db->table_name = 'mj_dd_cengji';
		if($this->db->delete(array('id'=>$_GET['id']))) {
			
			exit('1');
		} else {
			exit('0');
		}
	}
	
	
	
	
	//层级
	public function bumen() {
		$this->db->table_name = 'mj_dd_danwei';
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo('',$order = 'id asc',$page, $pages = '12');
		$pages = $this->db->pages;
	
		//邦单位
		$this->db->table_name = 'mj_bumen';
		$rss = $this->db->select("",'id,name','','id asc');
		$danwei=array();
		
		foreach($rss as $aaa){
			$danwei[$aaa['id']]=$aaa['name'];
			
			}
			
		include $this->admin_tpl('danwei_list');
	}
	
	function addbumen()
	{
		if(isset($_POST['dosubmit'])) {
			
			$this->db->table_name = 'mj_fujing';
			$fj = $this->db->get_one("id=".$_POST['info']['fjid'],'*');
			$_POST['info']['fjname']=$fj['xingming'];
			$_POST['info']['olddw']=$fj['dwid'];
			
			$_POST['info']['userid']=$_SESSION['userid'];
			$_POST['info']['inputtime']=time();
			
			
		$this->db->table_name = 'mj_dd_danwei';
		$this->db->insert($_POST['info']);
			
			
			showmessage('操作完毕','index.php?m=diaodong&c=diaodong&a=bumen');
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
		//邦单位
		$this->db->table_name = 'mj_bumen';
		$rss = $this->db->select("",'id,name','','id asc');
		$danwei=array();
		
		foreach($rss as $aaa){
			$danwei[$aaa['id']]=$aaa['name'];
			
			}
		include $this->admin_tpl('add_danwei');
	}
	
	function shdw()
	{
		
		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['shtime']=time();
			$this->db->table_name = 'mj_dd_danwei';
			$this->db->update($_POST['info'],array('id'=>$id));
			//审核成功后，变更辅警的层级
			if($_POST['info']['status']==9){
			$this->db->table_name = 'mj_fujing';
			$this->db->update(array('dwid'=>$_POST['dwid']),array('id'=>$_POST['fjid']));
			}
			echo "<script>alert('操作成功');</script>";
			showmessage('操作完毕','index.php?m=bzcj&c=biaozhang','','showme2');
		}
		$this->db->table_name = 'mj_dd_danwei';
		$info = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('sh_danwei');
	}
	function showdw()
	{
		$id=$_REQUEST['id'];
		$this->db->table_name = 'mj_dd_danwei';
		$info = $this->db->get_one("id=$id",'*');
		//邦单位
		$this->db->table_name = 'mj_bumen';
		$rss = $this->db->select("",'id,name','','id asc');
		$danwei=array();
		
		foreach($rss as $aaa){
			$danwei[$aaa['id']]=$aaa['name'];
			
			}
		include $this->admin_tpl('show_danwei');
	}
	
	
	function deletedw()
	{
		$id = $_GET['id'];
		$this->db->table_name = 'mj_dd_danwei';
		if($this->db->delete(array('id'=>$_GET['id']))) {
			
			exit('1');
		} else {
			exit('0');
		}
	}
	
	//变更岗位
	
	public function gangwei() {
		$this->db->table_name = 'mj_dd_gangwei';
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo('',$order = 'id asc',$page, $pages = '12');
		$pages = $this->db->pages;
	
		//邦单位
		$this->db->table_name = 'mj_gangwei';
		$rss = $this->db->select("",'id,gwname','','id asc');
		$gangwei=array();
		
		foreach($rss as $aaa){
			$gangwei[$aaa['id']]=$aaa['gwname'];
			
			}
			
		include $this->admin_tpl('gangwei_list');
	}
	
	function addgangwei()
	{
		if(isset($_POST['dosubmit'])) {
			
			$this->db->table_name = 'mj_fujing';
			$fj = $this->db->get_one("id=".$_POST['info']['fjid'],'*');
			$_POST['info']['fjname']=$fj['xingming'];
			$_POST['info']['oldgw']=$fj['gangwei'];
			
			$_POST['info']['userid']=$_SESSION['userid'];
			$_POST['info']['inputtime']=time();
			
			
		$this->db->table_name = 'mj_dd_gangwei';
		$this->db->insert($_POST['info']);
			
			
			showmessage('操作完毕','index.php?m=diaodong&c=diaodong&a=gangwei');
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
		//邦单位
		$this->db->table_name = 'mj_gangwei';
		$rss = $this->db->select("",'id,gwname','','id asc');
		$gangwei=array();
		
		foreach($rss as $aaa){
			$gangwei[$aaa['id']]=$aaa['gwname'];
			
			}
		include $this->admin_tpl('add_gangwei');
	}
	
	function shgw()
	{
		
		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['shtime']=time();
			$this->db->table_name = 'mj_dd_gangwei';
			$this->db->update($_POST['info'],array('id'=>$id));
			//审核成功后，变更辅警的层级
			if($_POST['info']['status']==9){
			$this->db->table_name = 'mj_fujing';
			$this->db->update(array('gangwei'=>$_POST['gangwei']),array('id'=>$_POST['fjid']));
			}
			echo "<script>alert('操作成功');</script>";
			showmessage('操作完毕','index.php?m=bzcj&c=biaozhang','','showme2');
		}
		$this->db->table_name = 'mj_dd_gangwei';
		$info = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('sh_gangwei');
	}
	function showgw()
	{
		$id=$_REQUEST['id'];
		$this->db->table_name = 'mj_dd_gangwei';
		$info = $this->db->get_one("id=$id",'*');
		//邦单位
		$this->db->table_name = 'mj_gangwei';
		$rss = $this->db->select("",'id,gwname','','id asc');
		$gangwei=array();
		
		foreach($rss as $aaa){
			$gangwei[$aaa['id']]=$aaa['gwname'];
			
			}
		include $this->admin_tpl('show_gangwei');
	}
	
	
	function deletegw()
	{
		$id = $_GET['id'];
		$this->db->table_name = 'mj_dd_gangwei';
		if($this->db->delete(array('id'=>$_GET['id']))) {
			
			exit('1');
		} else {
			exit('0');
		}
	}
	
	//岗位
	
	public function zhiwu() {
		$this->db->table_name = 'mj_dd_zhiwu';
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo('',$order = 'id asc',$page, $pages = '12');
		$pages = $this->db->pages;
	
		//邦单位
		$this->db->table_name = 'mj_zhiwu';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu=array();
		
		foreach($rss as $aaa){
			$zhiwu[$aaa['id']]=$aaa['zwname'];
			
			}
			
		include $this->admin_tpl('zhiwu_list');
	}
	
	function addzhiwu()
	{
		if(isset($_POST['dosubmit'])) {
			
			$this->db->table_name = 'mj_fujing';
			$fj = $this->db->get_one("id=".$_POST['info']['fjid'],'*');
			$_POST['info']['fjname']=$fj['xingming'];
			$_POST['info']['oldzw']=$fj['zhiwu'];
			
			$_POST['info']['userid']=$_SESSION['userid'];
			$_POST['info']['inputtime']=time();
			
			
		$this->db->table_name = 'mj_dd_zhiwu';
		$this->db->insert($_POST['info']);
			
			
			showmessage('操作完毕','index.php?m=diaodong&c=diaodong&a=zhiwu');
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
		//邦单位
		$this->db->table_name = 'mj_zhiwu';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu=array();
		
		foreach($rss as $aaa){
			$zhiwu[$aaa['id']]=$aaa['zwname'];
			
			}
		include $this->admin_tpl('add_zhiwu');
	}
	
	function shzw()
	{
		
		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['shtime']=time();
			$this->db->table_name = 'mj_dd_zhiwu';
			$this->db->update($_POST['info'],array('id'=>$id));
			//审核成功后，变更辅警的层级
			if($_POST['info']['status']==9){
			$this->db->table_name = 'mj_fujing';
			$this->db->update(array('zhiwu'=>$_POST['zhiwu']),array('id'=>$_POST['fjid']));
			}
			echo "<script>alert('操作成功');</script>";
			showmessage('操作完毕','index.php?m=bzcj&c=biaozhang','','showme2');
		}
		$this->db->table_name = 'mj_dd_zhiwu';
		$info = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('sh_zhiwu');
	}
	function showzw()
	{
		$id=$_REQUEST['id'];
		$this->db->table_name = 'mj_dd_zhiwu';
		$info = $this->db->get_one("id=$id",'*');
		//邦单位
		$this->db->table_name = 'mj_zhiwu';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu=array();
		
		foreach($rss as $aaa){
			$zhiwu[$aaa['id']]=$aaa['zwname'];
			
			}
		include $this->admin_tpl('show_zhiwu');
	}
	
	
	function deletezw()
	{
		$id = $_GET['id'];
		$this->db->table_name = 'mj_dd_zhiwu';
		if($this->db->delete(array('id'=>$_GET['id']))) {
			
			exit('1');
		} else {
			exit('0');
		}
	}
	
	
	//在职状态变更
	
	public function zaizhi() {
		$this->db->table_name = 'mj_dd_zaizhi';
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo('',$order = 'id asc',$page, $pages = '12');
		$pages = $this->db->pages;
	
		$sss=array(1=>'在职',2=>'离职',3=>'死亡',4=>'退休',5=>'其他');
			
		include $this->admin_tpl('zaizhi_list');
	}
	
	function addzaizhi()
	{
		if(isset($_POST['dosubmit'])) {
			
			$this->db->table_name = 'mj_fujing';
			$fj = $this->db->get_one("id=".$_POST['info']['fjid'],'*');
			$_POST['info']['fjname']=$fj['xingming'];
			$_POST['info']['oldstatus']=$fj['status'];
			
			$_POST['info']['userid']=$_SESSION['userid'];
			$_POST['info']['inputtime']=time();
			
			
		$this->db->table_name = 'mj_dd_zaizhi';
		$this->db->insert($_POST['info']);
			
			
			showmessage('操作完毕','index.php?m=diaodong&c=diaodong&a=zaizhi');
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
	$sss=array(1=>'在职',2=>'离职',3=>'死亡',4=>'退休',5=>'其他');
		include $this->admin_tpl('add_zaizhi');
	}
	
	function shzaizhi()
	{
		
		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['shtime']=time();
			$this->db->table_name = 'mj_dd_zaizhi';
			$this->db->update($_POST['info'],array('id'=>$id));
			//审核成功后，变更辅警的层级
			if($_POST['info']['status']==9){
			$this->db->table_name = 'mj_fujing';
			$this->db->update(array('status'=>$_POST['zhiwu']),array('id'=>$_POST['fjid']));
			}
			echo "<script>alert('操作成功');</script>";
			showmessage('操作完毕','index.php?m=bzcj&c=biaozhang','','showme2');
		}
		$this->db->table_name = 'mj_dd_zaizhi';
		$info = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('sh_zaizhi');
	}
	function showzaizhi()
	{
		$id=$_REQUEST['id'];
		$this->db->table_name = 'mj_dd_zaizhi';
		$info = $this->db->get_one("id=$id",'*');
		$sss=array(1=>'在职',2=>'离职',3=>'死亡',4=>'退休',5=>'其他');
		include $this->admin_tpl('show_zaizhi');
	}
	
	
	function deletezaizhi()
	{
		$id = $_GET['id'];
		$this->db->table_name = 'mj_dd_zaizhi';
		if($this->db->delete(array('id'=>$_GET['id']))) {
			
			exit('1');
		} else {
			exit('0');
		}
	}
	
	
	

}


