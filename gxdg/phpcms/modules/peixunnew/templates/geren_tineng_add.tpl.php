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
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<form action="?m=peixunnew&c=geren_tineng&a=addsave" method="POST" name="myform" id="myform">

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">添加体能记录</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="120" align="right" class="infotitle"><span style="color:red">*</span>选择人员：</td>
    <td colspan="5">
      <input type="text" id="fujing_search" name="fujing_search" value=""
             style="width:300px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
             placeholder="请输入姓名搜索辅警" autocomplete="off"/>

      <div id="fujing_inputlist" style="position:absolute;z-index:999;background-color:#28348e;border:1px solid #ccc;display:none;min-width:300px;">
        <ul style="list-style:none;padding:0;margin:0;"></ul>
      </div>

      <input type="hidden" name="info[fjid]" id="fjid" value="" />
      <input type="hidden" name="info[dwid]" id="dwid" value="" />

      <br/>
      <span style="color:#999;font-size:12px;margin-left:10px">输入姓名搜索并点击选择人员</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">1000米跑：</td>
    <td colspan="5">
      <input type="number" name="info[paoliang_min]" id="paoliang_min" value="" min="0" max="30"
             style="width:80px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="分"/>
      <span style="color:#fff;">分</span>
      <input type="number" name="info[paoliang_sec]" id="paoliang_sec" value="" min="0" max="59"
             style="width:80px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="秒"/>
      <span style="color:#fff;">秒</span>
      <span style="color:#999;font-size:12px;margin-left:10px">男子标准：4分35秒内优秀</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">俯卧撑(个)：</td>
    <td colspan="5">
      <input type="number" name="info[fuwocheng]" id="fuwocheng" value="" min="0" max="200"
             style="width:150px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入个数"/>
      <span style="color:#999;font-size:12px;margin-left:10px">1分钟内完成数量</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">仰卧起坐(个)：</td>
    <td colspan="5">
      <input type="number" name="info[yangwoqizuo]" id="yangwoqizuo" value="" min="0" max="200"
             style="width:150px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入个数"/>
      <span style="color:#999;font-size:12px;margin-left:10px">1分钟内完成数量</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">引体向上(个)：</td>
    <td colspan="5">
      <input type="number" name="info[yintixiangshang]" id="yintixiangshang" value="" min="0" max="100"
             style="width:150px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入个数"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">立定跳远(cm)：</td>
    <td colspan="5">
      <input type="number" name="info[lidingtiaoyan]" id="lidingtiaoyan" value="" min="0" max="400"
             style="width:150px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入厘米"/>
      <span style="color:#999;font-size:12px;margin-left:10px">男子标准：248cm以上优秀</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">综合评分：</td>
    <td colspan="5">
      <input type="number" name="info[zongfen]" id="zongfen" value="" step="0.1" min="0" max="100"
             style="width:150px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入0-100分"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5">
      <textarea name="info[beizhu]" id="beizhu" rows="3"
                style="width:400px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入备注"></textarea>
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
            url: 'index.php?m=peixunnew&c=geren_tineng&a=searchfujing',
            type: 'POST',
            data: {keyword: searchVal},
            dataType: 'json',
            success: function(res) {
                if(res.status == 1 && res.data && res.data.length > 0) {
                    for(var i = 0; i < res.data.length; i++) {
                        var item = res.data[i];
                        _html += "<li data-id='" + item.id + "' data-name='" + item.xingming + "' data-dwid='" + item.dwid + "' style='line-height:30px;font-size:14px;padding:5px 10px;cursor:pointer;white-space:nowrap;'>"
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
        var dwid = $(this).attr("data-dwid");

        if(id && name) {
            $("#fujing_search").val(name);
            $("#fjid").val(id);
            $("#dwid").val(dwid);
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
});
</script>

</body>
</html>
