<?php 
// DOUSER
require '../ini/baseconfig.php';


$uid=$_POST['uid'];
$name=$_POST['name'];
$event=$_POST['event'];
$intime=time();


switch($event){
case 'add':	

if($uid==""){
        echo json_encode(array("errorcode"=>"错误的请求结构"));
        exit;	
	}


//对比数据库
$con = mysql_connect($db_add,$db_user,$db_pass);
if ($con){ 
mysql_select_db($db_name, $con); 
mysql_query("SET NAMES UTF8"); 


//检查要加入的用户是否已存在

	   $sql="select count(id) from ".$db_tablepre."roles where uid='".$uid."' ";
	   $rs=mysql_query($sql,$con);
	   $row = mysql_fetch_array($rs);
	   if($row['0']==0){
       
	   $init="INSERT INTO ".$db_tablepre."roles (uid,uname,qx,dt)VALUES('$uid','$name','1','$intime')";
	   
	   $in=mysql_query($init,$con);
	   
	   if($in){
	   $sql="select * from ".$db_tablepre."roles order by id";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		 $lists['id']=$row['id'];
		 $lists['userid']=$row['uid'];
		 $lists['name']=$row['uname'];   
		 $uss[]=$lists;
		 unset($lists); 
	   }

         echo json_encode(array("errorcode"=>0,"userlist"=>$uss),true);
         exit;			   
	   }else{
         echo json_encode(array("errorcode"=>"添加用户失败"));
         exit;			   
		   }
	   	     
	   }
  }else{
        echo json_encode(array("errorcode"=>"接口暂时无法应答"));
        exit;		  
	  }

break;

case 'del':

if($uid==""){
        echo json_encode(array("errorcode"=>"错误的请求结构"));
        exit;	
	}


$con = mysql_connect($db_add,$db_user,$db_pass);
if ($con){ 
mysql_select_db($db_name, $con); 
mysql_query("SET NAMES UTF8"); 

	   $init="DELETE FROM ".$db_tablepre."roles WHERE uid= '".$uid."'";
	   $in=mysql_query($init,$con);
	   
	   if($in){
	   $sql="select * from ".$db_tablepre."roles order by id";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		 $lists['id']=$row['id'];
		 $lists['userid']=$row['uid'];
		 $lists['name']=$row['uname']; 
		 $uss[]=$lists;
		 unset($lists);   
	   }

         echo json_encode(array("errorcode"=>0,"userlist"=>$uss),true);
         exit;			   
	   }else{
         echo json_encode(array("errorcode"=>"删除用户失败"));
         exit;			   
		   }	   

}else{
        echo json_encode(array("errorcode"=>"接口暂时无法应答"));
        exit;	
	}
break;

case 'alllist': 

$con = mysql_connect($db_add,$db_user,$db_pass);
if ($con){ 
mysql_select_db($db_name, $con); 
mysql_query("SET NAMES UTF8"); 


	   $sql="select * from ".$db_tablepre."roles order by id";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		 $lists['id']=$row['id'];
		 $lists['userid']=$row['uid'];
		 $lists['name']=$row['uname'];
		 $uss[]=$lists;
		 unset($lists);   
	   }

         echo json_encode(array("errorcode"=>0,"userlist"=>$uss),true);
         exit;			   
   

}else{
        echo json_encode(array("errorcode"=>"接口暂时无法应答"));
        exit;	
	}
break;

default:
        echo json_encode(array("errorcode"=>"错误的请求方式"));
        break;
}
?>