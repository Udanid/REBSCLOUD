<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class tax_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_vat_rates()
	{ 
		$this->db->select('*');
		//$this->db->order_by('product_code,task_code');
		
		$query = $this->db->get('cm_vatconfig'); 
		return $query->result(); 
	}
	function get_esp_rates()
	{
		$this->db->select('*');
		//$this->db->order_by('product_code,task_code');
		
		$query = $this->db->get('cm_espconfig'); 
		return $query->result(); 
	}
	function is_inserted($year,$month,$m_half)
	{
		$this->db->select('*');
			$this->db->where('year',$year);
				$this->db->where('month',$month);
					$this->db->where('m_half',$m_half);
		$query = $this->db->get('cm_vatconfig'); 
			if ($query->num_rows() > 0){
				
				return false;
			}
			else
			return true;
	
		
	}
	function add_vat($year,$month,$m_half,$startdate,$enddate,$rate)
	{
	
			 $data=array( 
		  'year' => $year,
			 'month' =>$month,
		'm_half' =>$m_half ,
			'startdate' =>$startdate ,
		'enddate' =>$enddate ,
			'rate' =>$rate ,
		'create_by' =>$this->session->userdata('userid'),
		'create_date' =>date('Y-m-d') ,
		
		
		  );
		
		
		$insert = $this->db->insert('cm_vatconfig', $data);
		return $insert;
		
	}
	function get_vat_rates_bycode($id)
	{
		$this->db->select('*');
			$this->db->where('id',$id);
			$query = $this->db->get('cm_vatconfig'); 
			if ($query->num_rows() > 0){
				
				return $query->row();
			}
			else
			return false;
	}
		function edit_vat()
	{
	
			 $data=array( 
		  
		  'rate' => $this->input->post('rate'),
	
		
		  );
		
		$this->db->where('id', $this->input->post('id'));
		$insert = $this->db->update('cm_vatconfig', $data);
		return $insert;
		
	}
	function delete_year_vat($year)
	{
	
		
		$this->db->where('year', $year);
		$insert = $this->db->delete('cm_vatconfig', $data);
		return $insert;
		
	}
