<?php
ini_set("display_errors", "On"); 
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class geren extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion2_model');
		$this->db->table_name = 'v9_fujing';
		pc_base::load_app_func('global');
	}
	
	public function init() {
		//showmessage('模块建设中');
		/////////////////////////////////////
       		 //绑定组织
		 $this->db = pc_base::load_model('bumen_model');
		
		$rss = $this->db->select("",'id,name,parentid','','listorder asc');	
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			
			}
		
		include $this->admin_tpl('gr_list');
	}
	
	//新录人员
	function addmenu()
	{	
		include $this->admin_tpl('addmenu_geren');
	}
	
	function addsx()
	{
		// 分局党委介绍 - 添加/修改
		$this->db->table_name = 'v9_dangweijieshao';
		$info = $this->db->get_one('', '*', '', 'id DESC');

		// POST提交保存
		if (isset($_POST['dosubmit'])) {
			$neirong = trim($_POST['info']['neirong']);
			$fujian = trim($_POST['info']['fujian']);

			$data = array(
				'neirong' => $neirong,
				'fujian' => $fujian,
				'updatetime' => time()
			);

			if ($info && $info['id']) {
				// 更新现有记录
				$result = $this->db->update($data, " id=" . $info['id']);
				if ($result !== false) {
					showmessage('修改成功', '?m=renshi&c=geren&a=addsx');
				} else {
					showmessage('修改失败', HTTP_REFERER);
				}
			} else {
				// 新增记录
				$data['addtime'] = time();
				$data['create_datetime'] = date('Y-m-d H:i:s');
				$data['create_year'] = intval(date('Y'));
				$data['create_month'] = intval(date('m'));
				$data['create_day'] = intval(date('d'));
				$result = $this->db->insert($data);
				if ($result) {
					showmessage('添加成功', '?m=renshi&c=geren&a=addsx');
				} else {
					showmessage('添加失败', HTTP_REFERER);
				}
			}
			exit;
		}

		// 处理附件图片URL（支持JSON格式多图片）
		if ($info && !empty($info['fujian'])) {
			$upload_url = pc_base::load_config('system', 'upload_url');
			$fujian_array = json_decode($info['fujian'], true);
			if (is_array($fujian_array)) {
				foreach ($fujian_array as &$url) {
					if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
						$url = $upload_url . str_replace('uploadfile/', '', $url);
					}
				}
				$info['fujian'] = json_encode($fujian_array);
			} else {
				if (strpos($info['fujian'], 'http://') !== 0 && strpos($info['fujian'], 'https://') !== 0) {
					$info['fujian'] = $upload_url . str_replace('uploadfile/', '', $info['fujian']);
				}
			}
		}

		$this->info = $info;
		include $this->admin_tpl('dangweijieshao_form');
	}

	// 党委介绍图片上传
	public function upload_dangwei_image()
	{
		header('Content-Type: application/json; charset=utf-8');

		if (!isset($_FILES['file'])) {
			echo json_encode(array('status' => 0, 'msg' => '未选择文件'));
			exit;
		}

		$file = $_FILES['file'];

		// 检查上传错误
		if ($file['error'] !== UPLOAD_ERR_OK) {
			echo json_encode(array('status' => 0, 'msg' => '上传失败，错误代码：' . $file['error']));
			exit;
		}

		// 检查文件类型
		$allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
		if (!in_array($file['type'], $allowed_types)) {
			echo json_encode(array('status' => 0, 'msg' => '只允许上传图片文件'));
			exit;
		}

		// 扩展名白名单验证
		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		$allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
		if (!in_array($ext, $allowed_exts)) {
			echo json_encode(array('status' => 0, 'msg' => '只允许上传 jpg、jpeg、png、gif 格式的图片'));
			exit;
		}

		// 检查文件大小（限制5MB）
		if ($file['size'] > 5 * 1024 * 1024) {
			echo json_encode(array('status' => 0, 'msg' => '文件大小不能超过5MB'));
			exit;
		}

		// 生成保存路径
		$upload_path = 'uploadfile/renshi/dangwei/' . date('Y/md') . '/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, true);
		}

		// 生成文件名
		$filename = date('YmdHis') . '_' . rand(1000, 9999) . '.' . $ext;
		$filepath = $upload_path . $filename;

		// 移动上传文件
		if (move_uploaded_file($file['tmp_name'], $filepath)) {
			echo json_encode(array(
				'status' => 1,
				'msg' => '上传成功',
				'url' => $filepath
			));
		} else {
			echo json_encode(array('status' => 0, 'msg' => '文件保存失败'));
		}
		exit;
	}

	// ==================== 落实全面从严治党工作 ====================

	// 落实全面从严治党工作 - 列表
	function addsx2()
	{
		setcookie('zq_hash', $_SESSION['pc_hash']);

		// 分页参数
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

		// 查询记录
		$this->db->table_name = 'v9_congyanzhidang';
		$list = $this->db->listinfo('', 'id DESC', $page, 15);
		$pages = $this->db->pages;

		// 处理数据
		if (is_array($list)) {
			foreach ($list as &$item) {
				// 处理时间格式
				if ($item['content_time'] > 0) {
					$item['content_time_show'] = date("Y-m-d", $item['content_time']);
				} else {
					$item['content_time_show'] = '';
				}

				// 参会人员显示（只显示前3个）
				if (!empty($item['canhui_renyuan'])) {
					$renyuan_arr = explode(',', $item['canhui_renyuan']);
					$item['canhui_renyuan_show'] = count($renyuan_arr) > 3
						? implode('、', array_slice($renyuan_arr, 0, 3)) . '...'
						: implode('、', $renyuan_arr);
				} else {
					$item['canhui_renyuan_show'] = '';
				}

				// 处理附件图片URL（支持JSON格式多图片）
				if (!empty($item['fujian'])) {
					$upload_url = pc_base::load_config('system', 'upload_url');
					$fujian_array = json_decode($item['fujian'], true);
					if (is_array($fujian_array)) {
						foreach ($fujian_array as &$url) {
							if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
								$fujian_path = str_replace('uploadfile/', '', $url);
								$url = $upload_url . $fujian_path;
							}
						}
						$item['fujian'] = json_encode($fujian_array);
					}
				}
			}
		}

		$this->list = $list;
		$this->pages = $pages;
		include $this->admin_tpl('congyanzhidang_list');
	}

	// 落实全面从严治党工作 - 添加页面
	public function addsx2_add()
	{
		// 加载辅警列表（用于参会人员选择）
		$this->db->table_name = 'v9_fujing';
		$fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
		$this->fjlist = $fjlist;

		include $this->admin_tpl('congyanzhidang_add');
	}

	// 落实全面从严治党工作 - 添加保存
	public function addsx2_addsave()
	{
		if (isset($_POST['dosubmit'])) {
			$canhui_renyuan = isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '';
			$theme = trim($_POST['info']['theme']);
			$content_time = strtotime($_POST['info']['content_time']);
			$neirong = trim($_POST['info']['neirong']);
			$fujian = trim($_POST['info']['fujian']);

			if (!$theme) {
				showmessage('请输入主题', HTTP_REFERER);
			}

			$data = array(
				'canhui_renyuan' => $canhui_renyuan,
				'theme' => $theme,
				'content_time' => $content_time,
				'neirong' => $neirong,
				'fujian' => $fujian,
				'addtime' => time(),
				'updatetime' => time(),
				'create_datetime' => date('Y-m-d H:i:s'),
				'create_year' => intval(date('Y')),
				'create_month' => intval(date('m')),
				'create_day' => intval(date('d'))
			);

			$this->db->table_name = 'v9_congyanzhidang';
			$result = $this->db->insert($data);

			if ($result) {
				showmessage('添加成功', '?m=renshi&c=geren&a=addsx2');
			} else {
				showmessage('添加失败', HTTP_REFERER);
			}
		}
	}

	// 落实全面从严治党工作 - 编辑页面
	public function addsx2_edit()
	{
		$id = intval($_GET['id']);
		if (!$id) {
			showmessage('参数错误', HTTP_REFERER);
		}

		$this->db->table_name = 'v9_congyanzhidang';
		$info = $this->db->get_one(" id=$id ");

		if (!$info) {
			showmessage('记录不存在', HTTP_REFERER);
		}

		// 处理时间格式显示
		if ($info['content_time'] > 0) {
			$info['content_time_show'] = date('Y-m-d', $info['content_time']);
		}

		// 处理附件图片URL（支持JSON格式多图片）
		if (!empty($info['fujian'])) {
			$upload_url = pc_base::load_config('system', 'upload_url');
			$fujian_array = json_decode($info['fujian'], true);
			if (is_array($fujian_array)) {
				foreach ($fujian_array as &$url) {
					if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
						$fujian_path = str_replace('uploadfile/', '', $url);
						$url = $upload_url . $fujian_path;
					}
				}
				$info['fujian'] = json_encode($fujian_array);
			}
		}

		// 加载辅警列表
		$this->db->table_name = 'v9_fujing';
		$fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
		$this->fjlist = $fjlist;

		$this->info = $info;
		include $this->admin_tpl('congyanzhidang_edit');
	}

	// 落实全面从严治党工作 - 编辑保存
	public function addsx2_editsave()
	{
		if (isset($_POST['dosubmit'])) {
			$id = intval($_POST['id']);
			if (!$id) {
				showmessage('参数错误', HTTP_REFERER);
			}

			$canhui_renyuan = isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '';
			$theme = trim($_POST['info']['theme']);
			$content_time = strtotime($_POST['info']['content_time']);
			$neirong = trim($_POST['info']['neirong']);
			$fujian = trim($_POST['info']['fujian']);

			if (!$theme) {
				showmessage('请输入主题', HTTP_REFERER);
			}

			$data = array(
				'canhui_renyuan' => $canhui_renyuan,
				'theme' => $theme,
				'content_time' => $content_time,
				'neirong' => $neirong,
				'fujian' => $fujian,
				'updatetime' => time()
			);

			$this->db->table_name = 'v9_congyanzhidang';
			$result = $this->db->update($data, " id=$id ");

			if ($result !== false) {
				showmessage('修改成功', '?m=renshi&c=geren&a=addsx2');
			} else {
				showmessage('修改失败', HTTP_REFERER);
			}
		}
	}

	// 落实全面从严治党工作 - 删除
	public function addsx2_del()
	{
		$id = intval($_GET['id']);
		if (!$id) {
			showmessage('参数错误', HTTP_REFERER);
		}

		$this->db->table_name = 'v9_congyanzhidang';
		$result = $this->db->delete(" id=$id ");

		if ($result) {
			showmessage('删除成功', '?m=renshi&c=geren&a=addsx2');
		} else {
			showmessage('删除失败', HTTP_REFERER);
		}
	}

	// 上传落实全面从严治党工作附件图片
	public function upload_congyanzhidang_image()
	{
		header('Content-Type: application/json; charset=utf-8');

		if (!isset($_FILES['file'])) {
			echo json_encode(array('status' => 0, 'msg' => '未选择文件'));
			exit;
		}

		$file = $_FILES['file'];

		// 检查上传错误
		if ($file['error'] !== UPLOAD_ERR_OK) {
			echo json_encode(array('status' => 0, 'msg' => '上传失败，错误代码：' . $file['error']));
			exit;
		}

		// 检查文件类型
		$allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
		if (!in_array($file['type'], $allowed_types)) {
			echo json_encode(array('status' => 0, 'msg' => '只允许上传图片文件'));
			exit;
		}

		// 扩展名白名单验证
		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		$allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
		if (!in_array($ext, $allowed_exts)) {
			echo json_encode(array('status' => 0, 'msg' => '只允许上传 jpg、jpeg、png、gif 格式的图片'));
			exit;
		}

		// 检查文件大小（限制5MB）
		if ($file['size'] > 5 * 1024 * 1024) {
			echo json_encode(array('status' => 0, 'msg' => '文件大小不能超过5MB'));
			exit;
		}

		// 生成保存路径
		$upload_path = 'uploadfile/renshi/congyanzhidang/' . date('Y/md') . '/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, true);
		}

		// 生成文件名
		$filename = date('YmdHis') . '_' . rand(1000, 9999) . '.' . $ext;
		$filepath = $upload_path . $filename;

		// 移动上传文件
		if (move_uploaded_file($file['tmp_name'], $filepath)) {
			echo json_encode(array(
				'status' => 1,
				'msg' => '上传成功',
				'url' => $filepath
			));
		} else {
			echo json_encode(array('status' => 0, 'msg' => '文件保存失败'));
		}
		exit;
	}

	// 搜索辅警（用于参会人员搜索）
	public function search_fujing_congyanzhidang()
	{
		header('Content-Type: application/json; charset=utf-8');

		$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
		if (empty($keyword)) {
			echo json_encode(array('status' => 0, 'data' => array()));
			exit;
		}

		$this->db->table_name = 'v9_fujing';
		$list = $this->db->select(" status=1 AND isok=1 AND xingming LIKE '%" . addslashes($keyword) . "%' ", 'id,xingming,sfz,sex,ddanwei', 20, 'xingming asc');

		$result = array();
		if (is_array($list)) {
			foreach ($list as $item) {
				$result[] = array(
					'id' => $item['id'],
					'name' => $item['xingming'],
					'sfz' => $item['sfz'],
					'sex' => $item['sex'],
					'danwei' => $item['ddanwei']
				);
			}
		}

		echo json_encode(array('status' => 1, 'data' => $result));
		exit;
	}

	// ==================== 意识形态工作 ====================

	// 意识形态工作 - 列表
	function addsx3()
	{
		setcookie('zq_hash', $_SESSION['pc_hash']);

		// 分页参数
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

		// 查询记录
		$this->db->table_name = 'v9_yishixingtai';
		$list = $this->db->listinfo('', 'id DESC', $page, 15);
		$pages = $this->db->pages;

		// 处理数据
		if (is_array($list)) {
			foreach ($list as &$item) {
				// 处理时间格式
				if ($item['content_time'] > 0) {
					$item['content_time_show'] = date("Y-m-d", $item['content_time']);
				} else {
					$item['content_time_show'] = '';
				}

				// 参会人员显示（只显示前3个）
				if (!empty($item['canhui_renyuan'])) {
					$renyuan_arr = explode(',', $item['canhui_renyuan']);
					$item['canhui_renyuan_show'] = count($renyuan_arr) > 3
						? implode('、', array_slice($renyuan_arr, 0, 3)) . '...'
						: implode('、', $renyuan_arr);
				} else {
					$item['canhui_renyuan_show'] = '';
				}

				// 处理附件图片URL
				if (!empty($item['fujian'])) {
					$upload_url = pc_base::load_config('system', 'upload_url');
					$fujian_array = json_decode($item['fujian'], true);
					if (is_array($fujian_array)) {
						foreach ($fujian_array as &$url) {
							if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
								$fujian_path = str_replace('uploadfile/', '', $url);
								$url = $upload_url . $fujian_path;
							}
						}
						$item['fujian'] = json_encode($fujian_array);
					}
				}
			}
		}

		$this->list = $list;
		$this->pages = $pages;
		include $this->admin_tpl('yishixingtai_list');
	}

	// 意识形态工作 - 添加页面
	public function addsx3_add()
	{
		$this->db->table_name = 'v9_fujing';
		$fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
		$this->fjlist = $fjlist;

		include $this->admin_tpl('yishixingtai_add');
	}

	// 意识形态工作 - 添加保存
	public function addsx3_addsave()
	{
		if (isset($_POST['dosubmit'])) {
			$canhui_renyuan = isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '';
			$theme = trim($_POST['info']['theme']);
			$content_time = strtotime($_POST['info']['content_time']);
			$neirong = trim($_POST['info']['neirong']);
			$fujian = trim($_POST['info']['fujian']);

			if (!$theme) {
				showmessage('请输入主题', HTTP_REFERER);
			}

			$data = array(
				'canhui_renyuan' => $canhui_renyuan,
				'theme' => $theme,
				'content_time' => $content_time,
				'neirong' => $neirong,
				'fujian' => $fujian,
				'addtime' => time(),
				'updatetime' => time(),
				'create_datetime' => date('Y-m-d H:i:s'),
				'create_year' => intval(date('Y')),
				'create_month' => intval(date('m')),
				'create_day' => intval(date('d'))
			);

			$this->db->table_name = 'v9_yishixingtai';
			$result = $this->db->insert($data);

			if ($result) {
				showmessage('添加成功', '?m=renshi&c=geren&a=addsx3');
			} else {
				showmessage('添加失败', HTTP_REFERER);
			}
		}
	}

	// 意识形态工作 - 编辑页面
	public function addsx3_edit()
	{
		$id = intval($_GET['id']);
		if (!$id) {
			showmessage('参数错误', HTTP_REFERER);
		}

		$this->db->table_name = 'v9_yishixingtai';
		$info = $this->db->get_one(" id=$id ");

		if (!$info) {
			showmessage('记录不存在', HTTP_REFERER);
		}

		if ($info['content_time'] > 0) {
			$info['content_time_show'] = date('Y-m-d', $info['content_time']);
		}

		if (!empty($info['fujian'])) {
			$upload_url = pc_base::load_config('system', 'upload_url');
			$fujian_array = json_decode($info['fujian'], true);
			if (is_array($fujian_array)) {
				foreach ($fujian_array as &$url) {
					if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
						$fujian_path = str_replace('uploadfile/', '', $url);
						$url = $upload_url . $fujian_path;
					}
				}
				$info['fujian'] = json_encode($fujian_array);
			}
		}

		$this->db->table_name = 'v9_fujing';
		$fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
		$this->fjlist = $fjlist;

		$this->info = $info;
		include $this->admin_tpl('yishixingtai_edit');
	}

	// 意识形态工作 - 编辑保存
	public function addsx3_editsave()
	{
		if (isset($_POST['dosubmit'])) {
			$id = intval($_POST['id']);
			if (!$id) {
				showmessage('参数错误', HTTP_REFERER);
			}

			$canhui_renyuan = isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '';
			$theme = trim($_POST['info']['theme']);
			$content_time = strtotime($_POST['info']['content_time']);
			$neirong = trim($_POST['info']['neirong']);
			$fujian = trim($_POST['info']['fujian']);

			if (!$theme) {
				showmessage('请输入主题', HTTP_REFERER);
			}

			$data = array(
				'canhui_renyuan' => $canhui_renyuan,
				'theme' => $theme,
				'content_time' => $content_time,
				'neirong' => $neirong,
				'fujian' => $fujian,
				'updatetime' => time()
			);

			$this->db->table_name = 'v9_yishixingtai';
			$result = $this->db->update($data, " id=$id ");

			if ($result !== false) {
				showmessage('修改成功', '?m=renshi&c=geren&a=addsx3');
			} else {
				showmessage('修改失败', HTTP_REFERER);
			}
		}
	}

	// 意识形态工作 - 删除
	public function addsx3_del()
	{
		$id = intval($_GET['id']);
		if (!$id) {
			showmessage('参数错误', HTTP_REFERER);
		}

		$this->db->table_name = 'v9_yishixingtai';
		$result = $this->db->delete(" id=$id ");

		if ($result) {
			showmessage('删除成功', '?m=renshi&c=geren&a=addsx3');
		} else {
			showmessage('删除失败', HTTP_REFERER);
		}
	}

	// 意识形态工作 - 图片上传
	public function upload_yishixingtai_image()
	{
		header('Content-Type: application/json; charset=utf-8');

		if (!isset($_FILES['file'])) {
			echo json_encode(array('status' => 0, 'msg' => '未选择文件'));
			exit;
		}

		$file = $_FILES['file'];

		if ($file['error'] !== UPLOAD_ERR_OK) {
			echo json_encode(array('status' => 0, 'msg' => '上传失败，错误代码：' . $file['error']));
			exit;
		}

		$allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
		if (!in_array($file['type'], $allowed_types)) {
			echo json_encode(array('status' => 0, 'msg' => '只允许上传图片文件'));
			exit;
		}

		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		$allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
		if (!in_array($ext, $allowed_exts)) {
			echo json_encode(array('status' => 0, 'msg' => '只允许上传 jpg、jpeg、png、gif 格式的图片'));
			exit;
		}

		if ($file['size'] > 5 * 1024 * 1024) {
			echo json_encode(array('status' => 0, 'msg' => '文件大小不能超过5MB'));
			exit;
		}

		$upload_path = 'uploadfile/renshi/yishixingtai/' . date('Y/md') . '/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, true);
		}

		$filename = date('YmdHis') . '_' . rand(1000, 9999) . '.' . $ext;
		$filepath = $upload_path . $filename;

		if (move_uploaded_file($file['tmp_name'], $filepath)) {
			echo json_encode(array(
				'status' => 1,
				'msg' => '上传成功',
				'url' => $filepath
			));
		} else {
			echo json_encode(array('status' => 0, 'msg' => '文件保存失败'));
		}
		exit;
	}

	// 意识形态工作 - 搜索辅警
	public function search_fujing_yishixingtai()
	{
		header('Content-Type: application/json; charset=utf-8');

		$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
		if (empty($keyword)) {
			echo json_encode(array('status' => 0, 'data' => array()));
			exit;
		}

		$this->db->table_name = 'v9_fujing';
		$list = $this->db->select(" status=1 AND isok=1 AND xingming LIKE '%" . addslashes($keyword) . "%' ", 'id,xingming,sfz,sex,ddanwei', 20, 'xingming asc');

		$result = array();
		if (is_array($list)) {
			foreach ($list as $item) {
				$result[] = array(
					'id' => $item['id'],
					'name' => $item['xingming'],
					'sfz' => $item['sfz'],
					'sex' => $item['sex'],
					'danwei' => $item['ddanwei']
				);
			}
		}

		echo json_encode(array('status' => 1, 'data' => $result));
		exit;
	}

	// ==================== 主题活动 ====================

	// 主题活动 - 列表
	function addsx4()
	{
		setcookie('zq_hash', $_SESSION['pc_hash']);
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

		$this->db->table_name = 'v9_zhutihuodong';
		$list = $this->db->listinfo('', 'id DESC', $page, 15);
		$pages = $this->db->pages;

		if (is_array($list)) {
			foreach ($list as &$item) {
				$item['content_time_show'] = $item['content_time'] > 0 ? date("Y-m-d", $item['content_time']) : '';

				if (!empty($item['canhui_renyuan'])) {
					$renyuan_arr = explode(',', $item['canhui_renyuan']);
					$item['canhui_renyuan_show'] = count($renyuan_arr) > 3
						? implode('、', array_slice($renyuan_arr, 0, 3)) . '...'
						: implode('、', $renyuan_arr);
				} else {
					$item['canhui_renyuan_show'] = '';
				}

				if (!empty($item['fujian'])) {
					$upload_url = pc_base::load_config('system', 'upload_url');
					$fujian_array = json_decode($item['fujian'], true);
					if (is_array($fujian_array)) {
						foreach ($fujian_array as &$url) {
							if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
								$url = $upload_url . str_replace('uploadfile/', '', $url);
							}
						}
						$item['fujian'] = json_encode($fujian_array);
					}
				}
			}
		}

		$this->list = $list;
		$this->pages = $pages;
		include $this->admin_tpl('zhutihuodong_list');
	}

	public function addsx4_add()
	{
		$this->db->table_name = 'v9_fujing';
		$this->fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
		include $this->admin_tpl('zhutihuodong_add');
	}

	public function addsx4_addsave()
	{
		if (isset($_POST['dosubmit'])) {
			$theme = trim($_POST['info']['theme']);
			if (!$theme) {
				showmessage('请输入主题', HTTP_REFERER);
			}

			$data = array(
				'canhui_renyuan' => isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '',
				'theme' => $theme,
				'content_time' => strtotime($_POST['info']['content_time']),
				'neirong' => trim($_POST['info']['neirong']),
				'fujian' => trim($_POST['info']['fujian']),
				'addtime' => time(),
				'updatetime' => time(),
				'create_datetime' => date('Y-m-d H:i:s'),
				'create_year' => intval(date('Y')),
				'create_month' => intval(date('m')),
				'create_day' => intval(date('d'))
			);

			$this->db->table_name = 'v9_zhutihuodong';
			if ($this->db->insert($data)) {
				showmessage('添加成功', '?m=renshi&c=geren&a=addsx4');
			} else {
				showmessage('添加失败', HTTP_REFERER);
			}
		}
	}

	public function addsx4_edit()
	{
		$id = intval($_GET['id']);
		if (!$id) {
			showmessage('参数错误', HTTP_REFERER);
		}

		$this->db->table_name = 'v9_zhutihuodong';
		$info = $this->db->get_one(" id=$id ");
		if (!$info) {
			showmessage('记录不存在', HTTP_REFERER);
		}

		$info['content_time_show'] = $info['content_time'] > 0 ? date('Y-m-d', $info['content_time']) : '';

		if (!empty($info['fujian'])) {
			$upload_url = pc_base::load_config('system', 'upload_url');
			$fujian_array = json_decode($info['fujian'], true);
			if (is_array($fujian_array)) {
				foreach ($fujian_array as &$url) {
					if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
						$url = $upload_url . str_replace('uploadfile/', '', $url);
					}
				}
				$info['fujian'] = json_encode($fujian_array);
			}
		}

		$this->db->table_name = 'v9_fujing';
		$this->fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
		$this->info = $info;
		include $this->admin_tpl('zhutihuodong_edit');
	}

	public function addsx4_editsave()
	{
		if (isset($_POST['dosubmit'])) {
			$id = intval($_POST['id']);
			if (!$id) {
				showmessage('参数错误', HTTP_REFERER);
			}

			$theme = trim($_POST['info']['theme']);
			if (!$theme) {
				showmessage('请输入主题', HTTP_REFERER);
			}

			$data = array(
				'canhui_renyuan' => isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '',
				'theme' => $theme,
				'content_time' => strtotime($_POST['info']['content_time']),
				'neirong' => trim($_POST['info']['neirong']),
				'fujian' => trim($_POST['info']['fujian']),
				'updatetime' => time()
			);

			$this->db->table_name = 'v9_zhutihuodong';
			if ($this->db->update($data, " id=$id ") !== false) {
				showmessage('修改成功', '?m=renshi&c=geren&a=addsx4');
			} else {
				showmessage('修改失败', HTTP_REFERER);
			}
		}
	}

	public function addsx4_del()
	{
		$id = intval($_GET['id']);
		if (!$id) {
			showmessage('参数错误', HTTP_REFERER);
		}

		$this->db->table_name = 'v9_zhutihuodong';
		if ($this->db->delete(" id=$id ")) {
			showmessage('删除成功', '?m=renshi&c=geren&a=addsx4');
		} else {
			showmessage('删除失败', HTTP_REFERER);
		}
	}

	public function upload_zhutihuodong_image()
	{
		header('Content-Type: application/json; charset=utf-8');

		if (!isset($_FILES['file'])) {
			echo json_encode(array('status' => 0, 'msg' => '未选择文件'));
			exit;
		}

		$file = $_FILES['file'];
		if ($file['error'] !== UPLOAD_ERR_OK) {
			echo json_encode(array('status' => 0, 'msg' => '上传失败，错误代码：' . $file['error']));
			exit;
		}

		$allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
		if (!in_array($file['type'], $allowed_types)) {
			echo json_encode(array('status' => 0, 'msg' => '只允许上传图片文件'));
			exit;
		}

		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
			echo json_encode(array('status' => 0, 'msg' => '只允许上传 jpg、jpeg、png、gif 格式'));
			exit;
		}

		if ($file['size'] > 5 * 1024 * 1024) {
			echo json_encode(array('status' => 0, 'msg' => '文件大小不能超过5MB'));
			exit;
		}

		$upload_path = 'uploadfile/renshi/zhutihuodong/' . date('Y/md') . '/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, true);
		}

		$filename = date('YmdHis') . '_' . rand(1000, 9999) . '.' . $ext;
		$filepath = $upload_path . $filename;

		if (move_uploaded_file($file['tmp_name'], $filepath)) {
			echo json_encode(array('status' => 1, 'msg' => '上传成功', 'url' => $filepath));
		} else {
			echo json_encode(array('status' => 0, 'msg' => '文件保存失败'));
		}
		exit;
	}

	public function search_fujing_zhutihuodong()
	{
		header('Content-Type: application/json; charset=utf-8');

		$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
		if (empty($keyword)) {
			echo json_encode(array('status' => 0, 'data' => array()));
			exit;
		}

		$this->db->table_name = 'v9_fujing';
		$list = $this->db->select(" status=1 AND isok=1 AND xingming LIKE '%" . addslashes($keyword) . "%' ", 'id,xingming,sfz,sex,ddanwei', 20, 'xingming asc');

		$result = array();
		if (is_array($list)) {
			foreach ($list as $item) {
				$result[] = array('id' => $item['id'], 'name' => $item['xingming'], 'sfz' => $item['sfz'], 'sex' => $item['sex'], 'danwei' => $item['ddanwei']);
			}
		}

		echo json_encode(array('status' => 1, 'data' => $result));
		exit;
	}

	// ==================== 专项工作 ====================

	function addsx5()
	{
		setcookie('zq_hash', $_SESSION['pc_hash']);
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

		$this->db->table_name = 'v9_zhuanxianggongzuo';
		$list = $this->db->listinfo('', 'id DESC', $page, 15);
		$pages = $this->db->pages;

		if (is_array($list)) {
			foreach ($list as &$item) {
				$item['content_time_show'] = $item['meeting_time'] > 0 ? date("Y-m-d", $item['meeting_time']) : '';
				if (!empty($item['canhui_renyuan'])) {
					$renyuan_arr = explode(',', $item['canhui_renyuan']);
					$item['canhui_renyuan_show'] = count($renyuan_arr) > 3 ? implode('、', array_slice($renyuan_arr, 0, 3)) . '...' : implode('、', $renyuan_arr);
				} else {
					$item['canhui_renyuan_show'] = '';
				}
				if (!empty($item['fujian'])) {
					$upload_url = pc_base::load_config('system', 'upload_url');
					$fujian_array = json_decode($item['fujian'], true);
					if (is_array($fujian_array)) {
						foreach ($fujian_array as &$url) {
							if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
								$url = $upload_url . str_replace('uploadfile/', '', $url);
							}
						}
						$item['fujian'] = json_encode($fujian_array);
					}
				}
			}
		}

		$this->list = $list;
		$this->pages = $pages;
		include $this->admin_tpl('zhuanxianggongzuo_list');
	}

	public function addsx5_add()
	{
		$this->db->table_name = 'v9_fujing';
		$this->fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
		include $this->admin_tpl('zhuanxianggongzuo_add');
	}

	public function addsx5_addsave()
	{
		if (isset($_POST['dosubmit'])) {
			$theme = trim($_POST['info']['theme']);
			if (!$theme) { showmessage('请输入主题', HTTP_REFERER); }

			$data = array(
				'canhui_renyuan' => isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '',
				'theme' => $theme,
				'meeting_time' => strtotime($_POST['info']['content_time']),
				'content' => trim($_POST['info']['neirong']),
				'fujian' => trim($_POST['info']['fujian']),
				'addtime' => time(),
				'updatetime' => time(),
				'create_datetime' => date('Y-m-d H:i:s'),
				'create_year' => intval(date('Y')),
				'create_month' => intval(date('m')),
				'create_day' => intval(date('d'))
			);

			$this->db->table_name = 'v9_zhuanxianggongzuo';
			if ($this->db->insert($data)) {
				showmessage('添加成功', '?m=renshi&c=geren&a=addsx5');
			} else {
				showmessage('添加失败', HTTP_REFERER);
			}
		}
	}

	public function addsx5_edit()
	{
		$id = intval($_GET['id']);
		if (!$id) { showmessage('参数错误', HTTP_REFERER); }

		$this->db->table_name = 'v9_zhuanxianggongzuo';
		$info = $this->db->get_one(" id=$id ");
		if (!$info) { showmessage('记录不存在', HTTP_REFERER); }

		$info['content_time_show'] = $info['meeting_time'] > 0 ? date('Y-m-d', $info['meeting_time']) : '';
		$info['neirong'] = $info['content'];

		if (!empty($info['fujian'])) {
			$upload_url = pc_base::load_config('system', 'upload_url');
			$fujian_array = json_decode($info['fujian'], true);
			if (is_array($fujian_array)) {
				foreach ($fujian_array as &$url) {
					if (!empty($url) && strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
						$url = $upload_url . str_replace('uploadfile/', '', $url);
					}
				}
				$info['fujian'] = json_encode($fujian_array);
			}
		}

		$this->db->table_name = 'v9_fujing';
		$this->fjlist = $this->db->select(" status=1 AND isok=1 ", 'id,xingming', '', 'xingming asc');
		$this->info = $info;
		include $this->admin_tpl('zhuanxianggongzuo_edit');
	}

	public function addsx5_editsave()
	{
		if (isset($_POST['dosubmit'])) {
			$id = intval($_POST['id']);
			if (!$id) { showmessage('参数错误', HTTP_REFERER); }

			$theme = trim($_POST['info']['theme']);
			if (!$theme) { showmessage('请输入主题', HTTP_REFERER); }

			$data = array(
				'canhui_renyuan' => isset($_POST['info']['canhui_renyuan']) ? trim($_POST['info']['canhui_renyuan']) : '',
				'theme' => $theme,
				'meeting_time' => strtotime($_POST['info']['content_time']),
				'content' => trim($_POST['info']['neirong']),
				'fujian' => trim($_POST['info']['fujian']),
				'updatetime' => time()
			);

			$this->db->table_name = 'v9_zhuanxianggongzuo';
			if ($this->db->update($data, " id=$id ") !== false) {
				showmessage('修改成功', '?m=renshi&c=geren&a=addsx5');
			} else {
				showmessage('修改失败', HTTP_REFERER);
			}
		}
	}

	public function addsx5_del()
	{
		$id = intval($_GET['id']);
		if (!$id) { showmessage('参数错误', HTTP_REFERER); }

		$this->db->table_name = 'v9_zhuanxianggongzuo';
		if ($this->db->delete(" id=$id ")) {
			showmessage('删除成功', '?m=renshi&c=geren&a=addsx5');
		} else {
			showmessage('删除失败', HTTP_REFERER);
		}
	}

	public function upload_zhuanxianggongzuo_image()
	{
		header('Content-Type: application/json; charset=utf-8');
		if (!isset($_FILES['file'])) { echo json_encode(array('status' => 0, 'msg' => '未选择文件')); exit; }

		$file = $_FILES['file'];
		if ($file['error'] !== UPLOAD_ERR_OK) { echo json_encode(array('status' => 0, 'msg' => '上传失败，错误代码：' . $file['error'])); exit; }

		$allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
		if (!in_array($file['type'], $allowed_types)) { echo json_encode(array('status' => 0, 'msg' => '只允许上传图片文件')); exit; }

		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) { echo json_encode(array('status' => 0, 'msg' => '只允许上传 jpg、jpeg、png、gif 格式')); exit; }

		if ($file['size'] > 5 * 1024 * 1024) { echo json_encode(array('status' => 0, 'msg' => '文件大小不能超过5MB')); exit; }

		$upload_path = 'uploadfile/renshi/zhuanxianggongzuo/' . date('Y/md') . '/';
		if (!is_dir($upload_path)) { mkdir($upload_path, 0755, true); }

		$filename = date('YmdHis') . '_' . rand(1000, 9999) . '.' . $ext;
		$filepath = $upload_path . $filename;

		if (move_uploaded_file($file['tmp_name'], $filepath)) {
			echo json_encode(array('status' => 1, 'msg' => '上传成功', 'url' => $filepath));
		} else {
			echo json_encode(array('status' => 0, 'msg' => '文件保存失败'));
		}
		exit;
	}

	public function search_fujing_zhuanxianggongzuo()
	{
		header('Content-Type: application/json; charset=utf-8');
		$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
		if (empty($keyword)) { echo json_encode(array('status' => 0, 'data' => array())); exit; }

		$this->db->table_name = 'v9_fujing';
		$list = $this->db->select(" status=1 AND isok=1 AND xingming LIKE '%" . addslashes($keyword) . "%' ", 'id,xingming,sfz,sex,ddanwei', 20, 'xingming asc');

		$result = array();
		if (is_array($list)) {
			foreach ($list as $item) {
				$result[] = array('id' => $item['id'], 'name' => $item['xingming'], 'sfz' => $item['sfz'], 'sex' => $item['sex'], 'danwei' => $item['ddanwei']);
			}
		}

		echo json_encode(array('status' => 1, 'data' => $result));
		exit;
	}

	//补录辅警  正常情况下不使用本过程		
	function add()
	{
		if(isset($_POST['dosubmit'])) {
			
		
			$_POST['info']['inputuser']=param::get_cookie('admin_username');
			$_POST['info']['inputtime']=time();
			$_POST['info']['rjtime']=strtotime($_POST['rjtime']);
			$_POST['info']['rdtime']=strtotime($_POST['rdtime']);
			$_POST['info']['rdzztime']=strtotime($_POST['rdzztime']);
			$_POST['info']['gzzztime']=strtotime($_POST['gzzztime']);
			$_POST['info']['gzztime']=strtotime($_POST['gzztime']);
			$_POST['info']['scgztime']=strtotime($_POST['scgztime']);
			$_POST['info']['shengri']=strtotime($_POST['shengri']);
		$this->db->insert($_POST['info']);
			
			
			showmessage('添加成功','index.php?m=fujing&c=fujing&status=1');
		}
		
			//邦定层级
		$this->db->table_name = 'v9_cengji';
		$rss = $this->db->select("",'id,cjname','','id asc');
		$cengji=array();
		
		foreach($rss as $aaa){
			$cengji[$aaa['id']]=$aaa['cjname'];
			
			}
		
		//邦定岗位类别
		$this->db->table_name = 'v9_gangwei';
		$rss = $this->db->select("",'id,gwname','','id asc');
		$gangwei=array();
		
		foreach($rss as $aaa){
			$gangwei[$aaa['id']]=$aaa['gwname'];	
			}
			
		//邦定辅助岗位
		$this->db->table_name = 'v9_gangweifz';
		$rss = $this->db->select("",'id,gwname','','id asc');
		
		foreach($rss as $aaa){
			$gangweifz[$aaa['id']]=$aaa['gwname'];
			
			}
			
		//邦定学历
		$this->db->table_name = 'v9_xueli';
		$rss = $this->db->select("",'id,gwname','','id asc');
		
		foreach($rss as $aaa){
			$xueli[$aaa['id']]=$aaa['gwname'];
			}			
						
		//邦定职务
		$this->db->table_name = 'v9_zhiwu';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu=array();
		
		foreach($rss as $aaa){
			$zhiwu[$aaa['id']]=$aaa['zwname'];
			
			}		
			//绑定组织tree
			$show_validator = '';
			$tree = pc_base::load_sys_class('tree');
			$this->db = pc_base::load_model('bumen_model');
			
			if($_SESSION['roleid']>5){
		      $where .= "  id in(1,".$_SESSION['bmid'].")";
		    }
			
			$result = $this->db->select($where);
			
			$array = array();
			foreach($result as $r) {
				$r['cname'] = $r['name'];
				if($_SESSION['roleid']>5){
				 $r['selected'] = $r['id'] == $_SESSION['bmid'] ? 'selected' : '';
				}else{
				  $r['selected'] = $r['id'] == 2 ? 'selected' : '';
				}
				$array[] = $r;
			}
			$str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
			$tree->init($array);
			$select_categorys = $tree->get_tree(0, $str);
			
		include $this->admin_tpl('add_fujing');
	}
	
	function edit()
	{
		
		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
			$_POST['info']['rjtime']=strtotime($_POST['rjtime']);
			$_POST['info']['rdtime']=strtotime($_POST['rdtime']);
			$_POST['info']['rdzztime']=strtotime($_POST['rdzztime']);
			$_POST['info']['gzzztime']=strtotime($_POST['gzzztime']);
			$_POST['info']['gzztime']=strtotime($_POST['gzztime']);
			$_POST['info']['scgztime']=strtotime($_POST['scgztime']);
			$_POST['info']['shengri']=strtotime($_POST['shengri']);
			//////////////////////////////////
			$_POST['info']['pingdangtime']=strtotime($_POST['pingdangtime']);
			$_POST['info']['pingjitime']=strtotime($_POST['pingjitime']);
			//////////////////////////////////
			if($_POST['info']['status']==2){ //离职状态
			 $_POST['info']['lizhitime']=strtotime($_POST['lizhitime']);
			 $_POST['info']['lizhiyuanyin']=$_POST['lizhiyuanyin'];	
				}
			
			$this->db->update($_POST['info'],array('id'=>$id));
			
			showmessage('操作完毕','index.php?m=fujing&c=fujing&status='.$_REQUEST['status']);
		}
		$fujing = $this->db->get_one("id=$id",'*');
		
		//邦定层级
		$this->db->table_name = 'v9_cengji';
		$rss = $this->db->select("",'id,cjname','','id asc');
		$cengji=array();
		
		foreach($rss as $aaa){
			$cengji[$aaa['id']]=$aaa['cjname'];
			
			}
		//邦定岗位
		$this->db->table_name = 'v9_gangwei';
		$rss = $this->db->select("",'id,gwname','','id asc');
		$gangwei=array();
		
		foreach($rss as $aaa){
			$gangwei[$aaa['id']]=$aaa['gwname'];
			
			}
		//邦定职务
		$this->db->table_name = 'v9_zhiwu';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu=array();
		
		foreach($rss as $aaa){
			$zhiwu[$aaa['id']]=$aaa['zwname'];
			
			}

		//邦定辅助岗位
		$this->db->table_name = 'v9_gangweifz';
		$rss = $this->db->select("",'id,gwname','','id asc');
		
		foreach($rss as $aaa){
			$gangweifz[$aaa['id']]=$aaa['gwname'];
			
			}
			
		//邦定学历
		$this->db->table_name = 'v9_xueli';
		$rss = $this->db->select("",'id,gwname','','id asc');
		
		foreach($rss as $aaa){
			$xueli[$aaa['id']]=$aaa['gwname'];
			}	
			
		//邦定岗位等级
		
		$this->db->table_name = 'v9_gwdj';
		$rss = $this->db->select("",'id,cjname','','id asc');
		
		foreach($rss as $aaa){
			$gwdj[$aaa['id']]=$aaa['cjname'];
			}				
						
		 //绑定组织
		 $this->db = pc_base::load_model('bumen_model');
		
		$rss = $this->db->select("",'id,name,parentid','','listorder asc');
		$bms=array();
		
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			
			}
			
			//绑定组织tree
			$show_validator = '';
			$tree = pc_base::load_sys_class('tree');
			$this->db = pc_base::load_model('bumen_model');
					
			$result = $this->db->select();
			
			$array = array();
			foreach($result as $r) {
				$r['cname'] = $r['name'];
				  $r['selected'] = $r['id'] == $fujing['dwid'] ? 'selected' : '';
				$array[] = $r;
			}
			$str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
			$tree->init($array);
			$select_categorys = $tree->get_tree(0, $str);			

			
		include $this->admin_tpl('edit_fujing');
	}
	
	
	function show()
	{
		include $this->admin_tpl('edit_geren');
	}
	
	function shenhe()
	{
		include $this->admin_tpl('edit_geren');
	}	
	
	function dels()
	{
		$id = $_GET['id'];
		$this->db->table_name = 'v9_renshi_sx';
		$this->db->update("isok=0",array('id'=>$id));
		showmessage('操作完成','index.php?m=renshi&c=geren&a=init');	
	}	
	///////////////////////////////////////////////////////////////////
	function lvli()
	{
		$id=$_GET['id'];
		
		$this->db->table_name = 'v9_lvlib';
		
		if($_POST['dook']!=""){
		 $inarr['fjid']=intval($_POST['fjid']);
		 $inarr['lvli']=$_POST['in']['lvli'];
		 $inarr['indt']=time();
		 $inarr['inuser']=$_SESSION['userid'];	
		
		$this->db->insert($inarr);
		}
		
		if($_GET['dofei']!=""){
		 $lid=intval($_GET['dofei']);
		 $this->db->update("isok=0",array('id'=>$lid));	
		}
		
		
		$peixun = $this->db->select(" fjid=$id and isok=1",'*','','id desc');
		
		include $this->admin_tpl('lvli');
	}	
	
	function techang()
	{
		$id=$_GET['id'];
		
		//取出类别
		$this->db->table_name = 'v9_techangclass';
		$tcclass= $this->db->select("",'id,classname,pid','','id asc');
		
		foreach($tcclass as $aaa){
			$tcclassys[$aaa['id']]=$aaa['classname'];
			}		
		
		$this->db->table_name = 'v9_techang';
		
		if($_POST['dook']!=""){
		 $inarr['fjid']=intval($_POST['fjid']);
		 $inarr['tcid']=$_POST['tcid'];
		 $inarr['xiangqing']=$_POST['in']['xiangqing'];
		 $inarr['zhengming']=$_POST['in']['zhengming'];
		 $inarr['indt']=time();
		 $inarr['inuser']=$_SESSION['userid'];	
		
		$this->db->insert($inarr);
		}
		
		if($_GET['dofei']!=""){
		 $lid=intval($_GET['dofei']);
		 $this->db->update("isok=0",array('id'=>$lid));	
		}
		
		
		$peixun = $this->db->select(" fjid=$id and isok=1",'*','','id desc');
		
		include $this->admin_tpl('techang');
	}	
	///////////////////////////////////////////////////////////////////
	function jiaoyu()
	{
		$id=$_GET['id'];
		
		$this->db->table_name = 'v9_peixun';
		$peixun = $this->db->select(" fjid=$id and status=9",'*','','id asc');
		
		include $this->admin_tpl('jiaoyu');
	}
	function jiashu()
	{
		$id=$_GET['id'];
		
		$this->db->table_name = 'v9_jiashu';
		//$jiashu = $this->db->select(" fjid=$id ",'*','','id asc');
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$jiashu = $this->db->listinfo(" fjid=$id ",$order = 'id desc',$page, $pages = '3');
		$pages = $this->db->pages;
		include $this->admin_tpl('jiashu');
	}
	function addjiashu()
	{
		if(isset($_POST['dosubmit'])) {
			
			$this->db->table_name = 'v9_fujing';
			$fj = $this->db->get_one("id=".$_POST['id'],'*');
			$_POST['info']['fjname']=$fj['xingming'];
			$_POST['info']['fjid']=$_POST['id'];
			$_POST['info']['userid']=$_SESSION['userid'];
			$_POST['info']['inputtime']=time();
			
		$this->db->table_name = 'v9_jiashu';
		$this->db->insert($_POST['info']);
			
			
			showmessage('操作完毕','index.php?m=fujing&c=fujing&a=jiashu&id='.$_POST['id']);
		}
		
	}
	function deletejiashu()
	{
		$id = $_GET['id'];
		$this->db->table_name = 'v9_jiashu';
		if($this->db->delete(array('id'=>$_GET['id']))) {
			
			exit('1');
		} else {
			exit('0');
		}
	}
	function biaozhang()
	{
		$id=$_GET['id'];
		
		$this->db->table_name = 'v9_biaozhang';
		$biaozhang = $this->db->select(" fjid=$id and status=9  ",'*','','id asc');
		
		include $this->admin_tpl('biaozhang');
	}
	function chengjie()
	{
		$id=$_GET['id'];
		
		$this->db->table_name = 'v9_chengjie';
		$chengjie = $this->db->select(" fjid=$id and status=9  ",'*','','id asc');
		
		include $this->admin_tpl('chengjie');
	}
	function zhuangbei()
	{
		$id=$_GET['id'];
		
		$this->db->table_name = 'v9_zhuangbei';
		$zhuangbei = $this->db->select(" fjid=$id ",'*','','id asc');
		//绑定装备名称
		$this->db->table_name = 'v9_zbmx';
		$rss = $this->db->select("",'id,zbname','','id asc');
		$zb=array();
		
		foreach($rss as $aaa){
			$zb[$aaa['id']]=$aaa['zbname'];
			
			}
		include $this->admin_tpl('zhuangbei');
	}
	//更新排序
 	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $id => $listorder) {
				$id = intval($id);
				$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} 
	}
	
	
	
	function delete()
	{
		$id = $_GET['id'];
		
		if($this->db->delete(array('id'=>$_GET['id']))) {
			
			exit('1');
		} else {
			exit('0');
		}
	}
	function deleteall(){
		
		if(is_array($_POST['id'])){
				foreach($_POST['id'] as $linkid_arr) {
 					//批量删除友情链接
					$this->db->update(array('isdel'=>1),array('id'=>$linkid_arr));
					
					
				}
				showmessage(L('operation_success'),HTTP_REFERER);
		}
		}

