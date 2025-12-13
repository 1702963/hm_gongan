<?php
ini_set("display_errors", "On"); 
//error_reporting(7);

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class gzgl extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		$this->db->table_name = 'mj_gongzi_set';
		pc_base::load_app_func('global');
	}
	
	//默认
	public function init() { 
		
		include $this->admin_tpl('cengji_list');
	}
	
	//工资表基础设置
	public function sets() {
			
		
		$this->db->table_name = 'mj_gongzi_set';
		
		if($_POST["bsave"]!=""){
			if(intval($_POST['baseid'])>0){
		       $arrs["jiezhi"]=intval($_POST["jiezhi"]);
			   $arrs["douserid"]=$_SESSION["userid"];
			   $arrs["douser"]=param::get_cookie('admin_username');
			   $arrs["dotime"]=time();
			   $arrs["tongzhi"]=intval($_POST["tongzhi"]);
			   $arrs["jbgz"]=floatval($_POST['jbgz']);
			   
			   $arrs["ylbxjs"]=floatval($_POST['ylbxjs']);
			   $arrs["ylbxbl"]=floatval($_POST['ylbxbl']);
			   $arrs["sybxjs"]=floatval($_POST['sybxjs']);
			   $arrs["sybxbl"]=floatval($_POST['sybxbl']);
			   $arrs["yiliaojs"]=floatval($_POST['yiliaojs']);
			   $arrs["yiliaobl"]=floatval($_POST['yiliaobl']);
			   $arrs["nvwsf"]=floatval($_POST['nvwsf']);
			   $arrs["pjgzr"]=floatval($_POST['pjgzr']);
			   $arrs["zdgz"]=floatval($_POST['zdgz']);
			   
			   $baseid=intval($_POST['baseid']);
			   
			   $this->db->update($arrs,array("id"=>$baseid));
			   $basemsg="<font color=red>基础设置已保存</font>";		
			 }
		 }
		 
		
		$bases = $this->db->get_one("1=1","*","id desc");
		
		
		$this->db->table_name = 'mj_gongzi_fies';
		
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$gz_fies = $this->db->listinfo('',$order = 'px asc',$page, $pages = '5');
		$pages = $this->db->pages;
		
		////特殊工资基数
		$this->db->table_name = 'mj_fujing';
         $zdygzjs=$this->db->get_one("gzjs>0"," count(id) as zj ");	
		
		include $this->admin_tpl('gongzi_sets');
	}	
	
	//自定义工资基数
	function addzdy()
	{
		
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		//岗位映射
		  $this->db->table_name = 'mj_gangwei';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gangwei[$v['id']]=$v['gwname'];  
			 }	
			 
		//邦定层级
		$this->db->table_name = 'mj_cengji';
		$rss = $this->db->select("",'id,cjname','','id asc');
		$cengji=array();
		
		foreach($rss as $aaa){
			$cengji[$aaa['id']]=$aaa['cjname'];
			
			}			 
			 		
		$this->db->table_name = 'mj_fujing';	
		
		//搜索
		if(isset($_POST['sousuo'])) {
		 $sousuo = $this->db->select(" xingming like '%".$_POST['fjxm']."%' ","*","","id asc");	
		}		
		
		//新增
		if(isset($_POST['newzjs'])) {
		 //print_r($_POST);	
		$this->db->update(array('gzjs'=>$_POST['gzjs'],'jnbx'=>$_POST['canbao'],'cancengji'=>$_POST['cancengji'],'kz_zhiban'=>$_POST['kz_zhiban'],'kz_jixiao'=>$_POST['kz_jixiao'],'kz_niangong'=>$_POST['kz_niangong']),array('id'=>intval($_POST['uid'])));	

		}
		//编辑
		if(isset($_POST['editgzjs'])) {
		$this->db->update(array('gzjs'=>$_POST['gzjs'],'jnbx'=>$_POST['canbao'],'cancengji'=>$_POST['cancengji'],'kz_zhiban'=>$_POST['kz_zhiban'],'kz_jixiao'=>$_POST['kz_jixiao'],'kz_niangong'=>$_POST['kz_niangong']),array('id'=>intval($_POST['uid'])));		
		//$this->db->insert($_POST['info']);	

		}		


		
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$zdy_fies = $this->db->listinfo('gzjs>0 ',$order = 'id asc',$page, $pages = '8');
		$pages = $this->db->pages;
				
		include $this->admin_tpl('gongzi_zdygzjs');
	}	
    
	//月度工资表管理
	public function yuetabls() {
		
		
		if($_POST['dos']=="addtable"){  //创建工作表	        
		///////取出设置
		   $this->db->table_name = 'mj_gongzi_set'; 
		   $sets = $this->db->get_one("1=1","*","id desc");
		   
		   //$mydat=$this->db->query("select * from mj_gongzi_set");
           //$mydats=$this->db->fetch_array($mydat);
		   //var_dump($mydats);
		
		/// 表名及工资月度   
		   $db_days=date("Ym");	   
		   if(date("d")>=$sets['jiezhi']){
			   $db_days=date("Ym",strtotime($db_days."+1 month"));  //strtotime居然和手册的参数表完全不一样，根本没有now参数	
			   }
		///// 取出定义的字段进行转换
		 $this->db->table_name = 'mj_gongzi_fies';
		 $fies = $this->db->select("iscan=1","*","","px asc");

	     foreach($fies as $v){
		   $f[]=$v['fiesname']." ".$v['fiestype']." ";  
		 }
				 
          $fss=implode(",",$f);
	      $fss.=",`kqtj` VARCHAR( 1025 ) DEFAULT NULL, userid int(9) default 0,bmid int(6) default 0,islock int(1) default 0,id int(9) primary key auto_increment "; //插入通用字段         
		
		///创建数据表
         
		$ishave=$this->db->table_exists($this->db->db_tablepre."gz".$db_days); //检查指定名称数据表是否存在
//var_dump($this->db->db_tablepre."gz".$db_days);	exit;
		
		if(!$ishave){ 
		  $addtables="CREATE TABLE `".$this->db->db_tablepre."gz".$db_days."` (".$fss.")"; 
		  $isok=$this->db->query($addtables);
		  if($isok){
			$this->db->table_name = 'mj_gongzi_tables'; 
			$arrs['tname']="gz".$db_days;
			$arrs['yue']=$db_days;
    
	$benyue=date("Y-m-d",strtotime($db_days."20"));
	$shangyue=date("Y-m",strtotime($benyue."-1 month"))."-21";
	$benyue=str_replace("-",".",$benyue);
	$shangyue=str_replace("-",".",$shangyue);
				
	        $arrs['fromyue']=$shangyue;
			$arrs['toyue']=$benyue;
					
			$arrs['ctime']=time();
			$arrs['douser']=$_SESSION['userid'];
			$arrs['dotime']=time();
			
			$this->db->insert($arrs); 
			showmessage('月度工资表创建完毕','index.php?m=gongzi&c=gzgl&a=yuetabls');  
		  }
		}else{
		  $msgss="<font color=red>已存在同名数据表，创建失败</font>";	
		  showmessage($msgss,'index.php?m=gongzi&c=gzgl&a=yuetabls');
		}
			
		//////////////////////////////////////////////////////////////////////		    		
		}
		
		//000000000000000000000000000000000000000000000000000000000000000000000000000
		//转结后创建新表，与创建基准空表的过程不同。基准空表的档期取创建时日期，转结后新表档期以
		//转结表为基准计算下月
		
		if(intval($_GET['addtable'])>0){  //转结创建工资表
        
		///////取出设置
		   $this->db->table_name = 'mj_gongzi_set'; 
		   $sets = $this->db->get_one("1=1","*","id desc");
		
		/// 表名及工资月度   
		   $this->db->table_name = 'mj_gongzi_tables'; 
		   $olddbs = $this->db->get_one("id=".intval($_GET['addtable']),"*","id desc");
           if(!$olddbs){showmessage('不能获取新表的基准参数');}
		   	
		       $db_days=$olddbs['yue']."01"; //拼接为完整的日期结构，否则计算下月日期出错	   
			   $db_days=date("Ym",strtotime($db_days."+1 month"));  	
		
		$ishave=$this->db->table_exists("gz".$db_days); //检查指定名称数据表是否存在
		
		$ishaveqk=$this->db->table_exists("kq".$db_days);//检查相同月度考勤表是否存在
		if($ishaveqk!=1){
			showmessage('必须先创建'.$db_days."考勤表");
			} 
					
		///// 取出定义的字段进行转换
		 $this->db->table_name = 'mj_gongzi_fies';
		 $fies = $this->db->select("iscan=1","*","","px asc");

	     foreach($fies as $v){
		   $f[]=$v['fiesname']." ".$v['fiestype']." ";  
		 }
				 
          $fss=implode(",",$f);
	      $fss.=",`kqtj` VARCHAR( 1025 ) DEFAULT NULL, userid int(9) default 0,bmid int(6) default 0,islock int(1) default 0,id int(9) primary key auto_increment "; //插入通用字段         
		
		///创建数据表
         
			
		if($ishave==0){ 
		  $addtables="CREATE TABLE `".$this->db->db_tablepre."gz".$db_days."` (".$fss.")"; 
		  $isok=$this->db->query($addtables);
		  if($isok){
			$this->db->table_name = 'mj_gongzi_tables'; 
			$arrs['tname']="gz".$db_days;
			$arrs['yue']=$db_days;
    
	$benyue=date("Y-m-d",strtotime($db_days."20"));
	$shangyue=date("Y-m",strtotime($benyue."-1 month"))."-21";
	$benyue=str_replace("-",".",$benyue);
	$shangyue=str_replace("-",".",$shangyue);
				
	        $arrs['fromyue']=$shangyue;
			$arrs['toyue']=$benyue;
					
			$arrs['ctime']=time();
			$arrs['douser']=$_SESSION['userid'];
			$arrs['dotime']=time();
			
			$this->db->insert($arrs); 
			showmessage('月度工资表创建完毕','index.php?m=gongzi&c=gzgl&a=yuetabls'); 
		  }
		}else{
		  $msgss="已存指定月度工资表，创建失败";
		  showmessage($msgss,'index.php?m=gongzi&c=gzgl&a=yuetabls');	
		}
			
		//////////////////////////////////////////////////////////////////////		    		
		}		
		 
		//000000000000000000000000000000000000000000000000000000000000000000000000000
		
		$this->db->table_name = 'mj_gongzi_tables';
		
		if($_POST["bsave"]!=""){
			if(intval($_POST['baseid'])>0){
		       $arrs["jiezhi"]=intval($_POST["jiezhi"]);
			   $arrs["douserid"]=$_SESSION["userid"];
			   $arrs["douser"]=param::get_cookie('admin_username');
			   $arrs["dotime"]=time();
			   $arrs["tongzhi"]=intval($_POST["tongzhi"]);
			   
			   $baseid=intval($_POST['baseid']);
			   
			   $this->db->update($arrs,array("id"=>$baseid));
			   $basemsg="<font color=red>基础设置已保存</font>";		
			 }
		 }
		 
		 //000000000000000000000000000000000000
		//锁定工资表 
		$this->db->table_name = 'mj_gongzi_tables'; 		
		if(intval($_GET['islocked'])>0){
		  $islockeds=intval($_GET['islocked']);	
		  if(intval($_GET['locked'])==1){$dolock=0;}else{$dolock=1;}
          $this->db->update(array('islocked'=>$dolock),array('id'=>$islockeds));
			} 
		
		//结转工资表，不允许取消 	
		if(intval($_GET['isfinisheded'])>0){
		  $isfinisheded=intval($_GET['isfinisheded']);	
          $this->db->update(array('isfinish'=>1),array('id'=>$isfinisheded));
		}
		
	
		
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$gz_tables = $this->db->listinfo('',$order = 'id desc',$page, $pages = '10');
		$pages = $this->db->pages;
		include $this->admin_tpl('gongzi_yuelist');
	}	
	
	//增加工资表基础字段，未用
	function adds()
	{
		if(isset($_POST['dosubmit'])) {
			
		//$this->db->insert($_POST['info']);	
			
			showmessage('操作完毕','index.php?m=cengji&c=cengji');
		}
		
		include $this->admin_tpl('gongzi_add_fies');
	}
	
	//查看工资表
	function showtable()
	{
	    $id=intval($_REQUEST['id']);
	
		   $this->db->table_name = 'mj_gongzi_tables'; 
		   $tables = $this->db->get_one("id=$id","*");
	    
		//var_dump($tables['tname']);
		$ishave=$this->db->table_exists($tables['tname']); 	//为什么检测不到存在的表？ 
		
	    //if($ishave){
            
		  //数据泵
		  if($_POST["indats"]!=""){
			  
			  $this->datapump($this->db->db_tablepre.$tables['tname']);
			  			  
			  }	

			
		  //取出表格列名
		  $this->db->table_name = 'mj_gongzi_fies';
		  $rowss = $this->db->select("iscan=1","*","","px asc");
		  foreach($rowss as $v){
			 $rowname[]=array($v['fiesname'],$v['rowsname']);  
			 }
		 
		 //此处清空当月工资表
		 if($_POST['chongzhigzb']){
			 $this->db->query("TRUNCATE TABLE ".$this->db->db_tablepre.$tables['tname']);
			 } 
		  
		  //遍历数据表
		  $this->db->table_name = $this->db->db_tablepre.$tables['tname'];	
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo('',$order = 'id asc',$page, $pages = '10');
		  $pages = $this->db->pages;			
		//}
		   		
		include $this->admin_tpl('gongzi_showtable');
	}

    //当月工资表
	function dytables()
	{
		$this->db->table_name = 'mj_gongzi_tables'; 
		//$tables = $this->db->get_one("isfinish=0","*");

		if(intval($_GET['yue'])>0){
		 $tables = $this->db->get_one("id=".intval($_GET['yue']),"*");	
		}else{
		 $tables = $this->db->get_one("isfinish=0","*");
		}
				
		if($tables){
		  //取出表格列名
		  $this->db->table_name = 'mj_gongzi_fies';
		  $rowss = $this->db->select("iscan=1","*","","px asc");
		  //插入单位名称
		  $rowname[]=array('bmid','单位名称',0);
		  foreach($rowss as $v){
			 $rowname[]=array($v['fiesname'],$v['rowsname'],$v['canhj']);  
			 }
			
		  //遍历数据表
		  $this->db->table_name = $this->db->db_tablepre.$tables['tname'];	
		  
		  $where="1=1";
		  if($_SESSION['roleid']>1){

			 if($tables['zzcuser']!=$_SESSION['userid']){
				 //$where.=" and bmid=-1";
				 }


			 if($tables['juuser']!=$_SESSION['userid']){
				 //$where.=" and bmid=-1";
				 }
		
		   }
		   
		  //获取各项合计 
		   //print_r($rowname);
		   foreach($rowname as $k=>$v){
			   //if($k>3 && $k<14){//原来是按照字段序列获取，3到14都是金额，现在混的厉害，需要增加合计标识
			   if($v[2]==1){
				  $hjs = $this->db->get_one("","sum(".$v[0].") as hj"); 
				  $hj[$k]=$hjs['hj']; 
				  }
			   }

		 // print_r($hj);	   

			  		  
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo($where,$order = 'id asc',$page, $pages = '16');
		  $pages = $this->db->pages;	
		  include $this->admin_tpl('gongzi_dytables');			 
		}else{
			$tableslist = $this->db->select("","*","","id desc");
			include $this->admin_tpl('gongzi_dytables_nous');
			}
		   
	}


    //考勤表管理
	function kaoqin() 
	{	
		////取出设置
		   $this->db->table_name = 'mj_gongzi_set'; 
		   $sets = $this->db->get_one("1=1","*","id desc");
		
		if($_REQUEST['dos']=='addkaoqin'){
		  
		  //取出考勤人员
		  //$this->db->table_name = 'mj_fujing';
		  //$rowss = $this->db->select("status=1","id,xingming,dwid,sex,zhiwu,cengji,rjtime","","id asc");
		  //foreach($rowss as $v){}
		  
		////取出设置
		//   $this->db->table_name = 'mj_gongzi_set'; 
		//   $sets = $this->db->get_one("1=1","*","id desc");
		
		/// 表名   
		   $kaoqin_days=date("Y-m-d");	   
		   if(date("d")>=$sets['jiezhi']){
			   $db_days=date("Ym",strtotime($kaoqin_days."+1 month"));  
			   $day0=date("Y-m")."-".$sets['jiezhi'];
			   }else{
				$db_days=date("Ym"); 
				$day0=date("Y-m")."-".$sets['jiezhi'];
				$day0=date("Y-m-d",strtotime($day0."-1 month"));   
				   }		  
	
	      //这里需要检查是否有和工资表月度匹配
		  //生成考勤表字段
		  //工资表的时期区间算法有问题，但是正常情况下应触发不了异常。此处重写
		  
		  //$day0=date("Y-m")."-".$sets['jiezhi'];
		  //$day1=date("Y-m-d",strtotime($day0."+1 day"));
		  //$day2=date("Y-m-d",strtotime($day0."+1 month"));		  
		  $day1=date("Y-m-d",strtotime($day0));
		  $day2=date("Y-m-d",strtotime($day0."+1 month"));
		  $day2_mo=date("d",strtotime($day2."-1 day"));
		 
		  //for($i=1;$i<=31;$i++){	
		  for($i=0;$i<=$day2_mo;$i++){
			 $day3=date("Ymd",strtotime($day0."+".$i." day"));
			 //if(date("d")<>20){
			  $kqrow[]="`".$day3."` int(2) default 0";  
			 //}
		  }
		  
          $kqrows=implode(",",$kqrow);
		  
		  //echo $kqrows;exit;
		  
		  $ishave=$this->db->table_exists($this->db->db_tablepre."kq".$db_days); //检查指定名称数据表是否存在 
		 
		if(!$ishave){ 	
		  $addtables="CREATE TABLE `".$this->db->db_tablepre."kq".$db_days."` (id int(9) primary key auto_increment,xingming varchar(128),sfz varchar(128),userid int(9) default 0,bmid int(6) default 0,islock int(1) default 0,beizhu varchar(1024),".$kqrows.")"; 
		  $isok=$this->db->query($addtables);
		  if($isok){
			$this->db->table_name = 'mj_gongzi_kaoqintables'; 
			$arrs['tname']="kq".$db_days;
			$arrs['yue']=$db_days;
    
	$benyue=date("Y-m-d",strtotime($db_days."20"));
	$shangyue=date("Y-m",strtotime($benyue."-1 month"))."-21";
	$benyue=str_replace("-",".",$benyue);
	$shangyue=str_replace("-",".",$shangyue);
				
	        $arrs['fromyue']=$shangyue;
			$arrs['toyue']=$benyue;
					
			$arrs['ctime']=time();
			$arrs['douser']=$_SESSION['userid'];
			$arrs['dotime']=time();
			
			$this->db->insert($arrs);  
		  }	 	  
		 }
		}
		
		//00000000000000000000000000000000000000000000000000000000000000000000000000000
		//转结后创建新表
		if(intval($_REQUEST['addkaoqin'])>0){
		  
		////取出设置
		   $this->db->table_name = 'mj_gongzi_kaoqintables'; 
		   $olddb = $this->db->get_one("id=".intval($_REQUEST['addkaoqin']),"*","id desc");
		
		/// 表名   
		   $kaoqin_days=$olddb['yue']."01";	   
		   $db_days=date("Ym",strtotime($kaoqin_days."+1 month"));     		  
		  
		  //生成考勤表字段
		  //工资表的时期区间算法有问题，但是正常情况下应触发不了异常。此处重写

		  //$day0=$olddb['yue'].$sets['jiezhi']; 
		  $day0=$db_days."01";

		  //$day1=date("Y-m-d",strtotime($day0."+1 day"));
		  //$day2=date("Y-m-d",strtotime($day0."+1 month"));
		  $day1=date("Y-m-d",strtotime($day0));
		  $day2=date("Y-m-d",strtotime($day1."+1 month"));
		  $day2_mo=date("d",strtotime($day2."-1 day"));
		  //echo $day2_mo.">>";
		  
		  //统计当月应出勤天数，注意，此天数为非周六周日的计数，非实际工作日天数
		  $thisgzr=0;
		  //for($i=1;$i<32;$i++){
			 for($i=0;$i<$day2_mo;$i++){ 
			 $day3=date("Ymd",strtotime($day0."+".$i." day"));
			 //if(date("d",strtotime($day3))<>20){
			  //此处进行默认值的判断
			  if(date("w",strtotime($day3))==0 || date("w",strtotime($day3))==6){
				$morenzhi="0";   
			  }else{
				$morenzhi="1"; 
				$thisgzr++; 
				  }
			  ///////////////////					  
			  $kqrow[]="`".$day3."` int(2) default ".$morenzhi;  
			 //}else{ //如果循环到20号，跳出
			 // if(date("w",strtotime($day3))==0 || date("w",strtotime($day3))==6){
			//	$morenzhi="0";   
			 // }else{
			//	$morenzhi="1";  
			//	  }		
			//	$kqrow[]="`".$day3."` int(2) default ".$morenzhi;   		
			//	break; 
			//	 }
		  }
		  
          $kqrows=implode(",",$kqrow);
		  //echo $kqrows."---";exit;
	      
		  $ishave=$this->db->table_exists($this->db->db_tablepre."kq".$db_days); //检查指定名称数据表是否存在
		 if(!$ishave){	
		  $addtables="CREATE TABLE `".$this->db->db_tablepre."kq".$db_days."` (id int(9) primary key auto_increment,xingming varchar(128),sfz varchar(128),userid int(9) default 0,bmid int(6) default 0,islock int(1) default 0,beizhu varchar(1024),bmuser int(9) default 0,bmok int(1) default 0,bmdt int(9) default 0,zguser int(9) default 0,zgok int(1) default 0,zgdt int(9) default 0,".$kqrows.")"; 
		  $isok=$this->db->query($addtables);
		  if($isok){
			$this->db->table_name = 'mj_gongzi_kaoqintables'; 
			$arrs['tname']="kq".$db_days;
			$arrs['yue']=$db_days;
    
	$benyue=date("Y-m-d",strtotime($db_days."20"));
	$shangyue=date("Y-m",strtotime($benyue."-1 month"))."-21";
	$benyue=str_replace("-",".",$benyue);
	$shangyue=str_replace("-",".",$shangyue);
				
	        $arrs['fromyue']=$shangyue;
			$arrs['toyue']=$benyue;
					
			$arrs['ctime']=time();
			$arrs['douser']=$_SESSION['userid'];
			$arrs['dotime']=time();
			$arrs['sjts']=$thisgzr;
			
			$this->db->insert($arrs);  
		  }	 	  
		 }
		}		
		//00000000000000000000000000000000000000000000000000000000000000000000000000000	
			
			
		//锁定考勤表 
		$this->db->table_name = 'mj_gongzi_kaoqintables'; 		
		if(intval($_GET['islocked'])>0){
		  $islockeds=intval($_GET['islocked']);	
		  if(intval($_GET['locked'])==1){$dolock=0;}else{$dolock=1;}
          $this->db->update(array('islocked'=>$dolock),array('id'=>$islockeds));
			} 
        //////////////////////////////
		 
		//转结考勤表 ，不提供撤销	
		if(intval($_GET['isfinisheded'])>0){
	
		  $isfinisheded=intval($_GET['isfinisheded']);	
          $this->db->update(array('isfinish'=>1),array('id'=>$isfinisheded));
		  
		  //------------------------------------------------------------------
		  ///统计出勤情况，插入对应月份工资表
		  $kqb = $this->db->get_one("id=$isfinisheded","*");
		  if($kqb['sjts']==0){$kqb['sjts']=21.75;}
		  $kqflag=require 'caches/kaoqinflag.php'; //引入考勤映射表
		  $this->db->table_name = $this->db->db_tablepre.$kqb['tname']; //取出考勤数据
		  $rowss = $this->db->select("","*","","id asc");
		  
		  //取出参与统计的列  
          $rsss=$this->db->get_fields($kqb['tname']);
		  foreach($rsss as $k=>$v){
			if(strtotime($k)){
				$rowname[]=$k;
				} 
			  }		  
		  
		  
		  //统计出勤天数
		  foreach($rowss as $ry){
		  $is_kqsp[$ry['userid']]=$ry['bmok']; //部门审核标记	  
			 foreach($kqflag as $k=>$vs){
				$kqtj0[$k]=0;  
			  }           
			foreach($rowname as $d){
 
		    //创建映射结构				 
			 if($ry[$d]==0){$kqtj0[0]++;}	  
             if($ry[$d]==1){$kqtj0[1]++;}
			 if($ry[$d]==2){$kqtj0[2]++;}
			 if($ry[$d]==3){$kqtj0[3]++;}
			 if($ry[$d]==4){$kqtj0[4]++;}
			 if($ry[$d]==5){$kqtj0[5]++;}
			 if($ry[$d]==6){$kqtj0[6]++;}
			 if($ry[$d]==7){$kqtj0[7]++;}
			 if($ry[$d]==8){$kqtj0[8]++;}
			 if($ry[$d]==9){$kqtj0[9]++;}
			 if($ry[$d]==10){$kqtj0[10]++;}
			 if($ry[$d]==11){$kqtj0[11]++;}
			 if($ry[$d]==12){$kqtj0[12]++;}
			 if($ry[$d]==13){$kqtj0[13]++;}  //补辞退
			 $kqtj[$ry['userid']]=$kqtj0;
			} 
		  }
		  
		  //此处直接把考勤同步到绩效工资表中
		 
		  
		  //写入对应的工资表，并把统计数组插入
		  //直接用考勤表的当前数据表名，考勤和工资表是同档期的
		 
		  $bing_rkgz=round(round($sets['jbgz']/$sets['pjgzr'],2)-round($sets['zdgz']*0.8/$sets['pjgzr'],2),2);
		  $shi_rkgz=round($sets['jbgz']/$sets['pjgzr'],2);
		  $cizhi_rkgz=round($sets['zdgz']/$sets['pjgzr'],2);
		  
		  
		  $this->db->table_name = $this->db->db_tablepre.str_replace("kq","gz",$kqb['tname']);
		  //取出工资表，获取工资表的工资基数（太要命了）
		  $gzbss = $this->db->select("","userid,jiben,cengjigz,ruzhi,yf_yjx,sf_yjx","","id asc");
		  foreach($gzbss as $v){
			  $gzb_js[$v['userid']]=$v['jiben'];
			  $gzb_arr[$v['userid']]=$v;
			  }		  
		 
		  foreach($kqtj as $k=>$v){
			//考勤插入工资表的算法在这里 ，过于冗长，是否考虑抽象成方法？
			$uparr['kaoqin']=$v[1];
			$uparr['kqtj']=serialize($v);
           //读出病事假数量，计算扣发金额，并生成备注
		   $koufa_shi=$v[3]*$shi_rkgz;
		   $koufa_bing=$v[2]*$bing_rkgz;
		   $koufa_sang=$v[6]*$shi_rkgz;
		   $koufa_huli=$v[8]*$shi_rkgz;
		   $koufa_konggong=$v[12]*$shi_rkgz;
		   //$koufa_cizhi=$v[13]*$cizhi_rkgz;  //辞职不能这么算
		   
		   //考勤备注
		   if($v[3]>0){$tmpbei="事假".$v[3]."天 ";}
		   if($v[2]>0){$tmpbei.="病假".$v[2]."天 ";}
		   if($v[4]>0){$tmpbei.="年休假".$v[4]."天 ";}
		   if($v[5]>0){$tmpbei.="婚假".$v[5]."天 ";}
		   if($v[6]>0){$tmpbei.="丧假".$v[6]."天 ";}
		   if($v[7]>0){$tmpbei.="产假".$v[7]."天 ";}
		   if($v[8]>0){$tmpbei.="护理假".$v[8]."天 ";}
		   if($v[9]>0){$tmpbei.="探亲假".$v[9]."天 ";}
		   if($v[10]>0){$tmpbei.="工伤".$v[10]."天 ";}
		   if($v[12]>0){$tmpbei.="旷工".$v[12]."天 ";}
		   if($v[13]>0){$tmpbei.="辞职".$v[13]."天 ";}
		   
		   $uparr['beizhu']=$tmpbei;
		   //////////20230516 此处计算当月入职的人员工资，以出勤统计为准，要保证出勤统计正确
		   if(date("Ym",$gzb_arr[$k]['ruzhi'])==$kqb['yue']){ //如果入职时间是当月
			  $uparr['jiben']= ($gzb_arr[$k]['jiben']/$kqb['sjts'])*$uparr['kaoqin'];
			  $uparr['sf_yjx']= ($gzb_arr[$k]['yf_yjx']/$kqb['sjts'])*$uparr['kaoqin'];
			  $uparr['kf_yjx']= $gzb_arr[$k]['yf_yjx']-$uparr['sf_yjx'];
			   }
		   
		   
		   if($v[2]>=$kqb['sjts']){ //如果全月病假
		      $uparr['jiben']=$gzb_arr[$k]['jiben']*0.8; 
		   }else{
		     // $uparr['jiben']=$gzb_js[$k]-$koufa_shi-$koufa_bing-$koufa_konggong; //待确认
			 $uparr['jiben']= ($gzb_arr[$k]['jiben']/$kqb['sjts'])*$uparr['kaoqin']; //此处按实际出勤天数
		   }
		   if($v[13]>0){ //如果辞职，则计算出勤天数核算基本工资
			  // $uparr['jiben']=$shi_rkgz*$uparr['kaoqin'];
			  $uparr['jiben']= ($gzb_arr[$k]['jiben']/$kqb['sjts'])*$uparr['kaoqin'];
			   }
		   if($v[10]>0){ //如果工伤，则计算出勤天数核算基本工资
			   //$uparr['jiben']=$shi_rkgz;
			   $uparr['jiben']= ($gzb_arr[$k]['jiben']/$kqb['sjts'])*$uparr['kaoqin'];
			   }			   
		   
			$this->db->update($uparr,array('userid'=>$k));   //考勤统计居然写到ID上去了，怪不得考勤出错了
			unset($uparr);unset($tmpbei);
			  }
		 
		 //整理工资表 000000000000000
		 $gz_zhengli = $this->db->select("","*","","id asc");
		 foreach($gz_zhengli as $v){
	//var_dump($uparr['yanglao']);echo $exit;
		   $ids=$v['id'];	 
		   //$uparr['yingfa']=$v['jiben']+$v['nvwsf']+$v['cengji']+$v['zhiji']+$v['zwgz'];
		  /* 
		   if(!is_null($v['yanglao'])){//保险未初始化则计算保险，否则忽略
		   if($uparr['yingfa']>$sets['ylbxjs']){  //养老保险
		    $uparr['yanglao']=round($uparr['yingfa']*$sets['ylbxbl'],2);
		   }else{
			$uparr['yanglao']=round($sets['ylbxjs']*$sets['ylbxbl'],2);   
		   }
		   }
		   
		   if(!is_null($v['shiye'])){
		   if($uparr['yingfa']>$sets['sybxjs']){  //失业保险
		    $uparr['shiye']=round($uparr['yingfa']*$sets['sybxbl'],2);
		   }else{
			$uparr['shiye']=round($sets['sybxjs']*$sets['sybxbl'],2);   
		   }
		   }
			
		   if(!is_null($v['yiliao'])){	  
		   if($uparr['yingfa']>$sets['yiliaojs']){  //医疗保险
		    $uparr['yiliao']=round($uparr['yingfa']*$sets['yiliaobl'],2);
		   }else{
			$uparr['yiliao']=round($sets['yiliaojs']*$sets['yiliaobl'],2);   
		   }
		   }
		   
		   if(substr_count($v['beizhu'],"辞职")>0){//如果辞职,保险清空
		    $uparr['yanglao']=$uparr['shiye']=$uparr['yiliao']=0;
		   }
		   
		   //$uparr['shifa']=$uparr['yingfa']-$uparr['yanglao']-$uparr['shiye']-$uparr['yiliao'];			
			*/
			

			////////////////////////////////////////////////////////////////////////////////
			$uparr['shifa']=$v['jiben']+$v['cengjigz']+$v['sf_yjx']+$v['nvwsf']+$v['tcgx']+$v['zhiwugz']+$v['tsgwgz'];

			//这里判断是否考勤未审核,未审核则工资为0
			//echo $is_kqsp[$v['userid']]."<br>";
			if($is_kqsp[$v['userid']]==0){
				$uparr['shifa']=0.00;
				}
			
			$this->db->update($uparr,array('id'=>$ids));  
			unset($uparr);
						  
		 }
		 // exit;
		 /// sub exit
		 $this->db->table_name = 'mj_gongzi_kaoqintables';
		 } 		  	
				
		 /////////////////////////////////////////////

		//更新实际天数
if($_POST['sjtsgx']!=""){
 if(intval($_POST['id'])>0){
	$this->db->update(array("sjts"=>intval($_POST['sjts'])),array("id"=>intval($_POST['id']))); 

	 }	
	}		 
		 
		 
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$kq_tables = $this->db->listinfo('',$order = 'id desc',$page, $pages = '10');
		$pages = $this->db->pages;			 			   
		include $this->admin_tpl('gongzi_kaoqin');
	}	
	
	
	//查看考勤表
	function showkaoqin()
	{
		//加载考勤标记
		$kqflag=require 'caches/kaoqinflag.php';
		
	    $id=intval($_REQUEST['id']);
			  		
		   $this->db->table_name = 'mj_gongzi_kaoqintables'; 
		   $tables = $this->db->get_one("id=$id","*");

           //插入数据准备
		   if($_REQUEST['dos']=="indats"){

             //读出辅警人员
		     $this->db->table_name = 'mj_fujing';
		     $fujings = $this->db->select("status in (1,2) and isok=1","id,xingming,dwid,sex,zhiwu,cengji,rjtime,status,lizhitime","","rjtime asc");
			
             //部门转译
		     $this->db->table_name = 'mj_bumen';
		     $rowss = $this->db->select("","*","","id asc");
		     foreach($rowss as $v){
			    $bumen[$v['id']]=$v['name'];  
			 }			
			 
			 //状态
			 $zts[1]="在职";
			 $zts[2]="离职";
           
		   /////////////////////			   
		   }

           if($_REQUEST['dook']!=""){
			if(count($_POST['ids'])>0){
			   $instr=implode(",",$_POST['ids']);
			   
		       $this->db->table_name = 'mj_fujing';
		       $rsss = $this->db->select("id in ($instr)","id,xingming,sfz,dwid,sex,zhiwu,cengji,rjtime,status,jnbx","","rjtime asc,jnbx desc");
			   
			   $this->db->table_name = $this->db->db_tablepre.$tables['tname'];
			   
			   ///20230516 插入入警时间
			   foreach($rsss as $v){
				 $inarr['xingming']=$v['xingming'];
				 $inarr['userid']=$v['id'];
				 $inarr['bmid']=$v['dwid'];
				 $inarr['sfz']=$v['sfz'];
				 /////
				 if(date("Ym",$v['rjtime'])==$tables['yue']){
				  $inarr['beizhu']=date("m.d",$v['rjtime'])."入职";
				 }
				 
				 $this->db->insert($inarr);
		         unset($inarr);
				   }			   
			   	
		       //写回数量
		      $uparr['rows']=count($rsss);
		
		      $dbnamess=str_replace($this->db->db_tablepre,"",$tables['tname']);
		
		      $this->db->table_name = 'mj_gongzi_kaoqintables';
		      $this->db->update($uparr,array('tname'=>$dbnamess));				
				
				}  
		   }
	      /////////////////////////////////////////////////////////			
		  //取出表格列名	  
          $rsss=$this->db->get_fields($tables['tname']);
		  //print_r($rsss);
		  foreach($rsss as $k=>$v){
			if(strtotime($k)){
				$rowname[]=$k;
				}  
			  }
		  	  
		  //遍历数据表
		  $this->db->table_name = $this->db->db_tablepre.$tables['tname'];	
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo('',$order = 'id asc',$page, $pages = '10');
		  $pages = $this->db->pages;			
		   		
		include $this->admin_tpl('gongzi_showkaoqin');
	}	
	
	
	//月考勤表
	function yuekaoqin() 
	{
		//加载考勤标记
		$kqflag=require 'caches/kaoqinflag.php';
		
		$this->db->table_name = 'mj_gongzi_kaoqintables'; 
		
		if(intval($_GET['yue'])>0){
		 $tables = $this->db->get_one("id=".intval($_GET['yue']),"*");	
		}else{
		 $tables = $this->db->get_one("isfinish=0","*");
		}
		if($tables){ //判断是否有活动考勤表
		
		    $this->db->table_name = "mj_bumen";
			$rss = $this->db->select("",'id,name,parentid','','listorder asc');	
		    foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			
			}
		
			
		  //取出表格列名	  
          $rsss=$this->db->get_fields($tables['tname']);
		  //print_r($rsss);
		  foreach($rsss as $k=>$v){
			if(strtotime($k)){
				$rowname[]=$k;
				}  
			  }
			
		  //遍历数据表
		  $dbs=$tables['tname'];
		  
		  if($_SESSION['roleid']>5){
		    $where=" bmid=".$_SESSION['bmid'];   //默认按部门获取考勤数据
		  }
		 
		 if($_SESSION['roleid']==1){
		   $where=" bmok=1 ";
		 }
			
		 //如果是政治处审核员
		 if($_SESSION['roleid']==4){  
		    $where=" bmok=1 ";
		  }	
		  
		 //如果是部门领导	  
		  if($_SESSION['roleid']==5){	 
	    	 $where=" bmuser=".$_SESSION['userid'];
		  }
		  		   
			  
		 //如果是政治处主任	  
		  if($_SESSION['roleid']==2){
			 if($tables['zzcuser']==$_SESSION['userid']){
				 $where=" 1=1 ";
				 }else{
				  $where=" 1=0 ";	 
					 }
		  }
			
		  //如果是分管领导及局领导	
			if($_SESSION['roleid']==3){
			 if($tables['juuser']==$_SESSION['userid']){
				 $where=" 1=1 ";
				 }else{
				 $where=" 1=0 ";	 
					 }
			}			
		   
		  
		  $this->db->table_name = $this->db->db_tablepre.$tables['tname'];	
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo($where,$order = 'id asc',$page, $pages = '16');
		  $pages = $this->db->pages;	
		  			 
		}else{
			$tableslist = $this->db->select("","*","","id desc");
			}
		   
		include $this->admin_tpl('gongzi_dykaoqin');
	}

   //考勤表列表页批量编辑状态
   function kaoqinpiliang(){
	   
	   //print_r($_POST);
	   if($_POST['dook']!=""){
		  $this->db->table_name = $this->db->db_tablepre.$_POST['dbs'];
		  
		  $uparr[$_POST['days']]=$_POST['flags'];
		  
		  if(intval($_POST['bmid'])>1){ 
	        $this->db->update($uparr,array('bmid'=>intval($_POST['bmid'])));
	      }else{
			$this->db->update($uparr,'userid > 0');  
			}
			
		  showmessage("考勤标记已修改，请关闭当前窗口");		  	
			
	   }
	   
	   
	   $kqflag=require 'caches/kaoqinflag.php';

             //部门转译
		     $this->db->table_name = 'mj_bumen';
		     $rowss = $this->db->select("","*","","id asc");
		     foreach($rowss as $v){
			    $bumen[$v['id']]=$v['name'];  
			 }	
			 	   
	   include $this->admin_tpl('gongzi_dykaoqin_piliang');
   }


    //考勤明细处理
	function showkaoqinedit() 
	{
		//加载考勤标记
		$kqflag=require 'caches/kaoqinflag.php';
		
		$this->db->table_name = 'mj_gongzi_kaoqintables'; 
		$tables = $this->db->get_one("isfinish=0","*");
	
	    if($_SESSION['roleid']>1){
		  if($tables['islocked']==1){
			 showmessage("当前数据表已锁定，无法进行操作");
			 exit; 
			  }	
			}
		
		  //取出表格列名	  
          $rsss=$this->db->get_fields($tables['tname']);
		  //print_r($rsss);
		  foreach($rsss as $k=>$v){
			if(strtotime($k)){
				$rowname[]=$k;
				}  
			  }	  

          //部门转译
		     $this->db->table_name = 'mj_bumen';
		     $rowss = $this->db->select("","*","","id asc");
		     foreach($rowss as $v){
			    $bumen[$v['id']]=$v['name'];  
			 }		 
			 		
		  //取出辅警信息 
		  $id=intval($_REQUEST['id']);
		  $this->db->table_name = $this->db->db_tablepre.$tables['tname'];	
		  
		  //插入考勤信息
		  
		   if($_POST['dook']!=""){
			   
	//print_r($_POST);exit;		   
			  foreach($rowname as $x){
				$uparr[$x]=$_POST[$x];  
				  }
			 
			  if(is_array($uparr)){	  
			    $uparr['beizhu']=$_POST['beizhu'];
				$uparr['islock']=1; 
			    $this->db->update($uparr,array('id'=>$id));
			  }
		   }
		   		  
		  $infos=$this->db->get_one("id=$id","*");
		  
		  
		   
		include $this->admin_tpl('gongzi_kaoqin_edit');
	}	
		
    //工资明细处理
	function showgongziedit() 
	{

		
		////取出设置
		   $this->db->table_name = 'mj_gongzi_set'; 
		   $sets = $this->db->get_one("1=1","*","id desc");			
		
		$this->db->table_name = 'mj_gongzi_tables'; 
		$tables = $this->db->get_one("isfinish=0","*");
	
	    if($_SESSION['roleid']>1){
		  if($tables['islocked']==1){
			 showmessage("当前数据表已锁定，无法进行操作");
			 exit; 
			  }	
			}
				
		
  		  //取出表格列名
		  $this->db->table_name = 'mj_gongzi_fies';
		  $rowss = $this->db->select("iscan=1","*","","px asc");
		  foreach($rowss as $v){
			 $rowname[]=array($v['fiesname'],$v['rowsname']);  
			 }

          //部门转译
		     $this->db->table_name = 'mj_bumen';
		     $rowss = $this->db->select("","*","","id asc");
		     foreach($rowss as $v){
			    $bumen[$v['id']]=$v['name'];  
			 }		 
			 		
		  //取出辅警信息 
		  $id=intval($_REQUEST['id']);
		  $this->db->table_name = $this->db->db_tablepre.$tables['tname'];	
		  
		  //更新数据  
		   if($_POST['dook']!=""){
		   
			  foreach($_POST['up'] as $k=>$x){
				$uparr[$k]=$x;  
				  }
				  
			  $uparr['ruzhi']=strtotime($uparr['ruzhi']);	  
			 
			  if(is_array($uparr)){	  
			    //$uparr['beizhu']=$_POST['beizhu']; 
			    $this->db->update($uparr,array('id'=>$id));
				$upmsg="编辑操作已保存";
			  }
		   }
		   		  
		  $infos=$this->db->get_one("id=$id","*");  
  
		include $this->admin_tpl('gongzi_gongzi_edit');
	}	

