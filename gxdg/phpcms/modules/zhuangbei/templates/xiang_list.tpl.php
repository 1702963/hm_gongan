<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');

$myref=explode("?",$_SERVER["HTTP_REFERER"]);

$id=intval($_REQUEST['objid']);
$this->db->table_name = 'mj_beizhuang_pici';
$piciinfo=$this->db->get_one("id=$id",'*');

//判断来源
if($_REQUEST['ref']=="bumen"){
	$gotourl="index.php?m=zhuangbei&c=zhuangbei&a=jilu";
	}else{
	$gotourl="index.php?m=zhuangbei&c=zhuangbei&a=jilu";	
		}

/////批量编辑
if($_POST['dopl']!=''){
	$plids=explode("|",$_POST['plids']);
	foreach($plids as $s){ 
		if($_POST['pledits']=="sf"){//首发
	      $this->db->table_name = 'mj_fujing';
	      $this->db->update("scbz=".$_POST['plvalue'],array('id'=>intval($s)));
	      $this->db->table_name = 'mj_beizhuang_ulog';
		  $_POST['up']['scbz']=$_POST['plvalue'];
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
	$this->db->table_name = 'mj_fujing';
	$this->db->update("scbz=".$_POST['up']['scbz'],array('id'=>intval($_POST['uid'])));
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
		
///获取当前批次类目
        $this->db->table_name = 'mj_beizhuang_zidian';
		$rss = $this->db->select(" dotime=".$piciinfo['dotime'],'*','','px asc');	
		//此处结构变形 便于动态列生成
		foreach($rss as $aaa){
			    $lmarr_name[$aaa['id']]=$aaa['name'];  //类目名称数组
				///主类目数组

				$lmarr_p[$aaa['pid']][$aaa['id']]=$aaa;

		}
		//print_r($lmarr_p);				
?>
<div class="pad-lr-10">
<div class="explain-col"> 
<form method="get" >
<input type="hidden" value="zhuangbei" name="m">
<input type="hidden" value="zhuangbei" name="c">
<input type="hidden" value="logxiang" name="a">
<input type="hidden" value="<?php echo $id ?>" name="objid">
<input type="hidden" name="ref" value="<?php echo $_REQUEST['ref']?>" />
<table width="100%" border="0">
  <tr>
    <td width="56%" height="30">
  所在部门: <select name="bmid">
             <?php foreach($bms as $k=>$b){
				if($_SESSION['roleid']==10 || $_SESSION['roleid']==1){ 
				 ?>
              <option value="<?php echo $k?>" <?php if($k==intval($_GET['bmid'])){?>selected<?php }?>><?php echo $b?>&nbsp;[<?php echo intval($bmtj[$k][0])?>,<?php echo intval($bmtj[$k][1])?>]</option>
             <?php }else{
				 if($k==$_SESSION['bmid']){
				 ?>
             <option value="<?php echo $k?>" <?php if($k==intval($_GET['bmid'])){?>selected<?php }?>><?php echo $b?>&nbsp;[<?php echo intval($bmtj[$k][0])?>,<?php echo intval($bmtj[$k][1])?>]</option>
             <?php }}}?>
           </select>
  &nbsp;&nbsp;
  <input type="submit" value="筛选" class="button" name="dotongji" style="width:90px">&nbsp;&nbsp;&nbsp;&nbsp;<a class="button" href="<?php echo $gotourl?>">返回列表</a>
  &nbsp;&nbsp;<a class="button" href="<?php echo $gotourl?>" style="display:none">按人员查看</a>
  &nbsp;&nbsp;<a class="button" href="<?php echo $gotourl?>" style="display:none">按被装类型查看</a>
  &nbsp;&nbsp;<a class="button" style="display:" onclick="copyme()">复制报表</a>
&nbsp;&nbsp; </td>
    <td width="44%" align="right" style="padding-bottom:10px">&nbsp;&nbsp;批次名称：<b><?php echo $piciinfo['title']?></b> &nbsp;,批次编码:<b style="color:#F00"><?php echo $piciinfo['dotime']?></b></td>
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
    
<div class="table-list" id="print_content">
<?php 
        $this->db->table_name = 'mj_beizhuang_linglog';	
?>
<table width="100%" cellspacing="0" >
	<thead>
		<tr>       
			<th width="3%" align="center">ID</th>
			<th width='8%' align="center">所属部门</th>			
			<th width='6%' align="center">姓名</th>
			<th width='3%' align="center">性别</th>
			<th width='7%' align="center">电话</th>
			<th width='7%' align="center">资金额度</th>
			<th width='7%' align="center">已用额度</th>
			<th align="center">
               <!--好怪异的表格-->
               <table width="100%" border="1">
                <tr>
			   <?php 
			    foreach($lmarr_p as $k=>$mainlm){
					if($k>0){
			   ?>
                     <th colspan="<?php echo count($mainlm)?>" align="center"><?php echo $lmarr_name[$k]?></th>
                <?php }}?>   
                  </tr> 
                   <tr>
               <?php 
			    foreach($lmarr_p as $k=>$mainlm){
				  if($k>0){	
				  foreach($mainlm as $k1=>$sublm){					 	 
			   ?>                   
                     <td align="center"><?php echo $lmarr_name[$k1]?></td>
               <?php }}}?>      
                   </tr>
                </table>
                <!---->			
            </th>

		</tr>
	</thead>
<tbody>
<?php
$i=1;
$z_edu=$z_sje=0;
if(is_array($bfuser)){
	foreach($bfuser as $info){
		?>
   
	<tr>
		<td align="center" ><?php  echo $i?></td>
		<td align="center" ><?php  echo $bms[$info['bmid']]?></td>
		<td align="center" ><?php  echo $info['uname']?></td>
		<td align="center" ><?php echo $info['sex']?></td>
		<td align="center" ><?php echo $info['tel']?>&nbsp;</td>
		<td align="center" ><?php $z_edu+=$info['kyje']; echo $info['kyje']?></td>
		<td align="center" ><?php $z_sje+=$info['sjje']; echo $info['sjje']?></td>
		<td align="center" >
        <table width="100%" border="0">
           <tr>
               <?php 
			    foreach($lmarr_p as $k=>$mainlm){
				  if($k>0){	
				  foreach($mainlm as $k1=>$sublm){
				   		$rstj = $this->db->get_one(" dotime=".$piciinfo['dotime']." and lmid=".$k1." and uid=".$info['uid'],'count(*) as tj');	  					 	 
			   ?>                   
                     <td align="center" style="width:102px; border-bottom:none"><?php echo $rstj['tj']?></td>
               <?php }}}?> 
		   
           </tr>
        </table>
        </td>
                                       
	</tr>
 
	<?php
$i++;
	}
}
?>
	<tr>
		<td align="center" >合计</td>
		<td align="center" >&nbsp;</td>
		<td align="center" >&nbsp;</td>
		<td align="center" >&nbsp;</td>
		<td align="center" >&nbsp;</td>
		<td align="center" ><?php echo $z_edu?></td>
		<td align="center" ><?php echo $z_sje?></td>
		<td align="center" >
        <table width="100%" border="0">
           <tr>
               <?php 
			    foreach($lmarr_p as $k=>$mainlm){
				  if($k>0){	
				  foreach($mainlm as $k1=>$sublm){
				   		$rstj = $this->db->get_one(" dotime=".$piciinfo['dotime']." and lmid=".$k1,'count(*) as tj');	  					 	 
			   ?>                   
                     <td align="center" style="width:102px; border-bottom:none"><?php echo $rstj['tj']?></td>
               <?php }}}?> 
		   
           </tr>
        </table>
        </td>
                                       
	</tr>
</tbody>
</table>



</div>
<textarea id="copy" style="display:none;"></textarea>
</div>
</body>
</html>
<script type="text/javascript">

function doxuan(pici,uid,uname,objid,ref) {
	window.top.art.dialog({title:'申领-'+uname, id:'showme', iframe:'?m=zhuangbei&c=zhuangbei&a=showxuan&uid='+uid+'&dotime='+pici+'&objid='+objid+'&ref='+ref ,width:'500px',height:'650px'});
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
	
	$("#pledits").val($("#pledits0").val())
	$("#plvalue").val($("#plvalue0").val())
	$("#dopl").click()
	}	
	
function copyText(str) {

        $('#copy').text(str).show();

        var ele = document.getElementById("copy");

        ele.select();

        document.execCommand('copy', false, null);

        $('#copy').hide();
		
        alert("数据已复制完成");
 }

function copyme(){
	copyText($("#print_content").html() );
	}	
</script>