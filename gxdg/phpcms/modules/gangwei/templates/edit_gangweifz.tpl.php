<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<form action="?m=gangwei&c=gangweifz&a=edit" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="132">辅助岗位名称：</th>
		<td width="692"><input type="input" name="info[gwname]" value="<?php echo $gangwei['gwname']?>"  style="width:400px;"/></td>
		<td width="728">&nbsp;</td>
	</tr>
	

	<tr>
		<th width="132" height="37">辅助岗位工资：</th>
		<td width="692"><input type="input" name="info[gongzi]" value="<?php echo $gangwei['gongzi']?>"  style="width:400px;"/></td>
		<td width="728">&nbsp;</td>
	</tr>
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
		<td>&nbsp;</td>
	</tr>

</table>
<input type="hidden" name="id" value="<?=$gangwei['id']?>">
<input type="hidden" name="forward" value="?m=gangwei&c=gangweifz">
</form>
</div>
</body>
</html>



