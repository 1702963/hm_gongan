<?php
defined('IN_ADMIN') or exit('No permission resources.');
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';	
?>
<body>
<style type="text/css">
body {background:#eef0f6}
.clear {clear:both}
.sys_info {width:96%;float:left;margin:2% 0 0 2%;_display:inline;height:90px;background:#fff;overflow:hidden}
.sys_info_title {width:100%;height:30px;line-height:30px;background:#00c1de;color:#fff;font-size:14px;font-weight:900;text-indent:16px;float:left;overflow:hidden}
.sys_info_con {width:100%;height:60px;line-height:60px;background:#fff;float:left;color:#333;font-size:12px;overflow:hidden}
.sys_info_con b {margin-left:16px;font-weight:100}
.cat_main {width:98%;float:left;margin:2% 0 0 2%;_display:inline}
.cat_con {width:48%;height:350px;background:#fff;margin-right:2%;float:left;_display:inline;overflow:hidden}
.cat_title {width:100%;height:50px;line-height:50px;background:#00c1de;color:#fff;font-size:14px;font-weight:900;overflow:hidden;position:relative}
.cat_title ul {width:100%;height:40px;margin-top:10px;float:left;}
.cat_title ul li {width:100px;height:40px;float:left;margin-left:15px;_display:inline}
.cat_title ul li a {width:100px;height:40px;display:block;line-height:40px;text-align:center;background:url(statics/images/main_b.gif) no-repeat;color:#fff;text-decoration:none}
.cat_title ul li.active a {background:url(statics/images/main_a.gif) no-repeat;color:#00c1de}
.cat_title .daiban {width:32px;height:24px;text-align:center;line-height:24px;background:#f00;color:#fff;font-size:12px;position:absolute;left:96px;top:5px;z-index:9999;border-radius:12px;font-family:arial;font-weight:100}

.cat_list {width:96%;float:left;margin:2% 0 0 2%;_display:inline}
.cat_list p {width:100%;height:44px;line-height:44px;overflow:hidden;float:left}
.cat_list p a {float:left;text-decoration:none;color:#069}
.cat_list p a:hover {color:#00c1de}
.cat_list p em {float:right}
.cat_list p a:hover {color:#00c1de}

.cat_total {width:100%;float:left}
.cat_total_con {width:22.5%;height:70px;margin:0 0 0 2%;float:left;color:#fff;font-size:18px;font-family:microsoft yahei}
.cat_total_con .tcon {position:relative;width:100%;height:120px;}
.cat_total_con .tcon span {position:absolute;left:70px;top:20px;}
.cat_total_con .tcon b {font-size:44px;font-weight:100;position:absolute;right:20px;bottom:10px}
.ra {background:#6cc9b6 url(statics/images/ra.png) 15px 15px no-repeat}
.rb {background:#a2aee3 url(statics/images/rb.png) 15px 15px no-repeat}
.rc {background:#989bb7 url(statics/images/rc.png) 15px 15px no-repeat}
.rd {background:#e8bf9c url(statics/images/rd.png) 15px 15px no-repeat}
</style>
<script>
$(function(){
	$("#tongzhi > div:not(:first)").hide();
	var pi = $("#cat_nav > ul > li");
	var pd = $("#tongzhi > div");
	pi.each(function(p){
		$(this).mouseover(function(){
			pi.removeClass("active"); $(this).addClass("active");pd.hide();pd.eq(p).show();
		});
	});
	
});
</script>

<div class="cat_total">
	<div class="cat_total_con ra"><div class="tcon"><span><a href="index.php?m=shenpi&c=cengjishenpi&a=biandonglist" style="color:#ffffff">层级变动申请</a></span></div></div>
    <div class="cat_total_con ra"><div class="tcon"><span><a href="index.php?m=shenpi&c=cengjishenpi&a=qingkuanglist" style="color:#ffffff">层级情况</a></span></div></div>
</div>
<div class="sys_info">
	<div class="sys_info_title">审批记录</div>
    <div class="sys_info_con" style="padding-left:15px">
     审批申请
    </div>
</div>

</body></html>
