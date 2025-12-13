<?php
require '../ini/baseconfig.php';

//@print_r($_FILES);
//die(json_encode(array("error" => print_r($_FILES,1))));


$typeArr = array("jpg", "png", "gif","jpeg"); //允许上传文件格式
$path = "../uploads/"; //上传路径

if (isset($_POST)) {
    @$name = $_FILES['myfiles']['name'];
    @$size = $_FILES['myfiles']['size'];
    @$name_tmp = $_FILES['myfiles']['tmp_name'];
    if (empty($name)) {
        echo json_encode(array("error" => "您还未选择图片"));
        exit;
    }
    $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型

    if (!in_array($type, $typeArr)) {
        echo json_encode(array("error" => "只能上传jpg,png或gif类型的图片！"));
        exit;
    }
    if ($size > (50000 * 1024)) { //上传大小
        echo json_encode(array("error" => "图片大小已超过50000KB！"));
        exit;
    }

    $pic_name = time() . rand(10000, 99999) . "." . $type; //图片名称
    $pic_url = $path . $pic_name; //上传后图片路径+名称


	
    if (move_uploaded_file($name_tmp, $pic_url)) { //临时文件转移到目标文件夹
        //echo json_encode(array("error" => "0", "pic" => $pic_url, "name" => $pic_name));
		
        $con = mysql_connect($db_add,$db_user,$db_pass);
        mysql_select_db($db_name, $con); 
        mysql_query("SET NAMES UTF8");
		
		$intime=time();
		$zbs=$_POST['zbs'];
		$uid=$_POST['uid'];
		$address=$_POST['address'];
		
	   $init="INSERT INTO ".$db_tablepre."ups (uid,url,zb,fsize,dt,address)VALUES('$uid','$pic_url','$zbs','$size','$intime','$address')";
	   
	   $in=mysql_query($init,$con);		 		
		
	   echo json_encode(array("error" => "0", "pic" => $pic_url, "zb" => $zbs,"untime"=>date("Y-m-d H:i:s",$intime),"address"=>$address));	
		
    } else {
        echo json_encode(array("error" => "上传失败！"));
    }
}
?>