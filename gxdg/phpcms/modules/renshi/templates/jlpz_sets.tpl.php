<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');


       if($_POST['dosubmit']!=""){
		 $this->db->table_name = 'v9_jlset';
		   foreach($_POST['sets'] as $k=>$v){
			  $ins['bmid']=$k;
			  $ins['pid']= $_POST['pmid'][$k];
			  $ins['mj_ying']=$_POST['mj_ying'][$k];
			  $ins['fj_ying']=$_POST['fj_ying'][$k];
			  $ins['beizhu']=$_POST['bz'][$k];
		      
			 //print_r($ins);
			 // $this->db->insert($ins);
			 $this->db->update($ins,"bmid=$k");	   
		   }
		 }

		$this->db = pc_base::load_model('bumen_model');
		$rss = $this->db->select("",'id,name,parentid','','listorder asc');
		$bms=array();
		//foreach($rss as $v){
		 //$bms[]=$rss;	
		//	}
       
	   $this->db->table_name = 'v9_jlset';
	   $srs=$this->db->select("",'*','','id asc');
	   foreach($srs as $v){
		 $sarr[$v['bmid']]=$v;  
		   }
   
?>

<script type="text/javascript">
<!--
	var charset = '<?php echo CHARSET;?>';
	var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';
//-->
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script> 
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script> 
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<form action="?m=renshi&c=jlpeizhi&a=sets" method="POST" name="myform" id="myform">


<style type="text/css">
.baseinfo tbody tr {transition:all .2s ease-in-out}
.baseinfo tbody tr:hover {background:#039}
</style>

<div class="tableContent">

<div class="tabcon">
<div class="title">警力配置</div>

<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <thead>
  <tr>
    <td width="100" align="center" class="infotitle">选择</td>
    <td width="100" align="center" class="infotitle">单位ID</td>
    <td width="245" align="center" class="infotitle">单位</td>
    <td width="189" align="center" class="infotitle">应配置民警</td>
    <td width="195" align="center" class="infotitle">应配置辅警</td>
    <td width="178" align="center" class="infotitle">备注</td>    
    </tr>
  </thead>
  <tbody>
 <?php foreach($rss as $v){?>   
  <tr>
    <td width="100" align="center"><input type="checkbox" name="sets[<?php echo $v['id']?>]" />
      <input type="hidden" name="pmid[<?php echo $v['id']?>]" value="<?php echo $v['parentid']?>" class="input-text"/>
      <input type="hidden" name="myid[<?php echo $v['sid']?>]" value="<?php echo $v['sid']?>" class="input-text"/>    
    </td>
    <td width="100" align="center"><?php echo $v['id']?></td>
    <td width="245" align="center"><?php echo $v['name']?></td>
    <td width="189" align="center"><input type="text" name="mj_ying[<?php echo $v['id']?>]" class="input-text" value="<?php echo intval($sarr[$v['id']]['mj_ying'])?>"/></td>
    <td width="195" align="center"><input type="text" name="fj_ying[<?php echo $v['id']?>]" class="input-text" value="<?php echo intval($sarr[$v['id']]['fj_ying'])?>"/></td>
    <td width="178" align="center"><input type="text" name="bz[<?php echo $v['id']?>]" class="input-text" value="<?php echo $sarr[$v['id']]['beizhu']?>"/></td>    
    </tr>  
  <?php }?>    
  </tbody>
  </table>
</div>

<!--<div class="clear"></div>

<div class="tabcon">
<div class="title">参保类型</div>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="90" align="right" class="infotitle">参保类型：</td>
    <td width="870">
        <input type="checkbox" class="rad" checked />失业保险
        <input type="checkbox" class="rad" checked />医疗保险
        <input type="checkbox" class="rad" checked />工伤保险
        <input type="checkbox" class="rad" checked />养老保险
        <input type="checkbox" class="rad" checked />生育保险
    </td>
  </tr>

</table>
</div>-->


<div class="clear"></div>

<div class="tabcon"></div>

<div class="clear"></div>

<div class="tabcon">
<input type="hidden" name="id" value="<?php echo $fujing['id'];?>" />
<input type="hidden" name="status" value="<?php echo $_GET['status'];?>" />
	<input type="submit" class="dowhat" name="dosubmit" value="保存配置" />
</div>
<div class="clear"></div>
<div class="null"></div>

</div>
</form>
<script language="javascript">
function getbmi(){
	if($("#shengao").val()!="" || !isNaN($("#shengao").val()) ){
		if($("#tizhong").val()!="" || !isNaN($("#tizhong").val()) ){
		tmp=$("#tizhong").val()/($("#shengao").val()*$("#shengao").val());	
		  $("#bmi").val(tmp.toFixed(2))
		}
	  }
	}
</script>

<div id="return_up" onclick="javascript:history.go(-1);"></div>
</body></html>



