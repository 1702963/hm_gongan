<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');
?>




<style type="text/css">
.clear {clear:both}
.baseinfo {width:100%;border-left:2px solid #ccc;border-top:2px solid #ccc;border-right:2px solid #ccc;border-bottom:2px solid #ccc;margin:0 0 20px 20px;_display:inline}
.baseinfo td {border-bottom:1px solid #ccc;padding:10px 0;height:25px}
.baseinfo td b {margin-left:10px;color:#f00}
.infotitle {background:#fff;font-weight:900}

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
.null {width:100%;height:10px}
.rb {border-right:1px solid #ddd}
.upa {float:left;margin-left:15px}
.upa img {width:18px;margin-right:10px;}
.upa a {font-size:14px}
.c1{ color:#000000}
.c2{ color:#FF0000}
.c9{ color:#33CC33}
</style>



<div class="tabcon" style="margin-top:-20px">
<div class="title">辅警信息</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center" >
  <tr>
    <td width="181" align="right" class="infotitle" style="padding-left:20px">姓名：</td>
    <td width="306"><?php echo $info['fjname'];?>
                    </td>
    <td width="62" align="right" class="infotitle"></td>
    <td width="254">
       
    </td>
    <td width="700" align="left" id="selmsg" style="padding-left:5px; color:red">&nbsp;</td>
    </tr>
  
</table>
</div>

<div class="clear"></div>

<div class="clear"></div>

<div class="tabcon">
<div class="title">申请详情</div>
<table cellpadding="0" cellspacing="0" class="baseinfo">

 <tr>
    <td align="right" class="infotitle" style="padding-left:20px;border-bottom:0px">离职前部门/岗位/岗位辅助：</td>
    <td align="left"  style="border-bottom:0px">
    <select name="info[newdw]" class="infoinput" style="height:30px">
                    
                      <option value=""><?php echo $bumens[$info['olddw']];?></option>
                    </select> &nbsp;
    <select name="info[newgangwei]" class="infoinput" style="height:30px">
                    
                      <option value=""><?php echo $gangweis[$info['oldgangwei']];?></option>
          </select> &nbsp;<select name="info[newgangweifz]" class="infoinput" style="height:30px">
                     
                      <option value="<?php echo $k?>"><?php echo $fzgangweis[$info['oldgangweifz']];?></option>
                   
        </select> &nbsp;</td>
  </tr>
  
  <tr>
    <td align="right" class="infotitle" style="padding-left:20px;border-bottom:0px">调动原因：</td>
    <td align="left" class="infotitle" style="border-bottom:0px"><textarea name="info[content]" style="width:90%; height:100px" class="infoinput"><?php echo $info['content'];?></textarea></td>
  </tr>
  <tr>
    <td align="right" class="infotitle" style="padding-left:20px;border-bottom:0px">文件图片：</td>
    <td align="left" class="infotitle" style="border-bottom:0px">
	  <input type="hidden" id="con1" name="info[fj]"  />

    <div >
       
	<?php
	foreach($images as $img){
	?>
	<a href="?m=shenpi&c=renyuanshenpi&a=img&url=<?php echo $img;?>" target="_blank"><img src=<?php echo $img;?> width=100 height=100 /></a>
      <?php
	  }
	  ?>  
    </div>	</td>
  </tr>
   <tr>
    <td align="right" class="infotitle" style="padding-left:20px;border-bottom:0px">领导审批结果：</td>
    <td align="left" class="infotitle" style="border-bottom:0px">
	<?php if($info['bmshid']){?><?php echo $ld[$info['bmshid']]?>:<span class="c<?php echo $info['bmstatus'];?>"><?php echo $zt[$info['bmstatus']];?></span><?php }?> &nbsp;&nbsp;&nbsp;&nbsp;<?php if($info['bmshtime']){echo date("Y-m-d",$info['bmshtime']);}?><br>

		<?php if($info['fgshid']){?><?php echo $ld[$info['fgshid']]?>:<span class="c<?php echo $info['fgstatus'];?>"><?php echo $zt[$info['fgstatus']];?></span><?php }?>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($info['fgshtime']){echo date("Y-m-d",$info['fgshtime']);}?><br>

		<?php if($info['zrshid']){?><?php echo $ld[$info['zrshid']]?>:<span class="c<?php echo $info['zrstatus'];?>"><?php echo $zt[$info['zrstatus']];?></span><?php }?>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($info['zrshtime']){echo date("Y-m-d",$info['zrshtime']);}?><br>

		<?php if($info['ldshid']){?><?php echo $ld[$info['ldshid']]?>:<span class="c<?php echo $info['ldstatus'];?>"><?php echo $zt[$info['ldstatus']];?></span>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($info['ldshtime']){echo date("Y-m-d",$info['ldshtime']);}?>  <?php if($info['dai']==1){?><span class="c2">代签</span> <?php }?> <?php }?>	</td>
  </tr>
</table>
</div>

<div class="tabcon">
	
</div>

<div class="clear"></div>
<div class="null"></div>
</div>

</body></html>
