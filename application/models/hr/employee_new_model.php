<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class employee_new_model extends CI_Model
{
    function checktable($table,$emp_feild,$emp_id)
    {
        $this->db->where($emp_feild,$emp_id);
        $query=$this->db->get($table);
        if(count($query->result())>0){
            return true;
        }else{
            return false;
        }
    }



     function update_edudatasubmit_pending($data_set)
    {
        $employeeMasterID=$this->input->post('employeeMasterID', TRUE);
        $data4['emp_record_id'] = $employeeMasterID;
        $data4['school'] = $this->input->post('olschoolname', TRUE);
        $data4['updated_by'] = $this->session->userdata('username');
        $data4['status'] = "P"; 


        $check=$this->checktable('hr_olresults_update_pending','emp_record_id',$employeeMasterID);
        /*check employee data already exit */

        // start o/l document upload by dileep
        if(!empty($_FILES['oldocument']['name']))
        {
            $config['upload_path'] = './uploads/documents/OL';
            $config['allowed_types'] = '*';
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if(!($this->upload->do_upload('oldocument')))
            {

                echo "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
            }
            else
            {
                $dataol = $this->upload->data();
                $data4['document'] = base_url().'uploads/documents/OL/'.$dataol['file_name'];
            }
        }
        // end o/l document upload by dileep

        foreach($data_set['ordinary_level'] as $key=>$value){
            $subject_trim = trim($value['subject']);
            $grade_trim = trim($value['grade']);
            if(empty($subject_trim) || empty($grade_trim)){
                unset($data_set['ordinary_level'][$key]);//remove empty ol fields
            }
        }
        if(sizeof($data_set['ordinary_level']) > 0){
            $data_set['ordinary_level'] = array_values($data_set['ordinary_level']);
            $data4['result'] = serialize($data_set['ordinary_level']);

            $this->db->trans_start();
            if($check==true){
                $this->db->where('emp_record_id', $employeeMasterID);
                $this->db->update('hr_olresults_update_pending', $data4);
            }else{
                $this->db->insert('hr_olresults_update_pending', $data4);
            }
            $this->db->trans_complete();

        }elseif ($check==true) {
            $this->db->where('emp_record_id', $employeeMasterID);
            $this->db->delete('hr_olresults_update_pending');
        }



        $data5['emp_record_id'] = $employeeMasterID;
        $data5['school'] = $this->input->post('alschoolname', TRUE);
        $check=$this->checktable('hr_alresults_update_pending','emp_record_id',$employeeMasterID);
        /*check employee data already exit */

        // start a/l document upload by dileep
        if(!empty($_FILES['aldocument']['name']))
        {
            $config['upload_path'] = './uploads/documents/AL';
            $config['allowed_types'] = '*';
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if(!($this->upload->do_upload('aldocument')))
            {

                echo "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
            }
            else
            {
                $dataal = $this->upload->data();
                $data5['document'] = base_url().'uploads/documents/AL/'.$dataal['file_name'];
            }
        }
        // end a/l document upload by dileep

        foreach($data_set['advance_level'] as $key=>$value){
            $subject_trim = trim($value['subject']);
            $grade_trim = trim($value['grade']);
            if(empty($subject_trim) || empty($grade_trim)){
                unset($data_set['advance_level'][$key]);//remove empty ol fields
            }
        }
        if(sizeof($data_set['advance_level']) > 0){
            $data_set['advance_level'] = array_values($data_set['advance_level']);
            $data5['result'] = serialize($data_set['advance_level']);
            $this->db->trans_start();
            if($check==true){
                $this->db->where('emp_record_id', $employeeMasterID);
                $this->db->update('hr_alresults_update_pending', $data5);
            }else{
                $this->db->insert('hr_alresults_update_pending', $data5);
            }
            $this->db->trans_complete();
        }
        elseif ($check==true) {
            $this->db->where('emp_record_id', $employeeMasterID);
            $this->db->delete('hr_alresults_update_pending');
        }

        $data6['emp_record_id'] = $employeeMasterID;
        $check=$this->checktable('hr_empqlfct_update_pending','emp_record_id',$employeeMasterID);

        // start transcriptt upload by dileep
        $this->load->library('upload');

        $files_transcript = $_FILES;
        $path_transcript = array();
        $cpt = count($_FILES['hqtranscript']['name']);
        $higher_education_transcript = $this->employee_new_model->get_higher_education_transcript($employeeMasterID);
                if($higher_education_transcript)
                    $hqtranscript_path = unserialize($higher_education_transcript['document']);

        for($i=0; $i<$cpt; $i++)
        {
            $path_transcript[$i] = $hqtranscript_path[$i];

            $_FILES['hqtranscript']['name']= $files_transcript['hqtranscript']['name'][$i];
            $_FILES['hqtranscript']['type']= $files_transcript['hqtranscript']['type'][$i];
            $_FILES['hqtranscript']['tmp_name']= $files_transcript['hqtranscript']['tmp_name'][$i];
            $_FILES['hqtranscript']['error']= $files_transcript['hqtranscript']['error'][$i];
            $_FILES['hqtranscript']['size']= $files_transcript['hqtranscript']['size'][$i];

            $config['upload_path'] = './uploads/documents/HQ';
            $config['allowed_types'] = '*';
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if(!($this->upload->do_upload('hqtranscript')))
            {

                echo "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
            }

            if(!empty($_FILES['hqtranscript']['name']))
            {
                $datahq = $this->upload->data();
                $path_transcript[$i] = base_url().'uploads/documents/HQ/'.$datahq['file_name'];

            }


        }
        // end transcript upload by dileep

        // start certificate upload by dileep
        $this->load->library('upload');

        $files = $_FILES;
        $path = array();
        $cpt = count($_FILES['hqdocument']['name']);
        $higher_education_details = $this->employee_new_model->get_higher_education_document($employeeMasterID);
                if($higher_education_details)
                    $hqdocument_path = unserialize($higher_education_details['document1']);

        for($i=0; $i<$cpt; $i++)
        {
            $path[$i] = $hqdocument_path[$i];

            $_FILES['hqdocument']['name']= $files['hqdocument']['name'][$i];
            $_FILES['hqdocument']['type']= $files['hqdocument']['type'][$i];
            $_FILES['hqdocument']['tmp_name']= $files['hqdocument']['tmp_name'][$i];
            $_FILES['hqdocument']['error']= $files['hqdocument']['error'][$i];
            $_FILES['hqdocument']['size']= $files['hqdocument']['size'][$i];

            $config['upload_path'] = './uploads/documents/Document';
            $config['allowed_types'] = '*';
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if(!($this->upload->do_upload('hqdocument')))
            {

                echo "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
            }

            if(!empty($_FILES['hqdocument']['name']))
            {
                $datahq = $this->upload->data();
                $path[$i] = base_url().'uploads/documents/Document/'.$datahq['file_name'];

            }


        }       
        // end certificate upload by dileep
        foreach($data_set['higher_education'] as $key=>$value){
            $name_trim = trim($value['name']);
            $field_trim = trim($value['field']);
            $institute_trim = trim($value['institute']);
            $grade_trim = trim($value['grade']);
            $from_trim = trim($value['from']);
            $to_trim = trim($value['to']);
            if(empty($name_trim) || empty($field_trim) || empty($institute_trim) || empty($grade_trim) || empty($from_trim) || empty($to_trim)){
                unset($data_set['higher_education'][$key]);
            }
        }
        if(sizeof($data_set['higher_education']) > 0){
            $data_set['higher_education'] = array_values($data_set['higher_education']);
            $data6['qualification_details'] = serialize($data_set['higher_education']);
            $doc_path = array_values($path);
            $data6['document1'] = serialize($doc_path);//edit by dileep
            $doc_path_transcript = array_values($path_transcript);
            $data6['document'] = serialize($doc_path_transcript);//edit by dileep
            $this->db->trans_start();

            /*check employee data already exit */
            if($check==true){
                $this->db->where('emp_record_id', $employeeMasterID);
                $this->db->update('hr_empqlfct_update_pending', $data6);
            }else{
                $this->db->insert('hr_empqlfct_update_pending', $data6);
            }


            $this->db->trans_complete();
        }elseif ($check==true) {
            $this->db->where('emp_record_id', $employeeMasterID);
            $this->db->delete('hr_empqlfct_update_pending');
        }


        $data7['emp_record_id'] = $employeeMasterID;
        $check=$this->checktable('hr_workexpr_update_pending','emp_record_id',$employeeMasterID);

        foreach($data_set['work_experience'] as $key=>$value){
            $job_trim = trim($value['job']);
            $company_trim = trim($value['company']);
            $location_trim = trim($value['location']);
            $from_trim = trim($value['from']);
            $to_trim = trim($value['to']);
            if(empty($job_trim) || empty($company_trim) || empty($location_trim) || empty($from_trim) || empty($to_trim)) {
                unset($data_set['work_experience'][$key]);
            }
        }
        if(sizeof($data_set['work_experience']) > 0){
            $data_set['work_experience'] = array_values($data_set['work_experience']);
            $data7['experience_details'] = serialize($data_set['work_experience']);

            $this->db->trans_start();

            /*check employee data already exit */
            if($check==true){
                $this->db->where('emp_record_id', $employeeMasterID);
                $this->db->update('hr_workexpr_update_pending', $data7);
            }else{
                $this->db->insert('hr_workexpr_update_pending', $data7);
            }

            $this->db->trans_complete();
        }elseif ($check==true) {
            $this->db->where('emp_record_id', $employeeMasterID);
            $this->db->delete('hr_workexpr_update_pending');
        }

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return $employeeMasterID;
        }
    }

    //editMe

    function get_olresult_update_records_for_notificaton(){
        $userid = $this->session->userdata('userid');
        $team_employes_details = $this->check_immediate_manager($userid);

        $j = 0;
        $employe_list = array();
        foreach($team_employes_details as $team_employee){
            $employe_list['employee_id'][$j] = $team_employee->id;
            $j++;
        }
        if(count($employe_list)>0){
            $this->db->select('*');
            $this->db->where_in('emp_record_id', $employe_list['employee_id']);
            $this->db->where('status', 'P');
            $query = $this->db->get('hr_olresults_update_pending');
            $olresult_update_records = $query->result();
        }else{
            $olresult_update_records = null;
        }
        return $olresult_update_records;
    }

    function get_alresult_update_records_for_notificaton(){
        $userid = $this->session->userdata('userid');
        $team_employes_details = $this->check_immediate_manager($userid);

        $j = 0;
        $employe_list = array();
        foreach($team_employes_details as $team_employee){
            $employe_list['employee_id'][$j] = $team_employee->id;
            $j++;
        }
        if(count($employe_list)>0){
            $this->db->select('*');
            $this->db->where_in('emp_record_id', $employe_list['employee_id']);
            $this->db->where('status', 'P');
            $query = $this->db->get('hr_alresults_update_pending');
            $alresult_update_records = $query->result();
        }else{
            $alresult_update_records = null;
        }
        return $alresult_update_records;
    }

    function get_higheredu_update_records_for_notificaton(){
        $userid = $this->session->userdata('userid');
        $team_employes_details = $this->check_immediate_manager($userid);

        $j = 0;
        $employe_list = array();
        foreach($team_employes_details as $team_employee){
            $employe_list['employee_id'][$j] = $team_employee->id;
            $j++;
        }
        if(count($employe_list)>0){
            $this->db->select('*');
            $this->db->where_in('emp_record_id', $employe_list['employee_id']);
            $this->db->where('status', 'P');
            $query = $this->db->get('hr_empqlfct_update_pending');
            $higheredu_update_records = $query->result();
        }else{
            $higheredu_update_records = null;
        }
        return $higheredu_update_records;
    }
    function get_workexprnc_update_records_for_notificaton(){
        $userid = $this->session->userdata('userid');
        $team_employes_details = $this->check_immediate_manager($userid);

        $j = 0;
        $employe_list = array();
        foreach($team_employes_details as $team_employee){
            $employe_list['employee_id'][$j] = $team_employee->id;
            $j++;
        }
        if(count($employe_list)>0){
            $this->db->select('*');
            $this->db->where_in('emp_record_id', $employe_list['employee_id']);
            $this->db->where('status', 'P');
            $query = $this->db->get('hr_workexpr_update_pending');
            $workxpr_update_records = $query->result();
        }else{
            $workxpr_update_records = null;
        }
        return $workxpr_update_records;
    }

    function check_immediate_manager($emp_id){
        $this->db->select('*');
        $this->db->where('status !=', 'D');
        $this->db->where('immediate_manager_1', $emp_id)->or_where('immediate_manager_2', $emp_id);
        $this->db->order_by('epf_no');
        $query = $this->db->get('hr_empmastr');
        return $query->result();
    }

