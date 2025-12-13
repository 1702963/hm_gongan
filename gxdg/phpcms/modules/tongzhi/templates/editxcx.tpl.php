<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	var charset = '<?php echo CHARSET;?>';
	var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';
//-->
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script> 
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script> 
<div class="pad-lr-10">
<form action="?m=tongzhi&c=xcx&a=edit" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="232">通知标题：</th>
		<td width="960"><input type="input" name="info[title]" value="<?php echo $tongzhi['title'];?>"  style="width:400px;"/></td>
		<td width="438">标题图：</td>
	</tr>
	<tr>
		<th width="232"></th>
		<td width="960" align="left">
        
        </td>
		<td width="438" rowspan="5" align="center" valign="top">
<div style="border: none;" class='upload-pic img-wrap'><input type='hidden' name='info[titpic]' id='thumb' value='<?php echo $tongzhi['titpic'];?>'>
			<a href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,0','content','7','<?php echo $authkey;?>');return false;">
			<img src='<?php if($tongzhi['titpic']==''){?><?php echo IMG_PATH;?>icon/upload-pic.png<?php }else{?><?php echo $tongzhi['titpic'];?><?php }?>' id='thumb_preview' width='200' height='150' style='cursor:hand' />
			</a>
			<input type="button"  style="width: 100px;height: 38px;margin-right: 40px;font-weight: 600;margin-left: -10px;" class="button" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁切图片">
			<input type="button"  style="width: 100px;height: 38px;font-weight: 600;margin-left: -10px;" class="button" onclick="$('#thumb_preview').attr('src','<?php echo IMG_PATH;?>icon/upload-pic.png');$('#thumb').val(' ');return false;" value="取消图片">
			<script type="text/javascript">function crop_cut_thumb(id){
				if (id=='') { alert('请先上传缩略图');return false;}
				window.top.art.dialog({title:'裁切图片', id:'crop', iframe:'index.php?m=content&c=content&a=public_crop&module=content&catid=7&picurl='+encodeURIComponent(id)+'&input=thumb&preview=thumb_preview', width:'320x', height:'240px'}, 	function(){var d = window.top.art.dialog({id:'crop'}).data.iframe;
				d.uploadfile();return false;}, function(){window.top.art.dialog({id:'crop'}).close()});
			};
			</script>
		</div>        
        </td>
	</tr>

<tr>
		<th width="232">通知内容：</th>
		<td width="960">
		  <textarea name="info[content]" style="width:650px; height:400px;" id="content" boxid="content" ><?php echo $tongzhi['content'];?></textarea>
		  
	    </td>
	  </tr>
    
    
    
    <tr>
		<th width="232">阅读范围：</th>
		<td width="960"><?php echo form::select($zhudi,$tongzhi['zhudi'],'name=info[zhudi] ')?></td>
	  </tr>
    
    <tr>
		<th width="232">阅读记录：</th>
		<td width="960"><?php echo form::select(array(0=>'不记录',1=>'记录'),$tongzhi['doread'],'name=info[doread] ')?></td>
	  </tr>



	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " style="width:80px" /></td>
	  </tr>

</table>
<input type="hidden" name="id" value="<?php echo $id;?>" />
</form>
</div>
</body>
</html>



