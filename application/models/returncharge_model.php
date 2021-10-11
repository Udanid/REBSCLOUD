<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class returncharge_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	function get_pending_return_charge($cus_code)
	{
		$this->db->select('SUM(amount) as tot');
		$this->db->where('cus_code',$cus_code);
		$this->db->where('status','PENDING');
		$query = $this->db->get('re_chequecancel'); 
		 if ($query->num_rows >0) {
           $data=$query->row();
		   return  $data->tot;
        }
		else
		return 0; 
	}
	function update_pending_cheque_charge($cus_code,$incomeid)
	{
					$insert_data=array('status'=>'PAID',
					'pay_incomeid'=>$incomeid,
					'pay_date'=>date('Y-m-d'));
						$this->db->where('cus_code',$cus_code);
						$this->db->where('status','PENDING');
						if ( ! $this->db->update('re_chequecancel', $insert_data))
						{
							 	 $this->db->trans_rollback();
								 $this->messages->add('Error addding Entry.', 'error');
		  		
						 return;
						} 
	}
	function revert_cheque_charge_payment($incomeid)
	{
					$insert_data=array('status'=>'PENDING',
					'pay_incomeid'=>'',
					'pay_date'=>'');
						$this->db->where('pay_incomeid',$incomeid);
						if ( ! $this->db->update('re_chequecancel', $insert_data))
						{
							 	 $this->db->trans_rollback();
								 $this->messages->add('Error addding Entry.', 'error');
		  		
						 return;
						} 
	}
	
	

}