//endEditMe

    function get_ol_update_pending_results($id){
        $this->db->select('*');
        $this->db->where('emp_record_id', $id);
        $query = $this->db->get('hr_olresults_update_pending');
        return $query->row_array();
    }

    function get_al_update_pending_results($id){
        $this->db->select('*');
        $this->db->where('emp_record_id', $id);
        $query = $this->db->get('hr_alresults_update_pending');
        return $query->row_array();
    }

    function get_higher_education_update_pending($id){
        $this->db->select('*');
        $this->db->where('emp_record_id', $id);
        $query = $this->db->get('hr_empqlfct_update_pending');
        return $query->row_array();
    }

    function get_work_experience_update_pending($id){
        $this->db->select('*');
        $this->db->where('emp_record_id', $id);
        $query = $this->db->get('hr_workexpr_update_pending');
        return $query->row_array();
    }

    function get_ol_pending_results(){
        $this->db->select('*');
        $this->db->where('status', 'P');
        $query = $this->db->get('hr_olresults_update_pending');
        return $query->row_array();
    }


    function get_al_pending_results($id){
        $this->db->select('*');
        $this->db->where('status', 'P');
        $query = $this->db->get('hr_alresults_update_pending');
        return $query->row_array();
    }

    function get_pending_work_experience($id){
        $this->db->select('*');
        $this->db->where('status', 'P');
        $query = $this->db->get(' hr_workexpr_update_pending');
        return $query->row_array();
    }

    function get_pending_higher_education($id){
        $this->db->select('*');
        $this->db->where('status', 'P');
        $query = $this->db->get('hr_empqlfct_update_pending');
        return $query->row_array();
    }

    function checkDeactivateRecordList($userid){
        $this->db->select('*');
        $this->db->where('emp_record_id', $userid);
        $this->db->where('status', 'D');
        $query = $this->db->get('hr_olresults_update_pending');
        return $query->result();
    }
    function get_team_employees_result_update_request_records($employee_list){
        $this->db->select('*');
        $this->db->where_in('emp_record_id', $employee_list['employee_id']);
        $query = $this->db->get('hr_olresults_update_pending');
        return $query->result();
    }

    function decline_user_qulification_update_request($id){
        $data['status'] = "D";
        $data['updated_by'] = $this->session->userdata('username');

        $this->db->trans_start();

        $this->db->where('emp_record_id', $id);
        $this->db->delete('hr_olresults_update_pending');

        $this->db->where('emp_record_id', $id);
        $this->db->delete('hr_alresults_update_pending');

        $this->db->where('emp_record_id', $id);
        $this->db->delete('hr_empqlfct_update_pending');

        $this->db->where('emp_record_id', $id);
        $this->db->delete('hr_workexpr_update_pending');

        $status = $this->db->trans_complete();    //need To change
        if($status){
            return true ;
        }else{
            return false;
        }
    }

    function imidiate_manager_confirm($id)
    {
        $data['updated_by'] = $this->session->userdata('username');
        $data['status'] = "A";

        //get pending Table Data according To  $id
        $this->db->select('*');
        $this->db->where('status','P');
        $this->db->where( 'id' , $id ); //$id = pending tabel id
        $this->db->order_by('id');
        $pending_oldata_to_update = $this->db->get('hr_olresults_update_pending')->row();
        $pending_aldata_to_update = $this->db->get('hr_alresults_update_pending')->row();
        $pending_highredudata_to_update = $this->db->get('hr_empqlfct_update_pending')->row();
        $pending_wrkexprdata_to_update = $this->db->get('hr_workexpr_update_pending')->row();

//      print_r($pending_data_to_update->school);
if($pending_oldata_to_update || $pending_aldata_to_update || $pending_highredudata_to_update || $pending_wrkexprdata_to_update){

    $empRecordId = $pending_oldata_to_update->emp_record_id ;

    $data7['school'] = $pending_oldata_to_update->school;
    $data7['result'] = $pending_oldata_to_update->result;
    $data7['document'] = $pending_oldata_to_update->document;
    $data8['school'] = $pending_aldata_to_update->school;
    $data8['result'] = $pending_aldata_to_update->result;
    $data8['document'] = $pending_aldata_to_update->document;
    $data9['qualification_details'] = $pending_highredudata_to_update->qualification_details;
    $data9['document'] = $pending_highredudata_to_update->document;
    $data9['document1'] = $pending_highredudata_to_update->document1;
    $data10['experience_details'] = $pending_wrkexprdata_to_update->experience_details;

//        echo json_encode(['suc'=> $pending_data_to_update ]);

    $check=$this->checktable('hr_olresults','emp_record_id',$empRecordId); /*check employee data already exit */
    
    $this->db->trans_start();
    if ($check == true){
        $this->db->where('emp_record_id', $empRecordId);
        $this->db->update('hr_olresults', $data7);
        $this->db->where('emp_record_id', $empRecordId);
        $this->db->update('hr_alresults', $data8);
        $this->db->where('emp_record_id', $empRecordId);
        $this->db->update('hr_empqlfct', $data9);
        $this->db->where('emp_record_id', $empRecordId);
        $this->db->update('hr_workexpr', $data10);
    }else{
        $data7['emp_record_id'] = $empRecordId;
        $data8['emp_record_id'] = $empRecordId;
        $data9['emp_record_id'] = $empRecordId;
        $data10['emp_record_id'] = $empRecordId;

        $this->db->insert('hr_olresults', $data7);
        $this->db->insert('hr_alresults', $data8);
        $this->db->insert('hr_empqlfct', $data9);
        $this->db->insert('hr_workexpr', $data10);
    }



   $this->db->where('emp_record_id', $empRecordId);
    // $tt = $this->db->update('hr_olresults_update_pending', $data);
   $this->db->delete('hr_olresults_update_pending');

   $this->db->where('emp_record_id', $empRecordId);
   $this->db->delete('hr_alresults_update_pending');

   $this->db->where('emp_record_id', $empRecordId);
   $this->db->delete('hr_empqlfct_update_pending');

   $this->db->where('emp_record_id', $empRecordId);
   $this->db->delete('hr_workexpr_update_pending');


 $tt = $this->db->trans_complete();


    if($tt){
            return true;
        }else{
            return false;
        }
}else{
    return false;
}


}

