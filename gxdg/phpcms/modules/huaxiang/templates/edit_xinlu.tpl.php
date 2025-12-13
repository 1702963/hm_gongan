<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');
?>

<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script> 
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script> 



<style type="text/css">
.clear {clear:both}
.baseinfo {width:100%;border-left:2px solid #ccc;border-top:2px solid #ccc;border-right:2px solid #ccc;border-bottom:2px solid #ccc;margin:0 0 20px 20px;_display:inline}
.baseinfo td {border-bottom:1px solid #ccc;padding:10px 0;height:25px}
.baseinfo td b {margin-left:10px;color:#f00}
.infotitle {background:#fff;font-weight:900}
.infotitle span {color:#f00}
.infoinput {width:200px;height:20px;background:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px}
.baseinfo select {padding:5px 0}
.infonum {width:525px;height:24px;background:#fff;border:1px solid #aaa;margin-left:10px;text-indent:5px}
.rad {margin-left:10px;margin-right:5px}
.infoselect {width:206px;margin-left:5px}
#headpic {width:150px;height:230px;background:#fff;margin-left:15px;overflow:hidden}
#headpic img {width:150px}
.topnav {width:960px;padding-left:10px;margin-top:20px}
.thisnav {width:100%;height:90px}
.thisnav a {margin-left:15px;width:120px;height:80px;display:block;float:left;background:#f6f6f6;color:#3e6a90;font-weight:900;border-radius:4px;font-size:12px;text-decoration:none;text-align:center;overflow:hidden}
.thisnav a div {width:120px;height:80px;display:block;position:relative}
.thisnav a img {width:36px;position:absolute;left:50%;margin-left:-18px;top:40%;margin-top:-18px}
.thisnav a em {width:100%;height:36px;line-height:36px;display:block;font-style:normal;position:absolute;bottom:0;left:0}
.thisnav a:hover {background:url(statics/images/nb.gif) repeat-x;color:#039}
.tabcon {width:97%;padding-top:30px;position:relative;}
.tabcon .title {width:90px;height:30px;line-height:30px;text-align:center;background:#fff;position:absolute;top:15px;left:35px;font-size:16px;font-weight:900;color:#06c}
.basetext {width:1150px;height:90px;background:#fff;border:1px solid #ddd;float:left;margin-left:5px;overflow:hidden}
.lztext {width:1150px;height:60px;background:#fff;border:1px solid #ddd;float:left;margin-left:5px;overflow:hidden}
.dowhat {width:160px;height:40px;line-height:40px;border-radius:6px;background:#06c;color:#fff;text-align:center;position:absolute;left:50%;margin-left:-80px;top:0px}
.null {width:100%;height:100px}
.rb {border-right:1px solid #ddd}
.upa {float:left;margin-left:15px}
.upa img {width:18px;margin-right:10px;}
.upa a {font-size:14px}
</style>


<form action="?m=fujing&c=xinlu&a=edit" method="POST" name="myform" id="myform">
<div class="tabcon" style="margin-top:-20px">
<div class="title">招录信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="right" class="infotitle">姓名：</td>
    <td width="262"><input type="text" id="xingming" name="info[xingming]" value="<?php echo $xinlus['xingming'];?>" class="infoinput" /></td>
    <td width="98" align="right" class="infotitle">性别：</td>
    <td width="262"><input type="radio" class="rad" <?php if($xinlus['sex']=='男'){?>checked<?php }?>  name="info[sex]" value="男"/>男
      <input type="radio" class="rad"   name="info[sex]" <?php if($xinlus['sex']=='女'){?>checked<?php }?> value="女"/>女</td>
    <td width="131" align="right" class="infotitle">身份证：</td>
    <td width="262"><input type="text" id="sfz" name="info[sfz]" value="<?php echo $xinlus['sfz'];?>" class="infoinput" /></td>    
    </tr>
  <tr>
    <td align="right" class="infotitle">出生日期</td>
    <td width="262">&nbsp;<?php echo form::date('shengri',$xinlus['shengri'],0,0,'false');?></td>
    <td width="98" align="right" class="infotitle">年龄：</td>
    <td width="262"><input type="text" id="nianling" name="info[nianling]" value="<?php echo $xinlus['nianling'];?>" class="infoinput" /></td>
    <td width="131" align="right" class="infotitle">婚姻状况：</td>
    <td width="262"><select name="info[huns]" id="info[huns]" class="infoselect">
      <option value="未婚" <?php if($xinlus['huns']=='未婚'){?>selected<?php }?>>未婚</option>
      <option value="已婚" <?php if($xinlus['huns']=='已婚'){?>selected<?php }?>>已婚</option>
      <option value="离异" <?php if($xinlus['huns']=='离异'){?>selected<?php }?>>离异</option>
      <option value="丧偶" <?php if($xinlus['huns']=='丧偶'){?>selected<?php }?>>丧偶</option>
    </select></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">家庭住址：</td>
    <td width="262"><input type="text" name="info[zhuzhi]" id="zhuzhi" class="infoinput" value="<?php echo $xinlus['zhuzhi'];?>" /></td>
    <td width="98" align="right" class="infotitle">联系电话：</td>
    <td width="262"><input name="info[tels]" type="text" id="tels" class="infoinput" value="<?php echo $xinlus['tels'];?>" /></td>
    <td width="131" align="right" class="infotitle">籍贯：</td>
    <td width="262"><input type="text" id="jiguan" name="info[jiguan]" value="<?php echo $xinlus['jiguan'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">民族：</td>
    <td width="262"><input type="text" id="minzu" name="info[minzu]" value="<?php echo $xinlus['minzu'];?>" class="infoinput" /></td>
    <td width="98" align="right" class="infotitle">政治面貌：</td>
    <td width="262"> <input type="text" id="zzmm" name="info[zzmm]" value="<?php echo $xinlus['zzmm'];?>" class="infoinput" /> </td>
    <td width="131" align="right" class="infotitle">学历：</td>
    <td width="262"><input type="text" id="xueli" name="info[xueli]" value="<?php echo $xinlus['xueli'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">毕业院校：</td>
    <td width="262"><input type="text" id="byyx" name="info[byyx]" value="<?php echo $xinlus['byyx'];?>" class="infoinput" /></td>
    <td width="98" align="right" class="infotitle">所学专业：</td>
    <td width="262"><input type="text" name="info[zhuanye]" id="zhuanye" class="infoinput" value="<?php echo $xinlus['zhuanye'];?>" /></td>
    <td width="131" align="right" class="infotitle">特长：</td>
    <td width="262"><input type="text" id="techang" name="info[techang]" value="<?php echo $xinlus['techang'];?>" class="infoinput" /></td>
  </tr>
  <tr>
    <td align="right" class="infotitle">是否退伍军人：</td>
    <td width="262"><input type="text" id="tuiyi" name="info[tuiyi]" value="<?php echo $xinlus['tuiyi'];?>" class="infoinput" /></td>
    <td width="98" align="right" class="infotitle">&nbsp;</td>
    <td width="262">&nbsp;</td>
    <td width="131" align="right">&nbsp;</td>
    <td width="262">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="infotitle">笔试成绩&nbsp;</td>
    <td width="262"><span class="infotitle">
      <input type="text" id="bishi" name="info[bishicj]" value="<?php echo $xinlus['bishicj'];?>" class="infoinput" />
    </span></td>
    <td width="98" align="right" class="infotitle">体能测试</td>
    <td width="262"><span class="infotitle">
      <input type="text" id="tineng" name="info[tinengcj]" value="<?php echo $xinlus['tinengcj'];?>" class="infoinput" />
    </span></td>
    <td width="131" align="right">&nbsp;</td>
    <td width="262">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="infotitle">面试成绩</td>
    <td width="262"><span class="infotitle">
      <input type="text" id="mianshicj" name="info[mianshicj]" value="<?php echo $xinlus['mianshicj'];?>" class="infoinput" />
    </span></td>
    <td width="98" align="right" class="infotitle">政审情况</td>
    <td width="0"><span class="infotitle">
      <input type="text" id="zhengshen" name="info[zhengshenjg]" value="<?php echo $xinlus['zhengshenjg'];?>" class="infoinput" />
    </span></td>
    <td width="0" align="right" class="infotitle">状态：</td>
    <td width="262">
      <?php $zts=array('作废','考核中','单项不合格','合格待审核','审核待分配');  ?>
      <select name="info[zt]">
      <?php foreach($zts as $k=>$v){?>
       <option value="<?php echo $k?>" <?php if($xinlus['zt']==$k){?>selected="selected"<?php }?>><?php echo $v?></option>
      <?php }?> 
      </select>
    </td>
  </tr>
  
</table>
</div>

<div class="clear"></div>

<div class="tabcon">
<input type="hidden" name="id" value="<?php echo $xinlus['id'];?>" />
	<input type="submit" class="dowhat" name="dosubmit" value="修改信息" />
</div>
</form>
<div class="clear"></div>

<div class="tabcon">
<div class="title">相关附件</div>
<table cellpadding="0" cellspacing="0" class="baseinfo">
<form action="?m=fujing&c=xinlu&a=addfj" method="post" enctype="multipart/form-data">
<input type="hidden" name="xlid" value="<?php echo $xinlus['id']?>" />
  <tr>
    <td align="left" class="infotitle" style="padding-left:40px">附件类别: &nbsp;<select name="class">
                                                                          <option value="学历">学历证明</option>
                                                                          <option value="奖励">奖励证明</option>
                                                                          <option value="其他">其他证明</option>
                                                                         </select>&nbsp; 附件说明: <input type="text" id="fujians" name="addfujian" value="" class="infoinput" /> &nbsp; <input type="file"  name="infiles" />&nbsp;<input type="submit" name="addfjs" value="追加附件" class="button" style="width:90px"/></td>
  </tr>
</form>  
  <tr>
    <td align="center" class="infotitle">

<table width="97%" border="0">
  <tr>
    <td colspan="2"><input type="button" name="xlb" value="学历证明" class="button" style="width:90px" onclick="tabban('1-0')"/><input type="button" name="jlb" value="奖励证明" class="button" style="width:90px" onclick="tabban('2-0')"/><input type="button" name="qtb" value="其他证明" class="button" style="width:90px" onclick="tabban('3-0')"/></td>
  </tr>
<?php 
$this->db->table_name = 'mj_zhaolu_files';
$fujians1 = $this->db->select("isok=1 and class='学历' and xlid=".$xinlus['id'],'*','','id desc');

foreach($fujians1 as $k=>$v){
?>  
  <tr id="1-<?php echo $k?>" style="display:<?php if($k>0){echo "none";}?>">
    <td width="650"><img src="<?php echo $v['fujians']?>" width="640"/></td>
    <td valign="top" style="padding-left:10px">
      附件操作： &nbsp; <a href="<?php echo $v['fujians']?>" target="_blank">点击查看原文件</a>  &nbsp;&nbsp; <a href="?m=fujing&c=xinlu&a=delfj&xlid=<?php echo $xinlus['id']?>&id=<?php echo $v['id']?>" onclick="javascript:var r = confirm('删除操作将清除当前记录且无法恢复，确认删除吗?');if(!r){return false;}">点击删除当前附件</a> <BR>
      附件类别：<?php echo $v['class']?> <BR />
      上传时间：<?php echo date("Y-m-d H:i:s",$v['inputtime'])?> <BR />
      附件说明：<?php echo $v['title']?> <BR />
      <p style="margin-top:10px">查看附件  
         <?php for($i=0;$i<=count($fujians1)-1;$i++){?> <a href="javascript:;" onclick="tabban('1-<?php echo $i?>')"><?php echo $i+1 ?> </a> &nbsp;<?php }?> 
      </p>
      </td>
  </tr>
<?php }?>  
<?php 

$fujians2 = $this->db->select("isok=1 and class='奖励' and xlid=".$xinlus['id'],'*','','id desc');

foreach($fujians2 as $k=>$v){
?>  
  <tr id="2-<?php echo $k?>" style="display:none">
    <td width="650"><img src="<?php echo $v['fujians']?>" width="640"/></td>
    <td valign="top" style="padding-left:10px">
      附件操作： &nbsp; <a href="<?php echo $v['fujians']?>" target="_blank">点击查看原文件</a>  &nbsp;&nbsp; <a href="?m=fujing&c=xinlu&a=delfj&xlid=<?php echo $xinlus['id']?>&id=<?php echo $v['id']?>" onclick="javascript:var r = confirm('删除操作将清除当前记录且无法恢复，确认删除吗?');if(!r){return false;}">点击删除当前附件</a> <BR>
      附件类别：<?php echo $v['class']?> <BR />
      上传时间：<?php echo date("Y-m-d H:i:s",$v['inputtime'])?> <BR />
      附件说明：<?php echo $v['title']?> <BR />
      <p style="margin-top:10px">查看附件  
         <?php for($i=0;$i<=count($fujians2)-1;$i++){?> <a href="javascript:;" onclick="tabban('2-<?php echo $i ?>')"><?php echo $i+1 ?> </a> &nbsp;<?php }?> 
      </p>
      </td>
  </tr>
<?php }?>  

<?php 
$fujians3 = $this->db->select("isok=1 and class='其他' and xlid=".$xinlus['id'],'*','','id desc');

foreach($fujians3 as $k=>$v){
?>  
  <tr id="3-<?php echo $k?>" style="display:none">
    <td width="650"><img src="<?php echo $v['fujians']?>" width="640"/></td>
    <td valign="top" style="padding-left:10px">
      附件操作： &nbsp; <a href="<?php echo $v['fujians']?>" target="_blank">点击查看原文件</a>  &nbsp;&nbsp; <a href="?m=fujing&c=xinlu&a=delfj&xlid=<?php echo $xinlus['id']?>&id=<?php echo $v['id']?>" onclick="javascript:var r = confirm('删除操作将清除当前记录且无法恢复，确认删除吗?');if(!r){return false;}">点击删除当前附件</a> <BR>
      附件类别：<?php echo $v['class']?> <BR />
      上传时间：<?php echo date("Y-m-d H:i:s",$v['inputtime'])?> <BR />
      附件说明：<?php echo $v['title']?> <BR />
      <p style="margin-top:10px">查看附件  
         <?php for($i=0;$i<=count($fujians3)-1;$i++){?> <a href="javascript:;" onclick="tabban('3-<?php echo $i?>')"><?php echo $i+1 ?> </a> &nbsp;<?php }?> 
      </p>
      </td>
  </tr>
<?php }?>  
  </table>

  </td>
  </tr>
</table>
</div>


<div class="clear"></div>
<div class="null"></div>

</div>
<script language="javascript">
function tabban(objid){
	for(i=0;i<<?php echo count($fujians1)?>;i++){
		$("#1-"+i).css('display','none')
		}
	for(i=0;i<<?php echo count($fujians2)?>;i++){
		$("#2-"+i).css('display','none')
		}
	for(i=0;i<<?php echo count($fujians3)?>;i++){
		$("#3-"+i).css('display','none')
		}
	//table-row
	$("#"+objid).css('display','table-row')
							
	}
</script>
</body></html>