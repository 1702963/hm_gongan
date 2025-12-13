<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');

$myref=explode("?",$_SERVER["HTTP_REFERER"]);
///////批次入库////////////
if($_POST['dosubmit']!=''){

    if(!isset($_POST['xz'])){
		showmessage('未选择任何类目','index.php?m=zhuangbei&c=zbmx&a=addlm&id='.$_POST['objid']);
		}
	
	//取出当前批次串码
	$this->db->table_name = 'mj_beizhuang_pici';
	$piciarr=$this->db->get_one("isdel=0 and id=".intval($_POST['objid']),'dotime');
	if(!$piciarr){
		showmessage('不存在指定批次');
		}
	if($piciarr['dotime']<1){
		showmessage('当前批次无流水码，无法创建类目');
		}	
		
	
	$this->db->table_name = 'mj_beizhuang_zidian';
	
	$selins=implode(",",$_POST['xz']);
	$lmarr = $this->db->select(" id in($selins) ",'id,pid,paths,name,dotime,guige,jiage,isok,beizhu,syhx,xyhx,px','','id asc');
	
	//此处需要重新映射，比较的麻烦了
	if(is_array($lmarr)){
	  foreach($lmarr as $ins){ 
	    $ins['oldid']=$ins['id'];
		unset($ins['id']);	 
	    $ins['dotime']=$piciarr['dotime'];	
	    $newid=$this->db->insert($ins,true); 
         //此处修改映射关系
		 $chengs=$this->db->get_one("id=$newid",'*');
		 if($chengs['pid']>0){ //如果插入项目是子节点则修改映射
			$chengs2=$this->db->get_one("oldid=".$chengs['pid']." and dotime=".$chengs['dotime'],'*');
			$this->db->update("pid=".$chengs2['id'],"id=$newid"); 
			 }
		  
	  }
	 showmessage("操作完成",$_POST['forward'],3000,'showme');
	}
	
	}


//////
$lmarr = $this->db->listinfo("pid=0 and dotime=0 and isok=1 ",$order = 'px asc',$page, $pages = '300');
//////

$outtree="";

////此处递归输出树形结构
///pid 要获取的节点ID  0为一级；spid 当前选中的节点 ；dotime 批次；outstr 输出字串，&$引用
function gettrees($dbobj,$pid=0,$spid=0,$dotime=0,&$outstr ){
	$tmprs = $dbobj->select("pid=$pid and dotime=0 ",'*','',"px asc");
	if(isset($tmprs[0])){
		foreach($tmprs as $t){
		 //根据节点路由补加前置占位
		 $bwqzstr=str_repeat("┈",count(explode(",",$t['paths']))-1); //生成字符占位	
		 //判断是否选中
		 if($t['id']==$spid){
			 $issed="selected='selected'";
			 }else{
				$issed=""; 
				 }
		 
		 $outstr.="	<tr>
		<td width=\"97\" height=\"37\" align=\"center\"><input type=\"checkbox\" name=\"xz[]\" value=\"".$t['id']."\" /></td>
		<td width=\"609\" align=\"left\">".$bwqzstr.$t['name']."</td>
		<td width=\"426\" align=\"center\">".$t['syhx']."</td>
		<td width=\"286\" align=\"center\">".$t['xyhx']."</td>
		<td align=\"center\">".$t['jiage']."</td>
	  </tr>                
	<tr>";
		  gettrees($dbobj,$t['id'],$spid,0,$outstr);	
			}
		}else{
		  return ;	
			}
	}

?>
<div class="pad-lr-10">
<div class="table-list">
<form action="?m=zhuangbei&c=zbmx&a=addlm" method="POST" name="myform" id="myform">
<input type="hidden" name="objid" value="<?php echo $_GET['id']?>" />
<table cellpadding="2" cellspacing="1" width="100%">
<thead>
	<tr>
		<th width="97" height="37" bgcolor="#eef3f7"><label onclick="selall()">选择</label></th>
		<th width="609" align="center" bgcolor="#eef3f7">类目名称</th>
		<th width="426" align="center" bgcolor="#eef3f7">上衣号型</th>
		<th width="286" align="center" bgcolor="#eef3f7">下衣号型</th>
		<th width="428" align="center" bgcolor="#eef3f7">单价</th>
	  </tr> 
</thead>       
   <?php if(is_array($lmarr)){
	      foreach($lmarr as $l){
	   ?>   
	<tr>
		<td width="97" height="37" align="center"><input type="checkbox" name="xz[]" value="<?php echo $l['id']?>" /></td>
		<td width="609" align="left"><?php echo $l['name']?></td>
		<td width="426" align="center"><?php echo $l['syhx']?></td>
		<td width="286" align="center"><?php echo $l['xyhx']?></td>
		<td align="center"><?php echo $l['jiage']?></td>
	  </tr>                
  <?php
    gettrees($this->db,$l['id'],0,0,$outtree);
	echo $outtree;
	$outtree="";
   }}?>  
   	<tr>
		<th></th>
		<td colspan="4"><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " style="width:90px"/> &nbsp; <input type="submit" name="nodosave" class="button" value=" 关闭 " style="width:90px"/></a></td>
	  </tr>

</table>
<input type="hidden" name="forward" value="<?php echo "index.php?".$myref[1];?>">
</form>
</div>
</div>
</body>
<script language="javascript">
function selall(){
$("input[name='xz[]']").each(function() {
		if($(this).attr('checked')=='checked') {
          $(this).removeAttr("checked");
		}else{
			$(this).attr("checked","checked");
			}
	});	
	}
	
</script>
</html>



