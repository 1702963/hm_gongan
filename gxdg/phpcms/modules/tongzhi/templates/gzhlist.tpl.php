<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<div style="margin:-3px 0px 10px 0px">
<span style="display:inline; background-color:#06C; color:#FFF; padding:0.5em 1em 0.5em 1em; border-radius:.4em;cursor:pointer"><a href="javascript:addtongzhi();" style="color:#FFF" >新增通知</a></span>
</div>
<div class="table-list">
<form name="myform" id="myform" action="?m=hys&c=hys&a=listorder" method="POST">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="82" align="center">ID</th>
            <th width='660' align="center">标题</th>
			<th width='238' align="center">发布时间</th>
           
			<th align="center" width="209">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($hys)){
	foreach($hys as $info){
		?>
	<tr ondblclick="jilu(<?=$info['id']?>);">
		
		
		<td align="center" width="82"><?=$info['id']?></td>
        <td align="center" width="660"><?php echo $info['title'];?></td>
		<td align="center" width="238"><?php echo date("Y-m-d H:i:s",$info['inputtime']);?></td>
      
		<td align="center" width="209"><a href="javascript:edittongzhi(<?=$info['id']?>);">修改</a>&nbsp;&nbsp;<a href="javascript:;" onclick="att_delete(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a></td>
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
function addtongzhi() {
	window.top.art.dialog({title:'发布通知', id:'addtongzhi', iframe:'?m=tongzhi&c=tongzhi&a=addtongzhi',width:'1100px',height:'650px'});
}

function edittongzhi(id) {
	window.top.art.dialog({title:'修改通知', id:'edittongzhi', iframe:'?m=tongzhi&c=tongzhi&a=edit&id='+id,width:'1100px',height:'650px'});
}
function jilu(id) {
	window.top.art.dialog({title:'详细', id:'jilu', iframe:'?m=tongzhi&c=tongzhi&a=show&id='+id,width:'1100px',height:'650px'});
}
function att_delete(obj,aid){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=tongzhi&c=tongzhi&a=delete&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>