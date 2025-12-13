<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<div class="pad-lr-10">
<form action="?m=bzcj&c=biaozhang&a=sh" method="POST" name="myform" id="myform">
  <table cellpadding="2" cellspacing="1" class="table_form" width="100%">
    <tr>
      <th width="18%" height="36">审批状态：</th>
      <td width="82%"><?php echo form::select(array(2=>'驳回',9=>'通过'),9,'name=info[status] class=infoselect')?></td>
    </tr>
    <tr>
      <th  height="37">审批说明：</th>
      <td ><textarea name="info[shnr]" cols="" rows="8" style="width:350px;"></textarea></td>
    </tr>
    <tr>
      <td height="126" colspan="2" align="center"><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
      </tr>
  </table>
  <input type="hidden" name="id" value="<?php echo $id;?>">
</form>
</div>
</body>
</html>



