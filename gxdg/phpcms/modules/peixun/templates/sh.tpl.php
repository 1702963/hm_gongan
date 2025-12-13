<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<div class="pad-lr-10">
<form action="?m=peixun&c=peixun&a=sh" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="689" height="37">成绩：</th>
		<td width="961"><input type="input" name="info[chengji]"  style="width:200px;"/></td>
		
	</tr>
	<tr>
		<th width="689" height="36">是否通过培训：</th>
		<td width="961"><?php echo form::select(array(1=>'通过',2=>'未通过'),$peixun['guo'],'name=info[guo] infoselect')?></td>
		
	</tr>
	
	<tr>
		<th width="689" height="36">审核结果：</th>
		<td width="961"><?php echo form::select(array(9=>'通过',2=>'未通过',1=>'待审核'),$peixun['status'],'name=info[status] infoselect')?></td>
	  </tr>
	<tr>
		<th width="689" height="37">审核内容：</th>
		<td width="961"><textarea name="info[shnr]" cols="" rows="5"><?php echo $peixun['shnr'];?></textarea></td>
	  </tr>
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
	  </tr>
</table>
<input type="hidden" name="id" value="<?=$id?>">
</form>
</div>
</body>
</html>



