<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>值班管理</title>
</head>
<body>
<?php 
if(!isset($_COOKIE['loginar'])){
?>
<table width="90%" border="0" align="center">
  <tr>
    <td height="75" align="center" bgcolor="#d4d0c8">异常的访问请求</td>
  </tr>
</table>
<?php 
  exit;
   }else{
      $lgarr=json_decode($_COOKIE['loginar'],true); //？？为啥要解码两次
	  $lgarr=json_decode($lgarr,true);
   	  //print_r($lgarr);exit;
	  $ised=$lgarr['userid'];
	  $isname=$lgarr['name'];
	  $_token=$_COOKIE['access_token'];		

      $inuser=json_decode(file_get_contents("https://oapi.dingtalk.com/user/get?access_token=$_token&userid=".$lgarr['userid']),true);
	 // print_r($inuser['roles']);
	  $isadmined=0;
	  foreach($inuser['roles'] as $ro){
		  
		  if($ro['name']=="值班管理员"){
		  $isadmined=1;
		  break;}
		  }
			  //echo $isadmined;
			 
		setcookie("isadmin",$isadmined);  	  
	 }
	      if($isadmined<1){
	 ?>
<table width="90%" border="0" align="center">
  <tr>
    <td height="96" align="center" bgcolor="#d4d0c8">权限不足</td>
  </tr>
</table>     
<?php }else{
 Header("Location:main.php");
}
?>

</body>
</html>