<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>公安系统队伍管理系统宣传子系统统计展示大屏设计方案</title>
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
    	<span>公安系统队伍管理系统宣传子系统统计展示</span>
        <div id="thisTime">
	        <img src="statics/images/home.png">
        	<a href="#">返回</a>
        	<img src="statics/images/clock.png">
            <?php include '../common/date.php' ?>
            <b id="myClock"></b>
        </div>
    </div>
	<div class="container" id="top">
    
    	<!--内容储备总量-->
    	<div class="topCon">
        	<div class="conTitle"><span>内容储备总量</span></div>
        	<div class="topitem">
            	<div class="itemTitle">素材库累计素材数</div>
                <div class="itemNum">12,845</div>
                <div class="itemFd red">同比 +2%</div>
                <div class="itemFd green">环比 -3%</div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">稿件库累计稿件数</div>
                <div class="itemNum">956</div>
                <div class="itemFd red">同比 +2%</div>
                <div class="itemFd green">环比 -3%</div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">本月新增素材数</div>
                <div class="itemNum">103</div>
                <div class="itemFd red">同比 +2%</div>
                <div class="itemFd green">环比 -3%</div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">本月新增稿件数</div>
                <div class="itemNum" style="color:#FC3">121</div>
                <div class="itemFd red">同比 +2%</div>
                <div class="itemFd green">环比 -3%</div>
            </div>
        </div>
        
        <!--传播采用成效-->
    	<div class="topCon">
        	<div class="conTitle"><span>传播采用成效</span></div>
            <div id="partyCon">
                <div class="partyitem">
                    <div class="itemTitle">年度素材采用总数</div>
                    <div class="itemNum">12,845</div>
                    <div class="itemFd green"></div>
                </div>
                <div class="partyitem">
                    <div class="itemTitle">年度稿件采用总数</div>
                    <div class="itemNum">956</div>
                    <div class="itemFd red"></div>
                </div>
                
                <div class="drumpie" id="miniPieA"></div>
                <!--素材采用率-->
                <?php include 'mod/miniPieA.html' ?>
                
                <div class="drumpie" id="miniPieB"></div>
                <!--素材采用率-->
                <?php include 'mod/miniPieB.html' ?>
                
            </div>
        </div>
        
        <!--媒体传播能级-->
    	<div class="topCon">
        	<div class="conTitle"><span>媒体传播能级</span></div>
        	<div class="duesitem">
            	<div class="itemTitle">国家级媒体发表数</div>
                <div class="itemNum">12,845</div>
                <div class="itemFd green"></div>
            </div>
        	<div class="duesitem">
            	<div class="itemTitle">省级媒体发表数</div>
                <div class="itemNum">956</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="duesitem">
            	<div class="itemTitle">市级媒体发表数</div>
                <div class="itemNum">197</div>
                <div class="itemFd red"></div>
            </div>
            <div id="partyDues"></div>
            <!--年度总传播频次-->
            <?php include 'mod/supervisoryTypes.html' ?>
        </div>

        
        <!--审核进度看板-->
    	<div class="topCon">
        	<div class="conTitle"><span>审核进度看板</span></div>
        	<div class="topitem">
            	<div class="itemTitle">待审核素材数</div>
                <div class="itemNum">12,845</div>
                <div class="itemFd green"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">待审核稿件数</div>
                <div class="itemNum">956</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">审核办结率</div>
                <div class="itemNum">103</div>
                <div class="itemFd red"></div>
            </div>
        	<div class="topitem">
            	<div class="itemTitle">超期未审核数(>3天)</div>
                <div class="itemNum" style="color:#FC3">121</div>
                <div class="itemFd red"></div>
            </div>
            
        </div>
        
    </div>
    <div class="container" id="center">
    		
            <div id="pieCon">
            	<div class="cCenter">
	            	<div class="conTitle"><span>素材与稿件结构分析</span></div>
                	<!--按实际业务分类-->
                    <div id="pieX" style="width:50%;height:200px;float:left"></div>
                    <?php include 'mod/partyX.html' ?>
 
                     <!--按内容分类-->
                    <div id="pieY" style="width:50%;height:200px;float:left"></div>
                    <?php include 'mod/partyY.html' ?>
                </div>   
                <div class="cCenter" style="margin-top:10px">
                    <!--月度素材与稿件新增数分析-->
                    <div class="conTitle"><span>月度素材与稿件新增数分析</span></div>
                    <div id="lineZ" style="width:100%;height:200px;float:left"></div>
                    <?php include 'mod/partyZ.html' ?>
                </div>
            </div>
            
            <div class="lineBox">
            	<div class="cCenter">
                <div class="conTitle"><span>媒体级别发表分布</span></div>
	            <div class="lineCon">
                	<!--传播效果与单位贡献分析-->
                    <div id="pieType" style="width:100%;height:190px;float:left"></div>
					<?php include 'mod/partyW.html' ?>
                </div>
                </div>
                <!--各单位稿件采用数排名-->
            	<div class="cCenter" style="margin-top:10px">
                <div class="conTitle"><span>一级单位媒体采用质量对比</span></div>
                <div class="lineCon" id="daChart"></div>
                <?php include 'mod/processingEfficiency.html' ?>
                </div>
                
            </div>
            <div class="highrisk">
            	<div class="cCenter">
                <div class="conTitle"><span>素材/稿件审核通过率对比</span></div>
            	 <!--素材 / 稿件审核通过率对比-->
            	 <div id="lineT" style="width:100%;height:200px;float:left"></div>
                 <?php include 'mod/barA.html' ?>
                 </div>
                 
            	<div class="cCenter" style="width:49%;margin-right:2%;margin-top:10px">
                <div class="conTitle"><span>审核时长分布</span></div>
                 <!--审核时长分布-->
                 <div id="lineB" style="width:100%;height:200px;float:left"></div>
                 <?php include 'mod/barB.html' ?>
                 </div>
				<div class="cCenter" style="width:49%;margin-top:10px">
                <div class="conTitle"><span>宣传作者贡献TOP5</span></div>
                 <!--宣传作者贡献 TOP5-->
                 <div id="lineC" style="width:100%;height:200px;float:left"></div>
                 <?php include 'mod/barC.html' ?>
                 </div>
            </div>
       
    </div>
    <div class="container" id="bottom">
    
    	<div class="bLeft">
        	<div class="conTitle">宣传待审核任务清单</div>
            <table width="98%" cellspacing="0" cellpadding="0" class="fjList">
                <thead>
                    <tr>
                        <th width="150px">所属单位</th>
                        <th>内容类型</th>
                        <th width="300px">标题</th>
                        <th>提交人</th>
                        <th>提交时间</th>
                        <th>待审天数</th>
                        <th>操作提示</th>
                    </tr>
                </thead>
                <tbody>
                	<?php for($j=0;$j<3;$j++) { ?>
                	<tr>
                        <td>党工委</td>
                        <td>素材</td>
                        <td>雨不停、水没退，我就要对全村负责！</td>
                        <td>张三</td>
                        <td>2025-10-13</td>
                        <td style="background:#f00;color:#fff">8</td>
                        <td><a href="#">点击审核</a></td>
                    </tr>
                    <?php } ?>
                	<?php for($z=0;$z<2;$z++) { ?>
                	<tr>
                        <td>党工委</td>
                        <td>素材</td>
                        <td>雨不停、水没退，我就要对全村负责！</td>
                        <td>张三</td>
                        <td>2025-10-13</td>
                        <td style="background:#fc0;color:#333">5</td>
                        <td><a href="#">点击审核</a></td>
                    </tr>
                    <?php } ?>
                	<?php for($j=0;$j<1;$j++) { ?>
                	<tr>
                        <td>党工委</td>
                        <td>素材</td>
                        <td>雨不停、水没退，我就要对全村负责！</td>
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

            <div class="bRcon">
                
               <!--重点表彰人员卡片 轮播-->
                <div class="highDon">
                    <div class="conTitle"><span>高价值内容</span></div>
                    
                    <div id="slider" class="superslider">
                        <div class="bd">
                            <ul class="picList">
                            	<li>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr><td><span>标题：</span>暴雨夜中筑起生命防线</td></tr>
                                        <tr><td><span>作者：</span>张三</td></tr>
                                        <tr><td><span>单位：</span>治安大队</td></tr>
                                        <tr><td><span>发表媒体：</span>劳动日报</td></tr>
                                        <tr><td><span>核心亮点：</span>参警以来一直就职于基层派出所户籍窗口,多年来坚持为人民群众热情服务</td></tr>
                                    </table>
                                </li>
                            	<li>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr><td><span>标题：</span>暴雨夜中筑起生命防线</td></tr>
                                        <tr><td><span>作者：</span>张三</td></tr>
                                        <tr><td><span>单位：</span>治安大队</td></tr>
                                        <tr><td><span>发表媒体：</span>劳动日报</td></tr>
                                        <tr><td><span>核心亮点：</span>参警以来一直就职于基层派出所户籍窗口,多年来坚持为人民群众热情服务</td></tr>
                                    </table>
                                </li>
                            	<li>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr><td><span>标题：</span>暴雨夜中筑起生命防线</td></tr>
                                        <tr><td><span>作者：</span>张三</td></tr>
                                        <tr><td><span>单位：</span>治安大队</td></tr>
                                        <tr><td><span>发表媒体：</span>劳动日报</td></tr>
                                        <tr><td><span>核心亮点：</span>参警以来一直就职于基层派出所户籍窗口,多年来坚持为人民群众热情服务</td></tr>
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
            
            <!--未采用内容原因分析-->

            <div id="sdPie">
            	<div class="cCenter">
            	<div class="conTitle"><span>未采用内容原因分析</span></div>
                <div id="dPie"></div>
                </div>
            </div>
            <?php include 'mod/partyD.html' ?>

        </div>

        
    </div>
    

    
</div>
<video autoplay="autoplay" loop="loop" muted="muted" class="video-background" id="styleVideo">
<source src="statics/images/bg.mp4" type="video/mp4">
Your browser does not support the video tag.
</video>
</body>

</html>
