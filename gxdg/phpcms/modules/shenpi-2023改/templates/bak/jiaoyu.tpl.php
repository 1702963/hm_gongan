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
			
			<th width='890' align="center">培训名称</th>
			<th width='890' align="center">开始时间</th>
			<th width='890' align="center">结束时间</th>
			<th width='890' align="center">成绩</th>
			<th width='890' align="center">是否通过</th>
			
		</tr>
	</thead>
<tbody>
<?php
if(is_array($peixun)){
	foreach($peixun as $info){
		?>
	<tr>
		
		
		<td align="center" width="191"><?=$info['id']?></td>
		
		<td align="center" width="890"><?=$info['title']?></td>
		<td align="center" width="890"><?php echo date("Y-m-d",$info['btime']);?></td>
		<td align="center" width="890"><?php echo date("Y-m-d",$info['etime']);?></td>
		<td align="center" width="890"><?=$info['chengji']?></td>
		<td align="center" width="890"><?php if($info['guo']==1){echo "已通过";}else{echo "未通过";}?></td>
		
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
