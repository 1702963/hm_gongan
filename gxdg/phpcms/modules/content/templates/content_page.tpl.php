<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');?>
<div id="closeParentTime" style="display:none"></div>
<SCRIPT LANGUAGE="JavaScript">
<!--
if(window.top.$("#current_pos").data('clicknum')==1) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?m=content&c=content&a=public_categorys&type=add&menuid=<?php echo $_GET['menuid'];?>';
	window.top.$("#current_pos").data('clicknum',0);
}
$(document).ready(function(){
	setInterval(closeParent,3000);
});
function closeParent() {
	if($('#closeParentTime').html() == '') {
		window.top.$(".left_menu").addClass("left_menu_on");
		window.top.$("#openClose").addClass("close");
		window.top.$("html").addClass("on");
		$('#closeParentTime').html('1');
		window.top.$("#openClose").data('clicknum',1);
	}
}
//-->
</SCRIPT>
<style type="text/css">
body, html {
    background: #1a2550 !important;
    background-attachment: fixed !important;
}

/* 页面容器样式 */
.pad-lr-10, .pad-10 {
    background: transparent !important;
    border: none;
    border-radius: 0;
    margin: 0 auto;
    max-width: 1400px;
    padding: 20px !important;
}

.content-menu {
    background: transparent !important;
    border: none;
    border-radius: 0;
    padding: 10px 0 !important;
    margin-bottom: 15px !important;
}

.content-menu a {
    color: #bbd8f1 !important;
}

.content-menu a:hover {
    color: #fff !important;
}

/* 表单样式 */
.table_form {
    background: transparent !important;
    border: none !important;
    border-radius: 0;
    overflow: hidden;
}

.table_form tr {
    background: transparent !important;
    border-bottom: 1px solid #3132a4 !important;
}

.table_form th {
    background: transparent !important;
    color: #bbd8f1;
    border: none !important;
    border-bottom: 1px solid #3132a4 !important;
    padding: 10px 0 !important;
    font-weight: bold;
    white-space: nowrap;
}

.table_form td {
    background: transparent !important;
    color: #fff;
    border: none !important;
    border-bottom: 1px solid #3132a4 !important;
    padding: 8px 0 !important;
    white-space: nowrap;
}

.table_form input[type=text],
.table_form input[type=password],
.table_form input[type=email],
.table_form textarea,
.table_form select {
    background: rgba(10, 20, 50, 0.8) !important;
    border: 1px solid #3132a4 !important;
    color: #fff !important;
    border-radius: 3px;
    padding: 6px 8px;
}

.table_form input[type=text]:focus,
.table_form textarea:focus,
.table_form select:focus {
    border-color: #bbd8f1 !important;
    box-shadow: 0 0 8px rgba(187, 216, 241, 0.3) !important;
}

/* 按钮样式 */
.bk10 {
    clear: both;
}

.btn {
    background: transparent !important;
    border: none;
    border-radius: 0;
    padding: 25px 0 !important;
    margin-top: 15px !important;
    text-align: center;
}

.btn input[type=submit],
.btn input[type=button] {
    background: transparent !important;
    color: #2d5db9 !important;
    border: 1px solid #2d5db9 !important;
    border-radius: 5px !important;
    padding: 0 !important;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px !important;
    font-weight: 500 !important;
    margin-right: 12px;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    height: 32px !important;
    min-width: 100px !important;
    width: 130px !important;
    text-align: center !important;
}

.btn input[type=submit]:hover,
.btn input[type=button]:hover {
    background: rgba(45, 93, 185, 0.1) !important;
    border-color: #3d6dd9 !important;
    color: #3d6dd9 !important;
    box-shadow: 0 0 8px rgba(45, 93, 185, 0.3) !important;
}

/* 图片上传容器背景 */
.box_shadow, .box_border {
    background: rgba(20, 30, 80, 0.6) !important;
    border: 1px solid #3132a4 !important;
}

/* 图片预览区域 */
#picklist, .picklist {
    background: rgba(15, 25, 60, 0.8) !important;
    border: 1px solid #3132a4 !important;
}

/* 按钮组 */
.button_group {
    background: rgba(20, 30, 80, 0.6) !important;
}

</style>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<div class="pad-lr-10">
<div class="pad-10">
<div class="content-menu ib-a blue line-x"><a href="javascript:;" class=on><em><?php echo L('page_manage');?></em></a><span>|</span> <a href="<?php if(strpos($category['url'],'http://')===false) echo siteurl($this->siteid);echo $category['url'];?>" target="_blank"><em><?php echo L('click_vistor');?></em></a> <span>|</span> <a href="?m=block&c=block_admin&a=public_visualization&catid=<?php echo $catid;?>&type=page"><em><?php echo L('visualization_edit');?></em></a> 
</div>
</div>

<form name="myform" action="?m=content&c=content&a=add" method="post" enctype="multipart/form-data">
<div class="pad_10">
<div style='overflow-y:auto;overflow-x:hidden' class='scrolltable'>
<table width="100%" cellspacing="0" class="table_form contentWrap">
<tr>
	 <th width="80"> <?php echo L('title');?>	  </th>
      <td><input type="text" style="width:400px;" name="info[title]" id="title" value="<?php echo $title?>" style="color:<?php echo $style;?>" class="measure-input " onBlur="$.post('api.php?op=get_keywords&number=3&sid='+Math.random()*5, {data:$('#title').val()}, function(data){if(data && $('#keywords').val()=='') $('#keywords').val(data); })"/>
		<input type="hidden" name="style_color" id="style_color" value="<?php echo $style_color;?>">
		<input type="hidden" name="style_font_weight" id="style_font_weight" value="<?php echo $style_font_weight;?>">
		<img src="statics/images/icon/colour.png" width="15" height="16" onclick="colorpicker('title_colorpanel','set_title_color');" style="cursor:hand"/> 
		<img src="statics/images/icon/bold.png" width="10" height="10" onclick="input_font_bold()" style="cursor:hand"/> <span id="title_colorpanel" style="position:absolute; z-index:200" class="colorpanel"></span>  </td>
    </tr>
<tr>
      <th width="80"> <?php echo L('keywords');?>	  </th>
      <td><input type="text" name="info[keywords]" id="keywords" value="<?php echo $keywords?>" size="50">  <?php echo L('explode_keywords');?></td>
    </tr>

<tr>
 <th width="80"> <?php echo L('content');?>	  </th>
<td>
<textarea name="info[content]" id="content" style="width:100%; min-height:400px; background:rgba(10,20,50,0.8); border:1px solid #3132a4; color:#fff; padding:10px; border-radius:3px; font-size:14px; line-height:1.6; resize:vertical;"><?php echo $content?></textarea>
</td></tr>
</table>
</div>
<div class="bk10"></div>
<div class="btn">
<input type="hidden" name="info[catid]" value="<?php echo $catid;?>" />
<input type="hidden" name="edit" value="<?php echo $title ? 1 : 0;?>" />
<input type="submit" class="button" name="dosubmit" value="<?php echo L('submit');?>" />
</div> 
  </div>

</form>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="JavaScript">
<!--
	window.top.$('#display_center_id').css('display','none');
//-->
</script>
</body>
</html>