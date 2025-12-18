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


<form action="?m=peixunnew&c=qiangzhi_sheji_fankui&a=addsave" method="POST" name="myform" id="myform">

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">添加射击反馈</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="120" align="right" class="infotitle"><span style="color:red">*</span>射击计划：</td>
    <td colspan="5">
      <select name="info[jihua_id]" id="jihua_id" required
              style="width:300px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="0">请选择</option>
        <?php
        if(is_array($this->jihua_list)){
            foreach($this->jihua_list as $jh){
                echo "<option value='{$jh['id']}'>{$jh['title']}</option>";
            }
        }
        ?>
      </select>
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
    <td align="right" class="infotitle"><span style="color:red">*</span>参射人员：</td>
    <td colspan="5">
      <div style="position:relative;width:100%;">
        <input type="hidden" name="info[fjid]" id="fjid" value="" />
        <input type="text" name="info[fjname]" id="fjname" value=""
               style="width:300px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;"
               placeholder="输入辅警姓名或身份证号搜索" />
        <div id="search_result" style="position:absolute;top:100%;left:5px;width:300px;background:#1e1f5e;border:1px solid #ddd;z-index:10;display:none;max-height:300px;overflow-y:auto;">
        </div>
      </div>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">成绩：</td>
    <td colspan="5">
      <input type="text" name="info[chengji]" id="chengji" value=""
             style="width:300px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;"
             placeholder="请输入成绩"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">是否合格：</td>
    <td colspan="5">
      <select name="info[guo]" id="guo"
              style="width:150px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="0">不合格</option>
        <option value="1">合格</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">提报时间：</td>
    <td colspan="5">
      <input type="date" name="info[tianbao_time]" id="tianbao_time" value=""
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;"/>
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
// 多图片上传
var filesImages = [];

$(function() {
    // 搜索辅警
    $('#fjname').on('input', function(){
        var keyword = $(this).val();
        if(keyword.length < 2) {
            $('#search_result').hide();
            return;
        }

        $.ajax({
            url: '?m=peixunnew&c=qiangzhi_sheji_fankui&a=searchfujing',
            type: 'POST',
            data: {keyword: keyword},
            dataType: 'json',
            success: function(res){
                if(res.status == 1) {
                    var html = '';
                    $.each(res.data, function(i, item){
                        html += '<div style="padding:5px;border-bottom:1px solid #444;cursor:pointer;" onclick="selectFujing('+item.id+', \''+item.xingming+'\')">';
                        html += '<span style="color:#0f0;">'+item.xingming+'</span> - '+item.sfz+' - '+item.danwei;
                        html += '</div>';
                    });
                    $('#search_result').html(html).show();
                } else {
                    $('#search_result').html('<div style="padding:5px;color:#f00;">未找到匹配的辅警</div>').show();
                }
            },
            error: function(){
                $('#search_result').html('<div style="padding:5px;color:#f00;">搜索失败</div>').show();
            }
        });
    });

    // 文件上传
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
});

function selectFujing(id, name) {
    $('#fjid').val(id);
    $('#fjname').val(name);
    $('#search_result').hide();
}

function uploadSingleFile(file) {
    var formData = new FormData();
    formData.append('file', file);

    $.ajax({
        url: 'index.php?m=peixunnew&c=qiangzhi_sheji_fankui&a=upload_image',
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
