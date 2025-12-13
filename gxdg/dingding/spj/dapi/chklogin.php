<?php
//验证登录状态
//接口串
$d_sdk_api="https://oapi.dingtalk.com/gettoken?appkey=$sdk_config_appkey&appsecret=$sdk_config_appsecret";

$get_sdk= json_decode(file_get_contents($d_sdk_api),true);

//print_r($get_sdk);

//此令牌应存储至COOKIES 

if(!isset($_COOKIE['access_token'])){
    if($get_sdk['errcode']==0){
	setcookie("access_token", $get_sdk['access_token'], time()+7200);
	$_token=$get_sdk['access_token'];
	}else{
	$_token=$get_sdk['errmsg'];	
		}
}else{
	$_token=$_COOKIE['access_token'];
	}

print_r($_token);
	
//获取 jsapi_ticket
// https://oapi.dingtalk.com/get_jsapi_ticket?access_token=ACCESS_TOKEN
$_ticket=json_decode(file_get_contents("https://oapi.dingtalk.com/get_jsapi_ticket?access_token=$_token"),true);

//print_r($_ticket);

//编码
  function sign($ticket, $nonceStr, $timeStamp,$url)
	{
        $plain = 'jsapi_ticket=' . $ticket .'&noncestr=' . $nonceStr . '&timestamp=' . $timeStamp .'&url=' . $url;
        return sha1($plain);
    }

//拼接参数
     $timeStamp=time();
	 $signature=sign($_ticket['ticket'], "abcdef", $timeStamp,"http://39.104.77.131/gjoa/");
 
 //print_r($signature);
 //define("SUITE_KEY", "");
 
        $config = array(
            'url' => "http://39.104.77.131/gjoa/",
            'nonceStr' => "abcdef",
            'agentId' => "511681133",   //ID不同 注意调整
            'timeStamp' => $timeStamp,
            'corpId' => "ding1c6453421efe90caa39a90f97fcb1e09",
            'suite_key' => "SUITE_KEY",
            'signature' => $signature,
			'access_token'=>$_token
			);	



?>