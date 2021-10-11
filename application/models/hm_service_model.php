<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_service_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

   
    function service_paymetnlist()
    {
      $this->db->select('hm_service_payments.*,hm_config_services.service_name,hm_projectms.project_name,hm_prjaclotdata.lot_number');
      $this->db->join('hm_config_services','hm_config_services.service_id = hm_service_payments.service_id');
      $this->db->join('hm_projectms','hm_projectms.prj_id = hm_service_payments.prj_id');
	   $this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id = hm_service_payments.lot_id');
       $query=$this->db->get('hm_service_payments');
      if(count($query->result())>0)
      {
        return $query->result();
      }else{
        return false;
      }
    }
function get_subcat_bylotid($lot_id)
    {
      $this->db->select('hm_config_boqsubcat.subcat_name,
      hm_config_boqsubcat.boqcat_id,
      hm_config_boqsubcat.subcat_code,
      hm_config_boqcat.cat_name,hm_config_boqcat.cat_name,hm_config_boqsubcat.boqsubcat_id');
      $this->db->join('hm_config_boqsubcat','hm_prjfboq.boqsubcat_id = hm_config_boqsubcat.boqsubcat_id','left');
      $this->db->join('hm_config_boqcat','hm_config_boqsubcat.boqcat_id = hm_config_boqcat.boqcat_id','left');
      $this->db->where('hm_prjfboq.lot_id',$lot_id);
      $this->db->group_by('hm_config_boqsubcat.boqsubcat_id');
      $query=$this->db->get('hm_prjfboq');
      if(count($query->result())>0)
      {
        return $query->result();
      }else{
        return false;
      }
    }
    
    function add_service_payment()
    {
		  $advance_id=$this->input->post('advance_id');
		  $advid=explode('-',$advance_id);
			$advance_id=$advid['0'];
		  if($advance_id!='')
		  $type='ADVANCE';
		  else
		  {
		  $type='DIRECT';
		  $advance_id=0;
		  }
	
		  $data = array(
			'service_id'=>$this->input->post('service_id'),
			'supplier_id'=>$this->input->post('supplier_id'),
			'pay_date'=>$this->input->post('pay_date'),
			'pay_amount'=>$this->input->post('pay_amount'),
			'prj_id'=>$this->input->post('prj_id'),
			'lot_id'=>$this->input->post('lot_id'),
			'subcat_id'=>$this->input->post('cat_id'),
			'type'=>$type,
			'discription'=>$this->input->post('discription'),
			'advance_id'=>$advance_id,
			'request_by'=>$this->session->userdata('userid'),
			'request_date'=>date('Y-m-d'));
	
		  $insert=$this->db->insert('hm_service_payments',$data);
		  $insert_id=$this->db->insert_id();
		  
		
		 return $insert_id;

    }

	 function delete($id)
	 {
		 $this->db->where('id',$id);
		 $insert=$this->db->delete('hm_service_payments');
		  return true;
	 }
	 function get_projectdata($id)
	{
		$this->db->select('*');
			$this->db->where('prj_id',$id);
			 $query = $this->db->get('hm_projectms');
        if ($query->num_rows() > 0) {

			return $query->row();

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

   function service_paymetn_data($id)
    {
      $this->db->select('hm_service_payments.*,hm_config_services.service_name,hm_projectms.project_name,hm_prjaclotdata.lot_number,cm_supplierms.first_name,cm_supplierms.last_name');
      $this->db->join('hm_config_services','hm_config_services.service_id = hm_service_payments.service_id');
      $this->db->join('hm_projectms','hm_projectms.prj_id = hm_service_payments.prj_id');
	   $this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id = hm_service_payments.lot_id');
	     $this->db->join('cm_supplierms','cm_supplierms.sup_code=hm_service_payments.supplier_id','left');
    
	   $this->db->where('hm_service_payments.id',$id);
       $query=$this->db->get('hm_service_payments');
      if(count($query->result())>0)
      {
        return $query->row();
      }else{
        return false;
      }
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
      function confirm($id)
      {
    	$paymentdata=$this->service_paymetn_data($id);
		$projectdata=$this->get_projectdata($paymentdata->prj_id);
		 $ledger_account=$projectdata->ledger_acc;
		if($paymentdata->type=='DIRECT')
		{
				$vouid=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date('Y-m-d'));// function in reaccount_helper
		   
				$voucherdata=array(
				'voucherid'=>$vouid,
				'refnumber'=>'',
				'branch_code' =>$this->session->userdata('branchid'),
				'ledger_id' =>$ledger_account,
				'prj_id'=>$paymentdata->prj_id,
				'payeecode'=>$paymentdata->supplier_id,
				'payeename' => $paymentdata->first_name.' '.$paymentdata->last_name ,
				'vouchertype' => '12',
				'paymentdes' => $paymentdata->discription,
				'amount' => $paymentdata->pay_amount,
				'applydate' =>date('Y-m-d'),
				'status' => 'CONFIRMED',
	
				);
				$this->db->insert('ac_payvoucherdata',$voucherdata);
				
				
      }
	  else
	  {
		  $adv_id=$paymentdata->advance_id;
		  $prj_id=$paymentdata->prj_id;
		  $advancedata=$this->get_cashadvancedata($paymentdata->advance_id);
			$vouid=$advancedata->payvoucher_id;
			$amount=$paymentdata->pay_amount;
			//print_r($advancedata) ;
			if($advancedata){

						$date=date('Y-m-d');
						$bookdata=$this->get_cashbook_data($advancedata->book_id);
						$crlist[0]['ledgerid']=$bookdata->ledger_id;
						$crlist[0]['amount']=$amount;
						$drlist[0]['ledgerid']=$ledger_account;
						$drlist[0]['amount']=$amount;
						$crtot=$drtot=$amount;
						$narration = $prj_id.'Project Service Payment with Cash Advance Settlement '  ;
						$int_entry=hm_jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$prj_id,'');// function in hmaccount_helper

						 $data=array(
							'voucher_id' =>$advancedata->payvoucher_id,
							'adv_id' =>$adv_id,
							'settledate' => $date,
							'settleamount' => $amount,
							'note' => $paymentdata->discription,
							'status' => 'CONFIRMED',
							'settle_entry_id'=>$int_entry,
							'ledgerid'=>$ledger_account,
							'confirm_by' =>$this->session->userdata('userid'),



							);
							$insert = $this->db->insert('ac_cashsettlement', $data);
							$entry_id = $this->db->insert_id();


								$tot=$advancedata->settled_amount+$amount;
								if($tot>=$advancedata->amount)
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
	  $dat1=array(
				'status' =>'CONFIRMED',
				'voucher_id'=>$vouid,
			'confirm_date' =>date('Y-m-d'),
			'confirm_by' =>$this->session->userdata('userid'),


			);
		$this->db->where('id',$id);
			$insert = $this->db->Update('hm_service_payments', $dat1);
	}
      /*dev nadee*/
      function get_subcontrac_supliers($prj_id,$service_id)
      {
        $this->db->select('hm_subcontractmain.*,cm_supplierms.sup_code,cm_supplierms.first_name,
        cm_supplierms.last_name,');
        $this->db->join('cm_supplierms','cm_supplierms.sup_code = hm_subcontractmain.sup_id','left');
        $this->db->where('hm_subcontractmain.prj_id',$prj_id);
        $this->db->where('hm_subcontractmain.service_id',$service_id);
        $query=$this->db->get('hm_subcontractmain');
        if(count($query->result())>0)
          {
            return $query->result();
          }else{
            return false;
          }
      }

      function add_subcontract_payment()
      {
        $data = array(
        'contract_id'=>$this->input->post('contract_id'),
        'payment_stage'=>$this->input->post('stage'),
        'pay_date'=>$this->input->post('pay_date'),
        'pay_amount'=>$this->input->post('amount'),
        'persentage'=>$this->input->post('percentage'),
        'create_by'=>$this->session->userdata('userid'));
        $insert=$this->db->insert('hm_subcontract_payment',$data);
        if($insert){
          return true;
        }else{
          return false;
        }

      }

      function get_subcontract_payment($pagination_counter, $page_count)
      {
        $this->db->select("hm_subcontract_payment.*,
        hm_subcontractmain.service_id,
        hm_subcontractmain.sup_id,
        hm_subcontractmain.agreed_amount,
        cm_supplierms.first_name,
        cm_supplierms.last_name,
        cm_supplierms.sup_code,
        hm_config_services.service_id,
        hm_config_services.service_name,hm_projectms.project_name,
        hm_projectms.project_code");
        $this->db->join('hm_subcontractmain','hm_subcontract_payment.contract_id = hm_subcontractmain.contract_id','left');
        $this->db->join('cm_supplierms','hm_subcontractmain.sup_id = cm_supplierms.sup_code','left');
        $this->db->join('hm_config_services','hm_subcontractmain.service_id = hm_config_services.service_id','left');
        $this->db->join('hm_projectms','hm_subcontractmain.prj_id = hm_projectms.prj_id','left');
        if($pagination_counter){
          $this->db->limit($pagination_counter, $page_count);
        }
        $this->db->order_by('hm_subcontract_payment.pay_id','DESC');
        $query = $this->db->get('hm_subcontract_payment');
      if(count($query->result())>0)
        {
          return $query->result();
        }else{
          return false;
        }
      }

      /*dev nadee get payment data by id*/
      function get_subcontract_payment_bypayid($payid)
      {
        $this->db->select("hm_subcontract_payment.*,
        hm_subcontractmain.service_id,
        hm_subcontractmain.sup_id,
        hm_subcontractmain.agreed_amount,
        cm_supplierms.first_name,
        cm_supplierms.last_name,
        cm_supplierms.sup_code,
        hm_config_services.service_id,
        hm_config_services.service_name,hm_projectms.project_name,
        hm_projectms.project_code");
        $this->db->join('hm_subcontractmain','hm_subcontract_payment.contract_id = hm_subcontractmain.contract_id','left');
        $this->db->join('cm_supplierms','hm_subcontractmain.sup_id = cm_supplierms.sup_code','left');
        $this->db->join('hm_config_services','hm_subcontractmain.service_id = hm_config_services.service_id','left');
        $this->db->join('hm_projectms','hm_subcontractmain.prj_id = hm_projectms.prj_id','left');
        $this->db->where('hm_subcontract_payment.pay_id',$payid);
        $query = $this->db->get('hm_subcontract_payment');
      if(count($query->result())>0)
        {
          return $query->row();
        }else{
          return false;
        }
      }

      /*dev nadee*/
      function confirm_subcontract_payment($id)
      {
        $pay_data=$this->get_subcontract_payment_bypayid($id);
        $agreed_amount=$pay_data->pay_amount;
        $sup_code=$pay_data->sup_code;
        $sup_name=$pay_data->first_name." ".$pay_data->last_name;
        $refnumber=$id;
        $prj_id=$pay_data->prj_id;
        $add_voucher=$this->add_vouchers($refnumber,$prj_id,$sup_code,$sup_name,$agreed_amount);
        if($add_voucher){
          $update = array('approved_by' =>$this->session->userdata('userid'),'status'=>'CONFIRM','voucher_id'=>$add_voucher );
          $this->db->where('pay_id',$id);
          $query=$this->db->update('hm_subcontract_payment',$update);
          if($query){
            return true;
          }else{
            return false;
          }
        }
      }

      /*dev nadee*/
      function delete_subcontract_payment($id)
      {
        $this->db->where('pay_id',$id);
        $delete=$this->db->delete('hm_subcontract_payment');
        if($delete)
        {
          return true;
        }else{
          return false;
        }
      }

      /*dev Nadee*/
      function update_subcontract_payment()
      {
        $id=$this->input->post('pay_id');
        $data = array(
        'payment_stage'=>$this->input->post('stage'),
        'pay_date'=>$this->input->post('pay_date'),
        'pay_amount'=>$this->input->post('amount'),
        'persentage'=>$this->input->post('percentage'),);
        $this->db->where('pay_id',$id);

        $update=$this->db->update('hm_subcontract_payment',$data);
        if($update){
          return true;
        }else{
          return false;
        }
      }


}
