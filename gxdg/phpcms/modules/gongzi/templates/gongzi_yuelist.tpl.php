<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list">
<?php 

if(count($gz_tables)<1){
?>
<table width="100%" cellspacing="0" >
	<thead>
    <form action="" method="post">
     <input type="hidden" name="m" value="gongzi" />
     <input type="hidden" name="c" value="gzgl" />
     <input type="hidden" name="a" value="yuetabls" />
     <input type="hidden" name="dos" value="addtable" />
		<tr>	
			<th align="left">*未检出可用的月度工资表，点击按钮立即创建 <input type="submit" value="创建"  style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" /> <?php echo $msgss ?></th>
		</tr>
    </form>    
	</thead>
</table>
<?php }?>
<hr style="height:1px;border:none;border-top:1px solid #004f8c;" />

<table width="100%" cellspacing="0" >
	<thead>
		<tr>	
			<th width='10%' align="center">工资表名</th>
            <th width='10%' align="center">工资月度</th>
			<th width='10%' align="center">创建日期</th>
			<th width='10%' align="center">锁表状态</th>
            <th align="center" width="10%">结转状态</th>
            <th align="center" width="10%">导出XLS</th>
            <th align="center" >数据量</th>
            <th align="center" >操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($gz_tables)){
	$i=0;
	foreach($gz_tables as $info){
	?>
	<tr>
	<form action="" method="post">
    <input type="hidden" name="m" value="gongzi" />	
    <input type="hidden" name="c" value="gzgl" />
    <input type="hidden" name="a" value="yuetabls" />
    <input type="hidden" name="id" value="<?php echo $info[id]?>" />
		
		<td align="center" ><?php echo $info['tname']?></td>
		<td align="center" ><?php echo $info['yue']?></td>
		<td align="center" ><?php echo date("Y-m-d H:i:s",$info['ctime'])?></td>
        <td align="center" ><?php if($info['islocked']<1){?>未锁<?php }else{?><font color="red">锁定</font><?php }?></td>
        <td align="center" ><?php if($info['isfinish']<1){?>未转结<?php }else{?><font color="red">已转结</font><?php }?></td>
        <td align="center" ><?php if($info['isfinish']<1){?>未转结<?php }else{?><font color="red"><a href="index.php?m=gongzi&c=gzgl&a=dao&tbname=<?php echo $info['tname']?>&yue=<?php echo $info['yue']?>" target="_blank">导出</a></font><?php }?></td>
        <td align="center" ><?php echo $info['rows']?></td>
        <td align="center" ><input type="button" value="查看"  style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="showtables('<?php echo $info['id']?>')"/>
                            <input type="button" value="<?php if($info['islocked']<1){?>锁定<?php }else{?>解锁<?php }?>"  style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="dolocked('<?php echo $info['id']?>','<?php echo $info['islocked']?>')" />  
                            <?php if($info["islocked"]==1){?><input type="button" value="转结"  style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="dofinished('<?php echo $info['id']?>','<?php echo $info['isfinish']?>')"/> <?php }?>
                            <?php if($info["isfinish"]==1 && $i==0){?><input type="button" value="创建下月账"  style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="doaddnew('<?php echo $info['id']?>','<?php echo $info['yue']?>')"/> <?php }?>
                          </td>
	</tr>
    </form>
	<?php
	$i++;
	}
}
?>
</tbody>

</table>

<div id="pages"><?php echo $pages?></div>

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

function showtables(id) {
		window.top.art.dialog({title:'查看工资表', id:'shows', iframe:'?m=gongzi&c=gzgl&a=showtable&id='+id ,width:'1020px',height:'550px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}

function dolocked(id,locked){
	if(locked=='1'){
	  errs="解锁数据表后其他用户将可以进行编辑，确认解锁吗？"
	}else{
	  errs="锁定数据表后除超管外其他用户无法操作，确认锁定吗？";
    }
	var isok=confirm(errs);
    if (isok == true) {
     location.href="index.php?m=gongzi&c=gzgl&a=yuetabls&islocked="+id+"&locked="+locked+"&pc_hash=<?php echo $_SESSION['pc_hash']?>"
    }
}

function dofinished(id,finished){
	if(finished==1){
		alert("当前工资表已结转，不允许再次操作")
		return false;
		}else{
	errs="结转操作无法取消操作，确认转结吗？"
	var isok=confirm(errs);
    if (isok == true) {
     location.href="index.php?m=gongzi&c=gzgl&a=yuetabls&isfinisheded="+id+"&pc_hash=<?php echo $_SESSION['pc_hash']?>"
    }}	
}	

function doaddnew(id,yue){
	errs="确定创建下月工资表吗？"
	var isok=confirm(errs);
    if (isok == true) {
     location.href="index.php?m=gongzi&c=gzgl&a=yuetabls&addtable="+id+"&yue="+yue+"&pc_hash=<?php echo $_SESSION['pc_hash']?>"
    }	
}			
</script>