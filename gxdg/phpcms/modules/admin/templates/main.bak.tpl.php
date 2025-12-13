<?php
defined('IN_ADMIN') or exit('No permission resources.');
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';

//MIAN控制器不适合放数据调用，改在模板内

//站内通知
		$this->db->table_name = 'mj_msgs';
		$msgmus = $this->db->get_one('showuser='.$_SESSION['userid']." and readdt=0", 'count(id) as zj');
	
		$msglist = $this->db->select('showuser='.$_SESSION['userid'].' and readdt=0', '*',10 , 'id desc');
	
//数据统计

		$this->db->table_name = 'mj_fujing';
		$fj_zz = $this->db->get_one('status=1 and isok=1 and gangwei<5', 'count(id) as zj');
		$fj_lf = $this->db->get_one('status=1 and isok=1 and gangwei=5', 'count(id) as zj');
		
		$day1=date("Y")."-01-01";
		$day2=date("Y")."-12-31";
		$nds_1=strtotime($day1);
		$nds_2=strtotime($day2);
		$fj_ndrz = $this->db->get_one("status=1 and isok=1 and (rjtime>=$nds_1 and rjtime<=$nds_2) ", 'count(id) as zj');
		$fj_ndlz = $this->db->get_one("status=2 and isok=1 and (lizhitime>=$nds_1 and lizhitime<=$nds_2) ", 'count(id) as zj');
		
		//echo "status=1 and isok=1 and (rjtime>=$nds_1 and rjtime<=$nds_2)"; 
		//print_r($fj_ndrz);
	
		//获取统计起始年度
		$days=date("Y")."01-01";
		$days=strtotime($days); //strtotime参数表内进行日期拼接经常会转成错误的时间戳,不知道是不是BUG
		
//判断当前登录角色

$ssdwid=" and dwid=".$_SESSION['bmid'];
if($_SESSION['roleid']<5){
  $ssdwid="";	
	}		
		
		$fj_xz = $this->db->get_one("status=1 and isok=1 and rjtime>=$days".$ssdwid, 'count(id) as zj');
		$fj_lz = $this->db->get_one("status=2 and isok=1 and rjtime>=$days".$ssdwid, 'count(id) as zj');
		
		
