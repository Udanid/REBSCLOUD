<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Summery_model extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->helper('url');
    }
	function today_cash_sales_sum()
	{
		$this->db->select('SUM(BLLGTOT) as tot');
		$this->db->where('BLLTIME >=',date('Y-m-d')." 00-00-00");
		$this->db->where('BLLTIME <=',date('Y-m-d')." 24-00-00");
		
		$query = $this->db->get('salesbll'); 
		if ($query->num_rows() > 0){
			$val=$query->row();
		//	print_r($val);
			return $val->tot; 
		}else
			return 0;
			
	}
	function today_credit_sales_sum()
	{
		$this->db->select('SUM(CRBLLGTOT) as tot');
		$this->db->where('CRBLLTIME >=',date('Y-m-d')." 00-00-00");
		$this->db->where('CRBLLTIME <=',date('Y-m-d')." 24-00-00");
		
		$query = $this->db->get('salescrbll'); 
		if ($query->num_rows() > 0){
			$val=$query->row();
		//	print_r($val);
			return $val->tot; 
		}else
			return 0;
			
	}
	function get_months()
	{
		$first  = strtotime('first day this month');
		$months = array();

		for ($i = 6; $i >= 0; $i--) {
		  array_push($months, date('M', strtotime("-$i month", $first)));
		}

			return $months;
	}
	
	function get_month_sales_category($cat)
	{
		$first  = strtotime('first day this month');
		$months = array();

		for ($i = 6; $i >= 0; $i--) {
		  array_push($months, date('m', strtotime("-$i month", $first)));
		}
		
		$currentmonth=date('m');
		$currentyear=date('Y');
		$privisyear=date("Y",strtotime("-1 year"));
		for($i=0; $i<count($months); $i++)
		{
			if($months[$i]>$currentmonth)
			{
				$fromdate=$privisyear."-".$months[$i]."-".'01';
				$todate=$privisyear."-".$months[$i]."-".'31';
			}
			else
			{
				$fromdate=$currentyear."-".$months[$i]."-".'01';
				$todate=$currentyear."-".$months[$i]."-".'31';
			}
			$cashsales=$this->get_givenmonth_cat_sale_cash($cat,$fromdate,$todate);
			$creditsales=$this->get_givenmonth_cat_sale_credit($cat,$fromdate,$todate);
			
			$sales[$i]=$cashsales+$creditsales;
		}
		return $sales;
	}
	function get_givenmonth_cat_sale_credit($cat,$fromdate,$todate)
	{
		$this->db->select('SUM(salesitem.ITMGTOT) as tot');
		$this->db->join('salesitem','salesitem.POSBN=salescrbll.CRBLLNO');
		$this->db->join('itmms','itmms.ITMCODE=salesitem.ITMCODE');
		$this->db->where('CRBLLTIME >=',$fromdate." 00-00-00");
		$this->db->where('CRBLLTIME <=',$todate." 24-00-00");
		$this->db->where('itmms.ITMCAT',$cat);
		$query = $this->db->get('salescrbll'); 
		if ($query->num_rows() > 0){
			$val=$query->row();
		//	print_r($val);
			return $val->tot; 
		}else
			return 0;
	}
	function get_givenmonth_cat_sale_cash($cat,$fromdate,$todate)
	{
		$this->db->select('SUM(salesitem.ITMGTOT) as tot');
		$this->db->join('salesitem','salesitem.POSBN=salesbll.BLLNO');
		$this->db->join('itmms','itmms.ITMCODE=salesitem.ITMCODE');
		$this->db->where('BLLTIME >=',$fromdate." 00-00-00");
		$this->db->where('BLLTIME <=',$todate." 24-00-00");
		$this->db->where('itmms.ITMCAT',$cat);
		$query = $this->db->get('salesbll'); 
		if ($query->num_rows() > 0){
			$val=$query->row();
		//	print_r($val);
			return $val->tot; 
		}else
			return 0;
	}
	function get_month_sales_cash()
	{
		$first  = strtotime('first day this month');
		$months = array();

		for ($i = 6; $i >= 0; $i--) {
		  array_push($months, date('m', strtotime("-$i month", $first)));
		}
		
		$currentmonth=date('m');
		$currentyear=date('Y');
		$privisyear=date("Y",strtotime("-1 year"));
		for($i=0; $i<count($months); $i++)
		{
			if($months[$i]>$currentmonth)
			{
				$fromdate=$privisyear."-".$months[$i]."-".'01';
				$todate=$privisyear."-".$months[$i]."-".'31';
			}
			else
			{
				$fromdate=$currentyear."-".$months[$i]."-".'01';
				$todate=$currentyear."-".$months[$i]."-".'31';
			}
				$this->db->select('SUM(BLLGTOT) as tot');
				$this->db->where('BLLTIME >=',$fromdate." 00-00-00");
				$this->db->where('BLLTIME <=',$todate." 24-00-00");
		
				$query = $this->db->get('salesbll'); 
					if ($query->num_rows() > 0){
							$arr=$query->row();
							$val=$arr->tot; 
		//	print_r($val);
							
						}else
							$val= 0;
			if(!$val)
			$val=0;
			$sales[$i]=$val;
		}
		return $sales;
	}
	function get_month_sales_credit()
	{
		$first  = strtotime('first day this month');
		$months = array();

		for ($i = 6; $i >= 0; $i--) {
		  array_push($months, date('m', strtotime("-$i month", $first)));
		}
		
		$currentmonth=date('m');
		$currentyear=date('Y');
		$privisyear=date("Y",strtotime("-1 year"));
		for($i=0; $i<count($months); $i++)
		{
			if($months[$i]>$currentmonth)
			{
				$fromdate=$privisyear."-".$months[$i]."-".'01';
				$todate=$privisyear."-".$months[$i]."-".'31';
			}
			else
			{
				$fromdate=$currentyear."-".$months[$i]."-".'01';
				$todate=$currentyear."-".$months[$i]."-".'31';
			}
				$this->db->select('SUM(CRBLLGTOT) as tot');
		$this->db->where('CRBLLTIME >=',$fromdate." 00-00-00");
		$this->db->where('CRBLLTIME <=',$todate." 24-00-00");
		
		$query = $this->db->get('salescrbll'); 
					if ($query->num_rows() > 0){
							$arr=$query->row();
							$val=$arr->tot; 
		//	print_r($val);
							
						}else
							$val= 0;
			if(!$val)
			$val=0;
			$sales[$i]=$val;
		}
		return $sales;
	}
	function today_purchase_sum()
	{
		$this->db->select('SUM(TOTAMOUNT) as tot');
		$this->db->where('PODATE >=',date('Y-m-d')." 00-00-00");
		$this->db->where('PODATE <=',date('Y-m-d')." 24-00-00");
		
		$query = $this->db->get('pomaster'); 
		if ($query->num_rows() > 0){
			$val=$query->row();
		//	print_r($val);
			return $val->tot; 
		}else
			return 0;
			
	}
	function max_billno() { 
		$this->db->select_max('BLLNO');
		$query = $this->db->get('salesbll');
		return $query->result();
    }
	
	function get_invoice($invno){
		$this->db->select('salesitem.ITMGTOT,salesitem.ITMCNT,salesitem.ITMUPRS,salesitem.ITMTOT,salesitem.ITMDSC,itmms.ITMDIS,itmbrd.BRDNAME');
		$this->db->join('itmms','itmms.ITMCODE = salesitem.ITMCODE');
		$this->db->join('itmbrd', 'itmbrd.BRDCODE = itmms.ITMBRD');
		$this->db->where('salesitem.POSBN',$invno);
		$this->db->order_by('salesitem.POSID','acs');
		$query = $this->db->get('salesitem'); 
		return $query->result(); 	 		
	}
	
	
	
	
	
	function all_invs(){
		$this->db->select('salesbll.*');
		$this->db->order_by('salesbll.BLLNO','desc');
		$query = $this->db->get('salesbll'); 
		return $query->result(); 
	}
	
	function all_crdinvs(){
		$this->db->select('salescrbll.*');
		$this->db->order_by('salescrbll.CRBLLNO','desc');
		$query = $this->db->get('salescrbll'); 
		return $query->result(); 
	}
	
	function sales_by_invno($invno){
		$this->db->select('salesitem.POSID,salesitem.ITMCODE,salesitem.ITMGTOT,salesitem.ITMCNT,salesitem.ITMUPRS,salesitem.ITMTOT,salesitem.ITMDSC,itmms.ITMDIS,itmbrd.BRDNAME');
		$this->db->join('itmms','itmms.ITMCODE = salesitem.ITMCODE');
		$this->db->join('itmbrd', 'itmbrd.BRDCODE = itmms.ITMBRD');
		$this->db->where('salesitem.POSBN',$invno);
		$this->db->order_by('salesitem.POSID','desc');
		$query = $this->db->get('salesitem'); 
		return $query->result(); 
	}
	
	function total_by_invno($invno){
		$result = substr($invno, 0, 2);
		
		if ($result=='CR'){
			$this->db->select('salescrbll.CRBLLGTOT AS Total,salescrbll.ADDIS AS Discount');
			$this->db->where('salescrbll.CRBLLNO',$invno);
			$query = $this->db->get('salescrbll'); 
			return $query->row(); 
		}else{
			$this->db->select('salesbll.BLLGTOT AS Total,salesbll.ADDIS AS Discount');
			$this->db->where('salesbll.BLLNO',$invno);
			$query = $this->db->get('salesbll'); 
			return $query->row(); 
		}
		
	}
	function fullinvoicedata_by_invno($invno){
		$result = substr($invno, 0, 2);
		
		if ($result=='CR'){
			$this->db->select('salescrbll.CRBLLTIME as BLLTIME,salescrbll.CRBLLTOT as BLLTOT,salescrbll.CRBLLDIS as BLLDIS,salescrbll.CRBLLGTOT as BLLGTOT,dbtms.DBTNAME as name');
			$this->db->where('salescrbll.CRBLLNO',$invno);
			$this->db->join('dbtms','dbtms.DBTCODE=salescrbll.DBTCODE','left');
			$query = $this->db->get('salescrbll'); 
			return $query->row(); 
		}else{
			$this->db->select('salesbll.*,dbtms.DBTNAME as name');
			$this->db->join('dbtms','dbtms.DBTCODE=salesbll.DBTCODE','left');
			$this->db->where('salesbll.BLLNO',$invno);
			$query = $this->db->get('salesbll'); 
			return $query->row(); 
		}
		
	}
	
	function get_sup_inv($dealercode){
		$this->db->select('stockreceive.RCVCODE');
		$this->db->where('stockreceive.DLRCODE',$dealercode);
		$this->db->order_by('stockreceive.RCVCODE','desc');
		$this->db->group_by('stockreceive.RCVCODE');
		$query = $this->db->get('stockreceive'); 
		return $query->result(); 
	}
	
	function get_max_creditinv(){
		$this->db->select_max('CRBLLNO');
		$query = $this->db->get('salescrbll');
		return $query->result();
	}
	
	function other_data_inv($invno){
		$this->db->select('salesbll.BLLNO,salesbll.BLLTIME,salesbll.BLLTOT,salesbll.ADDIS,salesbll.BLLGTOT,salesbll.DBTCODE,dbtms.DBTNAME,dbtms.DBTADD');
		$this->db->join('dbtms','dbtms.DBTCODE = salesbll.DBTCODE');
		$this->db->where('salesbll.BLLNO',$invno);
		$this->db->limit(1);
		$query = $this->db->get('salesbll'); 
		return $query->row();
	}
	
	
}