<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new', 'admin');
?>
<link href="<?php echo CSS_PATH ?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo CSS_PATH ?>gridStyle.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css"/>
<style type="text/css">
    * {
        margin: 0;
        padding: 0
    }

    body {
        margin: 0;
        padding: 0; /*url(statics/images/admin_img/2025/tb/bodybg.jpg) center center no-repeat*/
        display: flex;
        justify-content: center;
        font-family: microsoft yahei
    }

    a, a:hover {
        text-decoration: none
    }

    body {
        display: block;
        padding: 0;
        margin: 0
    }

    .renshiTitle {
        width: 160px;
        height: 40px;
        text-align: center;
        line-height: 40px;
        font-weight: 900;
        font-size: 14px;
        border-radius: 3px;
        background: #05ac58;
        color: #fff;
        border: 1px solid #194c80;
        position: absolute;
        top: 20px;
        left: 40px;
        z-index: 1
    }

    .pad_10, .pad-lr-10 {
        padding: 0
    }

    .tableContent {
        height: calc(100% - 100px)
    }
</style>

<div class="tableContent">

    <div class="pad-lr-10">
        <div class="renshiTitle">
            党委班子
        </div>

        <div style="clear:both"></div>
        <div class="tri" style="width:100%">
            <div class="triBox">

                <div class="triCon" style="width:96%">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=geren&a=addsx&sxty=1" title=""><img src="statics/images/admin_img/2025/tb/type05.png"/><span>分局党委介绍</span></a>
                    </div>
                </div>         
                <!--        -->
                <!--    	<div class="triCon">-->
                <!--        	<div class="triConBox">-->
                <!--            	 <a href="?m=renshi&c=geren&a=addsx&sxty=2" title="边境通行证"><img src="statics/images/admin_img/2025/tb/type02.png" /><span>班子成员</span></a>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        -->
                <!--    	<div class="triCon">-->
                <!--        	<div class="triConBox">-->
                <!--            	 <a href="?m=renshi&c=geren&a=addsx&sxty=3" title="本人参与盈利情况"><img src="statics/images/admin_img/2025/tb/type03.png" /><span>理论学习情况</span></a>-->
                <!--            </div>-->
                <!--        </div>-->

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=geren&a=addsx2&sxty=4" title="落实全面从严治党工作"><img
                                    src="statics/images/admin_img/2025/tb/type02.png"/><span>落实全面从严治党工作</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=geren&a=addsx3&sxty=5" title="意识形态工作"><img src="statics/images/admin_img/2025/tb/type02.png"/><span>意识形态工作</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=geren&a=addsx4&sxty=6" title="主题活动"><img src="statics/images/admin_img/2025/tb/type02.png"/><span>主题活动</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=geren&a=addsx5&sxty=7" title="专项工作"><img src="statics/images/admin_img/2025/tb/type02.png"/><span>专项工作</span></a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>