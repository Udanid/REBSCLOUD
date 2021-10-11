<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_project_summery($branchid) { //get all stock
		$this->db->select('prj_id,project_name,branch_code');
		if(! check_access('all_branch')){
		$this->db->where('branch_code',$branchid);}
		$this->db->order_by('prj_id');
		$query = $this->db->get('re_projectms');
		return $query->result();
    }


	function get_all_project_details($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('re_projectms.project_name,re_projectms.prj_id,re_projectms.status,hr_empmastr.surname,hr_empmastr.initial,re_landms.property_name,cm_branchms.branch_name');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->join('re_landms','re_landms.land_code=re_projectms.land_code');
		$this->db->join('hr_empmastr','hr_empmastr.id=re_projectms.officer_code');
		$this->db->join('cm_branchms','cm_branchms.branch_code=re_projectms.branch_code');
		$this->db->order_by('re_projectms.prj_id','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_projectms');
		return $query->result();
    }
	function get_all_project_confirmed_search($prjid) { //get all stock
		$this->db->select('re_projectms.*,hr_empmastr.surname,hr_empmastr.initial,re_landms.property_name');
		$this->db->where('re_projectms.prj_id',$prjid);
		$this->db->join('re_landms','re_landms.land_code=re_projectms.land_code');
		$this->db->join('hr_empmastr','hr_empmastr.id=re_projectms.officer_code','left');
		$this->db->join('cm_branchms','cm_branchms.branch_code=re_projectms.branch_code');
			$query = $this->db->get('re_projectms');
			return $query->result();
    }
	function get_all_project_summery_fiesibility($branchid) { //get all stock
		$this->db->select('re_projectms.prj_id,re_projectms.project_name,branch_code');
		$this->db->join('re_prjfstimestamp','re_prjfstimestamp.prj_id=re_projectms.prj_id');
		$this->db->where('re_prjfstimestamp.last_generate !=','NULL');;
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$branchid);

		$this->db->order_by('prj_id','DESC');
		$query = $this->db->get('re_projectms');
		return $query->result();
    }
		function get_all_project_details_feasibility($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('re_projectms.project_name,re_projectms.prj_id,re_projectms.status,hr_empmastr.surname,hr_empmastr.initial,re_landms.property_name,cm_branchms.branch_name,re_prjfstimestamp.*');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->join('re_prjfstimestamp','re_prjfstimestamp.prj_id=re_projectms.prj_id');
		$this->db->where('re_prjfstimestamp.last_generate !=','NULL');;
		$this->db->join('re_landms','re_landms.land_code=re_projectms.land_code');
		$this->db->join('hr_empmastr','hr_empmastr.id=re_projectms.officer_code');
		$this->db->join('cm_branchms','cm_branchms.branch_code=re_projectms.branch_code');
		$this->db->order_by('re_projectms.prj_id','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_projectms');
		return $query->result();
    }
	function get_all_project_confirmed($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('re_projectms.project_name,re_projectms.prj_id,re_projectms.project_code,re_projectms.selable_area,re_projectms.price_status,re_projectms.status,hr_empmastr.surname,hr_empmastr.initial,re_projectms.sales_cml_status');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->where('re_projectms.status',CONFIRMKEY);;
		$this->db->join('hr_empmastr','hr_empmastr.id=re_projectms.officer_code','left');
		$this->db->order_by('re_projectms.prj_id','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_projectms');
		return $query->result();
    }
	function get_project_bycode($code) { //get all stock
		$this->db->select('re_projectms.*,hr_empmastr.surname,hr_empmastr.initial,re_landms.property_name,re_landms.owner_name,cm_branchms.branch_name');

		$this->db->join('re_landms','re_landms.land_code=re_projectms.land_code');
		$this->db->join('hr_empmastr','hr_empmastr.id=re_projectms.officer_code','left');
		$this->db->join('cm_branchms','cm_branchms.branch_code=re_projectms.branch_code');
		$this->db->where('re_projectms.prj_id',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_projectms');
		return $query->row();
    }

	function get_project_comments($code) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);

		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_projectcomment');
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
		//$id=$this->getmaincode('prj_id','LND','re_projectms');
		if( $this->input->post('branch_code'))
		{
			$branc_code=$this->input->post('branch_code');

		}
		else
		{
			$branc_code=$this->session->userdata('branchid');

		}
		$data=array(
	//	'prj_id'=>$id,
		'branch_code' => $branc_code,
		'land_code' => $this->input->post('land_code'),
			'town' => $this->input->post('town'),
		'project_name' => $this->input->post('project_name'),
		'project_code' => $this->input->post('project_code'),
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

		);
		$insert = $this->db->insert('re_projectms', $data);

		//Add as a WIP project
		$data=array(
			'prj_name' => $this->input->post('project_name'),
			'prj_createby' => $this->session->userdata('userid'),
			'prj_create_date' => date('Y-m-d'),
		);
		$insert = $this->db->insert('wip_project', $data);

		$data=array(


		'status' => 'USED',
		);
		$this->db->where('land_code', $this->input->post('land_code'));
		$insert = $this->db->update('re_landms', $data);


		$this->db->select_max('prj_id');
		$result = $this->db->get('re_projectms')->row();
		$id= $result->prj_id;
		$data=array(
		'prj_id' =>$id,
		'last_update' => date("Y-m-d H:i:s"),
		);

		$insert = $this->db->insert('re_prjfstimestamp',$data);
		$data=array(
		'prj_id' =>$id,
		'valueitems' => 0,
		'budget' => 0,
		'marketing' => 0,
		'price' => 0,
		'dptime' => 0,
		'saletime' => 0,
		);

		$insert = $this->db->insert('re_prjfsbstatus',$data);
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
		$insert = $this->db->insert('re_officerlist',$data);
	}
	function update_officers($prjid,$userid)
	{
		$data=array(
		'status' =>'Inactive',
		'end_date' =>date('Y-m-d'),

		);
		$this->db->where('prj_id', $prjid);
		$this->db->where('user_id', $userid);
		$insert = $this->db->update('re_officerlist',$data);
	}
	function add_documents($prjid,$docid,$document)
	{
		$data=array(
		'prj_id' =>$prjid,
		'doc_id' =>$docid,
		'document' =>$document,

		);

		$insert = $this->db->insert('re_projectdoc',$data);
	}
	function edit()
	{
		//$tot=$bprice*$quontity;
		$project_data=$this->get_project_bycode($this->input->post('prj_id'));
		$data=array(
			'project_code' => $this->input->post('project_code'),
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
		);
		$this->db->where('prj_id', $this->input->post('prj_id'));
		$insert = $this->db->update('re_projectms', $data);
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
		$insert = $this->db->update('re_projectms', $data);
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
		if($id)
		{
			$this->db->trans_start();
			$code=$this->getmaincode('project_code','LNS','re_projectms');
			$prjdata=$this->get_project_bycode($id);
			//$entrykey=project_confirm_entires($id,$code);
			$data=array(
	
			'status' => CONFIRMKEY,
			);
			$this->db->where('prj_id', $id);
			if(!  $this->db->update('re_projectms', $data))
			{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');
					$this->logger->write_message("error", "Error confirming Project");
				return false;
			}
			$data2=array(
		
			'status'=>'Purchased',
		
			);
			$this->db->where('land_code', $prjdata->land_code);
			$this->db->update('re_landms', $data2);
			return $code;
		}
		return false;

	}
	function confirm_budget($id)
	{
		
		if($id)
		{
			$prjdata1=$this->get_project_bycode($id);
			if($prjdata1->budgut_status=='PENDING')
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
				if(!  $this->db->update('re_projectms', $data))
				{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
						$this->logger->write_message("error", "Error confirming Project");
					return false;
				}
		
				$prjdata=$this->get_project_bycode($id);
				$price_entry=$prjdata->price_entry;
				$budget_entry=$prjdata->budget_entry;
				if($price_entry)
				{
					$price_tot=$this->get_entrydata_amount($price_entry);
					$budget_tot=$this->get_entrydata_amount($budget_entry);
				//	echo $budget_tot;
					//echo $price_tot;
					if($budget_tot!=$price_tot)
					{
						$dif=$budget_tot-$price_tot;
						if($dif>0)
						{
						$ledgerset=get_account_set('Price List Confirmation');
						$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
						$crlist[0]['amount']=$crtot=$dif;
						$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$drlist[0]['amount']=$crtot=$drtot=$dif;
						$narration = $prjdata->prj_code.' Project Price List Conformation adjustment after budget confirmation'  ;
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$id,'');
						}
						else
						{
							$dif=$dif*(-1);
							$ledgerset=get_account_set('Price List Confirmation');
							$crlist[0]['ledgerid']=$ledgerset['Dr_account'];
							$crlist[0]['amount']=$crtot=$dif;
							$drlist[0]['ledgerid']=$ledgerset['Cr_account'];
							$drlist[0]['amount']=$crtot=$drtot=$dif;
							$narration = $prjdata->prj_code.' Project Price List Conformation adjustment after budget confirmation'  ;
							$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$id,'','');
						}
					}
				}
			}
		}
		return $id;

	}
	function get_entrydata_amount($id)
	{
		$this->db->select('*');

		$this->db->where('id',$id);

		$query = $this->db->get('ac_entries');
		if ($query->num_rows() > 0){
		$data= $query->row();
			return $data->dr_total;
		}
		else
		return 0;
	}
	function confirm_price($id)
	{
		if($id)
		{	$prjdata=$this->get_project_bycode($id);
			if($prjdata->price_status=='PENDING')
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
				if(!  $this->db->update('re_projectms', $data))
				{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
						$this->logger->write_message("error", "Error confirming Project");
					return false;
				}
				return $id;
			}
	
			return $id;
		}
	return $id;
	}
	function delete($id)
	{
		//$tot=$bprice*$quontity;
		
		if($id)
		{
			$prjdata=$this->get_project_bycode($id);
			$data=array(
	
			'status'=>'PENDING',
	
			);
			$this->db->where('land_code', $prjdata->land_code);
			$this->db->update('re_landms', $data);
	
			$this->db->where('prj_id', $id);
			$insert = $this->db->delete('re_projectcomment');
			$this->db->where('prj_id', $id);
			$insert = $this->db->delete('re_projectms');
		}
		return $id;

	}
	function commetnadd()
	{
	//	$this->db->where('project_code', $this->input->post('project_code'));
		//$insert = $this->db->delete('re_projectcomment');

			$data=array(

			  'project_code' => $this->input->post('project_code'),
			  'userid' => $this->session->userdata('userid'),
			  'comment_type' => 'Higer Auth',
			  'comment' => $this->input->post('high_auth'),
			  'comment_date' => date("Y-m-d"),

			  );
			  $this->db->insert('re_projectcomment', $data);

			  $data=array(

			  'project_code' => $this->input->post('project_code'),
			  'userid' => $this->session->userdata('userid'),
			  'comment_type' => 'Managers',
			  'comment' => $this->input->post('manager'),
			  'comment_date' => date("Y-m-d"),


			  );
			  $this->db->insert('re_projectcomment', $data);


	}
	function project_expence($prj_id)
	{
		$this->db->select('SUM(new_budget) as tot');

		$this->db->where('prj_id',$prj_id);
		$this->db->group_by('prj_id');
		$query = $this->db->get('re_prjacpaymentms');
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

	function check_price_confirmed($project_id){
		$this->db->select('price_status');
		$this->db->where('prj_id',$project_id);
		$query = $this->db->get('re_projectms');
		if ($query->num_rows() > 0){
			$status = $query->row()->price_status;
			if($status == 'CONFIRMED'){
				return true;
			}else{
				return false;
			}
		}
		else
		return false;
	}

	function check_budget_confirmed($project_id){
		$this->db->select('budgut_status');
		$this->db->where('prj_id',$project_id);
		$query = $this->db->get('re_projectms');
		if ($query->num_rows() > 0){
			$status = $query->row()->budgut_status;
			if($status == 'CONFIRMED'){
				return true;
			}else{
				return false;
			}
		}
		else
		return false;
	}
	function update_sales_completion($id)
	{
		if($id)
		{
			$this->db->trans_start();
			$status='PENDING';
			$this->db->select('*');
			
			$this->db->where('prj_id',$id);
			$this->db->where('price_perch >',0);
			$this->db->where('status',$status);
			
			$query = $this->db->get('re_prjaclotdata');
			$this->db->last_query();
			if ($query->num_rows() > 0){
				
				$this->session->set_flashdata('error', 'This Project has unsold lots. ');
					redirect('re/lotdata/showall');
				return;
			}
			
			
			$data=array(
	
		
			'sales_cml_status' => 'COMPLETE',
			);
			$this->db->where('prj_id', $id);
			if(!  $this->db->update('re_projectms', $data))
			{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');
					$this->logger->write_message("error", "Error confirming Project");
				return false;
			}
	
			return $code;
		}

	}
}
