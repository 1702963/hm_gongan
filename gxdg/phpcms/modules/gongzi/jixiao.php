<?php
set_time_limit(0);
ini_set("display_errors", "On"); 
//error_reporting(7);

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class jixiao extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		$this->db2 = pc_base::load_model('opinion_model');
		$this->db->table_name = 'mj_gongzi_jixiao_sets';
		pc_base::load_app_func('global');
	}
	
	//默认
	public function init() { 
		
		include $this->admin_tpl('cengji_list');
	}
	
	//绩效基础设置
	public function sets() {
		
		$this->db->table_name = 'mj_gongzi_jixiao_sets';
		
		//创建基本项目
		if($_POST["addnew"]!=""){
			if(intval($_POST['settype'])>0){ //编辑
			   if($_POST['setname']!=""){
			    $arrs['setname']=$_POST['setname'];
			   }
			    $arrs['iscan']=intval($_POST['iscan']);
			    $ids=intval($_POST['settype']);
			  
			   $this->db->update($arrs,array("id"=>$ids));
			   $basemsg="<font color=red>基础设置已保存</font>";		
			 }else{
                 $arrs['setname']=$_POST['setname'];
				 $arrs['dotime']=time();
				 $this->db->insert($arrs);  
				 $basemsg="<font color=red>基础设置已保存</font>";
				 }
			 
		 }
		 
		 //创建子项目
		if($_POST["addnew1"]!=""){
                 $arrs['setname']=$_POST['setname'];
				 $arrs['pid']=$_POST['settype'];
				 $arrs['dotime']=time();
				 $this->db->insert($arrs);  
				 $basemsg="<font color=red>基础设置已保存</font>"; 
		 }		 
		 //编辑子项目
		if($_POST["addnew2"]!=""){
	
			$ids=intval($_POST['ids']);
                 $arrs['setname']=$_POST['setname'];
				 $arrs['pid']=$_POST['settype'];
				 $arrs['canshu']=$_POST['canshu'];
				 $arrs['iscan']=intval($_POST['iscan']);
				 $this->db->update($arrs,array("id"=>$ids));  
				 $basemsg="<font color=red>基础设置已保存</font>"; 
		 }			
		 
		 //编辑默认项
		if($_POST["addnew4"]!=""){
	
			$ids=intval($_POST['ids']);

				 $arrs['canshu']=$_POST['canshu'];
                 $arrs['fanwei']=$_POST['fanwei'];
			   
				 $this->db->update($arrs,array("id"=>$ids));  
				 $basemsg1="<font color=red>保留设置已保存</font>"; 
		 }			 
		
		$bases = $this->db->select("pid=0 and issys=0","*","","px asc");		
	    
		$zts[0]="停用";
		$zts[1]="启用";


	
	    $baseslists = $this->db->select("pid>0 and issys=0","*","","px asc");
		
		$syslists = $this->db->select("issys=1","*","","px asc");
	
		include $this->admin_tpl('gongzi_jixiao_sets');
	}	
	
    
	//绩效考评表管理
	public function guanli() {

		//由工资表同步人员信息
		if($_GET['yue']!="" && $_GET['addtable']!=""){

		//获取指定月工资表人员
			$this->db->table_name = $this->db->db_tablepre.'gz'.$_GET['yue'];
			$fjids = $this->db->select("","userid,bmid","","id asc");
			$this->db->table_name = 'mj_fujing';
            //获取岗位
			foreach($fjids as $i){
			 $tmps = $this->db->get_one("id=".$i['userid'],"gangwei,sfz","id desc");
			 $i['gangwei']=$tmps['gangwei'];
			 $i['sfz']=$tmps['sfz'];
			 $ids[]=$i;
			}

			//写入绩效表
			$this->db->table_name = 'mj_gongzi_jixiao';
			foreach($ids as $k=>$i){
			$arrs['userid']=$i['userid'];
			$arrs['bmid']=$i['bmid'];
			$arrs['gangwei']=$i['gangwei'];
			$arrs['sfz']=$i['sfz'];
			$arrs['yue']=$_GET['yue'];
		
			$this->db->insert($arrs);				
			}
					
		}
		
		//锁定绩效表
		if($_GET['yue']!="" && $_GET['locked']!=""){
		  if(intval($_GET['locked'])>0){$dolock=0;}else{$dolock=1;}
          $this->db->table_name = 'mj_gongzi_jixiao';
		  $yues=$_GET['yue'];
		  $this->db->update(array('islock'=>$dolock),array('yue'=>$yues));
			  	
		}
		
		$this->db->table_name = 'mj_gongzi_tables'; 
				
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$gz_tables = $this->db->listinfo('',$order = 'id desc',$page, $pages = '80');
		$pages = $this->db->pages;
		include $this->admin_tpl('jixiao_guanli');
	}	
	
	
	//查看绩效表
	function showtable()
	{
	    $yue=intval($_REQUEST['yue']);
		$where="yue='$yue'";
	    
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

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","id asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }		
			 			  
	  
		  //遍历数据表
		  $this->db->table_name = 'mj_gongzi_jixiao';	
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo($where,$order = 'id asc',$page, $pages = '10');
		  $pages = $this->db->pages;			
	
		   		
		include $this->admin_tpl('jixiao_showtable');
	}

    //考评表
	function kaoping()
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

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","id asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }			  
		  
		 //部门上报
		  if($_POST['dook']!=""){			
            $this->db->table_name = 'mj_gongzi_jixiao';	
		    $bmmasts=intval($_POST['bmmast']);
			$bmuserid=$_SESSION['userid'];
			$yues=intval($_POST['yue']);
			$bmids=intval($_POST['bmid']);
			
		    $this->db->update(array('bmmast'=>$bmmasts,'bmuserid'=>$bmuserid),array('yue'=>$yues,'bmid'=>$bmids));	
			
			//插入站内消息
			//获取本次审批涉及到的记录ID序列
			$isdrs = $this->db->select("bmid=$bmids and yue=$yues","id","","");
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
			$msgin['yuan']='绩效';
			$msgin['adddt']=time();
			$msgin['msg']=$bumen[$bmids].$_POST['yue']."绩效考核表等待您审核";
			$msgin['showuser']=$bmmasts;
			$msgin['doty']='bmuser';
			$msgin['yues']=$_POST['yue'];
			$msgin['adduser']=$_SESSION['userid'];
			$msgin['addbm']=$_SESSION['bmid'];
			$msgin['inids']=$_inids;
			  
			$this->db->insert($msgin);		
			}	
			
		 //部门审核
		  if($_POST['bmok']!=""){			
            $this->db->table_name = 'mj_gongzi_jixiao';	
            if(intval($_POST['bmmastok'])>0){ //同意,则自动转到政治处主任
			  //获取政治处主任的UID
			  $this->db2->table_name = 'mj_admin';	
			  $zzczr=$this->db2->get_one("roleid=2","*");
			  $oktime=time();
			  $zzcmast=$zzczr['userid'];
			  $yues=intval($_POST['yue']);
			  $bmids=$_SESSION['bmid'];	
			  $this->db->table_name = 'mj_gongzi_jixiao';		  
			  $this->db->update(array('bmmastok'=>1,'bmmastdt'=>$oktime,'zzcmast'=>$zzcmast),array('yue'=>$yues,'bmid'=>$bmids));
			  ///////
			//获取本次审批涉及到的记录ID序列
			$isdrs = $this->db->select("bmid=$bmids and yue=$yues","id","","");
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
			  
			   $msgin['yuan']='绩效考核';
			   $msgin['adddt']=time();
			   $msgin['msg']=$bumen[$_SESSION['bmid']].$yues."绩效考核表等待您审核";
			   $msgin['showuser']=$zzcmast;
			   $msgin['inids']=$_inids;
			   
			}else{ //拒绝,清空上报
			
			  $yues=intval($_POST['yue']);
			  $mes=$_SESSION['userid'];
			  //-----------------------------
			  //获取操作者
			  $douses=$this->db->get_one("yue=$yues and bmmast=$mes","*");			  			
			   $msgin['yuan']='绩效考核';
			   $msgin['adddt']=time();
			   $msgin['msg']=$bumen[$douses['bmid']].$yues."绩效考核表审核被拒绝";
			   $msgin['showuser']=$douses['bmuserid'];
			  //-----------------------------
			  
			  $this->db->update(array('bmmast'=>0,'bmuserid'=>0),array('yue'=>$yues,'bmmast'=>$mes));			  

			}
				
			//插入站内消息
			$this->db->table_name = 'mj_msgs';
			$this->db->insert($msgin);		
			}		
			
			
		 //政治处主任审核
		  if($_POST['zzcok']!=""){			
			
			$this->db->table_name = 'mj_gongzi_jixiao';	
		    $jumasts=intval($_POST['jumast']);
			$zzcmastdts=time();
			$yues=intval($_POST['yue']);
			$bmids=intval($_POST['bmid']);
			
		    $this->db->update(array('jumast'=>$jumasts,'zzcmastdt'=>$zzcmastdts,'zzcmastok'=>1),array('yue'=>$yues,'bmid'=>$bmids));	
			
			//插入站内消息
			//获取本次审批涉及到的记录ID序列
			$isdrs = $this->db->select("bmid=$bmids and yue=$yues","id","","");
			foreach($isdrs as $v){
				$_id_arr[]=$v['id'];
				}
			if(is_array($_id_arr)){
				$_inids=implode(",",$_id_arr);
				}else{
				$_inids="";//此选择肢仅为防止缺省异常	
					}	
			$msgin['inids']=$_inids;	
			///////////////////////////			
			$this->db->table_name = 'mj_msgs';
			$msgin['yuan']='绩效考核';
			$msgin['adddt']=time();
			$msgin['msg']=$bumen[$bmids].$_POST['yue']."绩效考核表等待您审核";
			$msgin['showuser']=$jumasts;
			$this->db->insert($msgin);		
			}				
			
			
		 //局领导审核
		  if($_POST['juok']!=""){			
			
			$this->db->table_name = 'mj_gongzi_jixiao';	

			$jumastdts=time();
			$yues=intval($_POST['yue']);
			$bmids=intval($_POST['bmid']);
			
		    $this->db->update(array('jumastok'=>1,'jumastdt'=>$jumastdts),array('yue'=>$yues,'bmid'=>$bmids));	
			
			//插入站内消息 局长审核不发消息
			//$this->db->table_name = 'mj_msgs';
			//$msgin['yuan']='绩效考核';
			//$msgin['adddt']=time();
			//$msgin['msg']=$bumen[$bmids].$_POST['yue']."绩效考核表等待您审核";
			//$msgin['showuser']=$jumasts;
			//$this->db->insert($msgin);		
			}				
			////////////////////////////////////////////////////////////////////					 		
				
		if($_GET['yue']!=''){
		  $this->db->table_name = 'mj_gongzi_jixiao';			  
		  		  
		  $where="1=1 and yue='".$_GET['yue']."'";
		  if($_SESSION['roleid']==1 || $_SESSION['roleid']==2 || $_SESSION['roleid']==3){
		    $where.=" and bmok>0 ";
		  }else{
			$where.=" and bmid=".$_SESSION['bmid'];
			  }
			  
		  if(intval($_GET['bms'])>1){ //选择部门
		   $where.=" and bmid=".intval($_GET['bms']);
		  }
			  		  
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo($where,$order = 'chengji desc',$page, $pages = '16');
		  $pages = $this->db->pages;	
		  include $this->admin_tpl('jixiao_kaoping');			 
		}else{
		    $this->db->table_name = 'mj_gongzi_tables';
		    $yuelists = $this->db->select("","*","","id desc");			
			include $this->admin_tpl('jixiao_kaoping_nous');
			}
		   
	}
	
	/////////////////////////////////////////////////////////
	function kaopingshenhe(){
	  //var_dump($_SESSION);exit;
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }
			 	  
	  $yues=$_GET['yue'];
	
		 $this->db->table_name = 'mj_gongzi_jixiao';
		 
	     if($_GET['ty']=='bm'){		 
		 $infos=$this->db->get_one(" yue=$yues and bmid=".$_SESSION['bmid'],"*"); 
		  //判断权限
		  if($infos['bmuser']>0){
			 showmessage("部门审核进行中，不允许重复申请"); 
			  } 		  	 
			 
		  //获取申请对象
		  $bms=$_SESSION['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select(" isbmuser=1 ","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		 	   
		  $rowsname="bmuser";  
		 }	
		 
	     if($_GET['ty']=='zzc'){
		  $infos=$this->db->get_one(" yue=$yues ","*"); 
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
		 	 
		 ////////////////////////////
		 //写入
		 
		 
		 	 	
		 if($_POST['dook']!=""){			 
           			 
			 foreach($_POST['sq'] as $k=>$v){
			   $inarr[$k]=$v;	 
				 }		                   
		
		//var_dump($_POST);exit;
         

 			 $this->db->table_name = 'mj_gongzi_jixiao';
			 $inarr['bmdt']=time();
			 if($_GET['ty']=='bm'){
			 $this->db->update($inarr,array('bmid'=>$_SESSION['bmid'],'yue'=>$yues));
			 $bmids=intval($_POST['bmid']);
			//获取本次审批涉及到的记录ID序列
			$isdrs = $this->db->select("bmid=$bmids and yue=$yues","id","","");
			foreach($isdrs as $v){
				$_id_arr[]=$v['id'];
				}
			if(is_array($_id_arr)){
				$_inids=implode(",",$_id_arr);
				}else{
				$_inids="";//此选择肢仅为防止缺省异常	
					}	
			$msgin['inids']=$_inids;	
			//////////////////////////			 
			 }else{
				$this->db->update($inarr,array('yue'=>$yues)); 
			//获取本次审批涉及到的记录ID序列
			$isdrs = $this->db->select("yue=$yues","id","","");
			foreach($isdrs as $v){
				$_id_arr[]=$v['id'];
				}
			if(is_array($_id_arr)){
				$_inids=implode(",",$_id_arr);
				}else{
				$_inids="";//此选择肢仅为防止缺省异常	
					}	
			$msgin['inids']=$_inids;	
			/////////////////				
				 }
			 
			//插入站内消息
			$this->db->table_name = 'mj_msgs';
			$msgin['yuan']='绩效考评';
			$msgin['adddt']=time();
			$msgin['msg']=$bumen[$_POST['bmid']].$_GET['yue']."绩效考评等待您审核";
			$msgin['showuser']=$inarr[$rowsname];
			$msgin['doty']=$rowsname;
			$msgin['yues']=$_GET['yue'];
			$msgin['adduser']=$_SESSION['userid'];
			$msgin['addbm']=$_SESSION['bmid'];
			
			$this->db->insert($msgin);			
			
			showmessage("审核申请已提交，请关闭窗口");	   
			 }		
			 
			 include $this->admin_tpl('jixiao_shenqing'); 
		 
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////
   //特殊贡献
	function tcgongxian()
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

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","id asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }			  
		
		/*  
		 //部门上报
		  if($_POST['dook']!=""){			
            $this->db->table_name = 'mj_gongzi_jixiao';	
		    $bmmasts=intval($_POST['bmmast']);
			$bmuserid=$_SESSION['userid'];
			$yues=intval($_POST['yue']);
			$bmids=intval($_POST['bmid']);
			
		    $this->db->update(array('bmmast'=>$bmmasts,'bmuserid'=>$bmuserid),array('yue'=>$yues,'bmid'=>$bmids));	
			
			//插入站内消息
			$this->db->table_name = 'mj_msgs';
			$msgin['yuan']='绩效考核';
			$msgin['adddt']=time();
			$msgin['msg']=$bumen[$bmids].$_POST['yue']."绩效考核表等待您审核";
			$msgin['showuser']=$bmmasts;
			$this->db->insert($msgin);		
			}	
			
		 //部门审核
		  if($_POST['bmok']!=""){			
            $this->db->table_name = 'mj_gongzi_jixiao';	
            if(intval($_POST['bmmastok'])>0){ //同意,则自动转到政治处主任
			  //获取政治处主任的UID
			  $this->db2->table_name = 'mj_admin';	
			  $zzczr=$this->db2->get_one("roleid=2","*");
			  $oktime=time();
			  $zzcmast=$zzczr['userid'];
			  $yues=intval($_POST['yue']);
			  $bmids=$_SESSION['bmid'];	
			  $this->db->table_name = 'mj_gongzi_jixiao';		  
			  $this->db->update(array('bmmastok'=>1,'bmmastdt'=>$oktime,'zzcmast'=>$zzcmast),array('yue'=>$yues,'bmid'=>$bmids));
			  ///////
			   $msgin['yuan']='绩效考核';
			   $msgin['adddt']=time();
			   $msgin['msg']=$bumen[$_SESSION['bmid']].$yues."绩效考核表等待您审核";
			   $msgin['showuser']=$zzcmast;
			   
			}else{ //拒绝,清空上报
			
			  $yues=intval($_POST['yue']);
			  $mes=$_SESSION['userid'];
			  //-----------------------------
			  //获取操作者
			  $douses=$this->db->get_one("yue=$yues and bmmast=$mes","*");			  			
			   $msgin['yuan']='绩效考核';
			   $msgin['adddt']=time();
			   $msgin['msg']=$bumen[$douses['bmid']].$yues."绩效考核表审核被拒绝";
			   $msgin['showuser']=$douses['bmuserid'];
			  //-----------------------------
			  
			  $this->db->update(array('bmmast'=>0,'bmuserid'=>0),array('yue'=>$yues,'bmmast'=>$mes));			  

			}
				
			//插入站内消息
			$this->db->table_name = 'mj_msgs';
			$this->db->insert($msgin);		
			}		
			
			
		 //政治处主任审核
		  if($_POST['zzcok']!=""){			
			
			$this->db->table_name = 'mj_gongzi_jixiao';	
		    $jumasts=intval($_POST['jumast']);
			$zzcmastdts=time();
			$yues=intval($_POST['yue']);
			$bmids=intval($_POST['bmid']);
			
		    $this->db->update(array('jumast'=>$jumasts,'zzcmastdt'=>$zzcmastdts,'zzcmastok'=>1),array('yue'=>$yues,'bmid'=>$bmids));	
			
			//插入站内消息
			$this->db->table_name = 'mj_msgs';
			$msgin['yuan']='绩效考核';
			$msgin['adddt']=time();
			$msgin['msg']=$bumen[$bmids].$_POST['yue']."绩效考核表等待您审核";
			$msgin['showuser']=$jumasts;
			$this->db->insert($msgin);		
			}				
			
			
		 //局领导审核
		  if($_POST['juok']!=""){			
			
			$this->db->table_name = 'mj_gongzi_jixiao';	

			$jumastdts=time();
			$yues=intval($_POST['yue']);
			$bmids=intval($_POST['bmid']);
			
		    $this->db->update(array('jumastok'=>1,'jumastdt'=>$jumastdts),array('yue'=>$yues,'bmid'=>$bmids));	
			
			//插入站内消息 局长审核不发消息
			//$this->db->table_name = 'mj_msgs';
			//$msgin['yuan']='绩效考核';
			//$msgin['adddt']=time();
			//$msgin['msg']=$bumen[$bmids].$_POST['yue']."绩效考核表等待您审核";
			//$msgin['showuser']=$jumasts;
			//$this->db->insert($msgin);		
			}				
			////////////////////////////////////////////////////////////////////					 		
		*/
		  
		  //处理列表类型

		  $doty=intval($_GET[ty]);
		  if($doty==0){$where=" isok=0";$orders="indt desc";}
		  if($doty==1){$where=" isok=1";$orders="indt desc";} //作废 ，标记作反了
		  if($doty==2){$where=" isok=-1";$orders="indt desc";} //拒绝
		  if($doty==3){$where=" isok1=1";$orders="indt desc";} //已发放
		  		
		   //取出最近工资月
		  $this->db->table_name = 'mj_gongzi_kaoqintables';
		  $nowyue = $this->db->select("","*","1","id desc");

		  $this->db->table_name = 'mj_tcgongxian';			  
		  	  
		  
		  if($_SESSION['roleid']>5){		    
			$where.=" and bmid=".$_SESSION['bmid'];
			  }
			  
		  if(intval($_GET['bms'])>1){ //选择部门
		   $where.=" and bmid=".intval($_GET['bms']);
		  }
			
		 if($_SESSION['roleid']>3 || $_SESSION['roleid']==1){ 
			 	  		  
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo($where,$order = $orders,$page, $pages = '14');
		  $pages = $this->db->pages;	
		  
		  include $this->admin_tpl('jixiao_tcgongxian');
		  
		 }else{
			 	 
		   $where.=" and zzcok>-1 and fgok=1 and yue=".$nowyue[0]['yue'];	 
		   $show_table= $this->db->select($where,"*","",$orders);
		   include $this->admin_tpl('jixiao_tcgongxian_ju');	 
		
			 }
		
		   
	}	
	/////////////////////////////////////////////////////////////////////////////////////////////////
    //绩效录入/编辑
	function jixiaoedits() 
	{
        $id=intval($_GET['id']); 
		

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

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","px asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }	
		  
		  //插入编辑字段
          $this->db->table_name = 'mj_gongzi_jixiao';	
		  		  		 
		 ////////////////////////////
		 //写入
		 if($_POST['dook']!=""){
			 foreach($_POST['jx'] as $k=>$v){
			   $uparr[$k]=$v;	 
				 }
			 
			  $uparr['dotime']=time();
			  	 
			 $ids=intval($_POST['id']);  	 
			 $this->db->update($uparr,array('id'=>$ids));	 
			 }
		 
		 ////////////////////////////  
		   		  
		  $infos=$this->db->get_one("id=$id","*");
		  
		  //获取考勤情况 
		  
		  $my_chuqin=0;	  		  
		  $this->db->table_name = 'mj_kq'.$infos['yue'];
		  $mykqs= $this->db->get_one(" userid=".$infos['userid'],"*");
		  
		  if($mykqs['bmok']!=1){
			 showmessage("考勤表未通过部门领导审核，禁止绩效考评录入");
			 exit; 			
			  }
		  
		  foreach($mykqs as $k=>$v){
			 if(strtotime($k)){
				 if($v==1){
					$my_chuqin++; 
					 }
				 }
			  }
		  
		  //echo 	$my_chuqin;  
		  		  
	    if($_SESSION['roleid']>1){
		  if($infos['islock']==1){
			 showmessage("当前数据表已锁定，无法进行操作");
			 exit; 
			  }	
			}		  
		   
		include $this->admin_tpl('jixiao_edit');
	}	

    //突出贡献发起
	function tcgongxianadd() 
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
			 			
		//辅警映射
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }	
			 
		//辅警列表
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select(" status=1 and isok=1 ","*","","id asc");
		  foreach($rowss as $v){
			 $fujinglist[]=$v;  
			 }	
 
			 
		 //获取当前活动的考勤表
		 $this->db->table_name = 'mj_gongzi_kaoqintables'; 
		 $kqyue= $this->db->select("","*","1","id desc");
		 if(!isset($infos['yue'])){
			 $infos['yue']=$kqyue[0]['yue'];
			 } 		 
		  		 
		 ////////////////////////////
		 //写入
				 	
		 if($_POST['dook']!=""){			 
           			 
			 foreach($_POST['tc'] as $k=>$v){
			   $inarr[$k]=$v;	 
				 }
			 
			 //获取申请人情况
			 $this->db->table_name = 'mj_fujing';
			 $fjs=$this->db->get_one("id=".$inarr['userid'],"*");
			 
			 $inarr['sfz']=$fjs['sfz'];
			 $inarr['bmid']=$fjs['dwid'];
			 $inarr['gangwei']=$fjs['gangwei'];
             $inarr['indt']=time(); 
			  
			 $this->db->table_name = 'mj_tcgongxian'; 	 
 	 
			 $this->db->insert($inarr);	
			 
			 showmessage($fjs['xingming']."的奖励申请已提交成功，请关闭窗口");  
			 }
		 
		 //////////////////////////// 
		 //$addnous="disabled=\"disabled\""; 	
		 
		 //////////////////////////// 
		 $editnous="disabled=\"disabled\""; 
		 $addnous1="disabled=\"disabled\"";
		 $addnous2="disabled=\"disabled\"";
		 $addnous3="disabled=\"disabled\"";
		 $addnous4="disabled=\"disabled\"";		
		 
		 if($_GET['id']!=""){
		  $mubiao="tcgongxianedits";
			 }else{
			$mubiao="tcgongxianadd";	 
				 }		    		  		  
		   
		include $this->admin_tpl('tcgongxian_etids');
	}	
	
    //编辑
	function tcgongxianedits() 
	{
		
		$id=intval($_GET['id']);
				 
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
			 			
		//辅警映射
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }	
			 
		//辅警列表
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujinglist[]=$v;  
			 }			 
		  		 
		 ////////////////////////////
		 //写入
				 	
		 if($_POST['dook']!=""){			 
           			 
			 foreach($_POST['tc'] as $k=>$v){
			   $inarr[$k]=$v;	 
				 }		                   	 
			  
			 $this->db->table_name = 'mj_tcgongxian'; 	 
 	 
			$this->db->update($inarr,array('id'=>$id));	
			   
			 }
		 
		 //////////////////////////// 
		 $editnous="disabled=\"disabled\""; 
		 $addnous1="disabled=\"disabled\"";
		 $addnous2="disabled=\"disabled\"";
		 $addnous3="disabled=\"disabled\"";
		 $addnous4="disabled=\"disabled\"";		   		  		  
		 

		 if($_GET['id']!=""){
		  $mubiao="tcgongxianedits";
			 }else{
			$mubiao="tcgongxianadd";	 
				 }
		 
		 $this->db->table_name = 'mj_tcgongxian';
		 $infos=$this->db->get_one("id=$id","*"); 
		   
		include $this->admin_tpl('tcgongxian_etids');
	}	
	
	function tcgongxianedits2() 
	{
		
		$id=intval($_GET['id']);
				 
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }
			 
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("","*","","userid asc");
		  foreach($rowss as $v){
			 $qianzis[$v['userid']]=$v['qianzipic'];  
			 }			 

		//岗位映射
		  $this->db->table_name = 'mj_gangwei';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gangwei[$v['id']]=$v['gwname'];  
			 }			 
			 			
		//辅警映射
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }	
			 
		//辅警列表
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujinglist[]=$v;  
			 }			 
		  		 
		 ////////////////////////////
		 //写入
				 	
		 if($_POST['dook']!=""){			 
           			 
			// foreach($_POST['tc'] as $k=>$v){
			//   $inarr[$k]=$v;	 
			//	 }		                   	 
			  
			// $this->db->table_name = 'mj_tcgongxian'; 	 
 	 
			// $this->db->update($inarr,array('id'=>$id));	
			   
			 }
		 
		 //////////////////////////// 
		 $editnous="disabled=\"disabled\""; 
		 $addnous1="disabled=\"disabled\"";
		 $addnous2="disabled=\"disabled\"";
		 $addnous3="disabled=\"disabled\"";
		 $addnous4="disabled=\"disabled\"";		   		  		  
		 

		 if($_GET['id']!=""){
		  $mubiao="tcgongxianedits";
			 }else{
			$mubiao="tcgongxianadd";	 
				 }
		 
		 $this->db->table_name = 'mj_tcgongxian';
		 $infos=$this->db->get_one("id=$id","*"); 
		   
		include $this->admin_tpl('tcgongxian_etids2');
	}		
	
   //突出贡献审核
	function tcgongxianshenhe() 
	{

		
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		$id=intval($_GET['id']);

		 $this->db->table_name = 'mj_tcgongxian';
		 $infos=$this->db->get_one("id=$id","*");
		 $mybmid=$infos['bmid']; 		
				 
	     if($_GET['ty']=='bm'){
		  //判断权限
		  if($infos['sqbmuser']>0){
			 showmessage("部门审核进行中，不允许重复申请"); 
			  } 		  	 
			 
		  //获取申请对象
		  $bms=$infos['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select(" isbmuser=1","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		   
		  $rowsname="sqbmuser";  
		 }
		 
	     if($_GET['ty']=='zzc'){
			 
		  //判断权限
		  if($infos['fgok']==0){
			 showmessage("分管领导审核未通过，不允许越级申请"); 
			  }		  
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
		  if($infos['fenguanlingdao']>0){
			 showmessage("分管领导审核进行中，不允许重复申请"); 
			  } 		 
		  //获取申请对象
		  $bms=$_SESSION['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("roleid=3","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		   
		  $rowsname="fenguanlingdao";  
		 }	
		 
	     if($_GET['ty']=='ju'){
		  //判断权限
		  //if($infos['zzcok']==0){
		  //	 showmessage("政治处审核未通过，不允许越级申请"); 
		  //	  }	
		 $this->db->table_name = 'mj_tcgongxian';
		 $infoss=$this->db->get_one("yue=".intval($_GET['id']),"*","id desc");		  
		  
		  if($infoss['juuser']>0){
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
		 	
	     if($_GET['ty']=='ju2'){
		  //判断权限
		  //if($infos['zzcok']==0){
		  //	 showmessage("政治处审核未通过，不允许越级申请"); 
		  //	  }	
		 $this->db->table_name = 'mj_tcgongxian';
		 $infoss=$this->db->get_one("yue=".intval($_GET['id']),"*","id desc");		  
		  
		  if($infoss['juuser2']>0){
			 showmessage("局领导审核进行中，不允许重复申请"); 
			  } 			 
		  //获取申请对象
		  $bms=$_SESSION['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("roleid=3","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		   
		  $rowsname="juuser2";  
		 }				 	 	 	  		 
		 ////////////////////////////
		 //写入
		 	 	
		 if($_POST['dook']!=""){
       	
			 foreach($_POST['sq'] as $k=>$v){
			   $inarr[$k]=$v;	 
				 }	
		  
		  $this->db->table_name = 'mj_tcgongxian'; 		 		
          
		  if($_POST['ty']=="ju"){ //审批类型
		    $sqss = $this->db->select("yue=".intval($_POST['id'])." and zzcok=1 and isok=0 ","*","","id asc");
		    foreach($sqss as $v){
			  $this->db->update($inarr,"id=".$v['id']);
			  $_id_arr[]=$v['id'];
			}
			$_POST['yue']=$_POST['id'];
		  }else{	                   	 
 	 
			$this->db->update($inarr,array('id'=>$id));
			$_id_arr[]=	$id;
		  }

		  	
			//插入站内消息
			if(is_array($_id_arr)){
				$_inids=implode(",",$_id_arr);
				}else{
				$_inids="";//此选择肢仅为防止缺省异常	
					}	
			$msgin['inids']=$_inids;			
			//
			$this->db->table_name = 'mj_msgs';
			$msgin['yuan']='突出贡献';
			$msgin['adddt']=time();
			$msgin['msg']=$bumen[intval($_POST['bmid'])]."突出贡献奖励申请等待您审核";
			$msgin['showuser']=$inarr[$rowsname];
			$msgin['doty']=$rowsname;
			$msgin['yues']=$_POST['yue'];
			$msgin['adduser']=$_SESSION['userid'];
			if($rowsname=='bm' || $rowsname=='fg'){
			  $msgin['addbm']=$mybmid;
			}else{
			  $msgin['addbm']=0;	
				}			
			$this->db->insert($msgin);		
									
			showmessage("审核申请已提交，请关闭窗口");	   
			 }
		 
		 //////////////////////////// 
		   
		include $this->admin_tpl('tcgongxian_shenqing');
	}
		
	///////////////////////////////////////////////////////////////////////////////////////////////
	
   //特殊贡献
	function tsrenwu()
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

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","id asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }			  
		


		  $this->db->table_name = 'mj_tsrenwu';			  
		  		  
		  $where="1=1";
		  if($_SESSION['roleid']>5){		    
			$where.=" and bmid=".$_SESSION['bmid'];
			  }
			  
		  if(intval($_GET['bms'])>1){ //选择部门
		   $where.=" and bmid=".intval($_GET['bms']);
		  }
			  		  
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo($where,$order = 'id asc',$page, $pages = '16');
		  $pages = $this->db->pages;	
		  include $this->admin_tpl('jixiao_tsrenwu');			 
		
		   
	}		

   //特殊任务发起
	function tsrenwuadd() 
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
			 			
		//辅警映射
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }	
			 
		//辅警列表
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujinglist[]=$v;  
			 }			 
		  		 
		 //获取当前活动的考勤表
		 $this->db->table_name = 'mj_gongzi_kaoqintables'; 
		 $kqyue= $this->db->select("","*","1","id desc");
		 if(!isset($infos['yue'])){
			 $infos['yue']=$kqyue[0]['yue'];
			 } 					 
				 
		 ////////////////////////////
		 //写入
				 	
		 if($_POST['dook']!=""){			 
           			 
			 foreach($_POST['tc'] as $k=>$v){
			   $inarr[$k]=$v;	 
				 }
			 
			 
			 //获取申请人情况
			 $this->db->table_name = 'mj_fujing';
			 $fjs=$this->db->get_one("id=".$inarr['userid'],"*");
			 
			 $inarr['sfz']=$fjs['sfz'];
			 $inarr['bmid']=$fjs['dwid'];
			 $inarr['gangwei']=$fjs['gangwei'];
             $inarr['sqdt']=time(); 
			 $inarr['inuser']=$_SESSION['userid'];
			 
			 $this->db->table_name = 'mj_tsrenwu'; 	 
 	 
			 $this->db->insert($inarr);	
			 
			 showmessage($fjs['xingming']."的奖励申请已提交成功，请关闭窗口");  
			 }
		 
		 //////////////////////////// 
		 //$addnous="disabled=\"disabled\""; 	
		 
		 //////////////////////////// 
		 $editnous="disabled=\"disabled\""; 
		 $addnous1="disabled=\"disabled\"";
		 $addnous2="disabled=\"disabled\"";
		 $addnous3="disabled=\"disabled\"";
		 $addnous4="disabled=\"disabled\"";		   		  		  
		   
		 if($_GET['id']!=""){
		  $mubiao="tsrenwuedits";
			 }else{
			$mubiao="tsrenwuadd";	 
				 }		   
		   
		include $this->admin_tpl('tsrenwu_etids');
	}
	
    //编辑
	function tsrenwuedits() 
	{
		
		$id=intval($_GET['id']);
				 
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
			 			
		//辅警映射
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }	
			 
		//辅警列表
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujinglist[]=$v;  
			 }			 
		  		 
		 ////////////////////////////
		 //写入
				 	
		 if($_POST['dook']!=""){			 
           			 
			 foreach($_POST['tc'] as $k=>$v){
			   $inarr[$k]=$v;	 
				 }		                   	 
			  
			 $this->db->table_name = 'mj_tsrenwu'; 	 
 	 
			$this->db->update($inarr,array('id'=>$id));	
			   
			 }
		 
		 //////////////////////////// 
		 $editnous="disabled=\"disabled\""; 
		 $addnous1="disabled=\"disabled\"";
		 $addnous2="disabled=\"disabled\"";
		 $addnous3="disabled=\"disabled\"";
		 $addnous4="disabled=\"disabled\"";		   		  		  
		 

		 if($_GET['id']!=""){
		  $mubiao="tsrenwuedits";
			 }else{
			$mubiao="tsrenwuadd";	 
				 }
		 
		 $this->db->table_name = 'mj_tsrenwu';
		 $infos=$this->db->get_one("id=$id","*"); 
		   
		include $this->admin_tpl('tsrenwu_etids');
	}	
	
   //特殊任务审核
	function tsrenwushenhe() 
	{
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		$id=intval($_GET['id']);

		 $this->db->table_name = 'mj_tsrenwu';
		 $infos=$this->db->get_one("id=$id","*"); 		
				 
	     if($_GET['ty']=='bm'){
		  //判断权限
		  if($infos['bmuser']>0){
			 showmessage("部门审核进行中，不允许重复申请"); 
			  } 		  	 
			 
		  //获取申请对象
		  $bms=$infos['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("isbmuser=1","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		 	   
		  $rowsname="bmuser";  
		 }
		 
	     if($_GET['ty']=='zzc'){
		  //判断权限
		  if($infos['fgok']==0){
			 showmessage("分管领导审核未通过，不允许越级申请"); 
			  }		  
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
			  
			 $this->db->table_name = 'mj_tsrenwu'; 	 
 	 
			$this->db->update($inarr,array('id'=>$id));	
			
			//插入站内消息
			$this->db->table_name = 'mj_msgs';
			$msgin['yuan']='特殊任务';
			$msgin['adddt']=time();
			$msgin['msg']=$bumen[intval($_POST['bmid'])]."特殊任务申请等待您审核";
			$msgin['showuser']=$inarr[$rowsname];
			$msgin['doty']=$rowsname;
			$msgin['yues']=$_POST['yue'];
			$msgin['adduser']=$_SESSION['userid'];
			if($rowsname=='bm' || $rowsname=='fg'){
			  $msgin['addbm']=$_SESSION['bmid'];
			}else{
			  $msgin['addbm']=0;	
				}
			$msgin['inids']=$id;	
				
			$this->db->insert($msgin);			
			
			showmessage("审核申请已提交，请关闭窗口");	   
			 }
		 
		 //////////////////////////// 
		   
		include $this->admin_tpl('tsrenwu_shenqing');
	}

     //00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
	 
    //绩效工资表
	function ydjxgzb()
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

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","id asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }			  
		  				 		
				
		if($_GET['yue']!=''){
		  $this->db->table_name = 'mj_gongzi_jxgzb';			  
		  		  
		  $where="1=1 and yue='".$_GET['yue']."'";
		  if($_SESSION['roleid']==1 || $_SESSION['roleid']==2 || $_SESSION['roleid']==3 || $_SESSION['roleid']==7){
		    
		  }else{
			$where.=" and bmid=".$_SESSION['bmid'];
			  }
			  
		  if(intval($_GET['bms'])>1){ //选择部门
		   $where.=" and bmid=".intval($_GET['bms']);
		  }
		  if($_POST['xingming']!=''){
			 //$where.=" and bmid=".intval($_GET['bms']); 
			  }
		  
		  //获取合计
		  $jxjj = $this->db->get_one($where,"sum(jxjj) as hj");
		  $koufa = $this->db->get_one($where,"sum(koufa) as hj");
		  $jiaban = $this->db->get_one($where,"sum(jiaban) as hj");
		  $tsrenwu = $this->db->get_one($where,"sum(tsrenwu) as hj");
		  $tcgongxian = $this->db->get_one($where,"sum(tcgongxian) as hj");
		  $shifa = $this->db->get_one($where,"sum(shifa) as hj");
		  
		  //其他统计
		  $hj_rs=$this->db->get_one($where,"count(id) as hj");
		  $hj_tcgx=$this->db->get_one(" tcgongxian >0 and ". $where,"count(id) as hj");
		  $hj_tsrw=$this->db->get_one(" tsrenwu >0 and ". $where,"count(id) as hj");
		  $hj_yx=$this->db->get_one(" khjieguo =2 and ". $where,"count(id) as hj");
		  $hj_hg=$this->db->get_one(" khjieguo =3 and ". $where,"count(id) as hj");
		  $hj_bhg=$this->db->get_one(" khjieguo =4 and ". $where,"count(id) as hj");
		  
	//echo $where;	  
			  		  
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo($where,$order = 'id asc',$page, $pages = '10');
		  $pages = $this->db->pages;	
		  include $this->admin_tpl('jixiao_jxgzb');			 
		}else{
		    $this->db->table_name = 'mj_gongzi_tables';
		    $yuelists = $this->db->select("","*","","id desc");			
			include $this->admin_tpl('jixiao_jxgzb_nous');
			}
		   
	}	 

	//绩效工资表管理
	public function jxgzb() {

		//应由考勤表同步人员，工资表不方便修改了，绩效表由考勤表同步,原则上工资表人员与考勤表一致
		if($_GET['yue']!="" && $_GET['addtable']!=""){
          
		  //////errrrrrr
		  //调试时火狐81.0 64位 多次出现未明确触发此过程却再次插入人员数据行的情况,未进行步进跟踪,直接检查数据,如果指定月份数据存在则直接跳出过程
		  //找到原因了 触发数据泵过程以后,如果直接用查看表按钮查看泵入的数据,因弹窗过程中检查关闭自身窗口的JS包含location.reload(),刷新当前URL
		  //就等同于再次触发数据泵,直接删掉location.reload()就行了,检查数据过程保留,较为严谨
		  $this->db->table_name = 'mj_gongzi_jxgzb';
		  //$haves = $this->db->get_one("yue=".$_GET['yue'],"count(id) as zj");
		  //此处允许多次创建绩效工资表，创建前清除原记录
		  $mm=$this->db->delete(array('yue'=>$_GET['yue'])); //!!!!
		  //echo $mm;exit;
		  
		  //if($haves['zj']>0){exit;}
		  
		  //////////////

         // 先取出当月实际出勤天数的参数
		 
		 
		//获取指定月考勤表人员
		    $this->db->table_name = 'mj_gongzi_kaoqintables';
			$tmp_sjts = $this->db->get_one("yue=".$_GET['yue'],"sjts");
			if($tmp_sjts['sjts']==0){$tmp_sjts['sjts']=21.75;}//如果实际天数没有设置，则按21.75天处理
			
			$this->db->table_name = $this->db->db_tablepre.'gz'.$_GET['yue'];
			$fjids = $this->db->select("","userid,bmid,kqtj,yf_yjx,kf_yjx","","id asc");
			//此过程需要创建两个更大的数组副本，否则追加到原数组，数据量大的情况下需要大量内存，暂时不重新设计算法了
            //获取岗位
			$this->db->table_name = 'mj_fujing';
			foreach($fjids as $i){
			 $tmps = $this->db->get_one("id=".$i['userid'],"gangwei,sfz,shequ","id desc");
			 $i['gangwei']=$tmps['gangwei'];
			 $i['sfz']=$tmps['sfz'];
			 $i['shequ']=$tmps['shequ'];
			 $yjxtb[$i['userid']]=$i['yf_yjx']; //取出应发月绩效
			 $gztmp[$i['userid']]=$i;
			 unset($i['yf_yjx']);unset($i['kf_yjx']);
			 $ids0[]=$i;
			 
			}
			//print_r($gztmp);exit;
            //获取绩效考核等级
			$this->db->table_name = 'mj_gongzi_jixiao';
			foreach($ids0 as $i){
			 $tmps = $this->db->get_one("userid=".$i['userid']." and yue='".$_GET['yue']."'","kh_dj","id desc");
			 $i['khjieguo']=$tmps['kh_dj'];
			 $ids1[]=$i;
			}			
			
			//填充考勤数据以及默认值 ,算法相当复杂
			//取出绩效基础参数
			$this->db->table_name = 'mj_gongzi_jixiao_sets';
			$khdj = $this->db->select("iscan=2 and pid>0","id,canshu,pid,fanwei","","id asc"); //考核等级映射
			$jiaban = $this->db->get_one("id=17","canshu"); //加班费
			$sqbz = $this->db->get_one("id=18","canshu,fanwei"); //社区补助
			
			//把社区补助结构变形，防止bmid作为字符串进行匹配
			$sqbz['arr']=explode(',',$sqbz['fanwei']);
			
			//计算绩效各项值，此处用FOR试一下
			$c=count($ids1);
			for($i=0;$i<$c;$i++){
			 
			 //	加班	 
			 //$ids1[$i]['jiaban']=$jiaban['canshu']; 
			 $ids1[$i]['jiaban']=0; 
			 
			 //社区补助，算法重写,社区补贴标记放在人员表内容，直接比对人员表
			 /*if(in_array($ids1[$i]['bmid'],$sqbz['arr'])){
				$ids1[$i]['shequbz']=$sqbz['canshu'];
				 }else{
				$ids1[$i]['shequbz']="0.00";	 
				} */
			  
			  //再次调整社区补助算法
			  //if($ids1[$i]['shequ']==1){
			  //	 $ids1[$i]['shequbz']=$sqbz['canshu']; 
			  //}else{
			  //	 $ids1[$i]['shequbz']="0.00"; 
			  //	  }	
			 	
			  //社区补助转到工资表内，绩效工资表不再计算	
			  if($ids1[$i]['gangweifz']==1){
			  	// $ids1[$i]['shequbz']=$sqbz['canshu']; 
			  }else{
			  	// $ids1[$i]['shequbz']="0.00"; 
			  	  }					
				
			  //同步应发绩效 ,此处应发月绩效改为从工资表内获取，因为绩效工资表内不包含人员的层级标记，无法获取准确的绩效工资
			  
			  //$ids1[$i]['jxjj']=$yjxtb[$ids1[$i]['userid']];
			  $ids1[$i]['jxjj']=$gztmp[$ids1[$i]['userid']]['yf_yjx'];
			//print_r($gztmp[675]); 
			  //计算绩效工资		 
              switch ($ids1[$i]['khjieguo']){
                case 2://优秀
				$ids1[$i]['jxjj']=$gztmp[$ids1[$i]['userid']]['yf_yjx'];
				//$yjxtb[$ids1[$i]['userid']]; //全部绩效
                 //for($j=0;$j<3;$j++){
				  // $tmp=explode(',',$khdj[$j]['fanwei']);  //这里$khdj一维索引并不是等级ID，而是数据表里面存储的顺序
				  // if(in_array($ids1[$i]['bmid'],$tmp)){
				  //  $ids1[$i]['jxjj']=$khdj[$j]['canshu'];
				  //	break;
				  // }
				 //}  
                break;  
                case 3://合格
                 $ids1[$i]['jxjj']=$gztmp[$ids1[$i]['userid']]['yf_yjx']; //全部绩
				 //for($j=3;$j<6;$j++){
				 //  $tmp=explode(',',$khdj[$j]['fanwei']);
				 //  if(in_array($ids1[$i]['bmid'],$tmp)){
				  //  $ids1[$i]['jxjj']=$khdj[$j]['canshu'];
				//	break;
				 //  }				  
				 //}                
                break;
                case 19://基本合格
                $ids1[$i]['jxjj']=round(($gztmp[$ids1[$i]['userid']]['yf_yjx']*0.5),2); //扣发一半
				
				// for($j=7;$j<10;$j++){
				//   $tmp=explode(',',$khdj[$j]['fanwei']);
				//   if(in_array($ids1[$i]['bmid'],$tmp)){
				  //  $ids1[$i]['jxjj']=$khdj[$j]['canshu'];
				//	break;
				 //  }				  
				 //}                
                break;				
                case 4://不合格
                 $ids1[$i]['jxjj']="0.00"; 
				 $ids1[$i]['koufa']=$gztmp[$ids1[$i]['userid']]['yf_yjx'];
                break;				
                default:
                 $ids1[$i]['jxjj']=$gztmp[$ids1[$i]['userid']]['yf_yjx'];
               }			  
			  
			  //print_r($gztmp[$ids1[$i]['userid']]); exit;
			  		 
			  //计算出勤
			  if($ids1[$i]['kqtj']!=''){
			    $cqarr=unserialize($ids1[$i]['kqtj']);
				//取出病事假天数
				if($cqarr[2]>0){$tyy="病假".$cqarr[2]."天 ";}
				if($cqarr[3]>0){$tyy.="事假".$cqarr[3]."天 ";}
				if($cqarr[6]>0){$tyy.="丧假".$cqarr[6]."天 ";}
				if($cqarr[8]>0){$tyy.="护理假".$cqarr[8]."天 ";}
				if($cqarr[9]>0){$tyy.="探亲假".$cqarr[9]."天 ";}
				if($cqarr[12]>0){$tyy.="旷工".$cqarr[12]."天 ";}
				if($cqarr[13]>0){$tyy.="辞职".$cqarr[13]."天 ";}
				
				//if($cqarr[13]>0){//如果辞职，因辞职天数不准确，应用出勤天数代替。此处扣发不准确
				//	$cizhits=30-$cqarr[1]-$cqarr[0];
				//	}
				
				$t_zs=$cqarr[2]+$cqarr[3]+$cqarr[6]+$cqarr[8]+$cqarr[9]+$cqarr[12]+$cqarr[13];//病事假总天数
				
				//仅更新考勤扣发!!
				  $ids1[$i]['koufa']=$gztmp[$ids1[$i]['userid']]['kf_yjx'];
				  $ids1[$i]['koufayy']=$tyy;	
				
			    /////////////////////////////////////////////////////////////////////////
				
				if($t_zs==0){ //没有病事假
				   //$ids1[$i]['koufa']="0.00";
				   //$ids1[$i]['koufayy']=$tyy;				
				}else{
				  ////20230530  此处不再处理 暂时取消	
				  if($ids1[$i]['jxjj']=="0.00"){ //基本绩效为0,不扣,再扣成负数了
				   //$ids1[$i]['koufa']="0.00";
				   //$ids1[$i]['koufayy']=$tyy;
				  }else{
				    //$koufajishgu= round($ids1[$i]['jxjj']/$tmp_sjts['sjts'],2); //按平均30天计算 
				    if($t_zs<5){
				    //  $ids1[$i]['koufa']=round($koufajishgu*$t_zs,2);
				    //  $ids1[$i]['koufayy']=$tyy;					
					}else{
				      if($t_zs<10){
				    //  $ids1[$i]['koufa']=round($ids1[$i]['jxjj']/2,2);
				    //  $ids1[$i]['koufayy']=$tyy;					  
					  }else{
				        if($t_zs>=10){
				     //   $ids1[$i]['koufa']=$ids1[$i]['jxjj'];
				      //  $ids1[$i]['koufayy']=$tyy;
						}					  
					  }
					}
				  }
				}
				
				if($cqarr[13]>0){//如果辞职，算法完全不一样，重置入库数组
				      $ids1[$i]['jxjj']=round($ids1[$i]['jxjj']/$tmp_sjts['sjts'],2)*$cqarr[1];
				      $ids1[$i]['koufa']=0;
					  //$ids1[$i]['jiaban']=round($ids1[$i]['jiaban']/30,2)*$cqarr[1];
					}				
				
				
				unset($tyy); //有连接符，必须及时销毁
			   }else{
				 $ids1[$i]['koufayy']='考勤未同步';  
			   }
		   
			   
			   
			   //加班费同时进行考勤扣发
			   if($cqarr[13]==0){ //辞职的不参与这个计算
			   if($t_zs*10>=300){
				     $ids1[$i]['jiaban']=0; //扣光了
				   }else{
			         // $ids1[$i]['jiaban']=$ids1[$i]['jiaban']-$t_zs*10;
					 $ids1[$i]['jiaban']=0;
				   }
			   }
				   
			   //计算实发
			   $ids1[$i]['shifa']=$ids1[$i]['jxjj']+$ids1[$i]['jiaban']-$ids1[$i]['koufa'];
			   
			} //for end	
//exit;
			/////////////////////////////////
			//写入绩效工资表
			$this->db->table_name = 'mj_gongzi_jxgzb';
			foreach($ids1 as $k=>$i){
			
			 foreach($i as $ks=>$v){
			  if($ks!='kqtj'){
			  $arrs[$ks]=$v;
			   }
			 }  
			//````````````````
			$arrs['yue']=$_GET['yue'];
			$arrs['inuser']=$_SESSION['userid'];
			$arrs['indt']=time();
	
			//print_r($arrs);
			//exit;
					
			$this->db->insert($arrs);
			  unset($arrs); //防止循环中出现不同的成员造成入库错误,对中间数组进行销毁,虽然能释放内存,但是耗用CPU周期				
			}
					
		}
		//eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee
		
		//锁定绩效表
		if($_GET['yue']!="" && $_GET['locked']!=""){	
			
		  if(intval($_GET['locked'])>0){$dolock=0;}else{$dolock=1;}
          $this->db->table_name = 'mj_gongzi_jxgzb';
		  $yues=$_GET['yue'];
		  $this->db->update(array('islock'=>$dolock),array('yue'=>$yues));
		  
		  ///绩效工资表同步到工资表 20230504
		  /// 当前的绩效工资表实际上已经无效，为了保持操作一致性和以后的扩展能力，保留当前操作，
		  
		    $jxgztb = $this->db->select(" yue=".$_GET['yue'] ,"*","","id asc"); //当月的绩效
			
			$this->db->table_name = $this->db->db_tablepre.'gz'.$_GET['yue'];
			$_arrs = $this->db->select("","*","","id asc"); //当月工资
			foreach($_arrs as $tmp){
				$dygz[$tmp['userid']]=$tmp;
				}
			
			//这个部分需要重写
			foreach($jxgztb as $tb){

			 if($dygz[$tb['userid']]['gwlb']!=5){	//非临辅进行绩效同步
			  $gztb['kaohedj']=	$tb['khjieguo'];
			  //$gztb['yf_yjx']=	$tb['jxjj']; //此处覆盖应发月绩效，但是不处理年度绩效金额
			  $gztb['kf_yjx']=	$tb['koufa'];
			  $gztb['sf_yjx']=	$dygz[$tb['userid']]['yf_yjx']-$tb['koufa'];
			  ////这里补入扣发、特殊岗位、突出贡献
			  $gztb['tsgwgz']=$tb['tsrenwu']; //特殊岗位工资
			  $gztb['tcgx']=$tb['tcgongxian'];
			  if($dygz[$tb['userid']]['beizhu']!=""){
				 if($tb['koufayy']!=""){$tt1=$tb['koufayy'];}else{$tt1="";} 
				 if($tb['beizhu']!=""){$tt2=";".$tb['beizhu'];}else{$tt2="";}	
				//还是用数组吧，替换太麻烦了
				$tmpbz=explode(";",$dygz[$tb['userid']]['beizhu']);
				foreach($tmpbz as $k=>$z){
					if($z==$tt1){unset($tmpbz[$k]);}
					if($z==$tt2){unset($tmpbz[$k]);}
					}
				$tmpbz[]=$tt1;
				$tmpbz[]=$tt2;	
				 			  
			  $gztb['beizhu']=implode(";",$tmpbz); //替换掉重复的备注
			    unset($tmpbz);
			  }else{
				 if($tb['koufayy']!=""){$tt1=$tb['koufayy'];}else{$tt1="";} 
				 if($tb['beizhu']!=""){$tt2=";".$tb['beizhu'];}else{$tt2="";}
				 $gztb['beizhu']= $tt1.$tt2;
				  }
			  //////
			  $gztb['yingfa']=$dygz[$tb['userid']]['jiben']+$dygz[$tb['userid']]['cengjigz']+$dygz[$tb['userid']]['yf_yjx']+$dygz[$tb['userid']]['nvwsf']+$dygz[$tb['userid']]['ndjx'];
			  $gztb['shifa']= $dygz[$tb['userid']]['jiben']+$dygz[$tb['userid']]['cengjigz']+$gztb['sf_yjx']+$dygz[$tb['userid']]['nvwsf'];

			  $this->db->update($gztb,array('userid'=>$tb['userid']));
			  unset($gztb);
			 }
			}
			//exit;
		  	
		  ///////////////////////////////////////////////////////////////////////////		  
			  	
		}
		
		$this->db->table_name = 'mj_gongzi_tables'; 
				
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$gz_tables = $this->db->listinfo('',$order = 'id desc',$page, $pages = '80');
		$pages = $this->db->pages;
		include $this->admin_tpl('jixiao_jxgzb_guanli');
	}	
	
	//查看绩效工资表
	function showjxgzb()
	{
	    $yue=intval($_REQUEST['yue']);
		$where="yue='$yue'";
	    
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

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","id asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }		
			 			  
	  
		  //遍历数据表
		  $this->db->table_name = 'mj_gongzi_jxgzb';	
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo($where,$order = 'id asc',$page, $pages = '10');
		  $pages = $this->db->pages;			
	
		   		
		include $this->admin_tpl('jixiao_showjxgzb');
	}	
	
    //绩效工资编辑
	function jxgzbedit() 
	{
        $id=intval($_GET['id']); 
		

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

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","id asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }	
		  
		  //插入编辑字段
          $this->db->table_name = 'mj_gongzi_jxgzb';	
		  		  		 
		 ////////////////////////////
		 //写入
		 if($_POST['dook']!=""){
			 foreach($_POST['jx'] as $k=>$v){
			   $uparr[$k]=$v;	 
				 }
			 
			 // $uparr['dotime']=time();
			 //追加日志
			  $infos_log=$this->db->get_one("id=$id","dolog"); 
			 if($infos_log['dolog']!=""){
				$indolog=json_decode($infos_log['dolog'],true); 	 
				$doun=param::get_cookie('admin_username');	 
				$indolog[]=array(urlencode($doun),date("Y-m-d H:i:s"),urlencode($_POST['jx']['koufayy']),urlencode($_POST['jx']['beizhu']));
				 }else{
				$doun=param::get_cookie('admin_username');	 
				$indolog[0]=array(urlencode($doun),date("Y-m-d H:i:s"),urlencode($_POST['jx']['koufayy']),urlencode($_POST['jx']['beizhu']));	 
					 }
				//print_r($indolog);exit;
				$uparr['dolog']=json_encode($indolog); 
			 //======== 	 
			 $ids=intval($_POST['id']);  	 
			 $this->db->update($uparr,array('id'=>$ids));	 
			 }
		 
		 ////////////////////////////  
		   		  
		  $infos=$this->db->get_one("id=$id","*");
		  
	    if($_SESSION['roleid']>1){
		  if($infos['islock']==1){
			 showmessage("当前数据表已锁定，无法进行操作");
			 exit; 
			  }	
			}		  
		   
		include $this->admin_tpl('jixiao_jxgzb_edit');
	}	
	
    //工具-特殊任务
	function toolsrenwu() 
	{
        $id=intval($_GET['id']); 
		

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

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","id asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }	
		  
		  //插入编辑字段
          $this->db->table_name = 'mj_tsrenwu';	

		  if(intval($_GET['bmid'])>1){
			 $where=" and bmid=".intval($_GET['bmid']); 
			  }
			  		  		  		 
		 ////////////////////////////
		 //写入
		 //这里不考虑解除关联
		 
		 if($_POST['dook']!=""){
			 
			 //先对任务表进行标记，然后进行统计，回写绩效工资表
			 foreach($_POST['ids'] as $k=>$v){	          
			  $this->db->update(array('isok1'=>$_GET['yue'],'je'=>$_POST['bzje'][$k]),array('id'=>$v));	 			   	 
			 }				 

			 //对标记记录进行统计
			 //update  `mj_gongzi_jxgzb` set beizhu=CONCAT(beizhu,'追加') where id=1
			 foreach($_POST['ids'] as $v){	          
			   $tmps=$this->db->get_one("id=$v","*");
			   if(isset($inarr[$tmps['userid']])){
				  $inarr[$tmps['userid']]['je']+=$tmps['je'];
				  $inarr[$tmps['userid']]['beizhu'].=$tmps['rwname']."(".$tmps['sgdt']."),";
				  $inarr[$tmps['userid']]['guanlian'].=$tmps['id'].","; 
			   }else{
				  $inarr[$tmps['userid']]['je']=$tmps['je'];
				  $inarr[$tmps['userid']]['beizhu']=$tmps['rwname']."(".$tmps['sgdt']."),";
				  $inarr[$tmps['userid']]['guanlian'].=$tmps['id'].",";				   
			   }	 			   	 
			 }	
			 
			 //写回绩效工资表，同时更新实发统计
			 $this->db->table_name = 'mj_gongzi_jxgzb';
			 foreach($inarr as $k=>$v){
			   $gzbs=$this->db->get_one("yue=".$_GET['yue']." and userid=$k","*"); //同月度表内如果有相同USERID就毁了
			   if($gzbs){ //有可能出现任务表里的人员不在工资表的情况，需要判断
			       $rews['tsrenwu']=$v['je'];
				   $rews['shifa']=$gzbs['jxjj']-$gzbs['koufa']+$gzbs['jiaban']+$gzbs['shequbz']+$rews['tsrenwu']+$gzbs['tcgongxian'];
				   $rews['renwubz']=$v['beizhu'];
				   $rews['beizhu']=$rews['renwubz']." ".$gzbs['gongxianbz'];
				   $rews['renwugl']=$v['guanlian'];
				   $this->db->update($rews,array('id'=>$gzbs['id']));
				   }
			   	 
			 }
			 	 
//print_r($inarr);
			  	 
			 }
		 
		 ////////////////////////////  

		  $this->db->table_name = 'mj_tsrenwu';
  		  
		  $infos=$this->db->select("juok=1 and isok1=0 ".$where,"*","","id asc");
		  		  
		   
		include $this->admin_tpl('jixiao_tools_tsrenwu');
	}
	
    //工具-特殊任务解除关联
	function toolsrenwujc() 
	{
        $id=intval($_GET['id']); 
		

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

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","id asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }	
		  
		  //先取出绩效工资关联的任务ID
		  $this->db->table_name = 'mj_gongzi_jxgzb';	
		  $tmps=$this->db->get_one("id=$id","*");	  
		  $idsarr= explode(",",$tmps['renwugl']);
		  if(count($idsarr)<2){
			//正常的插入关联转为数组后最少有两个成员，如果只有一个成员则说明关联串不正常
			$idss="0";  
		  }else{
			 $idss=$tmps['renwugl']."0"; //如果关联串正常，末尾补0,防止出现null成员 
			  }
		  
		  //插入编辑字段
          $this->db->table_name = 'mj_tsrenwu';	
			  		  		  		 
		 ////////////////////////////
		 //写入
		 //解除关联
		 
		 if($_POST['dook']!=""){
			 
			 //先对任务表进行标记，然后进行统计，回写绩效工资表
			 foreach($_POST['ids'] as $v){	          
			  $this->db->update(array('isok1'=>0),array('id'=>$v));	 			   	 
			 }				 

			 //对标记记录进行统计
			 //update  `mj_gongzi_jxgzb` set beizhu=CONCAT(beizhu,'追加') where id=1
			 //这里不能用加入关联时的算法，这个IDS串是解除的
			 //先对比关联串，把解除关联的成员销毁
			 
			 for($i=0;$i<count($idsarr)-1;$i++){
			   if(!in_array($idsarr[$i],$_POST['ids'])){
                    $newarr[]=$idsarr[$i];
				   }	 
			 }
			 
			if(is_array($newarr)){
			 foreach($newarr as $v){	          
			   $tmps=$this->db->get_one("id=$v","*");
			   if(isset($inarr[$tmps['userid']])){
				  $inarr[$tmps['userid']]['je']+=$tmps['je'];
				  $inarr[$tmps['userid']]['beizhu'].=$tmps['rwname']."(".$tmps['sgdt']."),";
				  $inarr[$tmps['userid']]['guanlian'].=$tmps['id'].","; 
			   }else{
				  $inarr[$tmps['userid']]['je']=$tmps['je'];
				  $inarr[$tmps['userid']]['beizhu']=$tmps['rwname']."(".$tmps['sgdt']."),";
				  $inarr[$tmps['userid']]['guanlian']=$tmps['id'].",";				   
			   }	 			   	 
			 }}else{
				  $inarr[$tmps['userid']]['je']=0.00;
				  $inarr[$tmps['userid']]['beizhu']='';
				  $inarr[$tmps['userid']]['guanlian']='';					 
				 }	
			 
			 //写回绩效工资表，同时更新实发统计
			 $this->db->table_name = 'mj_gongzi_jxgzb';
			 foreach($inarr as $k=>$v){
			   $gzbs=$this->db->get_one("yue=".$_GET['yue']." and userid=$k","*"); //同月度表内如果有相同USERID就毁了
			   if($gzbs){ //有可能出现任务表里的人员不在工资表的情况，需要判断
			       $rews['tsrenwu']=$v['je'];
				   $rews['shifa']=$gzbs['jxjj']-$gzbs['koufa']+$gzbs['jiaban']+$gzbs['shequbz']+$rews['tsrenwu']+$gzbs['tcgongxian'];
				   $rews['renwubz']=$v['beizhu'];
				   $rews['beizhu']=$rews['renwubz']." ".$gzbs['gongxianbz'];
				   $rews['renwugl']=$v['guanlian'];
				   $this->db->update($rews,array('id'=>$gzbs['id']));
				   }
			   	 
			 }
			  	 
			}
		 
		 ////////////////////////////  

		  $this->db->table_name = 'mj_tsrenwu';
		   		  
		  $infos=$this->db->select("id in($idss)","*","","id asc");
		  		  
		   
		include $this->admin_tpl('jixiao_tools_tsrenwu_jc');
	}	
	
    //工具-突出贡献
	function toolsgongxian() 
	{
        $id=intval($_GET['id']); 
		

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

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","id asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }	
		  
		  //插入编辑字段
          $this->db->table_name = 'mj_tcgongxian';	

		  if(intval($_GET['bmid'])>1){
			 $where=" and bmid=".intval($_GET['bmid']); 
			  }
			  		  		  		 
		 ////////////////////////////
		 //写入
		 //这里不考虑解除关联
		 
		 if($_POST['dook']!=""){
			 //print_r($_POST);exit;
			 //先对任务表进行标记，然后进行统计，回写绩效工资表
			 foreach($_POST['ids'] as $k=>$v){	          
			  $this->db->update(array('isok1'=>$_GET['yue'],'je'=>$_POST['bzje'][$k]),array('id'=>$v));	 			   	 
			 }				 

			 //对标记记录进行统计
			 //update  `mj_gongzi_jxgzb` set beizhu=CONCAT(beizhu,'追加') where id=1
			 foreach($_POST['ids'] as $v){	          
			   $tmps=$this->db->get_one("id=$v","*");
			   if(isset($inarr[$tmps['userid']])){
				  $inarr[$tmps['userid']]['je']+=$tmps['je'];
				  $inarr[$tmps['userid']]['beizhu'].=$fujings[$tmps['userid']]."(突出贡献),";
				  $inarr[$tmps['userid']]['guanlian'].=$tmps['id'].","; 
			   }else{
				  $inarr[$tmps['userid']]['je']=$tmps['je'];
				  $inarr[$tmps['userid']]['beizhu']=$fujings[$tmps['userid']]."(突出贡献),";
				  $inarr[$tmps['userid']]['guanlian'].=$tmps['id'].",";				   
			   }	 			   	 
			 }	
			 
			 //写回绩效工资表，同时更新实发统计
			 $this->db->table_name = 'mj_gongzi_jxgzb';
			 foreach($inarr as $k=>$v){
			   $gzbs=$this->db->get_one("yue=".$_GET['yue']." and userid=$k","*"); //同月度表内如果有相同USERID就毁了
			   if($gzbs){ //有可能出现任务表里的人员不在工资表的情况，需要判断
			       $rews['tcgongxian']=$v['je'];
				   $rews['shifa']=$gzbs['jxjj']-$gzbs['koufa']+$gzbs['jiaban']+$gzbs['shequbz']+$rews['tcgongxian']+$gzbs['tsrenwu'];
				   $rews['gongxianbz']=$v['beizhu'];
				   $rews['beizhu']=$gzbs['renwubz']." ".$rews['gongxianbz'];
				   $rews['gongxiangl']=$v['guanlian'];
				   $this->db->update($rews,array('id'=>$gzbs['id']));
				   }
			   	 
			 }
			 	 
//print_r($inarr);
			  	 
			 }
		 
		 ////////////////////////////  

		  $this->db->table_name = 'mj_tcgongxian';
		   		  
		  $infos=$this->db->select("juok=1 and isok1=0 ".$where,"*","","id asc");
		  		  
		   
		include $this->admin_tpl('jixiao_tools_tcgongxian');
	}	
	
    //工具-突出贡献解除关联
	function toolsgongxianjc() 
	{
        $id=intval($_GET['id']); 
		

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

		//考核等级
		  $this->db->table_name = 'mj_gongzi_jixiao_sets';
		  $rowss = $this->db->select("pid=1","*","","id asc");
		  foreach($rowss as $v){
			 $dengji[$v['id']]=$v['setname'];  
			 }	
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }	
		  
		  //先取出绩效工资关联的任务ID
		  $this->db->table_name = 'mj_gongzi_jxgzb';	
		  $tmps=$this->db->get_one("id=$id","*");	  
		  $idsarr= explode(",",$tmps['gongxiangl']);
		  if(count($idsarr)<2){
			//正常的插入关联转为数组后最少有两个成员，如果只有一个成员则说明关联串不正常
			$idss="0";  
		  }else{
			 $idss=$tmps['gongxiangl']."0"; //如果关联串正常，末尾补0,防止出现null成员 
			  }
	  
		  //插入编辑字段
          $this->db->table_name = 'mj_tcgongxian';	
			  		  		  		 
		 ////////////////////////////
		 //写入
		 //解除关联
		 
		 if($_POST['dook']!=""){
			 
			 //先对任务表进行标记，然后进行统计，回写绩效工资表
			 foreach($_POST['ids'] as $v){	          
			  $this->db->update(array('isok1'=>0),array('id'=>$v));	 			   	 
			 }				 

			 //对标记记录进行统计
			 //update  `mj_gongzi_jxgzb` set beizhu=CONCAT(beizhu,'追加') where id=1
			 //这里不能用加入关联时的算法，这个IDS串是解除的
			 //先对比关联串，把解除关联的成员销毁
			 
			 for($i=0;$i<count($idsarr)-1;$i++){
			   if(!in_array($idsarr[$i],$_POST['ids'])){
                    $newarr[]=$idsarr[$i];
				   }	 
			 }
			 
			if(is_array($newarr)){
			 foreach($newarr as $v){	          
			   $tmps=$this->db->get_one("id=$v","*");
			   if(isset($inarr[$tmps['userid']])){
				  $inarr[$tmps['userid']]['je']+=$tmps['je'];
				  $inarr[$tmps['userid']]['beizhu'].=$fujings[$tmps['userid']]."(突出贡献),";
				  $inarr[$tmps['userid']]['guanlian'].=$tmps['id'].","; 
			   }else{
				  $inarr[$tmps['userid']]['je']=$tmps['je'];
				  $inarr[$tmps['userid']]['beizhu']=$fujings[$tmps['userid']]."(突出贡献),";
				  $inarr[$tmps['userid']]['guanlian']=$tmps['id'].",";				   
			   }	 			   	 
			 }}else{
				  $inarr[$tmps['userid']]['je']=0.00;
				  $inarr[$tmps['userid']]['beizhu']='';
				  $inarr[$tmps['userid']]['guanlian']='';					 
				 }	

			 
			 //写回绩效工资表，同时更新实发统计
			 $this->db->table_name = 'mj_gongzi_jxgzb';
			 foreach($inarr as $k=>$v){
			   $gzbs=$this->db->get_one("yue=".$_GET['yue']." and userid=$k","*"); //同月度表内如果有相同USERID就毁了
			   if($gzbs){ //有可能出现任务表里的人员不在工资表的情况，需要判断
			       $rews['tcgongxian']=$v['je'];
				   $rews['shifa']=$gzbs['jxjj']-$gzbs['koufa']+$gzbs['jiaban']+$gzbs['shequbz']+$rews['tcgongxian']+$gzbs['tsrenwu'];
				   $rews['gongxianbz']=$v['beizhu'];
				   $rews['beizhu']=$gzbs['renwubz']." ".$rews['gongxianbz'];
				   $rews['gongxiangl']=$v['guanlian'];
				   $this->db->update($rews,array('id'=>$gzbs['id']));
				   }
			   	 
			 }
			  	 
			}
		 
		 ////////////////////////////  

		  $this->db->table_name = 'mj_tcgongxian';
		   		  
		  $infos=$this->db->select("id in($idss)","*","","id asc");
		  		  
		   
		include $this->admin_tpl('jixiao_tools_tcgongxian_jc');
	}	
	
  //绩效工资表审核申请
	function jxgzbshenhe() 
	{
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		 $yue=intval($_GET['yue']);
		 $this->db->table_name = 'mj_gongzi_jxgzb';		
				 
	    /* if($_GET['ty']=='bm'){

		  //判断权限
		  if($infos['sqbmuser']>0){
			 showmessage("部门审核进行中，不允许重复申请"); 
			  } 		  	 
			 
		  //获取申请对象
		  $bms=$infos['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("roleid=5 and bmid=$bms","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		   
		  $rowsname="sqbmuser";  
		 } */
		 
	     if($_GET['ty']=='zzc'){ //绩效工资表不检查部门审核
		  	$infos=$this->db->get_one("yue=$yue and zzcuser>0","count(id) as zj"); 
				  
		  //判断权限
		  //if($infos['fgok']==0){
		  //	 showmessage("分管领导审核未通过，不允许越级申请"); 
		  //	  }		  
		  if($infos['zj']>0){
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
		  if($infos['fenguanlingdao']>0){
			 showmessage("分管领导审核进行中，不允许重复申请"); 
			  } 		 
		  //获取申请对象
		  $bms=$_SESSION['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("roleid=3","*","","userid asc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		   
		  $rowsname="fenguanlingdao";  
		 }	
		 
	     if($_GET['ty']=='ju'){
		  $infos=$this->db->get_one("yue=$yue and zzcok=0","count(id) as zj");
		  $infos1=$this->db->get_one("id=$yue and juuser>0","count(id) as zj"); 
		  
		  //判断权限
		  if($infos['zj']>0){
			 showmessage("政治处审核未通过，不允许越级申请"); 
			  }			  
		  if($infos1['juuser']>0){
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
			  
			 $this->db->table_name = 'mj_gongzi_jxgzb'; 	 
 	 
			$this->db->update($inarr,array('yue'=>$yue));	
			
			//插入站内消息
			//获取本次审批涉及到的记录ID序列
			$isdrs = $this->db->select("yue=$yue","id","","");
			foreach($isdrs as $v){
				$_id_arr[]=$v['id'];
				}
			if(is_array($_id_arr)){
				$_inids=implode(",",$_id_arr);
				}else{
				$_inids="";//此选择肢仅为防止缺省异常	
					}	
			$msgin['inids']=$_inids;		
			////////////////////////////			
			
			$this->db->table_name = 'mj_msgs';
			$msgin['yuan']='绩效工资';
			$msgin['adddt']=time();
			$msgin['msg']=$_GET['yue']."绩效工资表申请等待您审核";
			$msgin['showuser']=$inarr[$rowsname];
			
			$msgin['doty']=$rowsname;
			$msgin['yues']=$_GET['yue'];
			$msgin['adduser']=$_SESSION['userid'];
			$msgin['addbm']=$_SESSION['bmid'];
						
			
			$this->db->insert($msgin);			
			
			showmessage("审核申请已提交，请关闭窗口");	   
			 }
		 
		 //////////////////////////// 
		   
		include $this->admin_tpl('jxgzb_shenqing');
	}
	
//绩效工资表审核处理
	function jxgzbshenhe_do() 
	{
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }

		 $yue=intval($_GET['yue']);
		 $this->db->table_name = 'mj_gongzi_jxgzb';		
				 
		 
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
			  
			 $this->db->table_name = 'mj_gongzi_jxgzb'; 
			 
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
		   
		include $this->admin_tpl('jxgzb_shenqing_do');
	}								
	/////////////////////////////////////////////////////////////////////////////////////////////// 
	///////////////////////////////////////////////////////////////////////////////////////////////		
     //查看站内提醒
	function showmsg() 
	{
        $id=intval($_GET['id']); 
		

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
 
 
		  $this->db->table_name = 'mj_msgs'; 		  
		  $infos=$this->db->get_one("id=$id","*");
		  
		  if($infos['showuser']==$_SESSION['userid']){ //更新阅读状态
		   $rdt=time();
		   $this->db->update(array('isshow'=>1,'readdt'=>$rdt),array('id'=>$id));
		  }	  
		   
		include $this->admin_tpl('show_msgs');
	}	
 
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
//获取层级工资
		  $this->db->table_name = 'mj_cengji';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $cengji[$v['id']]=$v['gongzi'];  
			 }
//获取职级工资
		  $this->db->table_name = 'mj_zhiwu';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $zhiji[$v['id']]=$v['gongzi'];  
			 }			 

