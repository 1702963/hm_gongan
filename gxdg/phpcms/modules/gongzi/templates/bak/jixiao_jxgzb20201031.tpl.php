<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">
<table width="350px" border="0" align="left">
 <thead>
  <tr>
    <th align="center">快捷工具</th>
    <th align="center"><input type="button" name="but1" value="统计特殊任务" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF" onclick="tools_renwu('<?php echo $_GET['yue']?>')"/></th>
    <th align="center"><input type="button" name="but1" value="统计突出贡献" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF" onclick="tools_gongxian('<?php echo $_GET['yue']?>')"/></th>
	<th align="center" ><input type="button" name="but1" value="同步考勤" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF;display:none" onclick="tools_kaoqin('<?php echo $_GET['yue']?>')"/></th>
  </tr>
</thead>  
</table>
<div style="clear:both"></div>
    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>高新公安分局<?php $dys=$_GET['yue']."01"; echo date("Y年m月",strtotime($dys))?>辅警绩效奖金、加班费发放表</b></div>
    <?php if($_SESSION['roleid']<=5){?>
    <form action="" method="get">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="ydjxgzb"/>
    <input type="hidden" name="yue" value="<?php echo $_GET['yue']?>"/>  
      <div style=" width:100%;font-size:12px; text-align:center; margin-bottom:5px">选择部门
               <select name="bms" id="bms">
                <?php foreach($bumen as $k=>$v){?>
                <option value="<?php echo $k?>" <?php if(intval($_GET['bms'])==$k){?> selected="selected"<?php }?> ><?php echo $v?></option>
                <?php }?>
               </select>
               <input type="submit" name="dosel" value="定位" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF"/>
      </div>
    </form> 
	 <?php }?>
<table width="1600px" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px">序号</th>
            <th align="center" style="font-size:12px">姓名</th>
            <th align="center" style="font-size:12px">身份证号</th>
            <th align="center" style="font-size:12px">单位</th>
            <th align="center" style="font-size:12px">岗位</th>
            <th align="center" style="font-size:12px">考核结果</th>
            <th align="center" style="font-size:12px">绩效奖金</th>
            <th align="center" style="font-size:12px">扣除金额</th>
            <th align="center" style="font-size:12px">扣除原因</th>
            <th align="center" style="font-size:12px">加班费</th>
            <th align="center" style="font-size:12px">特殊任务</th>
            <th align="center" style="font-size:12px">突出贡献奖</th>
            <th align="center" style="font-size:12px">社区补助</th>
            <th align="center" style="font-size:12px">实发金额</th>
            <th align="center" style="font-size:12px">备注</th>
		</tr>
	</thead>
<tbody>
<?php if(is_array($show_table)){
	  foreach($show_table as $info){
	?>
	<tr onclick="showjxgzb('<?php echo $info['id']?>')">		
		<td align="center" ><?php echo $info['id']?></td>
		<td align="center" ><?php echo $fujings[$info['userid']]?></td>
		<td align="center" ><?php echo $info['sfz']?></td>
		<td align="center" ><?php echo $bumen[$info['bmid']]?></td>
		<td align="center" ><?php echo $gangwei[$info['gangwei']]?></td>
		<td align="center" ><?php echo $dengji[$info['khjieguo']]?></td>
        <td align="center" ><?php echo $info['jxjj']?></td>
		<td align="center" ><?php echo $info['koufa']?></td>
		<td align="center" ><?php echo $info['koufayy']?></td>
		<td align="center" ><?php echo $info['jiaban']?></td>
		<td align="center" ><?php echo $info['tsrenwu']?></td>
		<td align="center" ><?php echo $info['tcgongxian']?></td>
		<td align="center" ><?php echo $info['shequbz']?></td>
		<td align="center" ><?php echo $info['shifa']?></td>
		<td align="center" ><?php echo $info['备注']?></td>      
     
	</tr>
<?php }}?>
</tbody>
 
</table>
<div id="pages"><?php echo $pages?></div>
</div>
</div>
<script language="javascript">
function tools_kaoqin(yue) {
	    bmid=document.getElementById('bms').value;
		window.top.art.dialog({title:'绩效工具-同步考勤', id:'showtools', iframe:'?m=gongzi&c=jixiao&a=toolskaoqin&yue='+yue+"&bmid="+bmid ,width:'1020px',height:'550px'},function(){var d = window.top.art.dialog({id:'showtools'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'showtools'}).close()});
	}

function tools_gongxian(yue) {
	    bmid=document.getElementById('bms').value;
		window.top.art.dialog({title:'绩效工具-突出贡献', id:'showtools', iframe:'?m=gongzi&c=jixiao&a=toolsgongxian&yue='+yue+"&bmid="+bmid ,width:'1020px',height:'550px'},function(){var d = window.top.art.dialog({id:'showtools'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'showtools'}).close()});
	}
	
function tools_renwu(yue) {
	    bmid=document.getElementById('bms').value;
		window.top.art.dialog({title:'绩效工具-特殊任务', id:'showtools', iframe:'?m=gongzi&c=jixiao&a=toolsrenwu&yue='+yue+"&bmid="+bmid ,width:'1020px',height:'550px'},function(){var d = window.top.art.dialog({id:'showtools'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'showtools'}).close()});
	}	
	
function showjxgzb(id) {
		window.top.art.dialog({title:'绩效工资表编辑', id:'showtools', iframe:'?m=gongzi&c=jixiao&a=jxgzbedit&id='+id,width:'1020px',height:'550px'},function(){var d = window.top.art.dialog({id:'showtools'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'showtools'}).close()});
	}		
</script>
</body>
</html>
