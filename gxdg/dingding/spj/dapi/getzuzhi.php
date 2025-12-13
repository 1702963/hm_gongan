<?php
header("Content-type: text/html; charset=utf-8"); 
ini_set("display_errors","On");

if(!isset($_COOKIE['loginid'])){
//echo json_encode(array("errcode"=>"权限不足"),true);	
//exit;
}
//  组织架构

//echo json_encode(array(print_r($_POST,1)),true);	
//exit;

if(!isset($_COOKIE['access_token'])){
 echo json_encode(array("errcode"=>"授权凭证已过期"),true);
 exit;		
	}else{
 $_token=$_COOKIE['access_token'];		
		}

$_zuzhi=json_decode(file_get_contents("https://oapi.dingtalk.com/department/list?access_token=$_token"),true);

//print_r($_zuzhi);

if($_zuzhi['errcode']!=0){
 echo json_encode(array("errcode"=>"异常的返回结构"),true);
 exit;
	}

/*
if(@$_POST['subid']=="1"){
	          foreach($_zuzhi['department'] as $arr){
			   if(@$arr['parentid']==1){
	               @$liststr.="<li style='list-style:none;font-size:16px' onclick='showsub(".$arr['id'].")'>".$arr['name']."</li>";
			   } 
             }
	}else{
	          foreach($_zuzhi['department'] as $arr){
			   if(@$arr['parentid']==intval(@$_POST['subid'])){
	               @$liststr.="<li style='list-style:none;font-size:16px' onclick='showsub(".$arr['id'].")'>".$arr['name']."</li>";
			   } 
             }		
		} */
      
//尝试输出树形结构   不做递归，生成5级结构
              $liststr="";
	          foreach($_zuzhi['department'] as $arr){
			   if(@$arr['parentid']==1){
	               $liststr.="<li style='list-style:none;font-size:16px' onclick='subuser(".$arr['id'].")'> + ".$arr['name']."</li>";
	               foreach($_zuzhi['department'] as $arr1){
			        if(@$arr1['parentid']==$arr['id']){
	                  $liststr.="<li style='list-style:none;font-size:16px;margin-left:5px' onclick='subuser(".$arr1['id'].")'> - ".$arr1['name']."</li>";
				      foreach($_zuzhi['department'] as $arr2){
			            if(@$arr2['parentid']==$arr1['id']){
	                      $liststr.="<li style='list-style:none;font-size:16px;margin-left:10px' onclick='subuser(".$arr2['id'].")'> - ".$arr2['name']."</li>";
				          foreach($_zuzhi['department'] as $arr3){
			                if(@$arr3['parentid']==$arr2['id']){
	                          $liststr.="<li style='list-style:none;font-size:16px;margin-left:15px' onclick='subuser(".$arr3['id'].")'> - ".$arr3['name']."</li>";
				              foreach($_zuzhi['department'] as $arr4){
			                    if(@$arr4['parentid']==$arr3['id']){
	                              $liststr.="<li style='list-style:none;font-size:16px;margin-left:20px' onclick='subuser(".$arr4['id'].")'> - ".$arr4['name']."</li>";
				   
			                    } 				     
			                   } 				   
			              } 
						  }
                      }		
					  }
			        } 
                   }				   
			   } 
             }

//	  
      //die($liststr);
	  $returnstr=array("errcode"=>0,"lists"=>$liststr);
    
echo json_encode($returnstr,true);	
?>