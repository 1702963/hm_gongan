<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');

$myref=explode("?",$_SERVER["HTTP_REFERER"]);
/////     
//获取人员信息
		  $this->db->table_name = 'mj_beizhuang_ulog';
		  $_user=$this->db->get_one("uid=".intval($_GET['uid'])." and dotime=".intval($_GET['dotime']),'*');
		  
//获取已选择类目
 	$this->db->table_name = 'mj_beizhuang_linglog';
	$lmyx = $this->db->select(" uid=".intval($_GET['uid'])." and dotime=".intval($_GET['dotime']),'*','','');
	foreach($lmyx as $yx){
	  $check[$yx['lmid']]='checked="checked"';	
		}		

//获取类目
 	$this->db->table_name = 'mj_beizhuang_zidian';
	$lmarr = $this->db->select(" pid=0 and dotime=".intval($_GET['dotime']),'*','','px asc');	
	
  
?>
<div class="pad-lr-10" style="margin-top:-20px">
<div class="explain-col">可用金额: <b id="kyje" style="color:#F00"><?php echo $_user['kyje']?></b> 元,当前合计 <b id="dqhj" style="color:#F00"><?php echo $_user['sjje']?></b> 元
</div>
<form action="" method="post">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
<?php 
     $i=1;  
     if(is_array($lmarr)){
	 foreach($lmarr as $lmp){
	?>
	<tr>
		<td height="37" colspan="3" align="left" style="padding-left:10px"><b><?php echo $i?>.</b> <b id="pn<?php echo $lmp['id']?>"><?php echo $lmp['name']?></b> <a href="javascript:;" onclick="eopenme('<?php echo $lmp["id"]?>')">▼</a>
         <span style="margin-left:10px">合计： <b id="msg<?php echo $lmp['id']?>" style="color:#F00">0.00</b></span>
        </td>
	  </tr>
    <?php 
	   $lmarrsub = $this->db->select(" pid=".$lmp['id']." and dotime=".intval($_GET['dotime']),'*','','px asc');
	?>  
	<tr id="p<?php echo $lmp['id']?>" style="display:none">
		<td width="125" height="37">&nbsp;</td>
		<td colspan="2" align="left"><table width="100%" border="0">
        	<?php    foreach($lmarrsub as $lmsub)	{ ?>
		  <tr>
		    <td width="40%"><b id="n<?php echo $lmsub['id']?>"><?php echo $lmsub['name']?></b> [单价: <b id="j<?php echo $lmsub['id']?>"><?php echo $lmsub['jiage']?></b>]</td>
		    <td width="60%"><label ><input type="checkbox" value="1" id="chk<?php echo $lmsub['id']?>" <?php echo $check[$lmsub['id']]?> onclick="onthischeck('<?php echo $lmsub['id']?>','<?php echo $lmsub['pid']?>','<?php echo $_user['dotime']?>','<?php echo $_user['uid']?>','<?php echo $_user['uname']?>','<?php echo $_user['bmid']?>')"/>&nbsp;选择</label> &nbsp;数量 <input id="s<?php echo $lmsub['id']?>" value="<?php if(isset($check[$lmsub['id']])){echo "1";}else{echo "0";}?>" style=" width:20px" readonly="readonly"/>&nbsp; <b id="m<?php echo $lmsub['id']?>" style="color:#F00"></b> </td>
		    </tr>
            <?php }?>
	    </table></td>
	  </tr>  
<?php 
  $i++;
}}?>              
	<tr>
		<td></td>
		<td width="315"><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" 返回 " style="width:90px"/> </td>
		<td width="1416">&nbsp;</td>
	</tr>

</table>
<input type="hidden" name="objid" value="<?php echo $_GET['objid']?>" />
<input type="hidden" name="ref" value="<?php echo $_GET['ref']?>" />
</form>
</div>
</body>
<script language="javascript">
 function eopenme(subid){
	$("#p"+subid).toggle() 
	 }
	 
 function onthischeck(lid,lpid,dotime,uid,uname,bmid){
	 t_kyje=parseFloat($("#kyje").text())
	 t_dj=parseFloat($("#j"+lid).text())	
	 if($("#chk"+lid).attr('checked')=='checked') {
	    t_dqhj=parseFloat($("#dqhj").text())	 
		t_hj=t_dqhj+t_dj
		if(t_hj>t_kyje){
		  $("#chk"+lid).removeAttr("checked");
		  $("#s"+lid).val(0)
		  $("#m"+lid).text("超过限额")	
		}else{
		 $("#s"+lid).val(1)
		 if($("#s"+lid).val()==1){
			  $("#m"+lid).text("")	 
		      $("#dqhj").text(t_hj)
			  lmname=$("#n"+lid).text()
			  plmname=$("#pn"+lpid).text()
	          $.post('api/doxuan.php',{lid:lid,lpid:lpid,lm:lmname,plm:plmname,dotime:dotime,uid:uid,hj:t_hj,uname:uname,bmid:bmid,dj:t_dj,dotys:'add'},function(data){
				 // console.log(data)
				  })
		       }			  
		 }
		 }else{
			$("#s"+lid).val(0) 
		    if($("#s"+lid).val()==0){
	         t_dqhj=parseFloat($("#dqhj").text())	 
		     t_hj=t_dqhj-t_dj
		     $("#dqhj").text(t_hj)
			  lmname=$("#n"+lid).text()
			  plmname=$("#pn"+lpid).text()
	          $.post('api/doxuan.php',{lid:lid,lpid:lpid,lm:lmname,plm:plmname,dotime:dotime,uid:uid,hj:t_hj,uname:uname,bmid:bmid,dj:t_dj,dotys:'del'},function(data){
				  //console.log(data)
				  })			 		
			 }
		 }
	 }	 
</script>
</html>



