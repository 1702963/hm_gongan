<?php
set_time_limit(0);
ini_set("display_errors", "On"); 
//error_reporting(7);

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class rencai extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		$this->db2 = pc_base::load_model('opinion_model');
		$this->db->table_name = 'mj_techang';
		pc_base::load_app_func('global');
	}
	
	public function init() { 
	   
	   $wheremain=$where="isok=1";;
	   
		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumens[$v['id']]=$v['name'];  
			 }

		//岗位映射
		  $this->db->table_name = 'mj_gangwei';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $gangweis[$v['id']]=$v['gwname'];  
			 }	
			 
		//邦定辅助岗位
		$this->db->table_name = 'mj_gangweifz';
		$rss = $this->db->select("",'id,gwname','','id asc');
		
		foreach($rss as $aaa){
			$gangweifzs[$aaa['id']]=$aaa['gwname'];
			
			}			 		 

		//邦定职务
		$this->db->table_name = 'mj_zhiwu';
		$rss = $this->db->select("",'id,zwname','','id asc');
		$zhiwu=array();
		
		foreach($rss as $aaa){
			$zhiwus[$aaa['id']]=$aaa['zwname'];
			
			}

		//邦定学历
		$this->db->table_name = 'mj_xueli';
		$rss = $this->db->select("",'id,gwname','','id asc');
		
		foreach($rss as $aaa){
			$xuelis[$aaa['id']]=$aaa['gwname'];
			}	
			
		//邦定层级
		$this->db->table_name = 'mj_cengji';
		$rss = $this->db->select("",'id,cjname','','id asc');
		$cengji=array();
		
		foreach($rss as $aaa){
			$cengjis[$aaa['id']]=$aaa['cjname'];
			
			}	
			
		//特长类别
		$this->db->table_name = 'mj_techangclass';
		$tcclass= $this->db->select("",'id,classname,pid','','id asc');
		
		foreach($tcclass as $aaa){
			$tcclassys[$aaa['id']]=$aaa['classname'];
			}						 
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v;  
			 }	
			 
	    //搜索，考虑表联合查询难以处理分页，是否可拆分为两次简单查询？
		
	if($_GET['dotongji']!=""){
			
		if(isset($_GET['xingming']) && !empty($_GET['xingming'])) {                               
			$xingming=$_GET['xingming'];
			$where .= " AND `xingming`  like '%$xingming%' ";
			}		
			
		if(isset($_GET['sex']) && !empty($_GET['sex'])) {                               
			$sex=$_GET['sex'];
			$where .= " AND `sex`='$sex' ";
			}			
			
		if(isset($_GET['dwid']) && !empty($_GET['dwid'])) {
			$dwid=$_GET['dwid'];
			if($dwid>1){
			$where .= " AND `dwid`  = $dwid ";
			}
			}
						
		if(isset($_GET['agetj']) && !empty($_GET['agetj'])) {                               
			$age=$_GET['age'];
			$agetiaojian="=";
			$orders="age desc";
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
			  }
			}
			
		if(isset($_GET['xueli']) && !empty($_GET['xueli'])) {                               
			$xuelis=$_GET['xueli'];
			$where .= " AND `xueli`='$xuelis' ";
			}
			
		if(isset($_GET['rjtj']) && !empty($_GET['rjtj'])) {                               
			$rjtimes=strtotime($_GET['rjtime']);
			$agetiaojian="=";
			$orders=" rjtime desc";
			if($_GET['rjtj']==">"){$agetiaojian=">=";$orders=" rjtime asc";}
			if($_GET['rjtj']=="<"){$agetiaojian="<=";$orders=" rjtime asc";}
			$where .= " AND `rjtime`".$agetiaojian."'$rjtimes' ";
			}	

		if(isset($_GET['zzmm']) && !empty($_GET['zzmm'])) {                               
			$zzmms=$_GET['zzmm'];
			$where .= " AND `zzmm`='$zzmms' ";
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
			$zhiwus=$_GET['zhiwu'];
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
			
		}
		
		if($where!="isok=1"){ //辅警表的检索条件反馈
		
		$this->db->table_name = 'mj_fujing';
		$selfujing= $this->db->select("$where",'id','','id asc');
          foreach($selfujing as $v){
		    $subs[]=$v['id'];	
		  }			
		 $substr=implode(",",$subs);
		}
		
		if(isset($_GET['tcid']) && !empty($_GET['tcid'])) {                               
			$tcids=intval($_GET['tcid']);
			$mclasss=intval($_GET['mclass']);
			$wheremain .= " AND `tcid`='$tcids' ";
			}
			
		if($substr!=""){
			$wheremain.=" and fjid in($substr)";
			}	
			
		//统计end
		
		  $this->db->table_name = 'mj_techang';	
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $rencai = $this->db->listinfo($wheremain,$order = 'id asc',$page, $pages = '10');
		  $pages = $this->db->pages;					 			
		
		include $this->admin_tpl('rencai_list');
	}
			
	

	function show(){ //查看
	
		//特长类别
		$this->db->table_name = 'mj_techangclass';
		$tcclass= $this->db->select("",'id,classname,pid','','id asc');
		
		foreach($tcclass as $aaa){
			$tcclassys[$aaa['id']]=$aaa['classname'];
			}	
				
	 $ids=intval($_REQUEST['id']);
	 $rencais = $this->db->get_one("id=$ids",'*');
	 
	 //获取特长类别的主类
	 for($i=0;$i<count($tcclass);$i++){
		 if($tcclass[$i]['id']==$rencais['tcid']){
			 $mainclasss=$tcclass[$i]['pid'];
			 break;
			 }
		 }	 
	 echo $mainclasss;
	 
	 include $this->admin_tpl('rencai_show');	
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

	
}


