<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pettycashpayments_model extends CI_Model {

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
		  	$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
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
	function get_officers_cash_advancedata($officer)
	{
		  	$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			 $this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');

			$this->db->where('ac_cashadvance.officer_id',$officer);
			$this->db->where('ac_cashbook.pay_type','CSH');
			$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			$this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function get_payment_list($pagination_count,$page)
	{

	    $amountsearch=$this->input->post('amountsearch');
        $name = $this->input->post('name');
		  $cashbookid_search = $this->input->post('cashbookid_search');
		$this->db->select('ac_cashpayment_ontime.*,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->join('ac_cashadvance','ac_cashadvance.adv_id=ac_cashpayment_ontime.advance_id','left');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashpayment_ontime.officer_id');

			if ($_POST)
        	{
				if($cashbookid_search != 'all') {
					$this->db->where('ac_cashpayment_ontime.book_id',$cashbookid_search);
				}
				if($amountsearch!='')
				$this->db->like('ac_cashpayment_ontime.amount',$amountsearch,'both');
				if($name!='')
				$this->db->where('ac_cashpayment_ontime.sup_code',$name);
			}
			else
			{
				$this->db->limit($pagination_count,$page);
			}


$this->db->order_by('ac_cashpayment_ontime.id', 'DESC');

			 $query = $this->db->get('ac_cashpayment_ontime');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function get_payment_list_confirmed($bookid,$rptdate)
	{
		$this->db->select('ac_cashpayment_ontime.*,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->join('ac_cashadvance','ac_cashadvance.adv_id=ac_cashpayment_ontime.advance_id','left');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashpayment_ontime.officer_id');
			$this->db->where('ac_cashpayment_ontime.book_id',$bookid);
			$this->db->where('ac_cashpayment_ontime.confirm_date <=',$rptdate);
			  $this->db->where('ac_cashpayment_ontime.reim_status','PENDING');
			$this->db->where('ac_cashpayment_ontime.status','APPROVED');
			 $query = $this->db->get('ac_cashpayment_ontime');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function get_onetimepayment_data($id)
	{
			//3153
			$this->db->select('ac_cashpayment_ontime.*,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.emp_no,ac_cashbook.ledger_id,ac_ledgers.name');//updated by nadee
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashpayment_ontime.officer_id');
      $this->db->join('ac_cashbook','ac_cashbook.id=ac_cashpayment_ontime.book_id');
      $this->db->join('ac_ledgers','ac_cashbook.ledger_id=ac_ledgers.id');
			$this->db->where('ac_cashpayment_ontime.id',$id);

			 $query = $this->db->get('ac_cashpayment_ontime');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function get_onetimepayment_data_entryid($id)
	{

			$this->db->select('ac_cashpayment_ontime.*,hr_empmastr.initial,hr_empmastr.surname');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashpayment_ontime.officer_id');
			$this->db->where('ac_cashpayment_ontime.pay_entry',$id);

			 $query = $this->db->get('ac_cashpayment_ontime');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}

	function get_payment_list_ontime($id)
	{

			$this->db->select('ac_payvoucherdata.*,cm_tasktype.task_name,re_projectms.project_name');
			$this->db->join('re_prjacpaymentdata','re_prjacpaymentdata.voucherid=ac_payvoucherdata.voucherid','left');
			$this->db->join('re_projectms','re_projectms.prj_id=re_prjacpaymentdata.prj_id','left');
			$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentdata.task_id','left');
			$this->db->where('ac_payvoucherdata.direct_payid',$id);

			 $query = $this->db->get('ac_payvoucherdata');
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
	function get_designation_officer_list($designation)
	{
		$this->db->select('hr_empmastr.id,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.display_name ');

				$this->db->join('hr_dsgntion','hr_dsgntion.id=hr_empmastr.designation');
				$this->db->where('hr_dsgntion.designation',$designation);

				$query = $this->db->get('hr_empmastr');
				 if ($query->num_rows >0) {
           			 $data=$query->row();

					 return $data->id;
       			 }
					else
				return 0;

	}
	function add_payments()
	{

		$book_id= $this->input->post('book_id');
		$officer_id= $this->input->post('officer_id');
		//$advancedata=$this->get_cashadvancedata($advid['0']);
		$amount= str_replace(',','',$this->input->post('settleamount'));
		$this->load->model('Entry_model');
		$nextid=$this->Entry_model->next_entry_number(2);
		$date=$this->input->post('settledate');
		$serial_code=$this->get_serial_code('serial_number',$prifix,'ac_cashpayment_ontime',$book_id);

		$this->db->trans_start();
            $adv_id=$this->input->post('adv_id');
			$sup_code='';$sup_name='';
			if($this->input->post('supplier_id')!="")
			{
				$supdate=explode('-',$this->input->post('supplier_id'));
				$sup_code=$supdate[0];
				$sup_name=$supdate[1];
			}
		if($adv_id!="")
		{
			$advancedata=$this->get_cashadvancedata($adv_id);
			$check_officerid=$advancedata->check_officerid;
			$apprved_officerid=$advancedata->apprved_officerid;
			$confirm_officerid=$advancedata->confirm_officerid;
		}
		else
		{
			$check_officerid=$this->input->post('check_officerid');
			$apprved_officerid=$this->input->post('apprved_officerid');
				if($apprved_officerid=='22')
				$confirm_officerid=$this->get_designation_officer_list('Audit Executive');
				if($apprved_officerid=='12')
				$confirm_officerid=$this->get_designation_officer_list('Intern');
		}


		$foldercode=$this->getfolder_code('file_folder','PTC','ac_cashpayment_ontime');
		 $data=array(
			'book_id' =>$book_id,
			'officer_id' =>$officer_id,
			'advance_id'=>$adv_id,
			'paid_date' => $this->input->post('settledate'),
			'pay_amount' => $amount,
			'note' => $this->input->post('note'),
			'status' => 'PENDING',
			'file_folder'=>$foldercode,
			'paid_by'=>$this->session->userdata('userid'),
			'check_officerid' => $check_officerid,
			'apprved_officerid' => $apprved_officerid,
			'confirm_officerid' => $confirm_officerid,
			'serial_number'=>$serial_code,
			'sup_code'=>$sup_code,
			'sup_name'=>$sup_name,
			);
			$insert = $this->db->insert('ac_cashpayment_ontime', $data);
			$insertid = $this->db->insert_id();

			$prjcount=$this->input->post('prjcount');
			$extcount=$this->input->post('extcount');
			if($sup_code!='')
			{
				$payeecode=$sup_code;
				$payeename=$sup_name;
			}
			else
			{
			$payeecode=$officer_id;
			$payeename=get_user_fullname_id($officer_id);
			}
			$bookdata=$this->get_cashbook_data($book_id);
						$creditledger=$bookdata->ledger_id;

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
				$this->add_project_payment($task_id,$subtask_id,$date,$amount_this,$payeename,$payeecode,$prj_id,$insertid,$dis);
			}
			for($i=1; $i<$extcount; $i++)
			{
				$ledgerid=$this->input->post('ledgerid_settle_ex'.$i);
				$amount_this=$this->input->post('amount_settle_ex'.$i);
				$dis=$this->input->post('dis_settle_ex'.$i);
				$this->add_external_payment($amount_this,$ledgerid,$date,$dis,$insertid,$payeecode,$payeename);

			}
				return $insertid;

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
function get_payment_data($voucherid)
	{
		$this->db->select('*');

		$this->db->where('voucherid',$voucherid);

		$query = $this->db->get('re_prjacpaymentdata');
		if ($query->num_rows() > 0){
		//$data= $query->row();
			return $query->row();
		}
		else
		return 0;

	}
  function delete_payment($id)
  {
  if($id)
  {
  $this->db->select('ac_payvoucherdata.*');

		$this->db->where('direct_payid',$id);
		$query = $this->db->get('ac_payvoucherdata');
		if ($query->num_rows >0) {
            $dataset=$query->result();
			foreach($dataset as $raw)
			{


				// check project payment and delete
					if($raw->voucherid)
					{
						$proejectdata=$this->get_payment_data($raw->voucherid);
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
							if($raw->voucherid)
							{
							$this->db->where('voucherid', $raw->voucherid);
							$insert = $this->db->delete('re_prjacpaymentdata');
							}
	
						}
						$this->db->where('voucherid', $raw->voucherid);
						$insert = $this->db->delete('ac_payvoucherdata');
					}
			}
        }


		$settledata=$this->get_onetimepayment_data($id);
		$this->db->where('file_folder ',$settledata->file_folder);
		$insert = $this->db->delete('ac_cashsettelment_files');

		$this->db->where('id', $id);
		 $insert = $this->db->delete('ac_cashpayment_ontime');
		 return $insert;
  }
   else
  return false;


  }
	function add_project_payment($task_id,$subtask_id,$date,$amount,$payeename,$payeecode,$prj_id,$pay_id,$note)
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




					  $idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',$date);
					$id=$idlist[0];
					$data=array(
					'voucherid'=>$id,
					'vouchercode'=>$idlist[1],
					'branch_code' => $this->session->userdata('branchid'),
					'ledger_id' => $this->session->userdata('accshortcode').$ledreid,
					'payeecode' => $payeecode,
					'payeename' => $payeename,
					'vouchertype' => $type,
						'prj_id' => $prj_id,
					'paymentdes' => $note,
					'amount' => $amount,
					'applydate' =>$date,
					'status' => 'PAID',

					'paymentdate'=>$date,
					'paymenttype'=>'CSH',
					'direct_payid'=>$pay_id

					);
					if(!$this->db->insert('ac_payvoucherdata', $data))
					{
							$this->db->trans_rollback();
								$this->logger->write_message("error", "Error confirming Project");
						return false;
					}





					$data=array(
					'voucherid'=>$id,
					'prj_id' =>$prj_id,
					'task_id' => $task_id,
					'subtask_id' => $subtask_id,
					'name' => $payeename,
					'amount' =>$amount,
					'create_date' =>$date,
					'pay_type'=>'DIRECT',

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







		return true;

	}
	function add_external_payment($amount,$ledgerid,$date,$note,$pay_id,$payeecode,$payeename)
	{
		$amount=$amount;
						 $idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',$date);
					$id=$idlist[0];
					$data=array(
					'voucherid'=>$id,
					'vouchercode'=>$idlist[1],
					'branch_code' => $this->session->userdata('branchid'),
					'ledger_id' => $ledgerid,
					'payeecode' => $payeecode,
					'payeename' => $payeename,
					'vouchertype' => 4,

					'paymentdes' => $note,
					'amount' => $amount,
					'applydate' =>$date,
					'status' => 'PAID',

					'paymentdate'=>$date,
					'paymenttype'=>'CSH',
					'direct_payid'=>$pay_id

					);
					if(!$this->db->insert('ac_payvoucherdata', $data))
					{
							$this->db->trans_rollback();
								$this->logger->write_message("error", "Error confirming Project");
						return false;
					}




	}
	function check_payment($id)
	{



		$data=array(
			'status' => 'CHECKED',
			'checked_by' =>  $this->session->userdata('userid'),
			'checked_date' => date('Y-m-d'),


				);
				$this->db->where('id',$id);
				$insert = $this->db->Update('ac_cashpayment_ontime', $data);
	}
	function confirm_payment($id)
	{



		$data=array(
			'status' => 'CONFIRMED',
			'confirm_by' =>  $this->session->userdata('userid'),
			'confirm_date' => date('Y-m-d'),


				);
				$this->db->where('id',$id);
				$insert = $this->db->Update('ac_cashpayment_ontime', $data);
	}
	function approve_payment($id)
	{
		$this->load->model("Entry_model");
		$settledata=$this->get_onetimepayment_data($id);
			$bookbalance=get_cashbook_balance($settledata->book_id);
		if($bookbalance<$settledata->pay_amount)
		{
			
			$this->session->set_flashdata('error', 'Did not has Enough cash to make payment');
				redirect('accounts/pettycashpayments/showall');
					return false;
		}
		if($settledata->status=='CONFIRMED')
		{
			$this->session->set_flashdata('error', 'Already Paid or not confirmed yet');
				redirect('accounts/pettycashpayments/showall');
					return false;
		}
			$nextid=$this->Entry_model->next_entry_number(2);
			$amount=$settledata->pay_amount;
			$date=date('Y-m-d');
				$this->db->trans_start();
            $insert_data = array(
                'number' => $nextid,
                'date' => $date,
                'narration' => $settledata->note,
                'entry_type' => 2,
                'tag_id' => '',
				 'dr_total' =>$amount,
				  'cr_total' => $amount,
            );
            if ( ! $this->db->insert('ac_entries', $insert_data))
            {
                $this->db->trans_rollback();
                exit;
            } else {
                $entry_id = $this->db->insert_id();
            }

			$bookdata=$this->get_cashbook_data($settledata->book_id);
			$creditledger=$bookdata->ledger_id;
			$insert_ledger_data = array(
						'entry_id' => $entry_id,
						'ledger_id' => $creditledger,
						'amount' => $amount,
						'dc' => 'C',
					);
			$this->db->insert('ac_entry_items', $insert_ledger_data);



			$this->db->select('ac_payvoucherdata.*');

			$this->db->where('direct_payid',$id);
			$query = $this->db->get('ac_payvoucherdata');
			if ($query->num_rows >0) {
				$dataset=$query->result();
				foreach($dataset as $raw)
				{$insert_ledger_data=NULL;

					$insert_ledger_data = array(
						'entry_id' => $entry_id,
						'ledger_id' => $raw->ledger_id,
						'amount' => $raw->amount,
						'dc' => 'D',
					);
					$this->db->insert('ac_entry_items', $insert_ledger_data);

				}
			}

					$data=array(
					'pay_entry' => $entry_id,//3153
					'status' => 'APPROVED',
					'approved_by' =>  $this->session->userdata('userid'),
					'approved_date' => date('Y-m-d'),


				);
				$this->db->where('id',$id);
				$insert = $this->db->Update('ac_cashpayment_ontime', $data);

				$data=array(
					'entryid' => $entry_id,
					'paymentdate' => date('Y-m-d'),


				);
				$this->db->where('direct_payid',$id);
				$insert = $this->db->Update('ac_payvoucherdata', $data);
				return true;

		
	}

	function get_ledger_name($ledgerid)
	{
		$this->db->select('name');

		$this->db->where('id',$ledgerid);

		$query = $this->db->get('ac_ledgers');
		 if ($query->num_rows >0) {
           $data=$query->row();
		   return $data->name;
        }
		else
		return '';
	}
	function  apply_reimbersment($bookid,$rptdate,$amount)
	{


		 $data=array(
			'book_id' =>$bookid,
			'amount' =>$amount,
			'date'=>$rptdate,
			'status' => 'PENDING',
			'apply_by'=>$this->session->userdata('userid'),
			'apply_date'=>date('Y-m-d')
			);
			$insert = $this->db->insert('ac_cashreimbursement', $data);
			$insertid = $this->db->insert_id();

			// update cash advance settpments
			$status_arr=array('SETTLED');
			 $this->db->select('*');
			 $this->db->where_in('ac_cashadvance.status',$status_arr);
			 $this->db->where('ac_cashadvance.book_id',$bookid);
			 $this->db->where('ac_cashadvance.rpt_status','PENDING');
			 $this->db->where('ac_cashadvance.settled_date <=',$rptdate);
			 $this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
       		 if ($query->num_rows() > 0) {

				$data= $query->result();
				if($data)
				{
					foreach($data as $raw) {
					$status='SETTLED';

					 $dataaa=array(
					'rpt_status' =>'COMPLETE',
					'reim_id' =>$insertid,
					'rpt_updateby' =>$this->session->userdata('userid'),
					'rpt_updatedate' =>date('Y-m-d'),


					);
					$this->db->where('adv_id',$raw->adv_id);
					$insert = $this->db->Update('ac_cashadvance', $dataaa);
					}
				}

        	}

			

			$this->db->select('*');
			$this->db->where('ac_cashpayment_ontime.book_id',$bookid);
			$this->db->where('ac_cashpayment_ontime.confirm_date <=',$rptdate);
			  $this->db->where('ac_cashpayment_ontime.reim_status','PENDING');
			$this->db->where('ac_cashpayment_ontime.status','APPROVED');
			 $query = $this->db->get('ac_cashpayment_ontime');
      	  if ($query->num_rows() > 0) {

			$data1= $query->result();
				if($data1)
				{
					foreach($data1 as $raw1) {

						 $dataaa=array(
						'reim_status' =>'COMPLETE',
						'reim_id' =>$insertid,



						);
						$this->db->where('id',$raw1->id);
						$insert = $this->db->Update('ac_cashpayment_ontime', $dataaa);
					}
				}

        }
		 return $insertid;
	}
	function get_reimbersment_list()
	{
		$this->db->select('ac_cashreimbursement.*,hr_empmastr.initial,hr_empmastr.surname,ac_cashbook.ledger_id');
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=ac_cashreimbursement.voucherid','left');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashreimbursement.apply_by');
				$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashreimbursement.book_id');

			 $query = $this->db->get('ac_cashreimbursement');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}

	function delete_reimbersment($id)
	{
		if($id)
		{
				 $dataaa=array(
				'reim_status' =>'PENDING',
				'reim_id' =>NULL,



				);
				$this->db->where('reim_id',$id);
				$insert = $this->db->Update('ac_cashpayment_ontime', $dataaa);
						$dataaa=array(
					'rpt_status' =>'PENDING',
					'reim_id' =>NULL,
					'rpt_updateby' =>NULL,
					'rpt_updatedate' =>NULL,


					);
					$this->db->where('reim_id',$id);
					$insert = $this->db->Update('ac_cashadvance', $dataaa);

					$this->db->where('id',$id);
					$insert = $this->db->delete('ac_cashreimbursement');
		}
	}
	function get_reimbersment_data($id)
	{
		$this->db->select('ac_cashreimbursement.*,hr_empmastr.initial,hr_empmastr.surname,ac_cashbook.ledger_id');
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=ac_cashreimbursement.voucherid','left');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashreimbursement.apply_by');
				$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashreimbursement.book_id');
				$this->db->where('ac_cashreimbursement.id',$id);

			 $query = $this->db->get('ac_cashreimbursement');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function confirm_reimbersment($id1)
	{
		$rimdata=$this->get_reimbersment_data($id1);
		if($rimdata)
		{
		//	$id=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date('Y-m-d'));
			 $idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date('Y-m-d'));
		$id=$idlist[0];
					$data=array(
					'voucherid'=>$id,
					'vouchercode'=>$idlist[1],
					'branch_code' => $this->session->userdata('branchid'),
					'ledger_id' => $rimdata->ledger_id,
					'payeecode' =>  $rimdata->apply_by,
					'payeename' => 'Home Lands Holding (Pvt) Ltd',
					'vouchertype' => 14,

					'paymentdes' => 'Pettycash Reimbursement on '.$rimdata->date,
					'amount' => $rimdata->amount,
					'applydate' =>date('Y-m-d'),
					'status' => 'CONFIRMED',


					);
					if(!$this->db->insert('ac_payvoucherdata', $data))
					{
							$this->db->trans_rollback();
								$this->logger->write_message("error", "Error confirming Project");
						return false;
					}
						$dataaa=array(
					'status' =>'CONFIRMED',
					'voucherid' =>$id,
					'confirm_by' =>$this->session->userdata('userid'),
					'confirm_date' =>date('Y-m-d'),


					);
					$this->db->where('id',$id1);
					$insert = $this->db->Update('ac_cashreimbursement', $dataaa);

		}
	}
	function get_cashadvance_reimbersment($rptid)
	{
		  	 $this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.branch,re_projectms.project_name,ac_cashsettlement.voucher_id');
			     $this->db->where('ac_cashadvance.reim_id',$rptid);
			  $this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			     $this->db->join('re_projectms','re_projectms.prj_id=ac_cashadvance.project_id','left');
			   $this->db->join('ac_cashsettlement','ac_cashsettlement.adv_id=ac_cashadvance.adv_id','left');
			   $this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function get_payment_reimbersment($rptid)
	{
		  	$this->db->select('ac_cashpayment_ontime.*,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->join('ac_cashadvance','ac_cashadvance.adv_id=ac_cashpayment_ontime.advance_id','left');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashpayment_ontime.officer_id');
			$this->db->where('ac_cashpayment_ontime.reim_id',$rptid);
				 $query = $this->db->get('ac_cashpayment_ontime');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}

	function get_pending_data_bybook($book_id,$rptdate)
	{
		  	 $this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.branch,re_projectms.project_name');
			 $this->db->where('ac_cashadvance.book_id',$book_id);
			  $this->db->where('ac_cashadvance.status','PAID');
			   $this->db->where('ac_cashadvance.pay_date <=',$rptdate);

			   $this->db->where('ac_cashadvance.rpt_status','PENDING');
			  $this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			   $this->db->join('re_projectms','re_projectms.prj_id=ac_cashadvance.project_id','left');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}

	function get_serial_code($idfield,$prifix,$table,$book_id)
	{

 		$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table." where book_id='".$book_id."'");

		$prifix='PV-';
		$newid="";

        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 $id=explode('-',$prjid);

			 if($data->id==NULL)
			 {
			 $newid=$prifix.str_pad(1, 5, "0", STR_PAD_LEFT);


			 }
			 else{
			// $prjid=substr($prjid,4,5);
			 $prjid=$id[1];
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=$prifix.str_pad($newid, 5, "0", STR_PAD_LEFT);


			 }
        }
		else
		{

		$newid=$prifix.str_pad(1, 5, "0", STR_PAD_LEFT);
		$newid=$newid;
		}
	return $newid;

	}
	function get_advance_data_reciept($entryid)
	{
		  	 $this->db->select('ac_cashadvance.*');
			     $this->db->where('ac_cashadvance.refund_entryid',$entryid);
			   $this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else
		return false;
	}


	//Ticket No-3002|Added By Uvini
	function get_payment_list_report($sup_code,$emp_no,$from_date,$to_date)
	{

		$this->db->select('ac_cashpayment_ontime.*,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->join('ac_cashadvance','ac_cashadvance.adv_id=ac_cashpayment_ontime.advance_id','left');
		$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashpayment_ontime.officer_id');
		if($sup_code != 'all')
			$this->db->where('ac_cashpayment_ontime.sup_code',$sup_code);
		if($emp_no != 'all')
			$this->db->where('ac_cashpayment_ontime.officer_id',$emp_no);
		if($from_date != 'all')
			$this->db->where('ac_cashpayment_ontime.paid_date >=',$from_date);
		if($to_date != 'all')
			$this->db->where('ac_cashpayment_ontime.paid_date <=',$to_date);


		$this->db->order_by('ac_cashpayment_ontime.paid_date', 'DESC');

		$query = $this->db->get('ac_cashpayment_ontime');
        if ($query->num_rows() > 0)
				return $query->result();
		else
			return false;
	}

	//Ticket No:3153 Added By Madushan 2021-07-21
	function get_ontimepayment_serial($direct_payid)
	{
		$this->db->select('serial_number');
		$this->db->where('id',$direct_payid);
		$query = $this->db->get('ac_cashpayment_ontime');
		if($query->num_rows>0)
			return $query->row()->serial_number;
		else
			return '';
	}

	//Ticket No:3298 Added By Madushan 2021-08-16
	function get_officer_branch($id)
	{
		$this->db->select('cm_branchms.branch_name');
		$this->db->join('hr_empmastr','hr_empmastr.branch = cm_branchms.branch_code');
		$this->db->where('hr_empmastr.id',$id);
		$query = $this->db->get('cm_branchms');
		if($query->num_rows>0)
			return $query->row()->branch_name;
		else
			return '';
	}

}
