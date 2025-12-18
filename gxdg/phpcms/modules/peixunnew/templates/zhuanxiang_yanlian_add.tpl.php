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

<form action="?m=peixunnew&c=zhuanxiang_yanlian&a=addsave" method="POST" name="myform" id="myform">

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">发起专项悬链</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span style="color:red">*</span>组织单位：</td>
    <td colspan="5">
      <select name="info[bmid]" id="bmid" required
              style="width:300px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="0">请选择</option>
        <?php echo $this->select_bumen?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>演练标题：</td>
    <td colspan="5">
      <input type="text" name="info[title]" id="title" value="" required
             style="width:500px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入专项悬链标题"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">演练内容：</td>
    <td colspan="5">
      <textarea name="info[content]" id="content" rows="5"
                style="width:600px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入专项悬链的具体内容（支持文字、图片、视频描述）"></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">演练评价、总结：</td>
    <td colspan="5">
      <textarea name="info[pingjia]" id="pingjia" rows="5"
                style="width:600px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入专项悬链的评价和总结"></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">演练状态：</td>
    <td colspan="5">
      <select name="info[status]" id="status"
              style="width:200px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="1" selected>进行中</option>
        <option value="2">已完成</option>
      </select>
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
