<?php
set_time_limit(0);
ini_set("display_errors", "On"); 
//error_reporting(7);

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class tcgxshenpi extends admin {
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
		  
		 // $msgs = $this->db->select(" yuan='突出贡献' ".$where,"*","","id desc");

		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$msgs = $this->db->listinfo(" yuan='突出贡献' ".$where,$order = 'id desc',$page, $pages = '20');
		$pages = $this->db->pages;		
			
		include $this->admin_tpl('tcgx_main');
	}

	public function sqbmuser() { //部门审核
	      
		  //提示阅读状态
		  $id=intval($_GET['msgid']);
		  $this->db->table_name = 'mj_msgs';
		  $msgs=$this->db->get_one("id=$id","*");
		  if($msgs['isshow']==0){
			$this->db->update(array('isshow'=>1,'readdt'=>time()),array('id'=>$id));  
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
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }		  
		  
		  $this->db->table_name = 'mj_tcgongxian';
		  
			 $where.=" isok=0 and bmok=0 and sqbmuser=".$_SESSION['userid']; 
			 
		  $show_table = $this->db->select($where,"*","","id asc");
		  
		  if($show_table[0]['bmok']==1){
			  $buttoncan="disabled='disabled'";
			  }
			
		include $this->admin_tpl('tcgx_shlist');
	}
	
	public function fenguanlingdao() { //主管领导审核
		
		  //提示阅读状态
		  $id=intval($_GET['msgid']);
		  $this->db->table_name = 'mj_msgs';
		  $msgs=$this->db->get_one("id=$id","*");
		  if($msgs['isshow']==0){
			$this->db->update(array('isshow'=>1,'readdt'=>time()),array('id'=>$id));  
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
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }		  
		  
		  $this->db->table_name = 'mj_tcgongxian';
		  
		  $where.=" isok=0 and fgok=0 and fenguanlingdao=".$_SESSION['userid']; 
			 
		  $show_table = $this->db->select($where,"*","","id asc");
		  
		  if($show_table[0]['zgok']==1){
			  $buttoncan="disabled='disabled'";
			  }
			
		include $this->admin_tpl('tcgx_shlist');
	}
	
	public function zzcuser() { //政治处主任审核
		
		  //提示阅读状态
		  $id=intval($_GET['msgid']);
		  $this->db->table_name = 'mj_msgs';
		  $msgs=$this->db->get_one("id=$id","*");
		  if($msgs['isshow']==0){
			$this->db->update(array('isshow'=>1,'readdt'=>time()),array('id'=>$id));  
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
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }		  
		  
		  $this->db->table_name = 'mj_tcgongxian';
		  
		  $where.=" isok=0 and zzcok=0 and zzcuser=".$_SESSION['userid'] ; 
			 
		  $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  $show_table = $this->db->listinfo($where,$order = 'id asc',$page, $pages = '16');
		  $pages = $this->db->pages;
		  
		  if($tables['zzcok']==1){
			  $buttoncan="disabled='disabled'";
			  }
			
		include $this->admin_tpl('tcgx_shlist');
	}	
	
	public function juuser() { //局长审核
		
		  //提示阅读状态
		  $id=intval($_GET['msgid']);
		  $this->db->table_name = 'mj_msgs';
		  $msgs=$this->db->get_one("id=$id","*");
		  if($msgs['isshow']==0){
			$this->db->update(array('isshow'=>1,'readdt'=>time()),array('id'=>$id));  
			  }

		  $nowyue[0]['yue']=$msgs['yues'];		  
		
		  //签字
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("","*","","userid asc");
		  foreach($rowss as $v){
			 $qianzis[$v['userid']]=$v['qianzipic'];  
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
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }		  
		  
		  $this->db->table_name = 'mj_tcgongxian';
		  
		  $where.=" isok=0 and yue=".$msgs['yues']." and juuser=".$_SESSION['userid']; 
			 
		 // $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		 // $show_table = $this->db->listinfo($where,$order = 'id desc',$page, $pages = '16');
		 // $pages = $this->db->pages;
		  
		   //$where.=" and zzcok>-1 and fgok=1 and yue=".$nowyue[0]['yue'];	 
		   $show_table= $this->db->select($where,"*","","id desc");
		   
		  if($tables['juok']==1){
			  $buttoncan="disabled='disabled'";
			  }
			
		include $this->admin_tpl('tcgx_shlist_ju');
		
	}	

	public function juuser2() { //局长审核
		
		  //提示阅读状态
		  $id=intval($_GET['msgid']);
		  $this->db->table_name = 'mj_msgs';
		  $msgs=$this->db->get_one("id=$id","*");
		  if($msgs['isshow']==0){
			$this->db->update(array('isshow'=>1,'readdt'=>time()),array('id'=>$id));  
			  }
		  
		  $nowyue[0]['yue']=$msgs['yues'];

		  //签字
		  $this->db->table_name = 'mj_admin';
		  $rowss = $this->db->select("","*","","userid asc");
		  foreach($rowss as $v){
			 $qianzis[$v['userid']]=$v['qianzipic'];  
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
			 			
		//辅警
		  $this->db->table_name = 'mj_fujing';
		  $rowss = $this->db->select("","*","","id asc");
		  foreach($rowss as $v){
			 $fujings[$v['id']]=$v['xingming'];  
			 }		  
		  
		  $this->db->table_name = 'mj_tcgongxian';
		  
		  $where.=" isok=0 and yue=".$msgs['yues']." and juuser2=".$_SESSION['userid']; 
			 
		  //$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		  //$show_table = $this->db->listinfo($where,$order = 'id desc',$page, $pages = '16');
		  //$pages = $this->db->pages;
		  
		  $show_table= $this->db->select($where,"*","","id desc");
		  
		  if($tables['juok']==1){
			  $buttoncan="disabled='disabled'";
			  }
			
		include $this->admin_tpl('tcgx_shlist_ju2');
		
	}
		
	public function tcgxshenpi_do() { //审核操作
			
		
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
			if($_POST['ty']=='sqbmuser'){ 
			  $bmids=intval($_POST['bmid']);
			  if(intval($_POST['nextuser'])==0){
			    showmessage("未匹配到审核角色,请联系管理员");
			  }
			  
			  if(intval($_POST['sq'])==0){
				  $uparr['sqbmuser']=0;//如果拒绝
				  }else{
				  $uparr['bmok']=1;
				  $uparr['fenguanlingdao']=$_POST['nextuser'];
				  $uparr['fenguandt']=time();	  
				}
				
				//print_r($uparr);exit;
				
			   //插入消息表
			   $msgup['dos']=intval($_POST['sq']);
			   $msgup['dodt']=time();
			   $this->db->table_name = 'mj_msgs';
			   ////////
			   $msgs=$this->db->get_one("id=".intval($_POST['msgid']),"*");
			   if($msgs['dodt']==0){
			   $plsh= $this->db->select("yuan='".$msgs['yuan']."' and showuser=".$msgs['showuser']." and doty='".$msgs['doty']."' and dodt=0","*","","id desc");
			    foreach($plsh as $v){
				$doids[]=$v["id"];
				}
			   }
			    if(isset($doids)){$ids= implode(",",$doids);}else{$ids=intval($_POST['msgid']);}
				//echo $ids;exit;
				$ids=intval($_POST['msgid']); //不再批量处理		   
			   $this->db->update($msgup,"id in($ids)");
			   
			   //同步发送消息
			  $msgin['yuan']='突出贡献';
			  $msgin['adddt']=time();
			  $msgin['msg']=$bumen[$bmids].$_POST['yue']."突出贡献申请等待您审核";
			  $msgin['showuser']=intval($_POST['nextuser']);
			  $msgin['doty']='fenguanlingdao';
			  $msgin['yues']=$_POST['yue'];
			  $msgin['adduser']=$_SESSION['userid'];
			  $msgin['addbm']=$bmids;
			  $this->db->insert($msgin);				   
			   
			   
			   //修改状态	
			   $this->db->table_name = 'mj_tcgongxian';	
			   $this->db->update($uparr,array('bmok'=>0,'sqbmuser'=>$_SESSION['userid']));
			   showmessage("审核完成，请关闭窗口");
			     	
			}
			
			//主管领导审核
			if($_POST['ty']=='fenguanlingdao'){ 
			  $bmids=intval($_POST['bmid']);
			  if(intval($_POST['sq'])==0){
				  $uparr['sqbmuser']=0;//如果拒绝
				  $uparr['bmok']=0;
				  $uparr['fenguanlingdao']=0;
				  }else{
				  $uparr['fgok']=1;
				  $uparr['fenguandt']=time();	  
				}
				
				//print_r($uparr);exit;
				
			   //插入消息表
			   $msgup['dos']=intval($_POST['sq']);
			   $msgup['dodt']=time();
			   $this->db->table_name = 'mj_msgs';
			   ////////
			   $msgs=$this->db->get_one("id=".intval($_POST['msgid']),"*");
			   if($msgs['dodt']==0){
			   $plsh= $this->db->select("yuan='".$msgs['yuan']."' and showuser=".$msgs['showuser']." and doty='".$msgs['doty']."' and dodt=0","*","","id desc");
			    foreach($plsh as $v){
				$doids[]=$v["id"];
				}
			   }
			    if(isset($doids)){$ids= implode(",",$doids);}else{$ids=intval($_POST['msgid']);}
				//echo $ids;exit;
				$ids=intval($_POST['msgid']); //不再批量处理		   
			   $this->db->update($msgup,"id in($ids)");
			   
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
			   
			   
			   //修改考勤状态	
			   $this->db->table_name = 'mj_tcgongxian';	
			   $this->db->update($uparr,array('fgok'=>0,'fenguanlingdao'=>$_SESSION['userid']));
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
			   ////////
			   $msgs=$this->db->get_one("id=".intval($_POST['msgid']),"*");
			   if($msgs['dodt']==0){
			   $plsh= $this->db->select("yuan='".$msgs['yuan']."' and showuser=".$msgs['showuser']." and doty='".$msgs['doty']."' and dodt=0","*","","id desc");
			    foreach($plsh as $v){
				$doids[]=$v["id"];
				}
			   }
			    if(isset($doids)){$ids= implode(",",$doids);}else{$ids=intval($_POST['msgid']);}
				//echo $ids;exit;	
				$ids=intval($_POST['msgid']); //不再批量处理	   
			   $this->db->update($msgup,"id in($ids)");
			   
			   //同步发送消息
			  $msgin['yuan']='突出贡献';
			  $msgin['adddt']=time();
			  $msgin['msg']=$bumen[$bmids].$_POST['yue']."突出贡献申请等待您审核";
			  $msgin['showuser']=intval($_POST['nextuser']);
			  $msgin['doty']='juuser';
			  $msgin['yues']=$_POST['yue'];
			  $msgin['adduser']=$_SESSION['userid'];
			  $msgin['addbm']=0;
			  $this->db->insert($msgin);				   
			   
			   
			   //修改状态	
			   $this->db->table_name = 'mj_tcgongxian';	
			   $this->db->update($uparr,array('zzcok'=>0,'zzcuser'=>$_SESSION['userid']));

			   showmessage("审核完成，请关闭窗口");
			     	
			}				
			
			//局领导
			if($_POST['ty']=='juuser'){ 
			  $bmids=intval($_POST['bmid']);
			  if(intval($_POST['nextuser'])==0){
			    showmessage("未匹配到审核角色,请联系管理员");
			  }				  
			  if(intval($_POST['sq'])==0){
				  $uparr['juuser']=0;//如果拒绝
				  $uparr['juok']=0;
				  }else{
				  $uparr['judt']=time();
				  $uparr['juok']=1; 
				  $uparr['juuser2']=intval($_POST['nextuser']); 
				}
				
				//print_r($uparr);exit;
				
			   //插入消息表
			   $msgup['dos']=intval($_POST['sq']);
			   $msgup['dodt']=time();
			   $this->db->table_name = 'mj_msgs';
			   ////////
			   $msgs=$this->db->get_one("id=".intval($_POST['msgid']),"*");
			   if($msgs['dodt']==0){
			   $plsh= $this->db->select("yuan='".$msgs['yuan']."' and showuser=".$msgs['showuser']." and doty='".$msgs['doty']."' and dodt=0","*","","id desc");
			    foreach($plsh as $v){
				$doids[]=$v["id"];
				}
			   }
			    if(isset($doids)){$ids= implode(",",$doids);}else{$ids=intval($_POST['msgid']);}
				//echo $ids;exit;
				$ids=intval($_POST['msgid']); //不再批量处理		   
			   $this->db->update($msgup,"id in($ids)");
			   
			   //同步发送消息
			  $msgin['yuan']='突出贡献';
			  $msgin['adddt']=time();
			  $msgin['msg']=$_POST['yue']."突出贡献申请等待您审核";
			  $msgin['showuser']=intval($_POST['nextuser']);
			  $msgin['doty']='juuser2';
			  $msgin['yues']=$_POST['yue'];
			  $msgin['adduser']=$_SESSION['userid'];
			  $msgin['addbm']=0;
			  $this->db->insert($msgin);			   
			   
			   
			   //修改考勤状态	
			   $this->db->table_name = 'mj_tcgongxian';		
			   $this->db->update($uparr,array('yue'=>$_POST['yue'],'juuser'=>$_SESSION['userid']));

			   showmessage("审核完成，请关闭窗口");
			     	
			}		
			
			//局领导
			if($_POST['ty']=='juuser2'){ 
			  $bmids=intval($_POST['bmid']);
			  if(intval($_POST['sq'])==0){
				  $uparr['juuser2']=0;//如果拒绝
				  $uparr['juok2']=0;
				  }else{
				  $uparr['judt2']=time();
				  $uparr['juok2']=1; 
				}
				
				//print_r($uparr);exit;
				
			   //插入消息表
			   $msgup['dos']=intval($_POST['sq']);
			   $msgup['dodt']=time();
			   $this->db->table_name = 'mj_msgs';
			   ////////
			   $msgs=$this->db->get_one("id=".intval($_POST['msgid']),"*");
			   if($msgs['dodt']==0){
			   $plsh= $this->db->select("yuan='".$msgs['yuan']."' and showuser=".$msgs['showuser']." and doty='".$msgs['doty']."' and dodt=0","*","","id desc");
			    foreach($plsh as $v){
				$doids[]=$v["id"];
				}
			   }
			    if(isset($doids)){$ids= implode(",",$doids);}else{$ids=intval($_POST['msgid']);}
				//echo $ids;exit;	
				$ids=intval($_POST['msgid']); //不再批量处理	   
			   $this->db->update($msgup,"id in($ids)");
			   
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
			   $this->db->table_name = 'mj_tcgongxian';		
			   $this->db->update($uparr,array('juok2'=>0,'juuser2'=>$_SESSION['userid']));

			   showmessage("审核完成，请关闭窗口");
			     	
			}							
		  }
        /////////////////////////////////////////////
         			
		include $this->admin_tpl('tcgx_shenqing_do');
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


