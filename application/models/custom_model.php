<?php

class Custom_model extends CI_Model
{

    function Custom_model()
    {
        parent::__construct();
    }

    function get_entry_id($entry_type_name)
    {
        $this->db->from('ac_entry_types')->where('label', $entry_type_name);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0) {
            $data = $ledger_q->row();
            return $data->id;
        } else{
            return $entry_type_name;
        }
    }
    function get_entry_name($entry_type_id)
    {
        $this->db->from('ac_entry_types')->where('id', $entry_type_id);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0) {
            $data = $ledger_q->row();
            return $data;
        } else{
            return $entry_type_id;
        }
    }
}