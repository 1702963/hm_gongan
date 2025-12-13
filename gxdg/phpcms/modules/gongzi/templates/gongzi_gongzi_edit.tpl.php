<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');


$kaohedj[0]="未指定等级";
$kaohedj[23]="不确定等次";
$kaohedj[2]="优秀";
$kaohedj[3]="合格";
$kaohedj[19]="基本合格";
$kaohedj[4]="不合格";
                   	
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>[<?php echo $bumen[$infos['bmid']]?>]<?php echo $infos['xingming']?>工资表明细</b></div>

<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px;width:15%">工资表项</th>
            <th align="center" style="font-size:12px;"><label><input type="checkbox" id="nous" value="1" onclick="donous(this)"/>手工编辑数值不使用公式 <font color="red">开启本功能请自行计算正确数值,系统不对数值进行关联计算</font></label> </th>
		</tr>
	</thead>
<tbody>
<form action="" method="post">
<input type="hidden" name="m" value="gongzi" />
<input type="hidden" name="c" value="gzgl" />
<input type="hidden" name="a" value="showgongziedit" />
<input type="hidden" name="id" value="<?php echo $id?>" />

	<tr>		
		<td align="center" >出勤天数</td>
        <td align="left">
           <input type="text" name="up[kaoqin]" id="kaoqin" value="<?php echo $infos['kaoqin']?>" onblur="dokaoqin(this)"/> 天 <b style="color:#FF0000" id="kaoqinmsg"></b>
        </td>      
	</tr>
	<tr>		
		<td align="center" >入职时间</td>
        <td align="left">
           <input type="text" name="up[ruzhi]" id="ruzhi" value="<?php echo date("Y-m-d",$infos['ruzhi'])?>" onblur="doruzhi(this)"/>  * 日期格式如  2000-01-01，其他格式不受支持 <b style="color:#FF0000" id="ruzhimsg"></b> 
        </td>      
	</tr>
	<tr>		
		<td align="center" >入职年限</td>
        <td align="left">
           <input type="text" name="up[nianxian]" id="nianxian" value="<?php echo $infos['nianxian']?>" /> 年
        </td>      
	</tr>
	<tr>		
		<td align="center" >基础工资</td>
        <td align="left">
           <input type="text" name="up[jiben]" id="jiben" value="<?php echo $infos['jiben']?>" onblur2="dojiben(this)" /> 元
        </td>      
	</tr>
	<tr>		
		<td align="center" >女职工卫生费</td>
        <td align="left">
           <input type="text" name="up[nvwsf]" id="nvwsf" value="<?php echo $infos['nvwsf']?>" onblur2="dowsf(this)"/> 元
        </td>      
	</tr>
	<tr>		
		<td align="center" >层级工资</td>
        <td align="left">
           <input type="text" name="up[cengjigz]" id="cengji" value="<?php echo $infos['cengjigz']?>" onblur2="docengji(this)"/> 元
        </td>      
	</tr>
	<tr>		
	  <td align="center" >考核等次</td>
	  <td align="left"> <select name="up[kaohedj]">
                          <?php foreach($kaohedj as $k=>$v){?>
                            <option value="<?php echo $k?>" <?php if($k==intval($infos['kaohedj'])){?>selected="selected"<?php }?>><?php echo $v?></option>
                          <?php }?>
                        </select>
	    </td>      
	  </tr>
	<tr>		
		<td align="center" >应发月绩效</td>
        <td align="left">
           <input type="text" name="up[yf_yjx]" id="yf_yjx" value="<?php echo $infos['yf_yjx']?>" /> 元
        </td>      
	</tr>
	<tr>		
		<td align="center" >扣除月绩效</td>
        <td align="left">
           <input type="text" name="up[kf_yjx]" id="kf_yjx" value="<?php echo intval($infos['kf_yjx'])?>" /> 元
        </td>      
	</tr>	
	<tr>		
		<td align="center" >实发月绩效</td>
        <td align="left">
           <input type="text" name="up[sf_yjx]" id="sf_yjx" value="<?php echo $infos['sf_yjx']?>" /> 元
        </td>      
	</tr>
	<tr>
	  <td align="center" >年度绩效</td>
	  <td align="left"><input type="text" name="up[ndjx]" id="ndjx" value="<?php echo $infos['ndjx']?>" />
	    元 </td>
	  </tr>
	<tr>
	  <td align="center" >职务工资</td>
	  <td align="left"><input type="text" name="up[zhiwugz]" id="zhiwugz" value="<?php echo intval($infos['zhiwugz'])?>" />
	    元 </td>
	  </tr>
	<tr>
	  <td align="center" >特殊岗位工资</td>
	  <td align="left"><input type="text" name="up[tsgwgz]" id="tsgwgz" value="<?php echo intval($infos['tsgwgz'])?>" />
	    元 </td>
	  </tr>
	<tr>
	  <td align="center" >突出贡献</td>
	  <td align="left"><input type="text" name="up[tcgx]" id="tcgx" value="<?php echo intval($infos['tcgx'])?>" />
	    元 </td>
	  </tr>
	<tr>
	  <td align="center" >应发工资</td>
	  <td align="left"><input type="text" name="up[yingfa]" id="yingfa" value="<?php echo $infos['yingfa']?>" />
	    元 </td>
	  </tr>
	<tr>		
		<td align="center" >实发工资</td>
        <td align="left">
           <input type="text" name="up[shifa]" id="shifa" value="<?php echo $infos['shifa']?>" /> 元
        </td>      
	</tr>
	<tr>		
		<td align="center" >备注</td>
        <td align="left">
           <textarea name="up[beizhu]" style="width:70%" rows="2"><?php echo $infos['beizhu']?></textarea> <b style="color:#FF0000" id="ruzhimsg"><?php echo $upmsg?></b>
        </td>      
	</tr>										
		

  <input type="submit" value="确认" id="dook" name="dook" style="display:none"/>  
