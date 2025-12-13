<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');

		$this->db->table_name = 'v9_zhiwu_mj';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu_mj=array();
		
		foreach($rss as $aaa){
			$zhiwu_mj[$aaa['id']]=$aaa['zwname'];
			
			}
			
		$this->db->table_name = 'v9_zhiwu2_mj';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu2_mj=array();
		
		foreach($rss as $aaa){
			$zhiwu2_mj[$aaa['id']]=$aaa['zwname'];
			
			}
			
		$this->db->table_name = 'v9_zhiwu_zymj';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu_zymj=array();
		
		foreach($rss as $aaa){
			$zhiwu_zymj[$aaa['id']]=$aaa['zwname'];
			
			}	
?>

<script type="text/javascript">
<!--
	var charset = '<?php echo CHARSET;?>';
	var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';
//-->
    parent.document.getElementById('display_center_id').style.display='';
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>dialog.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script> 
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script> 
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<div class="tableContent">

<form action="?m=renshi&c=renshi&a=add" method="POST" name="myform" id="myform">

<div class="topnav" style="width:1080px">
	<div class="thisnav">
    	<a href="javascript:;" onclick="jiashu(<?php echo $fujing['id'];?>);"><div><img src="statics/images/c01.png" /><em>家庭成员</em></div></a>
        <a href="javascript:;" onclick="jiaoyu(<?php echo $fujing['id'];?>);"><div><img src="statics/images/a02.png" /><em>教育培训</em></div></a>
        <a href="javascript:;" onclick="lvli(<?php echo $fujing['id'];?>);"><div><img src="statics/images/a03.png" /><em>履历记录</em></div></a>
        <a href="javascript:;" onclick="techang(<?php echo $fujing['id'];?>);"><div><img src="statics/images/a03.png" /><em>特长记录</em></div></a>
        <a href="javascript:;" onclick="biaozhang(<?php echo $fujing['id'];?>);"><div><img src="statics/images/a03.png" /><em>表彰记录</em></div></a>
		 <a href="javascript:;" onclick="chengjie(<?php echo $fujing['id'];?>);"><div><img src="statics/images/a03.png" /><em>惩戒记录</em></div></a>
         <a href="javascript:;" onclick="kaohe(<?php echo $fujing['id'];?>);"><div><img src="statics/images/a03.png" /><em>考核记录</em></div></a>
        <a href="javascript:;" onclick="zhuangbei(<?php echo $fujing['id'];?>);" style="display:none"><div><img src="statics/images/a04.png" /><em>装备发放</em></div></a>
        <a href="outfj.php?id=<?php echo $fujing['id'];?>" style="display:none"><div><img src="statics/images/a05.png" /><em>基础信息打印</em></div></a>
    </div>
</div>

