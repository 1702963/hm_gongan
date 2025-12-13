<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>实时值班表</title>
</head>
<!--引入前端JSAPI-->
<?php
ini_set("display_errors", "On"); 
//error_reporting(7);
date_default_timezone_set("PRC");
//数据库连接
$con = mysql_connect("127.0.0.1","root","2ycf4jd");
if (!$con) { die(); }
mysql_select_db("spjzhiban", $con); 
mysql_query("SET NAMES UTF8"); 


//SDK 的令牌和具体应用关联，同样的源码不同的APPID的令牌是不同的，一定要记着创建应用以后要初始化 

//配置接口参数 
$sdk_config_appkey="dingqpvsk9y5ebw4jhqo";
$sdk_config_appsecret="7gT38kevT8vqY0zpq_-O7XWRqVfbmTIZw87urhcLITPuvr0WIXmqgmchpjBRBson";

//接口串
$d_sdk_api="https://oapi.dingtalk.com/gettoken?appkey=$sdk_config_appkey&appsecret=$sdk_config_appsecret";
//echo $d_sdk_api;

//print_r($get_sdk);

//此令牌应存储至COOKIES 
//强制销毁

//setcookie("access_token", $value, time()-3600);
//$get_sdk= json_decode(file_get_contents($d_sdk_api),true); //如果令牌失效则重新生成，否则从缓存取出
//print_r($get_sdk);exit;	


if(!isset($_COOKIE['access_token'])){
    $get_sdk= json_decode(file_get_contents($d_sdk_api),true); //如果令牌失效则重新生成，否则从缓存取出
//print_r($get_sdk);	
    if($get_sdk['errcode']==0){
	setcookie("access_token", $get_sdk['access_token'], time()+7200);
	$_token=$get_sdk['access_token'];
	}else{
	$_token=$get_sdk['errmsg'];	
		}
}else{
	$_token=$_COOKIE['access_token'];
	}

//exit;

//获取 jsapi_ticket
// https://oapi.dingtalk.com/get_jsapi_ticket?access_token=ACCESS_TOKEN
$_ticket=json_decode(file_get_contents("https://oapi.dingtalk.com/get_jsapi_ticket?access_token=$_token"),true);

//print_r($_ticket);exit;

//编码
  function sign($ticket, $nonceStr, $timeStamp,$url)
	{
        $plain = 'jsapi_ticket=' . $ticket .'&noncestr=' . $nonceStr . '&timestamp=' . $timeStamp .'&url=' . $url;
        return sha1($plain);
    }

//拼接参数,这个是JSAPI用的
     $timeStamp=time();
	 $signature=sign($_ticket['ticket'], "abcdef", $timeStamp,"http://39.104.77.131/spjzb?showmenu=false");
 
        $config = array(
            'url' => "http://39.104.77.131/spjzb?showmenu=false",
            'nonceStr' => "abcdef",
            'agentId' => "1333138182",   //ID不同 注意调整
            'timeStamp' => $timeStamp,
            'corpId' => 'ding479ff0f07c5cca1cf2c783f7214b6d69', //都需要重置
            'suite_key' => 'SUITE_KEY',
            'signature' => $signature,
			'access_token'=>$_token,
			'type'=>0,
			'jsApiList'=>array('runtime.info','biz.contact.choose','device.notification.confirm','device.notification.alert','device.notification.prompt','biz.ding.post','biz.util.openLink','biz.telephone.call',
			             'biz.telephone.showCallMenu','biz.telephone.checkBizCall','biz.telephone.quickCallList')
			);

//获取组织架构
	//$_zuzhi=json_decode(file_get_contents("https://oapi.dingtalk.com/department/list?access_token=$_token"),true);	
	
	//print_r($_zuzhi);

//人员映射
			 $sql="select * from dduser ";
			 $rs=mysql_query($sql,$con);
	         while($row = mysql_fetch_array($rs)){
			   $use_arrs[$row['ddid']]=$row['dduser'];
			 }	

//$xb='190460041026161357';	
//echo $use_arrs[$xb];
//==================================================================================================
//获取考勤内容	
//$_kaoqin=json_decode(file_get_contents("https://oapi.dingtalk.com/topapi/attendance/listschedule?access_token=$_token"),true);	


