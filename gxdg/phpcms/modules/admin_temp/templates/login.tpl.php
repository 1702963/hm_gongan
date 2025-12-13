<?php

function userBrowser() {
    $user_OSagent = $_SERVER['HTTP_USER_AGENT'];

    if (strpos($user_OSagent, "Maxthon") && strpos($user_OSagent, "MSIE")) {
        $visitor_browser = "Maxthon(Microsoft IE)";
    } elseif (strpos($user_OSagent, "Maxthon 2.0")) {
        $visitor_browser = "Maxthon 2.0";
    } elseif (strpos($user_OSagent, "Maxthon")) {
        $visitor_browser = "Maxthon";
    } elseif (strpos($user_OSagent, "MSIE 9.0")) {
        $visitor_browser = "MSIE 9.0";
    } elseif (strpos($user_OSagent, "MSIE 8.0")) {
        $visitor_browser = "MSIE 8.0";
    } elseif (strpos($user_OSagent, "MSIE 7.0")) {
        $visitor_browser = "MSIE 7.0";
    } elseif (strpos($user_OSagent, "MSIE 6.0")) {
        $visitor_browser = "MSIE 6.0";
    } elseif (strpos($user_OSagent, "MSIE 5.5")) {
        $visitor_browser = "MSIE 5.5";
    } elseif (strpos($user_OSagent, "MSIE 5.0")) {
        $visitor_browser = "MSIE 5.0";
    } elseif (strpos($user_OSagent, "MSIE 4.01")) {
        $visitor_browser = "MSIE 4.01";
    } elseif (strpos($user_OSagent, "MSIE")) {
        $visitor_browser = "MSIE 较高版本";
    } elseif (strpos($user_OSagent, "Edge")) {
        $visitor_browser = "Edge";
    } elseif (strpos($user_OSagent, "rv:11")) {
        $visitor_browser = "ie11";
    } elseif (strpos($user_OSagent, "Chrome")) {
        $visitor_browser = "Chrome";
    }else {
        $visitor_browser = "其它";
    }
    return $visitor_browser;
}
$ccc=userBrowser();
if($ccc<>'Chrome'){
	echo "该系统不支持非Chrome内核浏览器,请点击&nbsp;&nbsp;<a href='360.exe'>下载</a>&nbsp;&nbsp;安装360极速浏览器或者切换到急速模式";exit;
	}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />

<meta name="renderer" content="webkit"/>
<meta name="force-rendering" content="webkit"/>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
<title>唐山市交通警察支队公文系统</title>
<style type="text/css">
	* {margin:0;padding:0}
	html {height:100%;}
    body {height:100%;background:url(statics/images/admin_img/zb/newbg.jpg) center center no-repeat}
	form {margin:0;padding:0}
	div{overflow:hidden; *display:inline-block;}div{*display:block;}
	.login_box{background:url(statics/images/admin_img/zb/login.png) center center no-repeat; width:800px; height:480px; overflow:hidden; position:absolute; left:50%; top:50%; margin-left:-400px; margin-top:-320px;}
	.login_iptbox{color:#fff;font-size:12px;left:50%;top:50%;margin-top:-125px;margin-left:-180px;position:absolute;width:365px; height:190px; overflow:visible; background:url(statics/images/admin_img/zb/formY.png) 0 0 no-repeat}
	.ipt{height:24px; width:290px; line-height:24px; border:none; color:#000; overflow:hidden; background:none;font-size:18px;font-family:Verdana, Geneva, sans-serif }
	.ipt_u {margin-left:56px;margin-top:24px}
	.ipt_p {margin-left:56px;margin-top:60px}
	.ipt_v {margin-left:56px;margin-top:45px}
		.login_iptbox label{ *position:relative; *top:-6px;}
	.login_iptbox .ipt_reg{width:290px; height:24px; background:none; *overflow:hidden;text-align:left;padding:2px 0 2px 5px;font-size:16px;font-weight:bold;}
	.login_tj_btn{ background:url(statics/images/admin_img/zb/dowhat.png) no-repeat 0px 0px; width:363px; height:51px; border:none; cursor:pointer; position:absolute;z-index:9999;top:210px;left:0px}
	.login_tj_btn:hover { background:url(statics/images/admin_img/zb/dowhatH.png) no-repeat 0px 0px; width:363px; height:51px; border:none; cursor:pointer; padding:0px}
	.yzm{position:absolute; background:url(statics/images/admin_img/zb/login_ts140x89.gif) no-repeat; width:140px; height:89px;right:0px;top:76px; text-align:center; font-size:12px; display:none;}
	.yzm {font-family:arial}
	.yzm a:link,.yzm a:visited{color:#036;text-decoration:none;}
	.yzm a:hover{color:#C30;}
	.yzm img{cursor:pointer; margin:4px auto 7px; width:130px; height:50px; border:1px solid #fff;}
	.cy{font-size:12px;font-style:inherit;text-align:center;color:#666;width:100%; position:absolute; bottom:50px;}
	.cr{font-size:12px;font-style:inherit;text-align:center;color:#666;width:100%; position:absolute; bottom:50px;}
	.cr a{color:#ccc;text-decoration:none;}
	#loginame {width:900px;height:60px;position:absolute;left:50%;margin-left:-475px;top:50%;margin-top:-250px}
	.downloads {width:100%;height:28px;line-height:28px;text-align:center}
	.downloads a {text-decoration:none}
	.downloads a:hover {color:#F00}
	.downloads a.f00 {color:#f00}
	.downloads a.ff0 {color:#ff0}
</style>

<script language="JavaScript">
<!--
	if(top!=self)
	if(self!=top) top.location=self.location;
//-->
</script>
</head>

<body onload="javascript:document.myform.username.focus();">
<div id="login_bg" class="login_box">
	<div class="login_iptbox">
   	 <form action="index.php?m=admin&c=index&a=login&dosubmit=1" method="post" name="myform">
     <input name="dosubmit" value="" type="submit" class="login_tj_btn" />
     <input name="username" type="text" class="ipt ipt_u" value="" />
     <input name="password" type="password" class="ipt ipt_p" value="" />
     </form>
    </div>
    
    <div class="cr">唐山市交警支队</div>
</div>
</body>
</html>