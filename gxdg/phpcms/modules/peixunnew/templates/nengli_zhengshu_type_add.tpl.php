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

<form action="?m=peixunnew&c=nengli_zhengshu_type&a=addsave" method="POST" name="myform" id="myform">

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">添加证书类型</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="120" align="right" class="infotitle"><span style="color:red">*</span>证书名称：</td>
    <td colspan="5">
      <input type="text" name="info[typename]" id="typename" value="" required
             style="width:400px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入证书名称"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">类别：</td>
    <td colspan="5">
      <select name="info[leibie]" id="leibie"
              style="width:220px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="">请选择类别</option>
        <option value="职业资格">职业资格</option>
        <option value="技能等级">技能等级</option>
        <option value="专业证书">专业证书</option>
        <option value="荣誉证书">荣誉证书</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">发证机构：</td>
    <td colspan="5">
      <input type="text" name="info[jigou]" id="jigou" value=""
             style="width:400px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入发证机构"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">有效期（月）：</td>
    <td colspan="5">
      <input type="text" name="info[youxiaoqi]" id="youxiaoqi" value=""
             style="width:150px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入有效期（月）"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">状态：</td>
    <td colspan="5">
      <select name="info[status]" id="status"
              style="width:200px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="1" selected>启用</option>
        <option value="0">停用</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">排序：</td>
    <td colspan="5">
      <input type="text" name="info[paixu]" id="paixu" value="0"
             style="width:100px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="数字越大越靠前"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5">
      <textarea name="info[beizhu]" id="beizhu" rows="4"
                style="width:600px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="备注信息"></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"></td>
    <td colspan="5" style="padding-top:20px;padding-left:5px;">
      <input type="submit" name="dosubmit" id="dosubmit" value="保存" class="dialog" style="margin-right:10px;font-size:14px;" />
      <input type="button" value="返回" class="dialog" onclick="javascript:history.back();" />
    </td>
  </tr>
</table>
</div>

<div class="clear"></div>
<div class="bk15"></div>

</div>

</form>

</body>
</html>
