<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<div class="explain-col" style=" margin-top:-10px;margin-bottom:3px"> 
 
<form name="searchform" method="post">
<input type="hidden" value="fujing" name="m">
<input type="hidden" value="xinlu" name="c">
<input type="hidden" value="pici" name="a">
<table width="100%" border="0">
  <tr>
    <td height="30">
  <a href="index.php?m=fujing&c=xinlu&a=init"><input type="button" value="招录人员管理" class="button" name="dotongji" style="width:100px"></a> &nbsp;
  <input type="button" value="创建新批次" class="button" name="dotongji" style="width:100px" onclick="showaddpicis()">
    </td>
  </tr> 
  <tr id="addpicis" style="display:none">
    <td height="30"> 
    <?php if($nofins['zj']>0){ ?>
     当前存在尚未完成的招录批次，不能创建新的批次
    <?php }else{?>   
    招录年度：<select name="zlnd">
              <?php for($i=0;$i<2;$i++){?>
              <option value="<?php echo date("Y")+$i?>"><?php echo date("Y")+$i?></option>
              <?php }?>
            </select> &nbsp;&nbsp;
    招录批次: <input type="text" class="input-text" size="20" name="zlpc">&nbsp;&nbsp;
    招录时段: <?php echo form::date('sd1',date("Y-m-d"),0,0,'false');?> 至&nbsp; <?php echo form::date('sd2',date("Y-m-d"),0,0,'false');?>&nbsp;&nbsp;
    计划招录人数: <input type="text" class="input-text" size="6" name="jhrs"> &nbsp;&nbsp;
    <input type="submit" value="新增" class="button" name="addits" style="width:40px">
    <?php }?>
    </td>
  </tr>   
</table>
</form>
</div>
    
<div class="table-list">

<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="10%" align="center">序号</th>
			<th width='10%' align="center">招录年度</th>			
			<th width='10%' align="center">招录批次</th>
            <th align="center">招录时段</th>
			<th width='10%' align="center">计划招录人数</th>
            <th width='10%' align="center">实际招录人数</th>
            <th width='10%' align="center">状态</th>
			<th align="center" >操作</th>
		</tr>
	</thead>
<tbody>
<?php
$j=1;
if(is_array($picis)){
	foreach($picis as $info){
		?>
	<tr>
		
		
		<td align="center" ><?php echo $j?></td>
		<td align="center" ><?php echo $info['zlnd']?></td>
		<td align="center" ><?php echo $info['zlpc']?></td>
        <td align="center" ><?php echo date("Y-m-d",$info['sd1'])." 至 ".date("Y-m-d",$info['sd2'])?></td>
        <td align="center" ><?php echo $info['jhrs']?></td>
		<td align="center" ><?php echo $info['sjrs']?></td>
		<td align="center" ><?php if($info['zt']==1){ echo "招录中";}?>
                            <?php if($info['zt']==2){ echo "结束";}?>
                            <?php if($info['zt']==0){ echo "作废";}?>
                           </td>
		<td align="center" >
                            <?php if($_SESSION['roleid']<5 && $info['zt']==1){?>
                                <a href="index.php?m=fujing&c=xinlu&a=pici&doty=dofei&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('作废操作将清除当前记录且无法恢复，确认作废吗?');return r"><input type="button" value="作废" class="button" name="dotongji" style="width:50px"></a> &nbsp;
                            <?php }?>
                            <?php if($_SESSION['roleid']<5 && $info['zt']==1){?>
                                <a href="index.php?m=fujing&c=xinlu&a=pici&doty=dook&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认当前批次招录完成吗?');return r;"><input type="button" value="完成" class="button" name="dotongji" style="width:50px"></a> &nbsp;
                            <?php }?>  
                            <?php if($_SESSION['roleid']<5 && $info['zt']==2){?>
                                <a href="index.php?m=fujing&c=xinlu&a=pici&doty=donook&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认重新启用当前批次吗?');return r;"><input type="button" value="重启批次" class="button" name="dotongji" style="width:70px"></a> &nbsp;
                            <?php }?>                                                        
                            
        </td>                    
	</tr>
	<?php
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

<script language="javascript">
function showaddpicis(){
  if($("#addpicis").css('display')!=''){
	   $("#addpicis").css('display','') 
	  }else{
	   $("#addpicis").css('display','none')		  
	}	 
}

</script>

<script type="text/javascript">

function att_delete(obj,aid){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=fujing&c=xinlu&a=delete&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};

function att_ok(obj,aid){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=fujing&c=xinlu&a=dook&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};

</script>