<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');
?>
<SCRIPT LANGUAGE="JavaScript">parent.document.getElementById('display_center_id').style.display='none';</SCRIPT>
<script type="text/javascript">var charset = '<?php echo CHARSET;?>';var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<form action="?m=renshi&c=geren&a=addsx4_editsave" method="POST" name="myform" id="myform">
<input type="hidden" name="id" value="<?php echo $this->info['id']?>" />
<div class="tableContent">
<div class="tabcon">
<div class="title" style="width:auto;">主题活动</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span style="color:red">*</span>主题：</td>
    <td colspan="5">
      <input type="text" name="info[theme]" id="theme" value="<?php echo $this->info['theme']?>" required style="width:500px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px" placeholder="请输入主题"/>
    </td>
  </tr>
  <tr>
    <td align="right" class="infotitle">时间：</td>
    <td colspan="5">
      <input type="date" name="info[content_time]" id="content_time" value="<?php echo $this->info['content_time_show']?>" style="width:300px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>
  <tr>
    <td align="right" class="infotitle">正文：</td>
    <td colspan="5">
      <textarea name="info[neirong]" id="neirong" style="width:600px;height:200px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px" placeholder="请输入正文内容"><?php echo $this->info['neirong']?></textarea>
    </td>
  </tr>
  <tr>
    <td align="right" class="infotitle">参会人员：</td>
    <td colspan="5">
      <input type="text" id="canhui_search" value="" style="width:300px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px" placeholder="请输入姓名搜索辅警" autocomplete="off"/>
      <div id="canhui_inputlist" style="position:absolute;z-index:999;background-color:#28348e;border:1px solid #ccc;display:none;min-width:300px;"><ul style="list-style:none;padding:0;margin:0;"></ul></div>
      <div id="selected_people" style="margin-top:10px;margin-left:5px;"></div>
      <input type="hidden" name="info[canhui_renyuan]" id="canhui_renyuan" value="<?php echo $this->info['canhui_renyuan']?>" />
      <br/><span style="color:#999;font-size:12px;margin-left:10px">输入姓名搜索并点击添加人员</span>
    </td>
  </tr>
  <tr>
    <td align="right" class="infotitle">附件图片：</td>
    <td colspan="5">
      <input type="hidden" name="info[fujian]" id="fujian" value='<?php echo htmlspecialchars($this->info['fujian'])?>' />
      <input type="file" id="fujian_upload" accept="image/*" multiple style="margin-left:5px;background:transparent;color:#fff"/>
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
<div class="clear"></div><div class="bk15"></div>
</div>
</form>

<script type="text/javascript">
var selectedPeople = [];
var searchTimer = null;
var fujianImages = [];

$(function() {
    var existingPeople = '<?php echo $this->info['canhui_renyuan']?>';
    if (existingPeople) { selectedPeople = existingPeople.split(','); updateSelectedPeople(); }

    var existingFujian = $('#fujian').val();
    if (existingFujian) {
        try { fujianImages = JSON.parse(existingFujian); if (!Array.isArray(fujianImages)) { fujianImages = existingFujian ? [existingFujian] : []; } }
        catch (e) { fujianImages = existingFujian ? [existingFujian] : []; }
    }
    updateFujianPreview();
});

$('#canhui_search').on('keyup', function() {
    clearTimeout(searchTimer);
    var keyword = $(this).val();
    if (keyword.length < 1) { $('#canhui_inputlist').hide(); return; }
    searchTimer = setTimeout(function() {
        $.ajax({
            url: 'index.php?m=renshi&c=geren&a=search_fujing_zhutihuodong',
            type: 'GET', data: {keyword: keyword}, dataType: 'json',
            success: function(res) {
                if (res.status == 1 && res.data.length > 0) {
                    var html = '';
                    for (var i = 0; i < res.data.length; i++) {
                        if (selectedPeople.indexOf(res.data[i].name) === -1) {
                            var displayText = res.data[i].name + ' [' + (res.data[i].sex || '') + ', ' + (res.data[i].sfz || '') + ', ' + (res.data[i].danwei || '') + ']';
                            html += '<li data-name="' + res.data[i].name + '" style="padding:8px 12px;cursor:pointer;border-bottom:1px solid #444;">' + displayText + '</li>';
                        }
                    }
                    if (html) { $('#canhui_inputlist ul').html(html); $('#canhui_inputlist').show(); }
                    else { $('#canhui_inputlist').hide(); }
                } else { $('#canhui_inputlist').hide(); }
            }
        });
    }, 300);
});

