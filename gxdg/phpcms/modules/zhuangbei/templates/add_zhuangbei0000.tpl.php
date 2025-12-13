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
<form action="?m=zhuangbei&c=zhuangbei&a=add" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="90" height="36">辅警姓名：</th>
		<td width="769"><?php echo form::select($fujing,'','name=info[fjid] id=area class=select2')?></td>
		<td width="788">&nbsp;</td>
	</tr>
	
<tr>
		<th width="90" height="37">装备名称：</th>
		<td width="769"><?php echo form::select($zb,'','name=info[zbid] class=infoselect')?></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th width="90" height="37">发放数量：</th>
		<td width="769"><input type="input" name="info[ffshu]"  style="width:200px;" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th width="90" height="37">发放人姓名：</th>
		<td width="769"><input type="input" name="info[ffname]"  style="width:200px;"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	
	<tr>
		<th width="90" height="37">发放时间：</th>
		<td width="769"><?php echo form::date('fftime','',0,0,'false');?></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
		<td>&nbsp;</td>
	</tr>

</table>
<input type="hidden" name="forward" value="?m=zhuangbei&c=zhuangbei">
</form>
</div>
</body>
</html>



