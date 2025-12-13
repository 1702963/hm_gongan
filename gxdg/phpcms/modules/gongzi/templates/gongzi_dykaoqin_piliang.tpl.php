<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <form action="" method="POST">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="gzgl"/>
    <input type="hidden" name="a" value="kaoqinpiliang"/>
    <input type="hidden" name="bmid" value="<?php echo $_GET['bmid']?>"/> 
    <input type="hidden" name="days" value="<?php echo $_GET['days']?>"/>
    <input type="hidden" name="dbs" value="<?php echo $_GET['dbs']?>"/>
<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
		<tr>
            <td width="30%" align="center" style="font-size:12px">待编辑日期</td>
            <td align="left" style="font-size:12px"> <?php echo substr($_GET['days'],0,4)."-".substr($_GET['days'],4,2)."-".substr($_GET['days'],6,2)?> </td>
		</tr>
		<tr>
		  <td align="center" style="font-size:12px">考勤修改为</td>
		  <td align="left" style="font-size:12px"><select name="flags">
                                                    <option value=""></option> 
                                                    <?php foreach($kqflag as $k=>$v){?>
                                                     <option value="<?php echo $k?>"><?php echo $v[1]?></option>
                                                    <?php }?>
                                                  </select></td>
	    </tr>
		<tr>
		  <td align="center" style="font-size:12px">作用区域</td>
		  <td align="left" style="font-size:12px"><?php if(intval($_GET['bmid'])<1){echo "全部部门";}else{echo $bumen[intval($_GET['bmid'])];}?></td>
	    </tr>
		<tr>
		  <td colspan="2" align="center" style="font-size:12px; color:red">* 请务必确认考勤状态修改是否准确，当前操作将影响整全部作用区域内考勤记录</td>
	    </tr>
	</table>
<input type="submit" value="确认" id="dook" name="dook" style="display:none" /> 
</form>
</div>
</div>
</body>
</html>
