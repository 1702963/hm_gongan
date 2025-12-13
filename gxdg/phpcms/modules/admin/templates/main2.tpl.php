<?php
defined('IN_ADMIN') or exit('No permission resources.');
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header_nosub.tpl.php';
?>
<script src="statics/js/scrollReveal.js"></script>
<body>

<style type="text/css">
* {margin:0;padding:0}
body { margin:0; padding:0; display:flex; align-items:center; justify-content: center; font-family:microsoft yahei; user-select: none}
a , a:hover {text-decoration:none}
#buttonItem {width:1400px;height:500px;display:flex;flex-wrap:wrap; justify-content:center;/*background:rgba(0,0,0,0.2);backdrop-filter:blur(10px);overflow:hidden*/}
#buttonItem a {
	width:200px;height:200px;line-height:160px;display:flex;align-items:center;justify-content:center; margin:0px 40px 0 0;border-radius:50%;
	box-shadow:0px 0px 0 inset rgba(0,120,200,0.4);position:relative
	
}
#buttonItem a span {
	    width:160px;height:160px;border-radius:50%;border:0 solid rgba(210,255,255,0);
		margin-top:0;z-index:99
}
#buttonItem a {text-align:center;font-size:20px;color:#D2FFFF;transition: all .3s ease-in-out;font-weight:900;box-sizing:border-box}
#buttonItem a {flex-wrap:wrap;align-items:center;justify-content:center}
#buttonItem a em {width:20px;height:4px;display:block;border-radius:2px;background:rgba(250,180,60,1);margin:-120px 90px 0 90px;transition: all .3s ease-in-out}
#buttonItem a:hover {color:#fff}
#buttonItem a:hover em {width:40px;background:#fff;margin-left:90px}
#buttonItem a:hover span {
    animation: floatAnimation 2s ease-in-out infinite;
}

@keyframes floatAnimation {
    0%, 100% {
        transform: translateY(5px);
    }
    50% {
        transform: translateY(-5px);
    }
}

@keyframes rotate360 {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

.cir {width:200px;height:240px;position:relative;overflow:hidden;text-align:center;line-height:240px;font-size:20px;color:#CEFFFF;}
.cirBg {
	width:200px;height:200px;position:absolute;left:0;top:0;
	background:url(statics/images/admin_img/2025/itemCircleBg02.png) center center no-repeat;
	background-size:100%;
	animation:rotate360 20s linear infinite;
	transition: all .3s ease-in-out;
	filter:brightness(0.9)
}
#buttonItem a:hover .cirBg {filter:brightness(1.75);animation:rotate360 6s linear infinite;}

.noSelect {	width:200px;height:200px; margin:0 40px 0 0;border-radius:50%; line-height:200px;pointer-events: none;}
.noSelect span { width:240px; height:240px; display:block; text-align:center; margin-top:0;color:#ccc}
.noSelect img {margin:30px 75px 30px 75px;border:0;}
.noSelect {text-align:center;font-size:20px;color:#fff;transition: all .3s ease-in-out}
.noSelect em {width:20px;height:4px;display:block;border-radius:2px;background:#ccc;margin-left:115px;margin-right:115px;margin-top:-160px}
a.noSelect , a.noSelect:hover {filter: grayscale(100%)}
#demo {width:800px;height:400px;background:#c00}
.itemLine {width:100%;display:flex;}
</style>

<div id="buttonItem">
	<div class="itemLine" data-scroll-reveal="enter left">
	<a href="javascript:openme(1780,'人事管理','?m=renshi&c=renshi&a=init')"><span>人事</span><div class="cirBg"></div></a>
    <a href="javascript:openme(1782,'表彰管理','?m=biaozhang&c=biaozhang&a=init')"><span>表彰</span><div class="cirBg"></div></a>
    <a href="javascript:openme(1673,'智能体','?m=fujing&c=fujing&a=init')"><span>智能体</span><div class="cirBg"></div></a>
    <a href="javascript:openme(1784,'监督管理','?m=jiandu&c=zhifa&a=init')"><span>监督</span><div class="cirBg"></div></a>
    <a href="javascript:openme(1786,'党建管理','?m=dangjian&c=dangjian&a=init')"><span>党建</span><div class="cirBg"></div></a>
    </div>
    
    <!--下方为无权限时显示模式-->
    <!--<a href="javascript:void(0)" class="noSelect"><span>党建</span><div class="cirBg"></div></a>-->
    <div class="itemLine" data-scroll-reveal="enter right">
	<a href="javascript:openme(1788,'教育管理','?m=jiaoyu&c=jiaoyu&a=init')"  data-scroll-reveal="wait 1.0s enter bottom"><span>教育</span><div class="cirBg"></div></a>
    <a href="javascript:openme(1790,'优抚管理','?m=youfu&c=youfu&a=init')" data-scroll-reveal="wait 1.2s enter bottom"><span>优抚</span><div class="cirBg"></div></a>
    <a href="javascript:openme(1801,'宣传管理','?m=xuanchuan&c=xuanchuan&a=init')" data-scroll-reveal="wait 1.4s enter bottom"><span>宣传</span><div class="cirBg"></div></a>
    <a href="javascript:openme(1792,'考核管理','?m=kaohe&c=kaohe&a=init')" data-scroll-reveal="wait 1.6s enter bottom"><span>考核</span><div class="cirBg"></div></a>
    <a href="javascript:openme(1794,'全警画像','?m=huaxiang&c=huaxiang&a=init')" data-scroll-reveal="wait 1.8s enter bottom"><span>画像</span><div class="cirBg"></div></a>
    </div>
</div>
<script>
//初始化scrollReveal
if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))){
	(function(){
		window.scrollReveal = new scrollReveal({reset: true});
	})();
};
function openme(menuid,menuname,targetUrl){

     window.top.$("#leftMain").load("?m=admin&c=index&a=public_menu_left&menuid="+menuid+"&sj="+Math.random());
	 $("#current_pos",window.parent.document).html(menuname);
     setTimeout(function() {
	//不知道为啥要延迟更新框架，啥意思呢 
   	   $("#rightMain",window.parent.document).attr('src', targetUrl+'&menuid='+menuid+'&pc_hash='+pc_hash);
     }, 100);		
	
	}
</script>


</body>
</html>