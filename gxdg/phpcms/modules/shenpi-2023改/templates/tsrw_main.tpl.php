<?php
defined('IN_ADMIN') or exit('No permission resources.');
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';	
?>
<body>
<style type="text/css">


.cat_total {width:100%;float:left}
.cat_total_con {width:22.5%;height:70px;margin:0 0 0 2%;float:left;color:#fff;font-size:18px;font-family:microsoft yahei}
.cat_total_con .tcon {position:relative;width:100%;height:120px;}
.cat_total_con .tcon span {position:absolute;left:70px;top:20px;}
.cat_total_con .tcon b {font-size:44px;font-weight:100;position:absolute;right:20px;bottom:10px}
.ra {background:#6cc9b6 url(statics/images/ra.png) 15px 15px no-repeat}
.rb {background:#a2aee3 url(statics/images/rb.png) 15px 15px no-repeat}
.rc {background:#989bb7 url(statics/images/rc.png) 15px 15px no-repeat}
.rd {background:#e8bf9c url(statics/images/rd.png) 15px 15px no-repeat}
.c1{ color:#000000}
.c2{ color:#FF0000}
.c9{ color:#33CC33}
</style>
<script>
$(function(){
	$("#tongzhi > div:not(:first)").hide();
	var pi = $("#cat_nav > ul > li");
	var pd = $("#tongzhi > div");
	pi.each(function(p){
		$(this).mouseover(function(){
			pi.removeClass("active"); $(this).addClass("active");pd.hide();pd.eq(p).show();
		});
	});
	
});
</script>
<?php
if($_SESSION['roleid']==9){
?>
<div class="cat_total">
	<div class="cat_total_con ra"><div class="tcon"><span><a href="javascript:;" onClick="gangwei()" style="color:#ffffff">考勤审核申请</a></span></div></div>
    
</div>
<?php }?>
<div class="table-list" <?php
if($_SESSION['roleid']==9){
?>style="margin-top:100px;"<?php }?>>
<form name="myform" id="myform" action="?m=cengji&c=cengji&a=listorder" method="POST">
<table width="96%" cellspacing="0" align="center">
	<thead>
		<tr>
			
			
			<th width="67" align="center">ID</th>
			<th width='813' align="center">申请内容</th>			
			<th width='281' align="center">申请时间</th>
			<th width='332' align="center">阅读状态</th>
			<th align="center" width="309">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($msgs)){
	$i=1;
	foreach($msgs as $info){
	
	if($_SESSION['roleid']==1){
	  $tousers="[".$admins[$info['showuser']]."]";
	}
		?>
	<tr onDblClick="show(<?=$info['id']?>);">
		<td align="center" width="67"><?=$i?></td>
		<td align="left" width="813"><?=$info['msg']?> &nbsp;<?php echo $tousers ?>&nbsp;[<?php if($info['addbm']>0){ echo $bumen[$info['addbm']]; }else{ echo "全局";}?>]</td>
		<td align="center" width="281"><?php echo date("Y-m-d H:i:s",$info['adddt'])?></td>
		
		<td align="center" width="332"><?php if($info['isshow']==1){echo "已读:".date("Y-m-d H:i:s",$info['readdt']);}else{echo "未读";}?></td>
		<td align="center" width="309">
        <?php if($info['dodt']==0){?>
           <a href="index.php?m=shenpi&c=tsrwshenpi&a=<?php echo $info['doty']?>&yues=<?php echo $info['yues']?>&msgid=<?php echo $info['id']?>&doty=<?php echo $info['doty']?>&bmid=<?php echo $info['addbm']?>" style="color:#F00">待审批</a>
        <?php }else{?>
           <a href="index.php?m=shenpi&c=tsrwshenpi&a=<?php echo $info['doty']?>&yues=<?php echo $info['yues']?>&msgid=<?php echo $info['id']?>&doty=<?php echo $info['doty']?>&bmid=<?php echo $info['addbm']?>" style="color:#0F0">已审批</a>        
        <?php }?>
        </td>
	</tr>
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
<script type="text/javascript">

function gangwei(id) {
		window.top.art.dialog({title:'岗位变动申请', id:'showme', iframe:'?m=shenpi&c=renyuanshenpi&a=gwbd' ,width:'980px',height:'610px'});
	}
function bmsh(id) {
		window.top.art.dialog({title:'部门领导审核', id:'showmebm', iframe:'?m=shenpi&c=renyuanshenpi&a=bmsh&id='+id ,width:'600px',height:'300px'});
	}
function fgsh(id) {
		window.top.art.dialog({title:'分管领导审核', id:'showmefg', iframe:'?m=shenpi&c=renyuanshenpi&a=fgsh&id='+id ,width:'600px',height:'300px'});
	}
function zrsh(id) {
		window.top.art.dialog({title:'政治处主任审核', id:'showmezr', iframe:'?m=shenpi&c=renyuanshenpi&a=zrsh&id='+id ,width:'600px',height:'300px'});
	}	
	function ldsh(id) {
		window.top.art.dialog({title:'局领导审核', id:'showmeld', iframe:'?m=shenpi&c=renyuanshenpi&a=ldsh&id='+id ,width:'600px',height:'300px'});
	}
function show(id) {
		window.top.art.dialog({title:'详细信息', id:'showmeld', iframe:'?m=shenpi&c=renyuanshenpi&a=show&id='+id ,width:'900px',height:'800px'});
	}	
function att_delete(obj,aid){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=shenpi&c=renyuanshenpi&a=delete&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>	
</body></html>
