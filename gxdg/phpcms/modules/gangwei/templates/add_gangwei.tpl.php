<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<form action="?m=gangwei&c=gangwei&a=add" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="129" height="36">岗位类别名称：</th>
		<td width="695"><input type="input" name="info[gwname]"  style="width:400px;"/></td>
		<td width="728">&nbsp;</td>
	</tr>
	

	<tr>
		<th width="129" height="37">岗位类别工资：</th>
		<td width="695"><input type="input" name="info[gongzi]"  style="width:400px;"/></td>
		<td width="728">&nbsp;</td>
	</tr>
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
		<td>&nbsp;</td>
	</tr>

</table>
<input type="hidden" name="forward" value="?m=gangwei&c=gangwei">
</form>
</div>
</body>
</html>



