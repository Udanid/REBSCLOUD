<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Generalpayments extends CI_Controller {

     function __construct() {
        parent::__construct();
       
        $this->load->model('paymentvoucher_model');
        $this->load->model('Entry_model');
        $this->load->model('Ledger_model');
        $this->load->model('Tag_model');
        $this->load->model('ac_projects_model');
		 $this->load->model('reservation_model');
		  $this->load->model('generalpayment_model');
		  $this->load->model('eploan_model');
        $this->load->model('cheque_model');
		//$this->load->model("project_model");
		$this->load->model('common_model');
		$this->load->model('supplier_model');
		//$this->load->model('generalpayment_model');
		$this->load->model('customer_model');
		$this->is_logged_in();
    }
	
	
     function index()
    {
		
		/* Form fields */
        $vouchertypes=$this->paymentvoucher_model->get_vouchertypes();
		$data['banks']=$this->Ledger_model->get_all_ac_ledgers_tomake_payment();
		$data['draccountset']=$this->Ledger_model->get_ac_ledgers_list_all();
		$data['supplier']=$this->supplier_model->get_all_supplier_summery();
		$data['customer']=$this->customer_model->get_all_customer_summery();
		

        $data['vouchertypes']=$vouchertypes;
        $data['typeid']="";
		 $data['name'] = '';
		  $data['payment_mode'] = 'CHQ';
		     $this->messages->add(validation_errors(), 'error');
        //$this->template->load('template', 'payments/add', $data);
        $this->load->view('accounts/generalpayment/index',$data);
        return;
    }
	function get_resaledata()
	{
		$data['resaletype']=$type=$this->uri->segment(4);
		if($type=='loan')
		{
			$data['resalelist']=$this->generalpayment_model->get_resale_loan();
		}
		else
		{
			$data['resalelist']=$this->generalpayment_model->get_resale_advance();
		}
	
		$this->load->view('accounts/generalpayment/refunddata', $data);
	}
	function get_resaledetails()
	{
		$data['resaletype']=$type=$this->uri->segment(4);
		$data['code']=$code=$this->uri->segment(5);
		if($type=='loan')
		{
			$resaledata=$this->generalpayment_model->get_resale_loan_data($code);
			echo "<strong>Approved Amount</strong> : ".number_format($resaledata->total_payment,2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo "<strong>Actual Paid Amount</strong> : ".number_format($resaledata->actual_paidamount,2);
		}
		else
		{
		//	echo $code;
			
			$resaledata=$this->generalpayment_model->get_resale_advance_data($code);
		//	print_r($resaledata);
			echo "<strong>Approved Amount</strong> : ".number_format($resaledata->total_payment,2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			echo "<strong>Actual Paid Amount</strong> : ".number_format($resaledata->actual_paidamount,2);
		}
	
		
	}
	function get_draccount()
	{
		$crledger=get_account_set('EP Reprocess Pay Capital Reversal');
		$draccountset=$this->Ledger_model->get_ac_ledgers_list_all();
		$data['type']=$type=$this->uri->segment(4);
		$ledgerid="";
		if($type==11)
		$ledgerid="HEDPE64000100";
		if($type==101 || $type==102)
		{
		$ledgerid=$crledger['Cr_account'];;
		}
		
		
		 echo '<select class="form-control" name="draccount" id="draccount"  required >
                 <option value="">Select Bank Account</option>';
				
                	foreach ($draccountset as $raw)
					{ 
				       if($ledgerid==$raw->id)
						 {
				 			echo '	<option value="'.$raw->id.'"  selected>'.$raw->ref_id.' -'.$raw->name.'</option>';
						}
						else
						{
							echo '	<option value="'.$raw->id.'"  >'.$raw->ref_id.' -'.$raw->name.'</option>';
						}
				 }
				 
        echo ' </select>';
	}
	
	function get_chequeboundle($ledger)
	{
		$isstart=$this->cheque_model->get_start_cheque_bundle($ledger);
      	   

			if($isstart)
			{
		//	print_r($resaledata);
			echo "<strong>Active book</strong> : ".$isstart->CHQBSNO.'- '.$isstart->CHQBNNO;
			}
			else
			echo "<strong>Boundle Not Assign Yet ";
			
	}
    function add()
    {
        $data=NULL;

        /* Check access */
        if ( ! check_access('add voucher'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('re/project/');
            return;
        }
      
	  

            
//            var_dump($data_date);
//            die();
		   $id=$this->generalpayment_model->add_payment();

          
            if ( $id)
            {
                  $this->session->set_flashdata('msg', 'Added Payment Voucher success');
				redirect('accounts/payments/index');
                
                return;
            } else {
                $this->db->trans_complete();
                  $this->session->set_flashdata('error', 'Error Adding Data');
				redirect('accounts/payments/index');
                return;
            }
        
        return;
    }

    
    function update_process()
    {
        if ( ! check_access('add voucher'))
        {

            redirect('accounts/paymentvouchers/index');
            return;
        }
        $id=$this->generalpayment_model->get_resale_advance_data_update();
		   $id=$this->generalpayment_model->get_resale_loan_data_update();


        

    }


}

/* End of file account.php */
/* Location: ./system/application/controllers/account.php */
