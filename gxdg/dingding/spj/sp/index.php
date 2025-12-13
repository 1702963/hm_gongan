<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>替换班审批</title>
</head>
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
/*
注意，和值班提醒应用不一样

agentId 1435852882

*/

//配置接口参数 
$sdk_config_appkey="dingrtwkiqwypylddqgp";
$sdk_config_appsecret="ZjM9aEyAo0HYsJG59FE-uaB4GP25fdL_6v59-FcOBd-iRFe0lg6QIA1Ut6Yc0PLF";

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

echo $_token;
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
	 $signature=sign($_ticket['ticket'], "abcdef", $timeStamp,"http://39.104.77.131/spjzb/sp/");
 
        $config = array(
            'url' => "http://39.104.77.131/spjzb/sp/",
            'nonceStr' => "abcdef",
            'agentId' => "1435852882",   //ID不同 注意调整
            'timeStamp' => $timeStamp,
            'corpId' => 'ding479ff0f07c5cca1cf2c783f7214b6d69', //当前企业的ID
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
	
//获取值班审批角色下的用户列表
//"role_id":2426170225 自定义的审批角色ID

function shenpiuser($_token,$roleid="2426170225"){ 
$tourl="https://oapi.dingtalk.com/topapi/role/simplelist?access_token=$_token";
$data = json_encode(array('role_id'=>$roleid));
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

$shenpiarr=json_decode(shenpiuser($_token),true);
if(isset($shenpiarr['result']['list'])){
	$spuserarr=$shenpiarr['result']['list'];
	}else{
	$spuserarr[]=array("name"=>"未能获取审批人","userid"=>"");	
		}
//print_r($shenpiarr['result']['list']);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
?>
<body>

  
<script type="text/javascript">var _config = <?php echo json_encode($config, JSON_UNESCAPED_SLASHES);?></script>
<script type="text/javascript" src="../public/javascripts/zepto.min.js"></script>
<script src="//g.alicdn.com/dingding/dingtalk-jsapi/2.6.41/dingtalk.open.js"></script>   
<script type="text/javascript" src="../public/javascripts/logger.js"></script>

<style type="text/css">
@media screen and (min-width:320px) {body { font-size:75%;}}
@media screen and (min-width:360px) {body { font-size:84.4%;}}
@media screen and (min-width:375px) {body { font-size:86.6%;}}
@media screen and (min-width:400px) {body { font-size:87%;}}
@media screen and (min-width:480px) {body { font-size:112.5%;}}
@media screen and (min-width:550px) {body { font-size:131.25%;}}
@media screen and (min-width:639px) {body { font-size:150%;}}
@media screen and (min-width:1024px) {body { font-size:100%;}}

.zhiban {font-size:1.8em;border-left:1px solid #ccc;border-top:1px solid #ccc}
.zhiban td {border-right:1px solid #ccc;border-bottom:1px solid #ccc;line-height:2;padding:.5em 0}
.zhiban td span {margin-left:.2em}
.zhiban td h2 {font-size:1.5em;font-weight:100}
.zhiban td span {margin-left:.8em}

</style>
<script type="text/javascript" src="../sdk/jquery-1.10.2.js"></script>
<script src="https://g.alicdn.com/dingding/dingtalk-jsapi/2.10.3/dingtalk.open.js"></script>
	<script>
	var myddid='';
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
			   myddid=obj.userid;
			   $.post("../dapi/getmyrole.php",{userid:obj.userid,atoken:"<?php echo $_token?>"}, function(data) {
                     var obj2 = JSON.parse(data);
					 if(obj2.error=="1"){
						//$("#heyan").hide();
						//$("#anniu").show(); 
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
 //   alert(dd.version)
dd.device.base.getPhoneInfo({
    onSuccess : function(data) {
     $("#isadmin").hide();	
    },
    onFail : function(err) {alert(err)}
})	
	</script>

 
<table width="100%" cellpadding="0" cellspacing="0" class="guanli" style="display:" id="isadmin">
  <tr id="heyan" style="display:none">
    <td colspan="2" align="center"><h2>管理权限核验中,请稍候....</h2></td>
  </tr>
  <tr id="anniu" style="display:none">
    <td colspan="2" align="center"><h2><a href="admin/"><input type="button" value="管理入口" style="width:70%;font-size:100%"/></a></h2></td>
  </tr>
  <tr id="heyan2">
    <td colspan="2" align="center"><h2><a href="splist.php"><input type="button" value="我的审批" style="width:70%;font-size:100%"/></a></h2></td>
  </tr>  
</table> 

<table width="100%" cellpadding="0" cellspacing="0" class="zhiban">
         <tr class="tabhover" >	
			<td width="15%"  align="center" style="border-right:none">* 选择您要换班或替班的日期</td>
            <td  width="33%" align="center" ><input type="button" value="选择值班日期" onclick="getmyzb(myddid)" style="font-size:100%"  doed="0" id="rqxz"/></td>
         </tr>   	
         <tr class="tabhover" id="daylist" style="display:none">	
			<td colspan="2" align="left" id="listdiv" style="padding-left:30px ;">&nbsp;</td>
         </tr> 
         <tr class="tabhover" id="dolist" style="display:none">	
			<td colspan="2" align="left" id="listdiv" style="padding-left:30px ;"> 
            <select style="font-size:100%" id="sqlx" onchange="shownext(this.value)">
             <option value="">选择申请类型</option>
             <option value="0">换班</option>
             <option value="1">替班</option>
            </select>&nbsp;
            <?php 
			   $nowdat=date("Y-m-d");
			?>
            <select onchange="gettozb(this.value)" style="font-size:100%;display:none" id="thbrq" >
              <option value="">选择替换班日期</option>
              <?php 
			    for($i=0;$i<=10;$i++){
				$t_day=strtotime("+$i day");	
			  ?>
              <option value="<?php echo strtotime(date("Y-m-d",$t_day))?>"><?php echo date("Y-m-d",$t_day)?></option>
              <?php } ?>
            </select> 
            </td>
         </tr> 
         <tr class="tabhover" id="todaylist" style="display:none">	
			<td colspan="2" align="left" id="tolistdiv" style="padding-left:30px ;">&nbsp;</td>
         </tr>  
         <tr class="tabhover" id="splist" style="display:none">	
			<td colspan="2" align="left" id="listdiv" style="padding-left:30px;"><span style="float:left">替换班原因:</span> <div id="liyou" contenteditable="true" style="float:left; width:99%; border:#FC9 1px solid "></div></td>
	     </tr> 
         <tr class="tabhover" id="tijiao" style="display:none">	
			<td colspan="2" align="left" id="listdiv" style="padding-left:30px;"><span style="float:left">审批人 <select style="font-size:100%">
             <?php foreach($spuserarr as $v){?>
             <option value="<?php echo $v['userid']?>"><?php echo $v['name']?></option>
             <?php }?>
             </select></span> &nbsp; <input type="button" value="发起申请" style="font-size:100%" onclick="dome()"/></td>
	     </tr>                                    
</table>
<form action="" method="post">
<input name="fpbid" id="fpbid" value="" />
<input name="tpbid" id="tpbid" value="" />
<input name="dotype" id="dotype" value="" />
<input name="liyou" id="liyou" value="" />
<input name="spuserid" id="spuserid" value="" />
<input name="spusername" id="spusername" value="" />
</form>

<script language="javascript">
function getmyzb(myid){
 if($("#rqxz").attr("doed")=="0"){
	  $.post("dapi/getmyday.php",{userid:myid}, function(data) {
                //alert(data)
			    var obj = JSON.parse(data);
				$("#daylist").show();
				$("#dolist").hide();
				$("#todaylist").hide();
				$("#splist").hide();
                if(obj.error==0){
					instrs="";
					for(i=0;i<obj.dats.length;i++){
					 instrs+='<li style="list-style:none" id="l'+i+'" maxme="'+obj.dats.length+'" checkme="0" value="'+obj.dats[i]['id']+'" onclick="selme(\''+i+'\',\''+obj.dats.length+'\')"><label><span>'+obj.dats[i]['dayname']+'</span><span>'+obj.dats[i]['banci']+'</span></label></li>';	
						}
					$("#listdiv").html(instrs);	
					$("#rqxz").attr("doed","1");					
					}else{
					$("#listdiv").html(obj.error);
					$("#daylist").hide(5000);	
				}			
          });
    }
}
	
function gettozb(days){
   if(days!=''){
	  $.post("dapi/getmyday2.php",{days:days}, function(data) {
               // alert(data)
			    var obj = JSON.parse(data);
				$("#todaylist").show();
                if(obj.error==0){
					instrs="";
					for(i=0;i<obj.dats.length;i++){
					 instrs+='<li style="list-style:none" id="tl'+i+'" maxme="'+obj.dats.length+'" checkme="0" value="'+obj.dats[i]['id']+'" onclick="tselme(\''+i+'\',\''+obj.dats.length+'\')"><label><span>'+obj.dats[i]['dayname']+'</span><span>'+obj.dats[i]['uname']+'</span><span>'+obj.dats[i]['banci']+'</span></label></li>';	
						}
					$("#tolistdiv").html(instrs);						
					}else{
					$("#tolistdiv").html(obj.error);
					$("#todaylist").hide(5000);	
				}			
          });
     }
	}	
	//03432952651047451
function selme(objid,objnum){
    $("#dolist").show();
	//类似单选框
	for(j=0;j<objnum;j++){
	    $("#l"+j).attr('checkme','0');			
		$("#l"+objid).attr('checkme','1');
	}
			
	for(j=0;j<objnum;j++){
		if($("#l"+j).attr('checkme')=="0"){
		 $("#l"+j).css("background-color","#FFF");
		}else{
		 $("#l"+j).css("background-color","#3FF");	
			}
		}
					
	}

function tselme(objid,objnum){
    $("#splist").show();
	$("#tijiao").show();
	//类似单选框
	for(j=0;j<objnum;j++){
	    $("#tl"+j).attr('checkme','0');			
		$("#tl"+objid).attr('checkme','1');
	}
			
	for(j=0;j<objnum;j++){
		if($("#tl"+j).attr('checkme')=="0"){
		 $("#tl"+j).css("background-color","#FFF");
		}else{
		 $("#tl"+j).css("background-color","#3FF");	
			}
		}
					
	}	
	
function dome(){
	if($("#sqlx").val()!=''){
		// fpbid tpbid dotype liyou spuserid spusername	
		$("#fpbid").val()
		}
	}

function shownext(objval){
	if(objval!=""){
		$("#thbrq").show();
	}else{
		$("#thbrq").hide();
		$("#todaylist").hide();
		$("#splist").hide();
		$("#tijiao").hide();
		}
}				
</script>
</body>
</html>