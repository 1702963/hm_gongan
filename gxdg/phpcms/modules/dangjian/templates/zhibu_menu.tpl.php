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
            党支部
        </div>

        <div style="clear:both"></div>
        <div class="tri" style="width:100%;height:auto;">
            <div class="triBox" style="height:auto;">
                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=init&sxty=2" title="党支部简介"><img
                                    src="statics/images/admin_img/2025/tb/type05.png"/><span>党支部简介</span></a>
                    </div>
                </div>
                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=baseinfo&sxty=3" title="党支部成员基本信息"><img
                                    src="statics/images/admin_img/2025/tb/type02.png"/><span>党支部成员基本信息</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=three&sxty=4" title="三会一课"><img
                                    src="statics/images/admin_img/2025/tb/type02.png"/><span>三会一课</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=brand&sxty=5" title="党支部品牌创建">
                            <img src="statics/images/admin_img/2025/tb/type02.png"/><span>党支部品牌创建</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=shenghuohui&sxty=6" title='组织生活会'>
                            <img src="statics/images/admin_img/2025/tb/type02.png"/><span>组织生活会</span></a>
                    </div>
                </div>


                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=dangke&sxty=2" title="党课"><img
                                    src="statics/images/admin_img/2025/tb/type02.png"/><span>党课</span></a>
                    </div>
                </div>
                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=peiyangfazhan&sxty=3" title="培养发展党员情况"><img
                                    src="statics/images/admin_img/2025/tb/type02.png"/><span>培养发展党员情况</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=jingshijiaoyu&sxty=4" title="开展警示教育情况"><img
                                    src="statics/images/admin_img/2025/tb/type02.png"/><span>开展警示教育情况</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=zhutidangri&sxty=6" title='开展主题党日情况'>
                            <img src="statics/images/admin_img/2025/tb/type02.png"/><span>开展主题党日情况</span></a>
                    </div>
                </div>


                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=dangfeishoujiao&sxty=2" title="党费收缴"><img
                                    src="statics/images/admin_img/2025/tb/type02.png"/><span>党费收缴</span></a>
                    </div>
                </div>
                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=zhengzhishengri&sxty=3" title="政治生日"><img
                                    src="statics/images/admin_img/2025/tb/type02.png"/><span>政治生日</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=tanxintanhua&sxty=4" title="谈心谈话"><img
                                    src="statics/images/admin_img/2025/tb/type02.png"/><span>谈心谈话</span></a>
                    </div>
                </div>

                <div class="triCon">
                    <div class="triConBox">
                        <a href="?m=dangjian&c=zhibu&a=zhuanxianggongzuo&sxty=5" title=“专项工作”>
                            <img src="statics/images/admin_img/2025/tb/type02.png"/><span>专项工作</span></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>