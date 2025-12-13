<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');
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
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>dialog.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script> 
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script> 
<form action="?m=fujing&c=fujing&a=add" method="POST" name="myform" id="myform">


<style type="text/css">
.clear {clear:both}
.baseinfo {width:1270px;border-left:2px solid #ccc;border-top:2px solid #ccc;border-right:2px solid #ccc;border-bottom:2px solid #ccc;float:left;margin:0 0 20px 20px;_display:inline}
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
.tabcon {width:1270px;padding-top:30px;position:relative}
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

<div class="topnav">
	<div class="thisnav">
    	<a href="javascript:;" onclick="jiashu(<?php echo $fujing['id'];?>);"><div><img src="statics/images/c01.png" /><em>家庭成员</em></div></a>
        <a href="javascript:;" onclick="jiaoyu(<?php echo $fujing['id'];?>);"><div><img src="statics/images/a02.png" /><em>教育培训</em></div></a>
        <a href="javascript:;" onclick="lvli(<?php echo $fujing['id'];?>);"><div><img src="statics/images/a03.png" /><em>履历记录</em></div></a>
        <a href="javascript:;" onclick="techang(<?php echo $fujing['id'];?>);"><div><img src="statics/images/a03.png" /><em>特长记录</em></div></a>
        <a href="javascript:;" onclick="biaozhang(<?php echo $fujing['id'];?>);"><div><img src="statics/images/a03.png" /><em>表彰记录</em></div></a>
		 <a href="javascript:;" onclick="chengjie(<?php echo $fujing['id'];?>);"><div><img src="statics/images/a03.png" /><em>惩戒记录</em></div></a>
        <a href="javascript:;" onclick="zhuangbei(<?php echo $fujing['id'];?>);"><div><img src="statics/images/a04.png" /><em>装备发放</em></div></a>
        <!--<a href="#"><div><img src="statics/images/a05.png" /><em>基础信息打印</em></div></a>-->
    </div>
</div>

<div class="tabcon">
<div class="title">基础信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span>姓名：</span></td>
    <td width="263"><input type="text" readonly   id="myname2" name="info[xingming]" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="100" align="right" class="infotitle">性别：</td>
    <td width="263"><span class="rb">
      <input type="radio"  class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
      男
      <input type="radio"  class="rad"   name="info[sex]" <?php if($fujing['sex']=='女'){?>checked<?php }?> value="女"/>
      女 </span></td>    
    <td width="100" align="right" class="infotitle"><span class="rb">身份证号：</span></td>
    <td width="263" class="rb"><input type="text" readonly  name="info[sfz]" id="myname9" class="infoinput"  value="<?php echo $fujing['sfz'];?>"/></td>
    <td width="180" rowspan="5" valign="top">

    	<div id="headpic"><img width="150" height="217" src="<?php if($fujing['thumb']==''){?>statics/images/demo.jpg<?php }else{?><?php echo $fujing['thumb'];?><?php }?>"  id='thumb_preview'/></div>
        
    </td>
  </tr>
  <tr>
    <td align="right" class="infotitle">出生日期：</td>
    <td width="170"><input type="text" readonly  name="info[shengri]" id="myname" class="infoinput" value="<?php echo date("Y-m-d",$fujing['shengri']);?>" /></td>
    <td width="90" align="right" class="infotitle">婚姻状况：</td>
    <td width="170">
      <select name="info[hun]" disabled="disabled" id="sexy3" class="infoselect">
        <option value="未婚" <?php if($fujing['hun']=='未婚'){?>selected<?php }?>>未婚</option>
		 <option value="已婚" <?php if($fujing['hun']=='已婚'){?>selected<?php }?>>已婚</option>
		  <option value="丧偶 <?php if($fujing['hun']=='丧偶'){?>selected<?php }?>">丧偶</option>
      </select></td>
    <td width="90" align="right" class="infotitle">学历：</td>
    <td width="170" class="rb"><input type="text" readonly  name="info[xueli]" id="myname" class="infoinput" value="<?php echo $xueli[$fujing['xueli']];?>" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle"><span>家庭住址：</span></td>
    <td width="170"><input type="text" readonly  name="info[jzd]" id="myname3" class="infoinput" value="<?php echo $fujing['jzd'];?>" /></td>
    <td width="90" align="right" class="infotitle"><span>户籍地址：</span></td>
    <td width="170"><input type="text" readonly  name="info[hjdizhi]" id="myname4" class="infoinput" value="<?php echo $fujing['hjdizhi'];?>" /></td>
    <td width="90" align="right" class="infotitle">年龄：</td>
    <td width="170" class="rb"><input type="text" readonly  id="myname5" name="info[age]" value="<?php echo $fujing['age'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">联系电话：</td>
    <td width="170"><input name="info[tel]" type="text" id="myname6" class="infoinput" value="<?php echo $fujing['tel'];?>" /></td>
    <td width="90" align="right" class="infotitle">政治面貌：</td>
    <td width="170"><select name="info[zzmm]" disabled="disabled" id="sexy2" class="infoselect">
      <option value="1" <?php if($fujing['zzmm']==1){?>selected<?php }?>>中共党员</option>
	  <option value="2" <?php if($fujing['zzmm']==2){?>selected<?php }?>>共青团员</option>
      <option value="3" <?php if($fujing['zzmm']==3){?>selected<?php }?>>民主党派</option>
      <option value="4" <?php if($fujing['zzmm']==4){?>selected<?php }?>>学生</option>
      <option value="5" <?php if($fujing['zzmm']==5){?>selected<?php }?>>群众</option>  
	  
    </select></td>
    <td width="90" align="right" class="infotitle">毕业院校：</td>
    <td width="170" class="rb"><input type="text" readonly  id="myname7" name="info[xuexiao]" class="infoinput" value="<?php echo $fujing['xuexiao'];?>"/></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">所学专业：</td>
    <td width="170"><input type="text" readonly  name="info[zhuanye]" id="myname8" class="infoinput" value="<?php echo $fujing['zhuanye'];?>" /></td>
    <td width="90" align="right" class="infotitle">是否退伍军人：</td>
    <td width="170"><select name="info[tuiwu]" disabled="disabled" id="sexy3" class="infoselect">
        <option value="1" <?php if($fujing['tuiwu']==1){?>selected<?php }?>>是</option>
		 <option value="2" <?php if($fujing['tuiwu']==2){?>selected<?php }?>>否</option>
		
      </select></td>
    <td width="90" align="right" class="infotitle">是否警校毕业：</td>
    <td width="170" class="rb"><select name="info[jingxiao]" disabled="disabled" id="sexy3" class="infoselect">
        <option value="1" <?php if($fujing['jingxiao']==1){?>selected<?php }?>>是</option>
		 <option value="2" <?php if($fujing['jingxiao']==2){?>selected<?php }?>>否</option>
		
      </select></td>
    </tr>
  
</table>
</div>




<div class="clear"></div>

<div class="tabcon">
<div class="title">岗位信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="90" align="right" class="infotitle"><span>归属单位：</span></td>
    <td width="230"><?php echo $bms[$fujing['dwid']];?></td>
    <td width="90" align="right" class="infotitle">岗位类别：</td>
    <td width="230"><?php echo $gangwei[$fujing['gangwei']];?></td>    
    <td width="90" align="right" class="infotitle">辅助岗位：</td>
    <td width="230"><?php echo $gangweifz[$fujing['gangweifz']];?></td>
  </tr>
  <tr>
    <td width="90" align="right" class="infotitle">职务：</td>
    <td width="230"><?php echo $zhiwu[$fujing['zhiwu']];?></td>
    <td width="90" align="right" class="infotitle">层级：</td>
    <td width="230"><?php echo $cengji[$fujing['cengji']];?></td>    
    <td width="90" align="right" class="infotitle">入警时间：</td>
    <td width="230"><?php echo form::date('rjtime',date("Y-m-d",$fujing['rjtime']),0,0,'false');?></td>
  </tr>
  <tr>
    <td width="90" align="right" class="infotitle">财政来源：</td>
    <td width="230"><input type="text" readonly  id="myname2" name="info[caizheng]" class="infoinput" value="<?php echo $fujing['caizheng'];?>"/></td>
    <td width="90" align="right" class="infotitle">开户行：</td>
    <td width="230"><input type="text" readonly  id="myname2" name="info[khh]" class="infoinput" value="<?php echo $fujing['khh'];?>"/></td>    
    <td width="90" align="right" class="infotitle">工资卡号：</td>
    <td width="230"><input type="text" readonly  id="myname2" name="info[kahao]" class="infoinput" value="<?php echo $fujing['kahao'];?>"/></td>
  </tr>

  <tr>
    <td width="90" align="right" class="infotitle"><span>入职前工作：</span></td>
    <td width="230"><input type="text" readonly  id="myname2" name="info[oldjob]" class="infoinput" value="<?php echo $fujing['oldjob'];?>"/></td>
    <td width="90" align="right" class="infotitle">社保卡号：</td>
    <td width="230"><input type="text" readonly  name="info[sbkh]" id="myname2" class="infoinput" value="<?php echo $fujing['sbkh'];?>"/></td>    
    <td width="90" align="right" class="infotitle"><span>在职状态：</span></td>
    <td width="230"><?php $sss=array(1=>'在职',2=>'离职',3=>'死亡',4=>'退休',5=>'其他');echo $sss[$fujing['status']];?><?php if($fujing['status']==2){echo "&nbsp;离职时间：";if($fujing['lizhitime']!=''){echo date("Y-m-d",$fujing['lizhitime']);}}?></td>
  </tr>
  
  <tr>
    <td width="90" align="right" class="infotitle">入党时间：</td>
    <td width="230"><?php if($fujing['rdtime']<1){$fujing['rdtime']='';} echo form::date('rdtime',date("Y-m-d",$fujing['rdtime']),0,0,'false');?></td>
    <td width="90" align="right" class="infotitle">入党转正时间：</td>
    <td width="230"><?php if($fujing['rdzztime']<1){$fujing['rdzztime']='';} echo form::date('rdzztime',date("Y-m-d",$fujing['rdzztime']),0,0,'false');?></td>    
    <td width="90" align="right" class="infotitle">目前党组织所在单位：</td>
    <td width="230"><input type="text" readonly  id="myname2" name="info[ddanwei]" class="infoinput" value="<?php echo $fujing['ddanwei'];?>"/></td>
  </tr>
  <tr>
    <td width="90" align="right" class="infotitle">辅警号：</td>
    <td width="230"><input type="text" readonly  id="myname2" name="info[gzz]" class="infoinput" value="<?php echo $fujing['gzz'];?>"/></td>
    <td width="90" align="right" class="infotitle">工作转正时间：</td>
    <td width="230"><?php if($fujing['gzzztime']<1){$fujing['gzzztime']='';}echo form::date('gzzztime',date("Y-m-d",$fujing['gzzztime']),0,0,'false');?></td>    
    <td width="90" align="right" class="infotitle">工作证有效期：</td>
    <td width="230"><?php if($fujing['gzztime']<1){$fujing['gzztime']='';} echo form::date('gzztime',date("Y-m-d",$fujing['gzztime']),0,0,'false');?></td>
  </tr>
  <tr>
    <td width="90" align="right" class="infotitle">首次工作时间：</td>
    <td width="230"><?php if($fujing['scgztime']<1){$fujing['scgztime']='';} echo form::date('scgztime',date("Y-m-d",$fujing['scgztime']),0,0,'false');?></td>
    <td width="90" align="right" class="infotitle">用工性质：</td>
    <td><input type="text" readonly  id="myname10" name="info[ygxz]" class="infoinput" value="<?php echo $fujing['ygxz'];?>" /></td>
    <td align="right"><span class="infotitle">备注：</span></td>
    <td><textarea name="info[beizhu]" rows="4" style="width:400px;"><?php echo $fujing['beizhu'];?></textarea></td>    
    </tr>
</table>
</div>

<div class="clear"></div>


<div class="null"></div>

</div>
</form>

</body></html>
<style type="text/css">
#return_up {width:87px;height:40px;background:url(statics/images/return.gif) no-repeat;position:fixed;left:50%;margin-left:450px;top:30px;}
</style>
<div id="return_up" onclick="javascript:history.go(-1);"></div>
<script type="text/javascript">
function jiaoyu(id) {
	window.top.art.dialog({title:'教育培训记录', id:'showme2', iframe:'?m=fujing&c=fujing&a=jiaoyu&id='+id ,width:'800px',height:'500px'});
}
function biaozhang(id) {
	window.top.art.dialog({title:'表彰记录', id:'showme5', iframe:'?m=fujing&c=fujing&a=biaozhang&id='+id ,width:'800px',height:'500px'});
}
function lvli(id) {
	window.top.art.dialog({title:'履历记录', id:'showme6', iframe:'?m=fujing&c=fujing&a=lvli&id='+id ,width:'1000px',height:'500px'});
}
function techang(id) {
	window.top.art.dialog({title:'特长记录', id:'showme7', iframe:'?m=fujing&c=fujing&a=techang&id='+id ,width:'1000px',height:'500px'});
}

function chengjie(id) {
	window.top.art.dialog({title:'惩戒记录', id:'showme5', iframe:'?m=fujing&c=fujing&a=chengjie&id='+id ,width:'800px',height:'500px'});
}
function jiashu(id) {
	window.top.art.dialog({title:'家属列表', id:'showme4', iframe:'?m=fujing&c=fujing&a=jiashu&id='+id ,width:'800px',height:'500px'});
}
function zhuangbei(id) {
	window.top.art.dialog({title:'装备发放记录', id:'showme3', iframe:'?m=fujing&c=fujing&a=zhuangbei&id='+id ,width:'800px',height:'500px'});
}
function showxiang(id) {
	window.top.art.dialog({title:'查看详情', id:'showme', iframe:'?m=bzcj&c=biaozhang&a=show&id='+id ,width:'900px',height:'650px'});
}

</script>



