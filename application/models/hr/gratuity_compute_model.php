<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class gratuity_compute_model extends CI_Model{

function get_gratuityleger(){
  $this->db->select('*');
  $this->db->where('type','Gratuvity Compute');//get gratuity ledgers
  $query = $this->db->get('hr_ledger');
  if($query->result()>0){
    return $query->row();
  }else{
    return false;
  }

}

function update_ledger()
{
  $ledger=$this->get_gratuityleger();//check gratuity ledgers are exist
  $selectCr1=$this->input->post('selectCr1');
  $selectDr1=$this->input->post('selectDr1');
  /*if ledgers exist ledgers will update else insert*/
  if($ledger){

    $data = array('cr_acc' =>$this->session->userdata('accshortcode').$selectCr1 ,
    'dr_acc'=>$this->session->userdata('accshortcode').$selectDr1,
    'updated_by'=>$this->session->userdata('username'),
    'updated_at'=>date('Y-m-d'));
    $this->db->where('type','Gratuvity Compute');
    $update=$this->db->update('hr_ledger',$data);
    if($update){
      return true;
    }else{
      return false;
    }
  }else{

    $data = array('type'=>'Gratuvity Compute',
    'cr_acc' =>$this->session->userdata('accshortcode').$selectCr1 ,
    'dr_acc'=>$this->session->userdata('accshortcode').$selectDr1,
    'updated_by'=>$this->session->userdata('username'),
    'updated_at'=>date('Y-m-d'));
    $insert=$this->db->insert('hr_ledger',$data);
    if($insert){
      return true;
    }else{
      return false;
    }
  }

}

function get_alagible_employee($date)//date should be today or runing date.
{
  $grain_day=date('Y-m-d', strtotime('-5 years',strtotime($date) ));//get could minimun date
  $this->db->select('hr_empmastr.*,hr_emp_salary.basic_salary,hr_emp_salary.gratuity');
  $this->db->join('hr_emp_salary','hr_empmastr.id = hr_emp_salary.emp_record_id');
  $this->db->where('DAY(hr_empmastr.joining_date)',date('d',strtotime($date)));
  $this->db->where('MONTH(hr_empmastr.joining_date)',date('m',strtotime($date)));
  $this->db->where('hr_empmastr.joining_date <=',$grain_day);
  $this->db->where('hr_emp_salary.status','Y');
  $this->db->where('hr_empmastr.status !=','D');
  $query = $this->db->get('hr_empmastr');
  if($query->num_rows()>0)
  {
    return $query->result();
  }else{
    return false;
  }
}

function get_alagible_employee_byemp($date,$emp)//date should be today or runing date.
{

  $grain_day=date('Y-m-d', strtotime('-5 years',strtotime($date) ));//get could minimun date
  $this->db->select('hr_empmastr.*,hr_emp_salary.basic_salary,hr_emp_salary.gratuity');
  $this->db->join('hr_emp_salary','hr_empmastr.id = hr_emp_salary.emp_record_id');
  $this->db->where('hr_empmastr.joining_date <=',$grain_day);
  $this->db->where('hr_emp_salary.status','Y');
  $this->db->where('hr_empmastr.status !=','D');
  $this->db->where('hr_empmastr.id',$emp);
  $query = $this->db->get('hr_empmastr');
  if($query->num_rows()>0)
  {
    return $query->row();
  }else{
    return false;
  }
}
function check_gratuity_for_year($year,$emp)
{
  $this->db->select('*');
  $this->db->where('emp_record_id',$emp);
  $this->db->where('year',$year);
  $query = $this->db->get('hr_emp_gratuity');
  if($query->num_rows()>0)
  {
    return false;
  }else{
    return true;
  }
}
function get_last_gratuity_data($emp)
{
  $this->db->select('*');
  $this->db->where('emp_record_id',$emp);
  $this->db->order_by('id','desc');
  $this->db->limit('1');
  $query = $this->db->get('hr_emp_gratuity');
  if($query->num_rows()>0)
  {
    return $query->row();
  }else{
    return false;
  }

}

function compute_gratuity($date)
{

	$emp=$this->get_alagible_employee($date);//get join day = today employees
	if($emp)
	{
		foreach ($emp as $key => $employee) {

			$this_year=date('Y');

			//check whether run for this year
			$check_year=$this->check_gratuity_for_year($this_year,$employee->id);
			if($check_year){
				$join_year=date('Y',strtotime($employee->joining_date));
				$year_diff=$this_year-$join_year;//get amount of service years
				$salary=$employee->basic_salary;//get employee basic salary
				$gratuity_rate=$employee->gratuity;//get employee gratuity
				$gratuity_val=$salary*($gratuity_rate/100)*$year_diff;
				//echo $employee->emp_no."  ".$salary." X ".($gratuity_rate/100)." * ".$year_diff." = ". $gratuity_val."<br>";

				$gratuity_diff=$gratuity_val;//if this is first time gratuity compute tranfer amount shoud be total value

				$last_gatuity=$this->get_last_gratuity_data($employee->id); //get data if employee has old record
				if($last_gatuity)
				{
					$gratuity_diff=$gratuity_val-$last_gatuity->total_gratuity;//if this is not first time gratuity compute tranfer balance value
				}

				$add=$this->add_gratuity_data($employee->id,$this_year,$gratuity_val,$gratuity_diff,$employee->emp_no);
				if($add)
				{
					//return true;
					echo $employee->joining_date."</br>";
				}
			}

		}
	}
}

function add_gratuity_data($emp_id,$this_year,$gratuity_val,$gratuity_diff,$emp_no)
{
  	$gratuityleger=$this->gratuity_compute_model->get_gratuityleger();//from hr_ledger table
    $data = array('emp_record_id'=>$emp_id,
                  'year'=>$this_year,
                  'total_gratuity'=>$gratuity_val,
                  'tranfer_amount'=>$gratuity_diff,
                  'cr_account'=>$gratuityleger->cr_acc,
                  'dr_account'=>$gratuityleger->dr_acc,
                  'calculate_date' =>date('Y-m-d H:i:s'), );
    $insert=$this->db->insert('hr_emp_gratuity',$data);
    $insert_id=$this->db->insert_id();
    if($insert && $gratuity_diff!=0)
    {
      if($gratuity_diff>0){
        //gratuity provins
        $drlist[0]['ledgerid']=$gratuityleger->dr_acc;
        $drlist[0]['amount']=$drtot=$gratuity_diff;

  			//gratuity Control
        $crlist[0]['ledgerid']=$gratuityleger->cr_acc;
        $crlist[0]['amount']=$crtot=$gratuity_diff;
      }else{
        $gratuity_diff=((-1)*$gratuity_diff);
        //gratuity Control
        $drlist[0]['ledgerid']=$gratuityleger->cr_acc;;
        $drlist[0]['amount']=$drtot=$gratuity_diff;

  			//gratuity provins
        $crlist[0]['ledgerid']=$gratuityleger->dr_acc;
        $crlist[0]['amount']=$crtot=$gratuity_diff;
      }



      $narration="Gratuity value tranfer for the employee ".$emp_no;
      $int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date($this_year.'-m-d'),$narration,'','');

			if($int_entry){
        $data_val = array('entry_id' => $int_entry, );
        $this->db->where('id',$insert_id);
        $this->db->update('hr_emp_gratuity',$data_val);
				return true;
			}else{
				return false;
			}
    }

}

