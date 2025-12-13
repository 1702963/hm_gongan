<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>辅警特殊任务管理</b></div>
    <?php if($_SESSION['roleid']==1||$_SESSION['roleid']==2||$_SESSION['roleid']==3){?>
    <form action="" method="get">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="tsrenwu"/>
    <input type="hidden" name="yue" value="<?php echo $_GET['yue']?>"/>  
      <div style=" width:100%;font-size:12px; text-align:center; margin-bottom:5px">选择部门
               <select name="bms">
                <?php foreach($bumen as $k=>$v){?>
                <option value="<?php echo $k?>" <?php if(intval($_GET['bms'])==$k){?> selected="selected"<?php }?> ><?php echo $v?></option>
                <?php }?>
               </select>
               <input type="submit" name="dosel" value="定位" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF"/>
      </div>
     </form> 
	 <?php }?>

<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px">序号</th>
            <th align="center" style="font-size:12px">姓名</th>
            <th align="center" style="font-size:12px">身份证号</th>
            <th align="center" style="font-size:12px">单位</th>
            <th align="center" style="font-size:12px">任务名称</th>
            <th align="center" style="font-size:12px">补助金额</th>
            <th align="center" style="font-size:12px">部门审核</th>
            <th align="center" style="font-size:12px">分管领导审核</th> 
            <th align="center" style="font-size:12px">政治部审核</th>
            <th align="center" style="font-size:12px">局领导审核</th>
            <th align="center" style="font-size:12px">审核进度</th>
            <th align="center" style="font-size:12px">操作</th>
		</tr>
	</thead>
<tbody>
<?php if(is_array($show_table)){
	   $i=1;
	  foreach($show_table as $info){
	    $bcolor="";	  
		if($info['bmmast']>0 && $info['bmmastdt']<1){
			$bcolor="style=\"background-color:#FFC\"";
			}
				
		if($info['zzcmast']>0 && $info['zzcmastdt']<1){
			$bcolor="style=\"background-color:#e8b853\"";
			}
				
		if($info['jumast']>0 && $info['jumastdt']<1){
			$bcolor="style=\"background-color:#ffd7c4\"";
			}
			
	    //$nosq1="disabled=\"disabled\"";	
		//$nosq2="disabled=\"disabled\"";	
		//$nosq3="disabled=\"disabled\"";	
		//$nosq4="disabled=\"disabled\"";	
											
	?>
	<tr>		
		<td <?php echo $bcolor?> align="center" ><?php echo $i?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $fujings[$info['userid']]?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['sfz']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $bumen[$info['bmid']]?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['rwname']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['je']?> 元</td>
        <td <?php echo $bcolor?> align="center" ><?php if($_SESSION['userid']==$info['bmuser']){?><a href="javascript:;" onclick="gongxianedits('<?php echo $info['id']?>')">点击审核<?php echo $shs[$info['bmok']]?></a><?php }else{ ?><input type="button" name="shenhe1" value="申请审核" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="shenhebm('<?php echo $info['id']?>')" <?php echo $nosq1?>/> <?php }?></td>
		<td <?php echo $bcolor?> align="center" ><?php if($_SESSION['userid']==$info['fguser']){?><a href="javascript:;" onclick="gongxianedits('<?php echo $info['id']?>')">点击审核<?php echo $shs[$info['fgok']]?></a><?php }else{ ?><input type="button" name="shenhe3" value="申请审核" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="shenhefg('<?php echo $info['id']?>')" <?php echo $nosq1?>/><?php }?></td>		
		<td <?php echo $bcolor?> align="center" ><?php if($_SESSION['userid']==$info['zzcuser']){?><a href="javascript:;" onclick="gongxianedits('<?php echo $info['id']?>')">点击审核<?php echo $shs[$info['zzcok']]?></a><?php }else{ ?><input type="button" name="shenhe2" value="申请审核" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="shenhezzc('<?php echo $info['id']?>')" <?php echo $nosq1?>/><?php }?></td>
		<td <?php echo $bcolor?> align="center" ><?php if($_SESSION['userid']==$info['juuser']){?><a href="javascript:;" onclick="gongxianedits('<?php echo $info['id']?>')">点击审核<?php echo $shs[$info['juok']]?></a><?php }else{ ?><input type="button" name="shenhe4" value="申请审核" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="shenheju('<?php echo $info['id']?>')" <?php echo $nosq1?>/><?php }?></td>
		<td <?php echo $bcolor?> align="center" >
		<?php $jindu="";
		      if($info['bmuser']>0){$jindu="部门审核";}
			  if($info['fguser']>0){$jindu="分管领导审核";}
			  if($info['zzcuser']>0){$jindu="政治处审核";}
			  if($info['juuser']>0){$jindu="局长审核";
			    if($info['juok']==1){$jindu="审核完成";}
			  }
			  echo $jindu;
		?>        
        </td>
        <td <?php echo $bcolor?> align="center" ><input type="button" name="shows" value="查看" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="gongxianedits('<?php echo $info['id']?>')"/></td>
             
	</tr>
<?php 
 $i++;
}}?>
</tbody>
	<thead>
		<tr>
            <th colspan="12" align="left" style="font-size:12px"><input type="button" name="addsq" value="发起申请" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="addshenqing()"/></th>
        </tr>
	</thead> 
</table>
<div id="pages"><?php echo $pages?></div>
<div style="clear:both"></div>
</div>
</div>
<script language="javascript">
function gongxianedits(id) {
		window.top.art.dialog({title:'编辑特殊任务申请表', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tsrenwuedits&id='+id ,width:'1100px',height:'550px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}
	
function addshenqing(){ 
		window.top.art.dialog({title:'发起特殊任务申请', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tsrenwuadd',width:'1100px',height:'550px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
	
function shenhebm(id){ 
		window.top.art.dialog({title:'申请部门审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tsrenwushenhe&ty=bm&id='+id,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}

function shenhezzc(id){ 
		window.top.art.dialog({title:'申请政治处审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tsrenwushenhe&ty=zzc&id='+id,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}

function shenhefg(id){ 
		window.top.art.dialog({title:'申请分管领导审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tsrenwushenhe&ty=fg&id='+id,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
	
function shenheju(id){ 
		window.top.art.dialog({title:'申请局领导审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tsrenwushenhe&ty=ju&id='+id,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}				
</script>	
</body>
</html>
