<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<div class="table-list">
<form name="myform" id="myform" action="?m=gangwei&c=techang&a=listorder" method="POST">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="191" align="center">ID</th>
			<th width='890' align="center">分类名称</th>
			<th width='890' align="center">分类归属</th>
            <th width='890' align="center">启用状态</th>
			<th align="center" width="531">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($gangwei)){
	foreach($gangwei as $info){
		?>
	<tr>
		
		
		<td align="center" width="191"><?php echo $info['id']?></td>
		<td align="center" width="890"><?php echo $info['classname']?></td>
		<td align="center" width="890"><?php echo $mainclass[$info['pid']]?></td>
        <td align="center" width="890"><?php echo $zt[$info['isok']]?></td>
		<td align="center" width="531"><a href="javascript:;" onclick="edittechang('<?=$info['id']?>')">修改</a>&nbsp;&nbsp;<a href="javascript:;" onclick="att_delete(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a></td>
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
	$.get('?m=gangwei&c=techang&a=delete&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};

function addtechang(){ 
		window.top.art.dialog({title:'添加分类', id:'shows', iframe:'?m=gangwei&c=techang&a=add',width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}
	
function edittechang(id){ 
		window.top.art.dialog({title:'编辑分类', id:'shows', iframe:'?m=gangwei&c=techang&a=edit&id='+id,width:'680px',height:'300px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
</script>