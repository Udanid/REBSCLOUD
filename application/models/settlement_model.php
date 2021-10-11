<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settlement_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_allbook_types() { //get all stock
		$this->db->select('*');
		$this->db->order_by('type_id');
		$query = $this->db->get('ac_cashbooktypes'); 
		return $query->result(); 
    }
	function get_Paid_advancedata()
	{
		  	$this->db->select('ac_cashadvance.*,hr_empmastr.emp_no,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			$this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');
			$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id','left');
			$this->db->where('ac_cashadvance.status','PAID');
			$this->db->where('ac_cashbook.pay_type','CSH');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			 $this->db->group_by('adv_id'); 
			 $query = $this->db->get('ac_cashadvance'); 
        if ($query->num_rows() > 0) {
          
			return $query->result();
           
        }
		else return false;
	}
	function get_settlement_list($pagination_count,$page)
	{
		$advance_no=$this->input->post('advance_no');
        $amountsearch=$this->input->post('amountsearch');
        $name = $this->input->post('name');
		 $pay_type = $this->input->post('pay_type');
		  $cashbookid_search = $this->input->post('cashbookid_search');
		  
		  
		$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,ac_cashsettelment_ontime.settled_amount ,ac_cashsettelment_ontime.settled_date,ac_cashsettelment_ontime.settled_by,ac_cashsettelment_ontime.status as settlstat,ac_cashsettelment_ontime.id,ac_cashsettelment_ontime.note,ac_cashsettelment_ontime.confirm_by');
		$this->db->join('ac_cashadvance','ac_cashadvance.adv_id=ac_cashsettelment_ontime.advance_id');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			if ($_POST)
        	{
				if($cashbookid_search != 'all') {
					$this->db->where('ac_cashadvance.book_id',$cashbookid_search);
				}
				if($advance_no!='')
				$this->db->like('ac_cashadvance.adv_code',$advance_no,'both');
				if($amountsearch!='')
				$this->db->like('ac_cashadvance.amount',$amountsearch,'both');
				if($name!='')
				$this->db->where('ac_cashadvance.officer_id',$name);
			}
			else
			{
				$this->db->limit($pagination_count,$page);
			}
			$this->db->order_by('ac_cashsettelment_ontime.id', 'DESC');
			 $query = $this->db->get('ac_cashsettelment_ontime');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function get_settlement_data($id)
	{

			$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,ac_cashsettelment_ontime.settled_amount ,ac_cashsettelment_ontime.settled_date,ac_cashsettelment_ontime.settled_by,ac_cashsettelment_ontime.status as settlstat,ac_cashsettelment_ontime.id,ac_cashsettelment_ontime.note,ac_cashsettelment_ontime.confirm_by,ac_cashsettelment_ontime.file_folder');
		$this->db->join('ac_cashadvance','ac_cashadvance.adv_id=ac_cashsettelment_ontime.advance_id');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			$this->db->where('ac_cashsettelment_ontime.id',$id);
			
			 $query = $this->db->get('ac_cashsettelment_ontime');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	
	function get_settlement_list_ontime($id)
	{

			$this->db->select('ac_cashsettlement.*,hr_empmastr.initial,hr_empmastr.surname,cm_tasktype.task_name,re_projectms.project_name');
			$this->db->join('ac_cashadvance','ac_cashadvance.adv_id=ac_cashsettlement.adv_id');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			$this->db->join('re_projectms','re_projectms.prj_id=ac_cashsettlement.prj_id','left');
			$this->db->join('cm_tasktype','cm_tasktype.task_id=ac_cashsettlement.task_id','left');
			$this->db->where('ac_cashsettlement.onetime_settleid',$id);
			
			 $query = $this->db->get('ac_cashsettlement');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function get_cashadvancedata($id)
	{
		$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname');
			$this->db->where('ac_cashadvance.adv_id',$id);
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function get_cashbook_data($book_id)
	{

			 $this->db->select('ac_cashbook.*,ac_cashbooktypes.type_name,ac_ledgers.name,cm_branchms.branch_name ');
		$this->db->join('ac_cashbooktypes','ac_cashbooktypes.type_id=ac_cashbook.type_id');
		$this->db->join('ac_ledgers','ac_cashbook.ledger_id=ac_ledgers.id');
		$this->db->join('cm_branchms','cm_branchms.branch_code=ac_cashbook.branch_code');
			 $this->db->where('ac_cashbook.id',$book_id);
			 $query = $this->db->get('ac_cashbook');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function add_settlment()
	{
		
		$advid=explode('-', $this->input->post('adv_id'));
		$advancedata=$this->get_cashadvancedata($advid['0']);
		$amount= str_replace(',','',$this->input->post('settleamount'));
		$foldercode=$this->getfolder_code('file_folder','STL','ac_cashsettelment_ontime');
		
		 $data=array( 
			'advance_id' =>$advid['0'],
			
			'settled_date' => $this->input->post('settledate'),
			'settled_amount' => $amount,
			'note' => $this->input->post('note'),
			'status' => 'PENDING',
			'file_folder'=>$foldercode,
			'settled_by'=>$this->session->userdata('userid')
			);
			$insert = $this->db->insert('ac_cashsettelment_ontime', $data); 
			$insertid = $this->db->insert_id();
			
			$prjcount=$this->input->post('prjcount');
			$extcount=$this->input->post('extcount');
			$payeecode=$advancedata->officer_id;
			$payeename=$advancedata->initial.' '.$advancedata->surname;
			$adv_id=$advid['0'];
			$date=$this->input->post('settledate');
			for($i=1; $i<$prjcount; $i++)
			{
				$task_list=explode(',',$this->input->post('task_id_settle_prj'.$i));
				$task_id=$task_list[0];
				$subtasklist=explode(',',$this->input->post('subtask_id_settle_prj'.$i));
				$subtask_id=$subtasklist[0];
				$prj_id=$this->input->post('prj_id_settle_prj'.$i);
				$amount_this=$this->input->post('amount_settle_prj'.$i);
				$dis=$this->input->post('dis_settle_prj'.$i);
				$this->add_project_payment($task_id,$subtask_id,$date,$amount_this,$payeename,$payeecode,$prj_id,$adv_id,$insertid,$dis);
			}
			for($i=1; $i<$extcount; $i++)
			{
				$ledgerid=$this->input->post('ledgerid_settle_ex'.$i);
				$amount_this=$this->input->post('amount_settle_ex'.$i);
				$dis=$this->input->post('dis_settle_ex'.$i);
				$this->add_external_settlments($amount_this,$adv_id,$ledgerid,$date,$dis,$insertid);
			}
				return $insertid;
				
	}
	function add_settelment_file($file_folder,$file_name)
	{
		 $data=array( 
			'file_folder' =>$file_folder,
			'file_name' => $file_name,
			);
			$insert = $this->db->insert('ac_cashsettelment_files', $data); 
	}
	function get_settelment_file($file_folder)
	{
		 	$this->db->select('*');
			$this->db->where('file_folder',$file_folder);
			
			 $query = $this->db->get('ac_cashsettelment_files');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	 function getfolder_code($idfield,$prifix,$table)
	{

 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table." where ".$idfield." like '%".$prifix."%'");

		$newid="";

        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=$prifix.str_pad(1, 4, "0", STR_PAD_LEFT);


			 }
			 else{
			 $prjid=substr($prjid,3,4);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=$prifix.str_pad($newid, 4, "0", STR_PAD_LEFT);


			 }
        }
		else
		{

		$newid=str_pad(1, 4, "0", STR_PAD_LEFT);
		$newid=$prifix.$newid;
		}
	return $newid;

	}

	function get_ledgerid_set($task_id)
	{
		$this->db->select('ledger_id,adv_ledgerid');
		
		$this->db->where('task_id',$task_id);
		$this->db->where('status','CONFIRMED');
		$query = $this->db->get('cm_tasktype'); 
		if ($query->num_rows() > 0){
		//$data= $query->row();
			return $query->row();
		}
		else
		return 0;
		
	}
	function get_projectstatus($prj_id) { //get all stock
		$this->db->select('re_projectms.status,re_projectms.budgut_status,re_projectms.price_status');
		$this->db->where('re_projectms.prj_id',$prj_id);
		//$this->db->where('re_projectms.status',CONFIRMKEY);;
		$this->db->order_by('re_projectms.prj_id');
		$query = $this->db->get('re_projectms'); 
		return $query->row(); 
    }
	function get_project_paymeny_task_data($id,$taskid)
	{
		$this->db->select('re_prjacpaymentms.*,cm_tasktype.task_name');
		
		$this->db->where('re_prjacpaymentms.prj_id',$id);
		$this->db->where('re_prjacpaymentms.task_id',$taskid);
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentms.task_id');
	
		$query = $this->db->get('re_prjacpaymentms'); 
		 if ($query->num_rows >0) {
            return $query->row();
        }
		else
		return false; 
	}
function get_payment_data($entry_id)
	{
		$this->db->select('*');
		
		$this->db->where('entry_id',$entry_id);
		
		$query = $this->db->get('re_prjacpaymentdata'); 
		if ($query->num_rows() > 0){
		//$data= $query->row();
			return $query->row();
		}
		else
		return 0;
		
	}
  function delete_settlment($id)
  {		
  if($id)
  {
  $this->db->select('ac_cashsettlement.*');
		
		$this->db->where('onetime_settleid',$id);
		$query = $this->db->get('ac_cashsettlement'); 
		if ($query->num_rows >0) {
            $dataset=$query->result();
			foreach($dataset as $raw)
			{
					 $this->db->where('id', $raw->settle_entry_id);
					 $insert = $this->db->delete('ac_entries');
					 $this->db->where('entry_id', $raw->settle_entry_id);
		 			 $insert = $this->db->delete('ac_entry_items');
					 
					 
					 
					  		$advancedata=$this->get_cashadvancedata($raw->advance_id);
		 
		 					$tot=$advancedata->settled_amount-$raw->amount;
								$status='PAID';
									 $dataaa=array(
									'settled_amount' =>$tot,
									'status' =>$status,
									'settled_date' =>date('Y-m-d'),
									);
								$this->db->where('adv_id',$advancedata->adv_id);
								$insert = $this->db->Update('ac_cashadvance', $dataaa);
				// check project payment and delete
					if($raw->settle_entry_id)
					{
						$proejectdata=$this->get_payment_data($raw->settle_entry_id);
						if($proejectdata)
						{
							$masterpaydata=$this->get_project_paymeny_task_data($proejectdata->prj_id,$proejectdata->task_id);
							$totpayments=floatval($masterpaydata->tot_payments)- floatval($proejectdata->amount);
							$data2=array(
								'tot_payments'=>$totpayments,
							);
							$this->db->where('prj_id',$proejectdata->prj_id);
								$this->db->where('task_id',$proejectdata->task_id);
							if(!$this->db->update('re_prjacpaymentms', $data2))
							{
									$this->db->trans_rollback();
										$this->logger->write_message("error", "Error confirming Project");
								return false;
							}
							if($raw->settle_entry_id)
							{
								$this->db->where('entry_id', $raw->settle_entry_id);
								$insert = $this->db->delete('re_prjacpaymentdata'); 
							}
							
						}
					}
					$this->db->where('id', $raw->id);
					 $insert = $this->db->delete('ac_cashsettlement');
			}
        }
			
			$settledata=$this->get_settlement_data($id);
		$this->db->where('file_folder ',$settledata->file_folder);
		$insert = $this->db->delete('ac_cashsettelment_files');
		
		$this->db->where('id', $id);
		 $insert = $this->db->delete('ac_cashsettelment_ontime');
		 return $insert;
  	}
	else
	return false;
	  
  }
  function delete_directory($dirname) {
         if (is_dir($dirname))
           $dir_handle = opendir($dirname);
     if (!$dir_handle)
          return false;
     while($file = readdir($dir_handle)) {
           if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                     unlink($dirname."/".$file);
                else
                     delete_directory($dirname.'/'.$file);
           }
     }
     closedir($dir_handle);
     rmdir($dirname);
     return true;
}
  
	function add_project_payment($task_id,$subtask_id,$date,$amount,$payeename,$payeecode,$prj_id,$adv_id,$settldi,$note)
	{
		//$tot=$bprice*$quontity; getmaincode($idfield,$prifix,$table)
		$this->db->trans_start();
		$taskdata=$this->get_ledgerid_set($task_id);
		
		$prjdata=$this->get_projectstatus($prj_id);
		if($prjdata->budgut_status=='PENDING')
		$ledreid=$taskdata->adv_ledgerid;
		else
		$ledreid=$taskdata->ledger_id;
        $type=6;
		$pf_invoice_number='';
			
			$advancedata=$this->get_cashadvancedata($adv_id);
			$id=$advancedata->payvoucher_id;
			if($advancedata){
				
				
						$bookdata=$this->get_cashbook_data($advancedata->book_id);
						
						 $data=array( 
							'voucher_id' =>$advancedata->payvoucher_id,
							'adv_id' =>$adv_id,
							'settledate' => $date,
							'settleamount' => $amount,
							'prj_id' => $prj_id,
							'task_id' => $task_id,
							'note' => $note,
								'ledgerid'=>$this->session->userdata('accshortcode').$ledreid,
							'status' => 'CONFIRMED',
							'settle_entry_id'=>$int_entry,
							'onetime_settleid'=>$settldi,
							'apply_by'=>$this->session->userdata('userid'),
							'apply_date'=>date('Y-m-d')
							);
							$insert = $this->db->insert('ac_cashsettlement', $data); 
							$item_id = $this->db->insert_id();
							
							
								$tot=$advancedata->settled_amount+$amount;
								if($tot >= $advancedata->amount)
								{
									$status='SETTLED';
								}
								else
								$status='PAID';
								
								
									 $dataaa=array(
									'settled_amount' =>$tot,
									'status' =>$status,
									'settled_date' =>date('Y-m-d'),
					
					
									);
								$this->db->where('adv_id',$advancedata->adv_id);
								$insert = $this->db->Update('ac_cashadvance', $dataaa);
							
							
							
						
					$data=array( 
					'voucherid'=>$advancedata->payvoucher_id,
					'prj_id' =>$prj_id,
					'task_id' => $task_id,
					'subtask_id' => $subtask_id,
					'name' => $payeename,
					'amount' =>$amount,
					'create_date' =>$date,
					'pay_type'=>'ADVANCE',
					'advance_id'=>$adv_id,
					'settle_id'=>$item_id,
					
					'create_by' =>$this->session->userdata('username'),
				
					
					);
					if(!$this->db->insert('re_prjacpaymentdata', $data))
					{
							$this->db->trans_rollback();
								$this->logger->write_message("error", "Error confirming Project");
						return false;
					}
					$masterpaydata=$this->get_project_paymeny_task_data($prj_id,$task_id);
					$totpayments=floatval($masterpaydata->tot_payments)+ floatval($amount);
					$data=array( 
					'tot_payments'=>$totpayments,
					);
					$this->db->where('prj_id',$prj_id);
					$this->db->where('task_id',$task_id);
					if(!$this->db->update('re_prjacpaymentms', $data))
					{
							$this->db->trans_rollback();
								$this->logger->write_message("error", "Error confirming Project");
						return false;
					}
					
							
			}

					
			
		

		return $id;
		
	}
	function add_external_settlments($amount,$adv_id,$ledgerid,$date,$note,$settldi)
	{
		$advancedata=$this->get_cashadvancedata($adv_id);
		$amount=$amount;
						$bookdata=$this->get_cashbook_data($advancedata->book_id);
				 $vaouchercode=$advancedata->payvoucher_id;
				 $data=array( 
							'voucher_id' =>$advancedata->payvoucher_id,
							'adv_id' =>$adv_id,
							'settledate' => $date,
							'settleamount' => $amount,
							'ledgerid'=>$ledgerid,
							'note' => $note,
							'status' => 'CONFIRMED',
							'onetime_settleid'=>$settldi,
							'apply_by'=>$this->session->userdata('userid'),
							'apply_date'=>date('Y-m-d')
						
							);
							$insert = $this->db->insert('ac_cashsettlement', $data); 
							$entry_id = $this->db->insert_id();
				
			//	$advfulldata=$this->get_Paid_advacne_full_databy_id($settledata->adv_id);
				if($advancedata)
				{
					$tot=$advancedata->settled_amount+$amount;
					if($tot >= $advancedata->amount)
					{
						$status='SETTLED';
					}
					else
					$status='PAID';
					
					
						 $dataaa=array(
						'settled_amount' =>$tot,
						'status' =>$status,
						'settled_date' =>date('Y-m-d'),
		
		
						);
					$this->db->where('adv_id',$advancedata->adv_id);
					$insert = $this->db->Update('ac_cashadvance', $dataaa);
				}
	}
	function check_settlement($id)
	{
		$data=array( 
			'status' => 'CHECKED',
			'checked_by' =>  $this->session->userdata('userid'),
			'checked_date' => date('Y-m-d'),);
		$this->db->where('id',$id);
		$insert = $this->db->Update('ac_cashsettelment_ontime', $data);
		
		$this->db->where('onetime_settleid',$id);
		$insert = $this->db->Update('ac_cashsettlement', $data);
				
	}
	function confirm_settlement($id)
	{
		$data=array( 
			'status' => 'CONFIRMED',
			'confirm_by' =>  $this->session->userdata('userid'),
			'confirm_date' => date('Y-m-d'),);
		$this->db->where('id',$id);
		$insert = $this->db->Update('ac_cashsettelment_ontime', $data);
		$this->db->where('onetime_settleid',$id);
		$insert = $this->db->Update('ac_cashsettlement', $data);
	}
	function approve_settlement($id)
	{
		$settledata=$this->get_settlement_data($id);
		if($settledata->settlstat=='CONFIRMED')
		{
				$data=array( 
				'status' => 'APPROVED',
				'approved_by' =>  $this->session->userdata('userid'),
				'approved_date' => date('Y-m-d'),);
			$this->db->where('id',$id);
			$insert = $this->db->Update('ac_cashsettelment_ontime', $data);
			$this->db->where('onetime_settleid',$id);
			$insert = $this->db->Update('ac_cashsettlement', $data);
			
			
			 $advancedata=$this->get_cashadvancedata($settledata->adv_id);
			$bookdata=$this->get_cashbook_data($advancedata->book_id);
			$this->db->select('*');
			$this->db->where('onetime_settleid',$id);
				$query = $this->db->get('ac_cashsettlement'); 
			 if ($query->num_rows >0) {
			   $data=$query->result();
			   foreach($data as $raw)
			   {
				  
						$amount=$raw->settleamount;
						$date=date('Y-m-d');
					
						if($bookdata->pay_type=='CSH')
						$boolkedger=$bookdata->advance_ledger;
						else
						$boolkedger=$bookdata->ledger_id;
							
							$crlist[0]['ledgerid']=$boolkedger;
							$crlist[0]['amount']=$amount;
							$drlist[0]['ledgerid']=$raw->ledgerid;
							$drlist[0]['amount']=$amount;
							$crtot=$drtot=$amount;
							$narration = $advancedata->adv_code.' Cash Advance Settlement';
							$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$raw->prj_id,'','');
							
							$data1=array(
							'entry_id' => $int_entry,);
							$this->db->where('settle_id',$raw->id);
							$insert = $this->db->Update('re_prjacpaymentdata', $data1);
							$data2=array(
							'settle_entry_id' => $int_entry,);
							$this->db->where('id',$raw->id);
							$insert = $this->db->Update('ac_cashsettlement', $data2);
				   
			   }
			 }
		
		}
	}
	
	function get_dr_account_name($entry_id)
	{
		$this->db->select('ac_ledgers.name');
		
		$this->db->where('ac_entry_items.entry_id',$entry_id);
		$this->db->where('ac_entry_items.dc','D');
		$this->db->join('ac_ledgers','ac_ledgers.id=ac_entry_items.ledger_id');
	
		$query = $this->db->get('ac_entry_items'); 
		 if ($query->num_rows >0) {
           $data=$query->row();
		   return $data->name;
        }
		else
		return '';
	}
}