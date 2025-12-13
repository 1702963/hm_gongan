<?php
ini_set("display_errors","On");

if(!isset($_COOKIE['loginid'])){
echo json_encode(array("error"=>"权限不足"),true);	
exit;
}
//  list
require '../ini/baseconfig.php';
$con = mysql_connect($db_add,$db_user,$db_pass);
if ($con){ 
mysql_select_db($db_name, $con); 
mysql_query("SET NAMES UTF8"); 

//拉出数据
if(@$_POST['page']==""){$_POST['page']=1;}
if(@$_POST['offz']==""){$_POST['offz']="0";}

//搜索条件
$selstr="";

	if(@$_POST['title']!=""){$selstr.=" and htname like '%".$_POST['title']."%' ";}
    if(@$_POST['jf']!=""){$selstr.=" and htjfname like '%".$_POST['jf']."%' ";}
    if(@$_POST['yf']!=""){$selstr.=" and htyfname like '%".$_POST['yf']."%' ";}
	if(@$_POST['leixing']!="0" && @$_POST['leixing']!=""){$selstr.=" and httype=".intval($_POST['leixing']); }
	if(@$_POST['bianh']!=""){$selstr.=" and htnumber like '%".$_POST['bianh']."' "; }
	
//echo json_encode(array(print_r($_POST,1)),true);	
//exit;

//计算分页
	   $sql="select count(id) from ".$db_tablepre."htgl where according=15 ".$selstr;
	   $rs=mysql_query($sql,$con);
       $row = mysql_fetch_array($rs);
	   if($row[0]>0){	
	    $num=$row[0];  
	    if($row[0]%$listnum>0){
			$fenye=intval($row[0]/$listnum)+1;
			}else{
			$fenye=intval($row[0]/$listnum);	
				} 
 	    
         if(intval($_POST['page'])<1){$nowpage=1;}else{$nowpage=intval($_POST['page']);} 		
		 if(intval($_POST['page'])>$fenye){
			 $nowpage=$fenye;
			 }
		 if($_POST['offz']=="-1"){
			 if($_POST['page']==1){
				 $nowpage=1;
				 }else{
				 $nowpage=intval($_POST['page'])-1;	 
					 }
			 }	
		 if($_POST['offz']=="1"){
			 if(intval($_POST['page'])==$fenye){
				 $nowpage=$fenye;
				 }else{
				 $nowpage=intval($_POST['page'])+1;	 
					 }
			 }				  
	    
		$limits=($nowpage-1)*$listnum;
		
		$htlx[11]="普通合同";
		$htlx[12]="技术合同";
		$htlx[13]="采购合同";
		
	   $sql="select * from ".$db_tablepre."htgl where according=15 ".$selstr." order by htmaintenancedate asc limit $limits,$listnum ";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		  if($row['htenddate']<time()){
			  $zt="已结束"; 
			  }else{
			  $zt="未结束";	  
				  }
				  
			  $htsigningdate=date('Y-m-d',$row['htsigningdate']);	
			  $htmaintenancedate=date('Y-m-d',$row['htmaintenancedate']);  
			  
			  //获取附件
			  $addimg="";
			  if($row['catpics']!=''){
			   $pics=json_decode($row['catpics'],true);
               foreach($pics as $parr){
				   $addimg.="<img src=\"".$parr['url']."\" width=150 style=\"margin-right:5px\" border=\"0\" class=\"".$row['id']."\">";
				   }
			  }
			  if($addimg!=""){
				  $addimg="<p onclick=\"showpics(".$row['id'].")\" id=\"pics".$row['id']."\">".$addimg."</p>";
				  }
			//  当维护费为0时，列表不会显示维护费和收维护费时间
		      if($row['htmaintenance']==0){
		  	     $none="display:none";
		      }else{
		      	 $none="display:inline";
		      }
		     
		  @$outarr.="<div class=\"htlist\"><p>合同名称：<span>".$row['htname']."</span></p><p>合同类型：<span>".$htlx[$row['httype']]."</span></p><p>合同编号：<span>".$row['htnumber']."</span></p><p onClick=\"openme(".$row[0].")\" id=\"".$row[0]."\">展开详情 ︾</p>
   <div id=\"xiang".$row[0]."\" style=\"display:none\"><p>总金额：<span>".$row['htzmoney']."元</span></p><p>尾款：<span>".$row['htwmoney']."元</span></p><p style=\"$none\">维护费：<span>".$row['htmaintenance']."元</span></p><p style=\"$none\">收维护费日期：<span>".$htmaintenancedate."</span></p>
   <p>甲方：<span>".$row['htjfname']."</span></p><p>乙方：<span>".$row['htyfname']."</span></p><p>签订日期：<span>".$htsigningdate."</span></p><p>到期日期：<span>".date("Y-m-d",$row['htenddate'])."</span></p>".$addimg."</div></div>"; 
		   }   
		   
  	  $returnstr['error']=0;
	  $returnstr['num']=$num;
	  $returnstr['nowpage']=$nowpage;
	  $returnstr['zpage']=$fenye;
	  $returnstr['lists']=$outarr;
	   }else{
  	  $returnstr['error']=0;
	  $returnstr['num']=0;
	  $returnstr['nowpage']=1;
	  $returnstr['zpage']=1;
	  $returnstr['lists']="";
	  		   
		   }
	   
         
}else{
	$returnstr=array("error"=>"远端异常"); 
	}

echo json_encode($returnstr,true);	
?>