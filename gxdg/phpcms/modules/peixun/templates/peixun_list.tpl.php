<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>

<div class="pad-lr-10">

<div class="table-list">
<form name="myform" id="myform" action="?m=peixun&c=peixun&a=listorder" method="POST">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="191" align="center">ID</th>
			<th width='890' align="center">辅警姓名</th>		
			<th width='890' align="center">性别</th>	
			<th width='890' align="center">所在部门</th>		
			<th width='890' align="center">培训名称</th>
			<th width='890' align="center">开始时间</th>
			<th width='890' align="center">结束时间</th>
			<th width='890' align="center">成绩</th>
			<th width='890' align="center">是否通过培训</th>
			<th width='890' align="center">录入时间</th>
			<th width='890' align="center">审核状态</th>
			<th width='890' align="center">审核时间</th>
			<th width='890' align="center">审核说明</th>
			<th align="center" width="531">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($peixun)){
	foreach($peixun as $info){
		?>
	<tr>
		
		
		<td align="center" width="191" ><?=$info['id']?></td>
		<td align="center" width="890"><?=$info['fjname']?></td>
		<td align="center" width="890"><?=$info['sex']?></td>
		<td align="center" width="890"><?=$bms[$info['bmid']]?></td>
		<td align="center" width="890"><?=$info['title']?></td>
		<td align="center" width="890"><?php echo date("Y-m-d",$info['btime']);?></td>
		<td align="center" width="890"><?php echo date("Y-m-d",$info['etime']);?></td>
		<td align="center" width="890"><?=$info['chengji']?></td>
		<td align="center" width="890"><?php if($info['guo']==1){echo "通过";}else{echo "未通过";}?></td>
		<td align="center" width="890"><?php echo date("Y-m-d H:i:s",$info['inputtime']);?></td>
		<td align="center" width="890"><?php if($info['status']==1){echo "待审核";}elseif($info['status']==9){echo "<span style='color:#00FF33'>已通过</span>";}else{echo "<span style='color:#FF0000'>未通过</span>";}?></td>
		<td align="center" width="890"><?php if($info['shtime']>0){echo date("Y-m-d H:i:s",$info['shtime']);}?></td>
		<td align="center" width="890"><?=$info['shnr']?></td>
		<td align="center" width="531"><?php if($info['status']==1){?><a href="javascript:;" onclick="att_delete(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a><?php }?></td>
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
<script type="text/javascript">

function att_delete(obj,aid){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=peixun&c=peixun&a=delete&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>