// TRANSACTION QUARY
function check_transaction_confirm_manager($userid){
        $this->db->select('*');
        $this->db->where('confirm_manager', $userid);
        $this->db->where('status =','P');
        $this->db->order_by('emp_record_id');
        $query = $this->db->get('hr_emp_transaction');
        return $query->result();
}

// GET ALL PENDING TRANSACTION RECORDS FOR NOTIFICATIONS VIEW
function get_all_pending_transactions($id){
    $loged_user_id = $this->session->userdata('userid');
    $this->db->select('*');
    $this->db->where('status','P');
    $this->db->where('confirm_manager',$loged_user_id);  //NEED TO EDIT
    // $this->db->order_by('emp_no');
    // $this->db->limit($pagination_counter, $page_count);
    $query = $this->db->get('hr_emp_transaction');
    return $query->result();


}




function view_update_transactions_pending_data($id){
   // Join hr_emp_transaction and  hr_transfer_trans  
   $this->db->select('hr_emp_transaction.* , hr_transfer_trans.* ');
    $this->db->join('hr_transfer_trans' , 'hr_transfer_trans.emp_record_id = hr_emp_transaction.emp_record_id','left');
    $this->db->where('hr_emp_transaction.id' , $id);
    $this->db->where('hr_emp_transaction.status' , 'P');
    $query = $this->db->get('hr_emp_transaction');
    if($query->result()>0){
        return $query->row_array();
    }else{
        return false;
    }



}





