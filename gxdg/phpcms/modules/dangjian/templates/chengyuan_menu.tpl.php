<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new', 'admin');
?>
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css"/>
<link href="statics/css/gridStyle.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css"/>
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
        <div class="tri" style="width:100%">
            <div class="triBox">
                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=chengyuan&a=init&sxty=2" title="党委班子成员情况"><img
                                    src="statics/images/admin_img/2025/tb/type02.png"/><span>党委班子成员情况</span></a>
                    </div>
                </div>
                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=chengyuan&a=shuangchongzuzhi&sxty=3" title="双重组织生活情况"><img
                                    src="statics/images/admin_img/2025/tb/type03.png"/><span>双重组织生活情况</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=chengyuan&a=tanxintanhua&sxty=4" title="谈心谈话"><img
                                    src="statics/images/admin_img/2025/tb/type04.png"/><span>谈心谈话</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=chengyuan&a=yigangshuangze&sxty=5" title="一岗双责">
                            <img src="statics/images/admin_img/2025/tb/type05.png"/><span>一岗双责</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=chengyuan&a=sixiajiceng&sxty=6" title='践行"四下基层"情况'>
                            <img src="statics/images/admin_img/2025/tb/type06.png"/><span>践行"四下基层"情况</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>