<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

//默认工具按钮禁用
$buttoncan="disabled=\"disabled\"";
if($_SESSION['roleid']<=5){
 $buttoncan="";
}
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">
<table width="1100px" border="0" align="left">
    <?php if($_SESSION['roleid']!=7){?>
 <thead>
  <tr>
    <th align="center" width="80px">快捷工具</th>
    <th align="center"><input type="button" name="but1" value="关联特殊任务" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF" onclick="tools_renwu('<?php echo $_GET['yue']?>')" <?php echo $buttoncan?>/></th>
    <th align="center"><input type="button" name="but1" value="关联突出贡献" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF" onclick="tools_gongxian('<?php echo $_GET['yue']?>')" <?php echo $buttoncan?>/></th>
	<th align="center" ><input type="button" name="but1" value="申请政治处审核" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:" onclick="zzcshenhe('<?php echo $_GET['yue']?>')" <?php echo $buttoncan?>/></th>
    <th align="center" ><input type="button" name="but1" value="申请局领导审核" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:" onclick="jushenhe('<?php echo $_GET['yue']?>')" <?php echo $buttoncan?>/></th>
    
    <th align="center" ><a href="index.php?m=gongzi&c=gzgl&a=daotsrenwu&yue=<?php echo $_GET['yue']?>" target="_blank"><input type="button" name="but1" value="导出特殊任务审批表" style="border-radius:.4em;cursor:pointer; width:120px; height:25px; background-color:#06C; color:#FFF;display:" <?php echo $buttoncan?>/></a></th>
    <th align="center" ><a href="index.php?m=gongzi&c=gzgl&a=daotcgongxian&yue=<?php echo $_GET['yue']?>" target="_blank"><input type="button" name="but1" value="导出突出贡献审批表" style="border-radius:.4em;cursor:pointer; width:120px; height:25px; background-color:#06C; color:#FFF;display:" <?php echo $buttoncan?>/></a></th>

	
<?php
//审批
if($show_table[0]['zzcuser']<1){
$shzt="未进入审核";
}
if($show_table[0]['zzcuser']>0){
 if($show_table[0]['zzcuser']==$_SESSION['userid']){
   $shzt="<a href=\"javascript:;\" onclick=\"zzcshenhe_do('".$_GET['yue']."')\"><font color=red>点击进行政治处审核</font></a>";
 }else{
  $shzt="政治处审核中";
 } 
}
if($show_table[0]['zzcok']>0){
  $shzt="<font color=green>政治处审核通过</font>";
}

if($show_table[0]['juuser']>0){
 if($show_table[0]['juuser']==$_SESSION['userid']){
   $shzt="<a href=\"javascript:;\" onclick=\"jushenhe_do('".$_GET['yue']."')\"><font color=red>点击进行局领导审核</font></a>";
 }else{
  $shzt="局领导审核中";
 } 
}

if($show_table[0]['juok']>0){
  $shzt="<font color=green>审核全部通过</font>";
}

?>	
    <th align="center" style="font-size:12px; width:250px">审批状态：<?php echo $shzt ?></th>
  </tr>
</thead>
    <?php }?>  
</table>
<div style="clear:both"></div>
    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>高新公安分局<?php $dys=$_GET['yue']."01"; echo date("Y年m月",strtotime($dys))?>辅警绩效奖金、加班费发放表</b></div>
    <?php if($_SESSION['roleid']<=5 || $_SESSION['roleid']==7){?>
    <form action="" method="get">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="ydjxgzb"/>
    <input type="hidden" name="yue" value="<?php echo $_GET['yue']?>"/>  
      <div style=" width:100%;font-size:12px; text-align:center; margin-bottom:5px">选择部门
               <select name="bms" id="bms" >
                <?php foreach($bumen as $k=>$v){?>
                <option value="<?php echo $k?>" <?php if(intval($_GET['bms'])==$k){?> selected="selected"<?php }?> ><?php echo $v?></option>
                <?php }?>
               </select>&nbsp;<span style="display:none">
               姓名&nbsp;<input name="xingming" value="" /> &nbsp; </span>
               <input type="submit" name="dosel" value="定位" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF"/>
      </div>
    </form> 
	 <?php }?>