////////////////////////////////////////////////////
//人员统计导出

public function dao2xls(){
	
			//邦定层级
		$this->db->table_name = 'v9_cengji';
		$rss = $this->db->select("",'id,cjname','','px desc');
		$cengji=array();
		
		foreach($rss as $aaa){
			$cengji[$aaa['id']]=$aaa['cjname'];
			
			}
		//邦定岗位
		$this->db->table_name = 'v9_gangwei';
		$rss = $this->db->select("",'id,gwname','','id asc');
		$gangwei=array();
		
		foreach($rss as $aaa){
			$gangwei[$aaa['id']]=$aaa['gwname'];
			
			}
			
		//邦定辅助岗位
		$this->db->table_name = 'v9_gangweifz';
		$rss = $this->db->select("",'id,gwname','','id asc');
		
		foreach($rss as $aaa){
			$gangweifz[$aaa['id']]=$aaa['gwname'];
			
			}
						
		//邦定职务
		$this->db->table_name = 'v9_zhiwu';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu=array();
		
		foreach($rss as $aaa){
			$zhiwu[$aaa['id']]=$aaa['zwname'];
			
			}
			
		//邦定学历
		$this->db->table_name = 'v9_xueli';
		$rss = $this->db->select("",'id,gwname','','id asc');
		
		foreach($rss as $aaa){
			$xueli[$aaa['id']]=$aaa['gwname'];
			}
						
		 //绑定组织
		 $this->db = pc_base::load_model('bumen_model');
		
		$rss = $this->db->select("",'id,name,parentid','','listorder asc');	
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			
			}
					
			 
      $zzmms=array('','中共党员','共青团员','民主党派','学生','群众');
	  $tuiyi=array('','是','否');				
	////////////////////////////////////////////////	
	$where=" isok=1 ";
		$orders="dwid asc,rjtime asc";
		

		if(isset($_GET['status']) && !empty($_GET['status'])) {
			$status=$_GET['status'];
			$where .= " AND `status`  = $status ";
			
			}
			
		if(isset($_GET['dwid']) && !empty($_GET['dwid'])) {
			$dwid=$_GET['dwid'];
			if($dwid>1){
			$where .= " AND `dwid`  = $dwid ";
			}
			}
						
			
		if(isset($_GET['xingming']) && !empty($_GET['xingming'])) {                               
			$xingming=$_GET['xingming'];
			$where .= " AND `xingming`  like '%$xingming%' ";
			}		
			
		if(isset($_GET['sex']) && !empty($_GET['sex'])) {                               
			$sex=$_GET['sex'];
			$where .= " AND `sex`='$sex' ";
			}			
			
		if(isset($_GET['agetj']) && !empty($_GET['agetj'])) {                               
			$age1=$_GET['age1'];
			$age2=$_GET['age2'];
			$agetiaojian="=";
			$orders="age desc";
			/*
			if($_GET['agetj']==">"){$agetiaojian=">";}
			if($_GET['agetj']=="<"){$agetiaojian="<";}

            //处理年龄条件
			$tmpage=intval($_GET['age']);
			if($tmpage<1){
				$tmpage=0;
				}
			$tmpagen=date("Y")-$tmpage;
			
			  if($agetiaojian=="<"){
			    $tmpage=$tmpagen."-01-01";
			    $tmpage=strtotime($tmpage);					  
			    $where .= " AND `shengri`".$agetiaojian."'$tmpage' ";
			  }			
			
			  if($agetiaojian==">"){
			    $tmpage=$tmpagen."-12-31";
			    $tmpage=strtotime($tmpage);					  
			    $where .= " AND `shengri`".$agetiaojian."'$tmpage' ";
			  }
			  
			  if($agetiaojian=="="){
			   $tmpage=$tmpagen."-01-01";
			   $tmpage2=$tmpagen."-12-31";
			   $tmpage=strtotime($tmpage);	
			   $tmpage2=strtotime($tmpage2);				  	  
				$where .= " AND `shengri` between $tmpage and $tmpage2 ";  
			  }*/
			  $where .= " AND `age` between $age1 and $age2 "; 
			}
			
		if(isset($_GET['xueli']) && !empty($_GET['xueli'])) {                               
			$xueli=$_GET['xueli'];
			$where .= " AND `xueli`='$xueli' ";
			}
			
		if(isset($_GET['rjtj']) && !empty($_GET['rjtj'])) {                               
			$rjtime=strtotime($_GET['rjtime']);
			$rjtime2=strtotime($_GET['rjtime2']);
			$agetiaojian="=";
			$orders=" rjtime asc";
			//if($_GET['rjtj']==">"){$agetiaojian=">=";$orders=" rjtime asc";}
			//if($_GET['rjtj']=="<"){$agetiaojian="<=";$orders=" rjtime asc";}
			//$where .= " AND `rjtime`".$agetiaojian."'$rjtime' ";
			$where .= " AND (`rjtime` between $rjtime and $rjtime2) ";
			}	
			
		if(isset($_GET['gangwei']) && !empty($_GET['gangwei'])) {                               
			$gangweis=$_GET['gangwei'];
			$where .= " AND `gangwei`='$gangweis' ";
			}
			
		if(isset($_GET['gangweifz']) && !empty($_GET['gangweifz'])) {                               
			$gangweifzs=$_GET['gangweifz'];
			$where .= " AND `gangweifz`='$gangweifzs' ";
			}
			
		if(isset($_GET['zhiwu']) && !empty($_GET['zhiwu'])) {                               
			$gangweis=$_GET['zhiwu'];
			$where .= " AND `zhiwu`='$zhiwus' ";
			}	
			
		if(isset($_GET['cengji']) && !empty($_GET['cengji'])) {                               
			$cengjis=$_GET['cengji'];
			$where .= " AND `cengji`='$cengjis' ";
			}
			
		if(isset($_GET['tuiwu']) && !empty($_GET['tuiwu'])) {                               
			$tuiwus=$_GET['tuiwu'];
			$where .= " AND `tuiwu`='$tuiwus' ";
			}			

		if(isset($_GET['tel']) && !empty($_GET['tel'])) {                               
			$tel=$_GET['tel'];
			$where .= " AND `tel` like '%".$tel."%' ";
			}
			
		if(isset($_GET['shengaotj']) && $_GET['shengaotj']!="") {                               		
		    if(isset($_GET['shengao']) && !empty($_GET['shengao'])) {                               
			   $shengao=$_GET['shengao'];
			   if($_GET['shengaotj']=="="){$where .= " AND `shengao` = $shengao ";}
			   if($_GET['shengaotj']==">"){$where .= " AND `shengao` >= $shengao ";}
			   if($_GET['shengaotj']=="<"){$where .= " AND `shengao` <= $shengao ";}
			   }
			}	
			
		if(isset($_GET['tizhongtj']) && $_GET['tizhongtj']!="") {                               		
		    if(isset($_GET['tizhong']) && !empty($_GET['tizhong'])) {                               
			   $tizhong=$_GET['tizhong'];
			   if($_GET['tizhongtj']=="="){$where .= " AND `tizhong` = $tizhong ";}
			   if($_GET['tizhongtj']==">"){$where .= " AND `tizhong` >= $tizhong ";}
			   if($_GET['tizhongtj']=="<"){$where .= " AND `tizhong` <= $tizhong ";}
			   }
			}				
		if(isset($_GET['gzz']) && !empty($_GET['gzz'])) {                               
			$gzz=$_GET['gzz'];
			$where .= " AND `gzz` like '%".$gzz."%' ";
			}			
			
			
																									
		$this->db->table_name = 'v9_fujing';	
		$daoxls = $this->db->select($where,'*','',$orders);	
        
		$maxss=count($daoxls);
		$j=1;
		for($i=0;$i<$maxss;$i++){
		 $daoxls[$i]['id']=$j;  	
		 $daoxls[$i]['dwid']=$bms[$daoxls[$i]['dwid']];	
	    if($daoxls[$i]['shengri']!=''){
	       $daoxls[$i]['age']=date("Y")-date("Y",$daoxls[$i]['shengri']);
	    }else{
	       $daoxls[$i]['age']='';	
		}		 
		 $daoxls[$i]['shengri']=date("Y-m-d",$daoxls[$i]['shengri']);
		 $daoxls[$i]['rjtime']=date("Y-m-d",$daoxls[$i]['rjtime']);
		 $daoxls[$i]['xueli']=$xueli[$daoxls[$i]['xueli']];
		 $daoxls[$i]['gangwei']=$gangwei[$daoxls[$i]['gangwei']];
		 $daoxls[$i]['gangweifz']=$gangweifz[$daoxls[$i]['gangweifz']];
		 $daoxls[$i]['zhiwu']=$zhiwu[$daoxls[$i]['zhiwu']];
		 $daoxls[$i]['cengji']=$cengji[$daoxls[$i]['cengji']];
		 $daoxls[$i]['zzmm']=$zzmms[$daoxls[$i]['zzmm']];
		 $daoxls[$i]['tuiwu']=$tuiyi[$daoxls[$i]['tuiwu']];
				 
		 $j++;
	    }
		
		
