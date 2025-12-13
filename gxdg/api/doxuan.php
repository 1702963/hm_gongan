<?php
 $db_c=require '../caches/configs/database.php';
 $con = mysqli_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);	
 if (!$con){
	 die(json_encode(array('error'=>"系统异常",'str'=>"系统异常")));
	 }
 mysqli_select_db($con,$db_c['default']['database']); 


mysqli_set_charset($con,"UTF8"); 

////ajax
// 参数表 lid:lid,lpid:lpid,lm:lmname,plm:plmname,dotime:dotime,uid:uid,hj:t_hj,dotys:'add'
$lid=intval($_POST['lid']);
$lpid=intval($_POST['lpid']);
$lm=$_POST['lm'];
$plm=$_POST['plm'];
$dotime=intval($_POST['dotime']);
$uid=intval($_POST['uid']);
$uname=$_POST['uname'];
$hj=$_POST['hj'];
$dotys=$_POST['dotys'];	
$inputtime=time();
$dj=$_POST['dj'];
$bmid=intval($_POST['bmid']);


if($dotys=="add"){ //新增

	   $sql="INSERT INTO v9_beizhuang_linglog (`uid`, `uname`, `dotime`, `lmid`, `lmpid`, `lmtitle`, `lmptitle`, `lmje`,`inputtime`,`bmid`) VALUES ($uid,'".$uname."',$dotime,$lid,$lpid,'".$lm."','".$plm."',$dj,$inputtime,$bmid) ";  
	   $rs=mysqli_query($con,$sql);
	   $newid=mysqli_insert_id($con);

	   if($newid){
		   //如果插入成功则更新额度
	       $sql="update v9_beizhuang_ulog set sjje=$hj where uid=$uid and dotime=$dotime "; 
		   $rs=mysqli_query($con,$sql); 
	   
			  $returnstr=array('error'=>0);
		      die(json_encode($returnstr));		   
		   }else{		  
			  $returnstr=array('error'=>1);
		      die(json_encode($returnstr));
		   }

}

if($dotys=="del"){ //删除

	   $sql="DELETE FROM `v9_beizhuang_linglog` WHERE uid=$uid and dotime=$dotime and lmid=$lid ";  
	   $rs=mysqli_query($con,$sql);
	  // var_dump($rs);
	  if($rs){
		  
	  	   $sql="update v9_beizhuang_ulog set sjje=$hj where uid=$uid and dotime=$dotime "; 
		   $rs=mysqli_query($con,$sql); 
		   
			  $returnstr=array('error'=>0);
		      die(json_encode($returnstr));
	   }else{
			  $returnstr=array('error'=>1);
		      die(json_encode($returnstr));		  
	}

}

?>