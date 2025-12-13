<?php
ini_set("display_errors","On");
require '../ini/baseconfig.php';
$con = mysql_connect($db_add,$db_user,$db_pass);
mysql_select_db($db_name, $con); 
mysql_query("SET NAMES UTF8");

if(!isset($_COOKIE['loginid'])){
echo json_encode(array("errorcode"=>"权限不足"),true);	
exit;
}

if($_POST['sdt']==""){$_POST['sdt']=8;}
if($_POST['edt']==""){$_POST['edt']=18;}

if($_POST['sdata']==""){
$nowss=date("Y-m-d",time())." ".$_POST['sdt'].":0:0";
$nowse=date("Y-m-d",time())." ".$_POST['edt'].":59:59";
	
$mydays=strtotime($nowss);
$mydaye=strtotime($nowse);
}else{
$nowss=$_POST['sdata']." ".$_POST['sdt'].":0:0";
$nowse=$_POST['sdata']." ".$_POST['edt'].":59:59";
		
$mydays=strtotime($nowss);
$mydaye=strtotime($nowse);	
	}


$dsel=" ( dt BETWEEN  ".$mydays." and ".$mydaye." ) and ";

if($_POST['uid']!=""){
 $suid=$_POST['uid'];	
	}else{
 $suid=$_COOKIE['loginid'];		
		}

//dt>$myday and

	   $sql="select * from ".$db_tablepre."gps where $dsel uid=$suid order by id ";

//echo $sql;
//exit;	 
	   
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		$dts[]=$row['dt'];   
		$myzb[]="[".$row['longitude'].",".$row['latitude']."]";   
		   } 
		if(isset($myzb)){
		$offtime=$dts[count($dts)-1]-$dts[0];	   
		$mystr="[".implode($myzb,",")."]";
		}
		
		if(isset($mystr)){
		 echo json_encode(array("errorcode"=>0,"gpss"=>$mystr,"offtime"=>$offtime),true);	
         exit;	
			}else{
         echo json_encode(array("errorcode"=>"未获得轨迹数据"),true);	
         exit;				
				} 
?>
