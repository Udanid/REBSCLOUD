<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Entrysearch_model extends CI_Model {

	function get_entries($fromdate,$todate,$ledger,$amount,$discription,$prj_id,$lot_id){

		$this->db->select('ac_entries.*,re_prjaclotdata.lot_number,re_projectms.project_name,ac_recieptdata.RCTNO');
		$this->db->join('re_projectms','re_projectms.prj_id=ac_entries.prj_id','left');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=ac_entries.lot_id','left');
		$this->db->join('ac_entry_items','ac_entry_items.entry_id=ac_entries.id','left');
		$this->db->join('ac_recieptdata','ac_recieptdata.RCTREFNO=ac_entries.id','left');
		if($fromdate != 'all')
			$this->db->where('ac_entries.date >=',$fromdate);
		if($todate != 'all')
			$this->db->where('ac_entries.date <=',$todate);
		if($prj_id != 'all')
			$this->db->where('ac_entries.prj_id',$prj_id);
		if($lot_id != 'all')
			$this->db->where('ac_entries.lot_id',$lot_id);
		if($discription != 'all')
			$this->db->like('ac_entries.narration',$discription);
		if($amount != 'all')
			$this->db->where('ac_entries.dr_total',$amount);
		if($ledger != 'all'){
			$this->db->where('ac_entry_items.ledger_id',$ledger);
			$this->db->where('ac_entry_items.dc','c');
		}
		$this->db->group_by('ac_entries.id');
		$query = $this->db->get('ac_entries');
		if($query->num_rows>0)
			return $query->result();
		else
			return false;
	}
}
?>