<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">
<form action="?m=gangwei&c=techang&a=edit&id=<?php echo $id?>" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	<tr>
		<th width="260" height="37">分类归属：</th>
		<td colspan="2"><select name="info[pid]">
                         <option value="0">作为主类别</option>
                         <?php foreach($mainclass as $k=>$v){
							 if($k!=$techangs['id']){
							 ?>
                          <option value="<?php echo $k?>" <?php if($techangs['pid']==$k){?>selected="selected"<?php }?>><?php echo $v?></option>
                         <?php }}?>
                        </select></td>
	  </tr>	
	
	<tr>
		<th width="260">分类名称：</th>
		<td colspan="2"><input type="input" name="info[classname]" value="<?php echo $techangs['classname']?>"  style="width:400px;"/></td>
	  </tr>

	<tr>
		<th width="260" height="37">启用状态：</th>
		<td colspan="2"><select name="info[isok]" >
                          <option value="0" <?php if($techangs['isok']==0){?>selected="selected"<?php }?>>禁用</option>
                          <option value="1" <?php if($techangs['isok']==1){?>selected="selected"<?php }?>>启用</option>
                        </select>
        </td>
	  </tr>    
	<tr>
		<th></th>
		<td width="549"><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " style="display:none"/></td>
		<td width="743">&nbsp;</td>
	</tr>

</table>
<input type="hidden" name="id" value="<?=$techangs['id']?>">
<input type="hidden" name="forward" value="?m=gangwei&c=techang">
</form>
</div>
</body>
</html>