function confirm_employee_transaction($id){

    $data4['status'] = 'A';
    $this->db->select('*');
    $this->db->where('id',$id);
    $this->db->update('hr_emp_transaction', $data4);
    $query = $this->db->get('hr_emp_transaction');
    return $query->result();

}

////////////////////////////
function reject_employee_transaction($id){
                        $data4['resign_status'] = 'N';
                        $data4['active_flag'] = 1 ;
                        $this->db->select('*');
                        $this->db->where('id',$id);
                        $this->db->update('cm_userdata', $data4);
                        $query = $this->db->get('cm_userdata');
                        return $query->result();

                        $data4['status'] = 'A';
                        $this->db->select('*');
                        $this->db->where('id',$id);
                        $this->db->update('hr_emp_transaction', $data4);
                        $query = $this->db->get('cm_userdata');
                        return $query->result();

                       



}
///////////////////////////////////////

function check_resignations_confirm_manager($id){

        $this->db->select('*');
        $this->db->where('resign_status','P');
        $this->db->where('resign_confirm_manager',$id);
        $query = $this->db->get('cm_userdata');
        return $query->result();
       
}



function get_employee_pending_resignation(){
    $userid = $this->session->userdata('userid');
    $this->db->select('*');
    
    $this->db->where('resign_status', 'P');

    $this->db->where('resign_confirm_manager',$userid);
    $query = $this->db->get('hr_emp_resignation');
    return $query->result();

    
   
}



