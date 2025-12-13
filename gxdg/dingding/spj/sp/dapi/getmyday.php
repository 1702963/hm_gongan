<?php
ini_set("display_errors","On");
date_default_timezone_set("PRC");
require '../../ini/baseconfig.php';
$con = mysql_connect($db_add,$db_user,$db_pass);
if (!$con){
	echo json_encode(array("error"=>1));
	exit;	
	} 
	
mysql_select_db("spjzhiban", $con); 
mysql_query("SET NAMES UTF8"); 

//var_dump($db_name);

//拉出数据
if(@$_POST['userid']=="" || !isset($_POST['userid'])){
	echo json_encode(array("error"=>1));
	exit;
	}

	   $sql="select * from zb_table where uid='".$_POST['userid']."' and days>=".strtotime(date("Y-m-d"));
	   $rs=mysql_query($sql,$con);
	   
	   if($rs){
	   while($row = mysql_fetch_array($rs)){
		  $row['dayname']=date("Y-m-d",$row['days']); 
          $arr[]=$row;  	  
	   }}
	   
	   if(isset($arr)){
        $returnstr=array("error"=>0,"dats"=>$arr);
	   }else{
		 $returnstr=array("error"=>"本月没有您的值班排班记录");  
		   }

echo json_encode($returnstr,true);	

?>