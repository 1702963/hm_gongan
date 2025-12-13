<?php
set_time_limit(0);
ini_set("display_errors", "On"); 
//error_reporting(7);

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class jixiaoshenpi extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		$this->db2 = pc_base::load_model('opinion_model');
		$this->db->table_name = 'mj_fujing';
		pc_base::load_app_func('global');
	}
	
	public function init() { //主列表
	
	          //部门转译
		     $this->db->table_name = 'mj_bumen';
		     $rowss = $this->db->select("","*","","id asc");
		     foreach($rowss as $v){
			    $bumen[$v['id']]=$v['name'];  
			 }	
		
	          //用户转译
		     $this->db->table_name = 'mj_admin';
		     $rowss = $this->db->select("","*","","userid asc");
		     foreach($rowss as $v){
			    $admins[$v['userid']]=$v['username'];  
			 }			
		
		  $this->db->table_name = 'mj_msgs';
		  
		  if($_SESSION['roleid']>1){
			 $where.=" and showuser=".$_SESSION['userid']; 
			  }
		  
		  $msgs = $this->db->select(" yuan='绩效考评' ".$where,"*","","id desc");
			
		include $this->admin_tpl('jixiao_main');
	}

	public function bmuser() { //部门审核
	      
		  //提示阅读状态
		  $id=intval($_GET['msgid']);
		  $this->db->table_name = 'mj_msgs';
		  $msgs=$this->db->get_one("id=$id","*");
		  if($msgs['isshow']==0){
			$this->db->update(array('isshow'=>1,'readdt'=>time()),array('id'=>$id));  
			  }
	
		
		//人员
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }			
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
			 			  
		  
		  $this->db->table_name = 'mj_gongzi_jixiao';
		  
			 $where.=" bmok=0 and bmuser=".$_SESSION['userid']." and yue=".$_GET['yues']; 
			 
		  $show_table = $this->db->select($where,"*","","id asc");
		  
		  if($show_table[0]['bmok']==1){
			  $buttoncan="disabled='disabled'";
			  }
			
		include $this->admin_tpl('jixiao_shlist');
	}
	
	public function zguser() { //主管领导审核
		
		  //提示阅读状态
		  $id=intval($_GET['msgid']);
		  $this->db->table_name = 'mj_msgs';
		  $msgs=$this->db->get_one("id=$id","*");
		  if($msgs['isshow']==0){
			$this->db->update(array('isshow'=>1,'readdt'=>time()),array('id'=>$id));  
			  }
			
		//人员
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }		
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
			 		  
		  
		  $this->db->table_name = 'mj_gongzi_jixiao';
		  
		  $where.=" zgok=0 and zguser=".$_SESSION['userid']." and bmid=".intval($_GET['bmid'])." and yue=".$_GET['yues']; 
			 
		  $show_table = $this->db->select($where,"*","","id asc");
		  
		  if($show_table[0]['zgok']==1){
			  $buttoncan="disabled='disabled'";
			  }
			
		include $this->admin_tpl('jixiao_shlist');
	}
	
	public function zzcuser() { //政治处主任审核
		
		  //提示阅读状态
		  $id=intval($_GET['msgid']);
		  $this->db->table_name = 'mj_msgs';
		  $msgs=$this->db->get_one("id=$id","*");
		  if($msgs['isshow']==0){
			$this->db->update(array('isshow'=>1,'readdt'=>time()),array('id'=>$id));  
			  }
		  
		
		 //人员
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }	
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
			 
			 
          $this->db->table_name = 'mj_gongzi_jixiao';
		  
		  $where.=" yue=".$_GET['yues']; 
			 
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo($where,$order = 'id asc',$page, $pages = '16');
		  $pages = $this->db->pages;
		  
		  if($show_table[0]['zzcok']==1){
			  $buttoncan="disabled='disabled'";
			  }
			
		include $this->admin_tpl('jixiao_shlist');
	}	
	
	public function juuser() { //局长审核
		
		  //提示阅读状态
		  $id=intval($_GET['msgid']);
		  $this->db->table_name = 'mj_msgs';
		  $msgs=$this->db->get_one("id=$id","*");
		  if($msgs['isshow']==0){
			$this->db->update(array('isshow'=>1,'readdt'=>time()),array('id'=>$id));  
			  }
		  
		//人员
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }		
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
			 	  
		
          $this->db->table_name = 'mj_gongzi_jixiao';
		  
		  $where.=" yue=".$_GET['yues']; 
			 
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo($where,$order = 'id asc',$page, $pages = '16');
		  $pages = $this->db->pages;
		  
		  if( $show_table[0]['juok']==1){
			  $buttoncan="disabled='disabled'";
			  }
			
		include $this->admin_tpl('jixiao_shlist');
		
	}	
	
	public function jixiaoshenpi_do() { //审核操作
			
		
		  //获取申请对象
		  $bms=$_SESSION['bmid'];
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("roleid=3","*","","px desc");
		  foreach($rowss as $v){
			 $shenpis[$v['userid']]=$v['username'];  
			 }		    

		//单位映射
		  $this->db->table_name = 'mj_bumen';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $bumen[$v['id']]=$v['name'];  
			 }
          
		  if($_POST['dook']!=""){  //保存审批
		    //部门审批
			if($_POST['ty']=='bmuser'){ 
			  $bmids=intval($_POST['bmid']);
			  if(intval($_POST['nextuser'])==0){
			    showmessage("未匹配到审核角色,请联系管理员");
			  }
			  
			  if(intval($_POST['sq'])==0){
				  $uparr['bmuser']=0;//如果拒绝
				  }else{
				  $uparr['bmok']=1;
				  $uparr['zguser']=$_POST['nextuser'];
				  $uparr['zgdt']=time();	  
				}
				
				//print_r($uparr);exit;
				
			   //插入消息表
			   $msgup['dos']=intval($_POST['sq']);
			   $msgup['dodt']=time();
			   $this->db->table_name = 'mj_msgs';
			   $this->db->update($msgup,array('id'=>intval($_POST['msgid'])));
			   
			   //同步发送消息
			  $msgin['yuan']='绩效考评';
			  $msgin['adddt']=time();
			  $msgin['msg']=$bumen[$bmids].$_POST['yue']."绩效考评等待您审核";
			  $msgin['showuser']=intval($_POST['nextuser']);
			  $msgin['doty']='zguser';
			  $msgin['yues']=$_POST['yue'];
			  $msgin['adduser']=$_SESSION['userid'];
			  $msgin['addbm']=$bmids;
			  $this->db->insert($msgin);				   
			   
			  
			   //修改状态	
			   $this->db->table_name = 'mj_gongzi_jixiao';	
			   $this->db->update($uparr,array('yue'=>$_POST['yue'],'bmid'=>$bmids));
			   showmessage("审核完成，请关闭窗口");
			     	
			}
			
			//主管领导审核
			if($_POST['ty']=='zguser'){ 
			  $bmids=intval($_POST['bmid']);
			  if(intval($_POST['sq'])==0){
				  $uparr['bmuser']=0;//如果拒绝
				  $uparr['bmok']=0;
				  $uparr['zguser']=0;
				  }else{
				  $uparr['zgok']=1;	  
				}
				
				//print_r($uparr);exit;
				
			   //插入消息表
			   $msgup['dos']=intval($_POST['sq']);
			   $msgup['dodt']=time();
			   $this->db->table_name = 'mj_msgs';
			   $this->db->update($msgup,array('id'=>intval($_POST['msgid'])));
			   
			   //同步发送消息
			  //$msgin['yuan']='考勤';
			  //$msgin['adddt']=time();
			  //$msgin['msg']=$_POST['yue']."考勤表等待您审核";
			  //$msgin['showuser']=intval($_POST['nextuser']);
			  //$msgin['doty']='zguser';
			  //$msgin['yues']=$_POST['yue'];
			  //$msgin['adduser']=$_SESSION['userid'];
			  //$msgin['addbm']=$_SESSION['bmid'];
			  //$this->db->insert($msgin);				   
			   
			   
			   //修改状态	
			   $this->db->table_name = 'mj_gongzi_jixiao';	
			   $this->db->update($uparr,array('bmid'=>$bmids,'yue'=>$_POST['yue']));
			   showmessage("审核完成，请关闭窗口");
			     	
			}			
			
			//政治处主任
			if($_POST['ty']=='zzcuser'){ 
			  $bmids=intval($_POST['bmid']);
			  if(intval($_POST['nextuser'])==0){
			    showmessage("未匹配到审核角色,请联系管理员");
			  }			  
			  if(intval($_POST['sq'])==0){
				  $uparr['zzcuser']=0;//如果拒绝
				  $uparr['zzcok']=0;
				  }else{
				  $uparr['zzcdt']=time();
				  $uparr['zzcok']=1; 
				  $uparr['juuser']=intval($_POST['nextuser']); 
				}
				
				//print_r($uparr);exit;
				
			   //插入消息表
			   $msgup['dos']=intval($_POST['sq']);
			   $msgup['dodt']=time();
			   $this->db->table_name = 'mj_msgs';
			   $this->db->update($msgup,array('id'=>intval($_POST['msgid'])));
			   
			   //同步发送消息
			  $msgin['yuan']='绩效考评';
			  $msgin['adddt']=time();
			  $msgin['msg']=$_POST['yue']."绩效考评等待您审核";
			  $msgin['showuser']=intval($_POST['nextuser']);
			  $msgin['doty']='juuser';
			  $msgin['yues']=$_POST['yue'];
			  $msgin['adduser']=$_SESSION['userid'];
			  $msgin['addbm']=0;
			  $this->db->insert($msgin);				   
			   
			   
			   //修改状态	
			   $this->db->table_name = 'mj_gongzi_jixiao';	
			   $this->db->update($uparr,array('yue'=>$_POST['yue']));

			   showmessage("审核完成，请关闭窗口");
			     	
			}				
			
			//局领导
			if($_POST['ty']=='juuser'){ 
			  $bmids=intval($_POST['bmid']);
			  if(intval($_POST['sq'])==0){
				  $uparr['juuser']=0;//如果拒绝
				  $uparr['juok']=0;
				  }else{
				  $uparr['judt']=time();
				  $uparr['juok']=1; 
				}
				
				//print_r($uparr);exit;
				
			   //插入消息表
			   $msgup['dos']=intval($_POST['sq']);
			   $msgup['dodt']=time();
			   $this->db->table_name = 'mj_msgs';
			   $this->db->update($msgup,array('id'=>intval($_POST['msgid'])));
			   
			   //同步发送消息
			  //$msgin['yuan']='考勤';
			  //$msgin['adddt']=time();
			  //$msgin['msg']=$_POST['yue']."考勤表等待您审核";
			  //$msgin['showuser']=intval($_POST['nextuser']);
			  //$msgin['doty']='juuser';
			  //$msgin['yues']=$_POST['yue'];
			  //$msgin['adduser']=$_SESSION['userid'];
			  //$msgin['addbm']=0;
			  //$this->db->insert($msgin);				   
			   
			   
			   //修改考勤状态	
			   $this->db->table_name = 'mj_gongzi_jixiao';	
			   $this->db->update($uparr,array('yue'=>$_POST['yue']));

			   showmessage("审核完成，请关闭窗口");
			     	
			}			
		  }
        /////////////////////////////////////////////
         			
		include $this->admin_tpl('jixiao_kaopingshenqing_do');
	}	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	function zlsp() 
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
		   
		include $this->admin_tpl('rencai_list');
	}	

	/////////////////////////////////////////////////////
}


