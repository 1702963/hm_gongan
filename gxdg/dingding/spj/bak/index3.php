<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>实时值班表</title>
</head>
<?php
ini_set("display_errors", "Off"); 
error_reporting(7);
//SDK 的令牌和具体应用关联，同样的源码不同的APPID的令牌是不同的，一定要记着创建应用以后要初始化 

//配置接口参数 
$sdk_config_appkey="dingu5xlqkz2h3lbqj4g";
$sdk_config_appsecret="tB6r9SHHlNWpjsVIzsdJfMBd3S2hlaVeXCzV5SJvC0acIeNsJjZ1Oc26RDNi-YIx";

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

//获取 jsapi_ticket
// https://oapi.dingtalk.com/get_jsapi_ticket?access_token=ACCESS_TOKEN
$_ticket=json_decode(file_get_contents("https://oapi.dingtalk.com/get_jsapi_ticket?access_token=$_token"),true);

//编码
  function sign($ticket, $nonceStr, $timeStamp,$url)
	{
        $plain = 'jsapi_ticket=' . $ticket .'&noncestr=' . $nonceStr . '&timestamp=' . $timeStamp .'&url=' . $url;
        return sha1($plain);
    }

//拼接参数
     $timeStamp=time();
	 $signature=sign($_ticket['ticket'], "abcdef", $timeStamp,"http://39.104.77.131/gjoa/");
 
        $config = array(
            'url' => "http://39.104.77.131/gjoa/",
            'nonceStr' => "abcdef",
            'agentId' => "511681133",   //ID不同 注意调整
            'timeStamp' => $timeStamp,
            'corpId' => 'ding1c6453421efe90caa39a90f97fcb1e09',
            'suite_key' => SUITE_KEY,
            'signature' => $signature,
			'access_token'=>$_token
			);

//获取组织架构
	$_zuzhi=json_decode(file_get_contents("https://oapi.dingtalk.com/department/list?access_token=$_token"),true);	

//静态人员映射

