<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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



//////////////////////////////////////////
	   $sql="select * from sheet0 where nl>0 ";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){

	     //插入表
	     //$f_id=mysql_insert_id();
$xingming=$row['xingming'];
$sex=$row['sex'];
$shengri=$row['sr2'];
$age=$row['nl'];
$dwid=$row['dwid'];
$minzu=$row['mz'];
$gzz=$row['jh'];
$rjtime=strtotime($row['cjgz']);
$zzmm=$row['zzmmid'];
$jiguan=$row['jg'];
$sfz=$row['sfz'];
$mjzt=$row['zz'];
$inputtime=time();
$inputuser="admin";
$hun="不详";
		 
		 
	     $init2="INSERT INTO ".$db_c['default']['tablepre']."fujing (xingming,sex,shengri,age,dwid,minzu,gzz,rjtime,zzmm,jiguan,sfz,mjzt,inputtime,inputuser,hun)VALUES('$xingming','$sex',$shengri,$age,$dwid,'$minzu','$gzz',$rjtime,$zzmm,'$jiguan','$sfz','$mjzt',$inputtime,'$inputuser','$hun')";
	     $in2=mysql_query($init2,$con);		 	 
		 echo $in2;
		 
		   }

/*

//var_dump($con);
	   $sql="select * from sheet0 where zz=1 ";
	   $rs=mysql_query($sql,$con);

$today = new DateTime();

	   while($row = mysql_fetch_array($rs)){
		 
		// $sql2="update sheet0 set sr2='".strtotime($row['sr'])."' where id=".$row['id'];
		
$birthDate = new DateTime($row['sr']);
// 计算两个日期的差
$age = $today->diff($birthDate);
// 获取完整的年龄（年）
//$ageInYears = $age->y;
 
		
		 $sql2="update sheet0 set nl=".($age->y+1)." where id=".$row['id'];
		 echo $sql2."<br>";
	     $rs2=mysql_query($sql2,$con);
	    
		   }
		   
*/		  
?>

