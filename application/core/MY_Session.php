<? 

class MY_Session extends CI_Session {

public function __construct() {
    parent::__construct();
}

function sess_destroy() {

    //write your update here 
  //  $this->CI->db->update('YOUR_TABLE', array('YOUR_DATA'), array('YOUR_CONDITION'));
 $this->CI->db->select('*');
		 $this->CI->db->where('userid',$this->session->userdata('userid'));
		//$this->db->order_by('pomaster.PODATE','DESC');
		$query =  $this->CI->db->get('cm_activflag');
		$price=NULL; 
		 if ($query->num_rows >0) {
            $dataset= $query->result();
			foreach($dataset as $raw)
			{
				$data=array('active_flag'=>0);
				 $this->CI->db->where($raw->field_name,$raw->record_key);
				 $this->CI->db->update($raw->table_name,$data);
			}
			 $this->CI->db->where('userid',$this->session->userdata('userid'));
			 $this->CI->db->delete('cm_activflag');
			
        }
    //call the parent 
    parent::sess_destroy();
}

}
?>