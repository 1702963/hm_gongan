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

<form action="?m=peixunnew&c=geren_bmi&a=addsave" method="POST" name="myform" id="myform">

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">添加BMI记录</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle"><span style="color:red">*</span>选择人员：</td>
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
      <span style="color:#999;font-size:12px;margin-left:10px">输入姓名搜索并点击选择人员，将自动带入身高体重数据</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>身高(cm)：</td>
    <td colspan="5">
      <input type="number" name="info[shengao]" id="shengao" value="" step="0.01" min="100" max="250"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入身高"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>体重(kg)：</td>
    <td colspan="5">
      <input type="number" name="info[tizhong]" id="tizhong" value="" step="0.01" min="30" max="200"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入体重"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">BMI值：</td>
    <td colspan="5">
      <span id="bmi_display" style="margin-left:5px;font-size:16px;font-weight:bold;">--</span>
      <span id="bmi_status" style="margin-left:10px;"></span>
      <br/><span style="color:#999;font-size:12px;margin-left:5px;">BMI = 体重(kg) ÷ 身高(m)² | 正常范围: 18.5~24</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">体脂率(%)：</td>
    <td colspan="5">
      <input type="number" name="info[tizhilv]" id="tizhilv" value="" step="0.01" min="0" max="100"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入体脂率"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">腰围(cm)：</td>
    <td colspan="5">
      <input type="number" name="info[yaowei]" id="yaowei" value="" step="0.01" min="0" max="200"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入腰围"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">臀围(cm)：</td>
    <td colspan="5">
      <input type="number" name="info[tunwei]" id="tunwei" value="" step="0.01" min="0" max="200"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入臀围"/>
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
    <td align="right" class="infotitle">测量月份：</td>
    <td colspan="5">
      <input type="month" name="info[ceyue]" id="ceyue" value=""
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
      <span style="color:#999;font-size:12px;margin-left:10px">选择年月</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">性别：</td>
    <td colspan="5">
      <select name="info[xingbie]" id="xingbie"
              style="width:150px;height:28px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="">请选择</option>
        <option value="男">男</option>
        <option value="女">女</option>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">达标体重(kg)：</td>
    <td colspan="5">
      <input type="number" name="info[dabiao_tizhong]" id="dabiao_tizhong" value="" step="0.01" min="0" max="200"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入达标体重"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">增重(kg)：</td>
    <td colspan="5">
      <input type="number" name="info[zengzhong]" id="zengzhong" value="" step="0.01" min="-100" max="100"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入增重数量（正数为增重，负数为减重）"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">与达标差额(kg)：</td>
    <td colspan="5">
      <input type="number" name="info[yu_dabiao_chae]" id="yu_dabiao_chae" value="" step="0.01" min="-100" max="100"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入与达标差额（正数为超重，负数为偏轻）"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">排名：</td>
    <td colspan="5">
      <input type="number" name="info[paiming]" id="paiming" value="" step="1" min="1"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入BMI排名"/>
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
            url: 'index.php?m=peixunnew&c=geren_bmi&a=searchfujing',
            type: 'POST',
            data: {keyword: searchVal},
            dataType: 'json',
            success: function(res) {
                if(res.status == 1 && res.data && res.data.length > 0) {
                    for(var i = 0; i < res.data.length; i++) {
                        var item = res.data[i];
                        _html += "<li data-id='" + item.id + "' data-name='" + item.xingming + "' data-dwid='" + item.dwid + "' data-shengao='" + item.shengao + "' data-tizhong='" + item.tizhong + "' style='line-height:30px;font-size:14px;padding:5px 10px;cursor:pointer;white-space:nowrap;'>"
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
        var shengao = $(this).attr("data-shengao");
        var tizhong = $(this).attr("data-tizhong");

        if(id && name) {
            $("#fujing_search").val(name);
            $("#fjid").val(id);
            $("#dwid").val(dwid);

            // 带入身高体重数据（身高从米转换为厘米）
            var sg = parseFloat(shengao) || 0;
            var tz = parseFloat(tizhong) || 0;

            // 数据库身高是米，转换为厘米
            if(sg > 0 && sg < 3) {
                sg = Math.round(sg * 100);
            }

            if(sg > 0) {
                $("#shengao").val(sg);
            } else {
                $("#shengao").val('').attr('placeholder', '档案中无数据，请手动输入');
            }
            if(tz > 0) {
                $("#tizhong").val(tz);
            } else {
                $("#tizhong").val('').attr('placeholder', '档案中无数据，请手动输入');
            }

            // 自动计算BMI
            calculateBMI();

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

    // 实时计算BMI
    $("#shengao, #tizhong").on("input change", function(){
        calculateBMI();
    });

    function calculateBMI() {
        var shengao = parseFloat($("#shengao").val()) || 0;
        var tizhong = parseFloat($("#tizhong").val()) || 0;

        if(shengao > 0 && tizhong > 0) {
            var heightM = shengao / 100;
            var bmi = tizhong / (heightM * heightM);
            bmi = Math.round(bmi * 10) / 10;

            var status = '';
            var color = '#fff';
            if(bmi < 18.5) {
                status = '偏瘦';
                color = '#5bc0de';
            } else if(bmi >= 18.5 && bmi < 24) {
                status = '正常';
                color = '#5cb85c';
            } else if(bmi >= 24 && bmi < 28) {
                status = '超重';
                color = '#f0ad4e';
            } else {
                status = '肥胖';
                color = '#d9534f';
            }

            $("#bmi_display").text(bmi).css('color', color);
            $("#bmi_status").text('(' + status + ')').css('color', color);
        } else {
            $("#bmi_display").text('--').css('color', '#fff');
            $("#bmi_status").text('');
        }
    }
});
</script>

</body>
</html>
