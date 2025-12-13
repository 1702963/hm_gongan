<?php 
ini_set("display_errors", "Off"); 

if($_GET['sel']==""){
        echo json_encode(array("errnum"=>1,"error" => "参数异常"));
        exit;	
	}else{
		$tmp_sel=$_GET['sel'];
		}

$where="";

if(intval($_GET['mj'])==1){
	$where=" ismj=1 and ";
	}
if($_GET['mj']=="-1"){
	$where=" ismj=0 and ";
	}	
	
//此处需要改为MYSQLI	
$db_c=require '../caches/configs/database.php'; 

//var_dump($db_c);

 $con = mysqli_connect($db_c['gxdgdb']['hostname'],$db_c['gxdgdb']['username'],$db_c['gxdgdb']['password']);	
 if (!$con){
	 die(json_encode(array('error'=>"系统异常",'str'=>"系统异常")));
	 }
 mysqli_select_db($con,$db_c['gxdgdb']['database']); 


mysqli_set_charset($con,"UTF8"); 

       //部门
	   $sql="select id,name from ".$db_c['gxdgdb']['tablepre']."bumen ";
	   $rs=mysqli_query($con,$sql);
       while($row = mysqli_fetch_array($rs)){
		 $bms[$row['id']]=$row['name'];   
	   }
	   
	   //职务
	   $sql="select id,zwname from ".$db_c['gxdgdb']['tablepre']."zhiwu ";
	   $rs=mysqli_query($con,$sql);
	   $zhiwu[]="";
       while($row = mysqli_fetch_array($rs)){
		 $zhiwu[$row['id']]=$row['zwname'];   
	   }
	   //职级、层级
	   $sql="select id,cjname from ".$db_c['gxdgdb']['tablepre']."cengji ";
	   $rs=mysqli_query($con,$sql);
	   $cengji[0]="";
       while($row = mysqli_fetch_array($rs)){
		 $cengji[$row['id']]=$row['cjname'];   
	   }	
	   
	   //print_r($cengji);   
	   // 身份
	   $shenfen[0]="辅警";
	   $shenfen[1]="民警";
	   //政治面貌
$zzmm[1]="中共党员";
$zzmm[2]="共青团员";
$zzmm[3]="民主党派";
$zzmm[4]="学生";
$zzmm[5]="群众";	   
	   

	   $sql="select xingming,sex,sfz,zzmm,hjdizhi,minzu,dwid,zhiwu,cengji,ismj,id,shengri from ".$db_c['gxdgdb']['tablepre']."fujing where $where xingming like '%$tmp_sel%' limit 0,10";
	   $rs=mysqli_query($con,$sql);
       while($row = mysqli_fetch_array($rs)){
		 $row['danwei']= $bms[$row['dwid']];
		 $row['zhiwuname']=$zhiwu[intval($row['zhiwu'])]; 
		 $row['cengjiname']=$cengji[intval($row['cengji'])];
		 $row['shenfen']=$shenfen[$row['ismj']];
		 $row['zzmmname']=$zzmm[$row['zzmm']];
		 $row['shengri']=date("Y-m-d",$row['shengri']);
		 $returns[]=$row;   
	   }
	   
	   if(isset($returns)){
         
		 echo json_encode(array("errnum"=>0,"data" =>$returns,"num"=>count($returns)));
         exit;			   
	   }else{
		 echo json_encode(array("errnum"=>1,"data" =>'',"num"=>0));
         exit;			   
		   }
	   
?>