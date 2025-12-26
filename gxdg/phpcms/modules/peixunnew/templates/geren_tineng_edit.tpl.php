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

<form action="?m=peixunnew&c=geren_tineng&a=editsave" method="POST" name="myform" id="myform">
<input type="hidden" name="id" value="<?php echo $this->info['id']?>" />

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">编辑体能记录</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="120" align="right" class="infotitle">人员：</td>
    <td colspan="5">
      <span style="color:#fff;font-size:14px;margin-left:5px;"><?php echo $this->info['fjname']?></span>
      <span style="color:#999;font-size:12px;margin-left:10px">（人员不可修改）</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">1000米跑：</td>
    <td colspan="5">
      <input type="number" name="info[paoliang_min]" id="paoliang_min" value="<?php echo $this->info['paoliang_min']?>" min="0" max="30"
             style="width:80px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="分"/>
      <span style="color:#fff;">分</span>
      <input type="number" name="info[paoliang_sec]" id="paoliang_sec" value="<?php echo $this->info['paoliang_sec']?>" min="0" max="59"
             style="width:80px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="秒"/>
      <span style="color:#fff;">秒</span>
      <span style="color:#999;font-size:12px;margin-left:10px">男子标准：4分35秒内优秀</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">俯卧撑(个)：</td>
    <td colspan="5">
      <input type="number" name="info[fuwocheng]" id="fuwocheng" value="<?php echo $this->info['fuwocheng']?>" min="0" max="200"
             style="width:150px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入个数"/>
      <span style="color:#999;font-size:12px;margin-left:10px">1分钟内完成数量</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">仰卧起坐(个)：</td>
    <td colspan="5">
      <input type="number" name="info[yangwoqizuo]" id="yangwoqizuo" value="<?php echo $this->info['yangwoqizuo']?>" min="0" max="200"
             style="width:150px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入个数"/>
      <span style="color:#999;font-size:12px;margin-left:10px">1分钟内完成数量</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">引体向上(个)：</td>
    <td colspan="5">
      <input type="number" name="info[yintixiangshang]" id="yintixiangshang" value="<?php echo $this->info['yintixiangshang']?>" min="0" max="100"
             style="width:150px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入个数"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">立定跳远(cm)：</td>
    <td colspan="5">
      <input type="number" name="info[lidingtiaoyan]" id="lidingtiaoyan" value="<?php echo $this->info['lidingtiaoyan']?>" min="0" max="400"
             style="width:150px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入厘米"/>
      <span style="color:#999;font-size:12px;margin-left:10px">男子标准：248cm以上优秀</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">综合评分：</td>
    <td colspan="5">
      <input type="number" name="info[zongfen]" id="zongfen" value="<?php echo $this->info['zongfen']?>" step="0.1" min="0" max="100"
             style="width:150px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入0-100分"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5">
      <textarea name="info[beizhu]" id="beizhu" rows="3"
                style="width:400px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
                placeholder="请输入备注"><?php echo $this->info['beizhu']?></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">录入时间：</td>
    <td colspan="5">
      <span style="color:#999;margin-left:5px;"><?php echo $this->info['inputtime_show']?></span>
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

</body>
</html>
