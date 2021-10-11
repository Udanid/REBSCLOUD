<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_design_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }



  function get_designtype_rooms($id) { //get all boq task
    $this->db->select('*');
    $this->db->where('design_id',$id);
    $query = $this->db->get('hm_config_floors');
    if(count($query->result())>0){
      return $query->result();
    }else{
      return false;
    }

  }

  function get_floor_related_rooms($flrid){
    $this->db->select('hm_config_floorrooms.*,hm_config_roomtypes.roomtype_name');
    $this->db->join('hm_config_roomtypes','hm_config_floorrooms.roomtype_id = hm_config_roomtypes.roomtype_id');
    $this->db->where('floor_id',$flrid);
    $query = $this->db->get('hm_config_floorrooms');
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }







}