<table width="98%" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px">序号</th>
            <th align="center" style="font-size:12px">姓名</th>
            <th align="center" style="font-size:12px; width:100px">身份证号</th>
            <th align="center" style="font-size:12px">单位</th>
            <th align="center" style="font-size:12px">操作</th>
            <th align="center" style="font-size:12px">考核结果</th>
            <th align="center" style="font-size:12px">绩效奖金</th>
            <th align="center" style="font-size:12px">扣除金额</th>
            <th align="center" style="font-size:12px">扣除原因</th>
            <th align="center" style="font-size:12px">加班费</th>
            <th align="center" style="font-size:12px">特殊岗位工资</th>
            <th align="center" style="font-size:12px">突出贡献奖</th>
            <th align="center" style="font-size:12px">实发金额</th>
            <th align="center" style="font-size:12px">备注</th>
		</tr>
	</thead>
<tbody>
<?php 
      if(intval($_GET["page"])>1){
	    $i=10*intval($_GET["page"])+1;
	  }else{
		$i=1;  
		  }
      if(is_array($show_table)){
	  foreach($show_table as $info){
	?>
	<tr>		
		<td align="center" ><?php echo $i;?></td>
		<td align="center" ><?php echo $fujings[$info['userid']]?></td>
		<td align="center" ><?php echo $info['sfz']?></td>
		<td align="center" ><?php echo $bumen[$info['bmid']]?></td>
		<td align="center" ><input type="button" name="shome" value="查看" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="showjxgzb('<?php echo $info['id']?>')"/></td>
		<td align="center" ><?php echo $dengji[$info['khjieguo']]?></td>
        <td align="center" ><?php echo $info['jxjj']?></td>
		<td align="center" ><?php echo $info['koufa']?></td>
		<td align="center" ><?php echo $info['koufayy']?></td>
		<td align="center" ><?php echo $info['jiaban']?></td>
		<td align="center" ><a href="javascript:;" <?php if($info['renwugl']!=""){?>onclick="tools_renwu_jc('<?php echo $_GET['yue']?>','<?php echo $info['id']?>')" title="解除关联" style="color:#F36"<?php }?>><?php echo $info['tsrenwu']?></a></td>
		<td align="center" ><a href="javascript:;" <?php if($info['gongxiangl']!=""){?>onclick="tools_gongxian_jc('<?php echo $_GET['yue']?>','<?php echo $info['id']?>')" title="解除关联" style="color:#F36"<?php }?>><?php echo $info['tcgongxian']?></a></td>
		<td align="center" ><?php echo $info['shifa']?></td>
		<td align="center" ><textarea name="beizhu" rows="1" readonly="readonly" style="width:90%"><?php echo $info['beizhu']?></textarea></td>      
     
	</tr>
<?php $i++;}}?>
  <tr>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3">合计</th>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3">&nbsp;</th>
            <th align="center" style="font-size:12px; width:100px" bgcolor="#c5d3e3">&nbsp;</th>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3">&nbsp;</th>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3">&nbsp;</th>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3">&nbsp;</th>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3"><?php echo $jxjj['hj']?></th>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3"><?php echo $koufa['hj']?></th>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3">&nbsp;</th>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3"><?php echo $jiaban['hj']?></th>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3"><?php echo $tsrenwu['hj']?></th>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3"><?php echo $tcgongxian['hj']?></th>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3"><?php echo $shifa['hj']?></th>
            <th align="center" style="font-size:12px" bgcolor="#c5d3e3">&nbsp;</th>
  </tr> 
  <tr> 
  <td style="font-size:12px;" bgcolor="#c5d3e3" align="left" colspan="14">
   <b>人员合计: <?php echo $hj_rs[hj]?>人 ; 突出贡献 ：<?php echo $hj_tcgx[hj]?> 人 ; 优秀：<?php echo $hj_yx[hj]?>人  ; 合格：<?php echo $hj_hg[hj]?>人  ; 不合格：<?php echo $hj_bhg[hj]?> 人  ; 特殊任务:<?php echo $hj_tsrw[hj]?>人</b>        
  </td>
  </tr>