//print_r($daoxls); exit;


///////////////////////////////////////////////////////////////////////////////////////////////////

	header("Content-Type:text/html;charset=utf-8");  
	require PC_PATH.'libs/classes/PHPExcel/Classes/PHPExcel.php';
//error_reporting(E_ALL);  
//ini_set('display_errors', TRUE);  
//ini_set('display_startup_errors', TRUE);  

/* @实例化 */
$obpe = new PHPExcel();  
//总工资表--------------------------------------------

$obpe->getActiveSheet()->setTitle("导出表");
//Excel表格4种情况

$letter2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE');  
$tableheader2 = array('序号','工作单位','姓名','性别','民族','身份证号','年龄','出生日期','学历','入警时间','离职时间','政治面貌','退役','岗位类别','辅助岗位','职务','层级','电话','辅警号','毕业院校','专业','住址','户籍','婚姻状况','带辅民警','身高','体重','BMI','入党时间','入党转正时间','辅警号'); 


//数据总数
$hang= count($daoxls);
$bh=$hang+2;	
//表头数组  

$obpe->getActiveSheet()->getDefaultRowDimension()->setRowHeight('25'); //设置默认行高

/* 
$obpe->getActiveSheet()->mergeCells('A1:M1');		
$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中
$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);      //第一行是否加粗
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);         //第一行字体大小
*/
//写入多行数据
//主标题  
//$yues=date("Y年m月",strtotime($_GET['yue']."-01")); 
//$obpe->getActiveSheet()->setCellValue("A1","高新公安分局".$yues."辅警绩效奖金、加班费发放表"); 
//$obpe->getActiveSheet()->setCellValue("A2","填报日期 ： ".date("Y年m月d日")); 

