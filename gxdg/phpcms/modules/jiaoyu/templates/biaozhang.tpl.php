<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<div class="table-list">

<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="70" align="center">ID</th>
				
			<th width='619' align="center">标题</th>
			<th width='240' align="center">表彰奖励时间</th>
			
			<th width='217' align="center">奖励金额</th>
			
			
		</tr>
	</thead>
<tbody>
<?php
if(is_array($biaozhang)){
	foreach($biaozhang as $info){
		?>
	<tr>
		
		
		<td align="center" width="70"><?=$info['id']?></td>
		
		<td align="center" width="619"><?=$info['title']?></td>
		<td align="center" width="240"><?php echo date("Y-m-d",$info['bztime']);?></td>
		
		<td align="center" width="217"><?=$info['gongzi']?></td>
		
	</tr>
	<?php
	}
}
?>
</tbody>
</table>


</div>
</div>
</body>
</html>