function getkaoqinzu($_token){ //获取考勤组情况
$tourl="https://oapi.dingtalk.com/topapi/attendance/getsimplegroups?access_token=$_token";
$data = array('dept_id'=>1);
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

//$kapqinzu=json_decode(getkaoqinzu($_token),true);
//print_r($kapqinzu);
//组ID 756560691



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

//$now_table= json_decode(getkaoqin($_token,'2021-10-21'),true);
//print_r($now_table);exit;

//获取班次名称

function getpaiban($_token,$douser){ //这个接口需要传入操作者ID
$tourl="https://oapi.dingtalk.com/topapi/attendance/shift/list?access_token=$_token";
$data = array('op_user_id'=>$douser);
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

//print_r(getpaiban($_token,'26513642141253024'));exit;
//生成班次映射

$bancis= json_decode(getpaiban($_token,'26513642141253024'),true);
foreach($bancis['result']['result'] as $bc){
	$banname[$bc['id']]=$bc['name'];
	}
	
//print_r($banname);	

//获取打卡数据
function getdk($_token,$datefor,$dateto,$dateuser){ 
$tourl="https://oapi.dingtalk.com/attendance/list?access_token=$_token";
$data = json_encode(array('workDateFrom'=>$datefor,'workDateTo'=>$dateto,'userIdList'=>array($dateuser),'offset'=>0,'limit'=>2));
$headers = array("Content-type: application/json;charset='utf-8'");
$curl = curl_init(); // 启动一个CURL会话
curl_setopt($curl, CURLOPT_URL, $tourl); // 要访问的地址
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // !!!这里不能进行编码 支持JSON必须！！
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
	
//print_r(json_decode(getdk($_token,'2020-03-06 00:00:00','2020-03-06 00:00:00','251461380426229750'),true));	

//排班打卡情况
function getpbdk($_token,$douser,$seluser,$selday){ //这个接口需要传入操作者ID
$tourl="https://oapi.dingtalk.com/topapi/attendance/schedule/listbyday?access_token=$_token";
$data = array('op_user_id'=>$douser,'user_id'=>$seluser,'date_time'=>$selday);
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
//echo $_kaoqin;
//exit;
if (curl_errno($curl)) {
    $_kaoqin= 'Errno'.curl_error($curl);//捕抓异常
}
curl_close($curl); 

return $_kaoqin;	
	}
$cx=time()*1000;

//print_r(json_decode(getpbdk($_token,'251461380426229750','03432952651047451',$cx),true));

//参与列表的班次
$basebanci=Array(760420109,761300101,838925092,840855505,846850093,846990087);

//工作通知状态查询
function smstype($_token,$t_id){ 
$tourl="https://oapi.dingtalk.com/topapi/message/corpconversation/getsendresult?access_token=$_token";
$data = json_encode(array('agent_id'=>1333138182,'task_id'=>$t_id));
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
	

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///转译用户名

function getusername($_token,$userid){ //用ID转译用户名

$tourl="https://oapi.dingtalk.com/topapi/v2/user/get?access_token=$_token";
$data = array('userid'=>$userid);
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


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// 获取值班排班表的递归过程
//// 排班日期，token,返回数组,偏移
//// 按引用传参的时候，5.4及以上应在定义函数时进行引用声明 function foo(&$val),不能在引用时进行按引用传递

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


//$returnarr2=array();
//zbdg('2021-10-22',$_token,0,$returnarr2,$basebanci);
/*
foreach($returnarr2 as $u){
  if($u['check_type']=="OnDuty"){	
    $zhuanyis=json_decode(getusername($_token,$u['userid']),true);
	//print_r($zhuanyis);
	echo $zhuanyis['result']['name']."<br>";
  }
}

exit;
*/
//print_r($returnarr2);exit;

/// 递归结束
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
?>
<body>

<table width="70%" border="1" align="center" style="display:none">
  <tr>
    <td colspan="3" align="center">获取考勤数据   &nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td width="16%" align="center">access_token</td>
    <td colspan="2"><?php echo $_token;?></td>
  </tr>
  <tr>
    <td align="center">获取登录者</td>
    <td colspan="2"><label id="uid"></label><br><label id="uname"></label>    
    <script type="text/javascript">var _config = <?php echo json_encode($config, JSON_UNESCAPED_SLASHES);?></script>
    <script type="text/javascript" src="public/javascripts/zepto.min.js"></script>
<script src="//g.alicdn.com/dingding/dingtalk-jsapi/2.6.41/dingtalk.open.js"></script> 
<script type="text/javascript" src="public/javascripts/htgl.js"></script>   
<script type="text/javascript" src="public/javascripts/logger.js"></script>
<?php if(1==2){?>
<script src="https://g.alicdn.com/dingding/dingtalk-jsapi/2.7.13/dingtalk.open.js"></script>
<script type="text/javascript" src="public/javascripts/demo5.js"></script>
<?php }?>
<button class="btn btn-block btn-default chooseonebtn" style="display:none">发消息</button>
<button class="btn btn-block btn-default phonecall" style="display:none">打电话</button>    

</td>
  </tr>
  <tr>
    <td align="center">获取组织架构<br>
        （点组织名获取人员） 
         </td>
    <td width="42%"><?php foreach($_zuzhi['department'] as $arr){
            if(isset($arr['parentid'])){
		       if($arr['parentid']==1){
	               echo "<li style='list-style:none' onclick='showlist(".$arr['id'].")'>".$arr['name']."</li>";
				   echo showzz($_zuzhi['department'],$arr['id']);
			   }else{
				   
	            } }  
		}?></td>
    <td width="42%" valign="top" id="userlist">&nbsp;</td>
  </tr>
  <tr style="display:">
    <td align="center">考勤排班</td>
    <td colspan="2">
<?php //print_r(getkaoqin($_token));?>
    </td>
  </tr>
</table>

<style type="text/css">
@media screen and (min-width:320px) {body { font-size:75%;}}
@media screen and (min-width:360px) {body { font-size:84.4%;}}
@media screen and (min-width:375px) {body { font-size:86.6%;}}
@media screen and (min-width:400px) {body { font-size:87%;}}
@media screen and (min-width:480px) {body { font-size:112.5%;}}
@media screen and (min-width:550px) {body { font-size:131.25%;}}
@media screen and (min-width:639px) {body { font-size:150%;}}

.zhiban {font-size:1.8em;border-left:1px solid #ccc;border-top:1px solid #ccc}
.zhiban td {border-right:1px solid #ccc;border-bottom:1px solid #ccc;line-height:2;padding:.5em 0}
.zhiban td span {margin-left:.2em}
.zhiban td h2 {font-size:1.5em;font-weight:100}
.zhiban td span {margin-left:.8em}

</style>
<script type="text/javascript" src="sdk/jquery-1.10.2.js"></script>
<script src="https://g.alicdn.com/dingding/dingtalk-jsapi/2.10.3/dingtalk.open.js"></script>
	<script>
	//获取当前登录账号身份
	dd.ready(function() {	
    dd.runtime.permission.requestAuthCode({
        corpId: "ding479ff0f07c5cca1cf2c783f7214b6d69",
        onSuccess: function(result) {
        var code = result.code;
            /////       
			$.ajax({
             url : "getuserinfo.php", //后台查询验证的方法
             data :"code="+code, //携带的参数
             type : "get",
			 datatype : "json",
		     async:'false',
             success : function(msg) {
                 //根据后台返回前台的msg给提示信息加HTML
				var obj = JSON.parse(JSON.parse(msg)); //卧槽 返回的串需要转两次
			   document.cookie="loginar="+msg;
               //换取分组
			   //alert(obj.userid)
			   $.post("dapi/getmyrole.php",{userid:obj.userid,atoken:"<?php echo $_token?>"}, function(data) {
                     var obj2 = JSON.parse(data);
					 if(obj2.error=="1"){
						$("#heyan").hide();
						$("#anniu").show(); 
						 }else{
						$("#heyan").hide();	 
						}
                 });
               
             }
         });
				   
		///	   
				   
        },
        onFail : function(err) {
		alert("error: " + JSON.stringify(err));
		}
  
    });

});
	</script>

<?php 
	$now_day=date("Y-m-d",strtotime("-1 day"));;
    $title_day=date("m月d日",strtotime("+8 day"));
?>
 
<table width="100%" cellpadding="0" cellspacing="0" class="guanli" style="display:" id="isadmin">
  <tr id="heyan">
    <td colspan="2" align="center"><h2>管理权限核验中,请稍候....</h2></td>
  </tr>
  <tr id="anniu" style="display:none">
    <td colspan="2" align="center"><h2><a href="admin/"><input type="button" value="管理入口" style="width:70%; height:5vh"/></a></h2></td>
  </tr>
</table> 
<table width="100%" cellpadding="0" cellspacing="0" class="zhiban">

<?php
    
	// 星期转换
	function getweeks($nowday){
	   $warrs=array("日","一","二","三","四","五","六");
	   return "(".$warrs[date("w",strtotime($nowday))].")";	
		}
 
	for($i=0;$i<10;$i++){
	if($i==0){$idays="-1";}else{$idays="+".$i-1;}	 
	$i_day=date("Y-m-d",strtotime($idays." day")); 
	//$now_table= json_decode(getkaoqin($_token,$i_day),true);
	//print_r($now_table);
	$now_table=array();
	zbdg($i_day,$_token,0,$now_table,$basebanci);
	//print_r($now_table);exit;
	//通知状态回调
	unset($reads);
	if($i<3){
			 //取出数据库
			 $js_dt=strtotime($i_day)-86400;
			 $sql="select * from sms where senddt=".$js_dt." order by id desc limit 1 ";
			 //echo $sql;
			 $rs=mysql_query($sql,$con);
	         $row = mysql_fetch_array($rs);	
			 if(is_array($row)){
			   $reads=json_decode(smstype($_token,$row['smsid']),true);	 
			   //print_r($reads);
			 }	 				 	
		}
?>  
  

		<?php 
			if(!count($now_table)){
				echo "<tr><td width=24% align=center>".$i_day.getweeks($i_day)."</td>";
				echo "<td><span>无班次</span></td></tr>";
			} else {
				if($i>1){
				if($i==2){
				echo "<tr id='shlist' style='display:'><td colspan=2 align=center bgcolor=#ebfeff onclick='doshow()'><b>查看至".$title_day."的值班表</b></td></tr>";	
					}	
				echo "<tr id='".$i."' style='display:none'><td colspan=2 align=center bgcolor=#ebfeff><b>".$i_day.getweeks($i_day)."</b></td></tr>";	
					}else{
				  if($i==0){
					   $onejs="onclick='showone()'";
					}else{
					   $onejs="";	
						}		
				echo "<tr id='".$i."' ".$onejs."><td colspan=2 align=center bgcolor=#ebfeff><b>".$i_day.getweeks($i_day)."</b></td></tr>";
					}
				foreach($now_table as $banci){ 
                  if(!isset($use_arrs[$banci['userid']])){
                    $renyuanzhuanyi=json_decode(getusername($_token,$banci['userid']),true); //接口转译
				    $tmpuser=$renyuanzhuanyi['result']['name'];
					$tmpddid=$banci['userid'];
					$use_arrs[$tmpddid]=$tmpuser; //立刻更新映射结构，防止特殊情况下造成冗余入库
					//插入缓存表
	                 $init="INSERT INTO dduser (ddid,dduser)VALUES('$tmpddid','$tmpuser')";
	                 $in=mysql_query($init,$con);						
				  }
				  $barr['noshow']=0; //不需要这个标记了，为了保证结构不变不做处理				
		   		  $barr['name']=$use_arrs[$banci['userid']];
				  $barr['userid']=$banci['userid'];
		   		  $barr['days']=$banci['plan_check_time'];
				  $barr['bc']=$banci['class_id'];
				    $banciarrs[]=$barr;
					unset($barr);
					
				} //foreach end
				
				unset($now_table); //销毁中间结构，因为是按引用传值的
				
				//var_dump($banciarrs);exit;
//此处排序
/*Array
(
    [458420375] => 值班员上午 4
    [534545623] => 值班员下午 6
    [540535340] => 节假日晚班 12 
    [540655138] => 工作日晚值班 10 
    [542690558] => 带班白班 0
    [565490035] => 带班晚班 2
    [573225460] => 正常上班 
	[586650134] => 节假日白班 8
	
{"id":760420109,"name":"带班领导节假日值班"} 08:30-次日08:30   2
{"id":761300101,"name":"休息日夜班值班"} 18:00-次日08:30       10
{"id":838925092,"name":"休息日白天值班"} 08:30-18:00          4
{"id":840855505,"name":"带班领导工作日夜班"} 17:00-次日08:30  0
{"id":846850093,"name":"工作日员工夜班值班"} 17:00-次日08:30   6 
{"id":846990087,"name":"中午值班"} 12:00-13:00               8  
	
)*/				
				//7个班次共14个成员，考虑给指定班次设置固定的排序权重，权重作为
				//排序中间数组的下标，遇到未用到的班次则对应下标成员为空，然后删除
				//中间数组的空成员之后重新插入下标连续的数组完成排序，这不是个通用排序算法
				// TMD 馒头比屉还大
				
				//需要先清理掉不显示的成员
				for($px=0;$px<count($banciarrs);$px++){
					 $tmps1[$px]=$banciarrs[$px];	
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
				/*
				for($px=0;$px<count($banciarrs);){
					if($banciarrs[$px]['bc']==840855505){
						$banciarrses[0]=$banciarrs[$px];
						}
					if($banciarrs[$px]['bc']==760420109){
						$banciarrses[1]=$banciarrs[$px];
						}
					if($banciarrs[$px]['bc']==838925092){
						$banciarrses[2]=$banciarrs[$px];
						}
					if($banciarrs[$px]['bc']==846850093){
						$banciarrses[6]=$banciarrs[$px];
						$banciarrses[7]=$banciarrs[$px+1];
						}
					if($banciarrs[$px]['bc']==846990087){
						$banciarrses[8]=$banciarrs[$px];
						$banciarrses[9]=$banciarrs[$px+1];
						}
					if($banciarrs[$px]['bc']==761300101){
						$banciarrses[10]=$banciarrs[$px];
						$banciarrses[11]=$banciarrs[$px+1];
						}																																					
					 $px=$px+2;	
					}*/
					//ksort($banciarrses);
					$banciarrses=$banciarrs;
					//print_r($banciarrses);
					
					//清理中间数据，生成结果数组
					$px=0;
					unset($banciarrs);
					foreach($banciarrses as $aa){
						$banciarrs[$px]=$aa;
						$px++;
						}
                    unset($banciarrses);  
						
		?>
        <?php
		//print_r($banciarrses);	
	    // exit;
		 
		//此处进行班次判断
		 	
		for($j=0;$j<count($banciarrs);){
		
		  $mystyle="";	
		  $zt_str="";
		  //if($banciarrs[$j][bc]!=0 /*and $banciarrs[$j][bc]!='573225460'*/){   /*此处修改判断方法*/
		 if(in_array($banciarrs[$j]['bc'],$basebanci) && $banciarrs[$j]['noshow']==0){
			if(strtotime($i_day)<=strtotime(date("Y-m-d"))){ 
			 /* 跟更换接口
			  $mystyle="#06C";
			  $dk_day1=date("Y-m-d",strtotime($banciarrs[$j][days]))." 00:00:00";
			  $dk_day2=date("Y-m-d",strtotime($banciarrs[$j+1][days]))." 00:00:00";
			  $thisdk= json_decode(getdk($_token,$dk_day1,$dk_day2,$banciarrs[$j][userid]),true);
			  //print_r($thisdk);
			  if($thisdk[recordresult][0][checkType]=="OnDuty"){
				    if($thisdk[recordresult][0][timeResult]=="Normal"){
				     $mystyle="#06C";
					 $zt_str="到岗";
				    }
	                if($thisdk[recordresult][0][procInstId]!=""){
				     $mystyle="#b1da36";
					 $zt_str="假勤";						
					}
				  }
			   */
			 
			 $dk_day=strtotime($i_day)*1000;
			 $thisdk=json_decode(getpbdk($_token,'251461380426229750',$banciarrs[$j]['userid'],$dk_day),true);
			 //print_r($thisdk);exit;
			   //==========================================================
			   $dkindex=0;//默认一个打卡记录的索引
			      /*
				  if($banciarrs[$j]['bc']==838925092){//值班员上午
					  $dkindex=0;
					  }
				  if($banciarrs[$j]['bc']==761300101){//值班员下午
					  $dkindex=2;
					  }	
				  if($banciarrs[$j]['bc']==846850093){//工作日晚班
					  $dkindex=2;
					  }	
				  if($banciarrs[$j]['bc']==840855505){//带班晚班
					  $dkindex=2;
					  }		
				  if($banciarrs[$j]['bc']==760420109){//节假日带班
					  $dkindex=2;
					  }		
				  if($banciarrs[$j]['bc']==846990087){//中午值班
					  $dkindex=2;
					  }*/						  				  				  				   
			   //==========================================================
			  if($thisdk['result'][$dkindex]['check_type']=="OnDuty"){
				    if($thisdk['result'][$dkindex]['check_status']=="Checked"){
				     $mystyle="#06C";
					 $zt_str="到岗";
				    }
	                if(isset($thisdk['result']['$dkindex']['approve_tag_name'])){
				     $mystyle="#b1da36";
					 $zt_str=$thisdk['result'][$dkindex]['approve_tag_name'];						
					}
				  }			 
			   	  
			}
			//通知回调
			$mystyle2="";
			//print_r($reads[send_result]);
			if(isset($reads)){
			   $mystyle2="true";
			   if(in_array($banciarrs[$j]['userid'],$reads['send_result']['read_user_id_list'])){
			    $zt_str2="已读";
			    }else{
				if(in_array($banciarrs[$j]['userid'],$reads['send_result']['unread_user_id_list'])){
					$zt_str2="未读";
					}else{	
				$zt_str2="未读";
					 }
					}
			
			 }
		 ?>
         <tr class="tabhover<?php if($i==0){echo "0";}?>" <?php if($i>1 || $i==0){?>style='display:none'<?php }?> >	
			<td width="24%" align="center" onclick="sendtel('<?php echo $banciarrs[$j]['userid']?>')"><img src="img/tel.jpg" width="30"/><?php echo $banciarrs[$j]['name'] ?> </td>
            <td align="left" style=" padding-left:1em;background-color:<?php //echo $mystyle ?>"><?php echo $banname[$banciarrs[$j]['bc']];/*echo date("m月d日 H:i",strtotime($banciarrs[$j][days]))." 至 ".date("m月d日 H:i",strtotime($banciarrs[$j+1][days]));*/ ?><?php if($mystyle2!=''){?><span style="display:inline; background-color:#b1da36; color:#FFF; padding:0 .5em .1em .5em; border-radius:.4em"><?php echo $zt_str2?></span><?php }?><?php if($mystyle!=''){?><span style="display:inline; background-color:<?php echo $mystyle?>; color:#FFF; padding:0 .5em .1em .5em; border-radius:.4em"><?php echo $zt_str?></span><?php }?></td>
         </tr>   
		<?php  
		  }	
		 $j++; 
		 	}	 ?>
	
	<?php unset($banciarrs);}?></td>

<?php }?>   
</table>


<?php

		

function showzz($zz_arr,$cj){ //此处待做递归处理
 if(is_array($zz_arr)){
	foreach ($zz_arr as $zz) {
	   if($zz['parentid']==$cj){
	   $jiegou.= "<li style='list-style:none;margin-left:10px' onclick='showlist(".$zz['id'].")'>".$zz['name']."</li>";
	   }
	} 
  }
  return $jiegou; 	
}
?>
<script language="javascript">
/*
dd.error(function(error){
       /**
        {
           errorMessage:"错误信息",// errorMessage 信息会展示出钉钉服务端生成签名使用的参数，请和您生成签名的参数作对比，找出错误的参数
           errorCode: "错误码"
        }
       **/
    //   alert('dd error: ' + JSON.stringify(error));
//});

function sendtel(num){
if(num.length<1){
	dd.device.notification.alert({
    message: "未指定通话对象",
    title: "错误",//可传空
    buttonName: "关闭",
    onSuccess : function() {
        //onSuccess将在点击button之后回调
        /*回调*/
    },
    onFail : function(err) {}
   });//alert end	
 return false;
	}

var nums = new Array();
nums[0]=num

  dd.biz.telephone.call({
    users: nums, 
    corpId: _config.corpId, 
    onSuccess : function() {
      //alert("ok");
    },
    onFail : function(err) {

	dd.device.notification.alert({
    message: err,
    title: DEBUG,//可传空
    buttonName: "关闭",
    onSuccess : function() {
        //onSuccess将在点击button之后回调
        /*回调*/
    },
    onFail : function(err) {}
   });//alert end
    
	}
  })
}

    function doshow(){
		$("#shlist").hide()
		for(tr=2;tr<10;tr++){
			$("#"+tr).show(800)
			}
		$(".tabhover").show(800)  	
		}

    function showone(){
		$(".tabhover0").toggle()  	
		}

    function showlist(zzid){
            $.ajax({
                url: 'dapi/getuser.php',
                type:"POST",
                data: {"event":"get_userlist","department_id":zzid,"corpId":_config.corpId,"access_token":"<?php echo $_token?>"},
                dataType:'json',
                timeout: 900,
                success: function (data, status, xhr) {
                   //alert(data);
                    var info = data;
                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }

                    if (info.errcode === 0) {
						lists=""
						for(i=0;i<info.userlist.length;i++){
						  lists+="<li style='list-style:none;margin-left:10px'>"+info.userlist[i]['name']+"["+info.userlist[i]['userid']+"]</li>"
						}
						if(lists==''){lists='无成员'}
						$("#userlist").html(lists);
                    }
                    else {
                        logger.e('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    logger.e(errorType + ', ' + error);
                }
            });
	}
</script>
</body>
</html>