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
<form name="searchform" method="get" id="daoxls" >
<input type="hidden" value="fujing" name="m">
<input type="hidden" value="rencai" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $status;?>" name="status">
<div class="explain-col"> 
<table width="100%" border="0">
  <tr>
    <td height="30">
  特长类型：<select name="mclass" onchange="getsub(this.value)">
                       <option value="">不限</option> 
                         <?php foreach($tcclass as $v){
							   if($v['pid']<1){
							 ?>
                             <option value="<?php echo $v['id']?>" <?php if($mclasss==$v['id']){?>selected="selected"<?php }?>><?php echo $v['classname']?></option>
                             <?php }}?>
                      </select>&nbsp;&nbsp;
                           </select> - <select name="tcid" id="tcid">
                             <option value="">不限</option> 
                             <?php if($tcids!=''){?>
                             <?php foreach($tcclass as $v){
							   if($v['pid']==$mclasss){
							 ?>
                             <option value="<?php echo $v['id']?>" <?php if($tcids==$v['id']){?>selected="selected"<?php }?>><?php echo $v['classname']?></option>
                             <?php }}?>                             
                             <?php }?>                        
                           </select>&nbsp;&nbsp;                    
                          
  姓名: <input type="text" value="<?php echo $xingming?>" class="input-text" size="6" name="xingming">&nbsp;&nbsp;
  单位：<select name="dwid">
                       <option value="">不限</option> 
                       <?php ksort($bumens);foreach($bumens as $k=>$v){?>
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
         <?php foreach($xuelis as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$xueli){?>selected="selected"<?php }?> ><?php echo $v?></option>
         <?php }?>
       </select>
       &nbsp;&nbsp; 
  入警时间: <select name="rjtj">
            <option value="">不限</option>
            <option value="=" <?php if($_GET['rjtj']=="="){?>selected="selected"<?php }?>>等于</option>
            <option value=">" <?php if($_GET['rjtj']==">"){?>selected="selected"<?php }?>>晚于</option>
            <option value="<" <?php if($_GET['rjtj']=="<"){?>selected="selected"<?php }?>>早于</option>
           </select><?php if(!isset($rjtimes)){$rjtimes=time();} echo form::date('rjtime',date("Y-m-d",$rjtimes),0,0,'false');?>
           &nbsp;&nbsp;
  <input type="submit" value="查询" class="button" name="dotongji">  
  <a href="index.php?m=renshi&c=renshi&a=dao2xls&status=<?php echo $status?>&xingming=<?php echo $xingming?>&dwid=<?php echo $dwid?>&sex=<?php echo $sex?>&agetj=<?php echo $_GET['agetj']?>&age=<?php echo $age?>&xueli=<?php echo $xuelis?>&rjtj=<?php echo $_GET['rjtj']?>&rjtime=<?php echo date("Y-m-d",$rjtimes)?>&gangwei=<?php echo $gangweis?>&gangweifz=<?php echo $gangweifzs?>&zhiwu=<?php echo $zhiwus?>&cengji=<?php echo $cengjis?>&zzmm=<?php echo $zzmms?>&tuiwu=<?php echo $tuiwus?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" target="_blank"><input type="button" value="导出" class="button" id="daochu"  style="display:none"> </a>  
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
         <?php foreach($gangweis as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$gangweis){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp;
  辅助岗位: <select name="gangweifz">
         <option value="">不限</option>
         <?php foreach($gangweifzs as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$gangweifzs){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select> &nbsp;&nbsp;
  职务: <select name="zhiwu">
         <option value="">不限</option>
         <?php foreach($zhiwus as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$zhiwus){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp; 
  层级: <select name="cengji">
         <option value="">不限</option>
         <?php foreach($cengjis as $k=>$v){?>
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
     
      <th width='63'>序号x</th>
      
      <th width="120">工作单位</th>
	  <th width='103'>姓名</th>
	   <th width="73">性别</th>
      <th width="165">身份证号</th>
	  <th width="84">年龄</th>
      <th width="119">特长</th>
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
  
if(is_array($rencai)){
	
	if(intval($_GET['page'])>1){
	 $i=12*(intval($_GET['page'])-1)+1;
	}else{
	 $i=1;
	}
	
	foreach($rencai as $info){
	
	//动态计算年龄
	if($fujings[$info['fjid']]['shengri']!=''){
	 $nianling=date("Y")-date("Y",$fujings[$info['fjid']]['shengri']);
	}else{
	 $nianling='';	
		}
		?>
	<tr>
      
      <td><?php echo $i?></td>
      <td><?php echo $bumens[$fujings[$info['fjid']]['dwid']];?></td>
      <td><?php echo $fujings[$info['fjid']]['xingming']?></td>
	  <td><?php echo $fujings[$info['fjid']]['sex']?></td>
      <td><?php echo $fujings[$info['fjid']]['sfz']?></td>
	  <td><?php echo $nianling?></td>
      <td><?php echo $tcclassys[$info['tcid']]?></td>
      <td><?php echo $xuelis[$fujings[$info['fjid']]['xueli']]?></td>
      <td><?php if($fujings[$info['fjid']]['rjtime']!=0){echo date("Y-m-d",$fujings[$info['fjid']]['rjtime']);}?></td>
      <td><?php echo $zzmm[$fujings[$info['fjid']]['zzmm']];?></td>
      <td><?php echo $tuiyi[$fujings[$info['fjid']]['tuiwu']];?></td>
      <td><?php echo $gangweis[$fujings[$info['fjid']]['gangwei']];?></td>
      <td><?php echo $gangweifzs[$fujings[$info['fjid']]['gangweifz']];?></td>
      <td><?php echo $zhiwus[$fujings[$info['fjid']]['zhiwu']];?></td>
      <td><?php echo $cengjis[$fujings[$info['fjid']]['cengji']];?></td>
      <td><?php echo $fujings[$info['fjid']]['tel'];?></td>
      <td><a href="javascript:;" onclick="showxiang('<?php echo $info['id']?>')">查看</a>
          <?php if($_SESSION['roleid']<5){
			   if($info['zzcod']<1){
			  ?>
              &nbsp;<a href="index.php?m=fujing&c=rencai&a=init&doshen=0&id=<?php echo $info['id']?>">待审核</a>
		  <?php }}else{ ?>
              &nbsp;<a href="index.php?m=fujing&c=rencai&a=init&doshen=1&id=<?php echo $info['id']?>">已审核</a>
		  <?php }?>
          <?php if($_SESSION['roleid']<2){ 
		          if($info["islock"]>0){
		   ?>             
              &nbsp;<a href="index.php?m=fujing&c=rencai&a=init&doty=0&ids=<?php echo $info['id']?>"><font color="red">解锁</font></a>
		  <?php }else{?>
              &nbsp;<a href="index.php?m=fujing&c=rencai&a=init&doty=1&ids=<?php echo $info['id']?>">锁定</a>
		  <?php } ?>
		      &nbsp;<a href="index.php?m=fujing&c=rencai&a=init&dofei=1&ids=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认作废当前记录吗？');if(!r){return false;}">作废</a>
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

function getsub(subid){
var subclass = new Array()
<?php for($i=0;$i<count($tcclass);$i++){?>
    subclass[<?php echo $i?>]=new Array('<?php echo $tcclass[$i]['id']?>','<?php echo $tcclass[$i]['classname']?>','<?php echo $tcclass[$i]['pid']?>')
<?php }?>

  onnew="";
  
  if(subid!=''){
    for(j=0,maxs=subclass.length;j<maxs;j++){
     if(subclass[j][2]==parseInt(subid)){	
       onnew+="<option value='"+subclass[j][0]+"'>"+subclass[j][1]+"</option>"	
  	 }
    }
  }else{
	  onnew+="<option value=''>不限</option>"  
	  }
  
  $("#tcid").html(onnew)  
}

function showxiang(id) {
	window.top.art.dialog({title:'查看详情', id:'showme', iframe:'?m=fujing&c=rencai&a=show&id='+id ,width:'600px',height:'650px'});
}

</script>
</body>
</html>