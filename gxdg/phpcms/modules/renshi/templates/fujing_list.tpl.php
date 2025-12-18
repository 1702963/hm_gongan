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

//民警职务
		$this->db->table_name = 'v9_zhiwu_mj';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu_mj=array(0=>"无职务");
		
		foreach($rss as $aaa){
			$zhiwu_mj[$aaa['id']]=$aaa['zwname'];
			
			}
			
		//民警学历
		$this->db->table_name = 'v9_xueli';
		$rss = $this->db->select("",'id,gwname_mj','','id asc');
		
		foreach($rss as $aaa){
			$xueli_mj[$aaa['id']]=$aaa['gwname_mj'];
			}			
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
	//if(window.top.$("#current_pos").data('clicknum')==1 || window.top.$("#current_pos").data('clicknum')==null) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?m=admin&c=bumen&a=bumen_tree&pc_hash=<?php echo $_SESSION['pc_hash'];?>&mm=renshi&cc=renshi&aa=init&status=<?php echo $status;?>';
	//window.top.$("#current_pos").data('clicknum',0);
	//window.top.$("#leftMain").load("?m=admin&c=index&a=public_menu_left&menuid=1780");

//}
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
input.button {padding:0 15px}
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
<div class="tableContent">
<div class="pad-lr-10">
<?php if($_SESSION['roleid']<2){?>
<form name="searchform" action="" method="post" >
<input type="hidden" value="renshi" name="m">
<input type="hidden" value="renshi" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $status;?>" name="status">
<div class="explain-col"> 
  快速工具:   人员表锁定 <select name="lockclass" style="margin-right:10px">
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
<label><input type="radio" name="lockeds" style="margin-right:10px" value="0" />解锁</label>
<label><input type="radio" name="lockeds" style="margin-right:10px" value="1" checked="checked"/>锁定</label>                      
<input type="submit" value="锁定" style="margin-left:10px" class="doLock" name="dook"> &nbsp; 

<a href="index.php?m=renshi&c=renshi&a=add" class="modChange"><input type="button" value="辅警新录" style="margin-left:10px;width:90px" class="doSearch" name="addfj" ></a>  &nbsp;
<a href="index.php?m=renshi&c=renshi&a=addmj" class="modChange"><input type="button" value="民警新录" style="margin-left:10px;width:90px" class="doSearch" name="addmj" ></a>
		</div>
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
    	<table width="1470" border="0">
        	<tr>
            	<td width="120">姓名：
					<input type="text" value="<?php echo $xingming?>" class="input-text" size="6" name="xingming">
                </td>
                <td width="240">单位：
                    <select name="dwid">
						<option value="">不限</option> 
						<?php ksort($bms);foreach($bms as $k=>$v){?>
						<option value="<?php echo $k?>" <?php if($k==$dwid){?>selected="selected"<?php }?> ><?php echo $v?></option>
						<?php }?>
					</select>
                </td>
                <td width="120">民警：
					<select name="ismj">
						<option value="">不限</option>
						<option value="1" <?php if($ismj=="1"){?>selected="selected"<?php }?>>民警</option>
						<option value="0" <?php if($ismj=="0"){?>selected="selected"<?php }?>>辅警</option>
					</select>
                </td>                
                <td width="120">性别：
					<select name="sex">
						<option value="">不限</option>
						<option value="男" <?php if($sex=="男"){?>selected="selected"<?php }?>>男</option>
						<option value="女" <?php if($sex=="女"){?>selected="selected"<?php }?>>女</option>
					</select>
                </td>
                <td width="250">年龄：
					<select name="agetj">
						<option value="">不限</option> 
						<option value="=" <?php if($_GET['agetj']=="="){?>selected="selected"<?php }?>>区间</option>
					</select>
                    <input type="text" value="<?php echo $age1 ?>" class="input-text" size="2" name="age1">&nbsp;至&nbsp; <input type="text" value="<?php echo $age2 ?>" class="input-text" size="2" name="age2">
                </td>
                <td width="190">学历：
					<select name="xueli">
						<option value="">不限</option>
						<?php foreach($xueli as $k=>$v){?>
						<option value="<?php echo $k?>" <?php if($k==$xueli){?>selected="selected"<?php }?> ><?php echo $v?></option>
						<?php }?>
					</select>
                </td>
                <td width="200">
  					<input type="submit" value="查询" class="doSearch" name="dotongji">
                    <a href="index.php?m=renshi&c=renshi&a=dao2xls&status=<?php echo $status?>&xingming=<?php echo $xingming?>&dwid=<?php echo $dwid?>&sex=<?php echo $sex?>&agetj=<?php echo $_GET['agetj']?>&age1=<?php echo $age1?>&age2=<?php echo $age2?>&xueli=<?php echo $xuelis?>&rjtj=<?php echo $_GET['rjtj']?>&rjtime=<?php echo date("Y-m-d",$rjtimes)?>&rjtime2=<?php echo date("Y-m-d",$rjtimes2)?>&gangwei=<?php echo $gangweis?>&gangweifz=<?php echo $gangweifzs?>&zhiwu=<?php echo $zhiwus?>&cengji=<?php echo $cengjis?>&zzmm=<?php echo $zzmms?>&tuiwu=<?php echo $tuiwus?>&gzz=<?php echo $_GET['gzz']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" target="_blank"><input type="button" value="导出" class="doExport" id="daochu" > </a>
                    <input type="button" value="展《" class="button" id="mianban" onclick="showkuozhan()" style="width:40px">
                </td>
            </tr>
        </table>
    
    </td>
    </tr>
  <tr id="kuozhan1" style="display:none">
    <td height="30">
    <div style="width:100%;height:15px"></div>
   入警时间：
					<select name="rjtj">
						<option value="">不限</option>
						<option value="=" <?php if($_GET['rjtj']=="="){?>selected="selected"<?php }?>>区间</option>
					</select>
                    <?php if(!isset($rjtimes)){$rjtimes=time();} echo form::date('rjtime',date("Y-m-d",$rjtimes),0,0,'false');?>
                    至
                    <?php if(!isset($rjtimes2)){$rjtimes2=time();} echo form::date('rjtime2',date("Y-m-d",$rjtimes2),0,0,'false');?>
                      
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
   警号：<input type="text" name="gzz" class="input-text" value="<?php echo $_GET['gzz']?>" size="10"/>     
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
  <input type="submit" value="查询" class="doSearch" name="dotongji">  
  <a href="index.php?m=renshi&c=renshi&a=dao2xls&status=<?php echo $status?>&xingming=<?php echo $xingming?>&dwid=<?php echo $dwid?>&sex=<?php echo $sex?>&agetj=<?php echo $_GET['agetj']?>&age=<?php echo $age?>&xueli=<?php echo $xuelis?>&rjtj=<?php echo $_GET['rjtj']?>&rjtime=<?php echo date("Y-m-d",$rjtimes)?>&rjtime2=<?php echo date("Y-m-d",$rjtimes2)?>&gangwei=<?php echo $gangweis?>&gangweifz=<?php echo $gangweifzs?>&zhiwu=<?php echo $zhiwus?>&cengji=<?php echo $cengjis?>&zzmm=<?php echo $zzmms?>&tuiwu=<?php echo $tuiwus?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" target="_blank"><input type="button" value="导出" class="doExport" id="daochu" > </a>  
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
     
      <th width='63'>序号</th>
      
      <th width="120">工作单位</th>
	  <th width='103'>姓名</th>
	   <th width="50">性别</th>
      <th width="165">身份证号</th>
	  <th width="84">年龄</th>
      <th width="119">出生日期</th>
      <th width="162">学历</th>
      <th width="103">民/辅警</th>  
      <th width="103">政治面貌</th>
      <th width="73">退役</th>
      <th width="103">岗位类别</th>
      <th width="121">辅助岗位</th>
      <th width="110">职务</th>
      <th width="150">层级</th>
      <th width="86">电话</th>
      <th width="220">操作</th>
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
	
	$ismj[0]="辅警";
	$ismj[1]="民警";
	
	
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
	  <td>
	  	<?php 
			$demoData=$info['sex'];
			if($demoData=="男") { echo '<div class="sexyMale">'.$demoData.'</div>'; }
			if($demoData=="女") { echo '<div class="sexyFemale">'.$demoData.'</div>'; }
		?>
      </td>
      <td><?php echo $info['sfz']?></td>
	  <td><?php echo $nianling?></td>
      <td><?php if($info['shengri']!=''){echo date("Y-m-d",$info['shengri']);}?></td>
      <td><?php 
	  if($info['ismj']==0){
	    echo $xueli[$info['xueli']];
	  }else{
		if($info['zz_xueli']==""){
			echo $xueli_mj[$info['xueli']];
			}else{
			echo $xueli_mj[$info['zz_xueli']];	
				}  
	  }
	  ?></td>
      <td><?php 
			if($info['ismj']==0) { echo '<div class="sexyMale">辅警</div>'; }
			if($info['ismj']==1) { echo '<div class="sexyFemale">民警</div>'; }
	  ?></td>
      <td>
	  	<?php 
			$demoData=$zzmm[$info['zzmm']];
			if($demoData=="中共党员") { 
				echo '<div class="PaCpc">'.$demoData.'</div>'; 
			}elseif( $demoData=="共青团员") { 
				echo '<div class="PaYlm">'.$demoData.'</div>'; 
			} else { 
				 echo '<div class="PaCc">'.$demoData.'</div>'; 
			}
		?>
      </td>
      <td><?php echo $tuiyi[$info['tuiwu']];?></td>
      <td><?php echo $gangwei[$info['gangwei']];?></td>
      <td><?php echo $gangweifz[$info['gangweifz']];?></td>
      <td>
	  	<?php 
		if($info['ismj']==0){
			//echo $zhiwu[$info['zhiwu']];
			$demoData=$zhiwu[$info['zhiwu']];
			if($demoData=="辅警长") { 
				echo '<div class="gmDaps">'.$demoData.'</div>'; 
			}elseif( $demoData=="助理辅警长") { 
				echo '<div class="gmAa">'.$demoData.'</div>'; 
			} else { 
				 echo '<div class="gmAp">'.$demoData.'</div>'; 
			}
		}else{
			echo '<div class="gmDaps">'.$zhiwu_mj[$info['zhiwu']].'</div>';
			}
		?>
      </td>
      <td><?php echo $cengji[$info['cengji']];?></td>
      <td><?php echo $info['tel'];?></td>
      <td>&nbsp;<a href="index.php?m=renshi&c=renshi&a=show&id=<?php echo $info['id']?>&status=<?php echo $status;?>" class="modView">查看</a>
          <?php if($_SESSION['roleid']>5){
			   if($info['islock']<1){
			  ?>
              &nbsp;<a href="index.php?m=renshi&c=renshi&a=edit&id=<?php echo $info['id']?>&status=<?php echo $status;?>" class="modChange">修改</a>
		  <?php }}else{ ?>
              &nbsp;<a href="index.php?m=renshi&c=renshi&a=edit&id=<?php echo $info['id']?>&status=<?php echo $status;?>" class="modChange">修改</a>
		  <?php }?>
          <div style="width:100%;height:5px;overflow:hidden"></div>
          <?php if($_SESSION['roleid']<2){ 
		          if($info["islock"]>0){
		   ?>             
              &nbsp;<a href="index.php?m=renshi&c=renshi&a=init&doty=0&ids=<?php echo $info['id']?>&status=<?php echo $status;?>">解锁</a>
		  <?php }else{?>
              &nbsp;<a href="index.php?m=renshi&c=renshi&a=init&doty=1&ids=<?php echo $info['id']?>&status=<?php echo $status;?>" class="modLock">锁定</a>
		  <?php } ?>
		      &nbsp;<a href="index.php?m=renshi&c=renshi&a=init&dofei=1&ids=<?php echo $info['id']?>&status=<?php echo $status;?>" onclick="javascript:var r = confirm('确认作废当前记录吗？');if(!r){return false;}" class="modCancel">作废</a>
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