<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
parent.document.getElementById('display_center_id').style.display='none';
//-->
</SCRIPT>

<script type="text/javascript">
<!--
var charset = '<?php echo CHARSET;?>';
var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';
//-->
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<form action="?m=peixunnew&c=peixunjineng_fankui&a=editsave" method="POST" name="myform" id="myform">
<input type="hidden" name="id" value="<?php echo $this->info['id']?>" />

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">编辑警务技能培训反馈</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="120" align="right" class="infotitle">培训计划：</td>
    <td colspan="5">
      <select name="info[jihua_id]" id="jihua_id"
              style="width:400px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="">请选择培训计划</option>
        <?php foreach($this->jihua_list as $jh): ?>
        <option value="<?php echo $jh['id']?>" <?php echo $this->info['jihua_id'] == $jh['id'] ? 'selected' : ''?>><?php echo $jh['title']?> [<?php echo $jh['pxly']?>]</option>
        <?php endforeach; ?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">参训人员：</td>
    <td colspan="5">
      <span style="color:#fff;margin-left:5px;font-size:14px;"><?php echo $this->info['fjname']?></span>
      <span style="color:#999;font-size:12px;margin-left:10px;">(人员不可修改)</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">所属部门：</td>
    <td colspan="5">
      <select name="info[bmid]" id="bmid"
              style="width:300px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="0">请选择</option>
        <?php echo $this->select_bumen?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">成绩：</td>
    <td colspan="5">
      <input type="text" name="info[chengji]" id="chengji" value="<?php echo htmlspecialchars($this->info['chengji'])?>"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入成绩"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">是否通过：</td>
    <td colspan="5">
      <select name="info[guo]" id="guo"
              style="width:150px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="0" <?php echo $this->info['guo'] == 0 ? 'selected' : ''?>>未通过</option>
        <option value="1" <?php echo $this->info['guo'] == 1 ? 'selected' : ''?>>通过</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">填报时间：</td>
    <td colspan="5">
      <input type="date" name="info[tianbao_time]" id="tianbao_time" value="<?php echo $this->info['tianbao_time_show']?>"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">证书材料：</td>
    <td colspan="5">
      <input type="hidden" name="info[files]" id="files" value='<?php echo htmlspecialchars($this->info['files'])?>' />
      <input type="file" id="files_upload" accept="image/*" multiple
             style="margin-left:5px;background:transparent;color:#fff"/>
      <div id="files_preview" style="margin-top:10px;"></div>
      <span style="color:#999;font-size:12px;margin-left:10px">支持上传多张证书图片</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"></td>
    <td colspan="5" style="padding-top:20px;padding-left:5px;">
      <input type="submit" name="dosubmit" id="dosubmit" value="保存" class="dialog" style="margin-right:10px;font-size:14px;" />
      <input type="button" value="返回" class="dialog" onclick="javascript:history.back();" />
    </td>
  </tr>
</table>
</div>

<div class="clear"></div>
<div class="bk15"></div>

</div>

</form>

<script type="text/javascript">
// 多图片上传
var filesImages = [];

// 初始化已有图片
$(function() {
    var existingFiles = $('#files').val();
    if (existingFiles) {
        try {
            filesImages = JSON.parse(existingFiles);
            if (!Array.isArray(filesImages)) {
                filesImages = existingFiles ? [existingFiles] : [];
            }
        } catch (e) {
            filesImages = existingFiles ? [existingFiles] : [];
        }
    }
    updateFilesPreview();
});

$('#files_upload').on('change', function(e) {
    var files = e.target.files;
    if (files.length > 0) {
        $('#files_preview').prepend('<div id="uploading_tip" style="color:#ff9900;margin-bottom:10px;">正在上传...</div>');
        for (var i = 0; i < files.length; i++) {
            uploadSingleFile(files[i]);
        }
        $(this).val('');
    }
});

function uploadSingleFile(file) {
    var formData = new FormData();
    formData.append('file', file);

    $.ajax({
        url: 'index.php?m=peixunnew&c=peixunjineng_fankui&a=upload_image',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
            if (res.status == 1) {
                filesImages.push(res.url);
                updateFilesPreview();
            } else {
                alert('上传失败：' + res.msg);
            }
        },
        error: function() {
            alert('上传请求失败');
        }
    });
}

function updateFilesPreview() {
    $('#uploading_tip').remove();
    var html = '';
    var upload_url = '<?php echo pc_base::load_config("system", "upload_url")?>';

    for (var i = 0; i < filesImages.length; i++) {
        var imgUrl = filesImages[i];
        if (imgUrl.indexOf('http://') !== 0 && imgUrl.indexOf('https://') !== 0) {
            imgUrl = upload_url + imgUrl.replace('uploadfile/', '');
        }
        html += '<div style="display:inline-block;margin:5px;position:relative;">'
              + '<img src="' + imgUrl + '" width="120" style="border:1px solid #ddd;" />'
              + '<a href="javascript:void(0)" class="remove-file-image" data-index="' + i + '" '
              + 'style="position:absolute;top:-5px;right:-5px;background:#ff6666;color:#fff;'
              + 'border-radius:50%;width:20px;height:20px;text-align:center;line-height:20px;'
              + 'text-decoration:none;font-weight:bold;">×</a>'
              + '</div>';
    }
    $('#files_preview').html(html);
    $('#files').val(JSON.stringify(filesImages));
}

$(document).delegate('.remove-file-image', 'click', function() {
    var index = parseInt($(this).attr('data-index'));
    filesImages.splice(index, 1);
    updateFilesPreview();
});
</script>

</body>
</html>
