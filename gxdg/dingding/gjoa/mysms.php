<?php 
header("Content-type: text/html; charset=utf-8");
ini_set("display_errors", "off"); 
error_reporting(7);
date_default_timezone_set("PRC");

//配置接口参数 
$sdk_config_appkey="dingu5xlqkz2h3lbqj4g";
$sdk_config_appsecret="tB6r9SHHlNWpjsVIzsdJfMBd3S2hlaVeXCzV5SJvC0acIeNsJjZ1Oc26RDNi-YIx";

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
//$_kaoqin=json_decode(file_get_contents("https://oapi.dingtalk.com/topapi/attendance/listschedule?access_token=$_token"),true);	

function getkaoqin($_token,$workday){ //获取排班详情
$tourl="https://oapi.dingtalk.com/topapi/attendance/listschedule?access_token=$_token";
$data = array('workDate'=>$workday);
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
$data = json_encode(array('agent_id'=>511681133,'userid_list'=>$touser,'to_all_user'=>false,'msg'=>array('msgtype'=>'text','text'=>array('content'=>"您将于明天（".$tomsg."日）值班，请按时到岗并打卡"))));
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

////////////////////////////////////////////////////////////////////////////////////////////
//获取次日的时间戳
$i_day=date("Y-m-d",strtotime("+1 day"));
//$i_day=date("Y-m-d");
//参与列表的班次
$basebanci=Array(458420375,534545623,540535340,540655138,542690558,565490035,586650134);

//获取值班班次数据
$now_table= json_decode(getkaoqin($_token,$i_day),true);

			if(count($now_table[result][schedules])){
				foreach($now_table[result][schedules] as $banci){ //需要合并人员
				if(in_array($banci[class_id],$basebanci)){ // 1c   只处理值班相关班次,提高计算效率
				  
				  //加入是否显示标记，很复杂
                  //echo str_replace($i_day,"",$banci[plan_check_time]);
				  $barr[noshow]=0;
				  if($banci[class_id]==458420375){//值班员上午
					  if(str_replace($i_day,"",$banci[plan_check_time])==" 13:00:00" || str_replace($i_day,"",$banci[plan_check_time])==" 17:30:00"){$barr[noshow]=1;}
					  }
				  if($banci[class_id]==534545623){//值班员下午
					  if(str_replace($i_day,"",$banci[plan_check_time])==" 08:30:00" || str_replace($i_day,"",$banci[plan_check_time])==" 11:59:00"){$barr[noshow]=1;}
					  }	
				  if($banci[class_id]==540655138){//工作日晚班
					  if(str_replace($i_day,"",$banci[plan_check_time])==" 08:30:00" || str_replace($i_day,"",$banci[plan_check_time])==" 17:29:00"){$barr[noshow]=1;}
					  }						  				  
				  if($banci[class_id]==565490035){//带班晚班
					  if(str_replace($i_day,"",$banci[plan_check_time])==" 08:30:00" || str_replace($i_day,"",$banci[plan_check_time])==" 17:30:00"){$barr[noshow]=1;}
					  }					
				
		   		  $barr[name]=$use_arrs[$banci[userid]];
				  $barr[userid]=$banci[userid];
		   		  $barr[days]=$banci[plan_check_time];
				  if(isset($banci[class_id])){
				    $barr[bc]=$banci[class_id];
				  }else{
				    $barr[bc]=0; //此处无需判断了，不会有其他班次ID	
				  }
				    $banciarrs[]=$barr;
					unset($barr);
					
				} // lc end 
				} //foreach end
			

				//需要先清理掉不显示的成员
				for($px=0;$px<count($banciarrs);$px++){
					if($banciarrs[$px][noshow]==0){
					 $tmps1[$px]=$banciarrs[$px];	
						}
					}
						
				//重整为连续下标
				$px=0;
				foreach($tmps1 as $t){
					$tmps[$px]=$t;
					$px++;
					}
               // print_r($tmps);
			    unset($tmps1);		
				unset($banciarrs);
				$banciarrs=$tmps;
				unset($tmps);
				
				//取出偶数下标的人员ID
                for($px=0;$px<count($banciarrs);){
					$listarr[]=$banciarrs[$px][userid];
					$px=$px+2;
					}
				
				$userlist=implode(',',$listarr);					

//echo $userlist;			
//exit;
// $userlist="03432952651047451";
//推送通知
$tmp_t=json_decode(postsms($_token,$userlist.",03432952651047451",$i_day),true);
// $tmp_t=json_decode(postsms($_token,"03432952651047451",'x0xxxx'),true);
// print_r($tmp_t);
//$tmp_t=json_decode('{"errcode":0,"task_id":149718506395,"request_id":"e2i0dvoamilf"}',true);

// echo smstype($_token,$tmp_t[task_id]);

//此处把工作通知入库
$con = mysql_connect("127.0.0.1","root","2ycf4jd");
if (!$con) { die(); }
mysql_select_db("gljoa", $con); 
mysql_query("SET NAMES UTF8"); 

if($tmp_t[errcode]==0){
 	$sdt=strtotime(date("Y-m-d"));
	$k_id=$tmp_t[task_id];
	   $init="INSERT INTO sms (userid,senddt,smsid)VALUES('$userlist',$sdt,'$k_id')";
	  //echo  $init;
	   $in=mysql_query($init,$con);	
	}
}
?>