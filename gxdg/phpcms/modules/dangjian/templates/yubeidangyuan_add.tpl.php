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

<form action="?m=dangjian&c=jiagou&a=yubeidangyuan_addsave" method="POST" name="myform" id="myform">
<input type="hidden" name="fujing_id" id="fujing_id" value="" />

<style type="text/css">
    #inputlist{
      position: absolute;
      z-index:999;
      background-color:#28348e;
      margin: 0;
      padding: 0;
      border: 1px solid #ccc;
      min-width: 300px;
      max-width: 800px;
      width: auto;
      display: none;
    }
    #inputlist ul,li{
      list-style: none;
    }
    #inputlist ul{
      padding: 0;
      margin: 0;
    }
    #inputlist ul li{
      line-height: 30px;
      font-size: 14px;
      text-indent: 5px;
      padding: 5px 10px;
      white-space: nowrap;
      cursor: pointer;
    }
    #inputlist ul li:hover{
      background: #E0E0E8;
      color:#28348e;
    }
</style>

<div class="tableContent">

<div class="tabcon">
<div class="title">预备党员信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span style="color:red">*</span>选择辅警：</td>
    <td colspan="5">
      <input type="text" id="basexm" name="xingming_search" value="" class="infoinput"
             style="width:300px;background:#1a2a4a;color:#fff"
             placeholder="请输入姓名搜索辅警" autocomplete="off"/>
      <div id="inputlist">
        <ul></ul>
      </div>
      <span style="color:#ff6600;margin-left:10px">*请输入辅警姓名进行搜索，点击选择后自动填充详细信息</span>
    </td>
  </tr>
  <tr>
    <td width="100" align="right" class="infotitle"><span>*</span>姓名：</td>
    <td width="263">
      <input type="text" name="info[xingming]" id="xingming" value="" class="infoinput" required style="background:#1a2a4a;color:#fff" />
    </td>
    <td width="100" align="right" class="infotitle"><span>*</span>性别：</td>
    <td width="263">
      <input type="radio" class="rad" checked name="info[sex]" id="nan" value="男"/>男
      <input type="radio" class="rad" name="info[sex]" id="nv" value="女"/>女
    </td>
    <td width="100" align="right" class="infotitle">身份证号：</td>
    <td class="rb">
      <input type="text" name="info[sfz]" id="sfz" class="infoinput" value="" style="background:#1a2a4a;color:#fff"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">出生年月日：</td>
    <td>
      <input type="text" name="shengri" id="shengri" class="infoinput" value="" style="width:200px;background:#1a2a4a;color:#fff" />
    </td>
    <td align="right" class="infotitle">年龄：</td>
    <td>
      <input type="text" name="info[age]" id="age" class="infoinput" value="" style="background:#1a2a4a;color:#fff"/>
      <span style="color:#999;font-size:12px">(自动计算)</span>
    </td>
    <td align="right" class="infotitle">电话：</td>
    <td class="rb">
      <input type="text" name="info[tel]" id="tel" class="infoinput" value="" style="background:#1a2a4a;color:#fff"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">学历：</td>
    <td>
      <select name="info[xueli]" id="xueli" class="infoselect" style="background:#1a2a4a;color:#fff">
        <option value="">请选择</option>
        <?php foreach($this->xueli as $k=>$v){?>
        <option value="<?php echo $k?>"><?php echo $v?></option>
        <?php }?>
      </select>
    </td>
    <td align="right" class="infotitle">专业：</td>
    <td>
      <input type="text" name="info[zhuanye]" id="zhuanye" class="infoinput" value="" style="background:#1a2a4a;color:#fff"/>
    </td>
    <td align="right" class="infotitle">毕业学校：</td>
    <td class="rb">
      <input type="text" name="info[xuexiao]" id="xuexiao" class="infoinput" value="" style="background:#1a2a4a;color:#fff"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">所属单位：</td>
    <td colspan="5">
      <select name="info[dwid]" id="dwid" style="background:#1a2a4a;color:#fff">
        <?php echo $this->select_categorys?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">行政职务：</td>
    <td>
      <select name="info[gangwei]" id="gangwei" class="infoselect" style="background:#1a2a4a;color:#fff">
        <option value="">请选择</option>
        <?php foreach($this->gangwei as $k=>$v){?>
        <option value="<?php echo $k?>"><?php echo $v?></option>
        <?php }?>
      </select>
    </td>
    <td align="right" class="infotitle">警务职务：</td>
    <td>
      <select name="info[zhiwu]" id="zhiwu" class="infoselect" style="background:#1a2a4a;color:#fff">
        <option value="">请选择</option>
        <?php foreach($this->zhiwu as $k=>$v){?>
        <option value="<?php echo $k?>"><?php echo $v?></option>
        <?php }?>
      </select>
    </td>
    <td align="right" class="infotitle">职级（层级）：</td>
    <td class="rb">
      <select name="info[cengji]" id="cengji" class="infoselect" style="background:#1a2a4a;color:#fff">
        <option value="">请选择</option>
        <?php foreach($this->cengji as $k=>$v){?>
        <option value="<?php echo $k?>"><?php echo $v?></option>
        <?php }?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">入党时间：</td>
    <td>
      <input type="text" name="rdzztime" id="rdzztime" class="infoinput" value="" style="width:200px;background:#1a2a4a;color:#fff" />
    </td>
    <td align="right" class="infotitle">参加工作时间：</td>
    <td colspan="3">
      <input type="text" name="scgztime" id="scgztime" class="infoinput" value="" style="width:200px;background:#1a2a4a;color:#fff" />
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">所获荣誉：</td>
    <td colspan="5">
      <textarea name="info[rongy]" id="rongy"
                style="width:500px;height:60px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入所获荣誉"></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">照片：</td>
    <td colspan="5">
      <input type="hidden" name="info[thumb]" id="thumb" value="" />
      <div id="thumb_images" style="margin-top:5px"></div>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5">
      <textarea name="info[beizhu]" id="beizhu"
                style="width:500px;height:80px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入备注信息"></textarea>
    </td>
  </tr>
  <tr>
    <td align="right" class="infotitle"></td>
    <td colspan="5" style="padding-top:20px;padding-left:5px;">
      <input type="submit" name="dosubmit" id="dosubmit" value="保存" class="dialog" style="margin-right:10px;color:white;font-size:12px;" />
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
// 搜索辅警自动完成功能
$(function(){
    $("#basexm").bind("keyup click", function(){
        var t = $(this), _html = "";
        var searchVal = t.val().trim();

        if(searchVal == "") {
            $("#inputlist").hide();
            return;
        }

        // 通过AJAX搜索辅警
        $.ajax({
            url: 'index.php?m=dangjian&c=jiagou&a=searchfujing',
            type: 'POST',
            data: {keyword: searchVal},
            dataType: 'json',
            success: function(res) {
                if(res.status == 1 && res.data && res.data.length > 0) {
                    for(var i = 0; i < res.data.length; i++) {
                        var item = res.data[i];
                        _html += "<li data-id='" + item.id + "'>"
                               + item.xingming + " [" + item.sex + ", "
                               + item.sfz + ", " + (item.danwei || '') + "]</li>";
                    }
                    $("#inputlist ul").html(_html);
                    $("#inputlist").show();
                } else {
                    $("#inputlist ul").html("<li style='color:#999'>未找到匹配的辅警</li>");
                    $("#inputlist").show();
                }
            },
            error: function() {
                $("#inputlist").hide();
            }
        });
    });

    // 点击列表项选择辅警
    $(document).delegate("#inputlist ul li", "click", function(){
        var fjid = $(this).attr("data-id");
        if(fjid) {
            $("#basexm").val($(this).text().split('[')[0].trim());
            $("#inputlist").hide();
            loadFujingData(fjid);
        }
    });

    // 点击文档其他地方隐藏列表
    $(document).click(function(e){
        if(!$(e.target).closest('#basexm, #inputlist').length) {
            $("#inputlist").hide();
        }
    });
});

