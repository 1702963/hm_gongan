<?php 
// SEND MSG

//echo json_encode(print_r($_POST,1));
//exit;

$access_token=$_POST['access_token'];
$agentId=$_POST['agentId'];
$userid_list=$_POST['userid_list'];
$msg=$_POST['msg'];

	
      $curl = curl_init();

      curl_setopt($curl, CURLOPT_URL, "https://oapi.dingtalk.com/topapi/message/corpconversation/asyncsend_v2?access_token=$access_token");
      
      curl_setopt($curl, CURLOPT_HEADER, 0);
	  
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	   
      curl_setopt($curl, CURLOPT_POST, 1);

     $post_data = array(
         "agent_id" => $agentId,
		 "userid_list"=> $userid_list,
		 "msg"=>$msg
         );

     curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

     $data = curl_exec($curl);
 
     curl_close($curl);


echo json_encode($data,true);

?>