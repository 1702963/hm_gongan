<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<div class="pad-lr-10">
<form action="?m=tongzhi&c=tongzhi&a=addtongzhi" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="142">通知标题：</th>
		<td width="1063"><input type="input" name="info[title]"  style="width:400px;"/></td>
	  </tr>
	<tr>
		<th width="142"></th>
		<td width="1063" align="left">        </td>
	  </tr>

<tr>
		<th width="142">通知内容：</th>
		<td width="1063">
		  <textarea name="info[content]" style="width:650px;" id="content" boxid="content" ></textarea><?php echo form::editor('content', 'full','','','',1);?>	    </td>
	  </tr>



	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " style="width:80px" /></td>
	  </tr>
</table>

</form>
</div>
</body>
</html>



