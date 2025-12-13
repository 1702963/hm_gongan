<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

$shs[0]="";
$shs[1]="[同意]";
?>
<style type="text/css">
.button {
    background: #06c;
    color: #fff;
    height: 24px;
    border: 0;
    margin-right: 5px;
    cursor: pointer;
    padding: 3px ;
}
.clbutton {
    background: #06c;
    color: #ffcc00;
    height: 24px;
    border: 0;
    margin-right: 5px;
    cursor: pointer;
    padding: 3px ;
}
</style>

<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">
    <?php $jqnian=substr($nowyue[0]['yue'],0,4);$jqyue=substr($nowyue[0]['yue'],4,2)?>
    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>高新公安分局<?php echo $jqnian?>年<?php echo $jqyue?>月辅警突出贡献奖审批表</b>
	&nbsp; <input type="button" name="but1" value="审核突出贡献" style="border-radius:.4em;cursor:pointer; width:100px; height:25px; background-color:#06C; color:#FFF;display:" onclick="bmshenhe_do('<?php echo $nowyue[0]['yue']?>','juuser','<?php echo $show_table[0]['bmid']?>','<?php echo $_GET['msgid']?>')" <?php echo $buttoncan?>/>
	</div>


<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th width="48" align="center" style="font-size:12px;">序号</th>
            <th width="113" align="center" style="font-size:12px" >姓名</th>
            <th width="242" align="center" style="font-size:12px">所属单位</th>
            <th width="990" align="center" style="font-size:12px">奖励事迹</th>
            <th width="122" align="center" style="font-size:12px">奖金</th>
            <th width="202" align="center" style="font-size:12px">备注</th>
            <th width="143" align="center" style="font-size:12px">操作</th>
        </tr>
	</thead>
<tbody>
<?php 
		$i=1; 
		$zzz=0;
      if(is_array($show_table)){
	  foreach($show_table as $info){											
	?>
	<tr>
        <td <?php echo $bcolor?> align="center" ><?php echo $i?>
         <input type="hidden" name="ids" id="id<?php echo $info['id']?>" value="<?php echo $info['id']?>" />
        </td>	
		<td <?php echo $bcolor?> align="center" ><?php echo $fujings[$info['userid']]?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $bumen[$info['bmid']]?></td>

        <td <?php echo $bcolor?> align="left" ><?php echo $info['shiji'] ?></td>
        <td <?php echo $bcolor?> align="center" ><?php echo $info['je'] ?> 元</td>
		<td align="left" ><textarea name="beizhu" style="width:90%" onblur2="ajax_do_bz('<?php echo $info['id']?>',this.value)"/><?php echo $info['beizhu']?></textarea></td>
		<td align="center" >
<input type="button" name="shows" value="查看" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="gongxianedits2('<?php echo $info['id']?>')"/>
        </td>
        </tr>
<?php
 $zzz+= $info['je'];
 $i++;
}}?>
	<tr>
        <td colspan="7" align="right" style="padding-right:30px">合计：<span id="hj"><?php echo $zzz?></span> 元</td>	
	</tr>
</tbody>
</table>
<table width="100%" border="0">
  <tr>
    <td width="29%">主要负责人&nbsp;<?php if($info['juok2']>0){ ?><img src="<?php echo $qianzis[$info['juuser2']]?>" /><?php }?></td>
    <td width="36%">分管领导 &nbsp;<?php if($info['juok']>0){ ?><img src="<?php echo $qianzis[$info['juuser']]?>" /><?php }?></td>
    <td width="26%">审核人 &nbsp; <img src="<?php echo $qianzis[38]?>" /></td>
    <td width="9%">制表人&nbsp;张学军</td>
  </tr>
</table>

<div style="clear:both"></div>
</div>
</div>
<script language="javascript">
function gongxianedits2(id) {
		window.top.art.dialog({title:'查看突出贡献申请表', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tcgongxianedits2&id='+id ,width:'1100px',height:'550px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}
	
function addshenqing(){ 
		window.top.art.dialog({title:'发起突出贡献申请', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tcgongxianadd',width:'1100px',height:'550px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
	
function shenhebm(id){ 
		window.top.art.dialog({title:'申请部门审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tcgongxianshenhe&ty=bm&id='+id,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}

function shenhezzc(id){ 
		window.top.art.dialog({title:'申请政治处审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tcgongxianshenhe&ty=zzc&id='+id,width:'990px',height:'800px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}

function shenhefg(id){ 
		window.top.art.dialog({title:'申请分管领导审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tcgongxianshenhe&ty=fg&id='+id,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
	
function shenheju(id){ 
		window.top.art.dialog({title:'申请局领导审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tcgongxianshenhe&ty=ju2&id='+id,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	

function bmshenhe_do(yue,doty,bmid,msgid){ 
		window.top.art.dialog({title:'突出贡献审核', id:'shows', iframe:'?m=shenpi&c=tcgxshenpi&a=tcgxshenpi_do&ty='+doty+'&yue='+yue+'&bmid='+bmid+'&msgid='+msgid,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
///////////////////////////////////////////
  
	var objs=<?php echo $i?>-1; //对象数量
	
function junfens(){
	
	var kyze=parseFloat($("#canyongje").val())
	if(isNaN(kyze)){
		alert("未指定可分配金额")
		return false
		}

	dojes=kyze/objs
    for(i=1;i<=objs;i++){
		$("#"+i).val(dojes.toFixed(2))
		}		
}	

function infas(objid,ids){
if($("#"+objid).val()==""){
	$("#"+objid).val("0.00")
	}
	
	ajax_je(ids,$("#"+objid).val()) //回写金额
	ajax_do(ids,$("#zzcok"+ids).val()) //回写状态	
		
var hjje=0;
    for(i=1;i<=objs;i++){
		hjje+= parseFloat($("#"+i).val())
		}
			
if(hjje>parseFloat($("#canyongje").val())){
	alert("累计发放金额已超过预设总额度")
	$("#"+objid).val("0.00")
	return false
	}
		
 $("#hj").text(hjje)
}

function ajax_je(ids,jes){
	indata={id:ids,je:jes,ty:1}
	$.post("postintcgx.php",indata,function(result){
    /*alert(result)*/})
	}
	
function ajax_do(ids,dos){
	//alert(dos)
	
	indata={id:ids,zzcok:dos,ty:2}
	$.post("postintcgx.php",indata,function(result){})
		
	}	

function ajax_do_bz(ids,bz){
	indata={id:ids,beizhu:bz,ty:3}
	$.post("postintcgx.php",indata,function(result){})
	}	
</script>	
</body>
</html>
