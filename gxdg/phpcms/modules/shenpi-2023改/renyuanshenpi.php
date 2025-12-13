<?php
set_time_limit(0);
ini_set("display_errors", "On"); 
//error_reporting(7);

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class renyuanshenpi extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		
		$this->db->table_name = 'mj_dd_danwei';
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
	$this->db->table_name = 'mj_dd_danwei';
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
		//绑定领导
		$this->db->table_name = 'mj_admin';
		$lds = $this->db->select("roleid in (5,3,2)",'userid,username','','userid asc');
		
		foreach($lds as $aaa){
			$ld[$aaa['userid']]=$aaa['username'];
			}	
		//审核状态
		$zt=array(1=>'未审核',2=>'不同意',9=>'同意');	
			
		include $this->admin_tpl('renyuan_main');
	}


public function show() { //主列表	
	$id=$_GET['id'];
	$this->db->table_name = 'mj_dd_danwei';
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
		
		include $this->admin_tpl('renyuan_gangwei_show');
	}
public function img(){
$url=$_GET['url'];
include $this->admin_tpl('img');
}

	public function gangweilist() { //岗位变动		
		include $this->admin_tpl('renyuan_gangwei_list');
	}
	
	public function lizhilist() { //离职		
		include $this->admin_tpl('renyuan_lizhi_list');
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
			
		$this->db->table_name = 'mj_dd_danwei';
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
		   
		include $this->admin_tpl('renyuan_gangwei_shenqing');
	}	
