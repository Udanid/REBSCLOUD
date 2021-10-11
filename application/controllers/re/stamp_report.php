<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stamp_report extends CI_Controller {
   function __construct() {
        parent::__construct();
		$this->load->model("stamp_report_model");
    }
	
    function index() {
		
        $data=NULL;
        if ( ! check_access('view_stamp_report'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('re/home');
            return;
        }
        redirect('re/stamp_report/stamp_report_main');

    }

    function stamp_report_main(){
        $this->load->view('re/report/stamp_duty_report_main');
    }

    function get_stamp_date_range(){
        $quarter_range = "";
        $rct_tot = 0;
        $no_of_rct = 0;
        $data['quarter'] = "";
        $data['fromdate'] = $fromdate = $this->uri->segment(4);
        $data['todate'] = $todate = $this->uri->segment(5);
        $data['stamp_report_data'] = $stamp_report_data = $this->stamp_report_model->get_stamp_date_range($fromdate,$todate);
        if($data['stamp_report_data'])
        {
            foreach($data['stamp_report_data'] as $row)
            {   
            $no_of_rct += 1;
            $rct_tot = $rct_tot + floatval($row->pay_amount).'<br>';

            }
        }
        $data['rct_tot'] = $rct_tot;
        $data['no_of_rct'] = $no_of_rct;
        $data['quarter_range'] =  $quarter_range;
        $this->load->view('re/report/stamp_duty_report',$data);
    }

    function get_stamp_quater(){
        $quarter_range = "";
        $rct_tot = 0;
        $no_of_rct = 0;
        $start_month = 0;
        $end_month = 0;
        $data['quarter'] = $quarter = $this->uri->segment(4);
        $year = $this->uri->segment(5);
        if($quarter == '01'){
            $start_month = '04';
            $end_month = '06';
            $quarter_range = 'April to June '.$year;
        }
        if($quarter == '02'){
            $start_month = '07';
            $end_month = '09';
            $quarter_range = 'July to September '.$year;
        }
        if($quarter == '03'){
            $start_month = '10';
            $end_month = '12';
            $quarter_range = 'Octomber to December '.$year;
        }
        if($quarter == '04'){
            $start_month = '01';
            $end_month = '03';
            $year = $year + 1;
            $quarter_range = 'January to March '.$year;
        }
       // $data['year'] = $year = $this->uri->segment(5);
        
        $stdate=$year.'-'.$start_month.'-01';
        $data['todate']=$enddate=$year.'-'.$end_month.'-31';
        // echo $stdate.'<br>';
        // echo $enddate;
       $data['stamp_report_data'] = $stamp_report_data = $this->stamp_report_model->get_stamp_date_range($stdate,$enddate);
       if($data['stamp_report_data'])
        {
            foreach($data['stamp_report_data'] as $row)
            {   
            $no_of_rct += 1;
            $rct_tot = $rct_tot + floatval($row->pay_amount).'<br>';

            }
        }
        $data['rct_tot'] = $rct_tot;
        $data['no_of_rct'] = $no_of_rct;
        $data['quarter_range'] = $quarter_range;
        // foreach($data['cost_report_data'] as $row)
        // {
        //     echo $row->full_cost.'<br>';
        // }
        $this->load->view('re/report/stamp_duty_report',$data);
    }
}
?>