//读出辅警人员
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("status=1","id,xingming,dwid,sex,zhiwu,cengji,rjtime","","id asc");
		  foreach($rowss as $v){
          
			 $v['jbgz']=$jb_arr['jbgz'];
			 if($v['sex']=="女"){
			   $v['nvwsf']=$jb_arr['nvwsf'];	 
				 }else{
			   $v['nvwsf']=0;	 
				}
				
             $v['cengjigz']=$cengji[$v['cengji']];
			 $v['zhijigz']=$zhiji[$v['zhiwu']];			  
			 
			 $fujing[]=$v;

			 }				 
      
//插入工作表
         $this->db->table_name = $dbname; 
		
		foreach($fujing as $f){ 
         $inarr['xingming']=$f['xingming'];
		 $inarr['ruzhi']=$f['rjtime'];
		 $inarr['nianxian']=date("Y")-date("Y",$f['rjtime']);
		 $inarr['jiben']=$f['jbgz'];
		 $inarr['nvwsf']=$f['nvwsf'];
		 $inarr['cengji']=$f['cengjigz'];
		 $inarr['zhiji']=$f['zhijigz'];
		 $inarr['userid']=$f['id'];
		 $inarr['bmid']=$f['dwid'];
		 		 
		 
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
/////////////////////////////////////
///导出
public function daoxls(){
		
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

  $this->db->table_name = "mj_gongzi_jixiao"; 
  $datas = $this->db->select("yue=$yue ","*","","bmid asc");
  
  if(count($datas)==0){
    showmessage("不存在可用导出的数据，无法进行操作"); 
  }
  
/*  
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
*/  

/* @实例化 */
$obpe = new PHPExcel();  


$obpe->getActiveSheet()->setTitle("绩效考核");
//Excel表格4种情况

$letter2 = array('A','B','C','D','E','F','G','H','I','J','K');  
$tableheader2 = array('序号','姓名','身份证号','单位','岗位','考核结果','考核成绩','出勤','出勤情况','纪律作风','工作实绩'); 


//数据总数
$hang= count($datas);
$bh=$hang+3;	

//设置纸型
$obpe->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$obpe->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

//表头数组  

$obpe->getActiveSheet()->getDefaultRowDimension()->setRowHeight('25'); //设置默认行高
 
$obpe->getActiveSheet()->mergeCells('A1:K1');		

$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中
$obpe->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);      //第一行是否加粗
$obpe->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);         //第一行字体大小

