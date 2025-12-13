<?php
defined('IN_ADMIN') or exit('No permission resources.');
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';

/*
$this->db->table_name = 'v9_xuanchuan_sucai';
$tjrs = $this->db->get_one(" isok=1 and dbtype='素材' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_sczs= $tjrs['hj'];

$tjrs = $this->db->get_one(" isok=1 and dbtype='稿件' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_gaozs= $tjrs['hj'];


$_bennian=date("Y");
$_benyue=date("m");
$_benweek=date("w");
/// 已发表
$tjrs = $this->db->get_one(" isok=1 and caiyong='已发表' and ns=$_bennian ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_fbzs= $tjrs['hj'];
/// 已采
$tjrs = $this->db->get_one(" isok=1 and caiyong='已采纳' and ms=$_benyue ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_cyzs= $tjrs['hj'];
/// 未
$tjrs = $this->db->get_one(" isok=1 and caiyong='未采纳' and ws=$_benweek ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_wczs= $tjrs['hj'];

//国家
$tjrs = $this->db->get_one(" isok=1 and mtjibie='国家级' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_gjzs= $tjrs['hj'];
//省级
$tjrs = $this->db->get_one(" isok=1 and mtjibie='省（部）级' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_sbzs= $tjrs['hj'];
//市级
$tjrs = $this->db->get_one(" isok=1 and mtjibie='市级' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_shizs= $tjrs['hj'];
//市局
$tjrs = $this->db->get_one(" isok=1 and mtjibie='市局内部' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_sjzs= $tjrs['hj'];
//本局
$tjrs = $this->db->get_one(" isok=1 and mtjibie='分局内部' ",'count(*) as hj');
if($tjrs['hj']>0){$tjrs['hj']+=1;}
$_bjzs= $tjrs['hj'];

*/
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
		['minjingrenshu', <?php echo $_sczs?>],        // 民警人数
		['fujingrenshu', <?php echo $_gaozs?>],          // 辅警人数
		['shishikaoqin', <?php echo $_fbzs?>],          // 实时考勤
		['xiujiarenshu ', <?php echo $_cyzs?>],          // 休假人数
		['gerenshixiangtianbao', <?php echo $_wczs?>], // 个人事项同填报
		['benyuebiaozhang', <?php echo $_gjzs?>],        // 本月表彰人数
		['wenmingbiaobing', <?php echo $_sbzs?>],       // 文明标兵
		['weixiaozhixing', <?php echo $_shizs?>],        // 微笑之星
		['youxiuwanggeyuan', <?php echo $_sjzs?>],       // 优秀网格员
		['benyuetongbaorenshu', <?php echo $_bjzs?>]     // 本月通报人数
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
.modEcharts {width:calc( 100% - 30px ); height:calc( 100vh - 50vh );  margin:0 30px 0 0}
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
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">党员数量</div>
                        <div class="DataItemNumber" id="minjingrenshu">0</div>
                    </div>
                </div>
                <!--辅警人数-->
            	<div class="DataItem" data-scroll-reveal="enter right">
                	<div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                    	<img src="statics/images/admin_img/2025/rs03.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">预备党员</div>
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
                        <div class="DataItemName">入党积极分子</div>
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
                        <div class="DataItemName">政治生日</div>
                        <div class="DataItemNumber" id="xiujiarenshu">0</div>
                    </div>
                </div>
                <!--个人事项填报-->
            	<div class="DataItem" data-scroll-reveal="enter right">
                	<div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                    	<img src="statics/images/admin_img/2025/rs03.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">党费缴纳</div>
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
                        <div class="DataItemName">专项工作</div>
                        <div class="DataItemNumber" id="benyuebiaozhang">0</div>
                    </div>
                </div>
                
                <!--文明标兵-->
                <div class="DataHonour" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/bz01.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">谈心谈话</div>
                        <div class="DataItemNumber" id="wenmingbiaobing">0</div>
                    </div>
                </div>
                
                <!--微笑之星-->
                <div class="DataHonour" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/bz01.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">党课</div>
                        <div class="DataItemNumber" id="weixiaozhixing">0</div>
                    </div>
                </div>
                
                <!--优秀网格警员-->
                <div class="DataHonour" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/bz01.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">组织生活会</div>
                        <div class="DataItemNumber" id="youxiuwanggeyuan">0</div>
                    </div>
                </div>
                
                <!--本月通报人数-->
                <div class="DataHonour" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/bz01.png">
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">“一岗双责”</div>
                        <div class="DataItemNumber" id="benyuetongbaorenshu">0</div>
                    </div>
                </div>
    
            </div>
        
        </div>
        <!--表彰督导模块-->
        
        <div class="modItemContent">
	        <div class="modEcharts" data-scroll-reveal="enter left" id="buMen"></div>
            <div class="modEchartsPie" data-scroll-reveal="enter right" style="display:none">稿件同环比</div>
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
<!---柱图-->
<script>
//各部门任务状态
<?php
	    $this->db->table_name = 'mj_xuanchuan_sucai';
		$rss = $this->db->select("isok=1 and shenhe=1 ",'count(zzdwid) as hj,zzdwid','','','zzdwid');	
		foreach($rss as $aaa){
			$zt[$aaa['zzdwid']][]=$aaa['hj'];
			}			 
        
		// 
	    $this->db->table_name = 'mj_xuanchuan_sucai';
		$rss = $this->db->select("isok=1 and shenhe=1 and caiyong='已发表' ",'count(zzdwid) as hj,zzdwid','','','zzdwid');	
		foreach($rss as $aaa){
			$zt[$aaa['zzdwid']][1]=$aaa['hj'];
			}		 
  

?>
var myChart = echarts.init(document.getElementById('buMen'));
option = {
    //backgroundColor: 'rgba(255, 255, 255, 0)',
	title:{
		text:'稿件情况',
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
            ['product', '上报量', '发表量','国家级','省部级'],
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
</body>
</html>