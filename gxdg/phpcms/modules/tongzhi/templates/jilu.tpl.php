<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<div class="table-list">

<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="82" align="center">阅读人</th>
            <th width='660' align="center">阅读时间</th>
		
		</tr>
	</thead>
<tbody>
<?php
if(is_array($hys)){
		$this->db->table_name = 'dx_admin';
		
	foreach($hys as $info){
		?>
	<tr>
		
		
		<td align="center" width="82"><?php
        
		$yuangong = $this->db->get_one("userid='".$info['userid']."'",'*');
		echo $yuangong['username'];
		?></td>
       
		<td align="center" width="238"><?php echo date("Y-m-d H:i:s",$info['readtime']);?></td>
      
	</tr>
	<?php
	}
}
?>
</tbody>
</table>

<div id="pages"><?php echo $pages?></div>

</div>
</div>
</body>
</html>
