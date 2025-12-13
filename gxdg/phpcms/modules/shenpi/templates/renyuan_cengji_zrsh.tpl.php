<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');
?>




<style type="text/css">
.clear {clear:both}
.baseinfo {width:100%;border-left:2px solid #ccc;border-top:2px solid #ccc;border-right:2px solid #ccc;border-bottom:2px solid #ccc;margin:0 0 20px 20px;_display:inline}
.baseinfo td {border-bottom:1px solid #ccc;padding:10px 0;height:25px}
.baseinfo td b {margin-left:10px;color:#f00}
.infotitle {background:#fff;font-weight:900}
.infotitle span {color:#f00}
.infoinput {width:200px;height:20px;background:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px}
.baseinfo select {padding:5px 0}
.infonum {width:525px;height:24px;background:#fff;border:1px solid #aaa;margin-left:10px;text-indent:5px}
.rad {margin-left:10px;margin-right:5px}
.infoselect {width:206px;margin-left:5px}
#headpic {width:150px;height:230px;background:#fff;margin-left:15px;overflow:hidden}
#headpic img {width:150px}
.topnav {width:960px;padding-left:10px;margin-top:20px}
.thisnav {width:100%;height:90px}
.thisnav a {margin-left:15px;width:120px;height:80px;display:block;float:left;background:#f6f6f6;color:#3e6a90;font-weight:900;border-radius:4px;font-size:12px;text-decoration:none;text-align:center;overflow:hidden}
.thisnav a div {width:120px;height:80px;display:block;position:relative}
.thisnav a img {width:36px;position:absolute;left:50%;margin-left:-18px;top:40%;margin-top:-18px}
.thisnav a em {width:100%;height:36px;line-height:36px;display:block;font-style:normal;position:absolute;bottom:0;left:0}
.thisnav a:hover {background:url(statics/images/nb.gif) repeat-x;color:#039}
.tabcon {width:90%;padding-top:30px;position:relative;}
.tabcon .title {width:90px;height:30px;line-height:30px;text-align:center;background:#fff;position:absolute;top:15px;left:35px;font-size:16px;font-weight:900;color:#06c}
.basetext {width:1150px;height:90px;background:#fff;border:1px solid #ddd;float:left;margin-left:5px;overflow:hidden}
.lztext {width:1150px;height:60px;background:#fff;border:1px solid #ddd;float:left;margin-left:5px;overflow:hidden}
.dowhat {width:160px;height:40px;line-height:40px;border-radius:6px;background:#06c;color:#fff;text-align:center;position:absolute;left:50%;margin-left:-80px;top:0px}
.null {width:100%;height:10px}
.rb {border-right:1px solid #ddd}
.upa {float:left;margin-left:15px}
.upa img {width:18px;margin-right:10px;}
.upa a {font-size:14px}
</style>


<form action="?m=shenpi&c=cengjishenpi&a=zrsh" method="POST" name="myform" id="myform" >


<div class="tabcon">
<div class="title">审核结果</div>
<table cellpadding="0" cellspacing="0" class="baseinfo">

  <tr>
    <td width="41%" align="right" class="infotitle" style="padding-left:20px;border-bottom:0px">审核结果：</td>
    <td width="59%" align="left"  style="border-bottom:0px"><?php echo form::select(array(9=>'同意',2=>'不同意'),9,'name=zrstatus   ')?></td>
  </tr>
   <tr>
    <td align="right" class="infotitle" style="padding-left:20px;border-bottom:0px">转交局领导：</td>
    <td align="left" class="infotitle" style="border-bottom:0px"><?php echo form::select($ld,'','name=ldshid   ')?></td>
  </tr>
  <tr>
    <td width="41%" align="right" class="infotitle" style="padding-left:20px;border-bottom:0px">是否替局领导审批：</td>
    <td width="59%" align="left"  style="border-bottom:0px"><?php echo form::select(array(''=>'否',1=>'是'),'','name=dai   ')?></td>
  </tr>
</table>
</div>

<div class="tabcon">
<input type="hidden" name="id" value="<?php echo $id;?>"/>
	<input type="submit" class="dowhat" name="dosubmit" value="提交" />
</div>
</form>
<div class="clear"></div>
<div class="null"></div>
</div>

</body></html>
