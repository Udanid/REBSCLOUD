<?php

class Report extends CI_Controller {
    var $acc_array;
    var $account_counter;
    function Report()
    {
        parent::__construct();
        $this->load->model('Ledger_model');
        $this->load->helper(array('form', 'url'));
		$this->load->model('common_model');
		$this->load->model('paymentvoucher_model');
		$this->load->model('reciept_model');
    $this->load->model('supplier_model');
    $this->load->model('project_model');
	$this->load->model('cashflow_model');
		$this->is_logged_in();

        /* Check access */
        if ( ! check_access('view reports'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('user/');
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
	function cash_flow(){
		$data['ladgers']=$this->Ledger_model->get_active_ladgers();
		$fromdate = '';
		$todate = '';
		$ledger_id ='';
		if ($_POST)
		{
			$ledger_id = $this->input->post('ledger_id',TRUE);
			$fromdate = $this->input->post('fromdate', TRUE);
			$todate = $this->input->post('todate', TRUE);
		}

		$data['print_preview'] = FALSE;
		$data['ledger_id'] = $ledger_id;
		$data['fromdate'] = $fromdate;
		$data['todate'] = $todate;

		$this->load->view('accounts/report/cash_flow',$data);
	}
}

/* End
of file report.php */
/* Location: ./system/application/controllers/report.php */
