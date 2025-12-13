<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	var charset = '<?php echo CHARSET;?>';
	var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';
//-->
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script> 
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script> 
<form action="?m=fujing&c=fujing&a=add" method="POST" name="myform" id="myform">


<style type="text/css">
.clear {clear:both}
.baseinfo {width:1270px;border-left:2px solid #ccc;border-top:2px solid #ccc;border-right:2px solid #ccc;border-bottom:2px solid #ccc;margin:0 0 20px 20px;_display:inline}
.baseinfo td {border-bottom:1px solid #ccc;padding:15px 0;height:32px}
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
.tabcon {width:1270px;padding-top:30px;position:relative;}
.tabcon .title {width:90px;height:30px;line-height:30px;text-align:center;background:#fff;position:absolute;top:15px;left:35px;font-size:16px;font-weight:900;color:#06c}
.basetext {width:1150px;height:90px;background:#fff;border:1px solid #ddd;float:left;margin-left:5px;overflow:hidden}
.lztext {width:1150px;height:60px;background:#fff;border:1px solid #ddd;float:left;margin-left:5px;overflow:hidden}
.dowhat {width:160px;height:40px;line-height:40px;border-radius:6px;background:#06c;color:#fff;text-align:center;position:absolute;left:50%;margin-left:-80px;top:0px}
.null {width:100%;height:100px}
.rb {border-right:1px solid #ddd}
.upa {float:left;margin-left:15px}
.upa img {width:18px;margin-right:10px;}
.upa a {font-size:14px}
</style>



<div class="tabcon">
<div class="title">基础信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span>姓名：</span></td>
    <td width="263"><input type="text" id="myname2" name="info[xingming]" class="infoinput" /></td>
    <td width="100" align="right" class="infotitle">性别</td>
    <td width="263">       	<input type="radio" class="rad" checked  name="info[sex]" value="男"/>男
        <input type="radio" class="rad"   name="info[sex]" value="女"/>女</td>    
    <td width="100" align="right" class="infotitle">身份证号：</td>
    <td width="263" class="rb"><input type="text" name="info[sfz]" id="mysfz" class="infoinput" onblur="chkme(this.id)"/><span id="msg" style="color:#F00"></span>

    </td>
    <td width="180" rowspan="5" valign="top">
	<input type='hidden' name='info[thumb]' id='thumb' value="">
    	<div id="headpic"><img width="150" height="217" src="statics/images/demo.jpg"  id='thumb_preview'/></div>
        <div class="upa"><a href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,0','content','7','<?php echo $authkey;?>');return false;"><img src="statics/images/a06.png" />上传</a></div>
        <div class="upa"><a href="::;" onclick="$('#thumb_preview').attr('src','<?php echo IMG_PATH;?>demo.jpg');$('#thumb').val(' ');return false;" value="取消图片"><img src="statics/images/a07.png" />删除</a></div>
    </td>
  </tr>
  <tr>
    <td align="right" class="infotitle">出生日期：</td>
    <td width="170"> &nbsp; <?php echo form::date('shengri','',0,0,'false');?></td>
    <td width="90" align="right" class="infotitle">婚姻状况：</td>
    <td width="170">
      <select name="info[hun]" id="sexy3" class="infoselect">
        <option value="未婚">未婚</option>
		 <option value="已婚">已婚</option>
		  <option value="丧偶">丧偶</option>
      </select></td>
    <td width="90" align="right" class="infotitle">学历：</td>
    <td width="170" class="rb"><?php echo form::select($xueli,'','name=info[xueli] class=infoselect')?></td>
    </tr>
  <tr>
    <td align="right" class="infotitle"><span>家庭住址：</span></td>
    <td width="170"><input type="text" name="info[jzd]" id="myname3" class="infoinput" /></td>
    <td width="90" align="right" class="infotitle"><span>户籍地址：</span></td>
    <td width="170"><input type="text" name="info[hjdizhi]" id="myname4" class="infoinput" /></td>
    <td width="90" align="right" class="infotitle">年龄：</td>
    <td width="170" class="rb"><input type="text" id="myname5" name="info[age]" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">联系电话：</td>
    <td width="170"><input name="info[tel]" type="text" id="myname6" class="infoinput" /></td>
    <td width="90" align="right" class="infotitle">政治面貌：</td>
    <td width="170"><select name="info[zzmm]" id="sexy2" class="infoselect">
      <option value="1">中共党员</option>
	  <option value="2">共青团员</option>
      <option value="3">民主党派</option>
      <option value="4">学生</option>
      <option value="5">群众</option>
    </select></td>
    <td width="90" align="right" class="infotitle">毕业院校：</td>
    <td width="170" class="rb"><input type="text" id="myname7" name="info[xuexiao]" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">所学专业：</td>
    <td width="170"><input type="text" name="info[zhuanye]" id="myname8" class="infoinput" /></td>
    <td width="90" align="right" class="infotitle">是否退伍军人：</td>
    <td width="170"><select name="info[tuiwu]" id="sexy3" class="infoselect">
        <option value="1">是</option>
		 <option value="2">否</option>
		
      </select></td>
    <td width="90" align="right" class="infotitle">是否警校毕业：</td>
    <td width="170" class="rb"><select name="info[jingxiao]" id="sexy3" class="infoselect">
        <option value="1">是</option>
		 <option value="2">否</option>
		
      </select></td>
    </tr>
  
</table>
</div>

<!--<div class="clear"></div>

<div class="tabcon">
<div class="title">参保类型</div>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="90" align="right" class="infotitle">参保类型：</td>
    <td width="870">
        <input type="checkbox" class="rad" checked />失业保险
        <input type="checkbox" class="rad" checked />医疗保险
        <input type="checkbox" class="rad" checked />工伤保险
        <input type="checkbox" class="rad" checked />养老保险
        <input type="checkbox" class="rad" checked />生育保险
    </td>
  </tr>

</table>
</div>-->


<div class="clear"></div>

<div class="tabcon">
<div class="title">岗位信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="90" align="right" class="infotitle"><span>归属单位：</span></td>
    <td width="230"><select class="infoselect" name="info[dwid]" >       
<?php echo $select_categorys;?>
</select></td>
    <td width="90" align="right" class="infotitle">岗位类别：</td>
    <td width="230"><?php echo form::select($gangwei,'','name=info[gangwei] class=infoselect')?></td>    
    <td width="90" align="right" class="infotitle">辅助岗位：</td>
    <td width="230"><?php echo form::select($gangweifz,'','name=info[gangweifz] class=infoselect')?></td>
  </tr>
  <tr>
    <td width="90" align="right" class="infotitle">职务：</td>
    <td width="230"><?php echo form::select($zhiwu,'','name=info[zhiwu] class=infoselect')?></td>
    <td width="90" align="right" class="infotitle">层级：</td>
    <td width="230"><?php echo form::select($cengji,'','name=info[cengji] class=infoselect')?></td>    
    <td width="90" align="right" class="infotitle">入警时间：</td>
    <td width="230"><?php echo form::date('rjtime','',0,0,'false');?></td>
  </tr>
  <tr>
    <td width="90" align="right" class="infotitle">财政来源：</td>
    <td width="230"><input type="text" id="myname2" name="info[caizheng]" class="infoinput" value="区财政"/></td>
    <td width="90" align="right" class="infotitle">开户行：</td>
    <td width="230"><input type="text" id="myname2" name="info[khh]" class="infoinput" /></td>    
    <td width="90" align="right" class="infotitle">工资卡号：</td>
    <td width="230"><input type="text" id="myname2" name="info[kahao]" class="infoinput" /></td>
  </tr>

  <tr>
    <td width="90" align="right" class="infotitle"><span>入职前工作：</span></td>
    <td width="230"><input type="text" id="myname2" name="info[oldjob]" class="infoinput" /></td>
    <td width="90" align="right" class="infotitle">社保卡号：</td>
    <td width="230"><input type="text" name="info[sbkh]" id="myname2" class="infoinput" /></td>    
    <td width="90" align="right" class="infotitle"><span>在职状态：</span></td>
    <td width="230"><?php echo form::select(array(1=>'在职',2=>'离职',3=>'死亡',4=>'退休',5=>'其他'),1,'name=info[status] class=infoselect')?></td>
  </tr>
  
  <tr>
    <td width="90" align="right" class="infotitle">入党时间：</td>
    <td width="230"><?php echo form::date('rdtime','',0,0,'false');?></td>
    <td width="90" align="right" class="infotitle">入党转正时间：</td>
    <td width="230"><?php echo form::date('rdzztime','',0,0,'false');?></td>    
    <td width="90" align="right" class="infotitle">组织关系所在单位：</td>
    <td width="230"><input type="text" id="myname2" name="info[ddanwei]" class="infoinput" /></td>
  </tr>
  <tr>
    <td width="90" align="right" class="infotitle">工作证号：</td>
    <td width="230"><input type="text" id="myname2" name="info[gzz]" class="infoinput" /></td>
    <td width="90" align="right" class="infotitle">工作转正时间：</td>
    <td width="230"><?php echo form::date('gzzztime','',0,0,'false');?></td>    
    <td width="90" align="right" class="infotitle">工作证有效期：</td>
    <td width="230"><?php echo form::date('gzztime','',0,0,'false');?></td>
  </tr>
  <tr>
    <td width="90" align="right" class="infotitle">首次工作时间：</td>
    <td width="230"><?php echo form::date('scgztime','',0,0,'false');?></td>
    <td width="90" align="right" class="infotitle">用工性质：</td>
    <td><input type="text" id="myname9" name="info[ygxz]" class="infoinput" value="劳务派遣"/></td>
    <td><span class="infotitle">备注：</span></td>
    <td><textarea name="info[beizhu]" rows="4" style="width:400px;"></textarea></td>
    </tr>
</table>
</div>

<div class="clear"></div>

<div class="tabcon">
	<input type="submit" class="dowhat" name="dosubmit" value="提交信息" />
</div>
<div class="clear"></div>
<div class="null"></div>

</div>
</form>
<script language="javascript">
function chkme(objid){
var msgstr=""	
$.get("getsfz.php",{'sfz':$('#'+objid).val()}, function(data){
  mydat=JSON.parse(data)
   if(mydat.err!='0'){
	 $("#msg").html('重复')
	 alert("录入的身份证已存在");  
	   }else{
	 $("#msg").html('')	   
	}
});	
	}
</script>
</body>
</html>



