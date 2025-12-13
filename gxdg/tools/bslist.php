<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
ini_set("display_errors","On");
$db_c=require '../caches/configs/database.php'; 
//print_r($db_c['default']['database']);
@$con = mysql_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);
if (!$con)
  { // 
  echo '<div style="color:red;height:80px;margin-top:20px;" align="center">err: E0X96001</div>';
  die();
  }

@mysql_select_db($db_c['default']['database'], $con); 
@mysql_query("SET NAMES UTF8"); 



//////////////////////////////////////////
	   $sql="select * from gx_bishi ";
	   $rs=mysql_query($sql,$con);
	   while($row = mysql_fetch_array($rs)){
		 
		//检查姓名
	   //$csql="select * from mj_fujing where xingming='".$row['un2']."' ";
	   //$crs=mysql_query($csql,$con);
	   //$crow = mysql_fetch_array($crs);		
	   //if(!isset($crow[0]['ddid'])){//如果已写入就跳过，防止重名	 
		 
		// $sql2="update mj_fujing set ddid=".$row['did']." where id=".$crow['id'];
	    // $rs2=mysql_query($sql2,$con);
	   //}
	   
	   $ls[]=$row;
		   }

//echo "dook";		   

/*

//var_dump($con);
	   $sql="select * from sheet0 where zz=1 ";
	   $rs=mysql_query($sql,$con);

$today = new DateTime();

	   while($row = mysql_fetch_array($rs)){
		 
		// $sql2="update sheet0 set sr2='".strtotime($row['sr'])."' where id=".$row['id'];
		
$birthDate = new DateTime($row['sr']);
// 计算两个日期的差
$age = $today->diff($birthDate);
// 获取完整的年龄（年）
//$ageInYears = $age->y;
 
		
		 $sql2="update sheet0 set nl=".($age->y+1)." where id=".$row['id'];
		 echo $sql2."<br>";
	     $rs2=mysql_query($sql2,$con);
	    
		   }
		   
*/		  
?>
<table width="100%" border="0">
  <tr>
    <td align="center" bgcolor="#CCCCCC">序号</td>
    <td align="center" bgcolor="#CCCCCC">姓名</td>
    <td align="center" bgcolor="#CCCCCC">身份证</td>
    <td align="center" bgcolor="#CCCCCC">性别</td>
    <td align="center" bgcolor="#CCCCCC">考场号</td>
    <td align="center" bgcolor="#CCCCCC">座位号</td>
    <td align="center" bgcolor="#CCCCCC">准考证号</td>
    <td align="center" bgcolor="#CCCCCC">查询时间</td>
    <td align="center" bgcolor="#CCCCCC">下载时间</td>
  </tr>
  <?php 
   foreach($ls as $v){
  ?>
  <tr>
    <td><?php echo $v['xh']?></td>
    <td><?php echo $v['xingming']?></td>
    <td><?php echo $v['sfz']?>`</td>
    <td><?php echo $v['sex']?></td>
    <td><?php echo $v['kch']?></td>
    <td><?php echo $v['zwh']?></td>
    <td><?php echo $v['zkzh']?>`</td>
    <td><?php if($v['xcdt']>0){echo date("Y-m-d H:i:s",$v['xcdt']);}?>`</td>
    <td><?php if($v['dndt']>0){echo date("Y-m-d H:i:s",$v['dndt']);}?>`</td>
  </tr>
  <?php }?>
</table>

