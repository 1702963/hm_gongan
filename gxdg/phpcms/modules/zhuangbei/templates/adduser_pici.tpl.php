<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');

$myref=explode("?",$_SERVER["HTTP_REFERER"]);
$id=intval($_REQUEST['objid']);
$this->db->table_name = 'mj_beizhuang_pici';
$piciinfo=$this->db->get_one("id=$id",'*');
///////////////////////////////////////////////////////////////////////
if($_POST['doadduser']!=""){
        $this->db->table_name = 'mj_fujing';
		//此处需要实例化两个数据库对象？不那么干，用数组解决
		foreach($_POST['uids'] as $uv){
          $_user=$this->db->get_one("id=$uv",'*');
		  if(isset($_user['id'])){
			$_intos['uid']=$_user['id'];
			$_intos['uname']=$_user['xingming'];
			$_intos['sex']=$_user['sex'];
			$_intos['tel']=$_user['tel'];  
			$_intos['sfz']=$_user['sfz'];
			$_intos['cengji']=$_user['cengji'];
			$_intos['zhiwu']=$_user['zhiwu'];
			$_intos['bmid']=$_user['dwid'];
			$_intos['dotime']=intval($_POST['dotime']);
			$_intos['inputtime']=time();
			$_intos['scbz']=$_user['scbz'];
			$intoss[]=$_intos;
			unset($_intos);
		  }
		}
		  /////
		  if(isset($intoss)){
			  $this->db->table_name = 'mj_beizhuang_ulog';
			  foreach($intoss as $ins)
			  $this->db->insert($ins);  
			  }
		 showmessage("操作完成","index.php?m=zhuangbei&c=zhuangbei&a=renyuan&ref=".$_POST['ref']."&objid=".$id);	  
	
	}
///////////////////////////////////////////////////////////////////////



//获取部门
        $this->db->table_name = 'mj_bumen';
		$rss = $this->db->select("",'id,name,parentid','','listorder asc');	
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
		}
		//邦定层级
		$this->db->table_name = 'mj_cengji';
		$rss = $this->db->select("",'id,cjname','','px desc');
		$cengji=array();
		
		foreach($rss as $aaa){
			$cengji[$aaa['id']]=$aaa['cjname'];
			
			}
		//邦定岗位
		$this->db->table_name = 'mj_gangwei';
		$rss = $this->db->select("",'id,gwname','','id asc');
		$gangwei=array();
		
		foreach($rss as $aaa){
			$gangwei[$aaa['id']]=$aaa['gwname'];
			
			}
		//邦定职务
		$this->db->table_name = 'mj_zhiwu';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu=array();
		
		foreach($rss as $aaa){
			$zhiwu[$aaa['id']]=$aaa['zwname'];
			
			}
					
////获取人员
$where="";
if($_GET['bmid']!=''){
	$where.=" and dwid=".intval($_GET['bmid']);
	}
if($_GET['cengji']!=''){
	$where.=" and cengji=".intval($_GET['cengji']);
	}
if($_GET['zhiwu']!=''){
	$where.=" and zhiwu=".intval($_GET['zhiwu']);
	}		

if($_SESSION['roleid']>1){ 
//  $where.=" and dwid=".intval($_SESSION['bmid']);
}else{
  if($_SESSION['roleid']!=10 ){ 
 //   $where.=" and dwid=".intval($_SESSION['bmid']);
  }	
	}

///此处获取已收入批次的人员ID，在人员池内清理掉
        $noinids[]=0;
        $this->db->table_name = 'mj_beizhuang_ulog';
		$rss = $this->db->select(" dotime=".$piciinfo['dotime'],'uid','','');	
		foreach($rss as $aaa){
			$noinids[]=$aaa['uid'];
		}
        
		$nowhere=" and id not in(".implode(",",$noinids).")";
//echo $where; 
        $this->db->table_name = 'mj_fujing';
		$rss = $this->db->select(" status=1 ".$where.$nowhere,'*','','dwid asc');	
		
		foreach($rss as $aaa){
			$userarr[]=$aaa;
		}		
		
	//	print_r($userarr);
