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
  <a href="index.php?m=peixunnew&c=nengli_zhengshu&a=add"><input type="button" value="添加个人证书" style="margin-left:10px; width:110px" class="doLock" name="dook"></a>
</div>

<div class="search-box">
    <form method="GET" action="index.php">
        <input type="hidden" name="m" value="peixunnew">
        <input type="hidden" name="c" value="nengli_zhengshu">
        <input type="hidden" name="a" value="init">

        <label>辅警姓名：</label>
        <input type="text" name="fjname" value="<?php echo htmlspecialchars($this->fjname)?>" placeholder="姓名关键词" style="width:150px;">

        <label style="margin-left:15px;">证书类型：</label>
        <select name="type_id" style="width:180px;">
            <option value="0">全部</option>
            <?php foreach($this->type_list as $t): ?>
            <option value="<?php echo $t['id']?>" <?php echo $this->type_id == $t['id'] ? 'selected' : ''?>><?php echo htmlspecialchars($t['typename'])?></option>
            <?php endforeach; ?>
        </select>

        <label style="margin-left:15px;">状态：</label>
        <select name="status" style="width:120px;">
            <option value="-1" <?php echo $this->status == -1 ? 'selected' : ''?>>全部</option>
            <option value="1" <?php echo $this->status == 1 ? 'selected' : ''?>>有效</option>
            <option value="0" <?php echo $this->status === 0 ? 'selected' : ''?>>失效</option>
        </select>

        <input type="submit" value="搜索" class="doLock" style="margin-left:10px;">
        <a href="index.php?m=peixunnew&c=nengli_zhengshu&a=init"><input type="button" value="重置" class="doLock"></a>
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
  });
</script>

<table width="100%" cellspacing="0" cellpadding="0" class="baseinfo kotable">
    <thead>
    <tr>
      <th width="60">ID</th>
      <th width="120">辅警姓名</th>
      <th width="180">证书名称</th>
      <th width="140">证书编号</th>
      <th width="160">发证机构</th>
      <th width="120">获得时间</th>
      <th width="200">有效期</th>
      <th width="80">状态</th>
      <th width="140">操作</th>
    </tr>
    </thead>
    <tbody>
  <?php
if(is_array($this->list)){
    foreach($this->list as $info){
    ?>
    <tr>
      <td><?php echo $info['id']?></td>
      <td><?php echo htmlspecialchars($info['fjname'])?></td>
      <td><?php echo isset($info['typename']) ? htmlspecialchars($info['typename']) : '-'?></td>
      <td><?php echo $info['zhengshu_no'] ? htmlspecialchars($info['zhengshu_no']) : '-'?></td>
      <td><?php echo $info['jigou'] ? htmlspecialchars($info['jigou']) : '-'?></td>
      <td><?php echo $info['huode_time'] ? htmlspecialchars($info['huode_time']) : '-'?></td>
      <td>
        <?php
          $start = $info['youxiao_start'] ? htmlspecialchars($info['youxiao_start']) : '-';
          $end = $info['youxiao_end'] ? htmlspecialchars($info['youxiao_end']) : '长期';
          echo $start . ' ~ ' . $end;
        ?>
      </td>
      <td><?php echo $info['status'] == 1 ? '<span style="color:#00ff00">有效</span>' : '<span style="color:#ffcc00">失效</span>'?></td>
      <td>
        &nbsp;<a href="index.php?m=peixunnew&c=nengli_zhengshu&a=edit&id=<?php echo $info['id']?>">编辑</a>
        &nbsp;<a href="index.php?m=peixunnew&c=nengli_zhengshu&a=delete&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认删除该证书吗？');if(!r){return false;}">删除</a>
      </td>
    </tr>
   <?php
    }
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