// 加载辅警数据的函数
function loadFujingData(fjid) {
    if(!fjid) {
        // 如果没有选择，清空所有字段
        $('#fujing_id').val('');
        $('#xingming').val('');
        $('#sfz').val('');
        $('#shengri').val('');
        $('#age').val('');
        $('#tel').val('');
        $('#xueli').val('');
        $('#zhuanye').val('');
        $('#xuexiao').val('');
        $('#dwid').val('');
        $('#gangwei').val('');
        $('#zhiwu').val('');
        $('#cengji').val('');
        $('#rdzztime').val('');
        $('#scgztime').val('');
        $('#rongy').val('');
        $('#thumb').val('');
        $('#thumb_images').html('');
        $('#beizhu').val('');
        $('input[name="info[sex]"]').prop('checked', false);
        return;
    }

    // 设置隐藏的fujing_id值
    $('#fujing_id').val(fjid);

    // 发送 AJAX 请求获取辅警详细信息
    $.ajax({
        url: 'index.php?m=dangjian&c=jiagou&a=getfujinginfo',
        type: 'POST',
        data: {id: fjid},
        dataType: 'json',
        success: function(res) {
            if(res.status == 1 && res.data) {
                var data = res.data;

                // 填充基本信息
                $('#xingming').val(data.xingming || '');
                $('#sfz').val(data.sfz || '');

                // 性别
                if(data.sex == '男') {
                    $('#nan').prop('checked', true);
                } else if(data.sex == '女') {
                    $('#nv').prop('checked', true);
                }

                // 出生日期和年龄
                $('#shengri').val(data.shengri || '');
                $('#age').val(data.age || '');
                $('#tel').val(data.tel || '');

                // 学历信息
                $('#xueli').val(data.xueli || '');
                $('#zhuanye').val(data.zhuanye || '');
                $('#xuexiao').val(data.xuexiao || '');

                // 工作信息
                $('#dwid').val(data.dwid || '');
                $('#gangwei').val(data.gangwei || '');
                $('#zhiwu').val(data.zhiwu || '');
                $('#cengji').val(data.cengji || '');

                // 时间信息
                $('#rdzztime').val(data.rdzztime || '');
                $('#scgztime').val(data.scgztime || '');

                // 所获荣誉
                $('#rongy').val(data.rongy || '');

                // 照片
                $('#thumb').val(data.thumb || '');
                if(data.thumb) {
                    $('#thumb_images').html('<img src="' + data.thumb + '" width="150" />');
                } else {
                    $('#thumb_images').html('');
                }

                // 备注
                $('#beizhu').val(data.beizhu || '');

            } else {
                alert(res.msg || '获取辅警信息失败');
            }
        },
        error: function() {
            alert('请求失败，请稍后重试');
        }
    });
}

// 根据出生日期自动计算年龄
$('#shengri').on('change', function(){
    var birthday = $(this).val();
    if(birthday){
        var birthdayDate = new Date(birthday);
        var today = new Date();
        var age = today.getFullYear() - birthdayDate.getFullYear();
        var m = today.getMonth() - birthdayDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthdayDate.getDate())) {
            age--;
        }
        $('#age').val(age);
    }
});
</script>

</body>
</html>
