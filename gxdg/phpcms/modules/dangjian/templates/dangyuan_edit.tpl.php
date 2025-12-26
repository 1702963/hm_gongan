<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');
$info = $this->info;
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
parent.document.getElementById('display_center_id').style.display='none';
//-->
</SCRIPT>

<script type="text/javascript">
<!--
var charset = '<?php echo CHARSET;?>';
var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';
//-->
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<form action="?m=dangjian&c=jiagou&a=editsave" method="POST" name="myform" id="myform">
<input type="hidden" name="id" value="<?php echo $info['id']?>" />
<input type="hidden" name="fujing_id" id="fujing_id" value="<?php echo $info['fujing_id']?>" />

<div class="tableContent">

<div class="tabcon">
<div class="title">编辑党员个人信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span>*</span>姓名：</td>
    <td width="263">
      <input type="text" name="info[xingming]" id="xingming" value="<?php echo $info['xingming']?>" class="infoinput" required style="background:#1a2a4a;color:#fff" />
    </td>
    <td width="100" align="right" class="infotitle"><span>*</span>性别：</td>
    <td width="263">
      <input type="radio" class="rad" name="info[sex]" id="nan" value="男" <?php if($info['sex']=='男') echo 'checked'?>/>男
      <input type="radio" class="rad" name="info[sex]" id="nv" value="女" <?php if($info['sex']=='女') echo 'checked'?>/>女
    </td>
    <td width="100" align="right" class="infotitle">身份证号：</td>
    <td class="rb">
      <input type="text" name="info[sfz]" id="sfz" class="infoinput" value="<?php echo $info['sfz']?>" style="background:#1a2a4a;color:#fff"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">出生年月日：</td>
    <td>
      <input type="text" name="shengri" id="shengri" class="infoinput" value="<?php echo $info['shengri']?>" style="width:200px;background:#1a2a4a;color:#fff" />
    </td>
    <td align="right" class="infotitle">年龄：</td>
    <td>
      <input type="text" name="info[age]" id="age" class="infoinput" value="<?php echo $info['age']?>" style="background:#1a2a4a;color:#fff"/>
      <span style="color:#999;font-size:12px">(自动计算)</span>
    </td>
    <td align="right" class="infotitle">电话：</td>
    <td class="rb">
      <input type="text" name="info[tel]" id="tel" class="infoinput" value="<?php echo $info['tel']?>" style="background:#1a2a4a;color:#fff"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">学历：</td>
    <td>
      <select name="info[xueli]" id="xueli" class="infoselect" style="background:#1a2a4a;color:#fff">
        <option value="">请选择</option>
        <?php foreach($this->xueli as $k=>$v){?>
        <option value="<?php echo $k?>" <?php if($info['xueli']==$k) echo 'selected'?>><?php echo $v?></option>
        <?php }?>
      </select>
    </td>
    <td align="right" class="infotitle">专业：</td>
    <td>
      <input type="text" name="info[zhuanye]" id="zhuanye" class="infoinput" value="<?php echo $info['zhuanye']?>" style="background:#1a2a4a;color:#fff"/>
    </td>
    <td align="right" class="infotitle">毕业学校：</td>
    <td class="rb">
      <input type="text" name="info[xuexiao]" id="xuexiao" class="infoinput" value="<?php echo $info['xuexiao']?>" style="background:#1a2a4a;color:#fff"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">所属单位：</td>
    <td colspan="5">
      <select name="info[dwid]" id="dwid" style="background:#1a2a4a;color:#fff">
        <?php echo $this->select_categorys?>
      </select>
      <script>document.getElementById('dwid').value='<?php echo $info['dwid']?>';</script>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">行政职务：</td>
    <td>
      <select name="info[gangwei]" id="gangwei" class="infoselect" style="background:#1a2a4a;color:#fff">
        <option value="">请选择</option>
        <?php foreach($this->gangwei as $k=>$v){?>
        <option value="<?php echo $k?>" <?php if($info['gangwei']==$k) echo 'selected'?>><?php echo $v?></option>
        <?php }?>
      </select>
    </td>
    <td align="right" class="infotitle">警务职务：</td>
    <td>
      <select name="info[zhiwu]" id="zhiwu" class="infoselect" style="background:#1a2a4a;color:#fff">
        <option value="">请选择</option>
        <?php foreach($this->zhiwu as $k=>$v){?>
        <option value="<?php echo $k?>" <?php if($info['zhiwu']==$k) echo 'selected'?>><?php echo $v?></option>
        <?php }?>
      </select>
    </td>
    <td align="right" class="infotitle">职级（层级）：</td>
    <td class="rb">
      <select name="info[cengji]" id="cengji" class="infoselect" style="background:#1a2a4a;color:#fff">
        <option value="">请选择</option>
        <?php foreach($this->cengji as $k=>$v){?>
        <option value="<?php echo $k?>" <?php if($info['cengji']==$k) echo 'selected'?>><?php echo $v?></option>
        <?php }?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">党内职务：</td>
    <td>
      <select name="info[dangneizhiwu]" id="dangneizhiwu" class="infoselect" style="background:#1a2a4a;color:#fff">
        <option value="">请选择</option>
        <?php if(isset($this->dangneizhiwu) && !empty($this->dangneizhiwu)){foreach($this->dangneizhiwu as $k=>$v){?>
        <option value="<?php echo $k?>" <?php if(isset($info['dangneizhiwu']) && $info['dangneizhiwu']==$k) echo 'selected'?>><?php echo $v?></option>
        <?php }}?>
      </select>
    </td>
    <td align="right" class="infotitle">所在党组织：</td>
    <td colspan="3">
      <select name="info[dangzuzhi]" id="dangzuzhi" class="infoselect" style="background:#1a2a4a;color:#fff">
        <option value="">请选择</option>
        <?php if(isset($this->dangzuzhi) && !empty($this->dangzuzhi)){foreach($this->dangzuzhi as $k=>$v){?>
        <option value="<?php echo $k?>" <?php if(isset($info['dangzuzhi']) && $info['dangzuzhi']==$k) echo 'selected'?>><?php echo $v?></option>
        <?php }}?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">入党时间：</td>
    <td>
      <input type="text" name="rdzztime" id="rdzztime" class="infoinput" value="<?php echo $info['rdzztime']>0?date('Y-m-d',$info['rdzztime']):''?>" style="width:200px;background:#1a2a4a;color:#fff" />
    </td>
    <td align="right" class="infotitle">参加工作时间：</td>
    <td colspan="3">
      <input type="text" name="scgztime" id="scgztime" class="infoinput" value="<?php echo $info['scgztime']>0?date('Y-m-d',$info['scgztime']):''?>" style="width:200px;background:#1a2a4a;color:#fff" />
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">所获荣誉：</td>
    <td colspan="5">
      <textarea name="info[rongy]" id="rongy"
                style="width:500px;height:60px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入所获荣誉"><?php echo $info['rongy']?></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">照片：</td>
    <td colspan="5">
      <input type="hidden" name="info[thumb]" id="thumb" value="<?php echo $info['thumb']?>" />
      <div id="thumb_images" style="margin-top:5px">
        <?php if($info['thumb']){?>
        <img src="<?php echo $info['thumb']?>" width="150" />
        <?php }?>
      </div>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5">
      <textarea name="info[beizhu]" id="beizhu"
                style="width:500px;height:80px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入备注信息"><?php echo $info['beizhu']?></textarea>
    </td>
  </tr>
  <tr>
    <td align="right" class="infotitle"></td>
    <td colspan="5" style="padding-top:20px;padding-left:5px;">
      <input type="submit" name="dosubmit" id="dosubmit" value="保存" class="dialog" style="margin-right:10px;color:white;font-size:12px;" />
      <input type="button" value="返回" class="dialog" onclick="javascript:history.back();" />
    </td>
  </tr>
</table>
</div>

<div class="clear"></div>
<div class="bk15"></div>

</div>

</form>

<script type="text/javascript">
// 根据出生日期自动计算年龄
$('#shengri').on('change', function(){
    var birthday = $(this).val();
    if(birthday){
        var birthdayDate = new Date(birthday);
        var today = new Date();
        var age = today.getFullYear() - birthdayDate.getFullYear();
        var m = today.getMonth() - birthdayDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthdayDate.getDate())) {
            age--;
        }
        $('#age').val(age);
    }
});
</script>

</body>
</html>
