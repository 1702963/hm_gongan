<?php
header('Content-Type:text/html;charset=utf-8');

////////////////////////////////////
      $zzmmarr[1]="中共党员";
	  $zzmmarr[2]="共青团员";
      $zzmmarr[3]="民主党派";
      $zzmmarr[4]="学生";
      $zzmmarr[5]="群众"; 
///////////////////////////////////////

$db_c=require 'caches/configs/database.php'; 
//print_r($db_c['default']['database']);
@$con = mysqli_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);
if (!$con)
  { // 
  die();
  }

 mysqli_select_db($con,"fujing"); 
 mysqli_set_charset($con,"UTF8"); 

/////////////////////////////////////////////////////////////
		//邦定层级
	   $sql="select * from v9_cengji ";
	   @$rs=mysqli_query($con,$sql);
	   while(@$row = mysqli_fetch_array($rs)){
			$cengji[$row['id']]=$row['cjname'];
			}
			
		//邦定岗位
	   $sql="select * from v9_gangwei ";
	   @$rs=mysqli_query($con,$sql);
	   while(@$row = mysqli_fetch_array($rs)){
			$gangwei[$row['id']]=$row['gwname'];
			}
			
		//邦定辅助岗位
	   $sql="select * from v9_gangweifz ";
	   @$rs=mysqli_query($con,$sql);
	   while(@$row = mysqli_fetch_array($rs)){
			$gangweifz[$row['id']]=$row['gwname'];
			}
						
		//邦定职务
	   $sql="select * from v9_zhiwu ";
	   @$rs=mysqli_query($con,$sql);
	   while(@$row = mysqli_fetch_array($rs)){
			$zhiwu[$row['id']]=$row['zwname'];
			
			}
			
		//邦定学历
	   $sql="select * from v9_xueli ";
	   @$rs=mysqli_query($con,$sql);
	   while(@$row = mysqli_fetch_array($rs)){
			$xueli[$row['id']]=$row['gwname'];
			}
			
		//邦定岗位等级
	   $sql="select * from v9_gwdj ";
	   @$rs=mysqli_query($con,$sql);
	   while(@$row = mysqli_fetch_array($rs)){
			$gwdj[$row['id']]=$row['cjname'];
			}
			
		//特长
	   $sql="select * from v9_techangclass ";
	   @$rs=mysqli_query($con,$sql);
	   while(@$row = mysqli_fetch_array($rs)){
			$techangs[$row['id']]=$row['classname'];
			}			
						
						
		 //绑定组织
	   $sql="select * from v9_bumen ";
	   @$rs=mysqli_query($con,$sql);
	   while(@$row = mysqli_fetch_array($rs)){
			$bms[$row['id']]=$row['name'];
			
			}

////////////////////////////////////////////////////////////


	   $sql="select * from v9_fujing where id=".intval(@$_GET['id']);
	   @$rs=mysqli_query($con,$sql);
	   @$row = mysqli_fetch_array($rs);
	   
	   if(!$row){
		   echo "<script>alert('不存在该人员信息')</script>";
           exit;
		   }
	   //var_dump($row);exit;
  
	   //特长
	   $sql="select tcid from v9_techang where isok=1 and fjid=".intval(@$_GET['id']);
	   @$rs=mysqli_query($con,$sql);
	   while(@$rowtc = mysqli_fetch_array($rs)){
		    if($techangs[$rowtc['tcid']]=="其他"){
			 $tcarr[]=$rowtc['xiangqing'];
			 }else{
			 $tcarr[]=$techangs[$rowtc['tcid']];
		     }
		   }
	   if(is_array($tcarr)){
		   $tcstr=implode(",",$tcarr);
		   }else{
			$tcstr="";   
			   }	
			   
	// var_dump($tcarr);exit;		   
		//简历	      
	   $sql="select * from v9_lvlib where isok=1 and fjid=".intval(@$_GET['id'])." order by indt desc";
	   @$rs=mysqli_query($con,$sql);
	   $jlarr[0]="";
	   while(@$rowjl = mysqli_fetch_array($rs)){
		   $jlarr[]=$rowjl['lvli'];
		   }
	   if(is_array($tcarr)){
		   $jlstr=implode("<w:br/>",$jlarr);
		   }else{
			$jlstr="";   
			   }		   
 
       //社会关系 
	   $sql="select * from v9_jiashu where fjid=".intval(@$_GET['id'])." order by id asc";
	   @$rs=mysqli_query($con,$sql);
	   while(@$rowsh = mysqli_fetch_array($rs)){
		   $shgx[]=$rowsh;
		   }
    
   
////////////////////////////////////

require_once 'phpcms/libs/classes/PHPWord/PHPWord.php';

$PHPWord = new PHPWord();

$document = $PHPWord->loadTemplate('wordtmp/fujingtemp.docx');

$document->setValue('xingming', "$row[xingming]");
$document->setValue('sex', "$row[sex]");

$picParam = array('src' => "..".$row[thumb], 'size' =>array('120','160')); 

//print_r($picParam);exit;
$document->setImg('pic', $picParam);   //照片
$shengri=date('Y-m-d',$row[shengri]); 
$document->setValue('shengri', "$shengri");//生日
$document->setValue('minzu', "$row[minzu]"); //民族
$document->setValue('jiguan', "$row[hjdizhi]"); //籍贯
if($row['rdtime']>0){
$rdshijian=date("Y-m-d".$row['rdtime']);
}else{
$rdshijian="";	
	}
