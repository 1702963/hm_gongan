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
<a href="index.php?m=renshi&c=geren&a=addsx3_add"><input type="button" value="添加记录" style="margin-left:10px; width:80px" class="doLock" name="dook"></a>
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
      <th width="200">主题</th>
      <th width="120">时间</th>
      <th width="200">参会人员</th>
      <th width="80">附件</th>
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
      <td><?php echo $info['theme']?></td>
      <td><?php echo $info['content_time_show']?></td>
      <td><?php echo $info['canhui_renyuan_show']?></td>
      <td>
        <?php
        if($info['fujian']){
            $fujian_array = json_decode($info['fujian'], true);
            if (is_array($fujian_array) && count($fujian_array) > 0) {
                echo '<a href="javascript:void(0)" onclick="showFujianImages(' . $info['id'] . ')">查看(' . count($fujian_array) . '张)</a>';
                echo '<div id="fujian_imgs_' . $info['id'] . '" style="display:none;">' . htmlspecialchars($info['fujian']) . '</div>';
            } else {
                echo '<a href="' . $info['fujian'] . '" target="_blank">查看</a>';
            }
        }else{
            echo '无';
        }
        ?>
      </td>
      <td>
        &nbsp;<a href="index.php?m=renshi&c=geren&a=addsx3_edit&id=<?php echo $info['id']?>">编辑</a>
        &nbsp;<a href="index.php?m=renshi&c=geren&a=addsx3_del&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认删除该记录吗？');if(!r){return false;}">删除</a>
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

<script type="text/javascript">
function showFujianImages(id) {
    var fujianJson = $('#fujian_imgs_' + id).text();
    if (fujianJson) {
        try {
            var images = JSON.parse(fujianJson);
            if (Array.isArray(images) && images.length > 0) {
                var html = '<div style="max-width:800px;max-height:600px;overflow:auto;">';
                for (var i = 0; i < images.length; i++) {
                    html += '<div style="margin:10px;text-align:center;">'
                          + '<img src="' + images[i] + '" style="max-width:100%;border:1px solid #ddd;" />'
                          + '</div>';
                }
                html += '</div>';

                if (typeof art !== 'undefined' && art.dialog) {
                    art.dialog({
                        title: '附件图片',
                        content: html,
                        lock: true
                    });
                } else {
                    var win = window.open('', '_blank', 'width=820,height=620,scrollbars=yes');
                    win.document.write('<html><head><title>附件图片</title></head><body style="background:#f5f5f5;">' + html + '</body></html>');
                }
            }
        } catch (e) {
            alert('图片数据格式错误');
        }
    }
}
</script>

</body>
</html>
