<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>公安系统队伍管理系统优抚子系统统计展示大屏设计方案</title>
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
    	<span>公安系统队伍管理系统优抚子系统统计展示大屏</span>
        <div id="thisTime">
	        <img src="statics/images/home.png">
        	<a href="#">返回</a>
        	<img src="statics/images/clock.png">
            <?php include '../common/date.php' ?>
            <b id="myClock"></b>
        </div>
    </div>
	<div class="container" id="top">
    
    
        
    	<!--优抚申报进度-->
    	<div class="topCon">
        	<div class="conTitle"><span>优抚申报进度</span></div>
        	<div class="topitem">
            	<div class="itemTitle">年度累计申报总数</div>
                <div class="itemNum">12,845</div>
                <div class="itemFd green"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">本月新增申报数</div>
                <div class="itemNum">956</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">已审批通过数</div>
                <div class="itemNum">103</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">审批通过率</div>
                <div class="itemNum" style="color:#FC3">88%</div>
                <div class="itemFd red"></div>
            </div>
        </div>
        
    	<!--工会福利覆盖-->
    	<div class="topCon">
        	<div class="conTitle"><span>工会福利覆盖</span></div>
        	<div class="topitem">
            	<div class="itemTitle">工会会员总数</div>
                <div class="itemNum">12,845</div>
                <div class="itemFd green"></div>
            </div>
