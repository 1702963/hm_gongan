<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <form action="" method="POST" onsubmit="return chkok()">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="jixiao"/>
    <input type="hidden" name="a" value="tcgongxianshenhe"/>
    <input type="hidden" name="ty" value="<?php echo $_GET['ty']?>"/> 
    <input type="hidden" id="ids" name="id" value="<?php echo $_GET['id']?>"/>
    <input type="hidden" name="bmid" value="<?php echo $infos['bmid']?>"/>
<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
		<tr>
            <td width="20%" align="center" style="font-size:12px">选择上报对象</td>
            <td width="39%" align="left" style="font-size:12px">
			 <select name="sq[<?php echo $rowsname?>]">
              <?php if(!is_array($shenpis)){?> 
              <option value="0">未匹配到上报对象</option>
              <?php }else{?>             
              <?php foreach($shenpis as $k=>$v){?>
              <option value="<?php echo $k?>"><?php echo $v?></option>
              <?php }}?>
             </select>
            </td>
		</tr>
	<tr>		
</table>
<?php if($_GET['ty']=="zzc000"){?>
<table width="100%" cellspacing="0" border="1" style="margin-right:10px; margin-top:5px" id="zzclist">
		<tr>
            <td width="6%" align="center" bgcolor="#d6d6d6" style="font-size:12px">选择</td>
            <td width="10%" align="center" bgcolor="#d6d6d6" style="font-size:12px">姓名</td>
            <td width="14%" align="center" bgcolor="#d6d6d6" style="font-size:12px">辅助岗位</td>
            <td width="10%" align="center" bgcolor="#d6d6d6" style="font-size:12px">发放月份</td>
            <td width="10%" align="center" bgcolor="#d6d6d6" style="font-size:12px">奖励金额</td>
            <td width="33%" align="center" bgcolor="#d6d6d6" style="font-size:12px">奖励事迹</td>
            <td width="17%" align="center" bgcolor="#d6d6d6" style="font-size:12px">备注</td>
		</tr>       
	<tr>		
</table>
<script language="javascript">
<?php 
		  $this->db->table_name = 'mj_gongzi_tables';
		  $rowss = $this->db->select("","yue","","id desc");
          $gzyue=$rowss[0]['yue'];
?>

if(window.parent.tcgongxian.length>0){
	$("#ids").val(window.parent.tcgongxian.toString())
	}

//////写回列表
$.get("gettcgongxian.php",{'userid':$("#ids").val()}, function(data){
 // alert(data)
  mydat=JSON.parse(data)
   if(mydat.err!='0'){
	 alert(mydat.errstr)  
	   }else{
		  for(j=0,len=mydat.datas.length; j < len; j++) {
			addtables="<tr>"+
            "<td width=\"6%\" align=\"center\"  style=\"font-size:12px\"><input type=\"checkbox\" id=\"tcid"+mydat.datas[j]['id']+"\" name=\"tcid[]\" checked=\"checked\" value=\"\"/></td>"+
            "<td width=\"10%\" align=\"center\"  style=\"font-size:12px\">"+mydat.datas[j]['xingming']+"</td>"+
            "<td width=\"14%\" align=\"center\"  style=\"font-size:12px\">"+mydat.datas[j]['bumen']+"</td>"+
            "<td width=\"10%\" align=\"center\"  style=\"font-size:12px\"><input type=\"text\" id=\"yue"+mydat.datas[j]['id']+"\" name=\"yue["+mydat.datas[j]['id']+"]\" value=\"<?php echo $gzyue?>\" style=\"width:70px\"/></td>"+
            "<td width=\"10%\" align=\"center\"  style=\"font-size:12px\"><input type=\"text\" id=\"je"+mydat.datas[j]['id']+"\" name=\"je["+mydat.datas[j]['id']+"]\" value=\""+mydat.datas[j]['je']+"\" style=\"width:70px\" onkeypress=\"return checkNumber(event);\" onblur=\"return chongji(this.id)\"/></td>"+
            "<td width=\"33%\" align=\"left\"  style=\"font-size:12px\"><textarea name=\"bz["+mydat.datas[j]['id']+"]\" style=\"width:80%; height:100px\">"+mydat.datas[j]['shiji']+"</textarea></td>"+
            "<td width=\"17%\" align=\"center\"  style=\"font-size:12px\"><textarea name=\"bz["+mydat.datas[j]['id']+"]\" style=\"width:80%; height:28px\">"+mydat.datas[j]['beizhu']+"</textarea></td>"+
		    "</tr>"   
            $("#zzclist").append(addtables)
		  }		   
	}
});	

function chongji(objid){
	//alert(parseInt($("#jjzs").val()))	
	if(isNaN($("#jjzs").val())){
	   alert("奖金发放总额格式错误")	
       $("#"+objid).val("0.00")
		}else{
		if(parseInt($("#"+objid).val())>parseInt($("#jjzs").val())-parseInt($("#yfp").val())){
		alert("可发放奖金额度不足")
		return false	
		}else{
		 bls=$("#ids").val().split(',')
		 yf=0
		 for(i=0;i<bls.length;i++){//成员数巨大的时候应先通过把数组长度赋值给中间量以后再循环
		   yf+=parseInt($("#je"+bls[i]).val()) 
		  }	
		  $("#yfp").val(yf)
		}
		}
	}

function checkNumber(e)
{
    var keynum = window.event ? e.keyCode : e.which;
    //alert(keynum);
    var tip = document.getElementById("tip");
    if( (48<=keynum && keynum<=57) || keynum == 8 ){
        return true;
    }else {
        return false;
    }
} 
	
function chkok(){
		 bls=$("#ids").val().split(',')
		 yf=0
		 for(i=0;i<bls.length;i++){//成员数巨大的时候应先通过把数组长度赋值给中间量以后再循环
		   if(parseInt($("#je"+bls[i]).val())<1){
		     alert("有尚未分配奖金的人员")
			 return false
		   }
		   yf+=parseInt($("#je"+bls[i]).val()) 
		  }	 
		if(parseInt(yf)>parseInt($("#jjzs").val())) {
		 return false		
		}	
	}	
</script>
<?php }?>
<input type="submit" value="确认" id="dook" name="dook" style="display:none" /> 
</form>
</div>
</div>
</body>

</html>
