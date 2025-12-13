<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');?>

<link rel="stylesheet" href="<?php echo CSS_PATH;?>jquery.treeview.css" type="text/css" />
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.treeview.js"></script>
<?php if($ajax_show) {?>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.treeview.async.js"></script>
<?php }?>
<SCRIPT LANGUAGE="JavaScript">
<!--

$(document).ready(function(){
    $("#category_tree").treeview({
			control: "#treecontrol",
			persist: "cookie",
			cookieId: "treeview-black"
	});
});

function open_list(obj) {

	window.top.$("#current_pos_attr").html($(obj).html());
}

//-->
</SCRIPT>
 <style type="text/css">
.filetree *{white-space:nowrap;}
.filetree span.folder, .filetree span.file{display:auto;padding:1px 0 1px 16px;}
.filetree span.folder {color:#eee}
.filetree span a {width:100%; height:20px;line-height:18px; display:block;  transition: all .3s ease-in-out; text-indent:5px;}
.filetree span a:hover {background:#05ac58; text-indent:12px}
 </style>
 <div id="treeContent">
 	<img src="statics/images/admin_img/2025/bumenTreeTitle.png" style="margin-bottom:8px" />
 	<div id="treeContentMain">
 <div id="treecontrol">
 <span style="display:none">
		<a href="#"></a>
		<a href="#"></a>
		</span>
		<a href="#"><img src="<?php echo IMG_PATH;?>minus.gif" /> <img src="<?php echo IMG_PATH;?>application_side_expand.png" /> 展开/收缩</a>
</div>

<?php  echo $categorys; ?>
</div>
</div>
</body>
</html>