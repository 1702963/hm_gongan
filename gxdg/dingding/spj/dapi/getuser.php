<?php 
ini_set("display_errors", "Off"); 
error_reporting(7);
// USERINFO
require '../ini/baseconfig.php';

$access_token=$_POST['access_token'];
$code=$_POST['code'];
$event=$_POST['event'];


switch($event){
case 'get_userinfo':	
//echo json_encode(file_get_contents("https://oapi.dingtalk.com/user/getuserinfo?access_token=$access_token&code=$code"),true);	
$loginusr_json=file_get_contents("https://oapi.dingtalk.com/user/getuserinfo?access_token=$access_token&code=$code");
$loginusr_arr=json_decode($loginusr_json,true);

//获取当前用户详细资料,需要通过UID获取详细资料，因此需要两步操作
$loginusr_xq_json=file_get_contents("https://oapi.dingtalk.com/user/get?access_token=$access_token&userid=".$loginusr_arr['userid']);

setcookie("loginid", $loginusr_arr['userid'], -1);	

//对比数据库
$con = mysql_connect($db_add,$db_user,$db_pass);
if ($con){ 
mysql_select_db($db_name, $con); 
mysql_query("SET NAMES UTF8"); 


$xq_arr=json_decode($loginusr_xq_json,true);

//取出当前用户记录数
	   $sql="select count(id) from ".$db_tablepre."roles ";
	   $rs=mysql_query($sql,$con);
	   $row = mysql_fetch_array($rs);
	   $xq_arr['usercount']=$row[0];

if(isset($xq_arr['userid'])){
	   $sql="select * from ".$db_tablepre."roles where uid='".$xq_arr['userid']."'";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		  $xq_arr['quanxian']=$row['qx']; //追加扩展权限 
		   }
	    setcookie("quanxian", $xq_arr['quanxian'], -1);	  //权限    
    } 
  }

if(!isset($xq_arr['quanxian'])){ 
	$xq_arr['quanxian']="0";
	}
if(!isset($xq_arr['usercount'])){  //没有用户
	$xq_arr['usercount']="0";
	}	

echo json_encode($xq_arr,true);
break;

case 'get_userlist':
$zz_userlist_json=file_get_contents("https://oapi.dingtalk.com/user/simplelist?access_token=$access_token&department_id=".$_POST['department_id']);

echo json_encode($zz_userlist_json,true);
break;

default:
        echo json_encode(array("errorcode"=>"4000"));
        break;
}
?>