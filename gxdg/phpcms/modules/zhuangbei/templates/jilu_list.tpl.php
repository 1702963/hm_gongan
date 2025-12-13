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
    <td height="30"><b style="padding-left:10px; color:#F00">请选择要查看发放记录的批次</b></td>
    </tr>  
</table>
</form>
	</div>
    
<div class="table-list">
<form name="myform" id="myform" action="?m=zhuangbei&c=zhuangbei&a=listorder" method="POST">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="5%" align="center">ID</th>
			<th width='23%' align="center">批次名称</th>			
			<th width='14%' align="center">批次日期</th>
			<th width='8%' align="center">状态</th>
			<th width='9%' align="center">预设总额</th>
			<th width='10%' align="center">实际总额</th>
			<th width='9%' align="center">人员总数</th>
			<th width='8%' align="center">申领人数</th>
            <th width='14%' align="center">查看</th>
		  </tr>
	</thead>
<tbody>
<?php
$locked=array("申领中","<b style=\"color:red\">锁定</b>");
$i=1;
    
	$this->db->table_name = 'mj_beizhuang_ulog';
	
if(is_array($zhuangbei)){
	foreach($zhuangbei as $info){
		 if($_SESSION['roleid']==10 || $_SESSION['roleid']==1){
		    $rsstj = $this->db->select(" dotime=".$info['dotime'],'count(*) as px','','');
			$rsstjw = $this->db->select(" sjje>0 and dotime=".$info['dotime'],'count(*) as px','','');
		    
			$rsstj_zje = $this->db->select(" dotime=".$info['dotime'],'sum(kyje) as px','','');
			$rsstj_sje = $this->db->select(" sjje>0 and dotime=".$info['dotime'],'sum(sjje) as px','','');			
		 }else{
			$rsstj = $this->db->select(" dotime=".$info['dotime']." and bmid=".intval($_SESSION['bmid']),'count(*) as px','',''); 
			$rsstjw = $this->db->select(" sjje>0 and dotime=".$info['dotime']." and bmid=".intval($_SESSION['bmid']),'count(*) as px','',''); 
			
			$rsstj_zje = $this->db->select(" dotime=".$info['dotime']." and bmid=".intval($_SESSION['bmid']),'sum(kyje) as px','',''); 
			$rsstj_sje = $this->db->select(" sjje>0 and dotime=".$info['dotime']." and bmid=".intval($_SESSION['bmid']),'sum(sjje) as px','',''); 			
			 }
		?>
	<tr>
		<td align="center" ><?php  echo $i?></td>
		<td align="left" ><?php  echo $info['title']?></td>
		<td align="center" ><?php  echo $info['dotime']?></td>
		<td align="center" ><?php echo $locked[$info['islocked']]?></td>
		<td align="center" ><?php echo $rsstj_zje[0]['px']?></td>
		<td align="center" ><?php echo $rsstj_sje[0]['px']?></td>
		<td align="center" ><?php echo $rsstj[0]['px']?></td>
		<td align="center" ><?php echo $rsstjw[0]['px']?></td>
        <td align="center" ><?php if($info['islocked']==0){?><a href="?m=zhuangbei&c=zhuangbei&a=logxiang&ref=bumen&objid=<?php echo $info['id']?>" class="button">查看详情</a><?php }else{echo "&nbsp;";}?></td>
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