<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');

$sxtyid=intval($_GET['sxty']);

$sxty[1]="护照";
$sxty[2]="边境通行证";
$sxty[3]="本人参与盈利情况";
$sxty[4]="经商办企";
$sxty[5]="家庭成员";
$sxty[6]="犯罪违法情况";
$sxty[7]="工资";
$sxty[8]="房产";
$sxty[9]="机动车";
$sxty[10]="股票";
$sxty[11]="证券基金";
$sxty[12]="投资型保险";
$sxty[13]="投资情况";

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	if(window.top.$("#current_pos").data('clicknum')==1 || window.top.$("#current_pos").data('clicknum')==null) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?m=admin&c=bumen&a=bumen_tree&pc_hash=<?php echo $_SESSION['pc_hash'];?>&mm=fujing&cc=fujing&aa=init&status=<?php echo $status;?>';
	window.top.$("#current_pos").data('clicknum',0);
}
//-->
</SCRIPT>
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
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<form action="?m=renshi&c=renshi&a=edit" method="POST" name="myform" id="myform">


<style type="text/css">
/*
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
*/
</style>



<div class="tabcon">
<div class="title">基础信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span>姓名：</span></td>
    <td width="263"><input type="text" id="myname2" name="info[xingming]" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="100" align="right" class="infotitle">性别：</td>
    <td width="263"><input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>男
        <input type="radio" class="rad"   name="info[sex]" <?php if($fujing['sex']=='女'){?>checked<?php }?> value="女"/>女</td>    
    <td width="100" align="right" class="infotitle">身份证号：</td>
    <td class="rb"><input type="text" name="info[sfz]" id="myname9" class="infoinput"  value="<?php echo $fujing['sfz'];?>"/>
      
    </td>
    </tr>
  <tr>
    <td align="right" class="infotitle">政治面貌：</td>
    <td width="263">&nbsp;
      <select name="info[zzmm]" id="sexy2" class="infoselect">
        <option value="1" <?php if($fujing['zzmm']==1){?>selected<?php }?>>中共党员</option>
        <option value="2" <?php if($fujing['zzmm']==2){?>selected<?php }?>>共青团员</option>
        <option value="3" <?php if($fujing['zzmm']==3){?>selected<?php }?>>民主党派</option>
        <option value="4" <?php if($fujing['zzmm']==4){?>selected<?php }?>>学生</option>
        <option value="5" <?php if($fujing['zzmm']==5){?>selected<?php }?>>群众</option>
      </select></td>
    <td width="100" align="right" class="infotitle">在职状态</td>
    <td colspan="3"><input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
      现职
        <input type="radio" class="rad"   name="info[sex]" <?php if($fujing['sex']=='女'){?>checked<?php }?> value="女"/>        
        退出现职尚未办理退休手续</td>
    </tr>
  <tr>
    <td align="right" class="infotitle">户籍地址：</td>
    <td width="263"><input type="text" name="info[hjdizhi]" id="myname4" class="infoinput" value="<?php echo $fujing['hjdizhi'];?>" /></td>
    <td width="100" align="right" class="infotitle">民族：</td>
    <td width="263"><select name="info[minzu]" id="sexy3" class="infoselect">
      <option <?php if($fujing['minzu']=='汉族'){?>selected<?php }?> value="汉族" >汉族</option>
      <option <?php if($fujing['minzu']=='蒙古族'){?>selected<?php }?> value="蒙古族">蒙古族</option>
      <option <?php if($fujing['minzu']=='彝族'){?>selected<?php }?> value="彝族">彝族</option>
      <option <?php if($fujing['minzu']=='侗族'){?>selected<?php }?> value="侗族">侗族</option>
      <option <?php if($fujing['minzu']=='哈萨克族'){?>selected<?php }?> value="哈萨克族">哈萨克族</option>
      <option <?php if($fujing['minzu']=='畲族'){?>selected<?php }?> value="畲族">畲族</option>
      <option <?php if($fujing['minzu']=='纳西族'){?>selected<?php }?> value="纳西族">纳西族</option>
      <option <?php if($fujing['minzu']=='仫佬族'){?>selected<?php }?> value="仫佬族">仫佬族</option>
      <option <?php if($fujing['minzu']=='仡佬族'){?>selected<?php }?> value="仡佬族">仡佬族</option>
      <option <?php if($fujing['minzu']=='怒族'){?>selected<?php }?> value="怒族">怒族</option>
      <option <?php if($fujing['minzu']=='保安族'){?>selected<?php }?> value="保安族">保安族</option>
      <option <?php if($fujing['minzu']=='鄂伦春族'){?>selected<?php }?> value="鄂伦春族">鄂伦春族</option>
      <option <?php if($fujing['minzu']=='回族'){?>selected<?php }?> value="回族">回族</option>
      <option <?php if($fujing['minzu']=='壮族'){?>selected<?php }?> value="壮族">壮族</option>
      <option <?php if($fujing['minzu']=='瑶族'){?>selected<?php }?> value="瑶族">瑶族</option>
      <option <?php if($fujing['minzu']=='傣族'){?>selected<?php }?> value="傣族">傣族</option>
      <option <?php if($fujing['minzu']=='高山族'){?>selected<?php }?> value="高山族">高山族</option>
      <option <?php if($fujing['minzu']=='景颇族'){?>selected<?php }?> value="景颇族">景颇族</option>
      <option <?php if($fujing['minzu']=='羌族'){?>selected<?php }?> value="羌族">羌族</option>
      <option <?php if($fujing['minzu']=='锡伯族'){?>selected<?php }?> value="锡伯族">锡伯族</option>
      <option <?php if($fujing['minzu']=='乌孜别克族'){?>selected<?php }?> value="乌孜别克族">乌孜别克族</option>
      <option <?php if($fujing['minzu']=='裕固族'){?>selected<?php }?> value="裕固族">裕固族</option>
      <option <?php if($fujing['minzu']=='赫哲族'){?>selected<?php }?> value="赫哲族">赫哲族</option>
      <option <?php if($fujing['minzu']=='藏族'){?>selected<?php }?> value="藏族">藏族</option>
      <option <?php if($fujing['minzu']=='布依族'){?>selected<?php }?> value="布依族">布依族</option>
      <option <?php if($fujing['minzu']=='白族'){?>selected<?php }?> value="白族">白族</option>
      <option <?php if($fujing['minzu']=='黎族'){?>selected<?php }?> value="黎族">黎族</option>
      <option <?php if($fujing['minzu']=='拉祜族'){?>selected<?php }?> value="拉祜族">拉祜族</option>
      <option <?php if($fujing['minzu']=='柯尔克孜族'){?>selected<?php }?> value="柯尔克孜族">柯尔克孜族</option>
      <option <?php if($fujing['minzu']=='布朗族'){?>selected<?php }?> value="布朗族">布朗族</option>
      <option <?php if($fujing['minzu']=='阿昌族'){?>selected<?php }?> value="阿昌族">阿昌族</option>
      <option <?php if($fujing['minzu']=='俄罗斯族'){?>selected<?php }?> value="俄罗斯族">俄罗斯族</option>
      <option <?php if($fujing['minzu']=='京族'){?>selected<?php }?> value="京族">京族</option>
      <option <?php if($fujing['minzu']=='门巴族'){?>selected<?php }?> value="门巴族">门巴族</option>
      <option <?php if($fujing['minzu']=='维吾尔族'){?>selected<?php }?> value="维吾尔族">维吾尔族</option>
      <option <?php if($fujing['minzu']=='朝鲜族'){?>selected<?php }?> value="朝鲜族">朝鲜族</option>
      <option <?php if($fujing['minzu']=='土家族'){?>selected<?php }?> value="土家族">土家族</option>
      <option <?php if($fujing['minzu']=='傈僳族'){?>selected<?php }?> value="傈僳族">傈僳族</option>
      <option <?php if($fujing['minzu']=='水族'){?>selected<?php }?> value="水族">水族</option>
      <option <?php if($fujing['minzu']=='土族'){?>selected<?php }?> value="土族">土族</option>
      <option <?php if($fujing['minzu']=='撒拉族'){?>selected<?php }?> value="撒拉族">撒拉族</option>
      <option <?php if($fujing['minzu']=='普米族'){?>selected<?php }?> value="普米族">普米族</option>
      <option <?php if($fujing['minzu']=='鄂温克族'){?>selected<?php }?> value="鄂温克族">鄂温克族</option>
      <option <?php if($fujing['minzu']=='塔塔尔族'){?>selected<?php }?> value="塔塔尔族">塔塔尔族</option>
      <option <?php if($fujing['minzu']=='珞巴族'){?>selected<?php }?> value="珞巴族">珞巴族</option>
      <option <?php if($fujing['minzu']=='苗族'){?>selected<?php }?> value="苗族">苗族</option>
      <option <?php if($fujing['minzu']=='满族'){?>selected<?php }?> value="满族">满族</option>
      <option <?php if($fujing['minzu']=='哈尼族'){?>selected<?php }?> value="哈尼族">哈尼族</option>
      <option <?php if($fujing['minzu']=='佤族'){?>selected<?php }?> value="佤族">佤族</option>
      <option <?php if($fujing['minzu']=='东乡族'){?>selected<?php }?> value="东乡族">东乡族</option>
      <option <?php if($fujing['minzu']=='达斡尔族'){?>selected<?php }?> value="达斡尔族">达斡尔族</option>
      <option <?php if($fujing['minzu']=='毛南族'){?>selected<?php }?> value="毛南族">毛南族</option>
      <option <?php if($fujing['minzu']=='塔吉克族'){?>selected<?php }?> value="塔吉克族">塔吉克族</option>
      <option <?php if($fujing['minzu']=='德昂族'){?>selected<?php }?> value="德昂族">德昂族</option>
      <option <?php if($fujing['minzu']=='独龙族'){?>selected<?php }?> value="独龙族">独龙族</option>
      <option <?php if($fujing['minzu']=='基诺族'){?>selected<?php }?> value="基诺族">基诺族</option>
    </select></td>
    <td width="100" align="right" class="infotitle">&nbsp;</td>
    <td class="rb">&nbsp;</td>
    </tr>
  <tr>
    <td align="right" class="infotitle">工作单位</td>
    <td width="263"><input name="info[tel]" type="text" id="myname6" class="infoinput" value="<?php echo $fujing['tel'];?>" /></td>
    <td width="100" align="right" class="infotitle">现任职务</td>
    <td width="263"><input name="myname" type="text" id="myname3" class="infoinput" value="<?php echo $fujing['tel'];?>" /></td>
    <td width="100" align="right" class="infotitle">职级</td>
    <td class="rb"><input name="myname2" type="text" id="myname5" class="infoinput" value="<?php echo $fujing['tel'];?>" /></td>
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
<div class="title" style="width:150px"><?php echo $sxty[$sxtyid]?></div>
<?php if($sxtyid==1){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>护照号：</span></td>
    <td width="289"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">签发日期：</td>
    <td width="344"><?php echo form::date('qianfa',date("Y-m-d"),0,0,'false');?></td>    
    <td width="140" align="right" class="infotitle">有效期至：</td>
    <td width="434"><?php echo form::date('youxiao',date("Y-m-d"),0,0,'false');?></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">保管机构：</td>
    <td width="289"><input type="text" id="myname7" name="myname4" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">备注：</td>
    <td colspan="3"><input type="text" id="myname8" name="myname5" value="<?php echo $fujing['xingming'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==2){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>证件名称：</span></td>
    <td width="289"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">证件号码：</td>
    <td width="344"><input type="text" id="myname11" name="myname7" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>    
    <td width="140" align="right" class="infotitle">有限期限：</td>
    <td width="434"><?php echo form::date('youxiao1',date("Y-m-d"),0,0,'false');?> 至 <?php echo form::date('youxiao2',date("Y-m-d"),0,0,'false');?></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">保管机构：</td>
    <td width="289"><input type="text" id="myname7" name="myname4" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">备注：</td>
    <td colspan="3"><input type="text" id="myname8" name="myname5" value="<?php echo $fujing['xingming'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==3){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="227" align="right" class="infotitle"><span>公司（单位）及职务：</span></td>
    <td width="284"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="123" align="right" class="infotitle">分管工作：</td>
    <td width="465"><input type="text" id="myname12" name="myname8" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>    
    <td width="114" align="right" class="infotitle">兼职时间：</td>
    <td width="220"><?php echo form::date('youxiao1',date("Y-m-d"),0,0,'false');?></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">报酬情况（元/年）：</td>
    <td width="284"><input type="text" id="myname7" name="myname4" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="123" align="right" class="infotitle">备注：</td>
    <td colspan="3"><input type="text" id="myname8" name="myname5" value="<?php echo $fujing['xingming'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==4){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>姓名：</span></td>
    <td width="289"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="211" align="right" class="infotitle">统一社会信用代码：</td>
    <td width="271"><input type="text" id="myname15" name="myname11" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>    
    <td width="110" align="right" class="infotitle">企业或其他<br>市场主体名称：</td>
    <td width="434"><input type="text" id="myname10" name="myname6" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">成立日期：</td>
    <td width="289"><?php echo form::date('youxiao1',date("Y-m-d"),0,0,'false');?></td>
    <td width="211" align="right" class="infotitle">经营范围：</td>
    <td><input type="text" id="myname14" name="myname10" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td align="right" class="infotitle">注册地：</td>
    <td><input type="text" id="myname16" name="myname12" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">经营地：</td>
    <td width="289"><input type="text" id="myname17" name="myname13" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="211" align="right" class="infotitle">企业或其<br>他市场主体类型</td>
    <td colspan="3"><input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
      股份有限公司
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        有限责任公司
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        个体工商户
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        个人独资企业
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        合伙企业<br>
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        在国（境）外注册公司或投资入股
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        其他</td>
  </tr>
  <tr>
    <td align="right" class="infotitle">注册资本或<br>
      资金数额：</td>
    <td width="289"><input type="text" id="myname18" name="myname14" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="211" align="right" class="infotitle">个人认缴出资额<br>
      或个人出资额：</td>
    <td><input type="text" id="myname19" name="myname15" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td align="right" class="infotitle">个人认缴出资比例或个人出资比例：</td>
    <td><input type="text" id="myname20" name="myname16" value="<?php echo $fujing['xingming'];?>" class="infoinput" />
      %</td>
  </tr>
  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5"><input type="text" id="myname13" name="myname9" value="<?php echo $fujing['xingming'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==5){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>姓名：</span></td>
    <td width="289"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">关系：</td>
    <td width="344"><select class="infoselect" name="info[gangwei]" >       
                     <?php foreach($gangwei as $k=>$v){?>
                     <option value="<?php echo $k?>" <?php if($k==$fujing['gangwei']){?>selected="selected"<?php }?>><?php echo $v?></option>
                     <?php }?>
                    </select></td>    
    <td width="140" align="right" class="infotitle">身份证号：</td>
    <td width="434"><input type="text" id="myname10" name="myname6" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">工作单位：</td>
    <td width="289"><input type="text" id="myname7" name="myname4" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">备注：</td>
    <td colspan="3"><input type="text" id="myname8" name="myname5" value="<?php echo $fujing['xingming'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==6){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>姓名：</span></td>
    <td width="289"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">被追究时间：</td>
    <td width="344"><?php echo form::date('youxiao1',date("Y-m-d"),0,0,'false');?></td>    
    <td width="140" align="right" class="infotitle">被追究原因：</td>
    <td width="434"><input type="text" id="myname10" name="myname6" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">处理阶段：</td>
    <td colspan="5"><input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
      立案侦查
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        审查起诉
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        刑事审判
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        刑罚执行
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        执行完毕
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        其他</td>
    </tr>
  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5"><input type="text" id="myname21" name="myname17" value="<?php echo $fujing['xingming'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==7){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>工资：</span></td>
    <td width="206"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="90" align="right" class="infotitle">奖金：</td>
    <td width="273"><input type="text" id="myname22" name="myname18" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>    
    <td width="86" align="right" class="infotitle">其他：</td>
    <td width="229"><input type="text" id="myname10" name="myname6" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="105" align="right">合计：</td>
    <td width="327"><input type="text" id="myname23" name="myname19" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="7" align="left"><input type="text" id="myname8" name="myname5" value="<?php echo $fujing['xingming'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==8){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>产权人姓名：</span></td>
    <td width="289"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="129" align="right" class="infotitle">房产来源：</td>
    <td width="323"><input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
      购买
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        继承
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        接收赠与
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        其他</td>    
    <td width="140" align="right" class="infotitle">建筑面积：</td>
    <td width="434"><input type="text" id="myname10" name="myname6" value="<?php echo $fujing['xingming'];?>" class="infoinput" /> &nbsp;平方米</td>
    </tr>
  <tr>
    <td align="right" class="infotitle">房产性质和功能类型：</td>
    <td width="289"><input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
      商品房
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        福利房
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        经济适用房<br>
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        限价房
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        自建房<br>
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        车库、车位、储藏间
        <input type="radio" class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
        其他</td>
    <td width="129" align="right" class="infotitle">交易时间：</td>
    <td><?php echo form::date('youxiao1',date("Y-m-d"),0,0,'false');?></td>
    <td align="right" class="infotitle">交易价格：</td>
    <td><input type="text" id="myname24" name="myname20" value="<?php echo $fujing['xingming'];?>" class="infoinput" />&nbsp;万元</td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==9){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>车主姓名：</span></td>
    <td width="289"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">关系：</td>
    <td width="344"><select class="infoselect" name="info[gangwei]" >       
                     <?php foreach($gangwei as $k=>$v){?>
                     <option value="<?php echo $k?>" <?php if($k==$fujing['gangwei']){?>selected="selected"<?php }?>><?php echo $v?></option>
                     <?php }?>
                    </select></td>    
    <td width="140" align="right" class="infotitle">车名及型号：</td>
    <td width="434"><input type="text" id="myname10" name="myname6" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">车牌号：</td>
    <td width="289"><input type="text" id="myname7" name="myname4" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">发生日期：</td>
    <td><?php echo form::date('youxiao1',date("Y-m-d"),0,0,'false');?></td>
    <td align="right" class="infotitle">金额（万元）</td>
    <td><input type="text" id="myname25" name="myname21" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==10){?>
<table width="1434" cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="116" align="right" class="infotitle"><span>持有人<br>姓名：</span></td>
    <td width="198"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="136" align="right" class="infotitle">股票名<br>称或代码：</td>
    <td width="215"><input type="text" id="myname26" name="myname22" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>    
    <td width="89" align="right" class="infotitle">持股数量：</td>
    <td width="186"><input type="text" id="myname10" name="myname6" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="137" align="right" class="infotitle">填报前一<br>交易日市值：</td>
    <td width="355"><input type="text" id="myname27" name="myname23" value="<?php echo $fujing['xingming'];?>" class="infoinput" />&nbsp;万元</td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==11){?>
<table width="1434" cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="116" align="right" class="infotitle"><span>持有人<br>姓名：</span></td>
    <td width="198"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="136" align="right" class="infotitle">基金名<br>
      称或代码：</td>
    <td width="215"><input type="text" id="myname26" name="myname22" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>    
    <td width="89" align="right" class="infotitle">基金份额：</td>
    <td width="186"><input type="text" id="myname10" name="myname6" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="137" align="right" class="infotitle">填报前一<br>
    交易日净值：</td>
    <td width="355"><input type="text" id="myname27" name="myname23" value="<?php echo $fujing['xingming'];?>" class="infoinput" />&nbsp;万元</td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==12){?>
<table width="1427" cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="141" align="right" class="infotitle"><span>投保人姓名：</span></td>
    <td width="193"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="143" align="right" class="infotitle">保险产品全称：</td>
    <td width="309"><input type="text" id="myname26" name="myname22" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>    
    <td width="95" align="right" class="infotitle">保单号：</td>
    <td width="544"><input type="text" id="myname10" name="myname6" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">保险公司名称：</td>
    <td width="193"><input type="text" id="myname28" name="myname24" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="143" align="right" class="infotitle">累计缴纳保费、投资金：</td>
    <td colspan="3"><input type="text" id="myname29" name="myname25" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==13){?>
<table width="1427" cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="141" align="right" class="infotitle"><span>投资人姓名：</span></td>
    <td width="193"><input type="text" id="myname" name="myname3" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="143" align="right" class="infotitle">投资的国家地区及城市：</td>
    <td width="309"><input type="text" id="myname26" name="myname22" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>    
    <td width="95" align="right" class="infotitle">投资情况：</td>
    <td width="544"><input type="text" id="myname10" name="myname6" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">币种：</td>
    <td width="193"><input type="text" id="myname28" name="myname24" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="143" align="right" class="infotitle">投资金额：</td>
    <td colspan="3"><input type="text" id="myname29" name="myname25" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5"><input type="text" id="myname21" name="myname17" value="<?php echo $fujing['xingming'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
</div>

<div class="clear"></div>

<div class="tabcon">
<input type="hidden" name="id" value="<?php echo $fujing['id'];?>" />
<input type="hidden" name="status" value="<?php echo $_GET['status'];?>" />
	<input type="submit" class="dowhat" name="dosubmit" value="提交信息" />
</div>
<div class="clear"></div>
<div class="null"></div>

</div>
</form>
<script language="javascript">
function getbmi(){
	if($("#shengao").val()!="" || !isNaN($("#shengao").val()) ){
		if($("#tizhong").val()!="" || !isNaN($("#tizhong").val()) ){
		tmp=$("#tizhong").val()/($("#shengao").val()*$("#shengao").val());	
		  $("#bmi").val(tmp.toFixed(2))
		}
	  }
	}
</script>
>
<div id="return_up" onclick="javascript:history.go(-1);"></div>
</body></html>



