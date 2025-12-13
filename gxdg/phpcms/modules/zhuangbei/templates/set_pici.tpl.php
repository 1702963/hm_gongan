<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');

$id=intval($_GET['objid']);
$this->db->table_name = 'mj_beizhuang_pici';
$piciinfo=$this->db->get_one("id=$id",'*');

///读出类目
	$this->db->table_name = 'mj_beizhuang_zidian';
	$zbmx=$this->db->select(" pid=0 and dotime=".$piciinfo['dotime'],'*','','px asc');

/////////////////////
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
		<td align=\"center\" width=\"340\"><a href=\"index.php?m=zhuangbei&c=zbmx&a=addsub&pid=".$t['id']."&dotime=".$t['dotime']."\">增加子类目</a> &nbsp;&nbsp; <a href=\"index.php?m=zhuangbei&c=zbmx&a=edit&id=".$t['id']."\">修改</a>&nbsp;&nbsp;<a href=\"javascript:;\" onclick=\"picidel(this,'".$t['id']."')\">删除</a></td>
	</tr>";
		
		  gettrees($dbobj,$t['id'],$spid,0,$outstr);	
			}
		}else{
		  return ;	
			}
	}
?>
<div class="pad-lr-10">
<div class="explain-col"> 

<table width="100%" border="0" align="center">
  <tr>
    <td width="86%" height="14">&nbsp;&nbsp;批次名称：<b><?php echo $piciinfo['title']?></b> &nbsp;,批次编码:<b style="color:#F00"><?php echo $piciinfo['dotime']?></b></td>
    <td width="14%">
      <?php if(count($zbmx)<1){?><input type="button" value="管理类目" class="button" name="dotongji2" style="width:90px; margin-left:20px" onclick="addlm('<?php echo $id?>')"/> <?php }?>
      <a href="?m=zhuangbei&c=zhuangbei"><input type="button" value="返回" class="button" name="dotongji" style="width:90px;margin-left:20px" /></a></td>
    </tr>
</table>

  </div>
    
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
$outstr="";
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
		<td align="center" width="124"><a href="index.php?m=zhuangbei&c=zbmx&a=addsub&pid=<?php echo $info['id']?>&dotime=<?php echo $info['dotime']?>">增加子类目</a> &nbsp;&nbsp; <a href="index.php?m=zhuangbei&c=zbmx&a=edit&id=<?=$info['id']?>">修改</a>&nbsp;&nbsp;<a href="javascript:;" onclick="picidel(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a></td>
	</tr>
	<?php
	gettrees($this->db,$info['id'],0,$info['dotime'],$outstr);
	echo $outstr;
	$outstr="";//此处一定要记得清空 gettrees是按地址传参的，等于是个全局变量
	}
}
?>
</tbody>
</table>
 <div class="btn"><input type="submit"  class="button" name="dopx" value="排序" style="width:90px"/></div>

</form>
</div>
</div>
</body>
</html>
<script type="text/javascript">

function addlm(id) {
	window.top.art.dialog({title:'添加类目', id:'showme', iframe:'?m=zhuangbei&c=zbmx&a=addlm&id='+id ,width:'600px',height:'750px'});
}

function picidel(obj,id){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=zhuangbei&c=zbmx&a=lmdelete&id='+id+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>