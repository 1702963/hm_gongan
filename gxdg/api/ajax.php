<?php
$db_c=require '../caches/configs/database.php'; 
//print_r($db_c['default']['database']);
@$con = mysql_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);
if (!$con)
  { // 
  die();
  }

mysql_select_db($db_c['default']['database'], $con); 
mysql_query("SET NAMES UTF8"); 

function GetmyIP(){ //取得CLI的IP
if(!empty($_SERVER["HTTP_CLIENT_IP"])){
  $cip = $_SERVER["HTTP_CLIENT_IP"];
}
elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
  $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
elseif(!empty($_SERVER["REMOTE_ADDR"])){
  $cip = $_SERVER["REMOTE_ADDR"];
}
else{
  $cip = "0.0.0.0"; //获取失败
}
return $cip;
}

//////////////////////////////////////

//@print_r($_FILES);
//die(json_encode(array("error" => print_r($_FILES,1))));
//session_start();
//if($_SESSION['uid']==""){
//	die(json_encode(array("error" => "未经身份验证的操作")));
//	}

$typeArr = array("jpg", "png", "gif","jpeg","bmp","doc","docx","xls","xlsx","wps","pdf","ppt","rar","zip"); //允许上传文件格式
$path = "../uploads/"; //上传路径

if(!file_exists($path."index.html")){ //判断上传根路径下是否存在默认文档
	$adddefault = fopen($path."index.html", "w");
	fclose($adddefault);
	}
//创建按时间存储的目录结构
$nowdir=date("Ym");
if(!file_exists($path.$nowdir)){
	@mkdir($path.$nowdir);
	$adddefault = fopen($path.$nowdir."/index.html", "w");
	fclose($adddefault);	
	}
$path=$path.$nowdir."/";	

if (isset($_POST)) {
	 if(intval($_POST['canshu'])==0){   
		echo json_encode(array("error" => "异常的请求途径"));
        exit;
	 }
    @$name = $_FILES['file']['name'];
    @$size = $_FILES['file']['size'];
    @$name_tmp = $_FILES['file']['tmp_name'];
    if (empty($name)) {
        echo json_encode(array("error" => "您还未选择附件"));
        exit;
    }
    $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型

    if (!in_array($type, $typeArr)) {
        echo json_encode(array("error" => "不允许的附件类型"));
        exit;
    }
    if ($size > (2000000 * 1024)) { //上传大小
        echo json_encode(array("error" => "附件大小已超过200MB！"));
        exit;
    }

    $pic_name = time() . rand(10000, 99999) . "." . $type; //图片名称
	$file_name=$name;
    $pic_url = $path . $pic_name; //上传后图片路径+名称
    if (move_uploaded_file($name_tmp, $pic_url)) { //临时文件转移到目标文件夹
	////////////////////////////////////
	//入库

//var_dump($_SESSION);
$filename=$pic_name;
$filepath=$pic_url;
$filesize=$size;
$fileext=$type;
$userid=intval($_POST['canshu']);
$uploadtime=time();
$uploadip=GetmyIP();
$wjname=$file_name;
$ispublic=0;
	   
	   $init="INSERT INTO ".$db_c['default']['tablepre']."attachment (filename,filepath,filesize,fileext,userid,uploadtime,uploadip,wjname,ispublic)VALUES('$filename','$filepath','$filesize','$fileext','$userid','$uploadtime','$uploadip','$wjname','$ispublic')";
      // echo  $init;
	   $ined=mysql_query($init,$con);
	   $aid=mysql_insert_id();	
	////////////////////////////////////
	
        echo json_encode(array("error" => "0", "furl" => $pic_url, "name" => $file_name,"size"=>$size,"fname"=>$pic_name,"aid"=>$aid));
    } else {
        echo json_encode(array("error" =>"附件上传失败","errstr"=> "上传失败！"));
    }
}
?>