</form>    
</tbody>
 
</table>

<script language="javascript">
function donous(obj){

 if(obj.checked){
  document.getElementById("yingfa").readOnly=false
  document.getElementById("yanglao").readOnly=false
  document.getElementById("shiye").readOnly=false
  document.getElementById("yiliao").readOnly=false
  document.getElementById("shifa").readOnly=false
 }else{
  document.getElementById("yingfa").readOnly=true
  document.getElementById("yanglao").readOnly=true
  document.getElementById("shiye").readOnly=true
  document.getElementById("yiliao").readOnly=true
  document.getElementById("shifa").readOnly=true 
 }
}

function dokaoqin(obj){
  if(parseInt(obj.value)>31 || parseInt(obj.value)<1){
   document.getElementById(obj.id+"msg").innerText="出勤天数不合法"
  }else{
   document.getElementById(obj.id+"msg").innerText="";
  }
}

function doruzhi(obj){
 if(IsDate(obj.value)){
  document.getElementById(obj.id+"msg").innerText=""
   var date = new Date; 
   var year = parseInt(date.getFullYear()); 
   ryear=parseInt(obj.value.split("-")[0])
   document.getElementById("nianxian").value=year-ryear;
 }else{
  document.getElementById(obj.id+"msg").innerText="日期格式错误";
 } 
}

function dojiben(obj){
document.getElementById("yingfa").value=toDecimal2(parseFloat(obj.value)+parseFloat(document.getElementById("cengji").value)+parseFloat(document.getElementById("zhiji").value)+parseFloat(document.getElementById("nvwsf").value))
  if(parseFloat(document.getElementById("yingfa").value)>parseFloat(<?php echo $sets['ylbxjs']?>)){
   document.getElementById("yanglao").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)*parseFloat(<?php echo $sets['ylbxbl']?>))
  }else{
   document.getElementById("yanglao").value=toDecimal2(parseFloat(<?php echo $sets['ylbxjs']?>)*parseFloat(<?php echo $sets['ylbxbl']?>))
  }
  if(parseFloat(document.getElementById("yingfa").value)>parseFloat(<?php echo $sets['sybxjs']?>)){
   document.getElementById("shiye").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)*parseFloat(<?php echo $sets['sybxbl']?>))
  }else{
   document.getElementById("shiye").value=toDecimal2(parseFloat(<?php echo $sets['sybxjs']?>)*parseFloat(<?php echo $sets['sybxbl']?>))
  }  
  if(parseFloat(document.getElementById("yingfa").value)>parseFloat(<?php echo $sets['yiliaojs']?>)){
   document.getElementById("yiliao").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)*parseFloat(<?php echo $sets['yiliaobl']?>))
  }else{
   document.getElementById("yiliao").value=toDecimal2(parseFloat(<?php echo $sets['yiliaojs']?>)*parseFloat(<?php echo $sets['yiliaobl']?>))
  } 
document.getElementById("shifa").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)-parseFloat(document.getElementById("yanglao").value)-parseFloat(document.getElementById("shiye").value)-parseFloat(document.getElementById("yiliao").value))    
}

function dowsf(obj){
document.getElementById("yingfa").value=toDecimal2(parseFloat(obj.value)+parseFloat(document.getElementById("cengji").value)+parseFloat(document.getElementById("zhiji").value)+parseFloat(document.getElementById("jiben").value))
  if(parseFloat(document.getElementById("yingfa").value)>parseFloat(<?php echo $sets['ylbxjs']?>)){
   document.getElementById("yanglao").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)*parseFloat(<?php echo $sets['ylbxbl']?>))
  }else{
   document.getElementById("yanglao").value=toDecimal2(parseFloat(<?php echo $sets['ylbxjs']?>)*parseFloat(<?php echo $sets['ylbxbl']?>))
  }
  if(parseFloat(document.getElementById("yingfa").value)>parseFloat(<?php echo $sets['sybxjs']?>)){
   document.getElementById("shiye").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)*parseFloat(<?php echo $sets['sybxbl']?>))
  }else{
   document.getElementById("shiye").value=toDecimal2(parseFloat(<?php echo $sets['sybxjs']?>)*parseFloat(<?php echo $sets['sybxbl']?>))
  }  
  if(parseFloat(document.getElementById("yingfa").value)>parseFloat(<?php echo $sets['yiliaojs']?>)){
   document.getElementById("yiliao").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)*parseFloat(<?php echo $sets['yiliaobl']?>))
  }else{
   document.getElementById("yiliao").value=toDecimal2(parseFloat(<?php echo $sets['yiliaojs']?>)*parseFloat(<?php echo $sets['yiliaobl']?>))
  } 
