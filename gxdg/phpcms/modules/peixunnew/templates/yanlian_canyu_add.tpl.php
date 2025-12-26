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
// 演练数据（按类型分组）
var yanlianByType = <?php echo json_encode($this->yanlian_by_type);?>;
//-->
</script>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<form action="?m=peixunnew&c=yanlian_canyu&a=addsave" method="POST" name="myform" id="myform">

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">添加参与人</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span style="color:red">*</span>演练类型：</td>
    <td colspan="5">
      <select name="info[yanlian_type]" id="yanlian_type" required style="width:300px;height:25px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="1">对抗训练</option>
        <option value="2">专项悬链</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>演练记录：</td>
    <td colspan="5">
      <select name="info[yanlian_id]" id="yanlian_id" required style="width:400px;height:25px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="">-- 请选择 --</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>分组：</td>
    <td colspan="5">
      <select name="info[fengzu]" id="fengzu" required style="width:300px;height:25px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="">-- 请选择 --</option>
        <option value="1">红方</option>
        <option value="2">蓝方</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>参与人员：</td>
    <td colspan="5">
      <input type="text" id="fujing_search" name="fujing_search" value=""
             style="width:300px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
             placeholder="请输入姓名搜索辅警" autocomplete="off"/>

      <div id="fujing_inputlist" style="position:absolute;z-index:999;background-color:#28348e;border:1px solid #ccc;display:none;min-width:300px;">
        <ul style="list-style:none;padding:0;margin:0;"></ul>
      </div>

      <input type="hidden" name="info[fjid]" id="fjid" value="" />

      <br/>
      <span style="color:#999;font-size:12px;margin-left:10px">输入姓名搜索并点击选择人员</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">评分：</td>
    <td colspan="5">
      <input type="number" name="info[pingjia_score]" id="pingjia_score" value="0" step="0.01" min="0" max="100"
             style="width:300px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入评分（0-100）"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">表现描述：</td>
    <td colspan="5">
      <textarea name="info[biaoxianbiao]" id="biaoxianbiao" rows="4"
                style="width:500px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入表现描述"></textarea>
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
// 参与人员单选功能
$(function(){
    // 搜索辅警自动完成
    $("#fujing_search").bind("keyup click", function(){
        var t = $(this), _html = "";
        var searchVal = t.val().trim();

        if(searchVal == "") {
            $("#fujing_inputlist").hide();
            return;
        }

        // 通过AJAX搜索辅警
        $.ajax({
            url: 'index.php?m=dangjian&c=chengyuan&a=searchfujing',
            type: 'POST',
            data: {keyword: searchVal},
            dataType: 'json',
            success: function(res) {
                if(res.status == 1 && res.data && res.data.length > 0) {
                    for(var i = 0; i < res.data.length; i++) {
                        var item = res.data[i];
                        _html += "<li data-id='" + item.id + "' data-name='" + item.xingming + "' style='line-height:30px;font-size:14px;padding:5px 10px;cursor:pointer;white-space:nowrap;'>"
                               + item.xingming + " [" + item.sex + ", " + item.sfz + ", " + (item.danwei || '') + "]</li>";
                    }
                    $("#fujing_inputlist ul").html(_html);
                    $("#fujing_inputlist").show();
                } else {
                    $("#fujing_inputlist ul").html("<li style='color:#999;padding:5px 10px;'>未找到匹配的辅警</li>");
                    $("#fujing_inputlist").show();
                }
            },
            error: function() {
                $("#fujing_inputlist").hide();
            }
        });
    });

    // 选择人员（单选）
    $(document).delegate("#fujing_inputlist ul li", "click", function(){
        var id = $(this).attr("data-id");
        var name = $(this).attr("data-name");
        if(id && name) {
            $("#fujing_search").val(name);
            $("#fjid").val(id);
            $("#fujing_inputlist").hide();
        }
    });

    // 点击其他地方隐藏下拉列表
    $(document).click(function(e){
        if(!$(e.target).closest('#fujing_search, #fujing_inputlist').length) {
            $("#fujing_inputlist").hide();
        }
    });

    // 鼠标悬停效果
    $(document).delegate("#fujing_inputlist ul li", "mouseover", function(){
        $(this).css('background', '#E0E0E8').css('color', '#28348e');
    }).delegate("#fujing_inputlist ul li", "mouseout", function(){
        $(this).css('background', 'transparent').css('color', '#fff');
    });

    // 演练类型和演练记录联动
    function updateYanlianOptions() {
        var type = $("#yanlian_type").val();
        var $select = $("#yanlian_id");
        $select.html('<option value="">-- 请选择 --</option>');

        if (yanlianByType && yanlianByType[type]) {
            for (var i = 0; i < yanlianByType[type].length; i++) {
                var item = yanlianByType[type][i];
                $select.append('<option value="' + item.id + '">' + item.title + '</option>');
            }
        }
    }

    // 演练类型改变时更新演练记录选项
    $("#yanlian_type").change(function(){
        updateYanlianOptions();
    });

    // 页面加载时初始化演练记录选项
    updateYanlianOptions();
});
</script>

</body>
</html>
