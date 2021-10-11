<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class yearend_model extends CI_Model {

    function __construct() {
        parent::__construct();
		//$this->load->model('Ledger_model');
    }
	function check_year($year)
	{
		$this->db->select('id');
		$this->db->where('year',$year);
		$query = $this->db->get('ac_finance_year'); 
		 if ($query->num_rows() > 0) {
            return true;
        }
		else
		return false; 
	}
	
	function clean_data($year){
		//get year id
		$this->db->select('id');
		$this->db->where('year',$year);
		$query = $this->db->get('ac_finance_year');
		$year_id = $query->row()->id;
		
		//delete data from ac_previous_balances table
		$this->db->where('year_id', $year_id);
		$this->db->delete('ac_previous_balances');
		
		//delete account_year
		$this->db->where('year', $year);
		$this->db->delete('ac_finance_year');
	}
	
	function get_years(){
		$this->db->select('year');
		$query = $this->db->get('ac_finance_year');
		if($query->num_rows() > 0){
			return $query->result();
		}
	}
	
	function change_year($year){
		if($year == 'current'){
			$this->db->select('fy_start,fy_end');
			$query = $this->db->get('cm_settings');
			$data = $query->row();
			$session = array('fy_start'=>$data->fy_start,'fy_end'=>$data->fy_end);
			$this->session->set_userdata($session);
			return true; 
		}else{
			$this->db->select('start_date,end_date');
			$this->db->where('year',$year);
			$query = $this->db->get('ac_finance_year');
			$data = $query->row();
			$session = array('fy_start'=>$data->start_date,'fy_end'=>$data->end_date);
			$this->session->set_userdata($session);
			return true;
		}
	}
	
	function run_yearend_process($year,$start_date,$end_date){
		//add year to ac_finance_year table
		$data = array(
			'year'			=>	$year,
			'start_date'	=>	date('Y-m-d',strtotime($end_date.' +1 day')),
			'end_date'		=> 	date('Y-m-d',strtotime($end_date.' +1 year'))
		);
		$this->db->trans_start();
		$this->db->insert('ac_finance_year', $data);	
		$year_id = $this->db->insert_id();
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
			
			//get all the ledger accounts
			$this->db->select('id,op_balance,op_balance_dc');
			$query = $this->db->get('ac_ledgers');

			if ($query->num_rows() > 0) {
				
				//get year id
				$this->db->select('*');
				$this->db->where('year',$year);
				$query2 = $this->db->get('ac_finance_year'); 
				if ($query2->num_rows() >0) {
					$year_id =  $query2->row()->id;
				}
				
				foreach ($query->result() as $raw){
					
					$ledger_id = $raw->id;
					$op_balance = $raw->op_balance;
					$op_balance_dc = $raw->op_balance_dc;
					
					//now we get the closing balance of the ledger and update ac_ledgers table op_balance
					$new_op_balance = $this->Ledger_model->get_ledger_balance_todate($ledger_id,$end_date);
					
					//if the balance is minus figure, we change the op balance type and update with absolute figure.
					if($op_balance_dc=='D' && $new_op_balance < 0){
						$op_balance_dc_etd = 'C';
					}
					else if($op_balance_dc=='C' && $new_op_balance > 0){
						$op_balance_dc_etd = 'C';
					}else{
						$op_balance_dc_etd = $op_balance_dc;
					}
					$new_op_balance_edt = abs($new_op_balance);
					
					//insert new data into ac_previous_balances table
					$data = array(
						'year_id'		=>	$year_id,
						'ledger_id'		=>	$ledger_id,
						'op_balance'	=>	$new_op_balance_edt,
						'op_balance_dc'	=>	$op_balance_dc_etd
					);
					$this->db->insert('ac_previous_balances', $data);					
					
					//now update ledger balances
					$data = array('op_balance' => $new_op_balance_edt,'op_balance_dc' => $op_balance_dc_etd);    
					$this->db->where('id', $ledger_id);
					$this->db->update('ac_ledgers', $data);
					
				}
				//update new account year
				$data = array(
					'fy_start'	=>	date('Y-m-d',strtotime($end_date.' +1 day')),
					'fy_end'	=>	date('Y-m-d',strtotime($end_date.' +1 year'))
				);
				$this->db->update('cm_settings', $data);
				
				return true;
			
			}
			
		}
	}
	
	function check_year_lock(){
		$year = date('Y',strtotime($this->session->userdata('fy_end').' -1 year'));
		$this->db->select('locked');
		$this->db->where('year',$year);
		$query = $this->db->get('ac_finance_year'); 
		 if ($query->num_rows() >0) {
            return $query->row()->locked;
        }
		else
		return false; 	
	}
	
	function check_lock($year){
		$this->db->select('locked');
		$this->db->where('year',$year);
		$query = $this->db->get('ac_finance_year'); 
		 if ($query->num_rows() >0) {
            return $query->row()->locked;
        }
		else
		return false; 	
	}
	
	function lock_year($year){
		$data = array('locked' => '1');    
		$this->db->where('year', $year);
		$this->db->trans_start();
		$this->db->update('ac_finance_year', $data);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function lock_lastyear($year){
		$this->load->model('Ledger_model');
		
		$this->db->select('locked');
		$this->db->where('year', $year);
		$query = $this->db->get('ac_finance_year');
		if ($query->num_rows() >0) {
			$status = $query->row()->locked;
		}
		
		$data = array('locked' => '1');    
		$this->db->where('year', $year);
		$this->db->trans_start();
		$this->db->update('ac_finance_year', $data);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			
			//get year id
			$this->db->select('*');
			$this->db->where('year',$year);
			$query = $this->db->get('ac_finance_year'); 
			if ($query->num_rows() >0) {
				$year_id =  $query->row()->id;
				$start_date = $query->row()->start_date;
				$end_date = $query->row()->end_date;
			}
			
			//$start_date = date('Y-m-d', strtotime($this->session->userdata('fy_start'). ' - 1 year'));
			//$end_date = date('Y-m-d', strtotime($this->session->userdata('fy_end'). ' - 1 year'));
			
			
			if(date('Y') == $year || $status == 0){
				//get all the ledger accounts
				$this->db->select('id,op_balance,op_balance_dc');
				$query = $this->db->get('ac_ledgers');
			}else{ 
				$this->db->select('ac_previous_balances.ledger_id as id,ac_previous_balances.op_balance,ac_previous_balances.op_balance_dc');
				$this->db->join('ac_finance_year','ac_finance_year.id=ac_previous_balances.year_id');
				$this->db->where('ac_finance_year.year',$year);
				$query = $this->db->get('ac_previous_balances');
			} 
				
			if ($query->num_rows() >0) {
				
				foreach ($query->result() as $raw){
					
					$ledger_id = $raw->id;
					$op_balance = $raw->op_balance;
					$op_balance_dc = $raw->op_balance_dc;
					
					if($status == 1){
						$this->db->delete('ac_previous_balances');
						$this->db->join('ac_finance_year','ac_finance_year.id=ac_previous_balances.year_id');
						$this->db->where('ac_finance_year.year',$year);
					}
					
					//insert new data into ac_previous_balances table
					$data = array(
						'year_id'		=>	$year_id,
						'ledger_id'		=>	$ledger_id,
						'op_balance'	=>	$op_balance,
						'op_balance_dc'	=>	$op_balance_dc
					);
					$this->db->trans_start();
					$this->db->insert('ac_previous_balances', $data);	
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
					}
					else
					{
						$this->db->trans_commit();
						
						//now we get the closing balance of the ledger and update ac_ledgers table op_balance
						$new_op_balance = $this->Ledger_model->get_ledger_balance_todate($ledger_id,$end_date);
						
						//if the balance is minus figure, we change the op balance type and update with absolute figure.
						if($op_balance_dc=='D' && $new_op_balance < 0){
							$op_balance_dc_etd = 'C';
							$new_op_balance_edt = abs($new_op_balance);
						}
						
						else if($op_balance_dc=='C' && $new_op_balance > 0){
							$op_balance_dc_etd = 'C';
							$new_op_balance_edt = abs($new_op_balance);
						}else{
							$new_op_balance_edt = abs($new_op_balance);
							$op_balance_dc_etd = $op_balance_dc;
						}
						
						if(date('Y') == $year){
							$data = array('op_balance' => $new_op_balance_edt,'op_balance_dc' => $op_balance_dc_etd);    
							$this->db->where('id', $ledger_id);
							$this->db->update('ac_ledgers', $data);
							
							$data = array(
								'fy_start'	=>	$this->session->userdata('fy_end'),
								'fy_end'	=>	date('Y-04-01', strtotime($this->session->userdata('fy_end').' +1 year'))
							);
							$this->db->update('cm_settings', $data);
						}
						
					}
				}
				
				//update new account year
				/*$data = array(
					'fy_start'	=>	$this->session->userdata('fy_end'),
					'fy_end'	=>	date('Y-04-01', strtotime($this->session->userdata('fy_end').' +1 year'))
				);
				$this->db->update('cm_settings', $data);*/	
				
				return true;
			}
			else
			{
				return false; 
			}
		}
	}
	
	function check_previousyear_lock() {
		$this->db->select('locked');
		$this->db->where('year',date('Y',strtotime($this->session->userdata('fy_end').' -1 year')));
		$query = $this->db->get('ac_finance_year'); 
		 if ($query->num_rows() >0) {
            return $query->row()->locked;

        }else{
			return false;	
		}
    }
	
	function get_last_year($thisyear){
		$this->db->select('start_date,end_date');
		$this->db->where('year',$thisyear);
		$query = $this->db->get('ac_finance_year'); 
		 if ($query->num_rows() >0) {
            $strdate = $query->row()->start_date;
			$enddate = $query->row()->end_date;
			$year = array(
						'start' => $strdate,
						'end'	=>	$enddate
					);
			return $year;

        }else{
			return false;	
		}	
	}
	
}