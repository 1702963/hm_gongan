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
<form action="?m=jiashu&c=jiashu&a=add" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="90" height="36">辅警姓名：</th>
		<td width="769"><?php echo form::select($fujing,'','name=info[fjid] id=area class=select2')?></td>
		<td width="788">&nbsp;</td>
	</tr>
	

	<tr>
		<th width="90" height="37">家属姓名：</th>
		<td width="769"><input type="input" name="info[xingming]"  style="width:200px;" /></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th width="90" height="37">性别：</th>
		<td width="769"><?php echo form::select(array('男'=>'男','女'=>'女'),'男','name=info[sex]  class=infoselect')?></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th width="90" height="37">身份证：</th>
		<td width="769"><input type="input" name="info[sfz]"  style="width:200px;" /></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th width="90" height="37">住址：</th>
		<td width="769"><input type="input" name="info[dizhi]"  style="width:200px;"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th width="90" height="37">电话：</th>
		<td width="769"><input type="input" name="info[tel]"  style="width:200px;"/></td>
		<td width="788">&nbsp;</td>
	</tr>
	<tr>
		<th width="90" height="36">与辅警关系：</th>
		<td width="769"><?php echo form::select(array('父亲'=>'父亲','母亲'=>'母亲','配偶'=>'配偶','儿子'=>'儿子','女儿'=>'女儿'),'','name=info[guanxi] class=infoselect')?></td>
		<td width="788">&nbsp;</td>
	</tr>
	
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
		<td>&nbsp;</td>
	</tr>

</table>
<input type="hidden" name="forward" value="?m=jiashu&c=jiashu">
</form>
</div>
</body>
</html>