//写入多行数据
//主标题  
//$yues=date("Y年m月",strtotime($_GET['yue']."01"));
 
$obpe->getActiveSheet()->setCellValue("A1","高新公安分局".$yue."辅警绩效考核表"); 
//$obpe->getActiveSheet()->setCellValue("A2","填报日期 ： ".date("Y年m月d日")); 

	
for($i = 0;$i < count($tableheader2);$i++) {
    $obpe->getActiveSheet()->setCellValue("$letter2[$i]3","$tableheader2[$i]"); 
	$obpe->getActiveSheet()->getColumnDimension("$letter2[$i]")->setWidth('15');
    $obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	//居中 
	$obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$obpe->getActiveSheet()->getStyle("$letter2[$i]3")->getFont()->setBold(true);      //第一行是否加粗
	
}  

//输出表格

$liej=4;
$i2=1;
for ($i = 0;$i < count($datas);$i++) { //行
 	
	$v1=$i2;
	$v2=$fujings[$datas[$i]['userid']];
	$v3=$datas[$i]['sfz'];
	$v4=$bumen[$datas[$i]['bmid']];
	$v5=$gangwei[$datas[$i]['gangwei']];
	$v6=$dengji[$datas[$i]['kh_dj']];
	$v7=$datas[$i]['chengji'];
	$v8=$datas[$i]['chuqin'];
	$v9=$datas[$i]['qin_chuqin'];
	$v10=$datas[$i]['qin_biaoxian'];
	$v11=$datas[$i]['ji_mubiao'];
	 	
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

  $i2++;	
  $liej++; 
  
} 

//合计
$hj=$hang+4;
$qz=$hj;


// 设置边框
    $styleThinBlackBorderOutline = array(
        'borders' => array(
            'allborders' => array( //设置全部边框
                'style' => \PHPExcel_Style_Border::BORDER_THIN //粗的是thick
            ),

        ),
    );
	
	$obpe->getActiveSheet()->getStyle( "A3:K$qz")->applyFromArray($styleThinBlackBorderOutline);	 
	
                
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
header("Content-Disposition:attachment;filename=高新公安分局".$yue."辅警绩效考评表.xls");
header('Content-Transfer-Encoding:binary');
$obwrite->save('php://output');

}
	
}


