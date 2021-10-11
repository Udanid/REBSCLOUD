<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_config_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*................................. terrance model coding............................. */

       function get_all_mesurements(){
         //return $this->db->get('hm_config_messuretype');
         $this->db->order_by('mt_id','DESC');
         $query = $this->db->get('hm_config_messuretype');

       if(count($query->result())>0)
         {
           return $query->result();
         }else{
           return false;
         }
       }

       function get_meterials_all($id,$pagination_counter,$page_count){

         $this->db->select('*');
         $this->db->from('hm_config_material as hcm');
         $this->db->join('hm_config_messuretype as hcmt','hcm.mt_id=hcmt.mt_id','left');
         if($id){
          $this->db->where('hcm.mat_id',$id);
         }

         $this->db->order_by('hcm.mat_id','DESC');

         if($pagination_counter){
           $this->db->limit($pagination_counter, $page_count);
         }
         $this->db->order_by('mat_id','DESC');
         $query = $this->db->get();
       if(count($query->result())>0)
         {
           return $query->result();
         }else{
           return false;
         }
       }

       function get_meterials_byid($id){

        $this->db->select('*');
        $this->db->from('hm_config_material as hcm');
        $this->db->join('hm_config_messuretype as hcmt','hcm.mt_id=hcmt.mt_id','left');
        $this->db->where('hcm.mat_id',$id);

        $query = $this->db->get();
        if(count($query->result())>0)
          {
            return $query->row();

          }else{
            return false;
          }
        }

       function get_floor_list($id,$pagination_counter,$page_count){
         $this->db->select('hmcf.*,hmcdt.design_id,
         hmcdt.prjtype_id,
         hmcdt.design_name,
         hmcdt.short_code,
         hmcdt.description,
         hmcdt.num_of_floors,
         hmcdt.tot_ext AS hmcdt_tot_ext');
         $this->db->from('hm_config_floors as hmcf');
         $this->db->join('hm_config_designtype as hmcdt','hmcf.design_id=hmcdt.design_id','left');

         if($id){
              $this->db->where('hmcf.floor_id',$id);
         }

         if($pagination_counter){
           $this->db->limit($pagination_counter, $page_count);
         }

           $this->db->order_by('hmcf.floor_id','DESC');

         $query = $this->db->get();
       if(count($query->result())>0)
         {
           return $query->result();
         }else{
           return false;
         }
       }


       function get_floorrooms_all($id,$pagination_counter,$page_count){
         $this->db->select("*");
         $this->db->from("hm_config_floorrooms as hmcfr");
         $this->db->join("hm_config_floors as hmcf","hmcfr.floor_id=hmcf.floor_id");
         $this->db->join("hm_config_roomtypes as hmcrt","hmcfr.roomtype_id=hmcrt.roomtype_id");

         if($id){
          $this->db->where('hmcfr.room_id',$id);
         }

         if($pagination_counter){
           $this->db->limit($pagination_counter, $page_count);
         }

           $this->db->order_by('hmcfr.room_id','DESC');

         $query=$this->db->get();
         if(count($query->result())>0)
         {
           return $query->result();
         }else{
           return false;
         }
       }

       function get_floor_related_images($flrid){
         $this->db->where('floor_id',$flrid);
           $query = $this->db->get('hm_config_floorimg');
       if(count($query->result())>0)
         {
           return $query->result();
         }else{
           return false;
         }
       }

       function insert_floor($insertfloorarr){

         $this->db->insert('hm_config_floors', $insertfloorarr);
         return $this->db->insert_id();

       }

       //add new material
       function add_new_meterials($metrial_inst_arr){
         $this->db->trans_start();
         $this->db->insert('hm_config_material',$metrial_inst_arr);
         $this->db->trans_complete();
         if ($this->db->affected_rows() > 0) {
           return TRUE;
       } else {
           // any trans error?
           if ($this->db->trans_status() === FALSE) {
               return false;
           }
           return true;
       }
       }

       //update meterial records
       function update_meterials($metrial_upd_arr,$emetid){
         $this->db->trans_start();
         $this->db->where('mat_id',$emetid);
         $this->db->update('hm_config_material',$metrial_upd_arr);
         $this->db->trans_complete();
         if ($this->db->affected_rows() > 0) {
           return TRUE;
       } else {
           // any trans error?
           if ($this->db->trans_status() === FALSE) {
               return false;
           }
           return true;
       }
       }

       function update_floor_details($updfloorarr,$flrid){
         $this->db->trans_start();
         $this->db->where('floor_id',$flrid);
         $this->db->update('hm_config_floors',$updfloorarr);
         $this->db->trans_complete();
         if ($this->db->affected_rows() > 0) {
           return TRUE;
       } else {
           // any trans error?
           if ($this->db->trans_status() === FALSE) {
               return false;
           }
           return true;
       }
       }

       function inserting_files($imageinsrtarr){
         $this->db->trans_start();
         $this->db->insert('hm_config_floorimg',$imageinsrtarr);
         $this->db->trans_complete();
         if ($this->db->affected_rows() > 0) {
           return TRUE;
       } else {
           // any trans error?
           if ($this->db->trans_status() === FALSE) {
               return false;
           }
           return true;
       }
       }



       function delete_previous_imges($flrid){
         $this->db->trans_start();
         $this->db->where('floor_id', $flrid);
           $this->db->delete('hm_config_floorimg');
           $this->db->trans_complete();
         if ($this->db->affected_rows() > 0) {
           return TRUE;
       } else {
           // any trans error?
           if ($this->db->trans_status() === FALSE) {
               return false;
           }
           return true;
       }
       }

       function insert_new_fllorrooms($floorroomarr){
         $this->db->trans_start();
         $this->db->insert('hm_config_floorrooms',$floorroomarr);
         $this->db->trans_complete();
         if ($this->db->affected_rows() > 0) {
           return TRUE;
       } else {
           // any trans error?
           if ($this->db->trans_status() === FALSE) {
               return false;
           }
           return true;
       }
       }

       function update_floor_room_details($floorroomarr,$eflrroomid){
         $this->db->trans_start();
         $this->db->where('room_id',$eflrroomid);
         $this->db->update('hm_config_floorrooms',$floorroomarr);
         $this->db->trans_complete();
         if ($this->db->affected_rows() > 0) {
           return TRUE;
       } else {
           // any trans error?
           if ($this->db->trans_status() === FALSE) {
               return false;
           }
           return true;
       }
       }


   /*................................. terrance model coding............................. */


/*2019-11-04 dev nadee */
  public function check_foreign_key($table,$id,$feild_name)
  {
    $this->db->select("*");
    $this->db->where($feild_name,$id);
    $query=$this->db->get($table);
    if(count($query->result())>0)
    {
      return false;
    }else{
      return true;
    }
  }
  //end check foreign key


  public function get_messures($pagination_counter,$page_count)//get all messures types
  {
    $this->db->select("*");
    //$this->db->order_by('mt_name');
		$this->db->limit($pagination_counter, $page_count);
    $this->db->order_by('mt_id','DESC');
    $query=$this->db->get("hm_config_messuretype");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  function get_messures_byid($id)//get meassures by id
  {
    $this->db->select("*");
    $this->db->where('mt_id',$id);
    $query=$this->db->get("hm_config_messuretype");
    if(count($query->result())>0)
    {
      return $query->row();
    }else{
      return false;
    }
  }

  public function add_messuretype()// add new meassure
  {
    $name=$this->input->post('messure_name');
    $array = array('mt_name' => $name, );
    $insert=$this->db->insert('hm_config_messuretype',$array);

    if($this->db->affected_rows()>0)
    {
      return true;
    }else{
      return false;
    }
  }

  public function update_messuretype()//update meassure
  {
    $name=$this->input->post('messure_name');
    $id=$this->input->post('messure_id');
    $array = array('mt_name' => $name, );
    $this->db->where('mt_id',$id);
    $update=$this->db->update('hm_config_messuretype',$array);

    if($this->db->affected_rows()>0)
    {
      return true;
    }else{
      return false;
    }
  }

  function delete_messuretype($id)//delete meassures
  {
    $this->db->where('mt_id',$id);
    $delete=$this->db->delete('hm_config_messuretype');
    if($this->db->affected_rows()>0){
      return true;

    }else{
      return false;
    }
  }

  public function get_services($pagination_counter, $page_count)//get all services types
  {
    $this->db->select("*");
    $this->db->order_by('service_id','DESC');
		$this->db->limit($pagination_counter, $page_count);

    $query=$this->db->get("hm_config_services");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }
  public function get_services_all()//get all services types
  {
    $this->db->select("*");
    $this->db->order_by('service_id','DESC');
    $query=$this->db->get("hm_config_services");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  public function get_services_byid($id)//get one services type
  {
    $this->db->select("*");
    $this->db->where('service_id',$id);
    $query=$this->db->get("hm_config_services");
    if(count($query->result())>0)
    {
      return $query->row();
    }else{
      return false;
    }
  }

  public function add_services()// add new service
  {
    $ser_name=$this->input->post('service_name');
    $ser_pay_type=$this->input->post('pay_type');
    $ser_pay_rate=$this->input->post('pay_rate');
    $array = array('service_name' =>$ser_name ,
    'pay_type'=>$ser_pay_type,
    'pay_rate'=>$ser_pay_rate,
    'update_by'=>$this->session->userdata('userid'),
    'update_date'=>date("Y-m-d"),
    );
    $insert=$this->db->insert('hm_config_services',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }

  public function update_services()//update services
  {
    $ser_id=$this->input->post('service_id');
    $ser_name=$this->input->post('service_name');
    $ser_pay_type=$this->input->post('pay_type');
    $ser_pay_rate=$this->input->post('pay_rate');
    $array = array('service_name' =>$ser_name ,
    'pay_type'=>$ser_pay_type,
    'pay_rate'=>$ser_pay_rate,
    'update_by'=>$this->session->userdata('userid'),
    'update_date'=>date("Y-m-d"),
    );
    $this->db->where('service_id',$ser_id);
    $update=$this->db->update('hm_config_services',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }

  function delete_servicetype($id)//delete services type
  {
    $this->db->where('service_id',$id);
    $delete=$this->db->delete('hm_config_services');
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  function get_roomtypes($pagination_counter, $page_count)//get all room types
  {
    $this->db->select("*");
    $this->db->order_by('roomtype_id','DESC');
		$this->db->limit($pagination_counter, $page_count);
    $query=$this->db->get("hm_config_roomtypes");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }
  function get_roomtypes_all()//get all room types
  {
    $this->db->select("*");
    $this->db->order_by('roomtype_id','DESC');
    $query=$this->db->get("hm_config_roomtypes");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  function get_roomtypes_byid($id)//get one room type
  {
    $this->db->select("*");
    $this->db->where('roomtype_id',$id);
    $query=$this->db->get("hm_config_roomtypes");
    if(count($query->result())>0)
    {
      return $query->row();
    }else{
      return false;
    }
  }

  public function add_roomtypes()//add new room type
  {
    $array = array('roomtype_name' =>$this->input->post('room_name'),
    'def_length'=>$this->input->post('lenth'),
    'def_height'=>$this->input->post('height'),
    'def_width'=>$this->input->post('width')
    );
    $insert=$this->db->insert('hm_config_roomtypes',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }

  public function update_roomtypes()//update room type
  {
    $room_id=$this->input->post('room_id');
    $array = array('roomtype_name' =>$this->input->post('room_name'),
    'def_length'=>$this->input->post('lenth'),
    'def_height'=>$this->input->post('height'),
    'def_width'=>$this->input->post('width')
    );
    $this->db->where('roomtype_id',$room_id);
    $update=$this->db->update('hm_config_roomtypes',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }

  function delete_roomtypes($id)// delete room type
  {
    $this->db->where('roomtype_id',$id);
    $delete=$this->db->delete('hm_config_roomtypes');
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  function get_designtypes($pagination_counter,$page_count)//get all design types
  {
    $this->db->select("hm_config_designtype.*,hm_config_prjtypes.prjtype_name,hm_config_prjtypes.short_code AS prj_short_code");
    $this->db->join('hm_config_prjtypes','hm_config_prjtypes.prjtype_id=hm_config_designtype.prjtype_id');
    $this->db->order_by('hm_config_designtype.design_id','DESC');
		$this->db->limit($pagination_counter, $page_count);
    $query=$this->db->get("hm_config_designtype");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  function get_designtypes_all()//get all design types
  {
    $this->db->select("hm_config_designtype.*,hm_config_prjtypes.prjtype_name,hm_config_prjtypes.short_code AS scode");
    $this->db->join('hm_config_prjtypes','hm_config_prjtypes.prjtype_id=hm_config_designtype.prjtype_id');
    $this->db->order_by('design_name');
    $this->db->order_by('hm_config_designtype.design_id','DESC');
		//$this->db->limit($pagination_counter, $page_count);
    $query=$this->db->get("hm_config_designtype");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  function get_designtypes_byid($id)//get one design type
  {
    $this->db->select("hm_config_designtype.*,hm_config_prjtypes.prjtype_name,hm_config_prjtypes.short_code AS prj_short_code");
    $this->db->join('hm_config_prjtypes','hm_config_prjtypes.prjtype_id=hm_config_designtype.prjtype_id');
    $this->db->where('hm_config_designtype.design_id',$id);
    $query=$this->db->get("hm_config_designtype");
    if(count($query->result())>0)
    {
      return $query->row();
    }else{
      return false;
    }
  }

  function get_prjtypes()//get all project types
  {
    $this->db->select("*");
    $query=$this->db->get("hm_config_prjtypes");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  public function add_designtypes()// add new design types
  {

    $file_array = $this->input->post('file_array');

    $array = array('prjtype_id'=>$this->input->post('prj_type'),
    'design_name'=>$this->input->post('design_name'),
    'short_code'=>$this->input->post('short_code'),
    'description'=>$this->input->post('description'),
    'create_date'=>date("Y-m-d"),
    'create_by'=>$this->session->userdata('userid'),
    'num_of_floors'=>$this->input->post('floors'),
    'tot_ext'=>$this->input->post('tot_ext'),);



    $insert=$this->db->insert('hm_config_designtype',$array);

    if($this->db->affected_rows() > 0)
    {
      if($file_array!==""){
        $designtype_id=$this->db->insert_id();
        return $this->add_design_images($file_array,$designtype_id);
      }else{
        return true;
      }

    }else{
      return false;
    }

  }

  function add_design_images($file_array,$designtype_id){
    $filearray = explode(",", $file_array);
      $filecount = count($filearray);

      for($i=0;$i<$filecount;$i++){

        $imageinsrtarr = array(
          'designtype_id' => $designtype_id,
          'designtype_image' => $filearray[$i]
        );


          $this->db->insert('hm_config_designtype_img',$imageinsrtarr);
        }

        return true;
  }

  public function update_designtypes()//update design types
  {
    $design_id=$this->input->post('design_id');

    $file_array_upd = $this->input->post('file_array_upd');
    $file_array = $this->input->post('file_array');


    $array = array('prjtype_id'=>$this->input->post('prj_type'),
    'design_name'=>$this->input->post('design_name'),
    'short_code'=>$this->input->post('short_code'),
    'description'=>$this->input->post('description'),
    'create_date'=>date("Y-m-d"),
    'create_by'=>$this->session->userdata('userid'),
    'num_of_floors'=>$this->input->post('floors'),
    'tot_ext'=>$this->input->post('tot_ext'),);

    $this->db->where('design_id',$design_id);
    $update=$this->db->update('hm_config_designtype',$array);
    if($this->db->affected_rows() > 0)
    {
      $this->update_designtype_images($file_array_upd,$file_array,$design_id);
      return true;
    }else{
      return false;
    }

  }

  function update_designtype_images($file_array_upd,$file_array,$design_id){
     //prepare for image add to the database..
       $filearrayold = explode(",", $file_array_upd);

       /* check new images are uploaded or not.if not image upload process not works*/
       if($file_array){
        $filearraynew = explode(",", $file_array);
        $finalarr=array_merge($filearrayold,$filearraynew);

        //delete pervious added images..
        $this->db->where('designtype_id',$design_id);
        $this->db->delete('hm_config_designtype_img');

        $filecountall = count($finalarr);
        for($img=1;$img<=$filecountall-1;$img++){

            $imageinsrtarr = array(
              'designtype_id' => $design_id,
              'designtype_image' => $finalarr[$img]
            );

        $this->db->insert('hm_config_designtype_img',$imageinsrtarr);

        }

       }

       // end prepare for image add to the database..
  }

  function delete_designtypes($id)// delete design types
  {
    $this->db->where('design_id',$id);
    $delete=$this->db->delete('hm_config_designtype');
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  function get_hmtask($pagination_counter, $page_count)//get all tasks
  {
    $this->db->select("*");
    $this->db->order_by('task_code');
    $this->db->limit($pagination_counter, $page_count);
    $query=$this->db->get("hm_config_task");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  function get_hmtask_byid($id)//get one task
  {
    $this->db->select("*");
    $this->db->where('task_id',$id);
    $query=$this->db->get("hm_config_task");
    if(count($query->result())>0)
    {
      return $query->row();
    }else{
      return false;
    }
  }

  // function get_hmtask_all()//get one task
  // {
  //   $this->db->select("*");
  //   $query=$this->db->get("hm_config_task");
  //   if(count($query->result())>0)
  //   {
  //     return $query->result();
  //   }else{
  //     return false;
  //   }
  // }
  function get_hmtask_all($type)//get one task
  {
    $this->db->select("*");
    if($type!="All"){
      $this->db->where('task_type',$type);
    }
    $query=$this->db->get("hm_config_task");

    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  public function add_hmtask()//add new task
  {
    $array = array('task_name' =>$this->input->post('task_name'),
    'task_code'=>$this->input->post('task_code'),
    'relative_code'=>$this->input->post('related_code'),
    'task_type'=>$this->input->post('task_type'),
    'ledger_id'=>$this->input->post('ledger_id'),
    'advance_ledger'=>$this->input->post('adv_ledgerid'),
    'active_status'=>"PENDING"
    );
    $insert=$this->db->insert('hm_config_task',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }

  public function update_hmtask()//update task
  {
    $task_id=$this->input->post('task_id');
    $array = array('task_name' =>$this->input->post('task_name'),
    'task_code'=>$this->input->post('task_code'),
    'relative_code'=>$this->input->post('related_code'),
    'task_type'=>$this->input->post('task_type'),
    'ledger_id'=>$this->input->post('ledger_id'),
    'advance_ledger'=>$this->input->post('adv_ledgerid'),
    'active_status'=>"PENDING"
    );
    $this->db->where('task_id',$task_id);
    $update=$this->db->update('hm_config_task',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }

  function task_delete($task_id)// delete task
  {
    $this->db->where('task_id',$task_id);
    $delete=$this->db->delete('hm_config_task');
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  function get_boq($pagination_counter, $page_count)//get all boq
  {
    $this->db->select("hm_config_boqcat.*,hm_config_designtype.design_name,hm_config_designtype.short_code");
    $this->db->join('hm_config_designtype','hm_config_boqcat.design_id = hm_config_designtype.design_id');
    $this->db->order_by('hm_config_boqcat.boqcat_id','DESC');
    $this->db->limit($pagination_counter, $page_count);
    $query=$this->db->get("hm_config_boqcat");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  function get_boq_all()//get all boq
  {
    $this->db->select("hm_config_boqcat.*");
    $this->db->order_by('hm_config_boqcat.boqcat_id','DESC');
    $query=$this->db->get("hm_config_boqcat");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  function get_boq_byid($id)//get one boq
  {
    $this->db->select("hm_config_boqcat.*,hm_config_designtype.design_name,hm_config_designtype.short_code");
    $this->db->join('hm_config_designtype','hm_config_boqcat.design_id = hm_config_designtype.design_id');
    $this->db->where('hm_config_boqcat.boqcat_id',$id);
    $query=$this->db->get("hm_config_boqcat");
    if(count($query->result())>0)
    {
      return $query->row();
    }else{
      return false;
    }
  }

  public function add_boq()//add new boq
  {
    $array = array('cat_name' =>$this->input->post('cat_name'),
    'design_id'=>$this->input->post('design_id'),
    'create_by'=>$this->session->userdata('userid'),
    'create_date'=>date("Y-m-d")
    );
    $insert=$this->db->insert('hm_config_boqcat',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }

  public function update_boq()//update boq
  {
    $boq_id=$this->input->post('boq_id');
    $array = array('cat_name' =>$this->input->post('cat_name'),
    'design_id'=>$this->input->post('design_id'),
    'create_by'=>$this->session->userdata('userid'),
    'create_date'=>date("Y-m-d")
    );
    $this->db->where('boqcat_id',$boq_id);
    $update=$this->db->update('hm_config_boqcat',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }

  function delete_boq($boq_id)// delete boq
  {
    $this->db->where('boqcat_id',$boq_id);
    $delete=$this->db->delete('hm_config_boqcat');
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  function get_subboq($pagination_counter, $page_count)//get all subboq
  {
    $this->db->select("hm_config_boqsubcat.*,hm_config_boqcat.cat_name,hm_config_boqcat.design_id,
    hm_config_designtype.design_name,
    hm_config_designtype.short_code");
    $this->db->join('hm_config_boqcat','hm_config_boqsubcat.boqcat_id = hm_config_boqcat.boqcat_id');
    $this->db->join('hm_config_designtype','hm_config_boqcat.design_id = hm_config_designtype.design_id');
    //$this->db->order_by('hm_config_boqcat.design_id','DESC');
    $this->db->order_by('hm_config_boqsubcat.boqsubcat_id','DESC');
    $this->db->limit($pagination_counter, $page_count);
    $query=$this->db->get("hm_config_boqsubcat");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  function get_subboq_byid($id)//get one subboq
  {
    $this->db->select("hm_config_boqsubcat.*,hm_config_boqcat.cat_name,hm_config_boqcat.design_id,
    hm_config_designtype.design_name,
    hm_config_designtype.short_code");
    $this->db->join('hm_config_boqcat','hm_config_boqsubcat.boqcat_id = hm_config_boqcat.boqcat_id');
    $this->db->join('hm_config_designtype','hm_config_boqcat.design_id = hm_config_designtype.design_id');
    $this->db->where('hm_config_boqsubcat.boqsubcat_id',$id);
    $query=$this->db->get("hm_config_boqsubcat");
    if(count($query->result())>0)
    {
      return $query->row();
    }else{
      return false;
    }
  }

  function get_subboq_all()
  {
    $this->db->select("hm_config_boqsubcat.*,hm_config_boqcat.cat_name");
    $this->db->join('hm_config_boqcat','hm_config_boqsubcat.boqcat_id = hm_config_boqcat.boqcat_id');
    $this->db->order_by('hm_config_boqsubcat.boqsubcat_id','DESC');
    $query=$this->db->get("hm_config_boqsubcat");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  function get_subboq_all_bytask($design_id)
  {
    $this->db->select("hm_config_boqsubcat.*,hm_config_boqcat.cat_name");
    $this->db->join('hm_config_boqsubcat','hm_config_boqtask.boqsubcat_id = hm_config_boqsubcat.boqsubcat_id');
    $this->db->join('hm_config_boqcat','hm_config_boqsubcat.boqcat_id = hm_config_boqcat.boqcat_id');
    $this->db->where('hm_config_boqcat.design_id',$design_id);
    $this->db->group_by('hm_config_boqsubcat.boqsubcat_id');
    $query=$this->db->get("hm_config_boqtask");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  public function add_subboq()//add new subboq
  {
    $array = array('subcat_name' =>$this->input->post('subcat_name'),
    'subcat_code'=>$this->input->post('subcat_code'),
    'boqcat_id'=>$this->input->post('boqcat_id'),
    );
    $insert=$this->db->insert('hm_config_boqsubcat',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }

  public function update_subboq()//update subboq
  {
    $boq_id=$this->input->post('boqsubcat_id');
    $array = array('subcat_name' =>$this->input->post('subcat_name'),
    'subcat_code'=>$this->input->post('subcat_code'),
    'boqcat_id'=>$this->input->post('boqcat_id'),
    );
    $this->db->where('boqsubcat_id',$boq_id);
    $update=$this->db->update('hm_config_boqsubcat',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }

  function delete_subboq($boq_id)// delete subboq
  {
    $this->db->where('boqsubcat_id',$boq_id);
    $delete=$this->db->delete('hm_config_boqsubcat');
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  function get_boqtask_bysubcat($task)//get all boqtasks
  {
    $this->db->select("*");
    $this->db->where('boqsubcat_id',$task);
    //$this->db->limit($pagination_counter, $page_count);
    $query=$this->db->get("hm_config_boqtask");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  function get_boqtask_byid($id)//get one boqtask
  {
    $this->db->select("hm_config_boqtask.*,hm_config_boqsubcat.boqcat_id,
    hm_config_boqcat.design_id");
    $this->db->join('hm_config_boqsubcat','hm_config_boqtask.boqsubcat_id = hm_config_boqsubcat.boqsubcat_id');
    $this->db->join('hm_config_boqcat','hm_config_boqsubcat.boqcat_id = hm_config_boqcat.boqcat_id');
    $this->db->where('boqtask_id',$id);
    $query=$this->db->get("hm_config_boqtask");
    if(count($query->result())>0)
    {
      return $query->row();
    }else{
      return false;
    }
  }

  public function add_boqtask()//add new boqtask
  {
    $array = array('boqsubcat_id' =>$this->input->post('boqsubcat_id'),
    'task_id'=>$this->input->post('task_id'),
    'description'=>$this->input->post('description'),
    'qty'=>$this->input->post('qty'),
    'unit'=>$this->input->post('unit'),
    'rate'=>$this->input->post('rate'),
    'amount'=>$this->input->post('amount'),);
    $insert=$this->db->insert('hm_config_boqtask',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }

  public function update_boqtask()//update boqtask
  {
    $boqtask_id=$this->input->post('boqtask_id');
    $array = array('boqsubcat_id' =>$this->input->post('boqsubcat_id'),
    'task_id'=>$this->input->post('task_id'),
    'description'=>$this->input->post('description'),
    'qty'=>$this->input->post('qty'),
    'unit'=>$this->input->post('unit'),
    'rate'=>$this->input->post('rate'),
    'amount'=>$this->input->post('amount'),);
    $this->db->where('boqtask_id',$boqtask_id);
    $update=$this->db->update('hm_config_boqtask',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }

  function delete_boqtask($boqtask_id)// delete boqtask
  {
    $this->db->where('boqtask_id',$boqtask_id);
    $delete1=$this->db->delete('hm_config_taskmat');

    $this->db->where('boq_taskid',$boqtask_id);
    $delete2=$this->db->delete('hm_config_taskserv');

    $this->db->where('boqtask_id',$boqtask_id);
    $delete=$this->db->delete('hm_config_boqtask');
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }



  function get_services_bytask($id)//get one taskser
  {
    $this->db->select("hm_config_taskserv.*,hm_config_services.service_name,
      hm_config_services.pay_type,
      hm_config_services.pay_rate");
    $this->db->join('hm_config_services','hm_config_taskserv.service_id = hm_config_services.service_id');
    $this->db->order_by('hm_config_taskserv.id','DESC');
    $this->db->where('boq_taskid',$id);
    $query=$this->db->get("hm_config_taskserv");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  public function add_taskser()//add new taskser
  {

    $array = array('boq_taskid' =>$this->input->post('boq_taskid'),
    'service_id'=>$this->input->post('service_id'),);
    $insert=$this->db->insert('hm_config_taskserv',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }


  function delete_taskser($id)// delete taskser
  {
    $this->db->where('id',$id);
    $delete=$this->db->delete('hm_config_taskserv');
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  function get_meterials_bytask($id)//get one task meterial
  {
    $this->db->select("hm_config_taskmat.*,hm_config_material.mat_code,
      hm_config_material.description,
      hm_config_material.mat_name");
    $this->db->join('hm_config_material','hm_config_taskmat.mat_id = hm_config_material.mat_id');
    $this->db->where('boqtask_id',$id);
    $query=$this->db->get("hm_config_taskmat");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  public function add_taskmat()//add new task meterial
  {

    $array = array('boqtask_id' =>$this->input->post('boqtask_id'),
    'mat_id'=>$this->input->post('mat_id'),
    'default_qnt'=>$this->input->post('default_qnt'));
    $insert=$this->db->insert('hm_config_taskmat',$array);
    if($this->db->affected_rows() > 0)
    {
      return true;
    }else{
      return false;
    }

  }


  function taskmat_delete($id)// delete task meterial
  {
    $this->db->where('id',$id);
    $delete=$this->db->delete('hm_config_taskmat');
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  //get no of units/lots for loop the unit boq..
  function get_no_of_lots($prj_id){

    $this->db->select('numof_units');
    $this->db->from('re_projectms');
    $this->db->where('prj_id',$prj_id);
    $query=$this->db->get();
    if(count($query->row())>0)
    {
      return $query->row();
    }else{
      return false;
    }

  }

  //insert unit boq..
  function insert_prjboqval($insertarr){
  	$this->db->insert('hm_prjfboq',$insertarr);
    if($this->db->affected_rows() > 0){
       return true;
    }else{
       return false;
    }
  }

  /* 2019-11-13 dev  develop by terance
     checking image exist.
  */
  public function chkimgexist($table,$id,$feild_name)
  {
    $this->db->select("*");
    $this->db->where($feild_name,$id);
    $query=$this->db->get($table);
    if(count($query->result())>0)
    {
      return true;
    }else{
      return false;
    }
  }
  //end check image exist


  //get designtype images by design id..
  function get_designtype_related_images($designtypeid){
     $this->db->select('*');
     $this->db->from('hm_config_designtype_img');
     $this->db->where('designtype_id',$designtypeid);
     $query=$this->db->get();
     if(count($query->result())>0)
     {
      return $query->result();
     }else{
      return false;
    }
  }

  // get floor related roomitems..
  function get_floor_related_roomitemslist($flrid){
    $this->db->select('hm_config_floorrooms.*,hm_config_roomtypes.roomtype_name');
    $this->db->join("hm_config_roomtypes","hm_config_roomtypes.roomtype_id=hm_config_floorrooms.roomtype_id");
    $this->db->where('floor_id',$flrid);

    $query = $this->db->get('hm_config_floorrooms');

       if(count($query->result())>0)
         {
           return $query->result();
         }else{
           return false;
         }
  }


  // update room related floorroom details.
  function update_room_rel_floorrooms($floorroomarr,$oldroomid){
     $this->db->where('room_id',$oldroomid);
      $update=$this->db->update('hm_config_floorrooms',$floorroomarr);
      if($this->db->affected_rows() > 0)
      {
        return true;
      }else{
        return false;
      }
  }

  /* boq excel file upload process..*/
  public function insert_boqcats($instboqcatarr){
      $this->db->insert('hm_config_boqcat',$instboqcatarr);
      if($this->db->affected_rows() > 0){
        return $this->db->insert_id();
      }else{
        return false;
      }


    }

    function insert_boqsubcat($boqsubcatarr){
      $this->db->insert('hm_config_boqsubcat',$boqsubcatarr);
      if($this->db->affected_rows() > 0){
      return $this->db->insert_id();
      }else{
        return false;
      }
    }

    function insert_configtask($conftaskarr){
        $this->db->insert('hm_config_task',$conftaskarr);
        if($this->db->affected_rows() > 0){
          return $this->db->insert_id();
        }else{
        return false;
        }

    }

    function insert_boqtask($boqtaskarr){
      $this->db->insert('hm_config_boqtask',$boqtaskarr);
      if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }

    }

    function check_catnameexist($catname,$designtype){
        $this->db->select("boqcat_id");
        $this->db->from("hm_config_boqcat");
        $this->db->where("cat_name",$catname);
        $this->db->where("design_id",$designtype);
        $query = $this->db->get();
        if(count($query->result())>0){
          return $query->row();
        }else{
          return false;
        }

    }

    function check_subcatnameexist($subcatname,$designtype){
        $this->db->select("boqsubcat_id");
        $this->db->from("hm_config_boqcat as cat");
        $this->db->join("hm_config_boqsubcat as subcat","cat.boqcat_id=subcat.boqcat_id");
        $this->db->where("subcat.subcat_name",$subcatname);
        $this->db->where("cat.design_id",$designtype);
        $query = $this->db->get();
        if(count($query->result())>0){
        return $query->row();
        }
        else{
          return false;
        }
    }

    function check_configtasknameexist($conftaskname){
        $this->db->select("task_id");
        $this->db->from("hm_config_task");
        $this->db->where("md5(task_name)",md5($conftaskname));
        $query = $this->db->get();
        if(count($query->result())>0){
          return $query->row();
        }else{
          return false;
        }
    }

    function insert_boqtask_getid($boqtaskarr){
      $this->db->insert('hm_config_boqtask',$boqtaskarr);
      if ($this->db->affected_rows() > 0){
        return $this->db->insert_id();
      }else{
        return false;
      }

    }

    //2019-11-22 update by nadee
    function get_floor_bydesign($des_id){
      $this->db->select('hmcf.*,hmcdt.design_id,
      hmcdt.prjtype_id,
      hmcdt.design_name,
      hmcdt.short_code,
      hmcdt.description,
      hmcdt.num_of_floors,
      hmcdt.tot_ext AS hmcdt_tot_ext');
      $this->db->from('hm_config_floors as hmcf');
      $this->db->join('hm_config_designtype as hmcdt','hmcf.design_id=hmcdt.design_id','left');
      $this->db->where('hmcf.design_id',$des_id);
      $this->db->order_by('hmcf.floor_id','DESC');

      $query = $this->db->get();
    if(count($query->result())>0)
      {
        return $query->result();
      }else{
        return false;
      }
    }

    function get_prjname($id)
    {
      $this->db->select('project_name,project_code');
      $this->db->where('prj_id',$id );
      $query = $this->db->get('re_projectms');
      if(count($query->result())>0){
        $result=$query->row();
        return $result->project_name;
      }else{
        return false;
      }

    }

    function get_relative_code()
    {
      $this->db->select('*');
      $query = $this->db->get('hm_config_shortcode');
      if(count($query->result())>0){
        return $query->result();
      }else{
        return false;
      }
    }

    //2020_01_06 update by Nadee
    function get_main_boqtask_bydesign($design_id)
    {
      $this->db->select("hm_config_boqcat.*");
      $this->db->where("design_id",$design_id);
      $query=$this->db->get("hm_config_boqcat");
      if(count($query->result())>0)
      {
        return $query->result();
      }else{
        return false;
      }
    }

    function get_sub_boqtask_bydesign($boq_id)
    {
      $this->db->select("hm_config_boqsubcat.*");
      $this->db->where("boqcat_id",$boq_id);
      $query=$this->db->get("hm_config_boqsubcat");
      if(count($query->result())>0)
      {
        return $query->result();
      }else{
        return false;
      }
    }

    /*2020-01-09 search functions*/
 	 /*dev nadee*/
  function search_material($search)
 	 {
     $this->db->select('*');
     $this->db->from('hm_config_material as hcm');
     $this->db->join('hm_config_messuretype as hcmt','hcm.mt_id=hcmt.mt_id','left');
     $this->db->like('mat_code',$search);
     $this->db->or_like('mat_name',$search);
     $query=$this->db->get();
     if(count($query->result())>0)
     {
       return $query->result();
     }else{
       return false;
     }
 	 }

   /*dev Nadee*/
   function search_messure($search)
   {
     $this->db->select("*");
     $this->db->order_by('mt_id','DESC');
     $this->db->like('mt_name',$search);
     $query=$this->db->get("hm_config_messuretype");
     if(count($query->result())>0)
     {
       return $query->result();
     }else{
       return false;
     }
   }

   /*dev nadee*/
   function search_services($search)
   {
     $this->db->select("*");
     $this->db->order_by('service_id','DESC');
     $this->db->like('service_name',$search);
     $this->db->or_like('pay_type',$search);
     $this->db->or_like('pay_rate',$search);
     $query=$this->db->get("hm_config_services");
     if(count($query->result())>0)
     {
       return $query->result();
     }else{
       return false;
     }
   }

   /*dev nadee*/
   function search_design($search)
   {
     $this->db->select("hm_config_designtype.*,hm_config_prjtypes.prjtype_name,hm_config_prjtypes.short_code AS prj_short_code");
     $this->db->join('hm_config_prjtypes','hm_config_prjtypes.prjtype_id=hm_config_designtype.prjtype_id');
     $this->db->like('hm_config_designtype.design_name',urldecode($search));
     $this->db->or_like('hm_config_designtype.short_code',urldecode($search));
     $this->db->or_like('hm_config_designtype.description',urldecode($search));
     $this->db->order_by('hm_config_designtype.design_id','DESC');

     $query=$this->db->get("hm_config_designtype");
     if(count($query->result())>0)
     {
       return $query->result();
     }else{
       return false;
     }
   }

   /*dev nadee*/
   function search_floors($search)
   {
     $this->db->select('hmcf.*,hmcdt.design_id,
     hmcdt.prjtype_id,
     hmcdt.design_name,
     hmcdt.short_code,
     hmcdt.description,
     hmcdt.num_of_floors,
     hmcdt.tot_ext AS hmcdt_tot_ext');
     $this->db->from('hm_config_floors as hmcf');
     $this->db->join('hm_config_designtype as hmcdt','hmcf.design_id=hmcdt.design_id','left');
     $this->db->like('design_name',urldecode($search));
     $this->db->or_like('floor_name',urldecode($search));
     $this->db->order_by('hmcf.floor_id','DESC');

     $query = $this->db->get();
   if(count($query->result())>0)
     {
       return $query->result();
     }else{
       return false;
     }
   }

   /*dev nadee*/
   function search_rooms($search)
   {
     $this->db->select("*");
     $this->db->like('roomtype_name',urldecode($search));
     $this->db->order_by('roomtype_id','DESC');
     $query=$this->db->get("hm_config_roomtypes");
     if(count($query->result())>0)
     {
       return $query->result();
     }else{
       return false;
     }
   }

   /*dev nadee*/
   function search_task($search)
   {
     $this->db->select("*");
     $this->db->like('task_name',urldecode($search));
     $this->db->or_like('relative_code',urldecode($search));
     $this->db->or_like('task_code',urldecode($search));
     $this->db->order_by('task_code');
     $query=$this->db->get("hm_config_task");
     if(count($query->result())>0)
     {
       return $query->result();
     }else{
       return false;
     }
   }

   /*dev nadee*/
   function search_boq($search)//get all boq
   {
     $this->db->select("hm_config_boqcat.*,hm_config_designtype.design_name,hm_config_designtype.short_code");
     $this->db->join('hm_config_designtype','hm_config_boqcat.design_id = hm_config_designtype.design_id');

     $this->db->like('hm_config_boqcat.cat_name',urldecode($search));
     $this->db->or_like('hm_config_designtype.design_name',urldecode($search));
     $this->db->order_by('hm_config_boqcat.boqcat_id','DESC');
     $query=$this->db->get("hm_config_boqcat");
     if(count($query->result())>0)
     {
       return $query->result();
     }else{
       return false;
     }
   }

   /*dev nadee*/
   function search_subboq($search)//get all subboq
   {
     $this->db->select("hm_config_boqsubcat.*,hm_config_boqcat.cat_name,hm_config_boqcat.design_id,
     hm_config_designtype.design_name,
     hm_config_designtype.short_code");
     $this->db->join('hm_config_boqcat','hm_config_boqsubcat.boqcat_id = hm_config_boqcat.boqcat_id');
     $this->db->join('hm_config_designtype','hm_config_boqcat.design_id = hm_config_designtype.design_id');
     //$this->db->order_by('hm_config_boqcat.design_id','DESC');
     $this->db->like('hm_config_designtype.design_name',urldecode($search));
     $this->db->or_like('hm_config_boqcat.cat_name',urldecode($search));
     $this->db->or_like('hm_config_boqsubcat.subcat_name',urldecode($search));
     $this->db->order_by('hm_config_boqsubcat.boqsubcat_id','DESC');
     $query=$this->db->get("hm_config_boqsubcat");
     if(count($query->result())>0)
     {
       return $query->result();
     }else{
       return false;
     }
   }
   
   // new functions added by udani
   //2020-01-18
function get_items(){

	 $this->db->select('hm_config_items.*,hm_config_brands.brand_name');
	 $this->db->join('hm_config_brands','hm_config_brands.brand_id=hm_config_items.brand_id','left');
	   $this->db->order_by('hm_config_items.item_id','DESC');
	 $query = $this->db->get('hm_config_items');
	if($query->num_rows() > 0)
	  {
	   return $query->result();
	 }else{
	   return false;
	 }
}

function get_item_data($item_id)
{
	 $this->db->select('hm_config_items.*,hm_config_brands.brand_name');
 	$this->db->join('hm_config_brands','hm_config_brands.brand_id=hm_config_items.brand_id','left');
	$this->db->where('hm_config_items.item_id',$item_id);
  	$query = $this->db->get('hm_config_items');
	if($query->num_rows() > 0)
	{
		return $query->row();
	}else{
		return false;
	}
}
function get_brands(){

 $this->db->select('hm_config_brands.*');
 $this->db->order_by('hm_config_brands.brand_id','DESC');
 $query = $this->db->get('hm_config_brands');
	if($query->num_rows() > 0)
	  {
	   return $query->result();
	 }else{
	   return false;
	 }
}

function get_brand_id($brandame)
{
	$brandame=strtoupper(trim($brandame));
		$this->db->select('*');
	 $this->db->where('brand_name',$brandame);
	  $query = $this->db->get('hm_config_brands');
	 if($query->num_rows >0)
	  {
		  $data=$query->row();
		  return  $data->brand_id;
	  }
	  else
	  {
		  $code= $this->getmaincode('brand_code','BRD','hm_config_brands');
			
		   $array = array('brand_name'=>$brandame,
		   'brand_code'=>$code,
		
			);
		$this->db->trans_start();
		$insert=$this->db->insert('hm_config_brands',$array);
		$brand_id = $this->db->insert_id();
		$this->db->trans_complete();
		return $brand_id;
	  }
	
	
}

function insert_item_data()
{
	$brand_name=$this->input->post('brand_name');
	$item_name=$this->input->post('item_name');
	$unit_rate=$this->input->post('unit_rate');
	$brand_id=$this->get_brand_id($brand_name);
	
	$code= $this->getmaincode('item_code','ITM','hm_config_items');
	
	$array = array('item_name'=>$item_name,
		   'item_code'=>$code,
		   'brand_id'=>$brand_id,
			'unit_rate'=>$unit_rate,
			'update_date'=>date('Y-m-d'),
			'update_by'=>$this->session->userdata('userid'),
		
			);
		$this->db->trans_start();
		$insert=$this->db->insert('hm_config_items',$array);
		$item_id = $this->db->insert_id();
		$this->db->trans_complete();
		return $item_id;
	 
	
}

function update_item_data()
{
	$brand_name=$this->input->post('brand_name');
	$item_id=$this->input->post('item_id');
	$item_name=$this->input->post('item_name');
	$unit_rate=$this->input->post('unit_rate');
	$brand_id=$this->get_brand_id($brand_name);
	
//	$code= $this->getmaincode('item_code','ITM','hm_config_items');
	
	$array = array('item_name'=>$item_name,
		   'brand_id'=>$brand_id,
			'unit_rate'=>$unit_rate,
			'update_date'=>date('Y-m-d'),
			'update_by'=>$this->session->userdata('userid'),
		
			);
		$this->db->trans_start();
		$this->db->where('item_id',$item_id);
		$insert=$this->db->update('hm_config_items',$array);
		$this->db->trans_complete();
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
