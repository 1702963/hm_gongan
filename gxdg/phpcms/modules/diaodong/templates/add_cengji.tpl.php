<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<link href="statics/css/select2.min.css" rel="stylesheet" />
<script src="statics/js/select2.min.js"></script>
<script type="text/javascript">
    //页面加载完成后初始化select2控件
    $(function () {
        $("#area").select2();
    });
    
    // select2()函数可添加相应配置：
    $('#area').select2({
      placeholder: '请选择姓名'
    });

    //选中控件id="area"、value="1"的元素
    function findByName(){
        //初始化select2
        var areaObj = $("#area").select2();
        var optionVal = 1;
        areaObj .val(optionVal).trigger("change");
        areaObj .change();
    }
    
</script>
<div class="pad-lr-10">
<form action="?m=diaodong&c=diaodong&a=addcengji" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="90" height="36">辅警姓名：</th>
		<td width="769"><?php echo form::select($fujing,'','name=info[fjid] id=area class=select2')?></td>
		<td width="788">&nbsp;</td>
	</tr>
	

	<tr>
		<th width="90" height="37">申请变更层级：</th>
		<td width="769"><?php echo form::select($cengji,'','name=info[newcj] class=infoselect')?></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th width="90" height="37">变更说明：</th>
		<td width="769"><textarea name="info[content]" cols="" rows="4" style="width:400px;"></textarea></td>
		<td width="788">&nbsp;</td>
	</tr>
	
	
		<tr>
		<th width="90" height="36">选择审批领导：</th>
		<td width="769"><?php echo form::select($lingdao,'','name=info[shid]  class=infoselect')?></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
		<td>&nbsp;</td>
	</tr>

</table>
<input type="hidden" name="forward" value="?m=chengjie&c=chengjie">
</form>
</div>
</body>
</html>