///00000000000000000000000000000000000000000000000000000000000000000000000
   //考勤审核
	function kaoqinshenhe() 
	{
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		$yid=intval($_GET['yue']);
		
		 //部门审核及主管审核		 
	     if($_GET['ty']=='bm'){

		 $this->db->table_name = 'mj_kq'.$yid;
		 $infos=$this->db->get_one("bmid=".$_SESSION['bmid']." and bmuser>0","*"); 
		 
		 
		  //判断权限
		  if($infos['bmuser']>0){
			 showmessage("部门审核进行中，不允许重复申请"); 
			  } 		  	 
			 
		  //获取申请对象
		  $bms=$_SESSION['bmid'];
		  $this->db->table_name = 'mj_admin';
		  //$rowss = $this->db->select(" isbmuser=1 and bmid=$bms","*","","userid asc"); //限制部门
		  $rowss = $this->db->select(" isbmuser=1 ","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		 	   
		  $rowsname="bmuser";  
		 }
		 
 		 
		 ////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 $this->db->table_name = 'mj_gongzi_kaoqintables';
		 $infos=$this->db->get_one("yue=$yid","*"); 		 
		 
	     if($_GET['ty']=='zzc'){
		  //判断权限	  
		  if($infos['zzcuser']>0){
			 showmessage("政治处审核进行中，不允许重复申请"); 
			  } 
			  			 
		  //获取申请对象
		  $bms=$_SESSION['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("roleid=3","*","","px desc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		   
		  $rowsname="zzcuser";  
		 }	
		 
	     if($_GET['ty']=='fg'){
		  //判断权限
		  if($infos['bmok']==0){
			 showmessage("部门审核审核未通过，不允许越级申请"); 
			  }		  
		  if($infos['fguser']>0){
			 showmessage("分管领导审核进行中，不允许重复申请"); 
			  } 	
			  	 
		  //获取申请对象
		  $bms=$_SESSION['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("roleid=3","*","","px desc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		   
		  $rowsname="fguser";  
		 }	
		 
	     if($_GET['ty']=='ju'){
		  //判断权限
		  if($infos['zzcok']==0){
			 showmessage("政治处审核未通过，不允许越级申请"); 
			  }			  
		  if($infos['juuser']>0){
			 showmessage("局领导审核进行中，不允许重复申请"); 
			  } 			 
		  //获取申请对象
		  $bms=$_SESSION['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("roleid=3","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		   
		  $rowsname="juuser";  
		 }
		 		 	 	 	  		 
		 ////////////////////////////
		 //写入
		 	 	
		 if($_POST['dook']!=""){			 
           			 
			 foreach($_POST['sq'] as $k=>$v){
			   $inarr[$k]=$v;	 
				 }		                   
		
		//var_dump($inarr);exit;
         
		 if($_GET['ty']=='bm'){ //别扭，不改了
 			 $this->db->table_name = 'mj_kq'.$yid;
			 $inarr['bmdt']=time();
			 $this->db->update($inarr,array('bmid'=>$_SESSION['bmid']));
			 }else{ 
            //政治处主任
			//print_r($inarr);exit;
			$this->db->table_name = 'mj_gongzi_kaoqintables'; 	 
			$this->db->update($inarr,array('yue'=>$yid));			
		
			 }
			 
			//插入站内消息
			//获取本次审批涉及到的记录ID序列
			$this->db->table_name = 'mj_kq'.$yid;
			$isdrs = $this->db->select("bmid=".$_SESSION['bmid'],"id","","");
			foreach($isdrs as $v){
				$_id_arr[]=$v['id'];
				}
			if(is_array($_id_arr)){
				$_inids=implode(",",$_id_arr);
				}else{
				$_inids="";//此选择肢仅为防止缺省异常	
					}	
			//$msgin['inids']=$_inids;		
			////////////////////////////
			
			$this->db->table_name = 'mj_msgs';
			$msgin['yuan']='考勤';
			$msgin['adddt']=time();
			$msgin['msg']=$_GET['yue']."考勤表等待您审核";
			$msgin['showuser']=$inarr[$rowsname];
			$msgin['doty']=$rowsname;
			$msgin['yues']=$_GET['yue'];
			$msgin['adduser']=$_SESSION['userid'];
			$msgin['addbm']=$_SESSION['bmid'];
			$msgin['inids']=$_inids;
			
			$this->db->insert($msgin);			
			
			showmessage("审核申请已提交，请关闭窗口");	   
			 }
		 
		 //////////////////////////// 
		   
		include $this->admin_tpl('kaoqin_shenqing');
	}
	
//考勤表审核处理
	function kaoqinshenhe_do() 
	{
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		 $yue=intval($_GET['yue']);
		 $this->db->table_name = 'mj_gongzi_kaoqintables';		
				 
		 
	     if($_GET['ty']=='zzc'){ 
	   
		  $rowsname="zzcok";
		    
		 }	
		 
		 
	     if($_GET['ty']=='ju'){	   
		  $rowsname="juok";  
		 }
		 		 	 	 	  		 
		 ////////////////////////////
		 //写入
		 	 	
		 if($_POST['dook']!=""){			     	
					 
			 foreach($_POST['sq'] as $k=>$v){
			   $inarr[$k]=$v;	 
				 }		                   
			  
			 $this->db->table_name = 'mj_gongzi_kaoqintables'; 
			 
			 if($_POST["ty"]=='zzc'){
			   if($inarr['zzcok']=='0'){
			     $inarr['zzcuser']=0;
			   }else{
			     $inarr['zzcdt']=time();
			   }
			 }
			 if($_POST["ty"]=='ju'){
			   if($inarr['juok']=='0'){
			     $inarr['zzcuser']=0;
				 $inarr['juuser']=0;
				 $inarr['zzcok']=0;
				 $inarr['zzcdt']=0;
			   }else{
			     $inarr['judt']=time();
			   }
			 }			 
			 	 
 	 
			$this->db->update($inarr,array('yue'=>$yue));	
			
		  /*	//插入站内消息
			$this->db->table_name = 'mj_msgs';
			$msgin['yuan']='绩效工资';
			$msgin['adddt']=time();
			$msgin['msg']=$_GET['yue']."绩效工资表申请等待您审核";
			$msgin['showuser']=$inarr[$rowsname];
			$this->db->insert($msgin); */			
			
			showmessage("审核已处理，请关闭窗口");	   
			 }
		 
		 //////////////////////////// 
		   
		include $this->admin_tpl('kaoqin_shenqing_do');
	}
	
   //工资表审核
	function gongzishenhe() 
	{
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		$yid=intval($_GET['yue']);

		 $this->db->table_name = 'mj_gongzi_tables';
		 $infos=$this->db->get_one("yue=$yid","*"); 		
				 
	     if($_GET['ty']=='bm'){
		  //判断权限
		  if($infos['bmuser']>0){
			 showmessage("部门审核进行中，不允许重复申请"); 
			  } 		  	 
			 
		  //获取申请对象
		  $bms=$infos['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("roleid=5 and bmid=$bms","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		 	   
		  $rowsname="bmuser";  
		 }
		 
	     if($_GET['ty']=='zzc'){
		  //判断权限	  
		  if($infos['zzcuser']>0){
			 showmessage("政治处审核进行中，不允许重复申请"); 
			  } 
			  			 
		  //获取申请对象
		  $bms=$_SESSION['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("roleid=3","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		   
		  $rowsname="zzcuser";  
		 }	
		 
	     if($_GET['ty']=='fg'){
		  //判断权限
		  if($infos['bmok']==0){
			 showmessage("部门审核审核未通过，不允许越级申请"); 
			  }		  
		  if($infos['fguser']>0){
			 showmessage("分管领导审核进行中，不允许重复申请"); 
			  } 		 
		  //获取申请对象
		  $bms=$_SESSION['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("roleid=3","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		   
		  $rowsname="fguser";  
		 }	
		 
	     if($_GET['ty']=='ju'){
		  //判断权限
		  if($infos['zzcok']==0){
			 showmessage("政治处审核未通过，不允许越级申请"); 
			  }			  
		  if($infos['juuser']>0){
			 showmessage("局领导审核进行中，不允许重复申请"); 
			  } 			 
		  //获取申请对象
		  $bms=$_SESSION['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("roleid=3","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		   
		  $rowsname="juuser";  
		 }
		 		 	 	 	  		 
		 ////////////////////////////
		 //写入
		 	 	
		 if($_POST['dook']!=""){			 
           			 
			 foreach($_POST['sq'] as $k=>$v){
			   $inarr[$k]=$v;	 
				 }		                   
		

			 $this->db->table_name = 'mj_gongzi_tables'; 	 
 	 
			$this->db->update($inarr,array('yue'=>$yid));	
					
			//插入站内消息			
			
			$this->db->table_name = 'mj_msgs';
			$msgin['yuan']='工资';
			$msgin['adddt']=time();
			$msgin['msg']=$_GET['yue']."工资表等待您审核";
			$msgin['showuser']=$inarr[$rowsname];
			
			  $msgin['doty']='zzcuser';
			  $msgin['yues']=$_POST['yue'];
			  $msgin['adduser']=$_SESSION['userid'];
			  $msgin['addbm']=0;
			  			
			$this->db->insert($msgin);			
			
			showmessage("审核申请已提交，请关闭窗口");	   
			 }
		 
		 //////////////////////////// 
		   
		include $this->admin_tpl('gongzi_shenqing');
	}
	
//考勤表审核处理
	function gongzishenhe_do() 
	{
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		 $yue=intval($_GET['yue']);
		 $this->db->table_name = 'mj_gongzi_tables';		
				 
		 
	     if($_GET['ty']=='zzc'){ 
	   
		  $rowsname="zzcok";
		    
		 }	
		 
		 
	     if($_GET['ty']=='ju'){	   
		  $rowsname="juok";  
		 }
		 		 	 	 	  		 
		 ////////////////////////////
		 //写入
		 	 	
		 if($_POST['dook']!=""){			     	
					 
			 foreach($_POST['sq'] as $k=>$v){
			   $inarr[$k]=$v;	 
				 }		                   
			  
			 $this->db->table_name = 'mj_gongzi_tables'; 
			 
			 if($_POST["ty"]=='zzc'){
			   if($inarr['zzcok']=='0'){
			     $inarr['zzcuser']=0;
			   }else{
			     $inarr['zzcdt']=time();
			   }
			 }
			 if($_POST["ty"]=='ju'){
			   if($inarr['juok']=='0'){
			     $inarr['zzcuser']=0;
				 $inarr['juuser']=0;
				 $inarr['zzcok']=0;
				 $inarr['zzcdt']=0;
			   }else{
			     $inarr['judt']=time();
			   }
			 }			 
			 	 
 	 
			$this->db->update($inarr,array('yue'=>$yue));	
			
		  /*	//插入站内消息
			$this->db->table_name = 'mj_msgs';
			$msgin['yuan']='绩效工资';
			$msgin['adddt']=time();
			$msgin['msg']=$_GET['yue']."绩效工资表申请等待您审核";
			$msgin['showuser']=$inarr[$rowsname];
			$this->db->insert($msgin); */			
			
			showmessage("审核已处理，请关闭窗口");	   
			 }
		 
		 //////////////////////////// 
		   
		include $this->admin_tpl('gongzi_shenqing_do');
	}		
//000000000000000000000000000000000000000000000000000000000000000000000000		
/////////////////////////////////////////
/////////////////////////////////////////
//定义数据泵方法
//目前只需要传入目标数据表名称，其他不需要传入

private function datapump($dbname) {

//获取基本设置项目
		  $this->db->table_name = 'mj_gongzi_set';
		  $rowss = $this->db->select("id=1","*","");
		  foreach($rowss as $v){
			 $jb_arr=$v;  
			 }
//获取层级工资 ,此处需解析
		  $this->db->table_name = 'mj_cengji';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $cengji[$v['id']]=$v;  
			 }
//获取职级工资
		  $this->db->table_name = 'mj_zhiwu';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $zhiji[$v['id']]=$v['gongzi'];  
			 }		

//获取辅助岗位工资
		  $this->db->table_name = 'mj_gangweifz';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fzgw[$v['id']]=$v['gongzi'];  
			 }	
			 
//岗位等级
		  $this->db->table_name = 'mj_gwdj';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gwdj[$v['id']]=$v; //这个映射需要解析  
			 }				 			 
			 	 

//读出辅警人员
//从当月考勤表取出人员
          $tmpkqdbname=str_replace("gz","kq",$dbname);
		  $this->db->table_name = $tmpkqdbname;
		  $kqrenyuan = $this->db->select("","userid","","id asc");
		  foreach($kqrenyuan as $kqaa){
			$tkqry[]=$kqaa['userid'];  
			  }
		  $gzryidarr=implode(",",$tkqry);  
		  //echo $gzryidarr;
		  //exit;
		  
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("id in(".$gzryidarr.")","id,xingming,sfz,dwid,sex,zhiwu,cengji,rjtime,gangweifz,gzjs,jnbx,cancengji,gwdj,pingdangtime,pingjitime,gangwei,kz_zhiban,kz_jixiao,kz_niangong","","rjtime asc,jnbx desc");

		  foreach($rowss as $v){
            if($v['gzjs']>0){ //特殊工资基数
			 $v['jbgz']=$v['gzjs'];
			}else{
			 $v['jbgz']=$cengji[$v['cengji']]['jibengz']; //基本工资不在设置中取出，改为层级内取出
			}
            if($v['jnbx']==0){ //不缴纳保险的，默认是0  保险部分不再参与，但是不能删
			// $v['yanglao']=0.00;
            // $v['shiye']=0.00;
			// $v['yiliao']=0.00;
			}			
			 
			 if($v['sex']=="女"){
			   $v['nvwsf']=$jb_arr['nvwsf'];	 
				 }else{
			   $v['nvwsf']=0;	 
				}
			
			if($v['cancengji']==1){ //是否享受层级工资	
             $v['cengjigz']=$cengji[$v['cengji']]['gongzi'];
			 $v['zhijigz']=$zhiji[$v['zhiwu']];	
			 $v['zwgz']=$fzgw[$v['gangweifz']];		  
			}else{
             $v['cengjigz']=0.00;
			 $v['zhijigz']=0.00;	
			 $v['zwgz']=0.00;					
				}
			 
			 
			 $fujing[]=$v;

			 }				 
      	//	  print_r($fujing);exit;
//插入工作表
         $this->db->table_name = $dbname; 
		
		foreach($fujing as $f){ 
		/*
         $inarr['xingming']=$f['xingming'];
		 $inarr['ruzhi']=$f['rjtime'];
		 $inarr['nianxian']=date("Y")-date("Y",$f['rjtime']);
		 $inarr['jiben']=$f['jbgz'];
		 $inarr['nvwsf']=$f['nvwsf'];
		 $inarr['cengji']=$f['cengjigz'];
		 $inarr['zhiji']=$f['zhijigz'];
		 $inarr['userid']=$f['id'];
		 $inarr['bmid']=$f['dwid'];
		 $inarr['zwgz']=$f['zwgz'];
		 if($f['jnbx']==1){//不交保险
		 //	$inarr['yanglao']=$f['yanglao'];
         //   $inarr['shiye']=$f['shiye'];
		 //	$inarr['yiliao']=$f['yiliao'];
		 } */

         $inarr['xingming']= $f['xingming'];	
         $inarr['sex']= $f['sex'];	
         $inarr['sfz']= $f['sfz'];	
         $inarr['ruzhi']= $f['rjtime'];	
         $inarr['nianxian']= date("Y")-date("Y",$f['rjtime']);
         //此处解析层级和档次名称
		 //先把全角换成半角吧，省的费事
		  $tmpcengjiname=str_replace("（","(",str_replace("）",")",$cengji[$f['cengji']]['cjname']));
		  $cjnamearr=explode("(",$tmpcengjiname);
		  if(count($cjnamearr)>1){
			  $cj_name=$cjnamearr[0];
			  $cj_dc=str_replace(")","",$cjnamearr[1]);
			  }else{
			  $cj_name=$cjnamearr[0];
			  $cj_dc=0;				  
				  }
		 /////////////////////	
         $inarr['cengji']=$f['cengji']; 	 
         $inarr['dangci']=$f['cengji']; 	
         $inarr['dangtime']=$f['pingdangtime'];  
         $inarr['jitime']= $f['pingjitime'];	
         $inarr['gwjb']= $f['gwdj'];	
         $inarr['gwlb']= $f['gangwei'];	
         $inarr['zhiwu']=$f['zhiwu']; 	
         $inarr['jiben']= $f['jbgz'];
		 ////这里判断是否为临辅，临辅的工资构成不同
		 if($f['gangwei']==5){ //临辅
			$inarr['sf_yjx']= $f['kz_jixiao']; //临辅的应发绩效为自定义绩效
			$inarr['cengjigz']=$f['kz_zhiban']; //层级工资为自定义值班
			$inarr['yf_yjx']= $f['kz_niangong']; //应发绩效为自定义年功
			$inarr['yingfa']=$inarr['shifa']=$inarr['jiben']+$inarr['cengjigz']+$inarr['sf_yjx'] + $inarr['yf_yjx']+$f['nvwsf'];	 
			 }else{ //非临辅	
         $inarr['cengjigz']= $cengji[$f['cengji']]['gongzi'];
         $inarr['yf_yjx']= $gwdj[$f['gwdj']]['gongzi'];		
         $inarr['sf_yjx']= $inarr['yf_yjx'];	
         $inarr['ndjx']= $gwdj[$f['gwdj']]['jibengz']-$gwdj[$f['gwdj']]['gongzi'];
         $inarr['yingfa']= 	$inarr['jiben']+$inarr['cengjigz']+$inarr['sf_yjx'] + $inarr['ndjx']+$f['nvwsf'];
         $inarr['shifa']= $inarr['jiben']+$inarr['cengjigz']+$inarr['sf_yjx']+$f['nvwsf'];	
			 }
		 ///见习辅警重置绩效,忽略岗位等级
		 if($inarr['cengji']==1){
           $inarr['yf_yjx']= $inarr['sf_yjx']=$cengji[$f['cengji']]['jxjx'];		
           $inarr['ndjx']= 0;	
           $inarr['yingfa']= 	$inarr['jiben']+$inarr['cengjigz']+$inarr['sf_yjx'] + $inarr['ndjx']+$f['nvwsf'];
           $inarr['shifa']= $inarr['jiben']+$inarr['cengjigz']+$inarr['sf_yjx']+$f['nvwsf'];			   		 
			 }
		 	 
         $inarr['nvwsf']= $f['nvwsf'];	
         $inarr['userid']= $f['id'];	
         $inarr['bmid']= $f['dwid'];	

		 		 
		 
		 $this->db->insert($inarr);
		 unset($inarr);
		}
		
		//写回数量量
		$uparr['rows']=count($fujing);
		
		//V9的DB类有些方法自己添加前缀，有些又不添加，莫名其妙
		$dbname=str_replace($this->db->db_tablepre,"",$dbname);
		
		$this->db->table_name = 'mj_gongzi_tables';
		$this->db->update($uparr,array('tname'=>$dbname));
		

	}
	
public function dao(){
	$tbname="mj_".$_GET['tbname'];
	$yue=$_GET['yue'];
	header("Content-Type:text/html;charset=utf-8");  
			require PC_PATH.'libs/classes/PHPExcel/Classes/PHPExcel.php';
//			error_reporting(E_ALL);  
//ini_set('display_errors', TRUE);  
//ini_set('display_startup_errors', TRUE);  
 //中国银行数据
// $rs1=$this->db->query("select b.kahao,a.xingming,a.shifa from $tbname a left join mj_fujing b on a.userid=b.id where a.userid in(select id from mj_fujing where khh like '%中国银行%')  ");
//$zgyh = $this->db->fetch_array($rs1);
  //唐山银行数据    
// $rs1=$this->db->query("select b.kahao,a.xingming,a.shifa from $tbname a left join mj_fujing b on a.userid=b.id where a.userid in(select id from mj_fujing where khh like '%唐山银行%')  ");
//$tsyh = $this->db->fetch_array($rs1);

 //$rs1=$this->db->query("select id,xingming,kaoqin,ruzhi,nianxian,jiben,nvwsf,cengji,zhiji,zwgz,yingfa,yanglao,shiye,yiliao,shifa,beizhu from $tbname  ");
 $rs1=$this->db->query("select * from $tbname where gwlb<5 ");
 $gongzi = $this->db->fetch_array($rs1);
 
 $rs1=$this->db->query("select * from $tbname where gwlb=5 ");
 $lfgongzi = $this->db->fetch_array($rs1); 
 /////////////////////////////////////////////////////////////////////
 //获取层级工资 ,此处需解析
		  $this->db->table_name = 'mj_cengji';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $cengji[$v['id']]=$v;  
			 }
//获取职务
		  $this->db->table_name = 'mj_zhiwu';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $zhiwu[$v['id']]=$v['zwname'];  
			 }		

//获取岗位
		  $this->db->table_name = 'mj_gangwei';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gangwei[$v['id']]=$v['gwname'];  
			 }	
			 
//岗位等级
		  $this->db->table_name = 'mj_gwdj';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gwdj[$v['id']]=$v; //这个映射需要解析  
			 }				 			 

//单位
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

$kaohedj[0]="未指定等级";
$kaohedj[23]="不确定等次";
$kaohedj[2]="优秀";
$kaohedj[3]="合格";
$kaohedj[19]="基本合格";
$kaohedj[4]="不合格";
 /////////////////////////////////////////////////////////////////////
 
 
 //print_r($gongzi);exit;
/* @实例化 */
$obpe = new PHPExcel();  

///////////////////

$obpe->setactivesheetindex(0);
$obpe->getActiveSheet()->setTitle("高新临辅");

//Excel表格式  
$letter2 = array('A','B','C','D','E','F','G','H','I','J','K','L');  
//数据总数
$hang= count($lfgongzi);
$bh=$hang+4;	
//表头数组  
 
$tableheader2 = array("序号","姓名","身份证号","出勤天数","基本工资","女职工卫生费","绩效工资","值班费","年功工资","突出贡献","应发合计","备注");
//合并第一行单元格
$obpe->getActiveSheet()->mergeCells('A1:L1');
//主体加边框
$styleThinBlackBorderOutline = array(
        'borders' => array(
            'allborders' => array( //设置全部边框
                'style' => \PHPExcel_Style_Border::BORDER_THIN //粗的是thick
            ),

        ),
    );

//设置纸型
$obpe->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$obpe->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);	
// 设置边距为0.5厘米 (1英寸 = 2.54厘米)
$margin = 1 / 2.54;   //phpexcel 中是按英寸来计算的,所以这里换算了一下
$obpe->getActiveSheet()->getPageMargins();
$obpe->getActiveSheet()->getPageMargins()->setTop($margin);       //上边距
$obpe->getActiveSheet()->getPageMargins()->setBottom($margin);   //下
$obpe->getActiveSheet()->getPageMargins()->setLeft($margin);      //左
$obpe->getActiveSheet()->getPageMargins()->setRight(0);    //右
	
    $obpe->getActiveSheet()->getStyle( "A3:L$bh")->applyFromArray($styleThinBlackBorderOutline);//边框
	//设置默认列宽
			$obpe->getActiveSheet()->getColumnDimension('A')->setWidth(6);
            $obpe->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $obpe->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $obpe->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $obpe->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $obpe->getActiveSheet()->getColumnDimension('F')->setWidth(10);
            $obpe->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('I')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('K')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('L')->setWidth(10);

