<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<?php 
ini_set('date.timezone','Asia/Shanghai');

if($_COOKIE['isadmin']!=1){
  Header("Location:error.php");
}

//#########################
$con = mysql_connect("127.0.0.1","root","2ycf4jd");
if (!$con){die("dberror");}

mysql_select_db("spjzhiban", $con); 
mysql_query("SET NAMES UTF8"); 
//#########################

if(intval(@$_GET["nian"])>0){
	$mynian=intval(@$_GET["nian"]);
	}else{
	$mynian=date("Y");	
		}
		
if(intval(@$_GET["yue"])>0){
	$myyue=intval(@$_GET["yue"]);
	}else{
	$myyue=date("n");	
		}	

//echo $mynian.'-'.$myyue;		

if(@$_GET['uid']!=""){		
$myuid=$_GET['uid'];
}else{
$myuid=0;
	}
	
if(@$_GET['uname']!=""){
	$myuname=$_GET['uname'];
	}else{
	$myuname="";	
		}	
		
////////////////////////////////////////////////
//获取班次
 	   $sql="select * from zb_banci order by px asc";
	   $rs=mysql_query($sql,$con);    
	   while($row = mysql_fetch_array($rs)){
		   $banciall[]=$row;
		     if($row['isok']==1){
		       $bancican[]=$row;
		     }
		   }
		   
//获取人员
 	   $sql="select * from zb_user order by px asc";
	   $rs=mysql_query($sql,$con);    
	   while($row = mysql_fetch_array($rs)){
		   $userall[]=$row;
		   }		   

//取出排班表
	   foreach($banciall as $cl){
		   $bccolors[$cl['id']]=$cl['color'];
		   }
		   
 	   $sql="select * from zb_table where nians='$mynian' and yues='$myyue' ";
	   $rs=mysql_query($sql,$con);  
	   //排班结果变形，方便调用	  
	   while($row = mysql_fetch_array($rs)){
		   $pbarr[$row['uid']][$row['dayss']]=$bccolors[$row['banciid']];  
		   }		
		   


		   //print_r($pbarr);					
?>
<body>
<style>
.onme tr:hover{
	cursor:pointer;
	background-color: rgba(35,198,200,0.3);
}
.tips{
	 display:none;
     width:400px;
     height:270px;
     background:transparent;
     background:rgba(200,200,200,1);
     border-radius:8px;
     position: fixed;
	 border:1px solid #000;
     margin:auto;left:0; right:0; top:0; bottom:0;
     z-index: 999; 
    }
</style>
<form action="" method="get">
<table width="1500" border="0" align="center">
  <tr>
    <td width="8%"  height="10" align="center">值班区间</td>
    <td width="17%"  align="left" style="padding-left:5px"> 
     <select name="nian" >
       <?php 
	      $nian1=2021;    
	      for($ni=0;$ni<10;$ni++){ 
	        $nian=2021+$ni;
	     ?>
         <option value="<?php echo $nian?>" <?php if($nian==$mynian){?> selected="selected"<?php }?>><?php echo $nian?></option>
       <?php }?>
     </select> -  <select name="yue" >
       <?php   
	      for($yi=1;$yi<=12;$yi++){ 
	       
	     ?>
         <option value="<?php echo $yi?>" <?php if($yi==$myyue){?> selected="selected"<?php }?> ><?php echo $yi?></option>
       <?php 
	   }?>    
     </select>
     
    </td>
    <td width="75%"  align="left"><input type="submit" name="selme" value="跳转到..." />&nbsp; *班次设置及调整实时保存，请谨慎操作</td>
    </tr>
  <tr>
    <td  height="10" align="center">值班人员</td>
    <td width="17%"  align="left" style="padding-left:5px">
    <select name="uid">
      <option value="0">全部人员</option>
      <?php foreach($userall as $uls){?>
       <option value="<?php echo $uls['uid']?>" <?php if($uls['uid']==$myuid){?>selected="selected"<?php }?>><?php echo $uls['username']?></option>
      <?php }?>
    </select>&nbsp;
    搜索 <input type="text" name="uname" value="" style="width:100px"/>
    </td>
    <td  align="left">* 不支持模糊搜索，姓名完整匹配</td>
  </tr>

  <tr>
    <td height="38" align="center">班次图例</td>
    <td colspan="2" align="center" style="padding-left:5px">
    <?php foreach($banciall as $b){?>
    <label style="float:left; width:150px; margin-left:3px; overflow:hidden;background-color:<?php echo $b['color']?>"><?php echo $b['banci']?></label>
    <?php }?>
    </td>
    </tr>

</table>
</form>
<?php
///////////////////
// 取出指定月的日期，生成表格

