<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php 
ini_set("display_errors","On");
$db_c=require '../caches/configs/database.php'; 
//print_r($db_c['default']['database']);
@$con = mysql_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);
if (!$con)
  { // 
  echo '<div style="color:red;height:80px;margin-top:20px;" align="center">err: E0X96001</div>';
  die();
  }

@mysql_select_db($db_c['default']['database'], $con); 
@mysql_query("SET NAMES UTF8"); 

	   $sql="select * from sheet0 where zz=1 and nl>=45";
	   $rs=mysql_query($sql,$con);

?>
<table width="100%" border="0">
  <tr>
    <td>序号</td>
    <td>姓名</td>
    <td>年龄</td>
    <td>性别</td>
    <td>单位</td>
  </tr>
<?php 
       $i=1;
	   while($row = mysql_fetch_array($rs)){
?>  
  <tr>
    <td><?php echo $i?></td>
    <td><?php echo $row['xingming']?></td>
    <td><?php echo $row['nl']?></td>
    <td><?php echo $row['sex']?></td>
    <td><?php echo $row['dw']?></td>
  </tr>
<?php $i++;}?>    
</table>

</body>
</html>