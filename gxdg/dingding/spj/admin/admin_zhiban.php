<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>考勤组管理</title>
</head>
<?php
if($_COOKIE['isadmin']!=1){
  Header("Location:error.php");
}


$con = mysql_connect("127.0.0.1","root","2ycf4jd");
if (!$con){die("dberror");}

mysql_select_db("spjzhiban", $con); 
mysql_query("SET NAMES UTF8"); 

if(@$_POST["addme"]!=""){
	
$banci=$_POST['banci'];
$beizhu=$_POST['beizhu'];
$isok=intval($_POST['isok']);
$px=intval($_POST['px']);
	
	   $init2="INSERT INTO zb_banci (banci,beizhu,isok,px)VALUES('$banci','$beizhu','$isok','$px')";
	   $in2=mysql_query($init2,$con);	
	}
if(@$_POST["editme"]!=""){

$banci=$_POST['banci'];
$beizhu=$_POST['beizhu'];
$isok=intval($_POST['isok']);
$px=intval($_POST['px']);
$id=intval($_POST['id']);
	
	   $updat="update zb_banci set banci='$banci',beizhu='$beizhu',isok='$isok',px='$px' where id=$id";
	   $up=mysql_query($updat,$con);	
	}	

 	   $sql="select * from zb_banci order by px asc";
	   $rs=mysql_query($sql,$con);    
	   while($row = mysql_fetch_array($rs)){
		   $banciarr[]=$row;
		   }
?>
<body>
<table width="100%" border="0" align="center">
  <tr>
    <td width="7%" align="center" valign="top">
<table width="100%" border="0">
  <tr>
    <td height="30" valign="middle" style="padding-left:10px"> <a href="admin_banci.php" ><input type="button" value="值班班次管理" style="width:100px"/></a></td>
  </tr>
  <tr>
    <td height="32" valign="middle" style="padding-left:10px"> <a href="admin_renyuan.php" ><input type="button" value="值班人员管理" style="width:100px" /></a></td>
  </tr>
  <tr>
    <td height="35" valign="middle" style="padding-left:10px"> <a href="admin_zhiban.php"><input type="button" value="值班表管理" style="width:100px" /></a></td>
  </tr>
</table>    
    
    </td>
    <td width="93%" valign="top" height="760px"><iframe src="zhibanmain.php" width="100%" scrolling="yes" frameborder=0 height="100%"></iframe></td>
  </tr>
</table>



</body>
</html>