document.getElementById("shifa").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)-parseFloat(document.getElementById("yanglao").value)-parseFloat(document.getElementById("shiye").value)-parseFloat(document.getElementById("yiliao").value))    
}

function docengji(obj){
document.getElementById("yingfa").value=toDecimal2(parseFloat(obj.value)+parseFloat(document.getElementById("jiben").value)+parseFloat(document.getElementById("zhiji").value)+parseFloat(document.getElementById("nvwsf").value))
  if(parseFloat(document.getElementById("yingfa").value)>parseFloat(<?php echo $sets['ylbxjs']?>)){
   document.getElementById("yanglao").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)*parseFloat(<?php echo $sets['ylbxbl']?>))
  }else{
   document.getElementById("yanglao").value=toDecimal2(parseFloat(<?php echo $sets['ylbxjs']?>)*parseFloat(<?php echo $sets['ylbxbl']?>))
  }
  if(parseFloat(document.getElementById("yingfa").value)>parseFloat(<?php echo $sets['sybxjs']?>)){
   document.getElementById("shiye").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)*parseFloat(<?php echo $sets['sybxbl']?>))
  }else{
   document.getElementById("shiye").value=toDecimal2(parseFloat(<?php echo $sets['sybxjs']?>)*parseFloat(<?php echo $sets['sybxbl']?>))
  }  
  if(parseFloat(document.getElementById("yingfa").value)>parseFloat(<?php echo $sets['yiliaojs']?>)){
   document.getElementById("yiliao").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)*parseFloat(<?php echo $sets['yiliaobl']?>))
  }else{
   document.getElementById("yiliao").value=toDecimal2(parseFloat(<?php echo $sets['yiliaojs']?>)*parseFloat(<?php echo $sets['yiliaobl']?>))
  } 
document.getElementById("shifa").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)-parseFloat(document.getElementById("yanglao").value)-parseFloat(document.getElementById("shiye").value)-parseFloat(document.getElementById("yiliao").value))    
}

function dozhiji(obj){
document.getElementById("yingfa").value=toDecimal2(parseFloat(obj.value)+parseFloat(document.getElementById("cengji").value)+parseFloat(document.getElementById("jiben").value)+parseFloat(document.getElementById("nvwsf").value))
  if(parseFloat(document.getElementById("yingfa").value)>parseFloat(<?php echo $sets['ylbxjs']?>)){
   document.getElementById("yanglao").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)*parseFloat(<?php echo $sets['ylbxbl']?>))
  }else{
   document.getElementById("yanglao").value=toDecimal2(parseFloat(<?php echo $sets['ylbxjs']?>)*parseFloat(<?php echo $sets['ylbxbl']?>))
  }
  if(parseFloat(document.getElementById("yingfa").value)>parseFloat(<?php echo $sets['sybxjs']?>)){
   document.getElementById("shiye").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)*parseFloat(<?php echo $sets['sybxbl']?>))
  }else{
   document.getElementById("shiye").value=toDecimal2(parseFloat(<?php echo $sets['sybxjs']?>)*parseFloat(<?php echo $sets['sybxbl']?>))
  }  
  if(parseFloat(document.getElementById("yingfa").value)>parseFloat(<?php echo $sets['yiliaojs']?>)){
   document.getElementById("yiliao").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)*parseFloat(<?php echo $sets['yiliaobl']?>))
  }else{
   document.getElementById("yiliao").value=toDecimal2(parseFloat(<?php echo $sets['yiliaojs']?>)*parseFloat(<?php echo $sets['yiliaobl']?>))
  } 
document.getElementById("shifa").value=toDecimal2(parseFloat(document.getElementById("yingfa").value)-parseFloat(document.getElementById("yanglao").value)-parseFloat(document.getElementById("shiye").value)-parseFloat(document.getElementById("yiliao").value))    
}

////////////////////////////////////////////////////////////////////////////////////
function IsDate(str) {
            arr = str.split("-");
            if (arr.length == 3) {
                intYear = parseInt(arr[0], 10);
                intMonth = parseInt(arr[1], 10);
                intDay = parseInt(arr[2], 10);
                if (isNaN(intYear) || isNaN(intMonth) || isNaN(intDay)) {
                    return false;
                }
                if (intYear > 2100 || intYear < 1900 || intMonth > 12 || intMonth < 0 || intDay > 31 || intDay < 0) {
                    return false;
                }
                if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) && intDay > 30) {
                    return false;
                }
                if (intYear % 100 == 0 && intYear % 400 || intYear % 100 && intYear % 4 == 0) {
                    if (intDay >
                        29) return false;
                } else {
                    if (intDay > 28) return false;
                }
                return true;
            }
            return false;
        }

 //保留两位小数 
 //功能：将浮点数四舍五入，取小数点后2位 
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
</div>
</div>
</body>
</html>
