<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>辅警<?php $dys=$_GET['yue']."01"; echo date("Y年m月",strtotime($dys))?>绩效考核情况一览</b></div>

<table width="1600px" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px">序号</th>
            <th align="center" style="font-size:12px">姓名</th>
            <th align="center" style="font-size:12px">身份证号</th>
            <th align="center" style="font-size:12px">单位</th>
            <th align="center" style="font-size:12px">岗位</th>
            <th align="center" style="font-size:12px">考核结果</th>
            <th align="center" style="font-size:12px">考核成绩</th>
            <th align="center" style="font-size:12px">出勤</th>
            <th align="center" style="font-size:12px">政治素质</th>
            <th align="center" style="font-size:12px">职业道德</th>
            <th align="center" style="font-size:12px">社会公德</th>
            <th align="center" style="font-size:12px">个人品德</th>
            <th align="center" style="font-size:12px">业务水平</th>
            <th align="center" style="font-size:12px">工作能力</th>
            <th align="center" style="font-size:12px">出勤情况</th>
            <th align="center" style="font-size:12px">工作表现</th> 
            
            <th align="center" style="font-size:12px">目标任务</th>
            <th align="center" style="font-size:12px">本职工作</th>
            <th align="center" style="font-size:12px">廉洁守纪</th>
            <th align="center" style="font-size:12px">突出贡献</th>
            <th align="center" style="font-size:12px">特殊任务</th>
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
		<td align="center" ><?php echo $dengji[$info['khdj']]?></td>
        <td align="center" ><?php echo $info['chengji']?></td>
		<td align="center" ><?php echo $info['chuqin']?></td>
		<td align="center" ><?php echo $info['de_zhengzhi']?></td>
		<td align="center" ><?php echo $info['de_zhiye']?></td>
		<td align="center" ><?php echo $info['de_shehui']?></td>
		<td align="center" ><?php echo $info['de_geren']?></td>
		<td align="center" ><?php echo $info['neng_yewu']?></td>
		<td align="center" ><?php echo $info['neng_gongzuo']?></td>
		<td align="center" ><?php echo $info['qin_chuqin']?></td>
		<td align="center" ><?php echo $info['qin_biaoxian']?></td>
		<td align="center" ><?php echo $info['ji_mubiao']?></td>
		<td align="center" ><?php echo $info['ji_benzhi']?></td>
		<td align="center" ><?php echo $info['lian_lianjie']?></td>
		<td align="center" ><?php echo $info['tcgongxian']?></td>
		<td align="center" ><?php echo $info['tsrenwu']?></td>        
     
	</tr>
<?php }}?>
</tbody>
 
</table>
<div id="pages"><?php echo $pages?></div>
</div>
</div>
</body>
</html>
