<?php defined('IN_ADMIN') or exit('No permission resources.'); 

//判断是否需要左边栏
$showleft="";
if($_GET['m']="admin" && $_GET['index']==""){
	//$showleft="display:none";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="off">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>高新区公安分局“明镜”系统</title>
<link href="<?php echo CSS_PATH?>reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH.SYS_STYLE;?>-system.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH?>dialog.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH?>style/<?php echo SYS_STYLE;?>-styles1.css" title="styles1" media="screen" />
<link rel="alternate stylesheet" type="text/css" href="<?php echo CSS_PATH?>style/<?php echo SYS_STYLE;?>-styles2.css" title="styles2" media="screen" />
<link rel="alternate stylesheet" type="text/css" href="<?php echo CSS_PATH?>style/<?php echo SYS_STYLE;?>-styles3.css" title="styles3" media="screen" />
<link rel="alternate stylesheet" type="text/css" href="<?php echo CSS_PATH?>style/<?php echo SYS_STYLE;?>-styles4.css" title="styles4" media="screen" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>styleswitch.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>dialog.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.sgallery.js"></script>
<script src="<?php echo JS_PATH?>scrollReveal.js"></script>
<script type="text/javascript">
var pc_hash = '<?php echo $_SESSION['pc_hash']?>'
</script>
<style type="text/css">
body {font-family:microsoft yahei;}

body {
    -webkit-user-select: none; /* Chrome, Opera, Safari */
    -moz-user-select: none;    /* Firefox */
    -ms-user-select: none;    /* Internet Explorer/Edge */
    user-select: none        /* 标准语法 */
}
.objbody{overflow:hidden}
.btns{background-color:#666;}
.btns{position: absolute; top:116px; right:30px; z-index:1000; opacity:0.6;}
.btns2{background-color:rgba(0,0,0,0.5); color:#fff; padding:2px; border-radius:3px; box-shadow:0px 0px 2px #333; padding:0px 6px; border:1px solid #ddd;}
.btns:hover{opacity:1;}
.btns h6{padding:4px; border-bottom:1px solid #666; text-shadow: 0px 0px 2px #000;}
.btns .pd4{ padding-top:4px; border-top:1px solid #999;}
.pd4 li{border-radius:0px 6spx 0px 6px; margin-top:2px; margin-bottom:3px; padding:2px 0px;}
.btns .pd4 li span{padding:0px 6px;}
.pd{padding:4px;}
.ac{background-color:#333; color:#fff;}
.hvs{background-color:#555; cursor: pointer;}
.bg_btn{background: url(<?php echo IMG_PATH?>admin_img/icon2.jpg) no-repeat; width:32px; height:32px;}
.header {z-index:999}
/*
.header_nav {width:640px;height:40px;margin-left:550px;display:flex;align-items:center;justify-content:center}
.header .nav {top:24px;}
.nav {
	width:20%;min-width:80px;height:40px;background-image: linear-gradient(350deg, #1d1e72 10%, #103f9c 100%);
	border:2px solid #62a8ff;box-sizing:border-box;border-radius:20px 0 20px 0;	transform: skewX(-15deg);
	float:left;	margin-right:15px;	line-height:26px;	text-align:center;	font-size:18px;	color:#fff;transition: all .2s ease-in-out
	}
.nav a {	width:100%;	height:40px; font-size:14px; display:block;	transform: skewX(15deg);	color:#d8feff;	text-decoration:none	}
.nav:hover {border:2px solid #c6edffff;background-image: linear-gradient(350deg, #1d1e72 10%, #379afdff 100%);box-shadow: 0 0 20px rgba(100, 200, 255, 1) }
.nav:hover a {color:#fff}
*/

@keyframes rotateLight {
  0% { filter:brightness(1.0) }
  50% {	filter:brightness(1.5) }
  100%{	filter:brightness(1.0)  }
}

.header_nav {width:100%;height:80px;position:relative;display:flex;justify-content: center;overflow:hidden}
.header_nav_left  {width:calc(50% - 295px); height:40px; margin-top:25px; display:flex;justify-content: flex-end}
.header_nav_center {width:590px;height:80px;background:url(statics/images/admin_img/2025/newHeadBgA.png) center 5px no-repeat}
.header_nav_right {width:calc(50% - 295px); height:40px; margin-top:25px;display:flex}

.header_nav_left .nav a  , .header_nav_right .nav a {
	width:150px; height:40px; line-height:40px; display:block;
	text-align:center; font-size:16px; font-weight:900; color:#fff;
	animation: rotateLight 2s linear infinite
	}
.header_nav_left .nav a {background:url(statics/images/admin_img/2025/headButtonLeft.png) no-repeat;transition: all .2s ease-in-out}
.header_nav_left .nav a:hover {background:url(statics/images/admin_img/2025/headButtonLeftHovers.png) no-repeat}
.header_nav_right .nav a {background:url(statics/images/admin_img/2025/headButtonRight.png) no-repeat;transition: all .2s ease-in-out}
.header_nav_right .nav a:hover {background:url(statics/images/admin_img/2025/headButtonRightHovers.png) no-repeat}
.video-background {
     max-width: none !important;
     border: none; object-fit: cover;   background-size: cover; opacity: 1; width: 100%;  height: 100%;
     position: absolute; left: 0px; top: 0%; display: block; object-position: center bottom !important;
     z-index:0; opacity:1.0;filter: brightness(50%);
	 background:url(statics/images/admin_img/vbg.jpg) center center no-repeat;
	 background-size:cover
}
.userInfo {width:540px;height:24px;background:url(statics/images/admin_img/2025/useInfo.png) center 0 no-repeat;line-height:22px;text-align:center;font-size:14px;font-weight:500}
.userInfo {position:absolute;top:70px;left:50%;margin-left:-270px;z-index:9999;font-size:12px;color:#DBFFFF}
.time {margin-right:10px}
</style>

</head>
<body scroll="no" class="objbody">



<input id="selcach" type="text" style="width:90%;display:none" /><input id="selcachid" type="text" style="width:10%;display:none" />
<div class="btns btns2" id="btnx">

<?php $model_types = pc_base::load_config('model_config');?>
<h6><?php echo L('panel_switch');?></h6>
<ul id="Site_model" class="pd4">
		<li onclick="_Site_M();" class="ac"><span><?php echo L('full_menu')?></span></li>
		<?php if (is_array($model_types)) { foreach ($model_types as $mt => $mn) {?>
		<li onclick="_Site_M('<?php echo $mt;?>');"><span><?php echo $mn;?></span></li>
		<?php } }?>
	</ul>
</div>
<div id="dvLockScreen" class="ScreenLock" style="display:<?php if(isset($_SESSION['lock_screen']) && $_SESSION['lock_screen']==0) echo 'none';?>">
    <div id="dvLockScreenWin" class="inputpwd">
    <h5><b class="ico ico-info"></b><span id="lock_tips"><?php echo L('lockscreen_status');?></span></h5>
    <div class="input">
    	<label class="lb"><?php echo L('password')?>：</label><input type="password" id="lock_password" class="input-text" size="24">
        <input type="submit" class="submit" value="&nbsp;" name="dosubmit" onclick="check_screenlock();return false;">
    </div></div>
</div>
<div class="header">

	<div class="userInfo" data-scroll-reveal="wait 0.4s enter top">
		<?php echo date("Y") ?>-<?php echo date("m") ?>-<?php echo date("d") ?> 
		<?php
			$days = array( 'Sunday' => '星期日', 'Monday' => '星期一', 'Tuesday' => '星期二', 'Wednesday' => '星期三', 'Thursday' => '星期四', 'Friday' => '星期五', 'Saturday' => '星期六');
            echo $days[date("l")];
        ?>
        <span class="time"></span>
		您好, <?php echo $admin_username?>  [<?php echo $rolename?>] 
        <span> | </span> 
        <a href="?m=admin&c=index&a=public_logout">[<?php echo L('exit')?>]</a>
	</div>	

	<!--<div class="logo lf"><a href="<?php echo $currentsite['domain']?>" target="_blank"><span class="invisible">&nbsp;</span></a></div>-->
    <div class="header_nav">
    	<div class="header_nav_left">
        	<div class="nav" data-scroll-reveal="wait 0.6s enter left"><a href="index.php?m=admin">首页</a></div>
            <div class="nav" data-scroll-reveal="wait 0.4s enter left"><a href="javascript:openme(1823,'业务中心','?m=admin&c=index&a=public_main2')">业务</a></div>
            <div class="nav" data-scroll-reveal="wait 0.2s enter left"><a href="javascript:openme(1819,'系统工具','?m=tools&c=tools')">工具</a></div>
        </div>
        <div class="header_nav_center" data-scroll-reveal="enter top"></div>
        <div class="header_nav_right">
            <div class="nav" data-scroll-reveal="wait 0.2s enter right"><a href="javascript:openme(1796,'系统功能','?m=sysgn&c=gongneng')">功能</a></div>
            <div class="nav" data-scroll-reveal="wait 0.4s enter right"><a href="javascript:openme(1,'系统设置','?m=admin&c=setting')">设置</a></div>            
            <div class="nav" data-scroll-reveal="wait 0.6s enter right"><a href="javascript:openme(1807,'系统扩展','?m=admin&c=log')">扩展</a></div>        
        </div>

    </div>
</div>
<!--<div id="content" style="background:url(statics/images/admin_img/2025/loginbg.jpg) center 0 no-repeat;background-size:cover">-->
<div id="content">
	<!--
    <video autoplay="autoplay" loop="loop" muted="muted" class="video-background">
    <source src="statics/images/admin_img/2025/loginBg.mp4" type="video/mp4" style="position:absolute;top:0;left:0">
    Your browser does not support the video tag.
    </video>
	-->
    <div class="video-background"></div>
	<div class="col-left left_menu" style="<?php echo $showleft?>">
    	<div id="leftMain"></div>
        <a href="javascript:;" id="openClose" style="outline-style: none; outline-color: invert; outline-width: medium;" hideFocus="hidefocus" class="open" title="<?php echo L('spread_or_closed')?>">
        <span class="hidden"><?php echo L('expand')?></span>
        </a>
    </div>

	<div class="col-1 lf cat-menu" id="display_center_id" style="display:block" height="100%">
	<div class="content">
        	<iframe name="center_frame" id="center_frame" src="" frameborder="false" scrolling="auto" style="border:none;background-color: transparent;" width="100%" height="auto" allowtransparency="true" ></iframe>
            </div>
        </div>
    <div class="col-auto mr8">
    <div class="crumbs">

    当前位置：<span id="current_pos">首页</span></div>
    	<div class="col-1">
        	<div class="content" style="position:relative; overflow:hidden">
                <iframe name="right" id="rightMain" src="?m=admin&c=index&a=public_main" frameborder="false" scrolling="auto" style="border:none; margin-bottom:0;background-color: transparent;" width="100%" height="auto" allowtransparency="true"></iframe>
                <!--
                <div class="fav-nav">
					<div id="panellist">
						<?php foreach($adminpanel as $v) {?>
								<span>
								<a onclick="paneladdclass(this);" target="right" href="<?php echo $v['url'].'menuid='.$v['menuid'].'&pc_hash='.$_SESSION['pc_hash'];?>"><?php echo L($v['name'])?></a>
								<a class="panel-delete" href="javascript:delete_panel(<?php echo $v['menuid']?>, this);"></a></span>
						<?php }?>
					</div>
					<div id="paneladd"></div>
					<input type="hidden" id="menuid" value="">
					<input type="hidden" id="bigid" value="" />
                    <div id="help" class="fav-help"></div>
				</div>
                -->
        	</div>
        </div>
    </div>
    

    
</div>
<div class="tab-web-panel hidden" style="position:absolute; z-index:999; background:#fff">
<ul>
<?php foreach ($sitelist as $key=>$v):?>
	<li style="margin:0"><a href="javascript:site_select(<?php echo $v['siteid']?>, '<?php echo new_addslashes($v['name'])?>', '<?php echo $v['domain']?>', '<?php echo $v['siteid']?>')"><?php echo $v['name']?></a></li>
<?php endforeach;?>
</ul>
</div>
<div class="scroll"><a href="javascript:;" class="per" title="使用鼠标滚轴滚动侧栏" onclick="menuScroll(1);"></a><a href="javascript:;" class="next" title="使用鼠标滚轴滚动侧栏" onclick="menuScroll(2);"></a></div>
<script type="text/javascript"> 
if(!Array.prototype.map)
Array.prototype.map = function(fn,scope) {
  var result = [],ri = 0;
  for (var i = 0,n = this.length; i < n; i++){
	if(i in this){
	  result[ri++]  = fn.call(scope ,this[i],i,this);
	}
  }
return result;
};

var getWindowSize = function(){
return ["Height","Width"].map(function(name){
  return window["inner"+name] ||
	document.compatMode === "CSS1Compat" && document.documentElement[ "client" + name ] || document.body[ "client" + name ]
});
}
window.onload = function (){
	if(!+"\v1" && !document.querySelector) { // for IE6 IE7
	  document.body.onresize = resize;
	} else { 
	  window.onresize = resize;
	}
	function resize() {
		wSize();
		return false;
	}
}
function wSize(){
	//这是一字符串
	var str=getWindowSize();
	var strs= new Array(); //定义一数组
	strs=str.toString().split(","); //字符分割
	var heights = strs[0]-50,Body = $('body');$('#rightMain').height(heights);   
	//iframe.height = strs[0]-46;
	if(strs[1]<980){
		$('.header').css('width',980+'px');
		$('#content').css('width',980+'px');
		Body.attr('scroll','');
		Body.removeClass('objbody');
	}else{
		$('.header').css('width','auto');
		$('#content').css('width','auto');
		Body.attr('scroll','no');
		Body.addClass('objbody');
	}
	
	var openClose = $("#rightMain").height()+39;
	$('#center_frame').height(openClose+9);
	$("#openClose").height(openClose+30);	
	$("#Scroll").height(openClose-20);
	windowW();
}
wSize();
function windowW(){
	if($('#Scroll').height()<$("#leftMain").height()){
		$(".scroll").show();
	}else{
		$(".scroll").hide();
	}
}
windowW();
//站点下拉菜单
$(function(){
	var offset = $(".tab_web").offset();
	var tab_web_panel = $(".tab-web-panel");
	$(".tab_web").mouseover(function(){
			tab_web_panel.css({ "left": +$(this).offset().left+4, "top": +offset.top+$('.tab_web').height()});
			tab_web_panel.show();
			if(tab_web_panel.height() > 200){
				tab_web_panel.children("ul").addClass("tab-scroll");
			}
		});
	$(".tab_web span").mouseout(function(){hidden_site_list_1()});
	$(".tab-web-panel").mouseover(function(){clearh();$('.tab_web a').addClass('on')}).mouseout(function(){hidden_site_list_1();$('.tab_web a').removeClass('on')});
	//默认载入左侧菜单
	$("#leftMain").load("?m=admin&c=index&a=public_menu_left&menuid=10");

	//面板切换
	$("#btnx").removeClass("btns2");
	$("#Site_model,#btnx h6").css("display","none");
	$("#btnx").hover(function(){$("#Site_model,#btnx h6").css("display","block");$(this).addClass("btns2");$(".bg_btn").hide();},function(){$("#Site_model,#btnx h6").css("display","none");$(this).removeClass("btns2");$(".bg_btn").show();});
	$("#Site_model li").hover(function(){$(this).toggleClass("hvs");},function(){$(this).toggleClass("hvs");});
	$("#Site_model li").click(function(){$("#Site_model li").removeClass("ac"); $(this).addClass("ac");});
})
//站点选择
function site_select(id,name, domain, siteid) {
	$(".tab_web span").html(name);
	$.get("?m=admin&c=index&a=public_set_siteid&siteid="+id,function(data){
		if (data==1){
				window.top.right.location.reload();
				window.top.center_frame.location.reload();
				$.get("?m=admin&c=index&a=public_menu_left&menuid=0&parentid="+$("#bigid").val(), function(data){$('.top_menu').remove();$('#top_menu').prepend(data)});
			}
		});
	$('#site_homepage').attr('href', domain);
	$('#site_search').attr('href', 'index.php?m=search&siteid='+siteid);
}
//隐藏站点下拉。
var s = 0;
var h;
function hidden_site_list() {
	s++;
	if(s>=3) {
		$('.tab-web-panel').hide();
		clearInterval(h);
		s = 0;
	}
}
function clearh(){
	if(h)clearInterval(h);
}
function hidden_site_list_1() {
	h = setInterval("hidden_site_list()", 1);
}

//左侧开关
$("#openClose").click(function(){
	if($(this).data('clicknum')==1) {
		$("html").removeClass("on");
		$(".left_menu").removeClass("left_menu_on");
		$(this).removeClass("close");
		$(this).data('clicknum', 0);
		$(".scroll").show();
	} else {
		$(".left_menu").addClass("left_menu_on");
		$(this).addClass("close");
		$("html").addClass("on");
		$(this).data('clicknum', 1);
		$(".scroll").hide();
	}
	return false;
});

function _M(menuid,targetUrl) {
	$("#menuid").val(menuid);
	$("#bigid").val(menuid);
	$("#paneladd").html('<a class="panel-add" href="javascript:add_panel();"><em><?php echo L('add')?></em></a>');
	if(menuid!=8) {
		$("#leftMain").load("?m=admin&c=index&a=public_menu_left&menuid="+menuid, {limit: 25}, function(){
		   windowW();
		 });
	} else {
		$("#leftMain").load("?m=admin&c=phpsso&a=public_menu_left&menuid="+menuid, {limit: 25}, function(){
		   windowW();
		 });
	}
	//$("#rightMain").attr('src', targetUrl);
	$('.top_menu').removeClass("on");
	$('#_M'+menuid).addClass("on");
	$.get("?m=admin&c=index&a=public_current_pos&menuid="+menuid, function(data){
		$("#current_pos").html(data);
	});
	//当点击顶部菜单后，隐藏中间的框架
	$('#display_center_id').css('display','none');
	//显示左侧菜单，当点击顶部时，展开左侧
	$(".left_menu").removeClass("left_menu_on");
	$("#openClose").removeClass("close");
	$("html").removeClass("on");
	$("#openClose").data('clicknum', 0);
	$("#current_pos").data('clicknum', 1);
}
function _MP(menuid,targetUrl) {
	$("#menuid").val(menuid);
	$("#paneladd").html('<a class="panel-add" href="javascript:add_panel();"><em><?php echo L('add')?></em></a>');

	$("#rightMain").attr('src', targetUrl+'&menuid='+menuid+'&pc_hash='+pc_hash);
	$('.sub_menu').removeClass("on fb blue");
	$('#_MP'+menuid).addClass("on fb blue");
	$.get("?m=admin&c=index&a=public_current_pos&menuid="+menuid, function(data){
		$("#current_pos").html(data+'<span id="current_pos_attr"></span>');
	});
	$("#current_pos").data('clicknum', 1);

}


function add_panel() {
	var menuid = $("#menuid").val();
	$.ajax({
		type: "POST",
		url: "?m=admin&c=index&a=public_ajax_add_panel",
		data: "menuid=" + menuid,
		success: function(data){
			if(data) {
				$("#panellist").html(data);
			}
		}
	});
}
function delete_panel(menuid, id) {
	$.ajax({
		type: "POST",
		url: "?m=admin&c=index&a=public_ajax_delete_panel",
		data: "menuid=" + menuid,
		success: function(data){
			$("#panellist").html(data);
		}
	});
}

function paneladdclass(id) {
	$("#panellist span a[class='on']").removeClass();
	$(id).addClass('on')
}
setInterval("session_life()", 160000);
function session_life() {
	$.get("?m=admin&c=index&a=public_session_life");
}
function lock_screen() {
	$.get("?m=admin&c=index&a=public_lock_screen");
	$('#dvLockScreen').css('display','');
}
function check_screenlock() {
	var lock_password = $('#lock_password').val();
	if(lock_password=='') {
		$('#lock_tips').html('<font color="red"><?php echo L('password_can_not_be_empty');?></font>');
		return false;
	}
	$.get("?m=admin&c=index&a=public_login_screenlock", { lock_password: lock_password},function(data){
		if(data==1) {
			$('#dvLockScreen').css('display','none');
			$('#lock_password').val('');
			$('#lock_tips').html('<?php echo L('lockscreen_status');?>');
		} else if(data==3) {
			$('#lock_tips').html('<font color="red"><?php echo L('wait_1_hour_lock');?></font>');
		} else {
			strings = data.split('|');
			$('#lock_tips').html('<font color="red"><?php echo L('password_error_lock');?>'+strings[1]+'<?php echo L('password_error_lock2');?></font>');
		}
	});
}
$(document).bind('keydown', 'return', function(evt){check_screenlock();return false;});

(function(){
    var addEvent = (function(){
             if (window.addEventListener) {
                return function(el, sType, fn, capture) {
                    el.addEventListener(sType, fn, (capture));
                };
            } else if (window.attachEvent) {
                return function(el, sType, fn, capture) {
                    el.attachEvent("on" + sType, fn);
                };
            } else {
                return function(){};
            }
        })(),
    Scroll = document.getElementById('Scroll');
    // IE6/IE7/IE8/IE10/IE11/Opera 10+/Safari5+
    addEvent(Scroll, 'mousewheel', function(event){
        event = window.event || event ;  
		if(event.wheelDelta <= 0 || event.detail > 0) {
				Scroll.scrollTop = Scroll.scrollTop + 29;
			} else {
				Scroll.scrollTop = Scroll.scrollTop - 29;
		}
    }, false);

    // Firefox 3.5+
    addEvent(Scroll, 'DOMMouseScroll',  function(event){
        event = window.event || event ;
		if(event.wheelDelta <= 0 || event.detail > 0) {
				Scroll.scrollTop = Scroll.scrollTop + 29;
			} else {
				Scroll.scrollTop = Scroll.scrollTop - 29;
		}
    }, false);
	
})();
function menuScroll(num){
	var Scroll = document.getElementById('Scroll');
	if(num==1){
		Scroll.scrollTop = Scroll.scrollTop - 60;
	}else{
		Scroll.scrollTop = Scroll.scrollTop + 60;
	}
}
function _Site_M(project) {
	var id = '';
	$('#top_menu li').each(function (){
		var S_class = $(this).attr('class');
		if ($(this).attr('id')){
			$(this).hide();
		}
		if (S_class=='on top_menu' || S_class=='top_menu on'){
			id = $(this).attr('id');
		}
	});
	$('#'+id).show();
	id = id.substring(2, id.length);
	if (!project){
		project = 0;
	}
	$.ajaxSettings.async = false; 
	$.getJSON('index.php', {m:'admin', c:'index', a:'public_set_model', 'site_model':project, 'time':Math.random()}, function (data){
		$.each(data, function(i, n){
			$('#_M'+n).show();
		})
	})
	$("#leftMain").load("?m=admin&c=index&a=public_menu_left&menuid="+id+'&time='+Math.random());
}

function openme(menuid,menuname,targetUrl){

     $("#leftMain").load("?m=admin&c=index&a=public_menu_left&menuid="+menuid+"&sj="+Math.random());
	 $("#current_pos").html(menuname);
     setTimeout(function() {
	//不知道为啥要延迟更新框架，啥意思呢 
   	   $("#rightMain").attr('src', targetUrl+'&menuid='+menuid+'&pc_hash='+pc_hash);
     }, 100);		
	
	}
	
		
<?php if($site_model) { ?> _Site_M('<?php echo $site_model?>'); <?php }?>
</script>
<script>
//初始化scrollReveal
if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))){
	(function(){
		window.scrollReveal = new scrollReveal({reset: true});
	})();
};

    function updateTime() {
        var now = new Date();
        var hours = now.getHours(); // 获取小时数
        var minutes = now.getMinutes(); // 获取分钟数
        var seconds = now.getSeconds(); // 获取秒数
        // 确保分钟和秒数始终是两位数
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        // 格式化时间
        var timeString = hours + ' : ' + minutes + ' : ' + seconds;
        $('.time').text(timeString); // 更新时间显示
    }
    // 初始显示时间
    updateTime();
    // 每秒更新一次时间
    setInterval(updateTime, 1000);

</script>

</body>
</html>