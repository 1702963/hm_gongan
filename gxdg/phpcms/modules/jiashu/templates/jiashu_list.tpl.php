<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<div class="table-list">
<form name="myform" id="myform" action="?m=jiashu&c=jiashu&a=listorder" method="POST">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="191" align="center">ID</th>
			<th width='890' align="center">辅警姓名</th>			
			<th width='890' align="center">家属姓名</th>
			<th width='890' align="center">与辅警关系</th>
			<th width='890' align="center">性别</th>
			<th width='890' align="center">身份证</th>
			<th width='890' align="center">住址</th>
			<th width='890' align="center">电话</th>
			<th align="center" width="531">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($jiashu)){
	foreach($jiashu as $info){
		?>
	<tr>
		
		
		<td align="center" width="191"><?=$info['id']?></td>
		<td align="center" width="890"><?=$info['fjname']?></td>
		<td align="center" width="890"><?=$info['xingming']?></td>
		<td align="center" width="890"><?=$info['guanxi']?></td>
		
		<td align="center" width="890"><?=$info['sex']?></td>
		<td align="center" width="890"><?=$info['sfz']?></td>
		<td align="center" width="890"><?=$info['dizhi']?></td>
		<td align="center" width="890"><?=$info['tel']?></td>
		<td align="center" width="531"><a href="javascript:;" onclick="att_delete(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a></td>
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
	$.get('?m=jiashu&c=jiashu&a=delete&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>