for($i = 0;$i < count($tableheader2);$i++) {
    $obpe->getActiveSheet()->setCellValue("$letter2[$i]1","$tableheader2[$i]"); 
	$obpe->getActiveSheet()->getColumnDimension("$letter2[$i]")->setWidth('15');
    $obpe->getActiveSheet()->getStyle("$letter2[$i]1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中 
	$obpe->getActiveSheet()->getStyle("$letter2[$i]1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[$i]1")->getFont()->setBold(true);      //第一行是否加粗
	
}  

//输出表格

$liej=2;

for ($i = 0;$i < $hang;$i++) { //行

	$v1=$daoxls[$i]['id'];
	$v2=$daoxls[$i]['dwid'];
	$v3=$daoxls[$i]['xingming'];
	$v4=$daoxls[$i]['sex'];
	$v5=$daoxls[$i]['sfz'];
	$v6=$daoxls[$i]['age'];
	$v7=$daoxls[$i]['shengri'];
	$v8=$daoxls[$i]['xueli'];
	$v9=$daoxls[$i]['rjtime'];
	$v10=$daoxls[$i]['zzmm'];
	$v11=$daoxls[$i]['tuiwu'];
	$v12=$daoxls[$i]['gangwei'];
	$v13=$daoxls[$i]['gangweifz'];
	$v14=$daoxls[$i]['zhiwu'];
	$v15=$daoxls[$i]['cengji'];
	$v16=$daoxls[$i]['tel'];
	$v17=$daoxls[$i]['gzz'];
	$v18=$daoxls[$i]['xuexiao'];
	$v19=$daoxls[$i]['zhuanye'];
	
	$v20=$daoxls[$i]['jzd'];
	$v21=$daoxls[$i]['hjdizhi'];
	$v22=$daoxls[$i]['hun'];
	$v23=$daoxls[$i]['dfmj'];
	
	if($daoxls[$i]['shengao']>0) {$v24=$daoxls[$i]['shengao'];}else{$v24="";}
	if($daoxls[$i]['tizhong']>0) {$v25=$daoxls[$i]['tizhong'];}else{$v25="";}
	if($daoxls[$i]['bmi']>0) {$v26=$daoxls[$i]['bmi'];}else{$v26="";}
	$v27=$daoxls[$i]['minzu'];
	if(intval($daoxls[$i]['lizhitime'])>0){$v28=date("Y-m-d",$daoxls[$i]['lizhitime']);}else{$v28="";}
	
	if(intval($daoxls[$i]['rdtime'])>0){$v29=date("Y-m-d",$daoxls[$i]['rdtime']);}else{$v29="";}
    if(intval($daoxls[$i]['rdzztime'])>0){$v30=date("Y-m-d",$daoxls[$i]['rdzztime']);}else{$v30="";}
	$v31=$daoxls[$i]['gzz'];
	
	
	 	
	$obpe->getActiveSheet()->setCellValue("$letter2[0]$liej","$v1");	
	$obpe->getActiveSheet()->setCellValue("$letter2[1]$liej","$v2");
	$obpe->getActiveSheet()->setCellValue("$letter2[2]$liej","$v3");
	$obpe->getActiveSheet()->setCellValue("$letter2[3]$liej","$v4");
	$obpe->getActiveSheet()->setCellValue("$letter2[4]$liej","$v27");
	$obpe->getActiveSheet()->setCellValue("$letter2[5]$liej","$v5");
	$obpe->getActiveSheet()->setCellValue("$letter2[6]$liej","$v6");
	$obpe->getActiveSheet()->setCellValue("$letter2[7]$liej","$v7");
	$obpe->getActiveSheet()->setCellValue("$letter2[8]$liej","$v8");
	$obpe->getActiveSheet()->setCellValue("$letter2[9]$liej","$v9");
	$obpe->getActiveSheet()->setCellValue("$letter2[10]$liej","$v28");
	$obpe->getActiveSheet()->setCellValue("$letter2[11]$liej","$v10");
	$obpe->getActiveSheet()->setCellValue("$letter2[12]$liej","$v11");
	$obpe->getActiveSheet()->setCellValue("$letter2[13]$liej","$v12");
    $obpe->getActiveSheet()->setCellValue("$letter2[14]$liej","$v13");
	$obpe->getActiveSheet()->setCellValue("$letter2[15]$liej","$v14");
    $obpe->getActiveSheet()->setCellValue("$letter2[16]$liej","$v15");
	$obpe->getActiveSheet()->setCellValue("$letter2[17]$liej","$v16");
	$obpe->getActiveSheet()->setCellValue("$letter2[18]$liej","$v17");
	$obpe->getActiveSheet()->setCellValue("$letter2[19]$liej","$v18");
	$obpe->getActiveSheet()->setCellValue("$letter2[20]$liej","$v19");
	$obpe->getActiveSheet()->setCellValue("$letter2[21]$liej","$v20");
	$obpe->getActiveSheet()->setCellValue("$letter2[22]$liej","$v21");
	$obpe->getActiveSheet()->setCellValue("$letter2[23]$liej","$v22");
	$obpe->getActiveSheet()->setCellValue("$letter2[24]$liej","$v23");
	$obpe->getActiveSheet()->setCellValue("$letter2[25]$liej","$v24");
	$obpe->getActiveSheet()->setCellValue("$letter2[26]$liej","$v25");
	$obpe->getActiveSheet()->setCellValue("$letter2[27]$liej","$v26");
	
	$obpe->getActiveSheet()->setCellValue("$letter2[28]$liej","$v29");
	$obpe->getActiveSheet()->setCellValue("$letter2[29]$liej","$v30");
	$obpe->getActiveSheet()->setCellValue("$letter2[30]$liej","$v31");
	
  $liej++; 
  
} 
  
// 设置边框
$qz=$hang+1;

    $styleThinBlackBorderOutline = array(
        'borders' => array(
            'allborders' => array( //设置全部边框
                'style' => \PHPExcel_Style_Border::BORDER_THIN //粗的是thick
            ),

        ),
    );
	
	$obpe->getActiveSheet()->getStyle( "A1:AE$qz")->applyFromArray($styleThinBlackBorderOutline);	 
	
//领导签字
/*$qz2=$hj+1;
$obpe->getActiveSheet()->setCellValue("A$qz2","主要负责人：");  
$obpe->getActiveSheet()->setCellValue("E$qz2","分管领导：");
$obpe->getActiveSheet()->setCellValue("I$qz2","审核人：");  
$obpe->getActiveSheet()->setCellValue("N$qz2","制表人：");
*/                
//写入类容
$obwrite = PHPExcel_IOFactory::createWriter($obpe, 'Excel5');
//ob_end_clean();
//保存文件
//$obwrite->save('mulit_sheet.xls');
           
//or 以下方式
/*******************************************
            直接在浏览器输出
*******************************************/

header('Pragma: public');
header('Expires: 0');
header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
header('Content-Type:application/force-download');
header('Content-Type:application/vnd.ms-execl');
header('Content-Type:application/octet-stream');
header('Content-Type:application/download');
header("Content-Disposition:attachment;filename=".time()."导出表.xls");
header('Content-Transfer-Encoding:binary');
$obwrite->save('php://output');

}
      ////////////////////////////////////////////////////
      ///// 辅警详情导出到DOC
      /////
	  
		function fjtoword(){
		
		$id = intval($_GET['id']);
		$this->db->table_name = 'v9_fujing';	
		$info = $this->db->get_one("id=$id",'*');
		
		//var_dump($info);	exit;
		
		/////////////////////////////////////////////////////////////////////////////////////////
			
			
		require PC_PATH.'libs/classes/PHPWord/PHPWord.php';
        require PC_PATH.'libs/classes/PHPWord/PHPWord/IOFactory.php';
		
    $PHPWord =  new PHPWord();

    $templateProcessor = $PHPWord->loadTemplate('./wordtmp/fjqingkuang.docx');//找到文件

	 $templateProcessor->setValue('doc01',iconv('utf-8', 'GB2312//IGNORE', $info['xingming']));
	//$templateProcessor->setValue('doc02',iconv('utf-8', 'GB2312//IGNORE', $info['sfz']));
	//$templateProcessor->setValue('doc03',iconv('utf-8', 'GB2312//IGNORE', $info['xingming']));
	//$templateProcessor->setValue('doc04',iconv('utf-8', 'GB2312//IGNORE', $info['sex']));
	//$templateProcessor->setValue('doc05',iconv('utf-8', 'GB2312//IGNORE', date("Y年m月d日 H:i:s",$info['shengri'])));
	//$templateProcessor->setValue('doc06',iconv('utf-8', 'GB2312//IGNORE', $info['xueli']));
	//$templateProcessor->setValue('doc07',iconv('utf-8', 'GB2312//IGNORE', $id));
	
	//$picpath= str_replace("http://101.200.200.203/fujing","",$info['thumb']); 
	//$arrImage = array("path" => $picpath, "width" =>150, "height" => 217);
    $arrImage=array('src' => $info['thumb'], 'swh' => '140', 'ml' => '45', 'mt' => '160');
	
	$templateProcessor->setImg('docpics',$arrImage);
	
	
	$title=time()."-".$id;
    $templateProcessor->save('./word/'.iconv('utf-8', 'GB2312//IGNORE',$title).'.docx');
	header('location:./word/'.$title.'.docx');
		}
		
	//////////////////////////////////////////////
	///人员情况导出
		
	function dao2doc(){
		
		/*
		$id = intval($_GET['id']);
		$this->db->table_name = 'v9_fujing';	
		$info = $this->db->get_one("id=$id",'*');
		*/
		
		//////////////////////////////////////////////////////
require_once 'phpcms/libs/classes/PHPWord/PHPWord.php';
//require PC_PATH.'libs/classes/PHPWord/PHPWord.php';

$PHPWord = new PHPWord();

$document = $PHPWord->loadTemplate('./wordtmp/fujingtemp2.docx');

$document->setValue('xingming', "姓名");
$document->setValue('sex', '性别');

$picParam = array('src' => 'uploadfile/2020/1112/20201112105513897.png', 'size' =>array('90','120')); 
$document->setImg('pic', $picParam);

$document->setValue('sex', '性别');
$document->setValue('shengri', '生日');
$document->setValue('minzu', '民族');
$document->setValue('jiguan', '籍贯');
$document->setValue('zzmm', '政治面貌');
$document->setValue('sfz', '身份证');
$document->setValue('xl', '学历');

$document->setValue('yuanxiao', '院校');
$document->setValue('zzjy', '在职教育');
$document->setValue('yuanxiao2', '院校2');
$document->setValue('zhuzhi', '住址');
$document->setValue('techang', '特长');

$document->setValue('jianli', '简历');
$document->setValue('danwei', '单位');
$document->setValue('zhiwu', '职务');
$document->setValue('ruzhi', '入职时间');
$document->setValue('cengji', '层级');
$document->setValue('gwdj', '岗位等级');


$title=time()."-".$id;
$document->save('./word/'.$title.'.docx');

//////////////////////////////////////

ob_clean();
ob_start();
$fp = fopen('./word/'.$title.'.docx',"r");
$file_size = filesize('./word/'.$title.'.docx');
Header("Content-type:application/octet-stream");
Header("Accept-Ranges:bytes");
Header("Accept-Length:".$file_size);
Header("Content-Disposition:attchment; filename=".'测试文件.docx');
$buffer = 1024;
$file_count = 0;
while (!feof($fp) && $file_count < $file_size){
    $file_con = fread($fp,$buffer);
    $file_count += $buffer;
    echo $file_con;
}
fclose($fp);
ob_end_flush();
		
		//////////////////////////////////////////////////////
				
		
		}	
		
}


