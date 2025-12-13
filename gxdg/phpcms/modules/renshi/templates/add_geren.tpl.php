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


if($_POST['dosubmit']!=""){
//print_r($_POST);	
//人员信息入表，并生成主记录
$_indt=time();
$_ns=date("Y",$_indt);
$_ms=date("m",$_indt);
$_ds=date("d",$_indt);
$_tjdt=strtotime(date("Y-m-d",$_indt));

$this->db->table_name = 'v9_renshi_sx';
$_POST['info']['indt']=$_indt;
$_POST['info']['ns']=$_ns;
$_POST['info']['ms']=$_ms;
$_POST['info']['ds']=$_ds;
$_POST['info']['tjdt']=$_tjdt;
$newid=$this->db->insert($_POST['info'],true);
//echo $newid;
//处理业务记录

foreach($_POST['shi'] as $k=>$v){
  $inyw['spid']=$newid;
  $inyw['indt']=$_indt;
  $inyw['ns']=$_ns;
  $inyw['ms']=$_ms;
  $inyw['ds']=$_ds;
  $inyw['tjdt']=$_tjdt;
  $inyw['sxty']=$_POST['info']['sxty'];
  $inyw['uid']=$_POST['info']['uid'];
  $inyw['xingming']=$_POST['info']['xingming'];
  $inyw['fname']=$k;
  $inyw['vals']=$v;	
  $this->db->insert($inyw);
	}
  showmessage('操作完成','index.php?m=renshi&c=geren&a=init');
}


?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//	if(window.top.$("#current_pos").data('clicknum')==1 || window.top.$("#current_pos").data('clicknum')==null) {
	parent.document.getElementById('display_center_id').style.display='none';
//	parent.document.getElementById('center_frame').src = '?m=admin&c=bumen&a=bumen_tree&pc_hash=<?php echo $_SESSION['pc_hash'];?>&mm=renshi&cc=geren&aa=init&status=<?php echo $status;?>';
//	window.top.$("#current_pos").data('clicknum',0);
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
<form action="?m=renshi&c=geren&a=addsx&sxty=<?php echo intval($_GET['sxty']) ?>" method="POST" name="myform" id="myform">
<input type="hidden" name="info[sxty]" value="<?php echo intval($_GET['sxty']) ?>" />

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
    #inputlist{
	  position: absolute;
	  z-index:999;
	  background-color:#28348e;	
      margin: 0;
      padding: 0;
      border: 1px solid #ccc;
            width: 300px;
            display: none;
    }
    #inputlist ul,li{
      list-style: none;
    }
    #inputlist ul{
      padding: 0;
    }
    #inputlist ul li{
            line-height: 30px;
            font-size: 14px;
            text-indent: 5px;
    }
    #inputlist ul li:hover{
      background: #E0E0E8;
	  color:#28348e;
    }
</style>

<div class="tableContent">

