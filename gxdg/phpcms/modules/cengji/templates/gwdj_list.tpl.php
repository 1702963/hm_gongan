<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<div class="table-list">
<form name="myform" id="myform" action="?m=cengji&c=cengji&a=listorder" method="POST">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="191" align="center">ID</th>
			<th width='890' align="center">岗位等级</th>
			<th width='890' align="center">等级工资</th>
			<th align="center" width="531">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($cengji)){
	foreach($cengji as $info){
		?>
	<tr>
		<td align="center" width="191"><?=$info['id']?></td>
		<td align="center" width="890"><?=$info['cjname']?></td>
        <td align="center" width="890"><?=$info['gongzi']?></td>
		<td align="center" width="531"><a href="index.php?m=cengji&c=gwdj&a=edit&id=<?=$info['id']?>">修改</a>&nbsp;&nbsp;<a href="javascript:;" onclick="att_delete(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a></td>
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
	$.get('?m=cengji&c=cengji&a=delete&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>