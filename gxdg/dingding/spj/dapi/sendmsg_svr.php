<?php 
ini_set("display_errors","On");
// SEND MSG Form SERVICE

//这里检查token,写入文件缓存
require dirname(__FILE__).'/../ini/baseconfig.php';
$_token_json=require dirname(__FILE__).'/../caches/_token.cach';
$_token_setup=json_decode($_token_json,true);

if((intval(time()-$_token_setup['untime']))>7000){ //如果令牌超时

$d_sdk_api="https://oapi.dingtalk.com/gettoken?appkey=$sdk_config_appkey&appsecret=$sdk_config_appsecret";
$get_sdk= json_decode(file_get_contents($d_sdk_api),true);

    if($get_sdk['errcode']==0){
	   $_token_setup['_token']=$get_sdk['access_token'];
	   $_token_setup['untime']=time();
	}else{
	   $_token_setup['_token']="";
	   $_token_setup['untime']=0;
		}
		
    $arr_json=json_encode($_token_setup,true);  

    $outtofiles="<?php return '".$arr_json."' ?>";
	file_put_contents(dirname(__FILE__)."/../caches/_token.cach",$outtofiles);
}

//print_r($_token_setup);
//exit;

//echo json_encode(print_r($_POST,1));
//exit;

//获取用户列表
$con = mysql_connect($db_add,$db_user,$db_pass);
mysql_select_db($db_name, $con); 
mysql_query("SET NAMES UTF8");

	   $sql="select * from ".$db_tablepre."roles order by id ";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		$ulists[]=$row['uid'];   
		   } 
		if(isset($ulists)){   
		$users=implode($ulists,",");
		}else{
		 exit;	
			}


$access_token=$_token_setup['_token'];
$agentId=$sdk_config_agentId;
$userid_list=$users;
$msg=json_encode(array("msgtype"=>"text",
               "text"=>array("content"=>"周期推送消息测试,间隔5分钟，重复5次，群发集合成员".count($ulists)."。发布于".date("Y-m-d H:i:s"))
			   ));
	

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