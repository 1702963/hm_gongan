<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">


<table width="100%" cellspacing="0" border="1" style="margin-right:10px">

		<tr>
            <td width="9%" align="center" style="font-size:12px">提醒来源</td>
            <td width="91%" align="left" style="font-size:12px"><?PHP echo $infos['yuan']?></td>
		</tr>


	<tr>		
		<td align="center" style="font-size:12px">提醒时间</td>
		<td align="left" style="font-size:12px"><?PHP echo date("Y-m-d H:i:s",$infos['adddt'])?></td>
	</tr>
	<tr>
	  <td align="center" style="font-size:12px">提醒内容</td>
	  <td align="left" style="font-size:12px"><?PHP echo $infos['msg']?></td>
	</tr>
	<tr>
	  <td align="center" style="font-size:12px">附加链接</td>
	  <td align="left" style="font-size:12px"><?PHP echo $infos['msgurl']?></td>
	</tr>
</table>

</div>
</div>
</body>
</html>
