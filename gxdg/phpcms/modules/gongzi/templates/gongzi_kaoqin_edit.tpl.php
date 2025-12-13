<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"><b>[<?php echo $bumen[$infos['bmid']]?>]<?php echo $infos['xingming']?>考勤表</b>
    <?php if($tables['isfinish']==1){?>&nbsp;<b style="color:#F00">当前已转结！调整考勤后需要重新转结才能生效</b><?php }?>
    </div>

<table width="100%" cellspacing="0" class="kotable">
	<thead>
		<tr>
            <th align="center" style="font-size:12px;width:15%">考勤日期</th>
            <th align="center" style="font-size:12px;">考勤</th>  
		</tr>
	</thead>
<tbody>
<form action="" method="post" id="kaoqinform">
<input type="hidden" name="m" value="gongzi" />
<input type="hidden" name="c" value="gzgl" />
<input type="hidden" name="a" value="showkaoqinedit" />
<input type="hidden" name="id" value="<?php echo $id?>" />
<?php
$i=0;
foreach($rowname as $rv){
			  if(date("w",strtotime($rv))==0 || date("w",strtotime($rv))==6){
				  $bcolor="#32336c";
				  }else{
				  $bcolor=""; 	  
					  } 	
	?>
	<tr>		
		<td align="center" style="background-color:<?php echo $bcolor?>"><?php echo date("Y-m-d",strtotime($rv))?></td>
        <td align="center" style="background-color:<?php echo $bcolor?>">
         <?php foreach($kqflag as $k=>$v){
		   
		   $ischecked="";	 
           if($infos['islock']==1){
			   if($infos[$rv]==$k){
				  $ischecked="checked='checked'";
				   }}else{
					   if($bcolor!=""){if($k==0){
						   $ischecked= "checked='checked' ";
						}}else{if($k==1){
							$ischecked= "checked='checked' ";
							}}}
		
			 
			 ?>
          <label id="<?php echo $i."-".$k ?>"<?php if($ischecked!=""){?>style="padding-bottom:5px;background-color:#06c"<?php }?> onclick="chengbc(this.id)"><input type="radio" id="r<?php echo $i."-".$k ?>" name="<?php echo $rv?>" value="<?php echo $k?>"  <?php echo $ischecked?>/><?php echo $v[1]?></label>&nbsp;
         <?php }?>
        </td>      
	</tr>
	<?php
	$i++;
	}	
?>
	<tr>		
		<td align="center" >备注</td>
        <td align="center" ><textarea id="beizhu" name="beizhu" style="width:98%" rows="2"><?php echo $infos['beizhu']?></textarea></td>      
	</tr>
  <input type="submit" value="确认" id="dook" name="dook" style="display:none"/>  
</form>    
</tbody>
 
</table>




</div>
</div>
<script type="text/javascript" >  
  $(document).ready(function() {  
    $(".kotable tbody tr:odd").addClass("odd");//even 奇数行 gt(0)排除第一个
	$(".kotable tbody tr:even").addClass("even");//even 奇数行 gt(0)排除第一个
    $(".kotable tbody tr").mouseover(function() {  
      $(this).addClass("iover");  
    }).mouseout(function() {  
      $(this).removeClass("iover");  
    });  
  }  
)  
</script> 
<script language="javascript">
function chengbc(objid){
	tmpqz=objid.split("-")
	for(i=0;i<=13;i++){
		document.getElementById(tmpqz[0]+"-"+i).style.backgroundColor="";
		}
	document.getElementById(objid).style.backgroundColor="#06c"	;
	
	//从这继续
	zj=<?php echo $i?>;
	if(parseInt(tmpqz[1])>12){

	  if(parseInt(tmpqz[0])<=zj){
		  for(y= parseInt(tmpqz[0]);y<parseInt(zj);y++){
	        for(i=0;i<=13;i++){
		     document.getElementById(y+"-"+i).style.backgroundColor="";
			 document.getElementById(y+"-"+i).setAttribute("checked","")
		    }			  
			 //document.getElementById(y+'-13').click() ;
			 $("#r"+y+"-13").prop("checked",true)
			 document.getElementById(y+'-13').style.backgroundColor="#c00";

			  }
	  }	
	}
	
	//更新备注
	kqarr=new Array()
	<?php foreach($kqflag as $k=>$v){?>
	 kqarr[<?php echo $k?>]=["<?php $outs=explode(":",$v[1]); echo $outs[0];?>",0]
	<?php }?>
	// radio不能通过 ByName 取值，需要遍历
	radios=document.getElementsByTagName("input")
	for(i=0;i<radios.length;i++){
		if(radios[i].type==="radio"){
			if(radios[i].checked){
			kqarr[parseInt(radios[i].value)][1]++
				}
			}
		}
	var outstr="";
	for(i=2;i<kqarr.length;i++){
		if(kqarr[i][1]!=0){
			outstr+=kqarr[i][0]+":"+kqarr[i][1]+";"
			}
		}
    document.getElementById("beizhu").value=outstr
}

function open_win(urls)
{
window.open(urls,"_blank","channelmode=yes,fullscreen=yes,toolbar=no, location=no, directories=yes, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=yes")
}
</script>
</body>
</html>
