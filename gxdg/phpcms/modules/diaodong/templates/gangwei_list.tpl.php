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
			
			
			<th width="70" align="center">ID</th>
			<th width='112' align="center">辅警姓名</th>			
			<th width='619' align="center">原岗位</th>
			<th width='240' align="center">变更后岗位</th>
			
			<th width='217' align="center">申请时间</th>
			<th width='212' align="center">审批状态</th>
			<th align="center" width="177">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		
		
		<td align="center" width="70"><?=$info['id']?></td>
		<td align="center" width="112"><?=$info['fjname']?></td>
		<td align="center" width="619"><?=$gangwei[$info['oldgw']]?></td>
		
		
		<td align="center" width="217"><?=$gangwei[$info['newgw']]?></td>
		<td align="center" width="240"><?php echo date("Y-m-d",$info['inputtime']);?></td>
		<td align="center" width="212"><?php if($info['status']==2){echo "<span style='color:#CC0000'>未通过</span>";}elseif($info['status']==9){echo "<span style='color:#090'>已通过</span>";}else{echo "待审批";}?></td>
		<td align="center" width="177"><a href="javascript:;" onclick="showxiang(<?=$info['id']?>);">查看</a>&nbsp;&nbsp;<?php if($info['status']==1 && $info['shid']==$_SESSION['userid']){?><a href="javascript:;" onclick="sh(<?=$info['id']?>);">审批</a>&nbsp;&nbsp;<?php }?><?php if($info['status']<>9){?><a href="javascript:;" onclick="att_delete(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a><?php }?></td>
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
function sh(id) {
	window.top.art.dialog({title:'岗位变更审批', id:'showme2', iframe:'?m=diaodong&c=diaodong&a=shgw&id='+id ,width:'500px',height:'400px'});
}
function showxiang(id) {
	window.top.art.dialog({title:'查看详情', id:'showme', iframe:'?m=diaodong&c=diaodong&a=showgw&id='+id ,width:'900px',height:'650px'});
}
function att_delete(obj,aid){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=diaodong&c=diaodong&a=deletegw&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>