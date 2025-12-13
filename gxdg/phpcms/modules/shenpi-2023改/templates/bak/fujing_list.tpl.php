<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new', 'admin');

$zzmm[1]="中共党员";
$zzmm[2]="共青团员";
$zzmm[3]="民主党派";
$zzmm[4]="学生";
$zzmm[5]="群众";


$tuiyi[1]="是";
$tuiyi[2]="否";
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
	if(window.top.$("#current_pos").data('clicknum')==1 || window.top.$("#current_pos").data('clicknum')==null) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?m=admin&c=bumen&a=bumen_tree&pc_hash=<?php echo $_SESSION['pc_hash'];?>&mm=fujing&cc=fujing&aa=init&status=<?php echo $status;?>';
	window.top.$("#current_pos").data('clicknum',0);
}
//-->
</SCRIPT>

<style type="text/css">
	html{_overflow-y:scroll}
</style><style>

.Bar ,.Bars { position: relative; width: 100px; border: 1px solid #B1D632; padding: 1px; } 
.Bar div,.Bars div { display: block; position: relative;background:#00F; color: #333; height: 20px;line-height: 20px;} 
.Bars div{ background:#090} 
.Bar div span,.Bars div span { position: absolute; width: 100px; text-align: center; font-weight: bold; } 
.cent{ margin:0 auto; width:150px; overflow:hidden} 
input.button {padding:0 15px;background:#498cd0}
.explain-col {
    border: 1px solid #e0e4e9;
    zoom: 1;
    background: #e6ecf5;
    padding: 8px 10px;
    line-height: 20px;
}
</style>

<div class="pad-lr-10">
<?php if($_SESSION['roleid']<2){?>
<form name="searchform" action="" method="post" >
<input type="hidden" value="fujing" name="m">
<input type="hidden" value="fujing" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $status;?>" name="status">
<div class="explain-col"> 
  快速工具:   人员表锁定 <select name="lockclass">
                       <?php ksort($bms);foreach($bms as $k=>$v){
						     $renshustr="";
							 if(isset($fjshuliang[$k])){
								$renshustr=" [".$fjshuliang[$k]."]"; 
							  }else{
								$renshustr=" [0]";  
								  }
						   ?>
                       <option value="<?php echo $k?>"><?php echo $v.$renshustr?></option>
                       <?php }?>
                      </select>
<label><input type="radio" name="lockeds" value="0" />解锁</label>
<label><input type="radio" name="lockeds" value="1" checked="checked"/>锁定</label>                      
<input type="submit" value="锁定" class="button" name="dook">  
		</div>
</form>

<form name="searchform" method="get" id="daoxls" >
<input type="hidden" value="fujing" name="m">
<input type="hidden" value="fujing" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $status;?>" name="status">
<div class="explain-col"> 
<table width="100%" border="0">
  <tr>
    <td height="30">
  姓名: <input type="text" value="<?php echo $xingming?>" class="input-text" size="6" name="xingming">&nbsp;&nbsp;
  单位：<select name="dwid">
                       <option value="">不限</option> 
                       <?php ksort($bms);foreach($bms as $k=>$v){?>
                       <option value="<?php echo $k?>" <?php if($k==$dwid){?>selected="selected"<?php }?> ><?php echo $v?></option>
                       <?php }?>
                      </select>&nbsp;&nbsp;
  性别: <select name="sex">
          <option value="">不限</option>
          <option value="男" <?php if($sex=="男"){?>selected="selected"<?php }?>>男</option>
          <option value="女" <?php if($sex=="女"){?>selected="selected"<?php }?>>女</option>
       </select> &nbsp;&nbsp;
  年龄: <select name="agetj">
            <option value="">不限</option> 
            <option value="=" <?php if($_GET['agetj']=="="){?>selected="selected"<?php }?>>等于</option>
            <option value=">" <?php if($_GET['agetj']==">"){?>selected="selected"<?php }?>>小于</option>
            <option value="<" <?php if($_GET['agetj']=="<"){?>selected="selected"<?php }?>>大于</option>
           </select><input type="text" value="<?php echo $age ?>" class="input-text" size="3" name="age">&nbsp;&nbsp; 
  学历: <select name="xueli">
         <option value="">不限</option>
         <?php foreach($xueli as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$xueli){?>selected="selected"<?php }?> ><?php echo $v?></option>
         <?php }?>
       </select>
       &nbsp;&nbsp; 
  入警时间: <select name="rjtj">
            <option value="">不限</option>
            <option value="=" <?php if($_GET['rjtj']=="="){?>selected="selected"<?php }?>>区间</option>
           </select><?php if(!isset($rjtimes)){$rjtimes=time();} echo form::date('rjtime',date("Y-m-d",$rjtimes),0,0,'false');?>&nbsp;至&nbsp;
           <?php if(!isset($rjtimes2)){$rjtimes2=time();} echo form::date('rjtime2',date("Y-m-d",$rjtimes2),0,0,'false');?>
           &nbsp;&nbsp;
  <input type="submit" value="查询" class="button" name="dotongji">  
  <a href="index.php?m=fujing&c=fujing&a=dao2xls&status=<?php echo $status?>&xingming=<?php echo $xingming?>&dwid=<?php echo $dwid?>&sex=<?php echo $sex?>&agetj=<?php echo $_GET['agetj']?>&age=<?php echo $age?>&xueli=<?php echo $xuelis?>&rjtj=<?php echo $_GET['rjtj']?>&rjtime=<?php echo date("Y-m-d",$rjtimes)?>&rjtime2=<?php echo date("Y-m-d",$rjtimes2)?>&gangwei=<?php echo $gangweis?>&gangweifz=<?php echo $gangweifzs?>&zhiwu=<?php echo $zhiwus?>&cengji=<?php echo $cengjis?>&zzmm=<?php echo $zzmms?>&tuiwu=<?php echo $tuiwus?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" target="_blank"><input type="button" value="导出" class="button" id="daochu" > </a>  
  <input type="button" value="展《" class="button" id="mianban" onclick="showkuozhan()" style="width:40px">  
    </td>
    </tr>
  <tr id="kuozhan1" style="display:none">
    <td height="30">
  政治面貌: <select name="zzmm">
         <option value="">不限</option>
         <?php foreach($zzmm as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$zzmms){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp;
       
  退役军人: <select name="tuiwu">
         <option value="">不限</option>
         <?php foreach($tuiyi as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$tuiwus){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp;       
           
  岗位类别: <select name="gangwei">
         <option value="">不限</option>
         <?php foreach($gangwei as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$gangweis){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp;
  辅助岗位: <select name="gangweifz">
         <option value="">不限</option>
         <?php foreach($gangweifz as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$gangweifzs){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select> &nbsp;&nbsp;
  职务: <select name="zhiwu">
         <option value="">不限</option>
         <?php foreach($zhiwu as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$zhiwus){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp; 
  层级: <select name="cengji">
         <option value="">不限</option>
         <?php foreach($cengji as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$cengjis){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>
       &nbsp;&nbsp; 
    </td>
    </tr>    
</table>
	</div>
</form>
<?php }?>

<div class="table-list">
<form name="myform" id="myform" action="?m=shenpi&c=shenpi&a=listorder" method="POST">
<script type="text/javascript" >  
  $(document).ready(function() {  
    $(".kotable tr:even:gt(0)").addClass("odd");//even 奇数行 gt(0)排除第一个
    $(".kotable tr:gt(0)").mouseover(function() {  
      $(this).addClass("iover");  
    }).mouseout(function() {  
      $(this).removeClass("iover");  
    });  
  }  
)  
</script> 
<style type="text/css">
.table-list td, .table-list th {padding:0;margin:0}
.table-list tbody td {padding:0}
.kotable {border-top:1px solid #ddd;border-left:1px solid #ddd;margin-top:10px;float:left}
.kotable th {border-right:1px solid #ddd;border-bottom:1px solid #ddd;background:#cee8ff;text-align:center;line-height:36px}
.kotable td {border-right:1px solid #ddd;border-bottom:1px solid #ddd;text-align:center;line-height:32px}
.table-list td {font-size:12px}
.odd {	background:#f7f7f7;	}
.iover {background:#FFFDE8 }

#pages {width:100%;float:left;margin-top:5px}
</style>
<table width="1400px" cellspacing="0" class="kotable">
	<tr>
     
      <th width='63'>序号</th>
      
      <th width="120">工作单位</th>
	  <th width='103'>姓名</th>
	   <th width="73">性别</th>
      <th width="165">身份证号</th>
	  <th width="84">年龄</th>
      <th width="119">出生日期</th>
      <th width="162">学历</th>
      <th width="103">入警时间</th>  
      <th width="103">政治面貌</th>
      <th width="73">退役</th>
      <th width="103">岗位类别</th>
      <th width="121">辅助岗位</th>
      <th width="110">职务</th>
      <th width="86">层级</th>
      <th width="86">电话</th>
      <th width="200">操作</th>
	</tr>
  <?php
  
if(is_array($fujing)){
	
	if(intval($_GET['page'])>1){
	 $i=12*(intval($_GET['page'])-1)+1;
	}else{
	 $i=1;
	}
	
	foreach($fujing as $info){
	
	//动态计算年龄
	if($info['shengri']!=''){
	 $nianling=date("Y")-date("Y",$info['shengri']);
	}else{
	 $nianling='';	
		}
		?>
	<tr>
      
      <td><?php echo $i?></td>
      <td><?php echo $bms[$info['dwid']];?></td>
      <td><?php echo $info['xingming']?></td>
	  <td><?php echo $info['sex']?></td>
      <td><?php echo $info['sfz']?></td>
	  <td><?php echo $nianling?></td>
      <td><?php if($info['shengri']!=''){echo date("Y-m-d",$info['shengri']);}?></td>
      <td><?php echo $xueli[$info['xueli']]?></td>
      <td><?php if($info['rjtime']!=0){echo date("Y-m-d",$info['rjtime']);}?></td>
      <td><?php echo $zzmm[$info['zzmm']];?></td>
      <td><?php echo $tuiyi[$info['tuiwu']];?></td>
      <td><?php echo $gangwei[$info['gangwei']];?></td>
      <td><?php echo $gangweifz[$info['gangweifz']];?></td>
      <td><?php echo $zhiwu[$info['zhiwu']];?></td>
      <td><?php echo $cengji[$info['cengji']];?></td>
      <td><?php echo $info['tel'];?></td>
      <td><a href="index.php?m=fujing&c=fujing&a=show&id=<?php echo $info['id']?>&status=<?php echo $status;?>">查看</a>
          <?php if($_SESSION['roleid']>5){
			   if($info['islock']<1){
			  ?>
              &nbsp;<a href="index.php?m=fujing&c=fujing&a=edit&id=<?php echo $info['id']?>&status=<?php echo $status;?>">修改</a>
		  <?php }}else{ ?>
              &nbsp;<a href="index.php?m=fujing&c=fujing&a=edit&id=<?php echo $info['id']?>&status=<?php echo $status;?>">修改</a>
		  <?php }?>
          <?php if($_SESSION['roleid']<2){ 
		          if($info["islock"]>0){
		   ?>             
              &nbsp;<a href="index.php?m=fujing&c=fujing&a=init&doty=0&ids=<?php echo $info['id']?>&status=<?php echo $status;?>"><font color="red">解锁</font></a>
		  <?php }else{?>
              &nbsp;<a href="index.php?m=fujing&c=fujing&a=init&doty=1&ids=<?php echo $info['id']?>&status=<?php echo $status;?>">锁定</a>
		  <?php } ?>
		      &nbsp;<a href="index.php?m=fujing&c=fujing&a=init&dofei=1&ids=<?php echo $info['id']?>&status=<?php echo $status;?>" onclick="javascript:var r = confirm('确认作废当前记录吗？');if(!r){return false;}">作废</a>
		  <?php }?>          
          </td>
	</tr>
   <?php
	$i++;}
}
?>
</table>

<div id="pages"><?php echo $pages?></div>
</form>
</div>
</div>
</div>
<script language="javascript">
function showkuozhan(){
  if($("#mianban").val()=='展《'){
	   $("#mianban").val('收》')
	   $("#kuozhan1").css('display','') 
	  }else{
	   $("#mianban").val('展《')
	   $("#kuozhan1").css('display','none')		  
		  }	 
}

</script>
</body>
</html>