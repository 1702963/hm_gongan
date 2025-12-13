<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class zhuangbei extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		$this->db->table_name = 'mj_fujing';
		pc_base::load_app_func('global');
	}
	
	public function init() {
		
		$this->db->table_name = 'mj_beizhuang_pici';
		
		if(intval($_GET['id'])>0 && $_GET['islock']!=''){ //锁定开关
		 $this->db->update("islocked=".intval($_GET['islock']),array('id'=>intval($_GET['id'])));	
			}
		
		$where=" isdel=0 ";
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$zhuangbei = $this->db->listinfo($where,$order = "id desc",$page, $pages = '12');
		$pages = $this->db->pages;
		
		include $this->admin_tpl('zhuangbei_list');
	}
	
	///创建、编辑批次基本信息
	public function dopici() {
		
		$g_id=intval($_GET['id']);
		$this->db->table_name = 'mj_beizhuang_pici';
		
		if($_POST['nodosave']!=""){
			showmessage("关闭窗口","?m=zhuangbei&c=zhuangbei&a=init",3000,'showme');
			}
		
		if($_POST['dosave']!=""){

		  
		  $_POST['do']['douser']=param::get_cookie('admin_username');
          $_POST['do']['dodt']=time();
		  $_POST['do']['ktime']=strtotime($_POST['do']['ktime']);	
		  $_POST['do']['etime']=strtotime($_POST['do']['etime']);
          $_POST['do']['dotime']=intval($_POST['nians'])*100+intval($_POST['yues']);
		  
		  if(intval($_POST['id'])<1){ //新建
			$this->db->insert($_POST['do']);  
			  }else{ //编辑
			$this->db->update($_POST['do'],array('id'=>intval($_POST['id'])));	  
				  }	
				  
		  showmessage("保存成功","?m=zhuangbei&c=zhuangbei&a=init",3000,'showme');	
			}
		
		$piciinfo=$this->db->get_one("id=$g_id",'*');
			
		include $this->admin_tpl('do_pici');
		}	
	
	///软删除批次  AJAX
	function picidel()
	{
		$id = intval($_GET['id']);
		$this->db->table_name = 'mj_beizhuang_pici';
		
		if($this->db->update(array('isdel'=>1),array('id'=>$id))) {	
			exit('1');
		} else {
			exit('0');
		}
	}	

	///删除人员  AJAX
	function renyuandel()
	{
		$id = intval($_GET['id']);
		$this->db->table_name = 'mj_beizhuang_ulog';
		
		if($this->db->delete(array('id'=>$_GET['id']))) {	
			exit('1');
		} else {
			exit('0');
		}
	}	

	function setobj()
	{
		$id = intval($_GET['id']);

		include $this->admin_tpl('set_pici');
	}	

	function renyuan()
	{

		include $this->admin_tpl('renyuan_pici');
	}	
		
	function piciuser()
	{

		include $this->admin_tpl('adduser_pici');
	}
	
	function shenling()
	{

		include $this->admin_tpl('shenling_list');
	}
	
	function doxuan()
	{

		include $this->admin_tpl('doxuan_list');
	}	
	
	function showxuan()
	{
        if($_POST['dosubmit']!=""){
			showmessage("关闭窗口","index.php?m=zhuangbei&c=zhuangbei&a=doxuan&ref=".$_POST['ref']."&objid=".$_POST['objid'],3000,'showme');
			}
		include $this->admin_tpl('showxuan_list');
	}			
	
	function logxiang()
	{
		include $this->admin_tpl('xiang_list');
	}					
	//////////////////////////////////////////////////////////////////////////////
	////以下屏蔽/////
	public function sou() {
		
		$where="status=1 and isok=1";
		$hhtimes=time();
		$orders=" id desc";
		
		if($_GET['dotongji']!=""){
		
		if(isset($_GET['xingming']) && !empty($_GET['xingming'])) {                               
			$xingmings=$_GET['xingming'];
			$where .= " AND `xingming`  like '%$xingmings%' ";
			}
						
		if(isset($_GET['dwid']) && !empty($_GET['dwid'])) {
			$dwids=$_GET['dwid'];
			if($dwids>1){
			$where .= " AND `dwid`  = $dwids ";
			}
			}		
			
		if(isset($_GET['zbid']) && !empty($_GET['zbid'])) {                               
			$zbids=$_GET['zbid'];
			$where .= " AND `zzsj`='$zbids'" ;
			}					
			
		if(isset($_GET['status']) && !empty($_GET['status'])) {                               
			$statuss=$_GET['status'];
			$where .= " AND `status`='$statuss'" ;
			}	
			
		if(isset($_GET['fftj']) && !empty($_GET['fftj'])) {                               
			$fftimes=strtotime($_GET['fftime']);
			$fftiaojian="=";
			$orders=" fftime desc";
			if($_GET['fftj']==">"){$fftiaojian=">=";$orders=" fftime asc";}
			if($_GET['fftj']=="<"){$fftiaojian="<=";$orders=" fftime asc";}
			$where .= " AND `fftime`".$fftiaojian."'$fftimes' ";
			}	
			
		if(isset($_GET['hhtj']) && !empty($_GET['hhtj'])) {                               
			$hhtimes=strtotime($_GET['hhtime']);
			$hhtiaojian="=";
			$orders=" hhtime desc";
			if($_GET['hhtj']==">"){$hhtiaojian=">=";$orders=" hhtime asc";}
			if($_GET['hhtj']=="<"){$hhtiaojian="<=";$orders=" hhtime asc";}
			$where .= " AND `hhtime`".$hhtiaojian."'$hhtimes' ";
			}								
		//echo $where;
		}
		//echo $where;
		
		$zhuangbei = $this->db->select($where,'*','',$orders);
		
		//绑定装备名称
		$this->db->table_name = 'mj_zhuangbei_field';
		$fields = $this->db->select("",'id,name,field','','id asc');
		
		
		//部门
		$this->db->table_name = 'mj_bumen';
		$rss = $this->db->select("",'id,name,parentid','','id asc');
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			}		
			
		//层级
		$this->db->table_name = 'mj_bumen';
		$rss = $this->db->select("",'id,name,parentid','','id asc');
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			}			
			
		include $this->admin_tpl('sou_list');
	}
	
	
	
	public function jilu() {
		
		include $this->admin_tpl('jilu_list');
	}
	function add()
	{
		if(isset($_POST['dosubmit'])) {

			$this->db->table_name = 'mj_fujing';
			$rss = $this->db->select("",'id,xingming','','id asc');
			foreach($rss as $v){
			  $fujings[$v['id']]=$v['xingming'];	
				}
			
			$this->db->table_name = 'mj_zhuangbei';	
					
         foreach($_POST['fjids'] as $v){
			 $_POST['info']['bmid']=$_POST['bms']; 
			$_POST['info']['fjid']=$v; 			
			$_POST['info']['fjname']=$fujings[$v];
			$_POST['info']['status']=1;
			$_POST['info']['userid']=$_SESSION['userid'];
			$_POST['info']['inputtime']=time();
			$_POST['info']['fftime']=strtotime($_POST['fftime']);
    		$this->db->insert($_POST['info']); //原则上批量入库效率会更高，但是批量不确定，没有必要设计算法进行入库拼接
		 }
			
			showmessage('操作完毕','index.php?m=zhuangbei&c=zhuangbei&a=init');
		}
		//绑定装备名称
		$this->db->table_name = 'mj_zbmx';
		$rss = $this->db->select("",'id,zbname','','id asc');
		$zb=array();
		$zb[0]="请选择";
		foreach($rss as $aaa){
			$zb[$aaa['id']]=$aaa['zbname'];
			}
				
		//绑定在职人员
		$this->db->table_name = 'mj_fujing';
		$rss = $this->db->select(" status=1 and isok=1 ",'id,xingming,sfz','','id asc');
		$fujing=array();
		
		foreach($rss as $aaa){
			$fujing[$aaa['id']]=$aaa['xingming']."-".$aaa['sfz'];
			
			}
			
		//部门
		$this->db->table_name = 'mj_bumen';
		$rss = $this->db->select("",'id,name,parentid','','id asc');
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			}
						
			
		include $this->admin_tpl('add_zhuangbei');
	}
	
	
	
	function fa()
	{
		if(isset($_POST['dosubmit'])) {

			
			if($_POST['zb']==''){
			showmessage('请选择发放被装',HTTP_REFERER);
			}
			$zb=implode(',',$_POST['zb']);
			
			$this->db->table_name = 'mj_zhuangbei_log';
			
			if(is_array($_POST['fjid'])){
				foreach($_POST['fjid'] as $linkid_arr) {
 					//批量插入发放记录
					$this->db->insert(array('fjid'=>$linkid_arr,'zb'=>$zb,'inputtime'=>time()));
					
					
				}
				showmessage('发放成功','index.php?m=zhuangbei&c=zhuangbei&a=jilu');
		}
			
			
			
		}
		
	}
	function huanhui()
	{
		
		$id=$_REQUEST['id'];

		$zhuangbei = $this->db->get_one("id=$id",'*');
				
		if(isset($_POST['dosubmit'])) {
			
			$upin["status"]=2;
			$upin['beizhu']=$_POST['beizhu'];
			$upin['hhtime']=strtotime($_POST['hhtime']);
			
			$this->db->update($upin,array('id'=>$id));
			
			showmessage('操作完毕');
		}
		$zhuangbei = $this->db->get_one("id=$id",'*');
		
		//部门
		$this->db->table_name = 'mj_bumen';
		$rss = $this->db->select("",'id,name,parentid','','id asc');
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			}
			
		//绑定装备名称
		$this->db->table_name = 'mj_zbmx';
		$rss = $this->db->select("",'id,zbname','','id asc');
		foreach($rss as $aaa){
			$zb[$aaa['id']]=$aaa['zbname'];
			}
						
		include $this->admin_tpl('edit_zhuangbei');
	}
	
	function editchima()
	{
		
	
		

		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
		//更新着装时间和服装分类
		$zhu=array();
		$zhu['zzsj']=$_POST['zzsj'];
		$zhu['fzlx']=$_POST['fzlx'];
		$this->db->table_name = 'mj_fujing';
		$this->db->update($zhu,array('id'=>$id));
		//更新尺码
		$this->db->table_name = 'mj_fujing_fz';
		$this->db->update($_POST['info'],array('id'=>$id));
		
		echo "<script>alert('更新成功')</script>";
		showmessage('分发成功',HTTP_REFERER,'1000','showme');
		
		
		}
		$this->db->table_name = 'mj_fujing';	
		$fj = $this->db->get_one("id=$id",'*');
		$this->db->table_name = 'mj_fujing_fz';	
		$fjfz = $this->db->get_one("id=$id",'*');
		//绑定装备名称
		$this->db->table_name = 'mj_zhuangbei_field';
		$fields = $this->db->select("",'id,name,field,seting','','id asc');
		include $this->admin_tpl('edit_chima');
	}
	function show()
	{
		//部门
		$this->db->table_name = 'mj_bumen';
		$rss = $this->db->select("",'id,name,parentid','','id asc');
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			}
			
		//绑定装备名称
		$this->db->table_name = 'mj_zbmx';
		$rss = $this->db->select("",'id,zbname','','id asc');
		foreach($rss as $aaa){
			$zb[$aaa['id']]=$aaa['zbname'];
			}

		$id=$_REQUEST['id'];
		$this->db->table_name = 'mj_zhuangbei';	
		$zhuangbei = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('show_zhuangbei');
	}
	
	public function dao(){
	$where="f.status=1 and f.isok=1";
	
	
	
	
	if(isset($_GET['dwid']) && !empty($_GET['dwid'])) {
	
			$dwids=$_GET['dwid'];
			if($dwids>1){
			$where .= " AND f.dwid  = $dwids ";
			}
			}		
			
		if(isset($_GET['zzsj']) && !empty($_GET['zzsj'])) {                               
			$zzsj=$_GET['zzsj'];
			$where .= " AND f.zzsj='$zzsj'" ;
			}
	 $rs1=$this->db->query("SELECT f.xingming,f.zzsj,f.fzlx,f.gzz,b.* FROM `mj_fujing` f left join `mj_fujing_fz` b on f.id=b.id where $where  order by f.id desc ");
     $shuju = $this->db->fetch_array($rs1);
	
			foreach($shuju as $key=>$val){//去掉id操作
          		unset($shuju[$key]['id']);
        }
			
			$this->db->table_name = 'mj_zhuangbei_field';
		$rss = $this->db->select("",'name,field','','id asc');
		foreach($rss as $aaa){
			$fff[$aaa['field']]=$aaa['name'];
			}
			$fff['xingming']="姓名";
			$fff['zzsj']="着装时间";	
			$fff['fzlx']="服装分类";	
			$fff['gzz']="辅警号";	
				
			//灌入字段和中文表头
			foreach($shuju[0] as $key=>$val){
          		$sjtou[]=$key;//数据表字段
				$extou[]=$fff[$key];//表格 头
       		 }
			
			
				header("Content-Type:text/html;charset=utf-8");  
			require PC_PATH.'libs/classes/PHPExcel/Classes/PHPExcel.php';
			$obpe = new PHPExcel();  


$obpe->setactivesheetindex(0);
$obpe->getActiveSheet()->setTitle("服装尺码");
//Excel表格式,这里简略写了8列
for($i=1;$i<=count($sjtou);$i++){
$letter[]=chr($i+64);
}  

	
//表头数组  
$tableheader = $extou;  
//填充表头信息  

for($i = 0;$i < count($tableheader);$i++) {  
    $obpe->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");  
} 
	
//写入多行数据

foreach($shuju as $k=>$v){
    $k = $k+2;
    
	for($i = 0;$i < count($tableheader);$i++) {  
    $obpe->getActiveSheet()->setCellValue("$letter[$i]".$k,$v[$sjtou[$i]]);  
} 
   
	
}	
	
	
	//写入类容
$obwrite = PHPExcel_IOFactory::createWriter($obpe, 'Excel5');
//ob_end_clean();
//保存文件
$obwrite->save('mulit_sheet.xls');
           
//or 以下方式
/*******************************************
            直接在浏览器输出
*******************************************/

header('Pragma: public');
header('Expires: 0');
header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
header('Content-Type:application/force-download');
header('Content-Type:application/vnd.ms-execl');
header('Content-Type:application/octet-stream');
header('Content-Type:application/download');
header("Content-Disposition:attachment;filename=服装尺码.xls");
header('Content-Transfer-Encoding:binary');
$obwrite->save('php://output');
	
	
	
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


