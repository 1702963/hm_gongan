<?php 
ini_set("display_errors", "off"); 
//error_reporting(7);
date_default_timezone_set("PRC");

//配置接口参数 
$sdk_config_appkey="ding5nbyeyncwfi2acoz";
$sdk_config_appsecret="8RZd6pzofta5FFHD08O-bPbflWYPSIg3VAGd2bQQg9-HhGzHyTuGYE2f2dzjo_B5";

//接口串
$d_sdk_api="https://oapi.dingtalk.com/gettoken?appkey=$sdk_config_appkey&appsecret=$sdk_config_appsecret";


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
	
	
$_ticket=json_decode(file_get_contents("https://oapi.dingtalk.com/get_jsapi_ticket?access_token=$_token"),true);

//编码
  function sign($ticket, $nonceStr, $timeStamp,$url)
	{
        $plain = 'jsapi_ticket=' . $ticket .'&noncestr=' . $nonceStr . '&timestamp=' . $timeStamp .'&url=' . $url;
        return sha1($plain);
    }
	
//var_dump($_token);	
	
//$_zuzhi=json_decode(file_get_contents("https://oapi.dingtalk.com/department/list?access_token=$_token"),true);	

//$_kaoqin=json_decode(file_get_contents("https://oapi.dingtalk.com/topapi/attendance/listschedule?access_token=$_token"),true);

//打卡数据

