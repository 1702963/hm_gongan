<?php 
header("Content-type: text/html; charset=utf-8");
ini_set("display_errors", "On"); 
//error_reporting(7);
date_default_timezone_set("PRC");

//配置接口参数 
//$sdk_config_appkey="dingu5xlqkz2h3lbqj4g";
//$sdk_config_appsecret="tB6r9SHHlNWpjsVIzsdJfMBd3S2hlaVeXCzV5SJvC0acIeNsJjZ1Oc26RDNi-YIx";

$sdk_config_appkey="dingqpvsk9y5ebw4jhqo";
$sdk_config_appsecret="7gT38kevT8vqY0zpq_-O7XWRqVfbmTIZw87urhcLITPuvr0WIXmqgmchpjBRBson";

//接口串
$d_sdk_api="https://oapi.dingtalk.com/gettoken?appkey=$sdk_config_appkey&appsecret=$sdk_config_appsecret";

//print_r($get_sdk);

//此令牌应存储至COOKIES 

if(!isset($_COOKIE['access_token'])){
    $get_sdk= json_decode(file_get_contents($d_sdk_api),true); //如果令牌失效则重新生成，否则从缓存取出
    if($get_sdk['errcode']==0){
	setcookie("access_token", $get_sdk['access_token'], time()+7200);
	$_token=$get_sdk['access_token'];
	}else{
	$_token=$get_sdk['errmsg'];	
		}
}else{
	$_token=$_COOKIE['access_token'];
	}

//获取考勤内容	
function getkaoqin($_token,$workday,$offs=0){ //获取排班详情
$tourl="https://oapi.dingtalk.com/topapi/attendance/listschedule?access_token=$_token";
$data = array('workDate'=>$workday,'offset'=>$offs,'size'=>200);
$headers = array('Content-Type: application/x-www-form-urlencoded');
$curl = curl_init(); // 启动一个CURL会话
curl_setopt($curl, CURLOPT_URL, $tourl); // 要访问的地址
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); // Post提交的数据包
curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$_kaoqin = curl_exec($curl); // 执行操作
if (curl_errno($curl)) {
    $_kaoqin= 'Errno'.curl_error($curl);//捕抓异常
}
curl_close($curl); 

return $_kaoqin;
}

//工作通知推送
function postsms($_token,$touser,$tomsg){ 
$tourl="https://oapi.dingtalk.com/topapi/message/corpconversation/asyncsend_v2?access_token=$_token";
//$data = json_encode(array('workDateFrom'=>$datefor,'workDateTo'=>$dateto,'userIdList'=>array($dateuser),'offset'=>0,'limit'=>2));
$data = json_encode(array('agent_id'=>1333138182,'userid_list'=>$touser,'to_all_user'=>false,'msg'=>array('msgtype'=>'text','text'=>array('content'=>"您将于明天（".$tomsg."日）值班，请按时到岗并打卡"))));
$headers = array("Content-type: application/json;charset='utf-8'");
$curl = curl_init(); // 启动一个CURL会话
curl_setopt($curl, CURLOPT_URL, $tourl); // 要访问的地址
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
//curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // !!!这里不能进行编码 支持JSON必须！！
curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$_kaoqin = curl_exec($curl); // 执行操作
if (curl_errno($curl)) {
    $_kaoqin= 'Errno'.curl_error($curl);//捕抓异常
}
curl_close($curl); 

return $_kaoqin;	
	}

//工作通知状态查询
function smstype($_token,$t_id){ 
$tourl="https://oapi.dingtalk.com/topapi/message/corpconversation/getsendresult?access_token=$_token";
$data = json_encode(array('agent_id'=>511681133,'task_id'=>$t_id));
$headers = array("Content-type: application/json;charset='utf-8'");
$curl = curl_init(); // 启动一个CURL会话
curl_setopt($curl, CURLOPT_URL, $tourl); // 要访问的地址
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
//curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // !!!这里不能进行编码 支持JSON必须！！
curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$_kaoqin = curl_exec($curl); // 执行操作
if (curl_errno($curl)) {
    $_kaoqin= 'Errno'.curl_error($curl);//捕抓异常
}
curl_close($curl); 

return $_kaoqin;	
	}
	
function zbdg($zbdays,$_token,$offs=0,&$returnarr,$basebanci){
  $sizes=200;	
  $_zbarr= json_decode(getkaoqin($_token,$zbdays,$offs),true);
  if(!isset($_zbarr['result']['has_more'])){return;}
  foreach($_zbarr['result']['schedules'] as $v){
	 if($v['group_id']==756560691){ 
	 if(isset($v['class_id'])){ //如果不存在class_id则排班数据为空，只有用户信息
     if(in_array($v['class_id'],$basebanci)){
	  if($v['check_type']=="OnDuty"){ //过滤掉下班记录	 	 
	   $returnarr[]=$v;
	 } }}}
  }
 
 //print_r($returnarr);
    
  if($_zbarr['result']['has_more']==1){ //如果分页为0则退出递归
      $offs2=$offs+$sizes;
	  zbdg($zbdays,$_token,$offs2,$returnarr,$basebanci);
	  }else{
		return ; 
	  }
  
  
}
	
$con = mysql_connect("127.0.0.1","root","2ycf4jd");
if (!$con) { die("err"); }
mysql_select_db("spjzhiban", $con); 
mysql_query("SET NAMES UTF8"); 

////////////////////////////////////////////////////////////////////////////////////////////
//获取次日的时间戳
$i_day=date("Y-m-d",strtotime("+1 day"));
//$i_day=date("Y-m-d");
//参与列表的班次
//$basebanci=Array(760420109,761300101,838925092,840855505,846850093,846990087);

//获取值班班次数据
$now_table= array();
//zbdg($i_day,$_token,0,$now_table,$basebanci);
     	   
		   $sql="select * from zb_table where days=".strtotime($i_day);
		   //echo $sql;
	       $rs=mysql_query($sql,$con);   
	       while($row = mysql_fetch_array($rs)){
			   $now_table[]=$row;
			   }

			if(count($now_table)){			
                foreach($now_table as $v){
					$listarr[]=$v['uid'];
					}
				
				$userlist=implode(',',$listarr);					

//echo $userlist;			
//exit;
// $userlist="03432952651047451";
//推送通知
$tmp_t=json_decode(postsms($_token,$userlist.",03432952651047451",$i_day),true);
//$tmp_t=json_decode(postsms($_token,"03432952651047451",$i_day),true);
// $tmp_t=json_decode(postsms($_token,"03432952651047451",'x0xxxx'),true);
 print_r($tmp_t);
//$tmp_t=json_decode('{"errcode":0,"task_id":149718506395,"request_id":"e2i0dvoamilf"}',true);

// echo smstype($_token,$tmp_t[task_id]);

//此处把工作通知入库


if(@$tmp_t['errcode']==0){
 	$sdt=strtotime(date("Y-m-d"));
	$k_id=$tmp_t['task_id'];
	   $init="INSERT INTO sms (userid,senddt,smsid)VALUES('$userlist',$sdt,'$k_id')";
	  //echo  $init;
	   $in=mysql_query($init,$con);	
	}
}
?>