<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<style type="text/css">
.input-text {width:455px;height:32px;}
.table_form {font-size:14px;}
.table_form td {height:80px}
.table_form td , .table_form tbody td , .table_form th , .table_form tbody th {background:#f7f7f7;border-bottom:5px solid #fff;border-right:5px solid #fff}
.table_form td span {margin-left:10px}
.button {background:#09c;font-size:14px;border-radius:3px;float:left;margin-left:120px;}
.button:hover {background:#f60}
input.button, input.btn {width:120px;height:32px;font-size:12px}
</style>
<div class="pad-lr-10">
<form action="?m=cengji&c=cengji&a=add" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="90" height="36">层级名称：</th>
		<td width="769"><input type="input" name="info[cjname]"  class="input-text"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th width="90" height="36">工作年限：</th>
		<td width="769"><input type="input" name="info[nx1]"   class="input-text" style="width:210px;"/>&nbsp;至&nbsp;<input type="input" name="info[nx2]"   class="input-text" style="width:210px;"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th width="90" height="37">层级工资：</th>
		<td width="769"><input type="input" name="info[gongzi]"  class="input-text"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th colspan="3" height="80"><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></th>
	  </tr>
</table>
<input type="hidden" name="forward" value="?m=cengji&c=cengji">
</form>
</div>
</body>
</html>



