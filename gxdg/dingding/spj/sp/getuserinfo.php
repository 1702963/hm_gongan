<?php
////////////////////////////////////
$sdk_config_appkey="dingrtwkiqwypylddqgp";
$sdk_config_appsecret="ZjM9aEyAo0HYsJG59FE-uaB4GP25fdL_6v59-FcOBd-iRFe0lg6QIA1Ut6Yc0PLF";

$d_sdk_api="https://oapi.dingtalk.com/gettoken?appkey=$sdk_config_appkey&appsecret=$sdk_config_appsecret";


  function sign($ticket, $nonceStr, $timeStamp,$url)
	{
        $plain = 'jsapi_ticket=' . $ticket .'&noncestr=' . $nonceStr . '&timestamp=' . $timeStamp .'&url=' . $url;
        return sha1($plain);
    }

     //jsAPI配置
  	 /*
     $timeStamp=time();
	 $signature=sign($_ticket['ticket'], "abcdef", $timeStamp,"http://other.tshmkj.com/gyzhongyi/dingding/?showmenu=false");
 
        $config = array(
            'url' => "http://other.tshmkj.com/gyzhongyi/dingding/?showmenu=false",
            'nonceStr' => "abcdef",
            'agentId' => "1348607907",   //ID不同 注意调整
            'timeStamp' => $timeStamp,
            'corpId' => 'ding494971938382df04a39a90f97fcb1e09', //都需要重置
            'suite_key' => 'SUITE_KEY',
            'signature' => $signature,
			'access_token'=>$_token,
			'type'=>0,
			'jsApiList'=>array('runtime.info','biz.contact.choose','device.notification.confirm','device.notification.alert','device.notification.prompt','biz.ding.post','biz.util.openLink','biz.telephone.call',
			             'biz.telephone.showCallMenu','biz.telephone.checkBizCall','biz.telephone.quickCallList')
			); */
			

/*
function getlogin($_token,$_code){ //获取登录人员
$tourl="https://oapi.dingtalk.com/user/getuserinfo?access_token=$_token";
$data = array('code'=>$_code);
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
*/



////////////////////////////////////////////////

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
	
$_ticket=json_decode(file_get_contents("https://oapi.dingtalk.com/get_jsapi_ticket?access_token=$_token"),true);


$_code=$_GET['code'];

echo json_encode(file_get_contents("https://oapi.dingtalk.com/user/getuserinfo?access_token=$_token&code=$_code"));
	
?>