function get_report_emp_view()
{
  $this->db->select('hr_empmastr.surname,hr_empmastr.initial,hr_emp_gratuity.emp_record_id,
          Sum(hr_emp_gratuity.tranfer_amount) as total_gratuity,
          hr_empmastr.joining_date,
          hr_emp_gratuity_payment.paid_gratuity,
          hr_emp_gratuity_payment.voucher_id,
          hr_emp_salary.basic_salary,
          hr_emp_salary.gratuity,
          hr_empmastr.resignation_date');
  $this->db->join('hr_emp_gratuity_payment','hr_emp_gratuity.emp_record_id = hr_emp_gratuity_payment.emp_record_id','Left');
  $this->db->join('hr_emp_salary','hr_emp_gratuity.emp_record_id = hr_emp_salary.emp_record_id','Left');
  $this->db->join('hr_empmastr','hr_emp_gratuity.emp_record_id = hr_empmastr.id','Left');
  $this->db->group_by('hr_emp_gratuity.emp_record_id');
  $query=$this->db->get('hr_emp_gratuity');
  if($query->result()>0)
  {
    return $query->result();
  }else{
    return false;
  }

}

function update_employee_resignation_fordate($date){

  $this->db->select('*');
  $this->db->where('resign_date',$date);//get today resign employees
  $this->db->join('hr_empmastr','hr_empmastr.id=hr_emp_resignation.emp_record_id');
  $query=$this->db->get('hr_emp_resignation');
  if($query->result()>0){
    $details=$query->result();
    foreach ($details as $key => $value) {

      $data['resignation_date'] = $value->resign_date;
      $data['status'] = "D";
    $this->db->trans_start();
    $this->db->where('id', $value->emp_record_id);
    $this->db->update('hr_empmastr', $data);
    $this->db->trans_complete();

      $user_data['EXPDATE'] = $value->resign_date;//restric logings
      $user_data['active_flag'] = 0;
      $this->db->trans_start();
      $this->db->where('USRID', $value->emp_record_id);
      $this->db->update('cm_userdata', $user_data);
      $this->db->trans_complete();

      $payee=$value->initial." ".$value->surname;

      $gratuity_pay=$this->create_payment_voucher($value->emp_record_id,$value->resign_date,$value->gratuity_cal,$value->gratuity_paymet,$payee);
    }
  }
  if($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
    return false;
  }else{
    $this->db->trans_commit();

    return true;
  }


}

function create_payment_voucher($emp_id,$resign_date,$gratuity_cal,$gratuity_pay,$surname)
{
  if($gratuity_pay>0){
    $des="Gratuity payment for ".$surname;
   $idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date('Y-m-d'));
					$voucherid=$idlist[0];
    $gratuityleger=$this->gratuity_compute_model->get_gratuityleger();
		$cr_account=$gratuityleger->cr_acc;
    $data=array(
      'voucherid'=>$voucherid,
	  	'vouchercode'=>$idlist[1],
      'branch_code' => $this->session->userdata('branchid'),
      'ledger_id' =>$cr_account,
      'payeename' => $surname,
      'vouchertype' => '10',
      'paymentdes' => $des,
      'amount' => $gratuity_pay,
      'applydate' =>date('Y-m-d'),
      'status' => 'CONFIRMED',

    );
    if(!$this->db->insert('ac_payvoucherdata', $data))
    {
      $this->db->trans_rollback();
      $this->logger->write_message("error", "Error confirming Project");
      return false;
    }else {
      $gratuit['emp_record_id']=$emp_id;
      $gratuit['calc_gratuity']=$gratuity_cal;
      $gratuit['paid_gratuity']=$gratuity_pay;
      $gratuit['paid_date']=date('Y-m-d');
      $gratuit['voucher_id']=$voucherid;
      $gratuit['updated_date']=date('Y-m-d');

      $this->db->trans_start();
      $this->db->insert('hr_emp_gratuity_payment', $gratuit);
      $this->db->trans_complete();

    }
}
}



}