<div class="tabcon">
<div class="title">基础信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span>姓名：</span><input type="hidden" name="info[uid]" id="uid" value="0" /><input type="hidden" name="info[dwid]" id="dwid" value="0" /></td>
    <td width="263"><input type="text" id="basexm" name="info[xingming]" value="<?php echo $sx['xingming'];?>" class="infoinput" />
    <div id="inputlist">
        <ul>
        </ul>
    </div>    
    </td>
    <td width="100" align="right" class="infotitle">性别：</td>
    <td width="263"><input type="radio" class="rad" <?php if($sx['sex']=='男'){?>checked<?php }?>  name="info[sex]"  id="nan" value="男"/>男
        <input type="radio" class="rad"   name="info[sex]" <?php if($sx['sex']=='女'){?>checked<?php }?> value="女" id="nv"/>女</td>    
    <td width="100" align="right" class="infotitle">身份证号：</td>
    <td class="rb"><input type="text" name="info[sfz]" id="sfz" class="infoinput"  value="<?php echo $sx['sfz'];?>"/>
      
    </td>
    </tr>
  <tr>
    <td align="right" class="infotitle">政治面貌：</td>
    <td width="263"><input type="text" name="info[zzmm]" id="zzmm" class="infoinput"  value="<?php echo $sx['zzmm'];?>" /></td>
    <td width="100" align="right" class="infotitle">在职状态</td>
    <td colspan="3"><input type="radio" class="rad" checked  name="info[zaizhi]" id="zzhi" value="现职"/>
      现职
        <input type="radio" class="rad"   name="info[zaizhi]" <?php if($sz['zaizhi']=='退休'){?>checked<?php }?> id="txiu" value="退出现职尚未办理退休手续"/>        
        退出现职尚未办理退休手续</td>
    </tr>
  <tr>
    <td align="right" class="infotitle">户籍地址：</td>
    <td width="263"><input type="text" name="info[hjdizhi]" id="hjdizhi" class="infoinput" value="<?php echo $sx['hjdizhi'];?>" /></td>
    <td width="100" align="right" class="infotitle">民族：</td>
    <td width="263"><input type="text" name="info[minzu]" id="minzu" class="infoinput" value="<?php echo $sx['minzu'];?>" /></td>
    <td width="100" align="right" class="infotitle">&nbsp;</td>
    <td class="rb">&nbsp;</td>
    </tr>
  <tr>
    <td align="right" class="infotitle">工作单位</td>
    <td width="263"><input name="info[danwei]" type="text" id="danwei" class="infoinput" value="<?php echo $sx['danwei'];?>" /></td>
    <td width="100" align="right" class="infotitle">现任职务</td>
    <td width="263"><input name="info[zhiwu]" type="text" id="zhiwu" class="infoinput" value="<?php echo $sx['zhiwu'];?>" /></td>
    <td width="100" align="right" class="infotitle">职级</td>
    <td class="rb"><input name="info[zhiji]" type="text" id="zhiji" class="infoinput" value="<?php echo $sx['zhiji'];?>" /></td>
    </tr>
</table>
</div>

<div class="clear"></div>

