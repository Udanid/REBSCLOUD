<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class cashadvance_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_allbook_types() { //get all stock
		$this->db->select('*');
		$this->db->order_by('type_id');
		$query = $this->db->get('ac_cashbooktypes');
		return $query->result();
    }
		function get_all_books($pay_type='') { //get all stock
		$this->db->select('ac_cashbook.*,ac_cashbooktypes.type_name,ac_ledgers.name,cm_branchms.branch_name ');
		$this->db->join('ac_cashbooktypes','ac_cashbooktypes.type_id=ac_cashbook.type_id');
		$this->db->join('ac_ledgers','ac_cashbook.ledger_id=ac_ledgers.id');
		$this->db->join('cm_branchms','cm_branchms.branch_code=ac_cashbook.branch_code');
		if($pay_type!='')
		$this->db->where('ac_cashbook.pay_type',$pay_type);
		$this->db->order_by('ac_cashbook.type_id,ac_cashbook.branch_code');
		$query = $this->db->get('ac_cashbook');
		return $query->result();
    }
	function get_all_ledgers() { //get all stock
		$this->db->select('ac_ledgers.*');
		$this->db->order_by('ac_ledgers.name');
		$query = $this->db->get('ac_ledgers');
		return $query->result();
    }


	function add_type()
	{
		//$tot=$bprice*$quontity;
		$data=array(

		'type_name' => $this->input->post('type_name'),


		);
		$insert = $this->db->insert('ac_cashbooktypes', $data);
		$row = $this->db->query('SELECT MAX(type_id) AS `maxid` FROM `ac_cashbooktypes`')->row();
		return $row->maxid;

	}
	 function check_booktype_used($id)
    {
     		  $this->db->select('*');
			 $this->db->where('type_id',$id);
			$query = $this->db->get('ac_cashbook');
        if ($query->num_rows() > 0) {

            return true;

        } else{
            return false;
        }
    }
	function delete_type($id)
	{
		//$tot=$bprice*$quontity;
		if($id)
		{
		$this->db->where('type_id', $id);
		$insert = $this->db->delete('ac_cashbooktypes');
		return $insert;
		}

	}

	function add_book()
	{
		  $this->db->select('*');
			 $this->db->where('type_id',$this->input->post('type_id'));
			  $this->db->where('branch_code',$this->input->post('branch_code'));
			$query = $this->db->get('ac_cashbook');
        if ($query->num_rows() > 0) {
           $dataset=$query->row();
           $data=array(
			'ledger_id' => $this->input->post('ledger_id'),
			'advance_ledger' => $this->input->post('ledger_id'),
			'cash_float' => $this->input->post('cash_float'),
				'pay_type' => $this->input->post('pay_type'),
			'last_update' => date('Y-m-d'),
			'update_by' => $this->session->userdata('userid'),


				);
				$this->db->where('id',  $dataset->id);
				$insert = $this->db->update('ac_cashbook', $data);

        } else{
           $data=array(

		'type_id' => $this->input->post('type_id'),
		'branch_code' => $this->input->post('branch_code'),
		'ledger_id' => $this->input->post('ledger_id'),
		'advance_ledger' =>$this->input->post('ledger_id'),
		'pay_type' => $this->input->post('pay_type'),
		'last_update' => date('Y-m-d'),
		'cash_float' => $this->input->post('cash_float'),
		'update_by' => $this->session->userdata('userid'),


		);
		$insert = $this->db->insert('ac_cashbook', $data);
        }
		//$tot=$bprice*$quontity;

		$row = $this->db->query('SELECT MAX(type_id) AS `maxid` FROM `ac_cashbook`')->row();
		return $row->maxid;

	}
	function get_cashbook_balance($book_id)
	{
		  $this->db->select('*');
			 $this->db->where('id',$book_id);
			 	$query = $this->db->get('ac_cashbook');
        if ($query->num_rows() > 0) {
           $dataset=$query->row();
		   $N5000=5000*$dataset->N5000;
		   $N2000=2000*$dataset->N2000;
		   $N1000=1000*$dataset->N1000;
		   $N500=500*$dataset->N500;
		   $N100=100*$dataset->N100;
		   $N50=50*$dataset->N50;
		   $N20=20*$dataset->N20;
		   $N10=10*$dataset->N10;
			$C10=10*$dataset->C10;
			$C5=5*$dataset->C5;
			$C2=2*$dataset->C2;
			$C1=1*$dataset->C1;
			$CC50=0.50*$dataset->CC50;
			$CC25=0.25*$dataset->CC25;
			$bankbal=$dataset->bankbal;

			$phycicalbal=$N5000+$N2000+$N1000+$N500+$N100+$N50+$N20+$N10+$C10+$C5+$C2+$C1+$CC50+$CC25+$bankbal;
			return $phycicalbal;

        }
		else return 0;
	}
	function get_cashbook_outstanding($book_id)
	{
		  	 $this->db->select('SUM(amount) as totapply, SUM(settled_amount) as totsettle');
			 $this->db->where('book_id',$book_id);
			  $this->db->where('status','PAID');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {
           $dataset=$query->row();
		  	$outbal=$dataset->totapply-$dataset->totsettle;
			$outbal=round($outbal,2);
			return $outbal;

        }
		else return 0;
	}
	function get_cashbook_data($book_id)
	{

			 $this->db->select('ac_cashbook.*,ac_cashbooktypes.type_name,ac_ledgers.name,cm_branchms.branch_name ');
		$this->db->join('ac_cashbooktypes','ac_cashbooktypes.type_id=ac_cashbook.type_id');
		$this->db->join('ac_ledgers','ac_cashbook.ledger_id=ac_ledgers.id');
		$this->db->join('cm_branchms','cm_branchms.branch_code=ac_cashbook.branch_code');
			 $this->db->where('ac_cashbook.id',$book_id);
			 $query = $this->db->get('ac_cashbook');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function get_cashbook_advancedata($book_id)
	{
		  	 $this->db->select('ac_cashadvance.*,hr_empmastr.emp_no,hr_empmastr.initial,hr_empmastr.surname');
			 $this->db->where('ac_cashadvance.book_id',$book_id);
			  $this->db->where('ac_cashadvance.status','PAID');
			  $this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function get_all_cash_advancedata($pagination_count,$page,$pay_type='')
	{
		  	$this->db->select('ac_cashadvance.*,hr_empmastr.emp_no,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			$this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id');
			if($pay_type!='')
			$this->db->where('ac_cashbook.pay_type',$pay_type);
			$this->db->order_by('apply_date','desc');
      $this->db->order_by('ac_cashadvance.adv_id','desc');
			$this->db->group_by('adv_id');
			$this->db->limit($pagination_count,$page);
			$query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function get_all_checked_cashadvancedata($brachid)
	{
		  	$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.emp_no,hr_empmastr.surname,hr_bankdtls.account_no,re_projectms.project_name');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			$this->db->join('hr_bankdtls','hr_bankdtls.emp_record_id=hr_empmastr.id','left');
			$this->db->join('re_projectms','re_projectms.prj_id=ac_cashadvance.project_id','left');

			$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id');
			$this->db->where('ac_cashbook.status','CHECKED');
			$this->db->order_by('apply_date','desc');
			$this->db->group_by('officer_id');
			$this->db->limit($pagination_count,$page);
			$query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function get_all_cash_advancedata_search($pagination_count,$page)
	{


		$advance_no=$this->input->post('advance_no');
        $amountsearch=$this->input->post('amountsearch');
        $pay_status=$this->input->post('pay_status');
        $name = $this->input->post('name');
		 $pay_type = $this->input->post('pay_type');
		  $cashbookid_search = $this->input->post('cashbookid_search');


		  	$this->db->select('ac_cashadvance.*,hr_empmastr.emp_no,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			$this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id');
			if($cashbookid_search != 'all') {
				$this->db->where('ac_cashadvance.book_id',$cashbookid_search);
			}
			if($advance_no!='')
			$this->db->like('ac_cashadvance.adv_code',$advance_no,'both');
			if($amountsearch!='')
			$this->db->like('ac_cashadvance.amount',$amountsearch,'both');
			if($name!='')
			$this->db->where('ac_cashadvance.officer_id',$name);
			if($pay_status!='')
			$this->db->like('hr_empmastr.status',$pay_status,'both');
			if($pay_type!='')
			$this->db->where('ac_cashbook.pay_type',$pay_type);
			$this->db->order_by('apply_date','desc');
			$this->db->group_by('adv_id');
			$this->db->limit($pagination_count,$page);
			$query = $this->db->get('ac_cashadvance');
		//	echo $this->db->last_query();
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}

	function count_cash_advancedata_all(){
		$this->db->select('ac_cashadvance.*,hr_empmastr.emp_no,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			$this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id');
			if($this->session->userdata('cashbookid') != '') {
				$this->db->where('ac_cashadvance.book_id',$this->session->userdata('cashbookid'));
			}
			$this->db->order_by('apply_date','desc');
			$this->db->group_by('adv_id');
			$query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->num_rows();

        }
		else return false;
	}

	function count_cash_advancedata_all_search($search_string,$search_field){
		$this->db->select('ac_cashadvance.*,hr_empmastr.emp_no,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			$this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id');
			if($this->session->userdata('cashbookid') != '') {
				$this->db->where('ac_cashadvance.book_id',$this->session->userdata('cashbookid'));
			}
			$this->db->like($search_field,$search_string,'both');
			$this->db->order_by('apply_date','desc');
			$this->db->group_by('adv_id');
			$query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->num_rows();

        }
		else return false;
	}

	function update_denomination()
	{
		 $data=array(
			'N5000' => $this->input->post('N5000'),
			'N2000' => $this->input->post('N2000'),
			'N1000' => $this->input->post('N1000'),
			'N500' => $this->input->post('N500'),
			'N100' => $this->input->post('N100'),
			'N50' => $this->input->post('N50'),
			'N20' => $this->input->post('N20'),
			'N10' => $this->input->post('N10'),
			'C10' => $this->input->post('C10'),
			'C5' => $this->input->post('C5'),
			'C2' => $this->input->post('C2'),
			'C1' => $this->input->post('C1'),
			'CC50' => $this->input->post('CC50'),
			'CC25' => $this->input->post('CC25'),
			'bankbal' => $this->input->post('bankbal'),

			'last_update' => date('Y-m-d'),
			'update_by' => $this->session->userdata('userid'),


				);
				$this->db->where('id',  $this->input->post('bookid'));
				$insert = $this->db->update('ac_cashbook', $data);
	}
    function get_employee_details(){
		$this->db->select('*');
		$this->db->where('status', 'A');
		$query = $this->db->get('hr_empmastr');

		 if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
    }

  function get_employee_data_by_id($officerid){
		$this->db->select('*');
		//$this->db->where('status', 'A');
		$this->db->where('id', $officerid);
		$query = $this->db->get('hr_empmastr');

		 if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
    }
	function get_designation_officer_list($designation)
	{
		$this->db->select('hr_empmastr.id,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.display_name ');

				$this->db->join('hr_dsgntion','hr_dsgntion.id=hr_empmastr.designation');
				$this->db->where('hr_dsgntion.designation',$designation);

				$query = $this->db->get('hr_empmastr');
				 if ($query->num_rows >0) {
           			 $data=$query->row();

					 return $data->id;
       			 }
					else
				return 0;

	}
	function add_advance()
	{
		$officerid=$this->input->post('officer_id');
		$empcode=$this->get_employee_data_by_id($officerid);
		$prifix=$empcode->epf_no.'-';
		$adv_code=$this->get_advance_code('adv_code',$prifix,'ac_cashadvance',$officerid);
		$serial_code=$this->get_serial_code('serial_number',$prifix,'ac_cashadvance',$this->input->post('book_id'));
		if($this->input->post('apprved_officerid')=='22')
		$confirm_officerid=$this->get_designation_officer_list('Audit Executive');

		if($this->input->post('apprved_officerid')=='12')


		$confirm_officerid=$this->get_designation_officer_list('Intern');

		 $data=array(
			'adv_code' =>$adv_code,
			'adv_type' => $this->input->post('adv_type'),
			'book_id' => $this->input->post('book_id'),
			'amount' => $this->input->post('amount'),
			'apply_date' => $this->input->post('apply_date'),
			'promiss_date' => $this->input->post('promiss_date'),
			'project_id' => $this->input->post('project_id'),
			'description' => $this->input->post('description'),
			'expence_type' => $this->input->post('expence_type'),
			'check_officerid' => $this->input->post('check_officerid'),
			'apprved_officerid' => $this->input->post('apprved_officerid'),
			'confirm_officerid' => $confirm_officerid,
			'status' => 'PENDING',
			'officer_id' => $this->input->post('officer_id'),
			'serial_number'=>$serial_code,


				);
				$insert = $this->db->insert('ac_cashadvance', $data);
				$entry_id = $this->db->insert_id();
				if($this->input->post('adv_type')=='Project')
				{
					for($i=1; $i<=3; $i++)
					{
						if($this->input->post('task_id'.$i)!='')
						{
											 $data=array(
							'adv_id' => $entry_id,
							'prj_id' => $this->input->post('project_id'),
							'task_id' => $this->input->post('task_id'.$i),
							'amount' => $this->input->post('task_amount'.$i),

								);
								$insert = $this->db->insert('ac_cashadv_tasklist', $data);
						}

					}
				}
		$row = $this->db->query('SELECT MAX(adv_id) AS `maxid` FROM `ac_cashadvance`')->row();
		return $row->maxid;
	}
	function project_managers_prjlist()
	{
		 $this->db->select('re_projectms.prj_id');
			 $this->db->where('re_projectms.officer_code',$this->session->userdata('userid'));
			 $query = $this->db->get('re_projectms');
        if ($query->num_rows() > 0) {
          $counter=0;
		  $listarr=NULL;
			$data= $query->result();
			foreach($data as $raw)
			{
				$listarr[$counter]=$raw->prj_id;
				 $counter++;
			}
           return $listarr;
        }
		else return false;
	}
	function get_managers_cash_advancedata($prjlist)
	{
		  	$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			 $this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');

			$this->db->where_in('ac_cashadvance.project_id',$prjlist);
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			   $this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function get_officers_cash_advancedata($officer,$pagination_count,$page,$pay_type='')
	{
		  	$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			 $this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');

			$this->db->where('ac_cashadvance.officer_id',$officer);
			if($pay_type!='')
			$this->db->where('ac_cashbook.pay_type',$pay_type);
			$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			$this->db->group_by('adv_id');
			$this->db->limit($pagination_count,$page);
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}

	function get_officers_cash_advancedata_search($officer,$pagination_count,$page,$search_string,$search_field)
	{
		  	$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			 $this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');

			$this->db->where('ac_cashadvance.officer_id',$officer);
			if($this->session->userdata('cashbookid') != '') {
				$this->db->where('ac_cashadvance.book_id',$this->session->userdata('cashbookid'));
			}
			$this->db->like($search_field,$search_string,'both');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			$this->db->group_by('adv_id');
			$this->db->limit($pagination_count,$page);
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}

	function count_cash_advancedata_officer($officer){
		$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			 $this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');

			$this->db->where('ac_cashadvance.officer_id',$officer);
			if($this->session->userdata('cashbookid') != '') {
				$this->db->where('ac_cashadvance.book_id',$this->session->userdata('cashbookid'));
			}
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			$this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->num_rows();

        }
		else return false;
	}

	function count_cash_advancedata_officer_search($officer,$search_string,$search_field){
		$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			 $this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');

			$this->db->where('ac_cashadvance.officer_id',$officer);
			if($this->session->userdata('cashbookid') != '') {
				$this->db->where('ac_cashadvance.book_id',$this->session->userdata('cashbookid'));
			}
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			$this->db->like($search_field,$search_string,'both');
			$this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->num_rows();

        }
		else return false;
	}

	function get_cashadvancedata($id)
	{
		$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname');
			$this->db->where('ac_cashadvance.adv_id',$id);
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function get_cashadvance_taskdata($id)
	{
		$this->db->select('*');
			$this->db->where('adv_id',$id);
			 $query = $this->db->get('ac_cashadv_tasklist');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function edit_advancedata()
	{
		 $data=array(

			'book_id' => $this->input->post('book_id'),
			'amount' => $this->input->post('amount'),
			'apply_date' => $this->input->post('apply_date'),
			'promiss_date' => $this->input->post('promiss_date'),
			'project_id' => $this->input->post('project_id'),
			'description' => $this->input->post('description'),
			'expence_type' => $this->input->post('expence_type'),


				);
				$this->db->where('adv_id',$this->input->post('adv_id'));
				$insert = $this->db->Update('ac_cashadvance', $data);

	}
	function get_voucherdata($voucherid)
	{
		$this->db->select('*');
		$this->db->where('voucherid',$voucherid);
			 $query = $this->db->get('ac_payvoucherdata');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function delete_advance($id)
	{
		//$tot=$bprice*$quontity;
    //ticket number 3318 updated by nadee 2021-08-19 start
	
		if($id)
		{
			$advancedata=$this->get_cashadvancedata($id);
			if($advancedata->status!='PAID')
			{
				$rowdata=$this->get_cashadvancedata($id);
				if($rowdata->payvoucher_id){
				  $suparray=array('status'=>'DELETED','deleted_by'=>$this->session->userdata('userid'));
				  $this->db->where('voucherid',$rowdata->payvoucher_id)->update('ac_payvoucherdata',$suparray );
				}
			//ticket number 3318 updated by nadee 2021-08-19 end
		
					$this->db->where('adv_id',$id);
				$insert = $this->db->delete('ac_cashadvance');
				$this->db->where('adv_id',$id);
				$insert = $this->db->delete('ac_cashadv_tasklist');
				return true;
			}
			else
			{
				$pay_type=$this->get_booktype_by_advanceid($id) ;
				if($pay_type=='CHQ')
				{
					
					$voucherdata=$this->get_voucherdata($advancedata->payvoucher_id);
					if($voucherdata)
					{
						if($voucherdata->status=='PAID')
						{
								return false;
						}
						
					}
						$this->db->select('ac_cashsettlement.*');
						$this->db->where('ac_cashsettlement.adv_id',$id);
						$query = $this->db->get('ac_cashsettlement');
						if ($query->num_rows() > 0) {
			
							return false;
			
						}
						
						$this->db->where('adv_id',$id);
						$insert = $this->db->delete('ac_cashadvance');
						$this->db->where('adv_id',$id);
						$insert = $this->db->delete('ac_cashadv_tasklist');
						if($advancedata->payvoucher_id)
						$this->db->where('voucherid',$advancedata->payvoucher_id);
						$insert = $this->db->delete('ac_payvoucherdata');
						return true;
					
				}
				
			}
		 }
		return false;

	}

	function check_advance($id)
	{
		 $data=array(
			'status' => 'CHECKED',
			'checked_by' =>  $this->session->userdata('userid'),
			'checked_date' => date('Y-m-d'),


				);
				$this->db->where('adv_id',$id);
				$insert = $this->db->Update('ac_cashadvance', $data);
	}
	function confirm_advance($id)
	{
		$advancedata=$this->get_cashadvancedata($id);
		if($advancedata->status=='CHECKED')
		{
		 $data=array(
			'status' => 'APPROVED',
			'aprove_by' =>  $this->session->userdata('userid'),
			'approve_date' => date('Y-m-d'),


				);
				$this->db->where('adv_id',$id);
				$insert = $this->db->Update('ac_cashadvance', $data);

				$pay_type=$this->get_booktype_by_advanceid($id) ;
				if($pay_type=='CHQ')
				{

					$advancedata=$this->get_cashadvancedata($id);
					$bookdata=$this->get_cashbook_data($advancedata->book_id);
						$idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',$advancedata->apply_date);
			
					$vaouchercode=$idlist[0];
					$data=array(
					'voucherid'=>$vaouchercode,
					'vouchercode'=>$idlist[1],
					'branch_code' => $this->session->userdata('branchid'),
					'ledger_id' => $bookdata->ledger_id,
					'payeecode' => $advancedata->officer_id,
					'payeename' => $advancedata->initial.' '.$advancedata->surname,
					'vouchertype' => '11',
					'paymentdes' =>'Cash  Advance'. $advancedata->adv_code .' - ' .$advancedata->initial.'   '.$advancedata->surname,
					'amount' => $advancedata->amount,
					'applydate' =>$advancedata->apply_date,
					'refnumber'=>$advancedata->adv_code,
					'confirmdate' =>$advancedata->apply_date,
					'status' => 'CONFIRMED',

					);
					if(!$this->db->insert('ac_payvoucherdata', $data))
					{
							$this->db->trans_rollback();
								$this->logger->write_message("error", "Error confirming Project");
						return false;
					}

					$data=array(
							'payvoucher_id' =>  $vaouchercode);
							$this->db->where('adv_id',$id);
						$insert = $this->db->Update('ac_cashadvance', $data);




				}
		}

	}
	function pay_cash($id)
	{
		$advancedata=$this->get_cashadvancedata($id);
		
		if($advancedata->status=='APPROVED')
		{
		
				$bookbalance=get_cashbook_balance($advancedata->book_id);
				if($bookbalance>$advancedata->amount)
				{
		
					$bookdata=$this->get_cashbook_data($advancedata->book_id);
		
		
					$bookdata=$this->get_cashbook_data($advancedata->book_id);
								/*	$crlist[0]['ledgerid']=$bookdata->ledger_id;
									$crlist[0]['amount']=$advancedata->amount;
									$drlist[0]['ledgerid']=$bookdata->advance_ledger;
									$drlist[0]['amount']=$advancedata->amount;
									$crtot=$drtot=$advancedata->amount;
									$narration = $advancedata->adv_code.' -'.$advancedata->description;
									$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,'','','');*/
		
		
		
					$data=array(
						'status' => 'PAID',
						'paid_by' =>  $this->session->userdata('userid'),
						'pay_date' => date('Y-m-d'),
								//'paid_entry_id'=>$int_entry,
		
		
							);
					$this->db->where('adv_id',$id);//updated by nadee 2021_07_02
					$insert = $this->db->Update('ac_cashadvance', $data);
					return true;
				}
				else
				{
					return false;
				}
		}
		else
		{
			return false;
		}

	}
	function get_Paid_advancedata()
	{
		  	$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.emp_no,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			$this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');
			$this->db->where('ac_cashadvance.status','PAID');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			 $this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
    function get_Paid_advancedata_officer($officer)
	{
		  	$this->db->select('ac_cashadvance.*,hr_empmastr.emp_no,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			$this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');
			$this->db->where('ac_cashadvance.status','PAID');
        $this->db->where('ac_cashadvance.officer_id',$officer);
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			 $this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function add_settlment()
	{
		$advancedata=$this->get_cashadvancedata($this->input->post('adv_id'));
		$advid=explode('-', $this->input->post('adv_id'));
		$invoiceid=explode('-', $this->input->post('invoice_id'));
		 $data=array(
			'adv_id' =>$advid['0'],
			'invoice_id' => $invoiceid['0'],
			'settledate' => $this->input->post('settledate'),
			'settleamount' => $this->input->post('settleamount'),
				'ledgerid' => $this->input->post('ledger_id'),
			'note' => $this->input->post('note'),
			'status' => 'PENDING',
			'apply_by'=>$this->session->userdata('userid'),
			'apply_date'=>date('Y-m-d')


				);
				$insert = $this->db->insert('ac_cashsettlement', $data);
				$entry_id = $this->db->insert_id();
		return $entry_id;

	}
	function get_settlmentdata($id)
	{
		$this->db->select('ac_cashsettlement.*,ac_cashadvance.adv_code,ac_cashadvance.amount,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.emp_no');
			$this->db->where('ac_cashsettlement.id',$id);
			$this->db->join('ac_cashadvance','ac_cashadvance.adv_id=ac_cashsettlement.adv_id');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
				 $query = $this->db->get('ac_cashsettlement');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function get_fullsettlmentdata()
	{
		$this->db->select('ac_cashsettlement.*,ac_cashadvance.adv_code,ac_cashadvance.amount,hr_empmastr.initial,hr_empmastr.surname,,ac_cashadvance.apprved_officerid,ac_cashadvance.check_officerid,ac_cashadvance.confirm_officerid');
				$this->db->join('ac_cashadvance','ac_cashadvance.adv_id=ac_cashsettlement.adv_id');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
				$this->db->order_by('ac_cashsettlement.id','DESC');

			 $query = $this->db->get('ac_cashsettlement');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
    function get_fullsettlmentdata_officer($officer)
	{
		$this->db->select('ac_cashsettlement.*,ac_cashadvance.adv_code,ac_cashadvance.amount,hr_empmastr.initial,hr_empmastr.surname');
				$this->db->join('ac_cashadvance','ac_cashadvance.adv_id=ac_cashsettlement.adv_id');
          $this->db->where('ac_cashadvance.officer_id',$officer);
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			 $query = $this->db->get('ac_cashsettlement');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function check_settlement($id)
	{
		 $data=array(
					'checked_date' => date('Y-m-d'),
					'status' => 'CHECKED',
					'checked_by' => $this->session->userdata('userid'),
				);
				$this->db->where('id',$id);
				$insert = $this->db->Update('ac_cashsettlement', $data);
	}
	function confirm_settlment($id)
	{
		 $data=array(
					'confirm_date' => date('Y-m-d'),
					'status' => 'CONFIRMED',
					'confirm_by' => $this->session->userdata('userid'),
				);
				$this->db->where('id',$id);
				$insert = $this->db->Update('ac_cashsettlement', $data);
	}
	function approved_settlment($id)
	{
		
		

		$settledata=$this->get_settlmentdata($id);
		$advancedata=$this->get_cashadvancedata($settledata->adv_id);
		$amount=$settledata->settleamount;
		
		$drledger=$settledata->ledgerid;
		if($settledata->invoice_id!='')
		{
			$drledger='HEDBL31000000';
		}
						$bookdata=$this->get_cashbook_data($advancedata->book_id);
						if($bookdata->pay_type=='CSH')
						$boolkedger=$bookdata->advance_ledger;
						else
						$boolkedger=$bookdata->ledger_id;
						$crlist[0]['ledgerid']=$boolkedger;
						$crlist[0]['amount']=$amount;
						$drlist[0]['ledgerid']=$drledger;
						$drlist[0]['amount']=$amount;
						$crtot=$drtot=$amount;
						$narration = $advancedata->adv_code.' Cash Advance Settlement';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,'','','');



				 $vaouchercode=$advancedata->payvoucher_id;
				 $data=array(
					'voucher_id' => $advancedata->payvoucher_id,
					'settle_entry_id' => $int_entry,
					'status' => 'APPROVED',
					'approved_by' => $this->session->userdata('userid'),
					'approved_date'=>date('Y-m-d')
				);
				$this->db->where('id',$id);
				$insert = $this->db->Update('ac_cashsettlement', $data);
				$entry_id = $this->db->insert_id();
				if($settledata->invoice_id!='')
				{
						$data=array(
						'invoice_id' => $settledata->invoice_id,
						'voucher_id' => $vaouchercode,
						'pay_amount' => $settledata->settleamount,
						'pay_date' => $settledata->settledate,
						'pay_status' => 'CONFIRMED',


						);
						$insert = $this->db->insert('ac_invoicepayments', $data);
						$entry_id = $this->db->insert_id();

						$invdata=$this->get_invoicedata($settledata->invoice_id);
						if($invdata)
						{
							$newpay=$invdata->paidtot+$settledata->settleamount;
							if(round($newpay,2)>=round($invdata->total,2))
							$status='PAID';
							else
							$status='PENDING';
							 $dataaa=array(
							'paidtot' =>$newpay,
							'paystatus' =>$status,


							);
							$this->db->where('id',$settledata->invoice_id);
							$insert = $this->db->Update('ac_invoices', $dataaa);
						}


				}

			//	$advfulldata=$this->get_Paid_advacne_full_databy_id($settledata->adv_id);
				if($advancedata)
				{
					$tot=$advancedata->settled_amount+$settledata->settleamount;
					if($tot>=$advancedata->amount)
					{
						$status='SETTLED';
					}
					else
					$status='PAID';


						 $dataaa=array(
						'settled_amount' =>$tot,
						'status' =>$status,
						'settled_date' =>date('Y-m-d'),


						);
					$this->db->where('adv_id',$advancedata->adv_id);
					$insert = $this->db->Update('ac_cashadvance', $dataaa);
				}

	}
	function delete_settlement($id)
	{
		//$tot=$bprice*$quontity;
		if($id)
		{
			$this->db->where('id',$id);
			$insert = $this->db->delete('ac_cashsettlement');
		}

		return $id;

	}
	function get_invoicedata($id)
	{
		$this->db->select('ac_invoices.*');
			$this->db->where('ac_invoices.id',$id);
			 $query = $this->db->get('ac_invoices');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function cheque_project_payment($voucherid)
	{
		$this->db->select('*');

		$this->db->where('voucherid',$voucherid);

		$query = $this->db->get('re_prjacpaymentdata');
		if ($query->num_rows() > 0){
		//$data= $query->row();
			return false;
		}
		else
		return true;

	}
	function update_cashadvance_onpayment($voucherid)
	{
		$data=array(
						'status' => 'PAID',
					'paid_by' =>  $this->session->userdata('userid'),
						'pay_date' => date('Y-m-d'),

							);
					$this->db->where('payvoucher_id',$voucherid);
					$insert = $this->db->Update('ac_cashadvance', $data);

	}
	function get_payment_data($voucherid)
	{
		$this->db->select('*');

		$this->db->where('voucherid',$voucherid);

		$query = $this->db->get('re_prjacpaymentdata');
		if ($query->num_rows() > 0){
		//$data= $query->row();
			return $query->row();
		}
		else
		return 0;

	}
	function get_project_paymeny_task_data($id,$taskid)
	{
		$this->db->select('re_prjacpaymentms.*,cm_tasktype.task_name');

		$this->db->where('re_prjacpaymentms.prj_id',$id);
		$this->db->where('re_prjacpaymentms.task_id',$taskid);
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentms.task_id');

		$query = $this->db->get('re_prjacpaymentms');
		 if ($query->num_rows >0) {
            return $query->row();
        }
		else
		return false;
	}
	function get_hm_payment_data($voucherid)
	{
		$this->db->select('*');

		$this->db->where('voucherid',$voucherid);

		$query = $this->db->get('re_hmacpaymentdata');
		if ($query->num_rows() > 0){
		//$data= $query->row();
			return $query->row();
		}
		else
		return 0;

	}


function get_hm_project_paymeny_task_data($id,$taskid)
	{
		$this->db->select('re_hmacpaymentms.*,hm_config_task.task_name');

		$this->db->where('re_hmacpaymentms.lot_id',$id);
		$this->db->where('re_hmacpaymentms.task_id',$taskid);
		$this->db->join('hm_config_task','hm_config_task.task_id=re_hmacpaymentms.task_id');

		$query = $this->db->get('re_hmacpaymentms');
		 if ($query->num_rows >0) {
            return $query->row();
        }
		else
		return false;
	}
	function check_already_settled_amount($id)
	{
		//$tot=$bprice*$quontity;

		$this->db->select('*');

		$this->db->where('payvoucher_id',$id);

		$query = $this->db->get('ac_cashadvance');
		if ($query->num_rows() > 0){
		$data= $query->row();
				if($data->settled_amount>0)
				{
				return false;
				}
				else
				return true;
		}
		else
		return true;



	}
	function delete_cashadvance_onpayment($entryid)
	{
		if($entryid)
		{

			$this->db->select('ac_payvoucherdata.*');
			$this->db->where('ac_payvoucherdata.entryid',$entryid);
			$query = $this->db->get('ac_payvoucherdata');
			if ($query->num_rows() > 0) {
				$voucherdata=$query->result();
	
				foreach($voucherdata as $vovraw)
				{
					
					$voucherid=$vovraw->voucherid;
					if($voucherid)
					{
					if($this->check_already_settled_amount($voucherid))
					{
						$this->db->select('ac_invoicepayments.*');
						$this->db->where('ac_invoicepayments.voucher_id',$voucherid);
						$query = $this->db->get('ac_invoicepayments');
						if ($query->num_rows() > 0) {
		
								$data=$query->row();
							$invdata=$this->get_invoicedata($data->invoice_id);
							if($invdata)
							{
								$newpay=$invdata->paidtot-$data->pay_amount;
		
								$status='PENDING';
								 $dataaa=array(
								'paidtot' =>$newpay,
								'paystatus' =>$status,
		
		
								);
							$this->db->where('id',$data->invoice_id);
							$insert = $this->db->Update('ac_invoices', $dataaa);
							}
		
							$suparray=array('status'=>'DELETED','deleted_by'=>$this->session->userdata('userid'));
								 $this->db->where('voucherid',$voucherid)->update('ac_payvoucherdata',$suparray );
							$this->db->where('ac_invoicepayments.voucher_id',$voucherid);
							$insert = $this->db->delete('ac_invoicepayments');
		
						 }
		
		
						$projectpayamet=$this->get_payment_data($voucherid);
						if($projectpayamet){
		
								$masterpaydata=$this->get_project_paymeny_task_data($projectpayamet->prj_id,$projectpayamet->task_id);
								$totpayments=floatval($masterpaydata->tot_payments)- floatval($projectpayamet->amount);
								$data2=array(
								'tot_payments'=>$totpayments,
								);
								$this->db->where('prj_id',$projectpayamet->prj_id);
								$this->db->where('task_id',$projectpayamet->task_id);
								if(!$this->db->update('re_prjacpaymentms', $data2))
								{
									$this->db->trans_rollback();
										$this->logger->write_message("error", "Error confirming Project");
									return false;
								}
								if($voucherid)
								{
								$this->db->where('voucherid', $voucherid);
								$insert = $this->db->delete('re_prjacpaymentdata');
								}
								if($projectpayamet->entry_id)
								{
								 $this->db->where('id', $projectpayamet->entry_id);
								 $insert = $this->db->delete('ac_entries');
								 $this->db->where('entry_id', $projectpayamet->entry_id);
								 $insert = $this->db->delete(' ac_entry_items');
								}
								$suparray=array('status'=>'DELETED','deleted_by'=>$this->session->userdata('userid'));
								 $this->db->where('voucherid',$voucherid)->update('ac_payvoucherdata',$suparray );
						}
		
		
						$projectpayamet_hm=$this->get_hm_payment_data($voucherid);
						if($projectpayamet_hm){
		
								$masterpaydata=$this->get_hm_project_paymeny_task_data($projectpayamet_hm->lot_id,$projectpayamet_hm->task_id);
								$totpayments=floatval($masterpaydata->tot_payments)- floatval($projectpayamet_hm->amount);
								$data2=array(
								'tot_payments'=>$totpayments,
								);
								$this->db->where('lot_id',$projectpayamet_hm->lot_id);
								$this->db->where('task_id',$projectpayamet_hm->task_id);
								if(!$this->db->update('re_hmacpaymentms', $data2))
								{
									$this->db->trans_rollback();
										$this->logger->write_message("error", "Error confirming Project");
									return false;
								}
		
								$this->db->where('voucherid', $voucherid);
								$insert = $this->db->delete('re_hmacpaymentdata');
								if($projectpayamet_hm->entry_id)
								{
								 $this->db->where('id', $projectpayamet_hm->entry_id);
								 $insert = $this->db->delete('ac_entries');
								 $this->db->where('entry_id', $projectpayamet_hm->entry_id);
								 $insert = $this->db->delete(' ac_entry_items');
								}
								$suparray=array('status'=>'DELETED','deleted_by'=>$this->session->userdata('userid'));
								 $this->db->where('voucherid',$voucherid)->update('ac_payvoucherdata',$suparray );
						}
		
					}
					}
				}
			}
			else return false;
		}
		else
		return false;
	}

	 function get_all_advance_tomake_payment()
    {
        $options = array();
        $options[0] = "";
        $this->db->select('ac_ledgers.*,ac_groups.name as gname');
		$this->db->join('ac_ledgers','ac_ledgers.id = ac_cashbook.ledger_id');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
        $this->db->order_by('ac_groups.name','asc');
         $ledger_q = $this->db->get('ac_cashbook');

        return $ledger_q->result();
    }
	function get_Paid_advacne_full_databy_id($id)
	{
		  	$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			$this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');
			$this->db->where('ac_cashadvance.status','PAID');
			$this->db->where('ac_cashadvance.adv_id',$id);
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			 $this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function refund_cash($advance_id)
	{
		$advancedata=$this->get_Paid_advacne_full_databy_id($advance_id);
		if($advancedata)
		{	 $total=$advancedata->amount;
			$paid=$advancedata->totpay;
			$balance=$total-$paid;
			if($balance>0)
			{

				$status='SETTLED';

				 $dataaa=array(
				'refund_amount' =>$balance,
				'status' =>$status,
				'settled_date' =>date('Y-m-d'),


				);
				$this->db->where('adv_id',$advance_id);
				$insert = $this->db->Update('ac_cashadvance', $dataaa);
			}


		}
	}
	function chaeck_pending_settlements_id($id)
	{
		  	$this->db->select('ac_cashsettlement.*');
			$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=ac_cashsettlement.voucher_id','left');
			$this->db->where('ac_payvoucherdata.status','CONFIRMED');
			$this->db->where('ac_cashsettlement.adv_id',$id);
			 $query = $this->db->get('ac_cashsettlement');
        if ($query->num_rows() > 0) {

			return true;

        }
		else return false;
	}
	function chaeck_pending_settlements_officer($id,$date)
	{
		  	$this->db->select('ac_cashadvance.*');
			$this->db->where('ac_cashadvance.promiss_date <',$date);
			$this->db->where('ac_cashadvance.officer_id',$id);
		$this->db->where('ac_cashadvance.status','PAID');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return true;

        }
		else return false;
	}
	function get_pending_data_bybook($book_id,$rptdate)
	{
		  	 $this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.branch,re_projectms.project_name');
			 $this->db->where('ac_cashadvance.book_id',$book_id);
			  $this->db->where('ac_cashadvance.status','PAID');
			  $this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			   $this->db->join('re_projectms','re_projectms.prj_id=ac_cashadvance.project_id','left');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	function  confirm_settlement_data_bybook($book_id,$rptdate)
	{
		  	 $this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.branch,re_projectms.project_name,ac_cashsettlement.voucher_id');
			 $this->db->where('ac_cashadvance.book_id',$book_id);
			  $this->db->where('ac_cashadvance.status','SETTLED');
			   $this->db->where('ac_cashadvance.rpt_status','PENDING');
			    $this->db->where('ac_cashadvance.settled_date <=',$rptdate);
			  $this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			     $this->db->join('re_projectms','re_projectms.prj_id=ac_cashadvance.project_id','left');
			   $this->db->join('ac_cashsettlement','ac_cashsettlement.adv_id=ac_cashadvance.adv_id','left');
			   $this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			$data= $query->result();
			if($data)
			{
				foreach($data as $raw) {
				$status='SETTLED';

				 $dataaa=array(
				'rpt_status' =>'COMPLETE',
				'rpt_updateby' =>$this->session->userdata('userid'),
				'rpt_updatedate' =>date('Y-m-d'),


				);
				$this->db->where('adv_id',$raw->adv_id);
				$insert = $this->db->Update('ac_cashadvance', $dataaa);
				}
			}

        }
		else return false;
	}

	function get_settlement_data_bybook($book_id,$rptdate)
	{
		  	 $this->db->select('ac_cashadvance.*,hr_empmastr.emp_no,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.branch,re_projectms.project_name,ac_cashsettlement.voucher_id');
			 $this->db->where('ac_cashadvance.book_id',$book_id);
			  $this->db->where('ac_cashadvance.status','SETTLED');
			   $this->db->where('ac_cashadvance.rpt_status','PENDING');
			    $this->db->where('ac_cashadvance.settled_date <=',$rptdate);
			  $this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			     $this->db->join('re_projectms','re_projectms.prj_id=ac_cashadvance.project_id','left');
			   $this->db->join('ac_cashsettlement','ac_cashsettlement.adv_id=ac_cashadvance.adv_id','left');
			   $this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}

	function get_cashadvancedata_for_reciept()
	{
		  	$this->db->select('ac_cashadvance.*,ac_cashbook.advance_ledger,ac_cashbook.ledger_id,ac_cashbook.pay_type,hr_empmastr.emp_no,hr_empmastr.display_name,hr_empmastr.initial,hr_empmastr.surname,SUM(ac_cashsettlement.settleamount) as totpay');
			 $this->db->join('ac_cashsettlement','ac_cashadvance.adv_id=ac_cashsettlement.adv_id','left');
			$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id');
					  $this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');

			$this->db->where('ac_cashadvance.status','PAID');
			$this->db->group_by('adv_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}

	  function delete_defunddata($entry_id)
	  {
		  $dataaa=array(
								'refund_amount' =>'0',
								'status' =>'PAID',
								'refund_entryid'=>NULL,
								'refund_rctnumber'=>NULL,
								'refund_date' =>NULL,
								'settled_date' =>NULL,


								);
								$this->db->where('refund_entryid',$entry_id);
								$insert = $this->db->Update('ac_cashadvance', $dataaa);
	  }
	  function get_active_ledgerlist()
	  {
		  $this->db->select('ac_ledgers.*');
		   $this->db->where('ac_ledgers.active',1);
			$query = $this->db->get('ac_ledgers');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	  }
	function get_advance_code($idfield,$prifix,$table,$officerid)
	{

 	$query = $this->db->query("SELECT COUNT(".$idfield.") as id  FROM ".$table." where officer_id='".$officerid."'");

		$newid="";

        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=$prifix.str_pad(1, 5, "0", STR_PAD_LEFT);


			 }
			 else{
			// $prjid=substr($prjid,4,5);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=$prifix.str_pad($newid, 5, "0", STR_PAD_LEFT);


			 }
        }
		else
		{

		$newid=$prifix.str_pad(1, 5, "0", STR_PAD_LEFT);
		$newid=$newid;
		}
	return $newid;

	}
	function get_serial_code($idfield,$prifix,$table,$book_id)
	{

 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table." where book_id='".$book_id."'");
        $bookdata= $this->get_cashbook_data($book_id);
		if($bookdata->pay_type=='CHQ')
		$prifix='ADV-';
		else
		$prifix='IOU-';
		$newid="";

        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 $id=explode('-',$prjid);

			 if($data->id==NULL)
			 {
			 $newid=$prifix.str_pad(1, 5, "0", STR_PAD_LEFT);


			 }
			 else{
			// $prjid=substr($prjid,4,5);
			 $prjid=$id[1];
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=$prifix.str_pad($newid, 5, "0", STR_PAD_LEFT);


			 }
        }
		else
		{

		$newid=$prifix.str_pad(1, 5, "0", STR_PAD_LEFT);
		$newid=$newid;
		}
	return $newid;

	}

	function get_cashadvance_code($entry_id){
		$this->db->select('ac_cashadvance.adv_code');
		$this->db->where('ac_cashadvance.refund_entryid',$entry_id);
		$query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->row()->adv_code;

        }else{
			return false;
		}
	}
	function get_booktype_by_advanceid($id)
	{

		$this->db->select('ac_cashbook.pay_type');
			$this->db->where('ac_cashadvance.adv_id',$id);
		$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			$data= $query->row();
			return $data->pay_type;

        }
		else return false;
	}
	function check_officer_unsettled_advance($officer_id)
	{
		$this->db->select('ac_cashadvance.adv_id');
		$this->db->where('ac_cashadvance.officer_id',$officer_id);
		$this->db->where('ac_cashadvance.promiss_date <=',date('Y-m-d'));
		$this->db->where('ac_cashadvance.status','PAID');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return true;

        }
		else return false;
		//$settlementdate=
	}


	 function get_settlement_data($fromdate,$todate,$officer_id,$amount)
  {

    $this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.branch,
    re_projectms.project_name,ac_cashsettlement.voucher_id,ac_chqprint.CHQNO');
    //$this->db->where('ac_cashadvance.book_id',$book_id);
    $this->db->where('ac_cashadvance.status','SETTLED');
    //$this->db->where('ac_cashadvance.rpt_status','PENDING');
	if($fromdate !="")
    $this->db->where('ac_cashadvance.settled_date >=',$fromdate);
	if($todate !="")
  	 $this->db->where('ac_cashadvance.settled_date <=',$todate);
	if($officer_id !="All")
	 $this->db->where('ac_cashadvance.officer_id ',$officer_id);
	 if($amount!="")
	 $this->db->where('ac_cashadvance.amount ',$amount);
    $this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
    $this->db->join('re_projectms','re_projectms.prj_id=ac_cashadvance.project_id','left');
	$this->db->join('ac_cashsettlement','ac_cashsettlement.adv_id=ac_cashadvance.adv_id','left');
	$this->db->join('ac_payvoucherdata','ac_cashadvance.payvoucher_id = ac_payvoucherdata.voucherid','left');
    $this->db->join('ac_chqprint','ac_payvoucherdata.entryid = ac_chqprint.PAYREFNO','left');
    $this->db->group_by('adv_id');
    $query = $this->db->get('ac_cashadvance');
	//echo $this->db->last_query();
    if ($query->num_rows() > 0) {

      return $query->result();
    }
    else return false;
  }
  function get_ledgerdata_byvoucher($voucherid)
  {
    $this->db->select('ac_payvoucherdata.amount,
    ac_entry_items.dc,
    ac_payvoucherdata.voucherid,
    ac_ledgers.id,
    ac_ledgers.`name`');
    $this->db->join('ac_payvoucherdata','ac_entry_items.entry_id = ac_payvoucherdata.entryid AND ac_entry_items.dc="D"');
    $this->db->join('ac_ledgers','ac_entry_items.ledger_id = ac_ledgers.id','left');

    $this->db->where('ac_payvoucherdata.voucherid',$voucherid);
    $this->db->group_by('ac_payvoucherdata.voucherid');
    $query = $this->db->get('ac_entry_items');
    if ($query->num_rows() > 0) {
      return $query->result();
    }
    else return false;

  }
  function get_project_paymeny_advanceid($adv_id)
  {
    $this->db->select('cm_tasktype.task_name,cm_tasktype.ledger_id,re_prjacpaymentdata.amount');
    $this->db->join('cm_tasktype','cm_tasktype.task_id = re_prjacpaymentdata.task_id','left');
    $this->db->where('re_prjacpaymentdata.advance_id',$adv_id);
    $query = $this->db->get('re_prjacpaymentdata');
    if ($query->num_rows() > 0) {
      return $query->result();
    }
    else return false;


  }
  //ticket end 1322

  //ticketnumber 1520 updated by nadee
  function get_unsettlement_data($fromdate,$todate,$officer_id,$amount)
  {
    $this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.branch,ac_chqprint.CHQNO,
    re_projectms.project_name');
    $this->db->where('ac_cashadvance.status','PAID');
	if($fromdate !="")
	{
    $this->db->where('ac_cashadvance.apply_date >=',$fromdate);
	}
	if($todate !="")
	{
  	 $this->db->where('ac_cashadvance.apply_date <=',$todate);
	}
   if($officer_id !="All"){
      $this->db->where('ac_cashadvance.officer_id',$officer_id);
    }
	 if($amount!="")
	 $this->db->where('ac_cashadvance.amount',$amount);
    $this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
    $this->db->join('re_projectms','re_projectms.prj_id=ac_cashadvance.project_id','left');
    $this->db->join('ac_payvoucherdata','ac_cashadvance.payvoucher_id = ac_payvoucherdata.voucherid','left');
    $this->db->join('ac_chqprint','ac_payvoucherdata.entryid = ac_chqprint.PAYREFNO','left');
    $query = $this->db->get('ac_cashadvance');
	//echo $officer_id;
    if ($query->num_rows() > 0) {

      return $query->result();
    }
    else return false;
  }


  function get_settlement_details($adv_id)
  {
    $this->db->select('ac_cashsettlement.*,re_projectms.project_name,
cm_tasktype.task_name,ac_ledgers.`name`');
    $this->db->join('re_prjacpaymentdata','ac_cashsettlement.settle_entry_id = re_prjacpaymentdata.entry_id','LEFT');
    $this->db->join('re_projectms','re_prjacpaymentdata.prj_id = re_projectms.prj_id','LEFT');
    $this->db->join('cm_tasktype','re_prjacpaymentdata.task_id = cm_tasktype.task_id','LEFT');
    $this->db->join('ac_ledgers','ac_ledgers.id = ac_cashsettlement.ledgerid','LEFT');
    $this->db->where('ac_cashsettlement.adv_id',$adv_id);
    $query = $this->db->get('ac_cashsettlement');
    if ($query->num_rows() > 0) {

      return $query->result();
    }
    else return false;

  }
  function get_settlement_details_task($adv_id,$prj_id,$task_id)
  {
    $this->db->select('ac_cashsettlement.*,re_projectms.project_name,
cm_tasktype.task_name,ac_ledgers.`name`');
    $this->db->join('re_prjacpaymentdata','ac_cashsettlement.settle_entry_id = re_prjacpaymentdata.entry_id','LEFT');
    $this->db->join('re_projectms','re_prjacpaymentdata.prj_id = re_projectms.prj_id','LEFT');
    $this->db->join('cm_tasktype','re_prjacpaymentdata.task_id = cm_tasktype.task_id','LEFT');
    $this->db->join('ac_ledgers','ac_ledgers.id = ac_cashsettlement.ledgerid','LEFT');
    $this->db->where('ac_cashsettlement.adv_id',$adv_id);
	if($prj_id!='All')
	 $this->db->where('re_prjacpaymentdata.prj_id',$prj_id);
	 if($task_id!='All')
	  $this->db->where('re_prjacpaymentdata.task_id',$task_id);
    $query = $this->db->get('ac_cashsettlement');
    if ($query->num_rows() > 0) {

      return $query->result();
    }
    else return false;

  }

  //Ticket No:3074 Updated By Madushan 2021-07-12
   function get_unsettlement_data_time_exceed($officer_id,$book_type,$branch)
  {
    $this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.branch,ac_chqprint.CHQNO,
    re_projectms.project_name');
    $this->db->where('ac_cashadvance.status','PAID');

   if($officer_id !="All"){
      $this->db->where('ac_cashadvance.officer_id',$officer_id);
    }
	$this->db->where('ac_cashadvance.promiss_date <=',date('Y-m-d'));

	 if($book_type != 'all')
    	$this->db->where('ac_cashadvance.book_id',$book_type);

     if($branch != 'all')
    	$this->db->where('hr_empmastr.branch',$branch);

    $this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
    $this->db->join('re_projectms','re_projectms.prj_id=ac_cashadvance.project_id','left');
    $this->db->join('ac_payvoucherdata','ac_cashadvance.payvoucher_id = ac_payvoucherdata.voucherid','left');
    $this->db->join('ac_chqprint','ac_payvoucherdata.entryid = ac_chqprint.PAYREFNO','left');
    $query = $this->db->get('ac_cashadvance');
	//echo $officer_id;
    if ($query->num_rows() > 0) {

      return $query->result();
    }
    else return false;
  }
	function get_checked_cashadvancelist()
	{
		  	$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,hr_bankdtls.account_no,re_projectms.project_name,hr_empmastr.emp_no');
			$this->db->join('re_projectms','re_projectms.prj_id=ac_cashadvance.project_id','left');
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
				$this->db->join('hr_bankdtls','hr_bankdtls.emp_record_id=hr_empmastr.id','left');
			$this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id');
			$this->db->where('ac_cashadvance.status','CHECKED');
			$this->db->order_by('apply_date','desc');
			$this->db->group_by('adv_id');
			$query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}


	//Ticket No-2800 | Added By Uvini
	function cashadvance_data_report($fromdate,$todate,$officer_id,$amount,$prj_id,$pay_type,$branch)
	{//Ticket No-3122 | Added By Uvini

		$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.branch,
	    re_projectms.project_name,ac_cashsettlement.voucher_id,ac_chqprint.CHQNO,ac_payvoucherdata.voucher_ncode');
	      $this->db->where('ac_cashadvance.status <>','PENDING');
		  $this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id','left');
	   $this->db->where('ac_cashbook.pay_type',$pay_type);
	    //$this->db->where('ac_cashadvance.rpt_status','PENDING');
		if($fromdate !="")
	    $this->db->where('ac_cashadvance.apply_date >=',$fromdate);
		if($todate !="")
	  	 $this->db->where('ac_cashadvance.apply_date <=',$todate);
		if($officer_id !="All")
		 $this->db->where('ac_cashadvance.officer_id ',$officer_id);
		 if($prj_id !="All")
		 $this->db->where('ac_cashadvance.project_id ',$prj_id);
		 if($amount!="")
		 $this->db->where('ac_cashadvance.amount ',$amount);
		//End of Ticket No-3122
		if($branch!="all")
		 $this->db->where('hr_empmastr.branch ',$branch);
	    $this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
	    $this->db->join('re_projectms','re_projectms.prj_id=ac_cashadvance.project_id','left');
		$this->db->join('ac_cashsettlement','ac_cashsettlement.adv_id=ac_cashadvance.adv_id','left');
		$this->db->join('ac_payvoucherdata','ac_cashadvance.payvoucher_id = ac_payvoucherdata.voucherid','left');
	    $this->db->join('ac_chqprint','ac_payvoucherdata.entryid = ac_chqprint.PAYREFNO','left');
	    $this->db->group_by('adv_id');
	    $this->db->order_by('ac_cashadvance.apply_date');
	    $query = $this->db->get('ac_cashadvance');
		//echo $this->db->last_query();
	    if ($query->num_rows() > 0) {

	      return $query->result();
	    }
	    else return false;

	}

	function add_dateextend()
	{
		  $dataaa=array(
								'extend_date' =>$this->input->post('extend_date'),
								'extend_apply_by' =>$this->session->userdata('userid'),
								'extend_reason' =>$this->input->post('extend_reason'),
								'extend_status'=>'PENDING'



								);
								$this->db->where('adv_id',$this->input->post('adv_id'));
								$insert = $this->db->Update('ac_cashadvance', $dataaa);
	}
	function confirm_dateextend($id)
	{
		$advancedata=$this->get_cashadvancedata($id);
		  $dataaa=array(
				'promiss_date' =>$advancedata->extend_date,
				'extend_approve_by' =>$this->session->userdata('userid'),
				'extend_status'=>'CONFIRMED'
			);
			$this->db->where('adv_id',$id);
			$insert = $this->db->Update('ac_cashadvance', $dataaa);
	}
	function all_tasklist()
	{
			$this->db->select('*');
					$query = $this->db->get('cm_tasktype');
        if ($query->num_rows() > 0) {

			return $query->result();

        }
		else return false;
	}
	/// IOU settlement report
	function iou_settlementdata($fromdate,$todate,$officer_id,$amount,$prj_id,$task_id,$book_id,$branch)
	{

		$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.branch,
	    re_projectms.project_name,ac_cashsettelment_ontime.checked_by as set_check,ac_cashsettelment_ontime.confirm_by as set_confirm,ac_cashsettelment_ontime.approved_by as set_approve');
	      $this->db->where('ac_cashadvance.status','SETTLED');
		  $this->db->join('ac_cashbook','ac_cashbook.id=ac_cashadvance.book_id','left');
		   $this->db->join('ac_cashsettelment_ontime','ac_cashsettelment_ontime.advance_id=ac_cashadvance.adv_id','left');
		  if($book_id!='')
	 	  $this->db->where('ac_cashadvance.book_id',$book_id);
		if($fromdate !="")
	    $this->db->where('ac_cashadvance.settled_date >=',$fromdate);//updated ticket 3075
		if($todate !="")
	  	 $this->db->where('ac_cashadvance.settled_date <=',$todate);
		if($officer_id !="All")
		 $this->db->where('ac_cashadvance.officer_id ',$officer_id);
		 if($prj_id !="All")
		 $this->db->where('ac_cashadvance.project_id ',$prj_id);
		 if($amount!="")
		 $this->db->where('ac_cashadvance.amount ',$amount);
		if($branch!="all")
		 $this->db->where('hr_empmastr.branch ',$branch);
	    $this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
	    $this->db->join('re_projectms','re_projectms.prj_id=ac_cashadvance.project_id','left');
	    $this->db->group_by('adv_id');
	    $this->db->order_by('ac_cashadvance.apply_date');
	    $query = $this->db->get('ac_cashadvance');
		//echo $this->db->last_query();
	    if ($query->num_rows() > 0) {

	      return $query->result();
	    }
	    else return false;

	}
	function get_settlement_details_IOU($adv_id,$prj_id,$task_id)
  {
	  $arra['amount']=0;
	   $arra['je']='';
    $this->db->select('ac_cashsettlement.*,re_projectms.project_name,
cm_tasktype.task_name,ac_ledgers.name,ac_entries.number');
    $this->db->join('re_prjacpaymentdata','ac_cashsettlement.settle_entry_id = re_prjacpaymentdata.entry_id','LEFT');
    $this->db->join('re_projectms','re_prjacpaymentdata.prj_id = re_projectms.prj_id','LEFT');
    $this->db->join('cm_tasktype','re_prjacpaymentdata.task_id = cm_tasktype.task_id','LEFT');
    $this->db->join('ac_ledgers','ac_ledgers.id = ac_cashsettlement.ledgerid','LEFT');
	   $this->db->join('ac_entries','ac_entries.id = ac_cashsettlement.settle_entry_id','LEFT');
    	$this->db->where('ac_cashsettlement.adv_id',$adv_id);
		if($prj_id!='All')
		 $this->db->where('re_prjacpaymentdata.prj_id',$prj_id);
		 if($task_id!='All')
		  $this->db->where('re_prjacpaymentdata.task_id',$task_id);
  		  $query = $this->db->get('ac_cashsettlement');
    if ($query->num_rows() > 0) {

      $dataset= $query->result();
	  foreach( $dataset as $raw)
	  {
		   $arra['amount']= $arra['amount']+$raw->settleamount;
		   $arra['je']= $raw->number.','.$arra['je'];
	  }
    }
     return $arra;
  }
function get_payment_details_IOU($adv_id,$prj_id,$task_id)
  {
	  $arra['amount']=0;
	   $arra['je']='';
    $this->db->select('ac_cashpayment_ontime.*');
    	$this->db->where('ac_cashpayment_ontime.advance_id',$adv_id);
			  $query = $this->db->get('ac_cashpayment_ontime');
    if ($query->num_rows() > 0) {

      $dataset= $query->result();
	  foreach( $dataset as $raw)
	  {
		   $arra['amount']= $arra['amount']+$raw->pay_amount;
		   $arra['je']= $raw->serial_number.','.$arra['je'];
	  }
    }
     return $arra;
  }

//ticket number 3318 updated by nadee 2021-08-19
  function check_voucher_statues($vou_id)
  {
    $this->db->select('ac_payvoucherdata.status');
      $this->db->where('voucherid',$vou_id);
        $query = $this->db->get('ac_payvoucherdata');
    if ($query->num_rows() > 0) {

      $dataset= $query->row();
      return $dataset;
    }
  }

}