function getdk($_token,$datefor,$dateto,$dateuser){ 
$tourl="https://oapi.dingtalk.com/attendance/list?access_token=$_token";
$data = json_encode(array('workDateFrom'=>$datefor,'workDateTo'=>$dateto,'userIdList'=>$dateuser,'offset'=>0,'limit'=>50));
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


/// 打卡数据
//$daka=getdk($_token,"2025-08-01 00:00:00","2025-08-05 00:00:00",array('172136285438195526','265208570329262300'));

//print_r(json_decode($daka,true));
//exit;

////////////////////////////////////////////////////////////////////////////////////
function getusers($_token,$bmids,$youbiao=0,$size=100){ 
$tourl="https://oapi.dingtalk.com/topapi/v2/user/list?access_token=$_token";
$data = json_encode(array('dept_id'=>$bmids,'cursor'=>$youbiao,'size'=>$size)); 
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

$_outs = curl_exec($curl); // 执行操作
if (curl_errno($curl)) {
    $_outs= 'Errno'.curl_error($curl);//捕抓异常
}
curl_close($curl); 

return $_outs;	
	}



//======================================================
//$doit=getusers($_token,'340292163');


//print_r(json_decode($doit,true));	
//exit;

/////////////////////////////////////////////////////////////////////////////////////////////
//数据库连接
$con = mysql_connect("127.0.0.1","root","2ycf4jd");
if (!$con) { die(); }
mysql_select_db("gxdb", $con); 
mysql_query("SET NAMES UTF8"); 
/////////////////////////////////////////////////////////////////////////////////////////////
/*

       //部门表
	   $sql="select ddid,name from bumen ";
	   $rs=mysql_query($sql,$con);
       while($row = mysql_fetch_array($rs)){
		   $getit=getusers($_token,$row['ddid']);
		   unset($_arr);//其实没必要
		   $_arr=json_decode($getit,true);
		   if($_arr['errcode']==0){ //if 1
		   //这个接口有递归，不按递归处理，仅取两页	   
		   foreach($_arr['result']['list'] as $v){ //foreach 1
			   $_name=$v['name'];
			   $_duid=$v['userid'];
			   $_uuid=$v['unionid'];
			   $_bmid=$row['ddid'];
			   $_bmname=$row['name'];
			     
				 //要处理一人在多部门的情况
				 $csql="select count(*) as hj from user where did='".$_duid."'";
	             $crs=mysql_query($csql,$con);
                 $crow = mysql_fetch_array($crs);
				 if($crow[0]['hj']==0){ //if 4 
				 //插入表
                 $init="INSERT INTO `user`(bmname,uname,un2,did,uuid,bmid) VALUES ('$_bmname','$_name','$_name','$_duid','$_uuid','$_bmid')";
			     $inrs=mysql_query($init,$con);
				 } //end if4
			   
			   } //end foreah1
			   
			if($_arr['result']['has_more']==1){ //if 2   
			   $getit=getusers($_token,$row['ddid'],$_arr['result']['next_cursor']);
			   unset($_arr);
			   $_arr=json_decode($getit,true);
		         if($_arr['errcode']==0){ //if 3
		           foreach($_arr['result']['list'] as $v){ //foreach2 
			         $_name=$v['name'];
			         $_duid=$v['userid'];
			         $_uuid=$v['unionid'];
			         $_bmid=$row['ddid'];
			         $_bmname=$row['name'];
				 //插入表
	             				 $csql="select count(*) as hj from user where did='".$_duid."'";
	             $crs=mysql_query($csql,$con);
                 $crow = mysql_fetch_array($crs);
				 if($crow[0]['hj']==0){ //if 5 
                  $init="INSERT INTO `user`(bmname,uname,un2,did,uuid,bmid) VALUES ('$_bmname','$_name','$_name','$_duid','$_uuid','$_bmid')";
			      $inrs=mysql_query($init,$con);
				 } //end if5
			   
			   } //end foreah2			   
			  } //end if3
			} // end if2
		   } //end if 1
		 } //end while 
	
	echo "dook";
*/

///////////////////////
//打卡数据
       //这还挺麻烦呢
	   //接口最多每次只接受50人列表，所以需要按批次返回，本处预设二维数组
	   $sql="select count(*) as hj from gxuser ";
	   $rs=mysql_query($sql,$con);
       $row = mysql_fetch_array($rs);	   
	   $zong=$row['hj'];
	   //等于分页
	   $page=intval($zong/50);
	   if($zong%50>0){
		   $page+=1;
		   }
	   
	   //echo $page;
	   
	   
	   for($i=0;$i<$page;$i++){
		 if($i>0){
			$s=$i*50; 
			 }else{
			$s=0;	 
				 }
		   
	     $sql="select * from gxuser limit $s,50 ";
	     $rs=mysql_query($sql,$con);
         while($row = mysql_fetch_array($rs)){
		    $dids[$i][]=$row['did'];
			$usr[$row['did']]=$row['uname'];
	      }
	   }
	
	//==================================================================
	//跑数组，获取本月全员打卡数据
	//麻烦 接口最多只返回7天数据，还是得每天都同步，不能一次拉一个月
	//$_sday=date("Y-m-d")." 00:00:00";
	//$_eday=date('Y-m-d')." 23:59:59";
	
	$_sday="2025-08-20 00:00:00";
	$_eday="2025-08-20 23:59:59";	
	
	$_ns=date("Y",strtotime($_sday));
	$_ms=date("m",strtotime($_sday));
	$_ds=date("d",strtotime($_sday));
	
    $_zt2=array("Normal"=>"正常","Early"=>"早退","Late"=>"迟到","SeriousLate"=>"严重迟到","Absenteeism"=>"旷工迟到","NotSigned"=>"未打卡");	
	foreach($dids as $k=>$v){
	
	$daka=getdk($_token,$_sday,$_eday,$v);
	$_arr=json_decode($daka,true);
	
		         if($_arr['errcode']==0){ //if 1
		           foreach($_arr['recordresult'] as $v){ //foreach 
                      $ddid=$v['userId'];
                      $name=$usr[$v['userId']];
                      $sdt=$_sday;
                      $edt=$_eday;
                      $wday=$v['workDate'];
					  $wday2=intval($v['workDate']/1000);
                      $dkday=$v['userCheckTime'];
					  $dkday2=intval($v['userCheckTime']/1000);
                      $kqz=$v['groupId']; 
                      $dzzt=$v['timeResult'];
					  $zt2=$_zt2[$dzzt];
                      $dklx=$v['checkType'];
                      $pbid=$v['planId'];
                      $ns=$_ns;
                      $ms=$_ms;
                      $ds=$_ds;

				 //插入表
                  $init="INSERT INTO `dklog`(ddid,name,sdt,edt,wday,dkday,kqz,dzzt,dklx,pbid,ns,ms,ds,zt2,wday2,dkday2) VALUES ('$ddid','$name','$sdt','$edt','$wday','$dkday','$kqz','$dzzt','$dklx','$pbid','$ns','$ms','$ds','$zt2','$wday2','$dkday2')";
			      $inrs=mysql_query($init,$con);
				   } //end foreach
				 } //end if1
	
	echo "dook<br>";
	//print_r($_arr);
	
	}
?>