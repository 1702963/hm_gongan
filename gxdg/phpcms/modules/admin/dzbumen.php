<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class dzbumen extends admin {
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('dzbumen_model');
	}
	
	function init () {
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$userid = $_SESSION['userid'];
		$admin_username = param::get_cookie('admin_username');
		
		$table_name = $this->db->table_name;

		$result = $this->db->select('','*','','listorder ASC,id asc');
		$array = array();
		foreach($result as $r) {
			$s_name="";
			if($r['sname']!=""){$s_name="【".$r['sname'].'】';}
			$r['cname'] = $r['name'].$s_name;
			$r['str_manage'] = '<a class=modView href="?m=admin&c=dzbumen&a=add&parentid='.$r['id'].'&menuid='.$_GET['menuid'].'">添加子组织</a> | <a class=modChange href="?m=admin&c=dzbumen&a=edit&id='.$r['id'].'&menuid='.$_GET['menuid'].'">'.L('modify').'</a> | <a class=modCancel href="javascript:confirmurl(\'?m=admin&c=dzbumen&a=delete&id='.$r['id'].'&menuid='.$_GET['menuid'].'\',\''.L('confirm',array('message'=>$r['cname'])).'\')">'.L('delete').'</a> ';
			$array[] = $r;
		}

		$str  = "<tr>
					<td align='center'><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input-text-c'></td>
					<td align='center'>\$id</td>
					<td align='left'>\$spacer\$cname</td>
					<td align='center'>\$str_manage</td>
				</tr>";
		$tree->init($array);
		$categorys = $tree->get_tree(0, $str);
		include $this->admin_tpl('dzbumen');
	}
	
	public function bumen_tree() {
		$mm=$_GET['mm'];
		$cc=$_GET['cc'];
		$aa=$_GET['aa'];
		$status=$_GET['status'];
		$tree = pc_base::load_sys_class('tree');
		
		$admin_username = param::get_cookie('admin_username');
		
		$table_name = $this->db->table_name;
	    
		if($_SESSION['roleid']>5){
		   $where = " id in(1,".$_SESSION['bmid'].")";
		}		
	
		$result = $this->db->select($where,'*','','listorder ASC,id asc');
		$array = array();
		foreach($result as $r) {
			$r['cname'] = $r['name'];
			$r['id'] = $r['id'];
			//$r['str_manage'] = '<a href="?m=admin&c=bumen&a=add&parentid='.$r['id'].'&menuid='.$_GET['menuid'].'">添加子部门</a> | <a href="?m=admin&c=bumen&a=edit&id='.$r['id'].'&menuid='.$_GET['menuid'].'">'.L('modify').'</a> | <a href="javascript:confirmurl(\'?m=admin&c=bumen&a=delete&id='.$r['id'].'&menuid='.$_GET['menuid'].'\',\''.L('confirm',array('message'=>$r['cname'])).'\')">'.L('delete').'</a> ';
			$array[] = $r;
		}

		$strs = "<span class='\$icon_type'>\$add_icon<a href='?m=$mm&c=$cc&a=$aa&status=$status&dwid=\$id' target='right' onclick='open_list(this)'>\$cname</a></span>";
						$strs2 = "<span class='folder'>\$cname</span>";
		$tree->init($array);
		$categorys = $tree->get_treeview(0,'category_tree',$strs,$strs2,$ajax_show);
		
        include $this->admin_tpl('dzbumen_tree');
		exit;
	}
	function add() {
		if(isset($_POST['dosubmit'])) {
			$this->db->insert($_POST['info']);
			
			showmessage(L('add_success'));
		} else {
			$show_validator = '';
			$tree = pc_base::load_sys_class('tree');
			$result = $this->db->select();
			$array = array();
			foreach($result as $r) {
				$r['cname'] = $r['name'];
				$r['selected'] = $r['id'] == $_GET['parentid'] ? 'selected' : '';
				$array[] = $r;
			}
			$str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
			$tree->init($array);
			$select_categorys = $tree->get_tree(0, $str);
			
			
			include $this->admin_tpl('dzbumen');
		}
	}
	function delete() {
		$_GET['id'] = intval($_GET['id']);
		$this->db->delete(array('id'=>$_GET['id']));
		showmessage(L('operation_success'));
	}
	
	function edit() {
		if(isset($_POST['dosubmit'])) {
			$id = intval($_POST['id']);
			//print_r($_POST['info']);exit;
			$r = $this->db->get_one(array('id'=>$id));
			$this->db->update($_POST['info'],array('id'=>$id));
		
			showmessage(L('operation_success'));
		} else {
			$show_validator = $array = $r = array(); //妈的 7.2还有这毛病呢
			$tree = pc_base::load_sys_class('tree');
			$id = intval($_GET['id']);
			$r = $this->db->get_one(array('id'=>$id));
			if($r) extract($r);
			$result = $this->db->select();
			foreach($result as $r) {
				$r['cname'] = $r['name'];
				$r['selected'] = $r['id'] == $parentid ? 'selected' : '';
				//var_dump($r);
				$array[] = $r;
			}
			$str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
			$tree->init($array);
			$select_categorys = $tree->get_tree(0, $str);
			
			include $this->admin_tpl('dzbumen');
		}
	}
	
	/**
	 * 排序
	 */
	function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $id => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessage(L('operation_success'));
		} else {
			showmessage(L('operation_failure'));
		}
	}
	
	/**
	 * 更新菜单的所属模式
	 * @param $id INT 菜单的ID
	 * @param $old_data 该菜单的老数据
	 * @param $new_data 菜单的新数据
	 **/
	private function update_menu_models($id, $old_data, $new_data) {
		$models_config = pc_base::load_config('model_config');
		if (is_array($models_config)) {
			foreach ($models_config as $_k => $_m) { 
				if (!isset($new_data[$_k])) $new_data[$_k] = 0;
				if ($old_data[$_k]==$new_data[$_k]) continue; //数据没有变化时继续执行下一项
				$r = $this->db->get_one(array('id'=>$id), 'parentid');
				$this->db->update(array($_k=>$new_data[$_k]), array('id'=>$id));
				if ($new_data[$_k] && $r['parentid']) {
					$this->update_parent_menu_models($r['parentid'], $_k); //如果设置所属模式，更新父级菜单的所属模式
				}
			}
		}
		return true;
	}

	/**
	 * 更新父级菜单的所属模式
	 * @param $id int 菜单ID
	 * @param $field  修改字段名
	 */
	private function update_parent_menu_models($id, $field) {
		$id = intval($id);
		$r = $this->db->get_one(array('id'=>$id), 'parentid');
		$this->db->update(array($field=>1), array('id'=>$id)); //修改父级的所属模式，然后判断父级是否存在父级
		if ($r['parentid']) {
			$this->update_parent_menu_models($r['parentid'], $field);
		}
		return true;
	}
}
?>