function get_employee_name_for_notify($emp_id){

    $this->db->select('*');
    $this->db->where('id',$emp_id);
    $query = $this->db->get('hr_empmastr');
    return $query->row_array();
   
}



function employee_reignation_confirm($id , $emp_rec_id){

    $check=$this->checktable('hr_emp_resignation','id',$id);
    if($check == true){


        $data2['resign_status'] = 'C';
        $data2['created_by'] = $emp_rec_id;

        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('hr_emp_resignation' , $data2);
        $this->db->trans_complete();

        // $check_record_id = check_userDta_table($emp_rec_id);
        //  if($check_record_id == true){
        $this->db->trans_start();
        $this->db->where('USRID', $emp_rec_id);
        $this->db->delete('cm_userdata');
        $this->db->trans_complete();  //    } 

    }
   
}



function reject_resignation($id){

    // $check=$this->checktable('cm_userdata','USRID',$id);

     
    $data4['resign_status'] = 'N';
    $this->db->trans_start();
    $this->db->where('id', $id);
    $this->db->update('hr_emp_resignation' , $data4);
    $this->db->trans_complete();

//AND CHANGE hr_empmastr  TABLE status VALUE TO 'A'


   $this->db->select('emp_record_id');
   $this->db->where('id' , $id);
   $rejected_record_id = $this->db->get('hr_emp_resignation');

   $data5['status'] = 'A';
   $this->db->trans_start();
   $this->db->where('id' , $rejected_record_id);
   $this->db->update('hr_empmastr' , $data5);
   $this->db->trans_complete();



    // if($check == true){

    //     // $this->db->trans_start();
    //     // $this->db->where('USRID', $id);
    //     // $this->db->delete('cm_userdata');
    //     // $this->db->trans_complete();

    // }
   
}


function check_userDta_table($emp_rec_id)
{
    $this->db->where('USRID',$emp_rec_id);
    $query=$this->db->get('cm_userdata');
    if(count($query->result())>0){
        return true;
    }else{
        return false;
    }
}

    //end Edit_By_Andrei 2021 FEB 12


    function get_higher_education_transcript($id){
        $this->db->select('*');
        $this->db->where('emp_record_id', $id);
        $query = $this->db->get('hr_empqlfct');
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }



     // edit by dileep
    public function get_higher_education_details(){
        $this->db->select('*');
        
        $query = $this->db->get('hr_education_qualification');
        return $data = $query->result();
    }

    public function get_qualification_field_details(){
        $this->db->select('*');
        
        $query = $this->db->get('hr_qualification_field');
        return $data = $query->result();
    }

    function get_higher_education_document($id){
        $this->db->select('*');
        $this->db->where('emp_record_id', $id);
        $query = $this->db->get('hr_empqlfct');
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }
    //end edit by dileep

}