//部门领导审核
function bmsh() {	
	
		$id=$_REQUEST['id'];
		
		
		
		if(isset($_POST['dosubmit'])) {
		
			
		$this->db->table_name = 'mj_dd_danwei';
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
 			
	
		   
		include $this->admin_tpl('renyuan_gangwei_bmsh');
	}
	
	//分管领导审核
function fgsh() {	
	
		$id=$_REQUEST['id'];
		
		
		
		if(isset($_POST['dosubmit'])) {
		
			
		$this->db->table_name = 'mj_dd_danwei';
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
 			
	
		   
		include $this->admin_tpl('renyuan_gangwei_fgsh');
	}

	//主任审核
function zrsh() {	
	
		$id=$_REQUEST['id'];
		
		
		
		if(isset($_POST['dosubmit'])) {
		
			
		$this->db->table_name = 'mj_dd_danwei';
		
		if($_POST['zrstatus']==9){
		
			if($_POST['dai']==1){
			$this->db->update(array('zrstatus'=>$_POST['zrstatus'],'zrshtime'=>time(),'ldshid'=>$_POST['ldshid'],'ldstatus'=>9,'ldshtime'=>time(),'dai'=>1),array('id'=>$id));
			//更改辅警部门 岗位信息
			$info = $this->db->get_one("id=$id",'*');
			$this->db->table_name = 'mj_fujing';
			$this->db->update(array('dwid'=>$info['newdw'],'gangwei'=>$info['newgangwei'],'gangweifz'=>$info['newgangweifz']),array('id'=>$info['fjid']));
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
 			
	
		   
		include $this->admin_tpl('renyuan_gangwei_zrsh');
	}
		//局领导审核
function ldsh() {	
	
		$id=$_REQUEST['id'];
		
		
		
		if(isset($_POST['dosubmit'])) {
		
			
		$this->db->table_name = 'mj_dd_danwei';
		$this->db->update(array('ldstatus'=>$_POST['ldstatus'],'ldshtime'=>time()),array('id'=>$id));
		if($_POST['ldstatus']==9){
		//更改辅警部门 岗位信息
		$info = $this->db->get_one("id=$id",'*');
		$this->db->table_name = 'mj_fujing';
		$this->db->update(array('dwid'=>$info['newdw'],'gangwei'=>$info['newgangwei'],'gangweifz'=>$info['newgangweifz']),array('id'=>$info['fjid']));
		}
		echo "<script>alert('操作成功');</script>";
		showmessage(L('operation_success'),'','','showmeld');
		}
		
		
 		
 			
	
		   
		include $this->admin_tpl('renyuan_gangwei_ldsh');
	}
	public function chafj(){
	$fjid=$_GET['fjid'];
	$this->db->table_name = 'mj_fujing';
	$fj = $this->db->get_one("id=$fjid","gangwei,gangweifz");
	//岗位
	$this->db->table_name = 'mj_gangwei';
	$gw = $this->db->get_one("id=".$fj['gangwei'],"gwname");
	//岗位辅助
	$this->db->table_name = 'mj_gangweifz';
	$gwfz = $this->db->get_one("id=".$fj['gangweifz'],"gwname");
	$fjarr=array('gwid'=>$fj['gangwei'],'gwname'=>$gw['gwname'],'fzid'=>$fj['gangweifz'],'fzname'=>$gwfz['gwname']);
	echo json_encode($fjarr);
	
	}
	
	function word(){
		
		$id=$_GET['id'];
	$this->db->table_name = 'mj_dd_danwei';
	$info = $this->db->get_one("id=$id",'*');
		
		$this->db->table_name = 'mj_fujing';
	$fj = $this->db->get_one("id=".$info['fjid'],'*');
		
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
		//绑定领导签名
		$this->db->table_name = 'mj_admin';
		$lds = $this->db->select("roleid in (5,3,2,9)",'userid,qianzipic','','userid asc');
		
		foreach($lds as $aaa){
			$ld[$aaa['userid']]=$aaa['qianzipic'];
			}	
		//审核状态
		$zt=array(1=>'未审核',2=>'不同意',9=>'同意');	
		//政治面貌
		$mm=array(1=>'中共党员',2=>'共青团员',3=>'民主党派',4=>'学生',5=>'群众');
		
		//邦定层级
		$this->db->table_name = 'mj_cengji';
		$rss = $this->db->select("",'id,cjname','','id asc');
		$cengji=array();
		
		foreach($rss as $aaa){
			$cengji[$aaa['id']]=$aaa['cjname'];
			
			}
		
		//邦定职务
		$this->db->table_name = 'mj_zhiwu';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu=array();
		
		foreach($rss as $aaa){
			$zhiwu[$aaa['id']]=$aaa['zwname'];
			
			}
			
		//邦定学历
		$this->db->table_name = 'mj_xueli';
		$rss = $this->db->select("",'id,gwname','','id asc');
		
		foreach($rss as $aaa){
			$xueli[$aaa['id']]=$aaa['gwname'];
			}
		
		 //echo $bumens[$info['olddw']];exit;
		require PC_PATH.'libs/classes/PHPWord/PHPWord.php';
        require PC_PATH.'libs/classes/PHPWord/PHPWord/IOFactory.php';
    $PHPWord =  new PHPWord();
	
	
	
    $templateProcessor = $PHPWord->loadTemplate('./ddgangwei.docx');//找到文件
	
	$templateProcessor->setValue('xingming',iconv('utf-8', 'GB2312//IGNORE', $info['fjname']));
	$templateProcessor->setValue('sex',iconv('utf-8', 'GB2312//IGNORE', $fj['sex']));
	$templateProcessor->setValue('birth',iconv('utf-8', 'GB2312//IGNORE', date("Y-m-d",$fj['shengri'])));
	$templateProcessor->setValue('gzsj',iconv('utf-8', 'GB2312//IGNORE', date("Y-m-d",$fj['rjtime'])));
	$templateProcessor->setValue('sfz',iconv('utf-8', 'GB2312//IGNORE', $fj['sfz']));
	$templateProcessor->setValue('tel',iconv('utf-8', 'GB2312//IGNORE', $fj['tel']));
	$templateProcessor->setValue('zzmm',iconv('utf-8', 'GB2312//IGNORE', $mm[$fj['zzmm']]));
	
	$templateProcessor->setValue('zhiwu',iconv('utf-8', 'GB2312//IGNORE', $zhiwu[$fj['zhiwu']]));
	$templateProcessor->setValue('cengji',iconv('utf-8', 'GB2312//IGNORE', $cengji[$fj['cengji']]));
	$templateProcessor->setValue('xueli',iconv('utf-8', 'GB2312//IGNORE', $xueli[$fj['xueli']]));
	
	$templateProcessor->setValue('olddw',iconv('utf-8', 'GB2312//IGNORE', $bumens[$info['olddw']]));
	$templateProcessor->setValue('oldgw',iconv('utf-8', 'GB2312//IGNORE', $gangweis[$info['oldgangwei']]));
	$templateProcessor->setValue('oldgwfz',iconv('utf-8', 'GB2312//IGNORE', $fzgangweis[$info['oldgangweifz']]));
	$templateProcessor->setValue('newdw',iconv('utf-8', 'GB2312//IGNORE', $bumens[$info['newdw']]));
	$templateProcessor->setValue('newgw',iconv('utf-8', 'GB2312//IGNORE', $gangweis[$info['newgangwei']]));
	$templateProcessor->setValue('newgwfz',iconv('utf-8', 'GB2312//IGNORE', $fzgangweis[$info['newgangweifz']]));
	$templateProcessor->setValue('content',iconv('utf-8', 'GB2312//IGNORE', $info['content']));
	
	$templateProcessor->setValue('bmstatus',iconv('utf-8', 'GB2312//IGNORE', $zt[$info['bmstatus']]));
	$arrImagenes4=array('src' => $ld[$info['bmshid']],'swh'=>'100', 'position' => 'absolute', 'top' => 100, 'left' => 1);
	$templateProcessor->setImg('bmshid', $arrImagenes4);
	
	$templateProcessor->setValue('bmshtime',iconv('utf-8', 'GB2312//IGNORE', date("Y-m-d",$info['bmshtime'])));
	
	$templateProcessor->setValue('fgstatus',iconv('utf-8', 'GB2312//IGNORE', $zt[$info['fgstatus']]));
	$arrImagenes3=array('src' => $ld[$info['fgshid']],'swh'=>'100', 'position' => 'absolute', 'top' => 1, 'left' => 1);
	$templateProcessor->setImg('fgshid', $arrImagenes3);
	
	$templateProcessor->setValue('fgshtime',iconv('utf-8', 'GB2312//IGNORE', date("Y-m-d",$info['fgshtime'])));
	
	$templateProcessor->setValue('zrstatus',iconv('utf-8', 'GB2312//IGNORE', $zt[$info['zrstatus']]));
	$arrImagenes2=array('src' => $ld[$info['zrshid']],'swh'=>'100', 'position' => 'absolute', 'top' => 1, 'left' => 1);
	$templateProcessor->setImg('zrshid', $arrImagenes2);
	
	$templateProcessor->setValue('zrshtime',iconv('utf-8', 'GB2312//IGNORE', date("Y-m-d",$info['zrshtime'])));
	
	$templateProcessor->setValue('ldstatus',iconv('utf-8', 'GB2312//IGNORE', $zt[$info['ldstatus']]));
	$arrImagenes=array('src' => $ld[$info['ldshid']],'swh'=>'100', 'position' => 'absolute', 'top' => 1, 'left' => 1);
	$templateProcessor->setImg('ldshid', $arrImagenes);

	$templateProcessor->setValue('ldshtime',iconv('utf-8', 'GB2312//IGNORE', date("Y-m-d",$info['ldshtime'])));
	
	
	$ttt='ddgangwei'.time();
    $templateProcessor->save('./word/'.$ttt.'.docx');
	header('location:./word/'.$ttt.'.docx');
	
		
		}
		
		
	function delete()
	{
		$id = $_GET['id'];
		$this->db->table_name = 'mj_dd_danwei';
		if($this->db->update(array('isdel'=>2),array('id'=>$_GET['id']))) {
			
			exit('1');
		} else {
			exit('0');
		}
	}
	/////////////////////////////////////////////////////
}


