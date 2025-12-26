<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new', 'admin');?>
<SCRIPT LANGUAGE="JavaScript">
<!--
parent.document.getElementById('display_center_id').style.display='none';
//-->
</SCRIPT>

<style type="text/css">
html{_overflow-y:scroll}
.kotable thead tr th {
    background: #252682;
    color: #bbd8f1;
    border: 1px solid #3132a4;
}
</style>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<div class="tableContent">
<div class="pad-lr-10">

<div class="explain-col">
  快速工具:
  <a href="?m=admin&c=category&a=add&menuid=<?php echo $_GET['menuid']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>"><input type="button" value="添加栏目" style="margin-left:10px; width:80px" class="doLock" name="dook"></a>
<!--  <a href="?m=admin&c=category&a=add_page&menuid=--><?php //echo $_GET['menuid']?><!--&pc_hash=--><?php //echo $_SESSION['pc_hash']?><!--"><input type="button" value="添加单网页" style="margin-left:10px; width:80px" class="doLock" name="dook"></a>-->
<!--  <a href="?m=admin&c=category&a=add_link&menuid=--><?php //echo $_GET['menuid']?><!--&pc_hash=--><?php //echo $_SESSION['pc_hash']?><!--"><input type="button" value="添加外部链接" style="margin-left:10px; width:100px" class="doLock" name="dook"></a>-->
  <a href="?m=admin&c=category&a=public_cache&menuid=<?php echo $_GET['menuid']?>&module=admin"><input type="button" value="更新栏目缓存" style="margin-left:10px; width:100px" class="doLock" name="dook"></a>
</div>

<form name="myform" action="?m=admin&c=category&a=listorder" method="post">
<div class="pad_10">
<div class="explain-col">
<?php echo L('category_cache_tips');?>，<a href="?m=admin&c=category&a=public_cache&menuid=43&module=admin"><?php echo L('update_cache');?></a>
</div>
<div class="bk10"></div>
<div class="table-list">
<script type="text/javascript" >
  $(document).ready(function() {
    $(".kotable tbody tr:odd").addClass("odd");
    $(".kotable tbody tr:even").addClass("even");
    $(".kotable tbody tr").mouseover(function() {
      $(this).addClass("iover");
    }).mouseout(function() {
      $(this).removeClass("iover");
    });
  })
</script>

    <table width="100%" cellspacing="4" cellpadding="4" class="kotable" style="margin-top:0;">
        <thead>
            <tr>
            <th width="50"><?php echo L('listorder');?></th>
            <th width="50"><?php echo L('catid');?></th>
            <th><?php echo L('catname');?></th>
            <th width="80"><?php echo L('category_type');?></th>
            <th width="80"><?php echo L('modelname');?></th>
            <th width="60"><?php echo L('items');?></th>
            <th width="100"><?php echo L('domain_help');?></th>
			<th width="120"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody>
    <?php echo $categorys;?>
    </tbody>
    </table>

    <div class="btn">
	<input type="hidden" name="pc_hash" value="<?php echo $_SESSION['pc_hash'];?>" />
	<input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>
</div>
</div>
</form>
</div>
</div>
<script language="JavaScript">
<!--
	window.top.$('#display_center_id').css('display','none');
//-->
</script>
</body>
</html>
