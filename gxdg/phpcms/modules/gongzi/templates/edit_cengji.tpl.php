<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<form action="?m=cengji&c=cengji&a=edit" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="90">层级名称：</th>
		<td width="769"><input type="input" name="info[cjname]" value="<?php echo $cengji['cjname']?>"  style="width:400px;"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	
<tr>
		<th width="90" height="36">工作年限：</th>
		<td width="769"><input type="input" name="info[nx1]" value="<?php echo $cengji['nx1']?>"  style="width:180px;"/>&nbsp;至&nbsp;<input type="input" name="info[nx2]" value="<?php echo $cengji['nx2']?>" style="width:180px;"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th width="90" height="37">层级工资：</th>
		<td width="769"><input type="input" name="info[gongzi]" value="<?php echo $cengji['gongzi']?>"  style="width:400px;"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
		<td>&nbsp;</td>
	</tr>

</table>
<input type="hidden" name="id" value="<?=$cengji['id']?>">
<input type="hidden" name="forward" value="?m=cengji&c=cengji">
</form>
</div>
</body>
</html>



