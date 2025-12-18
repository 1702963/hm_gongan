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
<a href="index.php?m=peixunnew&c=qiangzhi_sheji_fankui&a=add"><input type="button" value="添加射击反馈" style="margin-left:10px; width:100px" class="doLock" name="dook"></a>
</div>

<div class="search-box">
    <form method="GET" action="index.php">
        <input type="hidden" name="m" value="peixunnew">
        <input type="hidden" name="c" value="qiangzhi_sheji_fankui">
        <input type="hidden" name="a" value="init">

        <label>射击计划：</label>
        <select name="jihua_id" style="width:150px;">
            <option value="0">全部</option>
            <?php
            if(is_array($this->jihua_list)){
                foreach($this->jihua_list as $jh){
                    $selected = ($jh['id'] == $this->jihua_id) ? 'selected' : '';
                    echo "<option value='{$jh['id']}' {$selected}>{$jh['title']}</option>";
                }
            }
            ?>
        </select>

        <label style="margin-left:15px;">所属部门：</label>
        <select name="bmid" style="width:150px;">
            <option value="0">全部</option>
            <?php echo $this->select_bumen?>
        </select>

        <label style="margin-left:15px;">是否合格：</label>
        <select name="guo" style="width:100px;">
            <option value="-1">全部</option>
            <option value="1" <?php echo $this->guo == 1 ? 'selected' : ''?>>合格</option>
            <option value="0" <?php echo $this->guo == 0 ? 'selected' : ''?>>不合格</option>
        </select>

        <label style="margin-left:15px;">关键词：</label>
        <input type="text" name="keyword" value="<?php echo htmlspecialchars($this->keyword)?>" placeholder="参射人员名称" style="width:150px;">

        <input type="submit" value="搜索" class="doLock" style="margin-left:10px;">
        <a href="index.php?m=peixunnew&c=qiangzhi_sheji_fankui&a=init"><input type="button" value="重置" class="doLock"></a>
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
      <th width="150">射击计划</th>
      <th width="120">所属部门</th>
      <th width="120">参射人员</th>
      <th width="100">成绩</th>
      <th width="80">是否合格</th>
      <th width="100">提报时间</th>
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
      <td><?php echo isset($this->jihua_map[$info['jihua_id']]) ? $this->jihua_map[$info['jihua_id']] : '-'?></td>
      <td><?php echo isset($this->bumen_map[$info['bmid']]) ? $this->bumen_map[$info['bmid']] : '-'?></td>
      <td><?php echo htmlspecialchars($info['fjname'])?></td>
      <td><?php echo htmlspecialchars($info['chengji'])?></td>
      <td><?php echo $info['guo'] == 1 ? '<span style="color:#00ff00">合格</span>' : '<span style="color:#ff0000">不合格</span>'?></td>
      <td><?php echo $info['tianbao_time_show'] ? $info['tianbao_time_show'] : '-'?></td>
      <td><?php echo $info['inputtime_show']?></td>
      <td>
        &nbsp;<a href="index.php?m=peixunnew&c=qiangzhi_sheji_fankui&a=edit&id=<?php echo $info['id']?>\">编辑</a>
        &nbsp;<a href="index.php?m=peixunnew&c=qiangzhi_sheji_fankui&a=del&id=<?php echo $info['id']?>\" onclick=\"javascript:var r = confirm('确认删除该记录吗？');if(!r){return false;}\">删除</a>
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
