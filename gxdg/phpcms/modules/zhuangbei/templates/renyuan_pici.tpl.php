<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');

$myref=explode("?",$_SERVER["HTTP_REFERER"]);

$id=intval($_REQUEST['objid']);
$this->db->table_name = 'mj_beizhuang_pici';
$piciinfo=$this->db->get_one("id=$id",'*');

//判断来源
if($_REQUEST['ref']=="bumen"){
	$gotourl="index.php?m=zhuangbei&c=zhuangbei&a=shenling";
	}else{
	$gotourl="index.php?m=zhuangbei&c=zhuangbei";	
		}

/////批量编辑
if($_POST['dopl']!=''){
	$plids=explode("|",$_POST['plids']);
	foreach($plids as $s){ 
		if($_POST['pledits']=="sf"){//首发		
	      $this->db->table_name = 'mj_fujing';
	      $this->db->update("scbz=".strtotime($_POST['plvalue']),array('id'=>intval($s)));
	      $this->db->table_name = 'mj_beizhuang_ulog';
		  $_POST['up']['scbz']=strtotime($_POST['plvalue']);
	      $this->db->update($_POST['up'],"uid=".intval($s)." and dotime=".intval($_POST['dotime']));
		  unset($_POST['up']);				
			}
		if($_POST['pledits']=="zjed"){//可以金额
	      $this->db->table_name = 'mj_beizhuang_ulog';
		  $_POST['up']['kyje']=$_POST['plvalue'];
	      $this->db->update($_POST['up'],"uid=".intval($s)." and dotime=".intval($_POST['dotime']));
		  unset($_POST['up']);				
			}			
		}
	}
//////编辑
if($_POST['saveme']!=""){
	//首次发放同步修改
//print_r($_POST['up']['scbz']);exit;	
	$this->db->table_name = 'mj_fujing';
	$this->db->update(array("scbz"=>$_POST['up']['scbz']),array('id'=>intval($_POST['uid'])));
	$this->db->table_name = 'mj_beizhuang_ulog';
	$this->db->update($_POST['up'],array('id'=>intval($_POST['pcid'])));	
	}
/////////////////////////////////

//获取当前人员池数量
    $this->db->table_name = 'mj_beizhuang_ulog';
	//先取出全局数量
    $rss = $this->db->select(" dotime=".$piciinfo['dotime'],'count(*) as px','','');
	$bmtj[1][0]=$rss[0]['px'];
    $rss = $this->db->select(" sjje>0 and dotime=".$piciinfo['dotime'],'count(*) as px','','');
	$bmtj[1][1]=$rss[0]['px'];	
	
	
    $rss = $this->db->select(" dotime=".$piciinfo['dotime'],'bmid,count(bmid) as px','','','bmid');
	foreach($rss as $v){
		$bmtj[$v['bmid']][0]=$v['px'];
		}
//已申领的统计		
    $rss = $this->db->select(" sjje>0 and dotime=".$piciinfo['dotime'],'bmid,count(bmid) as px','','','bmid');
	foreach($rss as $v){
		$bmtj[$v['bmid']][1]=$v['px'];
		}

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
if($_REQUEST['bmid']!=''){
	$where=" and bmid=".intval($_REQUEST['bmid']);
	}
if($_SESSION['roleid']!=10 && $_SESSION['roleid']!=1 ){
	$where.=" and bmid=".intval($_SESSION['bmid']) ;
	}

        $this->db->table_name = 'mj_beizhuang_ulog';
		  $rss = $this->db->select(" dotime=".$piciinfo['dotime'].$where,'*','','bmid asc,CONVERT(uname USING gbk) asc');	 //注意此处的汉字排序语法，先用部门排序，然后用姓名排序

			
		foreach($rss as $aaa){
			$bfuser[]=$aaa;
		}		
?>
<div class="pad-lr-10">
<div class="explain-col" style="width:120%"> 
<form method="get" >
<input type="hidden" value="zhuangbei" name="m">
<input type="hidden" value="zhuangbei" name="c">
<input type="hidden" value="renyuan" name="a">
<input type="hidden" value="<?php echo $id ?>" name="objid">
<input type="hidden" name="ref" value="<?php echo $_REQUEST['ref']?>" />
<table width="100%" border="0">
  <tr>
    <td width="71%" height="30">
  所在部门: <select name="bmid">
             <?php foreach($bms as $k=>$b){
				if($_SESSION['roleid']==0 || $_SESSION['roleid']==1){ 
				 ?>
              <option value="<?php echo $k?>" <?php if($k==intval($_GET['bmid'])){?>selected<?php }?>><?php echo $b?>&nbsp;[<?php echo intval($bmtj[$k][0])?>,<?php echo intval($bmtj[$k][1])?>]</option>
             <?php }else{
				 if($k==$_SESSION['bmid']){
				 ?>
             <option value="<?php echo $k?>" <?php if($k==intval($_GET['bmid'])){?>selected<?php }?>><?php echo $b?>&nbsp;[<?php echo intval($bmtj[$k][0])?>,<?php echo intval($bmtj[$k][1])?>]</option>
             <?php }}}?>
           </select>
  &nbsp;&nbsp;
  <input type="submit" value="搜索" class="button" name="dotongji" style="width:90px">&nbsp;&nbsp;<a class="button" href="index.php?m=zhuangbei&c=zhuangbei&a=piciuser&ref=<?php echo $_GET['ref']?>&objid=<?php echo $id?>">添加人员</a>&nbsp;&nbsp;<a class="button" href="<?php echo $gotourl?>">返回列表</a>
  &nbsp;&nbsp;  批量编辑：<select id="pledits0">
                          <option value="">无操作</option>
                          <option value="sf">首发时间</option>
                          <option value="zjed">资金额度</option>
                        </select> &nbsp;<input id="plvalue0" value="" style="width:70px" /> &nbsp;
                        <input type="button" value="批量处理" class="button" name="dotongji" style="width:90px" onclick="doanniu()">
  </td>
    <td width="29%" align="right" style="padding-bottom:10px">&nbsp;&nbsp;批次名称：<b><?php echo $piciinfo['title']?></b> &nbsp;,批次编码:<b style="color:#F00"><?php echo $piciinfo['dotime']?></b></td>
    </tr>  
