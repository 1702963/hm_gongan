<?php 
ini_set("display_errors", "On"); 
$db_c=require 'caches/configs/database.php'; 
$con = mysql_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);

if (!$con) { echo json_encode(array("err"=>10000,"error" => "远端响应异常"));exit; }

mysql_select_db($db_c['default']['database'], $con); 
mysql_query("SET NAMES UTF8"); 

//echo json_encode(array("error" => "上传失败！"));

if($_GET['bmid']=='' || strlen($_GET['bmid'])>18){
   $r_arr=array("err"=>1,"errstr"=>"错误的请求结构");
   echo json_encode($r_arr);exit;	
	} 
	
//从部门获取人员
		
	   $fjdat= array();   
	   $sql="select id,xingming,sfz from v9_fujing where isok=1 and dwid=".intval($_GET['bmid'])." order by id asc" ;
	   $rs=mysql_query($sql,$con);
       while($row = mysql_fetch_array($rs)){
		 $fjdat[]=$row;  
		   }
	   
	   
	   $r_arr=array("err"=>0,"errstr"=>"","datas"=>$fjdat);   
	   
   echo json_encode($r_arr);exit;	
?>