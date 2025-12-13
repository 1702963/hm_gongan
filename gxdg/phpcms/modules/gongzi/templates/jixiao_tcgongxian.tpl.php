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
<?php 
		  if($_SESSION['roleid']<=4){		    
?>
<div>
  <a href="index.php?m=gongzi&c=jixiao&a=tcgongxian&ty=0"><input type="button" value="正常记录" class="<?php if($doty==0){?>clbutton<?php }else{?>button<?php }?>"  style="width:100px"></a> &nbsp;
  <a href="index.php?m=gongzi&c=jixiao&a=tcgongxian&ty=1"><input type="button" value="作废记录" class="<?php if($doty==1){?>clbutton<?php }else{?>button<?php }?>"  style="width:100px"></a> &nbsp;
</div>
<?php }?>
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>辅警突出贡献管理</b></div>
    <?php if($_SESSION['roleid']==1||$_SESSION['roleid']==2||$_SESSION['roleid']==3){?>
    <form action="" method="get">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="tcgongxian"/>
    <input type="hidden" name="yue" value="<?php echo $_GET['yue']?>"/>  
      <div style=" width:100%;font-size:12px; text-align:center; margin-bottom:5px">选择部门
               <select name="bms">
                <?php foreach($bumen as $k=>$v){?>
                <option value="<?php echo $k?>" <?php if(intval($_GET['bms'])==$k){?> selected="selected"<?php }?> ><?php echo $v?></option>
                <?php }?>
               </select>
               <input type="submit" name="dosel" value="定位" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF"/>
      </div>
     </form> 
	 <?php }?>

<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px;"><a href="javascript:;" onclick="checkAll()">选择</a></th>
            <th align="center" style="font-size:12px; width:30px">序号</th>
            <th align="center" style="font-size:12px" >姓名</th>
            <th align="center" style="font-size:12px; width:180px">身份证号</th>
            <th align="center" style="font-size:12px">单位</th>
            <th align="center" style="font-size:12px">岗位</th>
            <th align="center" style="font-size:12px">奖励金额</th>
            <th align="center" style="font-size:12px">申请日期</th>
            <th align="center" style="font-size:12px">发放档期</th>
            <th align="center" style="font-size:12px">部门审核</th>
            <th align="center" style="font-size:12px">分管领导审核</th>			
            <th align="center" style="font-size:12px">政治处审核</th>
            <th align="center" style="font-size:12px">局领导审核</th>
            <th align="center" style="font-size:12px">审核进度</th>
            <th align="center" style="font-size:12px">操作</th>
		</tr>
	</thead>
<tbody>
<?php 
	  if(intval($_GET['page'])<=1){
		$i=1;  
	   }else{
		$i=1+(intval($_GET['page'])-1)*14;   
		   }

      if(is_array($show_table)){
	  foreach($show_table as $info){
	    $bcolor="";	  
		if($info['bmmast']>0 && $info['bmmastdt']<1){
			$bcolor="style=\"background-color:#FFC\"";
			}
				
		if($info['zzcmast']>0 && $info['zzcmastdt']<1){
			$bcolor="style=\"background-color:#e8b853\"";
			}
				
		if($info['jumast']>0 && $info['jumastdt']<1){
			$bcolor="style=\"background-color:#ffd7c4\"";
			}
			
	    //$nosq1="disabled=\"disabled\"";	
		//$nosq2="disabled=\"disabled\"";	
		//$nosq3="disabled=\"disabled\"";	
		//$nosq4="disabled=\"disabled\"";	
											
	?>
	<tr>
        <td <?php echo $bcolor?> align="center" ><input type="checkbox" name="sle[]" id="ids<?php echo $info['id']?>" value="<?php echo $info['id']?>" onclick="clickmes(this.id)"  /></td>		
		<td <?php echo $bcolor?> align="center" ><?php echo $i?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $fujings[$info['userid']]?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['sfz']?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $bumen[$info['bmid']]?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $gangwei[$info['gangwei']]?></td>
        <td <?php echo $bcolor?> align="center" ><?php echo $info['je']?> 元</td>
        <td <?php echo $bcolor?> align="center" ><?php echo date("Y-m-d",$info['indt'])?></td>
		<td <?php echo $bcolor?> align="center" ><?php echo $info['yue']?></td>
        <td <?php echo $bcolor?> align="center" ><?php if($_SESSION['userid']==$info['sqbmuser']){?><a href="javascript:;" onclick="gongxianedits('<?php echo $info['id']?>')">点击审核<?php echo $shs[$info['bmok']]?></a><?php }else{ ?><input type="button" name="shenhe1" value="申请审核" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="shenhebm('<?php echo $info['id']?>')" <?php echo $nosq1?>/> <?php }?></td>
		<td <?php echo $bcolor?> align="center" ><?php if($_SESSION['userid']==$info['fenguanlingdao']){?><a href="javascript:;" onclick="gongxianedits('<?php echo $info['id']?>')">点击审核<?php echo $shs[$info['fgok']]?></a><?php }else{ ?><input type="button" name="shenhe3" value="申请审核" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="shenhefg('<?php echo $info['id']?>')" <?php echo $nosq1?>/><?php }?></td>		
		<td <?php echo $bcolor?> align="center" ><?php if($_SESSION['userid']==$info['zzcuser']){?><a href="javascript:;" onclick="gongxianedits('<?php echo $info['id']?>')">点击审核<?php echo $shs[$info['zzcok']]?></a><?php }else{ ?><input type="button" name="shenhe2" value="申请审核" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="shenhezzc('<?php echo $info['id']?>')" <?php echo $nosq1?>/><?php }?></td>
		<td <?php echo $bcolor?> align="center" ><?php if($_SESSION['userid']==$info['juuser']){?><a href="javascript:;" onclick="gongxianedits('<?php echo $info['id']?>')">点击审核<?php echo $shs[$info['juok']]?></a><?php }else{ ?><input type="button" name="shenhe4" value="申请审核" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="shenheju('<?php echo $info['id']?>')" <?php echo $nosq1?>/><?php }?></td>
		<td <?php echo $bcolor?> align="center" >
		<?php $jindu="";
		      if($info['sqbmuser']>0){$jindu="部门审核";}
			  if($info['fgok']>0){$jindu="分管领导审核通过";}
			  if($info['zzcuser']>0){$jindu="政治处审核";}
			  if($info['zzcok']>0){$jindu="政治处审核通过";}
			  if($info['juuser']>0){$jindu="局领导审核";
			    if($info['juok']==1){$jindu="审核完成";}
			  }
			  echo $jindu;
		?>
		</td>
        <td <?php echo $bcolor?> align="center" ><input type="button" name="shows" value="查看" style="border-radius:.4em;cursor:pointer; width:60px; height:25px; background-color:#06C; color:#FFF" onclick="gongxianedits('<?php echo $info['id']?>')"/>
           <input type="button" name="shows" value="作废" style="border-radius:.4em;cursor:pointer; width:60px; height:25px; background-color:#06C; color:#FFF" onclick="gongxianedits('<?php echo $info['id']?>')"/>
        </td>
             
	</tr>
<?php 
 $i++;
}}?>
</tbody>
	<thead>
		<tr>
            <th colspan="15" align="left" style="font-size:12px"><input type="button" name="addsq" value="发起申请" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF" onclick="addshenqing()"/></th>
        </tr>
	</thead> 