?>
<div class="pad-lr-10">
<div class="explain-col"> 
<form method="get" >
<input type="hidden" value="zhuangbei" name="m">
<input type="hidden" value="zhuangbei" name="c">
<input type="hidden" value="piciuser" name="a">
<input type="hidden" value="<?php echo $id ?>" name="objid">
<input type="hidden" value="<?php echo $piciinfo['dotime'] ?>" name="dotime">
<input type="hidden" value="<?php echo $_GET['ref'] ?>" name="ref">
<table width="100%" border="0">
  <tr>
    <td width="70%" height="30">
  所在部门: <select name="bmid">
             <?php foreach($bms as $k=>$b){
				 if($_SESSION['roleid']==10 || $_SESSION['roleid']==1){ 
				 ?>
              <option value="<?php echo $k?>" <?php if($k==intval($_GET['bmid'])){?>selected<?php }?>><?php echo $b?></option>
             <?php }else{
				 if($k==$_SESSION['bmid']){
				 ?>
                 <option value="<?php echo $k?>" <?php if($k==intval($_GET['bmid'])){?>selected<?php }?>><?php echo $b?></option> 
             <?php }}}?>
           </select>
  &nbsp;&nbsp;
  姓名： <input name="xingming" value="" style="width:80px"/>&nbsp;&nbsp;
  层级:  <select name="cengji">
          <option value="">不限</option>
         <?php foreach($cengji as $k=>$c){?>
         <option value="<?php echo $k?>"><?php echo $c?></option>
         <?php }?>
        </select>&nbsp;&nbsp;
  职务:  <select name="zhiwu">
            <option value="">不限</option>
          <?php foreach($zhiwu as $k=>$z){?>
          <option value="<?php echo $k?>"><?php echo $z?></option>
          <?php }?>
        </select>&nbsp;&nbsp;
  首发时间： <input name="sfsj" value="" style="width:80px"/> &nbsp;&nbsp;           
  
  <input type="submit" value="筛选" class="button" name="dotongji" style="width:90px">&nbsp;&nbsp;&nbsp;<a class="button" href="index.php?m=zhuangbei&c=zhuangbei&a=renyuan&ref=<?php echo $_GET['ref']?>&objid=<?php echo $id?>">返回列表</a></td>
    <td width="30%" align="right">&nbsp;&nbsp;批次名称：<b><?php echo $piciinfo['title']?></b> &nbsp;,批次编码:<b style="color:#F00"><?php echo $piciinfo['dotime']?></b> &nbsp;</td>
    </tr>  
</table>
</form>
	</div>
    
<div class="table-list">
<form name="myform" id="myform" action="?m=zhuangbei&c=zhuangbei&a=piciuser" method="POST">
<input type="hidden" value="<?php echo $id ?>" name="objid">
<input type="hidden" value="<?php echo $piciinfo['dotime'] ?>" name="dotime">
<input type="hidden" value="<?php echo $_GET['ref'] ?>" name="ref">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="3%" align="center"><label onclick="selall()">选择</label></th>
			<th width='8%' align="center">所属部门</th>			
			<th width='8%' align="center">姓名</th>
			<th width='6%' align="center">性别</th>
			<th width='6%' align="center">电话</th>
			<th width='11%' align="center">身份证</th>
			<th width='10%' align="center">层级</th>
			<th width='8%' align="center">职务</th>
            <th width='8%' align="center">首发时间</th>
            <th width='9%' align="center">上次申领时间</th>
          </tr>
	</thead>
<tbody>
<?php

if(is_array($userarr)){
	foreach($userarr as $info){
		?>
	<tr>
		<td align="center" ><input type="checkbox" name="uids[]" value="<?php echo $info['id']?>" /></td>
		<td align="center" ><?php  echo $bms[$info['dwid']]?></td>
		<td align="center" ><?php  echo $info['xingming']?></td>
		<td align="center" ><?php echo $info['sex']?></td>
		<td align="center" ><?php echo $info['tel']?></td>
		<td align="center" ><?php echo $info['sfz']?></td>
		<td align="center" ><?php echo $cengji[$info['cengji']]?></td>
		<td align="center" ><?php echo $zhiwu[$info['zhiwu']]?></td>
        <td align="center" ><?php echo $info['scbz']?></td>
        <td align="center" >&nbsp;</td>
        </tr>
	<?php
$i++;
	}
}
?>
</tbody>
</table>
<div class="btn"><input type="submit"  class="button" name="doadduser" value="加入选定人员" style="width:90px"/></div>
<div id="pages">共计：<b id="nums"><?php echo count($userarr)?></b></div>
</form>
</div>
</div>
</body>
</html>
<script type="text/javascript">

function dopici(id) {
	titlestr="新增";
	if(id>0){
		titlestr="编辑";
		}
	window.top.art.dialog({title:titlestr+'批次', id:'showme', iframe:'?m=zhuangbei&c=zhuangbei&a=dopici&id='+id ,width:'700px',height:'450px'});
}

function picidel(obj,id){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=zhuangbei&c=zhuangbei&a=picidel&id='+id+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};

function selall(){
$("input[name='uids[]']").each(function() {
		if($(this).attr('checked')=='checked') {
          $(this).removeAttr("checked");
		}else{
			$(this).attr("checked","checked");
			}
	});	
	}
	
</script>