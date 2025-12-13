<?php 
ini_set("display_errors", "On"); 
$db_c=require 'caches/configs/database.php'; 
$con = mysql_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);

if (!$con) { echo json_encode(array("err"=>10000,"error" => "远端响应异常"));exit; }

mysql_select_db($db_c['default']['database'], $con); 
mysql_query("SET NAMES UTF8"); 

//echo json_encode(array("error" => "上传失败！"));

if($_GET['sfz']=='' || strlen($_GET['sfz'])>18){
   $r_arr=array("err"=>1,"errstr"=>"错误的请求结构");
   echo json_encode($r_arr);exit;	
	} 
	
//检查身份证
		   
	   $sql="select count(id) as js from v9_fujing where isok=1 and sfz='".$_GET['sfz']."'" ;
	  
	   $rs=mysql_query($sql,$con);
       $row = mysql_fetch_array($rs);
	   $r_arr=array("err"=>$row['js'],"errstr"=>"");   
	   
   echo json_encode($r_arr);exit;	
?>