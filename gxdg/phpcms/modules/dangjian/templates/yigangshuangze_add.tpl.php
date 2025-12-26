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
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<form action="?m=dangjian&c=chengyuan&a=yigangshuangze_addsave" method="POST" name="myform" id="myform">

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">一岗双责记录</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span style="color:red">*</span>主题：</td>
    <td colspan="5">
      <input type="text" name="info[theme]" id="theme" value="" required
             style="width:500px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入主题"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">时间：</td>
    <td colspan="5">
      <input type="date" name="info[content_time]" id="content_time" value=""
             style="width:300px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">正文：</td>
    <td colspan="5">
      <textarea name="info[content]" id="content"
                style="width:500px;height:150px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入正文内容"></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">附件图片：</td>
    <td colspan="5">
      <input type="hidden" name="info[fujian]" id="fujian" value="" />
      <input type="file" id="fujian_upload" accept="image/*" multiple
             style="margin-left:5px;background:#1a2a4a;color:#fff"/>
      <div id="fujian_preview" style="margin-top:10px;"></div>
      <span style="color:#999;font-size:12px;margin-left:10px">支持上传多张图片</span>
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
// 多图片上传预览
var fujianImages = [];

// 文件上传处理
$('#fujian_upload').on('change', function(e) {
    var files = e.target.files;
    if (files.length > 0) {
        // 显示上传进度提示
        var uploadingCount = files.length;
        $('#fujian_preview').prepend('<div id="uploading_tip" style="color:#ff9900;margin-bottom:10px;">正在上传 ' + uploadingCount + ' 张图片...</div>');

        for (var i = 0; i < files.length; i++) {
            uploadSingleFile(files[i]);
        }
        // 清空文件输入，允许重复选择相同文件
        $(this).val('');
    }
});

// 上传单个文件
function uploadSingleFile(file) {
    var formData = new FormData();
    formData.append('file', file);

    $.ajax({
        url: 'index.php?m=dangjian&c=chengyuan&a=upload_fujian_image',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
            if (res.status == 1) {
                // 上传成功，添加URL到数组
                fujianImages.push(res.url);
                updateFujianPreview();
            } else {
                alert('上传失败：' + res.msg);
            }
        },
        error: function() {
            alert('上传请求失败');
        }
    });
}

// 更新图片预览显示
function updateFujianPreview() {
    // 移除上传提示
    $('#uploading_tip').remove();

    var html = '';
    var upload_url = '<?php echo pc_base::load_config("system", "upload_url")?>';

    for (var i = 0; i < fujianImages.length; i++) {
        var imgUrl = fujianImages[i];
        // 如果是相对路径，添加upload_url前缀
        if (imgUrl.indexOf('http://') !== 0 && imgUrl.indexOf('https://') !== 0) {
            imgUrl = upload_url + imgUrl.replace('uploadfile/', '');
        }

        html += '<div style="display:inline-block;margin:5px;position:relative;">'
              + '<img src="' + imgUrl + '" width="150" style="border:1px solid #ddd;" />'
              + '<a href="javascript:void(0)" class="remove-fujian-image" data-index="' + i + '" '
              + 'style="position:absolute;top:-5px;right:-5px;background:#ff6666;color:#fff;'
              + 'border-radius:50%;width:20px;height:20px;text-align:center;line-height:20px;'
              + 'text-decoration:none;font-weight:bold;">×</a>'
              + '</div>';
    }
    $('#fujian_preview').html(html);

    // 更新隐藏字段为JSON格式
    $('#fujian').val(JSON.stringify(fujianImages));
}

// 删除图片
$(document).delegate('.remove-fujian-image', 'click', function() {
    var index = parseInt($(this).attr('data-index'));
    fujianImages.splice(index, 1);
    updateFujianPreview();
});
</script>

</body>
</html>