//计算指定月的最后一天
if($myyue==12){$tmp_yue=1;$tmp_nian=$mynian+1;}else{$tmp_yue=$myyue+1;$tmp_nian=$mynian;}
$tmp_sjc=$tmp_nian."-".$tmp_yue."-01";
$maxday=date("d",strtotime("-1 day",strtotime($tmp_sjc)));

?>
<form action="" method="get">
<table width="1500" border="0" align="center" class="onme">
  <tr>
    <td width="10%"  height="36" align="center" bgcolor="#d6d6d6">值班人员</td>
    <?php 
	for($xq=1;$xq<=$maxday;$xq++){
	//计算周末
	 $nowdays=$mynian."-".$myyue."-".$xq;
	 if(date("w",strtotime($nowdays))==6 || date("w",strtotime($nowdays))==0){
		 $bgcolor="#fc5531";
		 }else{
		 $bgcolor="#d6d6d6";	 
			 }	
	?>
    <td align="center" style="width:15px" bgcolor="<?php echo $bgcolor?>"><?php echo $xq?></td>
    <?php }?>
    </tr>

 <?php if(isset($userall)){
	 foreach($userall as $us){
		if($myuid>0){
			if($us['uid']!=$myuid){continue;}
			} 
		if($myuname!=''){
			if($us['username']!=$myuname){continue;}
			}	
	 ?>
  <tr>
    <td height="38" align="center" id="xm<?php echo $us['uid']?>"><?php echo $us['username']?></td>
    <?php 
	for($xq=1;$xq<=$maxday;$xq++){
	//计算周末
	 $nowdays=$mynian."-".$myyue."-".$xq;
	 if(date("w",strtotime($nowdays))==6 || date("w",strtotime($nowdays))==0){
		 $bgcolor="#fc5531";
		 }else{
		 $bgcolor="";	 
			 }
			 
		//检查已排班情况
		if(isset($pbarr[$us['uid']][$xq])){
			$bgcolor=$pbarr[$us['uid']][$xq];
			}	 			
	?>
    <td align="center" bgcolor="<?php echo $bgcolor?>" id="<?php echo $us['uid']."-".$xq?>" onclick="zbpor('<?php echo $us['uid']?>','<?php echo $mynian?>','<?php echo $myyue?>','<?php echo $xq?>')">&nbsp;</td>
    <?php }?>
    </tr>
<?php }}?>
</table>
</form>
<div class="tips" id="tipsme">
<table width="100%" border="0">
  <tr>
    <td height="38" align="center" valign="middle"> <span id="xingming"></span> <span id="days" ></span> 日值班安排</td>
    </tr>
  <tr>
    <td style="padding-left:10px">
    <?php foreach($bancican as $bcc){?>
     <label style="width:90%; float:left; line-height:26px"><input type="radio" id="pros" name="pros" value="<?php echo $bcc['id']?>" /><?php echo $bcc['banci']?></label>
    <?php }?>
    </td>
  </tr>
  <tr>
    <td align="center"><input type="button" name="oks" value="保存" onclick="saveit()"/> &nbsp; <input type="button" name="quxiao" value="取消" onclick="closeme()"/></td>
  </tr>
</table>

</div>

<script language="javascript">
//班次图例
var bccolorarr=[];savearr=[];
<?php foreach($banciall as $js){?>
bccolorarr[<?php echo $js['id']?>]="<?php echo $js['color']?>";
<?php }?>
function zbpor(uid,nians,yues,days){
	$("#xingming").text($("#xm"+uid).text());
	$("#days").text(nians+"-"+yues+"-"+days);
	savearr[0]=uid;savearr[1]=nians;savearr[2]=yues;savearr[3]=days;
	//已选班次赋值
	$.post("showdb.php",{uid:savearr[0],nians:savearr[1],yues:savearr[2],days:savearr[3]},function(dat){
		//alert(dat);
		var obj=JSON.parse(dat)
		//alert(obj.bcid);
		$("input[name='pros'][value="+obj.bcid+"]").attr("checked",true);
		});	
	$("#tipsme").show()
	}

function closeme(){
	$("#tipsme").hide()
	}
	
function saveit(){
	//alert($('input:radio').length);
	//AJAX写入
	banciid=$('input:radio:checked').val()
	$.post("indb.php",{uid:savearr[0],nians:savearr[1],yues:savearr[2],days:savearr[3],banci:banciid},function(dat){
		//alert(dat);
		});
	
	$("#"+savearr[0]+"-"+savearr[3]).css("background-color",bccolorarr[banciid]);
	savearr[0]=savearr[1]=savearr[2]=savearr[3]=""; //清空全局变量
	$("#tipsme").hide()
	}		
</script>
</body>
</html>