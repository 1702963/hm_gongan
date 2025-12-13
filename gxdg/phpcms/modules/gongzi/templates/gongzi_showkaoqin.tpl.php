<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>唐山高新区管委会短期合同制工作人员考勤表(<?php echo $tables['yue']?>)</b>
    <form action="" method="post">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="gzgl"/>
    <input type="hidden" name="a" value="showkaoqin"/>
    <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>     
     <input type="submit" name="chongzhikqb" value="重置工资表" style="width:80px" />
    </form>    
    </div>

<?php 
$t_rs=count($rowname)+3;
$t_width=70*$t_rs;

             
		     $this->db->table_name = 'mj_fujing';
		     $rowss = $this->db->select("","id,sfz","","id asc");
		     foreach($rowss as $v){
			    $sfzarr[$v['id']]=$v['sfz'];  
			 }
?>


<table width="<?php echo $t_width?>px" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px;width:20px">序号</th>
            <th align="center" style="font-size:12px;width:20px">姓名</th>
            <th align="center" style="font-size:12px;width:20px">身份证</th>
        <?php foreach($rowname as $rv){
			  if(date("w",strtotime($rv))==0 || date("w",strtotime($rv))==6){
				  $bcolor="#F96";
				  }else{
				  $bcolor=""; 	  
					  } 			
			?>	
			<th align="center" style="font-size:12px;width:10px;background-color:<?php echo $bcolor?>"><?php echo date("d",strtotime($rv))?></th>
        <?php }?> 
            <th align="center" style="font-size:12px;width:150px">备注</th>   
		</tr>
	</thead>
<tbody>
<?php
if(count($show_table)>0){
	foreach($show_table as $info){
		?>
	<tr>		
		<td align="center" ><?php echo $info['id']?></td>
        <td align="center" ><?php echo $info['xingming']?></td>
        <td align="center" ><?php echo $sfzarr[$info['userid']]?></td>
        <?php foreach($rowname as $rv){
			  if(date("w",strtotime($rv))==0 || date("w",strtotime($rv))==6){
				  $bcolor="#F96";
				  }else{
				  $bcolor=""; 	  
					  } 			
			?>	
			<td align="center" style="background-color:<?php echo $bcolor?>""><?php echo $kqflag[$info[$rv]][0]?></td>
        <?php }?>  
        <td align="center" ><?php echo $info['beizhu']?></td>         
	</tr>
	<?php
	}	
	}
?>
</tbody>
 
</table>
<?php
if(count($show_table)<1){
 if($_REQUEST['dos']!='indats'){
?>	
<div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px; margin-top:10px"><a href="?m=gongzi&c=gzgl&a=showkaoqin&dos=indats&id=<?php echo $tables['id']?>">当前工作表尚未进行数据填充，点击立刻执行操作</a></div>
<?php }else{?>
<div style="clear:both"></div>
<form action="" method="post">
<input type="hidden" name="m" value="gongzi" />
<input type="hidden" name="c" value="gzgl" />
<input type="hidden" name="a" value="showkaoqin" />
<input type="hidden" name="dos" value="indats" />
<input type="hidden" name="id" value="<?php echo intval($_REQUEST['id'])?>" />

<table width="50%" cellspacing="0" border="1" style="margin-top:10px;">
	<thead>
		<tr>
            <th align="center" style="font-size:12px;width:30px">选择</th>
            <th align="center" style="font-size:12px;width:100px">姓名</th>
            <th align="center" style="font-size:12px;width:150px">所属部门</th>
            <th align="center" style="font-size:12px;width:50px">状态</th> 
            <th align="center" style="font-size:12px;width:50px">离职时间</th>  
		</tr>
	</thead>   
    <tbody>
<?php foreach($fujings as $v){
	  if($v['status']==2){$reds="color:red";
	   //判断离职时间是否在前一个月20日之前
	   $tmptime=strtotime(date("Y-m",strtotime("-1 month"))."-20");
	   if($v['lizhitime']>$tmptime){ 
	   
	?>     
        <tr>
         <td align="center" style="<?php echo $reds?>"><input type="checkbox" name="ids[]" value="<?php echo $v['id']?>" checked="checked"/></td>
         <td align="center" style="<?php echo $reds?>"><?php echo $v['xingming']?></td>
         <td align="center" style="<?php echo $reds?>"><?php echo $bumen[$v['dwid']]?></td>
         <td align="center" style="<?php echo $reds?>"><?php echo $zts[$v['status']]?></td>
         <td align="center" style="<?php echo $reds?>"><?php if($v['status']==2){echo date("Y-m-d",$v['lizhitime']);}?></td>
        </tr>
 <?php }}else{
	   $reds="";
	 ?>
         <tr>
         <td align="center" style="<?php echo $reds?>"><input type="checkbox" name="ids[]" value="<?php echo $v['id']?>" checked="checked"/></td>
         <td align="center" style="<?php echo $reds?>"><?php echo $v['xingming']?></td>
         <td align="center" style="<?php echo $reds?>"><?php echo $bumen[$v['dwid']]?></td>
         <td align="center" style="<?php echo $reds?>"><?php echo $zts[$v['status']]?></td>
         <td align="center" style="<?php echo $reds?>"><?php if($v['status']==2){echo date("Y-m-d",$v['lizhitime']);}?></td>
        </tr>
 <?php }}?>        
    </tbody>
</table>
<input type="submit" value="确认" id="dook" name="dook" style="display:none"/>
</form>
<?php }}?>

<div id="pages"><?php echo $pages?></div> 
</div>
</div>
</body>
</html>