$document->setValue('rdsj', "$rdshijian"); //入党时间
$zzmm=$zzmmarr[$row[zzmm]];
$document->setValue('zzmm', "$zzmm"); //民族
$document->setValue('sfz', "$row[sfz]"); //身份证
$xueli=$xueli[$row[xueli]];
$document->setValue('xl', "$xueli"); //学历
$xxjzy=$row['xuexiao'];
$zhuanye=$row['zhuanye'];
$document->setValue('yuanxiao', "$xxjzy"); //院校
$document->setValue('zhuanye', "$zhuanye"); //专业

//$document->setValue('zhuzhi', "$row[jzd]");
$document->setValue('techang', "$tcstr"); //特长
$fzgw=$gangweifz[$row[gangweifz]];
$document->setValue('fzgw', "$fzgw"); //辅助岗位
$document->setValue('dfmj', "$row[dfmj]"); //带辅民警
$document->setValue('jianli', "$jlstr"); //简历
$document->setValue('shouji', "$row[tel]"); //手机号

$jingxiaos[1]="是";
$jingxiaos[2]="否";
$tuiwus[1]="是";
$tuiwus[2]="否";

$jingxiao=$jingxiaos[$row[jingxiao]];
$tuiwu=$tuiwus[$row[tuiwu]];

$document->setValue('jingxiao', "$jingxiao"); //警校
$document->setValue('tuiwu', "$tuiwu"); //退伍

$danwei=$bms[$row['dwid']];
$zhiwus=$zhiwu[$row['zhiwu']];
$rzday=date("Y-m-d",$row['rjtime']);
$cengjis=$cengji[$row['cengji']];
$gangweidjs=$gwdj[$row['gwdj']];

$document->setValue('danwei', "$danwei");
$document->setValue('zhiwu', "$zhiwus");
$document->setValue('ruzhi', "$rzday");
$document->setValue('cengji', "$cengjis");
$document->setValue('gwdj', "$gangweidjs");

//////////////////////////////////////////////////////////////////////////////////////////
///社会关系  默认6条记录，再多也不显示
for($i=0;$i<=5;$i++){
	$cynn[$i]="";
	}

///循环赋值
foreach($shgx as $k=>$v){
 $cycw[$k]=$v['guanxi'];
 $cyxm[$k]=$v['xingming'];
 $cynn[$k]=$v['sfz'];
 $cyzz[$k]=$v['tel'];
 $cydw[$k]=$v['dizhi'];	
	}

//var_dump($cynn);exit;

//这么输出可是要命了
$document->setValue('cycw0', "$cycw[0]");
$document->setValue('cyxm0', "$cyxm[0]");
$document->setValue('cynn0', "$cynn[0]");
$document->setValue('cyzz0', "$cyzz[0]");
$document->setValue('cydw0', "$cydw[0]");

$document->setValue('cycw1', "$cycw[1]");
$document->setValue('cyxm1', "$cyxm[1]");
$document->setValue('cynn1', "$cynn[1]");
$document->setValue('cyzz1', "$cyzz[1]");
$document->setValue('cydw1', "$cydw[1]");

$document->setValue('cycw2', "$cycw[2]");
$document->setValue('cyxm2', "$cyxm[2]");
$document->setValue('cynn2', "$cynn[2]");
$document->setValue('cyzz2', "$cyzz[2]");
$document->setValue('cydw2', "$cydw[2]");

$document->setValue('cycw3', "$cycw[3]");
$document->setValue('cyxm3', "$cyxm[3]");
$document->setValue('cynn3', "$cynn[3]");
$document->setValue('cyzz3', "$cyzz[3]");
$document->setValue('cydw3', "$cydw[3]");

$document->setValue('cycw4', "$cycw[4]");
$document->setValue('cyxm4', "$cyxm[4]");
$document->setValue('cynn4', "$cynn[4]");
$document->setValue('cyzz4', "$cyzz[4]");
$document->setValue('cydw4', "$cydw[4]");

$document->setValue('cycw5', "$cycw[5]");
$document->setValue('cyxm5', "$cyxm[5]");
$document->setValue('cynn5', "$cynn[5]");
$document->setValue('cyzz5', "$cyzz[5]");
$document->setValue('cydw5', "$cydw[5]");

//////////////////////////////////////////////////////////////////////////////////////////


$title=time()."-".$id;
$document->save('word/'.$title.'.docx');

//////////////////////////////////////

ob_clean();
ob_start();
$fp = fopen('word/'.$title.'.docx',"r");
$file_size = filesize('word/'.$title.'.docx');
Header("Content-type:application/octet-stream");
Header("Accept-Ranges:bytes");
Header("Accept-Length:".$file_size);
Header("Content-Disposition:attchment; filename=".iconv("UTF-8","gbk//TRANSLIT",$row['xingming']."个人信息").'.docx');
$buffer = 1024;
$file_count = 0;
while (!feof($fp) && $file_count < $file_size){
    $file_con = fread($fp,$buffer);
    $file_count += $buffer;
    echo $file_con;
}
fclose($fp);
ob_end_flush();

?>