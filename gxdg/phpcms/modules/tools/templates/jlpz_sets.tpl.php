<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');


       if($_POST['dosubmit']!=""){
		 $this->db->table_name = 'mj_jlset';
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
       
	   $this->db->table_name = 'mj_jlset';
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
/*
.clear {clear:both}
.baseinfo {width:1270px;border-left:2px solid #ccc;border-top:2px solid #ccc;border-right:2px solid #ccc;border-bottom:2px solid #ccc;margin:0 0 20px 20px;_display:inline}
.baseinfo td {border-bottom:1px solid #ccc;padding:15px 0;height:32px}
.baseinfo td b {margin-left:10px;color:#f00}
.infotitle {background:#fff;font-weight:900}
.infotitle span {color:#f00}
.infoinput {width:200px;height:20px;background:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px}
.baseinfo select {padding:5px 0}
.infonum {width:525px;height:24px;background:#fff;border:1px solid #aaa;margin-left:10px;text-indent:5px}
.rad {margin-left:10px;margin-right:5px}
.infoselect {width:206px;margin-left:5px}
#headpic {width:150px;height:230px;background:#fff;margin-left:15px;overflow:hidden}
#headpic img {width:150px}
.topnav {width:960px;padding-left:10px;margin-top:20px}
.thisnav {width:100%;height:90px}
.thisnav a {margin-left:15px;width:120px;height:80px;display:block;float:left;background:#f6f6f6;color:#3e6a90;font-weight:900;border-radius:4px;font-size:12px;text-decoration:none;text-align:center;overflow:hidden}
.thisnav a div {width:120px;height:80px;display:block;position:relative}
.thisnav a img {width:36px;position:absolute;left:50%;margin-left:-18px;top:40%;margin-top:-18px}
.thisnav a em {width:100%;height:36px;line-height:36px;display:block;font-style:normal;position:absolute;bottom:0;left:0}
.thisnav a:hover {background:url(statics/images/nb.gif) repeat-x;color:#039}
.tabcon {width:1270px;padding-top:30px;position:relative;}
.tabcon .title {width:90px;height:30px;line-height:30px;text-align:center;background:#fff;position:absolute;top:15px;left:35px;font-size:16px;font-weight:900;color:#06c}
.basetext {width:1150px;height:90px;background:#fff;border:1px solid #ddd;float:left;margin-left:5px;overflow:hidden}
.lztext {width:1150px;height:60px;background:#fff;border:1px solid #ddd;float:left;margin-left:5px;overflow:hidden}
.dowhat {width:160px;height:40px;line-height:40px;border-radius:6px;background:#06c;color:#fff;text-align:center;position:absolute;left:50%;margin-left:-80px;top:0px}
.null {width:100%;height:100px}
.rb {border-right:1px solid #ddd}
.upa {float:left;margin-left:15px}
.upa img {width:18px;margin-right:10px;}
.upa a {font-size:14px}
*/
</style>

<div class="tableContent">

<div class="tabcon">
<div class="title">警力配置</div>

<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="100" align="center" class="infotitle">选择</td>
    <td width="100" align="center" class="infotitle">单位ID</td>
    <td width="245" align="center" class="infotitle">单位</td>
    <td width="189" align="center" class="infotitle">应配置民警</td>
    <td width="195" align="center" class="infotitle">应配置辅警</td>
    <td width="178" align="center" class="infotitle">备注</td>    
    </tr>
 <?php foreach($rss as $v){?>   
  <tr>
    <td width="100" align="center" class="infotitle"><input type="checkbox" name="sets[<?php echo $v['id']?>]" />
      <input type="hidden" name="pmid[<?php echo $v['id']?>]" value="<?php echo $v['parentid']?>" class="input-text"/>
      <input type="hidden" name="myid[<?php echo $v['sid']?>]" value="<?php echo $v['sid']?>" class="input-text"/>    
    </td>
    <td width="100" align="center" class="infotitle"><?php echo $v['id']?></td>
    <td width="245" align="center" class="infotitle"><?php echo $v['name']?></td>
    <td width="189" align="center" class="infotitle"><input type="text" name="mj_ying[<?php echo $v['id']?>]" class="input-text" value="<?php echo intval($sarr[$v['id']]['mj_ying'])?>"/></td>
    <td width="195" align="center" class="infotitle"><input type="text" name="fj_ying[<?php echo $v['id']?>]" class="input-text" value="<?php echo intval($sarr[$v['id']]['fj_ying'])?>"/></td>
    <td width="178" align="center" class="infotitle"><input type="text" name="bz[<?php echo $v['id']?>]" class="input-text" value="<?php echo $sarr[$v['id']]['beizhu']?>"/></td>    
    </tr>  
  <?php }?>    
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



