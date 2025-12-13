<?php
ini_set('date.timezone','Asia/Shanghai');

//#########################
$con = mysql_connect("127.0.0.1","root","2ycf4jd");
if (!$con){die("dberror");}

mysql_select_db("spjzhiban", $con); 
mysql_query("SET NAMES UTF8"); 
//#########################

//////////////////////////////
//全部排班数据均需要写表，防止因映射结构变动造成历史排班数据无法阅读，减少AJAX传输数据量，人员姓名、班次名称均由映射取出
//班次映射


 	   $sql="select * from zb_banci order by px asc";
	   $rs=mysql_query($sql,$con);    
	   while($row = mysql_fetch_array($rs)){
		   $banciall[$row['id']]=$row['banci'];
		   }
		   
//人员映射
 	   $sql="select * from zb_user order by px asc";
	   $rs=mysql_query($sql,$con);    
	   while($row = mysql_fetch_array($rs)){
		   $userall[$row['uid']]=$row['username'];
		   }	


$uid=$_POST['uid'];
$nians=$_POST['nians'];
$yues=$_POST['yues'];
$dayss=$_POST['days'];
//$banci=$_POST['banci'];
$days=strtotime($nians."-".$yues."-".$dayss);
$weeks=date("w",$days);

//print_r($_POST);

     	   $sql="select * from zb_table where uid=$uid and days=$days";
	       $rs=mysql_query($sql,$con);    
	       $row = mysql_fetch_array($rs);
           if($row){
	         echo json_encode(array("bcid"=>$row['banciid'],"errorstr"=>$banciall[$row['banciid']]));
             exit;
		   }else{
	         echo json_encode(array("bcid"=>7,"errorstr"=>"完成"));
             exit;			   
			   }
	


?>