<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>[<?php echo $bumen[$infos['bmid']]?>]<?php echo $fujings[$infos['userid']]?>绩效工资表详情</b></div>

<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px;width:15%">绩效工资项目</th>
            <th align="center" style="font-size:12px;">项目内容</th>
		</tr>
	</thead>
<tbody>
<form action="" method="post">
<input type="hidden" name="m" value="gongzi" />
<input type="hidden" name="c" value="jixiao" />
<input type="hidden" name="a" value="jxgzbedit" />
<input type="hidden" name="id" value="<?php echo $id?>" />
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">考核结果</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><select name="jx[khjieguo]">
                                                                          <option value="0">未指定等级</option>
                                                                         <?php foreach($dengji as $k=>$j){?>
                                                                           <option value="<?php echo $k?>" <?php if($k==$infos['khjieguo']){?>selected="selected"<?php }?>><?php echo $j?></option>
                                                                         <?php }?>
                                                                       </select> *手工修改考核等级请自行计算并修改绩效奖金 </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">绩效奖金</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><input type="text" id="jxjj" name="jx[jxjj]" value="<?php echo $infos['jxjj']?>" size="10" onblur="rejs()"/> 元 </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">扣除金额</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><input type="text" id="koufa" name="jx[koufa]" value="<?php echo $infos['koufa']?>" size="10" onblur="rejs()"/> 元 <a href="javascript:;" onclick="ajaxkaoqin('<?php echo $infos['userid']?>','<?php echo $infos['yue']?>')" style="display:none">点击查看出勤情况</a></td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">扣除原因</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><textarea name="jx[koufayy]" id="koufayy" rows="2" style="width:80%"><?php echo $infos['koufayy']?></textarea>
                                                                              
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">加班费</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><input type="text" id="jiaban" name="jx[jiaban]" value="<?php echo $infos['jiaban']?>" size="10" onblur="rejs()"/> 元 &nbsp; * 辅警无此项，临辅人员加班费不允许编辑
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">特殊岗位工资</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><input type="text" id="tsrenwu" name="jx[tsrenwu]" value="<?php echo $infos['tsrenwu']?>" size="10" onblur="rejs()"/> 元  
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">突出贡献奖</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><input type="text" id="tcgongxian" name="jx[tcgongxian]" value="<?php echo $infos['tcgongxian']?>" size="10" onblur="rejs()"/> 元       
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">社区补助</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><input type="text" id="shequbz" name="jx[shequbz]" value="<?php echo $infos['shequbz']?>" size="10" onblur="rejs()"/> 元 &nbsp; * 本项不参与工资表核算       
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">实发金额</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><input type="text" id="shifa" name="jx[shifa]" value="<?php echo $infos['shifa']?>" size="10" onblur="rejs()"/> 元        
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">备注</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><textarea name="jx[beizhu]" id="beizhu" rows="2" style="width:80%"><?php echo $infos['beizhu']?></textarea>       
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">操作日志</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
		<?php if($infos['dolog']!=""){
			$logarr=json_decode($infos['dolog'],true);
			foreach($logarr as $lg){
				echo "<li>".urldecode($lg[0])."于".$lg[1]."操作[".urldecode($lg[2])."]</li>";
				}
			}?>   
        </td>      
	</tr>	                                                  

  <input type="submit" value="确认" id="dook" name="dook" style="display:none"/>  
</form>    
</tbody>
 
</table>
<div style="margin:9px auto; color:#F00">* 社区补助等现行工资表内没有的工资项目不参与工资合计，</div>
</div>
</div>
<script language="javascript">
var kqflag=new Array('公休','出勤','病假','事假','年休假','婚假','丧假','产假','护理假','探亲假','工伤','二线','旷工','辞职')


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
