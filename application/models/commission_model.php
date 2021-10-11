<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Commission_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_commission_cat() { 
		$this->db->select('*');
		$this->db->order_by('year','DESC');
		$this->db->order_by('id');
		$query = $this->db->get('re_commision_configcat'); 
		return $query->result(); 
    }
	
		function get_commission_cat_year($year) { 
		$this->db->select('*');
		//$this->db->where('year',$year);
		$this->db->order_by('id');
		$query = $this->db->get('re_commision_configcat'); 
		return $query->result(); 
    }
	function get_commission_cat_id($id) { 
		$this->db->select('*');
		$this->db->where('id',$id);
		$this->db->order_by('id');
		$query = $this->db->get('re_commision_configcat'); 
		return $query->row(); 
    }
function get_commission_rate_by_catid_tableid($cat_id,$table_id,$year) { 
		$this->db->select('rate,status,rate_type');
		$this->db->where('cat_id',$cat_id);
		$this->db->where('table_id',$table_id);
		$this->db->where('year',$year);
		
		$query = $this->db->get('re_commision_configrate'); 
		  if ($query->num_rows() > 0) {
			  
		$data= $query->row(); 
		return $query->row(); 
		  }
		  else
		  return false;
    }
	function get_commission_rate_by_catid_tableid_rate($cat_id,$table_id,$year) { 
		$this->db->select('rate,status');
		$this->db->where('cat_id',$cat_id);
		$this->db->where('table_id',$table_id);
		$this->db->where('year',$year);
		
		$query = $this->db->get('re_commision_configrate'); 
		  if ($query->num_rows() > 0) {
			  
		$data= $query->row(); 
		return $data->rate; 
		  }
		  else
		  return false;
    }
	function add_range()
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		'year' => $this->input->post('year'),
		'start_range' => $this->input->post('start_range'),
		'end_range' => $this->input->post('end_range'),
		'create_by' => $this->session->userdata('userid'),
		'create_date' =>date("Y-m-d"),
	
		
		);
		$insert = $this->db->insert('re_commision_configcat', $data);
		$row = $this->db->query('SELECT MAX(type_id) AS `maxid` FROM `ac_cashbooktypes`')->row();
		return $row->maxid;
		
	}
	
	
	function delete_range($id)
	{
		//$tot=$bprice*$quontity; 
		if($id)
		{
		$this->db->where('id', $id);
		$insert = $this->db->delete('re_commision_configcat');
		return $insert;
		}
		
	}
	function update_cat_status($year)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		
		'status' =>'USED',
	
		
		);
			$this->db->where('year',$year);
		$insert = $this->db->update('re_commision_configcat', $data);
		$row = $this->db->query('SELECT MAX(type_id) AS `maxid` FROM `ac_cashbooktypes`')->row();
		return $row->maxid;
		
	}
	
	
	function  delete_cat_rate($cat_id,$table_id)
	{
		//$tot=$bprice*$quontity; 
		if($table_id)
		{
		$this->db->where('cat_id',$cat_id);
		$this->db->where('table_id',$table_id);
		$insert = $this->db->delete('re_commision_configrate');
		return $insert;
		}
		
	}
	
	function insert_cat_rate($amount,$cat_id,$tableid,$year,$rate_type)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		'cat_id' => $cat_id,
			'year' =>$year,
		'table_id' =>$tableid,
		'rate' => $amount,
		'rate_type' => $rate_type,
		'create_by' => $this->session->userdata('userid'),
		'create_date' =>date("Y-m-d"),
		
		);
		$insert = $this->db->insert('re_commision_configrate', $data);
		
		return $insert ;
		
	}
	function get_commission_master() { 
		$this->db->select('*');
		$this->db->order_by('year','DESC');
		$this->db->order_by('month','DESC');
		$query = $this->db->get('re_commision_master'); 
		return $query->result(); 
    }
	function get_checkgenerated($year,$month) { 
		$this->db->select('*');
		$this->db->where('year',$year);
		$this->db->where('month',$month);
		
		$query = $this->db->get('re_commision_master'); 
		  if ($query->num_rows() > 0) {
				return false; 
		  }
		  else
		 		 return true;
    }
	function get_current_month_payment($startdate,$enddate) { 
		$this->db->select('res_code,pay_date');
		$this->db->where('pay_date >=',$startdate);
		$this->db->where('pay_date <=',$enddate);
		$this->db->order_by('pay_date','DESC');
		$query = $this->db->get('re_saleadvance'); 
		  if ($query->num_rows() > 0) {
				return $query->result(); 
		  }
		  else
		 		 return true;
    }
	function tot_month_payment($rescode,$enddate) { 
		$this->db->select('SUM(pay_amount)as totpay');
		$this->db->where('res_code',$rescode);
		$this->db->where('pay_date <=',$enddate);
		$this->db->order_by('pay_date','DESC');
		$query = $this->db->get('re_saleadvance'); 
		  if ($query->num_rows() > 0) {
				$data= $query->row();
				return $data->totpay;
		  }
		  else
		 		 return 0;
    }
	function get_all_reservation_details_bycode($rescode) { //get all stock
		$this->db->select('re_resevation.*,re_prjaclotdata.lot_number,re_prjaclotdata.costof_sale,re_projectms.period,re_projectms.period,re_projectms.date_proposal,re_projectms.team_leader,re_projectms.tpo,re_projectms.officer_code,re_projectms.officer_code2');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
			$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->where('re_resevation.res_code',$rescode);
		$query = $this->db->get('re_resevation'); 
		return $query->row(); 
    }
	function commission_lot_data($id) { 
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get('re_commision_data'); 
		  if ($query->num_rows() > 0) {
				return $query->row(); 
				
		  }
		  else
		 		 return false;
    }
	function is_commission_given($lot_id) { 
		$this->db->select('MAX(id) as maxid');
		$this->db->where('lot_id',$lot_id);
		$query = $this->db->get('re_commision_data'); 
		  if ($query->num_rows() > 0) {
				$data= $query->row(); 
				$commdata=$this->commission_lot_data($data->maxid);
				return $commdata;
		  }
		  else
		 		 return false;
    }
	function get_price_category($year,$price)
	{
		$this->db->select('*');
		$this->db->where('year',$year);
		$this->db->where('start_range <=',$price);
		$this->db->where('end_range >=',$price);
		$query = $this->db->get('re_commision_configcat'); 
		//echo  $this->db->last_query();
		 if ($query->num_rows() > 0) {
				$data= $query->row(); 
				
				return $data->id;
		  }
		  else
		 		 return 0;
	}
	function get_commission_rate_by_catid_tableid_rate_fulldata($cat_id,$table_id,$year) { 
		$this->db->select('rate,status,rate_type');
		$this->db->where('cat_id',$cat_id);
		$this->db->where('table_id',$table_id);
		$this->db->where('year',$year);
		
		$query = $this->db->get('re_commision_configrate'); 
		  if ($query->num_rows() > 0) {
			  
		$data= $query->row(); 
		return $query->row();
		  }
		  else
		  return false;
    }
	function get_commission_rate_focal($runid,$res_code,$lot_id,$prj_id,$year,$table_id,$price,$team_leader,$tpo,$officer_code,$officer_code2,$pastpaydate,$presentage) { 
		
		$sl_rate_data=$this->get_commission_rate_by_catid_tableid_rate_fulldata(1,$table_id,$year);
		$dv_rate_data=$this->get_commission_rate_by_catid_tableid_rate_fulldata(4,$table_id,$year);
		$tl_rate_data=$this->get_commission_rate_by_catid_tableid_rate_fulldata(2,$table_id,$year);
		$bo_rate_data=$this->get_commission_rate_by_catid_tableid_rate_fulldata(3,$table_id,$year);
		if($sl_rate_data->rate_type=='Percentage')
		$sl_rate=($price*$sl_rate_data->rate)/100;
		else
		$sl_rate=$sl_rate_data->rate;
		
		if($dv_rate_data->rate_type=='Percentage')
		$dv_rate=($price*$dv_rate_data->rate)/100;
		else
		$dv_rate=$dv_rate_data->rate;
		
		if($tl_rate_data->rate_type=='Percentage')
		$tl_rate=($price*$tl_rate_data->rate)/100;
		else
		$tl_rate=$tl_rate_data->rate;
		
		if($bo_rate_data->rate_type=='Percentage')
		$bo_rate=($price*$bo_rate_data->rate)/100;
		else
		$bo_rate=$bo_rate_data->rate;
		$commission=$dv_rate+$tl_rate+$sl_rate+$bo_rate;
		//$commission=$price*$totrate/100;
		$data=array( 
		'run_id' => $runid,
		'res_code' => $res_code,
		'project_id' => $prj_id,
		'lot_id' =>$lot_id,
		'table_id' =>$table_id,
		'commission' =>$commission,
		'finalizedate'=>$pastpaydate,
		//'cat_id' =>$category,
		'persentage'=>$presentage
		
		);
		$insert = $this->db->insert('re_commision_data', $data);
		$row = $this->db->query('SELECT MAX(id) AS `maxid` FROM re_commision_data')->row();
		$data_id= $row->maxid;
		
		if($officer_code)
		{
			$amount=$sl_rate;
			$data=array( 
		'run_id' => $runid,
		'data_id' => $data_id,
		'emp_id' => $officer_code,
		'amount' =>$amount,
		//'deduct_amount' =>$deduct_amount,
		//'deduct_runid' =>$deduct_runid,
	//	'deduct_data_id'=>$deduct_data_id,
		'updated_by' => $this->session->userdata('userid'),
		'update_date' =>date("Y-m-d"),
		
		);
		$insert = $this->db->insert('re_commision_staff', $data);
		}
		if($officer_code2)
		{
			$amount=$dv_rate;
			$data=array( 
		'run_id' => $runid,
		'data_id' => $data_id,
		'emp_id' => $officer_code2,
		'amount' =>$amount,
		//'deduct_amount' =>$deduct_amount,
	//	'deduct_runid' =>$deduct_runid,
	//	'deduct_data_id'=>$deduct_data_id,
		'updated_by' => $this->session->userdata('userid'),
		'update_date' =>date("Y-m-d"),
		
		);
		$insert = $this->db->insert('re_commision_staff', $data);
		}
		if($team_leader)
		{
			$amount=$price*$tl_rate/100;
			$data=array( 
		'run_id' => $runid,
		'data_id' => $data_id,
		'emp_id' => $team_leader,
		'amount' =>$amount,
	//	'deduct_amount' =>$deduct_amount,
	//	'deduct_runid' =>$deduct_runid,
	//	'deduct_data_id'=>$deduct_data_id,
		'updated_by' => $this->session->userdata('userid'),
		'update_date' =>date("Y-m-d"),
		
		);
		$insert = $this->db->insert('re_commision_staff', $data);
		}
		if($tpo)
		{
			$amount=$price*$mn_rate/100;
			$data=array( 
		'run_id' => $runid,
		'data_id' => $data_id,
		'emp_id' => $tpo,
		'amount' =>$amount,
		//'deduct_amount' =>$deduct_amount,
	//	'deduct_runid' =>$deduct_runid,
	//	'deduct_data_id'=>$deduct_data_id,
		'updated_by' => $this->session->userdata('userid'),
		'update_date' =>date("Y-m-d"),
		
		);
		$insert = $this->db->insert('re_commision_staff', $data);
		}
		return $data_id;
    }
	function add_commision_master($year,$month)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		'year' => $year,
		'month' => $month,
		
		'run_by' => $this->session->userdata('userid'),
		'run_date' =>date("Y-m-d"),
	
		
		);
		$insert = $this->db->insert('re_commision_master', $data);
		$row = $this->db->query('SELECT MAX(id) AS `maxid` FROM re_commision_master')->row();
		return $row->maxid;
		
	}
	function add_commision_data($runid,$res_code,$lot_id,$prj_id,$tableid,$commission,$finalizedate,$category,$presentage)
	{
		$data=array( 
		'run_id' => $runid,
		'res_code' => $res_code,
		'project_id' => $prj_id,
		'lot_id' =>$lot_id,
		'table_id' =>$tableid,
		'commission' =>$commission,
		'finalizedate'=>$finalizedate,
		'cat_id' =>$category,
		'persentage'=>$presentage
		
		);
		$insert = $this->db->insert('re_commision_data', $data);
		$row = $this->db->query('SELECT MAX(id) AS `maxid` FROM re_commision_data')->row();
		return $row->maxid;
	}
	function commission_staff_data($runid,$dataid) { 
		$this->db->select('*');
		$this->db->where('run_id',$runid);
		$this->db->where('data_id',$dataid);
		$query = $this->db->get('re_commision_staff'); 
		  if ($query->num_rows() > 0) {
				return $query->result(); 
				
		  }
		  else
		 		 return false;
    }
	function add_commision_staff_data($run_id,$data_id,$emp_id,$amount,$deduct_amount,$deduct_runid,$deduct_data_id)
	{
		$data=array( 
		'run_id' => $run_id,
		'data_id' => $data_id,
		'emp_id' => $emp_id,
		'amount' =>$amount,
		'deduct_amount' =>$deduct_amount,
		'deduct_runid' =>$deduct_runid,
		'deduct_data_id'=>$deduct_data_id,
		'updated_by' => $this->session->userdata('userid'),
		'update_date' =>date("Y-m-d"),
		
		);
		$insert = $this->db->insert('re_commision_staff', $data);
		$row = $this->db->query('SELECT MAX(id) AS `maxid` FROM re_commision_staff')->row();
		return $row->maxid;
	}
	function get_project_data($prjid) { 
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		
		
		$query = $this->db->get('re_commision_configrate'); 
		  if ($query->num_rows() > 0) {
			  
		$data= $query->row(); 
		return $query->row(); 
		  }
		  else
		  return false;
    }
	function add_commision_tpo_data($run_id,$data_id,$tpo,$amount,$deduct_amount,$deduct_runid,$deduct_data_id)
	{
		$data=array( 
		'run_id' => $run_id,
		'data_id' => $data_id,
		'tpo_name' => $tpo,
		'amount' =>$amount,
		'deduct_amount' =>$deduct_amount,
		'deduct_runid' =>$deduct_runid,
		'deduct_data_id'=>$deduct_data_id,
		'updated_by' => $this->session->userdata('userid'),
		'update_date' =>date("Y-m-d"),
		
		);
		$insert = $this->db->insert('re_commision_tpo', $data);
		$row = $this->db->query('SELECT MAX(id) AS `maxid` FROM re_commision_staff')->row();
		return $row->maxid;
	}
	
	function get_current_month_loan($startdate,$enddate) { 
		$this->db->select('res_code,confirm_date');
		$this->db->where('confirm_date >=',$startdate);
		$this->db->where('confirm_date <=',$enddate);
		$this->db->order_by('confirm_date','DESC');
		$query = $this->db->get('re_eploan'); 
		  if ($query->num_rows() > 0) {
				return $query->result(); 
		  }
		  else
		 		 return true;
    }
	function get_marketing_staff($branch)
	{
		$this->db->select('*');
		$this->db->where('division',5);
		$this->db->where('branch',$branch);
		
		$query = $this->db->get('hr_empmastr'); 
		//echo  $this->db->last_query();
		 if ($query->num_rows() > 0) {
				return $query->result(); 
		  }
		  else
		 		 return false;
	}
		function  delete_commission($runid)
	{
		//$tot=$bprice*$quontity; 
		
		$this->db->where('run_id',$runid);
		
		$insert = $this->db->delete('re_commision_tpo');
		
		$this->db->where('run_id',$runid);
		
		$insert = $this->db->delete('re_commision_staff');
		$this->db->where('run_id',$runid);
		
		$insert = $this->db->delete('re_commision_data');
		$this->db->where('id',$runid);
		
		$insert = $this->db->delete('re_commision_master');
		
		return $insert;
		
	}
