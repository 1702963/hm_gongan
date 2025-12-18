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
<a href="index.php?m=peixunnew&c=geren_tineng&a=add"><input type="button" value="添加记录" style="margin-left:10px; width:80px" class="doLock" name="dook"></a>
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
      <th width="80">姓名</th>
      <th width="80">1000米跑</th>
      <th width="70">俯卧撑</th>
      <th width="70">仰卧起坐</th>
      <th width="70">引体向上</th>
      <th width="80">立定跳远</th>
      <th width="70">综合评分</th>
      <th width="120">录入时间</th>
      <th width="100">操作</th>
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
      <td><?php echo $info['paoliang_show']?></td>
      <td><?php echo $info['fuwocheng'] ? $info['fuwocheng'] . '个' : '-'?></td>
      <td><?php echo $info['yangwoqizuo'] ? $info['yangwoqizuo'] . '个' : '-'?></td>
      <td><?php echo $info['yintixiangshang'] ? $info['yintixiangshang'] . '个' : '-'?></td>
      <td><?php echo $info['lidingtiaoyan'] ? $info['lidingtiaoyan'] . 'cm' : '-'?></td>
      <td><?php
        if ($info['zongfen']) {
            $score = floatval($info['zongfen']);
            $color = '#fff';
            if ($score >= 90) $color = '#5cb85c';
            else if ($score >= 70) $color = '#5bc0de';
            else if ($score >= 60) $color = '#f0ad4e';
            else $color = '#d9534f';
            echo "<span style='color:$color'>" . $info['zongfen'] . "</span>";
        } else {
            echo '-';
        }
      ?></td>
      <td><?php echo $info['inputtime_show']?></td>
      <td>
        &nbsp;<a href="index.php?m=peixunnew&c=geren_tineng&a=edit&id=<?php echo $info['id']?>">编辑</a>
        &nbsp;<a href="index.php?m=peixunnew&c=geren_tineng&a=del&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认删除该记录吗？');if(!r){return false;}">删除</a>
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
