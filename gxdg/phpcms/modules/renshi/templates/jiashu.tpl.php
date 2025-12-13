<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');

$zzmm[1]="中共党员";
$zzmm[2]="共青团员";
$zzmm[3]="民主党派";
$zzmm[4]="学生";
$zzmm[5]="群众";
?>
<div class="pad-lr-10">
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<style type="text/css">
.kotable {margin-top:0}
input[type=input] {height:24px}
.infoselect {width:200px;height:24px;border:0;margin-left:0}
.table_form {width:98%; margin-left:1%}
.kotable a {padding:2px 8px;background:#F66;color:#fff;border-radius:3px}
.kotable a:hover {background:#c00}
.kotable tbody tr {transition: all .2s ease-in-out}
.kotable tbody tr:nth-child(even) {background:#373891}
.kotable tbody tr:hover {background:#077fac}
.table_form input[type=submit] {background:#3C6}
.table_form input[type=submit]:hover {background:#3CC}
</style>

<div class="table-list" style="height:320px;">

<table width="100%" cellspacing="0" class="kotable">
	<thead>
		<tr>
			<th width='159' align="center">家属姓名</th>
			<th width='208' align="center">与民/辅警关系</th>
			<th width='59' align="center">性别</th>
			<th width='155' align="center">身份证/生日</th>
			<th width='156' align="center">政治面貌</th>
			<th width='478' align="center">住址</th>
			<th width='233' align="center">电话</th>
			<th width='363' align="center">工作单位</th>
			<th width="99" align="center">操作</th>
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
		<td width="255" align="center"><?=$info['sfz']?>/<?php echo $info['shengri']?></td>
		<td width="156" align="center"><?php echo $zzmm[$info['zzmm']]?></td>
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
<form action="?m=renshi&c=renshi&a=addjiashu" method="POST" name="myform" id="myform">
<table width="966" cellpadding="2" cellspacing="1" class="table_form">

	<tr>
		<td width="11%" height="37"><strong>家属姓名：</strong></td>
		<td width="23%"><input type="input" name="info[xingming]"  style="width:200px;"  required  oninvalid="setCustomValidity('请填写家属姓名');" oninput="setCustomValidity('');" /></td>
		<td width="15%"><strong>性别：</strong></td>
		<td width="6%"><?php echo form::select(array('男'=>'男','女'=>'女'),'男','name=info[sex]  class=infoselect')?></td>
		<td width="9%" height="37"><strong>身份证：</strong></td>
		<td width="36%"><input type="input" name="info[sfz]"  style="width:250px;"  required  oninvalid="setCustomValidity('请填写身份证号码');" oninput="setCustomValidity('');" /></td>
	</tr>
    
    
    
	<tr>
		<td width="11%" height="18"><strong>电话：</strong></td>
		<td width="23%"><input type="input" name="info[tel]"  style="width:200px;"/></td>
		<td width="15%"><strong>住址：</strong></td>
		<td colspan="3"><input type="input" name="info[dizhi]"  style="width:400px;"  required  oninvalid="setCustomValidity('请填写住址');" oninput="setCustomValidity('');"/></td>
	</tr>
	<tr>
	  <td height="18"><strong>生日：</strong></td>
	  <td width="23%"><input type="input" name="info[shengri]"  style="width:200px;"/></td>
	  <td width="15%"><strong>政治面貌：</strong></td>
	  <td colspan="3"><?php echo form::select($zzmm,'5','name=info[zzmm]  class=infoselect')?></td>
	  </tr>
	<tr>
		<td width="11%"><strong>与民/辅警<br>关系：</strong></td>
		<td width="23%"><?php echo form::select(array('父亲'=>'父亲','母亲'=>'母亲','配偶'=>'配偶','伯父'=>'伯父','伯母'=>'伯母','叔叔'=>'叔叔','婶母'=>'婶母','祖父母'=>'祖父母','外祖父母'=>'外祖父母','儿子'=>'儿子','女儿'=>'女儿','哥哥'=>'哥哥','姐姐'=>'姐姐','弟弟'=>'弟弟','妹妹'=>'妹妹','岳母'=>'岳母','岳父'=>'岳父','妻兄'=>'妻兄','妻姐'=>'妻姐','妻弟'=>'妻弟','妻妹'=>'妻妹'),'','name=info[guanxi] class=infoselect')?></td>
		<td width="15%" height="37"><strong>工作单位：</strong></td>
		<td colspan="3"><input type="input" name="info[gzdw]"  style="width:400px;"  required  oninvalid="setCustomValidity('请填写工作单位');" oninput="setCustomValidity('');" /></td>

	</tr>
	<tr>
		<td colspan="6"><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
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
	$.get('?m=renshi&c=renshi&a=deletejiashu&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>