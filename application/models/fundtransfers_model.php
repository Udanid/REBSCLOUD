<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class fundtransfers_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	function get_transfer_list($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('re_prjacbudgettrn.*,re_projectms.project_name,re_projectms.project_code,cm_tasktype.task_name');
		if(! check_access('all_branch'))
		$this->db->where('re_prjacbudgettrn.branch_code',$branchid);
		$this->db->join('re_projectms','re_projectms.prj_id=re_prjacbudgettrn.to_prj_id');
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacbudgettrn.to_task_id');
		$this->db->order_by('re_prjacbudgettrn.cr_date','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjacbudgettrn'); 
		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		else
		return false;
		
    }
	function get_project_to_task($id)
	{
		$this->db->select('re_prjacpaymentms.*,cm_tasktype.task_name');
		
		$this->db->where('re_prjacpaymentms.prj_id',$id);
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentms.task_id');
		$this->db->order_by('cm_tasktype.task_id');
	
		$query = $this->db->get('re_prjacpaymentms'); 
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false; 
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


	function check_paymentledger_set()
	{
		$this->db->select('*');
		
		$this->db->where('ledger_id',NULL);
		$this->db->where('status','CONFIRMED');
		$query = $this->db->get('cm_tasktype'); 
		if ($query->num_rows() > 0){
		//echo $query->num_rows();
			return 1;
		}
		else
		return 0;
		
	}
	function get_all_payto_projectlist($branchid) { //get all stock
		$this->db->select('re_projectms.prj_id,re_projectms.project_name,re_projectms.project_code');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->where('re_projectms.status',CONFIRMKEY);;
		$this->db->order_by('re_projectms.prj_id');
		$query = $this->db->get('re_projectms'); 
		return $query->result(); 
    }
	
	function get_ledgerid_set($task_id)
	{
		$this->db->select('ledger_id');
		
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
	function get_payment_data($voucherid)
	{
		$this->db->select('*');
		
		$this->db->where('voucherid',$voucherid);
		
		$query = $this->db->get('re_prjacpaymentdata'); 
		if ($query->num_rows() > 0){
		//$data= $query->row();
			return $query->row();
		}
		else
		return 0;
		
	}
	
	function add_fundtransfers_internal($totask,$fromtaks,$trn_type,$amount,$description,$prj_id,$topjid,$date)
	{
		//$tot=$bprice*$quontity; getmaincode($idfield,$prifix,$table)
		$this->db->trans_start();
		
		$id=$this->get_nextid('trn_id','re_prjacbudgettrn');
		$data=array( 
		'trn_id'=>$id,
		'branch_code' => $this->session->userdata('branchid'),
		'trn_type' => $trn_type,
		'from_prj_id' => $prj_id,
		'to_prj_id' => $topjid,
		'from_task_id' => $fromtaks,
		'to_task_id' => $totask,
		'amount' => floatval($amount),
		'description' =>$description,
		'cr_date' =>$date,
		'cr_by' =>$this->session->userdata('username'),
		
		
		);
		if(!$this->db->insert('re_prjacbudgettrn', $data))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error confirming Project");
			return false;
		}
	
		$this->db->trans_complete();

		return $id;
		
	}
	function add_fundtransfers_external($totask,$trn_type,$amount,$description,$prj_id,$date)
	{
		//$tot=$bprice*$quontity; getmaincode($idfield,$prifix,$table)
		$this->db->trans_start();
		
		$id=$this->get_nextid('trn_id','re_prjacbudgettrn');
		$data=array( 
		'trn_id'=>$id,
		'branch_code' => $this->session->userdata('branchid'),
		'trn_type' => $trn_type,
		'to_prj_id' => $prj_id,
		'to_task_id' => $totask,
		'amount' => floatval($amount),
		'description' =>$description,
		'cr_date' =>$date,
		'cr_by' =>$this->session->userdata('username'),
		
		
		);
		if(!$this->db->insert('re_prjacbudgettrn', $data))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error confirming Project");
			return false;
		}
	
		$this->db->trans_complete();

		return $id;
		
	}
	function add_budget($to_prj_id,$to_task_id,$amount)
	{
		$this->db->select('re_prjacpaymentms.*');
		
		$this->db->where('re_prjacpaymentms.prj_id',$to_prj_id);
		$this->db->where('re_prjacpaymentms.task_id',$to_task_id);
	
		$query = $this->db->get('re_prjacpaymentms'); 
		 if ($query->num_rows >0) {
           $dataset=$query->row();
		   $tot=floatval($dataset->new_budget)+ floatval($amount);
		   $data=array( 
			'new_budget' => $tot,
			);
			$this->db->where('re_prjacpaymentms.prj_id',$to_prj_id);
			$this->db->where('re_prjacpaymentms.task_id',$to_task_id);
			$insert = $this->db->update('re_prjacpaymentms', $data);
			return true;
		 }
		 else 
		 return false;
	}
	function reduce_budget($to_prj_id,$to_task_id,$amount)
	{
		$this->db->select('re_prjacpaymentms.*');
		
		$this->db->where('re_prjacpaymentms.prj_id',$to_prj_id);
		$this->db->where('re_prjacpaymentms.task_id',$to_task_id);
	
		$query = $this->db->get('re_prjacpaymentms'); 
		 if ($query->num_rows >0) {
           $dataset=$query->row();
		   $current_availabel=$dataset->new_budget-$dataset->tot_payments;
		   if($current_availabel>=$amount)
		   {
		   $tot=floatval($dataset->new_budget)- floatval($amount);
		   $data=array( 
			'new_budget' => $tot,
			);
			$this->db->where('re_prjacpaymentms.prj_id',$to_prj_id);
			$this->db->where('re_prjacpaymentms.task_id',$to_task_id);
			$insert = $this->db->update('re_prjacpaymentms', $data);
			return true;
		   }
		   else
		    return false;
		 }
		 else 
		 return false;
	}
	function cost_adjustment($prj_id,$amount)
	{
		$currentprjex=project_expence($prj_id);
		
		$totpuerch=0;
		$this->db->select('SUM(sale_val) as totext');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('price_perch >',0.00);
		$this->db->where('status !=','SOLD');
		$this->db->group_by('prj_id');
		$query = $this->db->get('re_prjaclotdata'); 
			if ($query->num_rows() > 0){
				$data= $query->row();
			$saleval=$data->totext;
			//$perchcost=$currentprjex/$saleval;
			//echo $perchcost;
			//$perchcost=round($perchcost, 2);
			
			$this->db->select('*');
			$this->db->where('prj_id',$prj_id);
			$this->db->where('price_perch >',0.00);
			$this->db->where('status !=','SOLD');
			$query = $this->db->get('re_prjaclotdata'); 
			$data=$query->result();
			$totesp=0;
			$lastid=0;
			$lastidval=0;
			foreach($data as $raw)
			{
				$adcost=($amount*$raw->sale_val)/$saleval;
				$necost=$raw->costof_sale+$adcost;
				$necost=round($necost, 2);
				if($raw->sale_val>0)
				{
				$lastid=$raw->lot_id;
				$lastidval=$necost;
				}
				
				$totesp=$totesp+round($adcost, 2);
				$inst=array('costof_sale'=>$necost);
				$this->db->where('lot_id', $raw->lot_id);
				$insert = $this->db->update('re_prjaclotdata', $inst);
			}
			$adjestment=$amount-$totesp;
			if($adjestment>0)
			{
				$lastidval=$lastidval+$adjestment;
			}
			else
			$lastidval=$lastidval-((-1)*$adjestment);
			$inst=array('costof_sale'=>$lastidval);
			$this->db->where('lot_id', $lastid);
				$insert = $this->db->update('re_prjaclotdata', $inst);
			
		}
		
		
		
	}
	function get_projectstatus($prj_id) { //get all stock
		$this->db->select('re_projectms.status,re_projectms.budgut_status,re_projectms.price_status');
		$this->db->where('re_projectms.prj_id',$prj_id);
		//$this->db->where('re_projectms.status',CONFIRMKEY);;
		$this->db->order_by('re_projectms.prj_id');
		$query = $this->db->get('re_projectms'); 
		return $query->row(); 
    }
	function confirm($id)
	{
		//$tot=$bprice*$quontity;
		$this->db->select('*');
		
		$this->db->where('trn_id',$id);
		$query = $this->db->get('re_prjacbudgettrn'); 
		if ($query->num_rows() > 0){
			$data=$query->row();
			if($data->trn_type!='External' )
			{
				if($this->reduce_budget($data->from_prj_id,$data->from_task_id,$data->amount))
				{
					
				
					$this->add_budget($data->to_prj_id,$data->to_task_id,$data->amount);
					$toledger=$this->get_ledgerid_set($data->to_task_id);
					$fromledger=$this->get_ledgerid_set($data->from_task_id);
					$crlist[0]['ledgerid']=$this->session->userdata('accshortcode').$toledger->ledger_id;
					$crlist[0]['amount']=$crtot=$data->amount;
					$drlist[0]['ledgerid']=$this->session->userdata('accshortcode').$fromledger->ledger_id;
					$drlist[0]['amount']=$drtot=$data->amount;
					$narration = $data->description;
					$delay_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$data->cr_date,$narration,$data->to_prj_id,'','');
					insert_oumit_transactions($delay_entry,'','',$data->to_prj_id,'',date('Y-m-d'),'Fund Transfer');
					$data=array( 
					'status' => CONFIRMKEY,
					);
					$this->db->where('trn_id', $id);
					$insert = $this->db->update('re_prjacbudgettrn', $data);
					
					
					return true;
				}
				else
				return false;
				
			}
			else
			{
					$this->add_budget($data->to_prj_id,$data->to_task_id,$data->amount);
					$prjstat=$this->get_projectstatus($data->to_prj_id);
					
					$taskledger=$this->get_ledgerid_set($data->to_task_id);
					$ledgerset=get_account_set('Project Conformation');
					if($prjstat->price_status=='PENDING')
					$draccount=$ledgerset['Dr_account'];
					else
					$draccount=$ledgerset['Cr_account'];
					//echo $draccount.'-'.$prjstat->price_status;
					$crlist[0]['ledgerid']=$this->session->userdata('accshortcode').$taskledger->ledger_id;
					$crlist[0]['amount']=$crtot=$data->amount;
					$drlist[0]['ledgerid']=$draccount;
					$drlist[0]['amount']=$drtot=$data->amount;
					$narration = $data->description;
					$delay_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$data->cr_date,$narration,$data->to_prj_id,'','');
					insert_oumit_transactions($delay_entry,'','',$data->to_prj_id,'',date('Y-m-d'),'Fund Transfer');
					$this->cost_adjustment($data->to_prj_id,$data->amount);
					$data=array( 
					'entry_id'=>$delay_entry,
					'status' => CONFIRMKEY,
					);
					$this->db->where('trn_id', $id);
					$insert = $this->db->update('re_prjacbudgettrn', $data);
					return true;
			}
			
			return false;
		
		
		}
		else
		return false;
		
		
	}
	function delete($id)
	{
		//$tot=$bprice*$quontity;
		if($id) 
		{
			$this->db->where('trn_id', $id);
					$insert = $this->db->delete('re_prjacbudgettrn', $data);
		}
		
	}
 function get_nextid($idfield,$table)
	{
	
 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table );
        
		$newid="";
	
        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=1;
		

			 }
			 else{
			 //$prjid=substr($prjid,3,4);
			// echo
			 $id=intval($prjid);
			 $newid=$id+1;
			 
			
			
			 }
        }
		else
		{
		
		$newid=1;
		$newid=$newid;
		}
	return $newid;
	
	}
	function get_complete_list($pagination_counter, $page_count) { //get all stock
		$this->db->select('re_prjdvcomplete.*,re_projectms.project_name,re_projectms.project_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_prjdvcomplete.prj_id');
		//$this->db->order_by('re_prjacbudgettrn.cr_date','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjdvcomplete'); 
		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		else
		return false;
		
    }
	function get_task_fulldata($task_id)
	{
		$this->db->select('*');
		
		$this->db->where('task_id',$task_id);
	
		$query = $this->db->get('cm_tasktype'); 
		if ($query->num_rows() > 0){
		//$data= $query->row();
			return $query->row();
		}
		else
		return 0;
		
	}
	function project_complete_update($prj_id_ex,$trndate_ex,$total,$delay_entry)
	{
		$data=array( 
		'prj_id'=>$prj_id_ex,
		'cmp_date' => $trndate_ex,
		
		'entry_id' => $delay_entry,
		'trn_amount' =>$total,
	
		'cmp_by' =>$this->session->userdata('userid'),
		
		
		);
		if(!$this->db->insert('re_prjdvcomplete', $data))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error confirming Project");
			return false;
		}
		$data2=array( 
		'dp_cmp_status'=>'COMPLETE',
		);
		$this->db->where('prj_id',$prj_id_ex);
		
		if(!$this->db->update('re_projectms', $data2))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error confirming Project");
			return false;
		}
	
	}
	function get_completion_fulldata($id)
	{
		$this->db->select('*');
		
		$this->db->where('id',$id);
	
		$query = $this->db->get('re_prjdvcomplete'); 
		if ($query->num_rows() > 0){
		//$data= $query->row();
			return $query->row();
		}
		else
		return 0;
		
	}
	function delete_competion($id)
	{
		if($id)
		{
			$dataset=$this->get_completion_fulldata($id);
			if($dataset->entry_id)
			{
						$this->db->where('id', $dataset->entry_id);
						$insert = $this->db->delete('ac_entries', $data);
						$this->db->where('entry_id', $dataset->entry_id);
						$insert = $this->db->delete('ac_entry_items', $data);
			}
						$this->db->where('id', $id);
						$insert = $this->db->delete('re_prjdvcomplete', $data);
						$data2=array( 
			'dp_cmp_status'=>'PENDING',
			);
			$this->db->where('prj_id',$dataset->prj_id);
			
			if(!$this->db->update('re_projectms', $data2))
			{
					$this->db->trans_rollback();
						$this->logger->write_message("error", "Error confirming Project");
				return false;
			}
		}
			
	}
}