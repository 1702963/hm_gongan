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
.search-box {
    margin: 10px 0;
    padding: 10px;
    background: #1e1f5e;
    border-radius: 5px;
}
.search-box select, .search-box input[type="text"] {
    background: transparent;
    color: #fff;
    border: 1px solid #ddd;
    padding: 5px 10px;
    margin-right: 10px;
}
.search-box option {
    background: #1e1f5e;
    color: #fff;
}
</style>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<div class="tableContent">
<div class="pad-lr-10">

<div class="explain-col">
  快速工具:
<a href="index.php?m=peixunnew&c=yewujingzhong&a=add"><input type="button" value="添加培训计划" style="margin-left:10px; width:100px" class="doLock" name="dook"></a>
</div>

<div class="search-box">
    <form method="GET" action="index.php">
        <input type="hidden" name="m" value="peixunnew">
        <input type="hidden" name="c" value="yewujingzhong">
        <input type="hidden" name="a" value="init">

        <label>所属警种：</label>
        <select name="bmid" style="width:150px;">
            <option value="0">全部</option>
            <?php echo $this->select_bumen?>
        </select>

        <label style="margin-left:15px;">状态：</label>
        <select name="status" style="width:100px;">
            <option value="-1">全部</option>
            <option value="1" <?php echo $this->status == 1 ? 'selected' : ''?>>进行中</option>
            <option value="2" <?php echo $this->status == 2 ? 'selected' : ''?>>已完成</option>
        </select>

        <label style="margin-left:15px;">关键词：</label>
        <input type="text" name="keyword" value="<?php echo htmlspecialchars($this->keyword)?>" placeholder="培训标题" style="width:150px;">

        <input type="submit" value="搜索" class="doLock" style="margin-left:10px;">
        <a href="index.php?m=peixunnew&c=yewujingzhong&a=init"><input type="button" value="重置" class="doLock"></a>
    </form>
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
      <th width="150">所属警种</th>
      <th width="200">培训标题</th>
      <th width="100">培训来源</th>
      <th width="100">开始时间</th>
      <th width="100">结束时间</th>
      <th width="80">是否必须</th>
      <th width="80">状态</th>
      <th width="120">创建时间</th>
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
      <td><?php echo isset($this->bumen_map[$info['bmid']]) ? $this->bumen_map[$info['bmid']] : '-'?></td>
      <td><?php echo mb_substr($info['title'], 0, 20, 'utf-8') . (mb_strlen($info['title'], 'utf-8') > 20 ? '...' : '')?></td>
      <td><?php echo $info['pxly'] ? $info['pxly'] : '教育训练系统'?></td>
      <td><?php echo $info['btime_show']?></td>
      <td><?php echo $info['etime_show']?></td>
      <td><?php echo $info['bixu'] == 1 ? '<span style="color:#00ff00">是</span>' : '否'?></td>
      <td>
        <?php
        if($info['status'] == 1) echo '<span style="color:#ffcc00">进行中</span>';
        else if($info['status'] == 2) echo '<span style="color:#00ff00">已完成</span>';
        else echo '-';
        ?>
      </td>
      <td><?php echo $info['inputtime_show']?></td>
      <td>
        &nbsp;<a href="index.php?m=peixunnew&c=yewujingzhong&a=edit&id=<?php echo $info['id']?>">编辑</a>
        &nbsp;<a href="index.php?m=peixunnew&c=yewujingzhong&a=del&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认删除该记录吗？');if(!r){return false;}">删除</a>
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
