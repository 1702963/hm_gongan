<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>

<link href="<?php echo CSS_PATH?>jquery.treeTable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo JS_PATH?>jquery.treetable.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#dnd-example").treeTable({
    	indent: 20
    	});
  });
  function checknode(obj)
  {
      var chk = $("input[type='checkbox']");
      var count = chk.length;
      var num = chk.index(obj);
      var level_top = level_bottom =  chk.eq(num).attr('level')
      for (var i=num; i>=0; i--)
      {
              var le = chk.eq(i).attr('level');
              if(eval(le) < eval(level_top)) 
              {
                  chk.eq(i).attr("checked",'checked');
                  var level_top = level_top-1;
              }
      }
      for (var j=num+1; j<count; j++)
      {
              var le = chk.eq(j).attr('level');
              if(chk.eq(num).attr("checked")=='checked') {
                  if(eval(le) > eval(level_bottom)) chk.eq(j).attr("checked",'checked');
                  else if(eval(le) == eval(level_bottom)) break;
              }
              else {
                  if(eval(le) > eval(level_bottom)) chk.eq(j).attr("checked",false);
                  else if(eval(le) == eval(level_bottom)) break;
              }
      }
  }
</script>
<?php if($siteid) {?>

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
.kotable {margin:0 0 10px 0}
.col-2 {border:0 solid #c7d8ea}
.col-tab ul {margin:0px 0 10px 0;font-family:microsoft yahei;font-size:14px}
.col-tab ul.tabBut {height:32px;}
.col-tab ul.tabBut li {
	width:120px; height:30px; text-align:center; background-image: linear-gradient(350deg, #008898 0%, #042839 100%);
	border:0 solid #00f6ff; box-sizing:border-box; border-radius:10px 0 10px 0; transform: skewX(-15deg);transition:all .2s ease-in-out
}
.col-tab ul.tabBut li a { width:100%; height:30px; display:block; color:#fff;text-decoration:none; transform: skewX(10deg) }
.col-tab ul.tabBut li.on {width:150px;height:30px; border:0 solid #06d; background-image: linear-gradient(350deg, #56923b 0%, #3faa0f 100%);color:#fff;box-sizing:border-box;font-size:16px}
a.modState {padding:1px 6px; background:#fff;font-weight:900;border-radius:3px}
.kotable tbody td {text-align:left}
div.btn {padding:6px 12px 0 0}
</style>

<div class="table-list" id="load_priv">
<table width="100%" cellspacing="0" border="0" class="kotable">
	<thead>
	<tr>
	<th class="text-l cu-span" style='padding-left:30px;'><span onClick="javascript:$('input[name=menuid[]]').attr('checked', true)"><?php echo L('selected_all');?></span>/<span onClick="javascript:$('input[name=menuid[]]').attr('checked', false)"><?php echo L('cancel');?></span></th>
	</tr>
	</thead>
</table>
<form name="myform" action="?m=admin&c=role&a=role_priv" method="post">
<input type="hidden" name="roleid" value="<?php echo $roleid?>"></input>
<input type="hidden" name="siteid" value="<?php echo $siteid?>"></input>
<table width="100%" cellspacing="0" id="dnd-example" class="kotable">
<tbody>
<?php echo $categorys;?>
</tbody>
</table>
    <div class="btn"><input type="submit"  class="button" name="dosubmit" id="dosubmit" value="<?php echo L('submit');?>" /></div>
</form>
</div>
<?php } else {?>
<style type="text/css">
.guery{background: url(<?php echo IMG_PATH?>msg_img/msg_bg.png) no-repeat 0px -560px;padding:10px 12px 10px 45px; font-size:14px; height:100px; line-height:96px}
.guery{background-position: left -460px;}
</style>
<center>
	<div class="guery" style="display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;">
	<?php echo L('select_site');?>
	</div>
</center>
<?php }?>

</body>
</html>
