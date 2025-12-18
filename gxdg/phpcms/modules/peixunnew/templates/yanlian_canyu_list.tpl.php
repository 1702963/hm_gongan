<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new', 'admin');
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
parent.document.getElementById('display_center_id').style.display='none';
//-->
</SCRIPT>

<style type="text/css">
html{_overflow-y:scroll}
.explain-col {
    border: 1px solid #3132a4;
    zoom: 1;
    background: #252682;
    padding: 8px 10px;
    line-height: 20px;
    color:#bbd8f1
}
</style>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<div class="tableContent">
<div class="pad-lr-10">

<div class="explain-col">
  快速工具:
<a href="index.php?m=peixunnew&c=yanlian_canyu&a=add"><input type="button" value="添加记录" style="margin-left:10px; width:80px" class="doLock" name="dook"></a>
</div>

<div class="table-list">
<form name="myform" id="myform">
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

<table width="100%" cellspacing="4" cellpadding="4" class="kotable">
    <thead>
    <tr>
      <th width='50'>序号</th>
      <th width="100">演练类型</th>
      <th width="150">演练记录</th>
      <th width="80">分组</th>
      <th width="100">人员姓名</th>
      <th width="100">评分</th>
      <th width="150">表现描述</th>
      <th width="100">时间</th>
      <th width="150">操作</th>
    </tr>
    </thead>
    <tbody>
  <?php

if(is_array($this->list)){
    $i=1;

    foreach($this->list as $info){
    ?>
    <tr>
      <td><?php echo $i?></td>
      <td><?php echo $info['yanlian_type_name']?></td>
      <td><?php echo mb_substr($info['yanlian_title'], 0, 20, 'utf-8') . (mb_strlen($info['yanlian_title'], 'utf-8') > 20 ? '...' : '')?></td>
      <td><?php echo $info['fengzu'] == 1 ? '红方' : '蓝方'?></td>
      <td><?php echo $info['fjname']?></td>
      <td><?php echo $info['pingjia_score']?></td>
      <td><?php echo mb_substr($info['biaoxianbiao'], 0, 20, 'utf-8') . (mb_strlen($info['biaoxianbiao'], 'utf-8') > 20 ? '...' : '')?></td>
      <td><?php echo $info['inputtime_show']?></td>
      <td>
        &nbsp;<a href="index.php?m=peixunnew&c=yanlian_canyu&a=edit&id=<?php echo $info['id']?>">编辑</a>
        &nbsp;<a href="index.php?m=peixunnew&c=yanlian_canyu&a=del&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认删除该记录吗？');if(!r){return false;}">删除</a>
      </td>
    </tr>
   <?php
    $i++;}
}
?>
</tbody>
</table>

<div id="pages"><?php echo $this->pages?></div>
</form>
</div>
</div>
</div>

</body>
</html>
