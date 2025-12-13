<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>公安系统队伍管理系统表彰模块统计展示大屏设计方案</title>
<link href="statics/css/index.css?ver=<?php echo time() ?>" rel="stylesheet"/>
<link href="statics/css/common.css?ver=<?php echo time() ?>" rel="stylesheet"/>
<link href="statics/css/ui.css?ver=<?php echo time() ?>" rel="stylesheet"/>
<script type="text/javascript" src="statics/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="statics/js/jquery.SuperSlide.2.1.3.js"></script>
<script type="text/javascript" src="statics/js/scrollReveal.js"></script>
<script type="text/javascript" src="statics/js/echarts.js"></script>
<script type="text/javascript" src="common/time.js"></script>
<script>
$(function(){
	$('#myClock').clock();
})
</script>
</head>

<body>

<div id="main">

	<div id="header">
    	<span>公安系统队伍管理系统表彰模块统计展示</span>
        <div id="thisTime">
	        <img src="statics/images/home.png">
        	<a href="#">返回</a>
        	<img src="statics/images/clock.png">
            <?php include 'common/date.php' ?>
            <b id="myClock"></b>
        </div>
    </div>
    
	<div class="container" id="top">
    
    	<div class="topCon">
        	<div class="conTitle"><span>表彰总量统计</span></div>
        	<div class="topitem">
            	<div class="itemTitle"><span>年度累计表彰总人数</span><em>已审核通过</em></div>
                <div class="itemNum">145</div>
                <div class="itemFd green"><b>-2</b> 环比 ↓ 3.4%</div>
                
            </div>
        	<div class="topitem">
            	<div class="itemTitle"><span>本月新增表彰人数</span><em>已审核通过</em></div>
                <div class="itemNum">19</div>
                <div class="itemFd red"><b>+2</b> 环比 ↑ 8.2%</div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle"><span>民警表彰人数</span><em>已审核通过</em></div>
                <div class="itemNum">6</div>
                <div class="itemFd red">环比 ↑ 8.2%</div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle"><span>待拓展辅警表彰人数</span><em>已审核通过</em></div>
                <div class="itemNum">3</div>
                <div class="itemFd red">环比 ↑ 8.2%</div>
            </div>
        </div>
        
        <div class="topCon">
        	<div class="conTitle"><span>奖励类型分布</span></div>
            
            <!--奖励类型分布-->
            <div id="picH" style="width:100%;height:130px"></div>
            <?php include 'mod/supervisoryTypes.html' ?>
            
        </div>
        
        <div class="topCon">

        	<div class="conTitle"><span>审核进度看板</span></div>
        	<div class="topitem">
            	<div class="itemTitle">待审核表彰数</div>
                <div class="itemNum"><span style="color:#F90">24</span></div>
                <div class="itemFd keyYellow">超3天未审：6件</div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">已通过表彰数</div>
                <div class="itemNum">18</div>
                <div class="itemFd keyRed"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">已驳回表彰数</div>
                <div class="itemNum"><span style="color:#f00">4</span></div>
                <div class="itemFd keyDef"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">审核通过率</div>
                <div class="itemNum"><span style="color:#3F3">96%</span></div>
                <div class="itemFd keyDef"></div>
            </div>

        </div>
    </div>
    <div class="container" id="center">
    	
            <div id="pieCon">
                <div id="tempPieCon">
                
                    <!--同类型TOP3单位窗口-->
                    <div class="pieWin" id="pieWindow">
                        <div class="winItem">
                            <div class="winTitle">
                                <b id="winContentTitle"></b> TOP3 单位
                                <em>关闭</em>
                            </div>
                            <div class="winCon" id="winContent"></div>
                        </div>
                    </div>
                    <!--同类型TOP3单位窗口-->
                    
                    <div class="cCenter">
                    <div class="conTitle"><span>年度表彰类型占比</span></div>
                    <!--年度表彰类型占比-->
                    <div id="pieP" style="width:100%;height:200px"></div>
					<?php include 'mod/typePercentage.html' ?>
                    </div>
                    
                    <div class="cCenter" style="margin-top:10px">
                    <div class="conTitle"><span>近6个月表彰趋势</span></div>
                    <!--近6个月表彰趋势-->
                    <div id="lineP" style="width:100%;height:200px"></div>
                    <?php include 'mod/lastSixMonths.html' ?>
                    </div>
                    
                </div>
            </div>
            <div class="lineBox">
            	<div class="cCenter">
                <div class="conTitle"><span>各单位表彰人数统计</span></div>
                <!--各单位表彰人数统计-->
                <div class="lineCon" id="barChart"></div>
                <?php include 'mod/rankingIncidents.html' ?>
                </div>
                
            	<div class="cCenter" style="margin-top:10px">
                <div class="conTitle"><span>单位表彰覆盖率</span></div>
                <!--单位表彰覆盖率-->
                <div class="lineCon" id="daChart">
				<?php include 'mod/rateRecognition.html' ?>
                </div>
                
                </div>
                
            </div>
            <div class="highrisk">
            
            	<div class="cCenter" style="width:49%;margin-right:2%">
                <div class="conTitle"><span>表彰人员政治面貌分布</span></div>
            
            	<!--表彰人员政治面貌分布-->
                <div class="highCon" id="hDon"></div>
                <?php include 'mod/highPie.html' ?>
                </div>
                
				<div class="cCenter" style="width:49%">
                <div class="conTitle"><span>表彰人员职级分布</span></div>
            	<!--表彰人员职级分布-->
                <div class="highCon" id="level"></div>
                <?php include 'mod/levelBar.html' ?>
                </div>
                
                <!--重点表彰人员卡片 轮播-->
                <div class="highDon">
                	<div class="cCenter" style="margin-top:10px">
                    <div class="conTitle"><span>重点表彰人员</span></div>
                    
                    <div id="slider" class="superslider">
                        <div class="bd">
                            <ul class="picList">
                            	<li>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td><span>姓名：</span>张三</td>
                                            <td><em class="thisGood">√</em>证明材料齐全</td>
                                        </tr>
                                        <tr><td colspan="2"><span>单位：</span>治安大队</td></tr>
                                        <tr><td colspan="2"><span>称号：</span>微笑之星</td></tr>
                                        <tr><td colspan="2"><span>事迹：</span>参警以来一直就职于基层派出所户籍窗口,多年来坚持为人民群众热情服务</td></tr>
                                    </table>
                                </li>
                            	<li>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td><span>姓名：</span>张三</td>
                                            <td><em class="lack">!</em>材料待补</td>
                                        </tr>
                                        <tr><td colspan="2"><span>单位：</span>治安大队</td></tr>
                                        <tr><td colspan="2"><span>称号：</span>微笑之星</td></tr>
                                        <tr><td colspan="2"><span>事迹：</span>司法机关审查中</td></tr>
                                    </table>
                                </li>
                            	<li>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td><span>姓名：</span>张三</td>
                                            <td><em class="thisGood">√</em>证明材料齐全</td>
                                        </tr>
                                        <tr><td colspan="2"><span>单位：</span>治安大队</td></tr>
                                        <tr><td colspan="2"><span>称号：</span>微笑之星</td></tr>
                                        <tr><td colspan="2"><span>事迹：</span>司法机关审查中</td></tr>
                                    </table>
                                </li>
                            </ul>
                        </div>
                    </div>

					<script>
                        jQuery("#slider").slide({mainCell:".bd ul",autoPage:true,effect:"leftLoop",autoPlay:true,vis:3,pnLoop:true});
                    </script>
                </div>
                </div>
                
            </div>
       
    </div>
    <div class="container" id="bottom">
    
    	<div class="bLeft">
        	<div class="conTitle"><span>待审核表彰清单</span></div>
            <table width="98%" cellspacing="0" cellpadding="0" class="fjList">
                <thead>
                    <tr>
                        <th width="150">单位名称</th>
                        <th>表彰对象</th>
                        <th width="100">奖励类型</th>
                        <th>上报时间</th>
                        <th width="80">待审天数</th>
                        <th>操作提示</th>
                    </tr>
                </thead>
                <tbody>
                	<tr>
                        <td>治安大队</td>
                        <td>王五 警号:gx10130035</td>
                        <td>嘉奖</td>
                        <td>2025-09-30  </td>
                        <td class="exceedTimes">8</td>
                        <td><a href="#">点击审核</a></td>
                    </tr>
                	<?php for($j=0;$j<4;$j++) { ?>
                	<tr>
                        <td>治安大队</td>
                        <td>王五 警号:gx10130035</td>
                        <td>嘉奖</td>
                        <td>2025-09-30  </td>
                        <td align="center">3</td>
                        <td><a href="#">点击审核</a></td>
                    </tr>
                    <?php } ?>
                	<tr>
                        <td>治安大队</td>
                        <td>王五 警号:gx10130035</td>
                        <td>嘉奖</td>
                        <td>2025-09-30  </td>
                        <td class="exceedTime">5</td>
                        <td><a href="#">点击审核</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="bRight">
            <div class="bRcon" style="width:48%;margin-right:2%">
            	<div class="conTitle"><span>材料缺失统计</span></div>
                
                <!--材料缺失统计-->
				<div id="cMiss"></div>
                <?php include 'mod/materialMissing.html' ?>
                
            </div>
            <div class="bRcon">
				<div class="conTitle"><span>驳回原因分析</span></div>
                <!--驳回原因分析-->
				<div id="rPie"></div>
                <?php include 'mod/reasonPie.html' ?>
                
            </div>
        </div>

    </div>
</div>
<video autoplay="autoplay" loop="loop" muted="muted" class="video-background" id="styleVideo">
<source src="statics/images/bg.mp4" type="video/mp4">
Your browser does not support the video tag.
</video>
</body>
</html>