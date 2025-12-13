<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>已完成审核的特殊任务列表</b></div>

<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px;width10%">姓名</th>
            <th align="center" style="font-size:12px;">部门</th>
            <th align="center" style="font-size:12px;">岗位</th>
            <th align="center" style="font-size:12px;">任务时段</th>
            <th align="center" style="font-size:12px;">特殊任务名称</th>
            <th align="center" style="font-size:12px;">补助金额</th>
            <th align="center" style="font-size:12px;">关联工资月</th>
            <th align="center" style="font-size:12px;">选择</th>
		</tr>
	</thead>
<tbody>
<form action="" method="post">
<input type="hidden" name="m" value="gongzi" />
<input type="hidden" name="c" value="jixiao" />
<input type="hidden" name="a" value="toolsrenwu" />
<input type="hidden" name="yue" value="<?php echo $_GET['yue']?>" />
<?php if(is_array($infos)){
	  foreach($infos as $info){
	?>
		<tr>
            <td align="center" ><input name="xingming" type="text" value="<?php echo $fujings[$info['userid']]?>" disabled="disabled" size="8"/></td>
            <td align="center" ><input name="bumen" type="text" value="<?php echo $bumen[$info['bmid']]?>" disabled="disabled" size="10"/></td>
            <td align="center" ><input name="gangwei" type="text" value="<?php echo $gangwei[$info['gangwei']]?>" disabled="disabled" size="10"/></td>
            <td align="center" ><input name="sgdt" type="text" value="<?php echo $info['sgdt']?>" disabled="disabled" size="10"/></td>
            <td align="center" ><input name="rwname" type="text" value="<?php echo $info['rwname']?>" disabled="disabled" size="25"/></td>
            <td align="center" ><input name="bzje[]" type="text" value="<?php echo $info['je']?>"  size="10"/>元</td>
            <td align="center" ><input name="isok1" type="text" value="<?php if($info['isok1']>0){ echo $info['isok1'];}else{ echo "未关联";} ?>" disabled="disabled" size="10"/></td>
            <td align="center" ><input type="checkbox" name="ids[]" value="<?php echo $info['id']?>" <?php if($info['isok1']>0){?> checked="checked" <?php }?> <?php if($info['isok1']>0){ echo "disabled=\"disabled\" onclick=\"alert('已关联记录不允许撤销');return false\""; }?>  /></td>
		</tr>	                                                  
  <?php }}?>   
  <input type="submit" value="确认" id="dook" name="dook" style="display:none"/>  
</form>    
</tbody>
 
</table>
</div>
</div>
<script language="javascript">
var kqflag=new Array('公休','出勤','病假','事假','年休假','婚假','丧假','产假','护理假','探亲假','工伤','二线','旷工')


function rejs(){
	//统计多项的和
	zongji=toDecimal2(parseFloat(document.getElementById("jxjj").value)-parseFloat(document.getElementById("koufa").value)+parseFloat(document.getElementById("jiaban").value)+parseFloat(document.getElementById("tsrenwu").value)+parseFloat(document.getElementById("tcgongxian").value)+parseFloat(document.getElementById("shequbz").value))
	
	document.getElementById("shifa").value=zongji;
	}
	
function ajaxkaoqin(userid,yue){
var msgstr=""	
$.get("getkaoqin.php",{'userid':userid,'yue':yue}, function(data){
  mydat=JSON.parse(data)
   if(mydat.err!='0'){
	 alert(mydat.errstr)  
	   }else{
	  if(mydat.datas[1]=='0'){
		  alert("考勤尚未结转")
		  }else{
		 // $("#chuqin").val(mydat.datas[1])
		  //转译
		  for(j=0,len=mydat.datas.length; j < len; j++) {
			  msgstr+=kqflag[j]+":"+mydat.datas[j]+"\n"
			  }	
		  alert(msgstr);	    
		}	   
	}
});	
	}	
	
/////////////////
 function toDecimal(x) { 
  var f = parseFloat(x); 
  if (isNaN(f)) { 
  return; 
  } 
  f = Math.round(x*100)/100; 
  return f; 
 } 
  
  
 //制保留2位小数，如：2，会在2后面补上00.即2.00 
 function toDecimal2(x) { 
  var f = parseFloat(x); 
  if (isNaN(f)) { 
  return false; 
  } 
  var f = Math.round(x*100)/100; 
  var s = f.toString(); 
  var rs = s.indexOf('.'); 
  if (rs < 0) { 
  rs = s.length; 
  s += '.'; 
  } 
  while (s.length <= rs + 2) { 
  s += '0'; 
  } 
  return s; 
 } 
   
 function fomatFloat(src,pos){ 
  return Math.round(src*Math.pow(10, pos))/Math.pow(10, pos); 
 } 	
</script>
</body>
</html>
