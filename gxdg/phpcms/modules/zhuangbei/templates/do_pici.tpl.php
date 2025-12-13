<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');

?>

<div class="pad-lr-10">
<form action="?m=zhuangbei&c=zhuangbei&a=dopici" method="POST" name="myform" id="myform" onsubmit="return canyong()">
<input type="hidden" name="id" value="<?php echo $piciinfo['id']?>" />
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="17%" height="31" align="right">批次标题：</th>
		<td width="83%"><input type="text" name="do[title]" value="<?php echo $piciinfo['title']?>" size="50"/></td>
	  </tr>
	<tr>
	  <th height="29" align="right">批次日期：</th>
	  <td>
       <?php 
	    //解析批次日期
		if(isset($piciinfo['dotime'])){
		  $pcdt=explode(".",$piciinfo['dotime']/100);
		}else{
		  $pcdt=array(date("Y"),date("m"));	
			}
	    $nianed=$pcdt[0];
		$yueed=$pcdt[1];
	   ?>
       <select name="nians" id="nians" onchange="canyong()">
           <?php    
			 for($years=date("Y")-1;$years<=date("Y")+1;$years++){
		   ?> 
           <option value="<?php echo $years?>" <?php if($years==$nianed){?>selected="selected"<?php }?> ><?php echo $years?></option>
           <?php }?>
          </select> - 
          <select name="yues" id="yues" onchange="canyong()">
           <?php for($yues=1;$yues<=12;$yues++){?>
           <option value="<?php if($yues<=9){echo "0".$yues;}else{echo $yues;}?>" <?php if($yues==$yueed){?>selected="selected"<?php }?> ><?php if($yues<=9){echo "0".$yues;}else{echo $yues;}?></option>
           <?php }?>
          </select> &nbsp; <span id="iserr" style="color:#F00"></span></td>
	  </tr>
	
<tr>
		<th  height="28" align="right">申领开始日期：</th>
		<td ><?php 
		$ktime=$piciinfo['ktime'];$etime=$piciinfo['etime'];
		if(!isset($ktime)){$ktime=time();} echo form::date('do[ktime]',date("Y-m-d",$ktime),0,0,'false');?></td>
	  </tr>
	<tr>
		<th  height="28" align="right">申领结束日期：</th>
		<td ><?php if(!isset($etime)){$etime=time()+3600*24*7;} echo form::date('do[etime]',date("Y-m-d",$etime),0,0,'false');?>  &nbsp;默认一周</td>
	  </tr>
		
		<tr>
		<th  height="13" align="right">是否自动锁定：</th>
		<td ><select name="do[aoutlock]">
               <option value="0" <?php if($piciinfo['aoutlock']==0){?>selected="selected"<?php }?>>不自动锁定</option>
               <option value="1" <?php if($piciinfo['aoutlock']==1){?>selected="selected"<?php }?>>自动锁定</option>
             </select> &nbsp; 选择“自动锁定”则在申领结束日期后自动禁止操作
          </td>
	  </tr>
		<tr>
		  <th  height="14" align="right">备注：</th>
		  <td ><textarea name="do[beizhu]" rows="7" style="width:80%"><?php echo $piciinfo['beizhu']?></textarea></td>
	  </tr>
		
  
	<tr>
		<th></th>
		<td><input type="submit" id="dook" name="dosave" class="button" value=" <?php echo L('submit')?> " style="width:80px; "/> &nbsp; <input type="submit" id="dook" name="nodosave" class="button" value=" 关闭 " style="width:80px; "/></td>
	  </tr>
</table>
</form>
</div>

</body>
<script language="javascript">
function canyong(){
dotime=$("#nians").val()+$("#yues").val()	
$.post("api/canyong.php?rnd"+Math.random() , {dotime:dotime }, function(data){
  //console.log(data)
  var arrs=JSON.parse(data);
  if(arrs.error==0){
	 $("#iserr").html(''); 
	  }else{
		$("#iserr").html(arrs.error);  

		  }
  });		
	}
</script>
</html>



