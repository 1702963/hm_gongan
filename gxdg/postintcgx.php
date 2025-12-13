<?php 
ini_set("display_errors", "On"); 
$db_c=require 'caches/configs/database.php'; 
$con = mysql_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);

if (!$con) { echo json_encode(array("err"=>10000,"error" => "远端响应异常"));exit; }

mysql_select_db($db_c['default']['database'], $con); 
mysql_query("SET NAMES UTF8"); 

//echo json_encode(array("error" => "上传失败！"));

//if($_POST['je']==''){
//   $r_arr=array("err"=>1,"errstr"=>"错误的请求结构");
 //  echo json_encode($r_arr);exit;	
//	} 
//if($_POST['id']==''){
//   $r_arr=array("err"=>1,"errstr"=>"错误的请求结构");
 //  echo json_encode($r_arr);exit;	
//	} 	
	
//入库

if(intval($_POST['ty'])==1){	 	   
	   $sql="update v9_tcgongxian set je=".$_POST['je']." where id=".intval($_POST['id']) ;
	   $rs=mysql_query($sql,$con);
}	
if(intval($_POST['ty'])==2){	 	   
	   $sql="update v9_tcgongxian set zzcok=".$_POST['zzcok']." where id=".intval($_POST['id']) ;
	   $rs=mysql_query($sql,$con);
}   
if(intval($_POST['ty'])==3){	 	   
	   $sql="update v9_tcgongxian set beizhu='".$_POST['beizhu']."' where id=".intval($_POST['id']) ;
	   $rs=mysql_query($sql,$con);
} 
	   
   echo json_encode(array("err"=>0));exit;	
?>