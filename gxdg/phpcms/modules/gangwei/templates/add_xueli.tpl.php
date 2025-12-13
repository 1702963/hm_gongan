<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<form action="?m=gangwei&c=xueli&a=add" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="90" height="36">学历名称：</th>
		<td width="769"><input type="input" name="info[gwname]"  style="width:400px;"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	

	<tr>
		<th width="90" height="37">学历工资：</th>
		<td width="769"><input type="input" name="info[gongzi]"  style="width:400px;"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
		<td>&nbsp;</td>
	</tr>

</table>
<input type="hidden" name="forward" value="?m=gangwei&c=xueli">
</form>
</div>
</body>
</html>



