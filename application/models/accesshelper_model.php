<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accesshelper_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_active_Modules()
	{
		$this->db->select('*');
			$this->db->where('Status', 'Active');
		$query = $this->db->get('cm_modules'); 
		return $query->result(); 
	}
	function get_active_count()
	{
		$this->db->select('*');
		//$this->db->order_by('product_code,task_code');
		$this->db->where('Status', 'Active');
		$query = $this->db->get('cm_prdtype'); 
		return $query->num_rows();
	}
	function get_all_mainmenus($pagination_counter=100, $page_count=0) { //get all stock
		$this->db->select('cm_menu_main.*,cm_modules.name as module_name');
		$this->db->order_by('module_code,main_id');
		$this->db->join('cm_modules','cm_modules.module_code=cm_menu_main.module_code');
		$this->db->where('cm_menu_main.status','Active');
			//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_menu_main'); 
		return $query->result(); 
    }

	function add_mainmenu($name,$code,$menu_url,$color,$icon)
	{
		$data=array( 
		'menu_name'=>$name,
		'module_code' => $code,
		'url'=>$menu_url,
		'color'=>$color,
		'icon'=>$icon,
		);
		$insert = $this->db->insert('cm_menu_main', $data);
		return $insert;
		
	}
	function update_order_key_main($munuid,$key)
	{
			$data=array( 
		'order_key'=>$key,
	
		);
		$this->db->where('main_id',$munuid);
		$insert = $this->db->update('cm_menu_main', $data);
		
		return $insert;
	}
		function update_order_key_sub($munuid,$key)
	{
			$data=array( 
		'order_key'=>$key,
	
		);
		$this->db->where('sub_id',$munuid);
		$insert = $this->db->update('cm_menu_sub', $data);
		
		return $insert;
	}
	
	function add_submenu($name,$code,$sub_url)
	{
		$data=array( 
		'sub_name'=>$name,
		'main_id' => $code,
		'url' => $sub_url,
		
		
		);
		$insert = $this->db->insert('cm_menu_sub', $data);
		return $insert;
		
	}
	function get_submenu($code) { //get all stock
		$this->db->select('*');
		$this->db->where('main_id',$code);
		//$this->db->where('status',CONFIRMKEY);
	
		$query = $this->db->get('cm_menu_sub'); 
		return $query->result(); 
    }
		function load_controller($code) { //get all stock
		$this->db->select('*');
		$this->db->where('main_id',$code);
		//$this->db->where('status',CONFIRMKEY);
	
		$query = $this->db->get('cm_menu_controllers'); 
		return $query->result(); 
    }
	function add_controller($name,$code,$subcode)
	{
		$data=array( 
		'controller_name'=>$name,
		'main_id' => $code,
		'sub_id' => $subcode,
		
		
		);
		$insert = $this->db->insert('cm_menu_controllers', $data);
		return $insert;
		
	}
	
	function delete_controller($id)
	{
		//$tot=$bprice*$quontity; 
		$this->db->where('controle_id', $id);
		$insert = $this->db->delete('cm_menu_controllers');
			return $insert;
		
	}
	function delete_main_menu($id)
	{
		//$tot=$bprice*$quontity; 
		$this->db->where('main_id', $id);
		$insert = $this->db->delete('cm_menu_main');
		$this->db->where('main_id', $id);
		$insert = $this->db->delete('cm_menu_sub');
		return $insert;
		
	}
	function delete_submenu($id)
	{
		//$tot=$bprice*$quontity; 
			$this->db->where('sub_id', $id);
		$insert = $this->db->delete('cm_menu_sub');
		return $insert;
		
	}
	
	function get_active_usertypes()
	{
		$this->db->select('*');
		//$this->db->order_by('product_code,task_code');
			//$this->db->where('Status', 'Active');
		$query = $this->db->get('cm_usertype'); 
		return $query->result(); 
	}
