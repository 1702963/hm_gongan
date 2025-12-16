<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new', 'admin');
?>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>?ver=<?php echo time() ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo CSS_PATH?>gridStyle.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css"/>
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
            党委班子成员个人填报
        </div>

        <div style="clear:both"></div>
        <div class="tri" style="width:100%;height:auto;">
            <div class="triBox" style="height:auto;">
                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=jiagou&a=init&sxty=2" title="党员基本信息"><img
                                    src="statics/images/admin_img/2025/tb/type02.png"/><span>党员基本信息</span></a>
                    </div>
                </div>
                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=jiagou&a=jijifenzi&sxty=3" title="入党积极分子"><img
                                    src="statics/images/admin_img/2025/tb/type03.png"/><span>入党积极分子</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=jiagou&a=fazhandangyuan&sxty=4" title="发展党员情况"><img
                                    src="statics/images/admin_img/2025/tb/type04.png"/><span>发展党员情况</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=jiagou&a=yubeidangyuan&sxty=5" title="预备党员情况">
                            <img src="statics/images/admin_img/2025/tb/type05.png"/><span>预备党员情况</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=jiagou&a=lilunxuexi&sxty=6" title='参加政治理论学习培训情况'>
                            <img src="statics/images/admin_img/2025/tb/type06.png"/><span>参加政治理论学习培训情况</span></a>
                    </div>
                </div>


                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=jiagou&a=dangzhibu&sxty=2" title="参加党支部活动情况"><img
                                    src="statics/images/admin_img/2025/tb/type02.png"/><span>参加党支部活动情况</span></a>
                    </div>
                </div>
                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=jiagou&a=guanxibiandong&sxty=3" title="党关系变动情况"><img
                                    src="statics/images/admin_img/2025/tb/type03.png"/><span>党关系变动情况</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=jiagou&a=dangfei&sxty=4" title="党员个人党费缴纳情况"><img
                                    src="statics/images/admin_img/2025/tb/type04.png"/><span>党员个人党费缴纳情况</span></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>