//设置全体水平居中			
$obpe->getActiveSheet()->getStyle("A4:L$bh")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
$obpe->getActiveSheet()->getStyle("A4:L$bh")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);			
//设置第三行行高
$obpe->getActiveSheet()->getDefaultRowDimension()->setRowHeight(22);
$obpe->getActiveSheet()->getRowDimension('3')->setRowHeight(48); 	
$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中
$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);      //第一行是否加粗
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);         //第一行字体大小

$obpe->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中
$obpe->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$obpe->getActiveSheet()->getStyle('A3:L3')->getFont()->setBold(true);      //第一行是否加粗
$obpe->getActiveSheet()->getStyle('A3:L3')->getFont()->setSize(10);   

//写入多行数据
 $this->db->table_name = 'mj_gongzi_tables';
 $infos=$this->db->get_one("yue=$yue","*");  
$obpe->getActiveSheet()->setCellValue("A1","高新区公安分局临时性辅助人员（".$infos['yue']."）工资表"); 
$obpe->getActiveSheet()->setCellValue("A2","工资单位：元"); 
$obpe->getActiveSheet()->setCellValue("K2",date("Y年m月")."06日"); 


for($i = 0;$i < count($tableheader2);$i++) { 
    $obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getAlignment()->setWrapText(true); 
    $obpe->getActiveSheet()->setCellValue("$letter2[$i]3","$tableheader2[$i]");  
}  

