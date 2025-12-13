<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<div class="pad-lr-10">

<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="286" height="36">辅警姓名：</th>
		<td width="1364"><?php echo $biaozhang['fjname'];?></td>
	</tr>
	

	<tr>
		<th width="286" height="37">表彰标题：</th>
		<td width="1364"><?php echo $biaozhang['title'];?></td>
	</tr>
	<tr>
		<th width="286" height="37">表彰原因：</th>
		<td width="1364"><?php echo $biaozhang['content'];?></td>
	</tr>
	<tr>
		<th width="286" height="37">表彰时间：</th>
		<td width="1364"><?php echo date("Y-m-d",$biaozhang['bztime']);?></td>
	</tr>
	<tr>
		<th width="286" height="37">奖励内容：</th>
		<td width="1364"><?php echo $biaozhang['jl'];?></td>
	</tr>
	<tr>
		<th width="286" height="37">奖励金额：</th>
		<td width="1364"><?php echo $biaozhang['gongzi'];?></td>
	</tr>
	<tr>
		<th width="286" height="37">录入人：</th>
		<td width="1364"><?php 
		$this->db->table_name = 'mj_admin';
		$lr = $this->db->get_one("userid=".$biaozhang['userid'],'*');
		echo $lr['username'];?></td>
	</tr>
	<tr>
		<th width="286" height="37">录入时间：</th>
		<td width="1364"><?php echo date("Y-m-d",$biaozhang['inputtime']);?></td>
	</tr>
	<tr>
		<th width="286" height="37">审批人：</th>
		<td width="1364">
		<?php 
		if($biaozhang['shid']>0){
		$this->db->table_name = 'mj_admin';
		$sh = $this->db->get_one("userid=".$biaozhang['shid'],'*');
		echo $sh['username'];
		}
		?>
		</td>
	</tr>
	<tr>
		<th width="286" height="37">审批说明：</th>
		<td width="1364"><?php if($biaozhang['shnr']<>''){echo $biaozhang['shnr'];}?></td>
	</tr>
	<tr>
		<th width="286" height="37">审批时间：</th>
		<td width="1364"><?php if($biaozhang['shtime']>0){echo date("Y-m-d",$biaozhang['shtime']);}?></td>
	</tr>
	<tr>
		<th width="286" height="37">状态：</th>
		<td width="1364"><?php if($biaozhang['status']==2){echo "<span style='color:#red'>未通过</span>";}elseif($biaozhang['status']==9){echo "<span style='color:#090'>已通过</span>";}else{echo "待审批";}?></td>
	</tr>
</table>

</div>
</body>
</html>