<div class="tabcon">
<div class="title" style="width:150px"><?php echo $sxty[$sxtyid]?></div>
<?php if($sxtyid==1){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>护照号：</span></td>
    <td width="289"><input type="text" id="huzhaohao" name="shi[huzhaohao]" value="<?php echo $sx['huzhaohao'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">签发日期：</td>
    <td width="344"><?php echo form::date('shi[qianfa]',date("Y-m-d"),0,0,'false');?></td>    
    <td width="140" align="right" class="infotitle">有效期至：</td>
    <td width="434"><?php echo form::date('shi[youxiao]',date("Y-m-d"),0,0,'false');?></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">保管机构：</td>
    <td width="289"><input type="text" id="baoguanjigou" name="shi[baoguanjigou]" value="<?php echo $sx['baoguanjigou'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">备注：</td>
    <td colspan="3"><input type="text" id="beizhu" name="shi[beizhu]" value="<?php echo $sx['beizhu'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==2){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>证件名称：</span></td>
    <td width="289"><input type="text" id="zhengjianmingcheng" name="shi[zhengjianmingcheng]" value="<?php echo $sx['zhengjianmingcheng'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">证件号码：</td>
    <td width="344"><input type="text" id="zhengjianhaoma" name="shi[zhengjianhaoma]" value="<?php echo $sx['zhengjianhaoma'];?>" class="infoinput" /></td>    
    <td width="140" align="right" class="infotitle">有限期限：</td>
    <td width="434"><?php echo form::date('shi[youxiao1]',date("Y-m-d"),0,0,'false');?> 至 <?php echo form::date('shi[youxiao2]',date("Y-m-d"),0,0,'false');?></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">保管机构：</td>
    <td width="289"><input type="text" id="baoguanjigou" name="shi[baoguanjigou]" value="<?php echo $sx['baoguanjigou'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">备注：</td>
    <td colspan="3"><input type="text" id="beizhu" name="shi[beizhu]" value="<?php echo $sx['beizhu'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==3){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="227" align="right" class="infotitle"><span>公司（单位）及职务：</span></td>
    <td width="284"><input type="text" id="gszhiwu" name="shi[gszhiwu]" value="<?php echo $sx['gszhiwu'];?>" class="infoinput" /></td>
    <td width="123" align="right" class="infotitle">分管工作：</td>
    <td width="465"><input type="text" id="fenguangongzuo" name="shi[fenguangongzuo]" value="<?php echo $sx['fenguangongzuo'];?>" class="infoinput" /></td>    
    <td width="114" align="right" class="infotitle">兼职时间：</td>
    <td width="220"><?php echo form::date('shi[jianzhishijian]',date("Y-m-d"),0,0,'false');?></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">报酬情况（元/年）：</td>
    <td width="284"><input type="text" id="baochou" name="shi[baochou]" value="<?php echo $sx['baochou'];?>" class="infoinput" /></td>
    <td width="123" align="right" class="infotitle">备注：</td>
    <td colspan="3"><input type="text" id="beizhu" name="shi[beizhu]" value="<?php echo $sx['beizhu'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==4){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>姓名：</span></td>
    <td width="289"><input type="text" id="farenxingming" name="shi[farenxingming]" value="<?php echo $sx['farenxingming'];?>" class="infoinput" /></td>
    <td width="211" align="right" class="infotitle">统一社会信用代码：</td>
    <td width="271"><input type="text" id="tongyidaima" name="shi[tongyidaima]" value="<?php echo $sx['tongyidaima'];?>" class="infoinput" /></td>    
    <td width="110" align="right" class="infotitle">企业或其他<br>市场主体名称：</td>
    <td width="434"><input type="text" id="qiyemingcheng" name="shi[qiyemingcheng]" value="<?php echo $sx['qiyemingcheng'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">成立日期：</td>
    <td width="289"><?php echo form::date('shi[chenglishijian]',date("Y-m-d"),0,0,'false');?></td>
    <td width="211" align="right" class="infotitle">经营范围：</td>
    <td><input type="text" id="jingyingfanwei" name="shi[jingyingfanwei]" value="<?php echo $sx['jingyingfanwei'];?>" class="infoinput" /></td>
    <td align="right" class="infotitle">注册地：</td>
    <td><input type="text" id="zhicedi" name="shi[zhucedi]" value="<?php echo $sx['zhicedi'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">经营地：</td>
    <td width="289"><input type="text" id="jingyingdi" name="shi[jingyingdi]" value="<?php echo $sx['jingyingdi'];?>" class="infoinput" /></td>
    <td width="211" align="right" class="infotitle">企业或其<br>他市场主体类型</td>
    <td colspan="3"><input type="radio" class="rad" <?php if($sx['leixing']=='股份有限公司'){?>checked<?php }?>  name="shi[leixing]" value="股份有限公司"/>
      股份有限公司
        <input type="radio" class="rad" <?php if($sx['leixing']=='有限责任公司'){?>checked<?php }?>  name="shi[leixing]" value="有限责任公司"/>
        有限责任公司
        <input type="radio" class="rad" <?php if($sx['leixing']=='个体工商户'){?>checked<?php }?>  name="shi[leixing]" value="个体工商户"/>
        个体工商户
        <input type="radio" class="rad" <?php if($sx['leixing']=='个人独资企业'){?>checked<?php }?>  name="shi[leixing]" value="个人独资企业"/>
        个人独资企业
        <input type="radio" class="rad" <?php if($sx['leixing']=='合伙企业'){?>checked<?php }?>  name="shi[leixing]" value="合伙企业"/>
        合伙企业<br>
        <input type="radio" class="rad" <?php if($sx['leixing']=='在国（境）外注册公司或投资入股'){?>checked<?php }?>  name="shi[leixing]" value="在国（境）外注册公司或投资入股"/>
        在国（境）外注册公司或投资入股
        <input type="radio" class="rad" <?php if($sx['leixing']=='其他'){?>checked<?php }?>  name="shi[leixing]" value="其他"/>
        其他</td>
  </tr>
  <tr>
    <td align="right" class="infotitle">注册资本或<br>
      资金数额：</td>
    <td width="289"><input type="text" id="zhuceziben" name="shi[zhicezhiben]" value="<?php echo $sx['zhiceziben'];?>" class="infoinput" /></td>
    <td width="211" align="right" class="infotitle">个人认缴出资额<br>
      或个人出资额：</td>
    <td><input type="text" id="gerenchuzi" name="shi[gerenchuzi]" value="<?php echo $sx['gerenchuzhi'];?>" class="infoinput" /></td>
    <td align="right" class="infotitle">个人认缴出资比例或个人出资比例：</td>
    <td><input type="text" id="chuzibili" name="shi[chuzibili]" value="<?php echo $sx['chuzibili'];?>" class="infoinput" />
      %</td>
  </tr>
  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5"><input type="text" id="beihzu" name="shi[beizhu]" value="<?php echo $sx['beizhu'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==5){
  $guanxi=array("配偶","儿子","女儿","父亲","母亲","祖父","祖母","外祖父","外祖母","岳父","岳母","哥哥","弟弟","姐姐","妹妹","其他");	
	
	?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>姓名：</span></td>
    <td width="289"><input type="text" id="qinshuxingming" name="shi[qinshuxingming]" value="<?php echo $sx['qinshuxingming'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">关系：</td>
    <td width="344"><select class="infoselect" name="shi[guanxi]" >       
                     <?php foreach($guanxi as $k=>$v){?>
                     <option value="<?php echo $v?>" <?php if($v==$sx['guanxi']){?>selected="selected"<?php }?>><?php echo $v?></option>
                     <?php }?>
                    </select></td>    
    <td width="140" align="right" class="infotitle">身份证号：</td>
    <td width="434"><input type="text" id="sfz" name="shi[sfz]" value="<?php echo $sx['sfz'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">工作单位：</td>
    <td width="289"><input type="text" id="gongzuodanwei" name="shi[gongzuodanwei]" value="<?php echo $sx['gongzuodanwei'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">备注：</td>
    <td colspan="3"><input type="text" id="beizhu" name="shi[beizhu]" value="<?php echo $sx['beizhu'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==6){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>姓名：</span></td>
    <td width="289"><input type="text" id="qishuxingming" name="shi[qinshuxingming]" value="<?php echo $sx['qinshuxingming'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">被追究时间：</td>
    <td width="344"><?php echo form::date('shi[zuijiushijian]',date("Y-m-d"),0,0,'false');?></td>    
    <td width="140" align="right" class="infotitle">被追究原因：</td>
    <td width="434"><input type="text" id="zhuijiuyuanyin" name="shi[zhuijiushijian]" value="<?php echo $sx['zhuijiushijian'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">处理阶段：</td>
    <td colspan="5"><input type="radio" class="rad" <?php if($sx['sex']=='立案侦查'){?>checked<?php }?>  name="shi[jieduan]" value="立案侦查"/>
      立案侦查
        <input type="radio" class="rad" <?php if($sx['jieduan']=='审查起诉'){?>checked<?php }?>  name="shi[jieduan]" value="审查起诉"/>
        审查起诉
        <input type="radio" class="rad" <?php if($sx['jieduan']=='刑事审判'){?>checked<?php }?>  name="shi[jieduan]" value="刑事审判"/>
        刑事审判
        <input type="radio" class="rad" <?php if($sx['jieduan']=='刑罚执行'){?>checked<?php }?>  name="shi[jieduan]" value="刑罚执行"/>
        刑罚执行
        <input type="radio" class="rad" <?php if($sx['jieduan']=='执行完毕'){?>checked<?php }?>  name="shi[jieduan]" value="执行完毕"/>
        执行完毕
        <input type="radio" class="rad" <?php if($sx['jieduan']=='其他'){?>checked<?php }?>  name="shi[jieduan]" value="其他"/>
        其他</td>
    </tr>
  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5"><input type="text" id="beizhu" name="shi[beizhu]" value="<?php echo $sx['beizhu'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==7){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>工资：</span></td>
    <td width="206"><input type="text" id="gongzi" name="shi[gongzi]" value="<?php echo $sx['gongzi'];?>" class="infoinput" /></td>
    <td width="90" align="right" class="infotitle">奖金：</td>
    <td width="273"><input type="text" id="jiangjin" name="shi[jiangjin]" value="<?php echo $sx['jiangjin'];?>" class="infoinput" /></td>    
    <td width="86" align="right" class="infotitle">其他：</td>
    <td width="229"><input type="text" id="qita" name="shi[qita]" value="<?php echo $sx['qita'];?>" class="infoinput" /></td>
    <td width="105" align="right">合计：</td>
    <td width="327"><input type="text" id="heji" name="shi[heji]" value="<?php echo $sx['heji'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="7" align="left"><input type="text" id="beizhu" name="shi[beizhu]" value="<?php echo $sx['beizhu'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==8){?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>产权人姓名：</span></td>
    <td width="289"><input type="text" id="chanquanren" name="shi[chanquanren]" value="<?php echo $sx['chanquanren'];?>" class="infoinput" /></td>
    <td width="129" align="right" class="infotitle">房产来源：</td>
    <td width="323"><input type="radio" class="rad" <?php if($sx['sex']=='购买'){?>checked<?php }?>  name="shi[laiyuan]" value="购买"/>
      购买
        <input type="radio" class="rad" <?php if($sx['laiyuan']=='继承'){?>checked<?php }?>  name="shi[laiyuan]" value="继承"/>
        继承
        <input type="radio" class="rad" <?php if($sx['laiyuan']=='接收赠与'){?>checked<?php }?>  name="shi[laiyuan]" value="接收赠与"/>
        接收赠与
        <input type="radio" class="rad" <?php if($sx['laiyuan']=='其他'){?>checked<?php }?>  name="shi[laiyuan]" value="其他"/>
        其他</td>    
    <td width="140" align="right" class="infotitle">建筑面积：</td>
    <td width="434"><input type="text" id="jianzhumianji" name="shi[jianzhumianji]" value="<?php echo $sx['jianzhumianji'];?>" class="infoinput" /> &nbsp;平方米</td>
    </tr>
  <tr>
    <td align="right" class="infotitle">房产性质和功能类型：</td>
    <td width="289"><input type="radio" class="rad" <?php if($sx['xingzhi']=='商品房'){?>checked<?php }?>  name="shi[xingzhi]" value="商品房"/>
      商品房
        <input type="radio" class="rad" <?php if($sx['xingzhi']=='福利房'){?>checked<?php }?>  name="shi[xingzhi]" value="福利房"/>
        福利房
        <input type="radio" class="rad" <?php if($sx['xingzhi']=='经济适用房'){?>checked<?php }?>  name="shi[xingzhi]" value="经济适用房"/>
        经济适用房<br>
        <input type="radio" class="rad" <?php if($sx['xingzhi']=='限价房'){?>checked<?php }?>  name="shi[xingzhi]" value="限价房"/>
        限价房
        <input type="radio" class="rad" <?php if($sx['xingzhi']=='自建房'){?>checked<?php }?>  name="shi[xingzhi]" value="自建房"/>
        自建房<br>
        <input type="radio" class="rad" <?php if($sx['xingzhi']=='车库、车位、储藏间'){?>checked<?php }?>  name="shi[xingzhi]" value="车库、车位、储藏间"/>
        车库、车位、储藏间
        <input type="radio" class="rad" <?php if($sx['xingzhi']=='其他'){?>checked<?php }?>  name="shi[xingzhi]" value="其他"/>
        其他</td>
    <td width="129" align="right" class="infotitle">交易时间：</td>
    <td><?php echo form::date('shi[jiaoyishijian]',date("Y-m-d"),0,0,'false');?></td>
    <td align="right" class="infotitle">交易价格：</td>
    <td><input type="text" id="jiaoyijiage" name="shi[jiaoyijiage]" value="<?php echo $sx['jiaoyijiage'];?>" class="infoinput" />&nbsp;万元</td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==9){
 $guanxi=array("配偶","儿子","女儿","父亲","母亲","祖父","祖母","外祖父","外祖母","岳父","岳母","哥哥","弟弟","姐姐","妹妹","其他");		
	?>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="118" align="right" class="infotitle"><span>车主姓名：</span></td>
    <td width="289"><input type="text" id="chezhu" name="shi[chezhu]" value="<?php echo $sx['chezhu'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">关系：</td>
    <td width="344"><select class="infoselect" name="shi[guanxi]" >       
                     <?php foreach($guanxi as $k=>$v){?>
                     <option value="<?php echo $v?>" <?php if($v==$sx['guanxi']){?>selected="selected"<?php }?>><?php echo $v?></option>
                     <?php }?>
                    </select></td>    
    <td width="140" align="right" class="infotitle">车名及型号：</td>
    <td width="434"><input type="text" id="xinghao" name="shi[xinghao]" value="<?php echo $sx['xinghao'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">车牌号：</td>
    <td width="289"><input type="text" id="chepai" name="shi[chepai]" value="<?php echo $sx['chepai'];?>" class="infoinput" /></td>
    <td width="108" align="right" class="infotitle">发生日期：</td>
    <td><?php echo form::date('shi[goumairiqi]',date("Y-m-d"),0,0,'false');?></td>
    <td align="right" class="infotitle">金额（万元）</td>
    <td><input type="text" id="jine" name="shi[jine]" value="<?php echo $sx['jine'];?>" class="infoinput" /></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==10){?>
<table width="1434" cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="116" align="right" class="infotitle"><span>持有人<br>姓名：</span></td>
    <td width="198"><input type="text" id="chiyouren" name="shi[chiyouren]" value="<?php echo $sx['chiyouren'];?>" class="infoinput" /></td>
    <td width="136" align="right" class="infotitle">股票名<br>称或代码：</td>
    <td width="215"><input type="text" id="gupiaodaima" name="shi[gupiaodaima]" value="<?php echo $sx['gupiaodaima'];?>" class="infoinput" /></td>    
    <td width="89" align="right" class="infotitle">持股数量：</td>
    <td width="186"><input type="text" id="chigushuliang" name="shi[chigushuliang]" value="<?php echo $sx['chigushuliang'];?>" class="infoinput" /></td>
    <td width="137" align="right" class="infotitle">填报前一<br>交易日市值：</td>
    <td width="355"><input type="text" id="shizhi" name="shi[shizhi]" value="<?php echo $sx['shizhi'];?>" class="infoinput" />&nbsp;万元</td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==11){?>
<table width="1434" cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="116" align="right" class="infotitle"><span>持有人<br>姓名：</span></td>
    <td width="198"><input type="text" id="chiyouren" name="chiyouren" value="<?php echo $sx['chiyouren'];?>" class="infoinput" /></td>
    <td width="136" align="right" class="infotitle">基金名<br>
      称或代码：</td>
    <td width="215"><input type="text" id="jijindaima" name="shi[jijidanma]" value="<?php echo $sx['jijindaima'];?>" class="infoinput" /></td>    
    <td width="89" align="right" class="infotitle">基金份额：</td>
    <td width="186"><input type="text" id="fene" name="shi[fene]" value="<?php echo $sx['fene'];?>" class="infoinput" /></td>
    <td width="137" align="right" class="infotitle">填报前一<br>
    交易日净值：</td>
    <td width="355"><input type="text" id="jingzhi" name="shi[jingzhi]" value="<?php echo $sx['jingzhi'];?>" class="infoinput" />&nbsp;万元</td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==12){?>
<table width="1427" cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="141" align="right" class="infotitle"><span>投保人姓名：</span></td>
    <td width="193"><input type="text" id="toubaoren" name="shi[toubaoren]" value="<?php echo $sx['toubaoren'];?>" class="infoinput" /></td>
    <td width="143" align="right" class="infotitle">保险产品全称：</td>
    <td width="309"><input type="text" id="baoxianmingcheng" name="shi[baoxianmingcheng]" value="<?php echo $sx['baoxianmingcheng'];?>" class="infoinput" /></td>    
    <td width="95" align="right" class="infotitle">保单号：</td>
    <td width="544"><input type="text" id="baodanhao" name="shi[baodanhao]" value="<?php echo $sx['baodanhao'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">保险公司名称：</td>
    <td width="193"><input type="text" id="baoxiangongsi" name="shi[baoxiangongsi]" value="<?php echo $sx['baoxiangongsi'];?>" class="infoinput" /></td>
    <td width="143" align="right" class="infotitle">累计缴纳保费、投资金：</td>
    <td colspan="3"><input type="text" id="baofei" name="shi[baofei]" value="<?php echo $sx['baofei'];?>" class="infoinput" /></td>
    </tr>
</table>
<?php }?>
<?php if($sxtyid==13){?>
<table width="1427" cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="141" align="right" class="infotitle"><span>投资人姓名：</span></td>
    <td width="193"><input type="text" id="touzhiren" name="shi[touziren]" value="<?php echo $sx['touziren'];?>" class="infoinput" /></td>
    <td width="143" align="right" class="infotitle">投资的国家地区及城市：</td>
    <td width="309"><input type="text" id="touzidiqu" name="shi[touzidiqu]" value="<?php echo $sx['touzidiqu'];?>" class="infoinput" /></td>    
    <td width="95" align="right" class="infotitle">投资情况：</td>
    <td width="544"><input type="text" id="touziqingkuang" name="shi[touziqingkuang]" value="<?php echo $sx['touziqingkuang'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">币种：</td>
    <td width="193"><input type="text" id="bizhong" name="shi[bizhong]" value="<?php echo $sx['bizhong'];?>" class="infoinput" /></td>
    <td width="143" align="right" class="infotitle">投资金额：</td>
    <td colspan="3"><input type="text" id="touzie" name="shi[touzie]" value="<?php echo $sx['touzie'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5"><input type="text" id="beizhu" name="shi[beizhu]" value="<?php echo $sx['beizhu'];?>" class="infoinput" style="width:90%"/></td>
    </tr>
</table>
<?php }?>
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
function getbmi(){
	if($("#shengao").val()!="" || !isNaN($("#shengao").val()) ){
		if($("#tizhong").val()!="" || !isNaN($("#tizhong").val()) ){
		tmp=$("#tizhong").val()/($("#shengao").val()*$("#shengao").val());	
		  $("#bmi").val(tmp.toFixed(2))
		}
	  }
	}
	///////////////////////////////////////////////////////////////
     $(function(){
        $("#basexm").bind("keyup click",function(){
          var t=$(this),_html="";
         /*
		  window.baidu= {};
          window.baidu.sug = function(data){
            var x = JSON.stringify(data);
            x=JSON.parse(x); 
            var abc = x.s;
            for(var i=0; i<abc.length; i++){
              _html+="<li>"+abc[i]+"</li>";
            }
            $("#inputlist ul").html(_html);
            if(t.val() == ""){
              $("#inputlist").hide();
            }else{
              $("#inputlist").show();
              }
            if($("#inputlist").html() == ""){
              $("#inputlist").hide();
            }
                }; */
                $.ajax({
                  async:false,
                  url:'api/getuser.php?sel='+t.val(),
                  dataType:'json',
                  //jsonp:"mycallback",
                  //jsonpCallback:"window.baidu.sug"
                  success: function(data) {
                  var x = JSON.stringify(data);
                  x=JSON.parse(x); 
			      if(x.errnum==0){
			//var abc = x.data;
			console.log(x.data)	
            for(var i=0; i<x.data.length; i++){
              _html+="<li id="+x.data[i].id+" xm="+x.data[i].xingming+" sfz="+x.data[i].sfz+" sex="+x.data[i].sex+" zzmm="+x.data[i].zzmmname+" hj="+x.data[i].hjdizhi+" mz="+x.data[i].minzu+" dw="+x.data[i].danwei+" dwid="+x.data[i].dwid+" zw="+x.data[i].zhiwuname+" zj="+x.data[i].cengjiname+">"+x.data[i][0]+"["+x.data[i].sex+","+x.data[i].shenfen+"，"+x.data[i].danwei+"]</li>";
            }}
            $("#inputlist ul").html(_html);
            if(t.val() == ""){
              $("#inputlist").hide();
            }else{
              $("#inputlist").show();
              }
            if($("#inputlist").html() == ""){
              $("#inputlist").hide();
            }	

					 },				  
                });
        });
 
        $(document).delegate("#inputlist ul li","click",function(){
		  $("#uid").val($(this).attr("id"))	
		  $("#basexm").val($(this).attr("xm"))	
		  if($(this).attr('sex')=="男"){
			  $("#nan").attr("checked","checked");
			  }else{
				$("#nv").attr("checked","checked");  
				  }      
         $("#sfz").val($(this).attr('sfz'))
		 $("#zzmm").val($(this).attr('zzmm'))
         $("#hjdizhi").val($(this).attr('hj'))
		 $("#minzu").val($(this).attr('mz'))
		 $("#danwei").val($(this).attr('dw'))
		 $("#dwid").val($(this).attr('dwid'))
		 $("#zhiwu").val($(this).attr('zw'))
		 $("#zhiji").val($(this).attr('zj'))		  		  
        })
 
       //$(document).delegate("#submit","click",function(){
       //   var key = $("#search").val();
       //   //点击
       // })
 
        $(document).click(function(){
          $("#inputlist").hide();
        })
      });	
</script>
>

</div>
<div id="return_up" onclick="javascript:history.go(-1);"></div>
</body></html>



