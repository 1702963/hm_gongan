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
		<tr>	
			<th align="left">*未检出匹配的工资表，请先初始化工资系统再进行本项操作</th>
		</tr>
 	</thead>
</table>
<?php }?>
<hr style="height:1px;border:none;border-top:1px solid #004f8c;" />

<table width="100%" cellspacing="0" >
	<thead>
		<tr>	
            <th width='10%' align="center">工资月度</th>
			<th width='10%' align="center">绩效表状态</th>
            <th align="center" width="10%">锁定状态</th>
            <th align="center" width="10%">导出绩效考核表</th>
            <th align="center" >数据量</th>
            <th align="center" >操作</th>
		</tr>
	</thead>
<tbody>
<?php
$this->db->table_name = 'mj_gongzi_jixiao';
 
if(is_array($gz_tables)){
	foreach($gz_tables as $info){
  //取得绩效表状态
    $jxdbs = $this->db->get_one("yue='".$info['yue']."'","count(id) as zj");
	$jxdbs_lock = $this->db->get_one("yue='".$info['yue']."' and islock=1","count(id) as zj");	
	$jxdbs_nodo = $this->db->get_one("yue='".$info['yue']."' and juok=0","count(id) as zj");
	
	//检查是否存在同期工资表
	$rs=$this->db->query("SHOW TABLES like 'mj_gz".$info['yue']."'");	
	$havetable=$this->db->fetch_array($rs);

	//echo count($havetable);	
	?>
	<tr>
	<form action="" method="post">
    <input type="hidden" name="m" value="gongzi" />	
    <input type="hidden" name="c" value="jixiao" />
    <input type="hidden" name="a" value="guanli" />
    <input type="hidden" name="yue" value="<?php echo $info['yue']?>" />
		
		<td align="center" ><?php echo $info['yue']?></td>
        <td align="center" ><?php if($jxdbs['zj']>0){?>已创建<?php }else{?><font color="red">未创建</font><?php }?></td>
        <td align="center" ><?php if($jxdbs_lock['zj']<1){?>未锁<?php }else{?><font color="red">锁定</font><?php }?></td>
        <td align="center" ><?php if($jxdbs_lock['zj']>=1){?><a href="index.php?m=gongzi&c=jixiao&a=daoxls&yue=<?php echo $info['yue']?>">导出</a><?php }else{?>无导出数据<?php }?></td>
        <td align="center" ><?php if(count($havetable)>0){?><?php echo $jxdbs['zj']?><?php }else{ echo "<b color=red>需要先创建同期工资表</b>";}?></td>
        <td align="center" ><input type="button" value="创建"  style="border-radius:.4em;cursor:pointer; width:80px; height:25px; <?php if($jxdbs['zj']<1){?>background-color:#06C; color:#FFF<?php }?>" onclick="doaddnew('<?php echo $info['yue']?>','<?php echo $jxdbs['zj']?>')" <?php if($jxdbs['zj']>0){?>disabled="disabled"<?php }?> />
                            <input type="button" value="查看"  style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="showjixiao('<?php echo $info['yue']?>')"/>
                            <input type="button" value="<?php if($jxdbs_lock['zj']<1){?>锁定<?php }else{?>解锁<?php }?>"  style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="dolocked('<?php echo $info['yue']?>','<?php echo $jxdbs_lock['zj']?>','<?php echo $jxdbs_nodo['zj']?>')" />  
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

function showjixiao(id) {
		window.top.art.dialog({title:'查看绩效考核表', id:'shows', iframe:'?m=gongzi&c=jixiao&a=showtable&yue='+id ,width:'1400px',height:'550px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){window.top.art.dialog({id:'shows'}).close()});
	}

function dolocked(yue,locked,nodo){
	if(locked!='0'){
	  errs="解锁数据表后其他用户将可以进行编辑，确认解锁吗？"
	}else{
	  nostr=""	
	  if(nodo!='0'){
		  nostr="当前绩效考核表还有"+nodo+"名辅警记录未完成审核 \n";  
	   }	
	  errs=nostr+"锁定数据表后除超管外其他用户无法操作，确认锁定吗？";
    }
	var isok=confirm(errs);
    if (isok == true) {
     location.href="index.php?m=gongzi&c=jixiao&a=guanli&yue="+yue+"&locked="+locked+"&pc_hash=<?php echo $_SESSION['pc_hash']?>"
    }
}


function doaddnew(yue,ids){
	if(ids!='0'){
	alert(yue+"绩效表已存在，不能重复创建")
	}else{
	errs="确定创建绩效工作表吗？"
	var isok=confirm(errs);
    if (isok == true) {
     location.href="index.php?m=gongzi&c=jixiao&a=guanli&addtable=1&yue="+yue+"&pc_hash=<?php echo $_SESSION['pc_hash']?>"
    }}	
}			
</script>