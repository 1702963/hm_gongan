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
		<td align="center" style="background-color:<?php echo $bcolor?>">政治素质</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[de_zhengzhi]" id="de_zhengzhi" onchange="rejs()">
                                                                        <?php for($i=0;$i<=5;$i++){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['de_zhengzhi']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>        
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">职业道德</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[de_zhiye]" id="de_zhiye" onchange="rejs()">
                                                                        <?php for($i=0;$i<=5;$i++){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['de_zhiye']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">社会公德</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[de_shehui]" id="de_shehui" onchange="rejs()">
                                                                        <?php for($i=0;$i<=5;$i++){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['de_shehui']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">个人品德</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[de_geren]" id="de_geren" onchange="rejs()">
                                                                        <?php for($i=0;$i<=5;$i++){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['de_geren']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>        
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">业务水平</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[neng_yewu]" id="neng_yewu" onchange="rejs()">
                                                                        <?php for($i=0;$i<=5;$i++){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['neng_yewu']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>        
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">工作能力</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[neng_gongzuo]" id="neng_gongzuo" onchange="rejs()">
                                                                        <?php for($i=0;$i<=5;$i++){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['neng_gongzuo']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>        
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">出勤情况</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[qin_chuqin]" id="qin_chuqin" onchange="rejs()">
                                                                        <?php for($i=0;$i<=10;$i++){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['qin_chuqin']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>        
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">工作表现</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[qin_biaoxian]" id="qin_biaoxian" onchange="rejs()">
                                                                        <?php for($i=0;$i<=5;$i++){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['qin_biaoxian']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>        
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">目标任务</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[ji_mubiao]" id="ji_mubiao" onchange="rejs()">
                                                                        <?php for($i=0;$i<=25;$i++){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['ji_mubiao']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>        
        </td>      
	</tr>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>">本职工作</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[ji_benzhi]" id="ji_benzhi" onchange="rejs()">
                                                                        <?php for($i=0;$i<=20;$i++){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['ji_benzhi']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>        
        </td>      
	</tr>
		<td align="center" style="background-color:<?php echo $bcolor?>">廉洁守纪</td>
        <td align="left" style="background-color:<?php echo $bcolor?>">
                                                                       <select name="jx[lian_lianjie]" id="lian_lianjie" onchange="rejs()">
                                                                        <?php for($i=0;$i<=10;$i++){?>
                                                                        <option value="<?php echo $i?>" <?php if($i==$infos['lian_lianjie']){?>selected="selected"<?php }?>><?php echo $i?></option>
                                                                        <?php }?>
                                                                       </select>        
        </td>      
	</tr>                                                     

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
	zongji=parseInt(document.getElementById("de_zhengzhi").value)+parseInt(document.getElementById("de_zhiye").value)+parseInt(document.getElementById("de_shehui").value)+	parseInt(document.getElementById("de_geren").value)+parseInt(document.getElementById("neng_yewu").value)+parseInt(document.getElementById("neng_gongzuo").value)+	parseInt(document.getElementById("qin_chuqin").value)+parseInt(document.getElementById("qin_biaoxian").value)+parseInt(document.getElementById("ji_mubiao").value)+	parseInt(document.getElementById("ji_benzhi").value)+parseInt(document.getElementById("lian_lianjie").value)
	
	document.getElementById("chengji").value=zongji;
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
