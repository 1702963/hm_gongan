<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');
?>
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<style type="text/css">
* {margin:0;padding:0}
body {margin:0;padding:0;background:#1d1e72 /*url(statics/images/admin_img/2025/bodybg.jpg) center center no-repeat*/;background-size:cover;display:flex;align-items:center;justify-content: center;font-family:microsoft yahei}
a , a:hover {text-decoration:none}
#buttonItem {width:1600px;height:650px;overflow:hidden;display:flex;flex-wrap:wrap}
#buttonItem a {width:210px;height:100px;display:block;border:2px solid #263a93;background-image: linear-gradient(45deg,#0f2072,#142e89);margin:50px 50px 0 50px}
#buttonItem a img {margin:20px 55px 0 55px;border:0;}
#buttonItem a {text-align:center;align-items: center;line-height: 100px;font-size:20px;color:#fff;transition: all .3s ease-in-out}
#buttonItem a em {width:20px;height:4px;display:block;border-radius:2px;background:#35479d;margin-left:95px;margin-top:10px}
#buttonItem a:hover {filter:brightness(1.2);box-shadow: 0 0 25px rgba(0, 160, 255, 1);transform: scale(1.02)}

.noSelect {width:210px;height:240px;display:block;border:2px solid #263a93;background-image: linear-gradient(45deg,#0f2072,#142e89);margin:50px 50px 0 50px}
.noSelect img {margin:20px 55px 0 55px;border:0;}
.noSelect {text-align:center;font-size:20px;color:#fff;transition: all .3s ease-in-out}
.noSelect em {width:20px;height:4px;display:block;border-radius:2px;background:#35479d;margin-left:95px;margin-top:10px}
.noSelect {filter: grayscale(100%)}
</style>
<div class="pad-lr-10" >
<div class="explain-col"> 
   请选择要填报的类型 
</div>
</div>
<div style="clear:both"></div>
<div id="buttonItem" data-scroll-reveal="wait 1.5s enter top">
	<a href="?m=renshi&c=geren&a=addsx&sxty=1" title="护照"><span>护照</span></a>
    <a href="?m=renshi&c=geren&a=addsx&sxty=2" title="边境通行证"><span>边境通行证</span></a>
    <a href="?m=renshi&c=geren&a=addsx&sxty=3" title="本人参与盈利情况"><span>本人参与盈利情况</span></a>
    <a href="?m=renshi&c=geren&a=addsx&sxty=4" title="经商办企"><span>经商办企</span></a>
    <a href="?m=renshi&c=geren&a=addsx&sxty=5" title="家庭成员"><span>家庭成员</span></a>
    <!--下方为无权限时显示模式-->
    <!--<div class="noSelect"><img src="statics/images/admin_img/2025/button05.png"><span>党建</span><em></em></div>-->
	<a href="?m=renshi&c=geren&a=addsx&sxty=6" title="犯罪违法情况"><span>犯罪违法情况</span></a>
    <a href="?m=renshi&c=geren&a=addsx&sxty=7" title="工资"><span>工资</span></a>
    <a href="?m=renshi&c=geren&a=addsx&sxty=8" title="房产"><span>房产</span></a>
    <a href="?m=renshi&c=geren&a=addsx&sxty=9" title="机动车"><span>机动车</span></a>
    <a href="?m=renshi&c=geren&a=addsx&sxty=10" title="股票"><span>股票</span></a>
    
    <a href="?m=renshi&c=geren&a=addsx&sxty=11" title="证券基金"><span>证券基金</span></a>
    <a href="?m=renshi&c=geren&a=addsx&sxty=12" title="投资型保险"><span>投资型保险</span></a>
    <a href="?m=renshi&c=geren&a=addsx&sxty=13" title="投资情况"><span>投资情况</span></a>
</div>

</body></html>