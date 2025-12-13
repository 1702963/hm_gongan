<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<!--项目详情-->
<style type="text/css">
#xm_wrap {width:96%;margin:0 auto}
#xm_wrap h3 {font-size:14px;font-weight:900;color:#177ac2;line-height:48px;width:100%;height:48px;border:0}
.xm_xx {border-left:1px solid #fff;border-top:1px solid #fff;margin-bottom:30px}
.xm_xx td {line-height:32px;border-right:1px solid #fff;border-bottom:1px solid #fff;font-size:12px;text-indent:24px;color:#111}
.xm_base {width:100%;height:125px;background:#f3f3f3;margin-bottom:30px}
.xm_base ul {margin:0;padding:0}
.xm_base li {list-style:none;float:left;width:93px;height:93px;background:url(statics/images/admin_img/zb/cir.png) center center no-repeat}
.xm_base li.cut {width:30px;height:93px;background:#fff url(statics/images/admin_img/zb/cut.png) center center no-repeat}

</style>
<div id="xm_wrap">
	<h3>签约项目跟踪 - 详细内容</h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="xm_xx">
      <tr bgcolor="#f5fbff">
        <td width="25%"><b>项目名称</b></td>
        <td width="20%"><b>项目进度</b></td>
        <td width="40%"><b>项目介绍</b></td>
        <td width="15%"><b>负责人</b></td>
      </tr>
      <tr bgcolor="#f8f8f8">
        <td>中国石化PVP化工厂项目</td>
        <td>签订厂房租赁协议 </td>
        <td>中国石化PVP化工厂项目介绍此处省略大概30个字...</td>
        <td>赵凯</td>
      </tr>
    </table>
    <h3>项目基础信息</h3>
    <div class="xm_base">
    	<ul>
        	<li></li>
            <li class="cut"></li>
            <li></li>
            <li class="cut"></li>
            <li></li>
            <li class="cut"></li>
            <li></li>
            <li class="cut"></li>
            <li></li>
        </ul>
    </div>
    <h3>项目前期手续办理</h3>
</div>


</body>
</html>



