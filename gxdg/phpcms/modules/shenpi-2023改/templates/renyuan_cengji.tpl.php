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
	<div class="cat_total_con ra"><div class="tcon"><span><a href="javascript:;" onClick="gangwei()" style="color:#ffffff">层级变动申请</a></span></div></div>
    
</div>
<?php }?>
<div class="table-list" <?php
if($_SESSION['roleid']==9){
?>style="margin-top:100px;"<?php }?>>
<form name="myform" id="myform" action="?m=cengji&c=cengji&a=listorder" method="POST">
<table width="96%" cellspacing="0" align="center">
	<thead>
		<tr>
			
			
			<th width="59" align="center">ID</th>
			<th width='96' align="center">辅警姓名</th>			
			<th width='455' align="center">层级		    </th>
			<th width='300' align="center">申请时间</th>
			<th width='550' align="center">审批状态</th>
			<th align="center" width="122">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr onDblClick="show(<?=$info['id']?>);">
		
		
		<td align="center" width="59"><?=$info['id']?></td>
		<td align="center" width="96"><?=$info['fjname']?></td>
		<td align="center" width="455">
		<table width="80%" border="0">
  <tr>
    <td width="12%" align="right"><strong>调动前</strong></td>
    <td width="38%" align="center"><?=$cengjis[$info['oldcj']]?></td>
    
  </tr>
  <tr>
    <td align="right"><strong>调动后</strong></td>
    <td align="center"><?=$cengjis[$info['newcj']]?></td>
    
  </tr>
</table>

</td>
		
		<td align="center" width="300"><?php echo date("Y-m-d",$info['inputtime']);?></td>
		<td align="left" width="550">
		<?php if($info['bmshid']){?><?php echo $ld[$info['bmshid']]?>:<span class="c<?php echo $info['bmstatus'];?>"><?php echo $zt[$info['bmstatus']];?></span><?php }?><br>

		<?php if($info['fgshid']){?><?php echo $ld[$info['fgshid']]?>:<span class="c<?php echo $info['fgstatus'];?>"><?php echo $zt[$info['fgstatus']];?></span><?php }?><br>

		<?php if($info['zrshid']){?><?php echo $ld[$info['zrshid']]?>:<span class="c<?php echo $info['zrstatus'];?>"><?php echo $zt[$info['zrstatus']];?></span><?php }?><br>

		<?php if($info['ldshid']){?><?php echo $ld[$info['ldshid']]?>:<span class="c<?php echo $info['ldstatus'];?>"><?php echo $zt[$info['ldstatus']];?></span>  <?php if($info['dai']==1){?><span class="c2">代签</span> <?php }?> <?php }?>
		</td>
		<td align="center" width="122">
		<?php if($_SESSION['roleid']==5 && $info['bmstatus']==1){?><a href="javascript:;;" onClick="bmsh(<?php echo $info['id'];?>);">审核</a><?php }?>
		<?php if($_SESSION['roleid']==3 && $info['fgstatus']==1){?><a href="javascript:;;" onClick="fgsh(<?php echo $info['id'];?>);">审核</a><?php }?>
		<?php if($_SESSION['roleid']==3 && $info['ldstatus']==1){?><a href="javascript:;;" onClick="ldsh(<?php echo $info['id'];?>);">审核</a><?php }?>
		<?php if($_SESSION['roleid']==2 && $info['zrstatus']==1){?><a href="javascript:;;" onClick="zrsh(<?php echo $info['id'];?>);">审核</a><?php }?>
		
		<?php if($info['bmstatus']==1 && $info['userid']==$_SESSION['userid']){?><a href="javascript:;" onClick="att_delete(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a><?php }?>
		</td>
	</tr>
	<?php
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
		window.top.art.dialog({title:'岗位变动申请', id:'showme', iframe:'?m=shenpi&c=cengjishenpi&a=gwbd' ,width:'980px',height:'610px'});
	}
function bmsh(id) {
		window.top.art.dialog({title:'部门领导审核', id:'showmebm', iframe:'?m=shenpi&c=cengjishenpi&a=bmsh&id='+id ,width:'600px',height:'300px'});
	}
function fgsh(id) {
		window.top.art.dialog({title:'分管领导审核', id:'showmefg', iframe:'?m=shenpi&c=cengjishenpi&a=fgsh&id='+id ,width:'600px',height:'300px'});
	}
function zrsh(id) {
		window.top.art.dialog({title:'政治处主任审核', id:'showmezr', iframe:'?m=shenpi&c=cengjishenpi&a=zrsh&id='+id ,width:'600px',height:'300px'});
	}	
	function ldsh(id) {
		window.top.art.dialog({title:'局领导审核', id:'showmeld', iframe:'?m=shenpi&c=cengjishenpi&a=ldsh&id='+id ,width:'600px',height:'300px'});
	}
function show(id) {
		window.top.art.dialog({title:'详细信息', id:'showmeld', iframe:'?m=shenpi&c=cengjishenpi&a=show&id='+id ,width:'900px',height:'800px'});
	}	
function att_delete(obj,aid){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=shenpi&c=cengjishenpi&a=delete&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>	
</body></html>
