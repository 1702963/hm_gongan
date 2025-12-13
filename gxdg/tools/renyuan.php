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
//层级映射
$cengjiarr['一级辅警1']=7;
$cengjiarr['一级辅警2']=43;
$cengjiarr['一级辅警3']=44;
$cengjiarr['一级辅警4']=45;
$cengjiarr['一级辅警5']=46;
$cengjiarr['一级辅警6']=47;
$cengjiarr['一级辅警7']=48;

$cengjiarr['二级辅警1']=6;
$cengjiarr['二级辅警2']=34;
$cengjiarr['二级辅警3']=35;
$cengjiarr['二级辅警4']=36;
$cengjiarr['二级辅警5']=37;
$cengjiarr['二级辅警6']=38;
$cengjiarr['二级辅警7']=39;
$cengjiarr['二级辅警8']=40;
$cengjiarr['二级辅警9']=41;
$cengjiarr['二级辅警10']=42;

$cengjiarr['三级辅警1']=5;
$cengjiarr['三级辅警2']=25;
$cengjiarr['三级辅警3']=26;
$cengjiarr['三级辅警4']=27;
$cengjiarr['三级辅警5']=28;
$cengjiarr['三级辅警6']=29;
$cengjiarr['三级辅警7']=30;
$cengjiarr['三级辅警8']=31;
$cengjiarr['三级辅警9']=32;
$cengjiarr['三级辅警10']=33;

$cengjiarr['四级辅警1']=4;
$cengjiarr['四级辅警2']=15;
$cengjiarr['四级辅警3']=16;
$cengjiarr['四级辅警4']=17;
$cengjiarr['四级辅警5']=18;
$cengjiarr['四级辅警6']=19;
$cengjiarr['四级辅警7']=20;
$cengjiarr['四级辅警8']=21;
$cengjiarr['四级辅警9']=22;
$cengjiarr['四级辅警10']=23;
$cengjiarr['四级辅警11']=24;

$cengjiarr['五级辅警1']=3;
$cengjiarr['五级辅警2']=13;
$cengjiarr['五级辅警3']=14;

$cengjiarr['六级辅警1']=2;
$cengjiarr['六级辅警2']=11;
$cengjiarr['六级辅警3']=12;

$cengjiarr['七级辅警1']=8;
$cengjiarr['七级辅警2']=9;
$cengjiarr['七级辅警3']=10;

$cengjiarr['见习辅警0']=1;

$gwdjarr['一级岗位']=1;
$gwdjarr['二级岗位']=2;
$gwdjarr['三级岗位']=3;

//////////////////////////////////////////

//var_dump($con);
	   $sql="select * from `sheet2` ";
	   $rs=mysql_query($sql,$con);
$i=0;
	   while($row = mysql_fetch_array($rs)){
	//print_r($row);exit;	  
		 //$sql="select * from v9_fujing  where sfz='".$row['c']."' ";
		 
		 $tmp=$row[10].$row[11];
		 $sql2="update v9_fujing set cengji=".$cengjiarr[$tmp].",gwdj=".$gwdjarr[$row[14]].",cj3='".$row[10]."',dc='".$row[11]."',gw='".$row[14]."' where sfz='".$row['sfz']."' ";
		 echo $sql2."<br>";
	     $rs2=mysql_query($sql2,$con);
	     $i++;
		   }
		   
		   echo $i;
?>

