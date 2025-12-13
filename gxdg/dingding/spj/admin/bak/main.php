<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<?php
if($_COOKIE['isadmin']!=1){
  Header("Location:error.php");
}


$con = mysql_connect("127.0.0.1","root","2ycf4jd");
if (!$con){die("dberror");}

mysql_select_db("spjzhiban", $con); 
mysql_query("SET NAMES UTF8"); 


//统计

//用户
	   $sql="select count(id) as zj from zb_user ";
	   $rs=mysql_query($sql,$con);
	   $row = mysql_fetch_array($rs);
	   $user_zj=$row['zj'];
	   
//组
	   $sql="select count(id) as zj from zb_banci ";
	   $rs=mysql_query($sql,$con);
	   $row = mysql_fetch_array($rs);
	   $banci_zj=$row['zj'];
	   
	   	   
?>
<body>
<table width="90%" border="0" align="center">
  <tr>
    <td height="45" align="center" bgcolor="#d6d6d6">值班配置概况</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="padding-left:5px">参与值班人数：<?php echo $user_zj?> 人</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="padding-left:5px">值班分组： <?php echo $banci_zj?> 个</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="padding-left:5px">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>