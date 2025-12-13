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
$color=$_POST['color'];
	
	   $updat="update zb_banci set banci='$banci',beizhu='$beizhu',isok='$isok',px='$px',color='$color' where id=$id";
	   $up=mysql_query($updat,$con);	
	}	

 	   $sql="select * from zb_banci order by px asc";
	   $rs=mysql_query($sql,$con);    
	   while($row = mysql_fetch_array($rs)){
		   $banciarr[]=$row;
		   }
?>
<body>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/colorset.js"></script>
<script type="text/javascript">

    $(function(){

        $("#selcolor").colorpicker({
            fillcolor:true
        });
						
		})
		
 function editcolor(obj){
	 //alert(obj)
        $("#"+obj).colorpicker({

            fillcolor:true

        });	 
	 }		
</script>	
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
    <td width="93%">
  <table width="99%" border="0" align="center">
  <tr>
    <td width="9%"  height="22" align="center" bgcolor="#d6d6d6">ID</td>
    <td width="29%"  align="center" bgcolor="#d6d6d6">班次名称</td>
    <td width="29%"  align="center" bgcolor="#d6d6d6">备注</td>
    <td width="11%"  align="center" bgcolor="#d6d6d6">图例</td>
    <td width="10%"   align="center" bgcolor="#d6d6d6">排序</td>
    <td width="5%"  align="center" bgcolor="#d6d6d6">状态</td>
    <td width="7%"  align="center" bgcolor="#d6d6d6">操作</td>
  </tr>
<form action="" method="post">  
  <tr>
    <td height="38" align="center">&nbsp;<input type="hidden" name="id" value="" /></td>
    <td align="center"><input type="text" name="banci" value="" style="width:90%; height:24px"/></td>
    <td align="center"><input type="text" name="beizhu" value="" style="width:90%;height:24px"/></td>
    <td align="center">&nbsp;</td>
    <td align="center"><input type="text" name="px" value="0" style="width:80%;height:24px"/></td>
    <td align="center"><select name="isok">
          <option value="1">启用</option>
          <option value="0">停用</option>
        </select>
    </td>
    <td align="center"><input type="submit" name="addme" value="新建" /></td>
  </tr>
</form>
<?php 
 if(is_array(@$banciarr)){
 foreach($banciarr as $b){
?>  
<form action="" method="post">
  <tr>
    <td height="40" align="center">&nbsp;<?php echo $b['id']?><input type="hidden" name="id" value="<?php echo $b['id']?>" /></td>
    <td align="center"><input type="text" name="banci" value="<?php echo $b['banci']?>" style="width:90%; height:24px"/></td>
    <td align="center"><input type="text" name="beizhu" value="<?php echo $b['beizhu']?>" style="width:90%;height:24px"/></td>
    <td align="center"><input type="text" name="color" id="selcolor<?php echo $b['id']?>" style="width:90%;color:<?php echo $b['color'] ?>" value="<?php echo $b['color']?>" onfocus="editcolor(this.id)"/></td>
    <td align="center"><input type="text" name="px" value="<?php echo $b['px']?>" style="width:80%;height:24px"/></td>
    <td align="center">
      <select name="isok">
        <option value="1" <?php if($b['isok']==1){?>selected="selected"<?php }?>>启用</option>
        <option value="0" <?php if($b['isok']==0){?>selected="selected"<?php }?>>停用</option>
        </select>    
    </td>
    <td align="center"><input type="submit" name="editme" value="编辑" /></td>
  </tr>  
</form>  
<?php }}?>
</table>  
    </td>
  </tr>
</table>


</body>
</html>