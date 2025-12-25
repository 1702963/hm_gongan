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
.kotable th, .kotable td {
    font-size: 12px;
    padding: 4px 2px !important;
}
</style>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<div class="tableContent">
<div class="pad-lr-10">

<div class="explain-col">
  快速工具:
<a href="index.php?m=peixunnew&c=hebeiganyuan_jilu&a=add"><input type="button" value="添加培训记录" style="margin-left:10px; width:100px" class="doLock" name="dook"></a>
<span style="color:#ffcc00;margin-left:20px;">注：只能添加民警参训记录</span>
</div>

<div class="search-box">
    <form method="GET" action="index.php">
        <input type="hidden" name="m" value="peixunnew">
        <input type="hidden" name="c" value="hebeiganyuan_jilu">
        <input type="hidden" name="a" value="init">

        <label>培训计划：</label>
        <select name="jihua_id" style="width:180px;">
            <option value="0">全部</option>
            <?php foreach($this->jihua_list as $jh): ?>
            <option value="<?php echo $jh['id']?>" <?php echo $this->jihua_id == $jh['id'] ? 'selected' : ''?>><?php echo mb_substr($jh['title'], 0, 15, 'utf-8')?></option>
            <?php endforeach; ?>
        </select>

        <label style="margin-left:10px;">是否通过：</label>
        <select name="is_tongguo" style="width:80px;">
            <option value="-1">全部</option>
            <option value="1" <?php echo $this->is_tongguo === 1 ? 'selected' : ''?>>是</option>
            <option value="0" <?php echo $this->is_tongguo === 0 ? 'selected' : ''?>>否</option>
        </select>

        <label style="margin-left:10px;">是否结业：</label>
        <select name="is_jieye" style="width:80px;">
            <option value="-1">全部</option>
            <option value="1" <?php echo $this->is_jieye === 1 ? 'selected' : ''?>>是</option>
            <option value="0" <?php echo $this->is_jieye === 0 ? 'selected' : ''?>>否</option>
        </select>

        <label style="margin-left:10px;">姓名/登录名：</label>
        <input type="text" name="keyword" value="<?php echo htmlspecialchars($this->keyword)?>" placeholder="搜索" style="width:100px;">

        <input type="submit" value="搜索" class="doLock" style="margin-left:10px;">
        <a href="index.php?m=peixunnew&c=hebeiganyuan_jilu&a=init"><input type="button" value="重置" class="doLock"></a>
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

<table width="100%" cellspacing="2" cellpadding="2" class="kotable">
    <thead>
    <tr>
      <th width='30'>序号</th>
      <th width="120">培训计划</th>
      <th width="60">登录名</th>
      <th width="60">姓名</th>
      <th width="80">所属组织</th>
      <th width="80">所属部门</th>
      <th width="60">职务级别</th>
      <th width="50">共完成学时</th>
      <th width="50">在线选学</th>
      <th width="50">专题班学时</th>
      <th width="50">已完成课程</th>
      <th width="50">完成率</th>
      <th width="50">考试结果</th>
      <th width="40">通过</th>
      <th width="40">作业</th>
      <th width="40">结业</th>
      <th width="80">操作</th>
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
      <td title="<?php echo htmlspecialchars($info['jihua_title'])?>"><?php echo mb_substr($info['jihua_title'], 0, 10, 'utf-8') . (mb_strlen($info['jihua_title'], 'utf-8') > 10 ? '...' : '')?></td>
      <td><?php echo $info['username']?></td>
      <td><?php echo $info['mjname']?></td>
      <td title="<?php echo htmlspecialchars($info['suoshu_zuzhi'])?>"><?php echo mb_substr($info['suoshu_zuzhi'], 0, 6, 'utf-8')?></td>
      <td title="<?php echo htmlspecialchars($info['suoshu_bumen'])?>"><?php echo mb_substr($info['suoshu_bumen'], 0, 6, 'utf-8')?></td>
      <td><?php echo $info['zhiwu_jibie']?></td>
      <td><?php echo $info['gong_xueshi']?></td>
      <td><?php echo $info['zaixian_xueshi']?></td>
      <td><?php echo $info['zhuanti_xueshi']?></td>
      <td><?php echo $info['zhuanti_kecheng']?></td>
      <td><?php echo $info['kecheng_wancheng_lv']?></td>
      <td><?php echo $info['kaoshi_jieguo']?></td>
      <td><?php echo $info['is_tongguo'] == 1 ? '<span style="color:#00ff00">是</span>' : '<span style="color:#ff6666">否</span>'?></td>
      <td><?php echo $info['is_tijiao_zuoye'] == 1 ? '<span style="color:#00ff00">是</span>' : '<span style="color:#ff6666">否</span>'?></td>
      <td><?php echo $info['is_jieye'] == 1 ? '<span style="color:#00ff00">是</span>' : '<span style="color:#ff6666">否</span>'?></td>
      <td>
        <a href="index.php?m=peixunnew&c=hebeiganyuan_jilu&a=edit&id=<?php echo $info['id']?>">编辑</a>
        <a href="index.php?m=peixunnew&c=hebeiganyuan_jilu&a=del&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认删除？');if(!r){return false;}">删除</a>
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
