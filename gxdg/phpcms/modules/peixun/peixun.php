<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class peixun extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		$this->db->table_name = 'mj_peixun';
		pc_base::load_app_func('global');
	}
	
	public function init() {
		
		 $where=" bmid=".$_SESSION['bmid'];
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$peixun = $this->db->listinfo($where,$order = 'id asc',$page, $pages = '12');
		$pages = $this->db->pages;
	
		
		//绑定组织
		 $this->db = pc_base::load_model('bumen_model');
		
		$rss = $this->db->select("",'id,name,parentid','','listorder asc');	
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			
			}	
		include $this->admin_tpl('peixun_list');
	}
	
	function add()
	{
		if(isset($_POST['dosubmit'])) {
			
			$this->db->table_name = 'mj_fujing';
			$fj = $this->db->get_one("id=".$_POST['info']['fjid'],'*');
			$_POST['info']['fjname']=$fj['xingming'];
			$_POST['info']['bmid']=$fj['dwid'];
			$_POST['info']['sex']=$fj['sex'];
			$_POST['info']['userid']=$_SESSION['userid'];
			$_POST['info']['inputtime']=time();
			$_POST['info']['btime']=strtotime($_POST['btime']);
			$_POST['info']['etime']=strtotime($_POST['etime']);
		$this->db->table_name = 'mj_peixun';
		$this->db->insert($_POST['info']);
			
			
			showmessage('添加成功,等待审核','index.php?m=peixun&c=peixun&a=init');
		}
		
		//绑定在职人员
		$this->db->table_name = 'mj_fujing';
		$where= "status=1 and isok=1 AND `dwid`  = ".$_SESSION['bmid'];
		$rss = $this->db->select($where,'id,xingming,sfz','','id asc');
		$fujing=array();
		
		foreach($rss as $aaa){
			$fujing[$aaa['id']]=$aaa['xingming']."-".$aaa['sfz'];
			
			}
		include $this->admin_tpl('add_peixun');
	}
	public function gl() {
		
		$status = isset($_GET['status']) && intval($_GET['status']) ? intval($_GET['status']) : 1;
		$where=" status=".$status;
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$peixun = $this->db->listinfo($where,$order = 'id asc',$page, $pages = '12');
		$pages = $this->db->pages;
	
		
		//绑定组织
		 $this->db = pc_base::load_model('bumen_model');
		
		$rss = $this->db->select("",'id,name,parentid','','listorder asc');	
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			
			}	
		include $this->admin_tpl('gl_list');
	}
	function sh()
	{
		
		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['shtime']=time();
			$_POST['info']['shuserid']=$_SESSION['userid'];
			$this->db->update($_POST['info'],array('id'=>$id));
			
			echo "<script>alert('操作成功');</script>";
		showmessage(L('operation_success'),'','','showme');
		}
		$peixun = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('sh');
	}
	function edit()
	{
		
		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
			
			$this->db->update($_POST['info'],array('id'=>$id));
			
			showmessage('操作完毕','index.php?m=peixun&c=peixun');
		}
		$peixun = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('edit_peixun');
	}
	function show()
	{
		$id=$_REQUEST['id'];
		
		$peixun = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('show_peixun');
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
	
	//导出excel
	public function dao() {
		
		
		$tj = $this->db->select('','fjname,sex,bmid,title,btime,etime,chengji,guo,inputtime,status,shtime,shnr','','id desc');
	
		//绑定组织
		 $this->db = pc_base::load_model('bumen_model');
		
		$rss = $this->db->select("",'id,name,parentid','','listorder asc');	
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			
			}
		$guo=array(1=>'通过',2=>'未通过');		
		$status=array(1=>'待审核',2=>'未通过',9=>'已通过');	
		//导出Excel操作
			header("Content-Type:text/html;charset=utf-8");  
			require PC_PATH.'libs/classes/PHPExcel/Classes/PHPExcel.php';
			error_reporting(E_ALL);  
ini_set('display_errors', TRUE);  
ini_set('display_startup_errors', TRUE);  
  
//创建对象  
$excel = new PHPExcel();  
//Excel表格式,这里简略写了8列  
$letter = array('A','B','C','D','E','F','G','H','I','J','K','L');  
	
//表头数组  
$tableheader = array('辅警姓名','性别','所在部门','培训名称','开始时间','结束时间','成绩','是否通过培训','录入时间','审核状态','审核时间','审核说明');  
//填充表头信息  
$excel->getActiveSheet()->setCellValue("A1","培训记录"); 
for($i = 0;$i < count($tableheader);$i++) {  
    $excel->getActiveSheet()->setCellValue("$letter[$i]2","$tableheader[$i]");  
}  
  

//填充表格信息  
$k=1 ;
for ($i = 3;$i <= count($tj) + 3;$i++) {  
    $j = 0; 
	
    foreach ($tj[$i - 3] as $key=>$value) {  
			
			if($j==2){
				$value=$bms[$value];
				}
			if($j==4||$j==5){
				$value=date("Y-m-d",$value);
				}
			if($j==7){
				$value=$guo[$value];
				}
			if($j==8){
				$value=date("Y-m-d H:i:s",$value);
				}
			if($j==9){
				$value=$status[$value];
				}			
			if($j==10){
					if($value>0){
							$value=date("Y-m-d H:i:s",$value);
						}else{
						$value=" ";
						}
						
				}	
			  $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
			
			
        $j++;  
		
		if($j==13) break;
    } 
	$k++; 
}  

 
//创建Excel输入对象  
$write = new PHPExcel_Writer_Excel5($excel);  
header("Pragma: public");  
header("Expires: 0");  
header("Cache-Control:must-revalidate, post-check=0, pre-check=0");  
header("Content-Type:application/force-download");  
header("Content-Type:application/vnd.ms-execl");  
header("Content-Type:application/octet-stream");  
header("Content-Type:application/download");;  
header('Content-Disposition:attachment;filename="培训记录.xls"');  
header("Content-Transfer-Encoding:binary");  
$write->save('php://output'); 		
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


