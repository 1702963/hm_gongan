<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
//print_r($show_table);
?>
<div class="pad-lr-10">

<table width="100%" border="0" align="left">
 <thead>
  <tr>
    <th align="center" width="5%">快捷工具</th>
    <?php if($_SESSION['roleid']>51){?><th align="center" width="5%"><input type="button" name="but1" value="申请部门审核" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:" onclick="bmshenhe('<?php echo $_GET['yue']?>','<?php echo $_SESSION['bmid']?>')" <?php echo $buttoncan?>/></th> <?php }?> 
	<?php if($_SESSION['roleid']<-5 ){?><th align="center" width="5%"><input type="button" name="but1" value="申请政治处主任审核" style="border-radius:.4em;cursor:pointer; width:120px; height:25px; background-color:#06C; color:#FFF;display:" onclick="zzcshenhe('<?php echo $_GET['yue']?>')" <?php echo $buttoncan?>/></th> <?php }?>   	
<?php
//审批

if($_SESSION['roleid']>=5){

  if($show_table[0]['bmuser']>0){
    $shzt="等待部门领导审核";	
	}	

  if($show_table[0]['zguser']>0){
    $shzt="等待主管领导审核";	
	}

}else{

  if($tables['zzcok']==1){
    $shzt="政治处主任已审核";	
		}	

  if($tables['juok']==1){
    $shzt="局领导已审核";	
	}
}	
?>	
    <th align="center" style="font-size:12px; width:250px">审批状态：<?php echo $shzt ?></th>

    <th align="center" style="font-size:12px;">&nbsp;
    </th>    
  </tr>
</thead>  
</table>
<div style="clear:both"></div>

<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>辅警<?php $dys=$_GET['yues']."01"; echo date("Y年m月",strtotime($dys))?>绩效考核表</b> &nbsp;<input type="button" name="but1" value="审核绩效考评" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:" onclick="bmshenhe_do('<?php echo $_GET['yues']?>','<?php echo $_GET['doty']?>','<?php echo $show_table[0]['bmid']?>','<?php echo $_GET['msgid']?>')" <?php echo $buttoncan?>/></div>
    <?php if($_SESSION['roleid']==1||$_SESSION['roleid']==2||$_SESSION['roleid']==3){?>
    <form action="" method="get">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="kaoping"/>
    <input type="hidden" name="yue" value="<?php echo $_GET['yue']?>"/>  
      <div style=" width:100%;font-size:12px; text-align:center; margin-bottom:5px; display:none">选择部门
               <select name="bms">
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
	?>
	<tr onclick="jixiaoedits('<?php echo $info['id']?>')">		
		<td <?php echo $bcolor?> align="center" ><?php echo $i?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $fujings[$info['userid']]?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['sfz']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $bumen[$info['bmid']]?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $gangwei[$info['gangwei']]?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $dengji[$info['kh_dj']]?></td>
        <td <?php echo $bcolor?> align="center" ><?php echo $info['chengji']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['chuqin']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['de_zhengzhi']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['de_zhiye']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['de_shehui']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['de_geren']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['neng_yewu']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['neng_gongzuo']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['qin_chuqin']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['qin_biaoxian']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['ji_mubiao']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['ji_benzhi']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['lian_lianjie']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['tcgongxian']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['tsrenwu']?></td>        
     
	</tr>
<?php 
 $i++;
}}?>
</tbody>
 
</table>
<div id="pages"><?php echo $pages?></div>
<div style="clear:both"></div>
<?php
//分组
		  // $do_rs=$this->db->query("SELECT bmid FROM `mj_gongzi_jixiao` where bmmastdt=0 and bmmast>0 group by bmid");
          // $bm_log=$this->db->fetch_array($do_rs);   

?>

</div>
</div>
<script language="javascript">
function jixiaoedits(id) {
		window.top.art.dialog({title:'录入/编辑绩效考核项目', id:'shows', iframe:'?m=gongzi&c=jixiao&a=jixiaoedits&id='+id ,width:'1100px',height:'550px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}
	
function zzcoks(bms){ //函数名居然和对象ID同名

	if(document.getElementById('zzcokbmid').value!=bms){
		alert("请先选择要审核的部门")
		return false;
		}
	}	
	
function juoks(bms){ //函数名居然和对象ID同名

	if(document.getElementById('juokbmid').value!=bms){
		alert("请先选择要审核的部门")
		return false;
		}
	}
	
function bmshenhe(yue,bmid){ 
		window.top.art.dialog({title:'申请部门领导审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=kaopingshenhe&ty=bm&yue='+yue+'&bmid='+bmid,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}
	
function zzcshenhe(yue){ 
		window.top.art.dialog({title:'申请政治处审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=kaopingshenhe&ty=zzc&yue='+yue,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
	
	
function bmshenhe_do(yue,doty,bmid,msgid){ 
		window.top.art.dialog({title:'绩效考评审核', id:'shows', iframe:'?m=shenpi&c=jixiaoshenpi&a=jixiaoshenpi_do&ty='+doty+'&yue='+yue+'&bmid='+bmid+'&msgid='+msgid,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}			
</script>	
</body>
</html>