</table>
</form>
<form method="post" action="" >
<input type="hidden" value="zhuangbei" name="m">
<input type="hidden" value="zhuangbei" name="c">
<input type="hidden" value="renyuan" name="a">
<input type="hidden" value="<?php echo $id ?>" name="objid">
<input type="hidden" name="ref" value="<?php echo $_REQUEST['ref']?>" />
<input type="hidden" id="plids" name="plids" value="" />
<input type="hidden" id="plvalue" name="plvalue" value="" />
<input type="hidden" id="pledits" name="pledits" value="" />
<input type="hidden" id="dotime" name="dotime" value="<?php echo $piciinfo['dotime']?>" />
<input type="submit" id="dopl" name="dopl" style="display:none" value="oks"/>
</form>
	</div>
    
<div class="table-list">
<table width="120%" cellspacing="0">
	<thead>
		<tr>
            <th width="3%" align="center" ><label onclick="selall()">全选</label></th>        
			<th width="3%" align="center">ID</th>
			<th width='8%' align="center">所属部门</th>			
			<th width='7%' align="center">姓名</th>
			<th width='4%' align="center">性别</th>
			<th width='7%' align="center">电话</th>
			<th width='10%' align="center">身份证</th>
			<th width='10%' align="center">层级</th>
			<th width='8%' align="center">职务</th>
            <th width='8%' align="center">首发时间</th>
            <th width='9%' align="center">上次申领时间</th>
            <th width='6%' align="center">资金额度</th>
            <th width='7%' align="center">已用额度</th>
			<th width="10%" align="center" >操作</th>
		</tr>
	</thead>
<tbody>
<?php
$i=1;
if(is_array($bfuser)){
	foreach($bfuser as $info){
		?>
<form name="myform" id="myform" action="index.php?m=zhuangbei&c=zhuangbei&a=renyuan" method="POST">
<input type="hidden" name="objid" value="<?php echo $id?>" />  
<input type="hidden" name="uid" value="<?php echo $info['uid']?>" />
<input type="hidden" name="bmid" value="<?php echo $_GET['bmid']?>" />
<input type="hidden" name="pcid" value="<?php echo $info['id']?>" />   
<input type="hidden" name="ref" value="<?php echo $_REQUEST['ref']?>" />    
	<tr>
    <td align="center" ><input type="checkbox" name="uids[]" value="<?php echo $info['uid']?>" /></td>
		<td align="center" ><?php  echo $i?></td>
		<td align="center" ><?php  echo $bms[$info['bmid']]?></td>
		<td align="center" ><?php  echo $info['uname']?></td>
		<td align="center" ><?php echo $info['sex']?></td>
		<td align="center" ><?php echo $info['tel']?></td>
		<td align="center" ><?php echo $info['sfz']?></td>
		<td align="center" ><?php echo $cengji[$info['cengji']]?></td>
		<td align="center" ><?php echo $zhiwu[$info['zhiwu']]?></td>
        <td align="center" ><input name="up[scbz]" value="<?php echo date("Y-m-d",$info['scbz'])?>" style="width:80px"/></td>
        <td align="center" >&nbsp;</td>
        <td align="center" ><input name="up[kyje]" value="<?php echo $info['kyje']?>"style="width:60px"/> </td>
        <td align="center" ><input name="up[sjje]" value="<?php echo $info['sjje']?>"style="width:60px"/><span></span></td>
		<td align="center" >&nbsp; 
           <input type="submit" name="saveme" value="编辑" style="width:60px" class="button" /> &nbsp;
		  <a href="javascript:;" onclick="renyuandel(this,'<?php echo $info['id']?>')" class="button">删除</a></td>
                                       
	</tr>
</form>    
	<?php
$i++;
	}
}
?>
</tbody>
</table>

<div id="pages"><?php echo $pages?></div>
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

function renyuandel(obj,id){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=zhuangbei&c=zhuangbei&a=renyuandel&id='+id+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
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
	
function doanniu(){
var str = 0;
	var id = tag = '';
	$("input[name='uids[]']").each(function() {
		if($(this).attr('checked')=='checked') {
			str = 1;
			id += tag+$(this).val();
			tag = '|';
		}
	});
	if(str==0) {
		alert('没有选择人员');
		return false;
	}else{
		$("#plids").val(id)
		}
	if($("#pledits0").val()==""){
		alert('没有指定操作对象');
		return false;		
		}
	if($("#plvalue0").val()==""){
		alert('操作值不得为空');
		return false;		
		}		
	
	if($("#pledits0").val()=="sf"){
       const date = Date.parse($("#plvalue0").val());
       if(!isNaN(date)){
		   
		   }else{
		   alert("不是合法的日期格式")
		   return false;	   
			   }		
		}
	
	$("#pledits").val($("#pledits0").val())
	$("#plvalue").val($("#plvalue0").val())
	$("#dopl").click()
	}	
</script>