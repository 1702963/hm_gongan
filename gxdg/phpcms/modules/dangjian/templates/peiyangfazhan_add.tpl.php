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
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<form action="?m=dangjian&c=zhibu&a=peiyangfazhan_addsave" method="POST" name="myform" id="myform">

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">培养发展党员情况</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span style="color:red">*</span>主题：</td>
    <td colspan="5">
      <input type="text" name="info[theme]" id="theme" value="" required
             style="width:500px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入主题"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">时间：</td>
    <td colspan="5">
      <input type="date" name="info[meeting_time]" id="meeting_time" value=""
             style="width:300px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">正文：</td>
    <td colspan="5">
      <textarea name="info[content]" id="content"
                style="width:600px;height:200px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入正文"></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">个人警装照片展示：</td>
    <td colspan="5">
      <input type="hidden" name="info[jingzhuang_photo]" id="jingzhuang_photo" value="" />
      <input type="file" id="photo_upload" accept="image/*" multiple
             style="margin-left:5px;background:transparent;color:#fff"/>
      <div id="photo_preview" style="margin-top:10px;"></div>
      <span style="color:#999;font-size:12px;margin-left:10px">支持上传多张图片</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">参会人员：</td>
    <td colspan="5">
      <input type="text" id="canhui_search" name="canhui_search" value=""
             style="width:300px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
             placeholder="请输入姓名搜索辅警" autocomplete="off"/>

      <div id="canhui_inputlist" style="position:absolute;z-index:999;background-color:#28348e;border:1px solid #ccc;display:none;min-width:300px;">
        <ul style="list-style:none;padding:0;margin:0;"></ul>
      </div>

      <div id="selected_people" style="margin-top:10px;margin-left:5px;"></div>

      <input type="hidden" name="info[canhui_renyuan]" id="canhui_renyuan" value="" />

      <br/>
      <span style="color:#999;font-size:12px;margin-left:10px">输入姓名搜索并点击添加人员</span>
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
var photoImages = [];

// 文件上传处理
$('#photo_upload').on('change', function(e) {
    var files = e.target.files;
    if (files.length > 0) {
        // 显示上传进度提示
        var uploadingCount = files.length;
        $('#photo_preview').prepend('<div id="uploading_tip" style="color:#ff9900;margin-bottom:10px;">正在上传 ' + uploadingCount + ' 张图片...</div>');

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
        url: 'index.php?m=dangjian&c=zhibu&a=upload_peiyangfazhan_image',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
            if (res.status == 1) {
                // 上传成功，添加URL到数组
                photoImages.push(res.url);
                updatePhotoPreview();
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
function updatePhotoPreview() {
    // 移除上传提示
    $('#uploading_tip').remove();

    var html = '';
    var upload_url = '<?php echo pc_base::load_config("system", "upload_url")?>';

    for (var i = 0; i < photoImages.length; i++) {
        var imgUrl = photoImages[i];
        // 如果是相对路径，添加upload_url前缀
        if (imgUrl.indexOf('http://') !== 0 && imgUrl.indexOf('https://') !== 0) {
            imgUrl = upload_url + imgUrl.replace('uploadfile/', '');
        }

        html += '<div style="display:inline-block;margin:5px;position:relative;">'
              + '<img src="' + imgUrl + '" width="150" style="border:1px solid #ddd;" />'
              + '<a href="javascript:void(0)" class="remove-photo-image" data-index="' + i + '" '
              + 'style="position:absolute;top:-5px;right:-5px;background:#ff6666;color:#fff;'
              + 'border-radius:50%;width:20px;height:20px;text-align:center;line-height:20px;'
              + 'text-decoration:none;font-weight:bold;">×</a>'
              + '</div>';
    }
    $('#photo_preview').html(html);

    // 更新隐藏字段为JSON格式
    $('#jingzhuang_photo').val(JSON.stringify(photoImages));
}

// 删除图片
$(document).delegate('.remove-photo-image', 'click', function() {
    var index = parseInt($(this).attr('data-index'));
    photoImages.splice(index, 1);
    updatePhotoPreview();
});

// 参会人员选择功能
$(function(){
    var selectedPeople = [];

    // 搜索辅警自动完成
    $("#canhui_search").bind("keyup click", function(){
        var t = $(this), _html = "";
        var searchVal = t.val().trim();

        if(searchVal == "") {
            $("#canhui_inputlist").hide();
            return;
        }

        // 通过AJAX搜索辅警
        $.ajax({
            url: 'index.php?m=dangjian&c=zhibu&a=searchfujing',
            type: 'POST',
            data: {keyword: searchVal},
            dataType: 'json',
            success: function(res) {
                if(res.status == 1 && res.data && res.data.length > 0) {
                    for(var i = 0; i < res.data.length; i++) {
                        var item = res.data[i];
                        _html += "<li data-name='" + item.xingming + "' style='line-height:30px;font-size:14px;padding:5px 10px;cursor:pointer;white-space:nowrap;'>"
                               + item.xingming + " [" + item.sex + ", " + item.sfz + ", " + (item.danwei || '') + "]</li>";
                    }
                    $("#canhui_inputlist ul").html(_html);
                    $("#canhui_inputlist").show();
                } else {
                    $("#canhui_inputlist ul").html("<li style='color:#999;padding:5px 10px;'>未找到匹配的辅警</li>");
                    $("#canhui_inputlist").show();
                }
            },
            error: function() {
                $("#canhui_inputlist").hide();
            }
        });
    });

    // 添加人员到列表
    $(document).delegate("#canhui_inputlist ul li", "click", function(){
        var name = $(this).attr("data-name");
        if(name && selectedPeople.indexOf(name) === -1) {
            selectedPeople.push(name);
            updateSelectedList();
            $("#canhui_search").val("");
            $("#canhui_inputlist").hide();
        }
    });

    // 移除人员
    $(document).delegate(".remove-person", "click", function(){
        var name = $(this).attr("data-name");
        var index = selectedPeople.indexOf(name);
        if(index > -1) {
            selectedPeople.splice(index, 1);
            updateSelectedList();
        }
    });

    // 更新已选人员列表显示
    function updateSelectedList() {
        var html = "";
        for(var i = 0; i < selectedPeople.length; i++) {
            html += "<div style='display:inline-block;background:#3e4095;padding:5px 10px;margin:5px;border-radius:3px;'>"
                  + selectedPeople[i]
                  + " <a href='javascript:void(0)' class='remove-person' data-name='" + selectedPeople[i] + "' style='color:#ff6666;margin-left:5px;text-decoration:none;font-weight:bold;'>×</a>"
                  + "</div>";
        }
        $("#selected_people").html(html);

        // 更新隐藏字段
        $("#canhui_renyuan").val(selectedPeople.join(','));
    }

    // 点击其他地方隐藏下拉列表
    $(document).click(function(e){
        if(!$(e.target).closest('#canhui_search, #canhui_inputlist').length) {
            $("#canhui_inputlist").hide();
        }
    });

    // 鼠标悬停效果
    $(document).delegate("#canhui_inputlist ul li", "mouseover", function(){
        $(this).css('background', '#E0E0E8').css('color', '#28348e');
    }).delegate("#canhui_inputlist ul li", "mouseout", function(){
        $(this).css('background', 'transparent').css('color', '#fff');
    });
});
</script>

</body>
</html>
