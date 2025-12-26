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

<form action="?m=peixunnew&c=nengli_zhengshu&a=editsave" method="POST" name="myform" id="myform">
<input type="hidden" name="id" value="<?php echo $this->info['id']?>" />

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">个人证书编辑</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="120" align="right" class="infotitle"><span style="color:red">*</span>辅警：</td>
    <td colspan="5">
      <input type="text" id="fjing_search" name="fjing_search" value="<?php echo htmlspecialchars($this->info['fjname'])?>"
             style="width:300px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px"
             placeholder="请输入姓名搜索辅警" autocomplete="off" readonly />

      <div id="fjing_inputlist" style="position:absolute;z-index:999;background-color:#28348e;border:1px solid #ccc;display:none;min-width:320px;max-height:260px;overflow-y:auto;">
        <ul style="list-style:none;padding:0;margin:0;"></ul>
      </div>

      <input type="hidden" name="info[fjid]" id="fjid" value="<?php echo intval($this->info['fjid'])?>" />
      <input type="hidden" name="info[fjname]" id="fjname" value="<?php echo htmlspecialchars($this->info['fjname'])?>" />
      <input type="hidden" name="info[bmid]" id="bmid" value="<?php echo intval($this->info['bmid'])?>" />

      <div id="fjing_info_display" style="margin-top:10px;margin-left:5px;line-height:22px;color:#cde4ff;">加载中...</div>
      <span style="color:#999;font-size:12px;margin-left:10px">已选辅警，编辑页不可修改</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>证书类型：</td>
    <td colspan="5">
      <select name="info[type_id]" id="type_id" required
              style="width:300px;height:28px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;">
        <option value="">请选择证书类型</option>
        <?php foreach($this->type_list as $t): ?>
        <option value="<?php echo $t['id']?>" <?php echo $this->info['type_id'] == $t['id'] ? 'selected' : ''?>><?php echo htmlspecialchars($t['typename'])?></option>
        <?php endforeach; ?>
      </select>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>证书编号：</td>
    <td colspan="5">
      <input type="text" name="info[zhengshu_no]" id="zhengshu_no" value="<?php echo htmlspecialchars($this->info['zhengshu_no'])?>"
             style="width:300px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入证书编号"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>发证机构：</td>
    <td colspan="5">
      <input type="text" name="info[jigou]" id="jigou" value="<?php echo htmlspecialchars($this->info['jigou'])?>"
             style="width:300px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入发证机构"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>获得时间：</td>
    <td colspan="5">
      <input type="date" name="info[huode_time]" id="huode_time" value="<?php echo htmlspecialchars($this->info['huode_time'])?>"
             style="width:200px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle"><span style="color:red">*</span>有效期开始：</td>
    <td colspan="5">
      <input type="date" name="info[youxiao_start]" id="youxiao_start" value="<?php echo htmlspecialchars($this->info['youxiao_start'])?>"
             style="width:200px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
      <span style="color:#999;font-size:12px;margin-left:10px;">开始日期必填</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">有效期结束：</td>
    <td colspan="5">
      <input type="date" name="info[youxiao_end]" id="youxiao_end" value="<?php echo htmlspecialchars($this->info['youxiao_end'])?>"
             style="width:200px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"/>
      <span style="color:#999;font-size:12px;margin-left:10px;">为空表示长期有效</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">等级：</td>
    <td colspan="5">
      <input type="text" name="info[dengji]" id="dengji" value="<?php echo htmlspecialchars($this->info['dengji'])?>"
             style="width:200px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入等级"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">成绩：</td>
    <td colspan="5">
      <input type="text" name="info[chengji]" id="chengji" value="<?php echo htmlspecialchars($this->info['chengji'])?>"
             style="width:200px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="请输入成绩"/>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">附件：</td>
    <td colspan="5">
      <input type="text" name="info[files]" id="files" value="<?php echo htmlspecialchars($this->info['files'])?>"
             style="width:400px;height:20px;background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px"
             placeholder="可填写附件路径或说明"/>
      <span style="color:#999;font-size:12px;margin-left:10px;">后续可替换为上传</span>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">备注：</td>
    <td colspan="5">
      <textarea name="info[beizhu]" id="beizhu" rows="4" cols="60"
                style="background:#1a2a4a;color:#fff;border:1px solid #ddd;margin-left:5px;padding:5px;"
                placeholder="请输入备注"><?php echo htmlspecialchars($this->info['beizhu'])?></textarea>
    </td>
  </tr>

  <tr>
    <td align="right" class="infotitle">状态：</td>
    <td colspan="5" style="padding-left:5px;">
      <label style="margin-right:15px;"><input type="radio" name="info[status]" value="1" <?php echo $this->info['status']==1 ? 'checked' : ''?> /> 有效</label>
      <label><input type="radio" name="info[status]" value="0" <?php echo $this->info['status']==0 ? 'checked' : ''?> /> 失效</label>
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
    // 编辑页默认不允许切换辅警，但加载详细信息
    var initFjid = $("#fjid").val();
    if(initFjid) {
        loadFujingInfo(initFjid);
    } else {
        $("#fjing_info_display").html("未选择辅警");
    }
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