function get_commission_year_month($year,$month) { 
		$this->db->select('*');
		$this->db->where('year',$year);
		$this->db->where('month',$month);
		
		$query = $this->db->get('re_commision_master'); 
		  if ($query->num_rows() > 0) {
				return $query->row(); 
		  }
		  else
		 		 return false;
    }
	function get_commission_runid($id) { 
		$this->db->select('*');
		$this->db->where('id',$id);
		
		$query = $this->db->get('re_commision_master'); 
		  if ($query->num_rows() > 0) {
				return $query->row(); 
		  }
		  else
		 		 return false;
    }
	function commission_lot_run_id($id) { 
		
		$this->db->select('re_commision_data.*,re_resevation.discount,re_resevation.res_date,re_resevation.discounted_price,re_prjaclotdata.price_perch,re_prjaclotdata.lot_number,re_prjaclotdata.costof_sale,re_projectms.period,re_projectms.period,re_projectms.date_proposal,re_projectms.team_leader,re_projectms.tpo,re_projectms.officer_code,re_projectms.officer_code2,re_projectms.project_name');
		$this->db->join('re_resevation','re_resevation.res_code=re_commision_data.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_commision_data.lot_id');
			$this->db->join('re_projectms','re_projectms.prj_id=re_commision_data.project_id');
		$this->db->where('re_commision_data.run_id',$id);
		$this->db->order_by('re_commision_data.project_id,re_commision_data.lot_id');
		$query = $this->db->get('re_commision_data'); 
		  if ($query->num_rows() > 0) {
				return $query->result(); 
				
		  }
		  else
		 		 return false;
    }
	function commission_lot_run_id_prjid($id,$projectid) { 
		
		$this->db->select('re_commision_data.*,re_resevation.discount,re_resevation.res_date,re_resevation.discounted_price,re_prjaclotdata.price_perch,re_prjaclotdata.lot_number,re_prjaclotdata.costof_sale,re_projectms.period,re_projectms.period,re_projectms.date_proposal,re_projectms.team_leader,re_projectms.tpo,re_projectms.officer_code,re_projectms.officer_code2,re_projectms.project_name');
		$this->db->join('re_resevation','re_resevation.res_code=re_commision_data.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_commision_data.lot_id');
			$this->db->join('re_projectms','re_projectms.prj_id=re_commision_data.project_id');
		$this->db->where('re_commision_data.run_id',$id);
		$this->db->where('re_commision_data.project_id',$projectid);
		$this->db->order_by('re_commision_data.project_id,re_commision_data.lot_id');
		$query = $this->db->get('re_commision_data'); 
		  if ($query->num_rows() > 0) {
				return $query->result(); 
				
		  }
		  else
		 		 return false;
    }
	function commission_staff_prjid($id) { 
		
		$this->db->select('re_commision_staff.*,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->join('hr_empmastr','hr_empmastr.id=re_commision_staff.emp_id');
		$this->db->where('re_commision_staff.data_id',$id);
			$query = $this->db->get('re_commision_staff'); 
			//echo $this->db->last_query();
		  if ($query->num_rows() > 0) {
				return $query->result(); 
				
		  }
		  else
		 		 return false;
    }
	function commission_tpo_prjid($id) { 
		
		$this->db->select('re_commision_tpo.*');
		$this->db->where('re_commision_tpo.data_id',$id);
			$query = $this->db->get('re_commision_tpo'); 
			//echo $this->db->last_query();
		  if ($query->num_rows() > 0) {
				return $query->result(); 
				
		  }
		  else
		 		 return false;
    }
	
	function commission_lot_update_staffamount($id,$projectid,$branch)
	{
		$this->db->select('re_commision_data.*');
		$this->db->where('re_commision_data.run_id',$id);
		$this->db->where('re_commision_data.project_id',$projectid);
		$this->db->order_by('re_commision_data.project_id,re_commision_data.lot_id');
		$query = $this->db->get('re_commision_data'); 
		  if ($query->num_rows() > 0) {
				$dataset= $query->result(); 
				foreach($dataset as $raw)
				{
					$tot=0;
					$staffset=$this->commission_staff_prjid($raw->id);
					if($staffset)
					{
						$staffarr=NULL;	$counter=0;
						
						foreach($staffset as $staffraw)
						{
							//$tot=$tot+$amount;
							 $amount=str_replace(',', '', $this->input->post('amount'.$raw->id.$staffraw->emp_id));
							 	 $staffarr[$counter]=$staffraw->emp_id; 
							 $tot=$tot+$amount;
							$data=array( 
		
								'amount' =>$amount,
				
								'updated_by' => $this->session->userdata('userid'),
									'update_date' =>date("Y-m-d"),
		
									);
								$this->db->where('id',$staffraw->id);
								$insert = $this->db->update('re_commision_staff', $data);
								$counter++;
						
						}
						$allset=$this->get_all_sales_staff($branch);
						if($staffset)
						{
							foreach($allset as $staffraw)
							{
									if(!in_array($staffraw->id,$staffarr)){
							//$tot=$tot+$amount;
							 $amount=str_replace(',', '', $this->input->post('amount'.$raw->id.$staffraw->id));
							 if( $amount>0){
							 $tot=$tot+$amount;
							$data=array( 
								'run_id' => $raw->run_id,
								'data_id' => $raw->id,
								'emp_id' => $staffraw->id,
								'amount' =>$amount,
								'deduct_amount' =>0,
								'deduct_runid' =>0,
								'deduct_data_id'=>0,
								'updated_by' => $this->session->userdata('userid'),
								'update_date' =>date("Y-m-d"),
		
								);
								$insert = $this->db->insert('re_commision_staff', $data);
						
							 }}}
						}
						$tpodata=$this->commission_model->commission_tpo_prjid($raw->id);
						if($tpodata)
						{
							foreach($tpodata as $tpora)
							{
								 $amount=str_replace(',', '', $this->input->post('amount'.$raw->id.'tpo'));
							 
								 $tot=$tot+$amount;
									$data=array( 
		
										'amount' =>$amount,
				
										'updated_by' => $this->session->userdata('userid'),
											'update_date' =>date("Y-m-d"),
		
									);
								$this->db->where('id',$tpora->id);
								$insert = $this->db->update('re_commision_tpo', $data);
								
							}
						}
						
						
						$data=array( 
		
								'commission' =>$tot,
				
									);
								$this->db->where('id',$raw->id);
								$insert = $this->db->update('re_commision_data', $data);
					}					
					
					
				}
				
		  }
		  else
		 		 return false;
	}
	function get_all_sales_staff($branch)
	{
		$divitions=array('5',3,4);
		$this->db->select('*');
		$this->db->where_in('division',$divitions);
		$this->db->where('branch',$branch);
		
		$query = $this->db->get('hr_empmastr'); 
		//echo  $this->db->last_query();
		 if ($query->num_rows() > 0) {
				return $query->result(); 
		  }
		  else
		 		 return false;
	}
	function get_project_master_data($id) { 
		$this->db->select('*');
		$this->db->where('prj_id',$id);
		
		$query = $this->db->get('re_projectms'); 
		return $query->row(); 
    }
	function commission_project_sum_id($id) { 
		
		$this->db->select('SUM(commission) totpay,project_id');
		$this->db->where('re_commision_data.run_id',$id);
	//	$this->db->where('re_commision_data.project_id',$projectid);
		$this->db->group_by('re_commision_data.project_id');
		$query = $this->db->get('re_commision_data'); 
		  if ($query->num_rows() > 0) {
				return $query->result(); 
				
		  }
		  else
		 		 return false;
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
	function commission_project_diduct_id($id,$project) { 
		
		$this->db->select('SUM(re_commision_staff.deduct_amount) totdeduct');
		$this->db->where('re_commision_data.run_id',$id);
		$this->db->where('re_commision_data.project_id',$project);
		$this->db->join('re_commision_staff','re_commision_staff.data_id=re_commision_data.id');
		$query = $this->db->get('re_commision_data'); 
		  if ($query->num_rows() > 0) {
				$data= $query->row();
				return   $data->totdeduct;
				
		  }
		  else
		 		 return 0;
    }
	function confirm_commission($runid)
	{
		$taskdata=$this->get_ledgerid_set('11');
		$this->db->select('*');
	
		$this->db->where('id',$runid);
		
		$query = $this->db->get('re_commision_master'); 
		//echo  $this->db->last_query();
		 if ($query->num_rows() > 0) {
			 $total=0;$voucherlist='';
				$masterdata = $query->row(); 
				$dataset=$this->commission_project_sum_id($runid);
				if($dataset)
				{
					foreach($dataset as $raw)
					{
						$task_id=40;
						
						$prj_id=$raw->project_id;
						$deduct=$this->commission_project_diduct_id($runid,$prj_id);
						$prjdata=$this->commission_model->get_project_master_data($prj_id);
						$subtask_id='0';
						$payeename='CASH';
						$date=date('Y-m-d');
						$newbalance=0;
						$balance=$this->commission_project_balance_id($prj_id);
						$amount=$raw->totpay-$deduct-$balance;
						if($prjdata->budgut_status=='PENDING')
							$ledreid=$taskdata->adv_ledgerid;
						else
						$ledreid=$taskdata->ledger_id;
       					 $type=6;
						 
						 if($amount>0)
						{
									$idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',$date);
									$id=$idlist[0];
									$data=array( 
										'voucherid'=>$id,
										'vouchercode'=>$idlist[1],
										'branch_code' => $this->session->userdata('branchid'),
										'ledger_id' => $this->session->userdata('accshortcode').$ledreid,
										'payeecode' => '',
										'payeename' => $payeename,
										'vouchertype' => $type,
										'paymentdes' => 'Project Payments',
										'amount' => $amount,
										'applydate' =>$date,
										'status' => 'CONFIRMED',
		
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
						 				$total= $total+$amount;
										 $voucherlist=$voucherlist.$id.','; // 
											$data=array( 
										'voucher_id '=>$id,
										'project_id ' =>$prj_id,
										'run_id' => $runid,
											'amount' =>$amount,
											'create_date' =>$date,
										);
						
											if(!$this->db->insert('re_commision_payment', $data))
											{
												$this->db->trans_rollback();
												$this->logger->write_message("error", "Error confirming Project");
												return false;
											}
											if($balance>0){
												$crlist[0]['ledgerid']='HEDBL23002400';
												$crlist[0]['amount']=$crtot=$balance;
												$drlist[0]['ledgerid']=$this->session->userdata('accshortcode').$ledreid;;
												$drlist[0]['amount']=$drtot=$balance;
												$narration = 'Commission Reprocess Additional Amounts.';
												$entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$prj_id,'','');
												insert_oumit_transactions($entry,'','',$prj_id,'',date("Y-m-d"),'Commission Transaction');
											}
						}
						else
						{
							$newbalance=(-1)*$amount;
							$crlist[0]['ledgerid']=$this->session->userdata('accshortcode').$ledreid;
							$crlist[0]['amount']=$crtot=$newbalance;
							$drlist[0]['ledgerid']='HEDBL23002400';
							$drlist[0]['amount']=$drtot=$newbalance;
							$narration = 'Commission Reprocess Additional Amounts.';
							$entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$prj_id,'','');
							insert_oumit_transactions($entry,'','',$prj_id,'',date("Y-m-d"),'Commission Transaction');
						}
						//$raw->totpay-$deduct-$balance
						$data=array( 
						'amount'=>$amount,
						'project_id' =>$prj_id,
						'run_id' => $runid,
						'current_comm' =>$raw->totpay,
						'current_deduct' =>$deduct,
						'prev_deduct' =>$balance,
						 
						);
						$this->update_current_project_balance($prj_id,$newbalance);
						if(!$this->db->insert('re_commision_projctmonth', $data))
						{
							$this->db->trans_rollback();
							$this->logger->write_message("error", "Error confirming Project");
						return false;
						}
						
					}
					
				}
				
				
				$this->calculate_staff_balances($runid);
				$data=array( 
		
								'total_commision' =>$total,
				'voucher_id' =>$voucherlist,
				'status'=>'CONFIRMED'
									);
								$this->db->where('id',$runid);
								$insert = $this->db->update('re_commision_master', $data);
				
		  }
		  else
		 		 return false;
	}
	function commission_staff_diduct_id($id) { 
		
		$this->db->select('SUM(re_commision_staff.amount ) tot,SUM(re_commision_staff.deduct_amount) totdeduct,emp_id');
		$this->db->where('re_commision_staff.run_id',$id);
		$this->db->group_by('re_commision_staff.emp_id');
		$query = $this->db->get('re_commision_staff'); 
		  if ($query->num_rows() > 0) {
				$data= $query->result();
				return   $query->result();
				
		  }
		  else
		 		 return false;
    }
	function commission_staff_balance_id($id) { 
		
		$this->db->select('balance');
		$this->db->where('re_commision_staffdeduct.emp_id',$id);
	
		$query = $this->db->get('re_commision_staffdeduct'); 
		  if ($query->num_rows() > 0) {
				$data= $query->row();
				return   $data->balance;
				
		  }
		  else
		 		 return 0;
    }
	function commission_project_balance_id($id) { 
		
		$this->db->select('balance');
		$this->db->where('re_commision_projctbal.prj_id',$id);
	
		$query = $this->db->get('re_commision_projctbal'); 
		  if ($query->num_rows() > 0) {
				$data= $query->row();
				return   $data->balance;
				
		  }
		  else
		 		 return 0;
    }
	function calculate_staff_balances($runid)
	{
		$dataset=$this->commission_staff_diduct_id($runid);
		if($dataset){
			foreach($dataset as $raw){ $newbalance=0;
			$balance=$this->commission_staff_balance_id($raw->emp_id);
			$total=$raw->tot-$raw->totdeduct-$balance;
				if($total< 0)
				{
					$newbalance=(-1)*$total;
					$total=0;
				}
						$data=array( 
						'amount'=>$total,
						'emp_id' =>$raw->emp_id,
						'run_id' => $runid,
						'month_add' =>$raw->tot,
						'month_deduct' =>$raw->totdeduct,
						'prev_deduct' =>$balance,
						 
						);
						
						if(!$this->db->insert('re_commission_staffmonth', $data))
						{
							$this->db->trans_rollback();
							$this->logger->write_message("error", "Error confirming Project");
						return false;
						}
							$data=array( 
								'balance' =>$newbalance,
									);
								$this->db->where('emp_id',$raw->emp_id);
								$insert = $this->db->update('re_commision_staffdeduct', $data);
			
			}
		}
		
	}
	function update_current_project_balance($prj_id,$newbalance)
	{
		$this->db->where('prj_id',$prj_id);
		$insert = $this->db->delete('re_commision_projctbal');
		$data=array( 
						
						'prj_id' =>$prj_id,
						'balance' => $newbalance,
						
						 
						);
						
						if(!$this->db->insert('re_commision_projctbal', $data))
						{
							$this->db->trans_rollback();
							$this->logger->write_message("error", "Error confirming Project");
						return false;
						}
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
	function get_current_month_staffsummery($id)
	{
		$this->db->select('re_commission_staffmonth.*,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->join('hr_empmastr','hr_empmastr.id=re_commission_staffmonth.emp_id');
		
		$this->db->where('re_commission_staffmonth.run_id',$id);
	
		$query = $this->db->get('re_commission_staffmonth'); 
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false; 
	}
function get_current_month_projectsummery($id)
	{
		$this->db->select('re_commision_projctmonth.*,re_projectms.project_name');
		$this->db->join('re_projectms','re_projectms.prj_id=re_commision_projctmonth.project_id');
		
		$this->db->where('re_commision_projctmonth.run_id',$id);
	
		$query = $this->db->get('re_commision_projctmonth'); 
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false; 
	}
	function commission_staff_prjid_sum($id,$project_id,$epm_id) { 
		
		$this->db->select('SUM(re_commision_staff.amount) as tot,SUM(re_commision_staff.deduct_amount) as deduct ');
		$this->db->join('re_commision_staff','re_commision_staff.data_id=re_commision_data.id');
		//$this->db->join('hr_empmastr','hr_empmastr.id=re_commision_staff.emp_id');
			$this->db->where('re_commision_staff.emp_id',$epm_id);
	//	$staffraw->epm_id
		$this->db->where('re_commision_data.run_id',$id);
		$this->db->where('re_commision_data.project_id ',$project_id);
		$this->db->group_by('re_commision_data.project_id');
			$query = $this->db->get('re_commision_data'); 
			//echo $this->db->last_query();
		  if ($query->num_rows() > 0) {
				return $query->row(); 
				
		  }
		  else
		 		 return false;
    }
	function commission_tpo_prjid_sum($id,$project_id) { 
		
		$this->db->select('SUM(re_commision_tpo.amount) as tot,SUM(re_commision_tpo.deduct_amount) as deduct ,re_commision_tpo.tpo_name');
		$this->db->join('re_commision_tpo','re_commision_tpo.data_id=re_commision_data.id');
		//$this->db->join('hr_empmastr','hr_empmastr.id=re_commision_staff.emp_id');
		
		$this->db->where('re_commision_data.run_id',$id);
		$this->db->where('re_commision_data.project_id ',$project_id);
		$this->db->group_by('re_commision_data.project_id');
			$query = $this->db->get('re_commision_data'); 
			//echo $this->db->last_query();
		  if ($query->num_rows() > 0) {
				return $query->row(); 
				
		  }
		  else
		 		 return false;
		
    }
}