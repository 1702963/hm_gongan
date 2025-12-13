<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>高新分局“明镜”智管平台</title>
<script language="javascript" type="text/javascript" src="statics/js/jquery.min.js"></script>
<script src="statics/js/scrollReveal.js"></script>
<style type="text/css">
    *{margin:0;padding:0}
	html {height:100%;}
	body {margin:0;padding:0;height:100%;color:#ccc;position:relative;background:#155cff}

	/*#loginBg {width:100%;height:100%;background:url(statics/images/admin_img/2025/loginbg.jpg) center center no-repeat;position:fixed;top:0;left:0;z-index:1;filter:brightness(0.5)}*/
	

	.video-background {
     max-width: none !important;
     border: none; object-fit: cover;   background-size: cover;
     opacity: 1; width: 100%;  height: 100%;
     position: absolute; left: 0px; top: 0%; display: block;
     object-position: center bottom !important;
     z-index:-1; opacity:0.9
	}
	.loginTop {width:100%;height:180px;position:absolute;top:0;left:0;z-index:9;background:url(statics/images/admin_img/2025/loginTop.png) center 0 no-repeat}
	.loginBottom {width:100%;height:350px;position:absolute;bottom:0;left:0;z-index:9;background:url(statics/images/admin_img/2025/loginBottom.png) center bottom no-repeat}
	
	#loginName {width:500px;height:60px;position:absolute;left:50%;margin-left:-270px;top:50%;margin-top:-250px;overflow:hidden;z-index:11;background:url(statics/images/admin_img/2025/name.png) center center no-repeat}
	#new_login {width:600px;height:480px;position:absolute;left:50%;margin-left:-320px;top:50%;margin-top:-200px;overflow:hidden;z-index:11;background:url(statics/images/admin_img/2025/login.png) center center no-repeat }
	#new_login .mask {width:640px;height:480px;position:absolute;top:0;left:0;z-index:2;background:rgba(0,0,0,0.5)}
	div{overflow:hidden; *display:inline-block;}div{*display:block;}
	input {border-radius:2px;outline:none}
	input[type=text] , input[type=password] {transition: box-shadow 0.3s ease;}
	input[type=text]:focus , input[type=password]:focus , input[type=text]:hover , input[type=password]:hover {border:1px solid #fff;box-shadow: 0 0 10px rgba(155, 255, 255, 1.0);}
	#new_login form {position:absolute;top:120px;left:90px;z-index:3}
	#new_login .ipt{height:40px; width:420px; color:#ccc; border:1px solid #273b94;background:rgba(0,0,0,0.25); *line-height:40px; color:#92c2ff; overflow:hidden;margin-bottom:20px;text-indent:6px;font-size:16px;letter-spacing:2px;float:left}
	#new_login b {width:100%;height:36px;line-height:36px;display:block;color:#92c2ff;font-size:16px;font-family:microsoft yahei;clear:both}
	.login_tj_btn{ background:#87b910; width:420px; height:36px; line-height:36px;border:none; cursor:pointer; padding:0px; color:#fff; font-size:16px; margin-top:10px;float:left;clear:both;overflow:hidden;transition: all .2s ease-in-out}
	.login_tj_btn:hover {background:#06c;box-shadow: 0 0 8px rgba(100, 200, 255, 1);}
	#new_login h3 {font-size:20px;font-weight:100;color:#06c;line-height:30px;position:absolute;top:10px;left:40px;z-index:3}
	#new_login h2 {font-size:32px;font-weight:100;color:#06c;line-height:30px;position:absolute;top:40px;left:40px;z-index:3}
	#new_login form p {width:420px;height:50px;display:block;line-height:60px;font-size:12px;text-align:center;color:#ccc;float:left;_text-indent:-40px;padding:0;margin:0}
   	#loader { width:100%; height:100vh; background:#1d1e72; position:fixed; top:0; left:0; z-index:9999; display:flex; justify-content:center; align-items:center }
	#loader span { animation: rotate .2s infinite }
	@keyframes rotate {
	  0% { opacity: 0.5 }
	  50% {	opacity: 1.0 }
	  100%{	opacity: 0.5  }
	}
	@keyframes toBody {
		0% { opacity:0 }
		100% {opacity:1.0}
	}
	@keyframes bgChange {
		from {filter:brightness(0.1)} /* 开始状态 */
		to {filter:brightness(1)} /* 结束状态 */
	  }
	.animatedBg {
    	animation: bgChange 1.5s forwards; /* 应用动画，持续2秒，结束后保持最终状态 */
	  }
	/*
	.infoList li {transition: all .2s ease-in-out}
	.infoList li:hover {filter:brightness(3)}
	*/
</style>
<script language="JavaScript">
<!--
	if(top!=self)
	if(self!=top) top.location=self.location;
//-->
</script>
</head>

<body onload="javascript:document.myform.username.focus();">
<div id="loader"><span>加载中</span></div>
<div id="loginName" data-scroll-reveal="wait 1.3s enter bottom"></div>
<div id="new_login" data-scroll-reveal="wait 1.5s enter top">
    <form action="index.php?m=admin&c=index&a=login&dosubmit=1" method="post" name="myform">
        <b>用户名</b>
        <input name="username" type="text" class="ipt" value="" autocomplete="off"  required  oninvalid="setCustomValidity('请填写用户名');" oninput="setCustomValidity('');" />
        <b>密码</b>
        <input name="password" type="password" class="ipt" value="" autocomplete="off"  required  oninvalid="setCustomValidity('请填写密码');" oninput="setCustomValidity('');" />
        <input name="dosubmit" type="submit" class="login_tj_btn" value="登录" />
        <p>版权所有 唐山市公安局高新分局 &copy;2020&nbsp;&nbsp;&nbsp; 技术支持：唐山赫鸣科技</p>
    </form>
   
</div>

<video autoplay="autoplay" loop="loop" muted="muted" class="video-background" id="styleVideo">
<source src="statics/images/admin_img/2025/loginBg.mp4" type="video/mp4">
Your browser does not support the video tag.
</video>


<script>
//初始化scrollReveal
if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))){
	(function(){
		window.scrollReveal = new scrollReveal({reset: true});
	})();
};
$(function() {
	$(window).load(function(){
		$("#loader").delay(1000).fadeOut(500);
	})		
	$("#loginBg").delay(1500).addClass('animatedBg');
})

</script>
</body>
</html>