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
			<th width='890' align="center">发放数量</th>
			<th width='890' align="center">发放人</th>
			<th width='890' align="center">发放时间</th>
			<th width='890' align="center">状态</th>
			
		</tr>
	</thead>
<tbody>
<?php
if(is_array($zhuangbei)){
	foreach($zhuangbei as $info){
		?>
	<tr>
		
		
		<td align="center" width="191"><?=$info['id']?></td>
		
		<td align="center" width="890"><?=$zb[$info['zbid']]?></td>
		<td align="center" width="890"><?=$info['ffshu']?></td>
		<td align="center" width="890"><?=$info['ffname']?></td>
		<td align="center" width="890"><?php echo date("Y-m-d",$info['fftime']);?></td>
		<td align="center" width="890"><?php if($info['status']==1){echo "正常使用";}else{echo "已回收";}?></td>
		
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
