<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>公安系统队伍管理系统人事模块统计展示大屏设计方案</title>
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
<style>
/*body {transform: scale(1,1);overflow-x:hidden}*/
</style>
</head>

<body>

<div id="main">

	<div id="header">
    	<span>公安系统队伍管理系统人事模块统计展示</span>
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
        	<div class="conTitle"><span>总警力规模</span></div>
        	<div class="topitem">
            	<div class="itemTitle">全局在职总人数</div>
                <div class="itemNum">12,845</div>
                <div class="itemFd green"></div>
            </div>
        	<div class="topitem" style="background:#06c">
            	<div class="itemTitle">民警人数（区分）</div>
                <div class="itemNum">956</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="topitem" style="background:#f60">
            	<div class="itemTitle">辅警人数（区分）</div>
                <div class="itemNum">10,328</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">本月新增/减少人数</div>
                <div class="itemNum">2,517</div>
                <div class="itemFd red"></div>
            </div>
            
            <!--近3个月人数趋势图-->
            <div id="topTable"></div>
            <?php include 'mod/lastThreeMonths.html' ?>
            
        </div>
        
        <div class="topCon">
        	<div class="conTitle"><span>组织架构覆盖</span></div>
            <div class="zCon">
            	<div class="zConTitle">行政组织架构</div>
                <div class="topitem">
                    <div class="itemTitle">一级单位数量</div>
                    <div class="itemNum">12,845</div>
                    <div class="itemFd green"></div>
                </div>
                <div class="topitem">
                    <div class="itemTitle">二级单位数量</div>
                    <div class="itemNum">12,845</div>
                    <div class="itemFd green"></div>
                </div>
                <div class="topitem">
                    <div class="itemTitle">党组织覆盖单位数</div>
                    <div class="itemNum">12,845</div>
                    <div class="itemFd green"></div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="zCon">
            	<div class="zConTitle">党组织架构</div>
                <div class="topitem">
                    <div class="itemTitle">一级单位数量</div>
                    <div class="itemNum">12,845</div>
                    <div class="itemFd green"></div>
                </div>
                <div class="topitem">
                    <div class="itemTitle">二级单位数量</div>
                    <div class="itemNum">12,845</div>
                    <div class="itemFd green"></div>
                </div>
                <div class="topitem">
                    <div class="itemTitle">党组织覆盖单位数</div>
                    <div class="itemNum">12,845</div>
                    <div class="itemFd green"></div>
                </div>
            </div>
        </div>
        
        <div class="topCon" id="sx">

        	<div class="conTitle"><span>事项上报进度</span></div>
        	<div class="topitem">
            	<div class="itemTitle">本月需上报事项总数</div>
                <div class="itemNum">24</div>
                <div class="itemFd keyRed"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">已完成上报数</div>
                <div class="itemNum">18</div>
                <div class="itemFd keyRed"></div>
            </div>
        	<div class="topitem" style="background:#C93">
            	<div class="itemTitle">待审核数</div>
                <div class="itemNum">76</div>
                <div class="itemFd keyDef"></div>
            </div>
        	<div class="topitem" style="background:#093">
            	<div class="itemTitle">审核通过率</div>
                <div class="itemNum">96.01%</div>
                <div class="itemFd keyDef"></div>
            </div>

        </div>
    </div>
    <div class="container" id="center">
    		
            <div id="pieCon">
            		<div class="cCenter">
                        <div class="conTitle"><span>在职人员性别 / 学历 / 政治面貌分布</span></div>
                        <!--人员性别分布-->
                        <div class="pieC" id="pieX"></div>
                        <?php include 'mod/sexDistribution.html' ?>
                        
                        
                        <!--人员学历分布-->
                        <div class="pieC" id="pieY"></div>
                        <?php include 'mod/eduDistribution.html' ?>
                        
                        <!--人员政治面貌分布-->
                        <div class="pieC" id="pieZ"></div>
                        <?php include 'mod/polDistribution.html' ?>
                    
                    </div>
                    
                    <div class="cCenter" style="margin-top:10px">
                    <div class="conTitle"><span>民辅警用工性质 & 来源分布</span></div>
                    <!--民辅警用工性质 & 来源分布-->
                    <div id="lineZ" style="width:100%;height:170px;float:left"></div>
                    <?php include 'mod/levelBar.html' ?>
                    </div>

            </div>
            
            <div class="lineBox">
            
            	<div class="cCenter">
                <div class="conTitle"><span>民辅警BMI达标率</span></div>
            	<!--各单位警力配置达标率-->
                <div class="lineCon" id="daChart"></div>
                <?php include 'mod/processingEfficiency.html' ?>
                </div>
                
                <!--月度警力流动趋势
                <div class="lineCon" id="barC"></div>
                <?php include 'mod/monthPolice.html' ?>
                -->
                
            </div>
            <div class="highrisk">
            	<!--本月考勤状态分布-->
            	<div class="highKen">
                	<div class="conTitle"><span>本月考勤状态分布</span></div>
                	<div class="highCon" id="hDon"></div>
                </div>
                <?php include 'mod/atChart.html' ?>
                
                <!--休假审核进度-->
                <div id="xDcon">
                	<div class="conTitle"><span>休假申请审核进度</span></div>
                	<div id="xDon"></div>
                </div>
                <?php include 'mod/ProgressReview.html' ?>
                
            </div>
       
    </div>
    <div class="container" id="bottom">
    
    	<div class="bLeft">
        	<div class="conTitle"><span>个人事项上报异常监控表</span></div>
            <table width="98%" cellspacing="0" cellpadding="0" class="fjList">
                <thead>
                    <tr>
                        <th width="150px">单位名称</th>
                        <th>上报人</th>
                        <th width="300px">事项类型</th>
                        <th>上报时间</th>
                        <th>审核状态</th>
                    </tr>
                </thead>
                <tbody>
                	<?php for($j=0;$j<3;$j++) { ?>
                	<tr data-id="<?php echo $j ?>">
                        <td>治安大队</td>
                        <td>张朝阳 警号:gx130057</td>
                        <td>违法犯罪情况</td>
                        <td>2025-09-30 16:03:11 </td>
                        <td><b class="sxBlue">待审</b></td>
                    </tr>
                    <?php } ?>
                	<?php for($z=0;$z<3;$z++) { ?>
                	<tr data-id="<?php echo $z+10 ?>">
                        <td>治安大队</td>
                        <td>张朝阳 警号:gx130057</td>
                        <td>违法犯罪情况</td>
                        <td>2025-09-30 16:03:11 </td>
                        <td><b class="sxGreen">通过</b></td>
                    </tr>
                    <?php } ?>
                	<?php for($x=0;$x<1;$x++) { ?>
                	<tr data-id="<?php echo $x+25 ?>">
                        <td>治安大队</td>
                        <td>张朝阳 警号:gx130057</td>
                        <td>违法犯罪情况</td>
                        <td>2025-09-30 16:03:11 </td>
                        <td><b class="sxRed">驳回</b></td>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
        
        <div class="bRight">
            <!--<div class="conTitle">家庭成员 & 特长资源统计</div>-->
            <div class="bRcon">
            	<div class="conTitle"><span>民辅警年龄区间分布</span></div>
                
                <!--家庭成员关系分布-->
            	<div id="familyPie"></div>
                <?php include 'mod/familyPie.html' ?>
                
            </div>
            <div class="bRcon">
				<div class="conTitle"><span>队伍特长资源分布</span></div>
                
                <!--队伍特长资源分布-->
                <div id="familyBar"></div>
				<?php include 'mod/familyBar.html' ?>
                
                </div>
            </div>
        </div>

        
    </div>
    




    
</div>

<!--详情窗口-->
<div id="mask" style="display:none">
	<div id="show">
    	<div id="show_title">
        	<div id="myTitle"></div>
        	<div class="close"></div>
        </div>
        <div id="show_content">
        	<div class="show_about">

            </div>
        </div>
    </div>
</div>

<script>
$(function(){
	//打开详情
	$(".fjList tbody tr").on('click',function(e){
		console.log(e);
		$("#mask").fadeIn();
		var tmpData = $(this).attr('data-id');
		$("#myTitle").text(tmpData);
	})
	//关闭详情
	$(".close").on('click',function(){
		$("#mask").fadeOut();
	})
	//关闭loader窗口
	$(window).load(function(){
		$("#loader").fadeOut(500);
	})

})
</script>


<video autoplay="autoplay" loop="loop" muted="muted" class="video-background" id="styleVideo">
<source src="statics/images/bg.mp4" type="video/mp4">
Your browser does not support the video tag.
</video>
<script>
//初始化scrollReveal
if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))){
	(function(){
		window.scrollReveal = new scrollReveal({reset: true});
	})();
};
</script>
</body>
</html>