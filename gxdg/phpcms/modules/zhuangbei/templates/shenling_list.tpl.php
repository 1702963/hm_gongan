<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');

        $this->db->table_name = 'mj_beizhuang_pici';
		$where=" isdel=0 ";
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$zhuangbei = $this->db->listinfo($where,'id desc',$page, $pages = '12');
		$pages = $this->db->pages;
		
?>
<div class="pad-lr-10">
<div class="explain-col"> 
<form name="searchform" method="get" id="daoxls" >
<input type="hidden" value="zhuangbei" name="m">
<input type="hidden" value="zhuangbei" name="c">
<input type="hidden" value="shenling" name="a">
<table width="100%" border="0">
  <tr>
    <td height="30"><b style="padding-left:10px; color:#F00">请注意阅读备注</b></td>
    </tr>  
</table>
</form>
	</div>
    
<div class="table-list">
<form name="myform" id="myform" action="?m=zhuangbei&c=zhuangbei&a=listorder" method="POST">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="6%" align="center">ID</th>
			<th width='21%' align="center">批次名称</th>			
			<th width='12%' align="center">批次日期</th>
			<th width='35%' align="center">备注</th>
			<th width='6%' align="center">状态</th>
			<th width='10%' align="center">人员</th>
            <th width='10%' align="center">申领</th>
		  </tr>
	</thead>
<tbody>
<?php
$locked=array("正常","<b style=\"color:red\">锁定</b>");
$i=1;
    
	$this->db->table_name = 'mj_beizhuang_ulog';
	
if(is_array($zhuangbei)){
	foreach($zhuangbei as $info){
		 if($_SESSION['roleid']==10 || $_SESSION['roleid']==1){
		    $rsstj = $this->db->select(" dotime=".$info['dotime'],'count(*) as px','','');
			$rsstjw = $this->db->select(" sjje>0 and dotime=".$info['dotime'],'count(*) as px','','');
		 }else{
			$rsstj = $this->db->select(" dotime=".$info['dotime']." and bmid=".intval($_SESSION['bmid']),'count(*) as px','',''); 
			$rsstjw = $this->db->select(" sjje>0 and dotime=".$info['dotime']." and bmid=".intval($_SESSION['bmid']),'count(*) as px','',''); 
			 }
		?>
	<tr>
		<td align="center" ><?php  echo $i?></td>
		<td align="left" ><?php  echo $info['title']?></td>
		<td align="center" ><?php  echo $info['dotime']?></td>
		<td align="left" ><?php echo $info['beizhu']?></td>
		<td align="center" ><?php echo $locked[$info['islocked']]?></td>
		<td align="center" ><?php if($info['islocked']==0){?><a href="?m=zhuangbei&c=zhuangbei&a=renyuan&ref=bumen&objid=<?php echo $info['id']?>" class="button">人员管理 [<?php echo $rsstj[0]['px']?>,<?php echo $rsstjw[0]['px']?>]</a><?php }else{echo "&nbsp;";}?></td>
        <td align="center" ><?php if($info['islocked']==0){?><a href="?m=zhuangbei&c=zhuangbei&a=doxuan&ref=bumen&objid=<?php echo $info['id']?>" class="button">进入申领</a><?php }else{echo "&nbsp;";}?></td>
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