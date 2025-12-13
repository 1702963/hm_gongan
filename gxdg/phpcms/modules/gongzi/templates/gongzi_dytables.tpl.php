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

//单位
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

$kaohedj[0]="未指定等级";
$kaohedj[23]="不确定等次";
$kaohedj[2]="优秀";
$kaohedj[3]="合格";
$kaohedj[19]="基本合格";
$kaohedj[4]="不合格";
			 	 
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

<table width="600px" border="0" align="left">
 <thead>
  <tr>
    <th align="center">快捷工具</th>
	<th align="center" ><input type="button" name="but1" value="申请政治处审核" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:" onclick="zzcshenhe('<?php echo $tables['yue']?>')" <?php echo $buttoncan?>/></th>
    <th align="center" ><input type="button" name="but1" value="申请局领导审核" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:none" onclick="jushenhe('<?php echo $tables['yue']?>')" <?php echo $buttoncan?>/></th>
	
<?php
//审批
if($tables['zzcuser']<1){
$shzt="未进入审核";
}
if($tables['zzcuser']>0){
 if($tables['zzcuser']==$_SESSION['userid']){
   $shzt="<a href=\"javascript:;\" onclick=\"zzcshenhe_do('".$tables['yue']."')\"><font color=red>点击进行政治处审核</font></a>";
 }else{
  $shzt="政治处审核中";
 } 
}
if($tables['zzcok']>0){
  $shzt="<font color=green>政治处审核通过</font>";
}

if($tables['zhengweiuser']>0){
 if($tables['zhengweiuser']==$_SESSION['userid']){
   $shzt="<a href=\"javascript:;\" onclick=\"zhengweishenhe_do('".$tables['yue']."')\"><font color=red>点击进行政委审核</font></a>";
 }else{
  $shzt="政委审核中";
 } 
}

if($tables['zhengweiok']>0){
  $shzt="<font color=green>政委审核通过</font>";
}


if($tables['juuser']>0){
 if($tables['juuser']==$_SESSION['userid']){
   $shzt="<a href=\"javascript:;\" onclick=\"jushenhe_do('".$tables['yue']."')\"><font color=red>点击进行局领导审核</font></a>";
 }else{
  $shzt="局领导审核中";
 } 
}



if($tables['juok']>0){
  $shzt="<font color=green>审核全部通过</font>";
}

?>	
    <th align="center" style="font-size:12px; width:250px">审批状态：<?php echo $shzt ?></th>
  </tr>
</thead>  
</table>
<div style="clear:both"></div>

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>高新分局警务辅助人员（<?php echo $tables['yue']?>）工资表</b><?php if($tables['islocked']==1){echo "&nbsp;<font color=red>锁定</font>";}?></div>
    <?php if($_SESSION['roleid']<=5 || $_SESSION['roleid']==7){?>
    <form action="" method="get">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="gzgl"/>
    <input type="hidden" name="a" value="dytables"/>
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
     
<?php 
//print_r($bumen);
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
		$info['bmid']=$bumen[$info['bmid']];	  
		$info['cengji']=$cj_name;
		$info['dangci']=$cj_dc;	
		if($info['dangtime']>0){$info['dangtime']=date("Ym",$info['dangtime']);}else{$info['dangtime']="";}
		if($info['jitime']>0){$info['jitime']=date("Ym",$info['jitime']);}else{$info['jitime']="";}
		$info['gwjb']=$gwdj[$info['gwjb']]['cjname'];
		$info['gwlb']=$gangwei[$info['gwlb']];	
		$info['zhiwu']=$zhiwu[$info['zhiwu']]; 
		if($info['kaohedj']!=''){
			$info['kaohedj']=$kaohedj[$info['kaohedj']];
			}
				
		?>
	<tr <?php if(intval($_GET['yue'])<1){?>onclick="showtgongzis('<?php echo $info['id']?>','<?php echo $dbs?>')"<?php }?>>		
		<td align="center" ><?php echo $info['id']?></td>
        <?php 
		foreach($rowname as $rv){?>	
			<td align="center" ><?php echo $info[$rv[0]]?></td>
        <?php }?>           
	</tr>
	<?php
	}	
	}
?>
		<tr>
            <th align="center" bgcolor="#c5d3e3" style="font-size:12px">合计</th>
        <?php foreach($rowname as $k=>$rv){?>	
		  <th align="center" style="font-size:12px" bgcolor="#c5d3e3"><?php echo $hj[$k]?></th>
        <?php }?>    
		</tr> 
</tbody>
 
</table>
<?php
if(count($show_table)<1){
 if($_SESSION['roleid']==1){	
?>	
<div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px; margin-top:10px"><a href="?m=gongzi&c=gzgl&a=showtable&dos=indats&id=<?php echo $tables['id']?>">当前工作表尚未进行数据填充，点击立刻执行操作</a></div>
<?php }else{?>
<div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px; margin-top:10px">当前工作表尚未进行人员初始化，请联系管理员进行操作</div>
<?php }}?>
<div id="pages"><?php echo $pages?></div>
</div>
</div>
<script type="text/javascript">

function showtgongzis(id,dbs) {
		window.top.art.dialog({title:'工资录入/编辑', id:'shows', iframe:'?m=gongzi&c=gzgl&a=showgongziedit&id='+id+'&dbs='+dbs ,width:'1100px',height:'550px'},function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}

function zzcshenhe(yue){ 
		window.top.art.dialog({title:'申请政治处审核', id:'shows', iframe:'?m=gongzi&c=gzgl&a=gongzishenhe&ty=zzc&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}
	
function zzcshenhe_do(yue){ 
		window.top.art.dialog({title:'政治处审核处理', id:'shows', iframe:'?m=gongzi&c=gzgl&a=gongzishenhe_do&ty=zzc&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
	
function jushenhe(yue){ 
		window.top.art.dialog({title:'申请局领导审核', id:'shows', iframe:'?m=gongzi&c=gzgl&a=gongzishenhe&ty=ju&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}

function jushenhe_do(yue){ 
		window.top.art.dialog({title:'局领导审核处理', id:'shows', iframe:'?m=gongzi&c=gzgl&a=gongzishenhe_do&ty=ju&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}					
</script>
</body>
</html>