$k=1 ;
for ($i = 4;$i <= count($lfgongzi) + 4;$i++) {  
//"序号","姓名","身份证号","出勤天数","基本工资","女职工卫生费","绩效工资","值班费","年功工资","突出贡献","应发合计","备注"

    $value1=$k;
	$value2=$lfgongzi[$i-4]['xingming'];
	$value3=$lfgongzi[$i-4]['sfz'];
	$value4=$lfgongzi[$i-4]['kaoqin'];
	$value5=$lfgongzi[$i-4]['jiben']; //基础工资
	$value6=$lfgongzi[$i-4]['nvwsf'];
	$value7=$lfgongzi[$i-4]['sf_yjx']; //绩效
	$value8=$lfgongzi[$i-4]['cengjigz']; //值班
	$value9=$lfgongzi[$i-4]['yf_yjx']; //年功
	$value10=$lfgongzi[$i-4]['tsgwgz'];
	$value11=$lfgongzi[$i-4]['yingfa'];
	$value12=$lfgongzi[$i-4]['beizhu'];
	
								
			  $obpe->getActiveSheet()->setCellValue("A$i","$value1");
			  $obpe->getActiveSheet()->setCellValue("B$i","$value2");
			  $obpe->getActiveSheet()->setCellValue("C$i","$value3");
			  $obpe->getActiveSheet()->setCellValue("D$i","$value4");
			  $obpe->getActiveSheet()->setCellValue("E$i","$value5");
			  $obpe->getActiveSheet()->setCellValue("F$i","$value6");
			  $obpe->getActiveSheet()->setCellValue("G$i","$value7");
			  $obpe->getActiveSheet()->setCellValue("H$i","$value8");
			  $obpe->getActiveSheet()->setCellValue("I$i","$value9");
			  $obpe->getActiveSheet()->setCellValue("J$i","$value10");
			  $obpe->getActiveSheet()->setCellValue("K$i","$value11");
			  $obpe->getActiveSheet()->setCellValue("L$i","$value12");

			
	
	$k++; 
} 