$use_str="王小龙[023103284029196853]邓向辉[164839133936271467]张华[0354280332776238]邹永臣[101416525036496164]吕景华[215725014621519764]朱秀林[074702460526379464]刘亚男[051042500420850165]王可心[271460150229116031]陈鹏飞[240860095438267063]王万安[255968681729068077]王文娟[223121280529254211]徐怡斌[240812470024298779]郑文静[253452696836471619]张博文[223746631024089741]果冬梅[250357080626164469]张 洁[2668066519725530081]张国庆[250350182124116809]张 露[0428140806725540882]商 斌[3829641654650395270]王彩玉[132760660329212171]徐浩[1940245125786393]马立群[266736332838997413]张建波[250653425824183880]王扬帆[382323271629230565]侯振明[243719294920416686]周俊杰[141323200821424974]曹会标[270623444325987302]杨 林[2436643219788685615]马宝山[241013473338740960]王 伟[2665242850881239988]郝志伟[270040156136419525]孙立虎[270020245423481852]麻建军[382323272039824860]刘中尧[200154246220840370]熊 剑[2654011762865958023]郑树宗[270132641736476471]邢克敏[011357440136253062]吴 军[2667543802642227431]林永臣[266755130726376834]李 波[2704012239787912404]陈建忠[266819301737749870]姚金龙[016415363123302978]侯相民[143016362120575240]李 强[2667306921787908908]张建忠[266811394924180550]刘 磊[2667686744626150322]王学斌[382313024929176753]范荣利[382313025033294697]刘凤起[266813590520882475]郭金海[266836660736839283]杨 硕[0927691753788689901]赵庆瑞[240969695335580621]陈相衡[193239485837950641]李 明[5055602857787910656]郑 宇[50556028541104496918]庞 浩[0149156104721657355]王胜利[505560286129469080]杨泽昊[505560285926330645]刘洪涛[292834144221090761]王洪磊[505560286229322667]张玉良[505560285824352550]郑 伟[50556028601104493742]李凤鸣[505560286726104973]韩在生[260729372338093984]苏 斌[2607313658997668957]刘 杰[2607323634626145880]周金辉[260719514221959232]杨德熙[505560286326228266]宋伟健[505560286523169521]付 友[5055602864601354739]袁 龙[06285769301041119096]郭启强[281166412036346520]邱 涛[50556028661103548234]黄祝坤[222838253140044395]张明辉[505560285524248923]高俊伟[502716086238747501]葛小龙[245061580333332997]任 伟[0255174244602396228]张宝利[505560285624150348]王 刚[2607062208881240751]张 杰[2607146142725528656]魏 钰[3411643509-1935411105]姚晓光[266941035322937776]贾占春[266961331835435651]李宏亮[190460041026161357]王宝印[266718322229173822]常青山[165906175424403863]孙 越[2669494749696730513]王金岭[382323271829606343]刘泽武[383019161621088801]李志龙[305206100326216048]王子峰[383019161129173867]才 岩[0851135021749745980]孙丽[1004304616744964]高幸[26513642141253024]刘庆勋[266431600420967709]席晓晗[243844425024006993]杨志超[250315405626236406]李振海[251461380426229750]梁振权[266817244826523189]张振宇[2943604224212824]闫绍斌[266769094237914506]陈 坤[03611542311146173468]张 健[2701414318725522757]刘贺荣[270104512921350785]杨 震[3829641653788697759]王志伟[266824395029206259]孙喜秋[140611010323183560]刘建强[266715460420974488]张任东[270036375224049057]张积秀[193353190024401105]赵顺友[383019161436032198]孙文权[383019161323305141]刘晓江[383019161221036164]王 培[2701366418881242254]李瑞滨[274402054426366488]郝晓刚[383019161536471748]李艳君[171731263526471382]汪 涛[2229062569826879217]许 健[24176905611065616813]李霞[5115073814858512]宋风林[192415185223760212]张义明[266761306624049669]苏 健[2667504651997663542]付志刚[270216546820178427]高连锁[275453595339273915]姜泽明[254649100522997901]刘长海[276219533621410800]闫茂荣[312229264937955532]王井宇[196358034029072477]张宏庆[191534592124153079]霍思瑾[266724106037953486]许彩霞[095202396835168909]冯晓亮[266838386320927658]黄 乐[25230751601210877196]杨景凡[241051204026273466]孙 逊[2667166533696731153]曹建博[100063571726107993]王峰[2528463710940741]李学良[220859524726173335]桑 田[2645573922795630399]李志娜[255956640026198259]季祝威[383005433132158708]赵国强[143340606035515410]王文高[266735396929270780]刘国亮[085065342820906857]陆金鹏[266737004238167396]王赫赫[266719400729583915]韩立华[383005432938368140]郑宝珍[075337592236383841]江潮渤[266909211327573525]丁耀东[264556021720226013]王景伯[266928192829258603]刘晓晨[252933616521034637]李俊福[266808291126078931]董大帮[270125265233300874]杨军青[383005432826125951]孙建辉[383005433023263464]曾庆顺[240858302326126898]田志玲[172507183629620203]张秀君[240929426524390011]王纳新[240849550229456936]冯顺良[241247024121338916]张雯雯[270323374624638720]张龙[1005280125795769]乔新[5107080529647644]高山[51070804671252505]程志飞[510708052830824242]许丽莉[086515050635027620]牛健超[245031663328807515]孙振峰[443719426323283898]李 强[3830054327787908908]李淑芸[254456371226319573]王 芳[2544560938881253192]王凤友[240845045829096754]张 建[2668235009725526490]崔国涛[240860061823617106]张德华[254435145724183191]王补份[240853351729528067]李龙[2408675019860683";

$use_arr=explode("]",$use_str);
foreach($use_arr as $arrs){
 $tmparr=explode("[",$arrs);
 	$use_arrs[$tmparr[1]]=$tmparr[0];
	}

//$xb='190460041026161357';	
//echo $use_arrs[$xb];
//==================================================================================================
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

