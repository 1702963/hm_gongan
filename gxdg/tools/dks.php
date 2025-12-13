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

	   $sql="select id,xingming,dwid,ddid from mj_fujing where status=1  ";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		   if($row['ddid']!=""){
			   $fj[$row['ddid']]=$row;
			   }		   	 
		   }

       $ns=2025;
	   $ms=8;
	   $ds=28;
	   $tjdt=strtotime("2025-08-28");
	   
	   $sql="select ddid,name from dklog where dklx='OnDuty' and zt2='正常'  ";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		   
	     	   $sql2="select count(*) from mj_dks where ddid='".$row['ddid']."'  ";
	           $rs2=mysql_query($sql2,$con); 
               $row2 = mysql_fetch_array($rs2);
			   if($row2[0]==0){
				 if(isset($fj[$row['ddid']])){  
	     	     $sql3="INSERT INTO `mj_dks`(`ddid`, `xingming`, `uid`, `dwid`, `tjdt`, `ns`, `ms`, `ds`) VALUES ('".$row['ddid']."','".$fj[$row['ddid']]['xingming']."','".$fj[$row['ddid']]['id']."','".$fj[$row['ddid']]['dwid']."',$tjdt,$ns,$ms,$ds)";
	             $rs3=mysql_query($sql3,$con);
				 }
				   }
			   
	   }

echo "doing";


/*
//////////////////////////////////////////
	   $sql="select * from gxuser ";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		 
		//检查姓名
	   $csql="select * from mj_fujing where xingming='".$row['un2']."' ";
	   $crs=mysql_query($csql,$con);
	   $crow = mysql_fetch_array($crs);		
	   if(!isset($crow[0]['ddid'])){//如果已写入就跳过，防止重名	 
		 
		 $sql2="update mj_fujing set ddid=".$row['did']." where id=".$crow['id'];
	     $rs2=mysql_query($sql2,$con);
	   }
		   }

echo "dook";		   

*/

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

