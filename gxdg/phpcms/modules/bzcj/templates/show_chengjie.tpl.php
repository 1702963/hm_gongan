<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<div class="pad-lr-10">

<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="286" height="36">辅警姓名：</th>
		<td width="1364"><?php echo $chengjie['fjname'];?></td>
	</tr>
	

	<tr>
		<th width="286" height="37">惩戒标题：</th>
		<td width="1364"><?php echo $chengjie['title'];?></td>
	</tr>
	<tr>
		<th width="286" height="37">惩戒原因：</th>
		<td width="1364"><?php echo $chengjie['content'];?></td>
	</tr>
	<tr>
		<th width="286" height="37">惩戒时间：</th>
		<td width="1364"><?php echo date("Y-m-d",$chengjie['bztime']);?></td>
	</tr>
	<tr>
		<th width="286" height="37">处罚内容：</th>
		<td width="1364"><?php echo $chengjie['jl'];?></td>
	</tr>
	<tr>
		<th width="286" height="37">处罚金额：</th>
		<td width="1364"><?php echo $chengjie['gongzi'];?></td>
	</tr>
	<tr>
		<th width="286" height="37">录入人：</th>
		<td width="1364"><?php 
		$this->db->table_name = 'mj_admin';
		$lr = $this->db->get_one("userid=".$chengjie['userid'],'*');
		echo $lr['username'];?></td>
	</tr>
	<tr>
		<th width="286" height="37">录入时间：</th>
		<td width="1364"><?php echo date("Y-m-d",$chengjie['inputtime']);?></td>
	</tr>
	<tr>
		<th width="286" height="37">审批人：</th>
		<td width="1364">
		<?php 
		if($chengjie['shid']>0){
		$this->db->table_name = 'mj_admin';
		$sh = $this->db->get_one("userid=".$chengjie['shid'],'*');
		echo $sh['username'];
		}
		?>
		</td>
	</tr>
	<tr>
		<th width="286" height="37">审批说明：</th>
		<td width="1364"><?php if($chengjie['shnr']<>''){echo $chengjie['shnr'];}?></td>
	</tr>
	<tr>
		<th width="286" height="37">审批时间：</th>
		<td width="1364"><?php if($chengjie['shtime']>0){echo date("Y-m-d",$chengjie['shtime']);}?></td>
	</tr>
	<tr>
		<th width="286" height="37">状态：</th>
		<td width="1364"><?php if($chengjie['status']==2){echo "<span style='color:#red'>未通过</span>";}elseif($chengjie['status']==9){echo "<span style='color:#090'>已通过</span>";}else{echo "待审批";}?></td>
	</tr>
</table>

</div>
</body>
</html>



