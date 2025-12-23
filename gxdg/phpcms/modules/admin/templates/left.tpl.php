<?php defined('IN_ADMIN') or exit('No permission resources.'); 
//var_dump($_GET);exit;
 $db_c=require 'caches/configs/database.php';
 //引入语言包
include PC_PATH.'languages/zh-cn/system_menu.lang.php';
include PC_PATH.'languages/zh-cn/admin.lang.php';
//var_dump($_GET);

 $con = mysqli_connect($db_c['default']['hostname'],$db_c['default']['username'],$db_c['default']['password']);	
 if (!$con){
	 die(json_encode(array('error'=>"系统异常",'str'=>"系统异常")));
	 }
 mysqli_select_db($con,$db_c['default']['database']); 


mysqli_set_charset($con,"UTF8"); 

$mid=intval($_GET['menuid']);

	   $sql="SELECT * FROM `mj_menu` where id=$mid and display=1 order by listorder";  	   
	   $rs=mysqli_query($con,$sql);
	   $row = mysqli_fetch_array($rs);
	   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
*{padding:0; margin:0;}
html {height:100%;}
body {height:100%;/*background:#1d1e72*/}
a:hover {text-decoration:none}
body {
	scrollbar-face-color: #0099cc;
	scrollbar-bar-color: #0099cc;
	scrollbar-darkshadow-color: #0099cc;
	scrollbar-highlight-color: #0099cc;
	scrollbar-shadow-color: #0099cc;
	scrollbar-3dlight-color: #0099cc;
	scrollbar-arrow-color: #071e47;
	scrollbar-track-color: #071e47;
}
::-webkit-scrollbar {
  background-color:#f00;
}
 
::-webkit-scrollbar-track {
  background-color: #06c;
}
 
::-webkit-scrollbar-thumb {
  background-color:#0CF;
}
#menuc {width:226px;overflow:hidden;}
.box{ width:206px;height:100%;overflow-y:none;/*background:#1d1e72;*/margin:10px}
.navTitle {width:206px;height:65px;background:url(statics/images/admin_img/2025/leftNavBg.png) no-repeat;margin-bottom:7px;color:#fff;position:relative;overflow:hiddenm;float:left;margin-top:0px}
.navTitleName {font-size:18px;color:#fff;font-weight:900;margin-top:29px;margin-left:50px}
.navContent {width:206px;/*background:#1d1e72;border:1px solid #274676;*/float:left;margin:0 10px 10px 0;box-sizing:content-box}
.navContent {height:calc(100% - 180px);background:rgba(0,20,80,0.75)}

.Collapsing{ width:182px;height:35px;cursor:pointer; text-align:left;float:left;margin:10px 12px 0 12px}
.Collapsing a {width:100%;height:35px;line-height:35px;display:block;background:url(statics/images/admin_img/2025/leftNavHover.png) no-repeat;font-size:16px;text-indent:16px;color:#b4e5ff;font-weight:900;transition: all .2s ease-in-out}
.Collapsing a:hover {filter:brightness(2)}

.coll_body{width:182px;float:left;margin:10px 12px 0 12px;padding-bottom:12px;display:}
.coll_body dl {width:170px;display:flex;margin-left:12px}
.coll_body dt {width:10px;color:#fff;font-weight:900;line-height:28px;margin-left:6px}
.coll_body a{width:148px;display:block; text-align: left; font-size:14px;line-height:1.5;color:#b4e5ff;text-decoration:none;padding:6px 6px 10px 6px;background:url(statics/images/admin_img/2025/leftNavCut.png) 0 bottom no-repeat}
.coll_body dl {transition: all .2s ease-in-out}
.coll_body dl:hover {background: #103f9c ;}
.coll_body dl:hover a {color:#fff}
.current{color:#fc0}
.coll_null {width:100%;height:20px}
</style>
<script src="statics/js/jquery.min.js" type="text/javascript"></script>
<script src="statics/js/scrollReveal.js"></script>
<script>
//初始化scrollReveal
if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))){
	(function(){
		window.scrollReveal = new scrollReveal({reset: true});
	})();
};
</script>
</head>

<body>
<div id="menuc">
<?php 
if(intval($_GET['menuid'])<1){
?>
<div class="box" data-scroll-reveal="enter left">
    <div class="navTitle">
    	<div class="navTitleName">系统消息</div>
    </div>
    <div class="navContent">
        <div class="Collapsing">
        	<a href="#">站内通知</a>
        </div>
		<div class="coll_body">
			<dl><dt>·</dt><dd><a href="#">请各单位本月5日前上报上月全警考勤</a></dd></dl>
    	</div>
    </div>
</div>
</div>
<?php }else{
	
	?>
<div class="box" data-scroll-reveal="enter left">
    <div class="navTitle">
    	<div class="navTitleName"><?php echo $LANG[$row['name']]?></div>
    </div>
    <div class="navContent">
    <?php 
	   $sqla="SELECT * FROM `mj_menu` where parentid=".$row['id']." and display=1 order by listorder";  
	   $rsa=mysqli_query($con,$sqla);
	   while($rowa = mysqli_fetch_array($rsa)){	
	?>
        <div class="Collapsing">
        	<a href="#"><?php echo $LANG[$rowa['name']]?></a>
        </div>
    <?php 
	   $sqlb="SELECT * FROM `mj_menu` where parentid=".$rowa['id']." and display=1 order by listorder"; 
	   $rsb=mysqli_query($con,$sqlb);
	  
	?>        
		<div class="coll_body">
        <?php while($rowb = mysqli_fetch_array($rsb)){	 ?>
			<dl><dt>·</dt><dd><a href="javascript:openme(<?php echo $row['id']?>,'<?php echo $LANG[$rowa['name']]?>','?m=<?php echo $rowb['m']?>&c=<?php echo $rowb['c']?>&a=<?php echo $rowb['a']?>')"><?php echo $LANG[$rowb['name']]?></a></dd></dl>
        <?php }?>    
    	</div>
       
      <?php }?>
    </div>
</div>
</div>
<?php }?>
<script type="text/javascript">

$(function(){
    $(".coll_body").eq(0).show();
    $(".Collapsing").click(function(){
        $(this).toggleClass("current").siblings('.Collapsing').removeClass("current");
        $(this).next(".coll_body").slideToggle(300).siblings(".coll_body").slideUp(300);
    });

   	var h = $(window).height() - 78;
   	$("#menuc").css({height:h});

});

function openme(menuid,menuname,targetUrl){

     $("#leftMain",window.parent.document).load("?m=admin&c=index&a=public_menu_left&menuid="+menuid+"&sj="+Math.random());
	 $("#current_pos",window.parent.document).html(menuname);
     setTimeout(function() {
	//不知道为啥要延迟更新框架，啥意思呢 
   	   $("#rightMain",window.parent.document).attr('src', targetUrl+'&menuid='+menuid+'&pc_hash='+pc_hash);
     }, 100);		
	
	}
</script>
</body>
</html>
