<?php

class Group extends CI_Controller {

    function Group()
    {
        parent::__construct();
        $this->load->model('Group_model');
		$this->load->model('common_model');
		$this->is_logged_in();
        return;
    }

    function index()
    {
        $data=NULL;
        if ( ! check_access('create group'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('user');
            return;
        }
       // $data['entry_data'] = $this->Group_model->get_all_ac_groups();
       $entry_data = $this->Group_model->get_all_groups();
       //$parent_data = $this->Group_model->get_parent_groups();
        

        if (!$entry_data)
        {
            $this->session->set_flashdata('error', 'No Data');
        }
        $data['entry_data'] = $entry_data;

        //group add
        $data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'maxlength' => '100',
            'size' => '40',
            'value' => '',
        );
        $data['group_parent'] = $this->Group_model->get_all_ac_groups();
        $data['group_parent_active'] = 0;
        $data['affects_gross'] = 0;

        $this->load->view('accounts/group/index',$data);


    }

    function add()
    {
        //$this->load->library('validation');
        //$this->template->set('page_title', 'New Group');

        /* Check access */
        if ( ! check_access('create group'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('user');
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/account');
            return;
        }

        /* Form fields */
        $data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'maxlength' => '100',
            'size' => '40',
            'value' => '',
        );
        $data['group_parent'] = $this->Group_model->get_all_ac_groups();
        $data['group_parent_active'] = 0;
        $data['affects_gross'] = 0;

        /* Form validations */
        //$this->form_validation->set_rules('group_name', 'Group name', 'trim|required|min_length[2]|max_length[100]|unique[ac_groups.name]');
        //$this->form_validation->set_rules('group_parent', 'Parent group', 'trim|required|is_natural_no_zero');

        /* Re-populating form */
        if ($_POST)
        {
            $data['group_name']['value'] = $this->input->post('group_name', TRUE);
            $data['group_parent_active'] = $this->input->post('group_parent', TRUE);
            $data['affects_gross'] = $this->input->post('affects_gross', TRUE);
        }

//        if ($this->form_validation->run() == FALSE)
//        {
//            $this->messages->add(validation_errors(), 'error');
//            $this->template->load('template', 'group/add', $data);
//            return;
//        }
//        else
//        {
            $data_name = $this->input->post('group_name', TRUE);
            $data_parent_id = $this->input->post('group_parent', TRUE);

            /* Check if parent group id present */
            $this->db->select('id')->from('ac_groups')->where('id', $data_parent_id);
            if ($this->db->get()->num_rows() < 1)
            {
                //$this->messages->add('Invalid Parent group.', 'error');
                $this->session->set_flashdata('error', 'Invalid Parent group.');
                //$this->template->load('template', 'group/add', $data);
                $this->load->view('accounts/group/add',$data);
                return;
            }

            /* Only if Income or Expense can affect gross profit loss calculation */
            $data_affects_gross = $this->input->post('affects_gross', TRUE);
            if ($data_parent_id == "3" || $data_parent_id == "4")
            {
                if ($data_affects_gross == "1")
                    $data_affects_gross = 1;
                else
                    $data_affects_gross = 0;
            } else {
                $data_affects_gross = 0;
            }

            $this->db->trans_start();
            $insert_data = array(
                'name' => $data_name,
                'parent_id' => $data_parent_id,
                'affects_gross' => $data_affects_gross,
            );
            if ( ! $this->db->insert('ac_groups', $insert_data))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error addding Group account - ' . $data_name . '.', 'error');
                $this->session->set_flashdata('error', 'Error addding Group account - ' . $data_name . '.');
                $this->logger->write_message("error", "Error adding Group account called " . $data_name);
                //$this->template->load('template', 'group/add', $data);
                $this->load->view('accounts/group/add',$data);
                return;
            } else {
                $this->db->trans_complete();
                $this->messages->add('Added Group account - ' . $data_name . '.', 'success');
                $this->session->set_flashdata('msg', 'Added Group account - ' . $data_name . '.');
                $this->logger->write_message("success", "Added Group account called " . $data_name);
                redirect('accounts/group');
                return;
            }
//        }
//        return;
    }

    function edit($id)
    {
        //$this->template->set('page_title', 'Edit Group');

        /* Check access */
        if ( ! check_access('edit group'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('accounts/group');
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/group');
            return;
        }

        /* Checking for valid data */
        //$id = $this->input->xss_clean($id);
        $id = (int)$id;
        if ($id < 1) {
            //$this->messages->add('Invalid Group account.', 'error');
            $this->session->set_flashdata('error', 'Invalid Group account.');
            redirect('accounts/group');
            return;
        }
        if ($id <= 4) {
            //$this->messages->add('Cannot edit System Group account.', 'error');
            $this->session->set_flashdata('error', 'Cannot edit System Group account.');
            redirect('accounts/group');
            return;
        }

        /* Loading current group */
        $this->db->from('ac_groups')->where('id', $id);
        $group_data_q = $this->db->get();
        if ($group_data_q->num_rows() < 1)
        {
            //$this->messages->add('Invalid Group account.', 'error');
            $this->session->set_flashdata('error', 'Invalid Group account.');
            redirect('accounts/group');
            return;
        }
        $group_data = $group_data_q->row();

        /* Form fields */
        $data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'maxlength' => '100',
            'size' => '40',
            'value' => $group_data->name,
        );
        $data['group_parent'] = $this->Group_model->get_all_ac_groups($id);
        $data['group_parent_active'] = $group_data->parent_id;
        $data['group_id'] = $id;
        $data['affects_gross'] = $group_data->affects_gross;

        /* Form validations */
        //$this->form_validation->set_rules('group_name', 'Group name', 'trim|required|min_length[2]|max_length[100]|uniquewithid[ac_groups.name.' . $id . ']');
        //$this->form_validation->set_rules('group_parent', 'Parent group', 'trim|required|is_natural_no_zero');

        /* Re-populating form */
        if ($_POST)
        {
            $data['group_name']['value'] = $this->input->post('group_name', TRUE);
            $data['group_parent_active'] = $this->input->post('group_parent', TRUE);
            $data['affects_gross'] = $this->input->post('affects_gross', TRUE);
        }

//        if ($this->form_validation->run() == FALSE)
//        {
//            $this->messages->add(validation_errors(), 'error');
//            $this->template->load('template', 'group/edit', $data);
//            return;
//        }
//        else
//        {
            $data_name = $this->input->post('group_name', TRUE);
            $data_parent_id = $this->input->post('group_parent', TRUE);
            $data_id = $id;

            /* Check if parent group id present */
            $this->db->select('id')->from('ac_groups')->where('id', $data_parent_id);
            if ($this->db->get()->num_rows() < 1)
            {
                //$this->messages->add('Invalid Parent group.', 'error');
                $this->session->set_flashdata('error', 'Invalid Parent group.');
                //$this->template->load('template', 'group/edit', $data);
                $this->load->view('accounts/group/edit',$data);
                return;
            }

            /* Check if parent group same as current group id */
            if ($data_parent_id == $id)
            {
                //$this->messages->add('Invalid Parent group', 'error');
                $this->session->set_flashdata('error', 'Invalid Parent group.');
                //$this->template->load('template', 'group/edit', $data);
                $this->load->view('accounts/group/edit',$data);
                return;
            }

            /* Only if Income or Expense can affect gross profit loss calculation */
            $data_affects_gross = $this->input->post('affects_gross', TRUE);
            if ($data_parent_id == "3" || $data_parent_id == "4")
            {
                if ($data_affects_gross == "1")
                    $data_affects_gross = 1;
                else
                    $data_affects_gross = 0;
            } else {
                $data_affects_gross = 0;
            }

            $this->db->trans_start();
            $update_data = array(
                'name' => $data_name,
                'parent_id' => $data_parent_id,
                'affects_gross' => $data_affects_gross,
            );
            if ( ! $this->db->where('id', $data_id)->update('ac_groups', $update_data))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Group account - ' . $data_name . '.', 'error');
                $this->session->set_flashdata('error', 'Error updating Group account - ' . $data_name . '.');
                $this->logger->write_message("error", "Error updating Group account called " . $data_name . " [id:" . $data_id . "]");
                //$this->template->load('template', 'group/edit', $data);
                $this->load->view('account/group/edit',$data);
                return;
            } else {
                $this->db->trans_complete();
                //$this->messages->add('Updated Group account - ' . $data_name . '.', 'success');
                $this->session->set_flashdata('msg', 'Updated Group account - ' . $data_name . '.');
                $this->logger->write_message("success", "Updated Group account called " . $data_name . " [id:" . $data_id . "]");
                redirect('accounts/group');
                return;
            }
