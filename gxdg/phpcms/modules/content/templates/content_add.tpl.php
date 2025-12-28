<?php
defined('IN_ADMIN') or exit('No permission resources.');$addbg=1;
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
<form name="myform" id="myform" action="?m=content&c=content&a=add" method="post" enctype="multipart/form-data">
<div class="addContent">
<div class="crumbs"><?php echo L('add_content_position');?></div>
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
<?php if($_SESSION['roleid']==1 || $priv_status) {?>
<h6><?php echo L('c_status');?></h6>
<span class="ib" style="width:90px"><label><input type="radio" name="status" value="99" checked/> <?php echo L('c_publish');?> </label></span>
<?php if($workflowid) { ?><label><input type="radio" name="status" value="1" > <?php echo L('c_check');?> </label><?php }?>
<?php }?>
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
		  // 只输出textarea，不要富文本编辑器
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
	<!-- 审批人选择 -->
	<tr>
      <th width="80">一级审批人</th>
      <td>
        <input type="text" id="level1_search" value="" autocomplete="off"
               style="width:200px;height:26px;background:rgba(10,20,50,0.8);color:#fff;border:1px solid #3132a4;padding:0 8px;"
               placeholder="输入姓名搜索"/>
        <div id="level1_list" style="position:absolute;z-index:999;background:#28348e;border:1px solid #3132a4;display:none;min-width:200px;max-height:200px;overflow-y:auto;">
          <ul style="list-style:none;padding:0;margin:0;"></ul>
        </div>
        <span id="level1_selected" style="margin-left:10px;color:#bbd8f1;"></span>
        <a href="javascript:void(0)" id="level1_clear" style="color:#ff6666;margin-left:5px;display:none;">×</a>
        <input type="hidden" name="info[level1_user]" id="level1_user" value="0" />
      </td>
    </tr>
    <tr>
      <th width="80">二级审批人</th>
      <td>
        <input type="text" id="level2_search" value="" autocomplete="off"
               style="width:200px;height:26px;background:rgba(10,20,50,0.8);color:#fff;border:1px solid #3132a4;padding:0 8px;"
               placeholder="输入姓名搜索"/>
        <div id="level2_list" style="position:absolute;z-index:999;background:#28348e;border:1px solid #3132a4;display:none;min-width:200px;max-height:200px;overflow-y:auto;">
          <ul style="list-style:none;padding:0;margin:0;"></ul>
        </div>
        <span id="level2_selected" style="margin-left:10px;color:#bbd8f1;"></span>
        <a href="javascript:void(0)" id="level2_clear" style="color:#ff6666;margin-left:5px;display:none;">×</a>
        <input type="hidden" name="info[level2_user]" id="level2_user" value="0" />
      </td>
    </tr>

    </tbody></table>
                </div>
        	</div>
        </div>
        
    </div>
</div>

<div class="fixed-bottom">
	<div class="fixed-but text-c">
    <div class="button"><input value="<?php echo L('save_close');?>" type="submit" name="dosubmit" class="cu" style="width:145px;" onclick="refersh_window()"></div>
    <div class="button"><input value="<?php echo L('save_continue');?>" type="submit" name="dosubmit_continue" class="cu" style="width:130px;" title="Alt+X" onclick="refersh_window()"></div>
    <div class="button"><input value="<?php echo L('c_close');?>" type="button" name="close" onclick="refersh_window();close_window();" class="cu" style="width:70px;"></div>
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
	// 隐藏截取内容选项行
	$('input[name="add_introduce"]').closest('div').hide();
	$('input[name="add_introduce"]').parent().hide();
	$('input[name="auto_thumb"]').parent().hide();

	if(valClose==1){
		colRight.hide();
		openClose.addClass("r-open");
		openClose.removeClass("r-close");
	}else{
		colRight.show();
	}
	openClose.height(rh);
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({id:'check_content_id',content:msg,lock:true,width:'200',height:'50'}, 	function(){$(obj).focus();
	boxid = $(obj).attr('id');
	if($('#'+boxid).attr('boxid')!=undefined) {
		check_content(boxid);
	}
	})}});
	<?php echo $formValidator;?>
	
