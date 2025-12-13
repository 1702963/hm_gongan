<?php 
ini_set("display_errors", "On"); 
$db_c=require 'caches/configs/database.php'; 
$con = mysql_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);

if (!$con) { die("err009"); }

mysql_select_db($db_c['default']['database'], $con); 
mysql_query("SET NAMES UTF8"); 

if($_GET['userid']==""){
   $r_arr=array("err"=>1,"errstr"=>"错误的请求结构");
   echo json_encode($r_arr);exit;	
	} 
		
		//获取岗位
	   $sql="select id,gwname from v9_gangwei ";
	   $rss=mysql_query($sql,$con);		
	   while($aaa = mysql_fetch_array($rss)){
			$gangweifz[$aaa['id']]=$aaa['gwname'];
			}
			
		//获取单位
	   $sql="select id,name,parentid from v9_bumen ";
	   $rss=mysql_query($sql,$con);		
	   while($aaa = mysql_fetch_array($rss)){
			$bumen[$aaa['id']]=$aaa['name'];
			}		
							
		//获取姓名
	   $sql="select id,xingming from v9_fujing ";
	   $rss=mysql_query($sql,$con);		
	   while($aaa = mysql_fetch_array($rss)){
			$xingmings[$aaa['id']]=$aaa['xingming'];
			}						
		
		
		   
	   $sql="select * from v9_tcgongxian where id in (".$_GET['userid'].") order by bmid asc";
	  
	   $rs=mysql_query($sql,$con);

	   while($row = mysql_fetch_array($rs)){
		   $row['fzgw']=$gangweifz[$row['gangwei']];
		   $row['xingming']=$xingmings[$row['userid']];
		   $row['bumen']=$bumen[$row['bmid']];
		   $tcgx[]=$row;
		   }
	   		  
		  
   $r_arr=array("err"=>0,"errstr"=>"响应完成","datas"=>$tcgx);
   echo json_encode($r_arr);exit;	
?>