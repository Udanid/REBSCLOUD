<?php
// file use for create edit ac_projects
class accountsearch extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('paymentvoucher_model');
        $this->load->model('Entry_model');
        $this->load->model('Ledger_model');
        $this->load->model('Tag_model');
        $this->load->model('ac_projects_model');
        $this->load->model('cheque_model');
        $this->load->model('budgeting_model');
        $this->load->model('reciept_model');
		 $this->load->model('common_model');
		  $this->load->model('eploan_model');
		  $this->load->model('reservation_model');
		   $this->load->model('accountsearch_model');
	$this->is_logged_in();



    }
    function index()
    {
		
        $data=NULL;
		$data['recieptentrydata']=NULL;
	$data['paymentdata']=NULL;
	$data['otherdata']=NULL;
        if ( ! check_access('view_income'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('re/project/');
            return;
        }
     
		$data['ledgers']=$this->accountsearch_model->get_all_ac_ledgers();
		$data['entrytype']=$this->accountsearch_model->get_entry_type();
		$data['projects']=$this->accountsearch_model->get_project();
     
        //$data['employee']=$this->paymentvoucher_model->get_employeedata();
        $this->load->view('accounts/accountsearch/index',$data);
        return;
    }
	function check_income_expence_ledger()
	{
		echo $this->accountsearch_model->check_income_expence_ledger('HEDBL32000102');
	}

function get_blocklist($id)
{
	
		
	$data['lotlist']=$this->accountsearch_model->get_project_lots($id);
	$this->load->view('accounts/accountsearch/blocklist',$data);
}
function search()
{
	
//	print_r( $this->input->post());
	
	$ledgervalues=explode(',', $this->input->post('ledgervalues'));
	array_pop($ledgervalues);
	$type=$this->input->post('type');
	$data['recieptentrydata']=NULL;
	$data['paymentdata']=NULL;
	$data['otherdata']=NULL;
	$data['ledgers']=$this->accountsearch_model->get_all_ac_ledgers();
		$data['entrytype']=$this->accountsearch_model->get_entry_type();
		$data['projects']=$this->accountsearch_model->get_project();
		$data['ledgervalues']=$ledgervalues;
	if($type=='')
	{
		$data['recieptentrydata']=$this->accountsearch_model->get_recipet_data($ledgervalues);
		$data['paymentdata']=$this->accountsearch_model->get_payment_data($ledgervalues);
		$data['otherdata']=$this->accountsearch_model->get_other_data($ledgervalues);
	}
	else if($type=='1')
	{
		$data['recieptentrydata']=$this->accountsearch_model->get_recipet_data($ledgervalues);
	}
	else if($type=='2')
	{
		$data['paymentdata']=$this->accountsearch_model->get_payment_data($ledgervalues);
	}
	else
	{
		$data['otherdata']=$this->accountsearch_model->get_other_data($ledgervalues);
	}
	 $this->load->view('accounts/accountsearch/index',$data);

	//$data['lotlist']=$this->accountsearch_model->get_project_lots($id);
	
}



}
