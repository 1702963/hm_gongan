<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<div class="table-list" >
<input type="button" class="dowhat" id="but0" value="追加记录" onclick="showadd()"/>
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			
			
			<th width="10%" align="center">序号</th>	
			<th width='70%' align="center">履历内容</th>
			<th width='20%' align="center">操作 </th>
			
		</tr>
	</thead>
<tbody>
	<tr id="addform" style="display:none">
  <form action="" method="post">
  <input type="hidden" name="m" value="fujing" />
  <input type="hidden" name="c" value="fujing" />
  <input type="hidden" name="a" value="lvli" />
  <input type="hidden" name="fjid" value="<?php echo $_GET['id']?>" />
		<td align="center" >&nbsp;</td>
		<td align="center" ><textarea name="in[lvli]" style="width:95%" rows="2" ></textarea></td>
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
		<td align="left" ><?php echo $info['lvli']?></td>
		<td align="center" ><a href="index.php?m=renshi&c=renshi&a=lvli&id=<?php echo $_GET['id']?>&dofei=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认作废当前记录吗？');if(!r){return false;}">作废</a></td>
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
</script>
</div>
</div>
</body>
</html>