/*
 * 加载禁用外边链接
 */

	$('#linkurl').attr('disabled',true);
	$('#islink').attr('checked',false);
	$('.edit_content').hide();
	jQuery(document).bind('keydown', 'Alt+x', function (){close_window();});
})
document.title='<?php echo L('add_content');?>';
self.moveTo(-4, -4);
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

// 审批人搜索选择功能
function initApprovalSearch(level) {
    var searchInput = $('#level' + level + '_search');
    var listDiv = $('#level' + level + '_list');
    var selectedSpan = $('#level' + level + '_selected');
    var clearBtn = $('#level' + level + '_clear');
    var hiddenInput = $('#level' + level + '_user');

    // 搜索
    searchInput.bind('keyup click', function() {
        var keyword = $(this).val().trim();
        if (keyword == '') {
            listDiv.hide();
            return;
        }

        $.ajax({
            url: '?m=content&c=content&a=search_admin&pc_hash=<?php echo $_SESSION['pc_hash'];?>',
            type: 'POST',
            data: {keyword: keyword},
            dataType: 'json',
            success: function(res) {
                var html = '';
                if (res.status == 1 && res.data && res.data.length > 0) {
                    for (var i = 0; i < res.data.length; i++) {
                        var item = res.data[i];
                        var name = item.realname ? item.realname : item.username;
                        html += "<li data-id='" + item.userid + "' data-name='" + name + "' " +
                                "style='line-height:30px;font-size:13px;padding:5px 10px;cursor:pointer;color:#fff;'>" +
                                name + " [" + item.username + "]</li>";
                    }
                } else {
                    html = "<li style='color:#999;padding:5px 10px;'>未找到匹配的用户</li>";
                }
                listDiv.find('ul').html(html);
                listDiv.show();
            }
        });
    });

    // 选择
    $(document).delegate('#level' + level + '_list ul li[data-id]', 'click', function() {
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        if (id) {
            hiddenInput.val(id);
            selectedSpan.text(name);
            clearBtn.show();
            searchInput.val('');
            listDiv.hide();
        }
    });

    // 清除
    clearBtn.click(function() {
        hiddenInput.val('0');
        selectedSpan.text('');
        $(this).hide();
    });

    // 鼠标悬停效果
    $(document).delegate('#level' + level + '_list ul li', 'mouseover', function() {
        $(this).css('background', '#3e4095');
    }).delegate('#level' + level + '_list ul li', 'mouseout', function() {
        $(this).css('background', 'transparent');
    });
}

// 点击其他地方隐藏下拉列表
$(document).click(function(e) {
    if (!$(e.target).closest('#level1_search, #level1_list').length) {
        $('#level1_list').hide();
    }
    if (!$(e.target).closest('#level2_search, #level2_list').length) {
        $('#level2_list').hide();
    }
});

// 初始化
initApprovalSearch(1);
initApprovalSearch(2);

// 表单提交验证
$('#myform').submit(function(e) {
    // 标题不能为空
    var title = $('input[name="info[title]"]').val();
    if (!title || title.trim() == '') {
        alert('标题不能为空！');
        $('input[name="info[title]"]').focus();
        e.preventDefault();
        return false;
    }

    // 内容不能为空
    var content = $('textarea[name="info[content]"]').val();
    if (!content || content.trim() == '') {
        alert('内容不能为空！');
        $('textarea[name="info[content]"]').focus();
        e.preventDefault();
        return false;
    }

    // 一级审批人不能为空
    var level1 = $('#level1_user').val();
    if (!level1 || level1 == '0') {
        alert('请选择一级审批人！');
        $('#level1_search').focus();
        e.preventDefault();
        return false;
    }

    // 二级审批人不能为空
    var level2 = $('#level2_user').val();
    if (!level2 || level2 == '0') {
        alert('请选择二级审批人！');
        $('#level2_search').focus();
        e.preventDefault();
        return false;
    }

    // 一级和二级审批人不能相同
    if (level1 == level2) {
        alert('一级审批人和二级审批人不能是同一个人！');
        e.preventDefault();
        return false;
    }
    return true;
});
//-->
</script>