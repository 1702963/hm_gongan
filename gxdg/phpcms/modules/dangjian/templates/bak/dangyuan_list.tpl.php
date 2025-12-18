<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new', 'admin');

// 加载部门数据
$this->db->table_name = 'v9_bumen';
$bmlist = $this->db->select("", 'id,name', '', 'id asc');
$bms = array();
foreach ($bmlist as $v) {
    $bms[$v['id']] = $v['name'];
}

// 加载岗位数据
$this->db->table_name = 'v9_gangwei';
$gwlist = $this->db->select("", 'id,gwname', '', 'id asc');
$gangwei = array();
foreach ($gwlist as $v) {
    $gangwei[$v['id']] = $v['gwname'];
}

// 加载职务数据
$this->db->table_name = 'v9_zhiwu';
$zwlist = $this->db->select("", 'id,zwname', '', 'id asc');
$zhiwu = array();
foreach ($zwlist as $v) {
    $zhiwu[$v['id']] = $v['zwname'];
}

// 加载层级数据
$this->db->table_name = 'v9_cengji';
$cjlist = $this->db->select("", 'id,cjname', '', 'id asc');
$cengji = array();
foreach ($cjlist as $v) {
    $cengji[$v['id']] = $v['cjname'];
}

// 加载学历数据
$xueli_arr = array();
$this->db->table_name = 'v9_xueli';
$xllist = $this->db->select("", 'id,gwname', '', 'id asc');
foreach ($xllist as $v) {
    $xueli_arr[$v['id']] = $v['gwname'];
}
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
parent.document.getElementById('display_center_id').style.display='none';
//-->
</SCRIPT>

<style type="text/css">
html{_overflow-y:scroll}
.Bar ,.Bars { position: relative; width: 100px; border: 1px solid #B1D632; padding: 1px; }
.Bar div,.Bars div { display: block; position: relative;background:#00F; color: #333; height: 20px;line-height: 20px;}
.Bars div{ background:#090}
.Bar div span,.Bars div span { position: absolute; width: 100px; text-align: center; font-weight: bold; }
.cent{ margin:0 auto; width:150px; overflow:hidden}
input.button {padding:0 15px}
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
<a href="index.php?m=dangjian&c=jiagou&a=add"><input type="button" value="添加党员" style="margin-left:10px; width:80px" class="doLock" name="dook"></a>
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
  }
)
</script>

<table width="100%" cellspacing="4" cellpadding="4" class="kotable">
    <thead>
    <tr>
      <th width='50'>序号</th>
      <th width="80">照片</th>
      <th width='80'>姓名</th>
      <th width="100">单位</th>
      <th width='50'>性别</th>
      <th width="100">出生年月日</th>
      <th width='50'>年龄</th>
      <th width="80">学历</th>
      <th width="100">专业</th>
      <th width="100">岗位</th>
      <th width="100">入党时间</th>
      <th width="80">职级</th>
      <th width="80">职务</th>
      <th width="120">参加工作时间</th>
      <th width="150">操作</th>
    </tr>
    </thead>
    <tbody>
  <?php

if(is_array($this->list)){
    $i=1;

    foreach($this->list as $info){

    // 动态计算年龄
    if($info['shengri']!=''){
     $nianling=date("Y")-date("Y",strtotime($info['shengri']));
    }else{
     $nianling='';
    }
    ?>
    <tr>
      <td><?php echo $i?></td>
      <td>
        <?php if($info['thumb']){?>
        <img src="<?php echo $info['thumb']?>" width="50" height="60" />
        <?php }else{?>
        无照片
        <?php }?>
      </td>
      <td><?php echo $info['xingming']?></td>
      <td><?php echo $bms[$info['dwid']];?></td>
      <td><?php echo $info['sex']?></td>
      <td><?php if($info['shengri']!=''){echo $info['shengri'];}?></td>
      <td><?php echo $nianling?></td>
      <td><?php echo $xueli_arr[$info['xueli']]?></td>
      <td><?php echo $info['zhuanye']?></td>
      <td><?php echo $gangwei[$info['gangwei']]?></td>
      <td><?php if($info['rdzztime']!=0){echo date("Y-m-d",$info['rdzztime']);}?></td>
      <td><?php echo $cengji[$info['cengji']]?></td>
      <td><?php echo $zhiwu[$info['zhiwu']]?></td>
      <td><?php if($info['scgztime']!=0){echo date("Y-m-d",$info['scgztime']);}?></td>
      <td>
        <a href="index.php?m=dangjian&c=jiagou&a=edit&id=<?php echo $info['dy_id']?>">编辑</a>
        &nbsp;<a href="index.php?m=dangjian&c=jiagou&a=del&id=<?php echo $info['dy_id']?>" onclick="javascript:var r = confirm('确认删除该党员吗？');if(!r){return false;}">删除</a>
      </td>
    </tr>
   <?php
    $i++;}
}
?>
</tbody>
</table>

<div id="pages"><!-- 分页已禁用，使用完整列表 --></div>
</form>
</div>
</div>
</div>
</body>
</html>
