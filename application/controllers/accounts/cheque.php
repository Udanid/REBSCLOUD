<?php
//file create by udani 12-09-2013;
// file use for create edit ac_projects
class Cheque extends CI_Controller {
    function Cheque()
    {
        parent::__construct();
       
        $this->load->model('cheque_model');
		$this->load->model('common_model');
		$this->load->model('ledger_model');
		
		$this->is_logged_in();

    }
    function index()
    {
        $data=NULL;
        if ( ! check_access('create chequeboundle'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('re/project/');
            return;
        }

        /* Calculating difference in Opening Balance */
        $rcptbooks = $this->cheque_model->get_chequebooks($this->session->userdata('branchid'));
        if (!$rcptbooks)
        {
            //$this->messages->add('No Reciept Boundles In System', 'error');
        }
		$data['ledgerlist']=$this->cheque_model->get_all_ac_ledgers_bankcash();
        $data['rcptbooks'] = $rcptbooks;
        //$this->load->view('layout_acountant',$data);

        $this->load->view('accounts/cheque/index',$data);
        return;
        
        //$this->template->load('template', 'setting/cheque/chequebook',$data);
       
    }

    function add()
    {
        /* Check access */
        if ( ! check_access('create chequeboundle'))
        {
            $this->messages->add('Permission denied.', 'error');
            redirect('accounts/receipt/index');
            return;
        }
        
        /* Re-populating form */
        if ($_POST)
        {
            $data['CHQBNO']['value'] = $this->input->post('CHQBNO', TRUE);
            $data['CHQBSNO']['value'] = $this->input->post('CHQBSNO', TRUE);
            $data['CHQBNNO']['value'] = $this->input->post('CHQBNNO', TRUE);
            $data['branch_code']['value']= $this->session->userdata('branchid');
        }
        
            if($this->cheque_model->get_cheque_sequence_ledgerid($this->input->post('CHQBSNO'),$this->input->post('ledger_id')))
            {
                //$this->messages->add('Cheque Budle Sequence Already Taken', 'error');
                $this->session->set_flashdata('error', 'Cheque Budle Sequence Already Taken');

            }
            else if($this->cheque_model->get_cheque_bundle($this->input->post('CHQBNO')))
            {
                //$this->messages->add('cheque Budle Number Already Taken', 'error');
                $this->session->set_flashdata('error', 'cheque Budle Number Already Taken');
            }
			
            else if($this->input->post('CHQBSNO')>=$this->input->post('CHQBNNO'))
            {
                //$this->messages->add('Invalid Sequence', 'error');
                $this->session->set_flashdata('error', 'Invalid Sequence');
                
            }
            else
            {
              $this->cheque_model->add_chequebook();
                $this->logger->write_message("success", "Added Cheque Boundle " . $this->input->post('CHQBNO'));
                $this->session->set_flashdata('msg', 'Added Cheque Boundle - ' . $this->input->post('CHQBNO') .'success');

                $this->messages->add('Added Cheque Boundle - ' . $this->input->post('CHQBNO') . '.', 'success');
                redirect('accounts/cheque/index');
            }

          redirect('accounts/cheque/index');
        
        return;
    }

    function delete($id)
    {
        if ( ! check_access('delete chequeboundle'))
        {
            
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/cheque/index');
            return;
        }

        $id=$this->cheque_model->delete_chequebook($id);

        $this->common_model->delete_notification('ac_chequebookdata',$id);
        $this->session->set_flashdata('msg', 'Cheque Bundle Successfully Deleted ');
        $this->logger->write_message("success", $id.' Cheque Bundle successfully Deleted');
        redirect("accounts/cheque/index");

    }

    public function edit(){
        $data=NULL;
        if ( ! check_access('edit chequeboundle'))
        {
            redirect('accounts/cheque/index');
            return false;
        }
		$data['ledgerlist']=$this->cheque_model->get_all_ac_ledgers_bankcash();
        $data['details']=$this->cheque_model->get_chequebooks_by_id($this->uri->segment(4));


        $this->common_model->add_activeflag('ac_chequebookdata',$this->uri->segment(4),'CHQBID');
        $session = array('activtable'=>'ac_chequebookdata');
        $this->session->set_userdata($session);

        $this->load->view('accounts/cheque/edit',$data);
    }

    function editdata()
    {
        if ( ! check_access('edit chequeboundle'))
        {
            redirect('accounts/cheque/index');
            return;
        }
        
        $id =$this->input->post('CHQBID');
        $edit=$this->cheque_model->edit_chequebook($id);


        $this->session->set_flashdata('msg', 'Cheque Bundle Successfully Updated ');
        $this->common_model->delete_activflag('ac_chequebookdata',$this->input->post('CHQBID'),'CHQBID');
        $this->logger->write_message("success", $this->input->post('CHQBNO').'Receipt Bundle successfully Updated');
        redirect('accounts/cheque/index');

    }

//    function edit()
//    {
//        $this->load->model('cheque_model');
//        $rcptbooks = $this->cheque_model->get_chequebooks();
//        if (!$rcptbooks)
//        {
//            //	$this->messages->add('No cheque Boundles In System', 'error');
//        }
//        $data['rcptbooks'] = $rcptbooks;
//        $this->template->set('page_title', 'Edit cheque Boundle');
//
//        /* Check access */
//        if ( ! check_access('edit chequeboundle'))
//        {
//            $this->messages->add('Permission denied.', 'error');
//            redirect('ac_projects');
//            return;
//        }
//        /* Checking for valid data */
//        $id = $this->uri->segment(3);
//        $data['id']=$id;
//        $data['CHQBNO']="";
//        $data['CHQBSNO']="";
//        $data['CHQBNNO']="";
//        //	$id = (int)$id;
//        if ($id == "")// edited by Udani 10-09-2013
//        {
//            $this->messages->add('Invalid cheque Boundle.', 'error');
//            redirect('cheque');
//            return;
//        }
//        $this->db->from('ac_chequebookdata')->where('CHQBID', $id);
//        $ledger_data_q = $this->db->get();
//        if ($ledger_data_q->num_rows() < 1)
//        {
//            $this->messages->add('Invalid cheque Boundle.', 'error');
//            redirect('cheque');
//            return;
//        }
//        $ledger_data = $ledger_data_q->row();
//
//        $data['id']=$id;
//        $data['CHQBNO']=$ledger_data->CHQBNO;
//        $data['CHQBSNO']=$ledger_data->CHQBSNO;
//        $data['CHQBNNO']=$ledger_data->CHQBNNO;
//        $data['CHQBSTATUS']=$ledger_data->CHQBSTATUS;
//
//
//        $this->form_validation->set_rules('CHQBNO', 'cheque Book Number', 'trim|required|min_length[1]|max_length[100]|uniquewithid_new[ac_chequebookdata.CHQBNO.'.$ledger_data->CHQBID.'.CHQBID]');
//        //$this->form_validation->set_rules('CHQBNO', 'cheque Book Number', 'trim|required|min_length[1]|max_length[100]|uniquewithidprj[ac_chequebookdata.CHQBSNO.'.$ledger_data->CHQBSNO.']');
//        //$this->form_validation->set_rules('CHQBSNO', 'First No', 'trim|required|max_length[100]|uniquewithidprj[ac_chequebookdata.CHQBNNO.'.$ledger_data->CHQBNNO.']');
//
//
//        /* Re-populating form */
//        if ($_POST)
//        {
//            $data['CHQBNO']['value'] = $this->input->post('CHQBNO', TRUE);
//            $data['CHQBSNO']['value'] = $this->input->post('CHQBSNO', TRUE);
//            $data['CHQBNNO']['value'] = $this->input->post('CHQBNNO', TRUE);
//            $data['CHQBSTATUS']['value'] = $this->input->post('CHQBSTATUS', TRUE);
//        }
//
//        if ($this->form_validation->run() == FALSE)
//        {
//            $this->messages->add(validation_errors(), 'error');
//            $this->template->load('template', 'setting/cheque/edit', $data);
//            return;
//        }
//        else
//        {
//
//
//            if($this->input->post('CHQBSTATUS', TRUE)=="START")
//            {
//                $isstart=$this->cheque_model->get_start_cheque_bundle();
//                if(!$isstart)
//                {
//                    $this->cheque_model->edit_chequebook($id);
//                    $this->messages->add('Edit cheque Boundle - ' . $this->input->post('CHQBNO', TRUE) . '.', 'success');
//                    $this->logger->write_message("success", "Edit cheque Boundle " . $this->input->post('CHQBNO', TRUE));
//                    redirect('cheque');
//                    return;
//                }
//                else
//                {
//                    $this->messages->add('System Already has cheque Boundle', 'error');
//                    redirect('cheque');
//                    return;
//                }
//            }
//            else
//            {
//                $this->cheque_model->edit_chequebook($id);
//
//
//                $this->messages->add('Edit cheque Boundle - ' . $this->input->post('CHQBNO', TRUE) . '.', 'success');
//                $this->logger->write_message("success", "Edit cheque Boundle " . $this->input->post('CHQBNO', TRUE));
//                redirect('cheque');
//                return;
//            }
//
//        }
//        return;
//    }
//    function delete()
//    {
//        $this->load->model('cheque_model');
//        $rcptbooks = $this->cheque_model->get_chequebooks();
//        if (!$rcptbooks)
//        {
//            //	$this->messages->add('No cheque Boundles In System', 'error');
//        }
//        $data['rcptbooks'] = $rcptbooks;
//        $this->template->set('page_title', 'Edit cheque Boundle');
//
//        /* Check access */
//        if ( ! check_access('delete chequeboundle'))
//        {
//            $this->messages->add('Permission denied.', 'error');
//            redirect('cheque');
//            return;
//        }
//        /* Checking for valid data */
//        $id = $this->uri->segment(3);
//        $data['id']=$id;
//        $data['CHQBNO']="";
//        $data['CHQBSNO']="";
//        $data['CHQBNNO']="";
//        //	$id = (int)$id;
//        if ($id == "")// edited by Udani 10-09-2013
//        {
//            $this->messages->add('Invalid cheque Boundle.', 'error');
//            redirect('cheque');
//            return;
//        }
//        $this->db->from('ac_chequebookdata')->where('CHQBID', $id);
//        $ledger_data_q = $this->db->get();
//        if ($ledger_data_q->num_rows() < 1)
//        {
//            $this->messages->add('Invalid cheque Boundle.', 'error');
//            redirect('cheque');
//            return;
//        }
//
//        $data['id']=$id;
//
//        $this->cheque_model->delete_chequebook($id);
//        $this->messages->add('Delete cheque Boundle - ' .$ledger_data_q->CHQBNO . '.', 'success');
//        $this->logger->write_message("success", "Delete cheque Boundle called " . $ledger_data_q->CHQBNO );
//        redirect('cheque');
//        return;
//
//    }
//
//    function cancel_cheque()
//    {
//        $this->load->model('cheque_model');
//
//        $data['rctbooks']=$this->cheque_model->get_chequebooks();
//        //$data['cancelist']=$this->cheque_model->get_canceled_cheques();
//        //$this->load->view('layout_acountant',$data);
//
//        $this->template->load('template', 'setting/cheque/cancel_cheque',$data);
//
//    }
    function blank_list()
    {

        $id =$this->uri->segment(4);// $this->input->post('CHQBID');


        $data['bookcllist']=$book=$this->cheque_model->get_chequebooks_by_id($id);
        $data['receipt']=$receipt=$this->cheque_model->is_max_cheque_id($id);

        if($receipt->CHQNO){
            $data['minval']=intval($receipt->CHQNO)+1;}
        else{
            $data['minval']=intval($book->CHQBSNO);}
        $data['maxval']=intval($book->CHQBNNO);
        $this->load->view('accounts/cheque/blank_list',$data);

//         if($data != ""){
//             echo json_encode($data);
//        }
    }
    function process_cancel()
    {
        if ( ! check_access('edit chequeboundle'))
        {
            $this->messages->add('Permission denied.', 'error');
            redirect('cheque');
            return;
        }
        $list="0";

        $date=date("Y-m-d H:i:s");
        if($this->input->post('CHQBSNO')>$this->input->post('CHQBNNO'))
        {
            //$this->messages->add('Invalid Sequence', 'error');
            $this->session->set_flashdata('error', 'Invalid Sequence');
        }
        else if($this->input->post("CHQBID")=="")
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
            $from=$this->input->post("CHQBSNO");
            $to=$this->input->post("CHQBNNO");
            $date=date("Y-m-d H:i:s");
            $CI =& get_instance();
            for($i=$from; $i<=$to; $i++)
            {
                $newid=$i;
                $newid=str_pad($newid, 6, "0", STR_PAD_LEFT);
               // $list=$list.'-'.$newid;
//                var_dump($list);
//                die();
                $data2=array(
                    "CHQBID"=>$this->input->post("CHQBID"),
                    "CHQNO"=>$newid,
                    "CHQSTATUS"=>'CANCEL',
                    "CNDATE"=>$date,
                    "CNRES"=>$this->input->post("reason"),
                    "CNBY"=>$CI->session->userdata('userid'),

                );

                $this->db->insert('ac_chqprint',$data2);
            }
			if($this->cheque_model->is_last_chequeno($this->input->post("CHQBID"),$this->input->post("CHQBNNO")))
            {
                $rcdnewdata=array (
                    'CHQBSTATUS'=>'FINISH',
                    'CHQBENDDATE'=>date("Y-m-d H:i:s"),
                    'CHQBEBY'=>$this->session->userdata('username'),
                );
				$this->db->where('CHQBID',$this->input->post("CHQBID"))->update('ac_chequebookdata', $rcdnewdata);
			}
           // $list;
            //$this->messages->add('Successfully Canceled'.$list,  'success');
            $this->logger->write_message("success", "Successfully Canceled".$list);
            $this->session->set_flashdata('msg', 'Successfully Canceled');
        }
        redirect("accounts/cheque/index");

    }

    // Added By Kalum 2020.02.06 Ticket No 1140

    function pause_bundle(){

       if ( ! check_access('pause_bundle')){
          $this->messages->add('Permission denied.', 'error');
         redirect('accounts/cheque');
          return;
      }
        
        $data=NULL;
	$chequid=$this->uri->segment(4);
	$ledgerid=$this->uri->segment(5);
     $data=$this->cheque_model->pause_bundle($chequid,$ledgerid);

        if($data==true){
            $this->session->set_flashdata('msg', 'Successfully Change');
        }else{
           $this->session->set_flashdata('error', 'No Bundle To Start');
        }       
        
         redirect('accounts/cheque');
    }

    function start_bundle(){

        if ( ! check_access('pause_bundle')){
            $this->messages->add('Permission denied.', 'error');
            redirect('accounts/cheque');
            return;
        }
        
        $data=NULL;
$chequid=$this->uri->segment(4);
	$ledgerid=$this->uri->segment(5);
        $data=$this->cheque_model->start_bundle($chequid,$ledgerid);
        $this->session->set_flashdata('msg', 'Successfully Change');
        
       
         redirect('accounts/cheque');
    }
    // End Ticket 1140
}

/* End of file account.php */
/* Location: ./system/application/controllers/account.php */
