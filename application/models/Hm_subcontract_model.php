<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_subcontract_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*2020-01-13 create by nadee*/
    function get_subcat_bylotid($lot_id)
    {
      $this->db->select('hm_prjfboq.*,hm_config_boqsubcat.subcat_name,
      hm_config_boqsubcat.boqcat_id,
      hm_config_boqsubcat.subcat_code,
      hm_config_boqcat.cat_name');
      $this->db->join('hm_config_boqsubcat','hm_prjfboq.boqsubcat_id = hm_config_boqsubcat.boqsubcat_id','left');
      $this->db->join('hm_config_boqcat','hm_config_boqsubcat.boqcat_id = hm_config_boqcat.boqcat_id','left');
      $this->db->where('hm_prjfboq.lot_id',$lot_id);
      $this->db->group_by('hm_config_boqsubcat.boqcat_id');
      $query=$this->db->get('hm_prjfboq');
      if(count($query->result())>0)
      {
        return $query->result();
      }else{
        return false;
      }
    }

    function get_task_bysubcat($sub_id,$lot_id)
    {
      $this->db->select('hm_prjfboq.*');
      $this->db->where('hm_prjfboq.boqsubcat_id',$sub_id);
      $this->db->where('hm_prjfboq.lot_id',$lot_id);
      $query=$this->db->get('hm_prjfboq');
      if(count($query->result())>0)
      {
        return $query->result();
      }else{
        return false;
      }
    }

    /*dev nadee*/
    function add_subcontract($suplier_data)
    {
      $sup_id=$this->input->post('supplier_id');
      $service_id=$this->input->post('service_id');
      $contract_startdate=$this->input->post('date');
      $contract_period=$this->input->post('con_period');
      $agreed_amount=$this->input->post('agreed_amount');
      $mobilization_charge=$this->input->post('mob_charge');
      $retaining_period=$this->input->post('retain_period');
      $retaining_rate=$this->input->post('retain_rate');
      $agreement_copy=$this->input->post('agreement_copy');
      $added_by=$this->session->userdata('userid');
      $added_at=date('Y-m-d');

      $data = array(
        'sup_id'=>$sup_id,
        'service_id'=>$service_id,
        'contract_startdate'=>$contract_startdate,
        'contract_period'=>$contract_period,
        'agreed_amount'=>$agreed_amount,
        'mobilization_charge'=>$mobilization_charge,
        'retaining_period'=>$retaining_period,
        'retaining_rate'=>$retaining_rate,
        'agreement_copy'=>$agreement_copy,
        'added_by'=>$added_by,
        'added_at'=>$added_at,);

      $hm_subcontractmain=$this->db->insert('hm_subcontractmain',$data);
      $hm_subcontractmain_id=$this->db->insert_id();
      $lotviewcount=$this->input->post('lotviewcount');
      if($hm_subcontractmain){
      if($lotviewcount>0){
        for($i=1;$lotviewcount>=$i;$i++){
          $hm_subcontractdata_data = array(
          'contract_id'=>$hm_subcontractmain_id,
          'project_id'=>$this->input->post('prj_id'),
          'lot_id'=>$this->input->post('lot_id'.$i),);
          $hm_subcontractdata=$this->db->insert('hm_subcontractdata',$hm_subcontractdata_data);
          $hm_subcontractdata_id=$this->db->insert_id();
          $subcatviewcount=$this->input->post('subcatviewcount'.$i);
          for($p=1;$subcatviewcount>=$p;$p++)
          {
            $hm_subcontracttask_data = array(
              'data_id'=>$hm_subcontractdata_id,
              'subcat_id'=>$this->input->post('cat_id'.$i.$p),
              'task_id'=>$this->input->post('task_id'.$i.$p),
              'agreed_amount'=>$this->input->post('task_ageed_amt'.$i.$p),);

            $hm_subcontracttask=$this->db->insert('hm_subcontracttask',$hm_subcontracttask_data);
          }

        }
      }

      /*add Payment data*/



        return true;
      }else{
        return false;
      }


    }

    function get_subcontractdata($pagination_counter, $page_count)
    {
      $this->db->select('*');
      $this->db->from('hm_subcontractmain');
      $this->db->join('cm_supplierms','cm_supplierms.sup_code=hm_subcontractmain.sup_id','left');
      $this->db->join('hm_config_services','hm_config_services.service_id=hm_subcontractmain.service_id','left');


      $this->db->order_by('hm_subcontractmain.contract_id','DESC');

      if($pagination_counter){
        $this->db->limit($pagination_counter, $page_count);
      }
      $query = $this->db->get();
    if(count($query->result())>0)
      {
        return $query->result();
      }else{
        return false;
      }
    }

    /*dev nadee*/
    function get_subcontract_lotdata($contract_id)
    {
      $this->db->select('hm_subcontractdata.*,hm_projectms.project_name,hm_prjaclotdata.lot_number');

      $this->db->join('hm_projectms','hm_subcontractdata.project_id = hm_projectms.prj_id','left');
      $this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id = hm_subcontractdata.lot_id','left');
      $this->db->where('contract_id',$contract_id);
      $query=$this->db->get('hm_subcontractdata');
      if(count($query->result())>0)
        {
          return $query->result();
        }else{
          return false;
        }
    }

    /*dev nadee*/
    function get_task_bycontract($condata_id)
    {
      $this->db->select('hm_subcontracttask.*,hm_config_boqsubcat.subcat_name,
          hm_config_boqsubcat.subcat_code,
          hm_prjfboq.description');
      $this->db->join('hm_config_boqsubcat','hm_subcontracttask.subcat_id = hm_config_boqsubcat.boqsubcat_id','left');
      $this->db->join('hm_prjfboq','hm_subcontracttask.agreed_amount = hm_prjfboq.id','left');
      $this->db->where('hm_subcontracttask.data_id',$condata_id);
      $query=$this->db->get('hm_subcontracttask');
      if(count($query->result())>0)
        {
          return $query->result();
        }else{
          return false;
        }
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
      /*sun contract payment*/
      /*dev nadee*/
      function add_vouchers($refnumber,$prj_id,$sup_code,$sup_name,$agreed_amount)
      {
        //add payment vocher for mobilization_charge
		$projectdata=$this->get_projectdata($prj_id);
		 $ledger_account=$projectdata->ledger_acc;
        $vouid=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date('Y-m-d'));
       	$voucherdata=array(
    		'voucherid'=>$vouid,
    		'refnumber'=>$refnumber,
    		'branch_code' =>$this->session->userdata('branchid'),
    		'ledger_id' =>$ledger_account,
     		 'prj_id'=>$prj_id,
       		 'payeecode'=>$sup_code,
    		'payeename' => $sup_name ,
    		'vouchertype' => '3',
    		'paymentdes' => 'Sub Conctract Payment',
    		'amount' => $agreed_amount,
    		'applydate' =>date('Y-m-d'),
    		'status' => 'CONFIRMED',

    		);
    		if(!$this->db->insert('ac_payvoucherdata', $voucherdata))
    		{
    				$this->db->trans_rollback();
    					$this->logger->write_message("error", "Error confirming Project");
    			return false;
    		}else{
          return $vouid;
        }
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