function is_inserted_esp($year,$quoter)
	{
		$this->db->select('*');
		$this->db->where('year',$year);
		$this->db->where('quoter',$quoter);
				
		$query = $this->db->get('cm_espconfig'); 
			if ($query->num_rows() > 0){
				
				return false;
			}
			else
			return true;
	
		
	}
	function add_esp($year,$quoter,$startdate,$enddate,$rate)
	{
	
			 $data=array( 
		  'year' => $year,
			 'quoter' =>$quoter,
		
			'startdate' =>$startdate ,
		'enddate' =>$enddate ,
			'rate' =>$rate ,
		'create_by' =>$this->session->userdata('userid'),
		'create_date' =>date('Y-m-d') ,
		
		
		  );
		
		
		$insert = $this->db->insert('cm_espconfig', $data);
		return $insert;
		
	}
	function get_esp_rates_bycode($id)
	{
		$this->db->select('*');
			$this->db->where('id',$id);
			$query = $this->db->get('cm_espconfig'); 
			if ($query->num_rows() > 0){
				
				return $query->row();
			}
			else
			return false;
	}
		function edit_esp()
	{
	
			 $data=array( 
		  
		  'rate' => $this->input->post('rate'),
	
		
		  );
		
		$this->db->where('id', $this->input->post('id'));
		$insert = $this->db->update('cm_espconfig', $data);
		return $insert;
		
	}
	function get_project_lots($code) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);
	
		$this->db->order_by('lot_number');
		
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjaclotdata'); 
		return $query->result(); 
    }
	function get_all_project_confirmed() { //get all stock
		$this->db->select('re_projectms.project_name,re_projectms.prj_id,re_projectms.project_code,re_projectms.selable_area,re_projectms.price_status,re_projectms.status,hr_empmastr.surname,hr_empmastr.initial');
		
		$this->db->where('re_projectms.price_status',CONFIRMKEY);;
		$this->db->join('hr_empmastr','hr_empmastr.id=re_projectms.officer_code','left');
		$this->db->order_by('re_projectms.prj_id','DESC');
		
		$query = $this->db->get('re_projectms'); 
		return $query->result(); 
    }
	function update_market()
	{
		$prj_id=$this->input->post('prj_id');
		$blocklist=$this->get_project_lots($prj_id);
		if($blocklist)
		{
			foreach($blocklist as $raw)
			{
				
				 $data=array( 
		  
				  'market_val' => $this->input->post('marketprice'.$raw->lot_id),
	
		
			  );
		
				$this->db->where('lot_id', $raw->lot_id);
				$insert = $this->db->update('re_prjaclotdata', $data);
			}
		}
	}
	function get_esp_rates_bycode_year_quotare($year,$quoter)
	{
		$this->db->select('*');
			$this->db->where('year',$year);
			$this->db->where('quoter',$quoter);
			$query = $this->db->get('cm_espconfig'); 
			if ($query->num_rows() > 0){
				
				return $query->row();
			}
			else
			return false;
	}
	function get_vat_rates_bycode_year_month($year,$month,$m_half)
	{
		$this->db->select('*');
			$this->db->where('year',$year);
				$this->db->where('month',$month);
					$this->db->where('m_half',$m_half);
		$query = $this->db->get('cm_vatconfig'); 
			if ($query->num_rows() > 0){
				
				return $query->row();
			}
			else
			return false;
	}
	function get_ep_settle_list($prj_id,$stardate,$enddate)
	{
		$this->db->select('re_eprebate.*,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_resevation.discounted_price');
		$this->db->join('re_resevation','re_resevation.res_code=re_eprebate.res_code');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		
		
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_eprebate.apply_date >=',$stardate);
		$this->db->where('re_eprebate.apply_date <=',$enddate);
		
		
		$query = $this->db->get('re_eprebate'); 
		if ($query->num_rows() > 0){
	 
		return $query->result(); 
		}
		else
		return false;
	}
	function get_ep_settle_list_new($prj_id,$stardate,$enddate)
	{
		$this->db->select('re_eploan.*,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_resevation.discounted_price,MAX(ac_entries.date) as apply_date2');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
			$this->db->join('re_prjacincome','re_prjacincome.temp_code=re_eploan.loan_code');
			$this->db->join('ac_entries','ac_entries.id=re_prjacincome.entry_id');
		
	$this->db->where('re_eploan.loan_status','SETTLED');
		$this->db->where('re_resevation.res_status !=','REPROCESS');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('ac_entries.date >=',$stardate);
		$this->db->where('ac_entries.date <=',$enddate);
			$this->db->group_by('re_prjacincome.temp_code');
		
		
		$query = $this->db->get('re_eploan'); 
		if ($query->num_rows() > 0){
	 
		return $query->result(); 
		}
		else
		return false;
	}
	
	function get_advance_settlelist($prj_id,$stardate,$enddate)
	{
		$this->db->select('re_settlement.*,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_resevation.discounted_price,re_resevation.last_dpdate');
		$this->db->join('re_resevation','re_resevation.res_code=re_settlement.res_code');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		
		
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.last_dpdate >=',$stardate);
		$this->db->where('re_resevation.last_dpdate <=',$enddate);
		
		
		$query = $this->db->get('re_settlement'); 
		if ($query->num_rows() > 0){
	 
		return $query->result(); 
		}
		else
		return false;
	}
	function get_period_income_list($stardate,$enddate)
	{
		$this->db->select('re_resevation.*,re_projectms.project_name,re_prjaclotdata.market_val,re_prjaclotdata.lot_number,re_prjaclotdata.extend_perch,re_prjacincome.id');
		$this->db->join('re_resevation','re_resevation.prj_id=re_prjacincome.pri_id and re_resevation.lot_id=re_prjacincome.lot_id'); 		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_prjacincome.lot_id');
			$this->db->join('re_projectms','re_projectms.prj_id=re_prjacincome.pri_id');
			$this->db->join('ac_entries',"ac_entries.id=re_prjacincome.entry_id",'left');
			$this->db->where('ac_entries.date >=',$stardate);
		$this->db->where('ac_entries.date <=',$enddate);
		$this->db->order_by('re_prjacincome.pri_id,re_prjacincome.lot_id');
	
			$query = $this->db->get('re_prjacincome'); 
		if ($query->num_rows() > 0){
	 
		return $query->result(); 
		}
		else
		return false;
	}
	function advance_payment_period_date($res_code,$stardate,$enddate)
	{
		$this->db->select('SUM(pay_amount) as payment');
			$this->db->join('re_prjacincome',"re_saleadvance.rct_id=re_prjacincome.id");
		$this->db->join('ac_entries',"ac_entries.id=re_prjacincome.entry_id",'left');
		
		$this->db->where('re_saleadvance.res_code',$res_code);
		$this->db->where('ac_entries.date >=',$stardate);
		$this->db->where('ac_entries.date <=',$enddate);
		$query = $this->db->get('re_saleadvance'); 
		if ($query->num_rows() > 0){
			$data= $query->row();
		return  $data->payment;
		
		}
		else
		return 0;
	}
	function loan_payment_befoer_date($res_code,$stardate,$enddate)
	{
		$this->db->select('SUM(cap_amount) as sum_cap');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
			$this->db->join('re_prjacincome',"re_eploanpayment.rct_id=re_prjacincome.id");
		$this->db->join('ac_entries',"ac_entries.id=re_prjacincome.entry_id",'left');
		
		$this->db->where('re_eploan.res_code',$res_code);
		$this->db->where('ac_entries.date >=',$stardate);
		$this->db->where('ac_entries.date <=',$enddate);
		
	
		$query = $this->db->get('re_eploanpayment'); 
		if ($query->num_rows() > 0){
			$data= $query->row();
		return $data->sum_cap;
		
		}
		else
		return 0;
	}	
	function loan_settlepayment_month($loan_code,$start_date,$enddate)
	{
		//$loandata=$this->get_loandata_loancode($loan_code);
		$this->db->select('balance_capital as sum_cap,balance_int as sum_int');
		$this->db->where('re_eprebate.res_code',$loan_code);
			//$this->db->where('re_eprebate.reschdue_sqn',$loandata->reschdue_sqn);
		$this->db->where('re_eprebate.confirm_date >=',$start_date);
		$this->db->where('re_eprebate.confirm_date <=',$enddate);
		$query = $this->db->get('re_eprebate'); 
		if ($query->num_rows() > 0){
			$data= $query->row();
		return $data->sum_cap;
		
		
		}
		else
		return 0;
	}//  provition Reports
	
	function get_period_invoice_list($startdate,$enddate) { //get all stock
		$this->db->select('ac_invoices.*,cm_supplierms.first_name,cm_supplierms.last_name,cm_supplierms.sup_tin,SUM(ac_invoicepayments.pay_amount) as totpay');
		$this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
		$this->db->join('ac_invoicepayments','ac_invoicepayments.invoice_id=ac_invoices.id','left');
		$this->db->where('ac_invoices.date >=',$startdate);
		$this->db->where('ac_invoices.date <=',$enddate);
		$this->db->where('ac_invoices.vat_amount >',0);
		$this->db->group_by('ac_invoices.id');
		$this->db->group_by('ac_invoicepayments.invoice_id');
		$query = $this->db->get('ac_invoices'); 
		return $query->result(); 
    }	
	function get_period_advance_resale($stardate,$enddate)
	{
		$this->db->select('re_resevation.*,re_prjaclotdata.market_val,re_prjaclotdata.lot_number,re_prjaclotdata.extend_perch,re_projectms.project_name,re_adresale.confirm_date');
		$this->db->join('re_resevation','re_resevation.res_code=re_adresale.res_code'); 		
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		
		$this->db->where('re_adresale.confirm_date >=',$stardate);
		$this->db->where('re_adresale.confirm_date <=',$enddate);
		$this->db->order_by('re_resevation.prj_id');
		$query = $this->db->get('re_adresale'); 
		if ($query->num_rows() > 0){
			//$data= $query->row();
		return   $query->result();
		
		}
		else
		return false;
	}
	function get_period_loan_resale($stardate,$enddate)
	{
		$this->db->select('re_resevation.*,re_prjaclotdata.market_val,re_prjaclotdata.lot_number,re_prjaclotdata.extend_perch,re_projectms.project_name,re_epresale.confirm_date,SUM(re_eploanpayment.cap_amount) as totcap,re_epresale.loan_amount,re_epresale.paid_capital');
		$this->db->join('re_resevation','re_resevation.res_code=re_epresale.res_code'); 		
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('re_eploanpayment','re_eploanpayment.loan_code=re_epresale.loan_code');
		
		$this->db->where('re_epresale.confirm_date >=',$stardate);
		$this->db->where('re_epresale.confirm_date <=',$enddate);
		$this->db->order_by('re_resevation.prj_id');
		$this->db->group_by('re_eploanpayment.loan_code');
		$query = $this->db->get('re_epresale'); 
		if ($query->num_rows() > 0){
			//$data= $query->row();
		return   $query->result();
		
		}
		else
		return false;
	}
}