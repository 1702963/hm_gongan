<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', '', 0);

class tongzhi extends admin {
	var $db;
	public function __construct() {
		$this->db = pc_base::load_model('opinion_model');
		$this->db->table_name = 'mj_tongzhi';
		pc_base::load_app_func('global');
	}
	
	public function init() {
		
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$hys = $this->db->listinfo('',$order = 'inputtime desc',$page, $pages = '12');
		$pages = $this->db->pages;
		
			
		include $this->admin_tpl('gzhlist');
	}
	
	function addtongzhi()
	{
		if(isset($_POST['dosubmit'])) {
			
			
			$_POST['info']['inputtime']=time();
			$_POST['info']['userid']=$_SESSION['userid'];
			
			 $this->db->insert($_POST['info']);
			 echo "<script>alert('添加成功');</script>";
			 showmessage("添加成功","?m=tongzhi&c=gzh&a=init",100,'addtongzhi');
			}
		
		include $this->admin_tpl('addtongzhi');
	}
	
	function edit()
	{
		$id=$_REQUEST['id'];
		if(isset($_POST['dosubmit'])) {
			
			
			
			
			 $this->db->update($_POST['info'],array('id'=>$id));
			 echo "<script>alert('修改成功');</script>";
			 showmessage("添加成功","?m=tongzhi&c=gzh&a=init",100,'edittongzhi');
			}
		
			
			
			$tongzhi = $this->db->get_one("id=$id",'*');
		include $this->admin_tpl('edittongzhi');
	}
	
	public function jilu() {
		$id=$_GET['id'];
		$this->db->table_name = 'dx_news_gzh_read';
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$hys = $this->db->listinfo(" aid=$id ",$order = 'readtime asc',$page, $pages = '12');
		$pages = $this->db->pages;
			
			
		include $this->admin_tpl('jilu');
	}
	function show()
	{
		$id=$_REQUEST['id'];
		
		$hys = $this->db->get_one("id=$id",'*');
		
		include $this->admin_tpl('show_tongzhi');
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
		
		if($this->db->update(array('zt'=>0),array('id'=>$_GET['id']))) {
			
			exit('1');
		} else {
			exit('0');
		}
	}

		
		
/////////////////////////
public function curl_post($url , $data=array()){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    // POST数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // 把post的变量加上
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
  }
   public function posturl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $jsoninfo = json_decode($output, true);
        return $jsoninfo;
    }	
public  function sendmessage($template){		
		
    $json_template=json_encode($template);
	$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->access_token();
    $this->curl_post($url,urldecode($json_template));

		}
		
	//获取缓存的token	
	private function access_token(){
		$tokenarr=getcache('ac','commons');
		if((time()-$tokenarr['sj'])>7200){
			$token=$this->get_token();
			$acs=array('sj'=>time(),'ac'=>$token);
			setcache('ac',$acs,'commons');
			}else{
			$token=$tokenarr['ac'];
				}
		
		
		return $token;
		}
	
	//获取远程token
	private function get_token(){
          
		
            $appid = GZHAPP_ID;
            $appsec = GZHAPP_SEC;
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsec}";
            $raw = $this->posturl($url);
			
            if($raw['access_token']){
                
                return $raw['access_token'];
            }else{
                return false;
            }
    }


}


