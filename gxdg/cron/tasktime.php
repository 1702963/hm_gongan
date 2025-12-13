<?php 
ini_set('memory_limit', '1024M');
set_time_limit(1200);
ini_set('date.timezone', 'Asia/Shanghai'); //设置默认时区
////////////
/// 定时任务，目前只有飞行任务，其他任务都可以加在此处
////////////

@$con = mysql_connect("localhost","root","root");
if (!$con) {  die('Could not connect: ' . mysql_error()); }  //没必要返回调试信息
mysql_select_db("wrj", $con); //选择数据库
mysql_query("SET NAMES UTF8");

/////////////////////////////////////////////
///取出当前年月日时分，供定时任务用
$now_y=date("Y");
$now_m=date("m");
$now_d=date("d");
$now_h=date("H");
$now_f=date("i");
$now_s=date("s");
$now_time=time();
//取出接口配置
			 $sql="select * from sets where type=1 and isok=1 ";
	         $rs=mysql_query($sql,$con);
	         while($row = mysql_fetch_array($rs)){
			   $sets[$row['pid']]=$row;	 
				 }

/////////////////////////////////////////////
             //检查飞行任务
			 $sql="select * from v9_fly where isdo=1 and hs=$now_h and ms=$now_f order by id desc"; //检查最新一条
	         $rs=mysql_query($sql,$con);
	         $row = mysql_fetch_array($rs);
             if($row){ //如果命中，则执行
			 echo "Task1 execution in progress.....";
		       foreach($sets as $k=>$s){  
			    $dotask=getrul2($s['apiurl']); //投送飞控指令
		        $dodat=json_decode($dotask,true); //解析JSOM
				if($dodat['code']==0){ //如果指令投送被执行
				   $tid=$dodat['task_uuid']; 	
					} 
				 $name=$row['name'];
				 $dotime=time();
				 $yctime=time()+1200; //延迟20分钟  实测10分钟左右有返回数据
				 $dozt=1; // 1投送指令 2 已获取数据
				 if($tid!=''){
			       $str="执行正常";	 
					 }
				 $apiurl=$s['apiurl'];
				 $quyu=$k;
				 $tjdt=strtotime(date("Y-m-d",$dotime));
				 //$istemp=$row['istemp'];
				 
				   $init="INSERT INTO v9_dolog (name,ys,ms,ds,hs,fens,ss,dotime,yctime,dozt,tid,str,apiurl,quyu,tjdt)VALUES('$name','$now_y','$now_m','$now_d','$now_h','$now_f','$now_s','$dotime','$yctime','$dozt','$tid','$str','$apiurl','$quyu','$tjdt')";
				   //echo $init."<br>"; exit;
	               $ok=mysql_query($init,$con);
				   				 
			   } //end for
				 } //end if

///##############################################################################################
             //检查数据反馈
			 $sql="select * from v9_dolog where dozt=1 and yctime<=$now_time and str='执行正常' "; 		 
	         $rs=mysql_query($sql,$con);
	         $row = mysql_fetch_array($rs);
	//var_dump($row);		 
             if($row){ //如果命中，则执行同步CLI
			 echo "Task2 execution in progress.....";
				  system('F:\phpStudy\PHPTutorial\php\php-5.3.29-nts\php.exe L:\phpweb\wrj\gets_lun.php', $return_str);				 
				 } //end if

///##############################################################################################


mysql_close($con); //显式关闭数据库
///////////////////////////////////////////////////////////////
//// 支持函数

function getrul2($str_rul){ //cURL 方法
$ch = curl_init();
 
// 设置cURL选项
curl_setopt($ch, CURLOPT_URL, $str_rul); // 设置请求的URL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($ch, CURLOPT_HEADER, false); // 禁止cURL包括header部分。Header部分将会被丢弃且不会返回。
curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
// 执行cURL会话
$_out = curl_exec($ch);
 
// 关闭cURL资源，并且释放系统资源
curl_close($ch);
return $_out;
	}	

?>