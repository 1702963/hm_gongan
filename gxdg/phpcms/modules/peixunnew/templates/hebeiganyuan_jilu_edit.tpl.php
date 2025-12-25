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

<form action="?m=peixunnew&c=hebeiganyuan_jilu&a=editsave" method="POST" name="myform" id="myform">
<input type="hidden" name="id" value="<?php echo $this->info['id']?>" />

<div class="tableContent">

<div class="tabcon">
<div class="title" style="width:auto;">编辑河北干院培训人次记录</div>

<div class="section-title">基本信息</div>

<div class="form-row">
    <label>培训计划：</label>
    <select name="info[jihua_id]" id="jihua_id" style="width:350px;">
        <option value="">请选择培训计划</option>
        <?php foreach($this->jihua_list as $jh): ?>
        <option value="<?php echo $jh['id']?>" <?php echo $this->info['jihua_id'] == $jh['id'] ? 'selected' : ''?>><?php echo $jh['title']?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-row">
    <label>系统部门：</label>
    <select name="info[bmid]" id="bmid" style="width:250px;">
        <option value="0">请选择</option>
        <?php echo $this->select_bumen?>
    </select>
</div>

<div class="form-row">
    <label>参训民警：</label>
    <span style="color:#00ff00;margin-left:5px;">[民警] <?php echo $this->info['mjname']?></span>
    <span style="color:#999;font-size:12px;margin-left:10px;">(人员不可修改)</span>
</div>

<div class="form-row">
    <label>登录名：</label>
    <input type="text" name="info[username]" id="username" value="<?php echo htmlspecialchars($this->info['username'])?>" placeholder="河北干院系统登录名"/>
</div>

<div class="section-title">组织信息</div>

<div class="form-row">
    <label>所属组织：</label>
    <input type="text" name="info[suoshu_zuzhi]" id="suoshu_zuzhi" value="<?php echo htmlspecialchars($this->info['suoshu_zuzhi'])?>" style="width:300px;"/>
</div>

<div class="form-row">
    <label>所属部门：</label>
    <input type="text" name="info[suoshu_bumen]" id="suoshu_bumen" value="<?php echo htmlspecialchars($this->info['suoshu_bumen'])?>" style="width:300px;"/>
</div>

<div class="form-row">
    <label>职务级别：</label>
    <input type="text" name="info[zhiwu_jibie]" id="zhiwu_jibie" value="<?php echo htmlspecialchars($this->info['zhiwu_jibie'])?>"/>
</div>

<div class="form-row">
    <label>用户组：</label>
    <input type="text" name="info[yonghu_zu]" id="yonghu_zu" value="<?php echo htmlspecialchars($this->info['yonghu_zu'])?>"/>
</div>

<div class="section-title">学时信息</div>

<div class="form-row">
    <label>共完成学时：</label>
    <input type="number" step="0.01" name="info[gong_xueshi]" id="gong_xueshi" value="<?php echo $this->info['gong_xueshi']?>"/>
</div>

<div class="form-row">
    <label>在线选学学时：</label>
    <input type="number" step="0.01" name="info[zaixian_xueshi]" id="zaixian_xueshi" value="<?php echo $this->info['zaixian_xueshi']?>"/>
</div>

<div class="form-row">
    <label>专题班已完成学时：</label>
    <input type="number" step="0.01" name="info[zhuanti_xueshi]" id="zhuanti_xueshi" value="<?php echo $this->info['zhuanti_xueshi']?>"/>
</div>

<div class="form-row">
    <label>专题班必学学时：</label>
    <input type="number" step="0.01" name="info[zhuanti_bixue_xueshi]" id="zhuanti_bixue_xueshi" value="<?php echo $this->info['zhuanti_bixue_xueshi']?>"/>
</div>

<div class="form-row">
    <label>专题班选学学时：</label>
    <input type="number" step="0.01" name="info[zhuanti_xuanxue_xueshi]" id="zhuanti_xuanxue_xueshi" value="<?php echo $this->info['zhuanti_xuanxue_xueshi']?>"/>
</div>

<div class="form-row">
    <label>专题班已完成课程：</label>
    <input type="number" name="info[zhuanti_kecheng]" id="zhuanti_kecheng" value="<?php echo $this->info['zhuanti_kecheng']?>"/>
</div>

<div class="form-row">
    <label>课程完成率：</label>
    <input type="text" name="info[kecheng_wancheng_lv]" id="kecheng_wancheng_lv" value="<?php echo htmlspecialchars($this->info['kecheng_wancheng_lv'])?>"/>
</div>

<div class="section-title">考核结果</div>

<div class="form-row">
    <label>考试结果：</label>
    <input type="text" name="info[kaoshi_jieguo]" id="kaoshi_jieguo" value="<?php echo htmlspecialchars($this->info['kaoshi_jieguo'])?>"/>
</div>

<div class="form-row">
    <label>是否通过：</label>
    <select name="info[is_tongguo]" id="is_tongguo" style="width:100px;">
        <option value="0" <?php echo $this->info['is_tongguo'] == 0 ? 'selected' : ''?>>否</option>
        <option value="1" <?php echo $this->info['is_tongguo'] == 1 ? 'selected' : ''?>>是</option>
    </select>
</div>

<div class="form-row">
    <label>是否提交作业：</label>
    <select name="info[is_tijiao_zuoye]" id="is_tijiao_zuoye" style="width:100px;">
        <option value="0" <?php echo $this->info['is_tijiao_zuoye'] == 0 ? 'selected' : ''?>>否</option>
        <option value="1" <?php echo $this->info['is_tijiao_zuoye'] == 1 ? 'selected' : ''?>>是</option>
    </select>
</div>

<div class="form-row">
    <label>是否结业：</label>
    <select name="info[is_jieye]" id="is_jieye" style="width:100px;">
        <option value="0" <?php echo $this->info['is_jieye'] == 0 ? 'selected' : ''?>>否</option>
        <option value="1" <?php echo $this->info['is_jieye'] == 1 ? 'selected' : ''?>>是</option>
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

</body>
</html>