<!--        	<div class="topitem">
            	<div class="itemTitle">本月新增会员数</div>
                <div class="itemNum">956</div>
                <div class="itemFd red"></div>
            </div>-->
        	<div class="topitem">
            	<div class="itemTitle">工会申报通过数</div>
                <div class="itemNum">103</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">工会福利覆盖率</div>
                <div class="itemNum" style="color:#FC3">77%</div>
                <div class="itemFd red"></div>
            </div>
        </div>
        
 
        <!--健康体检进展-->
    	<div class="topCon">
        	<div class="conTitle"><span>健康体检进展</span></div>
        	<div class="topitem">
            	<div class="itemTitle">年度应体检人数</div>
                <div class="itemNum">12,845</div>
                <div class="itemFd green"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">已体检人数</div>
                <div class="itemNum">956</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">体检完成率</div>
                <div class="itemNum">93%</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="topitem" style="background:#c00">
            	<div class="itemTitle" style="color:#fff">体检异常人员数</div>
                <div class="itemNum" style="color:#fff">121</div>
                <div class="itemFd red"></div>
            </div>
            
        </div>
        
    </div>
    <div class="container" id="center">
    		
            
            <div id="pieCon">
            	<div class="cCenter">
            	<div class="conTitle"><span>优抚申报类型分布</span></div>
                	<!--优抚申报类型分布-->
                    <div id="pieX" style="width:100%;height:200px;float:left"></div>
                    <?php include 'mod/partyX.html' ?>
                </div>
                <div class="cCenter" style="margin-top:10px">
				<div class="conTitle"><span>月度优抚申报趋势</span></div>
                    <!--月度优抚申报趋势-->
                    <div id="lineZ" style="width:100%;height:205px;float:left"></div>
                    <?php include 'mod/partyZ.html' ?>
                </div>
            </div>
            
            <div class="lineBox">
            
                <!--工会申报类型与批复金额分布-->
                <div class="cCenter">
                <div class="conTitle"><span>各类福利申报批复金额对比</span></div>
                <div class="lineCon" id="daChart"></div>
                <?php include 'mod/processingEfficiency.html' ?>
                </div>
                
	            <div class="lineCon">
					
                    
                 	<!--工会会员结构分析 / 会员年龄分布-->
                    <div class="cCenter" style="width:49%;height:240px;float:left;margin:10px 2% 0 0">
                    <div class="conTitle"><span>会员年龄分布</span></div>
                    <div id="pieA" style="width:100%;height:240px;float:left"></div>
					<?php include 'mod/partyY.html' ?>
                    </div>

                    
                	<!--今日过生日民辅警-->
                    <div class="cCenter" style="width:49%;height:240px;float:left;margin:10px 0 0 0">
                    <div id="pieType" style="width:100%;height:240px;float:left">
                    	<div class="conTitle">今日生日民辅警<em> 2025/10/20</em></div>
                            <table width="98%" cellspacing="0" cellpadding="0" class="peList">
                                <tbody>
                                    <tr>
                                        <td width="130" align="center"><img src="statics/images/per.png" class="personImg" /></td>
                                        <td>
                                        	<p>姓名：张三</p>
                                            <p>单位：治安大队</p>
                                            <p>岗位：文职</p>
                                            <p>政治面貌：中共党员</p>
                                            <p>入职日期：2011-09-01</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="yugao"><b>本月预告</b><br>10月15日（刘洋）、10月22日（陈阳）、10月28日（赵伟）</div>
                    </div>
                    </div>
					<!--<?php include 'mod/partyW.html' ?>-->
                    
                </div>

                
            </div>
            
            <div class="highrisk">
            	 <!--体检异常项 TOP5 分布-->
                 <div class="cCenter">
                 <div class="conTitle"><span>各类健康异常项人数分布(今年vs去年)</span></div>
            	 <div id="lineT" style="width:100%;height:200px;float:left"></div>
                 <?php include 'mod/partyT.html' ?>
                 </div>
                 
                 <!--不同年龄段体检异常率对比-->
                 <div class="cCenter" style="width:49%;height:240px;float:left;margin:10px 2% 0 0">
                 <div class="conTitle"><span>各年龄段健康异常率分布</span></div>
                 <div id="lineB" style="width:100%;height:200px;float:left"></div>
                 <?php include 'mod/partyK.html' ?>
                 </div>
                 
                 <!--体检异常人员跟踪进度-->
                 <div class="cCenter" style="width:49%;height:240px;float:left;margin:10px 0 0 0">
                 <div class="conTitle"><span>体检异常人员跟踪进度</span></div>
                 <div id="lineC" style="width:100%;height:240px;float:left">
                    
                    <div style="width:100%">
                        <div class="topitem">
                            <div class="itemTitle">需复查人数</div>
                            <div class="itemNum">1145</div>
                            <div class="itemFd green"></div>
                        </div>
                        <div class="topitem">
                            <div class="itemTitle">已复查人数</div>
                            <div class="itemNum">956</div>
                            <div class="itemFd red"></div>
                        </div>
                        <div class="topitem">
                            <div class="itemTitle">复查完成率</div>
                            <div class="itemNum">95%</div>
                            <div class="itemFd red"></div>
                        </div>
                        <div id="topTable" style="width:100%;height:140px">
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span class="progress-name">跟踪进度</span>
                                    <span class="progress-rate">85%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill green" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
                 </div>
                 
                 
            </div>
       
    </div>
    <div class="container" id="bottom">
    
    	<div class="bLeft">
        	<div class="conTitle">优抚待办任务清单</div>
            <table width="98%" cellspacing="0" cellpadding="0" class="fjList">
                <thead>
                    <tr>
                        <th width="150px">所属单位</th>
                        <th>任务类型</th>
                        <th width="300px">申请人/上报人</th>
                        <th>提交时间</th>
                        <th>待办天数</th>
                        <th>操作提示</th>
                    </tr>
                </thead>
                <tbody>
                	<?php for($j=0;$j<2;$j++) { ?>
                	<tr>
                        <td>党工委</td>
                        <td>优抚申报</td>
                        <td>张三</td>
                        <td>2025-10-13</td>
                        <td style="background:#f00;color:#fff">8</td>
                        <td><a href="#">点击审核</a></td>
                    </tr>
                    <?php } ?>
                	<?php for($z=0;$z<3;$z++) { ?>
                	<tr>
                        <td>党工委</td>
                        <td>风险排查</td>
                         <td>张三</td>
                        <td>2025-10-13</td>
                        <td style="background:#fc0;color:#333">5</td>
                        <td><a href="#">点击审核</a></td>
                    </tr>
                    <?php } ?>
                	<?php for($j=0;$j<1;$j++) { ?>
                	<tr>
                        <td>党工委</td>
                        <td>工会申报</td>
                        <td>张三</td>
                        <td>2025-10-13</td>
                        <td>3</td>
                        <td><a href="#">点击审核</a></td>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
        
        <div class="bRight">

                
               <!--体检异常重点人员卡片 轮播-->
                <div class="highDon">
                
                	<div class="yichang">
                        <div class="conTitle"><span>体检异常重点人员卡片</span></div>
                        <div id="slider" class="superslider">
                            <div class="bd">
                                <ul class="picList">
                                    <li>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr><td><span>姓名：</span>张三</td></tr>
                                            <tr><td><span>单位：</span>治安大队</td></tr>
                                            <tr><td><span>核心异常项：</span>血糖、血脂、血压</td></tr>
                                            <tr><td><span>跟踪状态：</span>未复查</td></tr>
                                        </table>
                                    </li>
                                    <li>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr><td><span>姓名：</span>张三</td></tr>
                                            <tr><td><span>单位：</span>治安大队</td></tr>
                                            <tr><td><span>核心异常项：</span>血糖、血脂、血压</td></tr>
                                            <tr><td><span>跟踪状态：</span>未复查</td></tr>
                                        </table>
                                    </li>
                                    <li>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr><td><span>姓名：</span>张三</td></tr>
                                            <tr><td><span>单位：</span>治安大队</td></tr>
                                            <tr><td><span>核心异常项：</span>血糖、血脂、血压</td></tr>
                                            <tr><td><span>跟踪状态：</span>未复查</td></tr>
                                        </table>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

					<script>
                        jQuery("#slider").slide({mainCell:".bd ul",autoPage:true,effect:"leftLoop",autoPlay:true,vis:3,pnLoop:true});
                    </script>
                    
                    <!--未采用内容原因分析-->
                    <div id="sdPie">
                    	<div class="conTitle"><span>惠警优选</span></div>
                        <div id="huiJing" class="superslider">
                            <div class="bd">
                                <ul class="huiList">
									<?php for($k=0;$k<5;$k++) { ?>
                                    <li>
                                    	<p><b>椰子便利店(大学道店)</b> <span>办公用品 9 折</span><span>饮用水 85 折</span></p>
                                        <p>地址：高新区大学道10号底商 联系电话：13303150000、13303150001</p>
                                     </li>
									<?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
					<script>
                        jQuery("#huiJing").slide({mainCell:".bd ul",autoPage:true,effect:"topLoop",autoPlay:true,vis:3,pnLoop:true});
                    </script>
                    <?php //include 'mod/partyD.html' ?>
                    
                    <!--高需求单位 TOP3-->
                    <!--<div id="sdBar"></div>-->
                    <?php //include 'mod/partyC.html' ?>
                    
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
