<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_project_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_project_summery($branchid) { //get all stock
		$this->db->select('prj_id,project_name,branch_code');
		if(! check_access('all_branch')){
		$this->db->where('branch_code',$branchid);}
		$this->db->order_by('prj_id');
		$query = $this->db->get('hm_projectms');
		return $query->result();
    }


	function get_all_project_details($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('hm_projectms.project_name,hm_projectms.prj_id,hm_projectms.status,hr_empmastr.surname,hr_empmastr.initial,hm_landms.property_name,cm_branchms.branch_name,hm_landms.owenership_type');
		if(! check_access('all_branch')){
		$this->db->where('hm_projectms.branch_code',$branchid);
	    }
		$this->db->join('hm_landms','hm_landms.land_code=hm_projectms.land_code','left');
		$this->db->join('hr_empmastr','hr_empmastr.id=hm_projectms.officer_code','left');
		$this->db->join('cm_branchms','cm_branchms.branch_code=hm_projectms.branch_code','left');
		$this->db->order_by('hm_projectms.prj_id','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hm_projectms');
		
		if(count($query->result())>0){
			return $query->result();
		}else{
			return false;
		}
    }
	function get_all_project_summery_fiesibility($branchid) { //get all stock
		$this->db->select('hm_projectms.prj_id,hm_projectms.project_name,branch_code');
		$this->db->join('hm_prjfstimestamp','hm_prjfstimestamp.prj_id=hm_projectms.prj_id');
		$this->db->where('hm_prjfstimestamp.last_generate !=','NULL');;
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$branchid);

		$this->db->order_by('prj_id','DESC');
		$query = $this->db->get('hm_projectms');
		return $query->result();
    }
		function get_all_project_details_feasibility($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('hm_projectms.project_name,hm_projectms.prj_id,hm_projectms.status,hr_empmastr.surname,hr_empmastr.initial,hm_landms.property_name,cm_branchms.branch_name,hm_prjfstimestamp.last_generate,hm_landms.owenership_type');
		if(! check_access('all_branch'))
		$this->db->where('hm_projectms.branch_code',$branchid);
		$this->db->join('hm_prjfstimestamp','hm_prjfstimestamp.prj_id=hm_projectms.prj_id');
		$this->db->where('hm_prjfstimestamp.last_generate !=','NULL');;
		$this->db->join('hm_landms','hm_landms.land_code=hm_projectms.land_code');
		$this->db->join('hr_empmastr','hr_empmastr.id=hm_projectms.officer_code');
		$this->db->join('cm_branchms','cm_branchms.branch_code=hm_projectms.branch_code');
		$this->db->order_by('hm_projectms.prj_id','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hm_projectms');
		return $query->result();
    }
	function get_all_project_confirmed($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('hm_projectms.project_name,hm_projectms.prj_id,hm_projectms.project_code,hm_projectms.selable_area,hm_projectms.price_status,hm_projectms.status,hr_empmastr.surname,hr_empmastr.initial');
		if(! check_access('all_branch'))
		$this->db->where('hm_projectms.branch_code',$branchid);
		$this->db->where('hm_projectms.status',CONFIRMKEY);;
		$this->db->join('hr_empmastr','hr_empmastr.id=hm_projectms.officer_code','left');
		$this->db->order_by('hm_projectms.prj_id','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hm_projectms');
		return $query->result();
    }
	function get_project_bycode($code) { //get all stock
		$this->db->select('hm_projectms.*,hm_landms.property_name,hm_landms.owner_name,hm_landms.owenership_type,cm_branchms.branch_name');

		$this->db->join('hm_landms','hm_landms.land_code=hm_projectms.land_code','left');
		$this->db->join('hr_empmastr','hr_empmastr.id=hm_projectms.officer_code','left');
		$this->db->join('cm_branchms','cm_branchms.branch_code=hm_projectms.branch_code');
		$this->db->where('hm_projectms.prj_id',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hm_projectms');
		//echo $this->db->last_query();
		return $query->row();
    }

	function get_project_comments($code) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);

		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hm_projectcomment');
		return $query->result();
    }
	function get_project_officer_list($code) { //get all stock
		$this->db->select('hr_empmastr.*');
		if(! check_access('all_branch'))
		$this->db->where('branch',$code);
		$this->db->order_by('initial');
		$this->db->where('hr_empmastr.status','A');
		$query = $this->db->get('hr_empmastr');
		return $query->result();


    }
	function add()
	{
		//$tot=$bprice*$quontity;
		//$id=$this->getmaincode('prj_id','LND','hm_projectms');
		$data=array(
	//	'prj_id'=>$id,
		'branch_code' => $this->input->post('branch_code'),
		'land_code' => $this->input->post('land_code'),
			'town' => $this->input->post('town'),
		'project_name' => $this->input->post('project_name'),
		'officer_code' => $this->input->post('officer_code'),
		'officer_code2' => $this->input->post('officer_code2'),
		'period' => $this->input->post('period'),

		'date_proposal' => $this->input->post('date_proposal'),
		'date_purchase' => $this->input->post('date_purchase'),
		'date_prjcommence' => $this->input->post('date_prjcommence'),
		'date_slscommence' => $this->input->post('date_slscommence'),
		'date_prjcompletion' => $this->input->post('date_prjcompletion'),
		'date_dvpcompletion' => $this->input->post('date_dvpcompletion'),
		'land_extend ' => $this->input->post('land_extend'),
		'road_ways' => $this->input->post('road_ways'),
		'other_res' => $this->input->post('other_res'),
		'open_space' => $this->input->post('open_space'),
		'unselable_area' => $this->input->post('unselable_area'),
		'selable_area' => $this->input->post('selable_area'),
		'lots' => $this->input->post('lots'),
		'purchase_price' => $this->input->post('purchase_price'),
		'market_price' => $this->input->post('market_price'),
		'expect_price' =>$this->input->post('expect_price'),
		'create_date' =>date("Y-m-d"),
		'create_by' => $this->session->userdata('username'),

    //2019-11-08 nadee modification
    'prj_typeid' => $this->input->post('prj_type'),
    'numof_units' =>$this->input->post('units'),
      'dp_typeid' => $this->input->post('dev_type'),
      'ownership' => $this->input->post('ownership'),

		);
		$insert = $this->db->insert('hm_projectms', $data);
		$data=array(


		'status' => 'USED',
		);
		$this->db->where('land_code', $this->input->post('land_code'));
		$insert = $this->db->update('hm_landms', $data);


		$this->db->select_max('prj_id');
		$result = $this->db->get('hm_projectms')->row();
		$id= $result->prj_id;
		$data=array(
		'prj_id' =>$id,
		'last_update' => date("Y-m-d H:i:s"),
		);

		$insert = $this->db->insert('hm_prjfstimestamp',$data);
    //2019-11-19 added by nadee
    /* if this project build on client request value item, common budget, marcketing data, dp time, sales time is unvalid */
    $default_val=0;
    $valueitems =0;
		$budget =0;
		$marketing =0;
		$price =0;
		$dptime =0;
		$saletime =0;
    if($this->input->post('ownership')=="client_property")
    {
      $valueitems =1;
  		$budget =1;
  		$marketing =1;
  		$dptime =1;
  		$saletime =1;
    }
		$data=array(
		'prj_id' =>$id,
		'valueitems' => $valueitems,
		'budget' => $budget,
		'marketing' => $marketing,
		'price' => $price,
		'dptime' => $dptime,
		'saletime' => $saletime,
		);

		$insert = $this->db->insert('hm_prjfsbstatus',$data);
		$this->add_officers($id,$this->input->post('officer_code'),'Project Officer');
		$this->add_officers($id,$this->input->post('officer_code2'),'CR Officer');

		return $id;

	}
	function add_officers($prjid,$userid,$type)
	{
		$data=array(
		'prj_id' =>$prjid,
		'user_id' =>$userid,
		'type' =>$type,
		'start_date' =>date('Y-m-d'),

		);
		$insert = $this->db->insert('hm_officerlist',$data);
	}
	function update_officers($prjid,$userid)
	{
		$data=array(
		'status' =>'Inactive',
		'end_date' =>date('Y-m-d'),

		);
		$this->db->where('prj_id', $prjid);
		$this->db->where('user_id', $userid);
		$insert = $this->db->update('hm_officerlist',$data);
	}
	function add_documents($prjid,$docid,$document)
	{
		$data=array(
		'prj_id' =>$prjid,
		'doc_id' =>$docid,
		'document' =>$document,

		);

		$insert = $this->db->insert('hm_projectdoc',$data);
	}
	function edit()
	{
		//$tot=$bprice*$quontity;
		$project_data=$this->get_project_bycode($this->input->post('prj_id'));
		$data=array(

		'project_name' => $this->input->post('project_name'),
		'officer_code' => $this->input->post('officer_code'),
		'officer_code2' => $this->input->post('officer_code2'),
		'period' => $this->input->post('period'),
		'date_proposal' => $this->input->post('date_proposal'),
		'date_purchase' => $this->input->post('date_purchase'),
		'date_prjcommence' => $this->input->post('date_prjcommence'),
		'date_slscommence' => $this->input->post('date_slscommence'),
		'date_prjcompletion' => $this->input->post('date_prjcompletion'),
		'date_dvpcompletion' => $this->input->post('date_dvpcompletion'),
		'land_extend ' => $this->input->post('land_extend'),
		'road_ways' => $this->input->post('road_ways'),
		'other_res' => $this->input->post('other_res'),
		'open_space' => $this->input->post('open_space'),
		'unselable_area' => $this->input->post('unselable_area'),
		'selable_area' => $this->input->post('selable_area'),
		'purchase_price' => $this->input->post('purchase_price'),
		'market_price' => $this->input->post('market_price'),
		'expect_price' =>$this->input->post('expect_price'),
			'period' => $this->input->post('period'),

      //2019-11-08 nadee modification
      'prj_typeid' => $this->input->post('prj_type'),
  		'numof_units' =>$this->input->post('units'),
  			'dp_typeid' => $this->input->post('dev_type'),
        'ownership' => $this->input->post('ownership'),
		);
		$this->db->where('prj_id', $this->input->post('prj_id'));
		$insert = $this->db->update('hm_projectms', $data);
		if($this->input->post('officer_code')!=$project_data->officer_code)
		{
			if($project_data->officer_code)
			{
				$this->update_officers($this->input->post('prj_id'),$project_data->officer_code);

			}
			$this->add_officers($this->input->post('prj_id'),$this->input->post('officer_code'),'Project Officer');
		}
		if($this->input->post('officer_code2')!=$project_data->officer_code2)
		{
			if($project_data->officer_code2)
			{
				$this->update_officers($this->input->post('prj_id'),$project_data->officer_code2);

			}
			$this->add_officers($this->input->post('prj_id'),$this->input->post('officer_code2'),'CR Officer');
		}

		return $insert;

	}
	function edit_po()
	{
		//$tot=$bprice*$quontity;
		$project_data=$this->get_project_bycode($this->input->post('prj_id'));
		$data=array(

		'officer_code' => $this->input->post('officer_code'),
		'officer_code2' => $this->input->post('officer_code2'),
		'team_leader' => $this->input->post('team_leader'),
		'tpo' => $this->input->post('tpo'),
		);
		$this->db->where('prj_id', $this->input->post('prj_id'));
		$insert = $this->db->update('hm_projectms', $data);
		if($this->input->post('officer_code')!=$project_data->officer_code)
		{
			if($project_data->officer_code)
			{
				$this->update_officers($this->input->post('prj_id'),$project_data->officer_code);

			}
			$this->add_officers($this->input->post('prj_id'),$this->input->post('officer_code'),'Project Officer');
		}
		if($this->input->post('officer_code2')!=$project_data->officer_code2)
		{
			if($project_data->officer_code2)
			{
				$this->update_officers($this->input->post('prj_id'),$project_data->officer_code2);

			}
			$this->add_officers($this->input->post('prj_id'),$this->input->post('officer_code2'),'CR Officer');
		}

		return $insert;

	}
	function confirm($id)
	{
		$this->db->trans_start();
		$code=$this->getmaincode('project_code','LNS','hm_projectms');

		//$entrykey=project_confirm_entires($id,$code);
		$data=array(

		'project_code'=>$code,
		'status' => CONFIRMKEY,
		);
		$this->db->where('prj_id', $id);
		if(!  $this->db->update('hm_projectms', $data))
		{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Entry.', 'error');
				$this->logger->write_message("error", "Error confirming Project");
			return false;
		}

		return $code;

	}
	function confirm_budget($id)
	{
		$this->db->trans_start();
		$prjdata=$this->get_project_bycode($id);
		$code=$prjdata->project_code;

		$entrykey=project_confirm_entires($id,$code);
		$data=array(

		'budget_entry'=>$entrykey,
		'budgut_status' => CONFIRMKEY,
		);
		$this->db->where('prj_id', $id);
		if(!  $this->db->update('hm_projectms', $data))
		{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Entry.', 'error');
				$this->logger->write_message("error", "Error confirming Project");
			return false;
		}

		return $code;

	}
	function confirm_price($id)
	{
		$this->db->trans_start();
		$prjdata=$this->get_project_bycode($id);
		$code=$prjdata->project_code;
		$expense=$this->project_expence($id);
		$entrykey=project_price_entires($id,$code,$expense);
		$data=array(

		'price_entry'=>$entrykey,
		'price_status' => CONFIRMKEY,
		);
		$this->db->where('prj_id', $id);
		if(!  $this->db->update('hm_projectms', $data))
		{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Entry.', 'error');
				$this->logger->write_message("error", "Error confirming Project");
			return false;
		}

		return $code;

	}
	function delete($id)
	{
		//$tot=$bprice*$quontity;
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('hm_projectcomment');
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('hm_projectms');
		return $insert;

	}
	function commetnadd()
	{
		$this->db->where('project_code', $this->input->post('project_code'));
		$insert = $this->db->delete('hm_projectcomment');

			$data=array(

			  'project_code' => $this->input->post('project_code'),
			  'userid' => $this->session->userdata('userid'),
			  'comment_type' => 'Higer Auth',
			  'comment' => $this->input->post('high_auth'),
			  'comment_date' => date("Y-m-d"),

			  );
			  $this->db->insert('hm_projectcomment', $data);

			  $data=array(

			  'project_code' => $this->input->post('project_code'),
			  'userid' => $this->session->userdata('userid'),
			  'comment_type' => 'Managers',
			  'comment' => $this->input->post('manager'),
			  'comment_date' => date("Y-m-d"),


			  );
			  $this->db->insert('hm_projectcomment', $data);


	}
	function project_expence($prj_id)
	{
		$this->db->select('SUM(new_budget) as tot');

		$this->db->where('prj_id',$prj_id);
		$this->db->group_by('prj_id');
		$query = $this->db->get('hm_prjacpaymentms');
		if ($query->num_rows() > 0){
		$data= $query->row();
			return $data->tot;
		}
		else
		return 0;

	}
 function getmaincode($idfield,$prifix,$table)
	{

 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table);

		$newid="";

        if ($query->num_rows() > 0) {
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
}