</table>
<div id="pages"><?php echo $pages?></div>
<div style="clear:both"></div>
</div>
</div>
<script language="javascript">
function gongxianedits(id) {
		window.top.art.dialog({title:'编辑突出贡献申请表', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tcgongxianedits&id='+id ,width:'1100px',height:'550px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
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
		window.top.art.dialog({title:'申请局领导审核', id:'shows', iframe:'?m=gongzi&c=jixiao&a=tcgongxianshenhe&ty=ju&id='+id,width:'480px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
	
///////////////////////////////////////////
//复选过程
function clickmes(objid){
//此处考虑使用公共数组方式进行操作，比使用组件对象存储字符串有优势
if($("#"+objid).attr("checked")){
	window.parent.tcgongxian.push($("#"+objid).val())
	//alert(window.parent.tcgongxian.length)
	}else{
	  window.parent.tcgongxian.forEach(function(item, index, arr) {
	    if(item == $("#"+objid).val() ) {
          window.parent.tcgongxian.splice(index, 1);
        }
	   })
		//alert(window.parent.tcgongxian.length)	
	}	

//////////
	}	
	
function getQueryString() {  
  var qs = location.search.substr(1), // 获取url中"?"符后的字串  
    args = {}, // 保存参数数据的对象
    items = qs.length ? qs.split("&") : [], // 取得每一个参数项,
    item = null,
    len = items.length;
 
  for(var i = 0; i < len; i++) {
    item = items[i].split("=");
    var name = decodeURIComponent(item[0]),
      value = decodeURIComponent(item[1]);
    if(name) {
      args[name] = value;
    }
  }
  return args;
}

//如果是直接进入则清空中间数据
getstr=getQueryString()
if(getstr['page']==undefined){
 //在父层创建一个数组
 window.parent.tcgongxian = new Array()	
}else{
   //如果是翻页，则检查数组写回已选状态	
	  window.parent.tcgongxian.forEach(function(item, index, arr) {
         if($("#ids"+item).val()!=undefined){
			$("#ids"+item).prop("checked",true)
			 }
	   })	
	}

///////////////////////////////////////////
			function checkAll(){		
				var checkboxs = document.getElementsByName("sle[]");//根据name获得每个输入框的对象数组
				for(var i = 0 ;i<checkboxs.length;i++){//普通for循环遍历
					if(checkboxs[i].checked==true){
						checkboxs[i].checked = false;
						//批量取消的时候
	                     window.parent.tcgongxian.forEach(function(item, index, arr) {
	                      if(item == checkboxs[i].value ) {
                            window.parent.tcgongxian.splice(index, 1);
                           }
	                     })						
					}else{
						checkboxs[i].checked = true;
						window.parent.tcgongxian.push(checkboxs[i].value)
					}
				}
			}		
</script>	
</body>
</html>
