<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>安系统队伍管理系统监督模块统计</title>
<link href="statics/css/index.css?ver=<?php echo time() ?>" rel="stylesheet"/>
<link href="statics/css/common.css?ver=<?php echo time() ?>" rel="stylesheet"/>
<link href="statics/css/window.css?ver=<?php echo time() ?>" rel="stylesheet"/>
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

	<!--<div id="header">公安系统队伍管理系统监督模块统计展示大屏设计方案</div>-->
    
	<div id="header">
    	<span>公安系统队伍管理系统监督模块统计展示</span>
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
        	<div class="conTitle"><span>监督事件总量</span></div>
        	<div class="topitem">
            	<div class="itemTitle">年度累计监督事件数</div>
                <div class="itemNum">12,845</div>
                <div class="itemFd green">环比 ↓ 3.4%</div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">本月新增事件数</div>
                <div class="itemNum">956</div>
                <div class="itemFd red">环比 ↑ 8.2%</div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">已办结事件数</div>
                <div class="itemNum">10,328</div>
                <div class="itemFd red">环比 ↑ 8.2%</div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">待处理事件数</div>
                <div class="itemNum">2,517</div>
                <div class="itemFd red">环比 ↑ 8.2%</div>
            </div>
        </div>
        
        <div class="topCon">
        	<div class="conTitle"><span>监督类型分布</span></div>
            <div id="picH" style="width:100%;height:205px"></div>
            <!--监督类型分布-->
            <?php include 'mod/supervisoryTypes.html' ?>
        </div>
        
        <div class="topCon">

        	<div class="conTitle"><span>高风险事件预警</span></div>
        	<div class="topitem">
            	<div class="itemTitle">移送司法机关案件数</div>
                <div class="itemNum">24</div>
                <div class="itemFd keyRed">需要重点关注</div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">重大舆情事件数</div>
                <div class="itemNum">18</div>
                <div class="itemFd keyRed">需要重点关注</div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">问责事件数</div>
                <div class="itemNum">76</div>
                <div class="itemFd keyDef">常规关注</div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">通报曝光事件数</div>
                <div class="itemNum">32</div>
                <div class="itemFd keyDef">常规关注</div>
            </div>

        </div>
    </div>
    <div class="container" id="center">
    	
            <div id="pieCon">
                <div id="tempPieCon">
                    <!--违纪违规TOP3窗口-->
                    <div class="pieWin" id="pieWindow">
                        <div class="winItem">
                            <div class="winTitle">
                                <b id="winContentTitle"></b>违纪/违规TOP3
                                <em>关闭</em>
                            </div>
                            <div class="winCon" id="winContent"></div>
                        </div>
                    </div>
                    <!--违纪违规TOP3窗口-->
                    <div class="cCenter" style="margin-bottom:10px">
                    <div class="conTitle"><span>年度监督事件类型占比</span></div>
                    <div id="pieP" style="width:100%;height:200px"></div>
                    <!--年度监督事件类型占比-->
                    <?php include 'mod/typePercentage.html' ?>
                    </div>
                    
                    <div class="cCenter">
                    <div class="conTitle"><span>近6个月监督事件趋势</span></div>
                    <div id="lineP" style="width:100%;height:200px"></div>
                    <!--近6个月监督事件趋势-->
                    <?php include 'mod/lastSixMonths.html' ?>
                    </div>
                    
                </div>
            </div>
            <div class="lineBox">
            	<div class="cCenter">
                <div class="conTitle"><span>各一级单位监督事件数量排名</span></div>
                <div class="lineCon" id="barChart"></div>
                <!--各一级单位监督事件数量排名-->
                <?php include 'mod/rankingIncidents.html' ?>
                </div>
                
                <div class="cCenter" style="margin-top:10px">
                <div class="conTitle"><span>年度监督事件类型占比</span></div>
                <div class="lineCon" id="daChart"></div>
                <!--年度监督事件类型占比-->
                <?php include 'mod/processingEfficiency.html' ?>
                </div>
                
            </div>
            <div class="highrisk">
            
                <div class="cCenter" style="width:48%;margin-right:2%">
                <div class="conTitle"><span>执法办案违纪行为分布</span></div>
                <div class="highCon" id="hDon"></div>
                <!--执法办案违纪行为分布-->
                <?php include 'mod/highPie.html' ?>
                </div>
                
                <div class="cCenter" style="width:50%">
                <div class="conTitle"><span>舆情事件级别与处理结果分布</span></div>
                <div class="highCon" id="level"></div>
                <!--舆情事件级别与处理结果分布-->
                <?php include 'mod/levelBar.html' ?>
                </div>
                
                
                <div class="highDon">
                	<div class="cCenter" style="margin-top:10px">
                    <div class="conTitle"><span>现场/网上督察违纪类型 TOP3</span></div>
                    <div class="hditem">
                        <div class="hdTitle">违纪类型：警容风纪不规范</div>
                        <div class="hdTitle">涉及人数：45</div>
                        <div class="hdTitle">主要发生单位：治安大队、网安大队、巡特警支队</div>
                        <div class="hdTitle">整改意见加强学习，提高自身素质。不断提高自身的政治和思想文化素质。</div>
                    </div>
                    <div class="hditem">
                        <div class="hdTitle">违纪类型：警容风纪不规范</div>
                        <div class="hdTitle">涉及人数：45</div>
                        <div class="hdTitle">主要发生单位：治安大队、网安大队、巡特警支队</div>
                        <div class="hdTitle">整改意见加强学习，提高自身素质。不断提高自身的政治和思想文化素质。</div>
                    </div>
                    <div class="hditem">
                        <div class="hdTitle">违纪类型：警容风纪不规范</div>
                        <div class="hdTitle">涉及人数：45</div>
                        <div class="hdTitle">主要发生单位：治安大队、网安大队、巡特警支队</div>
                        <div class="hdTitle">整改意见加强学习，提高自身素质。不断提高自身的政治和思想文化素质。</div>
                    </div>
                </div>
                </div>
            </div>
       
    </div>
    <div class="container" id="bottom">
    
    	<div class="bLeft">
        	<div class="conTitle"><span>待处理监督事件清单</span></div>
            <table width="98%" cellspacing="0" cellpadding="0" class="fjList">
                <thead>
                    <tr>
                        <th width="150px">单位名称</th>
                        <th>监督类型</th>
                        <th width="300px">事件标题</th>
                        <th>发生时间</th>
                        <th>待处理天数</th>
                        <th>操作提示</th>
                    </tr>
                </thead>
                <tbody>
                	<?php for($j=0;$j<3;$j++) { ?>
                	<tr style="color:#f00">
                        <td>治安大队</td>
                        <td>现场/网上督察违纪</td>
                        <td>暴力执法</td>
                        <td>2025-09-30  </td>
                        <td>20</td>
                        <td><a href="#">点击查看详情</a> / <a href="#">分配处理人</a></td>
                    </tr>
                    <?php } ?>
                	<tr style="background:rgba(255,255,0,0.5);color:#fff">
                        <td>治安大队</td>
                        <td>现场/网上督察违纪</td>
                        <td>暴力执法</td>
                        <td>2025-09-30  </td>
                        <td>5</td>
                        <td><a href="#">点击查看详情</a> / <a href="#">分配处理人</a></td>
                    </tr>
                	<tr style="background:rgba(255,255,0,0.5);color:#fff">
                        <td>治安大队</td>
                        <td>现场/网上督察违纪</td>
                        <td>暴力执法</td>
                        <td>2025-09-30  </td>
                        <td>5</td>
                        <td><a href="#">点击查看详情</a> / <a href="#">分配处理人</a></td>
                    </tr>
                	<tr style="background:#491804;color:#fff">
                        <td>治安大队</td>
                        <td>现场/网上督察违纪</td>
                        <td>暴力执法</td>
                        <td>2025-09-30  </td>
                        <td>8</td>
                        <td><a href="#">点击查看详情</a> / <a href="#">分配处理人</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="bRight">
           
            <div class="bRcon">
            	<div class="conTitle"><span>移送司法/重大舆情</span></div>
                <!-- 轮播容器 -->
                <div id="slider" class="superslider">
                	<div class="bd">
                    	<ul class="picList">
                            <!-- 第一张卡片 -->
                            <li>
                            	<table width="96%" cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                    	<td><span>事件类型：</span>重大安全事故</td>
                                        <td bgcolor="#cc0000" align="center">高风险</td>
                                    </tr>
                                    <tr><td colspan="2"><span>涉及单位：</span>治安大队、网安大队3333</td></tr>
                                    <tr><td colspan="2"><span>发生时间：</span>2023-10-15 09:23</td></tr>
                                    <tr><td colspan="2"><span>处理阶段：</span>司法机关审查中</td></tr>
                                    <tr><td colspan="2"><span>责任人：</span>张明</td></tr>
                                    <tr><td colspan="2"><span>联系方式：</span>13800138000</td></tr>
                                </table>
                            	<table width="96%" cellpadding="0" cellspacing="0" border="0">
                               	  <tr><td><span>预计办结时间：</span>2023-11-15  逾期</td></tr>
                              </table>
                      </li>
                            <!-- 第二张卡片 -->
                            <li>
                            	<table width="96%" cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                    	<td><span>事件类型：</span>重大安全事故</td>
                                        <td bgcolor="#cc0000" align="center">高风险</td>
                                    </tr>
                                    <tr><td colspan="2"><span>涉及单位：</span>治安大队、网安大队</td></tr>
                                    <tr><td colspan="2"><span>发生时间：</span>2023-10-15 09:23</td></tr>
                                    <tr><td colspan="2"><span>处理阶段：</span>司法机关审查中</td></tr>
                                    <tr><td colspan="2"><span>责任人：</span>张明</td></tr>
                                    <tr><td colspan="2"><span>联系方式：</span>13800138000</td></tr>
                                </table>
                            	<table width="96%" cellpadding="0" cellspacing="0" border="0">
                                	<tr><td><span>预计办结时间：</span>2023-11-15  逾期</td></tr>
                                </table>
                          </li>
						</ul>
                    </div>
                    <a class="prev"></a>
                    <a chass="next"></a>
                </div>
            
            </div>
            <div class="bRcon" style="width:48%;margin-left:2%">
				<div class="conTitle"><span>信访事件办结率监控</span></div>
                <div class="drawLine">
                    <div class="completion-card">
                
                        <!-- 1. 总办结率（92% ≥90% → 绿色） -->
                        <div class="rate-item">
                            <div class="rate-header">
                                <div class="rate-name">总办结率</div>
                                <div class="rate-value">92%</div>
                            </div>
                            <div class="progress-bg">
                                <div class="progress-bar progress-green" style="width: 92%;"></div>
                            </div>
                            <div class="reader">未办结信访主要来源：XX（如'12345 热线转办'）</div>
                        </div>
                
                        <!-- 2. 网上办结率（83% 70%-90% → 黄色） -->
                        <div class="rate-item">
                            <div class="rate-header">
                                <div class="rate-name">网上信访办结率</div>
                                <div class="rate-value">83%</div>
                            </div>
                            <div class="progress-bg">
                                <div class="progress-bar progress-yellow" style="width: 83%;"></div>
                            </div>
                            <div class="reader">未办结信访主要来源：XX（如'12345 热线转办'）</div>
                        </div>
                
                        <!-- 3. 来访办结率（65% <70% → 红色） -->
                        <div class="rate-item">
                            <div class="rate-header">
                                <div class="rate-name">来访信访办结率</div>
                                <div class="rate-value">65%</div>
                            </div>
                            <div class="progress-bg">
                                <div class="progress-bar progress-red" style="width: 65%;"></div>
                            </div>
                            <div class="reader">未办结信访主要来源：XX（如'12345 热线转办'）</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
        	jQuery("#slider").slide({mainCell:".bd ul",autoPage:true,effect:"leftLoop",autoPlay:true,vis:1,pnLoop:true});
        </script>
        
    </div>
    

    
</div>
<video autoplay="autoplay" loop="loop" muted="muted" class="video-background" id="styleVideo">
<source src="statics/images/bg.mp4" type="video/mp4">
Your browser does not support the video tag.
</video>
</body>


</html>