$(document).delegate('#canhui_inputlist li', 'click', function() {
    var name = $(this).attr('data-name');
    if (selectedPeople.indexOf(name) === -1) { selectedPeople.push(name); updateSelectedPeople(); }
    $('#canhui_search').val(''); $('#canhui_inputlist').hide();
});

$(document).delegate('.remove-person', 'click', function() {
    var name = $(this).attr('data-name');
    var index = selectedPeople.indexOf(name);
    if (index > -1) { selectedPeople.splice(index, 1); updateSelectedPeople(); }
});

function updateSelectedPeople() {
    var html = '';
    for (var i = 0; i < selectedPeople.length; i++) {
        html += '<span style="display:inline-block;background:#3498db;color:#fff;padding:3px 8px;margin:2px;border-radius:3px;">' + selectedPeople[i] + ' <a href="javascript:void(0)" class="remove-person" data-name="' + selectedPeople[i] + '" style="color:#fff;text-decoration:none;margin-left:5px;">&times;</a></span>';
    }
    $('#selected_people').html(html);
    $('#canhui_renyuan').val(selectedPeople.join(','));
}

$(document).click(function(e) { if (!$(e.target).closest('#canhui_search, #canhui_inputlist').length) { $('#canhui_inputlist').hide(); } });

$('#fujian_upload').on('change', function(e) {
    var files = e.target.files;
    if (files.length > 0) {
        $('#fujian_preview').prepend('<div id="uploading_tip" style="color:#ff9900;margin-bottom:10px;">正在上传 ' + files.length + ' 张图片...</div>');
        for (var i = 0; i < files.length; i++) { uploadSingleFile(files[i]); }
        $(this).val('');
    }
});

function uploadSingleFile(file) {
    var formData = new FormData();
    formData.append('file', file);
    $.ajax({
        url: 'index.php?m=renshi&c=geren&a=upload_zhutihuodong_image',
        type: 'POST', data: formData, processData: false, contentType: false, dataType: 'json',
        success: function(res) {
            if (res.status == 1) { fujianImages.push(res.url); updateFujianPreview(); }
            else { alert('上传失败：' + res.msg); }
        },
        error: function() { alert('上传请求失败'); }
    });
}

function updateFujianPreview() {
    $('#uploading_tip').remove();
    var html = '';
    var upload_url = '<?php echo pc_base::load_config("system", "upload_url")?>';
    for (var i = 0; i < fujianImages.length; i++) {
        var imgUrl = fujianImages[i];
        if (imgUrl.indexOf('http://') !== 0 && imgUrl.indexOf('https://') !== 0) { imgUrl = upload_url + imgUrl.replace('uploadfile/', ''); }
        html += '<div style="display:inline-block;margin:5px;position:relative;"><img src="' + imgUrl + '" width="150" style="border:1px solid #ddd;" /><a href="javascript:void(0)" class="remove-fujian-image" data-index="' + i + '" style="position:absolute;top:-5px;right:-5px;background:#ff6666;color:#fff;border-radius:50%;width:20px;height:20px;text-align:center;line-height:20px;text-decoration:none;font-weight:bold;">&times;</a></div>';
    }
    $('#fujian_preview').html(html);
    $('#fujian').val(JSON.stringify(fujianImages));
}

$(document).delegate('.remove-fujian-image', 'click', function() {
    fujianImages.splice(parseInt($(this).attr('data-index')), 1);
    updateFujianPreview();
});
</script>
</body>
</html>
