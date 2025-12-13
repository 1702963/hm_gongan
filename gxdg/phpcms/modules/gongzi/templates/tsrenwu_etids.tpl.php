<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

if($id!=""){
if($_SESSION['roleid']<=5){
$basenous="disabled=\"disabled\"";;
}}else{
$editnous="";	
	}
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

<div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>辅警特殊任务申请</b></div>
    <form action="" method="post">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="<?php echo $mubiao?>"/>
    <input type="hidden" name="id" value="<?php echo $infos['id']?>"/>
<table width="100%" cellspacing="0" border="1" style="margin-right:10px">

		<tr>
            <td width="9%" align="center" style="font-size:12px">申请人</td>
            <td colspan="2" align="left" style="font-size:12px"><select name="tc[userid]" <?php echo $editnous?>>
                                                                  <?php foreach($fujinglist as $v){
																	    if($_SESSION['roleid']>5){ 
																		if($v['dwid']==$_SESSION['bmid']){
																	  ?>
                                                                      <option value="<?php echo $v['id']?>" <?php if($infos['userid']==$v['id']){?>selected="selected"<?php }?>>[<?php echo $bumen[$v['dwid']]?>]<?php echo $v['xingming']?></option>
                                                                  <?php }}else{ ?>
																	  <option value="<?php echo $v['id']?>" <?php if($infos['userid']==$v['id']){?>selected="selected"<?php }?>>[<?php echo $bumen[$v['dwid']]?>]<?php echo $v['xingming']?></option>
																	<?php  }}?>
                                                                </select>                                                                </td>
		</tr>
	<tr>		
		<td align="center" style="font-size:12px">申请日期</td>
		<td colspan="2" align="left" style="font-size:12px"><select name="tc[yue]" <?php echo $editnous?>>
                                                 <?php for($i=1;$i>=0;$i--){ ?> 
                                                  <option value="<?php echo date("Ym",strtotime(" -".$i." month "))?>"><?php echo date("Ym",strtotime(" -".$i." month "))?></option>
                                                 <?php }?> 
                                                </select> *此项目为关联绩效审核档期，实际申请日期为系统生成，无需指定        </td>
	</tr>
	<tr>
	  <td align="center" style="font-size:12px">任务名称</td>
	  <td colspan="2" align="left" style="font-size:12px"><input type="text" name="tc[rwname]" id="rwname"  style="width:80%" value="<?php echo $infos['rwname']?>"/></td>
	</tr>
	<tr>
	  <td align="center" style="font-size:12px">任务内容</td>
	  <td colspan="2" align="left" style="font-size:12px"><textarea name="tc[rwxq]" id="rwxq" rows="3" style="width:80%" ><?php echo $infos['rwxq']?></textarea></td>
	</tr>    
	<tr>
	  <td align="center" style="font-size:12px">上岗时间</td>
	  <td colspan="2" align="left" style="font-size:12px"><input type="text" name="tc[sgdt]" id="sgdt"  value="<?php echo $infos['sgdt']?>"/> * 日期格式 2020-01-01 其他格式不受支持</td>
	</tr>
	<tr>
	  <td align="center" style="font-size:12px">上岗天数</td>
	  <td colspan="2" align="left" style="font-size:12px"><input type="text" name="tc[tianshu]" id="tianshu"  value="<?php echo $infos['tianshu']?>" /> 天</td>
	</tr>  
    
	<tr>
	  <td align="center" style="font-size:12px">备注</td>
	  <td colspan="2" align="left" style="font-size:12px"><textarea name="tc[beizhu]" id="beizhu" rows="3" style="width:80%" ><?php echo $infos['beizhu']?></textarea></td>
	</tr>
	<tr>
	  <td align="center" style="font-size:12px">补助金额</td>
	  <td colspan="2" align="left" style="font-size:12px"><input type="text" name="tc[je]" id="je" value="<?php echo $infos['je']?>" /> 元</td>
	</tr>
	<tr>
	  <td align="center" style="font-size:12px">申请单位意见</td>
	  <?php if($_SESSION['userid']==$infos['bmuser']){$addnous1="";}?>
	  <input type="hidden" name="tc[bmdt]" value="<?php echo time()?>"  <?php echo $addnous1?>/>
	  <td width="79%" align="left" style="font-size:12px"><textarea name="tc[bmyj]" id="bmyj" rows="3" style="width:95%" <?php echo $addnous1?>><?php echo $infos['bmyj']?></textarea> </td>
	  <td width="12%" align="left" style="font-size:12px"><label><input type="checkbox" name="tc[bmok]" value="1" <?php if($infos['bmok']==1){?>checked="checked"<?php }?>  <?php echo $addnous1?>/>部门审核同意</label></td>
	</tr>
	<tr>
	  <td align="center" style="font-size:12px">分管领导意见</td>
	  <?php if($_SESSION['userid']==$infos['fguser']){$addnous2="";}?>
	  <input type="hidden" name="tc[fgdt]" value="<?php echo time()?>"  <?php echo $addnous2?>/>
	  <td align="left" style="font-size:12px"><textarea name="tc[fgyj]" id="fgyj" rows="3" style="width:95%" <?php echo $addnous2?>><?php echo $infos['fgyj']?></textarea></td>
	  <td align="left" style="font-size:12px"><input type="checkbox" name="tc[fgok]" value="1" <?php if($infos['fgok']==1){?>checked="checked"<?php }?>  <?php echo $addnous2?>/>分管领导审核同意</label></td>
	</tr> 
	<tr>
	  <td align="center" style="font-size:12px">政治处意见</td>
      <?php if($_SESSION['userid']==$infos['zzcuser']){$addnous3="";}?>	
	  <input type="hidden" name="tc[zzcdt]" value="<?php echo time()?>"  <?php echo $addnous3?>/>  
	  <td align="left" style="font-size:12px"><textarea name="tc[zzcyj]" id="zzcyj" rows="3" style="width:95%" <?php echo $addnous3?>><?php echo $infos['zzcyj']?></textarea></td>
	  <td align="left" style="font-size:12px"><input type="checkbox" name="tc[zzcok]" value="1" <?php if($infos['zzcok']==1){?>checked="checked"<?php }?> <?php echo $addnous3?>/>政治处审核同意</label></td>
	</tr> 
	<tr>
	  <td align="center" style="font-size:12px">局领导意见</td>
       <?php if($_SESSION['userid']==$infos['juuser']){$addnous4="";}?>	
	   <input type="hidden" name="tc[judt]" value="<?php echo time()?>"  <?php echo $addnous4?>/>  
	  <td align="left" style="font-size:12px"><textarea name="tc[juyj]" id="juyj" rows="3" style="width:95%" <?php echo $addnous4?>><?php echo $infos['juyj']?></textarea></td>
	  <td align="left" style="font-size:12px"><input type="checkbox" name="tc[juok]" value="1" <?php if($infos['juok']==1){?>checked="checked"<?php }?>  <?php echo $addnous4?>/>局领导审核同意</label></td>
	</tr>          
</table>
<input type="submit" value="确认" id="dook" name="dook" style="display:none"/> 
</form>
</div>
</div>
</body>
</html>
