<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<script type="text/javascript" >  
  $(document).ready(function() {  
    $(".kotable tbody tr:odd").addClass("odd");
	$(".kotable tbody tr:even").addClass("even");
    $(".kotable tbody tr").mouseover(function() {  
      $(this).addClass("iover");  
    }).mouseout(function() {  
      $(this).removeClass("iover");  
    });  
  }  
)  
</script>
<style>
.tableContent {margin-top:50px}
.kotable {margin-bottom:20px}
.col-tab ul {margin:0px 0 10px 0;font-family:microsoft yahei;font-size:14px}
.col-tab ul.tabBut {height:32px;}
.col-tab ul.tabBut li {
	width:120px; height:30px; text-align:center; background-image: linear-gradient(350deg, #008898 0%, #042839 100%);
	border:0 solid #00f6ff; box-sizing:border-box; border-radius:10px 0 10px 0; transform: skewX(-15deg);transition:all .2s ease-in-out
}
.col-tab ul.tabBut li a { width:100%; height:30px; display:block; color:#fff;text-decoration:none; transform: skewX(10deg) }
.col-tab ul.tabBut li.on {width:150px;height:30px; border:0 solid #06d; background-image: linear-gradient(350deg, #56923b 0%, #3faa0f 100%);color:#fff;box-sizing:border-box;font-size:16px}
a.modState {padding:1px 6px; background:#fff;font-weight:900;border-radius:3px}
</style>

<form action="?m=admin&c=role&a=setting_cat_priv&roleid=<?php echo $roleid?>&siteid=<?php echo $siteid?>&op=2" method="post">
<div class="table-list" id="load_priv">
<table width="100%" class="kotable">
			  <thead>
				<tr>
				  <th width="25"><?php echo L('select_all')?></th><th align="left"><?php echo L('title_varchar')?></th><th width="25"><?php echo L('view')?></th><th width="25"><?php echo L('add')?></th><th width="25"><?php echo L('edit')?></th><th width="25"><?php echo L('delete')?></th><th width="25"><?php echo L('sort')?></th><th width="25"><?php echo L('push')?></th><th width="25"><?php echo L('move')?></th>
			  </tr>
			    </thead>
				 <tbody>
				<?php echo $categorys?>
			 </tbody>
			</table>
<div class="btn">
<input type="submit" value="<?php echo L('submit')?>" class="button">
</div>
</div>
</form>
<script type="text/javascript">
<!--
function select_all(name, obj) {
	if (obj.checked) {
		$("input[type='checkbox'][name='priv["+name+"][]']").attr('checked', 'checked');
	} else {
		$("input[type='checkbox'][name='priv["+name+"][]']").removeAttr('checked');
	}
}
//-->
</script>
</body>
</html>
