<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<div class="table-list" style="height:250px;">

<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			
				
			<th width='159' align="center">家属姓名</th>
			<th width='208' align="center">与辅警关系</th>
			<th width='59' align="center">性别</th>
			<th width='411' align="center">身份证</th>
			<th width='478' align="center">住址</th>
			<th width='263' align="center">电话</th>
			<th width='263' align="center">工作单位</th>
			<th width="69" align="center">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($jiashu)){
	foreach($jiashu as $info){
		?>
	<tr>
		
		
		
		
		<td align="center" width="159"><?=$info['xingming']?></td>
		<td align="center" width="208"><?=$info['guanxi']?></td>
		
		<td align="center" width="59"><?=$info['sex']?></td>
		<td align="center" width="411"><?=$info['sfz']?></td>
		<td align="center" width="478"><?=$info['dizhi']?></td>
		<td align="center" width="263"><?=$info['tel']?></td>
		<td align="center" width="263"><?=$info['gzdw']?></td>
		<td align="center" width="69"><a href="javascript:;" onclick="att_delete(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a></td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>

<div id="pages"><?php echo $pages?></div>
</div>
<form action="?m=fujing&c=fujing&a=addjiashu" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	
	

	<tr>
		<td width="262" height="37"><strong>家属姓名：</strong></td>
		<td width="437"><input type="input" name="info[xingming]"  style="width:200px;" /></td>
		<td width="267"><strong>性别：</strong></td>
		<td width="674"><?php echo form::select(array('男'=>'男','女'=>'女'),'男','name=info[sex]  class=infoselect')?></td>
	</tr>
	<tr>
		<td width="262" height="37"><strong>身份证：</strong></td>
		<td width="437"><input type="input" name="info[sfz]"  style="width:200px;" /></td>
		<td width="267"><strong>住址：</strong></td>
		<td width="674"><input type="input" name="info[dizhi]"  style="width:200px;"/></td>
	</tr>
	<tr>
		<td width="262" height="37"><strong>电话：</strong></td>
		<td width="437"><input type="input" name="info[tel]"  style="width:200px;"/></td>
		<td width="267"><strong>与辅警关系：</strong></td>
		<td width="674"><?php echo form::select(array('父亲'=>'父亲','母亲'=>'母亲','配偶'=>'配偶','伯父'=>'伯父','伯母'=>'伯母','叔叔'=>'叔叔','婶母'=>'婶母','祖父母'=>'祖父母','外祖父母'=>'外祖父母','儿子'=>'儿子','女儿'=>'女儿','哥哥'=>'哥哥','姐姐'=>'姐姐','弟弟'=>'弟弟','妹妹'=>'妹妹','岳母'=>'岳母','岳父'=>'岳父','妻兄'=>'妻兄','妻姐'=>'妻姐','妻弟'=>'妻弟','妻妹'=>'妻妹'),'','name=info[guanxi] class=infoselect')?></td>
	</tr>
	<tr>
		<td width="262" height="37"><strong>工作单位：</strong></td>
		<td width="437"><input type="input" name="info[gzdw]"  style="width:200px;" /></td>
		<td width="267"><strong></strong></td>
		<td width="674"></td>
	</tr>
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
<input type="hidden" name="id" value="<?php echo $id;?>">
</form>
</div>
</body>
</html>
<script type="text/javascript">

function att_delete(obj,aid){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=fujing&c=fujing&a=deletejiashu&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>