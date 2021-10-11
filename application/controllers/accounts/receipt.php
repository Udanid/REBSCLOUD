<?php
class Receipt extends CI_Controller {

    function Receipt()
    {
        parent::__construct();
        $this->load->model('reciept_model');
       $this->load->model('common_model');
	   $this->load->model("branch_model");
	
		$this->is_logged_in();
      
    }
    
    
    function index()
    {
        $data=NULL;
        if ( ! check_access('edit recieptboundle'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('user');
            return;
        }

        /* Calculating difference in Opening Balance */

        $rcptbooks = $this->reciept_model->get_recieptbook($this->session->userdata('branchid'));
        if (!$rcptbooks)
        {
            	//$this->messages->add('No Reciept Boundles In System', 'error');
            //$this->session->set_flashdata('msg', 'No Receipt Bundles');
        }
        $data['rcptbooks'] = $rcptbooks;
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
        //$this->load->view('layout_acountant',$data);

        $this->load->view('accounts/receipt/index',$data);
        return;
    }
	 function cancel()
    {
        $data=NULL;
        if ( ! check_access('cancel blank recipet'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('user');
            return;
        }

        /* Calculating difference in Opening Balance */
		 $this->db->from('ac_recieptdata')->join('ac_entries','ac_entries.id=ac_recieptdata.RCTREFNO','left')->where('RCTSTATUS', 'CANCEL')->order_by('date', 'desc')->order_by('number');
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q1 = $this->db->get();
        $rcptbooks = $this->reciept_model->get_recieptbook($this->session->userdata('branchid'));
        if (!$rcptbooks)
        {
            	//$this->messages->add('No Reciept Boundles In System', 'error');
            //$this->session->set_flashdata('msg', 'No Receipt Bundles');
        }
		$data['cancellist']=$entry_q1->result();
		  $data['entry_q1'] = $entry_q1;
        $data['rcptbooks'] = $rcptbooks;
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
        //$this->load->view('layout_acountant',$data);

        $this->load->view('accounts/receipt/cancel',$data);
        return;
    }

    function add()
    {
//        $rcptbooks = $this->reciept_model->get_recieptbook();
//        $data['rcptbooks'] = $rcptbooks;
        

        /* Check access */
        if ( ! check_access('create recieptbook'))
        {
            $this->messages->add('Permission denied.', 'error');
            redirect('accounts/receipt/index');
            return;
        }

			
        /* Re-populating form */
        if ($_POST)
        {
            $data['RCTBNO']['value'] = $this->input->post('RCTBNO', TRUE);
            $data['RCTBSNO']['value'] = $this->input->post('RCTBSNO', TRUE);
            $data['RCTBNNO']['value'] = $this->input->post('RCTBNNO', TRUE);
            $data['branch_code']['value']= $this->session->userdata('branchid');

        }

            if($this->reciept_model->get_recipt_sequence($this->input->post('RCTBSNO'),$this->input->post('branch_code')))
            {
                $this->session->set_flashdata('error', 'Receipt Budle Sequence Already Taken');

            }
            else if($this->reciept_model->get_recipt_bundle($this->input->post('RCTBNO')))
            {
                $this->session->set_flashdata('error', 'Reciept Budle Sequence Already Taken');
            }
            else if($this->input->post('RCTBSNO')>=$this->input->post('RCTBNNO'))
            {
                $this->session->set_flashdata('error', 'Invalid Sequence');
            }
            else
            {
//                $aa ='aa';
//                var_dump($aa);
//                die();
                $this->reciept_model->add_recieptbook();
                $this->logger->write_message("success", "Added Receipt Boundle " . $this->input->post('RCTBSNO'));
                $this->session->set_flashdata('msg', 'Added Receipt Boundle - ' . $this->input->post('RCTBSNO') . 'successful');

                $this->messages->add('Added Receipt Boundle - ' . $this->input->post('RCTBSNO') . '.', 'success');
                redirect('accounts/receipt/index');
            }

            redirect('accounts/receipt/index');

        return;
    }



    public function edit(){
        $data=NULL;
        if ( ! check_access('edit recieptboundle'))
        {
            redirect('accounts/receipt/index');
            return false;
        }

        $data['details']=$this->reciept_model->get_recieptbook_by_id($this->uri->segment(4));


        $this->common_model->add_activeflag('ac_recieptbookdata',$this->uri->segment(4),'RCTBID');
        $session = array('activtable'=>'ac_recieptbookdata');
        $this->session->set_userdata($session);

        $this->load->view('accounts/receipt/edit',$data);
    }

    function editdata()
    {
        if ( ! check_access('edit recieptboundle'))
        {

            redirect('accounts/receipt/index');
            return;
        }
        $id=$this->reciept_model->edit_recieptbook();


        $this->session->set_flashdata('msg', 'Receipt Bundle Successfully Updated ');
        $this->common_model->delete_activflag('ac_recieptbookdata',$this->input->post('RCTBID'),'RCTBID');
        $this->logger->write_message("success", $this->input->post('RCTBNO').'Receipt Bundle successfully Updated');
        redirect('accounts/receipt/index');

    }

    function delete($id)
    {
//        var_dump($id);
//        die();
        //$id=$this->input->post('id');

        if ( ! check_access('delete recieptboundle'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('accounts/receipt/index');
            return;
        }

        $id=$this->reciept_model->delete_recieptbook($id);

        $this->common_model->delete_notification('ac_recieptbookdata',$id);
        $this->session->set_flashdata('msg', 'Receipt Bundle Successfully Deleted ');
        $this->logger->write_message("success", $id.' Receipt Bundle successfully Deleted');
        redirect("accounts/receipt/index");

    }
    
    function blank_list()
    {
        $id =$this->uri->segment(4);

        $data['bookcllist']=$book=$this->reciept_model->get_recieptbook_by_id($id);
        $data['receipt']=$receipt=$this->reciept_model->is_max_reciept_id($id);
        if($receipt->RCTNO){
            //print_r($receipt);
            $data['minval']=intval($receipt->RCTNO)+1;}
        else{
            $data['minval']=intval($book->RCTBSNO);}
        $data['maxval']=intval($book->RCTBNNO);
        $this->load->view('accounts/receipt/blank_list',$data);
    }
    function process_cancel()
    {
        if ( ! check_access('cancel blank recipet'))
        {
            $this->messages->add('Permission denied.', 'error');
            redirect('accounts/receipt/cancel');
            return;
        }

        $date=date("Y-m-d H:i:s");
        if($this->input->post('RCTBSNO')>$this->input->post('RCTBNNO'))
        {
            //$this->messages->add('Invalid Sequence', 'error');
            $this->session->set_flashdata('error', 'Invalid Sequence');
        }
        else if($this->input->post("RCTBID")=="")
        {
            //$this->messages->add('Boundle Number Cannot Be Blank', 'error');
            $this->session->set_flashdata('error', 'Bundle number cannot be blank');
        }
        else if($this->input->post("reason")=="")
        {
            //$this->messages->add('Reason Cannot Be Blank', 'error');
            $this->session->set_flashdata('error', 'Reason cannot be blank');
        }
        else
        {
            $from=$this->input->post("RCTBSNO");
            $to=$this->input->post("RCTBNNO");
            $date=date("Y-m-d H:i:s");
            for($i=$from; $i<=$to; $i++)
            {
                $newid=str_pad($i, 7, "0", STR_PAD_LEFT);
                $data2=array(
                    "RCTBID"=>$this->input->post("RCTBID"),
                    "RCTNO"=>$newid,
					'RTCBRN'=>$this->session->userdata('accshortcode'),
                    "RCTSTATUS"=>'CANCEL',
                    "CNDATE"=>$date,
                    "CNRES"=>$this->input->post("reason"),
                    "CNBY"=>$this->session->userdata('userid'),

                );
                $this->reciept_model->add_reciept($data2);
            }
            $this->logger->write_message("success", "Successfully Canceled");
            $this->session->set_flashdata('msg', 'Successfully Canceled');
        }
        redirect("accounts/receipt/cancel");

    }
}

/* End of file account.php */
/* Location: ./system/application/controllers/account.php */
