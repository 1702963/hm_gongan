<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>辅警特殊任务管理</b> &nbsp;<input type="button" name="but1" value="审核特殊任务" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:" onclick="bmshenhe_do('<?php echo $_GET['yues']?>','<?php echo $_GET['doty']?>','<?php echo $show_table[0]['bmid']?>','<?php echo $_GET['msgid']?>')" <?php echo $buttoncan?>/></div>


<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th width="5%" align="center" style="font-size:12px">序号</th>
            <th width="5%" align="center" style="font-size:12px">姓名</th>
            <th width="9%" align="center" style="font-size:12px">身份证号</th>
            <th width="12%" align="center" style="font-size:12px">单位</th>
            <th width="11%" align="center" style="font-size:12px">任务名称</th>
            <th width="10%" align="center" style="font-size:12px">补助金额</th>
            <th width="10%" align="center" style="font-size:12px">部门审核</th>
            <th width="10%" align="center" style="font-size:12px">分管领导审核</th> 
            <th width="8%" align="center" style="font-size:12px">政治部审核</th>
            <th width="11%" align="center" style="font-size:12px">局领导审核</th>
            <th width="9%" align="center" style="font-size:12px">操作</th>
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
        <td <?php echo $bcolor?> align="center" ><?php if($info['bmok']==1){echo "同意";}?></td>
		<td <?php echo $bcolor?> align="center" ><?php if($info['fgok']==1){echo "同意";}?></td>		
		<td <?php echo $bcolor?> align="center" ><?php if($info['zzcok']==1){echo "同意";}?></td>
		<td <?php echo $bcolor?> align="center" ><?php if($info['juok']==1){echo "同意";}?></td>
		<td <?php echo $bcolor?> align="center" ><input type="button" name="shows" value="查看" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="gongxianedits('<?php echo $info['id']?>')"/></td>
             
	</tr>
	<tr>		
		<td colspan="11" align="left" <?php echo $bcolor?> >
 <table width="98%" border="0">
  <tr>
    <td width="4%" valign="middle"><strong style="font-size:12px">上岗时间</strong></td>
    <td width="9%"><?php echo  $info['sgdt']?></td>
    <td width="5%" align="right"><strong style="font-size:12px">上岗天数</strong></td>
    <td width="31%"><?php echo  $info['tianshu']?></td>
    <td width="24%">&nbsp;</td>
    <td width="27%">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle"><strong style="font-size:12px">任务内容</strong></td>
    <td colspan="5"><textarea style="width:100%;height:50px" readonly="readonly"><?php echo $info['rwxq']?></textarea></td>
  </tr>
</table>        
        </td>
	</tr>    
<?php 
 $i++;
}}?>
</tbody>

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
	
function bmshenhe_do(yue,doty,bmid,msgid){ 
		window.top.art.dialog({title:'特殊任务审核', id:'shows', iframe:'?m=shenpi&c=tsrwshenpi&a=tsrwshenpi_do&ty='+doty+'&yue='+yue+'&bmid='+bmid+'&msgid='+msgid,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}				
</script>	
</body>
</html>