</tbody>
 
</table>

<div id="pages"><?php echo $pages?></div>
</div>
</div>
<script language="javascript">
function tools_kaoqin(yue) {
	    bmid=document.getElementById('bms').value;
		window.top.art.dialog({title:'审核申请-政治处', id:'showtools', iframe:'?m=gongzi&c=jixiao&a=jxgzbshzzc&yue='+yue+"&bmid="+bmid ,width:'1020px',height:'550px'},function(){var d = window.top.art.dialog({id:'showtools'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'showtools'}).close()});
	}

function tools_gongxian(yue) {
	    bmid=document.getElementById('bms').value;
		window.top.art.dialog({title:'绩效工具-突出贡献', id:'showtools', iframe:'?m=gongzi&c=jixiao&a=toolsgongxian&yue='+yue+"&bmid="+bmid ,width:'1020px',height:'550px'},function(){var d = window.top.art.dialog({id:'showtools'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'showtools'}).close()});
	}

function tools_gongxian_jc(yue,id) {
	    bmid=document.getElementById('bms').value;
		window.top.art.dialog({title:'绩效工具-解除突出贡献关联', id:'showtools', iframe:'?m=gongzi&c=jixiao&a=toolsgongxianjc&yue='+yue+"&bmid="+bmid+"&id="+id ,width:'1020px',height:'550px'},function(){var d = window.top.art.dialog({id:'showtools'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'showtools'}).close()});
	}
		
function tools_renwu(yue) {
	    bmid=document.getElementById('bms').value;
		window.top.art.dialog({title:'绩效工具-特殊任务', id:'showtools', iframe:'?m=gongzi&c=jixiao&a=toolsrenwu&yue='+yue+"&bmid="+bmid ,width:'1020px',height:'550px'},function(){var d = window.top.art.dialog({id:'showtools'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'showtools'}).close()});
	}	

function tools_renwu_jc(yue,id) {
	    bmid=document.getElementById('bms').value;
		window.top.art.dialog({title:'绩效工具-解除特殊任务关联', id:'showtools', iframe:'?m=gongzi&c=jixiao&a=toolsrenwujc&yue='+yue+"&bmid="+bmid+'&id='+id ,width:'1020px',height:'550px'},function(){var d = window.top.art.dialog({id:'showtools'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'showtools'}).close()});
	}		
	
function showjxgzb(id) {
		window.top.art.dialog({title:'绩效工资表编辑', id:'showtools', iframe:'?m=gongzi&c=jixiao&a=jxgzbedit&id='+id,width:'1020px',height:'550px'},function(){var d = window.top.art.dialog({id:'showtools'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'showtools'}).close()});
	}	
	
function zzcshenhe(yue){ 
		window.top.art.dialog({title:'申请政治处审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=jxgzbshenhe&ty=zzc&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}
	
function zzcshenhe_do(yue){ 
		window.top.art.dialog({title:'政治处审核处理', id:'shows', iframe:'?m=gongzi&c=jixiao&a=jxgzbshenhe_do&ty=zzc&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
	
function jushenhe(yue){ 
		window.top.art.dialog({title:'申请局领导审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=jxgzbshenhe&ty=ju&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}

function jushenhe_do(yue){ 
		window.top.art.dialog({title:'局领导审核处理', id:'shows', iframe:'?m=gongzi&c=jixiao&a=jxgzbshenhe_do&ty=ju&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}						
</script>
</body>
</html>
