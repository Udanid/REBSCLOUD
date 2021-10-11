<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_shedule extends CI_Controller {

	/**
	 * Index Page for this controller.intorducer
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 function __construct() {
        parent::__construct();

		$this->load->model("add_shedule_model");
		$this->load->model('entry_model');
		
    }

    function test()
	{
		$reservation_data = $this->add_shedule_model->get_all_reservations();
		if($reservation_data)
		{	
			
			foreach($reservation_data as $row)
			{	$status = "PENDING";
				if(!$this->entry_model->check_shedule_create($row->res_code))
				{
					if($row->min_down <= $row->down_payment)
					$status = "PAID";
					$data = array(
						'res_code'=>$row->res_code,
						'installment_number'=>'1',
						'amount'=>$row->min_down,
						'due_date'=>$row->dp_cmpldate,
						'paid_date'=>$row->last_dpdate,
						'paid_amount'=>$row->down_payment,
						'status'=>$status,
					);

			  		$this->add_shedule_model->add_shedule($data);
				}
				
			}
		}
	}
	
	function test2()
	{
		$reservation_data = $this->add_shedule_model->get_all_reservations_status();
		if($reservation_data)
		{	
			$count=0;
		
			foreach($reservation_data as $row)
			{	$status = "PENDING";
				if($row->status!='SOLD')
				{
						$count++;
					echo $count.')'.$row->project_name.'-'.$row->res_date.'-profstat--'.$row->res_status.'-lotstat--'.$row->status.'<br>';
					$data = array(
						'status'=>'SOLD',
						
					);
					$this->db->where('lot_id',$row->lot_id);
					$this->db->update('re_prjaclotdata',$data);
					
				}
				
			}
		}
	}
}

