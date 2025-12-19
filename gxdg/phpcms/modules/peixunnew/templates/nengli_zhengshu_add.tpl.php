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

<form action="?m=peixunnew&c=nengli_zhengshu&a=addsave" method="POST" name="myform" id="myform">

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">个人证书添加</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="120" align="right" class="infotitle"><span style="color:red">*</span>辅警：</td>
    <td colspan="5">
      <input type="text" id="fjing_search" name="fjing_search" value=""
             style="width:300px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
             placeholder="请输入姓名搜索辅警" autocomplete="off"/>

      <div id="fjing_inputlist" style="position:absolute;z-index:999;background-color:#28348e;border:1px solid #ccc;display:none;min-width:320px;max-height:260px;overflow-y:auto;">
        <ul style="list-style:none;padding:0;margin:0;"></ul>
      </div>

      <input type="hidden" name="info[fjid]" id="fjid" value="" />
      <input type="hidden" name="info[fjname]" id="fjname" value="" />
      <input type="hidden" name="info[bmid]" id="bmid" value="" />

      <div id="fjing_info_display" style="margin-top:10px;margin-left:5px;line-height:22px;color:#cde4ff;">未选择辅警</div>
      <span style="color:#999;font-size:12px;margin-left:10px">输入姓名关键字并点击列表选择</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>证书类型：</td>
    <td colspan="5">
      <select name="info[type_id]" id="type_id" required
              style="width:300px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="">请选择证书类型</option>
        <?php foreach($this->type_list as $t): ?>
        <option value="<?php echo $t['id']?>"><?php echo htmlspecialchars($t['typename'])?></option>
        <?php endforeach; ?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>证书编号：</td>
    <td colspan="5">
      <input type="text" name="info[zhengshu_no]" id="zhengshu_no" value=""
             style="width:300px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入证书编号"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>发证机构：</td>
    <td colspan="5">
      <input type="text" name="info[jigou]" id="jigou" value=""
             style="width:300px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入发证机构"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>获得时间：</td>
    <td colspan="5">
      <input type="date" name="info[huode_time]" id="huode_time" value=""
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>有效期开始：</td>
    <td colspan="5">
      <input type="date" name="info[youxiao_start]" id="youxiao_start" value=""
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
      <span style="color:#999;font-size:12px;margin-left:10px;">开始日期必填</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">有效期结束：</td>
    <td colspan="5">
      <input type="date" name="info[youxiao_end]" id="youxiao_end" value=""
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
      <span style="color:#999;font-size:12px;margin-left:10px;">为空表示长期有效</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">等级：</td>
    <td colspan="5">
      <input type="text" name="info[dengji]" id="dengji" value=""
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入等级"/>
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
    <td align="right" class="infotitle">附件：</td>
    <td colspan="5">
      <input type="text" name="info[files]" id="files" value=""
             style="width:400px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="可填写附件路径或说明"/>
      <span style="color:#999;font-size:12px;margin-left:10px;">后续可替换为上传</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5">
      <textarea name="info[beizhu]" id="beizhu" rows="4" cols="60"
                style="background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px;"
                placeholder="请输入备注"></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">状态：</td>
    <td colspan="5" style="padding-left:5px;">
      <label style="margin-right:15px;"><input type="radio" name="info[status]" value="1" checked /> 有效</label>
      <label><input type="radio" name="info[status]" value="0" /> 失效</label>
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
var selectedDanwei = '';

$(function(){
    // 辅警搜索自动完成
    $("#fjing_search").bind("keyup click", function(){
        var t = $(this), _html = "";
        var searchVal = t.val().trim();

        if(searchVal === "") {
            $("#fjing_inputlist").hide();
            return;
        }

        $.ajax({
            url: 'index.php?m=peixunnew&c=nengli_zhengshu&a=searchfujing',
            type: 'POST',
            data: {keyword: searchVal},
            dataType: 'json',
            success: function(res) {
                if(res.status == 1 && res.data && res.data.length > 0) {
                    for(var i = 0; i < res.data.length; i++) {
                        var item = res.data[i];
                        _html += "<li data-id='" + item.id + "' data-name='" + item.xingming + "' data-dwid='" + (item.dwid || '') + "' data-danwei='" + (item.danwei || '') + "' style='line-height:30px;font-size:14px;padding:5px 10px;cursor:pointer;white-space:nowrap;'>"
                               + item.xingming + " [" + item.sex + ", " + item.sfz + (item.danwei ? ", " + item.danwei : "") + "]</li>";
                    }
                    $("#fjing_inputlist ul").html(_html);
                    $("#fjing_inputlist").show();
                } else {
                    $("#fjing_inputlist ul").html("<li style='color:#999;padding:5px 10px;'>未找到匹配的辅警</li>");
                    $("#fjing_inputlist").show();
                }
            },
            error: function() {
                $("#fjing_inputlist").hide();
            }
        });
    });

    // 选择辅警
    $(document).delegate("#fjing_inputlist ul li", "click", function(){
        var fjid = $(this).attr("data-id");
        var fjname = $(this).attr("data-name");
        var dwid = $(this).attr("data-dwid");
        selectedDanwei = $(this).attr("data-danwei") || '';
        if(fjid) {
            $("#fjid").val(fjid);
            $("#fjname").val(fjname);
            $("#bmid").val(dwid);
            $("#fjing_search").val(fjname);
            $("#fjing_inputlist").hide();
            loadFujingInfo(fjid);
        }
    });

    // 鼠标悬停效果
    $(document).delegate("#fjing_inputlist ul li", "mouseover", function(){
        $(this).css('background', '#E0E0E8').css('color', '#28348e');
    }).delegate("#fjing_inputlist ul li", "mouseout", function(){
        $(this).css('background', 'transparent').css('color', '#fff');
    });

    // 点击其他区域隐藏下拉
    $(document).click(function(e){
        if(!$(e.target).closest('#fjing_search, #fjing_inputlist').length) {
            $("#fjing_inputlist").hide();
        }
    });
});

// 获取辅警详细信息
function loadFujingInfo(fjid) {
    if(!fjid) {
        $("#fjing_info_display").html("未选择辅警");
        return;
    }

    $.ajax({
        url: 'index.php?m=peixunnew&c=nengli_zhengshu&a=getfujinginfo',
        type: 'POST',
        data: {fjid: fjid},
        dataType: 'json',
        success: function(res) {
            if(res.status == 1 && res.data) {
                var d = res.data;
                var danweiText = selectedDanwei ? selectedDanwei : (d.dwid ? ('部门ID：' + d.dwid) : '未填写');
                var html = ''
                    + '姓名：' + (d.xingming || '') + '<br/>'
                    + '性别：' + (d.sex || '') + '<br/>'
                    + '身份证：' + (d.sfz || '') + '<br/>'
                    + '部门：' + danweiText + '<br/>'
                    + '电话：' + (d.tel || '');
                $("#fjing_info_display").html(html);
            } else {
                $("#fjing_info_display").html("未能获取辅警信息");
            }
        },
        error: function() {
            $("#fjing_info_display").html("获取辅警信息失败");
        }
    });
}
</script>

</body>
</html>