$hj=$hang+4;
$qz=$hj+1;
$qz2=$hj+2;
//合计
$obpe->getActiveSheet()->setCellValue("A$hj","合计"); 
 $obpe->getActiveSheet()->setCellValue("F$hj",$jiben); 
 $obpe->getActiveSheet()->setCellValue("G$hj",$nvwsf);      
  $obpe->getActiveSheet()->setCellValue("H$hj",$cengji);      
   $obpe->getActiveSheet()->setCellValue("I$hj",$zhiji);      
    $obpe->getActiveSheet()->setCellValue("J$hj",$zwgz);
	$obpe->getActiveSheet()->setCellValue("K$hj",$yingfa);      
	 $obpe->getActiveSheet()->setCellValue("L$hj",$yanglao); 

//领导签字
$obpe->getActiveSheet()->setCellValue("A$qz","单位主要负责人：");   
$obpe->getActiveSheet()->setCellValue("E$qz","部门领导：");  
$obpe->getActiveSheet()->setCellValue("J$qz","制表人：吕镇豪 ");  

//插入签名
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('avatar');
$objDrawing->setDescription('avatar');
$objDrawing->setPath('uploadfile/qianming/30.png');
$objDrawing->setHeight(100);
$objDrawing->setWidth(190);
$objDrawing->setCoordinates("C$qz");
$objDrawing->setWorksheet($obpe->getActiveSheet());

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('avatar');
$objDrawing->setDescription('avatar');
$objDrawing->setPath('uploadfile/qianming/38.png');
$objDrawing->setHeight(90);
$objDrawing->setWidth(190);
$objDrawing->setCoordinates("F$qz");
$objDrawing->setWorksheet($obpe->getActiveSheet());

//$obpe->getActiveSheet()->setCellValue("A$qz2","管委会审核："); 

unset($tableheader2);
///上面是临辅
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//总工资表--------------------------------------------
$obpe->createSheet();
$obpe->setactivesheetindex(1);
$obpe->getActiveSheet()->setTitle("高新警务辅助");
//Excel表格式  
$letter2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC');  
//数据总数
$hang= count($gongzi);
$bh=$hang+4;	
//表头数组  
//$tableheader2 = array("序\n号","姓名","出勤\n天数","入职\n时间","入职\n年限","基本\n工资","女职\n工卫\n生费","层级\n工资","职级\n工资","岗位\n工资","应发\n合计","扣养老\n保险","扣失业\n保险","扣医疗\n保险","实发\n工资","备注");  
$tableheader2 = array("序号","工作单位","姓名","性别","身份证号","出勤天数","入职时间","	入职年限","层级","档次","定档时间","定级时间","岗位级别","岗位类别","职务","基础工资","层级工资","考核等次","应发月绩效","扣除月绩效","实发月绩效","年度绩效","职务工资","特殊岗位工资","女职工卫生费","突出贡献","合计应发","实发工资","备注");
//合并第一行单元格
$obpe->getActiveSheet()->mergeCells('A1:AC1');
//主体加边框
$styleThinBlackBorderOutline = array(
        'borders' => array(
            'allborders' => array( //设置全部边框
                'style' => \PHPExcel_Style_Border::BORDER_THIN //粗的是thick
            ),

        ),
    );

//设置纸型
$obpe->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$obpe->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);	
// 设置边距为0.5厘米 (1英寸 = 2.54厘米)
$margin = 1 / 2.54;   //phpexcel 中是按英寸来计算的,所以这里换算了一下
$obpe->getActiveSheet()->getPageMargins();
$obpe->getActiveSheet()->getPageMargins()->setTop($margin);       //上边距
$obpe->getActiveSheet()->getPageMargins()->setBottom($margin);   //下
$obpe->getActiveSheet()->getPageMargins()->setLeft($margin);      //左
$obpe->getActiveSheet()->getPageMargins()->setRight(0);    //右
	
    $obpe->getActiveSheet()->getStyle( "A3:AC$bh")->applyFromArray($styleThinBlackBorderOutline);//边框
	//设置默认列宽
			$obpe->getActiveSheet()->getColumnDimension('A')->setWidth(6);
            $obpe->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $obpe->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $obpe->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $obpe->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $obpe->getActiveSheet()->getColumnDimension('F')->setWidth(10);
            $obpe->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('I')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('K')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('L')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('M')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('N')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('O')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('P')->setWidth(10);
			
			$obpe->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('R')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('S')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('T')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('U')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('V')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('W')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('X')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('Z')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('AA')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('AB')->setWidth(10);
			$obpe->getActiveSheet()->getColumnDimension('AC')->setWidth(10);

//设置全体水平居中			
$obpe->getActiveSheet()->getStyle("A4:AC$bh")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
$obpe->getActiveSheet()->getStyle("A4:AC$bh")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);			
//设置第三行行高
$obpe->getActiveSheet()->getDefaultRowDimension()->setRowHeight(22);
$obpe->getActiveSheet()->getRowDimension('3')->setRowHeight(48); 	
$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中
$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);      //第一行是否加粗
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);         //第一行字体大小

