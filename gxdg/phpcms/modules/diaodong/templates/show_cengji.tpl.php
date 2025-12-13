<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<div class="pad-lr-10">

<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="286" height="36">辅警姓名：</th>
		<td width="1364"><?php echo $info['fjname'];?></td>
	</tr>
	

	<tr>
		<th width="286" height="37">当前层级：</th>
		<td width="1364"><?php echo $cengji[$info['oldcj']];?></td>
	</tr>
	<tr>
		<th width="286" height="37">变更后层级：</th>
		<td width="1364"><?php echo $cengji[$info['newcj']];?></td>
	</tr>

	<tr>
		<th width="286" height="37">变更说明：</th>
		<td width="1364"><?php echo $info['content'];?></td>
	</tr>
	
	<tr>
		<th width="286" height="37">录入人：</th>
		<td width="1364"><?php 
		$this->db->table_name = 'mj_admin';
		$lr = $this->db->get_one("userid=".$info['userid'],'*');
		echo $lr['username'];?></td>
	</tr>
	<tr>
		<th width="286" height="37">录入时间：</th>
		<td width="1364"><?php echo date("Y-m-d",$info['inputtime']);?></td>
	</tr>
	<tr>
		<th width="286" height="37">审批人：</th>
		<td width="1364">
		<?php 
		if($info['shid']>0){
		$this->db->table_name = 'mj_admin';
		$sh = $this->db->get_one("userid=".$info['shid'],'*');
		echo $sh['username'];
		}
		?>
		</td>
	</tr>
	<tr>
		<th width="286" height="37">审批说明：</th>
		<td width="1364"><?php if($info['shnr']<>''){echo $info['shnr'];}?></td>
	</tr>
	<tr>
		<th width="286" height="37">审批时间：</th>
		<td width="1364"><?php if($info['shtime']>0){echo date("Y-m-d",$info['shtime']);}?></td>
	</tr>
	<tr>
		<th width="286" height="37">状态：</th>
		<td width="1364"><?php if($info['status']==2){echo "<span style='color:#red'>未通过</span>";}elseif($info['status']==9){echo "<span style='color:#090'>已通过</span>";}else{echo "待审批";}?></td>
	</tr>
</table>

</div>
</body>
</html>



