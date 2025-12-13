<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>公安系统队伍管理系统党建子系统统计展示大屏设计方案</title>
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
    	<span>公安系统队伍管理系统党建子系统统计展示</span>
        <div id="thisTime">
	        <img src="statics/images/home.png">
        	<a href="#">返回</a>
        	<img src="statics/images/clock.png">
            <?php include 'common/date.php' ?>
            <b id="myClock"></b>
        </div>
    </div>
	<div class="container" id="top">
    
    	<!--党组织规模统计-->
    	<div class="topCon">
        	<div class="conTitle"><span>党组织规模统计</span></div>
        	<div class="topitem">
            	<div class="itemTitle">启用党组织总数</div>
                <div class="itemNum">12,845</div>
                <div class="itemFd green"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">党委班子成员数</div>
                <div class="itemNum">956</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">基层党支部数</div>
                <div class="itemNum">10,328</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">党组织覆盖率(启用数/应建数)</div>
                <div class="itemNum" style="color:#FC3">80%</div>
                <div class="itemFd red">80/100</div>
            </div>
        </div>
        
        <!--党员队伍规模-->
    	<div class="topCon">
        	<div class="conTitle"><span>党员队伍规模</span></div>
            <div id="partyCon">
                <div class="partyitem">
                    <div class="itemTitle">全局党员总人数</div>
                    <div class="itemNum">12,845</div>
                    <div class="itemFd green"></div>
                </div>
                <div class="partyitem">
                    <div class="itemTitle">年度新增党员数</div>
                    <div class="itemNum">956</div>
                    <div class="itemFd red">+33  较上月+5%</div>
                </div>
                <div class="partyitem">
                    <div class="itemTitle">党员占全局警力比例</div>
                    <div class="itemNum">82.35%</div>
                    <div class="itemFd red"></div>
                </div>
            </div>
            
            <!--党员队伍规模/人员类型分布-->
            <div id="partyPie"></div>
			<?php include 'mod/familyPie.html' ?>
            
        </div>
        
        <!--党费收缴进度-->
    	<div class="topCon">
        	<div class="conTitle"><span>党费收缴进度</span></div>
        	<div class="duesitem">
            	<div class="itemTitle">本月应交党费总人数</div>
                <div class="itemNum">12,845</div>
                <div class="itemFd green"></div>
            </div>
        	<div class="duesitem">
            	<div class="itemTitle">已缴人数</div>
                <div class="itemNum">956</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="duesitem">
            	<div class="itemTitle">收缴率</div>
                <div class="itemNum">97.33%</div>
                <div class="itemFd red"></div>
            </div>
            
            <!--欠缴人员数-->
            <div id="partyDues"></div>
			<?php include 'mod/supervisoryTypes.html' ?>
            
        </div>

        
        <!--组织生活完成率-->
    	<div class="topCon">
        	<div class="conTitle"><span>组织生活完成率</span></div>
            <div id="partyCon">
            
                <div class="partyitem">
                    <div class="itemTitle">本月应开展组织生活次数</div>
                    <div class="itemNum">12,845</div>
                    <div class="itemFd green"></div>
                </div>
                <div class="partyitem">
                    <div class="itemTitle">已开展次数</div>
                    <div class="itemNum">956</div>
                    <div class="itemFd red"></div>
                </div>
                <div class="partyitem">
                    <div class="itemTitle">完成率</div>
                    <div class="itemNum">88.89%</div>
                    <div class="itemFd red"></div>
                </div>
            </div>
            
            <!--已开展次数-->
            <div id="pieCons">
            	<div style="font-size:14px;font-weight:900;color:#eee;margin-left:10px;margin-top:4px">已开展次数</div>
                <div class="tabs">
                	<a href="javascript:void(0)" id="tab_a" class="on">分局党委</a>
                    <a href="javascript:void(0)" id="tab_b">分局基层党支部</a>
                </div>
                
                <!--分局党委-->
	            <div id="lifePie" style="display:block"></div>
                <?php include 'mod/partyPie.html' ?>
                
                <!--分局基层党支部-->
                <div id="lifePieT" style="display:none"></div>
                <?php include 'mod/partyPieT.html' ?>
            </div>
            
            <script>
				//已开展次数 分局党委/分局基层党支队 tab切换
            	$(function(){
					$("#tab_a").click(function(){
						$(this).addClass('on');
						$("#tab_b").removeClass('on');
						$("#lifePieT").hide();
						$("#lifePie").show();
					})
					$("#tab_b").click(function(){
						$(this).addClass('on');
						$("#tab_a").removeClass('on');
						$("#lifePieT").show();
						$("#lifePie").hide();
					})
				})
            </script>
            
        </div>
        
    </div>
    <div class="container" id="center">
    		
            <div id="pieCon">
            	<div class="cCenter">
	            	<div class="conTitle"><span>党员人员类型与政治面貌分布</span></div>
                
                	<!--党员人员类型与政治面貌分布/人员类型-->
                    <div id="pieX" style="width:47%;height:200px;float:left;margin:2% 0 0 2%"></div>
                    <?php include 'mod/partyX.html' ?>
                    
                    <!--党员人员类型与政治面貌分布/政治面貌-->
                    <div id="pieY" style="width:47%;height:200px;float:left;margin:2% 0 0 2%"></div>
                    <?php include 'mod/partyY.html' ?>
                </div>
                <div class="cCenter" style="margin-top:10px">
                    <!--党员年龄与学历分布-->
                    <div class="conTitle"><span>政治面貌</span></div>
                    <div id="lineZ" style="width:100%;height:180px;float:left"></div>
                    <?php include 'mod/partyZ.html' ?>
                </div>
            </div>
            <div class="lineBox">
	            <div class="lineCon">
                	<!--年度组织生活类型占比
                    <div id="lifeType" style="width:45%;height:240px;float:left"></div>
                    <?php include 'mod/partyS.html' ?>
                    -->
                    
                    <!--近6个月组织生活开展趋势-->
                    <div class="cCenter">
                    <div class="conTitle"><span>近6个月组织生活开展趋势</span></div>
                    <div id="sixMonthLife" style="width:100%;height:210px;float:left"></div>
                    <?php include 'mod/lastSixMonths.html' ?>
                    </div>
                    
                    <div  class="cCenter" style="width:100%;height:215px;float:left;margin-top:10px">
                    	<div class="conTitle">党建品牌 党建+</div>
                        
                        <!--党建品牌数据模块-->
                        <div class="partyCon">
                            <div id="partyPay">
                                <div class="partyitem">
                                    <div class="itemTitle">民警警务技能基本级达标率</div>
                                    <div class="itemNum">100%</div>
                                    <div class="itemFd green"></div>
                                </div>
                                <div class="partyitem">
                                    <div class="itemTitle">民警警务技能中级达标率</div>
                                    <div class="itemNum">53%</div>
                                    <div class="itemFd red"></div>
                                </div>
                                <div class="partyitem">
                                    <div class="itemTitle">培训覆盖民警人数</div>
                                    <div class="itemNum">1510</div>
                                    <div class="itemFd red"></div>
                                </div>
                            </div>
                        <!--党建品牌培训饼图-->
                        <div id="partyEduPie"></div>
                        <?php include 'mod/familyEduPie.html' ?>


                        </div>
                        

                        
                        
                    </div>
                    
                </div>
                
                <!--党委班子核心工作完成情况
                <div class="lineCon" id="daChart"></div>
                <?php include 'mod/processingEfficiency.html' ?>
                -->
                
            </div>
            <div class="highrisk">
            	 <!--各党支部 "三会一课" 完成率排名-->
                 <div class="cCenter">
                 <div class="conTitle"><span>各党支部 "三会一课" 完成率排名</span></div>
            	 <div id="lineT" style="width:100%;height:210px;float:left"></div>
                 <?php include 'mod/threeOne.html' ?>
                 </div>
                 
                 
                 <!--党内表彰与惩处分布-->
                 <div class="cCenter" style="width:100%;height:215px;float:left;margin-top:10px">
                 	<div class="conTitle"><span>党建表彰与惩处情况对比</span></div>
                     <div id="lineB" style="width:75%;height:200px;float:left"></div>
                     <?php include 'mod/commendationPunishment.html' ?>
                     
                      <div id="partyJs">
                          <div class="partyitem">
                              <div class="itemTitle">累计表扬人数</div>
                              <div class="itemNum">570</div>
                              <div class="itemFd green"></div>
                          </div>
                          <div class="partyitem">
                              <div class="itemTitle">累计警示人数</div>
                              <div class="itemNum">60</div>
                              <div class="itemFd red"></div>
                          </div>
                          <div class="partyitem">
                              <div class="itemTitle">累计告诫人数</div>
                              <div class="itemNum">35</div>
                              <div class="itemFd red"></div>
                          </div>
                      </div>
                  </div>
                 
                 <!--
                 <div id="lineC" style="width:45%;height:240px;float:left">
                 	<div class="conTitle">"四下基层" 工作成效</div>
                    
                    <div style="width:100%">
                        <div class="topitem">
                            <div class="itemTitle">累计解决问题数</div>
                            <div class="itemNum">12,845</div>
                            <div class="itemFd green"></div>
                        </div>
                        <div class="topitem" style="background:#1d1e72">
                            <div class="itemTitle">累计服务群众数</div>
                            <div class="itemNum">956</div>
                            <div class="itemFd red"></div>
                        </div> -->
                        
                        <!--近3个月服务数据趋势-->
                        <!--<div id="topTable" style="width:100%;height:140px"></div>
                        <?php //include 'mod/lastThreeMonths.html' ?>
                        
                    </div>
                    
                 </div>-->
                
            </div>
      
    </div>
    <div class="container" id="bottom">
    

        
        <div class="bRight">
            <!--<div class="conTitle">重点党建工作进展监控</div>-->
            <div class="bRcon">
            	
                
            	<div id="familyPie">
                	
                	<div id="dataCardCon">
	                    <div class="conTitle"><span>警示教育与主题党日开展情况</span></div>
                        <div class="itemCard">
                            <div class="itemTitle">年度警示教育开展次数</div>
                            <div class="itemNumS">956</div>
                            <div class="itemFdS red">+33  较上月+5%</div>
                        </div>
                        <div class="itemCard">
                            <div class="itemTitle">主题党日参与率（参与人数 / 应参与人数）</div>
                            <div class="itemNumS">82.35%</div>
                            <div class="itemFdS red">1000 / 1056</div>
                        </div>
                    </div>
                    
                    <!--警示教育与主题党日开展情况 饼图-->
                    <div id="eduCon">
	                    <div class="conTitle"><span>主题党日类型占比</span></div>
						<div id="eduPie"></div>
                        <?php include 'mod/eduPie.html' ?>
                    </div>
                    
                    
                    <!--本月政治生日-->
                    <div id="partyBirthday">
                    	<div class="conTitle"><span>本月政治生日人员</span></div>
                        <div id="pbPie"></div>
                        <?php include 'mod/pbPie.html' ?>
                    </div>
                    
                    <!--党建工作提示-->
                    <div id="partyTip">
                    	<div class="conTitle"><span>党建工作提示</span></div>
                        <table width="98%" cellspacing="0" cellpadding="0" class="tipList">
                            <tbody>
                                <tr><td><a href="#"><b>2025-10-22</b> 各支部本周内完成'我为群众办实事'项目台账更新</a></td></tr>
                                <tr><td><a href="#"><b>2025-10-21</b> 党员同志按时缴纳6月份党费，避免逾期</a></td></tr>
                                <tr><td><a href="#"><b>2025-10-21</b> 党员同志按时缴纳5月份党费，避免逾期</a></td></tr>
                                <tr><td><a href="#"><b>2025-10-20</b> 发展党员流程中，需在考察期结束后10日内召开支部会议</a></td></tr>
                             </tbody>
                        </table>
                    </div>
                    
                </div>
                
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