$obpe->getActiveSheet()->getStyle('A3:AC3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中
$obpe->getActiveSheet()->getStyle('A3:AC3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$obpe->getActiveSheet()->getStyle('A3:AC3')->getFont()->setBold(true);      //第一行是否加粗
$obpe->getActiveSheet()->getStyle('A3:AC3')->getFont()->setSize(10);   

//写入多行数据
 $this->db->table_name = 'mj_gongzi_tables';
 $infos=$this->db->get_one("yue=$yue","*");  
$obpe->getActiveSheet()->setCellValue("A1","高新分局警务辅助人员（".$infos['yue']."）工资表"); 
$obpe->getActiveSheet()->setCellValue("A2","工资单位：元"); 
$obpe->getActiveSheet()->setCellValue("AB2",date("Y年m月")."06日"); 


for($i = 0;$i < count($tableheader2);$i++) { 
    $obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getAlignment()->setWrapText(true); 
    $obpe->getActiveSheet()->setCellValue("$letter2[$i]3","$tableheader2[$i]");  
}  

$k=1 ;
////////////////////////////////////////////////////////////////
////岗位层级统计
$gwdj_tj[1]=$gwdj_tj[2]=$gwdj_tj[3]=0;

////////////////////////////////////////////////////////////////

for ($i = 4;$i <= count($gongzi) + 4;$i++) {  
	//array("序号","工作单位","姓名","性别","身份证号","出勤天数","入职时间","	入职年限","层级","档次","定档时间","定级时间","岗位级别","岗位类别","职务","基础工资","层级工资","考核等次","应发月绩效","扣除月绩效","实发月绩效","年度绩效","职务工资","特殊岗位工资","女职工卫生费","突出贡献","合计应发","实发工资","备注");
    
	///统计岗位档次
	$gwdj_tj[$gongzi[$i-4]['gwjb']]++;
	
	if(isset($cj_tj[$gongzi[$i-4]['cengji']])){
	  $cj_tj[$gongzi[$i-4]['cengji']]['cj']++;
	  $cj_tj[$gongzi[$i-4]['cengji']][$gongzi[$i-4]['gwjb']]++;
	}else{
		$cj_tj[$gongzi[$i-4]['cengji']]['cj']=1;
		if(isset($cj_tj[$gongzi[$i-4]['cengji']][$gongzi[$i-4]['gwjb']])){
		   $cj_tj[$gongzi[$i-4]['cengji']][$gongzi[$i-4]['gwjb']]++;
			}else{
		   $cj_tj[$gongzi[$i-4]['cengji']][$gongzi[$i-4]['gwjb']]=1;
			}
		}
		
	 if(isset($kh_tj[$gongzi[$i-4]['kaohedj']])){
		 $kh_tj[$gongzi[$i-4]['kaohedj']]++;
		 }else{
		$kh_tj[$gongzi[$i-4]['kaohedj']]=1;	 
			 }	
	/////////////////////////////////
	$value1=$k;
	$value2=$bumen[$gongzi[$i-4]['bmid']];
	$value3=$gongzi[$i-4]['xingming'];
	$value4=$gongzi[$i-4]['sex'];
	$value5=$gongzi[$i-4]['sfz'];
	$value6=$gongzi[$i-4]['kaoqin'];
	if($gongzi[$i-4]['ruzhi']>0){
	  $value7=date("Y-m-d",$gongzi[$i-4]['ruzhi']); //入职时间
	}else{
	  $value7="无";	
		}
	$value8=$gongzi[$i-4]['nianxian'];
	//处理层级
		  $tmpcengjiname=str_replace("（","(",str_replace("）",")",$cengji[$gongzi[$i-4]['cengji']]['cjname']));
		  $cjnamearr=explode("(",$tmpcengjiname);
		  if(count($cjnamearr)>1){
			  $cj_name=$cjnamearr[0];
			  $cj_dc=str_replace(")","",$cjnamearr[1]);
			  }else{
			  $cj_name=$cjnamearr[0];
			  $cj_dc=0;				  
				  }
			unset($cjnamearr);	
				
	$value9=$cj_name;
	$value10=$cj_dc;
	if($gongzi[$i-4]['dangtime']>0){
	  $value11=date("Y-m-d",$gongzi[$i-4]['dangtime']);
	}else{
	  $value11="";	
		}
	if($gongzi[$i-4]['jitime']>0){	
	  $value12=date("Y-m-d",$gongzi[$i-4]['jitime']);
	}else{
	  $value12="";
		}
	$value13=$gwdj[$gongzi[$i-4]['gwjb']]['cjname'];
	$value14=$gangwei[$gongzi[$i-4]['gwlb']];
	$value15=$zhiwu[$gongzi[$i-4]['zhiwu']];
	$value16=$gongzi[$i-4]['jiben']; //基础工资
	$value17=$gongzi[$i-4]['cengjigz']; //层级工资
	$value18=$kaohedj[$gongzi[$i-4]['kaohedj']];
	$value19=$gongzi[$i-4]['yf_yjx'];
	$value20=$gongzi[$i-4]['kf_yjx'];
	$value21=$gongzi[$i-4]['sf_yjx'];
	$value22=$gongzi[$i-4]['ndjx'];
	$value23=$gongzi[$i-4]['zhiwugz'];
	$value24=$gongzi[$i-4]['tsgwgz'];
	$value25=$gongzi[$i-4]['nvwsf'];
	$value26=$gongzi[$i-4]['tcgx'];
	$value27=$gongzi[$i-4]['yingfa'];
	$value28=$gongzi[$i-4]['shifa'];
	$value29=$gongzi[$i-4]['beizhu'];
	
								
			  $obpe->getActiveSheet()->setCellValue("A$i","$value1");
			  $obpe->getActiveSheet()->setCellValue("B$i","$value2");
			  $obpe->getActiveSheet()->setCellValue("C$i","$value3");
			  $obpe->getActiveSheet()->setCellValue("D$i","$value4");
			  $obpe->getActiveSheet()->setCellValue("E$i","$value5");
			  $obpe->getActiveSheet()->setCellValue("F$i","$value6");
			  $obpe->getActiveSheet()->setCellValue("G$i","$value7");
			  $obpe->getActiveSheet()->setCellValue("H$i","$value8");
			  $obpe->getActiveSheet()->setCellValue("I$i","$value9");
			  $obpe->getActiveSheet()->setCellValue("J$i","$value10");
			  $obpe->getActiveSheet()->setCellValue("K$i","$value11");
			  $obpe->getActiveSheet()->setCellValue("L$i","$value12");
			  $obpe->getActiveSheet()->setCellValue("M$i","$value13");
			  $obpe->getActiveSheet()->setCellValue("N$i","$value14");
			  $obpe->getActiveSheet()->setCellValue("O$i","$value15");
			  $obpe->getActiveSheet()->setCellValue("P$i","$value16");
			  $obpe->getActiveSheet()->setCellValue("Q$i","$value17");
			  $obpe->getActiveSheet()->setCellValue("R$i","$value18");
			  $obpe->getActiveSheet()->setCellValue("S$i","$value19");
			  $obpe->getActiveSheet()->setCellValue("T$i","$value20");
			  $obpe->getActiveSheet()->setCellValue("U$i","$value21");
			  $obpe->getActiveSheet()->setCellValue("V$i","$value22");
			  $obpe->getActiveSheet()->setCellValue("W$i","$value23");
			  $obpe->getActiveSheet()->setCellValue("X$i","$value24");
			  $obpe->getActiveSheet()->setCellValue("Y$i","$value25");
			  $obpe->getActiveSheet()->setCellValue("Z$i","$value26");
			  $obpe->getActiveSheet()->setCellValue("AA$i","$value27");
			  $obpe->getActiveSheet()->setCellValue("AB$i","$value28");
			  $obpe->getActiveSheet()->setCellValue("AC$i","$value29");
			
	
	$k++; 
} 

$hj=$hang+4;
$qz=$hj+1;
$qz2=$hj+2;
//合计
////////////////////////////////////////////////////////////////////////
///合计统计
$tj01="岗位级别：一级岗岗位".$gwdj_tj[1]."人；二级岗岗位".$gwdj_tj[2]."人，三级岗岗位".$gwdj_tj[3]."人；"."\r\n";
$cjstr="见习辅警".intval($cj_tj[1]['cj'])."人，其中一级岗岗位".intval($cj_tj[1][1])."人，二级岗岗位".intval($cj_tj[1][2])."人，三级岗岗位".intval($cj_tj[1][3])."人；\r\n";
$cjstr7= "七级辅警".(intval($cj_tj[8]['cj'])+intval($cj_tj[9]['cj'])+intval($cj_tj[10]['cj']))."人，其中1档".intval($cj_tj[8]['cj'])."人，2档".intval($cj_tj[9]['cj'])."人，3档".intval($cj_tj[10]['cj'])."人；\r\n";
$cjstr6= "六级辅警".(intval($cj_tj[2]['cj'])+intval($cj_tj[11]['cj'])+intval($cj_tj[12]['cj']))."人，其中1档".intval($cj_tj[2]['cj'])."人，2档".intval($cj_tj[11]['cj'])."人，3档".intval($cj_tj[12]['cj'])."人；\r\n";
$cjstr5= "五级辅警".(intval($cj_tj[3]['cj'])+intval($cj_tj[13]['cj'])+intval($cj_tj[14]['cj']))."人，其中1档".intval($cj_tj[3]['cj'])."人，2档".intval($cj_tj[13]['cj'])."人，3档".intval($cj_tj[14]['cj'])."人；\r\n";

$cjstr4= "四级辅警".(intval($cj_tj[4]['cj'])+intval($cj_tj[15]['cj'])+intval($cj_tj[16]['cj'])+intval($cj_tj[17]['cj'])+intval($cj_tj[18]['cj'])+intval($cj_tj[19]['cj'])+intval($cj_tj[20]['cj'])+intval($cj_tj[21]['cj'])+intval($cj_tj[22]['cj'])+intval($cj_tj[23]['cj'])+intval($cj_tj[24]['cj']))."人，其中1档".intval($cj_tj[4]['cj'])."人，2档".intval($cj_tj[15]['cj'])."人，3档".intval($cj_tj[16]['cj'])."人，4档；".+intval($cj_tj[17]['cj'])."人；5档".+intval($cj_tj[18]['cj'])."人，6档".+intval($cj_tj[19]['cj'])."人，7档".+intval($cj_tj[20]['cj'])."人，8档".+intval($cj_tj[21]['cj'])."人，9档".+intval($cj_tj[22]['cj'])."人，10档".+intval($cj_tj[23]['cj'])."人，11档".+intval($cj_tj[24]['cj'])."人\r\n";

$cjstr3= "三级辅警".(intval($cj_tj[5]['cj'])+intval($cj_tj[25]['cj'])+intval($cj_tj[26]['cj'])+intval($cj_tj[27]['cj'])+intval($cj_tj[28]['cj'])+intval($cj_tj[29]['cj'])+intval($cj_tj[30]['cj'])+intval($cj_tj[31]['cj'])+intval($cj_tj[32]['cj'])+intval($cj_tj[33]['cj']))."人，其中1档".intval($cj_tj[5]['cj'])."人，2档".intval($cj_tj[25]['cj'])."人，3档".intval($cj_tj[26]['cj'])."人，4档；".+intval($cj_tj[27]['cj'])."人；5档".+intval($cj_tj[28]['cj'])."人，6档".+intval($cj_tj[29]['cj'])."人，7档".+intval($cj_tj[30]['cj'])."人，8档".+intval($cj_tj[31]['cj'])."人，9档".+intval($cj_tj[32]['cj'])."人，10档".intval($cj_tj[33]['cj'])."人；\r\n";

$cjstr2= "二级辅警".(intval($cj_tj[6]['cj'])+intval($cj_tj[34]['cj'])+intval($cj_tj[35]['cj'])+intval($cj_tj[36]['cj'])+intval($cj_tj[37]['cj'])+intval($cj_tj[38]['cj'])+intval($cj_tj[39]['cj'])+intval($cj_tj[40]['cj'])+intval($cj_tj[41]['cj'])+intval($cj_tj[42]['cj']))."人，其中1档".intval($cj_tj[6]['cj'])."人，2档".intval($cj_tj[34]['cj'])."人，3档".intval($cj_tj[35]['cj'])."人，4档；".+intval($cj_tj[36]['cj'])."人；5档".+intval($cj_tj[37]['cj'])."人，6档".+intval($cj_tj[38]['cj'])."人，7档".+intval($cj_tj[39]['cj'])."人，8档".+intval($cj_tj[40]['cj'])."人，9档".+intval($cj_tj[41]['cj'])."人，10档".intval($cj_tj[42]['cj'])."人；\r\n";;

$cjstr1= "一级辅警".(intval($cj_tj[7]['cj'])+intval($cj_tj[43]['cj'])+intval($cj_tj[44]['cj'])+intval($cj_tj[45]['cj'])+intval($cj_tj[46]['cj'])+intval($cj_tj[47]['cj'])+intval($cj_tj[48]['cj']))."人，其中1档".intval($cj_tj[7]['cj'])."人，2档".intval($cj_tj[43]['cj'])."人，3档".intval($cj_tj[44]['cj'])."人，4档；".+intval($cj_tj[45]['cj'])."人；5档".+intval($cj_tj[46]['cj'])."人，6档".+intval($cj_tj[47]['cj'])."人，7档".+intval($cj_tj[48]['cj'])."人；\r\n"; 

$tj02="层级确定：\r\n".$cjstr.$cjstr7.$cjstr6.$cjstr5.$cjstr4.$cjstr3.$cjstr2.$cjstr1;
$tj03=$tj01.$tj02;
$tj_04="优秀".intval($kh_tj[2])."人;合格".intval($kh_tj[3])."人，基本合格".intval($kh_tj[19])."人，不合格".intval($kh_tj[4])."人，不确定等次".intval($kh_tj[23])."人，未指定等次".intval($kh_tj[0])."人";

////////////////////////////////////////////////////////////////////////
$obpe->getActiveSheet()->mergeCells("B$hj:O$hj");	
$obpe->getActiveSheet()->setCellValue("A$hj","合计"); 
 $obpe->getActiveSheet()->setCellValue("B$hj","$tj03");
 $obpe->getActiveSheet()->getStyle("B$hj")->getAlignment()->setWrapText(true);
 $obpe->getActiveSheet()->getStyle("R$hj")->getAlignment()->setWrapText(true);
$obpe->getActiveSheet()->getRowDimension("$hj")->setRowHeight(170); 	
//$obpe->getActiveSheet()->getStyle("B$hj")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中
$obpe->getActiveSheet()->getStyle("B$hj")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$obpe->getActiveSheet()->getStyle("R$hj")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                                                          
 $obpe->getActiveSheet()->setCellValue("J$hj","");
 $obpe->getActiveSheet()->setCellValue("P$hj",$jiben); 
 $obpe->getActiveSheet()->setCellValue("Q$hj",$nvwsf);      
  $obpe->getActiveSheet()->setCellValue("R$hj",$tj_04);      
   $obpe->getActiveSheet()->setCellValue("S$hj",$zhiji);      
    $obpe->getActiveSheet()->setCellValue("T$hj",$zwgz);
	$obpe->getActiveSheet()->setCellValue("U$hj",$yingfa);      
	 $obpe->getActiveSheet()->setCellValue("V$hj",$yanglao); 
	 $obpe->getActiveSheet()->setCellValue("W$hj",$shiye); 
	 $obpe->getActiveSheet()->setCellValue("X$hj",$yiliao); 
	 $obpe->getActiveSheet()->setCellValue("Y$hj",$shifa);  
	 $obpe->getActiveSheet()->setCellValue("Z$hj",$shifa);
	 $obpe->getActiveSheet()->setCellValue("AA$hj",$shifa);
	 $obpe->getActiveSheet()->setCellValue("AB$hj",$shifa);
 
//领导签字
$obpe->getActiveSheet()->setCellValue("A$qz","单位主要负责人：");  
$obpe->getActiveSheet()->setCellValue("J$qz","部门领导：");  
$obpe->getActiveSheet()->setCellValue("O$qz","制表人：吕镇豪 ");  

//插入签名
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('avatar');
$objDrawing->setDescription('avatar');
$objDrawing->setPath('uploadfile/qianming/30.png');
$objDrawing->setHeight(100);
$objDrawing->setWidth(190);
$objDrawing->setCoordinates("C$qz");
$objDrawing->setWorksheet($obpe->getActiveSheet());

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('avatar');
$objDrawing->setDescription('avatar');
$objDrawing->setPath('uploadfile/qianming/38.png');
$objDrawing->setHeight(90);
$objDrawing->setWidth(190);
$objDrawing->setCoordinates("L$qz");
$objDrawing->setWorksheet($obpe->getActiveSheet());

//$obpe->getActiveSheet()->setCellValue("A$qz2","管委会审核：");  	                
//写入类容
$obwrite = PHPExcel_IOFactory::createWriter($obpe, 'Excel5');
//ob_end_clean();
//保存文件
$obwrite->save('mulit_sheet.xls');
           
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
header("Content-Disposition:attachment;filename=高新分局警务辅助人员（".$infos['yue']."）工资表.xls");
header('Content-Transfer-Encoding:binary');
$obwrite->save('php://output');

}	


public function daokq(){



$kqflag=require 'caches/kaoqinflag.php';
foreach($kqflag as $vs){
if($vs[0]=='辞职'){$vs[0]="辞";}	
$flag[$vs[2]]=$vs[0];
}

	$tbname=$_GET['tbname'];
	 $rsss=$this->db->get_fields($tbname);
      /*foreach($rsss as $k=>$v){
      if(strtotime($k)){
        $rowname[]=$k;
        }  
        }*/  
	
	//print_r($rsss);	
		$qk=count($rsss)-6;
	//echo $qk;exit;	
		
	header("Content-Type:text/html;charset=utf-8");  
			require PC_PATH.'libs/classes/PHPExcel/Classes/PHPExcel.php';
//			error_reporting(E_ALL);  
//ini_set('display_errors', TRUE);  
//ini_set('display_startup_errors', TRUE);  
/*
  $this->db->table_name = "mj_fujing"; 
  $u_arr = $this->db->select("","id,sfz");
  foreach($u_arr as $v){
	  $arr_u[$v['id']]=$v['sfz'];
	  }
  unset($u_arr); //释放中间变量
*/
  
 $this->db->table_name = "mj_$tbname"; 
  $datas = $this->db->select("","*","","id asc");
foreach($datas as $key=>$value){

	foreach($value as $k=>$v){
		if($k=='bmid'||$k=='userid'||$k=='islock'||$k=='kqtj'||$k=='bmuser'||$k=='bmok'||$k=='bmdt'||$k=='zguser'||$k=='zgok'||$k=='zgdt'){
			unset($datas[$key][$k]);
			}
		if($k=='beizhu'){
		$datas[$key]['haha']=$v;
			unset($datas[$key][$k]);
			
			}	
		}
}


//变换数组结构
//foreach($datas as $tindx=>$v){
// 	array_splice($datas[$tindx],3,0,$arr_u[$v['userid']]);
//	}
/////////////////////
//print_r($datas);exit;
$gongzi=$datas;
//print_r($datas[0]);exit;
//echo count($gongzi);exit;


/* @实例化 */
$obpe = new PHPExcel();  
//总工资表--------------------------------------------

$obpe->getActiveSheet()->setTitle("考勤");
//Excel表格4种情况
if($qk==38){ 
$letter2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI');  
$tableheader2 = array('序号','姓名','身份证','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','备注'); 
$bt_kuan="AI1";
$kq_sd="AF2";
$kq_zbr="Q";
$kq_bs="AF";
$kq_w="AI";
}
if($qk==37){ 
$letter2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH');  
$tableheader2 = array('序号','姓名','身份证','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','备注'); 
$bt_kuan="AH1";
$kq_sd="AE2";
$kq_zbr="Q";
$kq_bs="AE";
$kq_w="AH";
}
if($qk==36){ 
$letter2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG');  
$tableheader2 = array('序号','姓名','身份证','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','备注'); 
$bt_kuan="AG1";
$kq_sd="AD2";
$kq_zbr="Q";
$kq_bs="AD";
$kq_w="AG";
}
if($qk==35){ 
$letter2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF');  
$tableheader2 = array('序号','姓名','身份证','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','备注'); 
$bt_kuan="AF1";
$kq_sd="AC2";
$kq_zbr="Q";
$kq_bs="AC";
$kq_w="AF";
}
//数据总数
$hang= count($gongzi);
$bh=$hang+3;	
//表头数组  
 

//边框
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    //'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                    'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                    //'color' => array('argb' => 'FFFF0000'),
                ),
            ),
        );


