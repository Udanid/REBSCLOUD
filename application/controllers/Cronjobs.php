<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjobs extends CI_Controller {

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

		$this->load->model("message_model");
		$this->load->model("dicalculate_model");
		$this->load->model("common_model");
		$this->load->model("eploan_model");
		$this->load->model("lotdata_model");
		$this->load->model("accountinterface_model");
		$this->load->model("hr/emp_app_model");
		$this->load->model("hr/employee_model");
		$this->load->model("andr_manager_model");
		$this->load->model("wip/Task_model");
		$this->load->model("wip/Sub_task_model");
		$this->load->model("financialtransfer_model");
		$this->load->model("dayendprocess_model");

	//	$this->is_logged_in();

    }

	function index()
	{
				$session = array('accshortcode'=>'HED');
              $this->session->set_userdata($session);

		
		while($start<=$todate)
		{
				transfer_todayint($start);
				echo 'today interest transfers updated<br>';
				capital_and_interest_transfer_onduedate($start);//financal transfer model
				echo 'capital and intrest successfully transferd<br>';
				$this->accountinterface_model->get_reservation_list_forcompleteadvance($start);
				echo 'Outright settlements updated<br>';
				$this->accountinterface_model->get_myloanlist_forupdetesettlement_NEP($start);
				echo 'NEP settlements updated<br>';
				$this->financialtransfer_model->update_settled_loans_ondayend();
					echo 'Day end settlements updated<br>';
				$this->message_model->generate_today_delaint($start);
					echo 'Generate loan delay interest<br>';
				$this->dicalculate_model->generate_advance_today_delaint($start);
					echo 'Generate Advance delay interest<br>';
					/*Ticket No:2889 Added By Madushan 2021.06.14*/
				$this->dicalculate_model->generate_advance_schedule_today_delaint($start);
					echo 'Generate Advance delay interest for shedule<br>';
				$this->message_model->add_cronjob($start);
				echo 'Corn test table updated<br>';
				$start=date('Y-m-d',strtotime('+1 day',strtotime($start)));


		}
			// tempory comment this modules till costomer provide letters
		/*		$this->message_model->generate_first_remind();
				$this->message_model->generate_second_remind();
				$this->message_model->generate_third_remind();
				$this->message_model->generate_termination_letter();
				$this->message_model->generate_resale_letter();
		*/
		//Ticket No:2385
		$this->landpayment_agreement->dueNotification();

			echo  'ssss'.$this->session->userdata('accshortcode');

	}
	function new_cornprocess()
	{
		$companies=$this->dayendprocess_model->getcompanylist();
		if($companies)
		{
			foreach($companies as $raw)
			{
				$database=$raw->company_code;
				
				
				$data1=$this->dayendprocess_model->get_last_cron($database);

				$addate= $data1->lastupdate;
				$todate=date("Y-m-d");

				$start=date('Y-m-d',strtotime('+1 day',strtotime($addate)));
				echo $database.'-'.$addate.'<br>';
				while($start<=$todate)
				{
					
					
					$this->dayendprocess_model->transfer_todayint($start,$database);
					$this->dayendprocess_model->add_cronjob($start,$database);
					$start=date('Y-m-d',strtotime('+1 day',strtotime($start)));
					
				}
			
			}
		}
	}

	//added by Eranga on 09.12.2019
	function expire_tasks_subtasks(){
		$num_tasks = $this->Task_model->expire_tasks();
		$num_stasks = $this->Sub_task_model->expire_subtasks();
		//echo $num_tasks + $num_stasks;
	}
	//end Erang's script
	function dayend()
	{
		$data=$this->emp_app_model->index();


	}
	function sms()
	{
		$this->message_model->generate_sms_alert(date('Y-m-d'));


	}


function send_mail(){
	//

}
function send_mail2()
{

}
function sendemails(){
echo 'sssss';
$this->load->model("ledgerbalance_report_model");


 $this->financialtransfer_model->update_settled_one_time();
}
/*function rate($nprest, $vlrparc, $vp, $guess = 0.25) {
    $maxit = 100;
    $precision = 14;
    $guess = round($guess,$precision);
    for ($i=0 ; $i<$maxit ; $i++) {
        $divdnd = $vlrparc - ( $vlrparc * (pow(1 + $guess , -$nprest)) ) - ($vp * $guess);
        $divisor = $nprest * $vlrparc * pow(1 + $guess , (-$nprest - 1)) - $vp;
        $newguess = $guess - ( $divdnd / $divisor );
        $newguess = round($newguess, $precision);
        if ($newguess == $guess) {
            return $newguess;
        } else {
            $guess = $newguess;
        }
    }
    return null;
}*/
function Ontime_backdate_prcess()
	{
				$session = array('accshortcode'=>'HED');
              $this->session->set_userdata($session);
			$data1=$this->message_model->get_last_cron();

		$addate= $data1->lastupdate;
		$todate=date('Y-m-d');
		$start=date('Y-m-d',strtotime('+1 day',strtotime($addate)));
		while($start<=$todate)
		{
				transfer_todayint($start);
				capital_and_interest_transfer_onduedate($start);//financal transfer model
				$this->message_model->generate_today_delaint($start);
				$this->dicalculate_model->generate_advance_today_delaint($start);
				$this->accountinterface_model->get_reservation_list_forcompleteadvance($start);
				$this->accountinterface_model->get_myloanlist_forupdetesettlement_NEP($start);

				$this->financialtransfer_model->update_settled_loans_ondayend();
			$this->message_model->add_cronjob($start);
			$start=date('Y-m-d',strtotime('+1 day',strtotime($start)));




		}

		echo  'ssss'.$this->session->userdata('accshortcode');

	}

	function datetime(){
		//echo date('Y-m-d H:i:s a');
		$addate = '2021-03-01';
		$todate=date("Y-m-d");

		$start=date('Y-m-d',strtotime('+1 day',strtotime($addate)));

		echo $start;
		echo '<br>';
		echo 	$todate;
	}

function update_instalment_number()
{
	//$this->lotdata_model->onetime_cost_adjestmant(7);
	//$this->accountinterface_model->get_reservation_list_not_transferdd_profit($start);
	$this->eploan_model->update_instalment_number();
}
}




/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
