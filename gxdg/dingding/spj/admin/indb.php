<?php
ini_set('date.timezone','Asia/Shanghai');

//#########################
$con = mysql_connect("127.0.0.1","root","2ycf4jd");
if (!$con){die("dberror");}

mysql_select_db("spjzhiban", $con); 
mysql_query("SET NAMES UTF8"); 
//#########################

//////////////////////////////
//全部排班数据均需要写表，防止因映射结构变动造成历史排班数据无法阅读，减少AJAX传输数据量，人员姓名、班次名称均由映射取出
//班次映射


 	   $sql="select * from zb_banci order by px asc";
	   $rs=mysql_query($sql,$con);    
	   while($row = mysql_fetch_array($rs)){
		   $banciall[$row['id']]=$row['banci'];
		   }
		   
//人员映射
 	   $sql="select * from zb_user order by px asc";
	   $rs=mysql_query($sql,$con);    
	   while($row = mysql_fetch_array($rs)){
		   $userall[$row['uid']]=$row['username'];
		   }	


$uid=$_POST['uid'];
$nians=$_POST['nians'];
$yues=$_POST['yues'];
$dayss=$_POST['days'];
$banci=$_POST['banci'];
$days=strtotime($nians."-".$yues."-".$dayss);
$weeks=date("w",$days);

//print_r($_POST);

if($banciall[$banci]=="休息"){ //如果班次设置为休息，则检查是否存在排班，如果存在则删除，不存在则跳过

     	   $sql="select count(*) as zj from zb_table where uid=$uid and days=$days";
	       $rs=mysql_query($sql,$con);    
	       $row = mysql_fetch_array($rs);
		   if($row['zj']>0){
			   	   $delme="delete from zb_table where uid=$uid and days=$days";
	               mysql_query($delme,$con);	
			   }
	
	         echo json_encode(array("error"=>0,"errorstr"=>"完成"));
             exit;
	
	}else{ //如果班次不是休息，则检查排班，不存在则插入，存在则修改为当前值
		
     	   $sql="select count(*) as zj from zb_table where uid=$uid and days=$days";
	       $rs=mysql_query($sql,$con);    
	       $row = mysql_fetch_array($rs);
		   if($row['zj']>0){
			       //存在则更新
	               $updat="update zb_table set banci='".$banciall[$banci]."',banciid='$banci' where uid=$uid and days=$days ";
	               $up=mysql_query($updat,$con);
	               echo json_encode(array("error"=>0,"errorstr"=>"更新完成"));
                   exit;				   		
			   }else{
				      //不存在则插入
				   $init2="INSERT INTO zb_table (uid,uname,days,weeks,banci,nians,yues,dayss,banciid)VALUES('$uid','".$userall[$uid]."','$days','$weeks','".$banciall[$banci]."','$nians','$yues','$dayss','$banci')";
	               $in2=mysql_query($init2,$con);	
	               echo json_encode(array("error"=>0,"errorstr"=>"新加完成"));
                   exit;				   
				  }
			   		
		}

?>