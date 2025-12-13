<?php
defined('IN_ADMIN') or exit('No permission resources.');
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';

$this->db->table_name = 'mj_xuanchuan_sucai';
$tjrs = $this->db->get_one(" isok=1 and dbtype='稿件' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_zs= $tjrs['hj'];


$_bennian=date("Y");
$_benyue=date("m");
$_benweek=date("w");
/// 本年
$tjrs = $this->db->get_one(" isok=1 and dbtype='稿件' and ns=$_bennian ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_ns= $tjrs['hj'];
/// 本月
$tjrs = $this->db->get_one(" isok=1 and dbtype='稿件' and ms=$_benyue ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_ms= $tjrs['hj'];
/// 本周
$tjrs = $this->db->get_one(" isok=1 and dbtype='稿件' and ws=$_benweek ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_ws= $tjrs['hj'];

//国家
$tjrs = $this->db->get_one(" isok=1 and dbtype='稿件' and mtjibie='国家级' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_mt_g= $tjrs['hj'];
//省级
$tjrs = $this->db->get_one(" isok=1 and dbtype='稿件' and mtjibie='省（部）级' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_mt_sb= $tjrs['hj'];
//市级
$tjrs = $this->db->get_one(" isok=1 and dbtype='稿件' and mtjibie='市级' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_mt_shi= $tjrs['hj'];
//区县
$tjrs = $this->db->get_one(" isok=1 and dbtype='稿件' and mtjibie='区级' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_mt_q= $tjrs['hj'];
//市局

?>
<!--
<div id="main_frameid" class="pad-10 display" style="_margin-right:-12px;_width:98.9%;">
-->
<body>
<script src="statics/js/jquery.min.js"></script>
<script>
$(function(){
//关于高新系统
//1、由于英文字体Acens显示逗号时窄数字1与其他数字有差异，所以暂时改用KeepCal字体；
	
	//设置需要显示的数据
	var ArrayWrapData = [
		['minjingrenshu', <?php echo $_zs?>],        // 总数
		['fujingrenshu', <?php echo $_ns?>],          // 辅警人数
		['shishikaoqin', <?php echo $_ms?>],          // 实时考勤
		['xiujiarenshu ', <?php echo $_ws?>],          // 休假人数
		['gerenshixiangtianbao', 4], // 个人事项同填报
		['benyuebiaozhang', <?php echo $_mt_g?>],        // 本月表彰人数
		['wenmingbiaobing', <?php echo $_mt_sb?>],       // 文明标兵
		['weixiaozhixing', <?php echo $_mt_shi?>],        // 微笑之星
		['youxiuwanggeyuan', <?php echo $_mt_q?>],       // 优秀网格员
		['benyuetongbaorenshu', 0]     // 本月通报人数
	];
	//数字过渡效果
	function numberAnimate(idName,countNumber) {
		var fidName = idName;
		var fcount = parseInt(countNumber);
		$("#"+fidName).animate({count: fcount}, {     
			duration: 2000,     
			step: function() {       
				$("#"+fidName).text( Intl.NumberFormat().format( parseInt(this.count) ) );
			}  
		});
	}
	//遍历数组并执行过渡效果
	$.each(ArrayWrapData, function(index, subArray) {
		numberAnimate(subArray[0],subArray[1]); 
	});	
 
})
</script>
<style type="text/css">
@font-face {
    font-family: "AcensFont";
    src: url('statics/fonts/KeepCalm-Medium.ttf');
    font-weight: normal;
    font-style: normal;
}
@keyframes rotate360 {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
* {margin:0;padding:0}
html {height:100%}
body { margin:0; padding:0; height:100%; display:flex; align-items:center; justify-content: center; font-family:microsoft yahei; user-select: none}
a , a:hover {text-decoration:none}
.tableContent {margin-top:-15px;height:calc( 100% - 100px )}
div { box-sizing: border-box }


.DigitalContent {width:100%;min-width:1640px; height:100%; /*background:rgba(10,60,160,0.25);*/ color:#fff; }
.DigitalContent span {font-family:AcensFont}

#modRenshi , #modHonour {width:1580px;width:100%}
.modTitle {width:100%;height:40px;}
.modName {width:100%;height:36px;line-height:36px;font-size:20px;text-indent:15px;color:#cbf0ff;font-weight:600; background:linear-gradient(to right, rgba(0,80,180,0.4) , rgba(0,80,180,0) )}
.modLine {width:100%;height:4px;border-bottom:1px solid #274ca2}
.modItemContent {width:100%;display:flex;padding:0 30px}
.DataItemPic {width:60px;height:60px; border-radius:50px; overflow:hidden;margin:0 20px; position:relative; display:flex; align-items:center;justify-content: center;}
.DataItemLight {width:60px;height:60px;position:absolute;left:0;top:0;z-index:99;background:url(statics/images/admin_img/2025/itemCircleBg.png) center center no-repeat;background-size:100%;animation:rotate360 5s linear infinite;}
.DataItemName {width:100%;font-size:14px;margin-top:0px}
.DataItemNumber {font-size:30px;font-family:AcensFont;margin-top:0;letter-spacing:3px}

.DataItem , .DataHonour , .DataReport {display:flex; align-items:center; border-radius:3px; }
.DataItem {width:20%;height:calc( 100vh - 90vh ); min-height:100px;  background:rgba(10,80,180,0.2);  border:1px solid rgba(10,60,160,0.5); margin:30px 30px 30px 0;}
.DataHonour  {width:20%;height:calc( 100vh - 90vh ); min-height:100px; background:rgba(10,150,180,0.2); border:1px solid rgba(10,160,160,0.5); margin:0 30px 30px 0;}
.DataReport {width:20%;height:calc( 100vh - 90vh );  min-height:100px; background:rgba(255,100,0,0.2); border:1px solid rgba(255,100,0,0.5); margin:0 30px 30px 0;}

.modEcharts , .modEchartsPie {min-height:400px; background:rgba(10,80,180,0.2);  border:1px solid rgba(10,60,160,0.5); border-radius:3px}
.modEcharts {width:calc( 60% - 30px ); height:calc( 100vh - 50vh );  margin:0 30px 0 0}
.modEchartsPie {width:calc( 40% - 30px ); height:calc( 100vh - 50vh ); margin:0 0 0 0}
</style>

<div class="tableContent">
	<div class="DigitalContent">
        <!--
        	scrollReveal实例
        	data-scroll-reveal="wait 0.2s enter left"
        -->
        <!--人事模块-->
        <div id="modRenshi">
        	<!--
        	<div class="modTitle">
            	<div class="modName" data-scroll-reveal="wait .2s enter right">人事</div>
                <div class="modLine" data-scroll-reveal="enter left"></div>
            </div>
            -->
            <div class="modItemContent">
            
            	<!--民警人数-->
                
            	<div class="DataItem" data-scroll-reveal="enter right">
                	<div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                    	<img src="statics/images/admin_img/2025/rs03.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <a href="?m=xuanchuan&c=gaojian&a=lists">
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">全部稿件</div>
                        <div class="DataItemNumber" id="minjingrenshu">0</div>
                    </div>
                    </a>
                </div>
                
                <!--辅警人数-->
            	<div class="DataItem" data-scroll-reveal="enter right">
                	<div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                    	<img src="statics/images/admin_img/2025/rs03.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName"><?php echo $_bennian?> 年</div>
                        <div class="DataItemNumber" id="fujingrenshu">0</div>
                    </div>
                </div>
                <!--实时考勤-->
            	<div class="DataItem" data-scroll-reveal="enter right">
                	<div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                    	<img src="statics/images/admin_img/2025/rs03.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName"><?php echo $_benyue?> 月</div>
                        <div class="DataItemNumber" id="shishikaoqin">0</div>
                    </div>
                </div>
                <!--休假人数-->
            	<div class="DataItem" data-scroll-reveal="enter right">
                	<div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                    	<img src="statics/images/admin_img/2025/rs03.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">本周</div>
                        <div class="DataItemNumber" id="xiujiarenshu">0</div>
                    </div>
                </div>
                <!--个人事项填报-->
            	<div class="DataItem" data-scroll-reveal="enter right" style="display:none">
                	<div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                    	<img src="statics/images/admin_img/2025/rs03.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">未采用稿件</div>
                        <div class="DataItemNumber" id="gerenshixiangtianbao">0</div>
                    </div>
                </div>
                <!--数据组结束-->
                
            </div>
        </div>
        <!--人事模块-->
        
        
        <!--表彰督导模块-->
        <div id="modHonour">
            <div class="modItemContent">
            
                <!--本月表彰人数-->
                <div class="DataHonour" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/bz01.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">国家级媒体</div>
                        <div class="DataItemNumber" id="benyuebiaozhang">0</div>
                    </div>
                </div>
                
                <!--文明标兵-->
                <div class="DataHonour" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/bz01.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">省(部)级媒体</div>
                        <div class="DataItemNumber" id="wenmingbiaobing">0</div>
                    </div>
                </div>
                
                <!--微笑之星-->
                <div class="DataHonour" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/bz01.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">市级媒体</div>
                        <div class="DataItemNumber" id="weixiaozhixing">0</div>
                    </div>
                </div>
                
                <!--优秀网格警员-->
                <div class="DataHonour" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/bz01.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">区县级媒体</div>
                        <div class="DataItemNumber" id="youxiuwanggeyuan">0</div>
                    </div>
                </div>
                
                <!--本月通报人数-->
                <div class="DataHonour" data-scroll-reveal="enter right" style="display:none">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/bz01.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">本局采用</div>
                        <div class="DataItemNumber" id="benyuetongbaorenshu">0</div>
                    </div>
                </div>
    
            </div>
        
        </div>
        <!--表彰督导模块-->
        
        <div class="modItemContent">
	        <div class="modEcharts" data-scroll-reveal="enter left">单位上报同环比</div>
            <div class="modEchartsPie" data-scroll-reveal="enter right">单位采用同环比</div>
        </div>
        
        
    </div>
</div>

<script>
//初始化scrollReveal
if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))){
	(function(){
		window.scrollReveal = new scrollReveal({reset: true});
	})();
};
function openme(menuid,menuname,targetUrl){
     //alert(window.top.document)
     window.top.$("#leftMain").load("?m=admin&c=index&a=public_menu_left&menuid="+menuid+"&sj="+Math.random());
	 $("#current_pos",window.parent.document).html(menuname);
     setTimeout(function() {
	//不知道为啥要延迟更新框架，啥意思呢 
   	   $("#rightMain",window.parent.document).attr('src', targetUrl+'&menuid='+menuid+'&pc_hash='+pc_hash);
     }, 100);	
}
</script>

</body>
</html>