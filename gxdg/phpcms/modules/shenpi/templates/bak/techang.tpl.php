<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<div class="table-list" >
<input type="button" class="dowhat" id="but0" value="追加记录" onclick="showadd()" style="display:"/>
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="5%" align="center">序号</th>	
			<th width='25%' align="center">特长类型</th>
            <th width='25%' align="center">特长详情</th>
            <th width='25%' align="center">证明材料</th>
			<th width='15%' align="center">操作 </th>
			
		</tr>
	</thead>
<tbody>
	<tr id="addform" style="display:none">
  <form action="" method="post">
  <input type="hidden" name="m" value="fujing" />
  <input type="hidden" name="c" value="fujing" />
  <input type="hidden" name="a" value="techang" />
  <input type="hidden" name="fjid" value="<?php echo $_GET['id']?>" />
        <td align="center" >&nbsp;</td>
		<td align="center" ><select name="mclass" onchange="getsub(this.value)">
                             <?php foreach($tcclass as $v){
								   if($v['pid']<1){
								 ?>
                             <option value="<?php echo $v['id']?>"><?php echo $v['classname']?></option>
                             <?php }}?>
                           </select> - <select name="tcid" id="tcid">
                             <?php foreach($tcclass as $v){
								   if($v['pid']==1){
								 ?>
                             <option value="<?php echo $v['id']?>"><?php echo $v['classname']?></option>
                             <?php }}?>                           
                           </select>
                           
                           </td>
        <td align="center" ><textarea name="in[xiangqing]" style="width:95%" rows="2" ></textarea></td>
		<td align="center" ><textarea name="in[zhengming]" style="width:95%" rows="2" ></textarea></td>
		<td align="center" ><input type="submit" class="dowhat" name="dook" value="保存" /></td>
  </form>  
	</tr>
 
<?php
$i=1;
if(is_array($peixun)){
	foreach($peixun as $info){
		?>
	<tr>
		<td align="center" ><?php  echo $i?></td>
		<td align="left" ><?php echo $tcclassys[$info['tcid']]?></td>
        <td align="left" ><?php echo $info['xiangqing']?></td>
        <td align="left" ><?php echo $info['zhengming']?></td>
		<td align="center" ><a href="index.php?m=fujing&c=fujing&a=techang&id=<?php echo $_GET['id']?>&dofei=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认作废当前记录吗？');if(!r){return false;}">作废</a></td>
	</tr>
	<?php
	$i++;}
}
?>
</tbody>
</table>


<script language="javascript">
function showadd(){
	if($("#but0").val()=="追加记录"){
		$("#but0").val("取消追加")
		$("#addform").css("display","")
		}else{
		$("#but0").val("追加记录")
		$("#addform").css("display","none")			
			}
	}
	
function getsub(subid){
var subclass = new Array()
<?php for($i=0;$i<count($tcclass);$i++){?>
    subclass[<?php echo $i?>]=new Array('<?php echo $tcclass[$i]['id']?>','<?php echo $tcclass[$i]['classname']?>','<?php echo $tcclass[$i]['pid']?>')
<?php }?>

  onnew="";
  for(j=0,maxs=subclass.length;j<maxs;j++){
     if(subclass[j][2]==parseInt(subid)){	
       onnew+="<option value='"+subclass[j][0]+"'>"+subclass[j][1]+"</option>"	
  	 }
  }
  $("#tcid").html(onnew)  
}	
</script>
</div>
</div>
</body>
</html>
