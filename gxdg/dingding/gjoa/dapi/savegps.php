<?php 
// DOUSER
require '../ini/baseconfig.php';


$uid=$_POST['uid'];
$longitude=$_POST['longitude'];
$latitude=$_POST['latitude'];
$accuracy=$_POST['accuracy'];
$address=$_POST['address'];
$netType=$_POST['netType'];

$dt=time();

if($longitude=="undefined"){
         echo json_encode(array("errorcode"=>"终止点"));
         exit;		
	}

$con = mysql_connect($db_add,$db_user,$db_pass);
if ($con){ 
mysql_select_db($db_name, $con); 
mysql_query("SET NAMES UTF8"); 


       
	   $init="INSERT INTO ".$db_tablepre."gps (uid,longitude,latitude,accuracy,address,netType,dt)VALUES('$uid','$longitude','$latitude','$accuracy','$address','$netType','$dt')";

   
	   $in=mysql_query($init,$con);
	   
	   if($in){
   /*      $gpslist['longitude']=$longitude;
		 $gpslist['latitude']=$latitude;
		 $gpslist['accuracy']=$accuracy;
		 $gpslist['address']=$address;
		 $gpslist['netType']=$netType; */
		 
         echo json_encode(array("errorcode"=>0),true);
         exit;			   
	   }else{
         echo json_encode(array("errorcode"=>"保存失败"));
         exit;			   
		   }
	   	     
	   }

?>