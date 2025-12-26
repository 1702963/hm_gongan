<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');?>
<SCRIPT LANGUAGE="JavaScript">
<!--
parent.document.getElementById('display_center_id').style.display='none';
//-->
</SCRIPT>
<style type="text/css">
body, html {
    background: #1a2550 !important;
    background-attachment: fixed !important;
}

/* 主容器 */
.addContent {
    background: transparent !important;
    border: none;
    border-radius: 0;
    padding: 20px;
    margin: 0 auto;
    max-width: 1400px;
    box-shadow: none;
    backdrop-filter: none;
}

.crumbs {
    color: #bbd8f1;
    font-size: 14px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(49, 50, 164, 0.5);
}

/* 左右列样式 */
.col-right {
    display: none !important;
}
.col-auto {
    background: transparent !important;
    border: none;
    border-radius: 0;
    padding: 15px 0;
    margin-bottom: 15px;
    width: 100% !important;
    float: none !important;
}

.col-1 {
    background: transparent !important;
}

.content {
    background: transparent !important;
    color: #fff;
}

.content h6 {
    color: #bbd8f1;
    font-size: 13px;
    margin-top: 15px;
    margin-bottom: 8px;
    padding-bottom: 5px;
    border-bottom: 1px solid rgba(49, 50, 164, 0.3);
    font-weight: bold;
}

/* 表单样式 */
.table_form {
    background: transparent !important;
    border: none !important;
    width: 100% !important;
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
    text-align: right;
    padding-right: 15px;
    font-weight: bold;
    font-size: 12px;
    white-space: nowrap;
}