// 设置边距为0.5厘米 (1英寸 = 2.54厘米)
$margin = 1 / 2.54;   //phpexcel 中是按英寸来计算的,所以这里换算了一下
$obpe->getActiveSheet()->getPageMargins();
$obpe->getActiveSheet()->getPageMargins()->setTop($margin);       //上边距
$obpe->getActiveSheet()->getPageMargins()->setBottom($margin);   //下
$obpe->getActiveSheet()->getPageMargins()->setLeft($margin);      //左
$obpe->getActiveSheet()->getPageMargins()->setRight(0);    //右

//跑循环设置单元格宽度
foreach($letter2 as $v){
	if($v=="A" || $v=="B" ){
	 $obpe->getActiveSheet()->getColumnDimension("$v")->setWidth(10);	
		}else{
	  if( $v=="C"){
		  $obpe->getActiveSheet()->getColumnDimension("$v")->setWidth(25);
		  }else{		
	   $obpe->getActiveSheet()->getColumnDimension("$v")->setWidth(3.5);
	  }
	}
}
$beizhuk=$letter2[count($letter2)-1];
$obpe->getActiveSheet()->getColumnDimension("$beizhuk")->setWidth(20);

//$obpe->getActiveSheet()->mergeCells('A1:O1');		

$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中
$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);      //第一行是否加粗
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);         //第一行字体大小

 
//考勤时段
$yue=$_GET['yue'];
$dn=substr($yue,0,4);
$dy=substr($yue,4,2);
/*
if($dy=='01'){
$xy="12";
}else{
$xy=$dy-1;
}*/
$txday=date("Y年m月",strtotime($yue."01 +1 month"));
//计算本月最后一天，真J8恶心
$md=date("d",strtotime(date("Y-m-d",strtotime($yue."01 +1 month"))."-1 day"));
//echo date("d",strtotime(date("Y-m-d",strtotime($yue."01 +1 month"))."-1 day"));exit;

//写入多行数据

$obpe->getActiveSheet()->getRowDimension("1")->setRowHeight(30);
$obpe->getActiveSheet()->setCellValue("A1","唐山高新区管委会短期合同制工作人员考勤表"); 
$obpe->getActiveSheet()->mergeCells("A1:$bt_kuan"); 
$obpe->getActiveSheet()->getRowDimension("2")->setRowHeight(20);
$obpe->getActiveSheet()->setCellValue("A2","单位（盖章）  ：高新区公安分局 "); 
$obpe->getActiveSheet()->setCellValue("$kq_sd","考勤时段".$dy."月1日至".$dy."月".$md."日"); 


for($i = 0;$i < count($tableheader2);$i++) {
	$obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中	  
    $obpe->getActiveSheet()->setCellValue("$letter2[$i]3","$tableheader2[$i]");
	$obpe->getActiveSheet()->getStyle("$letter2[$i]3")->applyFromArray($styleArray);
	//设置单元格背景色,可用
	/*
	if(intval($tableheader2[$i])>0){
	$obpe->getActiveSheet()->getStyle("$letter2[$i]3")->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'ff8040')
        )
      )
    );
	} */
}  

$k=1 ;
for ($i = 4;$i <= count($gongzi) + 4;$i++) {  
    $j = 0; 
	
    foreach ($gongzi[$i - 4] as $key=>$value) {  
		
		if($j==0||$j==1||$j==2){
		$value=$value;
		}else{
		$value=$flag[$value];
		}
		//echo $letter2[$j].">".$value."<br>";
		      $obpe->getActiveSheet()->getStyle("$letter2[$j]$i")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			  $obpe->getActiveSheet()->getStyle("$letter2[$j]$i")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中		
			  $obpe->getActiveSheet()->setCellValue("$letter2[$j]$i","$value");
			  $obpe->getActiveSheet()->getStyle("$letter2[$j]$i")->applyFromArray($styleArray);
			
		if($j<count($tableheader2)-1){	
        $j++; 
		
		}else{
		  continue;	
			}
		
		
    } 
	
	$k++;
	//exit; 
} 


$hj=$hang+4;
$qz=$hj;
$qz2=$hj+1;


$obpe->getActiveSheet()->getRowDimension("$qz")->setRowHeight(80);
$obpe->getActiveSheet()->getStyle("A$qz")->getAlignment()->setWrapText(true);
$obpe->getActiveSheet()->setCellValue("A$qz","注：\n 1.出勤:√  病假:○  事假:△  年休假:D  婚假:H  丧假:S  产假:C  护理假:P  探亲假:T  工伤:G  二线:E  旷工:×；  双休日、节假日不填写。\n 2.考勤表须在每月21日报送人社局人事处，遇节假日顺延至工作日第一天。\n 3.特殊情况须在备注栏进行说明。\n"); 
$obpe->getActiveSheet()->mergeCells("A$qz:$kq_w$qz");

//领导签字
$obpe->getActiveSheet()->getRowDimension("$qz2")->setRowHeight(30);
$obpe->getActiveSheet()->getStyle("A$qz2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$obpe->getActiveSheet()->getStyle("G$qz2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$obpe->getActiveSheet()->getStyle("$kq_zbr$qz2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$obpe->getActiveSheet()->getStyle("$kq_bs$qz2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
$obpe->getActiveSheet()->setCellValue("A$qz2","单位主管领导签字：");  
$obpe->getActiveSheet()->setCellValue("G$qz2","考勤登记人员签字：");  
$obpe->getActiveSheet()->setCellValue("$kq_zbr$qz2","制表人：___________  联系电话： 3163479");  
$obpe->getActiveSheet()->setCellValue("$kq_bs$qz2","报送时间： ".$txday."01日");  

//插入签名
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('avatar');
$objDrawing->setDescription('avatar');
$objDrawing->setPath('uploadfile/qianming/30.png');
$objDrawing->setHeight(100);
$objDrawing->setWidth(190);
$objDrawing->setCoordinates("C$qz2");
$objDrawing->setWorksheet($obpe->getActiveSheet());

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('avatar');
$objDrawing->setDescription('avatar');
$objDrawing->setPath('uploadfile/qianming/38.png');
$objDrawing->setHeight(90);
$objDrawing->setWidth(190);
$objDrawing->setCoordinates("L$qz2");
$objDrawing->setWorksheet($obpe->getActiveSheet());
	

//设置纸型
$obpe->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$obpe->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

                
//写入类容
$obwrite = PHPExcel_IOFactory::createWriter($obpe, 'Excel5');
//ob_end_clean();
//保存文件
$obwrite->save('mulit_sheet.xls');
           
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
header("Content-Disposition:attachment;filename=唐山高新区管委会短期合同制工作人员考勤表".$yue.".xls");
header('Content-Transfer-Encoding:binary');
$obwrite->save('php://output');

}	

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//特殊任务审批表导出

public function daotsrenwu(){
		
$yue=intval($_GET['yue']);

	header("Content-Type:text/html;charset=utf-8");  
	require PC_PATH.'libs/classes/PHPExcel/Classes/PHPExcel.php';
//error_reporting(E_ALL);  
//ini_set('display_errors', TRUE);  
//ini_set('display_startup_errors', TRUE);  

		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		//岗位映射
		  $this->db->table_name = 'mj_gangwei';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gangwei[$v['id']]=$v['gwname'];  
			 }			 
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }


  $this->db->table_name = "mj_tsrenwu"; 
  $datas = $this->db->select("yue=$yue and isok1>0","id,userid,sfz,bmid,rwname,sgdt,tianshu,je,beizhu","","id asc");
  
  if(!is_array($datas)){
    showmessage("不存在可用导出的数据，无法进行操作"); 
  }
  
  $jezj=0;
  for($i=0;$i<count($datas);$i++){
	$datas[$i]['id']=$i+1;  
    $datas[$i]['userid']=$fujings[$datas[$i]['userid']];
	$datas[$i]['bmid']=$bumen[$datas[$i]['bmid']];
	$jezj+=$datas[$i]['je'];
  }
  

/* @实例化 */
$obpe = new PHPExcel();  
//总工资表--------------------------------------------

$obpe->getActiveSheet()->setTitle("特殊任务补助审批表");
//Excel表格4种情况

$letter2 = array('A','B','C','D','E','F','G','H','I');  
$tableheader2 = array('序号','姓名','身份证号','所在单位','任务名称','上岗时间','上岗天数','补助金额','备注'); 


//数据总数
$hang= count($datas);
$bh=$hang+3;	
//表头数组  

$obpe->getActiveSheet()->getDefaultRowDimension()->setRowHeight('25'); //设置默认行高
 
$obpe->getActiveSheet()->mergeCells('A1:I1');		

$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中
$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);      //第一行是否加粗
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);         //第一行字体大小

//写入多行数据
//主标题  
$yues=date("Y年m月",strtotime($_GET['yue']."01"));
 
$obpe->getActiveSheet()->setCellValue("A1","高新公安分局辅警队员".$yues."特殊任务补助审批表"); 
$obpe->getActiveSheet()->setCellValue("A2","填报单位  ： 高新公安分局政治处"); 
$obpe->getActiveSheet()->setCellValue("H2","填报日期 ： ".date("Y年m月d日")); 

	
for($i = 0;$i < count($tableheader2);$i++) {
    $obpe->getActiveSheet()->setCellValue("$letter2[$i]3","$tableheader2[$i]"); 
	$obpe->getActiveSheet()->getColumnDimension("$letter2[$i]")->setWidth('15');
    $obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中 
	$obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getFont()->setBold(true);      //第一行是否加粗
	
}  

//输出表格

$liej=4;

for ($i = 0;$i <= count($datas);$i++) { //行

	$v1=$datas[$i]['id'];
	$v2=$datas[$i]['userid'];
	$v3=$datas[$i]['sfz'];
	$v4=$datas[$i]['bmid'];
	$v5=$datas[$i]['rwname'];
	$v6=$datas[$i]['sgdt'];
	$v7=$datas[$i]['tianshu'];
	$v8=$datas[$i]['je'];
	$v9=$datas[$i]['beizhu'];
	 	
	$obpe->getActiveSheet()->setCellValue("$letter2[0]$liej","$v1");	
	$obpe->getActiveSheet()->setCellValue("$letter2[1]$liej","$v2");
	$obpe->getActiveSheet()->setCellValue("$letter2[2]$liej","$v3");
	$obpe->getActiveSheet()->setCellValue("$letter2[3]$liej","$v4");
	$obpe->getActiveSheet()->setCellValue("$letter2[4]$liej","$v5");
	$obpe->getActiveSheet()->setCellValue("$letter2[5]$liej","$v6");
	$obpe->getActiveSheet()->setCellValue("$letter2[6]$liej","$v7");
	$obpe->getActiveSheet()->setCellValue("$letter2[7]$liej","$v8");
	$obpe->getActiveSheet()->setCellValue("$letter2[8]$liej","$v9");

	
  $liej++; 
  
} 

//合计
$hj=$hang+4;
$qz=$hj;
$qz2=$hj+1;

	$obpe->getActiveSheet()->setCellValue("$letter2[0]$qz","合计");	
	$obpe->getActiveSheet()->setCellValue("$letter2[1]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[2]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[3]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[4]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[5]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[6]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[7]$qz","$jezj");
	$obpe->getActiveSheet()->setCellValue("$letter2[8]$qz","");
	


// 设置边框
    $styleThinBlackBorderOutline = array(
        'borders' => array(
            'allborders' => array( //设置全部边框
                'style' => \PHPExcel_Style_Border::BORDER_THIN //粗的是thick
            ),

        ),
    );
	
	$obpe->getActiveSheet()->getStyle( "A3:I$qz")->applyFromArray($styleThinBlackBorderOutline);	 
	
//领导签字
$obpe->getActiveSheet()->mergeCells("A$qz2:B$qz2");
$obpe->getActiveSheet()->setCellValue("A$qz2","主要负责人：");  
$obpe->getActiveSheet()->mergeCells("D$qz2:E$qz2");
$obpe->getActiveSheet()->setCellValue("D$qz2","分管领导：");
$obpe->getActiveSheet()->mergeCells("H$qz2:I$qz2");  
$obpe->getActiveSheet()->setCellValue("H$qz2","用人单位：");  
                
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
header("Content-Disposition:attachment;filename=高新公安分局辅警队员".$yues."特殊任务补助审批表.xls");
header('Content-Transfer-Encoding:binary');
$obwrite->save('php://output');

}	

//突出贡献审批表

