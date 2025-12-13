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
	parent.document.getElementById('display_center_id').style.display='none';
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
    border: 1px solid #3132a4;
    zoom: 1;
    background: #252682;
    padding: 8px 10px;
    line-height: 20px;
	color:#bbd8f1
}
/*
.input-text , select {border:0}
input[type=submit] {border-radius:3px;transition: all .2s ease-in-out}
input[type=submit]:hover {background:#06c}
.input-text , select {border-radius:3px;background:#0e0957;color:#fff}
input[type=text]:focus {outline:none}
*/
</style>
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<div class="pad-lr-10">
<?php if($_SESSION['roleid']<2){?>
<form name="searchform" action="" method="post" >
<input type="hidden" value="renshi" name="m">
<input type="hidden" value="renshi" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $status;?>" name="status">
<div class="explain-col"> 
  快速工具:接口管理   </div>
</form>

<form name="searchform" method="get" id="daoxls" >
<input type="hidden" value="renshi" name="m">
<input type="hidden" value="renshi" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $status;?>" name="status">
<div class="explain-col"> 
<table width="100%" border="0">
  <tr>
    <td height="30">
    	<table width="1278" border="0">
        	<tr>
            	<td width="220">接口名称：
					<input type="text" value="<?php echo $xingming?>" class="input-text" size="6" name="xingming">
                </td>
                <td width="248">接口类型：
                    <select name="dwid">
						<option value="">不限</option> 
                        <option value="">系统集成</option>
                        <option value="">扩展接口</option>

					</select>
                </td>
                <td width="283">接口状态：
					<select name="sex">
						<option value="">不限</option>
						<option value="" >启用</option>
						<option value="" >禁用</option>
					</select>
                </td>
                <td width="406">创建时间：
					<select name="rjtj">
						<option value="">不限</option>
						<option value="=" <?php if($_GET['rjtj']=="="){?>selected="selected"<?php }?>>区间</option>
					</select>
                    <?php if(!isset($rjtimes)){$rjtimes=time();} echo form::date('rjtime',date("Y-m-d",$rjtimes),0,0,'false');?>
                    至
                    <?php if(!isset($rjtimes2)){$rjtimes2=time();} echo form::date('rjtime2',date("Y-m-d",$rjtimes2),0,0,'false');?>
                </td>
                <td width="99">
  					<input type="submit" value="查询" class="button" name="dotongji">
                    <a href="index.php?m=renshi&c=renshi&a=dao2xls&status=<?php echo $status?>&xingming=<?php echo $xingming?>&dwid=<?php echo $dwid?>&sex=<?php echo $sex?>&agetj=<?php echo $_GET['agetj']?>&age1=<?php echo $age1?>&age2=<?php echo $age2?>&xueli=<?php echo $xuelis?>&rjtj=<?php echo $_GET['rjtj']?>&rjtime=<?php echo date("Y-m-d",$rjtimes)?>&rjtime2=<?php echo date("Y-m-d",$rjtimes2)?>&gangwei=<?php echo $gangweis?>&gangweifz=<?php echo $gangweifzs?>&zhiwu=<?php echo $zhiwus?>&cengji=<?php echo $cengjis?>&zzmm=<?php echo $zzmms?>&tuiwu=<?php echo $tuiwus?>&gzz=<?php echo $_GET['gzz']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" target="_blank"><input type="button" value="导出" class="button" id="daochu" style="display:none" > </a>
                    <input type="button" value="展《" class="button" id="mianban" onclick="showkuozhan()" style="width:40px; display:none">
                </td>
            </tr>
        </table>
    
    </td>
    </tr>
  <tr id="kuozhan1" style="display:none">
    <td height="30">
    <div style="width:100%;height:15px"></div>
  政治面貌：<select name="zzmm" style="margin-right:10px">
         <option value="">不限</option>
         <?php foreach($zzmm as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$zzmms){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>
       
  退役军人：<select name="tuiwu" style="margin-right:10px">
         <option value="">不限</option>
         <?php foreach($tuiyi as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$tuiwus){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>  
           
  岗位类别：<select name="gangwei" style="margin-right:10px">
         <option value="">不限</option>
         <?php foreach($gangwei as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$gangweis){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>
  辅助岗位：<select name="gangweifz" style="margin-right:10px">
         <option value="">不限</option>
         <?php foreach($gangweifz as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$gangweifzs){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>
  职务：<select name="zhiwu" style="margin-right:10px">
         <option value="">不限</option>
         <?php foreach($zhiwu as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$zhiwus){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>
  层级：<select name="cengji" style="margin-right:10px">
         <option value="">不限</option>
         <?php foreach($cengji as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$cengjis){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>
   电话：<input type="text" value="<?php echo $tel?>" class="input-text" size="12" name="tel" style="margin-right:10px">
   身高：<select name="shengaotj" style="margin-right:5px">
            <option value="">不限</option> 
            <option value="=" <?php if($_GET['shengaotj']=="="){?>selected="selected"<?php }?>>等于</option>
            <option value="<" <?php if($_GET['shengaotj']=="<"){?>selected="selected"<?php }?>>小于</option>
            <option value=">" <?php if($_GET['shengaotj']==">"){?>selected="selected"<?php }?>>大于</option>
           </select><input type="text" value="<?php echo $shengao?>" class="input-text" size="6" name="shengao" style="margin-right:10px"><br><br>
   体重：<select name="tizhongtj" style="margin-right:5px">
            <option value="">不限</option> 
            <option value="=" <?php if($_GET['tizhongtj']=="="){?>selected="selected"<?php }?>>等于</option>
            <option value="<" <?php if($_GET['tizhongtj']=="<"){?>selected="selected"<?php }?>>小于</option>
            <option value=">" <?php if($_GET['tizhongtj']==">"){?>selected="selected"<?php }?>>大于</option>
           </select><input type="text" value="<?php echo $tizhong?>" class="input-text" style="margin-right:10px" size="6" name="tizhong">
   辅警号：<input type="text" name="gzz" class="input-text" value="<?php echo $_GET['gzz']?>" size="10"/>     
    </td>
    </tr>    
</table>
	</div>
</form>
<?php }?>
<?php if($_SESSION['roleid']==9){?>
<form name="searchform" method="get" id="daoxls" >
<input type="hidden" value="renshi" name="m">
<input type="hidden" value="renshi" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $status;?>" name="status">
<div class="explain-col"> 
<table width="100%" border="0">
  <tr>
    <td height="30">
	
  姓名: <input type="text" value="<?php echo $xingming?>" class="input-text" size="6" name="xingming">&nbsp;&nbsp;
  单位：<select name="dwid">
                       
                       
                       <option value="<?php echo $_SESSION['bmid'];?>"  ><?php echo $bms[$_SESSION['bmid']]?></option>
                       
                      </select>&nbsp;&nbsp;
  性别: <select name="sex">
          <option value="">不限</option>
          <option value="男" <?php if($sex=="男"){?>selected="selected"<?php }?>>男</option>
          <option value="女" <?php if($sex=="女"){?>selected="selected"<?php }?>>女</option>
       </select> &nbsp;&nbsp;
  年龄: <select name="agetj">
            <option value="">不限</option> 
            <option value="=" <?php if($_GET['agetj']=="="){?>selected="selected"<?php }?>>等于</option>
            <option value="<" <?php if($_GET['agetj']=="<"){?>selected="selected"<?php }?>>小于</option>
            <option value=">" <?php if($_GET['agetj']==">"){?>selected="selected"<?php }?>>大于</option>
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
  <a href="index.php?m=renshi&c=renshi&a=dao2xls&status=<?php echo $status?>&xingming=<?php echo $xingming?>&dwid=<?php echo $dwid?>&sex=<?php echo $sex?>&agetj=<?php echo $_GET['agetj']?>&age=<?php echo $age?>&xueli=<?php echo $xuelis?>&rjtj=<?php echo $_GET['rjtj']?>&rjtime=<?php echo date("Y-m-d",$rjtimes)?>&rjtime2=<?php echo date("Y-m-d",$rjtimes2)?>&gangwei=<?php echo $gangweis?>&gangweifz=<?php echo $gangweifzs?>&zhiwu=<?php echo $zhiwus?>&cengji=<?php echo $cengjis?>&zzmm=<?php echo $zzmms?>&tuiwu=<?php echo $tuiwus?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" target="_blank"><input type="button" value="导出" class="button" id="daochu" > </a>  
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
   电话: <input type="text" value="<?php echo $tel?>" class="input-text" size="6" name="tel">&nbsp;&nbsp;
   身高：<select name="shengaotj">
            <option value="">不限</option> 
            <option value="=" <?php if($_GET['shengaotj']=="="){?>selected="selected"<?php }?>>等于</option>
            <option value="<" <?php if($_GET['shengaotj']=="<"){?>selected="selected"<?php }?>>小于</option>
            <option value=">" <?php if($_GET['shengaotj']==">"){?>selected="selected"<?php }?>>大于</option>
           </select><input type="text" value="<?php echo $shengao?>" class="input-text" size="6" name="shengao">&nbsp;&nbsp;
   体重：<select name="tizhongtj">
            <option value="">不限</option> 
            <option value="=" <?php if($_GET['tizhongtj']=="="){?>selected="selected"<?php }?>>等于</option>
            <option value="<" <?php if($_GET['tizhongtj']=="<"){?>selected="selected"<?php }?>>小于</option>
            <option value=">" <?php if($_GET['tizhongtj']==">"){?>selected="selected"<?php }?>>大于</option>
           </select><input type="text" value="<?php echo $tizhong?>" class="input-text" size="6" name="tizhong">&nbsp;&nbsp;         
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
    $(".kotable tbody tr:odd").addClass("odd");//even 奇数行 gt(0)排除第一个
    $(".kotable tbody tr").mouseover(function() {  
      $(this).addClass("iover");  
    }).mouseout(function() {  
      $(this).removeClass("iover");  
    });  
  }  
)  
</script> 
<style type="text/css">
/*
table {
border-collapse:collapse;
border-spacing:4px	
}
.table-list {color:#99d2f6}
.kotable {font-family:microsoft yahei}
.kotable {border-top:0 solid #ddd;border-left:0 solid #ddd;margin-top:10px;float:left}
.kotable thead th {border-right:0 solid #ddd;border-bottom:0 solid #ddd;background:#2f4ca6;text-align:center;line-height:36px;font-size:14px}
.kotable tbody td {border-right:0 solid #ddd;border-bottom:0 solid #ddd;text-align:center;line-height:1.5;font-size:12px;height:32px}

.odd {	background:#28348e;	}
.iover {background:#0e0957;color:#ffc;}
.iover a {color:#ffc}

.kotable tbody tr {transition: all .2s ease-in-out}

#pages {width:100%;float:left;margin-top:5px}
*/
</style>
<table width="100%" cellspacing="4" cellpadding="4" class="kotable">
	<thead>
	<tr>
     
      <th width='106'>序号</th>
      
      <th width="195">接口名称</th>
	  <th width='169'>接口类型</th>
	   <th width="171">接口状态</th>
      <th width="205">创建日期</th>
	  <th width="228">调用次数</th>
      <th width="391">接口参数</th>
      <th width="307">操作</th>
	</tr>
    </thead>
    <tbody>
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
      <td><a href="index.php?m=renshi&c=renshi&a=show&id=<?php echo $info['id']?>&status=<?php echo $status;?>">查看</a>
        <?php if($_SESSION['roleid']>5){
			   if($info['islock']<1){
			  ?>
        &nbsp;<a href="index.php?m=renshi&c=renshi&a=edit&id=<?php echo $info['id']?>&status=<?php echo $status;?>">修改</a>
        <?php }}else{ ?>
        &nbsp;<a href="index.php?m=renshi&c=renshi&a=edit&id=<?php echo $info['id']?>&status=<?php echo $status;?>">修改</a>
        <?php }?>
        <?php if($_SESSION['roleid']<2){ 
		          if($info["islock"]>0){
		   ?>             
        &nbsp;<a href="index.php?m=renshi&c=renshi&a=init&doty=0&ids=<?php echo $info['id']?>&status=<?php echo $status;?>"><font color="red">解锁</font></a>
        <?php }else{?>
        &nbsp;<a href="index.php?m=renshi&c=renshi&a=init&doty=1&ids=<?php echo $info['id']?>&status=<?php echo $status;?>">锁定</a>
        <?php } ?>
        &nbsp;<a href="index.php?m=renshi&c=renshi&a=init&dofei=1&ids=<?php echo $info['id']?>&status=<?php echo $status;?>" onclick="javascript:var r = confirm('确认作废当前记录吗？');if(!r){return false;}">作废</a>
        <?php }?>          
      </td>
	</tr>
   <?php
	$i++;}
}
?>
</tbody>
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