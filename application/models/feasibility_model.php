<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feasibility_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_fesibilitystatus($prjid) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->where('valueitems',1);
		$this->db->where('budget',1);
		$this->db->where('marketing',1);
		$this->db->where('price',1);
		$this->db->where('dptime',1);
		$this->db->where('saletime',1);
		
		$query = $this->db->get('re_prjfsbstatus'); 
		if ($query->num_rows() > 0){
		return true;
		}
		else
		return false;
    }
	function get_project_dprates($prjid) { //get all stock
		$this->db->select('re_prjfdprate.*,cm_dplevels.dp_rate');
		$this->db->where('prj_id',$prjid);
		$this->db->join('cm_dplevels','cm_dplevels.dp_id=re_prjfdprate.dp_level');
		$this->db->order_by('prj_id');
		$query = $this->db->get('re_prjfdprate'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_project_dprates_bydpid($prjid,$dpid) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->where('dp_level',$dpid);
		$query = $this->db->get('re_prjfdprate'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
		function get_project_epchart($prjid) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->order_by('timerange');
		$query = $this->db->get('re_prjfepchart'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_project_perch_price($prjid) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->order_by('perches_count');
		$query = $this->db->get('re_prjfprice'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
		function get_project_sales_time($prjid) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->order_by('month');
		$query = $this->db->get('re_prjfsalestime'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_project_subtask($prjid,$taskid) { //get all stock
		$this->db->select('re_prjfsubtask.*,cm_subtask.subtask_name,cm_subtask.subtask_code');
		$this->db->where('re_prjfsubtask.prj_id',$prjid);
		$this->db->where('re_prjfsubtask.task_id',$taskid);
		$this->db->join('cm_subtask','cm_subtask.subtask_id=re_prjfsubtask.subtask_id');
		$this->db->order_by('prj_id');
		$query = $this->db->get('re_prjfsubtask'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
		function get_project_maintask_forentry($prjid,$taskid) { //get all stock
		$this->db->select('re_prjftask.*');
		$this->db->where('re_prjftask.prj_id',$prjid);
		$this->db->where('re_prjftask.task_id',$taskid);
			$this->db->order_by('re_prjftask.task_id');
		$query = $this->db->get('re_prjftask'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }

    //Ticket No-2902 | Added By Uvini
    function get_project_maintask_forentry_confirm_budget($prjid,$taskid) { //get all stock
		$this->db->select('re_prjacpaymentms.id,re_prjacpaymentms.prj_id,re_prjacpaymentms.task_id,re_prjacpaymentms.estimate_budget as budget');
		$this->db->where('re_prjacpaymentms.prj_id',$prjid);
		$this->db->where('re_prjacpaymentms.task_id',$taskid);
			$this->db->order_by('re_prjacpaymentms.task_id');
		$query = $this->db->get('re_prjacpaymentms'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }

    function get_project_maintask_forentry_new_budget($prjid,$taskid) { //get all stock
		$this->db->select('re_prjacpaymentms.id,re_prjacpaymentms.prj_id,re_prjacpaymentms.task_id,re_prjacpaymentms.new_budget as budget');
		$this->db->where('re_prjacpaymentms.prj_id',$prjid);
		$this->db->where('re_prjacpaymentms.task_id',$taskid);
			$this->db->order_by('re_prjacpaymentms.task_id');
		$query = $this->db->get('re_prjacpaymentms'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
    //End Ticket No-2902
		function get_project_maintask_forreport($prjid) { //get all stock
		$this->db->select('re_prjftask.*,cm_tasktype.task_name,cm_tasktype.task_code');
		$this->db->where('re_prjftask.prj_id',$prjid);
		//$this->db->where('cm_tasktype.entry_flag','M');
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjfsubtask.task_id');
		$this->db->order_by('re_prjftask.task_id');
		$query = $this->db->get('re_prjftask'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_project_timechart_maintask($prjid) { //get all stock
		$this->db->select('re_prjftimechart.*,cm_tasktype.task_name,cm_tasktype.task_code');
		$this->db->where('re_prjftimechart.prj_id',$prjid);
		$this->db->where('re_prjftimechart.task_type','M');
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjftimechart.task_id');
		$this->db->order_by('re_prjftask.task_id');
		$query = $this->db->get('re_prjftimechart'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
		function get_project_timechart_subtask($prjid) { //get all stock
		$this->db->select('re_prjftimechart.*,cm_subtask.subtask_name,cm_subtask.subtask_code');
		$this->db->where('re_prjftimechart.prj_id',$prjid);
		$this->db->where('re_prjftimechart.task_type','S');
		$this->db->join('cm_tasktype','cm_subtask.subtask_id=re_prjftimechart.task_id');
		$this->db->order_by('re_prjftask.task_id');
		$query = $this->db->get('re_prjftimechart'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_month_task_percentage($prjid,$taskid,$i)
	{
		$this->db->select('percentage');
		$this->db->where('prj_id',$prjid);
		$this->db->where('task_type','M');
		$this->db->where('task_id',$taskid);
		$this->db->where('month',$i);
		$query = $this->db->get('re_prjftimechart'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
	}
	function get_salestime_month($prjid,$i)
	{
		$this->db->select('percentage');
		$this->db->where('prj_id',$prjid);
		$this->db->where('month',$i);
		$query = $this->db->get('re_prjfsalestime'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
	}
	function get_bankloan_month($prjid,$i)
	{
		$this->db->select('amount');
		$this->db->where('prj_id',$prjid);
		$this->db->where('month',$i);
		$query = $this->db->get('re_prjfbankloan'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return 0;
	}
	function get_project_valueitems($prjid) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->order_by('id');
		$query = $this->db->get('re_prjfvalueitems'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	

	function delete_valueitems($id)
	{
		if($id)
		{
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('re_prjfvalueitems');
		return $insert;
		}
	}
	function add_valueitems($prjid,$name,$qty,$value) { //get all stock
		$data=array( 
	//	'prj_id'=>$id,
		'prj_id' => $prjid,
		'name' => $name,
		'quontity' => $qty,
		'value' => $value,
		
		
		);
		$insert = $this->db->insert('re_prjfvalueitems', $data);
		
		return $insert;
    }
	function delete_budgut_task($id)
	{
		if($id)
		{
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('re_prjftask');
		return $insert;
		}
	}
	function add_budgut_task($prjid,$task_id,$budget)
	{
		$data=array( 
	//	'prj_id'=>$id,
		'prj_id' => $prjid,
		'task_id' => $task_id,
		
		'budget' => $budget,
		
		
		
		);
		$insert = $this->db->insert('re_prjftask', $data);
		
		return $insert;
		
	}
	function update_prjpayment($prjid,$task_id,$budget)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->where('task_id',$task_id);
		$this->db->order_by('prj_id');
		$query = $this->db->get('re_prjacpaymentms'); 
		if ($query->num_rows() > 0){
			$dataset=$query->row();
			if($dataset->tot_payments <= $budget)
			{
				$data=array( 
					'estimate_budget'=>$budget,
				'new_budget'=>$budget,
			
				);
				$this->db->where('prj_id',$prjid);
				$this->db->where('task_id',$task_id);
				if(!$this->db->update('re_prjacpaymentms', $data))
				{
					$this->db->trans_rollback();
					return false;
				}
			}
				
			
		}
		else
		{
			
				$data=array( 
				'prj_id'=>$prjid,
				'task_id'=>$task_id,
				'estimate_budget'=>$budget,
				'new_budget'=>$budget,
				'tot_payments '=>'0.00',
			
				);
				if(!$this->db->insert('re_prjacpaymentms', $data))
				{
					$this->db->trans_rollback();
					return false;
				}
		}
	}
	function delete_budgut_subtask($id)
	{
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('re_prjfsubtask');
		return $insert;
	}
	function add_budgut_subtask($prjid,$task_id,$budget,$subtask_id)
	{
		$data=array( 
	//	'prj_id'=>$id,
		'prj_id' => $prjid,
		'task_id' => $task_id,
		'budget' => $budget,
		'subtask_id' => $subtask_id,
		'update_by' =>$this->session->userdata('username'),
		'last_update' =>date("Y-m-d") ,
		
		
		
		);
		$insert = $this->db->insert('re_prjfsubtask', $data);
		
		return $insert;
		
	}
	function delete_dprates($id)
	{
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('re_prjfdprate');
		return $insert;
	}
	function add_dprates($prjid,$dp_level,$percentage)
	{
		$data=array( 
	//	'prj_id'=>$id,
		'prj_id' => $prjid,
		'dp_level' => $dp_level,
		'percentage' => $percentage,
		'update_by' =>$this->session->userdata('username'),
		'last_update' =>date("Y-m-d") ,
		
		
		
		);
		$insert = $this->db->insert('re_prjfdprate', $data);
		
		return $insert;
		
	}
	function delete_epchart($id)
	{
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('re_prjfepchart');
		return $insert;
	}
	function add_epchart($prjid,$timerange,$percentage)
	{
		$data=array( 
	//	'prj_id'=>$id,
		'prj_id' => $prjid,
		'timerange' => $timerange,
		'percentage' => $percentage,
		'update_by' =>$this->session->userdata('username'),
		'last_update' =>date("Y-m-d") ,
		
		
		
		);
		$insert = $this->db->insert('re_prjfepchart', $data);
		
		return $insert;
		
	}
	function add_bankloan($prjid,$timerange,$percentage)
	{
		$data=array( 
	//	'prj_id'=>$id,
		'prj_id' => $prjid,
		'month' => $timerange,
		'amount' => $percentage,
		'update_by' =>$this->session->userdata('username'),
		'last_update' =>date("Y-m-d") ,
		
		
		
		);
		$insert = $this->db->insert('re_prjfbankloan', $data);
		
		return $insert;
	}
	function delete_bankloan($id)
	{
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('re_prjfbankloan');
		return $insert;
	}
	function update_marketdata($prjid)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		
		'outright' => $this->input->post('outright'),
		'epsales' => $this->input->post('epsales'),
		'land_bank' => $this->input->post('land_bank'),
		'other_rate' => $this->input->post('other_rate'),
		'branch_rate' => $this->input->post('branch_rate'),
		'sales_tax' => $this->input->post('sales_tax'),
		'int_freetime' => $this->input->post('int_freetime'),
		'prj_discount' => $this->input->post('prj_discount'),
	
		);
		$this->db->where('prj_id', $prjid);
		$insert = $this->db->update('re_projectms', $data);
	
		return $insert;
		
	}
	function update_feasibilitystatus($prj_id,$raw)
	{
		$data=array( 
			$raw =>true,
		);
		$this->db->where('prj_id', $prj_id);
		$insert = $this->db->update('re_prjfsbstatus', $data);
	}
	
	function delete_price($id)
	{
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('re_prjfprice');
		return $insert;
	}
	function add_price($prjid,$perches_count,$price) { //get all stock
		$data=array( 
	//	'prj_id'=>$id,
		'prj_id' => $prjid,
		'perches_count' => $perches_count,
		'price' => $price,
		'update_by' =>$this->session->userdata('username'),
		'last_update' =>date("Y-m-d") ,
		
		
		);
		$insert = $this->db->insert('re_prjfprice', $data);
		
		return $insert;
    }
	
	function delete_time($id)
	{
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('re_prjftimechart');
		return $insert;
	}
	function add_time($prj_id,$task_id,$month,$percentage) { //get all stock
		$data=array( 
		'prj_id' => $prj_id,
		'task_id' => $task_id,
		'month' => $month,
		'percentage' => $percentage,
		'update_by' =>$this->session->userdata('username'),
		'last_update' =>date("Y-m-d") ,
		
		
		);
		$insert = $this->db->insert('re_prjftimechart', $data);
		
		return $insert;
    }
	function delete_salestime($id)
	{
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('re_prjfsalestime');
		return $insert;
	}
	function add_salestime($prj_id,$month,$percentage) { //get all stock
		$data=array( 
		'prj_id' => $prj_id,
		'month' => $month,
		'percentage' => $percentage,
		'update_by' =>$this->session->userdata('username'),
		'last_update' =>date("Y-m-d") ,
		);
		$insert = $this->db->insert('re_prjfsalestime', $data);
		
		return $insert;
    }
	function get_project_tasklist($prjid) { //get all stock
		$this->db->select('re_prjftask.*,cm_tasktype.task_name,cm_tasktype.task_code');
		$this->db->where('re_prjftask.prj_id',$prjid);
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjftask.task_id');
		$this->db->order_by('prj_id');
		$query = $this->db->get('re_prjftask'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_lastupdate($prjid) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$query = $this->db->get('re_prjfstimestamp'); 
		if ($query->num_rows() > 0){
		$data= $query->row();
		if($data->last_update>$data->last_generate) 
		 return true;
		 else 
		 return false;
		}
		else
		return false;
    }
	function last_update($prj_id)
	{
	$data=array( 
		'last_update' => date("Y-m-d H:i:s"),
		'update_by' =>$this->session->userdata('userid'),
		);
		$this->db->where('prj_id', $prj_id);
		$insert = $this->db->update('re_prjfstimestamp', $data);
	}
	function get_dplevels()
	{
		$this->db->select('*');
		//$this->db->order_by('product_code,task_code');
		
		$query = $this->db->get('cm_dplevels'); 
		return $query->result(); 
	}
	function generate_evereport($prj_id,$epsales)
	{
		$data=array( 
		'last_generate' => date("Y-m-d H:i:s"),
		'generate_by' =>$this->session->userdata('userid'),
		);
		$this->db->where('prj_id', $prj_id);
		$insert = $this->db->update('re_prjfstimestamp', $data);
		
		$tasklist=$this->get_project_tasklist($prj_id);
		$this->db->where('prj_id', $prj_id);
		$insert = $this->db->delete('re_prjrtask');
		$this->db->where('prj_id',$prj_id);
		$insert = $this->db->delete('re_prjrmsdata');
		$this->db->where('prj_id', $prj_id);
		$insert = $this->db->delete('re_prjreprate');
		$this->db->where('prj_id', $prj_id);
		$insert = $this->db->delete('re_prjrepirates');
		
		if($tasklist)
		{
			foreach($tasklist as $raw)
			{
				
				$taskbudget=$raw->budget;
				$data=array( 
				'prj_id' => $prj_id,
				'task_id' => $raw->task_id,
				'task_name' => $raw->task_name,
				'budget' => $raw->budget);
					
				for($i=1; $i<=12; $i++ )
				{
					$monthval=$this->get_month_task_percentage($prj_id,$raw->task_id,$i);
					if($monthval)
						$val=$monthval->percentage;
					else
						$val=0;
					if($val !=0)
					$month=($taskbudget*$val)/100;
					else
					$month=0;
					//echo $month;
					$data[$i.'M']=$month;
				}
				$insert = $this->db->insert('re_prjrtask', $data);
			}

		}
		$purchprice=$this->get_project_perch_price($prj_id);
		$totsaleval=0;
		if($purchprice)
		{
			foreach($purchprice as $peraw)
			{
				$totsaleval=$totsaleval+($peraw->perches_count*$peraw->price);
			}
		}
		$dprates=$this->get_project_dprates($prj_id);
		$avgdp=0;
		if($purchprice)
		{
			foreach($dprates as $dpraw)
			{
				$avgdp=$avgdp+($dpraw->dp_rate*$dpraw->percentage);
			}
		}
		if($avgdp>0)
		$avgdp=$avgdp/100;
		$data=array( 
				'prj_id' => $prj_id,
				'total_sale' => $totsaleval,
				'avg_dpcash' => $avgdp,
				);
				$insert = $this->db->insert('re_prjrmsdata', $data);
				
		$eplist=$this->get_project_epchart($prj_id);
		if($eplist)
		{
			$data=array( 
				'prj_id' => $prj_id,
			);
			foreach($eplist as $epraw)
			{ $rate=0;
				if($epraw->percentage>0)
				$rate=$epsales*$epraw->percentage/100;
				$data[$epraw->timerange.'M']=$rate;
			}
			$insert = $this->db->insert('re_prjreprate', $data);
		}
		$dplist=$this->get_dplevels();
		if($dplist)
		{
			foreach($dplist as $dpraw)
			{
				$prjthisdp=$this->get_project_dprates_bydpid($prj_id,$dpraw->dp_id);
				$data=array( 
				'prj_id' => $prj_id,
				'dp_level' => $dpraw->dp_rate,
				
				);
				
				if($prjthisdp)
				$prjdp=$prjthisdp->percentage;
				for($i=12; $i<=96; $i=$i+12)
				{ 
				$rawstring='months'.$i;
					if($dpraw->$rawstring!=0 & $prjdp!=0)
					{ //echo $dpraw->dp_rate .'-'.$prjthisdp->percentage.'\n';
					   if($epsales!=0)
						$avg= ($dpraw->$rawstring*$prjdp)/$epsales;
						else $avg=0;
					}
					else $avg=0;
					$data[$i.'M']=$avg;
				}
				$insert = $this->db->insert('re_prjrepirates', $data);
			}
		}
		
					
	}
	function insert_rentalCalculation($data)
	{
		 $this->db->insert('re_prjrrentcal', $data);
	}
	function delete_rentalCalculation($prj_id)
	{
		$this->db->where('prj_id', $prj_id);
		$insert = $this->db->delete('re_prjrrentcal');
	}
	function insert_monthlycash($data)
	{
		for($i=1; $i<=61; $i++)
		 $this->db->insert('re_prjrmonthcsh', $data[$i]);
	}
	function delete_monthlycash($prj_id)
	{
		$this->db->where('prj_id', $prj_id);
		$insert = $this->db->delete('re_prjrmonthcsh');
	}
	
	function get_monthcash($prjid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->order_by('id');
		$query = $this->db->get('re_prjrmonthcsh'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
	}
	function get_rentalchart($prjid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->order_by('id');
		$query = $this->db->get('re_prjrrentcal'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
	}
	function get_evereport_task($prjid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->order_by('task_id');
		$query = $this->db->get('re_prjrtask'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
	}
	
	function get_evereport_avarage_eprates($prjid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->order_by('dp_level');
		$query = $this->db->get('re_prjrepirates'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
	}
	function get_evereport_eprates($prjid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$query = $this->db->get('re_prjreprate'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
	}
	function get_developmentcost_sum($prjid)
	{
		$this->db->select('SUM(budget) as totbudget');
		$this->db->where('prj_id',$prjid);
		$query = $this->db->get('re_prjftask'); 
		if ($query->num_rows() > 0){
		$data=$query->row();
		return $data->totbudget;
		}
		else
		return false;
	}

	function get_salesprice_sum($prjid)
	{
		$this->db->select('perches_count, price');
		$this->db->where('prj_id',$prjid);
		$query = $this->db->get('re_prjfprice'); 
		if ($query->num_rows() > 0){
		$data=$query->result();
		$tot=0;
		foreach($data as $rw)
		{
			$tot=$tot+($rw->perches_count*$rw->price);
		}
		return $tot;
		}
		else
		return 0;
	}
	function get_evereport_masterdata($prjid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$query = $this->db->get('re_prjrmsdata'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
	}
	
	
	
	function confirm($id)
	{
		$data=array( 
			'confirm_by' =>$this->session->userdata('userid'),
		);
		$this->db->where('prj_id', $id);
		$insert = $this->db->update('re_prjfstimestamp', $data);
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		
		'status' => CONFIRMKEY,
		);
		$this->db->where('prj_id', $id);
		$insert = $this->db->update('re_projectms', $data);
		return $insert;
		
	}
	function checked($id)
	{
		$data=array( 
			'checked_by' =>$this->session->userdata('userid'),
			'report_status'=>'CHECKED'
		);
		$this->db->where('prj_id', $id);
		$insert = $this->db->update('re_prjfstimestamp', $data);
		//$tot=$bprice*$quontity; 
		
		return $insert;
		
	}
	function get_evereport_user_action_data($prjid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$query = $this->db->get('re_prjfstimestamp'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
	}
	function delete($id)
	{
		//$tot=$bprice*$quontity; 
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('re_projectcomment');
		$this->db->where('prj_id', $id);
		$insert = $this->db->delete('re_projectms');
		return $insert;
		
	}
	function commetnadd()
	{
		$this->db->where('project_code', $this->input->post('project_code'));
		$insert = $this->db->delete('re_projectcomment');
		
		
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
	//odiliya new modification // update sales commission value
	//2019-04-16
	function update_sales_commision($prjid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
	
		$query = $this->db->get('re_prjfprice'); 
		if ($query->num_rows() > 0){
		$data= $query->result(); 
		$tot=0;
			foreach($data as $raw)
			{
			$tot=$tot+($raw->perches_count*$raw->price);
			}
				$salescom=($tot*get_rate('Sales Commision'))/100;
				$markieting_com=($tot*get_rate('Development & Marketing Commission'))/100;
				$totcom=$markieting_com+$salescom;
				$this->db->where('prj_id', $prjid);
				$this->db->where('subtask_id', 26);
				$insert = $this->db->delete('re_prjfsubtask');
				$data=array( 
	//	'prj_id'=>$id,
					'prj_id' => $prjid,
					'task_id' => 8,
					'budget' =>$salescom,
					'subtask_id' => 26,
					'update_by' =>$this->session->userdata('username'),
					'last_update' =>date("Y-m-d") ,
					);
					$insert = $this->db->insert('re_prjfsubtask', $data);
					$this->db->where('prj_id', $prjid);
				$this->db->where('subtask_id', 27);
				$insert = $this->db->delete('re_prjfsubtask');
					$data=array( 
	//	'prj_id'=>$id,
					'prj_id' => $prjid,
					'task_id' => 8,
					'budget' =>$markieting_com,
					'subtask_id' => 27,
					'update_by' =>$this->session->userdata('username'),
					'last_update' =>date("Y-m-d") ,
					);
					$insert = $this->db->insert('re_prjfsubtask', $data);
					$this->db->where('prj_id', $prjid);
				$this->db->where('task_id', 8);
				$insert = $this->db->delete('re_prjftask');
					$data=array( 
				//	'prj_id'=>$id,
					'prj_id' => $prjid,
					'task_id' => 8,
					'budget' => $totcom,
						);
					$insert = $this->db->insert('re_prjftask', $data);
					$this->update_prjpayment($prjid,8,$totcom);
			
		}
		else
		return false;
	}
	//odiliya new modification // update sales commission value
	//2019-04-16
	function get_project_master_data($prjid) { //get all stock
		$this->db->select('re_projectms.*');
		$this->db->where('prj_id',$prjid);
	
		$query = $this->db->get('re_projectms'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
	function update_cost_of_capital($prjid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
	
		$query = $this->db->get('re_prjftask'); 
		if ($query->num_rows() > 0){
		$data= $query->result(); 
		$tot=0;
			foreach($data as $raw)
			{
			$tot=$tot+($raw->budget);
			}$markieting_com=0;
				$this->db->where('prj_id', $prjid);
				$this->db->where('subtask_id', 27);
				$query = $this->db->get('re_prjfsubtask'); 
				if ($query->num_rows() > 0){
					$taskdata=$query->row();
					$markieting_com=$taskdata->budget;
				}
				$totcost=$tot-$markieting_com;
				$projectdata=$this->get_project_master_data($prjid);
				$costof_cap=($totcost*$projectdata->land_bank*$projectdata->period)/(100*12);
				$totcom=$markieting_com+$salescom;
			
					$this->db->where('prj_id', $prjid);
					$this->db->where('task_id', 9);
					$insert = $this->db->delete('re_prjftask');
					$data=array( 
				//	'prj_id'=>$id,
					'prj_id' => $prjid,
					'task_id' => 9,
					'budget' => $costof_cap,
						);
					$insert = $this->db->insert('re_prjftask', $data);
					$this->update_prjpayment($prjid,8,$totcom);
			
		}
		else
		return false;
	}
	function dpcost_only($prjid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->where('task_id',5);
		$this->db->order_by('task_id');
		$query = $this->db->get('re_prjrtask'); 
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->budget ;
		}
		else
		return 0;
	}
	function purchasing_price_only($prjid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->where('task_id',1);
		$this->db->order_by('task_id');
		$query = $this->db->get('re_prjrtask'); 
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->budget ;
		}
		else
		return 0;
	}
	function special_task_cost($prjid,$taskid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->where('task_id',$taskid);
		$this->db->order_by('task_id');
		$query = $this->db->get('re_prjrtask'); 
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->budget ;
		}
		else
		return 0;
	}
	function special_subtasklist($prjid,$taskid)
	{
		$this->db->select('re_prjfsubtask.*,cm_subtask.subtask_name');
		$this->db->join('cm_subtask','cm_subtask.subtask_id=re_prjfsubtask.subtask_id');
		$this->db->where('re_prjfsubtask.prj_id',$prjid);
		$this->db->where('re_prjfsubtask.task_id',$taskid);
		
		$query = $this->db->get('re_prjfsubtask'); 
		if ($query->num_rows() > 0){
		$data= $query->result();
		return $query->result() ;
		}
		else
		return false;
	}
	function marketing_commission($prjid)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prjid);
		$this->db->where('subtask_id', 27);
	
		$query = $this->db->get('re_prjfsubtask'); 
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->budget ;
		}
		else
		return 0;
	}
}