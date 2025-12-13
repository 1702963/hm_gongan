<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>新区公安分局短期合同工（<?php echo $tables['fromyue']?>-<?php echo $tables['toyue']?>）工资表</b></div>

<?php 
$t_rs=count($rowname)+1;
$t_width=98*$t_rs;

?>


<table width="<?php echo $t_width?>px" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px">序号</th>
        <?php foreach($rowname as $rv){?>	
			<th align="center" style="font-size:12px"><?php echo $rv[1]?></th>
        <?php }?>    
		</tr>
	</thead>
<tbody>
<?php
if(count($show_table)>0){
	foreach($show_table as $info){
		//日期型从这里变换
		$info['ruzhi']=date("Y-m-d",$info['ruzhi']);
		?>
	<tr>		
		<td align="center" ><?php echo $info['id']?></td>
        <?php foreach($rowname as $rv){?>	
			<td align="center" ><?php echo $info[$rv[0]]?></td>
        <?php }?>           
	</tr>
	<?php
	}	
	}
?>
</tbody>
 
</table>
<?php
if(count($show_table)<1){
?>	
<div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px; margin-top:10px"><a href="?m=gongzi&c=gzgl&a=showtable&dos=indats&id=<?php echo $tables['id']?>">当前工作表尚未进行数据填充，点击立刻执行操作</a></div>
<?php }?>
<div id="pages"><?php echo $pages?></div>
</div>
</div>
</body>
</html>
