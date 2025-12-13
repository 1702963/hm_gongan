<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<div class="explain-col"> 
<form name="searchform" method="get" id="daoxls" >
<input type="hidden" value="zhuangbei" name="m">
<input type="hidden" value="zhuangbei" name="c">
<input type="hidden" value="sou" name="a">
<table width="100%" border="0">
  <tr>
    <td height="30">
  姓名: <input type="text" value="<?php echo $xingming?>" class="input-text" size="6" name="xingming">&nbsp;&nbsp;
  辅警号: <input type="text" value="<?php echo $fjh?>" class="input-text" size="6" name="fjh">&nbsp;&nbsp;
  单位：<select name="dwid">
                       <?php foreach($bms as $k=>$v){?>
                       <option value="<?php echo $k?>" <?php if($k==$dwids){?>selected="selected"<?php }?> ><?php echo $v?></option>
                       <?php }?>
                      </select>
  &nbsp;&nbsp;
  职务：<select name="zhiwu">
                       <?php foreach($bms as $k=>$v){?>
                       <option value="<?php echo $k?>" <?php if($k==$dwids){?>selected="selected"<?php }?> ><?php echo $v?></option>
                       <?php }?>
                      </select>
  &nbsp;&nbsp;  
  入警时间：<select name="zhiwu">
                       <?php foreach($bms as $k=>$v){?>
                       <option value="<?php echo $k?>" <?php if($k==$dwids){?>selected="selected"<?php }?> ><?php echo $v?></option>
                       <?php }?>
                      </select>
  &nbsp;&nbsp;   
  发放时间: 
  <select name="zbid">
          <option value="">不限</option>
           <?php
		   for($i=1999;$i<=date("Y");$i++){
		   ?>
           <option value="<?php echo $i;?>" <?php if($zbids==$i){?>selected="selected"<?php }?> ><?php echo $i;?></option>
             <?php }?>  
       </select> 
 
           &nbsp;&nbsp;
  <input type="submit" value="筛选" class="button" name="dotongji" style="width:70px"></td>
    </tr>  
</table>
</form>
	</div>
    
<div class="table-list">
<form name="myform" id="myform" action="?m=zhuangbei&c=zhuangbei&a=fa" method="POST">
<table width="60%" cellspacing="0" style="float:left;">
	<thead>
		<tr>
			
			
			<th width="3%" align="center">&nbsp;</th>
			<th width='5%' align="center">辅警姓名</th>			
			<th width='7%' align="center">辅警号</th>
			<th width='8%' align="center">入警时间</th>
			<th width='6%' align="center">发放时间</th>
			<th width='5%' align="center">服装类型</th>
		
			
		</tr>
	</thead>
<tbody>
<?php
if(is_array($zhuangbei)){

	foreach($zhuangbei as $info){
	
		?>
	<tr>
		
		
		<td align="center" ><input type="checkbox" name="fjid[]" checked="checked" value="<?php echo $info['id']?>"></td>
		<td align="center" ><?=$info['xingming']?></td>
		<td align="center" ><?=$info['gzz']?></td>
		<td align="center" ><?php echo date("Y-m",$info['rjtime']);?></td>
		<td align="center" ><?=$info['zzsj']?></td>
		<td align="center" ><?=$info['fzlx']?></td>
	
                                       
	</tr>
	<?php
	}
}
?>
</tbody>
</table>

<table width="19%" cellspacing="0" style="float:left; margin-left:100px;">
	
<tbody>

	<tr>	
		<td width="32%" align="center" >人数：</td>  
		<td width="68%" align="left" ><?php echo count($zhuangbei);?>&nbsp;人</td>                                        
	</tr>
	<tr>	
		<td align="center" >发放被装：</td>  
		<td align="left" >
		<input type="checkbox" name="zb[]"  value="辅警号">&nbsp;辅警号<br />
		<?php
if(is_array($fields)){
	foreach($fields as $field){
		?>
		<input type="checkbox" name="zb[]"  value="<?php echo $field['name'];?>">&nbsp;<?php echo $field['name'];?><br />

		
		<?php
	}
}
?>
		</td>                                        
	</tr>
	<tr>	
		<td colspan="2" align="center" ><input type="submit" value="发放" class="button" name="dosubmit" style="width:70px"></td>  
		</tr>
</tbody>
</table>
</form>
</div>
</div>
</body>
</html>
