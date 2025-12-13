<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<div class="table-list" >
  <table width="100%" cellspacing="0">
    <thead>
		<tr>
			
			
			<th width="14%" align="center">项目</th>	
			<th width='86%' align="center">内容</th>
        </tr>
	</thead>
<tbody>
 
	<tr>
		<td align="center" >特长类型</td>
		<td align="left" ><select name="mclass" onchange="getsub(this.value)">
                       <option value="">不限</option> 
                         <?php foreach($tcclass as $v){
							   if($v['pid']<1){
							 ?>
                             <option value="<?php echo $v['id']?>" <?php if($mclasss==$v['id']){?>selected="selected"<?php }?>><?php echo $v['classname']?></option>
                             <?php }}?>
                      </select>&nbsp;&nbsp;
                           </select> - <select name="tcid" id="tcid">
                             <option value="">不限</option> 
                             <?php if($tcids!=''){?>
                             <?php foreach($tcclass as $v){
							   if($v['pid']==$mclasss){
							 ?>
                             <option value="<?php echo $v['id']?>" <?php if($tcids==$v['id']){?>selected="selected"<?php }?>><?php echo $v['classname']?></option>
                             <?php }}?>                             
                             <?php }?>                        
                           </select></td>
        </tr>
	<tr>
	  <td align="center" >特长详情</td>
	  <td align="left" ><?php echo $rencais['xiangqing']?></td>
	  </tr>
	<tr>
	  <td align="center" >证明材料</td>
	  <td align="left" ><?php echo $rencais['zhengming']?></td>
	  </tr>
	<tr>
	  <td align="center" >审核情况</td>
	  <td align="left" ><?php $shzt="未审核";if($rencais['zzcok']==1){$shzt="已审核";}echo $shzt;?></td>
	  </tr>
	<tr>
	  <td align="center" >&nbsp;</td>
	  <td align="left" >&nbsp;</td>
	  </tr>
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
  
  if(subid!=''){
    for(j=0,maxs=subclass.length;j<maxs;j++){
     if(subclass[j][2]==parseInt(subid)){	
       onnew+="<option value='"+subclass[j][0]+"'>"+subclass[j][1]+"</option>"	
  	 }
    }
  }else{
	  onnew+="<option value=''>不限</option>"  
	  }
  
  $("#tcid").html(onnew)  
}
</script>
</div>
</div>
</body>
</html>