//print_r(getpaiban($_token,'26513642141253024'));
//生成班次映射
$bancis= json_decode(getpaiban($_token,'26513642141253024'),true);
foreach($bancis[result][result] as $bc){
	$banname[$bc[id]]=$bc[name];
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
curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // !!!这里不能进行编码
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
	
//print_r(json_decode(getdk($_token,'2020-03-01 00:00:00','2020-03-01 00:00:00','26513642141253024'),true));	
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
<button class="btn btn-block btn-default chooseonebtn" style="display:none">发消息</button>
<button class="btn btn-block btn-default phonecall" style="display:none">打电话</button>    
<script type="text/javascript" src="public/javascripts/logger.js"></script>
<script type="text/javascript" src="public/javascripts/demo5.js"></script>
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

.zhiban {font-size:1.2em;border-left:1px solid #ccc;border-top:1px solid #ccc}
.zhiban td {border-right:1px solid #ccc;border-bottom:1px solid #ccc;line-height:2;padding:.5em 0}
.zhiban td span {margin-left:.2em}
.zhiban td h2 {font-size:1.5em;font-weight:100}
.zhiban td span {margin-left:.8em}

</style>

<?php 
	$now_day=date('Y-m-d');
    $title_day=date("Y-m-d",strtotime("+9 day"));
?>
 
 
<table width="100%" cellpadding="0" cellspacing="0" class="zhiban">
  <tr>
    <td colspan="2" align="center"><h2><?php //echo $now_day?>  <?php //echo $title_day?> 值班表</h2></td>
  </tr>
<?php
    
	// 星期转换
	function getweeks($nowday){
	   $warrs=array("日","一","二","三","四","五","六");
	   return "(".$warrs[date("w",strtotime($nowday))].")";	
		}
 
	for($i=0;$i<10;$i++){ 
	$i_day=date("Y-m-d",strtotime("+".$i." day")); 
	$now_table= json_decode(getkaoqin($_token,$i_day),true);
	//print_r($now_table);
?>  
  

		<?php 
			if(!count($now_table[result][schedules])){
				echo "<tr><td width=24% align=center>".$i_day.getweeks($i_day)."</td>";
				echo "<td><span>无班次</span></td></tr>";
			} else {
				if($i>0){
				if($i==1){
				echo "<tr id='shlist' style='display:'><td colspan=2 align=center bgcolor=#ebfeff onclick='doshow()'><b>查看十天内的值班表</b></td></tr>";	
					}	
				echo "<tr id='".$i."' style='display:none'><td colspan=2 align=center bgcolor=#ebfeff><b>".$i_day.getweeks($i_day)."</b></td></tr>";	
					}else{
				echo "<tr id='".$i."' ><td colspan=2 align=center bgcolor=#ebfeff><b>".$i_day.getweeks($i_day)."</b></td></tr>";
					}
				foreach($now_table[result][schedules] as $banci){ //需要合并人员
		   		$barr[name]=$use_arrs[$banci[userid]];
		   		$barr[days]=$banci[plan_check_time];
				if(isset($banci[class_id])){
				 $barr[bc]=$banci[class_id];
				}else{
				 $barr[bc]=0;	
					}
		   		$banciarrs[]=$barr;
				} 
		?>
        <?php
		for($j=0;$j<count($banciarrs);){
		  $mystyle="";	
		  if($banciarrs[$j][bc]!=0){
			if(strtotime($i_day)==strtotime(date("Y-m-d"))){ 
			  $mystyle="#8080c0";
			  $thisdk= json_decode(getdk($_token,$banciarrs[$j][days],$banciarrs[$j+1][days],$banciarrs[$j][name]),true);
			  if($thisdk[recordresult][checkType]=="OnDuty"){
				  $mystyle="#00ff80";
				  }
			}
		 ?>
         <tr class="tabhover" <?php if($i>0){?>style='display:none'<?php }?> >	
			<td width="24%" align="center"><?php echo $banciarrs[$j][name] ?> </td>
            <td align="left" style=" padding-left:1em;background-color:<?php //echo $mystyle ?>"><?php echo $banname[$banciarrs[$j][bc]];/*echo date("m月d日 H:i",strtotime($banciarrs[$j][days]))." 至 ".date("m月d日 H:i",strtotime($banciarrs[$j+1][days]));*/ ?><?php if($mystyle=='#00ff80'){?><span style="display:inline; background-color:#06C; color:#FFF; padding:0 .5em .1em .5em; border-radius:.4em">在岗</span><?php }?></td>
         </tr>   
		<?php }	
		 $j=$j+2; 
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
    function doshow(){
		$("#shlist").hide()
		for(tr=1;tr<10;tr++){
			$("#"+tr).show(800)
			}
		$(".tabhover").show(800)  	
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