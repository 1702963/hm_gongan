<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="subnav" style="margin-top:-25px;">
    <div class="content-menu ib-a blue line-x">
        <a href="<?php echo APP_PATH;?>?m=peixun&c=peixun&a=gl&status=1" <?php if($status==1){?>class="on"<?php }?>><em>待审批</em></a><span>|</span><a href="<?php echo APP_PATH;?>?m=peixun&c=peixun&a=gl&status=9" <?php if($status==9){?>class="on"<?php }?>><em>已通过</em></a><span>|</span><a href="<?php echo APP_PATH;?>?m=peixun&c=peixun&a=gl&status=2" <?php if($status==2){?>class="on"<?php }?>><em>未通过</em></a> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<a href="<?php echo APP_PATH;?>?m=peixun&c=peixun&a=dao" ><em>导出全部</em></a>   </div>
</div>
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
		<td align="center" width="531"><a href="javascript:;" onclick="showxiang('<?php echo $info['id']?>')">审核</a></td>
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

function showxiang(id) {
	window.top.art.dialog({title:'审核', id:'showme', iframe:'?m=peixun&c=peixun&a=sh&id='+id ,width:'400px',height:'300px'});
}
</script>