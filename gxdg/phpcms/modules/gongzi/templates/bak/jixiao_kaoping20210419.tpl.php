<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>辅警<?php $dys=$_GET['yue']."01"; echo date("Y年m月",strtotime($dys))?>绩效考核表</b> &nbsp;<?php if($show_table[0]['islock']==1){?><font color=red>[锁定]</font><?php }?></div>
    <?php if($_SESSION['roleid']==1||$_SESSION['roleid']==2||$_SESSION['roleid']==3){?>
    <form action="" method="get">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="kaoping"/>
    <input type="hidden" name="yue" value="<?php echo $_GET['yue']?>"/>  
      <div style=" width:100%;font-size:12px; text-align:center; margin-bottom:5px">选择部门
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
		   $do_rs=$this->db->query("SELECT bmid FROM `mj_gongzi_jixiao` where bmmastdt=0 and bmmast>0 group by bmid");
           $bm_log=$this->db->fetch_array($do_rs);
		   
		   $do_rs=$this->db->query("SELECT bmid FROM `mj_gongzi_jixiao` where bmmastdt>0 and bmmast>0 group by bmid");
           $bm2_log=$this->db->fetch_array($do_rs);	
		   
		   $do_rs=$this->db->query("SELECT bmid FROM `mj_gongzi_jixiao` where zzcmastdt=0 and zzcmast>0 group by bmid");
           $zzc_log=$this->db->fetch_array($do_rs);		
		   
		   $do_rs=$this->db->query("SELECT bmid FROM `mj_gongzi_jixiao` where zzcmastdt>0 and zzcmast>0 group by bmid");
           $zzc2_log=$this->db->fetch_array($do_rs);
		   
		   $do_rs=$this->db->query("SELECT bmid FROM `mj_gongzi_jixiao` where jumastdt=0 and jumast>0 group by bmid");
           $ju_log=$this->db->fetch_array($do_rs);
		   
		   $do_rs=$this->db->query("SELECT bmid FROM `mj_gongzi_jixiao` where jumastdt>0 and jumast>0 group by bmid");
           $ju2_log=$this->db->fetch_array($do_rs);		   		   			   	   	   
		   //var_dump($do_log);
		   

?>
<table width="50%" border="1">
<thead>
  <tr>
    <th>绩效考核审批记录</th>
  </tr>
</thead>
<?php if($_SESSION['roleid']==8){
       if($show_table[0]['bmmast']==0){
		    $this->db->table_name = 'mj_admin';
		    $shenhe = $this->db->select("roleid=5 and bmid=".$_SESSION['bmid'],"*","","userid asc");
	?>
  <tr>
    <td>    <form action="" method="post">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="kaoping"/>
    <input type="hidden" name="yue" value="<?php echo $_GET['yue']?>"/>
    <input type="hidden" name="bmid" value="<?php echo $_SESSION['bmid']?>"/>
    
    <div>选择上报对象 
            <select name="bmmast">
            <?php foreach($shenhe as $v){?>
             <option value="<?php echo $v['userid']?>"><?php echo $v['username']?></option>
            <?php }?> 
            </select>  &nbsp; <input type="submit" name="dook" value="上报" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF"/> 
     </div>
     </form> </td>
  </tr>
<?php	}}?>  
<?php foreach($bm_log as $b){?>  
  <tr>
    <td>&nbsp;<?php echo $bumen[$b['bmid']]?> 等待部门负责人审核
<?php if($_SESSION['roleid']==5){
        if($show_table[0]['bmmast']==$_SESSION['userid']){
      ?>
 <form action="" method="post">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="kaoping"/>
    <input type="hidden" name="yue" value="<?php echo $_GET['yue']?>"/>
    <input type="hidden" name="bmid" value="<?php echo $_SESSION['bmid']?>"/>
           <select name="bmmastok">
             <option value="1">同意</option>
			 <option value="0">拒绝</option>
            </select>	
	 <input type="submit" name="bmok" value="审核" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF"/>
</form>	        
<?php }}?>	
	</td>
  </tr>
<?php }?>
<?php foreach($bm2_log as $b){?>  
  <tr>
    <td>&nbsp;<?php echo $bumen[$b['bmid']]?> 部门负责人已审核</td>
  </tr>
<?php }?>  
<?php foreach($zzc_log as $b){?>  
  <tr>
    <td>&nbsp;<?php echo $bumen[$b['bmid']]?> 等待政治处审核
<?php if($_SESSION['roleid']==2){
       if($show_table[0]['jumast']==0){
		    $this->db->table_name = 'mj_admin';
		    $shenhe = $this->db->select("roleid=3","*","","userid asc");
	?>
    <form action="" method="post">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="kaoping"/>
    <input type="hidden" name="yue" value="<?php echo $_GET['yue']?>"/>
    <input type="hidden" id="zzcokbmid" name="bmid" value="<?php echo $_GET['bms']?>" />
    
    <div>选择上报对象 
            <select name="jumast">
            <?php foreach($shenhe as $v){?>
             <option value="<?php echo $v['userid']?>"><?php echo $v['username']?></option>
            <?php }?> 
            </select>  &nbsp; <input type="submit" name="zzcok" value="上报" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="return zzcoks('<?php echo $b['bmid']?>')"/> 
     </div>
     </form>     
<?php	}}?>    
    </td>
  </tr>
<?php }?> 
<?php foreach($zzc2_log as $b){?>  
  <tr>
    <td>&nbsp;<?php echo $bumen[$b['bmid']]?> 政治处已审核         
    </td>
  </tr>
<?php }?>
<?php foreach($ju_log as $b){?>  
  <tr>
    <td>&nbsp;<?php echo $bumen[$b['bmid']]?> 等待局领导审核
<?php if($_SESSION['roleid']==3){
	?>
    <form action="" method="post">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="kaoping"/>
    <input type="hidden" name="yue" value="<?php echo $_GET['yue']?>"/>
    <input type="hidden" id="juokbmid" name="bmid" value="<?php echo $_GET['bms']?>" />
    <input type="submit" name="juok" value="审核" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="return juoks('<?php echo $b['bmid']?>')"/> 
    </form>     
<?php	}?>     
    </td>
  </tr>
<?php }?>
<?php foreach($ju2_log as $b){?>  
  <tr>
    <td>&nbsp;<?php echo $bumen[$b['bmid']]?> 局领导已审核</td>
  </tr>
<?php }?>
</table>
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
</script>	
</body>
</html>
