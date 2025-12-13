<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list">
<div style="color:#F00"> &nbsp; 非开发者慎用基础设置功能，错误的操作将不可逆的覆盖数据，影响多个模块的正常运行</div>
<table width="100%" border="0" style="margin:5px 0 5px 0">
	<thead>
		<tr>	
			<th colspan="10" align="left">&nbsp;系统保留设置 &nbsp;<?php echo $basemsg1 ?></th>
		</tr>
	</thead>
 <tbody>
<?php if(is_array($syslists)){
	foreach($syslists as $vs){
	?> 
  <tr>
<form name="myform" id="myform" action="?m=gongzi&c=jixiao&a=sets" method="POST"> 
 <input type="hidden" name="ids" value="<?php echo $vs["id"]?>" />
    <td width="12%" align="right">&nbsp;</td>
    <td width="10%" align="right"><?php echo $vs["setname"]?></td>
    <td width="4%">&nbsp;</td>
    <td width="5%" align="right"><?php if($vs['iscan']==1){?>权重<?php }else{?>金额<?php }?></td>
    <td width="10%"><input type="text" name="canshu" value="<?php echo $vs["canshu"]?>" size="10"/></td>
    <td width="7%" align="right">有效范围</td>
    <td width="42%"><input type="text" name="fanwei" value="<?php echo $vs["fanwei"]?>" size="50" <?php if($vs['iscan']==1){?>readonly="readonly"<?php }?>/> *本参数存储单位ID</td>
    <td width="10%"><input type="submit" name="addnew4" value="保存设置" style="width:90px; height:24px"/></td>
 </form> 
    </tr>
<?php }}?>    
  </tbody>
</table>
<!---->
<table width="100%" border="0" style="margin:5px 0 5px 0">
	<thead>
		<tr>	
			<th colspan="10" align="left">&nbsp;基础设置 &nbsp;<?php echo $basemsg ?></th>
		</tr>
	</thead>
 <tbody>
<form name="myform" id="myform" action="?m=gongzi&c=jixiao&a=sets" method="POST">
  <tr>
    <td width="12%" align="right">创建关联类型</td>
    <td width="10%" align="right">类型名称</td>
    <td width="14%"><input type="text" name="setname" value=""  /></td>
    <td width="7%" align="right">关联类型</td>
    <td width="13%"><select name="settype">
                      <option value="0">新建</option>
                     <?php foreach($bases as $v){?>
                      <option value="<?php echo $v['id']?>"><?php echo $v['setname']."[".$zts[$v['iscan']]."]"?></option>
                     <?php }?>
                    </select>
    </td>
    <td width="7%" align="right">状态</td>
    <td width="27%"><select name="iscan" >
                      <option value="1">启用</option>
                      <option value="0">停用</option>
                    </select>
    </td>
    <td width="10%"><input type="submit" name="addnew" value="保存设置" style="width:90px; height:24px"/></td>
    </tr>
  </form>    
  <tr>      
<form name="myform" id="myform" action="?m=gongzi&c=jixiao&a=sets" method="POST">
    <td align="right">关联项目</td>
    <td align="right">项目名称</td>
    <td width="14%"><input type="text" name="setname" value="" size="20"/></td>
    <td width="7%" align="right">归属项目</td>
    <td width="13%">
                     <select name="settype">
                     <?php foreach($bases as $v1){
						 if($v1['iscan']==1){
						 ?>
                      <option value="<?php echo $v1['id']?>" <?php if($v1['settype']==$v['pid']){?>selected="selected"<?php }?> ><?php echo $v1['setname']?></option>
                     <?php }}?>
                    </select>    
      </td>
    <td width="7%" align="right">参数</td>
    <td><input type="text" name="canshu" value="" size="20"/></td>
    <td width="10%"><input type="submit" name="addnew1" value="新建项目" style="width:90px; height:24px"/></td>
</form>  
    </tr>
<?php if(is_array($baseslists)){

	  foreach($baseslists as $v){
	?> 
  <tr>      
<form name="myform" id="myform" action="?m=gongzi&c=jixiao&a=sets" method="POST">
<input type="hidden" name="ids" value="<?php echo $v["id"]?>" />
  
    <td align="right">&nbsp;</td>
    <td align="right">项目名称</td>
    <td width="14%"><input type="text" name="setname" value="<?php echo $v["setname"]?>" size="20"/></td>
    <td width="7%" align="right">归属项目</td>
    <td width="13%">
                     <select name="settype">
                     <?php foreach($bases as $v1){
						 if($v1['iscan']==1){
						 ?>
                      <option value="<?php echo $v1['id']?>" <?php if($v1['settype']==$v['pid']){?>selected="selected"<?php }?> ><?php echo $v1['setname']?></option>
                     <?php }}?>
                    </select>    
      </td>
    <td width="7%" align="right">参数</td>
    <td><input type="text" name="canshu" value="<?php echo $v["canshu"]?>" size="20"/> <label><input type="checkbox" name="iscan" value="1" <?php if($v['iscan']==1){?>checked="checked"<?php }?>/>启用</label></td>
    <td width="10%"><input type="submit" name="addnew2" value="保存" style="width:90px; height:24px"/></td>
</form>  
    </tr>
<?php 

}}?>  
  </tbody>
</table>
<!---->


</div>
</div>
</body>
</html>
<script type="text/javascript">

function att_delete(obj,aid){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=cengji&c=cengji&a=delete&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};

function adds() {
		window.top.art.dialog({title:'新建字段', id:'adds', iframe:'?m=gongzi&c=gzgl&a=adds' ,width:'900px',height:'550px'}, 	function(){var d = window.top.art.dialog({id:'adds'}).data.iframe;
		var form = d.document.getElementById('adddo');form.click();return false;}, function(){window.top.art.dialog({id:'adds'}).close()});
	}
	
function doedits(){
	alert("系统保留字段不允许编辑")
	return false
	}	
</script>