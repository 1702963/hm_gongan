<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');
?>
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<link href="statics/css/gridStyle.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<style type="text/css">
* {margin:0;padding:0}
body {margin:0;padding:0; /*url(statics/images/admin_img/2025/tb/bodybg.jpg) center center no-repeat*/display:flex;justify-content: center;font-family:microsoft yahei}
a , a:hover {text-decoration:none}

body {display:block;padding:0;margin:0}
.renshiTitle {width:160px;height:40px;text-align:center;line-height:40px;font-weight:900;font-size:14px;border-radius:3px;background:#05ac58;color:#fff;border:1px solid #194c80;position:absolute;top:20px;left: 40px;z-index:1}
.pad_10, .pad-lr-10 {padding:0}
.tableContent {height:calc( 100% - 100px )}
</style>

<div class="tableContent">

<div class="pad-lr-10" >
<div class="renshiTitle"> 
   请选择要填报的类型 
</div>

<div style="clear:both"></div>
<div class="tri">
	<div class="triBox">
    
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=1" title="护照"><img src="statics/images/admin_img/2025/tb/type01.png" /><span>护照</span></a>
            </div>
        </div>
        
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=2" title="边境通行证"><img src="statics/images/admin_img/2025/tb/type02.png" /><span>边境通行证</span></a>
            </div>
        </div>
        
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=3" title="本人参与盈利情况"><img src="statics/images/admin_img/2025/tb/type03.png" /><span>本人参与盈利情况</span></a>
            </div>
        </div>
        
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=4" title="经商办企"><img src="statics/images/admin_img/2025/tb/type04.png" /><span>经商办企</span></a>
            </div>
        </div>
        
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=5" title="家庭成员"><img src="statics/images/admin_img/2025/tb/type05.png" /><span>家庭成员</span></a>
            </div>
        </div>
        
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=6" title="犯罪违法情况"><img src="statics/images/admin_img/2025/tb/type06.png" /><span>犯罪违法情况</span></a>
            </div>
        </div>
        
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=7" title="工资"><img src="statics/images/admin_img/2025/tb/type07.png" /><span>工资</span></a>
            </div>
        </div>
        
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=8" title="房产"><img src="statics/images/admin_img/2025/tb/type08.png" /><span>房产</span></a>
            </div>
        </div>
        
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=9" title="机动车"><img src="statics/images/admin_img/2025/tb/type09.png" /><span>机动车</span></a>
            </div>
        </div>
        
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=10" title="股票"><img src="statics/images/admin_img/2025/tb/type10.png" /><span>股票</span></a>
            </div>
        </div>
        
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=11" title="证券基金"><img src="statics/images/admin_img/2025/tb/type11.png" /><span>证券基金</span></a>
            </div>
        </div>
        
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=12" title="投资型保险"><img src="statics/images/admin_img/2025/tb/type12.png" /><span>投资型保险</span></a>
            </div>
        </div>
        
    	<div class="triCon">
        	<div class="triConBox">
            	 <a href="?m=renshi&c=geren&a=addsx&sxty=13" title="投资情况"><img src="statics/images/admin_img/2025/tb/type13.png" /><span>投资情况</span></a>
            </div>
        </div>
        

    </div>
</div>
</div>
</body></html>