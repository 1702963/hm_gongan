<?php
defined('IN_ADMIN') or exit('No permission resources.');
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';


//民警数
$this->db->table_name = 'v9_fujing';
$tjrs = $this->db->get_one(" status=1 and ismj=1",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_mjzs= $tjrs['hj'];

//辅警数
$this->db->table_name = 'v9_fujing';
$tjrs = $this->db->get_one(" status=1 and ismj=0",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_fjzs= $tjrs['hj'];

//考勤数
$this->db->table_name = 'v9_dks';
$tjrs = $this->db->get_one("",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_kqzs= $tjrs['hj'];

//休假数
$nowday=strtotime(date("Y-m-d"));
$this->db->table_name = 'v9_renshi_xiujia';
$tjrs = $this->db->get_one(" shenhe=1 and qt1<=$nowday and qt2>=$nowday",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_xjzs= $tjrs['hj'];

//填报数
$this->db->table_name = 'v9_renshi_sx';
$tjrs = $this->db->get_one(" isok=1 and spid=0",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_tbzs= $tjrs['hj'];

//表彰数
$benian=date("Y");
$benyue=intval(date("m"));
$this->db->table_name = 'v9_biaozhang_log';
$tjrs = $this->db->get_one(" shenhe=1 and isok=1 and ns=$benian and ms=$benyue ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_biaozhangzs= $tjrs['hj'];
//文明
$this->db->table_name = 'v9_biaozhang_log';
$tjrs = $this->db->get_one(" shenhe=1 and isok=1 and ns=$benian and ms=$benyue and mleixing='文明标兵' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_wenmingzs= $tjrs['hj'];
//微笑
$this->db->table_name = 'v9_biaozhang_log';
$tjrs = $this->db->get_one(" shenhe=1 and isok=1 and ns=$benian and ms=$benyue and mleixing='微笑之星' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_weixiaozs= $tjrs['hj'];
//网格
$this->db->table_name = 'v9_biaozhang_log';
$tjrs = $this->db->get_one(" shenhe=1 and isok=1 and ns=$benian and ms=$benyue and mleixing='优秀网格员' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_wanggezs= $tjrs['hj'];
//通报
$this->db->table_name = 'v9_biaozhang_log';
$tjrs = $this->db->get_one(" shenhe=1 and isok=1 and ns=$benian and ms=$benyue and mleixing='优秀网格员' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_tongbaozs= $tjrs['hj'];


?>
<!--
<div id="main_frameid" class="pad-10 display" style="_margin-right:-12px;_width:98.9%;">
-->
<body>
<script src="statics/js/jquery.min.js"></script>
<script src="statics/js/jquery.SuperSlide.2.1.1.js"></script>
<script src="statics/js/echarts.js"></script>
<script src="statics/js/resize.js"></script>
<script>
$(function(){
//关于高新系统
//1、由于英文字体Acens显示逗号时窄数字1与其他数字有差异，所以暂时改用KeepCal字体；
	
	//设置需要显示的数据
	var ArrayWrapData = [
		['minjingrenshu', <?php echo $_mjzs?>],        // 民警人数
		['fujingrenshu', <?php echo $_fjzs?>],          // 辅警人数
		['shishikaoqin', <?php echo $_kqzs?>],          // 实时考勤
		['xiujiarenshu ', <?php echo $_xjzs?>],          // 休假人数
		['gerenshixiangtianbao', <?php echo $_tbzs?>], // 个人事项同填报
		['benyuebiaozhang', <?php echo $_biaozhangzs?>],        // 本月表彰人数
		['wenmingbiaobing', <?php echo $_wenmingzs?>],       // 文明标兵
		['weixiaozhixing', <?php echo $_weixiaozs?>],        // 微笑之星
		['youxiuwanggeyuan', <?php echo $_wanggezs?>],       // 优秀网格员
		['benyuetongbaorenshu', <?php echo $_tongbaozs?>]     // 本月通报人数
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

.modEcharts , .modEchartsPie {min-height:360px; background:rgba(10,80,180,0.2);  border:1px solid rgba(10,60,160,0.5); border-radius:3px}
.modEcharts {/*width:calc( 60% - 30px );*/ width:100%; height:calc( 100vh - 55vh );  margin:0 30px 0 0}
.modEchartsPie {width:calc( 40% - 30px ); height:calc( 100vh - 50vh ); margin:0 0 0 0}
.modSliderForText {width:calc(100% - 90px);height:80px; background:rgba(10,80,180,0.2);  border:1px solid rgba(10,60,160,0.5); border-radius:3px; padding:0 0px;margin:30px 0 0 30px;display:flex;align-items:center}
.modSliderForTitle { width:120px; height:40px; background:#000;display:flex;align-items:center;justify-content:center;background:rgba(0,70,200,0.4);color:#fc0;font-size:14px;font-weight:900 ; margin-left:10px}

.picslide  {width:calc(100% - 160px); height:60px; border:0 solid #ddd;margin-left:10px;position:relative}
.tabbtn{position:relative}
.tabbtn .prev{width:20px;height:20px;text-align:center;line-height:20px;position:absolute;left:10px;top:20px;background:#036}
.tabbtn .next{width:20px;height:20px;text-align:center;line-height:20px;position:absolute;right:0px;top:20px;background:#036}
.pics{width:calc(100% - 60px);height:60px;margin:0 auto;overflow:hidden; display:flex; align-items:center;}
.pics ul {width:100%;}
.pics ul li{ border:0 solid #666; width:40%; height:40px; display:flex; align-items:center; margin:0 10px ; background:rgba(0,100,200,0.3); padding:0 20px}
.pics ul li a {font-size:14px;}
.pics ul li img{border:1px solid #eee}
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
                    	<img src="statics/images/admin_img/2025/rs01.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">民警人数</div>
                        <div class="DataItemNumber" id="minjingrenshu">0</div>
                    </div>
                </div>
                <!--辅警人数-->
            	<div class="DataItem" data-scroll-reveal="enter right">
                	<div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                    	<img src="statics/images/admin_img/2025/rs02.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">辅警人数</div>
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
                        <div class="DataItemName">实时考勤</div>
                        <div class="DataItemNumber" id="shishikaoqin">0</div>
                    </div>
                </div>
                <!--休假人数-->
            	<div class="DataItem" data-scroll-reveal="enter right">
                	<div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                    	<img src="statics/images/admin_img/2025/rs04.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">休假人数</div>
                        <div class="DataItemNumber" id="xiujiarenshu">0</div>
                    </div>
                </div>
                <!--个人事项填报-->
            	<div class="DataItem" data-scroll-reveal="enter right">
                	<div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                    	<img src="statics/images/admin_img/2025/rs05.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">个人事项填报</div>
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
                        <div class="DataItemName">本月表彰人数</div>
                        <div class="DataItemNumber" id="benyuebiaozhang">0</div>
                    </div>
                </div>
                
                <!--文明标兵-->
                <div class="DataHonour" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/bz02.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">文明标兵</div>
                        <div class="DataItemNumber" id="wenmingbiaobing">0</div>
                    </div>
                </div>
                
                <!--微笑之星-->
                <div class="DataHonour" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/bz03.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">微笑之星</div>
                        <div class="DataItemNumber" id="weixiaozhixing">0</div>
                    </div>
                </div>
                
                <!--优秀网格警员-->
                <div class="DataHonour" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/bz04.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">优秀网格警员</div>
                        <div class="DataItemNumber" id="youxiuwanggeyuan">0</div>
                    </div>
                </div>
                
                <!--本月通报人数-->
                <div class="DataReport" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/jd01.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">本月通报人数</div>
                        <div class="DataItemNumber" id="benyuetongbaorenshu">0</div>
                    </div>
                </div>
    
            </div>
        
        </div>
        <!--表彰督导模块-->
        
        <div class="modItemContent">
	        <div class="modEcharts" id="buMen" data-scroll-reveal="enter left"></div>

        </div>
      <?php 
	    //mj_renshi_xiujia
      $this->db->table_name = 'v9_renshi_xiujia';
      $tjrs = $this->db->get_one(" shenhe=0 and isok=1 ",'count(*) as hj');
      $outarr=array();
	  if($tjrs['hj']>0){
		 $outarr[]="<a href=javascript:openmes(1780,'人事管理','?m=renshi&c=renshi&a=init','?m=renshi&c=xiujia&a=init')>有新的休假申请等待审核</a>"; 
		  } 
	
      $this->db->table_name = 'v9_renshi_sx';
      $tjrs = $this->db->get_one(" shenhe=0 and isok=1 and spid=0 ",'count(*) as hj');

	  if($tjrs['hj']>0){
		 $outarr[]="<a href=javascript:openmes(1780,'人事管理','?m=renshi&c=renshi&a=init','?m=renshi&c=geren&a=init')>有新的个人事项上报等待审核</a>"; 
		  }

      $this->db->table_name = 'v9_biaozhang_log';
      $tjrs = $this->db->get_one(" shenhe=0 and isok=1 and mleixing='民警奖励' ",'count(*) as hj');

	  if($tjrs['hj']>0){
		 $outarr[]="<a href=javascript:openmes(1782,'表彰管理','?m=biaozhang&c=biaozhang&a=init','?m=biaozhang&c=biaozhang&a=mjjl')>有新的民警奖励等待审核</a>"; 
		  }		   	  	
	  ?>  
        <!--通知公告-->
        <div class="modSliderForText">
        	<div class="modSliderForTitle">系统消息</div>
            <div class="picslide">
              <div class="tabbtn">
                <ul>
                  <a href="javascript:void(0)" class="prev"><</a> <a href="javascript:void(0)" class="next">></a>
                </ul>
              </div>
              <div class="pics">
      
                <?php 
				  foreach($outarr as $v){
				?>
              <ul>  
                  <li><?php echo $v?></li>
              </ul>    
                <?php }?>  
                
              </div>
            </div>
        
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
function openmes(menuid,menuname,targetUrl,sburul){
     //alert(window.top.document)
     window.top.$("#leftMain").load("?m=admin&c=index&a=public_menu_left&menuid="+menuid+"&sj="+Math.random());
	 $("#current_pos",window.parent.document).html(menuname);
     setTimeout(function() {
	//不知道为啥要延迟更新框架，啥意思呢 
   	   $("#rightMain",window.parent.document).attr('src', sburul+'&menuid='+menuid+'&pc_hash='+pc_hash);
     }, 100);	
}
</script>
<?php 
//////柱图
	/*	 
	$zt[2]=array(20,0);	
	$zt[3]=array(14,0);	
	$zt[4]=array(15,0);	
	$zt[5]=array(0,0);	
	$zt[6]=array(17,0);	
	$zt[7]=array(12,0);	
	$zt[8]=array(4,0);	
	$zt[9]=array(6,0);	
	$zt[10]=array(23,0);	
	$zt[26]=array(5,0);	
	$zt[11]=array(33,0);	
	$zt[12]=array(64,0);	
	$zt[13]=array(117,0);	
	$zt[14]=array(97,0);	
	$zt[15]=array(67,0);	
	$zt[16]=array(64,0);	
	$zt[17]=array(4,0);	
	$zt[18]=array(4,0);	
	$zt[19]=array(4,0);	
	$zt[22]=array(0,0);
	$zt[23]=array(4,0);	
	$zt[24]=array(0,0);	
	$zt[27]=array(7,0);	
	*/
	    $this->db->table_name = 'v9_fujing';
		$rss = $this->db->select("isok=1 and status=1 ",'count(dwid) as hj,dwid','','','dwid');	
		foreach($rss as $aaa){
			$zt[$aaa['dwid']][]=$aaa['hj'];
			}			 
        
		//这里比较麻烦 
	    $this->db->table_name = 'v9_dks';
		$rss = $this->db->select("isok=1 ",'count(dwid) as hj,dwid','','','dwid');	
		foreach($rss as $aaa){
			$zt[$aaa['dwid']][1]=$aaa['hj'];
			}		 
  
?>
<script>
//各部门任务状态
var myChart = echarts.init(document.getElementById('buMen'));
option = {
    //backgroundColor: 'rgba(255, 255, 255, 0)',
	title:{
		text:'本日在岗情况',
		x:'left',
		y:'top',
		padding:[20,10,10,20],
		textStyle:{
			fontSize:18,
			fontWeight:'bolder',
			color:'#ffffff'
		}
	},
    legend: {
         textStyle:{
            fontSize: 14,
            color: '#eeeeee',
        },
        padding:[20,0,0,0],
    },
    grid: {
        left: '1%',
        right: '2%',
        bottom: '2%',
        containLabel: true,
        
    },
    tooltip: {
		trigger:'axis',
		axisPointer:{
			type:'shadow',
			shadowStyle:{
                //color: 'rgba(0,0,0, 0.2)', // 阴影颜色
                //shadowBlur: 5, // 阴影的模糊大小
                //shadowOffsetX: 3, // 阴影水平方向上的偏移
                //shadowOffsetY: 3 // 阴影垂直方向上的偏移
			}
		}
	},
    dataset: {
        source: [
            ['product', '总人数', '在岗数','待办','问题件'],
            ['指挥中心', <?php echo $zt[2][0]?>, <?php echo $zt[2][1]?>],
            ['政治处', <?php echo $zt[3][0]?>, <?php echo $zt[3][1]?>],
            ['警务督察大队', <?php echo $zt[4][0]?>, <?php echo $zt[4][1]?>],
            ['纪委', <?php echo $zt[5][0]?>, <?php echo $zt[5][1]?>],
            ['警务保障室', <?php echo $zt[6][0]?>, <?php echo $zt[6][1]?>],
            ['法制大队', <?php echo $zt[7][0]?>, <?php echo $zt[7][1]?>],
            ['国保大队', <?php echo $zt[8][0]?>, <?php echo $zt[8][1]?>],
            ['食品药品安全保卫大队', <?php echo $zt[9][0]?>, <?php echo $zt[9][1]?>],
            ['治安大队', <?php echo $zt[10][0]?>, <?php echo $zt[10][1]?>],
            ['网安大队', <?php echo $zt[26][0]?>, <?php echo $zt[26][1]?>],
            ['刑警大队', <?php echo $zt[11][0]?>, <?php echo $zt[11][1]?>],
            ['巡警特警大队', <?php echo $zt[12][0]?>, <?php echo $zt[12][1]?>],
            ['火炬路派出所', <?php echo $zt[13][0]?>, <?php echo $zt[13][1]?>],
            ['庆南道派出所', <?php echo $zt[14][0]?>, <?php echo $zt[14][1]?>],
            ['唐丰路派出所', <?php echo $zt[15][0]?>, <?php echo $zt[15][1]?>],
            ['老庄子派出所', <?php echo $zt[16][0]?>, <?php echo $zt[16][1]?>],
            ['流动警务工作站', <?php echo $zt[17][0]?>, <?php echo $zt[17][1]?>],
            ['会展广场警务站', <?php echo $zt[18][0]?>, <?php echo $zt[18][1]?>],
            ['龙泽路警务站', <?php echo $zt[19][0]?>, <?php echo $zt[19][1]?>],
            ['收费治安办', <?php echo $zt[22][0]?>, <?php echo $zt[22][1]?>],
            ['纪工委', <?php echo $zt[23][0]?>, <?php echo $zt[23][1]?>],
            ['空港城所', <?php echo $zt[24][0]?>, <?php echo $zt[24][1]?>],
            ['图侦中心', <?php echo $zt[27][0]?>, <?php echo $zt[27][1]?>]
        ]
    },
    xAxis: {
        type: 'category',
		barCategoryGap:20,
        axisLabel:{
        
        	interval:0,
			formatter:function(value) {
							var ret = "";
							var maxLength = 4;
							var valLength = value.length;
							var rowN = Math.ceil(valLength / maxLength); 
							if (rowN > 1) {
								for (var i = 0; i < rowN; i++) {
									var temp = "";
									var start = i * maxLength;
									var end = start + maxLength;
									temp = value.substring(start, end) + "\n";
									ret += temp;
								}
								return ret;
							} else {
								return value;
							}
				},
            
            textStyle:{
                color:'#b8d8f4',
				fontSize: 12,
            }
        },
        axisLine:{
                lineStyle:{
                color:'#28487f',
                width:2
            }
        },
        splitLine: {
                show:true,
                lineStyle: {
                    color: "#28487f",
					width:0
             }
        }
    },
    yAxis: {
        axisLabel:{
            textStyle:{
                color:'#b8d8f4'
            }
        },
        axisLine:{
                lineStyle:{
                color:'#28487f',
                width:0
            }
        },
        splitLine: {
                show:true,
                lineStyle: {
                    color: "#28487f",
             }
        }
    },
    // Declare several bar series, each will be mapped
    // to a column of dataset.source by default.
    series: [
        {
            type: 'bar',
            barWidth : 10,
			barGap:'50%',
			emphasis:{
					disabled:true,
					itemStyle:{
						//color:'#ff0000'
					}
			},
            itemStyle:{
			    normal:{
					barBorderRadius:[5,5,0,0],
					//color:'rgba(255, 90, 120, 0.9)',
					color: new echarts.graphic.LinearGradient(
						0,0,0,1,
						[
							{
								offset:1 , 
								color:'rgba(0,200,230,0)'
							},
							{
								offset:0,
								color:'rgba(0,200,230,1)'
							}
						]
					),
					label:{
						show:true,
						position:'top',
						textStyle:{
							color:'rgba(0,200,230,1)',
							fontSize:12,
							fontWeight:'normal'
						}
					},
				},
			}
        },
        {
            type: 'bar',
            barWidth : 10,
			emphasis:{
				disabled:true,
			},
            itemStyle:{
			    normal:{
					barBorderRadius:[5,5,0,0],
					//color:'rgba(255,200,40,0.9)',
					color: new echarts.graphic.LinearGradient(
						0,0,0,1,
						[
							{
								offset:1 , 
								color:'rgba(20,200,50,0)'
							},
							{
								offset:0,
								color:'rgba(20,200,50,1)'
							}
						]
					),
					label:{
						show:true,
						position:'top',
						textStyle:{
							color:'rgba(20, 200, 50, 1.0)',
							fontSize:12,
							fontWeight:'normal'
						}
					}
				},
			}
        }
    ]
//	dataZoom:[{
//		type:'slider',
//		start:0,
//		end:30
//	}]
};

myChart.setOption(option);
window.onresize = myChart.resize
</script>
<script type="text/javascript">
//图片滚动
jQuery(".picslide").slide({mainCell:".pics ul",autoPage:true,effect:"leftLoop",autoPlay:true,vis:3,pnLoop:true,scroll:1});
</script>
</body>
</html>