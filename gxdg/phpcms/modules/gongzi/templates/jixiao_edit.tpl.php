<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>[<?php echo $bumen[$infos['bmid']]?>]<?php echo $fujings[$infos['userid']]?>绩效考核</b></div>

<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px;width:15%">考核项目</th>
            <th align="center" style="font-size:12px;">考核内容</th>
		</tr>
	</thead>
<tbody>
<form action="" method="post">
<input type="hidden" name="m" value="gongzi" />
<input type="hidden" name="c" value="jixiao" />
<input type="hidden" name="a" value="jixiaoedits" />
<input type="hidden" name="id" value="<?php echo $id?>" />
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">考核结果</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><select name="jx[kh_dj]">
                                                                          <option value="0">未指定等级</option>
                                                                         <?php foreach($dengji as $k=>$j){?>
                                                                           <option value="<?php echo $k?>" <?php if($k==$infos['kh_dj']){?>selected="selected"<?php }?>><?php echo $j?></option>
                                                                         <?php }?>
                                                                       </select> *考核等级不做程序判断，请手工指定 </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">考核成绩</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><input type="text" id="chengji" name="jx[chengji]" value="<?php echo $infos['chengji']?>" size="10" readonly="readonly"/> *自动统计</td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">出勤</td>
        <td align="left" style="background-color:<?php echo $bcolor?>"><input type="text" id="chuqin" name="jx[chuqin]" value="<?php if($infos['chuqin']==0){echo $my_chuqin;}else{ echo $infos['chuqin'];}?>" size="10"/> <a href="javascript:;" onclick="ajaxkaoqin('<?php echo $infos['userid']?>','<?php echo $infos['yue']?>')">点击同步出勤数据</a></td>      
	</tr>
	<tr>		
	  <td align="center" style="background-color:<?php echo $bcolor?>">出勤情况</td>
	  <td align="left" style="background-color:<?php echo $bcolor?>">
	    <select name="jx[qin_chuqin]" id="qin_chuqin" onchange="rejs()">
	      <?php for($i=20;$i>=0;$i--){?>
	      <option value="<?php echo $i?>" <?php if($i==$infos['qin_chuqin']){?>selected="selected"<?php }?>><?php echo $i?></option>
	      <?php }?>
	      </select>
          <?php for($ns=20;$ns>=10;$ns--){?>
          <label onmousemove="mouon(this)" onmouseleave="mouout(this)" ><input type="radio" name="chuqin_k" id="chuqin_k" value="<?php echo $ns?>" onclick="kuairu('qin_chuqin',this.value)"/><?php echo $ns?></label>&nbsp;
          <?php }?> 
          <label><input type="radio" name="chuqin_k" id="chuqin_k" value=""  disabled="disabled"/>其他分值请在下拉框中选择</label>      
	    </td>      
	  </tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">纪律作风</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[qin_biaoxian]" id="qin_biaoxian" onchange="rejs()">
                                                                        <?php for($i=35;$i>=0;$i--){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['qin_biaoxian']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>  
                                                                       
          <?php for($ns=35;$ns>=20;$ns--){?>
          <label onmousemove="mouon(this)" onmouseleave="mouout(this)"><input type="radio" name="chuqin_j" id="chuqin_j" value="<?php echo $ns?>" onclick="kuairu('qin_biaoxian',this.value)"/><?php echo $ns?></label>&nbsp;
          <?php }?>                                                                              
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">工作实绩</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[ji_mubiao]" id="ji_mubiao" onchange="rejs()">
                                                                        <?php for($i=45;$i>=0;$i--){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['ji_mubiao']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>   
          <?php for($ns=45;$ns>=30;$ns--){?>
          <label onmousemove="mouon(this)" onmouseleave="mouout(this)"><input type="radio" name="chuqin_g" id="chuqin_g" value="<?php echo $ns?>" onclick="kuairu('ji_mubiao',this.value)"/><?php echo $ns?></label>&nbsp;
          <?php }?>                                                                        
                                                                            
        </td>                                                          

  <input type="submit" value="确认" id="dook" name="dook" style="display:none"/>  
</form>    
</tbody>
 
</table>
</div>
</div>
<script language="javascript">
var kqflag=new Array('公休','出勤','病假','事假','年休假','婚假','丧假','产假','护理假','探亲假','工伤','二线','旷工','辞职')


function rejs(){
	//统计多项的和
	zongji=parseInt(document.getElementById("qin_chuqin").value)+parseInt(document.getElementById("qin_biaoxian").value)+parseInt(document.getElementById("ji_mubiao").value)
	
	document.getElementById("chengji").value=zongji;
	}
	
function kuairu(sobj,kr){
	//统计多项的和
	$("#"+sobj).val(kr)
	zongji=parseInt(document.getElementById("qin_chuqin").value)+parseInt(document.getElementById("qin_biaoxian").value)+parseInt(document.getElementById("ji_mubiao").value)
	
	document.getElementById("chengji").value=zongji;
	}	
	
function mouon(obj){
	$(obj).css("border","1px solid red")
	}

function mouout(obj){
	$(obj).css("border","")
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
		  $("#chuqin").val(mydat.datas[1])
		  //转译
		  for(j=0,len=mydat.datas.length; j < len; j++) {
			  msgstr+=kqflag[j]+":"+mydat.datas[j]+"\n"
			  }	
		  alert(msgstr);	    
		}	   
	}
});	
	}	
</script>
</body>
</html>
