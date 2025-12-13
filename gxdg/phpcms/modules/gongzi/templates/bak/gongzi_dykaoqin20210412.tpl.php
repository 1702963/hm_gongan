<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<link href="<?php echo CSS_PATH?>dialog.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>dialog.js"></script>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">
<?php if($tables){?>
<table width="600px" border="0" align="left">
 <thead>
  <tr>
    <th align="center">快捷工具</th>
	<th align="center" ><input type="button" name="but1" value="申请政治处审核" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:" onclick="zzcshenhe('<?php echo $tables['yue']?>')" <?php echo $buttoncan?>/></th>
    <th align="center" ><input type="button" name="but1" value="申请局领导审核" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:" onclick="jushenhe('<?php echo $tables['yue']?>')" <?php echo $buttoncan?>/></th>
	
<?php
//审批
if($tables['zzcuser']<1){
$shzt="未进入审核";
}
if($tables['zzcuser']>0){
 if($tables['zzcuser']==$_SESSION['userid']){
   $shzt="<a href=\"javascript:;\" onclick=\"zzcshenhe_do('".$tables['yue']."')\"><font color=red>点击进行政治处审核</font></a>";
 }else{
  $shzt="政治处审核中";
 } 
}
if($tables['zzcok']>0){
  $shzt="<font color=green>政治处审核通过</font>";
}

if($tables['juuser']>0){
 if($tables['juuser']==$_SESSION['userid']){
   $shzt="<a href=\"javascript:;\" onclick=\"jushenhe_do('".$tables['yue']."')\"><font color=red>点击进行局领导审核</font></a>";
 }else{
  $shzt="局领导审核中";
 } 
}

if($tables['juok']>0){
  $shzt="<font color=green>审核全部通过</font>";
}

?>	
    <th align="center" style="font-size:12px; width:250px">审批状态：<?php echo $shzt ?></th>
  </tr>
</thead>  
</table>
<div style="clear:both"></div>
<?php }?>
<?php if($tables) { ?>
    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>唐山高新区管委会短期合同制工作人员考勤表(<?php echo $tables['yue']?>)</b><?php if($tables['islocked']==1){echo "&nbsp;<font color=red>锁定</font>";}?> <a id="fulla" href="javascript:;" onclick="open_win('index.php?m=gongzi&c=gzgl&a=yuekaoqin')">全屏模式</a></div>

<?php 
$t_rs=count($rowname)+3;
$t_width=50*$t_rs;

?>

<table width="<?php echo $t_width?>px" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px;width:35px">序号</th>
            <th align="center" style="font-size:12px;width:80px">姓名</th>
        <?php foreach($rowname as $rv){
			  if(date("w",strtotime($rv))==0 || date("w",strtotime($rv))==6){
				  $bcolor="#F96";
				  }else{
				  $bcolor=""; 	  
					  } 
			?>	
			<th align="center" style="font-size:12px; background-color:<?php echo $bcolor?>" onclick="piliang('<?php echo $rv?>','<?php echo $dbs?>')"><?php echo date("d",strtotime($rv))?></th>
        <?php }?>
            <th align="center" style="font-size:12px;width:150px">备注</th>
		</tr>
	</thead>
<tbody>
<?php

if(count($show_table)>0){
	
	if(intval($_GET['page'])==0){
	 $i=1;
	}else{
	 $i=intval($_GET['page']-1)*16+1;
	}
	foreach($show_table as $info){
		?>
	<tr <?php if(intval($_GET['yue'])<1){?>onclick="showtkapqons('<?php echo $info['id']?>','<?php echo $dbs?>')"<?php }?>>		
		<td align="center" ><?php echo $i?></td>
        <td align="center" ><?php echo $info['xingming']?></td>
        <?php foreach($rowname as $rv){
			  if(date("w",strtotime($rv))==0 || date("w",strtotime($rv))==6){
				  $bcolor="#F96";
				  }else{
				  $bcolor=""; 	  
					  } 			
			?>	
			<td align="center" style="background-color:<?php echo $bcolor?>"><?php echo $kqflag[$info[$rv]][0]?></td>
        <?php }?>
            <td align="center" ><?php echo $info['beizhu']?></td>           
	</tr>
	<?php
	$i++;
	}	
	}
?>
</tbody>
 
</table>


<div style="font-size:14px; margin-top:5px">考勤标记说明：
<?php foreach($kqflag as $v){echo $v[1]."&nbsp;&nbsp;";} ?>
</div>
<div id="pages"><?php echo $pages?></div>
<?php }else{?>

<table width="50%" border="1" align="center" style="margin-top:200px">
<thead>
  <tr>
    <th>没有未结转的默认考勤表，请选择要查看的历史考勤表</td>
  </tr>
</thead>
<form action="" method="get"> 
<input type="hidden" name="m" value="gongzi"/>
<input type="hidden" name="c" value="gzgl"/>
<input type="hidden" name="a" value="yuekaoqin"/>   
  <tr>
    <td align="center"><select name="yue">
         <?php foreach($tableslist as $v){?>
           <option value="<?php echo $v['id']?>"><?php echo $v['yue']?></option>
         <?php }?>
        </select>  <input type="submit" name="xuanze" value="查看" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF"/> </td>
  </tr>
</form> 
 <tr>
  <td>&nbsp; * 历史考勤表只能查阅，无法进行操作</td>
 </tr>  
</table>

<?php }?>
</div>
</div>
<script type="text/javascript">

function showtkapqons(id,dbs) {
		window.top.art.dialog({title:'考勤录入/编辑', id:'shows', iframe:'?m=gongzi&c=gzgl&a=showkaoqinedit&id='+id+'&dbs='+dbs ,width:'1300px',height:'550px'},function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}

function piliang(days,dbs) {
		window.top.art.dialog({title:'批量编辑', id:'shows', iframe:'?m=gongzi&c=gzgl&a=kaoqinpiliang&days='+days+'&dbs='+dbs ,width:'480px',height:'300px'},function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}

function zzcshenhe(yue){ 
		window.top.art.dialog({title:'申请政治处审核', id:'shows', iframe:'?m=gongzi&c=gzgl&a=kaoqinshenhe&ty=zzc&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}
	
function zzcshenhe_do(yue){ 
		window.top.art.dialog({title:'政治处审核处理', id:'shows', iframe:'?m=gongzi&c=gzgl&a=kaoqinshenhe_do&ty=zzc&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
	
function jushenhe(yue){ 
		window.top.art.dialog({title:'申请局领导审核', id:'shows', iframe:'?m=gongzi&c=gzgl&a=kaoqinshenhe&ty=ju&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}

function jushenhe_do(yue){ 
		window.top.art.dialog({title:'局领导审核处理', id:'shows', iframe:'?m=gongzi&c=gzgl&a=kaoqinshenhe_do&ty=ju&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	

	
function open_win(urls)
{
window.open(urls,"fulls","channelmode=yes,fullscreen=yes,toolbar=no, location=no, titlebar=no,directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no,top=0,left=0,width="+screen.width+",height="+screen.height)
}	

if(window.name=="fulls"){
	$("#fulla").css("display","none")
	}							
</script>
</body>
</html>
