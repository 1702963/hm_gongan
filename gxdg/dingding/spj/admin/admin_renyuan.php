<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>值班人员管理</title>
</head>
<?php
if($_COOKIE['isadmin']!=1){
  Header("Location:error.php");
}


$con = mysql_connect("127.0.0.1","root","2ycf4jd");
if (!$con){die("dberror");}

mysql_select_db("spjzhiban", $con); 
mysql_query("SET NAMES UTF8"); 
		   
if(isset($_POST['saveme'])){
//print_r($_POST['inarr']);

//清空人员表
$delsql="TRUNCATE TABLE zb_user";
mysql_query($delsql,$con);

 foreach($_POST['inarr'] as $inarr){
	   $t_arr=explode(",",$inarr);
	   $t1=$t_arr[0];$t2=$t_arr[1];
	   
	   $init2="INSERT INTO zb_user (uid,username)VALUES('$t1','$t2')";
	   $in2=mysql_query($init2,$con);	
        }

}
		   
		   
///////////////////////////////////////////////////////////////////////////////////
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
	 $signature=sign($_ticket['ticket'], "abcdef", $timeStamp,"http://39.104.77.131/spjzb/admin/admin_renyuan.php");
 /*
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
			);	*/

        $config = array(
            'url' => "http://39.104.77.131/spjzb/admin/admin_renyuan.php",
            'nonceStr' => "abcdef",
            'agentId' => "1333138182",   //ID不同 注意调整
            'timeStamp' => $timeStamp,
            'corpId' => "ding479ff0f07c5cca1cf2c783f7214b6d69",
            'suite_key' =>'SUITE_KEY',
            'signature' => $signature,
			'access_token'=>$_token
			);	
			
			//获取当前用户列表
	   $sql="select * from zb_user order by id";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		 $zb_u[]=$row;
		 $zb_js[]="'".$row['uid']."'"; //要输出成JS数组  
	   }	
	   
	   if(isset($zb_js)){
	    $outjs=implode(",",$zb_js);
	   }else{
		 $outjs="";  
		   }
?>
<body>
<script type="text/javascript" src="../sdk/jquery-1.10.2.js"></script>
<script src="https://g.alicdn.com/dingding/dingtalk-jsapi/2.10.3/dingtalk.open.js"></script>
<script type="text/javascript">var _config = <?php echo json_encode($config, JSON_UNESCAPED_SLASHES);?></script>
<script type="text/javascript" src="conf.js"></script>

<script language="javascript">
function getrenyuan(){
	
dd.biz.contact.choose({
    multiple: true, //是否多选：true多选 false单选； 默认true
    users: [<?php echo $outjs?>], //默认选中的用户列表，员工userid；成功回调中应包含该信息
    corpId: 'ding479ff0f07c5cca1cf2c783f7214b6d69', //企业id
    max: 500, //人数限制，当multiple为true才生效，可选范围1-1500
    onSuccess: function(data) {
	 var instr=JSON.stringify(data);
     //console.log(data)
	 //ajax入库  考虑不在此处入库，直接回写
     /* 
	   $.post("dapi/saveuser.php",{instr:instr}, function(data) {
           // $(".result").html(data);
       }); */
	  arrcount=data.length;
	  var outstr="";
	  for(i=0;i<arrcount;i++){
		 outstr+='<label style="width:90px; float:left"><input type="checkbox" id="'+i+'" name="inarr[]" value="'+data[i]['emplId']+','+data[i]['name']+'" checked="checked" />'+data[i]['name']+'</label>'; 
		  }  
		 $("#ulist").html(outstr) 	 
    },
    onFail : function(err) {
		//alert("err:"+JSON.stringify(err))
		}
})

////////////end
}
   </script>   
   
<table width="100%" border="0" align="center"> 
  <tr>
    <td width="7%" align="center" valign="top">
<table width="100%" border="0">
  <tr>
    <td height="30" valign="middle" style="padding-left:10px"> <a href="admin_banci.php" ><input type="button" value="值班班次管理" style="width:100px"/></a></td>
  </tr>
  <tr>
    <td height="32" valign="middle" style="padding-left:10px"> <a href="admin_renyuan.php" ><input type="button" value="值班人员管理" style="width:100px" /></a></td>
  </tr>
  <tr>
    <td height="35" valign="middle" style="padding-left:10px"> <a href="admin_zhiban.php"><input type="button" value="值班表管理" style="width:100px" /></a></td>
  </tr>
</table>    
    
    </td>
    <td width="93%" align="center" valign="top">
<form action="" method="post">
<table width="99%" border="0" align="center">

  <tr>
    <td  height="48" align="center" bgcolor="#d6d6d6">参与值班人员列表 &nbsp; <input type="button" value="选择人员" onclick="getrenyuan()"/> &nbsp; <input type="submit" name="saveme" value="保存设置" /></td>
    </tr>

  <tr>
    <td align="left" id="ulist">
    <?php 
	 if(isset($zb_u)){
	   foreach($zb_u as $u){	  
	?>
    <label style="width:90px; float:left"><input type="checkbox" id="<?php echo $u['id']?>" name="inarr[]" value="<?php echo $u['uid']?>,<?php echo $u['username']?>" checked="checked" /><?php echo $u['username']?></label>
    <?php }}?>
    </td>
  </tr>

</table> 
</form>   
    </td>
  </tr>
</table>
    


</body>
</html>