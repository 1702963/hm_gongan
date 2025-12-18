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
<a href="index.php?m=peixunnew&c=tinen_xunlian_fankui&a=add"><input type="button" value="添加反馈记录" style="margin-left:10px; width:100px" class="doLock" name="dook"></a>
</div>

<div class="search-box">
    <form method="GET" action="index.php">
        <input type="hidden" name="m" value="peixunnew">
        <input type="hidden" name="c" value="tinen_xunlian_fankui">
        <input type="hidden" name="a" value="init">

        <label>培训计划：</label>
        <select name="jihua_id" style="width:200px;">
            <option value="0">全部</option>
            <?php foreach($this->jihua_list as $jh): ?>
            <option value="<?php echo $jh['id']?>" <?php echo $this->jihua_id == $jh['id'] ? 'selected' : ''?>><?php echo mb_substr($jh['title'], 0, 20, 'utf-8')?></option>
            <?php endforeach; ?>
        </select>

        <label style="margin-left:15px;">所属部门：</label>
        <select name="bmid" style="width:150px;">
            <option value="0">全部</option>
            <?php echo $this->select_bumen?>
        </select>

        <label style="margin-left:15px;">是否通过：</label>
        <select name="guo" style="width:100px;">
            <option value="-1">全部</option>
            <option value="1" <?php echo $this->guo === 1 ? 'selected' : ''?>>通过</option>
            <option value="0" <?php echo $this->guo === 0 ? 'selected' : ''?>>未通过</option>
        </select>

        <label style="margin-left:15px;">姓名：</label>
        <input type="text" name="keyword" value="<?php echo htmlspecialchars($this->keyword)?>" placeholder="参训人员姓名" style="width:120px;">

        <input type="submit" value="搜索" class="doLock" style="margin-left:10px;">
        <a href="index.php?m=peixunnew&c=tinen_xunlian_fankui&a=init"><input type="button" value="重置" class="doLock"></a>
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
      <th width="200">培训计划</th>
      <th width="100">参训人员</th>
      <th width="120">所属部门</th>
      <th width="100">成绩</th>
      <th width="80">是否通过</th>
      <th width="80">证书</th>
      <th width="100">填报时间</th>
      <th width="120">记录时间</th>
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
      <td><?php echo mb_substr($info['jihua_title'], 0, 18, 'utf-8') . (mb_strlen($info['jihua_title'], 'utf-8') > 18 ? '...' : '')?></td>
      <td><?php echo $info['fjname']?></td>
      <td><?php echo isset($this->bumen_map[$info['bmid']]) ? $this->bumen_map[$info['bmid']] : '-'?></td>
      <td><?php echo $info['chengji'] ? $info['chengji'] : '-'?></td>
      <td><?php echo $info['guo'] == 1 ? '<span style="color:#00ff00">通过</span>' : '<span style="color:#ff6666">未通过</span>'?></td>
      <td>
        <?php
        if($info['files']){
            $files_array = json_decode($info['files'], true);
            if (is_array($files_array) && count($files_array) > 0) {
                echo '<a href="javascript:void(0)" onclick="showFiles(' . $info['id'] . ')">查看(' . count($files_array) . ')</a>';
                echo '<div id="files_' . $info['id'] . '" style="display:none;">' . htmlspecialchars($info['files']) . '</div>';
            } else {
                echo '无';
            }
        }else{
            echo '无';
        }
        ?>
      </td>
      <td><?php echo $info['tianbao_time_show']?></td>
      <td><?php echo $info['inputtime_show']?></td>
      <td>
        &nbsp;<a href="index.php?m=peixunnew&c=tinen_xunlian_fankui&a=edit&id=<?php echo $info['id']?>">编辑</a>
        &nbsp;<a href="index.php?m=peixunnew&c=tinen_xunlian_fankui&a=del&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认删除该记录吗？');if(!r){return false;}">删除</a>
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
function showFiles(id) {
    var filesJson = $('#files_' + id).text();
    if (filesJson) {
        try {
            var images = JSON.parse(filesJson);
            if (Array.isArray(images) && images.length > 0) {
                var html = '<div style="max-width:800px;max-height:600px;overflow:auto;">';
                var upload_url = '<?php echo pc_base::load_config("system", "upload_url")?>';
                for (var i = 0; i < images.length; i++) {
                    var imgUrl = images[i];
                    if (imgUrl.indexOf('http://') !== 0 && imgUrl.indexOf('https://') !== 0) {
                        imgUrl = upload_url + imgUrl.replace('uploadfile/', '');
                    }
                    html += '<div style="margin:10px;text-align:center;">'
                          + '<img src="' + imgUrl + '" style="max-width:100%;border:1px solid #ddd;" />'
                          + '</div>';
                }
                html += '</div>';
                var win = window.open('', '_blank', 'width=820,height=620,scrollbars=yes');
                win.document.write('<html><head><title>证书材料</title></head><body style="background:#f5f5f5;">' + html + '</body></html>');
            }
        } catch (e) {
            alert('数据格式错误');
        }
    }
}
</script>

</body>
</html>
