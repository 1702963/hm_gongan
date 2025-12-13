<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_nosub', 'admin');

function gettrees($dbobj,$pid=0,$spid=0,$dotime=0,&$outstr ){
	 $tmprs = $dbobj->select("pid=$pid and dotime=$dotime",'*','',"px asc");

	if(isset($tmprs[0])){
		foreach($tmprs as $t){
		 //根据节点路由补加前置占位
		 $bwqzstr=str_repeat("┈",count(explode(",",$t['paths']))-1); //生成字符占位	
		 //判断是否选中
		 if($t['id']==$spid){
			 $issed="selected='selected'";
			 }else{
				$issed=""; 
				 }
		 
		 if($t['dotime']>0){
			 $tmppici=$t['dotime'];
			 }else{
			 $tmppici="基础类目";	 
				 }
		 
		 $outstr.="<tr>
		<td align=\"center\" width=\"91\"><input name=\"px[".$t['id']."]\" value=\"".$t['px']."\" style=\"width:60px\"/></td>
		<td align=\"center\" width=\"91\">".$t['id']."</td>
		<td align=\"left\" width=\"390\">".$bwqzstr.$t['name']."</td>
		<td width=\"99\" align=\"center\">".$t['guige']."</td>
        <td width=\"196\" align=\"center\">".$t['syhx']."</td>
        <td width=\"153\" align=\"center\">".$t['xyhx']."</td>   		
		<td width=\"103\" align=\"center\">".$t['jiage']."</td>
		<td width=\"124\" align=\"center\">".$t['beizhu']."</td>
		<td width=\"281\" align=\"center\">".$tmppici."</td>
		<td align=\"center\" width=\"340\"><a href=\"index.php?m=zhuangbei&c=zbmx&a=add&pid=".$t['id']."\">增加子类目</a> &nbsp;&nbsp; <a href=\"index.php?m=zhuangbei&c=zbmx&a=edit&id=".$t['id']."\">修改</a>&nbsp;&nbsp;<a href=\"javascript:;\" onclick=\"att_delete(this,'".$info['id']."')\">删除</a></td>
	</tr>";
		
		  gettrees($dbobj,$t['id'],$spid,0,$outstr);	
			}
		}else{
		  return ;	
			}
	}
	
?>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="?m=zhuangbei&c=zbmx&a=init" class="on" style="margin-right:15px"><em>基础类目</em></a>  
        <a href="?m=zhuangbei&c=zbmx&a=init&doty=subs" class="on" style="margin-right:15px"><em>批次类目</em></a> 
        <a href="?m=zhuangbei&c=zbmx&a=add" style="margin-right:15px"><em>增加类目</em></a>
    </div>
</div>    
<div class="pad-lr-10">

<div class="table-list">
<form name="myform" id="myform" action="?m=zhuangbei&c=zbmx&a=listorder" method="POST">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			<th width="91" align="center">排序</th>
			<th width="91" align="center">ID</th>
			<th width='390' align="center">类目名称</th>	
			<th width='99' align="center">规格</th>
            <th width='196' align="center">上衣号型</th>
            <th width='153' align="center">下衣号型</th>
			<th width='103' align="center">单价</th>
			<th width='124' align="center">备注</th>
			<th width='281' align="center">批次</th>
			<th align="center" width="340">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($zbmx)){
	foreach($zbmx as $info){
		?>
	<tr>
		
		<td align="center" width="91"><input name="px[<?php echo $info['id']?>]" value="<?php echo $info['px']?>" style="width:60px"/></td>
		<td align="center" width="91"><?php echo $info['id']?></td>
		<td align="left" width="390"><?php echo $info['name']?></td>		
		<td width="99" align="center"><?php echo $info['guige']?></td>
        <td width='196' align="center"><?php echo $info['syhx']?></td>
        <td width='153' align="center"><?php echo $info['xyhx']?></td>        
		<td width="196" align="center"><?php echo $info['jiage']?></td>
		<td width="153" align="center"><?php echo $info['beizhu']?></td>
		<td width="103" align="center"><?php if($info['dotime']==0){echo "基础类目";}else{echo $info['dotime'];}?></td>
		<td align="center" width="124"><a href="index.php?m=zhuangbei&c=zbmx&a=add&pid=<?php echo $info['id']?>">增加子类目</a> &nbsp;&nbsp; <a href="index.php?m=zhuangbei&c=zbmx&a=edit&id=<?=$info['id']?>">修改</a>&nbsp;&nbsp;<a href="javascript:;" onclick="att_delete(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a></td>
	</tr>
	<?php
	gettrees($this->db,$info['id'],0,0,$outstr);
	echo $outstr;
	$outstr="";//此处一定要记得清空 gettrees是按地址传参的，等于是个全局变量
	}
}
?>
</tbody>
</table>
 <div class="btn"><input type="submit"  class="button" name="dopx" value="排序" style="width:90px"/></div>
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
	$.get('?m=zhuangbei&c=zbmx&a=delete&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>