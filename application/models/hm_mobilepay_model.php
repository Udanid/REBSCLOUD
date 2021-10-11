<?php

class hm_mobilepay_model extends CI_Model {

    function mobilepay_model()
    {
        parent::__construct();
    }



    function get_pending_incomes()
    {
        $options = array();
        $options[0] = "(Please Select)";
		$this->db->select('*');
		$this->db->where('hm_temp_table_andr.status',"PENDING");
		$ledger_q = $this->db->get('hm_temp_table_andr');
   //     $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
	 function get_project_payment_data_by_code($loancode)
    {
       $code=$loancode;
	  $myarr=array('project_name'=>'','lot_number'=>'','customer_name'=>'','pay_type'=>'');
	   if(strlen($code)==8)
	   {
		   $this->db->select('hm_resevation.*,hm_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,hm_prjaclotdata.lot_number,hm_prjaclotdata.plan_sqid');
		$this->db->join('hm_projectms','hm_projectms.prj_id=hm_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->where('hm_resevation.res_code',$loancode);
		$query = $this->db->get('hm_resevation');
				if ($query->num_rows() > 0){
				$data= $query->row();
				  $myarr=array('project_name'=>$data->project_name,'lot_number'=>$data->lot_number,'customer_name'=>$data->first_name.' '.$data->last_name,'pay_type'=>'Advance Payment');
				}


	   }
	   else
	   {
		  $this->db->select('hm_eploan.*,hm_resevation.prj_id,hm_resevation.pay_type,hm_resevation.discounted_price,hm_resevation.profit_status,hm_resevation.lot_id,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.id_number,hm_projectms.project_name,hm_prjaclotdata.lot_number,hm_prjaclotdata.plan_sqid,hm_prjaclotdata.lot_id');
		$this->db->where('hm_eploan.loan_code',$loancode);
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_eploan.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');
		$this->db->join('hm_projectms','hm_projectms.prj_id=hm_resevation.prj_id');
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$query = $this->db->get('hm_eploan');
		if ($query->num_rows() > 0){
		$data= $query->row();
				  $myarr=array('project_name'=>$data->project_name,'lot_number'=>$data->lot_number,'customer_name'=>$data->first_name.' '.$data->last_name,'pay_type'=>'Rental Payment');
		}


	   }
	   return $myarr;

    }
	 function get_mobilepaydata_id($tempId)
    {

		$this->db->where('hm_temp_table_andr.tempId',$tempId);
		$query = $this->db->get('hm_temp_table_andr');
				if ($query->num_rows() > 0){
				return $query->row();

				}
				else
				return false;



    }
	function get_resevationdata($rescode) { //get all stock
		$this->db->select('*');
		$this->db->where('res_code',$rescode);
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_re_ledgerset() { //get all stock
		$this->db->select('*');
			$query = $this->db->get('hm_lederset');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function add_advance($amount,$rescode,$temp_no,$temp_date)
	{
		$res_code=$rescode;
		$resdata=$this->get_resevationdata($res_code);
		$lederset=$this->get_re_ledgerset();
		$temp_date=date('Y-m-d',$temp_date);
		if($resdata->profit_status=='PENDING')
		$ledgerset=get_account_set('Advanced Payment');
		else
		$ledgerset=get_account_set('Advance Payment After Profit');
		$advanceCr=$ledgerset['Cr_account'];
		$advanceDr=$ledgerset['Dr_account'];


		$this->db->trans_start();
			$insert_data = array(
				'temp_code' =>  $resdata->res_code,
				'pri_id' =>$resdata->prj_id,
				'cus_code' =>$resdata->cus_code,
				'lot_id' =>$resdata->lot_id,
				'branch_code' => $resdata->branch_code,
				'income_type' =>'Advance Payment',
				'amount' => $amount,
				'income_date' =>$temp_date,
				 'temp_rct_no'=>$temp_no,
       			 'temp_income_date'=>$temp_date,
			);
			if ( ! $this->db->insert('hm_prjacincome', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Entry.', 'error');

				return;
			} else {
				$entry_id = $this->db->insert_id();
			}$retruncharge=get_pending_return_charge($resdata->cus_code);
			$payamount=$amount;
			if($retruncharge>0)
				{
					$payamount=$payamount-$retruncharge;
					$diledger=get_account_set('Checque Return Charge');
					//echo $diledger['Cr_account'];
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$diledger['Cr_account'],
					'dc_type' => 'C',
					'amount' =>$retruncharge,
					);
					if ( ! $this->db->insert('hm_incomentires', $insert_data))
						{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');

					return;
					}
				}
			//Document Fee insert

				$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
					'dc_type' => 'C',
					'amount' =>$payamount,
				);
				if ( ! $this->db->insert('hm_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceDr,
					'dc_type' => 'D',
					'amount' =>$amount,
				);
				if ( ! $this->db->insert('hm_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$pay_seq=$this->getsequense_pay('pay_seq',$resdata->res_code,'hm_saleadvance');
				$insert_data = array(
				    'pay_seq'=>$pay_seq,
					'res_code' =>$resdata->res_code,
					'pay_amount' =>$payamount,
					'rct_id' => $entry_id,
					'pay_date' =>$temp_date,
				);
				if ( ! $this->db->insert('hm_saleadvance', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$new_down=floatval($payamount)+floatval($resdata->down_payment);
				$outstad=floatval($resdata->total_out) - floatval($payamount);
		$data=array(
			'down_payment' => $new_down,
			'last_dpdate'=>$temp_date,
			'total_out' =>$outstad,
		);
		$this->db->where('res_code', $res_code);
		$insert = $this->db->update('hm_resevation', $data);
		$arrears=round($new_down-$resdata->discounted_price,2);
		if($arrears>0)
		{
			customer_arreaspayment($resdata->branch_code,$resdata->cus_code,$resdata->res_code,$resdata->lot_id,'',$arrears,$advanceCr,date('Y-m-d'),$entry_id);
		}


		return $entry_id;
	}
	function update_mobile_pay($tempid,$payid)
	{
			$data=array(
			'pay_id' => $payid,
			'status' =>'PAID',
		);
		$this->db->where('tempId', $tempid);
		$insert = $this->db->update('hm_temp_table_andr', $data);
	}
	function get_pending_reservations()
    {
        $options = array();
        $options[0] = "(Please Select)";
		$this->db->select('hm_temp_reserve_andr.*,hm_projectms.project_name,hm_prjaclotdata.lot_number');
		//$this->db->where('hm_temp_reserve_andr.status',"PENDING");
		$this->db->join('hm_projectms',"hm_projectms.project_code=hm_temp_reserve_andr.projectno");
		$this->db->join('hm_prjaclotdata',"hm_prjaclotdata.lot_id=hm_temp_reserve_andr.blockid");
		$ledger_q = $this->db->get('hm_temp_reserve_andr');
   //     $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
	function confirm_res($tempid)
	{
			$data=array(

			'status' =>'CONFIRMED',
		);
		$this->db->where('res_id', $tempid);
		$insert = $this->db->update('hm_temp_reserve_andr', $data);
	}
	function confirm_data_byid($tempid)
	{
			$this->db->select('hm_temp_reserve_andr.*');
		$this->db->where('res_id',$tempid);
		$ledger_q = $this->db->get('hm_temp_reserve_andr');
   //     $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->row();
        }else
            return false;
	}
	function getsequense_pay($res_seq,$where,$table)
	{
		 $query = $this->db->query("SELECT MAX(".$res_seq.") as id  FROM ".$table." where  	res_code='".$where."'");

        $newid="";

		$newid="";

        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=str_pad(1, 3, "0", STR_PAD_LEFT);


			 }
			 else{
			// $prjid=substr($prjid,3,4);
			 $id=intval($prjid);
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

}
