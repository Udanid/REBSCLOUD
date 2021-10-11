<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class dicalculate_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function reservation_list($date) { //get all stock
    $this->db->select('*');
    $this->db->where('res_status','PROCESSING');
    $this->db->where('dp_fulcmpdate <',$date);
    $this->db->where('dp_cmpldate >','1970-01-01');
    $query = $this->db->get('re_resevation');
    return $query->result();
  }

   


  /*Ticket No:2889 Added by Madushan 2021.06.14*/

  function reservation_list_for_shedule($date) { //get all stock
    $this->db->select('*');
    $this->db->where('res_status','PROCESSING');
    $this->db->where('dp_cmpldate >','1970-01-01');
    $query = $this->db->get('re_resevation');
    return $query->result();
  }
 
  function generate_advance_schedule_today_delaint($date)
  {

    $loanlist=$this->reservation_list_for_shedule($date);
    if($loanlist){
    foreach($loanlist as $loanraw)
    {
      if($this->check_shedule($loanraw->res_code)){
    $tot_due_amount = $tot_paid_amount = $balance_amount = $di = 0.0;
    //Get Total Due Amount
    $this->db->select('SUM(amount) as amount,MIN(due_date) as due_date');
    $this->db->where('res_code',$loanraw->res_code);
    $this->db->where('due_date <=',$date);
    $query1 = $this->db->get('re_salesadvanceshedule');
    if($query1->num_rows>0)
      $tot_due_amount = $query1->row()->amount;
    
    //Get Total Paid Amount
    $this->db->select('SUM(paid_amount) as paid_amount,MAX(paid_date) as paid_date');
    $this->db->where('res_code',$loanraw->res_code);
    $this->db->where('paid_date <=',$date);
    $query2 = $this->db->get('re_salesadvanceshedule');
    if($query2->num_rows>0)
      $tot_paid_amount = $query2->row()->paid_amount;

    //Calculate Balance amount
    $balance_amount = $tot_due_amount -  $tot_paid_amount;
    //Cal Delay Interest
    $date1=date_create($date);
    if($query2->row()->paid_date)
      $date2=date_create($query2->row()->paid_date);
    else
       $date2=date_create($query1->row()->due_date);
    
    $diff=date_diff($date1,$date2);
    $dates=$diff->format("%a ");
    $delay_date=intval($dates);

    $dirate=get_rate('Advance DI Rate');
    if($balance_amount>0)
      $di = ($balance_amount*$dirate*$delay_date)/(100*30);

     if( $di>0){
        $di=round($di,2);
        $data=array(
          'res_code'=>$loanraw->res_code,
          'di_amount' => $di,
          'date'=>$date,
          );
        $insert = $this->db->insert('re_advancedi', $data);
      }

      //echo $di;

    }}}

  }

  function check_shedule($res_code)
  {
    $this->db->select('*');
    $this->db->where('res_code',$res_code);
    $query = $this->db->get('re_salesadvanceshedule');
    if($query->num_rows>0)
      return true;
    else
      return false;
  }
  /*End Of Ticket No:2889*/

/*Ticket No:2889 Updated By Madushan 2021.06.14*/
function  generate_advance_today_delaint($date)
  {
    
    //print_r($loanlist);
   
        //print_r($loanraw);
  $loanlist=$this->reservation_list($date);
  if($loanlist){
   foreach($loanlist as $loanraw)
    {
      if(!$this->check_shedule($loanraw->res_code)){
        $paid_amount_precentage=($loanraw->down_payment/$loanraw->discounted_price)*100;
        //N14 days = dp_cmpldate;40%3%
        //N60 days = dp_fulcmpdate;60%5%

              $paydate=$date;
              $dirate=get_rate('Advance DI Rate');
              if($loanraw->dp_cmpldate>$loanraw->last_dpdate && $paid_amount_precentage<=40)
              {
                  $dirate=3;
                  $date1=date_create($loanraw->dp_cmpldate);
              }elseif($loanraw->dp_fulcmpdate>$loanraw->last_dpdate){

                  $date1=date_create($loanraw->dp_fulcmpdate);
              }else{
                  $date1=date_create($loanraw->last_dpdate);
              }
			  if($date1)
			  $date1=$date1;
			  else
			  $date1=date_create($loanraw->res_date);
		//echo  $loanraw->res_date.'ssss';
              $date2=date_create($paydate);
              $diff=date_diff($date1,$date2);
              $dates=$diff->format("%a ");
              $delay_date=intval($dates);
              $dalay_int=0;

              $balanceamount=$loanraw->discounted_price-$loanraw->down_payment;
              if($balanceamount>0 )
              {
                  //echo $delay_date.'-'.$loanraw->res_code.'-'.$dirate.'<br>';
                  $dalay_int=($balanceamount*$dirate*$delay_date)/(100*30);
              }

              if( $dalay_int>0){
				  $dalay_int=round($dalay_int,2);
                  $data=array(
                      'res_code'=>$loanraw->res_code,
                      'di_amount' => $dalay_int,
                      'date'=>$date,
                  );
                  $insert = $this->db->insert('re_advancedi', $data);
              }


        //return $insert;
            }
            }
          }
  }

  
  function is_generate_advance_di($date)
  {
    $this->db->select('*');
    $this->db->where('date',$date);
    $query = $this->db->get('re_advancedi');
    if ($query->num_rows() > 0){
      return false;
    }
    else
    return true;
  }
  function get_advance_date_di($loan,$date)
  {
    $this->db->select('*');
    $this->db->where('date',$date);
    $this->db->where('res_code',$loan);
    $query = $this->db->get('re_advancedi');
    if ($query->num_rows() > 0){
      $raw=$query->row();
      $di=$raw->di_amount;
      return $di;
    }
    else
    return 0;
  }
  function update_today_di($loan,$date,$dalay_int)
  {
    $data=array(

      'di_amount' => $dalay_int,

    );
    $this->db->where('date',$date);
    $this->db->where('res_code',$loan);
    $insert = $this->db->update('re_advancedi', $data);


  }


}
