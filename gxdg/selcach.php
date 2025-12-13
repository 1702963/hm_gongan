<?php 
ini_set("display_errors", "On"); 
$db_c=require 'caches/configs/database.php'; 
$con = mysql_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);

if (!$con) { die("err009"); }

mysql_select_db($db_c['default']['database'], $con); 
mysql_query("SET NAMES UTF8"); 

//echo json_encode(array("error" => "上传失败！"));

if(intval($_GET['userid'])==0 || intval($_GET['yue'])==0){
   $r_arr=array("err"=>1,"errstr"=>"错误的请求结构");
   echo json_encode($r_arr);exit;	
	} 
	
//先获取考勤表字段（因为列不固定）
$mydb=$db_c['default']['tablepre']."kq".$_GET['yue'];

	   $sql="select COLUMN_NAME from information_schema.COLUMNS where table_name = '$mydb' and table_schema = '".$db_c['default']['database']."'";
	   $rs=mysql_query($sql,$con);

	   while($row = mysql_fetch_array($rs)){
		 $fids[]= $row[0];  
	   }

if(!is_array($fids)){
   $r_arr=array("err"=>9,"errstr"=>"异常的数据响应");
   echo json_encode($r_arr);exit;		
	}


//取出要统计的列名
		  foreach($fids as $v){
			if(strtotime($v)){
				$rowname[]=$v;
				}  
			  }		

	
$kqflag=require 'caches/kaoqinflag.php'; //引入考勤映射表


//取出考勤数据
		   
	   $sql="select * from $mydb where userid=".intval($_GET['userid']);
	  
	   $rs=mysql_query($sql,$con);

	   while($row = mysql_fetch_array($rs)){
		   $kaoqin[]=$row;
		   }
	   
		  //统计出勤天数
		  foreach($kaoqin as $ry){
			 foreach($kqflag as $k=>$vs){
				$kqtj0[$k]=0;  
			  }           
			foreach($rowname as $d){
 
		    //创建映射结构				 
			 if($ry[$d]==0){$kqtj0[0]++;}	  
             if($ry[$d]==1){$kqtj0[1]++;}
			 if($ry[$d]==2){$kqtj0[2]++;}
			 if($ry[$d]==3){$kqtj0[3]++;}
			 if($ry[$d]==4){$kqtj0[4]++;}
			 if($ry[$d]==5){$kqtj0[5]++;}
			 if($ry[$d]==6){$kqtj0[6]++;}
			 if($ry[$d]==7){$kqtj0[7]++;}
			 if($ry[$d]==8){$kqtj0[8]++;}
			 if($ry[$d]==9){$kqtj0[9]++;}
			 if($ry[$d]==10){$kqtj0[10]++;}
			 if($ry[$d]==11){$kqtj0[11]++;}
			 if($ry[$d]==12){$kqtj0[12]++;}
			 if($ry[$d]==13){$kqtj0[13]++;}
			 $kqtj=$kqtj0;
			} 
		  }	 
		  
		  
   $r_arr=array("err"=>0,"errstr"=>"响应完成","datas"=>$kqtj);
   echo json_encode($r_arr);exit;	
?>