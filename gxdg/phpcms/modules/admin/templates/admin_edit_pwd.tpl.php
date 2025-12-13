<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_validator = true;include $this->admin_tpl('header');?>
<script type="text/javascript">
//2020-09-11新增 切换栏目关闭树状菜单
window.top.$('#display_center_id').css('display','none');
</script>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#old_password").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('password').L('between_6_to_20')?>",oncorrect:"<?php echo L('old_password_right')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password').L('between_6_to_20')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=admin&c=admin_manage&a=public_password_ajx",
		datatype : "html",
		async:'false',
		success : function(data){	
            if( data == "1" )
			{
                return true;
			}
            else
			{
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('old_password_wrong')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	});
	$("#new_password").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('password').L('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password').L('between_6_to_20')?>"});
	$("#new_pwdconfirm").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('input').L('passwords_not_match')?>",oncorrect:"<?php echo L('passwords_match')?>"}).compareValidator({desid:"new_password",operateor:"=",onerror:"<?php echo L('input').L('passwords_not_match')?>"});
  })
</script>
<style type="text/css">
.input-text {width:400px;height:32px;}

.table_form {font-size:14px;width:98%;margin-left:1%;margin-top:10px}
.table_form td {height:80px}
.table_form th {text-align:left}
.table_form th b {color:#eee;margin-left:20px}
.table_form th h3 {color:#D5FFFF;margin-left:20px}
.table_form th , .table_form td , .table_form tbody th , .table_form tbody td {padding:25px 0}
.table_form td span {margin-left:10px}
.kotable tbody td { text-align:left;height:28px }
.button {background:#09c;font-size:14px;border-radius:3px;margin-left:1%;margin-bottom:10px}
.tableContent {margin-top:10px}
.button:hover {background:#f60}
input.button, input.btn {width:120px;height:32px;font-size:12px}
</style>
<div class="tableContent">

<div class="pad_10">
<div class="common-form">
<form name="myform" action="?m=admin&c=admin_manage&a=public_edit_pwd" method="post" id="myform">
<input type="hidden" name="info[userid]" value="<?php echo $userid?>"></input>
<input type="hidden" name="info[username]" value="<?php echo $username?>"></input>
<div class="table-list">
<table width="100%" cellpadding="2" cellspacing="5" class="table_form">
<tr>
	<th colspan="2"><h3>修改密码</h3></th>
</tr>
<tr>
<td width="150" align="right"><b><?php echo L('username')?>：</b></td> 
<td><span><?php echo $username?> (<?php echo L('realname')?> <?php echo $realname?>)</span></td>
</tr>

<tr>
<td align="right"><b><?php echo L('email')?>：</b></td>
<td><span><?php echo $email?></span></td>
</tr>

<tr>
<td align="right"><b><?php echo L('old_password')?>：</b></td> 
<td><span><input type="password" name="old_password" id="old_password" class="input-text"></input></span></td>
</tr>

<tr>
<td align="right"><b><?php echo L('new_password')?>：</b></td> 
<td><span><input type="password" name="new_password" id="new_password" class="input-text"></input></span></td>
</tr>
<tr>
<td align="right"><b><?php echo L('new_pwdconfirm')?>：</b></td> 
<td><span><input type="password" name="new_pwdconfirm" id="new_pwdconfirm" class="input-text"></input></span></td>
</tr>


</table>
</div>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button" id="dosubmit">
</form>
</div>
</div>

</div>
</body>
</html>
