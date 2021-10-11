<!-- Ticket No-2683 | Added By Uvini -->
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cap_report extends CI_Controller {
   function __construct() {
        parent::__construct();
		$this->load->model("cap_report_model");
    }
	
    function index() {
		
        $data=NULL;
        if ( ! check_access('view_report'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('re/home');
            return;
        }
        redirect('re/cap_report/cap_report_main');

    }

    function cap_report_main(){
        $this->load->view('re/report/cap_report_main');
    }

    function get_cost_date_range(){
        $data['month'] = "";
        $data['fromdate'] = $fromdate = $this->uri->segment(4);
        $data['todate'] = $todate = $this->uri->segment(5);
        $data['cost_report_data'] = $this->cap_report_model->get_cost_date_range($fromdate,$todate);
        // foreach($data['cost_report_data'] as $row)
        // {
        //     echo $row->full_cost.'<br>';
        // }
        $this->load->view('re/report/cost_report',$data);
    }

    function get_cost_month(){
        $data['month'] = $month = $this->uri->segment(4);
        $data['year'] = $year = $this->uri->segment(5);
        $stdate=$year.'-'.$month.'-01';
        $data['todate']=$enddate=$year.'-'.$month.'-31';
        $data['cost_report_data'] = $this->cap_report_model->get_cost_date_range($stdate,$enddate);
        // foreach($data['cost_report_data'] as $row)
        // {
        //     echo $row->full_cost.'<br>';
        // }
        $this->load->view('re/report/cost_report',$data);
    }

    function get_turn_over_date_range()
    {
        $data['month'] = "";
        $data['fromdate'] = $fromdate = $this->uri->segment(4);
        $data['todate'] = $todate = $this->uri->segment(5);
        $data['turn_over_report_data'] = $this->cap_report_model->get_turn_over_date_range($fromdate,$todate);
        $this->load->view('re/report/turn_over_report',$data);
        // echo $fromdate.'<br>';
        // echo $todate.'<br>';

    }

    function get_turn_over_month()
    {
        $data['month'] = $month = $this->uri->segment(4);
        $data['year'] = $year = $this->uri->segment(5);
        $stdate=$year.'-'.$month.'-01';
        $data['todate']=$enddate=$year.'-'.$month.'-31';
        $data['turn_over_report_data'] = $this->cap_report_model->get_turn_over_date_range($stdate,$enddate);
        $this->load->view('re/report/turn_over_report',$data);
        // echo $fromdate.'<br>';
        // echo $todate.'<br>';

    }
}
?>