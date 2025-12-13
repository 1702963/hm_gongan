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
.kotable {margin-bottom:20px}
.col-tab ul {margin:0px 0 10px 0;font-family:microsoft yahei;font-size:14px}
.col-tab ul.tabBut {height:32px;}
.col-tab ul.tabBut li {
	width:120px; height:30px; text-align:center; background-image: linear-gradient(350deg, #008898 0%, #042839 100%);
	border:0 solid #00f6ff; box-sizing:border-box; border-radius:10px 0 10px 0; transform: skewX(-15deg);transition:all .2s ease-in-out
}
.col-tab ul.tabBut li a { width:100%; height:30px; display:block; color:#fff;text-decoration:none; transform: skewX(10deg) }
.col-tab ul.tabBut li.on {width:150px;height:30px; border:0 solid #06d; background-image: linear-gradient(350deg, #56923b 0%, #3faa0f 100%);color:#fff;box-sizing:border-box;font-size:16px}
a.modState {padding:1px 6px; background:#fff;font-weight:900;border-radius:3px}
</style>
<div class="tableContent">
<div class="table-list pad-lr-10">
<div class="col-tab">
    <ul class="tabBut cu-li">
		<li id="tab_setting_1" class="on"><a href="javascript:void(0)">角色管理</a></li>
    </ul>
</div>
<form name="myform" action="?m=admin&c=role&a=listorder" method="post">
    <table width="100%" cellspacing="0" class="kotable" style="margin-top:0">
        <thead>
		<tr>
		<th width="10%"><?php echo L('listorder');?></th>
		<th width="10%">ID</th>
		<th width="15%"  align="left" ><?php echo L('role_name');?></th>
		<th width="265"  align="left" ><?php echo L('role_desc');?></th>
		<th width="5%"  align="left" ><?php echo L('role_status');?></th>
		<th class="text-c"><?php echo L('role_operation');?></th>
		</tr>
        </thead>
<tbody>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td width="10%" align="center" style="color:#FFF"><input name='listorders[<?php echo $info['roleid']?>]' type='text' size='3' value='<?php echo $info['listorder']?>' class="input-text-c"></td>
<td width="10%" align="center" style="color:#FFF"><?php echo $info['roleid']?></td>
<td width="15%" style="color:#FFF" ><?php echo $info['rolename']?></td>
<td width="265" style="color:#FFF"><?php echo $info['description']?></td>
<td width="5%" style="color:#FFF">
	<a class="modState" href="?m=admin&c=role&a=change_status&roleid=<?php echo $info['roleid']?>&disabled=<?php echo ($info['disabled']==1 ? 0 : 1)?>"><?php echo $info['disabled']? L('icon_locked'):L('icon_unlock')?></a>
</td>
<td  class="text-c">
<?php if($info['roleid'] > 1) {?>
<a class="modView" href="javascript:setting_role(<?php echo $info['roleid']?>, '<?php echo new_addslashes($info['rolename'])?>')"><?php echo L('role_setting');?></a> |
<?php } else {?>

<?php }?>
<a class="modChange" href="?m=admin&c=role&a=member_manage&roleid=<?php echo $info['roleid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('role_member_manage');?></a> | 
<?php if($info['roleid'] > 1) {?><a  class="modLock" href="?m=admin&c=role&a=edit&roleid=<?php echo $info['roleid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('edit')?></a> | 
<a class="modCancel" href="javascript:confirmurl('?m=admin&c=role&a=delete&roleid=<?php echo $info['roleid']?>', '<?php echo L('posid_del_cofirm')?>')"><?php echo L('delete')?></a>
<?php } else {?>
<font color="#cccccc"><?php echo L('edit')?></font> | <font color="#cccccc"><?php echo L('delete')?></font>
<?php }?>
</td>
</tr>
<?php 
	}
}
?>

</tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>
</form>
</div>
</div>
</body>
<script type="text/javascript">
<!--
function setting_role(id, name) {

	window.top.art.dialog({title:'<?php echo L('sys_setting')?>《'+name+'》',id:'edit',iframe:'?m=admin&c=role&a=priv_setting&roleid='+id,width:'700',height:'500'});
}

function setting_cat_priv(id, name) {

	window.top.art.dialog({title:'<?php echo L('usersandmenus')?>《'+name+'》',id:'edit',iframe:'?m=admin&c=role&a=setting_cat_priv&roleid='+id,width:'700',height:'500'});
}
//-->
</script>
</html>
