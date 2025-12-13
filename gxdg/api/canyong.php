<?php
 $db_c=require '../caches/configs/database.php';
 $con = mysqli_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);	
 if (!$con){
	 die(json_encode(array('error'=>"系统异常",'str'=>"系统异常")));
	 }
 mysqli_select_db($con,$db_c['default']['database']); 


mysqli_set_charset($con,"UTF8"); 


//数据拉取
//print_r($_POST);
//exit;
$dotime=$_POST['dotime'];	

	   $sql="SELECT count(*) FROM `v9_beizhuang_pici` where isdel=0 and dotime=$dotime ";  
	   $rs=mysqli_query($con,$sql);
	   $row = mysqli_fetch_array($rs);
	   
	   if($row[0]>0){
			  $returnstr=array('error'=>"该日期已存在");
		      die(json_encode($returnstr));		   
		   }else{		  
			  $returnstr=array('error'=>0);
		      die(json_encode($returnstr));
		   }
   

?>