<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_validator = true;include $this->admin_tpl('header');?>

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
.kotable {margin-bottom:20px;margin-top:0}
.kotable tbody td {text-align:left}
.col-tab ul {margin:0px 0 10px 0;font-family:microsoft yahei;font-size:14px}
.col-tab ul.tabBut {height:32px;}
.col-tab ul.tabBut li {
	width:120px; height:30px; text-align:center; background-image: linear-gradient(350deg, #008898 0%, #042839 100%);
	border:0 solid #00f6ff; box-sizing:border-box; border-radius:10px 0 10px 0; transform: skewX(-15deg);transition:all .2s ease-in-out
}
.col-tab ul.tabBut li a { width:100%; height:30px; display:block; color:#fff;text-decoration:none; transform: skewX(10deg) }
.col-tab ul.tabBut li.on {width:150px;height:30px; border:0 solid #06d; background-image: linear-gradient(350deg, #56923b 0%, #3faa0f 100%);color:#fff;box-sizing:border-box;font-size:16px}
a.modState {padding:1px 6px; background:#fff;font-weight:900;border-radius:3px}
#menuLink a {padding:1px 6px;color:#fff;border-radius:3px;filter: brightness(90%);transition:all .2s ease-in-out }
#menuLink a:hover {filter: brightness(120%) }
#menuLink a:first-of-type {background:#09C}
#menuLink a:nth-of-type(2) {background:#3C6}
#menuLink a:nth-of-type(3) {background:#F63}
div.btn {background:none}

</style>

<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#rolename").formValidator({onshow:"<?php echo L('input').L('role_name')?>",onfocus:"<?php echo L('role_name').L('not_empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('role_name').L('not_empty')?>"});
})
//-->
</script>

<div class="tableContent">
<div class="col-tab">
    <ul class="tabBut cu-li">
		<li id="tab_setting_1" class="on"><a href="javascript:void(0)">修改角色</a></li>
    </ul>
</div>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?m=admin&c=role&a=edit" method="post" id="myform">
<input type="hidden" name="roleid" value="<?php echo $roleid?>"></input>
<table width="100%" class="table_form contentWrap">
<tr>
<td><?php echo L('role_name')?></td> 
<td><input type="text" name="info[rolename]" value="<?php echo $rolename?>" class="input-text" id="rolename"></input></td>
</tr>
<tr>
<td><?php echo L('role_description')?></td>
<td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:100px;width:500px;"><?php echo $description?></textarea></td>
</tr>
<tr>
<td><?php echo L('enabled')?></td>
<td><input type="radio" name="info[disabled]" value="0" <?php echo ($disabled=='0')?' checked':''?>> <?php echo L('enable')?>  <label><input type="radio" name="info[disabled]" value="1" <?php echo ($disabled=='1')?' checked':''?>><?php echo L('ban')?></td>
</tr>
<tr>
<td><?php echo L('listorder')?></td>
<td><input type="text" name="info[listorder]" size="3" value="<?php echo $listorder?>" class="input-text"></input></td>
</tr>
</table>

    <div class="bk15"></div>
    <div class="btn"><input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button" /></div>
</form>
</div>
</div>
</div>
</body>
</html>


