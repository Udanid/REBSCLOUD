<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class common_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function check_common_activeflag($tablename,$id,$fieldname)
	{
		$this->db->select('id');
		$this->db->where('table_name',$tablename);
		$this->db->where('field_name',$fieldname);
		$this->db->where('record_key',$id);
		
		$query = $this->db->get('cm_activflag'); 
		 if ($query->num_rows >0) {
            return true;
        }
		else
		return false; 
	}
	function get_current_flaguser($tablename,$id,$fieldname)
	{
		$this->db->select('cm_activflag.userid,hr_empmastr.initial,hr_empmastr.surname');
		
		$this->db->where('table_name',$tablename);
		$this->db->where('field_name',$fieldname);
		$this->db->where('record_key',$id);
		$this->db->join('hr_empmastr', 'hr_empmastr.id = cm_activflag.userid','left');
		$query = $this->db->get('cm_activflag'); 
		 if ($query->num_rows >0) {
            return $query->row();
        }
		else
		return false; 
	}
	function update_activeflag($tablename,$id,$fieldname,$release_key)
	{
		$data=array('active_flag'=>$release_key);
				$this->db->where($fieldname,$id);
				$this->db->update($tablename,$data);
	}
	function delete_activflag($tablename,$id,$fieldname)
	{
				$this->db->where('table_name',$tablename);
				$this->db->where('field_name',$fieldname);
				$this->db->where('userid',$this->session->userdata('userid'));
				$this->db->where('record_key',$id);
				$sqlout =$this->db->delete('cm_activflag');
				return $sqlout;
	}
	function delete_curent_tabactivflag($tablename)
	{
				$this->db->where('table_name',$tablename);
				$this->db->where('userid',$this->session->userdata('userid'));
				
				$sqlout =$this->db->delete('cm_activflag');
				return $sqlout;
	}
	function add_activeflag($tablename,$id,$fieldname)
	{
		//$tot=$bprice*$quontity; 
		$thiskey=$this->get_maxid('id','cm_activflag');
		$data=array( 
		'id'=>$thiskey,
		'userid' => $this->session->userdata('userid'),
		'table_name' => $tablename,
		'field_name' => $fieldname,
		'record_key' => $id,
		
		);
		$insert = $this->db->insert('cm_activflag', $data);
		return $insert;
		
	}
	function release_user_activeflag($userid)
	{
		$this->db->select('*');
		$this->db->where('userid',$userid);
		//$this->db->order_by('pomaster.PODATE','DESC');
		$query = $this->db->get('cm_activflag');
		$price=NULL; 
		 if ($query->num_rows >0) {
            $dataset= $query->result();
			
			$this->db->where('userid',$userid);
			$this->db->delete('cm_activflag');
			
        }
		else
		{ 
		return false; 
		}
	}
	
	function get_bankbranchlist($id)
	{
		$this->db->select('*');
		
		$this->db->where('BANKCODE',$id);
	
		$query = $this->db->get('cm_bnkbrnch'); 
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false; 
	}
	function getbanklist()
	{
		$this->db->select('*');
		
		$query = $this->db->get('cm_banklist'); 
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false; 
	}
	function getbank_details($id)
	{
		$this->db->select('BANKNAME');
		$this->db->where('BANKCODE',$id);
		
		$query = $this->db->get('cm_banklist'); 
		 if ($query->num_rows >0) {
			$data = $query->row();
            return $data->BANKNAME;
        }
		else
		return false; 
	}function getbank_short_code($id)
	{
		$this->db->select('SHORTCODE');
		$this->db->where('BANKCODE',$id);
		
		$query = $this->db->get('cm_banklist'); 
		 if ($query->num_rows >0) {
			$data = $query->row();
            return $data->SHORTCODE;
        }
		else
		return false; 
	}
	function distict_list()
	{
		$this->db->select('*');
		
		$query = $this->db->get('cm_districts'); 
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false; 
	}
	function town_list()
	{
		$this->db->select('*');
		
		$query = $this->db->get('cm_towns'); 
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false; 
	}
		
		function council_list()
	{
		$this->db->select('*');
		
		$query = $this->db->get('cm_procouncil'); 
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false; 
	}
	
	function get_postal_code(){
		$this->db->select('postal_code');
		$this->db->where('town',$this->input->post('town'));
			$query = $this->db->get('cm_towns'); 
		 if ($query->num_rows >0) {
			 return $query->row()->postal_code;
		 }
			else
			return false; 
	}
	
	function add_notification($tablename,$notification,$module,$recordkey,$prililege = '')
	{
		if($prililege != ''){
			//we check which user levels have access
			$this->db->select('cm_menu_activecntl.user_type');
			$this->db->join('cm_menu_controllers','cm_menu_controllers.controle_id = cm_menu_activecntl.controle_id');
			$this->db->where('cm_menu_controllers.controller_name',$prililege);
				$query = $this->db->get('cm_menu_activecntl'); 
			 if ($query->num_rows >0) {
				foreach($query->result() as $row){
					 $data=array( 
						'branch_code' => $this->session->userdata('branchid'),
						'table_name' => $tablename,
						'notification' => $notification,
						'record_key' => $recordkey,
						'module'=>$module,
						'privilege_level'=>$row->user_type,
						'create_date' => date("Y-m-d H:i:s"),
					  
					  );
					  $insert = $this->db->insert('cm_notification', $data);
				}
			 }
				else
				return false;
		}else{
			$data=array( 
			  'branch_code' => $this->session->userdata('branchid'),
			  'table_name' => $tablename,
			  'notification' => $notification,
			  'record_key' => $recordkey,
			  'module'=>$module,
			  //'privilege_level'=>$prililege,
			  'create_date' => date("Y-m-d H:i:s"),
			
			);
			$insert = $this->db->insert('cm_notification', $data);
		}
		return $insert;
		
	}
	function delete_notification($tablename,$id)
	{
				$this->db->where('table_name',$tablename);
				$this->db->where('record_key',$id);
				$sqlout =$this->db->delete('cm_notification');
			//	echo $this->db->last_query();
				return $sqlout;
	}
	function get_notification_count($tablenames)
	{
				$this->db->select('COUNT(id) as mycount,notification,module,record_key');
				$this->db->where_in('table_name',$tablenames);
					if(! check_access('all_branch'))
				$this->db->where('branch_code',$this->session->userdata('branchid'));
				$this->db->where('privilege_level',NULL);
				$this->db->or_where('privilege_level',$this->session->userdata('usertype'));
				$this->db->group_by('table_name');
				$this->db->group_by('notification');
				$this->db->group_by('module');
				$this->db->order_by('record_key','DESC');
				$query = $this->db->get('cm_notification'); 
				 if ($query->num_rows >0) {
           			 return $query->result();
       			 }
					else
				return false; 
	}
	function get_notification_alert($tablenames)
	{
		$cur_time=date("Y-m-d H:i:s");
		$duration='-45 minutes';
		$nietime= date('Y-m-d H:i:s', strtotime($duration, strtotime($cur_time)));
		//echo $nietime;
				$this->db->select('COUNT(id) as mycount,notification,module');
				$this->db->where_in('table_name',$tablenames);
				
				$this->db->where_in('table_name',$tablenames);
				$this->db->where('create_date >=',$nietime);
				$this->db->where('create_date <=',$cur_time);
					if(! check_access('all_branch'))
				$this->db->where('branch_code',$this->session->userdata('branchid'));
				$this->db->group_by('table_name');
				$this->db->group_by('notification');
				$this->db->group_by('module');
					$query = $this->db->get('cm_notification'); 
				 if ($query->num_rows >0) {
           			 //$data= $query->row();
					return $query->result();
					 
       			 }
					else
				return 0; 
	}
	function confirm_count($tablenames)
	{
				$this->db->select('*');
				$this->db->where('status',CONFIRMKEY);
					$query = $this->db->get($tablenames); 
				 if ($query->num_rows >0) {
           			 return $query->num_rows();
       			 }
					else
				return 0; 
	}
	function get_maxid($idfield,$table)
	{
	
 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table );
        
		$newid="";
	
        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=1;
		

			 }
			 else{
			 //$prjid=substr($prjid,3,4);
			// echo
			 $id=intval($prjid);
			 $newid=$id+1;
			 
			
			
			 }
        }
		else
		{
		
		$newid=1;
		$newid=$newid;
		}
	return $newid;
	
	}
	
	function get_project_subtask($taskid,$id)
	{
		$this->db->select('re_prjfsubtask.*,cm_subtask.subtask_name');
		
		$this->db->where('re_prjfsubtask.prj_id',$id);
		$this->db->where('re_prjfsubtask.task_id',$taskid);
		$this->db->join('cm_subtask','cm_subtask.subtask_id=re_prjfsubtask.subtask_id');
	
		$query = $this->db->get('re_prjfsubtask'); 
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false; 
	}
	function get_subtask_payment($taskid)
	{
		$this->db->select('cm_subtask.*');
		
			$this->db->where('cm_subtask.task_id',$taskid);
		//$this->db->join('cm_subtask','cm_subtask.subtask_id=re_prjfsubtask.subtask_id');
	
		$query = $this->db->get('cm_subtask'); 
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false; 
	}
	function get_finance_year()
	{
			$this->db->select('*');
			$this->db->where('id',1);
	
		$query = $this->db->get('cm_settings'); 
		 if ($query->num_rows >0) {
            return $query->row();
        }
		else
		return false; 
}
	function delete_ledger_bank($id)
	{
			if($id)	
			{$this->db->where('ledger_id',$id);
				$sqlout =$this->db->delete('ac_ledgerbank');
			//	echo $this->db->last_query();
				return $sqlout;
			}
	}
	function insert_ledgerbank($id,$bank)
	{
		//$tot=$bprice*$quontity; 
		
		$this->delete_ledger_bank($id);
		
		$next_sq= $this->getsequense_banks($bank);
		$data=array( 
		
		'ledger_id' => $id,
		'bank_code' => $bank,
		'prefix_sequance'=>$next_sq,
		'next_number'=>100000,
		
		
		);
		$insert = $this->db->insert('ac_ledgerbank', $data);
		return $insert;
		
	}
	function update_nextvoucher_number($ledger_id,$nextcode)
	{
		//$tot=$bprice*$quontity; 
		
	
		$data=array( 
		
		'next_number'=>$nextcode,
		
		
		);
		 $this->db->where('ledger_id', $ledger_id);
		$insert = $this->db->update('ac_ledgerbank', $data);
		return $insert;
		
	}
	function getsequense_banks($bank)
	{
		 $query = $this->db->query("SELECT MAX(prefix_sequance) as id  FROM ac_ledgerbank where  bank_code='".$bank."'");

        $newid="";

		$newid="";

        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=str_pad(1, 2, "0", STR_PAD_LEFT);


			 }
			 else{
			// $prjid=substr($prjid,3,4);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=str_pad($newid, 2, "0", STR_PAD_LEFT);


			 }
        }
		else
		{

		$newid=str_pad(1, 2, "0", STR_PAD_LEFT);
		$newid=$newid;
		}
		return $newid;
	}
	function get_account_bank_code($id)
	{
			$this->db->select('bank_code');
			$this->db->where('ledger_id',$id);
	
		$query = $this->db->get('ac_ledgerbank'); 
		 if ($query->num_rows >0) {
			 $data=$query->row();
            return $data->bank_code;
        }
		else
		return ''; 
}
function get_account_bankdata($id)
	{
			$this->db->select('*');
			$this->db->where('ledger_id',$id);
	
		$query = $this->db->get('ac_ledgerbank'); 
		 if ($query->num_rows >0) {
		
            return $query->row();
        }
		else
		return ''; 
}
	function get_entry_bank_account($id)
	{
			$this->db->select('ledger_id');
			$this->db->where('entry_id',$id);
			$this->db->where('dc','C');
	
		$query = $this->db->get('ac_entry_items'); 
		 if ($query->num_rows >0) {
			 $data=$query->row();
            return $data->ledger_id;
        }
		else
		return false; 
}
function get_followuplist_bycuscode($cus_code)
{
		$this->db->select('re_epfollowups.*,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->where('re_epfollowups.cus_code',$cus_code);
			$this->db->join('hr_empmastr', 'hr_empmastr.id = re_epfollowups.emp_code','left');
	
		$query = $this->db->get('re_epfollowups'); 
		 if ($query->num_rows >0) {
		    return $query->result();
        }
		else
		return false; 
}
function get_resale_payment($res_code,$type)
	{
		$this->db->select('re_resalerefund.*,ac_payvoucherdata.status,ac_payvoucherdata.applydate,ac_chqprint.CHQNO');
			$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_resalerefund.voucher_id');
		$this->db->join('ac_chqprint',"ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid and ac_payvoucherdata.status='PAID'",'left');
	
		$this->db->where('re_resalerefund.res_code',$res_code);
		$this->db->where('re_resalerefund.type',$type);
		
			$query = $this->db->get('re_resalerefund'); 
		if ($query->num_rows() > 0){
	 
		return $query->result(); 
		}
		else
		return false;
	}
	function get_epresale_payment($branchid)
	{
		$this->db->select('re_epresalepayment.*,ac_payvoucherdata.status,ac_chqprint.CHQNO');
			$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_epresalepayment.voucher_code');
		$this->db->join('ac_chqprint',"ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid and ac_payvoucherdata.status='PAID'",'left');
	
		$this->db->where('re_epresalepayment.resale_code',$branchid);
		
			$query = $this->db->get('re_epresalepayment'); 
		if ($query->num_rows() > 0){
	 
		return $query->result(); 
		}
		else
		return false;
	}
	function get_taskname($id)
	{
		$this->db->select('task_name');
			$this->db->where('task_id',$id);
	
		$query = $this->db->get('cm_tasktype'); 
		 if ($query->num_rows >0) {
			 $data=$query->row();
            return $data->task_name;
        }
		else
		return ''; 
	}
	function get_user_fullname($id)
	{
		$this->db->select('hr_empmastr.initial,hr_empmastr.surname');
			$this->db->join('hr_empmastr','hr_empmastr.id=cm_userdata.USRID');
		
			$this->db->where('USRNAME',$id);
	
		$query = $this->db->get('cm_userdata'); 
		 if ($query->num_rows >0) {
			 $data=$query->row();
            $name=$data->initial.' '.$data->surname;
			return $name;
        }
		else
		return ''; 
	}
	function get_user_fullname_id($id)
	{
		$this->db->select('hr_empmastr.initial,hr_empmastr.surname');
			$this->db->join('hr_empmastr','hr_empmastr.id=cm_userdata.USRID');
		
			$this->db->where('USRID',$id);
	
		$query = $this->db->get('cm_userdata'); 
		 if ($query->num_rows >0) {
			 $data=$query->row();
            $name=$data->initial.' '.$data->surname;
			return $name;
        }
		else
		return ''; 
	}
	
	
	function get_user_notification_alert($user_id)
	{
	  $cur_time=date("Y-m-d H:i:s");
	  $duration='-45 minutes';
	  $nietime= date('Y-m-d H:i:s', strtotime($duration, strtotime($cur_time)));
	  //echo $nietime;
		  $this->db->select('COUNT(id) as mycount,notification,module');
		  $this->db->where('to_user',$user_id);
	
		//    $this->db->where('create_date >=',$nietime);
		  $this->db->where('create_date <=',$cur_time);
			if(! check_access('all_branch'))
		  $this->db->where('branch_code',$this->session->userdata('branchid'));
		  $this->db->group_by('table_name');
		  $this->db->group_by('notification');
		  $this->db->group_by('module');
			$query = $this->db->get('cm_notification');
		   if ($query->num_rows >0) {
				   //$data= $query->row();
			return $query->result();
	
			   }
			else
		  return 0;
	}
	//Ticket No:2537 Added By Madushan
	function get_advancepayment_as_at_date($res_code,$date)
	{
		$this->db->select('pay_amount');
		$this->db->from('re_saleadvance');
		$this->db->where('res_code',$res_code);
		$this->db->where('pay_date <=',$date);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
			return false;
	}
	function get_voucher_ncode($entryid)
	{
		$this->db->select('voucher_ncode');
		$this->db->from('ac_payvoucherdata');
		$this->db->where('entryid',$entryid);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$data= $query->row();
			return $data->voucher_ncode;
		}
		else
			return '';
	}
	
	//Ticket 2735 by Eranga
	function get_voucher_by_entry($entry_id){
		$this->db->select('ac_payvoucherdata.voucherid');
		$this->db->join('ac_entries','ac_entries.id = ac_payvoucherdata.entryid','left');
		$this->db->where('ac_entries.id',$entry_id);
		$query = $this->db->get('ac_payvoucherdata');
		if($query->num_rows()>0)
		{
			$data= $query->row();
			return $data->voucherid;
		}
		else
			return false;
		
	}

	/*Ticket No:2771 Added By Madushan 2021.05.05*/
	function get_all_projects(){
		$this->db->select('*');
		$query = $this->db->get('re_projectms');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
			return false;
	}
	// added by udani for cash advance workfolow module
	function add_notification_officer($tablename,$notification,$module,$recordkey,$officer)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		'branch_code' => $this->session->userdata('branchid'),
		'table_name' => $tablename,
		'notification' => $notification,
		'record_key' => $recordkey,
		'module'=>$module,
		'create_date' => date("Y-m-d H:i:s"),
		'user_id'=>$officer
		
		);
		$insert = $this->db->insert('cm_notification', $data);
		return $insert;
		
	}
	function get_privilage_officer_list($userprivilage)
	{
		$this->db->select('hr_empmastr.id,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.display_name ');
			
				$this->db->join('cm_menu_controllers','cm_menu_controllers.controle_id=cm_menu_activecntl.controle_id');
				$this->db->join('cm_usertype','cm_usertype.usertype=cm_menu_activecntl.user_type');
				$this->db->join('hr_empmastr','hr_empmastr.user_privilege=cm_usertype.usertype_id');
				$this->db->where('cm_menu_controllers.controller_name',$userprivilage);
			
				$query = $this->db->get('cm_menu_activecntl'); 
				 if ($query->num_rows >0) {
           			 return $query->result();
       			 }
					else
				return false; 
		
	}
	function get_notification_count_user()
	{
				$this->db->select('COUNT(id) as mycount,notification,module');
				$this->db->where('user_id', $this->session->userdata('userid'));
				//	if(! check_access('all_branch'))
				//$this->db->where('branch_code',$this->session->userdata('branchid'));
				$this->db->group_by('table_name');
				$this->db->group_by('notification');
				$this->db->group_by('module');
				$query = $this->db->get('cm_notification'); 
				 if ($query->num_rows >0) {
           			 return $query->result();
       			 }
					else
				return false; 
	}
	function get_designation_officer_list($designation)
	{
		$this->db->select('hr_empmastr.id,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.display_name ');
			
				$this->db->join('hr_dsgntion','hr_dsgntion.id=hr_empmastr.designation');
				$this->db->where('hr_dsgntion.designation',$designation);
			
				$query = $this->db->get('hr_empmastr'); 
				 if ($query->num_rows >0) {
           			 return $query->result();
       			 }
					else
				return false; 
		
	}

	/*Ticket No:2889 Added By Madushan 2021.06.18*/
	function check_loan_created($lot_id)
    {
        $this->db->select('re_eploan.*');
        $this->db->join('re_resevation','re_resevation.res_code = re_eploan.res_code');
        $this->db->where('re_resevation.lot_id',$lot_id);
        $query = $this->db->get('re_eploan');
        if($query->num_rows>0)
            return true;
        else
            return false;
    }

     /*Ticket No:2975 Added By Madushan 2021.06.28*/
	function check_chargers_paid($res_code)
	{
		 $this->db->select('*');
	     $this->db->where('res_code',$res_code);
	     $query = $this->db->get('re_chargepayments');
	     if($query->num_rows>0)
	         return true;
	     else
	         return false;
	}

	//Ticket No:3153 Added By Madushan 2021-07-21
	function get_emp_details($emp_id){
		$this->db->select('*');
		$this->db->where('id',$emp_id);
		$query = $this->db->get('hr_empmastr');
		if($query->num_rows>0)
			return $query->row();
		else
			return false;
	}

	//Ticket No:3269 Added By Madushan 2021-08-07
	function check_loan_payment_date_period($loan_code,$startdate,$enddate){
		$this->db->select('*');
		$this->db->where('temp_code',$loan_code);
		$this->db->where('entry_date >=',$startdate);
		$this->db->where('entry_date <=',$enddate);
		$query = $this->db->get('re_prjacincome');
		if($query->num_rows>0)
			return true;
		else
			return false;
	}
}