function get_module_main_menu($module) { //get all stock
		$this->db->select('cm_menu_main.*');
		$this->db->where('cm_menu_main.module_code',$module);
		$this->db->order_by('module_code,order_key');
		$this->db->where('cm_menu_main.status','Active');
			//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_menu_main'); 
		 if ($query->num_rows > 0) 
		return $query->result(); 
		else
		return false;
    }
	function get_module_main_menu_module_code($module) { //get all stock
		$this->db->select('cm_menu_main.*');
		$this->db->where('cm_modules.menu_name',$module);
		$this->db->join('cm_modules','cm_modules.module_code=cm_menu_main.module_code');
		$this->db->order_by('module_code,order_key');
		$this->db->where('cm_menu_main.status','Active');
			//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_menu_main'); 
		 if ($query->num_rows > 0) 
		return $query->result(); 
		else
		return false;
    }
	function get_main_sub_menu($mainid) { //get all stock
	$this->db->select('cm_menu_sub.*');
		$this->db->where('cm_menu_sub.main_id',$mainid);
		$this->db->where('cm_menu_sub.status','Active');
		$this->db->order_by('order_key');
		
			//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_menu_sub');
		if ($query->num_rows > 0) 
		return $query->result(); 
		else
		return false;; 
    }
	function get_mainmenu_controllers($mainid) { //get all stock
	$this->db->select('cm_menu_controllers.*');
		$this->db->where('cm_menu_controllers.main_id',$mainid);
		$this->db->where('cm_menu_controllers.sub_id',0);
		$this->db->order_by('controle_id');
		
			//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_menu_controllers');
		if ($query->num_rows > 0) 
		return $query->result(); 
		else
		return false;; 
    }
	function get_submenu_controllers($subid) { //get all stock
	$this->db->select('cm_menu_controllers.*');
		$this->db->where('cm_menu_controllers.sub_id',$subid);
		//$this->db->where('cm_menu_controllers.sub_id',0);
		$this->db->order_by('controle_id');
		
			//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_menu_controllers');
		if ($query->num_rows > 0) 
		return $query->result(); 
		else
		return false;; 
    }
	function get_main_active($mainid,$user_type) { //get all stock
	$this->db->select('cm_menu_activemain.*');
		$this->db->where('cm_menu_activemain.main_id',$mainid);
		$this->db->where('cm_menu_activemain.user_type',$user_type);
		//$this->db->where('cm_menu_controllers.sub_id',0);
		
			//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_menu_activemain');
		if ($query->num_rows > 0) 
		return true; 
		else
		return false;; 
    }
	function get_sub_active($mainid,$user_type) { //get all stock
	$this->db->select('cm_menu_activesub.*');
		$this->db->where('cm_menu_activesub.sub_id',$mainid);
		$this->db->where('cm_menu_activesub.user_type',$user_type);
			$query = $this->db->get('cm_menu_activesub');
		if ($query->num_rows > 0) 
		return true; 
		else
		return false;; 
    }
	function get_controller_active($controle_id,$user_type) { //get all stock
	$this->db->select('cm_menu_activecntl.*');
		$this->db->where('cm_menu_activecntl.controle_id',$controle_id);
		$this->db->where('cm_menu_activecntl.user_type',$user_type);
			$query = $this->db->get('cm_menu_activecntl');
		if ($query->num_rows > 0) 
		return true; 
		else
		return false;; 
    }
	
	function get_controller_active_by_name($controle_name,$user_type) { //get all stock
	$this->db->select('cm_menu_activecntl.*');
	$this->db->join('cm_menu_controllers','cm_menu_controllers.controle_id=cm_menu_activecntl.controle_id');
		$this->db->where('cm_menu_controllers.controller_name',$controle_name);
		$this->db->where('cm_menu_activecntl.user_type',$user_type);
			$query = $this->db->get('cm_menu_activecntl');
		if ($query->num_rows > 0) 
		return true; 
		else
		return false;
    }
	function get_controller_1($controle_name,$user_type) { //get all stock
	$this->db->trans_off();
	$this->db->trans_begin();
	$this->db->select('cm_menu_activecntl.*');
	$this->db->join('cm_menu_controllers','cm_menu_controllers.controle_id=cm_menu_activecntl.controle_id');
		$this->db->where('cm_menu_controllers.controller_name',$controle_name);
		$this->db->where('cm_menu_activecntl.user_type',$user_type);
			$query = $this->db->get('cm_menu_activecntl');
			$this->db->trans_complete();
		if ($query->num_rows > 0) 
		return true; 
		else
		return false;
    }
	function add_user_controller_mainmenu($item_id,$userid)
	{
		$data=array( 
		'main_id'=>$item_id,
		'user_type' => $userid,
		
		
		
		);
		$insert = $this->db->insert('cm_menu_activemain', $data);
		return $insert;
	}
	function add_user_controller_submenu($item_id,$userid)
	{
		$data=array( 
		'sub_id'=>$item_id,
		'user_type' => $userid,
		
		
		
		);
		$insert = $this->db->insert('cm_menu_activesub', $data);
		return $insert;
	}
	function add_user_controller_cntrl($item_id,$userid)
	{
		$data=array( 
		'controle_id'=>$item_id,
		'user_type' => $userid,
		
		
		
		);
		$insert = $this->db->insert('cm_menu_activecntl', $data);
		return $insert;
	}
	function delete_user_controller_mainmenu($item_id,$userid)
	{
		$this->db->where('main_id',$item_id);
		$this->db->where('user_type',$userid);
		$insert = $this->db->delete('cm_menu_activemain');
		return $insert;
	}
	function delete_user_controller_submenu($item_id,$userid)
	{
		$this->db->where('sub_id',$item_id);
		$this->db->where('user_type',$userid);
		$insert = $this->db->delete('cm_menu_activesub');
		return $insert;
	}
	function delete_user_controller_cntrl($item_id,$userid)
	{
		$this->db->where('controle_id',$item_id);
		$this->db->where('user_type',$userid);
		
		$insert = $this->db->delete('cm_menu_activecntl');
		return $insert;
	}
	
	function getuserlevels(){
		$typestoavoid = array('admin','re_manager');
		$this->db->select('usertype,usertype_id');
		$this->db->where_not_in('usertype',$typestoavoid);
		$this->db->order_by('usertype');
		$query = $this->db->get('cm_usertype');
		if($query->num_rows() > 0){
			return $query->result();
		}
	}
	
	function check_user_usage($usertype_id){
		$this->db->select('user_privilege');
		$this->db->where('user_privilege',$usertype_id);
		$query = $this->db->get('hr_empmastr');
		if($query->num_rows() > 0){
			return $query->num_rows();
		}else{
			return false;	
		}	
	}
	
	function delete_user_level($id){
		$this->db->where('usertype_id',$id);
		$insert = $this->db->delete('cm_usertype');
		if($this->db->affected_rows()){
			return true;
		}else
			return false;
	}
	
	function check_user_level($user_level){
		$this->db->select('usertype_id');
		$this->db->where('usertype',$user_level);
		$query = $this->db->get('cm_usertype');
		if($query->num_rows() > 0){
			return $query->num_rows();
		}else{
			return false;	
		}	
	}
	
	function create_user_level($user_level,$module){
		$user_level = ucwords(strtolower($user_level));
		$user_level = preg_replace('/\s+/', '_', $user_level);
		$data = array(
			'usertype' => $user_level,
			'module'	=>	$module,
			'module_list' => $module,
		);
		$this->db->insert('cm_usertype',$data);
		if($this->db->affected_rows()){
			return true;
		}else
			return false;	
	}
	
 function getmaincode($idfield,$prifix,$table,$fildname)
	{
	
 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table ."  where ".$fildname."='".$prifix."'");
        
		$newid="";
	
        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			  $id=intval($data->id);
			 if($data->id==NULL)
			 {
				 $newid=$id+1;
			 $newid=str_pad($newid, 3, "0", STR_PAD_LEFT);
		

			 }
			 else{
			 //$prjid=substr($prjid,3,4);
			 $id=intval($id);
			 $newid=$id+1;
			 $newid=str_pad($newid, 3, "0", STR_PAD_LEFT);
			
			
			 }
        }
		else
		{
		
		$newid=str_pad(1, 3, "0", STR_PAD_LEFT);
		$newid=$newid;
		}
	return $newid;
	
	}
	function get_user_modules($usertype) { //get all stock
		$this->db->select('cm_modules.*');
		$this->db->where('cm_menu_activemain.user_type',$usertype);//cm_menu_activemain
		$this->db->join('cm_menu_activemain','cm_menu_activemain.main_id=cm_menu_main.main_id');
		$this->db->join('cm_modules','cm_modules.module_code=cm_menu_main.module_code');
		$this->db->where('cm_modules.status','Active');
		$this->db->group_by('cm_menu_main.module_code');
		$this->db->order_by('cm_modules.menuorder','ACS');
			//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_menu_main'); 
		$arr=NULL;
		 if ($query->num_rows > 0) 
		return $query->result(); 
		else
		return false;
    }
}