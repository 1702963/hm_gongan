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

<form action="?m=peixunnew&c=geren_bmi&a=editsave" method="POST" name="myform" id="myform">

<input type="hidden" name="id" value="<?php echo $this->info['id']?>" />

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">编辑BMI记录</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle">人员姓名：</td>
    <td colspan="5">
      <input type="text" value="<?php echo $this->info['fjname']?>" readonly
             style="width:300px;height:20px;background:transparent;color:#ccc;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>身高(cm)：</td>
    <td colspan="5">
      <input type="number" name="info[shengao]" id="shengao" value="<?php echo $this->info['shengao']?>" step="0.01" min="100" max="250"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入身高"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>体重(kg)：</td>
    <td colspan="5">
      <input type="number" name="info[tizhong]" id="tizhong" value="<?php echo $this->info['tizhong']?>" step="0.01" min="30" max="200"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入体重"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">BMI值：</td>
    <td colspan="5">
      <span id="bmi_display" style="margin-left:5px;font-size:16px;font-weight:bold;"><?php echo $this->info['bmi']?></span>
      <span id="bmi_status" style="margin-left:10px;"></span>
      <br/><span style="color:#999;font-size:12px;margin-left:5px;">BMI = 体重(kg) ÷ 身高(m)² | 正常范围: 18.5~24</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">体脂率(%)：</td>
    <td colspan="5">
      <input type="number" name="info[tizhilv]" id="tizhilv" value="<?php echo $this->info['tizhilv']?>" step="0.01" min="0" max="100"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入体脂率"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">腰围(cm)：</td>
    <td colspan="5">
      <input type="number" name="info[yaowei]" id="yaowei" value="<?php echo $this->info['yaowei']?>" step="0.01" min="0" max="200"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入腰围"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">臀围(cm)：</td>
    <td colspan="5">
      <input type="number" name="info[tunwei]" id="tunwei" value="<?php echo $this->info['tunwei']?>" step="0.01" min="0" max="200"
             style="width:200px;height:20px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入臀围"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5">
      <textarea name="info[beizhu]" id="beizhu" rows="3"
                style="width:400px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入备注"><?php echo $this->info['beizhu']?></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">录入时间：</td>
    <td colspan="5">
      <input type="text" value="<?php echo $this->info['inputtime_show']?>" readonly
             style="width:200px;height:20px;background:transparent;color:#ccc;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
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
    // 页面加载时计算当前BMI状态
    calculateBMI();

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