//        }
//        return;
    }

    function delete($id)
    {
        /* Check access */
        if ( ! check_access('delete group'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('accounts/account');
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/account');
            return;
        }

        /* Checking for valid data */
        $id = $this->input->xss_clean($id);
        $id = (int)$id;
        if ($id < 1) {
            //$this->messages->add('Invalid Group account.', 'error');
            $this->session->set_flashdata('error', 'Invalid Group account.');
            redirect('accounts/account');
            return;
        }
        if ($id <= 4) {
            //$this->messages->add('Cannot delete System Group account.', 'error');
            $this->session->set_flashdata('error', 'Cannot delete System Group account.');
            redirect('accounts/account');
            return;
        }
        $this->db->from('ac_groups')->where('parent_id', $id);
        if ($this->db->get()->num_rows() > 0)
        {
            //$this->messages->add('Cannot delete non-empty Group account.', 'error');
            $this->session->set_flashdata('error', 'Cannot delete non-empty Group account.');
            redirect('accounts/account');
            return;
        }
        $this->db->from('ac_ledgers')->where('group_id', $id);
        if ($this->db->get()->num_rows() > 0)
        {
            //$this->messages->add('Cannot delete non-empty Group account.', 'error');
            $this->session->set_flashdata('error', 'Cannot delete non-empty Group account.');
            redirect('accounts/account');
            return;
        }

        /* Get the group details */
        $this->db->from('ac_groups')->where('id', $id);
        $group_q = $this->db->get();
        if ($group_q->num_rows() < 1)
        {
            //$this->messages->add('Invalid Group account.', 'error');
            $this->session->set_flashdata('error', 'Invalid Group account.');
            redirect('accounts/account');
            return;
        } else {
            $group_data = $group_q->row();
        }

        /* Deleting group */
        $this->db->trans_start();
        if ( ! $this->db->delete('ac_groups', array('id' => $id)))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error deleting Group account - ' . $group_data->name . '.', 'error');
            $this->session->set_flashdata('error', 'Error deleting Group account - ' . $group_data->name . '.');
            $this->logger->write_message("error", "Error deleting Group account called " . $group_data->name . " [id:" . $id . "]");
            redirect('accounts/account');
            return;
        } else {
            $this->db->trans_complete();
            //$this->messages->add('Deleted Group account - ' . $group_data->name . '.', 'success');
            $this->session->set_flashdata('msg', 'Deleted Group account - ' . $group_data->name . '.');
            $this->logger->write_message("success", "Deleted Group account called " . $group_data->name . " [id:" . $id . "]");
            redirect('accounts/account');
            return;
        }
        return;
    }


    function delete_group()
    {
        $id=$this->uri->segment(4);

        /* Check access */
        if ( ! check_access('delete group'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('accounts/group');
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/group');
            return;
        }

        $this->db->from('ac_groups')->where('parent_id', $id);
        $entry_q = $this->db->get();
        $rowcount = $this->db->from('ac_groups')->where('parent_id', $id)->get()->num_rows();
        if($rowcount>1)
        {

            $this->session->set_flashdata('error', 'Can not Delete this group.');
            redirect('accounts/group');
            return;
        }
        $this->db->from('ac_ledgers')->where('group_id', $id);
        $entry_q1 = $this->db->get();
        $rowcount1 = $this->db->from('ac_ledgers')->where('group_id', $id)->get()->num_rows();
        if($rowcount1>1)
        {
            $this->session->set_flashdata('error', 'Can not Delete this group.');
            redirect('accounts/group');
            return;
        }
//        var_dump('ok');
//        die();
        if(!$this->db->delete('ac_groups', array('id' => $id)))
        {
            $this->session->set_flashdata('error','Error Deleting Group id -'.$id.'.');
            redirect('accounts/group');
            return;
        }

        $this->db->trans_complete();

        $this->session->set_flashdata('msg', 'Delete group id'.$id .'.');
        $this->logger->write_message("success", "DELETE Group id -" . $id );
        ?><script></script><?
        redirect('accounts/group');

        return;
    }
	
	function update_order(){
		$this->Group_model->update_order();
		
	}
}

/* End of file group.php */
/* Location: ./system/application/controllers/group.php */
