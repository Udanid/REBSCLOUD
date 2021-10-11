<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_branches_summery() { //get all stock
		$this->db->select('branch_code,branch_name,shortcode');
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$this->session->userdata('branchid'));
		$this->db->order_by('branch_name');
		$query = $this->db->get('cm_branchms');
		return $query->result();
    }
	function get_all_project_summery($branchid) { //get all stock
			if($branchid=='ALL' & check_access('all_branch')){
				$this->db->select('prj_id,project_code,project_name,branch_code,town');
				$this->db->where('re_projectms.status',CONFIRMKEY);
			//	$this->db->where('re_projectms.price_status',CONFIRMKEY);
				$this->db->order_by('project_name');
			//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
				$query = $this->db->get('re_projectms');
				return $query->result();
			}
			else
			{
				$this->db->select('prj_id,project_code,project_name,branch_code,town');
				$this->db->where('branch_code',$this->session->userdata('branchid'));
				$this->db->order_by('project_name');
				$this->db->where('re_projectms.status',CONFIRMKEY);
				//$this->db->where('re_projectms.price_status',CONFIRMKEY);
			//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
				$query = $this->db->get('re_projectms');
				return $query->result();
			}
		}

    function get_reservation_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate){
		$status = array('PROCESSING'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		if($branch_code!='ALL')
		$this->db->where('re_resevation.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_resevation.res_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_resevation.res_date <=',$todate);

		$this->db->where_in('re_resevation.res_status',$status);
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_resevation');

		return $query->result();

    }    function get_allsearch_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate){
		$status = array('SETTLED'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
	//	$this->db->select('re_resevation.*,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id','left');
		if($branch_code!='ALL')
		$this->db->where('re_resevation.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_resevation.res_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_resevation.res_date <=',$todate);

		//$this->db->where_in('re_resevation.res_status',$status);
		$this->db->order_by('re_resevation.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_resevation');
		//echo $this->db->last_query();
		return $query->result();

    }
	function get_resale_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate)
	{
		$this->db->select('re_adresale.*,re_resevation.prj_id,re_resevation.lot_id,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_resevation','re_resevation.res_code=re_adresale.res_code');
		//$this->db->join('re_prjacincome','re_prjacincome.id=re_epresale.rct_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_adresale.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		if($branch_code!='ALL')
		$this->db->where('re_projectms.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_adresale.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_adresale.apply_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_adresale.apply_date <=',$todate);
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_adresale');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	function get_outright_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate){
		$status = array('SETTLED'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		if($branch_code!='ALL')
		$this->db->where('re_resevation.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_resevation.res_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_resevation.res_date <=',$todate);

		$this->db->where_in('re_resevation.res_status',$status);
		$this->db->where('re_resevation.pay_type','Outright');
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_resevation');

		return $query->result();

    }
	function get_loan_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate,$loantype){
		$status = array('SETTLED'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_eploan.loan_amount,re_eploan.loan_code,re_eploan.loan_type');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		if($branch_code!='ALL')
		$this->db->where('re_projectms.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_resevation.res_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_resevation.res_date <=',$todate);
		if($loantype!='')
		$this->db->where('re_eploan.loan_type',$loantype);

		$this->db->where_in('re_resevation.res_status','COMPLETE');
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_resevation');

		return $query->result();

    }
	function get_reshedule_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate)
	{
		$this->db->select('re_epreschedule.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_resevation.prj_id,re_resevation.lot_id,re_eploan.loan_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_epreschedule.cus_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_epreschedule.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
			$this->db->join('re_eploan','re_eploan.loan_code=re_epreschedule.loan_code');

		if($branch_code!='ALL')
		$this->db->where('re_projectms.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_epreschedule.apply_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_epreschedule.apply_date <=',$todate);
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_epreschedule');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	function get_rebate_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate)
	{
		$this->db->select('re_eprebate.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjacincome.pay_status,re_resevation.prj_id,re_resevation.lot_id,re_eploan.loan_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_eprebate.res_code');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eprebate.loan_code');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eprebate.rct_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		if($branch_code!='ALL')
		$this->db->where('re_projectms.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_eprebate.apply_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_eprebate.apply_date <=',$todate);
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_eprebate');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	function get_loanresale_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate)
	{
		$this->db->select('re_epresale.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_resevation.prj_id,re_resevation.lot_id,re_eploan.loan_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_epresale.res_code');
		$this->db->join('re_eploan','re_eploan.loan_code=re_epresale.loan_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_epresale.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		if($branch_code!='ALL')
		$this->db->where('re_projectms.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_epresale.apply_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_epresale.apply_date <=',$todate);
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');

		$query = $this->db->get('re_epresale');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;

	}
	 function get_customer_reservation_list($cus_code){
		$status = array('SETTLED'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
	//	$this->db->select('re_resevation.*,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id','left');

		$this->db->where('re_resevation.cus_code',$cus_code);
		$this->db->order_by('re_resevation.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
			return false;
		//echo $this->db->last_query();


    }
//Added by Madushan
    function personal_info_search($nationallity,$martial_status,$religion,$race,$blood_group,$dob_from_date,$dob_to_date,$branch,$division)
    {

    	$this->db->select('hr_empmastr.*,hr_dsgntion.designation,cm_branchms.branch_name,hr_division.division_name,
      hr_employment_types.employment_type AS emp_type');
    	$this->db->join('hr_dsgntion','hr_dsgntion.id = hr_empmastr.designation','left');
    	$this->db->join('cm_branchms','cm_branchms.branch_code = hr_empmastr.branch','left');
    	$this->db->join('hr_division','hr_division.id = hr_empmastr.division','left');
      $this->db->join('hr_employment_types','hr_empmastr.employment_type = hr_employment_types.id','left');
      $this->db->where('hr_empmastr.id !=', 1);
  		$this->db->where('hr_empmastr.id !=', 2);

    	if($nationallity != '')
    	$this->db->where('nationality',$nationallity);
    	if($martial_status != '')
    	$this->db->where('living_status',$martial_status);
    	if($religion != '')
    	$this->db->where('religion',$religion);
    	if($race != '')
    	$this->db->where('race',$race);
    	if($branch != 'ALL')
    	$this->db->where('branch',$branch);
      if($division != '')
      $this->db->where('division',$division);
    	if($blood_group != '')
    	$this->db->where('blood_group',$blood_group);
    	if($dob_from_date != '')
    	$this->db->where('dob >=',$dob_from_date);
   	 	if($dob_to_date != '')
    	$this->db->where('dob <=',$dob_to_date);

      	$this->db->order_by('cast(epf_no AS INT)',"DESC");
    	$query = $this->db->get('hr_empmastr');
   //  	foreach($query->result() as $row)
			// {
			// 	echo $row->emp_no.'<br>';
			// }
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
			return false;
    }

    function employement_info_search($emp_type,$joining_fromdate,$joining_todate,$designation,$branch,$division,$immediate_manager,$town,$province)
    {

    	$this->db->select('hr_empmastr.*,hr_dsgntion.designation,cm_branchms.branch_name,hr_division.division_name,
      hr_employment_types.employment_type AS emp_type');
    	$this->db->join('hr_dsgntion','hr_dsgntion.id = hr_empmastr.designation','left');
    	$this->db->join('cm_branchms','cm_branchms.branch_code = hr_empmastr.branch','left');
    	$this->db->join('hr_division','hr_division.id = hr_empmastr.division','left');
      $this->db->join('hr_employment_types','hr_empmastr.employment_type = hr_employment_types.id','left');
      $this->db->where('hr_empmastr.id !=', 1);
  		$this->db->where('hr_empmastr.id !=', 2);
    	if($emp_type != '')
    	$this->db->where('employment_type',$emp_type);
    	if($designation != '')
    	$this->db->where('hr_empmastr.designation',$designation);
    	if($branch != 'ALL')
    	$this->db->where('branch',$branch);
    	if($town != '')
    	$this->db->like('town',$town);
    	if($province != '')
    	$this->db->where('province',$province);
    	if($division != '')
    	$this->db->where('division',$division);
    	if($immediate_manager != '')
    	$this->db->where('immediate_manager_1',$immediate_manager);
    	if($joining_fromdate != '')
    	$this->db->where('joining_date >=',$joining_fromdate);
   	 	if($joining_todate != '')
    	$this->db->where('joining_date <=',$joining_todate);

      	$this->db->order_by('cast(epf_no AS INT)',"DESC");
    	$query = $this->db->get('hr_empmastr');
   //  	foreach($query->result() as $row)
			// {
			// 	echo $row->emp_no.'<br>';
			// }
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
			return false;
    }

    function educational_al_info_search($branch,$division)
    {

    	$this->db->select('hr_empmastr.*,hr_dsgntion.designation,cm_branchms.branch_name,hr_division.division_name');
    	$this->db->join('hr_dsgntion','hr_dsgntion.id = hr_empmastr.designation','left');
    	$this->db->join('cm_branchms','cm_branchms.branch_code = hr_empmastr.branch','left');
    	$this->db->join('hr_division','hr_division.id = hr_empmastr.division','left');
      $this->db->join('hr_employment_types','hr_empmastr.employment_type = hr_employment_types.id','left');
    	$this->db->join('hr_alresults','hr_alresults.emp_record_id = hr_empmastr.id');
      $this->db->where('hr_empmastr.id !=', 1);
  		$this->db->where('hr_empmastr.id !=', 2);
    	if($branch != 'ALL')
    	$this->db->where('branch',$branch);
      if($division != '')
      $this->db->where('division',$division);

      	$this->db->order_by('cast(epf_no AS INT)',"DESC");
    	$query = $this->db->get('hr_empmastr');


   //  	foreach($query->result() as $row)
			// {
			// 	echo $row->emp_no.'<br>';
			// }
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
			return false;
    }

    function educational_ol_info_search($branch,$division)
    {

    	$this->db->select('hr_empmastr.*,hr_dsgntion.designation,cm_branchms.branch_name,hr_division.division_name');
    	$this->db->join('hr_dsgntion','hr_dsgntion.id = hr_empmastr.designation','left');
    	$this->db->join('cm_branchms','cm_branchms.branch_code = hr_empmastr.branch','left');
    	$this->db->join('hr_division','hr_division.id = hr_empmastr.division','left');
      $this->db->join('hr_employment_types','hr_empmastr.employment_type = hr_employment_types.id','left');
    	$this->db->join('hr_olresults','hr_olresults.emp_record_id = hr_empmastr.id');
      $this->db->where('hr_empmastr.id !=', 1);
  		$this->db->where('hr_empmastr.id !=', 2);
    	if($branch != 'ALL')
    	$this->db->where('branch',$branch);
      if($division != '')
      $this->db->where('division',$division);

      	$this->db->order_by('cast(epf_no AS INT)',"DESC");
    	$query = $this->db->get('hr_empmastr');
   //  	foreach($query->result() as $row)
			// {
			// 	echo $row->emp_no.'<br>';
			// }
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
			return false;
    }

    function higher_education_search($higher_education,$higher_education_area)
    {
    	$this->db->select('*');
    	$query = $this->db->get('hr_empqlfct');
   //  	foreach($query->result() as $row)
			// {
			// 	echo $row->emp_no.'<br>';
			// }
		if ($query->num_rows() > 0){

			$i = 0;
			$c = 0;
			$search_query = false;
			$search_emp = array();
			foreach($query->result() as $row)
			{
				$data[$i] = unserialize($row->qualification_details);
				$emp_id[$i] = $row->emp_record_id;
				$c = $i++;

			}

			for($i = 0;$i<sizeof($data);$i++)
			{
				$search_query = false;
        if($data[$i]){
				foreach($data[$i] as $row)
				{
					if($higher_education == $row['name'])
					{
						$search_query = true;

						if($higher_education_area != '')
						{
							$search_query = false;
							if($higher_education_area == $row['field'])
								$search_query = true;
						}
					}
				}
      }

				if($search_query)
				$search_emp[$i] = $emp_id[$i];
			}

			// foreach($search_emp as $row)
			// {
			// 	echo $row.'<br>';
			// }

			return $search_emp;
		}
		else
			return false;
    }

    function get_qlft_employee($id,$branch)
    {

		$this->db->select('hr_empmastr.*,hr_dsgntion.designation,cm_branchms.branch_name,hr_division.division_name');
		$this->db->join('hr_dsgntion','hr_dsgntion.id = hr_empmastr.designation','left');
		$this->db->join('cm_branchms','cm_branchms.branch_code = hr_empmastr.branch','left');
	    $this->db->join('hr_division','hr_division.id = hr_empmastr.division','left');
      $this->db->join('hr_employment_types','hr_empmastr.employment_type = hr_employment_types.id','left');
      $this->db->where('hr_empmastr.id !=', 1);
  		$this->db->where('hr_empmastr.id !=', 2);
		$this->db->where('hr_empmastr.id',$id);
		if($branch != 'ALL')
    	$this->db->where('branch',$branch);

      	$this->db->order_by('cast(epf_no AS INT)',"DESC");
		$query = $this->db->get('hr_empmastr');
		if ($query->num_rows() > 0){
					return $query->result();
				}
				else
					return false;

    }
    //End of Madushan

   function get_turnover_searchlist($branch,$fromdate,$todate,$division)
   {

   		$this->db->select('hr_empmastr.*,cm_branchms.branch_name,hr_division.division_name,hr_employment_types.employment_type AS emp_type');
		$this->db->join('hr_dsgntion','hr_dsgntion.id = hr_empmastr.designation','left');
		$this->db->join('cm_branchms','cm_branchms.branch_code = hr_empmastr.branch','left');
	    $this->db->join('hr_division','hr_division.id = hr_empmastr.division','left');
      $this->db->join('hr_employment_types','hr_empmastr.employment_type = hr_employment_types.id','left');
		$this->db->where('hr_empmastr.resignation_date >=',$fromdate);
		$this->db->where('hr_empmastr.resignation_date <=',$todate);
		if($branch != 'ALL')
    	$this->db->where('branch',$branch);
      if($division != '')
      $this->db->where('division',$division);

      	$this->db->order_by('cast(epf_no AS INT)',"DESC");
		$query = $this->db->get('hr_empmastr');
		if ($query->num_rows() > 0){
					return $query->result();
				}
				else
					return false;

   }

   function get_all_emp_branch_wise($branch,$division="")
   {
   		$this->db->select('*');
      $this->db->where('hr_empmastr.id !=', 1);
  		$this->db->where('hr_empmastr.id !=', 2);
		if($branch != 'ALL')
    	$this->db->where('branch',$branch);
      if($division != '')
      $this->db->where('division',$division);

      	$this->db->order_by('cast(epf_no AS INT)',"DESC");
		$query = $this->db->get('hr_empmastr');
		if ($query->num_rows() > 0){
					return $query->result();
				}
				else
					return false;
   }

   /*Ticket No:2863 Added By Madushan 2021.05.21*/
   function get_employee_info_by_id($id)
   {
   		$this->db->select('hr_empmastr.*,hr_division.division_name,hr_employment_types.employment_type AS emp_type');
   		$this->db->join('hr_division','hr_division.id = hr_empmastr.division','left');
      $this->db->join('hr_employment_types','hr_empmastr.employment_type = hr_employment_types.id','left');
   		$this->db->where('hr_empmastr.id',$id);
		$query = $this->db->get('hr_empmastr');
		if ($query->num_rows() > 0){
					return $query->row();
				}
				else
					return false;
   }
}
