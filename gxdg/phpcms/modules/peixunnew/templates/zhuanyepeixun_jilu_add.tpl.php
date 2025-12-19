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

<form action="?m=peixunnew&c=zhuanyepeixun_jilu&a=addsave" method="POST" name="myform" id="myform">

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">专业培训记录</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="120" align="right" class="infotitle"><span style="color:red">*</span>培训计划：</td>
    <td colspan="5">
      <select name="info[jihua_id]" id="jihua_id" required
              style="width:400px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="">请选择培训计划</option>
        <?php foreach($this->jihua_list as $jh): ?>
        <option value="<?php echo $jh['id']?>" data-bmid="<?php echo $jh['bmid']?>" data-pxly="<?php echo $jh['pxly']?>"><?php echo $jh['title']?> [<?php echo $jh['pxly']?>]</option>
        <?php endforeach; ?>
      </select>
      <span style="color:#999;font-size:12px;margin-left:10px;">只显示进行中的培训计划</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">所属单位：</td>
    <td colspan="5">
      <select name="info[bmid]" id="bmid"
              style="width:300px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="0">请选择</option>
        <?php echo $this->select_bumen?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>参训人员：</td>
    <td colspan="5">
      <input type="text" id="fujing_search" name="fujing_search" value=""
             style="width:300px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
             placeholder="请输入姓名或身份证搜索" autocomplete="off"/>

      <div id="fujing_inputlist" style="position:absolute;z-index:999;background-color:#28348e;border:1px solid #ccc;display:none;min-width:400px;max-height:300px;overflow-y:auto;">
        <ul style="list-style:none;padding:0;margin:0;"></ul>
      </div>

      <div id="selected_fujing" style="margin-top:10px;margin-left:5px;"></div>

      <input type="hidden" name="info[fjid]" id="fjid" value="" />
      <input type="hidden" name="info[fjname]" id="fjname" value="" />

      <br/>
      <span style="color:#999;font-size:12px;margin-left:10px">输入姓名或身份证搜索</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">成绩：</td>
    <td colspan="5">
      <input type="text" name="info[chengji]" id="chengji" value=""
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入成绩"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">是否通过：</td>
    <td colspan="5">
      <select name="info[guo]" id="guo"
              style="width:150px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="0">未通过</option>
        <option value="1">通过</option>
      </select>
    </td>
  </tr>
  <tr>
    <td align="right" class="infotitle">是否出勤：</td>
    <td colspan="5">
      <select name="info[chuqin]" id="chuqin"
              style="width:150px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="0">否</option>
        <option value="1" selected>是</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">评价等级：</td>
    <td colspan="5">
      <select name="info[pingjia]" id="pingjia"
              style="width:150px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="">请选择</option>
        <option value="优">优</option>
        <option value="良">良</option>
        <option value="中">中</option>
        <option value="差">差</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">评语：</td>
    <td colspan="5">
      <textarea name="info[pingyu]" id="pingyu" rows="3"
                style="width:500px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入评语（评价为差时必填）"></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">填报时间：</td>
    <td colspan="5">
      <input type="date" name="info[tianbao_time]" id="tianbao_time" value=""
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">证书材料：</td>
    <td colspan="5">
      <input type="hidden" name="info[files]" id="files" value="" />
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
// 选择培训计划时自动填充单位
$('#jihua_id').on('change', function() {
    var bmid = $(this).find('option:selected').data('bmid');
    if (bmid) {
        $('#bmid').val(bmid);
    }
});

// 多图片上传
var filesImages = [];

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
        url: 'index.php?m=peixunnew&c=zhuanyepeixun_jilu&a=upload_image',
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

// 辅警搜索单选
$(function(){
    $("#fujing_search").bind("keyup click", function(){
        var searchVal = $(this).val().trim();
        if(searchVal == "") {
            $("#fujing_inputlist").hide();
            return;
        }

        $.ajax({
            url: 'index.php?m=peixunnew&c=zhuanyepeixun_jilu&a=searchfujing',
            type: 'POST',
            data: {keyword: searchVal},
            dataType: 'json',
            success: function(res) {
                var _html = "";
                if(res.status == 1 && res.data && res.data.length > 0) {
                    for(var i = 0; i < res.data.length; i++) {
                        var item = res.data[i];
                        _html += "<li data-id='" + item.id + "' data-name='" + item.xingming + "' data-dwid='" + item.dwid + "' "
                               + "style='line-height:30px;font-size:14px;padding:5px 10px;cursor:pointer;white-space:nowrap;'>"
                               + item.xingming + " [" + item.sex + ", " + item.sfz + ", " + (item.danwei || '') + "]</li>";
                    }
                    $("#fujing_inputlist ul").html(_html);
                    $("#fujing_inputlist").show();
                } else {
                    $("#fujing_inputlist ul").html("<li style='color:#999;padding:5px 10px;'>未找到匹配的辅警</li>");
                    $("#fujing_inputlist").show();
                }
            }
        });
    });

    $(document).delegate("#fujing_inputlist ul li", "click", function(){
        var id = $(this).attr("data-id");
        var name = $(this).attr("data-name");
        var dwid = $(this).attr("data-dwid");

        if(id && name) {
            $('#fjid').val(id);
            $('#fjname').val(name);
            $('#selected_fujing').html('<div style="display:inline-block;background:#3e4095;padding:5px 10px;margin:5px;border-radius:3px;">'
                  + name + ' <a href="javascript:void(0)" id="clear_fujing" '
                  + 'style="color:#ff6666;margin-left:5px;text-decoration:none;font-weight:bold;">×</a></div>');
            if(dwid && !$('#bmid').val()) {
                $('#bmid').val(dwid);
            }
            $("#fujing_search").val("");
            $("#fujing_inputlist").hide();
        }
    });

    $(document).delegate("#clear_fujing", "click", function(){
        $('#fjid').val('');
        $('#fjname').val('');
        $('#selected_fujing').html('');
    });

    $(document).click(function(e){
        if(!$(e.target).closest('#fujing_search, #fujing_inputlist').length) {
            $("#fujing_inputlist").hide();
        }
    });

    $(document).delegate("#fujing_inputlist ul li", "mouseover", function(){
        $(this).css('background', '#E0E0E8').css('color', '#28348e');
    }).delegate("#fujing_inputlist ul li", "mouseout", function(){
        $(this).css('background', 'transparent').css('color', '#fff');
    });
});
</script>

</body>
</html>
