<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new', 'admin');


$tuiyi[1]="是";
$tuiyi[2]="否";

		$this->db->table_name = 'mj_bumen';
		$rss = $this->db->select("",'id,name','','id asc');
		$bms[]="";
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			}	


		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$this->db->table_name = 'mj_biaozhang_log';
		$where=" isok=1 and mleixing='文明标兵' ";
		$orders=" id desc ";
		$bzlist = $this->db->listinfo($where,$order = $orders,$page, $pages = '12');
		$pages = $this->db->pages;

?>

<SCRIPT LANGUAGE="JavaScript">
<!--
	if(window.top.$("#current_pos").data('clicknum')==1 || window.top.$("#current_pos").data('clicknum')==null) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?m=admin&c=bumen&a=bumen_tree&pc_hash=<?php echo $_SESSION['pc_hash'];?>&mm=biaozhang&cc=biaozhang&aa=wmbb&status=<?php echo $status;?>';
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
</style>
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<div class="tableContent">
<div class="pad-lr-10">
<?php if($_SESSION['roleid']<2){?>
<form name="searchform" action="" method="post" >
<input type="hidden" value="biaozhang" name="m">
<input type="hidden" value="biaozhang" name="c">
<input type="hidden" value="wmbb" name="a">
<input type="hidden" value="<?php echo $status;?>" name="status">
<div class="explain-col"> 
  快速工具:   文明标兵 &nbsp;                      
<a href="?m=biaozhang&c=biaozhang&a=addwmbb"><input type="button" value="新增" class="button" name="dook"></a>  
		</div>
</form>

<form name="searchform" method="get" id="daoxls" >
<input type="hidden" value="biaozhang" name="m">
<input type="hidden" value="biaozhang" name="c">
<input type="hidden" value="wmbb" name="a">
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
  奖励类别: <select name="agetj">
            <option value="">不限</option> 
           </select>
&nbsp;
  <input type="submit" value="查询" class="button" name="dotongji">  
  <a href="index.php?m=fujing&c=fujing&a=dao2xls&status=<?php echo $status?>&xingming=<?php echo $xingming?>&dwid=<?php echo $dwid?>&sex=<?php echo $sex?>&agetj=<?php echo $_GET['agetj']?>&age1=<?php echo $age1?>&age2=<?php echo $age2?>&xueli=<?php echo $xuelis?>&rjtj=<?php echo $_GET['rjtj']?>&rjtime=<?php echo date("Y-m-d",$rjtimes)?>&rjtime2=<?php echo date("Y-m-d",$rjtimes2)?>&gangwei=<?php echo $gangweis?>&gangweifz=<?php echo $gangweifzs?>&zhiwu=<?php echo $zhiwus?>&cengji=<?php echo $cengjis?>&zzmm=<?php echo $zzmms?>&tuiwu=<?php echo $tuiwus?>&gzz=<?php echo $_GET['gzz']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" target="_blank"><input type="button" value="导出" class="button" id="daochu" style="display:none"> </a>  
  <input type="button" value="展《" class="button" id="mianban" onclick="showkuozhan()" style="width:40px; display:none">  
    </td>
    </tr>
  <tr id="kuozhan1" style="display:none">
    <div style="width:100%;height:15px"></div>
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
       </select>&nbsp;&nbsp;
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
           </select><input type="text" value="<?php echo $tizhong?>" class="input-text" size="6" name="tizhong">&nbsp;&nbsp; <br>    
   辅警号：<input type="text" name="gzz" class="input-text" value="<?php echo $_GET['gzz']?>" size="10"/>     
    </td>
    </tr>    
</table>
	</div>
</form>
<?php }?>
<?php if($_SESSION['roleid']==9){?>
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
  <a href="index.php?m=fujing&c=fujing&a=dao2xls&status=<?php echo $status?>&xingming=<?php echo $xingming?>&dwid=<?php echo $dwid?>&sex=<?php echo $sex?>&agetj=<?php echo $_GET['agetj']?>&age=<?php echo $age?>&xueli=<?php echo $xuelis?>&rjtj=<?php echo $_GET['rjtj']?>&rjtime=<?php echo date("Y-m-d",$rjtimes)?>&rjtime2=<?php echo date("Y-m-d",$rjtimes2)?>&gangwei=<?php echo $gangweis?>&gangweifz=<?php echo $gangweifzs?>&zhiwu=<?php echo $zhiwus?>&cengji=<?php echo $cengjis?>&zzmm=<?php echo $zzmms?>&tuiwu=<?php echo $tuiwus?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" target="_blank"><input type="button" value="导出" class="button" id="daochu" > </a>  
  <input type="button" value="展《" class="button" id="mianban" onclick="showkuozhan()" style="width:40px">  
    </td>
    </tr>
  <tr id="kuozhan1" style="display:none">
    <td height="30">
    <div style="width:100%;height:15px"></div>
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
           </select><input type="text" value="<?php echo $shengao?>" class="input-text" size="6" name="shengao">&nbsp;&nbsp;<br><br>
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
    $(".kotable tbody tr:odd").addClass("odd");
	$(".kotable tbody tr:even").addClass("even");
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
.table-list td, .table-list th {padding:0;margin:0}
.table-list tbody td {padding:0}
.kotable {border-top:1px solid #ddd;border-left:1px solid #ddd;margin-top:10px;float:left}
.kotable th {border-right:1px solid #ddd;border-bottom:1px solid #ddd;background:#cee8ff;text-align:center;line-height:36px}
.kotable td {border-right:1px solid #ddd;border-bottom:1px solid #ddd;text-align:center;line-height:32px}
.table-list td {font-size:12px}
.odd {	background:#f7f7f7;	}
.iover {background:#FFFDE8 }

#pages {width:100%;float:left;margin-top:5px}
*/
</style>
<table width="100%" cellspacing="0" class="kotable">
	<thead>
	<tr>
      <th width='99'>序号</th>
      <th width="193">工作单位</th>
	  <th width='165'>姓名</th>
	  <th width="115">性别</th>
      <th width="264">身份证号</th>
	  <th width="205">月度</th>
      <th width="410">受奖励时单位</th>
      <th width="186">审核</th>
      <th width="217">操作</th>
	</tr>
    </thead>
    <tbody>
  <?php
  
if(is_array($bzlist)){
	
	if(intval($_GET['page'])>1){
	 $i=12*(intval($_GET['page'])-1)+1;
	}else{
	 $i=1;
	}
	
	foreach($bzlist as $info){
	
		?>
	<tr>
      
      <td><?php echo $i?></td>
      <td><?php echo $bms[$info['dwid']];?></td>
      <td><?php echo $info['xingming']?></td>
	  <td><?php echo $info['sex']?></td>
      <td><?php echo $info['sfz']?></td>
	  <td><?php echo date("Y-m",$info['yuedu'])?></td>
      <td><?php echo $info['jldanwei']?></td>
      <td><?php 
	         if($info['shenhe']==0){
				 echo "待审核";
				 }
			  if($info['shenhe']==1){
					 echo "已审核";
					 }
			  if($info['shenhe']==-1){
					 echo "退回";
					 }	 
	  
	  ?></td>
      <td>
        <a href="index.php?m=biaozhang&c=biaozhang&a=wmbbshow&id=<?php echo $info['id']?>&status=<?php echo $status;?>">查看</a>
        
        &nbsp;<a href="index.php?m=biaozhang&c=biaozhang&a=editwmbb&id=<?php echo $info['id']?>&status=<?php echo $status;?>">修改</a>
        
        &nbsp;<a href="index.php?m=biaozhang&c=biaozhang&a=wmbbzuofei&dofei=1&ids=<?php echo $info['id']?>&status=<?php echo $status;?>" onclick="javascript:var r = confirm('确认作废当前记录吗？');if(!r){return false;}">作废</a>             
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