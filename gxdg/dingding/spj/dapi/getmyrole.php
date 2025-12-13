<?php 
// DOUSER

if(!isset($_POST['userid']) || !isset($_POST['atoken'])){
         echo json_encode(array("error"=>1,"errorstr"=>"异常的请求来源"));
         exit;		
	}
	
	  $_uid=$_POST['userid'];
	  $_token=$_POST['atoken'];		
	  
      $inuser=json_decode(file_get_contents("https://oapi.dingtalk.com/user/get?access_token=$_token&userid=$_uid"),true);
	  //print_r($inuser['roles']);
	 
	  $isadmined=0;
	  foreach($inuser['roles'] as $ro){
		  
		  if($ro['name']=="值班管理员"){
		  $isadmined=1;
		  break;}
		  }
			  //echo $isadmined;
			 
		setcookie("isadmin",$isadmined);  	  
          


         echo json_encode(array("error"=>$isadmined,"errorstr"=>""));
         exit;	
?>