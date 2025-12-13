<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');

?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <div style=" width:100%;font-size:16px; text-align:center; margin-bottom:5px"></div>

<table width="70%" border="1" align="center" cellspacing="0" style="margin-top:40px">
	<thead>
		<tr>
            <th align="center" style="font-size:12px">请选择要操作的绩效工资档期</th>

		</tr>
	</thead>
<tbody>

	<tr>
    <form action="" method="get">
    <input type="hidden" name="m" value="gongzi" />
    <input type="hidden" name="c" value="jixiao" />
    <input type="hidden" name="a" value="ydjxgzb" />
    <input type="hidden" name="pc_hash" value="<?php echo $_SESSION['pc_hash']?>" />
    		
		<td align="center" >绩效工资档期 <select name="yue" >
                                        <?php foreach($yuelists as $y){?>
                                          <option value="<?php echo $y['yue']?>"><?php echo $y['yue']?></option>
										<?php }?> &nbsp;&nbsp;
                                       </select> <input type="submit" name="dome" value="打开" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF"/></td>
    </form>
	</tr>

</tbody>
 
</table>
<div id="pages"><?php echo $pages?></div>
</div>
</div>
</body>
</html>
