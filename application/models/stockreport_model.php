<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stockreport_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	function get_all_project_summery($branchid,$prjid,$todate) { //get all stock

				$this->db->select('prj_id,project_code,project_name,branch_code,town');
				if($branchid!='ALL')
				$this->db->where('branch_code',$branchid);
				if($prjid!='ALL')
				$this->db->where('prj_id',$prjid);

				$this->db->order_by('project_name');
				$this->db->where('re_projectms.status',CONFIRMKEY);
				$this->db->where('re_projectms.price_status',CONFIRMKEY);


			//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
				$query = $this->db->get('re_projectms');
				return $query->result();

    }
	function check_priclist_confirm($prjid,$todate) { //get all stock

				$this->db->select('price_entry');

				$this->db->where('prj_id',$prjid);

				$this->db->order_by('project_name');
				$query = $this->db->get('re_projectms');
				if ($query->num_rows() > 0){
					$raw= $query->row();
					if($raw->price_entry)
					{
						$this->db->select('date');

						$this->db->where('id',$raw->price_entry);


						$query = $this->db->get('ac_entries');
						if ($query->num_rows() > 0){

							$raw2= $query->row();
							if($raw2->date>$todate)
							return false;
							else
							return true;
						}
					}
					return true;
				}
				else
				return false;

    }
	function get_full_lot_list($prj_id) { //get all stock
		$this->db->select('re_prjaclotdata.*');
		$this->db->where('re_prjaclotdata.prj_id',$prj_id);
			$this->db->order_by('lot_id');
		$query = $this->db->get('re_prjaclotdata');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function check_available_lot($lot_id,$todate)
	{
		$this->db->select('*');
		$this->db->where('lot_id',$lot_id);
		//$this->db->where('re_resevation.res_status !=',"REPROCESS");
			$this->db->order_by('re_resevation.res_date');
			$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
			$data= $query->result();
			$tag=false;
			foreach($data as $raw)
			{
				if($raw->res_status=='REPROCESS')
				{
					if($raw->res_date>$todate)
					$tag=true;
					else
					{  if($raw->resale_date <$todate)
						$tag=true;
						else
						$tag=false;
					}
				}
				else
				{
					if($raw->res_date>$todate)
					$tag=true;
					else
					{
						if($raw->init_costtrn_status=='PENDING')
						{
							if($raw->profit_status=='PENDING')
								$tag=true;
								else
								$tag=false;

						}
						else
						$tag=false;
					}
				}
			}
			return $tag;
		}
		else
		return true;

	}
	function check_advance_lot($lot_id,$todate)
	{
		$this->db->select('*');
		$this->db->where('lot_id',$lot_id);
		//$this->db->where('re_resevation.res_status !=',"REPROCESS");
			$this->db->order_by('re_resevation.res_date');
			$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
			$data= $query->result();
			$tag=false;
			foreach($data as $raw)
			{
				if($raw->res_date<$todate)
				{
					if($raw->res_status=='REPROCESS')
					{

							if($raw->resale_date>$todate)
							{
								if($raw->profit_status=='PENDING')
								{
									$tag=true;
								}
								else
								{
									if($raw->profit_date<=$todate)
									$tag=false;
									else
									$tag=true;

								}
							}
							else
							$tag=false;
						}
						else
						{
							if($raw->profit_status=='PENDING')
							{
								$tag=true;
							}
							else
							{
								if($raw->profit_date<=$todate)
								$tag=false;
								else
								$tag=true;

							}
						}

				}
				else
				{

					$tag=false;
				}
			}
			return $tag;
		}
		else
		return false;

	}


    function resale_lot_period($lot_id,$fromdate,$todate)
  	{
  		$this->db->select('*');
  		$this->db->where('lot_id',$lot_id);
  		//$this->db->where('re_resevation.res_status !=',"REPROCESS");
  			$this->db->order_by('re_resevation.res_date');
  			$query = $this->db->get('re_resevation');
  		if ($query->num_rows() > 0){
  			$data= $query->result();
  			$tag=false;
  			foreach($data as $raw)
  			{
  				if($raw->res_date<$todate)
  				{
  					if($raw->res_status=='REPROCESS')
  					{

  							if($raw->resale_date>$todate && $raw->resale_date<=$fromdate)
  							{
  								if($raw->profit_status=='PENDING')
  								{
  									$tag=true;
  								}
  								else
  								{
  									if($raw->profit_date<=$todate)
  									$tag=false;
  									else
  									$tag=true;

  								}
  							}
  							else
  							$tag=false;
  						}
              else
              $tag=false;

  				}
  				else
  				{

  					$tag=false;
  				}
  			}
  			return $tag;
  		}
  		else
  		return false;

  	}

    function check_advance_lot_period($lot_id,$fromdate,$todate)
  	{
  		$this->db->select('*');
  		$this->db->where('lot_id',$lot_id);
  		//$this->db->where('re_resevation.res_status !=',"REPROCESS");
  			$this->db->order_by('re_resevation.res_date');
  			$query = $this->db->get('re_resevation');
  		if ($query->num_rows() > 0){
  			$data= $query->result();
  			$tag=false;
  			foreach($data as $raw)
  			{
  				if($raw->res_date<$todate && $raw->res_date>=$fromdate)
  				{
  					if($raw->res_status=='REPROCESS')
  					{

  							if($raw->resale_date>$todate)
  							{
  								if($raw->profit_status=='PENDING')
  								{
  									$tag=true;
  								}
  								else
  								{
  									if($raw->profit_date<=$todate)
  									$tag=false;
  									else
  									$tag=true;

  								}
  							}
  							else
  							$tag=false;
  						}
  						else
  						{
  							if($raw->profit_status=='PENDING')
  							{
  								$tag=true;
  							}
  							else
  							{
  								if($raw->profit_date<=$todate)
  								$tag=false;
  								else
  								$tag=true;

  							}
  						}

  				}
  				else
  				{

  					$tag=false;
  				}
  			}
  			return $tag;
  		}
  		else
  		return false;

  	}

//updated by nadee 2021-06-08
}
