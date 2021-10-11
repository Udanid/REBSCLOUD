<?php

class Group_model extends CI_Model {

    function Group_model()
    {
        parent::__construct();
    }

    function get_all_ac_groups($id = NULL)
    {
        $options = array();
        if ($id == NULL)
            $this->db->from('ac_groups')->where('id >', 0)->order_by('name', 'asc');
        else
            $this->db->from('ac_groups')->where('id >', 0)->where('id !=', $id)->order_by('name', 'asc');
        $group_parent_q = $this->db->get();
        foreach ($group_parent_q->result() as $row)
        {
            $options[$row->id] = $row->name;
        }
        return $options;
    }

    function get_ledger_ac_groups()
    {
        $options = array();
        $this->db->from('ac_groups')->where('id >', 4)->order_by('name', 'asc');
        $group_parent_q = $this->db->get();
        foreach ($group_parent_q->result() as $row)
        {
            $options[$row->id] = $row->name;
        }
        return $options;
    }

    function get_all_groups()
    {
        
        $this->db->from('ac_groups');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
	function update_order(){
		$data = array ( 'group_order' => $this->input->post('order') );
		$this->db->where('id',$this->input->post('id'));
		$this->db->update('ac_groups',$data);
		
	}
   
}