.table_form td {
    background: transparent !important;
    border: none !important;
    border-bottom: 1px solid #3132a4 !important;
    padding: 8px 0;
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
.fixed-bottom {
    background: transparent !important;
    border-top: none;
    padding: 25px 0;
    margin-top: 20px;
    border-radius: 0;
}

.fixed-but {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.button {
    display: inline-block;
    padding: 0 !important;
}

.cu {
    background: transparent !important;
    color: #2d5db9 !important;
    border: 1px solid #2d5db9 !important;
    border-radius: 5px !important;
    padding: 0 !important;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px !important;
    font-weight: 500 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    height: 32px !important;
    min-width: 100px !important;
    width: 130px !important;
    text-align: center !important;
}

.cu:hover {
    background: rgba(45, 93, 185, 0.1) !important;
    border-color: #3d6dd9 !important;
    color: #3d6dd9 !important;
    box-shadow: 0 0 8px rgba(45, 93, 185, 0.3) !important;
}

/* 展开/关闭按钮 - 隐藏 */
.r-close, .r-open, #RopenClose {
    display: none !important;
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

<?php if(!$can_edit) { ?>
/* 只读模式样式 */
.table_form input[type=text],
.table_form input[type=password],
.table_form input[type=email],
.table_form textarea,
.table_form select {
    pointer-events: none !important;
    opacity: 0.7 !important;
}
.table_form input[type=checkbox],
.table_form input[type=radio] {
    pointer-events: none !important;
}
<?php } ?>
</style>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
	var charset = '<?php echo CHARSET;?>';
	var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';
//-->
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript">var catid=<?php echo $catid;?></script>
<form name="myform" id="myform" action="?m=content&c=content&a=edit" method="post" enctype="multipart/form-data">
<div class="addContent">
<div class="crumbs"><?php echo L('edit_content_position');?></div>
<?php if(!$can_edit) { ?>
<div style="background:#ff6b6b;color:#fff !important;padding:10px 15px;margin-bottom:15px;border-radius:3px;">
    <strong style="color:#fff !important;">提示：</strong><span style="color:#fff !important;">当前为只读模式，无法编辑。</span>
</div>
<?php } ?>
<div class="col-right">
    	<div class="col-1">
        	<div class="content pad-6">
<?php
if(is_array($forminfos['senior'])) {
 foreach($forminfos['senior'] as $field=>$info) {
	if($info['isomnipotent']) continue;
	if($info['formtype']=='omnipotent') {
		foreach($forminfos['base'] as $_fm=>$_fm_value) {
			if($_fm_value['isomnipotent']) {
				$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
			}
		}
		foreach($forminfos['senior'] as $_fm=>$_fm_value) {
			if($_fm_value['isomnipotent']) {
				$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
			}
		}
	}
 ?>
	<h6><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <?php echo $info['name']?></h6>
	 <?php
	 if($info['formtype']=='editor') {
		 preg_match('/<textarea[^>]*>.*?<\/textarea>/s', $info['form'], $matches);
		 if($matches[0]) {
			 $textarea = preg_replace('/style="[^"]*"/', '', $matches[0]);
			 $textarea = str_replace('<textarea', '<textarea style="width:100%;min-height:300px;background:rgba(10,20,50,0.8);border:1px solid #3132a4;color:#fff;padding:10px;border-radius:3px;font-size:14px;line-height:1.6;resize:vertical;"', $textarea);
			 echo $textarea;
		 }
	 } else {
		 echo $info['form'];
	 }
	 ?><?php echo $info['tips']?>
<?php
} }
?>
          </div>
        </div>
    </div>
    <a title="展开与关闭" class="r-close" hidefocus="hidefocus" style="outline-style: none; outline-width: medium;" id="RopenClose" href="javascript:;"><span class="hidden">展开</span></a>
    <div class="col-auto">
    	<div class="col-1">
        	<div class="content pad-6">
<table width="100%" cellspacing="0" class="table_form">
	<tbody>	
<?php
if(is_array($forminfos['base'])) {
 foreach($forminfos['base'] as $field=>$info) {
	if($info['isomnipotent']) continue;
	if($info['formtype']=='omnipotent') {
		foreach($forminfos['base'] as $_fm=>$_fm_value) {
			if($_fm_value['isomnipotent']) {
				$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
			}
		}
		foreach($forminfos['senior'] as $_fm=>$_fm_value) {
			if($_fm_value['isomnipotent']) {
				$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
			}
		}
	}
 ?>
	<tr>
      <th width="80"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <?php echo $info['name']?>
	  </th>
      <td><?php
	  if($info['formtype']=='editor') {
		  preg_match('/<textarea[^>]*>.*?<\/textarea>/s', $info['form'], $matches);
		  if($matches[0]) {
			  $textarea = preg_replace('/style="[^"]*"/', '', $matches[0]);
			  $textarea = str_replace('<textarea', '<textarea style="width:100%;min-height:300px;background:rgba(10,20,50,0.8);border:1px solid #3132a4;color:#fff;padding:10px;border-radius:3px;font-size:14px;line-height:1.6;resize:vertical;"', $textarea);
			  echo $textarea;
		  }
	  } else {
		  echo $info['form'];
	  }
	  ?>  <?php echo $info['tips']?></td>
    </tr>
<?php
} }
?>
	<tr>
      <th width="80">一级审批人</th>
      <td>
        <span style="color:#bbd8f1;font-size:14px;"><?php echo $level1_name ? $level1_name : '未设置';?></span>
        <?php if($level1_status == 1) { ?>
        <span style="color:#4CAF50;margin-left:10px;">【已通过】</span>
        <?php } elseif($level1_status == 2) { ?>
        <span style="color:#ff6b6b;margin-left:10px;">【已拒绝】</span>
        <?php } else { ?>
        <span style="color:#ff9800;margin-left:10px;">【待审批】</span>
        <?php } ?>
      </td>
    </tr>
	<tr>
      <th width="80">二级审批人</th>
      <td>
        <span style="color:#bbd8f1;font-size:14px;"><?php echo $level2_name ? $level2_name : '未设置';?></span>
        <?php if($level2_status == 1) { ?>
        <span style="color:#4CAF50;margin-left:10px;">【已通过】</span>
        <?php } elseif($level2_status == 2) { ?>
        <span style="color:#ff6b6b;margin-left:10px;">【已拒绝】</span>
        <?php } else { ?>
        <span style="color:#ff9800;margin-left:10px;">【待审批】</span>
        <?php } ?>
      </td>
    </tr>
    <?php if($show_level1_approval) { ?>
    <tr>
      <th width="80">一级审批</th>
      <td>
        <label style="color:#fff;margin-right:20px;cursor:pointer;">
          <input type="radio" name="approval_action" value="1" style="margin-right:5px;"> 通过
        </label>
        <label style="color:#fff;cursor:pointer;">
          <input type="radio" name="approval_action" value="2" style="margin-right:5px;"> 拒绝
        </label>
        <input type="hidden" name="approval_level" value="1" />
      </td>
    </tr>
    <?php } ?>
    <?php if($is_level2_approver && $level1_status == 1 && $level2_status == 0) { ?>
    <tr>
      <th width="80">二级审批</th>
      <td>
        <label style="color:#fff;margin-right:20px;cursor:pointer;">
          <input type="radio" name="approval_action" value="1" style="margin-right:5px;"> 通过
        </label>
        <label style="color:#fff;cursor:pointer;">
          <input type="radio" name="approval_action" value="2" style="margin-right:5px;"> 拒绝
        </label>
        <input type="hidden" name="approval_level" value="2" />
      </td>
    </tr>
    <?php } elseif($is_level2_approver && $level1_status != 1 && $level2_status == 0) { ?>
    <tr>
      <th width="80">二级审批</th>
      <td><span style="color:#ff9800;font-size:14px;">待一级审批员审批</span></td>
    </tr>
    <?php } ?>

    </tbody></table>
                </div>
        	</div>
        </div>
        
    </div>
</div>
<div class="fixed-bottom">
	<div class="fixed-but text-c">
	<input value="<?php if($r['upgrade']) echo $r['url'];?>" type="hidden" name="upgrade">
	<input value="<?php echo $id;?>" type="hidden" name="id">
	<?php if($can_edit) { ?>
    <div class="button"><input value="<?php echo L('save_close');?>" type="submit" name="dosubmit" class="cu" onclick="refersh_window()"></div>
    <div class="button"><input value="<?php echo L('save_continue');?>" type="submit" name="dosubmit_continue" class="cu" onclick="refersh_window()"></div>
    <?php } elseif($show_level1_approval || $show_level2_approval) { ?>
    <div class="button"><input value="提交审批" type="submit" name="dosubmit" class="cu" onclick="refersh_window()"></div>
    <?php } ?>
    <div class="button"><input value="<?php echo L('c_close');?>" type="button" name="close" onclick="refersh_window();close_window();" class="cu" title="Alt+X"></div>
      </div>
</div>
</form>

</body>
</html>
<script type="text/javascript"> 
<!--
//只能放到最下面
var openClose = $("#RopenClose"), rh = $(".addContent .col-auto").height(),colRight = $(".addContent .col-right"),valClose = getcookie('openClose');
$(function(){
	if(valClose==1){
		colRight.hide();
		openClose.addClass("r-open");
		openClose.removeClass("r-close");
	}else{
		colRight.show();
	}
	openClose.height(rh);
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, 	function(){$(obj).focus();
	boxid = $(obj).attr('id');
	if($('#'+boxid).attr('boxid')!=undefined) {
		check_content(boxid);
	}
	})}});
	<?php echo $formValidator;?>
	
/*
 * 加载禁用外边链接
 */
	jQuery(document).bind('keydown', 'Alt+x', function (){close_window();});
})
document.title='<?php echo L('edit_content').addslashes($data['title']);?>';
self.moveTo(0, 0);
function refersh_window() {
	setcookie('refersh_time', 1);
}
openClose.click(
	  function (){
		if(colRight.css("display")=="none"){
			setcookie('openClose',0,1);
			openClose.addClass("r-close");
			openClose.removeClass("r-open");
			colRight.show();
		}else{
			openClose.addClass("r-open");
			openClose.removeClass("r-close");
			colRight.hide();
			setcookie('openClose',1,1);
		}
	}
)
//-->
</script>