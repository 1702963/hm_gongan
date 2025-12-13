<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<?php
if($_POST['po']=="send"){

$access_token=$_POST['access_token'];
$agentId=$_POST['agent_id'];
$userid_list=$_POST['userid_list'];
$msg=$_POST['msg'];
	
      $curl = curl_init();
	  
      curl_setopt($curl, CURLOPT_URL, "https://oapi.dingtalk.com/topapi/message/corpconversation/asyncsend_v2?access_token=ca89c9f28bbc3676875e51b72f84f462");
      
      curl_setopt($curl, CURLOPT_HEADER, 0);
	  
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	   
      curl_setopt($curl, CURLOPT_POST, 1);

     $post_data = array(
         //"access_token" => $access_token,
         "agent_id" => $agentId,
		 "userid_list"=> $userid_list,
		 "msg"=>$msg
         );

     curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

     $data = curl_exec($curl);
 
	curl_close($curl);
       
	   echo $data; 		
	} 

?>
<body>
<form action="" method="post">
<input type="text" name="agent_id" value="249906547" />
<input type="text" name="userid_list" value="03432952659089" />
<input type="text" name="msg" value='{"msgtype":"text","text":{"content":"这是一条来自合同管理的消息"}}' />
<input type="submit" name="po" value="send"/>
</form>

<form action="getuser.php" method="post">
<input type="text" name="event" value="get_userinfo" />
<input type="text" name="code" value="eeee9d6b73a13e7789816fd2006649f0" />
<input type="text" name="corpId" value='dingaa7a5c2aa325a3c4' />
<input type="text" name="access_token" value='314bfe2e4873301797bfeb412e8e31c5' />
<input type="submit" name="po" value="send"/>
</form>

<!--
    [agentId] => 249906547
    [userid_list] => 03432952659089
    [msg] => {"msgtype":"text","text":{"content":"这是一条来自合同管理的消息"}}
    [access_token] => ca89c9f28bbc3676875e51b72f84f462
-->
</body>
</html>