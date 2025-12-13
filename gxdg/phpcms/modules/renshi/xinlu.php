<?php
set_time_limit(0);
ini_set("display_errors", "On"); 
//error_reporting(7);

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class xinlu extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		$this->db2 = pc_base::load_model('opinion_model');
		$this->db->table_name = 'mj_fujing';
		pc_base::load_app_func('global');
	}
	
	public function init() { 	
	
		$this->db->table_name = 'mj_pici';
		//检查未完成招录的批次
		$picis=$this->db->select("zt=1",'*','','id desc');
		$nofins['zj']=count($picis); 	
						 				
		//转译批次
		$picis=$this->db->select("zt>0",'*','','id desc');
		foreach($picis as $v){
		 $piciss[$v['id']]=array('zlnd'=>$v['zlnd'],'zlpc'=>$v['zlpc']);	
		}		
				
		// 状态
		
        $zts=array('作废','考核中','单项不合格','合格待审核','审核待分配');
		
		$this->db->table_name = 'mj_zhaolu';
		if($_GET['doty']==0){ //作废
			if(intval($_GET['xlid'])>0){
				$this->db->update(array('zt'=>0),array('id'=>intval($_GET['xlid'])));
				}
			}
		//-------------------
		
		// 统计
		if($nofins['zj']>0){
		 $zltj=$this->db->select("zt>0",'count(id) as zj','','id desc');
		 $zt_0=	$zltj[0]['zj'];
		 $zltj=$this->db->select("zt=1",'count(id) as zj','','id desc');
		 $zt_1=	$zltj[0]['zj'];	
		 $zltj=$this->db->select("zt=2",'count(id) as zj','','id desc');
		 $zt_2=	$zltj[0]['zj'];
		 $zltj=$this->db->select("zt=3",'count(id) as zj','','id desc');
		 $zt_3=	$zltj[0]['zj'];
		 $zltj=$this->db->select("zt=4",'count(id) as zj','','id desc');
		 $zt_4=	$zltj[0]['zj'];		 		 		 		
		}
		
		$where="1=1";
		$orders=" id desc";
		//检索
		if($_GET['souits']!=''){
		 if($_GET['xingming']!=''){//姓名
			 $s_xingming=$_GET['xingming'];
			 $where.=" and xingming like '%".$s_xingming."%' ";
			 }
		 if($_GET['zzmm']!=''){//政治面貌
			 $s_zzmm=$_GET['nianling'];
			 $where.=" and zzmm like '%".$s_zzmm."%' ";
			 }	
		 if($_GET['bishi']!=''){ //笔试
			 $s_bishi=$_GET['bishi'];
			 $s_bishichengji=$_GET['bishichengji'];
			 $orders=" bishicj desc";
			  if($_GET['bishi']=='>'){
			  $where.=" and bishicj >= ".intval($_GET['bishichengji']);
			  }
			  if($_GET['bishi']=='<'){
			  $where.=" and bishicj <= ".intval($_GET['bishichengji']);
			  }	
		  }
		 if($_GET['mianshi']!=''){ //面试
			 $s_mianshi=$_GET['mianshi'];
			 $s_mianshichengji=$_GET['mianshichengji'];
			 $orders=" mianshicj desc";
			  if($_GET['mianshi']=='>'){
			  $where.=" and mianshicj >= ".intval($_GET['mianshichengji']);
			  }
			  if($_GET['bishi']=='<'){
			  $where.=" and mianshicj <= ".intval($_GET['mianshichengji']);
			  }			  
			 }	
		 if($_GET['tineng']!=''){ //体能
			 $s_tineng=$_GET['tineng'];
			 $s_tinengchengji=$_GET['tinengchengji'];
			 $orders=" tineng desc";
			  if($_GET['tineng']=='>'){
			  $where.=" and tinengcj >= ".intval($_GET['tinengchengji']);
			  }
			  if($_GET['tineng']=='<'){
			  $where.=" and tinengcj <= ".intval($_GET['tinengchengji']);
			  }			  
			 }
		 if($_GET['zhengshen']!=''){ //政审
			 $s_zhengshen=$_GET['zhengshen'];
			  $where.=" and zhengshenjg = '".$_GET['zhengshen']."'";
			 }				 				 
		 if($_GET['xueli']!=''){ //学历
			 $s_xueli=$_GET['xueli'];
			 $where.=" and xueli = '".$_GET['xueli']."'";
			 }	
		 if($_GET['zhuanye']!=''){ //专业
			 $s_zhuanye=$_GET['zhuanye'];
			 $where.=" and zhuanye like '%".$_GET['zhuanye']."%'";
			 }		 			 		 			 	  	 
		}
		 if($_GET['zt']!=''){ //状态
			 $s_zts=intval($_GET['zt']);
			 $where.=" and zt=".$s_zts;
			 }else{
			 $where.=" and zt in(1,3,4)";	 
				 }			

		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		
		$zhaolus = $this->db->listinfo($where,$order = $orders,$page, $pages = '12');
		$pages = $this->db->pages;										
										
		include $this->admin_tpl('xinlu_list');
	}
			
    ///编辑
	function edit(){
		$id=intval($_REQUEST['id']);
		$this->db->table_name = 'mj_zhaolu';
		
		if($_POST['dosubmit']!=''){ 
		 $_POST['info']['shengri']=$_POST['shengri'];	 	
		 $this->db->update($_POST['info'],array('id'=>$id));	
		}
		
		$xinlus = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('edit_xinlu');
	}
   
   
   // 删除附件
	function delfj(){
		
		if(intval($_GET['xlid'])>0 && intval($_GET['id'])>0){
		  $this->db->table_name = 'mj_zhaolu_files';
		  $this->db->update(array('isok'=>0),array('id'=>intval($_GET['id'])));
		  showmessage('附件删除成功','index.php?m=fujing&c=xinlu&a=edit&id='.intval($_GET['xlid']));
		}else{
		  showmessage('参数错误，无法操作','index.php?m=fujing&c=xinlu&a=init');	
			}
		
	}   
   // 追加附件
	function addfj(){
		$xlid=$_POST['xlid'];
		
        $uperr="";
	
	//上传文件
        $web_path=pc_base::load_config('system','web_path');
        $app_path=pc_base::load_config('system','app_path');
	
        $uproot=$_SERVER['DOCUMENT_ROOT'].$web_path;

        $typeArr = array("bmp", "jpg","jpeg","JPG"); //允许上传文件格式
        $realpath=$path = "uploadfiles/"; //上传路径
   //生成月目录
        $dir_m=date("m");

        if(!is_dir($uproot.$path.$dir_m)){
	      $mk_ok=mkdir($uproot.$path.$dir_m);
           if (!$mk_ok) {
             showmessage('创建工作区失败','index.php?m=fujing&c=xinlu&a=edit&id='.$xlid);
          }
	    }

      if($web_path=="/"){		
          $path=$web_path.$path.$dir_m."/";	//如果服务在ROOT上
      }else{
          $path="..".$web_path.$path.$dir_m."/";	//如果服务不在ROOT上，不支持大于2级目录服务	
	  }


      if (isset($_POST)) {
        @$name = $_FILES['infiles']['name'];
        @$size = $_FILES['infiles']['size'];
        @$name_tmp = $_FILES['infiles']['tmp_name'];
        if (empty($name)) {
          showmessage('未指定要上传的附件','index.php?m=fujing&c=xinlu&a=edit&id='.$xlid);
        }
        
		$type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型

        if (!in_array($type, $typeArr)) {
          showmessage('只能上传BMP或JPG附件','index.php?m=fujing&c=xinlu&a=edit&id='.$xlid);
        }
        if ($size > (500000 * 1024)) { //上传大小
          showmessage('附件超过5M','index.php?m=fujing&c=xinlu&a=edit&id='.$xlid);
        }

    $pic_name = time() . rand(10000, 99999) . "." . $type; //图片名称
    $pic_url = $path . $pic_name; //上传后图片路径+名称

    if (move_uploaded_file($name_tmp, $pic_url)) { //临时文件转移到目标文件夹
      //变换文件实际路径
      //$realpath=$uproot.$realpath."/".$dir_m."/".$pic_name;
	  //echo $pic_url;
	  
	  //入库
	  $this->db->table_name = 'mj_zhaolu_files';
	  $infj['xlid']=$xlid;
	  $infj['type']=$type;
	  $infj['fujians']=$pic_url;
	  $infj['class']=$_POST['class'];
	  $infj['title']=$_POST['addfujian'];
	  $infj['inputtime']=time();
	  $infj['douser']=param::get_cookie('admin_username');
	  $this->db->insert($infj);
      showmessage('附件添加成功','index.php?m=fujing&c=xinlu&a=edit&id='.$xlid);
    } else {
       showmessage('保存附件失败，请联系管理员','index.php?m=fujing&c=xinlu&a=edit&id='.$xlid);
    }
   }
	}
	
		
	//新录批次
	function pici()
	{			
		$this->db->table_name = 'mj_pici';

				
		//新建
	    if($_POST['addits']!=""){
			
			$_POST['info']['douser']=param::get_cookie('admin_username');
			$_POST['info']['inputtime']=time();
			$_POST['info']['sd1']=strtotime($_POST['sd1']);
			$_POST['info']['sd2']=strtotime($_POST['sd2']);
			$_POST['info']['jhrs']=intval($_POST['jhrs']);
			$_POST['info']['zlpc']=$_POST['zlpc'];
			$_POST['info']['zlnd']=intval($_POST['zlnd']);
		
		$this->db->insert($_POST['info']);

		}
		
		//作废或完成
	    if(intval($_GET['id'])>0){

		 $id=intval($_GET['id']);
		 
	    	if($_GET['doty']=="dofei"){//作废	
               $this->db->update("zt=0",array('id'=>$id));
			}
	    	if($_GET['doty']=="dook"){//完成	
               $this->db->update("zt=2",array('id'=>$id));
			}
	    	if($_GET['doty']=="donook"){//完成	
               $this->db->update("zt=1",array('id'=>$id));
			}						
		}		
	    
		//检查未完成招录的批次
		$nofins=$this->db->get_one("zt=1",'count(*) as zj');


		$where="zt>0";
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$picis = $this->db->listinfo($where,$order = $orders,$page, $pages = '12');
		$pages = $this->db->pages;
			
		include $this->admin_tpl('xinlu_pici_list');
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////
    //招录汇总导入
public function inforxls(){
			
$uperr="";
	
	//上传文件
$web_path=pc_base::load_config('system','web_path');
$app_path=pc_base::load_config('system','app_path');
	
$uproot=$_SERVER['DOCUMENT_ROOT'].$web_path;

$typeArr = array("xls", "xlsx"); //允许上传文件格式
$realpath=$path = "uploadfiles/"; //上传路径
//生成月目录
$dir_m=date("m");

//var_dump(is_dir($uproot.$path.$dir_m));
//exit;

//echo $uproot.$path.$dir_m;

if(!is_dir($uproot.$path.$dir_m)){
	$mk_ok=mkdir($uproot.$path.$dir_m);
    if (!$mk_ok) {
        $uperr= "无法接收文件";
		//echo $uperr;
		//exit;
    }
	}

if($web_path=="/"){		
 $path=$web_path.$path.$dir_m."/";	//如果服务在ROOT上
}else{
 $path="..".$web_path.$path.$dir_m."/";	//如果服务不在ROOT上，不支持大于2级目录服务	
	}


if (isset($_POST)) {
    @$name = $_FILES['infiles']['name'];
    @$size = $_FILES['infiles']['size'];
    @$name_tmp = $_FILES['infiles']['tmp_name'];
    if (empty($name)) {
        $uperr= "您还未选择附件";
		//echo $uperr;exit;
    }
    $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型

    if (!in_array($type, $typeArr)) {
        $uperr="只能上传XLS、XLSX类型的附件！";
		//echo $uperr;
    }
    if ($size > (500000 * 1024)) { //上传大小
        $uperr= "附件大小已超过500000KB！";
		//echo $uperr;
    }

    $pic_name = time() . rand(10000, 99999) . "." . $type; //图片名称
    $pic_url = $path . $pic_name; //上传后图片路径+名称
	


    if (move_uploaded_file($name_tmp, $pic_url)) { //临时文件转移到目标文件夹
      //变换文件实际路径
      $realpath=$uproot.$realpath."/".$dir_m."/".$pic_name;
	  //echo $realpath;
   
    } else {
        $uperr= "上传失败！";
		//echo $uperr;
    }
}

  ///////////////////////////////////////////////////
  //导入过程	
  require PC_PATH.'libs/classes/PHPExcel/Classes/PHPExcel.php';

 //判断文件类型
 if($type=="xls"){  
  $objReader = \PHPExcel_IOFactory::createReader('Excel5'); //2003
 }
 if($type=="xlsx"){  
  $objReader = \PHPExcel_IOFactory::createReader('Excel2007'); //2007
 } 
 
 
 $objPHPExcel = $objReader->load($realpath,$encode='utf-8');//$file 为解读的excel文件
  //dump($objPHPExcel);die;
  $sheet = $objPHPExcel->getSheet(0);
  $highestRow = $sheet->getHighestRow(); // 取得总行数
  $intimes=time();
  
  $this->db->table_name = 'mj_zhaolu';
	   
  for($di=3;$di<=$highestRow;$di++){
	 if($objPHPExcel->getActiveSheet()->getCell('A'.$di)->getValue()!=""){ 
//	 echo $objPHPExcel->getActiveSheet()->getCell('A'.$di)->getValue();

     $incan['pici']=$_POST['inpici'];
     $incan['xingming']=$objPHPExcel->getActiveSheet()->getCell('B'.$di)->getValue();
     $incan['sex']=$objPHPExcel->getActiveSheet()->getCell('C'.$di)->getValue();
     $incan['shengri']=$objPHPExcel->getActiveSheet()->getCell('D'.$di)->getValue();
     $incan['nianling']=$objPHPExcel->getActiveSheet()->getCell('E'.$di)->getValue();
     $incan['minzu']=$objPHPExcel->getActiveSheet()->getCell('F'.$di)->getValue();
     $incan['jiguan']=$objPHPExcel->getActiveSheet()->getCell('G'.$di)->getValue();
     $incan['zzmm']=$objPHPExcel->getActiveSheet()->getCell('H'.$di)->getValue();
     $incan['sfz']=$objPHPExcel->getActiveSheet()->getCell('I'.$di)->getValue();
     $incan['xueli']=$objPHPExcel->getActiveSheet()->getCell('J'.$di)->getValue();
	 $incan['byyx']=$objPHPExcel->getActiveSheet()->getCell('K'.$di)->getValue();
     $incan['zhuanye']=$objPHPExcel->getActiveSheet()->getCell('L'.$di)->getValue();
     $incan['techang']=$objPHPExcel->getActiveSheet()->getCell('M'.$di)->getValue();
     $incan['zhuzhi']=$objPHPExcel->getActiveSheet()->getCell('N'.$di)->getValue();
     $incan['tels']=$objPHPExcel->getActiveSheet()->getCell('O'.$di)->getValue();
     $incan['huns']=$objPHPExcel->getActiveSheet()->getCell('P'.$di)->getValue();
     $incan['tuiyi']=$objPHPExcel->getActiveSheet()->getCell('Q'.$di)->getValue();
     $incan['bishicj']=$objPHPExcel->getActiveSheet()->getCell('R'.$di)->getValue();
     $incan['tinengcj']=$objPHPExcel->getActiveSheet()->getCell('S'.$di)->getValue();
     $incan['mianshicj']=$objPHPExcel->getActiveSheet()->getCell('T'.$di)->getValue();
     $incan['zhengshenjg']=$objPHPExcel->getActiveSheet()->getCell('U'.$di)->getValue();
     $incan['inputtime']=$intimes;
     $incan['infiles']=$name;
     $incan['douser']=param::get_cookie('admin_username');

     // 追加

	 $this->db->insert($incan);
	  unset($incan);
	 }
  }	
  	 showmessage('导入完成','index.php?m=fujing&c=xinlu&a=init');
}


/////////////////////////////////////////////////////////////////////////////////////
//批量编辑导入

public function editxls(){
			
$uperr="";
	
	//上传文件
$web_path=pc_base::load_config('system','web_path');
$app_path=pc_base::load_config('system','app_path');
	
$uproot=$_SERVER['DOCUMENT_ROOT'].$web_path;

$typeArr = array("xls", "xlsx"); //允许上传文件格式
$realpath=$path = "uploadfiles/"; //上传路径
//生成月目录
$dir_m=date("m");

//var_dump(is_dir($uproot.$path.$dir_m));
//exit;

//echo $uproot.$path.$dir_m;

if(!is_dir($uproot.$path.$dir_m)){
	$mk_ok=mkdir($uproot.$path.$dir_m);
    if (!$mk_ok) {
        $uperr= "无法接收文件";
		//echo $uperr;
		//exit;
    }
	}

if($web_path=="/"){		
 $path=$web_path.$path.$dir_m."/";	//如果服务在ROOT上
}else{
 $path="..".$web_path.$path.$dir_m."/";	//如果服务不在ROOT上，不支持大于2级目录服务	
	}


if (isset($_POST)) {
    @$name = $_FILES['infiles']['name'];
    @$size = $_FILES['infiles']['size'];
    @$name_tmp = $_FILES['infiles']['tmp_name'];
    if (empty($name)) {
        $uperr= "您还未选择附件";
		//echo $uperr;exit;
    }
    $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型

    if (!in_array($type, $typeArr)) {
        $uperr="只能上传XLS、XLSX类型的附件！";
		//echo $uperr;
    }
    if ($size > (500000 * 1024)) { //上传大小
        $uperr= "附件大小已超过500000KB！";
		//echo $uperr;
    }

    $pic_name = time() . rand(10000, 99999) . "-edit." . $type; //图片名称
    $pic_url = $path . $pic_name; //上传后图片路径+名称
	


    if (move_uploaded_file($name_tmp, $pic_url)) { //临时文件转移到目标文件夹
      //变换文件实际路径
      $realpath=$uproot.$realpath."/".$dir_m."/".$pic_name;
	  //echo $realpath;
   
    } else {
        $uperr= "上传失败！";
		//echo $uperr;
    }
}

  ///////////////////////////////////////////////////
  //导入过程	
  require PC_PATH.'libs/classes/PHPExcel/Classes/PHPExcel.php';

 //判断文件类型
 if($type=="xls"){  
  $objReader = \PHPExcel_IOFactory::createReader('Excel5'); //2003
 }
 if($type=="xlsx"){  
  $objReader = \PHPExcel_IOFactory::createReader('Excel2007'); //2007
 } 
 
 
 $objPHPExcel = $objReader->load($realpath,$encode='utf-8');//$file 为解读的excel文件
  //dump($objPHPExcel);die;
  $sheet = $objPHPExcel->getSheet(0);
  $highestRow = $sheet->getHighestRow(); // 取得总行数
  $intimes=time();
  
  $this->db->table_name = 'mj_zhaolu';
	   
  for($di=2;$di<=$highestRow;$di++){
	 if($objPHPExcel->getActiveSheet()->getCell('A'.$di)->getValue()!=""){ 
//	 echo $objPHPExcel->getActiveSheet()->getCell('A'.$di)->getValue();
     
	 $ids=$objPHPExcel->getActiveSheet()->getCell('A'.$di)->getValue();
     $incan['xingming']=$objPHPExcel->getActiveSheet()->getCell('C'.$di)->getValue();
     $incan['sex']=$objPHPExcel->getActiveSheet()->getCell('D'.$di)->getValue();
     $incan['shengri']=$objPHPExcel->getActiveSheet()->getCell('E'.$di)->getValue();
     $incan['nianling']=$objPHPExcel->getActiveSheet()->getCell('F'.$di)->getValue();
     $incan['minzu']=$objPHPExcel->getActiveSheet()->getCell('G'.$di)->getValue();
     $incan['jiguan']=$objPHPExcel->getActiveSheet()->getCell('H'.$di)->getValue();
     $incan['zzmm']=$objPHPExcel->getActiveSheet()->getCell('I'.$di)->getValue();
     $incan['sfz']=$objPHPExcel->getActiveSheet()->getCell('J'.$di)->getValue();
     $incan['xueli']=$objPHPExcel->getActiveSheet()->getCell('K'.$di)->getValue();
	 $incan['byyx']=$objPHPExcel->getActiveSheet()->getCell('L'.$di)->getValue();
     $incan['zhuanye']=$objPHPExcel->getActiveSheet()->getCell('M'.$di)->getValue();
     $incan['techang']=$objPHPExcel->getActiveSheet()->getCell('N'.$di)->getValue();
     $incan['zhuzhi']=$objPHPExcel->getActiveSheet()->getCell('O'.$di)->getValue();
     $incan['tels']=$objPHPExcel->getActiveSheet()->getCell('P'.$di)->getValue();
     $incan['huns']=$objPHPExcel->getActiveSheet()->getCell('Q'.$di)->getValue();
     $incan['tuiyi']=$objPHPExcel->getActiveSheet()->getCell('R'.$di)->getValue();
     $incan['bishicj']=$objPHPExcel->getActiveSheet()->getCell('S'.$di)->getValue();
     $incan['tinengcj']=$objPHPExcel->getActiveSheet()->getCell('T'.$di)->getValue();
     $incan['mianshicj']=$objPHPExcel->getActiveSheet()->getCell('U'.$di)->getValue();
     $incan['zhengshenjg']=$objPHPExcel->getActiveSheet()->getCell('V'.$di)->getValue();
     //$incan['inputtime']=$intimes;
     //$incan['infiles']=$name;
     //$incan['douser']=param::get_cookie('admin_username');

     // 编辑

	 //$this->db->insert($incan);
	 $this->db->update($incan,array('id'=>$ids));
	  unset($incan);
	 }
  }	
  	 showmessage('批量编辑完成','index.php?m=fujing&c=xinlu&a=init');
}

//招录检索导出	
public function dao2xls(){
					
	////////////////////////////////////////////////	
        $where="1=1";
		$orders=" id desc";
		//检索
		 if($_GET['xingming']!=''){//姓名
			 $s_xingming=$_GET['xingming'];
			 $where.=" and xingming like '%".$s_xingming."%' ";
			 }
		 if($_GET['zzmm']!=''){//政治面貌
			 $s_zzmm=$_GET['nianling'];
			 $where.=" and zzmm like '%".$s_zzmm."%' ";
			 }	
		 if($_GET['bishi']!=''){ //笔试
			 $s_bishi=$_GET['bishi'];
			 $s_bishichengji=$_GET['bishichengji'];
			 $orders=" bishicj desc";
			  if($_GET['bishi']=='>'){
			  $where.=" and bishicj >= ".intval($_GET['bishichengji']);
			  }
			  if($_GET['bishi']=='<'){
			  $where.=" and bishicj <= ".intval($_GET['bishichengji']);
			  }	
		  }
		 if($_GET['mianshi']!=''){ //面试
			 $s_mianshi=$_GET['mianshi'];
			 $s_mianshichengji=$_GET['mianshichengji'];
			 $orders=" mianshicj desc";
			  if($_GET['mianshi']=='>'){
			  $where.=" and mianshicj >= ".intval($_GET['mianshichengji']);
			  }
			  if($_GET['bishi']=='<'){
			  $where.=" and mianshicj <= ".intval($_GET['mianshichengji']);
			  }			  
			 }	
		 if($_GET['tineng']!=''){ //体能
			 $s_tineng=$_GET['tineng'];
			 $s_tinengchengji=$_GET['tinengchengji'];
			 $orders=" tineng desc";
			  if($_GET['tineng']=='>'){
			  $where.=" and tinengcj >= ".intval($_GET['tinengchengji']);
			  }
			  if($_GET['tineng']=='<'){
			  $where.=" and tinengcj <= ".intval($_GET['tinengchengji']);
			  }			  
			 }
		 if($_GET['zhengshen']!=''){ //政审
			 $s_zhengshen=$_GET['zhengshen'];
			  $where.=" and zhengshenjg = '".$_GET['zhengshen']."'";
			 }				 				 
		 if($_GET['xueli']!=''){ //学历
			 $s_xueli=$_GET['xueli'];
			 $where.=" and xueli = '".$_GET['xueli']."'";
			 }	
		 if($_GET['zhuanye']!=''){ //专业
			 $s_zhuanye=$_GET['zhuanye'];
			 $where.=" and zhuanye like '%".$_GET['zhuanye']."%'";
			 }			 		 			 	  	 
		 if($_GET['zt']!=''){ //状态
			 $s_zts=$_GET['zt'];
			 $where.=" and zt=".$s_zts;
			 }else{
		     $where.=" and zt>0";				 
				 }			 	
																									
		$this->db->table_name = 'mj_zhaolu';	
		$daoxls = $this->db->select($where,'*','',$orders);	
        
		$maxss=count($daoxls);		
		
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

$letter2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V');  

$tableheader2 = array('人员ID','批次ID','姓名','性别','出生年月','年龄','民族','籍贯','政治面貌','身份证号','学历','毕业院校','专业','特长','住址','联系电话','婚否','是否退役','笔试成绩','体能测试','面试成绩','政审结果'); 


//数据总数
$hang= count($daoxls);
$bh=$hang+2;	
//表头数组  

$obpe->getActiveSheet()->getDefaultRowDimension()->setRowHeight('25'); //设置默认行高


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
	$v2=$daoxls[$i]['pici'];
	$v3=$daoxls[$i]['xingming'];
	$v4=$daoxls[$i]['sex'];
	$v5=$daoxls[$i]['shengri'];
	$v6=$daoxls[$i]['nianling'];
	$v7=$daoxls[$i]['minzu'];
	$v8=$daoxls[$i]['jiguan'];
	$v9=$daoxls[$i]['zzmm'];
	$v10=$daoxls[$i]['sfz'];
	$v11=$daoxls[$i]['xueli'];
	$v12=$daoxls[$i]['byyx'];
	$v13=$daoxls[$i]['zhuanye'];
	$v14=$daoxls[$i]['techang'];
	$v15=$daoxls[$i]['zhuzhi'];
	$v16=$daoxls[$i]['tels'];
	$v17=$daoxls[$i]['huns'];
	$v18=$daoxls[$i]['tuiyi'];
	$v19=$daoxls[$i]['bishicj'];
	$v20=$daoxls[$i]['tinengcj'];
	$v21=$daoxls[$i]['mianshicj'];
	$v22=$daoxls[$i]['zhengshenjg'];
	 	
	$obpe->getActiveSheet()->setCellValue("$letter2[0]$liej","$v1");	
	$obpe->getActiveSheet()->setCellValue("$letter2[1]$liej","$v2");
	$obpe->getActiveSheet()->setCellValue("$letter2[2]$liej","$v3");
	$obpe->getActiveSheet()->setCellValue("$letter2[3]$liej","$v4");
	$obpe->getActiveSheet()->setCellValue("$letter2[4]$liej","$v5");
	$obpe->getActiveSheet()->setCellValue("$letter2[5]$liej","$v6");
	$obpe->getActiveSheet()->setCellValue("$letter2[6]$liej","$v7");
	$obpe->getActiveSheet()->setCellValue("$letter2[7]$liej","$v8");
	$obpe->getActiveSheet()->setCellValue("$letter2[8]$liej","$v9");
	$obpe->getActiveSheet()->setCellValue("$letter2[9]$liej","$v10");
	$obpe->getActiveSheet()->setCellValue("$letter2[10]$liej","$v11");
	$obpe->getActiveSheet()->setCellValue("$letter2[11]$liej","$v12");
	$obpe->getActiveSheet()->setCellValue("$letter2[12]$liej","$v13");
    $obpe->getActiveSheet()->setCellValue("$letter2[13]$liej","$v14");
	$obpe->getActiveSheet()->setCellValue("$letter2[14]$liej","$v15");
    $obpe->getActiveSheet()->setCellValue("$letter2[15]$liej","$v16");
	$obpe->getActiveSheet()->setCellValue("$letter2[16]$liej","$v17");	
	$obpe->getActiveSheet()->setCellValue("$letter2[17]$liej","$v18");
	$obpe->getActiveSheet()->setCellValue("$letter2[18]$liej","$v19");
	$obpe->getActiveSheet()->setCellValue("$letter2[19]$liej","$v20");
	$obpe->getActiveSheet()->setCellValue("$letter2[20]$liej","$v21");
	$obpe->getActiveSheet()->setCellValue("$letter2[21]$liej","$v22");

	
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
	
	$obpe->getActiveSheet()->getStyle( "A1:V$qz")->applyFromArray($styleThinBlackBorderOutline);	 
	
              
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
header("Content-Disposition:attachment;filename=".time()."检索导出数据.xls");
header('Content-Transfer-Encoding:binary');
$obwrite->save('php://output');

}	

//////////////////////////////////////////////////////////////////////////////////////////	

//批量编辑导出	
public function downeditxls(){
					
	////////////////////////////////////////////////	
		$where="zt>0";
		$orders=" id desc";
		 		 			 	  	 		 	
																									
		$this->db->table_name = 'mj_zhaolu';	
		$daoxls = $this->db->select($where,'*','',$orders);	
        
		$maxss=count($daoxls);		
		
///////////////////////////////////////////////////////////////////////////////////////////////////

	header("Content-Type:text/html;charset=utf-8");  
	require PC_PATH.'libs/classes/PHPExcel/Classes/PHPExcel.php';
//error_reporting(E_ALL);  
//ini_set('display_errors', TRUE);  
//ini_set('display_startup_errors', TRUE);  

/* @实例化 */
$obpe = new PHPExcel();  

$obpe->getActiveSheet()->setTitle("导出表");

$letter2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V');  

$tableheader2 = array('人员ID','批次ID','姓名','性别','出生年月','年龄','民族','籍贯','政治面貌','身份证号','学历','毕业院校','专业','特长','住址','联系电话','婚否','是否退役','笔试成绩','体能测试','面试成绩','政审结果'); 


//数据总数
$hang= count($daoxls);
$bh=$hang+2;	
//表头数组  

$obpe->getActiveSheet()->getDefaultRowDimension()->setRowHeight('25'); //设置默认行高


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
	$v2=$daoxls[$i]['pici'];
	$v3=$daoxls[$i]['xingming'];
	$v4=$daoxls[$i]['sex'];
	$v5=$daoxls[$i]['shengri'];
	$v6=$daoxls[$i]['nianling'];
	$v7=$daoxls[$i]['minzu'];
	$v8=$daoxls[$i]['jiguan'];
	$v9=$daoxls[$i]['zzmm'];
	$v10=$daoxls[$i]['sfz'];
	$v11=$daoxls[$i]['xueli'];
	$v12=$daoxls[$i]['byyx'];
	$v13=$daoxls[$i]['zhuanye'];
	$v14=$daoxls[$i]['techang'];
	$v15=$daoxls[$i]['zhuzhi'];
	$v16=$daoxls[$i]['tels'];
	$v17=$daoxls[$i]['huns'];
	$v18=$daoxls[$i]['tuiyi'];
	$v19=$daoxls[$i]['bishicj'];
	$v20=$daoxls[$i]['tinengcj'];
	$v21=$daoxls[$i]['mianshicj'];
	$v22=$daoxls[$i]['zhengshenjg'];
	 	
	$obpe->getActiveSheet()->setCellValue("$letter2[0]$liej","$v1");	
	$obpe->getActiveSheet()->setCellValue("$letter2[1]$liej","$v2");
	$obpe->getActiveSheet()->setCellValue("$letter2[2]$liej","$v3");
	$obpe->getActiveSheet()->setCellValue("$letter2[3]$liej","$v4");
	//$obpe->getActiveSheet()->setCellValue("$letter2[4]$liej","$v5");
	$obpe->getActiveSheet()->setCellValue("$letter2[5]$liej","$v6");
	$obpe->getActiveSheet()->setCellValueExplicit("$letter2[4]$liej","$v5",PHPExcel_Cell_DataType::TYPE_STRING);
	
	$obpe->getActiveSheet()->setCellValue("$letter2[6]$liej","$v7");
	$obpe->getActiveSheet()->setCellValue("$letter2[7]$liej","$v8");
	$obpe->getActiveSheet()->setCellValue("$letter2[8]$liej","$v9");
	//$obpe->getActiveSheet()->setCellValue("$letter2[9]$liej","$v10");
	$obpe->getActiveSheet()->setCellValueExplicit("$letter2[9]$liej","$v10",PHPExcel_Cell_DataType::TYPE_STRING);
	$obpe->getActiveSheet()->setCellValue("$letter2[10]$liej","$v11");
	$obpe->getActiveSheet()->setCellValue("$letter2[11]$liej","$v12");
	$obpe->getActiveSheet()->setCellValue("$letter2[12]$liej","$v13");
    $obpe->getActiveSheet()->setCellValue("$letter2[13]$liej","$v14");
	$obpe->getActiveSheet()->setCellValue("$letter2[14]$liej","$v15");
    $obpe->getActiveSheet()->setCellValue("$letter2[15]$liej","$v16");
	$obpe->getActiveSheet()->setCellValue("$letter2[16]$liej","$v17");	
	$obpe->getActiveSheet()->setCellValue("$letter2[17]$liej","$v18");
	$obpe->getActiveSheet()->setCellValue("$letter2[18]$liej","$v19");
	$obpe->getActiveSheet()->setCellValue("$letter2[19]$liej","$v20");
	$obpe->getActiveSheet()->setCellValue("$letter2[20]$liej","$v21");
	$obpe->getActiveSheet()->setCellValue("$letter2[21]$liej","$v22");

	
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
	
	$obpe->getActiveSheet()->getStyle( "A1:V$qz")->applyFromArray($styleThinBlackBorderOutline);	 
	
              
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
header("Content-Disposition:attachment;filename=".time()."批量编辑数据包.xls");
header('Content-Transfer-Encoding:binary');
$obwrite->save('php://output');

}	

//////////////////////////////////////////////////////////////////////////////////////////	

}


