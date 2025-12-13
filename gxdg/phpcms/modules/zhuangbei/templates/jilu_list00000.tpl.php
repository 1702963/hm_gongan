<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

    
<div class="table-list">
<form name="myform" id="myform" action="?m=zhuangbei&c=zhuangbei&a=listorder" method="POST">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="3%" align="center">ID</th>
			<th width='5%' align="center">辅警姓名</th>			
			<th width='7%' align="center">发放明晰</th>
			<th width='8%' align="center">发放时间</th>
			
		</tr>
	</thead>
<tbody>
<?php
if(is_array($zhuangbei)){
$this->db->table_name = 'mj_fujing';
	foreach($zhuangbei as $info){
	$fz = $this->db->get_one("id=".$info['fjid'],'*');
		?>
	<tr>
		
		
		<td align="center" ><?=$info['id']?></td>
		<td align="center" ><?=$fz['xingming']?></td>
		<td align="center" ><?=$info['zb']?></td>
		<td align="center" ><?php echo date("Y-m-d H:i:s",$info['inputtime']);?></td>
		
		
		
                                       
	</tr>
	<?php
	}
}
?>
</tbody>
</table>

<div id="pages"><?php echo $pages?></div>
</form>
</div>
</div>
</body>
</html>
