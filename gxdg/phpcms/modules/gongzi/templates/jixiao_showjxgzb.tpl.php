<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>辅警<?php $dys=$_GET['yue']."01"; echo date("Y年m月",strtotime($dys))?>绩效工资表</b></div>

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
	<tr>		
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
		<td align="center" ><?php echo $info['beizhu']?></td>      
     
	</tr>
<?php }}?>
</tbody>
 
</table>
<div id="pages"><?php echo $pages?></div>
</div>
</div>
</body>
</html>
