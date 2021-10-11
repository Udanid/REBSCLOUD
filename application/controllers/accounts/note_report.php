<?php

class Note_report extends CI_Controller {
    var $acc_array;
    var $account_counter;
    function Report()
    {
        parent::__construct();
        $this->load->model('Ledger_model');
        $this->load->helper(array('form', 'url'));
		$this->load->model('common_model');
		$this->is_logged_in();

        /* Check access */
        if ( ! check_access('view reports'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('');
            return;
        }

        return;
    }

    function index()
    {
        //$this->template->set('page_title', 'Reports');
        //$this->template->load('template', 'report/index');
        $this->load->view('accounts/report/index');
        return;
    }



    function note_report_main($period = NULL)
  	{
  		//$this->template->set('page_title', 'Balance Sheet');
  		//$this->template->set('nav_links', array('report/download/balancesheet' => 'Download CSV', 'report/printpreview/balancesheet' => 'Print Preview'));
  		$data['left_width'] = "450";
  		$data['right_width'] = "450";
  		$this->load->view('accounts/note_report/note_report_main', $data);
  		//$this->template->load('template', 'report/balancesheet', $data);
  		return;
  	}
  	function note_reports($period = NULL)
  	{
  		//$this->template->set('page_title', 'Balance Sheet');
  		//$this->template->set('nav_links', array('report/download/balancesheet' => 'Download CSV', 'report/printpreview/balancesheet' => 'Print Preview'));
  		if ($_POST)
  		{
  			$month = $this->input->post('month', TRUE);
  			$fromdate = $this->input->post('fromdate', TRUE);
  			$todate = $this->input->post('todate', TRUE);
  		}
  		if($fromdate=="" && $todate=="")
  		{
  			redirect('accounts/note_report/note_report_main');
  		}
      if($month=="01"){
        $data['month']=$month;
    		$data['fromdate']=$fromdate;
    		$data['todate']=$todate;
    		$data['left_width'] = "450";
    		$data['right_width'] = "450";
    		$this->load->view('accounts/note_report/note_report', $data);
    		//$this->template->load('template', 'report/balancesheet', $data);
    		return;
      }elseif($month=="02"){
        $data['month']=$month;
    		$data['fromdate']=$fromdate;
    		$data['todate']=$todate;
    		$data['left_width'] = "450";
    		$data['right_width'] = "450";
    		$this->load->view('accounts/note_report/note_report_annual', $data);
      }

  	}
    function getAccgroups($id){
  		$data = $this->Ledger_model->getAccgroups($id);
  		return $data;
  	}


}

/* End
of file report.php */
/* Location: ./system/application/controllers/report.php */
