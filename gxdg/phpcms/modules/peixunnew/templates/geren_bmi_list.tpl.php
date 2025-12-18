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
<a href="index.php?m=peixunnew&c=geren_bmi&a=add"><input type="button" value="添加记录" style="margin-left:10px; width:80px" class="doLock" name="dook"></a>
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
      <th width="100">姓名</th>
      <th width="80">身高(cm)</th>
      <th width="80">体重(kg)</th>
      <th width="80">BMI</th>
      <th width="80">体脂率(%)</th>
      <th width="80">腰围(cm)</th>
      <th width="80">臀围(cm)</th>
      <th width="120">录入时间</th>
      <th width="120">操作</th>
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
      <td><?php echo $info['fjname']?></td>
      <td><?php echo $info['shengao']?></td>
      <td><?php echo $info['tizhong']?></td>
      <td><?php
        $bmi = floatval($info['bmi']);
        $color = '#fff';
        if ($bmi < 18.5) $color = '#5bc0de';
        else if ($bmi >= 18.5 && $bmi < 24) $color = '#5cb85c';
        else if ($bmi >= 24 && $bmi < 28) $color = '#f0ad4e';
        else $color = '#d9534f';
        echo "<span style='color:$color'>" . $info['bmi'] . "</span>";
      ?></td>
      <td><?php echo $info['tizhilv'] ? $info['tizhilv'] : '-'?></td>
      <td><?php echo $info['yaowei'] ? $info['yaowei'] : '-'?></td>
      <td><?php echo $info['tunwei'] ? $info['tunwei'] : '-'?></td>
      <td><?php echo $info['inputtime_show']?></td>
      <td>
        &nbsp;<a href="index.php?m=peixunnew&c=geren_bmi&a=edit&id=<?php echo $info['id']?>">编辑</a>
        &nbsp;<a href="index.php?m=peixunnew&c=geren_bmi&a=del&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认删除该记录吗？');if(!r){return false;}">删除</a>
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