<div class="tabcon">
<div class="title">基础信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span>姓名：</span></td>
    <td width="263"><input type="text" readonly   id="myname2" name="info[xingming]" value="<?php echo $fujing['xingming'];?>" class="infoinput" /></td>
    <td width="100" align="right" class="infotitle">性别：</td>
    <td width="244"><span class="rb">
      <input type="radio"  class="rad" <?php if($fujing['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>
      男
      <input type="radio"  class="rad"   name="info[sex]" <?php if($fujing['sex']=='女'){?>checked<?php }?> value="女"/>
      女 </span></td>    
    <td width="119" align="right" class="infotitle"><span class="rb">身份证号：</span></td>
    <td width="263" class="rb"><input type="text" readonly  name="info[sfz]" id="myname9" class="infoinput"  value="<?php echo $fujing['sfz'];?>"/></td>
    <td width="180" rowspan="9" valign="top">

    	<div id="headpic"><img width="150" height="217" src="<?php if($fujing['thumb']==''){?>statics/images/demo.jpg<?php }else{?><?php 
		//检查头像源
		$mypicarr=explode("fujing",$fujing['thumb']);
		if(count($mypicarr)>1){
			$mypics="http://20.56.255.150/fujing".$mypicarr[1];
			}else{
				$mypics=$fujing['thumb'];
				} 
		echo $mypics; ?><?php }?>"  id='thumb_preview'/></div>
        
    </td>
  </tr>
  <tr>
    <td align="right" class="infotitle">出生日期：</td>
    <td width="263"><input type="text" readonly  name="info[shengri]" id="myname" class="infoinput" value="<?php echo date("Y-m-d",$fujing['shengri']);?>" /></td>
    <td width="100" align="right" class="infotitle">婚姻状况：</td>
    <td width="244">
      <select name="info[hun]" disabled="disabled" id="sexy3" class="infoselect">
          <option value="不详" <?php if($fujing['hun']=='不详'){?>selected<?php }?>>不详</option>
          <option value="未婚" <?php if($fujing['hun']=='未婚'){?>selected<?php }?>>未婚</option>
		  <option value="已婚" <?php if($fujing['hun']=='已婚'){?>selected<?php }?>>已婚</option>
		  <option value="丧偶 <?php if($fujing['hun']=='丧偶'){?>selected<?php }?>">丧偶</option>
      </select></td>
    <td width="119" align="right" class="infotitle">年龄：</td>
    <td width="263" class="rb"><input type="text" readonly  id="myname5" name="info[age]" value="<?php echo $fujing['age'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle"><span>家庭住址：</span></td>
    <td width="263"><input type="text" readonly  name="info[jzd]" id="myname3" class="infoinput" value="<?php echo $fujing['jzd'];?>" /></td>
    <td width="100" align="right" class="infotitle"><span>籍贯：</span></td>
    <td width="244"><input type="text" readonly  name="info[hjdizhi]" id="myname4" class="infoinput" value="<?php echo $fujing['hjdizhi'];?>" /></td>
    <td width="119" align="right" class="infotitle">出生地：</td>
    <td width="263" class="rb"><input type="text" readonly  name="info[hjdizhi]" id="myname4" class="infoinput" value="<?php echo $fujing['chushengdi'];?>" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">联系电话：</td>
    <td width="263"><input name="info[tel]" type="text" id="myname6" class="infoinput" value="<?php echo $fujing['tel'];?>" /></td>
    <td width="100" align="right" class="infotitle">政治面貌：</td>
    <td width="244"><select name="info[zzmm]" disabled="disabled" id="sexy2" class="infoselect">
      <option value="1" <?php if($fujing['zzmm']==1){?>selected<?php }?>>中共党员</option>
	  <option value="2" <?php if($fujing['zzmm']==2){?>selected<?php }?>>共青团员</option>
      <option value="3" <?php if($fujing['zzmm']==3){?>selected<?php }?>>民主党派</option>
      <option value="4" <?php if($fujing['zzmm']==4){?>selected<?php }?>>学生</option>
      <option value="5" <?php if($fujing['zzmm']==5){?>selected<?php }?>>群众</option> 
      <option value="6" <?php if($fujing['zzmm']==6){?>selected<?php }?>>中共预备党员</option>  
	  
    </select></td>
    <td width="119" align="right" class="infotitle">是否退伍军人：</td>
    <td width="263" class="rb"><select name="info[tuiwu]" disabled="disabled" id="sexy3" class="infoselect">
        <option value="1" <?php if($fujing['tuiwu']==1){?>selected<?php }?>>否</option>
		 <option value="2" <?php if($fujing['tuiwu']==2){?>selected<?php }?>>是</option>
		
      </select></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">熟悉专业：</td>
    <td width="263"><input name="info[zhuanchang]" type="text" id="myname6" class="infoinput" value="<?php echo $fujing['zhuanchang'];?>" /></td>
    <td width="100" align="right" class="infotitle">健康情况：</td>
    <td width="244"><select name="info[tuiwu]" id="info[jiankang]" class="infoselect">
      <option value="1" <?php if($fujing['jiankang']=="健康"){?>selected<?php }?>>健康</option>
      <option value="2" <?php if($fujing['jiankang']=="疾病"){?>selected<?php }?>>疾病</option>
    </select></td>
    <td width="119" align="right" class="infotitle">&nbsp;</td>
    <td width="263" class="rb">&nbsp;</td>
    </tr>
  <tr>
    <td rowspan="2" align="right" class="infotitle">全日制<br />
      毕业院校：</td>
    <td width="263" rowspan="2"><input type="text" id="myname7" name="info[xuexiao]" class="infoinput" value="<?php echo $fujing['xuexiao'];?>"/></td>
    <td width="100" rowspan="2" align="right" class="infotitle">所学专业：</td>
    <td width="244" rowspan="2"><input type="text" name="info[zhuanye]" id="myname8" class="infoinput" value="<?php echo $fujing['zhuanye'];?>" /></td>
    <td width="119" align="right" class="infotitle">学历：</td>
    <td width="263" class="rb"><select name="info[xueli]">
      <?php foreach($xueli as $k=>$v){?>
      <option value="<?php echo $k?>" <?php if($k==intval($fujing['xueli'])){?>selected="selected"<?php }?>><?php echo $v?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td align="right" class="infotitle">学位：</td>
    <td width="263" class="rb"><input type="text" id="myname7" name="info[xuewei]" class="infoinput" value="<?php echo $fujing['xuewei'];?>"/></td>
  </tr>
  <tr>
    <td rowspan="2" align="right" class="infotitle">在职教育<br />
      毕业院校：</td>
    <td width="263" rowspan="2"><input type="text" id="myname7" name="info[zz_xuexiao]" class="infoinput" value="<?php echo $fujing['zz_xuexiao'];?>"/></td>
    <td width="100" rowspan="2" align="right" class="infotitle">所学专业：</td>
    <td width="244" rowspan="2"><input type="text" name="info[zz_zhuanye]" id="myname8" class="infoinput" value="<?php echo $fujing['zz_zhuanye'];?>" /></td>
    <td width="119" align="right" class="infotitle">学历：</td>
    <td width="263" class="rb"><select name="info[zz_xueli]">
      <?php foreach($xueli as $k=>$v){?>
      <option value="<?php echo $k?>" <?php if($k==intval($fujing['zz_xueli'])){?>selected="selected"<?php }?>><?php echo $v?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td align="right" class="infotitle">学位：</td>
    <td width="263" class="rb"><input type="text" id="myname7" name="info[zz_xuewei]" class="infoinput" value="<?php echo $fujing['zz_xuewei'];?>"/></td>
  </tr>
  <tr>
    <td align="right" class="infotitle">民族：</td>
    <td width="263"><select name="info[minzu]" disabled="disabled"  id="sexy3" class="infoselect">
	<option value="">未知</option>
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
    <td width="100" align="right" class="infotitle">身高</td>
    <td colspan="4"><input type="text" readonly  name="info[shengao]" id="shengao" class="infoinput" value="<?php echo $fujing['shengao'];?>" style="width:50px"/> 米 &nbsp;&nbsp;体重
      <input type="text" readonly  name="info[tizhong]" id="tizhong" class="infoinput" value="<?php echo $fujing['tizhong'];?>" style="width:50px"/> 
      公斤 &nbsp;&nbsp; BMI <input type="text" readonly  name="info[bmi]" id="bmi" class="infoinput" value="<?php echo $fujing['bmi'];?>" style="width:50px"/></td>
    </tr>
</table>
</div>




<div class="clear"></div>

<div class="tabcon">
<div class="title">扩展信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="123" align="right" class="infotitle"><span>归属单位：</span></td>
    <td width="400"><?php echo $bms[$fujing['dwid']];?></td>
    <td width="84" align="right" class="infotitle">入警时间：</td>
    <td width="203"><?php echo form::date('rjtime',date("Y-m-d",$fujing['rjtime']),0,0,'false');?></td>    
    <td width="90" align="right" class="infotitle">在职状态：</td>
    <td width="168"><?php $sss=array(1=>'在职',2=>'离职',3=>'死亡',4=>'退休',5=>'其他');?>
      <select class="infoselect" name="info[status]" >       
        <?php foreach($sss as $k=>$v){?>
        <option value="<?php echo $k?>" <?php if($k==$fujing['status']){?>selected="selected"<?php }?>><?php echo $v?></option>
        <?php }?>
        </select></td>
  </tr>
  <tr>
    <td width="123" align="right" class="infotitle">行政职务：</td>
    <td width="400"><select class="infoselect" name="info[zhiwu]" > 
                      <option value="0">无</option>
                     <?php foreach($zhiwu_mj as $k=>$v){?>
                     <option value="<?php echo $k?>" <?php if($k==$fujing['zhiwu']){?>selected="selected"<?php }?>><?php echo $v?></option>
                     <?php }?>
          </select></td>
    <td width="84" align="right" class="infotitle">警务职务：</td>
    <td width="203"><select class="infoselect" name="info[zhiwu2]" > 
                      <option value="0">无</option>
                     <?php foreach($zhiwu2_mj as $k=>$v){?>
                     <option value="<?php echo $k?>" <?php if($k==$fujing['zhiwu2']){?>selected="selected"<?php }?>><?php echo $v?></option>
                     <?php }?>
          </select></td>    
    <td width="90" align="right" class="infotitle">专业技术职务：</td>
    <td><select class="infoselect" name="info[zy_zhiwu]" > 
                      <option value="0">无</option>
                     <?php foreach($zhiwu_zymj as $k=>$v){?>
                     <option value="<?php echo $k?>" <?php if($k==$fujing['zy_zhiwu']){?>selected="selected"<?php }?>><?php echo $v?></option>
                     <?php }?>
                    </select></td>
    </tr>
  
  <tr>
    <td width="123" align="right" class="infotitle">入党时间：</td>
    <td width="400"><?php if($fujing['rdtime']<1){$fujing['rdtime']='';} echo form::date('rdtime',date("Y-m-d",$fujing['rdtime']),0,0,'false');?></td>
    <td width="84" align="right" class="infotitle">入党转正时间：</td>
    <td width="203"><?php if($fujing['rdzztime']<1){$fujing['rdzztime']='';} echo form::date('rdzztime',date("Y-m-d",$fujing['rdzztime']),0,0,'false');?></td>    
    <td width="90" align="right" class="infotitle">目前党组织所在单位：</td>
    <td><input type="text" readonly  id="myname2" name="info[ddanwei]" class="infoinput" value="<?php echo $fujing['ddanwei'];?>"/></td>
  </tr>
  <tr>
    <td width="123" align="right" class="infotitle">警号：</td>
    <td width="400"><input type="text" readonly  id="myname2" name="info[gzz]" class="infoinput" value="<?php echo $fujing['gzz'];?>"/></td>
    <td width="84" align="right" class="infotitle">&nbsp;</td>
    <td width="203">&nbsp;</td>    
    <td width="90" align="right" class="infotitle">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="123" align="right" class="infotitle">备注：</td>
    <td width="400"><textarea name="info[beizhu]" rows="4" style="width:400px;"><?php echo $fujing['beizhu'];?></textarea></td>
    <td width="84" align="right" class="infotitle">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" class="infotitle">&nbsp;</td>
    <td>&nbsp;</td>    
    </tr>
	<tr>
    <td width="123" align="right" class="infotitle">&nbsp;</td>
    <td width="400">&nbsp;</td>
    <td width="84" align="right" class="infotitle"></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
</table>
</div>

<div class="clear"></div>


<div class="null"></div>


</form>

</div>

</body></html>

<div id="return_up" onclick="javascript:history.go(-1);"></div>
<script type="text/javascript">
function jiaoyu(id) {
	window.top.art.dialog({title:'教育培训记录', id:'showme2', iframe:'?m=renshi&c=renshi&a=jiaoyu_mj&id='+id ,width:'1200px',height:'500px'},function(){alert("1")},function(){parent.document.getElementById('display_center_id').style.display='';});

}
function biaozhang(id) {
	window.top.art.dialog({title:'表彰记录', id:'showme5', iframe:'?m=renshi&c=renshi&a=biaozhang_mj&id='+id ,width:'1200px',height:'500px'},function(){alert("1")},function(){parent.document.getElementById('display_center_id').style.display='';});
}
function lvli(id) {
	window.top.art.dialog({title:'履历记录', id:'showme6', iframe:'?m=renshi&c=renshi&a=lvli_mj&id='+id ,width:'1200px',height:'500px'},function(){alert("1")},function(){parent.document.getElementById('display_center_id').style.display='';});
}
function techang(id) {
	window.top.art.dialog({title:'特长记录', id:'showme7', iframe:'?m=renshi&c=renshi&a=techang_mj&id='+id ,width:'1200px',height:'500px'},function(){alert("1")},function(){parent.document.getElementById('display_center_id').style.display='';});
}

function chengjie(id) {
	window.top.art.dialog({title:'惩戒记录', id:'showme5', iframe:'?m=renshi&c=renshi&a=chengjie_mj&id='+id ,width:'1200px',height:'500px'},function(){alert("1")},function(){parent.document.getElementById('display_center_id').style.display='';});
}
function kaohe(id) {
	window.top.art.dialog({title:'考核记录', id:'showme5', iframe:'?m=renshi&c=renshi&a=kaohe_mj&id='+id ,width:'1200px',height:'500px'},function(){alert("1")},function(){parent.document.getElementById('display_center_id').style.display='';});
}

function jiashu(id) {
	window.top.art.dialog({title:'家属列表', id:'showme4', iframe:'?m=renshi&c=renshi&a=jiashu_mj&id='+id ,width:'1200px',height:'500px'},function(){alert("1")},function(){parent.document.getElementById('display_center_id').style.display='';});
}
function zhuangbei(id) {
	window.top.art.dialog({title:'装备发放记录', id:'showme3', iframe:'?m=renshi&c=renshi&a=zhuangbei&id='+id ,width:'800px',height:'500px'},function(){alert("1")},function(){parent.document.getElementById('display_center_id').style.display='';});
}
function showxiang(id) {
	window.top.art.dialog({title:'查看详情', id:'showme', iframe:'?m=bzcj&c=biaozhang&a=show&id='+id ,width:'900px',height:'650px'},function(){alert("1")},function(){parent.document.getElementById('display_center_id').style.display='';});
}
function prints(id) {
	window.top.art.dialog({title:'打印', id:'showme', iframe:'?m=renshi&c=renshi&a=dao2doc&id='+id ,width:'900px',height:'650px'},function(){alert("1")},function(){parent.document.getElementById('display_center_id').style.display='';});
}
</script>



