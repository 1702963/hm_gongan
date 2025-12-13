<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

<div style="clear:both"></div>

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>新区公安分局短期合同工（<?php echo $tables['fromyue']?>-<?php echo $tables['toyue']?>）工资表</b>&nbsp; <input type="button" name="but1" value="审核工资" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:" onclick="bmshenhe_do('<?php echo $dbnames?>','<?php echo $_GET['doty']?>','<?php echo $show_table[0]['bmid']?>','<?php echo $_GET['msgid']?>')" <?php echo $buttoncan?>/></div>

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
	<tr <?php if(intval($_GET['yue'])<1){?>onclick="showtgongzis('<?php echo $info['id']?>','<?php echo $dbs?>')"<?php }?>>		
		<td align="center" ><?php echo $info['id']?></td>
        <?php foreach($rowname as $rv){?>	
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

function bmshenhe_do(yue,doty,bmid,msgid){ 
		window.top.art.dialog({title:'工资审核', id:'shows', iframe:'?m=shenpi&c=gongzishenpi&a=gongzishenpi_do&ty='+doty+'&yue='+yue+'&bmid='+bmid+'&msgid='+msgid,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
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
