<?php 
ini_set("display_errors", "On"); 

if(intval($_GET['dw'])<1){
        echo json_encode(array("errnum"=>1,"error" => "丢失参数1"));
        exit;	
	}else{
	  $dwid=intval($_GET['dw']);	
	}

if($_GET['fujing']==''){
        echo json_encode(array("errnum"=>1,"error" => "丢失参数2"));
        exit;	
	}else{
	 $tmp_sel=$_GET['fujing'];	
	}
	
	
$db_c=require '../caches/configs/database.php'; 
$con = mysql_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);
if (!$con) { 
        echo json_encode(array("errnum"=>1,"error" => "远端未响应"));
        exit;	
 }

mysql_select_db($db_c['default']['database'], $con); 
mysql_query("SET NAMES UTF8"); 

	   $sql="select * from ".$db_c['default']['tablepre']."fujing where dwid='$dwid' and xingming='$tmp_sel' ";
	   $rs=mysql_query($sql,$con);
       while($row = mysql_fetch_array($rs)){
		 $returns=$row;   
	   }
	   
	   if(isset($returns)){
         
		 echo json_encode(array("errnum"=>0,"date" =>$returns,"num"=>count($returns)));
         exit;			   
	   }else{
		 echo json_encode(array("errnum"=>0,"num"=>0));
         exit;			   
		   }
	   
?>