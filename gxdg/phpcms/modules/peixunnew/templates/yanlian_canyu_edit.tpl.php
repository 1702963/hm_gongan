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
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<form action="?m=peixunnew&c=yanlian_canyu&a=editsave" method="POST" name="myform" id="myform">

<input type="hidden" name="id" value="<?php echo $this->info['id']?>" />

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">编辑参与人</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle">演练类型：</td>
    <td colspan="5">
      <input type="text" value="<?php echo $this->info['yanlian_type'] == 1 ? '对抗训练' : '专项悬链'?>" readonly
             style="width:300px;height:20px;background:transparent;color:#ccc;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">演练记录：</td>
    <td colspan="5">
      <input type="text" value="<?php echo isset($this->yanlian_list[$this->info['yanlian_id']]) ? $this->yanlian_list[$this->info['yanlian_id']]['title'] : ''?>" readonly
             style="width:400px;height:20px;background:transparent;color:#ccc;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">参与人员：</td>
    <td colspan="5">
      <input type="text" value="<?php echo $this->info['fjname'] ?? ''?>" readonly
             style="width:400px;height:20px;background:transparent;color:#ccc;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>分组：</td>
    <td colspan="5">
      <select name="info[fengzu]" id="fengzu" required style="width:300px;height:25px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="1" <?php echo $this->info['fengzu'] == 1 ? 'selected' : ''?>>红方</option>
        <option value="2" <?php echo $this->info['fengzu'] == 2 ? 'selected' : ''?>>蓝方</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">评分：</td>
    <td colspan="5">
      <input type="number" name="info[pingjia_score]" id="pingjia_score" value="<?php echo $this->info['pingjia_score']?>" step="0.01" min="0" max="100"
             style="width:300px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入评分（0-100）"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">表现描述：</td>
    <td colspan="5">
      <textarea name="info[biaoxianbiao]" id="biaoxianbiao" rows="4"
                style="width:500px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入表现描述"><?php echo $this->info['biaoxianbiao']?></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">创建时间：</td>
    <td colspan="5">
      <input type="text" value="<?php echo $this->info['inputtime_show']?>" readonly
             style="width:300px;height:20px;background:transparent;color:#ccc;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
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
