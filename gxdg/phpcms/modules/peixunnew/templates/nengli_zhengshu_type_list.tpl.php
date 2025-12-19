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
  <a href="index.php?m=peixunnew&c=nengli_zhengshu_type&a=add"><input type="button" value="添加新证书类型" style="margin-left:10px; width:120px" class="doLock" name="dook"></a>
</div>

<div class="search-box">
    <form method="GET" action="index.php">
        <input type="hidden" name="m" value="peixunnew">
        <input type="hidden" name="c" value="nengli_zhengshu_type">
        <input type="hidden" name="a" value="init">

        <label>类别：</label>
        <select name="leibie" style="width:160px;">
            <option value="" <?php echo $this->leibie === '' ? 'selected' : ''?>>全部</option>
            <option value="职业资格" <?php echo $this->leibie == '职业资格' ? 'selected' : ''?>>职业资格</option>
            <option value="技能等级" <?php echo $this->leibie == '技能等级' ? 'selected' : ''?>>技能等级</option>
            <option value="专业证书" <?php echo $this->leibie == '专业证书' ? 'selected' : ''?>>专业证书</option>
            <option value="荣誉证书" <?php echo $this->leibie == '荣誉证书' ? 'selected' : ''?>>荣誉证书</option>
        </select>

        <label style="margin-left:15px;">状态：</label>
        <select name="status" style="width:120px;">
            <option value="-1" <?php echo $this->status == -1 ? 'selected' : ''?>>全部</option>
            <option value="1" <?php echo $this->status == 1 ? 'selected' : ''?>>启用</option>
            <option value="0" <?php echo $this->status === 0 ? 'selected' : ''?>>停用</option>
        </select>

        <label style="margin-left:15px;">关键词：</label>
        <input type="text" name="keyword" value="<?php echo htmlspecialchars($this->keyword)?>" placeholder="证书名称关键词" style="width:200px;">

        <input type="submit" value="搜索" class="doLock" style="margin-left:10px;">
        <a href="index.php?m=peixunnew&c=nengli_zhengshu_type&a=init"><input type="button" value="重置" class="doLock"></a>
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

<table width="100%" cellspacing="0" cellpadding="0" class="baseinfo kotable">
    <thead>
    <tr>
      <th width="50">ID</th>
      <th width="200">证书名称</th>
      <th width="120">类别</th>
      <th width="200">发证机构</th>
      <th width="120">有效期(月)</th>
      <th width="80">状态</th>
      <th width="80">排序</th>
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
      <td><?php echo htmlspecialchars($info['typename'])?></td>
      <td><?php echo $info['leibie'] ? htmlspecialchars($info['leibie']) : '-'?></td>
      <td><?php echo $info['jigou'] ? htmlspecialchars($info['jigou']) : '-'?></td>
      <td><?php echo intval($info['youxiaoqi']) > 0 ? intval($info['youxiaoqi']) : '-'?></td>
      <td><?php echo $info['status'] == 1 ? '<span style="color:#00ff00">启用</span>' : '<span style="color:#ffcc00">停用</span>'?></td>
      <td><?php echo intval($info['paixu'])?></td>
      <td>
        &nbsp;<a href="index.php?m=peixunnew&c=nengli_zhengshu_type&a=edit&id=<?php echo $info['id']?>">编辑</a>
        &nbsp;<a href="index.php?m=peixunnew&c=nengli_zhengshu_type&a=delete&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认删除该证书类型吗？');if(!r){return false;}">删除</a>
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
