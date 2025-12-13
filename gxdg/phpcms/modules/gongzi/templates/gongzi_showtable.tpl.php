<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

//获取层级工资 ,此处需解析
		  $this->db->table_name = 'mj_cengji';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $cengji[$v['id']]=$v;  
			 }
//获取职务
		  $this->db->table_name = 'mj_zhiwu';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $zhiwu[$v['id']]=$v['zwname'];  
			 }		

//获取岗位
		  $this->db->table_name = 'mj_gangwei';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gangwei[$v['id']]=$v['gwname'];  
			 }	
			 
//岗位等级
		  $this->db->table_name = 'mj_gwdj';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gwdj[$v['id']]=$v; //这个映射需要解析  
			 }				 			 
			 	 
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>高新分局警务辅助人员（<?php echo $tables['yue']?>）工资表</b>&nbsp; 
    <form action="" method="post">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="gzgl"/>
    <input type="hidden" name="a" value="showtable"/>
    <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>     
     <input type="submit" name="chongzhigzb" value="重置工资表" style="width:80px" />
    </form>
    </div>
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
		///转换都在这做吧，乱套了
		  $tmpcengjiname=str_replace("（","(",str_replace("）",")",$cengji[$info['cengji']]['cjname']));
		  $cjnamearr=explode("(",$tmpcengjiname);
		  if(count($cjnamearr)>1){
			  $cj_name=$cjnamearr[0];
			  $cj_dc=str_replace(")","",$cjnamearr[1]);
			  }else{
			  $cj_name=$cjnamearr[0];
			  $cj_dc=0;				  
				  }
			unset($cjnamearr);	  
		$info['cengji']=$cj_name;
		$info['dangci']=$cj_dc;	
		$info['dangtime']=date("Ym",$info['dangtime']);
		$info['jitime']=date("Ym",$info['jitime']);
		$info['gwjb']=$gwjb[$info['gwjb']]['cjnama'];
		$info['gwlb']=$gangwei[$info['gwlb']];	
		$info['zhiwu']=$zhiwu[$info['zhiwu']];  		
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
<div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px; margin-top:10px"><form action="" method="post"><input type="hidden" name="<?php echo $tables['id']?>" />当前工作表尚未进行数据填充 <input type="submit" name="indats" value="点击立即填充" style="width:150px; height:30px"/></form></div>
<?php }?>
<div id="pages"><?php echo $pages?></div>
</div>
</div>
</body>
</html>
