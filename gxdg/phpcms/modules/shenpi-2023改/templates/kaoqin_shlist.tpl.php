<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
//print_r($msgs);

/////////
if($msgs['dodt']>0){
	$yishenpi="<b color='red'>已审批</b>";
	$noshow="none";
	}
/////////
?>
<link href="<?php echo CSS_PATH?>dialog.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>dialog.js"></script>

<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">
<?php if($tablesss){?>
<table width="100%" border="0" align="left">
 <thead>
  <tr>
    <th align="center" width="5%">快捷工具</th>
    <?php if($_SESSION['roleid']>5){?><th align="center" width="5%"><input type="button" name="but1" value="申请部门审核" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:" onclick="bmshenhe('<?php echo $tables['yue']?>')" <?php echo $buttoncan?>/></th> <?php }?> 
	<?php if($_SESSION['roleid']<5){?><th align="center" width="5%"><input type="button" name="but1" value="申请政治处主任审核" style="border-radius:.4em;cursor:pointer; width:120px; height:25px; background-color:#06C; color:#FFF;display:" onclick="zzcshenhe('<?php echo $tables['yue']?>')" <?php echo $buttoncan?>/></th> <?php }?>   	
<?php
//审批
if($talbes['zzcuser']<1){
  if($show_table[0]['bmuser']<1){
    $shzt="未进入审核";	
	}else{
  if($show_table[0]['bmok']<1){
    $shzt="部门未审核";	
	}}		
}
?>	
    <th align="center" style="font-size:12px; width:250px">审批状态：<?php echo $shzt ?></th>
    <?php 
	//这里统计未通过部门领导审核的部门
	
	$weibao = $this->db->select(" bmok=0 ","count(id) as js,bmid","","","bmid");
	?>
    <th align="center" style="font-size:12px;">未上报单位：
    <?php if(count($weibao)>0){ ?>
      <select >
    <?php  
		foreach($weibao as $v){
		?>
        <option><?php echo $bms[$v[bmid]]?></option>
    <?php }?>    
     </select> 
    <?php }else{?>无<?php }?>
    </th>    
  </tr>
</thead>  
</table>
<div style="clear:both"></div>
<?php }?>

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>唐山高新区管委会短期合同制工作人员考勤表(<?php echo $dbnames?>)</b>&nbsp; <input type="button" name="but1" value="审核考勤" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:<?php echo $noshow?>" onclick="bmshenhe_do('<?php echo $dbnames?>','<?php echo $_GET['doty']?>','<?php echo $show_table[0]['bmid']?>','<?php echo $_GET['msgid']?>')" <?php echo $buttoncan?>/> <?php echo $yishenpi?></div>

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
	}else{
?>
    <tr><td align="center" colspan="<?php echo count($rowname)+3 ?>">未检索到相关数据集合</td></tr>
<?php }?>
</tbody>
 
</table>


<div style="font-size:14px; margin-top:5px">考勤标记说明：
<?php foreach($kqflag as $v){echo $v[1]."&nbsp;&nbsp;";} ?>
</div>
<div id="pages"><?php echo $pages?></div>

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

function bmshenhe(yue){ 
		window.top.art.dialog({title:'申请部门领导审核', id:'shows', iframe:'?m=gongzi&c=gzgl&a=kaoqinshenhe&ty=bm&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}
	
function bmshenhe_do(yue,doty,bmid,msgid){ 
		window.top.art.dialog({title:'考勤审核', id:'shows', iframe:'?m=shenpi&c=kaoqinshenpi&a=kaoqinshenpi_do&ty='+doty+'&yue='+yue+'&bmid='+bmid+'&msgid='+msgid,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
		
function zgshenhe(yue){ 
		window.top.art.dialog({title:'申请主管领导审核', id:'shows', iframe:'?m=gongzi&c=gzgl&a=kaoqinshenhe&ty=zg&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}
	
function zgshenhe_do(yue){ 
		window.top.art.dialog({title:'主管领导审核处理', id:'shows', iframe:'?m=gongzi&c=gzgl&a=kaoqinshenhe_do&ty=zg&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
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
