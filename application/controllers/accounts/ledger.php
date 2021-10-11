<?php
// Modifications done by udani
// modification 01 = Modified GL code -Allow to add GL code mannualy New Code  ** Efected Functions :add(), edit() **Date - 04-09-2013
// modification 02 = remove the restriction of GL code should be an Integer ** Efected Functions: edit(), delete() ** Date - 10-09-2013
// Modificetion 03 = add new feald (GL ref code) - for the reference for government reports. ** Efected Functions :add(), edit() **Date - 10-09-2013
class Ledger extends CI_Controller {

	function Ledger()
	{
		parent::__construct();
		$this->load->model('Ledger_model');
		$this->load->model('Group_model');
		$this->load->model('common_model');
		$this->is_logged_in();
		return;
	}

	function index()
	{
		redirect('accounts/ledger/add');
		return;
	}

	function add()
	{
		//$this->template->set('page_title', 'New Ledger');

		/* Check access */
		if ( ! check_access('create ledger'))
		{
			//$this->messages->add('Permission denied.', 'error');
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/masteraccounts');
			return;
		}

		/* Check for account lock */
		if ($this->config->item('account_locked') == 1)
		{
			//$this->messages->add('Account is locked.', 'error');
			$this->session->set_flashdata('error', 'Account is locked.');
			redirect('accounts/masteraccounts');
			return;
		}

		/* Form fields */
		$data['ledger_name'] = array(
			'name' => 'ledger_name',
			'id' => 'ledger_name',
			'maxlength' => '100',
			'size' => '40',
			'value' => '',
			'class' => 'form-control',
		);
		// modification 01
		
		//modification 03

		$data['ref_id'] = array(
			'name' => 'ref_id',
			'id' => 'ref_id',
			'maxlength' => '100',
			'size' => '40',
			'value' => '',
			'class' => 'form-control',
		);
		$data['ledger_group_id'] = $this->Group_model->get_ledger_ac_groups();
		$data['op_balance'] = array(
			'name' => 'op_balance',
			'id' => 'op_balance',
			'maxlength' => '15',
			'size' => '15',
			'value' => '',
			'type' => 'number',
			'step' => '0.01',
		);
		$data['ledger_group_active'] = 0;
		$data['op_balance_dc'] = "D";
		$data['ledger_type_cashbank'] = FALSE;
		$data['reconciliation'] = FALSE;

		/* Form validations */
		// modification 01
//		$this->form_validation->set_rules('ledger_id', 'Ledger Code', 'trim|required|min_length[2]|max_length[100]|unique[ac_ledgers.id]');
//		//modification 03
//		$this->form_validation->set_rules('ref_id', 'Reference Code', 'trim|min_length[2]|max_length[100]');
//
//		$this->form_validation->set_rules('ledger_name', 'Ledger name', 'trim|required|min_length[2]|max_length[250]|unique[ac_ledgers.name]');
//		$this->form_validation->set_rules('ledger_group_id', 'Parent group', 'trim|required|is_natural_no_zero');
//		$this->form_validation->set_rules('op_balance', 'Opening balance', 'trim|currency');
//		$this->form_validation->set_rules('op_balance_dc', 'Opening balance type', 'trim|required|is_dc');

		/* Re-populating form */
		if ($_POST)
		{
			$data['ledger_name']['value'] = $this->input->post('ledger_name', TRUE);
			$data['ref_id']['value'] = $this->input->post('ref_id', TRUE);
			$data['op_balance']['value'] = $this->input->post('op_balance', TRUE);
			$data['ledger_group_active'] = $this->input->post('ledger_group_id', TRUE);
			$data['op_balance_dc'] = $this->input->post('op_balance_dc', TRUE);
			$data['ledger_type_cashbank'] = $this->input->post('ledger_type_cashbank', TRUE);
			$data['reconciliation'] = $this->input->post('reconciliation', TRUE);
		}

//		if ($this->form_validation->run() == FALSE)
//		{
//			$this->messages->add(validation_errors(), 'error');
//			$this->template->load('template', 'ledger/add', $data);
//			return;
//		}
//		else
//		{
			$data_name = $this->input->post('ledger_name', TRUE);
			$ref_id=$this->input->post('ref_id', TRUE);
			$data_group_id = $this->input->post('ledger_group_id', TRUE);
			$data_op_balance = $this->input->post('op_balance', TRUE);
			$data_op_balance_dc = $this->input->post('op_balance_dc', TRUE);
			$data_ledger_type_cashbank_value = $this->input->post('ledger_type_cashbank', TRUE);
			$data_reconciliation = $this->input->post('reconciliation', TRUE);

			if ($data_group_id < 5)
			{
				//$this->messages->add('Invalid Parent group.', 'error');
				$this->session->set_flashdata('error', 'Invalid Parent group.');
				//$this->template->load('template', 'ledger/add', $data);
				$this->load->view('accounts/ledger/add',$data);
				return;
			}

			/* Check if parent group id present */
			$this->db->select('id')->from('ac_groups')->where('id', $data_group_id);
			if ($this->db->get()->num_rows() < 1)
			{
				//$this->messages->add('Invalid Parent group.', 'error');
				$this->session->set_flashdata('error', 'Invalid Parent group.');
				//$this->template->load('template', 'ledger/add', $data);
				$this->load->view('accounts/ledger/add',$data);
				return;
			}

			if (!$data_op_balance) {
				$data_op_balance = "0.00";
			}

			if ($data_ledger_type_cashbank_value == "1")
			{
				$data_ledger_type = 1;
			} else {
				$data_ledger_type = 0;
			}

			if ($data_reconciliation == "1")
			{
				$data_reconciliation = 1;
			} else {
				$data_reconciliation = 0;
			}

			$this->db->trans_start();
			$id=$this->Ledger_model->get_next_ledgerid($data_group_id);
			$insert_data = array(
				'name' => $data_name,
				'id' => $id,
				'ref_id' => $ref_id,
				'group_id' => $data_group_id,
				'op_balance' => $data_op_balance,
				'op_balance_dc' => $data_op_balance_dc,
				'type' => $data_ledger_type,
				'reconciliation' => $data_reconciliation,

			);
			if ( ! $this->db->insert('ac_ledgers', $insert_data))
			{
				$this->db->trans_rollback();
				//$this->messages->add('Error addding Ledger account - ' . $data_name . '.', 'error');
				$this->session->set_flashdata('error', 'Error addding Ledger account - ' . $data_name . '.');
				$this->logger->write_message("error", "Error adding Ledger account called " . $data_name);
				//$this->template->load('template', 'group/add', $data);
				$this->load->view('accounts/ledger/add',$data);
				return;
			} else {
				//ticket number 1172 updated by nadee 2020-02-18
				$insert_data2 = array(
					'name' => $data_name,
					'id' => substr($id, 3),
					'ref_id' => $ref_id,
					'group_id' => $data_group_id,
					'op_balance' => $data_op_balance,
					'op_balance_dc' => $data_op_balance_dc,
					'type' => $data_ledger_type,
					'reconciliation' => $data_reconciliation,);
					$this->db->insert('ac_config_ledgers', $insert_data2);
					
					
					
					$codedata=array('group_code'=>$id);
					$this->db->where('id', $data_group_id);
					$this->db->update('ac_groups', $codedata);
					//ticket number 1172 updated by nadee 2020-02-18
				$this->db->trans_complete();
				//$this->messages->add('Added Ledger account - ' . $data_name . '.', 'success');
				$this->session->set_flashdata('msg', 'Added Ledger account - ' . $data_name . '.');
				$this->logger->write_message("success", "Added Ledger account called " . $data_name);
				redirect('accounts/account/load_acclist');
				return;
			}
//		}
//		return;
	}

