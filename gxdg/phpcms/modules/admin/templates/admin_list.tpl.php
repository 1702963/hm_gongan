<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<script type="text/javascript" >  
  $(document).ready(function() {  
    $(".kotable tbody tr:odd").addClass("odd");
	$(".kotable tbody tr:even").addClass("even");
    $(".kotable tbody tr").mouseover(function() {  
      $(this).addClass("iover");  
    }).mouseout(function() {  
      $(this).removeClass("iover");  
    });  
  }  
)  
</script>
<style>
.tableContent {margin-top:50px}
.col-tab ul {margin:0px 0 10px 0;font-family:microsoft yahei;font-size:14px}
.col-tab ul.tabBut {height:32px;}
.col-tab ul.tabBut li {
	width:120px; height:30px; text-align:center; background-image: linear-gradient(350deg, #008898 0%, #042839 100%);
	border:0 solid #00f6ff; box-sizing:border-box; border-radius:10px 0 10px 0; transform: skewX(-15deg);transition:all .2s ease-in-out
}
.col-tab ul.tabBut li a { width:100%; height:30px; display:block; color:#fff;text-decoration:none; transform: skewX(10deg) }
.col-tab ul.tabBut li.on {width:150px;height:30px; border:0 solid #06d; background-image: linear-gradient(350deg, #56923b 0%, #3faa0f 100%);color:#fff;box-sizing:border-box;font-size:16px}
</style>
<div class="tableContent">
<div class="pad_10">
<div class="col-tab">
    <ul class="tabBut cu-li">
		<li id="tab_setting_1" class="on"><a href="javascript:void(0)">管理员管理</a></li>
    </ul>
</div>
<div class="table-list">
<form name="myform" action="?m=admin&c=role&a=listorder" method="post">
	<div class="table-list">
    <table width="100%" cellspacing="0" class="kotable" style="margin-top:0">
        <thead>
		<tr>
		<th width="5%"><?php echo L('userid')?></th>
		<th width="10%" align="left" ><?php echo L('username')?></th>
		<th width="10%" align="left" ><?php echo L('userinrole')?></th>
		<th width="10%"  align="left" ><?php echo L('lastloginip')?></th>
		<th width="20%"  align="left" ><?php echo L('lastlogintime')?></th>
		<th width="15%"  align="left" ><?php echo L('email')?></th>
		<th width="10%"><?php echo L('realname')?></th>
		<th width="10%">所属部门</th>
		<th width="20%" ><?php echo L('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
<?php $admin_founders = explode(',',pc_base::load_config('system','admin_founders'));?>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td width="5%" align="center" style="color:#FFF"><?php echo $info['userid']?></td>
<td width="10%" style="color:#FFF"><?php echo $info['username']?></td>
<td width="10%" style="color:#FFF"><?php echo $roles[$info['roleid']]?></td>
<td width="10%" style="color:#FFF"><?php echo $info['lastloginip']?></td>
<td width="20%"  style="color:#FFF"><?php echo $info['lastlogintime'] ? date('Y-m-d H:i:s',$info['lastlogintime']) : ''?></td>
<td width="15%" style="color:#FFF"><?php echo $info['email']?></td>
<td width="10%"  align="center" style="color:#FFF"><?php echo $info['realname']?></td>
<td width="8%"  align="center" style="color:#FFF"><?php echo $bms[$info['bmid']]?></td>
<td width="20%"  align="center" style="color:#FFF">
<a  class="modChange" href="javascript:edit(<?php echo $info['userid']?>, '<?php echo new_addslashes($info['username'])?>')"><?php echo L('edit')?></a> | 
<?php if(!in_array($info['userid'],$admin_founders)) {?>
<a   class="modCancel" href="javascript:confirmurl('?m=admin&c=admin_manage&a=delete&userid=<?php echo $info['userid']?>', '<?php echo L('admin_del_cofirm')?>')"><?php echo L('delete')?></a>
<?php } else {?>
<font color="#cccccc"><?php echo L('delete')?></font>
<?php } ?> 
</td>
</tr>
<?php 
	}
}
?>
</tbody>
</table>
 <div id="pages"> <?php echo $pages?></div>
 </div>
</form>
</div>
</div>
</div>
</body>
</html>
<script type="text/javascript">
<!--
	function edit(id, name) {
		window.top.art.dialog({title:'<?php echo L('edit')?>--'+name, id:'edit', iframe:'?m=admin&c=admin_manage&a=edit&userid='+id ,width:'500px',height:'400px'}, 	function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
		var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
	}

function card(id) {
	window.top.art.dialog({title:'<?php echo L('the_password_card')?>', id:'edit', iframe:'?m=admin&c=admin_manage&a=card&userid='+id ,width:'500px',height:'400px'}, 	'', function(){window.top.art.dialog({id:'edit'}).close()});
}
//-->
</script>