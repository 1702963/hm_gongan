<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<form action="?m=zhuangbei&c=zblx&a=edit" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="90">装备类型：</th>
		<td width="769"><input type="input" name="info[zblx]" value="<?php echo $zblx['zblx']?>"  style="width:400px;"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	

	
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
		<td>&nbsp;</td>
	</tr>

</table>
<input type="hidden" name="id" value="<?=$zblx['id']?>">
<input type="hidden" name="forward" value="?m=zblx&c=zblx">
</form>
</div>
</body>
</html>



