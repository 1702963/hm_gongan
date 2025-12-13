<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<div class="pad-lr-10">
<form action="?m=tongzhi&c=tongzhi&a=addtongzhi" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<td width="1063" align="center" style="font-size:16px;"><strong><?php echo $hys['title'];?></strong></td>
	  </tr>
	<tr>
		<td width="1063" align="center" >     <?php echo date("Y-m-d H:i:s",$hys['inputtime']);?>   </td>
	  </tr>

<tr>
		<td width="1063">
		  <tr>
		<td width="1063"><?php echo $hys['content'];?></td>
	  </tr>
	  </tr>
</table>

</form>
</div>
</body>
</html>