?>
<div id="main_frameid" class="pad-10 display" style="_margin-right:-12px;_width:98.9%;">
<body>
<style type="text/css">
body {background:#eef0f6}
.clear {clear:both}
.sys_info {width:96%;float:left;margin:2% 0 0 2%;_display:inline;height:90px;background:#fff;overflow:hidden}
.sys_info_title {width:100%;height:30px;line-height:30px;background:#00c1de;color:#fff;font-size:14px;font-weight:900;text-indent:16px;float:left;overflow:hidden}
.sys_info_con {width:100%;height:60px;line-height:60px;background:#fff;float:left;color:#333;font-size:12px;overflow:hidden}
.sys_info_con b {margin-left:16px;font-weight:100}
.cat_main {width:98%;float:left;margin:2% 0 0 2%;_display:inline}
.cat_con {width:48%;height:350px;background:#fff;margin-right:2%;float:left;_display:inline;overflow:hidden}
.cat_title {width:100%;height:50px;line-height:50px;background:#00c1de;color:#fff;font-size:14px;font-weight:900;overflow:hidden;position:relative}
.cat_title ul {width:100%;height:40px;margin-top:10px;float:left;}
.cat_title ul li {width:100px;height:40px;float:left;margin-left:15px;_display:inline}
.cat_title ul li a {width:100px;height:40px;display:block;line-height:40px;text-align:center;background:url(statics/images/main_b.gif) no-repeat;color:#fff;text-decoration:none}
.cat_title ul li.active a {background:url(statics/images/main_a.gif) no-repeat;color:#00c1de}
.cat_title .daiban {width:32px;height:24px;text-align:center;line-height:24px;background:#f00;color:#fff;font-size:12px;position:absolute;left:96px;top:5px;z-index:9999;border-radius:12px;font-family:arial;font-weight:100}

.cat_list {width:96%;float:left;margin:2% 0 0 2%;_display:inline}
.cat_list p {width:100%;height:44px;line-height:44px;overflow:hidden;float:left}
.cat_list p a {float:left;text-decoration:none;color:#069}
.cat_list p a:hover {color:#00c1de}
.cat_list p em {float:right}
.cat_list p a:hover {color:#00c1de}

.cat_total {width:100%;float:left}
.cat_total_con {width:22.5%;height:120px;margin:2% 0 0 2%;float:left;color:#fff;font-size:18px;font-family:microsoft yahei}
.cat_total_con .tcon {position:relative;width:100%;height:120px;}
.cat_total_con .tcon span {position:absolute;left:70px;top:20px;}
.cat_total_con .tcon b {font-size:44px;font-weight:100;position:absolute;right:20px;bottom:10px}
.ra {background:#6cc9b6 url(statics/images/ra.png) 15px 15px no-repeat}
.rb {background:#a2aee3 url(statics/images/rb.png) 15px 15px no-repeat}
.rc {background:#989bb7 url(statics/images/rc.png) 15px 15px no-repeat}
.rd {background:#e8bf9c url(statics/images/rd.png) 15px 15px no-repeat}
</style>
<script>
$(function(){
	$("#tongzhi > div:not(:first)").hide();
	var pi = $("#cat_nav > ul > li");
	var pd = $("#tongzhi > div");
	pi.each(function(p){
		$(this).mouseover(function(){
			pi.removeClass("active"); $(this).addClass("active");pd.hide();pd.eq(p).show();
		});
	});
	
});
</script>
<div class="sys_info">
	<div class="sys_info_title">我的个人信息</div>
    <div class="sys_info_con">
    <b><?php echo L('main_hello')?></b><?php echo $admin_username?>
    <b><?php echo L('main_role')?></b><?php echo $rolename?>
  	<b><?php echo L('main_last_logintime')?></b><?php echo date('Y-m-d H:i:s',$logintime)?>
	<b><?php echo L('main_last_loginip')?></b><?php echo $loginip?>
    </div>
</div>
<div class="cat_main">
	<div class="cat_con">
    	<div class="cat_title" id="cat_nav">
        	<ul>
            	<li class="active"><a href="javascript:void(0)">通知公告</a></li>
                <li style="display:none"><a href="javascript:void(0)">表彰奖励</a></li>
            </ul>
        </div>
        <div id="tongzhi">
			<div class="cat_list">
			<?php
if(is_array($hys)){
	foreach($hys as $info){
		?>
                <p><a href="javascript:void(0);" onClick="jilu(<?=$info['id']?>);"><?php echo $info['title'];?></a><em><?php echo date("Y-m-d H:i:s",$info['inputtime']);?></em></p>
				<?php
	}
}
?>
            </div>
			<div class="cat_list">
                <p><a href="#"></a><em></em></p>

            </div>
        </div>
    </div>
	<div class="cat_con">
    	<div class="cat_title">
        	<div class="daiban"><?php echo $msgmus['zj']?></div>
        	<ul>
        		<li class="active"><a href="javascript:void(0)">待办事项</a></li>
            </ul>
        </div>
        <div id="daiban">
			<div class="cat_list">
		<?php foreach($msglist as $v){?>	
                <p><span style="float:left;border-radius: 12px;background: #f00;height:12px;width: 12px;color: #fff; margin-top:18px"></span><a href="javascript:;" onClick="showmsg('<?php echo $v['id']?>')">【<?php echo $v['yuan']?>】<?php echo $v['msg']?></a><em><?php echo date("Y-m-d",$v['adddt'])?></em></p>
        <?php }?>
            </div>
        </div>
    </div>
</div>

<div class="cat_total">
	<div class="cat_total_con ra"><div class="tcon"><span>当前辅警数量(<?php echo $fj_zz['zj']+$fj_lf['zj']?>)</span><b>辅警<?php echo $fj_zz['zj']?>，临辅<?php echo $fj_lf['zj']?></b></div></div>
    <div class="cat_total_con rb"><div class="tcon"><span>待培训人数</span><b>0</b></div></div>
    <div class="cat_total_con rc"><div class="tcon"><span>年度新增人数(1月1日至当前)</span><b><?php echo $fj_ndrz['zj']?></b></div></div>
    <div class="cat_total_con rd"><div class="tcon"><span>年度离职人数(1月1日至当前)</span><b><?php echo $fj_ndlz['zj']?></b></div></div>
</div>

</div>
</body></html>
<script type="text/javascript">

function jilu(id) {
	window.top.art.dialog({title:'详细', id:'jilu', iframe:'?m=tongzhi&c=tongzhi&a=show&id='+id,width:'1100px',height:'650px'});
}


function showmsg(id) {
		window.top.art.dialog({title:'站内通知', id:'showskaoqin', iframe:'?m=gongzi&c=jixiao&a=showmsg&id='+id ,width:'500px',height:'350px'},function(){var d = window.top.art.dialog({id:'showskaoqin'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'showskaoqin'}).close()});
	}
</script>	