<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
parent.document.getElementById('display_center_id').style.display='none';
//-->
</SCRIPT>

<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<style>
.form-row { margin-bottom: 10px; }
.form-row label { display: inline-block; width: 130px; text-align: right; color: #bbd8f1; }
.form-row input[type="text"], .form-row input[type="number"], .form-row select {
    background: transparent; color: #fff; border: 1px solid #ddd; padding: 5px 8px; margin-left: 5px;
}
.form-row input[type="text"] { width: 200px; }
.form-row input[type="number"] { width: 100px; }
.form-row select { height: 28px; }
.section-title { color: #ffcc00; font-size: 14px; margin: 15px 0 10px 0; padding-bottom: 5px; border-bottom: 1px solid #3132a4; }
</style>

<form action="?m=peixunnew&c=hebeiganyuan_jilu&a=addsave" method="POST" name="myform" id="myform">

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">河北干院培训人次记录 <span style="color:#ffcc00;font-size:12px;margin-left:15px;">（只能添加民警）</span></div>

<div class="section-title">基本信息</div>

<div class="form-row">
    <label><span style="color:red">*</span>培训计划：</label>
    <select name="info[jihua_id]" id="jihua_id" required style="width:350px;">
        <option value="">请选择培训计划</option>
        <?php foreach($this->jihua_list as $jh): ?>
        <option value="<?php echo $jh['id']?>" data-bmid="<?php echo $jh['bmid']?>"><?php echo $jh['title']?></option>
        <?php endforeach; ?>
    </select>
    <span style="color:#999;font-size:12px;margin-left:10px;">只显示进行中的培训计划</span>
</div>

<div class="form-row">
    <label>系统部门：</label>
    <select name="info[bmid]" id="bmid" style="width:250px;">
        <option value="0">请选择</option>
        <?php echo $this->select_bumen?>
    </select>
</div>

<div class="form-row">
    <label><span style="color:red">*</span>参训民警：</label>
    <input type="text" id="minjing_search" name="minjing_search" value="" placeholder="输入姓名/账号搜索民警" autocomplete="off" style="width:250px;"/>
    <div id="minjing_inputlist" style="position:absolute;z-index:999;background-color:#28348e;border:1px solid #ccc;display:none;min-width:400px;max-height:300px;overflow-y:auto;">
        <ul style="list-style:none;padding:0;margin:0;"></ul>
    </div>
    <div id="selected_minjing" style="display:inline-block;margin-left:10px;"></div>
    <input type="hidden" name="info[mjid]" id="mjid" value="" />
    <input type="hidden" name="info[mjname]" id="mjname" value="" />
</div>

<div class="form-row">
    <label>登录名：</label>
    <input type="text" name="info[username]" id="username" value="" placeholder="河北干院系统登录名"/>
</div>

<div class="section-title">组织信息</div>

<div class="form-row">
    <label>所属组织：</label>
    <input type="text" name="info[suoshu_zuzhi]" id="suoshu_zuzhi" value="" style="width:300px;" placeholder="河北干院中的所属组织"/>
</div>

<div class="form-row">
    <label>所属部门：</label>
    <input type="text" name="info[suoshu_bumen]" id="suoshu_bumen" value="" style="width:300px;" placeholder="河北干院中的所属部门"/>
</div>

<div class="form-row">
    <label>职务级别：</label>
    <input type="text" name="info[zhiwu_jibie]" id="zhiwu_jibie" value="" placeholder="如：科员、副科等"/>
</div>

<div class="form-row">
    <label>用户组：</label>
    <input type="text" name="info[yonghu_zu]" id="yonghu_zu" value="" placeholder="河北干院用户组"/>
</div>

<div class="section-title">学时信息</div>

<div class="form-row">
    <label>共完成学时：</label>
    <input type="number" step="0.01" name="info[gong_xueshi]" id="gong_xueshi" value="0"/>
</div>

<div class="form-row">
    <label>在线选学学时：</label>
    <input type="number" step="0.01" name="info[zaixian_xueshi]" id="zaixian_xueshi" value="0"/>
</div>

<div class="form-row">
    <label>专题班已完成学时：</label>
    <input type="number" step="0.01" name="info[zhuanti_xueshi]" id="zhuanti_xueshi" value="0"/>
</div>

<div class="form-row">
    <label>专题班必学学时：</label>
    <input type="number" step="0.01" name="info[zhuanti_bixue_xueshi]" id="zhuanti_bixue_xueshi" value="0"/>
</div>

<div class="form-row">
    <label>专题班选学学时：</label>
    <input type="number" step="0.01" name="info[zhuanti_xuanxue_xueshi]" id="zhuanti_xuanxue_xueshi" value="0"/>
</div>

<div class="form-row">
    <label>专题班已完成课程：</label>
    <input type="number" name="info[zhuanti_kecheng]" id="zhuanti_kecheng" value="0"/>
</div>

<div class="form-row">
    <label>课程完成率：</label>
    <input type="text" name="info[kecheng_wancheng_lv]" id="kecheng_wancheng_lv" value="" placeholder="如：100%"/>
</div>

<div class="section-title">考核结果</div>

<div class="form-row">
    <label>考试结果：</label>
    <input type="text" name="info[kaoshi_jieguo]" id="kaoshi_jieguo" value="" placeholder="如：90分"/>
</div>

<div class="form-row">
    <label>是否通过：</label>
    <select name="info[is_tongguo]" id="is_tongguo" style="width:100px;">
        <option value="0">否</option>
        <option value="1">是</option>
    </select>
</div>

<div class="form-row">
    <label>是否提交作业：</label>
    <select name="info[is_tijiao_zuoye]" id="is_tijiao_zuoye" style="width:100px;">
        <option value="0">否</option>
        <option value="1">是</option>
    </select>
</div>

<div class="form-row">
    <label>是否结业：</label>
    <select name="info[is_jieye]" id="is_jieye" style="width:100px;">
        <option value="0">否</option>
        <option value="1">是</option>
    </select>
</div>

<div class="form-row" style="margin-top:20px;">
    <label></label>
    <input type="submit" name="dosubmit" id="dosubmit" value="保存" class="dialog" style="margin-right:10px;font-size:14px;" />
    <input type="button" value="返回" class="dialog" onclick="javascript:history.back();" />
</div>

</div>

<div class="clear"></div>
<div class="bk15"></div>

</div>

</form>

<script type="text/javascript">
$('#jihua_id').on('change', function() {
    var bmid = $(this).find('option:selected').data('bmid');
    if (bmid) {
        $('#bmid').val(bmid);
    }
});

$(function(){
    $("#minjing_search").bind("keyup click", function(){
        var searchVal = $(this).val().trim();
        if(searchVal == "") {
            $("#minjing_inputlist").hide();
            return;
        }

        $.ajax({
            url: 'index.php?m=peixunnew&c=hebeiganyuan_jilu&a=searchminjing',
            type: 'POST',
            data: {keyword: searchVal},
            dataType: 'json',
            success: function(res) {
                var _html = "";
                if(res.status == 1 && res.data && res.data.length > 0) {
                    for(var i = 0; i < res.data.length; i++) {
                        var item = res.data[i];
                        _html += "<li data-id='" + item.id + "' data-name='" + item.xingming + "' data-bmid='" + item.bmid + "' data-username='" + (item.username||'') + "' "
                               + "style='line-height:30px;font-size:14px;padding:5px 10px;cursor:pointer;white-space:nowrap;'>"
                               + item.xingming + " [" + (item.username || '') + ", " + (item.danwei || '') + "]</li>";
                    }
                    $("#minjing_inputlist ul").html(_html);
                    $("#minjing_inputlist").show();
                } else {
                    $("#minjing_inputlist ul").html("<li style='color:#999;padding:5px 10px;'>未找到匹配的民警</li>");
                    $("#minjing_inputlist").show();
                }
            }
        });
    });

    $(document).delegate("#minjing_inputlist ul li", "click", function(){
        var id = $(this).attr("data-id");
        var name = $(this).attr("data-name");
        var bmid = $(this).attr("data-bmid");
        var username = $(this).attr("data-username");

        if(id && name) {
            $('#mjid').val(id);
            $('#mjname').val(name);
            $('#username').val(username);
            $('#selected_minjing').html('<span style="background:#3e4095;padding:3px 8px;border-radius:3px;color:#00ff00;">'
                  + '[民警] ' + name + '</span> <a href="javascript:void(0)" id="clear_minjing" style="color:#ff6666;text-decoration:none;font-weight:bold;">×</a>');
            if(bmid && !$('#bmid').val()) {
                $('#bmid').val(bmid);
            }
            $("#minjing_search").val("");
            $("#minjing_inputlist").hide();
        }
    });

    $(document).delegate("#clear_minjing", "click", function(){
        $('#mjid').val('');
        $('#mjname').val('');
        $('#selected_minjing').html('');
    });

    $(document).click(function(e){
        if(!$(e.target).closest('#minjing_search, #minjing_inputlist').length) {
            $("#minjing_inputlist").hide();
        }
    });

    $(document).delegate("#minjing_inputlist ul li", "mouseover", function(){
        $(this).css('background', '#E0E0E8').css('color', '#28348e');
    }).delegate("#minjing_inputlist ul li", "mouseout", function(){
        $(this).css('background', 'transparent').css('color', '#fff');
    });
});
</script>

</body>
</html>
