<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//model create by udani_dissanayake
//date:04/04/2013

class Config_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_data($table) { //get all brands
		$this->db->select('*');
		$this->db->order_by('NAME');
		$query = $this->db->get($table); 
		return $query->result(); 
    }
	function get_brdcode_by_brdname($brdname) { //get all catogories
		$this->db->select('BRDCODE');
		$this->db->where('BRDNAME',$brdname);
		$query = $this->db->get('itmbrd'); 
		 if ($query->num_rows > 0) {
            return $query->row();
        } else 
			return false;
    }
	function add_brand($brdname)
	{
		$id=$this->getmaincode("BRDCODE","BRD","itmbrd");
		$data=array( 
		'BRDCODE' => $id,
		'BRDNAME' => $brdname);
		$insert = $this->db->insert('itmbrd', $data);
		return $id;
	}
	function edit_brand($id,$catname)
	{
		//$id=$this->getmaincode("CATCODE","CAT","itmcat");
		$data=array( 
		'BRDNAME' => $catname);
		$this->db->where('BRDCODE', $id);
       $update= $this->db->update('itmbrd', $data);
		return $id;
	}
	function delete_brand($id)
	{
		$this->db->where('BRDCODE', $this->uri->segment(3));
        $update= $this->db->delete('itmbrd');
	}
	function get_catogery() { //get all catogories
		$this->db->select('CATCODE,CATNAME');
		$this->db->order_by('CATNAME');
		$query = $this->db->get('itmcat'); 
		return $query->result(); 
    }
	function get_catcode_by_catename($catname) { //get all catogories
		$this->db->select('CATCODE,CATNAME');
		$this->db->where('CATNAME',$catname);
		$query = $this->db->get('itmcat'); 
		 if ($query->num_rows > 0) {
            return $query->row();
        } else 
			return false;
    }
	function add_catogery($catname)
	{
		$id=$this->getmaincode("CATCODE","CAT","itmcat");
		$data=array( 
		'CATCODE' => $id,
		'CATNAME' => $catname);
		$insert = $this->db->insert('itmcat', $data);
		return $id;
	}
	
	function edit_catogery($id,$catname)
	{
		//$id=$this->getmaincode("CATCODE","CAT","itmcat");
		$data=array( 
		'CATNAME' => $catname);
		$this->db->where('CATCODE', $id);
       $update= $this->db->update('itmcat', $data);
		return $id;
	}
	function delete_catogery($id)
	{
		$this->db->where('CATCODE', $this->uri->segment(3));
        $update= $this->db->delete('itmcat');
	}
	function get_mstype() { //get messure type
		$this->db->select('MSTCODE,MSTNAME');
		$this->db->order_by('MSTNAME');
		$query = $this->db->get('itmmst'); 
		return $query->result();
    }
	function edit_mstype($id,$catname)
	{
		//$id=$this->getmaincode("CATCODE","CAT","itmcat");
		$data=array( 
		'MSTNAME' => $catname);
		$this->db->where('MSTCODE', $id);
       $update= $this->db->update('itmmst', $data);
		return $id;
	}
	function delete_mstype($id)
	{
		$this->db->where('MSTCODE', $this->uri->segment(3));
        $update= $this->db->delete('itmmst');
	}
	function get_mstcode_by_mstname($mstname) { //get all catogories
		$this->db->select('MSTCODE');
		$this->db->where('MSTNAME',$mstname);
		$query = $this->db->get('itmmst'); 
		 if ($query->num_rows > 0) {
            return $query->row();
        } else 
			return false;
    }
	
	function add_mtype($mstname)
	{
		$id=$this->getmaincode("MSTCODE","MST","itmmst");
		$data=array( 
		'MSTCODE' => $id,
		'MSTNAME' => $mstname);
		$insert = $this->db->insert('itmmst', $data);
		return $id;
	}
	function add_item($catcode,$brdcode,$mstcode)
	{
		$id=$this->getmaincode("ITMCODE","ITM","itmms");
		$data=array( 
		'ITMCODE' => $id,
		'ITMBRD' => $brdcode,
		'ITMCAT' => $catcode,
		'ITMMST' => $mstcode,
		'ITMDIS'=>$this->input->post('ITMDIS'),
		'ITMROL'=>$this->input->post('ITMROL'));
		$insert = $this->db->insert('itmms', $data);
		return $id;
	}
	function edit_item($catcode,$brdcode,$mstcode)
	{
		
		$data=array( 
		
		'ITMBRD' => $brdcode,
		'ITMCAT' => $catcode,
		'ITMMST' => $mstcode,
		'ITMDIS'=>$this->input->post('ITMDIS'),
		'ITMROL'=>$this->input->post('ITMROL'));
		$this->db->where('ITMCODE', $this->input->post('ITMCODE'));
       $update= $this->db->update('itmms', $data);
		
	}
	function delete_item($id)
	{
		if($this->no_item_in_stock())
		{
		$this->db->where('ITMCODE', $this->uri->segment(3));
		 $update= $this->db->delete('itmms');
		}
		
       
	}
	function get_all_items()
	{
		$this->db->select('itmms.ITMCODE,itmms.ITMROL,itmms.ITMDIS,itmmst.MSTNAME,itmcat.CATNAME,itmbrd.BRDNAME');
        $this->db->from('itmms');
		$this->db->join('itmmst','itmms.ITMMST=itmmst.MSTCODE');
		$this->db->join('itmcat','itmms.ITMCAT=itmcat.CATCODE');
		$this->db->join('itmbrd','itmms.ITMBRD=itmbrd.BRDCODE');
		$this->db->order_by('itmms.ITMCODE','desc');
		$query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
	}
	function get_items_by_itmcode()
	{
		$this->db->select('itmms.ITMCODE,itmms.ITMROL,itmms.ITMDIS,itmmst.MSTNAME,itmcat.CATNAME,itmbrd.BRDNAME');
        $this->db->from('itmms');
		$this->db->join('itmmst','itmms.ITMMST=itmmst.MSTCODE');
		$this->db->join('itmcat','itmms.ITMCAT=itmcat.CATCODE');
		$this->db->join('itmbrd','itmms.ITMBRD=itmbrd.BRDCODE');
		$this->db->where('itmms.ITMCODE',$this->uri->segment(3));
		$query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->row();
        }
	}
	function get_all_items_by_catcode($id)
	{
		$this->db->select('itmms.ITMDIS,itmmst.MSTNAME,itmcat.CATNAME,itmbrd.BRDNAME');
        $this->db->from('itmms');
		 $this->db->where('itmms.ITMCAT',$id);
		$this->db->join('itmmst','itmms.ITMMST=itmmst.MSTCODE');
		$this->db->join('itmcat','itmms.ITMCAT=itmcat.CATCODE');
		$this->db->join('itmbrd','itmms.ITMBRD=itmbrd.BRDCODE');
		$query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result();
        }
	}
	function no_item_in_thiscode($code)
	{
		$this->db->select('itmms.ITMDIS');
        $this->db->from('itmms');
		$this->db->where($code,$this->uri->segment(3));
		$query = $this->db->get();
        if ($query->num_rows > 0) {
            return false;
        }
		else
		return true;
	}
	function no_item_in_stock()
	{
		$this->db->select('inventory.ITMCODE');
        $this->db->from('inventory');
		$this->db->where('ITMCODE',$this->uri->segment(3));
		$query = $this->db->get();
        if ($query->num_rows > 0) {
            return false;
        }
		else
		return true;
	}
	 function getmaincode($idfield,$prifix,$table)
	{
	
 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table);
        
		$newid="";
	
        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=$prifix.str_pad(1, 5, "0", STR_PAD_LEFT);
		

			 }
			 else{
			 $prjid=substr($prjid,3,5);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=$prifix.str_pad($newid, 5, "0", STR_PAD_LEFT);
			
			
			 }
        }
		else
		{
		
		$newid=str_pad(1, 5, "0", STR_PAD_LEFT);
		$newid=$prifix.$newid;
		}
	return $newid;
	
	}
	
	function remove_item($id){
		$this->db->where('ITMCODE',$id);
		$this->db->delete('itmms');
	}

}