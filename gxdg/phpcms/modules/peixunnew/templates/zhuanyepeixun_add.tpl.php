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
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<form action="?m=peixunnew&c=zhuanyepeixun&a=addsave" method="POST" name="myform" id="myform">

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">专业培训计划</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="120" align="right" class="infotitle">所属业务警种：</td>
    <td colspan="5">
      <select name="info[bmid]" id="bmid"
              style="width:300px;height:28px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="0">请选择</option>
        <?php echo $this->select_bumen?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>培训来源：</td>
    <td colspan="5">
      <select name="info[pxly]" id="pxly"
              style="width:300px;height:28px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="">请选择</option>
        <option value="警衔系统">警衔系统</option>
        <option value="河网干院">河网干院</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>培训类型：</td>
    <td colspan="5">
      <select name="info[type]" id="type"
              style="width:300px;height:28px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="">请选择</option>
        <option value="业务培训">业务培训</option>
        <option value="应急演练">应急演练</option>
        <option value="制度培训">制度培训</option>
        <option value="实战培训">实战培训</option>
        <option value="理论培训">理论培训</option>
        <option value="专业培训">专业培训</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>培训标题：</td>
    <td colspan="5">
      <input type="text" name="info[title]" id="title" value="" required
             style="width:500px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入培训标题"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">来源内标题：</td>
    <td colspan="5">
      <input type="text" name="info[ly_title]" id="ly_title" value=""
             style="width:500px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="培训来源内的标题"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">培训要求/条件：</td>
    <td colspan="5">
      <textarea name="info[yaoqiu]" id="yaoqiu" rows="4"
                style="width:500px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入培训要求、条件"></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">培训开始时间：</td>
    <td colspan="5">
      <input type="date" name="info[btime]" id="btime" value=""
             style="width:200px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">培训结束时间：</td>
    <td colspan="5">
      <input type="date" name="info[etime]" id="etime" value=""
             style="width:200px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">是否必须参加：</td>
    <td colspan="5">
      <select name="info[bixu]" id="bixu"
              style="width:150px;height:28px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="0">否</option>
        <option value="1">是</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">状态：</td>
    <td colspan="5">
      <select name="info[status]" id="status"
              style="width:150px;height:28px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;">
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
