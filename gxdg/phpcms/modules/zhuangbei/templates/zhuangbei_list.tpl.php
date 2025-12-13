<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<div class="explain-col"> 
<form name="searchform" method="get" id="daoxls" >
<input type="hidden" value="zhuangbei" name="m">
<input type="hidden" value="zhuangbei" name="c">
<input type="hidden" value="init" name="a">
<table width="100%" border="0">
  <tr>
    <td height="30">
  申领批次标题: <input type="text" value="<?php echo $title?>" class="input-text" size="35" name="title">&nbsp;&nbsp;
  &nbsp;&nbsp;
  <input type="submit" value="筛选" class="button" name="dotongji" style="width:90px">&nbsp;&nbsp;<a class="button" onclick="dopici(0)">创建批次</a></td>
    </tr>  
</table>
</form>
	</div>
    
<div class="table-list">
<form name="myform" id="myform" action="?m=zhuangbei&c=zhuangbei&a=listorder" method="POST">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="4%" align="center">ID</th>
			<th width='19%' align="center">批次名称</th>			
			<th width='13%' align="center">批次日期</th>
			<th width='14%' align="center">创建时间</th>
			<th width='9%' align="center">状态</th>
			<th width='11%' align="center">人员</th>
            <th width='14%' align="center">申领</th>
			<th width="16%" align="center" >操作</th>
		</tr>
	</thead>
<tbody>
<?php
$locked=array("正常","<b style=\"color:red\">锁定</b>");
$i=1;
    
	$this->db->table_name = 'mj_beizhuang_ulog';
	
if(is_array($zhuangbei)){
	foreach($zhuangbei as $info){
		    $rsstj = $this->db->select(" dotime=".$info['dotime'],'count(*) as px','','');
		?>
	<tr>
		<td align="center" ><?php  echo $i?></td>
		<td align="center" ><?php  echo $info['title']?></td>
		<td align="center" ><?php  echo $info['dotime']?></td>
		<td align="center" ><?php echo date("Y-m-d",$info['dodt']);?></td>
		<td align="center" ><a href="index.php?m=zhuangbei&c=zhuangbei&a=init&id=<?php echo $info['id']?>&islock=<?php if($info['islocked']==1){echo "0";}else{echo "1";} ?>"><?php echo $locked[$info['islocked']]?></a></td>
		<td align="center" > <a href="?m=zhuangbei&c=zhuangbei&a=renyuan&objid=<?php echo $info['id']?>" class="button">人员管理 [<?php echo $rsstj[0]['px']?>]</a></td>
        <td align="center" > <a href="?m=zhuangbei&c=zhuangbei&a=renyuan&objid=<?php echo $info['id']?>" class="button">申领统计</a></td>
		<td align="center" > 
        <a href="?m=zhuangbei&c=zhuangbei&a=setobj&objid=<?php echo $info['id']?>" class="button">类目设置</a> &nbsp;
        <a href="javascript:;" onclick="dopici('<?php echo $info['id']?>')" class="button">信息编辑</a> &nbsp; 
        <a href="javascript:;" onclick="picidel(this,'<?php echo $info['id']?>')" class="button">删除</a></td>
                                       
	</tr>
	<?php
$i++;
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

function dopici(id) {
	titlestr="新增";
	if(id>0){
		titlestr="编辑";
		}
	window.top.art.dialog({title:titlestr+'批次', id:'showme', iframe:'?m=zhuangbei&c=zhuangbei&a=dopici&id='+id ,width:'700px',height:'450px'});
}

function picidel(obj,id){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=zhuangbei&c=zhuangbei&a=picidel&id='+id+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>