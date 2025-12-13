<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list">
<form name="myform" id="myform" action="?m=gongzi&c=gzgl&a=sets" method="POST">
<input type="hidden" name="baseid" value="<?php echo $bases["id"]?>" />
<table width="100%" border="0" style="margin:5px 0 5px 0">
	<thead>
		<tr>	
			<th colspan="10" align="left">&nbsp;基础设置 &nbsp;<?php echo $basemsg ?></th>
		</tr>
	</thead>
 <tbody>
  <tr>
    <td width="12%" align="right">控制设置</td>
    <td width="10%" align="right">工资账截止日</td>
    <td width="22%"><select name="jiezhi">
                      <?php for($i=1;$i<=31;$i++){?>
                        <option value="<?php echo $i?>" <?php if($i==$bases["jiezhi"]){?> selected="selected" <?php }?>><?php echo $i?></option>
                      <?php }?>
                    </select> &nbsp;*工资账封账最后日期</td>
    <td width="8%" align="right">系统通知</td>
    <td width="19%"><select name="tongzhi">
                      <option value="0" <?php if($bases["tongzhi"]==0){?> selected="selected" <?php }?>>不提示</option>
                      <option value="3" <?php if($bases["tongzhi"]==3){?> selected="selected" <?php }?>>提前3天</option>
                      <option value="5" <?php if($bases["tongzhi"]==5){?> selected="selected" <?php }?>>提前5天</option>
                      <option value="7" <?php if($bases["tongzhi"]==7){?> selected="selected" <?php }?>>提前7天</option>
                    </select>
    </td>
    <td width="7%" align="right">自动封账</td>
    <td width="12%"><select name="fengzhang" disabled="disabled">
                      <option value="0">否</option>
                    </select>
    </td>
    <td width="10%"><input type="submit" name="bsave" value="保存设置" style="width:90px; height:24px"/></td>
    </tr>
  <tr>
    <td align="right">基础数据</td>
    <td align="right">基本工资</td>
    <td width="22%"><input type="text" name="jbgz" value="<?php echo $bases["jbgz"]?>" size="10"/>
      元</td>
    <td width="8%" align="right">女职工卫生费</td>
    <td width="19%"><input type="text" name="nvwsf" value="<?php echo $bases["nvwsf"]?>" size="10"/>
      元</td>
    <td width="7%" align="right">社会最低工资</td>
    <td><input type="text" name="zdgz" value="<?php echo $bases["zdgz"]?>" size="10"/>元</td>
    <td width="10%">&nbsp;</td>
    </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">失业保险基数</td>
    <td width="22%"><input type="text" name="sybxjs" value="<?php echo $bases["sybxjs"]?>" size="10"/>
    元，扣缴比例 <input type="text" name="sybxbl" value="<?php echo $bases["sybxbl"]?>" size="6"/></td>
    <td width="8%" align="right">医疗保险基数</td>
    <td width="19%"><input type="text" name="yiliaojs" value="<?php echo $bases["yiliaojs"]?>" size="10"/>
    元，扣缴比例 <input type="text" name="yiliaobl" value="<?php echo $bases["yiliaobl"]?>" size="6"/></td>
    <td width="7%" align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">养老保险基数</td>
    <td width="22%"><input type="text" name="ylbxjs" value="<?php echo $bases["ylbxjs"]?>" size="10"/>
    元，扣缴比例 <input type="text" name="ylbxbl" value="<?php echo $bases["ylbxbl"]?>" size="6"/></td>
    <td width="8%" align="right">平均工作日</td>
    <td width="19%"><input type="text" name="pjgzr" value="<?php echo $bases["pjgzr"]?>" size="6"/>天</td>
    <td width="7%" align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  </tbody>
</table>
</form>
<hr style="height:1px;border:none;border-top:1px solid #004f8c;" />

<table width="100%" border="0" style="margin:5px 0 5px 0">
	<thead>
		<tr>	
			<th colspan="10" align="left">&nbsp;特殊工资基数 &nbsp;<input type="button" name="bsave" value="管理特殊工资基数" style="width:120px; height:24px" onclick="addzdy()"/>&nbsp; &nbsp; 当前特殊工资基数人员 <?php echo $zdygzjs['zj']?> 名</th>
		</tr>
	</thead>
</table>

<hr style="height:1px;border:none;border-top:1px solid #004f8c;" />
<form name="myform" id="myform" action="?m=gongzi&c=gzgl&a=sets" method="POST">
<table width="100%" cellspacing="0">
	<thead>
		<tr>	
			<th width="5%" align="center">ID</th>
			<th width='10%' align="center">字段名</th>
			<th width='10%' align="center">字段</th>
			<th width='10%' align="center">字段类型</th>
            <th align="center" width="20%">字段公式</th>
            <th align="center" width="20%">字段备注</th>
            <th align="center" width="5%">启用</th>
            <th align="center" >系统默认</th>
			<th align="center" >操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($gz_fies)){
	foreach($gz_fies as $info){
	   if($info['ismain']==1){
		  $readonly="readonly=\"readonly\""; 
		   }else{
			$readonly="";   
			   }	
		?>
	<tr>
	<form action="" method="post">
    <input type="hidden" name="m" value="gongzi" />	
    <input type="hidden" name="c" value="gzgl" />
    <input type="hidden" name="a" value="sets" />
    <input type="hidden" name="id" value="<?php echo $info[id]?>" />
		
		<td align="center" ><?php echo $info['id']?></td>
		<td align="center" ><?php echo $info['fiesname']?></td>
		<td align="center" ><?php echo $info['rowsname']?></td>
		<td align="center" ><?php echo $info['fiestype']?></td>
        <td align="center" ><textarea rows="1" name="gongshi" style="width:90%; height:24px" <?php echo $readonly?>><?php echo $info['gongs']?></textarea></td>
        <td align="center" ><textarea rows="1" name="beizhu" style="width:90%; height:24px" <?php echo $readonly?>><?php echo $info['beiz']?></textarea></td>
        <td align="center" ><select name="iscan">
                              <option value="0" <?php if($info['iscan']==0){?>selected="selected"<?php }?>>停用</option>
                              <option value="1" <?php if($info['iscan']==1){?>selected="selected"<?php }?>>启用</option>
                            </select>
        </td>
        <td align="center" ><?php if($info['ismain']==1){echo "<font color=red>是</font>";}else{ echo "否";}?></td>
		<td align="center" ><input type="submit" name="doedit" value="编辑" style="width:40px; height:30px" onclick="return doedits()"/></td>
	</tr>
    </form>
	<?php
	}
}
?>
</tbody>
	<thead>
		<tr>	
			<th align="center" colspan="8" style="color:red"> &nbsp; *编辑已存在的字段或者新建字段必须在空白月度工资表进行，否则可能出现无法纠正的数据异常 </th>

			<th align="center" ><input type="submit" name="bsave" value="新建字段" style="width:90px; height:24px" onclick="adds()"/></th>
		</tr>
     </thead>   
</table>

<div id="pages"><?php echo $pages?></div>
</form>
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
	
function addzdy() {
		window.top.art.dialog({title:'新建自定义工资基数', id:'adds', iframe:'?m=gongzi&c=gzgl&a=addzdy' ,width:'1200px',height:'550px'}, 	function(){var d = window.top.art.dialog({id:'adds'}).data.iframe;
		var form = d.document.getElementById('adddo');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'adds'}).close()});
	}	
	
function doedits(){
	alert("系统保留字段不允许编辑")
	return false
	}	
</script>