<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<div class="table-list">

<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="191" align="center">ID</th>
					
			<th width='890' align="center">装备名称</th>
			
			<th width='890' align="center">发放时间</th>
			
			
		</tr>
	</thead>
<tbody>
<?php
if(is_array($zhuangbei)){
$i=1;
	foreach($zhuangbei as $info){
		?>
	<tr>
		
		
		<td align="center" width="191"><?=$i?></td>
		
		
		<td align="center" width="890"><?=$info['zb']?></td>
		<td align="center" width="890"><?php echo date("Y-m-d",$info['inputtime']);?></td>
	
		
	</tr>
	<?php
	$i++;}
}
?>
</tbody>
</table>



</div>
</div>
</body>
</html>
