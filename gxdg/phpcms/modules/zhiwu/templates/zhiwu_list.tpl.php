<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<div class="table-list">
<form name="myform" id="myform" action="?m=zhiwu&c=zhiwu&a=listorder" method="POST">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="191" align="center">ID</th>
			<th width='890' align="center">职务名称</th>
			
			<th width='890' align="center">职务工资</th>
			<th align="center" width="531">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($zhiwu)){
	foreach($zhiwu as $info){
		?>
	<tr>
		
		
		<td align="center" width="191"><?=$info['id']?></td>
		<td align="center" width="890"><?=$info['zwname']?></td>
		
		<td align="center" width="890"><?=$info['gongzi']?></td>
		<td align="center" width="531"><a href="index.php?m=zhiwu&c=zhiwu&a=edit&id=<?=$info['id']?>">修改</a>&nbsp;&nbsp;<a href="javascript:;" onclick="att_delete(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a></td>
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
	$.get('?m=zhiwu&c=zhiwu&a=delete&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>