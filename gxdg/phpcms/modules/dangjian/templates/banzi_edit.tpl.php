<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');
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
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<form action="?m=dangjian&c=chengyuan&a=editbz" method="POST" name="myform" id="myform">
<input type="hidden" name="id" value="<?php echo $info['id']?>" />

<style type="text/css">
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
<div class="title">班子成员信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span style="color:red">*</span>辅警信息：</td>
    <td colspan="5">
      <input type="text" id="basexm" value="<?php echo $info['xingming']?> [<?php echo $info['sex']?>, <?php echo $info['sfz']?>]"
             class="infoinput" readonly
             style="width:500px;background:transparent;color:#fff"/>
      <span style="color:#999;margin-left:10px">*辅警信息不可修改，只能修改党关系所在支部和备注</span>
    </td>
  </tr>
  <tr>
    <td width="100" align="right" class="infotitle"><span>*</span>姓名：</td>
    <td width="263">
      <input type="text" name="info[xingming]" id="xingming" value="<?php echo $info['xingming']?>" class="infoinput" readonly style="background:transparent;color:#fff" />
    </td>
    <td width="100" align="right" class="infotitle"><span>*</span>性别：</td>
    <td width="263">
      <input type="radio" class="rad" <?php echo $info['sex']=='男'?'checked':''?> name="info[sex]" id="nan" value="男" disabled/>男
      <input type="radio" class="rad" <?php echo $info['sex']=='女'?'checked':''?> name="info[sex]" id="nv" value="女" disabled/>女
    </td>
    <td width="100" align="right" class="infotitle">身份证号：</td>
    <td class="rb">
      <input type="text" name="info[sfz]" id="sfz" class="infoinput" value="<?php echo $info['sfz']?>" readonly style="background:transparent;color:#fff"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">出生年月日：</td>
    <td>
      <input type="text" name="shengri" id="shengri" class="infoinput" value="<?php echo $info['shengri']?>"
             readonly style="width:200px;background:transparent;color:#fff" />
    </td>
    <td align="right" class="infotitle">年龄：</td>
    <td>
      <input type="text" name="info[age]" id="age" class="infoinput" value="<?php echo $info['age']?>" readonly style="background:transparent;color:#fff"/>
      <span style="color:#999;font-size:12px">(自动计算)</span>
    </td>
    <td align="right" class="infotitle">电话：</td>
    <td class="rb">
      <input type="text" name="info[tel]" id="tel" class="infoinput" value="<?php echo $info['tel']?>" readonly style="background:transparent;color:#fff"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">学历：</td>
    <td>
      <select name="info[xueli]" id="xueli" class="infoselect" disabled style="background:transparent;color:#fff">
        <option value="">请选择</option>
        <?php foreach($xueli as $k=>$v){?>
        <option value="<?php echo $k?>" <?php echo $info['xueli']==$k?'selected':''?>><?php echo $v?></option>
        <?php }?>
      </select>
    </td>
    <td align="right" class="infotitle">专业：</td>
    <td>
      <input type="text" name="info[zhuanye]" id="zhuanye" class="infoinput" value="<?php echo $info['zhuanye']?>" readonly style="background:transparent;color:#fff"/>
    </td>
    <td align="right" class="infotitle">毕业学校：</td>
    <td class="rb">
      <input type="text" name="info[xuexiao]" id="xuexiao" class="infoinput" value="<?php echo $info['xuexiao']?>" readonly style="background:transparent;color:#fff"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">所属单位：</td>
    <td colspan="5">
      <select name="info[dwid]" id="dwid" disabled style="background:transparent;color:#fff">
        <?php echo $select_categorys?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">岗位：</td>
    <td>
      <select name="info[gangwei]" id="gangwei" class="infoselect" disabled style="background:transparent;color:#fff">
        <option value="">请选择</option>
        <?php foreach($gangwei as $k=>$v){?>
        <option value="<?php echo $k?>" <?php echo $info['gangwei']==$k?'selected':''?>><?php echo $v?></option>
        <?php }?>
      </select>
    </td>
    <td align="right" class="infotitle">职务：</td>
    <td>
      <select name="info[zhiwu]" id="zhiwu" class="infoselect" disabled style="background:transparent;color:#fff">
        <option value="">请选择</option>
        <?php foreach($zhiwu as $k=>$v){?>
        <option value="<?php echo $k?>" <?php echo $info['zhiwu']==$k?'selected':''?>><?php echo $v?></option>
        <?php }?>
      </select>
    </td>
    <td align="right" class="infotitle">职级（层级）：</td>
    <td class="rb">
      <select name="info[cengji]" id="cengji" class="infoselect" disabled style="background:transparent;color:#fff">
        <option value="">请选择</option>
        <?php foreach($cengji as $k=>$v){?>
        <option value="<?php echo $k?>" <?php echo $info['cengji']==$k?'selected':''?>><?php echo $v?></option>
        <?php }?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">入党时间：</td>
    <td>
      <input type="text" name="rdzztime" id="rdzztime" class="infoinput" value="<?php echo $info['rdzztime_show']?>"
             readonly style="width:200px;background:transparent;color:#fff" />
    </td>
    <td align="right" class="infotitle">参加工作时间：</td>
    <td colspan="3">
      <input type="text" name="scgztime" id="scgztime" class="infoinput" value="<?php echo $info['scgztime_show']?>"
             readonly style="width:200px;background:transparent;color:#fff" />
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>党关系所在支部：</td>
    <td colspan="5">
      <input type="text" name="info[ddanwei]" id="ddanwei"
             style="width:500px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             value="<?php echo $info['ddanwei']?>" placeholder="请输入党关系所在支部"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">所获荣誉：</td>
    <td colspan="5">
      <textarea name="info[rongy]" id="rongy" readonly
                style="width:500px;height:60px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="此字段只读，来自表彰管理"><?php
                // 获取荣誉列表
                $bzlist_show = '';
                if($info['fujing_id']) {
                    $bzdb = pc_base::load_model('opinion2_model');
                    $bzdb->table_name = 'v9_biaozhang';
                    $bzlist = $bzdb->select(" fjid={$info['fujing_id']} AND status=9 ", 'title,bztime', '5', 'bztime desc');
                    if($bzlist) {
                        $bzarr = array();
                        foreach($bzlist as $bz) {
                            $bzarr[] = date("Y年", $bz['bztime']) . ' ' . $bz['title'];
                        }
                        $bzlist_show = implode("\n", $bzarr);
                    }
                }
                echo $bzlist_show;
                ?></textarea>
      <br/>
      <span style="color:#999;font-size:12px;margin-left:10px">*此字段从表彰管理中自动获取，只读</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">照片：</td>
    <td colspan="5">
      <input type="hidden" name="info[thumb]" id="thumb" value="<?php echo $info['thumb']?>" />
      <?php if($info['thumb']){?>
      <div id="thumb_images" style="margin-top:5px">
        <img src="<?php echo $info['thumb']?>" width="150" />
      </div>
      <?php }else{?>
      <div id="thumb_images" style="margin-top:5px"></div>
      <?php }?>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5">
      <textarea name="info[beizhu]" id="beizhu"
                style="width:500px;height:80px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
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