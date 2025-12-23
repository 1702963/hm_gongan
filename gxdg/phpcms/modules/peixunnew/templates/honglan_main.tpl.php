<?php
defined('IN_ADMIN') or exit('No permission resources.');
include PC_PATH . 'modules' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'header.tpl.php';

// 统计数据查询 - 从配置读取fujing数据库连接
$_db_config = pc_base::load_config('database', 'gxdgdb');
$_fj_conn = new mysqli($_db_config['hostname'], $_db_config['username'], $_db_config['password'], $_db_config['database']);
$_fj_conn->set_charset($_db_config['charset']);

// 对抗演练数量
$_result = $_fj_conn->query("SELECT COUNT(*) as cnt FROM v9_duikang_yanlian where isok<>'0'");
$_row = $_result->fetch_assoc();
$duikang_count = intval($_row['cnt']);

// 专项演练数量
$_result = $_fj_conn->query("SELECT COUNT(*) as cnt FROM v9_zhuanxiang_yanlian where isok<>'0'");
$_row = $_result->fetch_assoc();
$zhuanxiang_count = intval($_row['cnt']);

// 参与人员数量
$_result = $_fj_conn->query("SELECT COUNT(*) as cnt FROM v9_yanlian_canyu where isok<>'0'");
$_row = $_result->fetch_assoc();
$canyu_count = intval($_row['cnt']);

$_fj_conn->close();

?>
<body>
<script src="statics/js/jquery.min.js"></script>
<script src="statics/js/jquery.SuperSlide.2.1.1.js"></script>
<script src="statics/js/echarts.js"></script>
<script src="statics/js/resize.js"></script>
<script>
    $(function () {
        //设置需要显示的数据
        var ArrayWrapData = [
            ['duikang_count', <?php echo $duikang_count?>],        // 对抗演练
            ['zhuanxiang_count', <?php echo $zhuanxiang_count?>],  // 专项演练
            ['canyu_count', <?php echo $canyu_count?>],            // 参与人
        ];

        //数字过渡效果
        function numberAnimate(idName, countNumber) {
            var fidName = idName;
            var fcount = parseInt(countNumber);
            $("#" + fidName).animate({count: fcount}, {
                duration: 2000,
                step: function () {
                    $("#" + fidName).text(Intl.NumberFormat().format(parseInt(this.count)));
                },
                complete: function () {
                    $("#" + fidName).text(Intl.NumberFormat().format(fcount));
                }
            });
        }

        //遍历数组并执行过渡效果
        $.each(ArrayWrapData, function (index, subArray) {
            numberAnimate(subArray[0], subArray[1]);
        });

    })
</script>
<style type="text/css">
    @font-face {
        font-family: "AcensFont";
        src: url('statics/fonts/KeepCalm-Medium.ttf');
        font-weight: normal;
        font-style: normal;
    }

    @keyframes rotate360 {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    * {
        margin: 0;
        padding: 0
    }

    html {
        height: 100%
    }

    body {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: microsoft yahei;
        user-select: none
    }

    a, a:hover {
        text-decoration: none
    }

    .tableContent {
        margin-top: -15px;
        height: calc(100% - 100px)
    }

    div {
        box-sizing: border-box
    }

    .DigitalContent {
        width: 100%;
        min-width: 1640px;
        height: 100%;
        color: #fff;
    }

    .DigitalContent span {
        font-family: AcensFont
    }

    #modHonglan {
        width: 100%
    }

    .modTitle {
        width: 100%;
        height: 40px;
    }

    .modName {
        width: 100%;
        height: 36px;
        line-height: 36px;
        font-size: 20px;
        text-indent: 15px;
        color: #cbf0ff;
        font-weight: 600;
        background: linear-gradient(to right, rgba(0, 80, 180, 0.4), rgba(0, 80, 180, 0))
    }

    .modLine {
        width: 100%;
        height: 4px;
        border-bottom: 1px solid #274ca2
    }

    .modItemContent {
        width: 100%;
        display: flex;
        padding: 0 30px;
        flex-wrap: wrap;
    }

    .DataItemPic {
        width: 60px;
        height: 60px;
        border-radius: 50px;
        overflow: hidden;
        margin: 0 20px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .DataItemLight {
        width: 60px;
        height: 60px;
        position: absolute;
        left: 0;
        top: 0;
        z-index: 99;
        background: url(statics/images/admin_img/2025/itemCircleBg.png) center center no-repeat;
        background-size: 100%;
        animation: rotate360 5s linear infinite;
    }

    .DataItemName {
        width: 100%;
        font-size: 14px;
        margin-top: 0px
    }

    .DataItemNumber {
        font-size: 30px;
        font-family: AcensFont;
        margin-top: 0;
        letter-spacing: 3px
    }

    .DataItem {
        display: flex;
        align-items: center;
        border-radius: 3px;
        width: 30%;
        height: calc(100vh - 90vh);
        min-height: 100px;
        background: rgba(10, 80, 180, 0.2);
        border: 1px solid rgba(10, 60, 160, 0.5);
        margin: 30px 20px 30px 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .DataItem:hover {
        background: rgba(10, 80, 180, 0.4);
        border: 1px solid rgba(10, 60, 160, 0.8);
    }

    .DataItems {
        flex: 1;
        padding-left: 10px;
    }

</style>

<div class="tableContent">
    <div class="DigitalContent">
        <!--红蓝对抗演练模块-->
        <div id="modHonglan">
            <div class="modTitle">
                <div class="modName" style="display: none">红蓝对抗演练</div>
                <div class="modLine"></div>
            </div>
            <div class="modItemContent">

                <!--对抗演练-->
                <div  onclick="location.href='index.php?m=peixunnew&c=duikang_yanlian&a=init'"  style="cursor:pointer;" class="DataItem" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/rs03.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">对抗演练</div>
                        <div class="DataItemNumber" id="duikang_count">0</div>
                    </div>
                </div>

                <!--专项演练-->
                <div onclick="location.href='index.php?m=peixunnew&c=zhuanxiang_yanlian&a=init'"  style="cursor:pointer;" class="DataItem" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/rs03.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">专项演练</div>
                        <div class="DataItemNumber" id="zhuanxiang_count">0</div>
                    </div>
                </div>

                <!--参与人-->
                <div onclick="location.href='index.php?m=peixunnew&c=yanlian_canyu&a=init'"  style="cursor:pointer;" class="DataItem" data-scroll-reveal="enter right">
                    <div class="DataItemPic" data-scroll-reveal="wait .2s enter left">
                        <img src="statics/images/admin_img/2025/rs03.png">
                        <div class="DataItemLight"></div>
                    </div>
                    <div class="DataItems" data-scroll-reveal="wait .4s enter right">
                        <div class="DataItemName">参与人</div>
                        <div class="DataItemNumber" id="canyu_count">0</div>
                    </div>
                </div>

            </div>
        </div>
        <!--红蓝对抗演练模块结束-->

    </div>
</div>

<script>
    //初始化scrollReveal
    if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))) {
        (function () {
            window.scrollReveal = new scrollReveal({reset: true});
        })();
    }
    ;
</script>
</body>
</html>