public function daotcgongxian(){
		
$yue=intval($_GET['yue']);

	header("Content-Type:text/html;charset=utf-8");  
	require PC_PATH.'libs/classes/PHPExcel/Classes/PHPExcel.php';
//error_reporting(E_ALL);  
//ini_set('display_errors', TRUE);  
//ini_set('display_startup_errors', TRUE);  

		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		//岗位映射
		  $this->db->table_name = 'mj_gangwei';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gangwei[$v['id']]=$v['gwname'];  
			 }			 
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }


  $this->db->table_name = "mj_tcgongxian"; 
  $datas = $this->db->select(" bmok>0 and yue=$yue ","id,userid,bmid,gangwei,shiji,je,beizhu","","bmid asc");  //导出全部部门已审核的
  
  if(!is_array($datas)){
    showmessage("不存在可用导出的数据，无法进行操作"); 
  }
  
  $jezj=0;
  for($i=0;$i<count($datas);$i++){
	$datas[$i]['id']=$i+1;  
    $datas[$i]['userid']=$fujings[$datas[$i]['userid']];
	$datas[$i]['bmid']=$bumen[$datas[$i]['bmid']];
	$datas[$i]['gangwei']=$gangwei[$datas[$i]['gangwei']];
	$jezj+=$datas[$i]['je'];
  }
  

/* @实例化 */
$obpe = new PHPExcel();  
//总工资表--------------------------------------------

$obpe->getActiveSheet()->setTitle("突出贡献奖励发放表");
//Excel表格4种情况

$letter2 = array('A','B','C','D','E','F');  
$tableheader2 = array('序号','姓名','所属单位','奖励事迹','奖金','备注'); 


//数据总数
$hang= count($datas);
$bh=$hang+3;	
//表头数组  

$obpe->getActiveSheet()->getDefaultRowDimension()->setRowHeight('25'); //设置默认行高
 
$obpe->getActiveSheet()->mergeCells('A1:F1');		

$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中
$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);      //第一行是否加粗
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);         //第一行字体大小

//写入多行数据
//主标题  
$yues=date("Y年m月",strtotime($_GET['yue']."01"));
//echo $yues;exit;

$obpe->getActiveSheet()->getDefaultRowDimension('1')->setRowHeight('45'); //设置默认行高 
$obpe->getActiveSheet()->setCellValue("A1","高新公安分局".$yues."辅警突出贡献奖奖金发放表"); 


$obpe->getActiveSheet()->setCellValue("A2","填报单位  ： 高新公安分局"); 
$obpe->getActiveSheet()->mergeCells('A2:C2');

$obpe->getActiveSheet()->setCellValue("E2","填报日期 ： ".date("Y年m月d日")); 

	
for($i = 0;$i < count($tableheader2);$i++) {
    $obpe->getActiveSheet()->setCellValue("$letter2[$i]3","$tableheader2[$i]"); 
	if($i==3){
	   $obpe->getActiveSheet()->getColumnDimension("$letter2[$i]")->setWidth('65');
	 }
	if($i==0){  
	   $obpe->getActiveSheet()->getColumnDimension("$letter2[$i]")->setWidth('13');	      
	 }
	if($i==1){  
	   $obpe->getActiveSheet()->getColumnDimension("$letter2[$i]")->setWidth('15');	      
	 }
	if($i==2){  
	   $obpe->getActiveSheet()->getColumnDimension("$letter2[$i]")->setWidth('15');	      
	 }	
	if($i==4){  
	   $obpe->getActiveSheet()->getColumnDimension("$letter2[$i]")->setWidth('15');	      
	 }
	if($i==5){  
	   $obpe->getActiveSheet()->getColumnDimension("$letter2[$i]")->setWidth('15');	      
	 }	 	  	 
    $obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中 
	$obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getFont()->setBold(true);      //第一行是否加粗
	
}  

//输出表格

$liej=4;

for ($i = 0;$i <= count($datas);$i++) { //行

	$v1=$datas[$i]['id'];
	$v2=$datas[$i]['userid'];
	$v3=$datas[$i]['bmid'];
	$v4=$datas[$i]['shiji'];
	$v5=$datas[$i]['je'];
	$v6=$datas[$i]['beizhu'];
	 	
	$obpe->getActiveSheet()->setCellValue("$letter2[0]$liej","$v1");	
	$obpe->getActiveSheet()->setCellValue("$letter2[1]$liej","$v2");
	$obpe->getActiveSheet()->setCellValue("$letter2[2]$liej","$v3");
	$obpe->getActiveSheet()->setCellValue("$letter2[3]$liej","$v4");
	$obpe->getActiveSheet()->setCellValue("$letter2[4]$liej","$v5");
	$obpe->getActiveSheet()->setCellValue("$letter2[5]$liej","$v6");
	$obpe->getActiveSheet()->getStyle("$letter2[3]$liej")->getAlignment()->setWrapText(TRUE);
    $obpe->getActiveSheet()->getDefaultRowDimension("$liej")->setRowHeight(-1);
	$obpe->getActiveSheet()->getStyle("$letter2[0]$liej")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[0]$liej")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[1]$liej")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[1]$liej")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[2]$liej")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[2]$liej")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[3]$liej")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);	
	$obpe->getActiveSheet()->getStyle("$letter2[4]$liej")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[4]$liej")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[5]$liej")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[5]$liej")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	
  $liej++; 
  
} 

//合计
$hj=$hang+4;
$qz=$hj;
$qz2=$hj+1;

	$obpe->getActiveSheet()->setCellValue("$letter2[0]$qz","合计");	
	$obpe->getActiveSheet()->setCellValue("$letter2[1]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[2]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[3]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[4]$qz","$jezj");
	$obpe->getActiveSheet()->setCellValue("$letter2[5]$qz","");

	


// 设置边框
    $styleThinBlackBorderOutline = array(
        'borders' => array(
            'allborders' => array( //设置全部边框
                'style' => \PHPExcel_Style_Border::BORDER_THIN //粗的是thick
            ),

        ),
    );
	
	$obpe->getActiveSheet()->getStyle( "A3:F$qz")->applyFromArray($styleThinBlackBorderOutline);	 

//设置纸型
$obpe->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$obpe->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

$margin = 1 / 2.54;   //phpexcel 中是按英寸来计算的,所以这里换算了一下
$obpe->getActiveSheet()->getPageMargins()->setTop($margin);
$obpe->getActiveSheet()->getPageMargins()->setBottom($margin); //下
$obpe->getActiveSheet()->getPageMargins()->setLeft($margin);      //左
$obpe->getActiveSheet()->getPageMargins()->setRight($margin);    //右	
//领导签字

//$obpe->getActiveSheet()->getDefaultRowDimension("qz2")->setRowHeight(25);
$obpe->getActiveSheet()->setCellValue("A$qz2","主要负责人：");  
$obpe->getActiveSheet()->setCellValue("C$qz2","分管领导：");
$obpe->getActiveSheet()->setCellValue("E$qz2","审核人：");  
$obpe->getActiveSheet()->setCellValue("F$qz2","制表人：   ");
                
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
header("Content-Disposition:attachment;filename=高新公安分局".$yues."辅警突出贡献奖奖金发放表.xls");
header('Content-Transfer-Encoding:binary');
$obwrite->save('php://output');

}	


//绩效工资表导出

public function daojxgzb(){
		
$yue=intval($_GET['yue']);

	header("Content-Type:text/html;charset=utf-8");  
	require PC_PATH.'libs/classes/PHPExcel/Classes/PHPExcel.php';
//error_reporting(E_ALL);  
//ini_set('display_errors', TRUE);  
//ini_set('display_startup_errors', TRUE);  

		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		//岗位映射
		  $this->db->table_name = 'mj_gangwei';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gangwei[$v['id']]=$v['gwname'];  
			 }			 
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","id asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	

  $this->db->table_name = "mj_gongzi_jxgzb"; 
  $datas = $this->db->select("yue=$yue and islock=1","*","","id asc");
  
  if(count($datas)==0){
    showmessage("不存在可用导出的数据，无法进行操作"); 
  }
  
  $jxjj=0;
  $koufa=0;
  $jiaban=0;
  $tsrenwu=0;
  $tcgongxian=0;
  $sqbz=0;
  $shifa=0;
  
  // 人员合计：106人 突出贡献 ：18 人  优秀：20人  合格：86人 辞职：1人  辞退：人  不合格： 人    特殊任务 22人    年度优秀：人
  
  $_ryzj=count($datas);
  $_tcgongxian=0;
  $_youxiu=0;
  $_hege=0;
  $_buhege=0;
  $_tsrenwu=0;
  $_ndyouxiu=0;
  
  for($i=0;$i<count($datas);$i++){
	
	if($datas[$i]['tcgongxian']>0){$_tcgongxian++;}
	if($datas[$i]['khjieguo']==2){$_youxiu++;}
	if($datas[$i]['khjieguo']==3){$_hege++;}
	if($datas[$i]['khjieguo']==4){$_buhege++;}
	if($datas[$i]['tsrenwu']>0){$_tsrenwu++;}
	
	$datas[$i]['id']=$i+1;  
    $datas[$i]['userid']=$fujings[$datas[$i]['userid']];
	$datas[$i]['bmid']=$bumen[$datas[$i]['bmid']];
	$datas[$i]['khjieguo']=$dengji[$datas[$i]['khjieguo']];
	
	$jxjj+=$datas[$i]['jxjj'];
	$koufa+=$datas[$i]['koufa'];
	$jiaban+=$datas[$i]['jiaban'];
	$tsrenwu+=$datas[$i]['tsrenwu'];
	$tcgongxian+=$datas[$i]['tcgongxian'];
	$sqbz+=$datas[$i]['shequbz'];
	$shifa+=$datas[$i]['shifa'];
	
	
  }
  

/* @实例化 */
$obpe = new PHPExcel();  
//总工资表--------------------------------------------

$obpe->getActiveSheet()->setTitle("绩效奖金发放表");
//Excel表格4种情况

$letter2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M');  
$tableheader2 = array('序号','姓名','身份证号','所在单位','考核结果','绩效奖金(元)','扣除金额（元）','扣除原因','加班费（元）','特殊任务(元)','突出贡献奖（元）','实发金额','备注'); 


//数据总数
$hang= count($datas);
$bh=$hang+3;	

//设置纸型
$obpe->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$obpe->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

//表头数组  

$obpe->getActiveSheet()->getDefaultRowDimension()->setRowHeight('25'); //设置默认行高
 
$obpe->getActiveSheet()->mergeCells('A1:M1');		

$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中
$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);      //第一行是否加粗
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);         //第一行字体大小

//写入多行数据
//主标题  
$yues=date("Y年m月",strtotime($_GET['yue']."01"));
 
$obpe->getActiveSheet()->setCellValue("A1","高新公安分局".$yues."辅警绩效奖金、加班费发放表"); 
$obpe->getActiveSheet()->setCellValue("A2","填报日期 ： ".date("Y年m月d日")); 

	
for($i = 0;$i < count($tableheader2);$i++) {
    $obpe->getActiveSheet()->setCellValue("$letter2[$i]3","$tableheader2[$i]"); 
	$obpe->getActiveSheet()->getColumnDimension("$letter2[$i]")->setWidth('15');
    $obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中 
	$obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getFont()->setBold(true);      //第一行是否加粗
	
}  

//输出表格

$liej=4;

for ($i = 0;$i < count($datas);$i++) { //行

	$v1=$datas[$i]['id'];
	$v2=$datas[$i]['userid'];
	$v3=$datas[$i]['sfz'];
	$v4=$datas[$i]['bmid'];
	$v5=$datas[$i]['khjieguo'];
	$v6=$datas[$i]['jxjj'];
	$v7=$datas[$i]['koufa'];
	$v8=$datas[$i]['koufayy'];
	$v9=$datas[$i]['jiaban'];
	$v10=$datas[$i]['tsrenwu'];
	$v11=$datas[$i]['tcgongxian'];
	//$v12=$datas[$i]['shequbz'];
	$v13=$datas[$i]['shifa'];
	$v14=$datas[$i]['beizhu'];
	 	
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
	$obpe->getActiveSheet()->setCellValue("$letter2[11]$liej","$v13");
	$obpe->getActiveSheet()->setCellValue("$letter2[12]$liej","$v14");


	
  $liej++; 
  
} 

//合计
$hj=$hang+4;
$qz=$hj;

	
	$obpe->getActiveSheet()->setCellValue("$letter2[0]$qz","合计");	
	$obpe->getActiveSheet()->setCellValue("$letter2[1]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[2]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[3]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[4]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[5]$qz","$jxjj");
	$obpe->getActiveSheet()->setCellValue("$letter2[6]$qz","$koufa");
	$obpe->getActiveSheet()->setCellValue("$letter2[7]$qz","");
	$obpe->getActiveSheet()->setCellValue("$letter2[8]$qz","$jiaban");
	$obpe->getActiveSheet()->setCellValue("$letter2[9]$qz","$tsrenwu");
	$obpe->getActiveSheet()->setCellValue("$letter2[10]$qz","$tcgongxian");
	//$obpe->getActiveSheet()->setCellValue("$letter2[11]$qz","$sqbz");
	$obpe->getActiveSheet()->setCellValue("$letter2[11]$qz","$shifa");
	$obpe->getActiveSheet()->setCellValue("$letter2[12]$qz","");

// 人员合计：106人 突出贡献 ：18 人  优秀：20人  合格：86人 辞职：1人  辞退：人  不合格： 人    特殊任务 22人    年度优秀：人 
// 说明：如有特殊任务，请在备注栏备注任务名称、上岗时间。如有突出贡献的也需备注上说明。 同时上报《特殊任务补助审批表》和  《突出贡献奖励审批表》。

//说明行
$hj+=1;
$qz=$hj;

$obpe->getActiveSheet()->mergeCells("A$qz:M$qz");
$obpe->getActiveSheet()->setCellValue("A$qz","人员合计:".$_ryzj."人 ;突出贡献 ：".$_tcgongxian." 人  ;优秀：".$_youxiu."人  ;合格：".$_hege."人  ;辞职：0人  ;辞退：0人  ;不合格：".$_buhege." 人  ;特殊任务:".$_tsrenwu."人   ;年度优秀：0人 "); 

$hj+=1;
$qz=$hj;

$obpe->getActiveSheet()->mergeCells("A$qz:M$qz");
$obpe->getActiveSheet()->setCellValue("A$qz","说明：如有特殊任务，请在备注栏备注任务名称、上岗时间。如有突出贡献的也需备注上说明。 同时上报《特殊任务补助审批表》和  《突出贡献奖励审批表》。 "); 

  

// 设置边框
    $styleThinBlackBorderOutline = array(
        'borders' => array(
            'allborders' => array( //设置全部边框
                'style' => \PHPExcel_Style_Border::BORDER_THIN //粗的是thick
            ),

        ),
    );
	
	$obpe->getActiveSheet()->getStyle( "A3:M$qz")->applyFromArray($styleThinBlackBorderOutline);	 
	
//领导签字
$qz2=$hj+1;
$obpe->getActiveSheet()->setCellValue("A$qz2","主要负责人：");  
$obpe->getActiveSheet()->setCellValue("E$qz2","分管领导：");
$obpe->getActiveSheet()->setCellValue("I$qz2","审核人：");  
$obpe->getActiveSheet()->setCellValue("M$qz2","制表人：");
                
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
header("Content-Disposition:attachment;filename=高新公安分局".$yues."辅警绩效奖金、加班费发放表.xls");
header('Content-Transfer-Encoding:binary');
$obwrite->save('php://output');

}


	
}


