<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <form action="" method="POST">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="tcgongxianshenhe"/>
    <input type="hidden" name="ty" value="<?php echo $_GET['ty']?>"/> 
    <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>
    <input type="hidden" name="bmid" value="<?php echo $infos['bmid']?>"/>
<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
		<tr>
            <td width="30%" align="center" style="font-size:12px">选择上报对象</td>
            <td align="left" style="font-size:12px">
			 <select name="sq[<?php echo $rowsname?>]">
              <?php if(!is_array($shenpis)){?> 
              <option value="0">未匹配到上报对象</option>
              <?php }else{?>             
              <?php foreach($shenpis as $k=>$v){?>
              <option value="<?php echo $k?>"><?php echo $v?></option>
              <?php }}?>
             </select>
            </td>
		</tr>
	<tr>		
</table>
<input type="submit" value="确认" id="dook" name="dook" style="display:none" /> 
</form>
</div>
</div>
</body>
</html>