	function edit($id)
	{
		//$this->template->set('page_title', 'Edit Ledger');

//		/* Check access */
		if ( ! check_access('edit ledger'))
		{
			$this->messages->add('Permission denied.', 'error');
			redirect('accounts/account/load_acclist');
			return;
		}

		/* Check for account lock */
		if ($this->config->item('account_locked') == 1)
		{
			$this->messages->add('Account is locked.', 'error');
			redirect('accounts/account/load_acclist');
			return;
		}

		/* Checking for valid data */
		$id = $id;
//		$id = (int)$id;
	if ($id == "")// edited by Udani 10-09-2013
		{
			$this->messages->add('Invalid Ledger account.', 'error');
			redirect('accounts/account/load_acclist');
			return;
		}

//		/* Loading current group */
		$this->db->from('ac_ledgers')->where('id', $id);
		$ledger_data_q = $this->db->get();
		if ($ledger_data_q->num_rows() < 1)
		{
			$this->messages->add('Invalid Ledger account.', 'error');
			redirect('accounts/account/load_acclist');
			return;
		}
		$ledger_data = $ledger_data_q->row();
		$data['banklist']=$this->common_model->getbanklist();
		/* Form fields */
		// Mofification 03
		$data['ref_id'] = array(
			'name' => 'ref_id',
			'id' => 'ref_id',
			'maxlength' => '100',
			'size' => '40',
				'class' => 'form-control',
			'value' => $ledger_data->ref_id,
		);
		$data['ledger_name'] = array(
			'name' => 'ledger_name',
			'id' => 'ledger_name',
			'maxlength' => '100',
				'class' => 'form-control',
			'size' => '40',
			'value' => $ledger_data->name,
		);
		$data['ledger_group_id'] = $this->Group_model->get_ledger_ac_groups();
		if(ledger_deletable($id))
		{
				$data['op_balance'] = array(
				'name' => 'op_balance',
				'id' => 'op_balance',
				'maxlength' => '15',
				'size' => '15',
				
					'class' => 'form-control',
				'value' => $ledger_data->op_balance,
			);
		}
		else 
		{
			$data['op_balance'] = array(
			'name' => 'op_balance',
			'id' => 'op_balance',
			'maxlength' => '15',
			'size' => '15',
			//'readonly'=>'readonly',
				'class' => 'form-control',
			'value' => $ledger_data->op_balance,
		);
		}
		
		$data['ledger_group_active'] = $ledger_data->group_id;
		$data['op_balance_dc'] = $ledger_data->op_balance_dc;
		$data['ledger_id'] = $id;
		if ($ledger_data->type == 1)
			$data['ledger_type_cashbank'] = TRUE;
		else
			$data['ledger_type_cashbank'] = FALSE;
		$data['reconciliation'] = $ledger_data->reconciliation;
		$data['active'] = $ledger_data->active;

		/* Form validations */
	//	$this->form_validation->set_rules('ledger_name', 'Ledger name', 'trim|required|min_length[2]|max_length[250]|uniquewithid[ac_ledgers.name.' . $id . ']');
		//$this->form_validation->set_rules('ref_id', 'Reference Code', 'trim|min_length[2]|max_length[100]');
		//$this->form_validation->set_rules('ledger_group_id', 'Parent group', 'trim|required|is_natural_no_zero');
		//$this->form_validation->set_rules('op_balance', 'Opening balance', 'trim|currency');
		//$this->form_validation->set_rules('op_balance_dc', 'Opening balance type', 'trim|required|is_dc');

		/* Re-populating form */
		if ($_POST)
		{
			$data['ledger_name']['value'] = $this->input->post('ledger_name', TRUE);
			$data['ref_id']['value'] = $this->input->post('ref_id', TRUE);
			$data['ledger_group_active'] = $this->input->post('ledger_group_id', TRUE);
			$data['op_balance']['value'] = $this->input->post('op_balance', TRUE);
			$data['op_balance_dc'] = $this->input->post('op_balance_dc', TRUE);
			$data['ledger_type_cashbank'] = $this->input->post('ledger_type_cashbank', TRUE);
			$data['reconciliation'] = $this->input->post('reconciliation', TRUE);
			$data['active'] = $this->input->post('active', TRUE);
		}

		if (0)
		{
			$this->messages->add(validation_errors(), 'error');
		$this->load->view( 'accounts/ledger/edit', $data);
			return;
		}
		else
		{
			$data_name = $this->input->post('ledger_name', TRUE);
			$ref_id = $this->input->post('ref_id', TRUE);
			$data_group_id = $this->input->post('ledger_group_id', TRUE);
			$data_op_balance = $this->input->post('op_balance', TRUE);
			$data_op_balance_dc = $this->input->post('op_balance_dc', TRUE);
			$data_id = $id;
			$data_ledger_type_cashbank_value = $this->input->post('ledger_type_cashbank', TRUE);
			$data_reconciliation = $this->input->post('reconciliation', TRUE);
			$data_active = $this->input->post('active', TRUE);

			if ($data_group_id < 5)
			{
				$this->messages->add('Invalid Parent group.', 'error');
				$this->load->view( 'accounts/ledger/edit', $data);
				return;
			}

			/* Check if parent group id present */
			$this->db->select('id')->from('ac_groups')->where('id', $data_group_id);
			if ($this->db->get()->num_rows() < 1)
			{
				$this->messages->add('Invalid Parent group.', 'error');
				$this->load->view( 'accounts/ledger/edit', $data);
				return;
			}

			if (!$data_op_balance) {
				$data_op_balance = "0.00";
			}

			/* Check if bank_cash_ledger_restriction both entry present */
			if ($data_ledger_type_cashbank_value != "1")
			{
				$entry_type_all = $this->config->item('account_ac_entry_types');
				if($entry_type_all ){
				foreach ($entry_type_all as $entry_type_id => $row)
				{
					/* Check for Entry types where bank_cash_ledger_restriction is for all ac_ledgers */
					if ($row['bank_cash_ledger_restriction'] == 4)
					{
						$this->db->from('ac_entry_items')->join('ac_entries', 'ac_entry_items.entry_id = ac_entries.id')->where('ac_entries.entry_type', $entry_type_id)->where('ac_entry_items.ledger_id', $id);
						$all_ledger_bank_cash_count = $this->db->get()->num_rows();
						if ($all_ledger_bank_cash_count > 0)
						{
							$this->messages->add('Cannot remove the Bank or Cash Account status of this Ledger account since it is still linked with ' . $all_ledger_bank_cash_count . ' ' . $row['name'] . ' ac_entries.', 'error');
							$this->load->view( 'accounts/ledger/edit', $data);
							return;
						}
					}
				}
				}
			}

			if ($data_ledger_type_cashbank_value == "1")
			{
				$data_ledger_type = 1;
			} else {
				$data_ledger_type = 0;
			}

			if ($data_reconciliation == "1")
			{
				$data_reconciliation = 1;
			} else {
				$data_reconciliation = 0;
			}

			$this->db->trans_start();
			if($this->input->post('bank1')!="")
			{
				$prev_bankcode=$this->common_model->get_account_bank_code($data_id);
				if($prev_bankcode!=$this->input->post('bank1'))
					$this->common_model->insert_ledgerbank($data_id,$this->input->post('bank1'));
			}

			$update_data = array(
				'name' => $data_name,
				'ref_id' => $ref_id,
				'group_id' => $data_group_id,
				'op_balance' => $data_op_balance,
				'op_balance_dc' => $data_op_balance_dc,
				'type' => $data_ledger_type,
				'reconciliation' => $data_reconciliation,
				'active' => $data_active,
			);
			if ( ! $this->db->where('id', $data_id)->update('ac_ledgers', $update_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error updating Ledger account - ' . $data_name . '.', 'error');
				$this->logger->write_message("error", "Error updating Ledger account called " . $data_name . " [id:" . $data_id . "]");
				$this->load->view( 'accounts/ledger/edit', $data);
				return;
			} else {
				/* Deleting reconciliation data if reconciliation disabled */
				if (($ledger_data->reconciliation == 1) AND ($data_reconciliation == 0))
				{
					$this->Ledger_model->delete_reconciliation($data_id);
				}

				//ticket number 1172 updated by nadee 2020-02-18
				$select_config=$this->db->select('id')->from('ac_config_ledgers')->where('id',substr($data_id,3));
				$update_config= $this->db->get()->num_rows();
				if($update_config>0){
					$update_data_config = array(
						'name' => $data_name,
						'ref_id' => $ref_id,
						'group_id' => $data_group_id,
						'op_balance' => $data_op_balance,
						'op_balance_dc' => $data_op_balance_dc,
						'type' => $data_ledger_type,
						'reconciliation' => $data_reconciliation,
					);
					$update_config=$this->db->where('id', substr($data_id,3))->update('ac_config_ledgers', $update_data_config);
				}else{
					$update_data2 = array(
						'id'=>substr($data_id,3),
						'name' => $data_name,
						'ref_id' => $ref_id,
						'group_id' => $data_group_id,
						'op_balance' => $data_op_balance,
						'op_balance_dc' => $data_op_balance_dc,
						'type' => $data_ledger_type,
						'reconciliation' => $data_reconciliation,);
						$this->db->insert('ac_config_ledgers', $update_data2);
				}
				//ticket number 1172 updated by nadee 2020-02-18
				$this->db->trans_complete();
				$this->messages->add('Updated Ledger account - ' . $data_name . '.', 'success');
				$this->logger->write_message("success", "Updated Ledger account called " . $data_name . " [id:" . $data_id . "]");
				redirect('accounts/account/load_acclist');
				return;
			}
		}
		return;
	}

	function confirm($id){

		if ( ! check_access('edit ledger'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/masteraccounts');
			return;
		}

		if ($this->config->item('account_locked') == 1)
		{
			$this->session->set_flashdata('error', 'Account is locked.');
			redirect('accounts/masteraccounts');
			return;
		}

		if ($id == "")
		{
			$this->session->set_flashdata('error', 'Invalid Ledger account.');
			redirect('accounts/masteraccounts');
			return;
		}

		$this->db->from('ac_config_ledgers')->where('id', $id);
		$ledger_data_q = $this->db->get();
		if ($ledger_data_q->num_rows() < 1)
		{
			$this->session->set_flashdata('error', 'Invalid Ledger account.');
			redirect('accounts/masteraccounts');
			return;
		}
		$ledger_data = $ledger_data_q->row();

		$this->db->trans_start();
		$update_data = array(
			'status' => CONFIRMKEY,
		);
		if ( ! $this->db->where('id', $id)->update('ac_config_ledgers', $update_data))
		{
			$this->db->trans_rollback();
			$this->session->set_flashdata('error', 'Error updating Ledger account - ' . $id . '.');
			$this->logger->write_message("error", "Error updating Ledger account called " . $id . " [id:" . $id . "]");
			redirect('accounts/masteraccounts');

			return;
		} else {

			$this->db->trans_complete();
			//$this->messages->add('Updated Ledger account - ' . $id . '.', 'success');
			$this->session->set_flashdata('error', 'Updated Ledger account - ' . $id . '.');
			$this->logger->write_message("success", "Updated Ledger account called " . $id . " [id:" . $id . "]");
			redirect('accounts/masteraccounts');
			return;
		}
	}

	function delete($id)
	{
//		var_dump($id);
//		die();
		/* Check access */
		if ( ! check_access('delete ledger'))
		{
			$this->session->set_flashdata('error', 'Permission denied.');
			redirect('accounts/masteraccounts');
			return;
		}

		/* Check for account lock */
		if ($this->config->item('account_locked') == 1)
		{
			//$this->messages->add('Account is locked.', 'error');
			$this->session->set_flashdata('error', 'Account is locked.');
			redirect('accounts/masteraccounts');
			return;
		}

		/* Checking for valid data */
		//$id = $this->input->xss_clean($id);

		if ($id == "")// edited by Udani 10-09-2013
		{
			//$this->messages->add('Invalid Ledger account.'.$id, 'error');
			$this->session->set_flashdata('error', 'Invalid Ledger account.'.$id);
			redirect('accounts/masteraccounts');
			return;
		}
		if(ledger_deletable($id)){
			$name = $this->Ledger_model->delete_ledger($id);
			if($name){
				$this->session->set_flashdata('msg', 'Deleted Ledger account - ' . $name . '.');
				$this->logger->write_message("success", "Deleted Ledger account called " . $name . " [id:" . $id . "]");
			}else{
				$this->session->set_flashdata('error', 'Unable to Delete Ledger account.');

			}
		}
		redirect('accounts/account/load_acclist');

		/*$this->db->from('ac_entry_items')->where('ledger_id', $id);
		if ($this->db->get()->num_rows() > 0)
		{
			//$this->messages->add('Cannot delete non-empty Ledger account.', 'error');
			$this->session->set_flashdata('error', 'Cannot delete non-empty Ledger account.');
			redirect('accounts/masteraccounts');
			return;
		}

		//Get the ledger details
		$this->db->from('ac_config_ledgers')->where('id', $id);
		$ledger_q = $this->db->get();
		if ($ledger_q->num_rows() < 1)
		{
			///$this->messages->add('Invalid Ledger account.', 'error');
			$this->session->set_flashdata('error', 'Invalid Ledger account.');
			redirect('accounts/masteraccounts');
			return;
		} else {
			$ledger_data = $ledger_q->row();
		}

		//Deleting ledger
		$this->db->trans_start();
		if ( ! $this->db->delete('ac_config_ledgers', array('id' => $id)))
		{
			$this->db->trans_rollback();
			//$this->messages->add('Error deleting Ledger account - ' . $ledger_data->name . '.', 'error');
			$this->session->set_flashdata('error', 'Error deleting Ledger account - ' . $ledger_data->name . '.');
			$this->logger->write_message("error", "Error deleting Ledger account called " . $ledger_data->name . " [id:" . $id . "]");
			redirect('accounts/masteraccounts');
			return;
		} else {
			//Deleting reconciliation data if present
			$this->Ledger_model->delete_reconciliation($id);
			$this->db->trans_complete();
			//$this->messages->add('Deleted Ledger account - ' . $ledger_data->name . '.', 'success');
			$this->session->set_flashdata('msg', 'Deleted Ledger account - ' . $ledger_data->name . '.');
			$this->logger->write_message("success", "Deleted Ledger account called " . $ledger_data->name . " [id:" . $id . "]");
			redirect('accounts/masteraccounts');
			return;
		}*/
		return;
	}

	function balance($ledger_id = 0)
	{
		if ($ledger_id != '')
			echo $this->Ledger_model->get_ledger_balance($ledger_id);

		else
			echo "";
		return;
	}

	function checkLedgersBygroup($groupid)
	{
		return $this->Ledger_model->checkLedgersBygroup($groupid);
	}
}

/* End of file ledger.php */
/* Location: ./system/application/controllers/ledger.php */
