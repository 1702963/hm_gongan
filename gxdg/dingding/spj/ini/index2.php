<?php
require 'ini/baseconfig.php';
require 'dapi/chklogin.php';


?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="no" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="format-detection" content="telephone=no" />
<meta http-equiv="cache-control" content="no-chche">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>实时值班表</title>
</head>
<style type="text/css">
* {margin:0;padding:0}
body {color:#000;font-family:"Microsoft YaHei",Verdana, Geneva, sans-serif,"Time New Roman";position:relative;background:#fff}
li {list-style:none}
img {border:0}
input{border:none;outline:none}
a {outline:none;text-decoration:none}
a:hover {color:#c00;text-decoration:none}
.clear{clear:both}
.left{float:left}
.right{float:right}
@media screen and (min-width:320px){body{font-size:75%}}
@media screen and (min-width:360px){body{font-size:84.4%}}
@media screen and (min-width:375px){body{font-size:86.6%}}
@media screen and (min-width:400px){body{font-size:87%}}
@media screen and (min-width:480px){body{font-size:112.5%}}
@media screen and (min-width:550px){body{font-size:131.25%}}
@media screen and (min-width:639px){body{font-size:150%}}

.header p{float:left;width:22%;font-size:1.5em;background:#06c;border-radius:5px;text-align:center;line-height:2em;margin-top:0.8em;margin-left:2.2%}
.header p a{color:#fff}
.htlist{width:88%;margin:3% auto;background:#f8f8f8;padding:1em 1em 0.5em 1em;border-radius:5px}
.htlist p{font-size:1.1em;margin-bottom:0.5em}
.htlist p span{color:#666}
.pages{height:3em;text-align:center;line-height:3em}
.pages span{color:#06c;margin-left:0.5em}
.pages a{color:#666;margin-left:0.5em}
</style>
<body>

<div id="chk" style="display:none">
    <script type="text/javascript">var _config = <?php echo json_encode($config, JSON_UNESCAPED_SLASHES);?></script>
    <script type="text/javascript" src="public/javascripts/zepto.min.js"></script>
    <script src="//g.alicdn.com/dingding/dingtalk-jsapi/2.6.41/dingtalk.open.js"></script>
<table align="center" style="margin:0 auto; width:50%">
<tr>
 <td align="center" style="background-color:#0066cc; color:#FFF" height="100" id="nouser">权限不足</td>
</tr>
</table>
</div>

<div id="htlist" style="display:none">
<div class="header">
<p><a href="javascript:;" onClick="callme(1)" id="a1">查询</a></p>
<p><a href="javascript:;" onClick="callme(2)" onpc="1" id="a2">管理</a></p>
<p><a href="javascript:;" id="a3" onClick="callme(3)">轨迹</a></p>
<p><a href="javascript:;" id="a4" onClick="callme(4)">电话</a></p>

<div id="box1" style="display:none;width:93%;font-size:12px; color:#FFF; background:#999;float:left;margin-top:0.8em;margin-left:3%;border-radius:5px;padding:1em 0">
<div style="width:90%;margin:5%"><span style="width:100%;font-size:1.5em;">合同名称</span><input type="text" id="title" style="width:100%;height:2.5em;background:#fff;border-radius:5px;font-size:1.5em;text-indent:1em" /></div>
<div style="width:90%;margin:5%"><span style="width:100%;font-size:1.5em;">甲方</span><input type="text" id="jf" style="width:100%;height:2.5em;background:#fff;border-radius:5px;font-size:1.5em;text-indent:1em" /></div>
<div style="width:90%;margin:5%"><span style="width:100%;font-size:1.5em;">乙方</span><input type="text" id="yf" style="width:100%;height:2.5em;background:#fff;border-radius:5px;font-size:1.5em;text-indent:1em" /></div>
<div style="width:90%;margin:5%"><span style="width:100%;font-size:1.5em;">合同类型</span>
<select id="leixing" style="width:100%;height:2.5em;background:#fff;border-radius:5px;font-size:1.5em;text-indent:1em" >
<option value="0">不限</option>
<option value="11">普通合同</option>
<option value="12">技术合同</option>
<option value="13">采购合同</option>
</select> 
</div>

<div style="width:90%;margin:5%"><span style="width:100%;font-size:1.5em;">合同编号</span><input type="text" id="bianh"  style="width:100%;height:2.5em;background:#fff;border-radius:5px;font-size:1.5em;text-indent:1em" /></div>
<input type="button" value=" 检索 " onClick="clist(0)" style="width:90%;height:2.5em;background:#09c;color:#fff;font-size:1.5em;margin:5%;border-radius:5px" />
</div>
<!--box2-->
<div id="box2" style="display:none;width:93%;font-size:12px; color:#FFF; background:#999;float:left;margin-top:0.8em;margin-left:3%;border-radius:5px;padding:1em 0">
<div style="width:90%;margin:5%; margin-top:-5px"><span style="font-size: 1.5em; border-bottom-color:#FFF; border-bottom-style:solid; border-bottom-width:1px">组织架构</span>
<table width="90%">
<tr>
<td width="60%">
<div id="zuzhi" style="height:100px;overflow:hidden;overflow-y:scroll;">

</div>
</td>
<td>
<div id="zuzhi2" style="height:100px;overflow:hidden;overflow-y:auto;">

</div>
</td>
</tr>
</table>
</div>
<div style="width:90%;margin:5%"><span style="width:100%;font-size:1.5em;border-bottom-color:#FFF; border-bottom-style:solid; border-bottom-width:1px">系统用户</span>
<div id="yonghu" style="height:100px;overflow:hidden;overflow-y:auto;">

 </div>
</div>
<div style="width:90%;margin:5%"><span style="width:100%;font-size:1.5em;border-bottom-color:#FFF; border-bottom-style:solid; border-bottom-width:1px">提醒设置</span>
<div><label>提前48小时提醒合同到期及维护费到期 <input type="checkbox" id="tixing" value="1" disabled checked></label></div>
</div>
</div>
<!--box3-->
<div id="box3" style="display:none;width:93%;font-size:12px; color:#FFF; background:#999;float:left;margin-top:0.8em;margin-left:3%;border-radius:5px;padding:1em 0">
<!--dmap -->
<div style="width:90%;margin:2%"><span style="width:100%;font-size:1.5em;border-bottom-color:#FFF; border-bottom-style:solid; border-bottom-width:1px">动态定位</span>
<div style="margin-top:5px;height:30px"><input type="button" id="dings" value=" 开始 " style="width:50px; height:25px" onClick="dingwei_lx_start()"> &nbsp; <input type="button" id="dinge" value=" 停止 " style="width:50px; height:25px" onClick="dingwei_lx_stop()"> </div>
<div style="margin-top:5px;height:50px;overflow:hidden;overflow-y:auto;" id="gpss"></div>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.14&key=c0cbdcaa9f88421cd77fa870154458be"></script>
<div style="margin-top:5px;height:30px;" id="xuanz">
<div style="float:left">
<?php if(1==2){?>
<?php

$con = mysql_connect($db_add,$db_user,$db_pass);
mysql_select_db($db_name, $con); 
mysql_query("SET NAMES UTF8");

	   $sql="select * from ".$db_tablepre."roles order by id ";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		$uee[]=$row;   
		   } 
?>
<select id="suid">
 <option value="">当前账号</option>
 <?php foreach($uee as $u){?>
  <option value="<?php echo $u['uid']?>"><?php echo $u['uname']?></option>
 <?php }?>
</select>
<select id="sdata">
<option value="">当前日期</option>
<?php 
for($i=1;$i<=6;$i++){
  $outdt=intval(time())-(3600*24*$i);
?>
<option value="<?php echo date("Y-m-d",$outdt)?>"><?php echo date("Y-m-d",$outdt)?></option>
<?php }?>
</select>
<select id="sdt">
<option value="8">8点</option>
<option value="9">9点</option>
<option value="10">10点</option>
<option value="11">11点</option>
<option value="12">12点</option>
<option value="13">13点</option>
<option value="14">14点</option>
<option value="15">15点</option>
<option value="16">16点</option>
<option value="17">17点</option>
<option value="18">18点</option>
</select> 至
<select id="edt">
<option value="8">8点</option>
<option value="9">9点</option>
<option value="10">10点</option>
<option value="11">11点</option>
<option value="12">12点</option>
<option value="13">13点</option>
<option value="14">14点</option>
<option value="15">15点</option>
<option value="16">16点</option>
<option value="17">17点</option>
<option value="18" selected>18点</option>
</select>

</div>
<div style=" float:left;width:90%; height:30px; margin-left:3px" id="licheng"></div>
</div>
<div id="container" style="width:100%; height: 300px; margin-bottom:-8px"></div>
<script type="text/javascript" src="dapi/gpsjs.js"></script> 
</div>
</div>
<!--tel-->
<div id="box4" style="display:none;width:93%;font-size:12px; color:#FFF; background:#999;float:left;margin-top:0.8em;margin-left:3%;border-radius:5px;padding:1em 0">
<div style="width:90%;margin:2%"><span style="width:100%;font-size:1.5em;border-bottom-color:#FFF; border-bottom-style:solid; border-bottom-width:1px">电话会议</span>
<div style="margin-top:5px;height:30px"><input type="button" id="tels" value=" 发起 " style="width:50px; height:25px" onClick="tels_start(<?php echo count($uee)?>)" teladd="" > </div>
<div style="margin-top:5px;height:50px;">
<?php for($t=0;$t<count($uee);$t++){?>
<label><input type="checkbox" id="telu<?php echo $t;?>" value="<?php echo $uee[$t]['uid']?>" ><?php echo $uee[$t]['uname']?></label>
<?php }?>
</div>
</div>

<div style="width:90%;margin:2%"><span style="width:100%;font-size:1.5em;border-bottom-color:#FFF; border-bottom-style:solid; border-bottom-width:1px">语音识别</span>
<div style="margin-top:5px;height:30px"><input type="button" id="https" value=" 录制音频 " style="width:100px; height:25px" onClick="startRecord()" teladd=""> &nbsp; <input type="button" id="https" value=" 停止并转换语音 " style="width:100px; height:25px" onClick="stopRecord()" teladd=""> &nbsp; <input type="button" id="https" value=" 回放 " style="width:50px; height:25px" onClick="soundplay()" teladd=""></div>
<div style=" float:left;width:90%; height:30px; margin-left:3px" id="texts"></div>

</div>

<div class="clear"></div>

<div style="width:90%;margin:2%"><span style="width:100%;font-size:1.5em;border-bottom-color:#FFF; border-bottom-style:solid; border-bottom-width:1px">照片操作</span>
<div style="margin-top:5px;height:30px"> <input type="file" id="picss" value="" style="display:" onChange="upme(this)" name="myfiles" accept="image/*;capture=camera"> </div>
<div style=" float:left;width:90%; margin-left:3px" id="texts">
 <progress id='prob1' value="0" max="100" style='width:90%;margin-top:3px'></progress><br>
<span id="biaoji" zb="">时间戳：，坐标</span><br><img id="picshow" style="width:90%"></div>

</div>

<script type="text/javascript" src="dapi/gettel.js"></script>
<script type="text/javascript" src="dapi/picjs.js"></script>  
</div>
<?php }?>
</div>
<!--控制层结束-->
</div>
<div class="clear"></div>
<div id="lists">

</div>
<div id="pages" class="pages">
 <span style="color:#666" id="allnum"></span>
 <a href="javascript:;" onClick="clist(-1)" style="display:none">上一页</a>
 <span id="page" style="display:none">1</span>
 <a href="javascript:;" onClick="clist(1)" id="more" zpage="1">加载更多</a>
</div>
</div>
<script language="javascript">
//clist(0)
</script>
    <script type="text/javascript" src="public/javascripts/htgl.js"></script>
</body>
</html>
