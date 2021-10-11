<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_uploadboq_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function is_check_customized_design($designid)
	{
		$this->db->select('*');
         $this->db->where('type','M');
	     $this->db->where('design_id',$designid);

        $query = $this->db->get('hm_config_designtype');
		echo $this->db->last_query();
        if($query->num_rows() > 0)
          {
            return false;

          }else{
            return true;
          }
        
		
	}
	
	function delete_all_boq_masterdata($designid)
	{
		
		$this->db->select('*');
         $this->db->where('design_id',$designid);

        $query = $this->db->get('hm_config_boqcat');
        if($query->num_rows >0)
          {
            $data= $query->result();
			foreach($data as $raw)
			{
				
				$this->db->select('*');
      		 	$this->db->where('boqcat_id',$raw->boqcat_id);
				 $query = $this->db->get('hm_config_boqsubcat');
       		 	if($query->num_rows >0)
       		 	{
					 $data2= $query->result();
					foreach($data2 as $raw2)
					{
						$this->db->select('*');
						$this->db->where('boqsubcat_id',$raw2->boqsubcat_id);
						 $query = $this->db->get('hm_config_boqtask');
						if($query->num_rows >0)
						{
							 $data3= $query->result();
								foreach($data3 as $raw3)
								{
								
										$this->db->where('task_id',$raw3->task_id);
										$this->db->delete('hm_config_task');
									
									
								}
								
							
						}
						$this->db->where('boqsubcat_id',$raw2->boqsubcat_id);
						$this->db->delete('hm_config_boqtask');
					}
				}
				$this->db->where('boqcat_id',$raw->boqcat_id);
				$this->db->delete('hm_config_boqsubcat');
			}
			 $this->db->where('design_id',$designid);
			$this->db->delete('hm_config_boqcat');
			 $this->db->where('design_id',$designid);
			$this->db->delete('hm_config_designtype');

          }else{
            return true;
          }
        
	}
	function delete_lot_boqtask($lotid)
	{
		$this->db->where('lot_id',$lotid);
		$this->db->delete('hm_prjfboq');
		$this->db->where('lot_id',$lotid);
		$this->db->delete('hm_prjacboqms');
		$this->db->where('lot_id',$lotid);
		$this->db->delete('hm_prjfboqmaterial');
	}
	
	function add_newcustom_designing($lotid)
	{
		$this->db->select('hm_prjaclotdata.lot_number,hm_projectms.project_name,hm_config_designtype.*');
		$this->db->where('lot_id',$lotid);
		$this->db->join("hm_config_designtype","hm_config_designtype.design_id=hm_prjaclotdata.design_id");
		 $this->db->join("hm_projectms","hm_projectms.prj_id=hm_prjaclotdata.prj_id");
		 $query = $this->db->get('hm_prjaclotdata');
		  if($query->num_rows >0)
		{
		 	$data3= $query->row();
		 	$name=$data3->project_name.'-'.$data3->lot_number;
		 	 $array = array('prjtype_id'=> $data3->prjtype_id,
			'design_name'=>$name,
			'short_code'=>'',
			'description'=>$data3->description,
			'create_date'=>date("Y-m-d"),
			'create_by'=>$this->session->userdata('userid'),
			'num_of_floors'=>$data3->num_of_floors,
			'tot_ext'=>$data3->tot_ext,
			'type'=>'C');
		
		
		
			$insert=$this->db->insert('hm_config_designtype',$array);
			$newdesign = $this->db->insert_id();
			 $updatearr = array(
			'design_id'=>$newdesign,
			);
			$this->db->where('lot_id',$lotid);
			$this->db->update('hm_prjaclotdata',$updatearr);
			
			return $newdesign;
						
		}
		else{ 
			return false;
		}
		

	}
	function add_boq_cat($name,$designing)
	{
		 $array = array('cat_name'=>$name,
			'design_id'=>$designing,
			'create_date'=>date("Y-m-d"),
			'create_by'=>$this->session->userdata('userid'),
			);
		
		
		
			$insert=$this->db->insert('hm_config_boqcat',$array);
			$insertid = $this->db->insert_id();
			return $insertid;
	}
	function add_boq_sub_cat($code,$name,$catid)
	{
		 $array = array('subcat_name'=>$name,
				'subcat_code'=>$code,
				'boqcat_id'=>$catid,
			);
		
		
		
			$insert=$this->db->insert('hm_config_boqsubcat',$array);
			$insertid = $this->db->insert_id();
			return $insertid;
	}
	function get_unit_id($unitname)
	{
		$name=trim($unitname);
			$this->db->select('*');
         $this->db->where('mt_name',$name);
	      $query = $this->db->get('hm_config_messuretype');
       	 if($query->num_rows >0)
          {
			  $data=$query->row();
			  return  $data->mt_id;
		  }
		  else
		  {
			   $array = array('mt_name'=>$name,
			
				);
			$insert=$this->db->insert('hm_config_messuretype',$array);
			$mat_id = $this->db->insert_id();
			return $mat_id;
		  }
		
		
	}
	function add_boq_task($taskcode,$relativecode,$detail,$subcatid,$qty,$unit,$rate,$amount,$prj_id,$lot_id)
	{
		$unit=$this->get_unit_id($unit);
			$qty=str_replace(',','',$qty);
		$rate=str_replace(',','',$rate);
		$amount=str_replace(',','',$amount);
		 $detail = preg_replace('/[^a-zA-Z0-9.]/',' ',iconv('UTF-8', 'ASCII//TRANSLIT',$detail));
	                   
		 $array = array('task_name'=>$detail,
				'relative_code'=>$relativecode,
				'task_code'=>$taskcode,
				'task_type'=>'BOQ'
			);
			$insert=$this->db->insert('hm_config_task',$array);
			$task_id = $this->db->insert_id();
			
			$array = array('boqsubcat_id'=>$subcatid,
				'task_id'=>$task_id,
				'description'=>$detail,
				'qty'=>$qty,
				'unit'=>$unit,
				'rate'=>$rate,
				'amount'=>$amount,
				'CODE'=>$relativecode,
			);
			$insert=$this->db->insert('hm_config_boqtask',$array);
				$boqtask_id = $this->db->insert_id();
			$array = array('prj_id'=>$prj_id,
				'lot_id'=>$lot_id,
				'boqtask_id'=>$boqtask_id,
				'boqsubcat_id'=>$subcatid,
				'description'=>$detail,
				'qty'=>$qty,
				'unit'=>$unit,
				'rate'=>$rate,
				'amount'=>$amount,
				
			);
			$insert=$this->db->insert('hm_prjacboqms',$array);
				$insertid = $this->db->insert_id();
			$array = array('prj_id'=>$prj_id,
				'lot_id'=>$lot_id,
				'boqsubcat_id'=>$subcatid,
				'boqtask_id'=>$boqtask_id,
				'description'=>$detail,
				'qty'=>$qty,
				'unit'=>$unit,
				'rate'=>$rate,
				'amount'=>$amount,
				
			);
			$insert=$this->db->insert('hm_prjfboq',$array);
			$insertid = $this->db->insert_id();
			return $insertid;
	}
    function add_boq_material_types($code)
	{
		$codearr=explode('(',$code);
		
		$mat_name=trim($codearr[0]);// matierieal name
		if(count($codearr)==2)
		$mt_name=str_replace(')','',$codearr[1]);//messure type name
		else
		$mt_name='nos';
		$mt_id=$this->get_unit_id($mt_name);
		$mat_name=str_replace('"','',$mat_name);
		$mat_name=str_replace('×','-',$mat_name);
		$mat_name=str_replace("'",'',$mat_name);
		$mat_name=str_replace("*",'-',$mat_name);
		$mat_name=preg_replace('/[^A-Za-z0-9\-]/', '', $mat_name);
		echo $mat_name.'<br>';
		 $this->db->select('*');
         $this->db->where('mat_name',$mat_name);
	      $query = $this->db->get('hm_config_material');
       	 if($query->num_rows >0)
          {
			  $data=$query->row();
			  return  $data->mat_id;
		  }
		  else
		  {
				 $code= $this->getmaincode('mat_code','MAT','hm_config_material');
			 	  $array = array('mat_name'=>$mat_name,
			  	 'mat_code'=>$code,
			   	 'mt_id'=>$mt_id,
				 'create_date'=>date("Y-m-d"),
			'create_by'=>$this->session->userdata('userid'),
		
			
					);
			$insert=$this->db->insert('hm_config_material',$array);
			$mat_id = $this->db->insert_id();
			return $mat_id;
		  }
		
	}
      function add_boq_materials($prj_id,$lotid,$fboqid,$matid,$amount)
	  {
		    $insertmat = array(
					 'prj_id'      => $prj_id,
					 'lot_id'  => $lotid,
					 'fboq_id' => $fboqid,
					 'mat_id'  => $matid,
					  'value'=>$amount,
					 'last_update' => date('Y-m-d H:i:s'),
					 'update_by'   => $this->session->userdata('userid'),
	  				 );
					 $insert=$this->db->insert('hm_prjfboqmaterial',$insertmat);
			$mat_id = $this->db->insert_id();
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
			 $newid=$prifix.str_pad(1, 4, "0", STR_PAD_LEFT);


			 }
			 else{
			 $prjid=substr($prjid,3,4);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=$prifix.str_pad($newid, 4, "0", STR_PAD_LEFT);


			 }
        }
		else
		{

		$newid=str_pad(1, 4, "0", STR_PAD_LEFT);
		$newid=$prifix.$newid;
		}
	return $newid;


	}


}
