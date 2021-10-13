<?php
// file use for create edit ac_projects
class auditreport extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('paymentvoucher_model');
        $this->load->model('Entry_model');
        $this->load->model('Ledger_model');
        $this->load->model('Tag_model');
        $this->load->model('ac_projects_model');
        $this->load->model('cheque_model');
        $this->load->model('budgeting_model');
        $this->load->model('reciept_model');
		 $this->load->model('common_model');
		  $this->load->model('eploan_model');
		  $this->load->model('reservation_model');
		   $this->load->model('accountsearch_model');
		    $this->load->model('auditreport_model');
	$this->is_logged_in();



    }
    function index()
    {
		
        $data=NULL;
		$data['recieptentrydata']=NULL;
	$data['paymentdata']=NULL;
	$data['otherdata']=NULL;
        if ( ! check_access('view_income'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('re/project/');
            return;
        }
     
		$data['projects']=$this->auditreport_model->get_project();
     
        //$data['employee']=$this->paymentvoucher_model->get_employeedata();
        $this->load->view('accounts/auditreport/index',$data);
        return;
    }
	function check_income_expence_ledger()
	{
		echo $this->accountsearch_model->check_income_expence_ledger('HEDBL32000102');
	}

function get_blocklist($id)
{
	
		
	$data['lotlist']=$this->auditreport_model->get_project_lots($id);
	$this->load->view('accounts/auditreport/blocklist',$data);
}
function get_reservation($prj_id,$lot_id)
{
	
		
	$data['reslist']=$this->auditreport_model->get_project_reservations($prj_id,$lot_id);
	$this->load->view('accounts/auditreport/reservation_list',$data);
}
function search()
{
	
//	print_r( $this->input->post());
	
	$prj_id=$this->uri->segment(4);
	$lot_id=$this->uri->segment(5);
	$res_code=$this->uri->segment(6);
	$todate=$this->uri->segment(7);
	echo $prj_id.'/'.$lot_id.'/'.$res_code;
	if($res_code=='ALL')
	{
		$data['reslist']=$reslist=$this->auditreport_model->get_project_reservations($prj_id,$lot_id);
		if($reslist)
		{
			foreach($reslist as $raw)
			{
				$advanceland_module[$raw->res_code]=0;
				$tradedebtor_module[$raw->res_code]=0;
				$nepdebtor_module[$raw->res_code]=0;
				$zepdebtor_module[$raw->res_code]=0;
				$epbdebtor_module[$raw->res_code]=0;
				$zepstock_module[$raw->res_code]=0;
				$nepstock_module[$raw->res_code]=0;
				$unsale_module[$raw->res_code]=0;
				$uncost_module[$raw->res_code]=0;
				$unsalehm_module[$raw->res_code]=0;
				$uncosthm_module[$raw->res_code]=0;
				$unint_module[$raw->res_code]=0;
				$susint_module[$raw->res_code]=0;
				
				$intincome_module[$raw->res_code]=0;
				$salesincome_module[$raw->res_code]=0;
				$costsale_module[$raw->res_code]=0;
				
				$hmsalesincome_module[$raw->res_code]=0;
				$hmcostsale_module[$raw->res_code]=0;
				$prifitflag=false;
				$advabnceflag=false;
				if($raw->res_date <=$todate)//reservation has done before seach date
				{
					$prifitflag=false;
					$advabnceflag=false;
				}
				else 
				{
					if($raw->res_status!='REPROCESS' )// if reservation not  reporcess
					{
						if($raw->profit_date <=$todate)// if profit transferd before search date
								$prifitflag=true;
						else
							$advabnceflag=true;
					}
					else
					{
						if($raw->resale_date <= $todate)
							{
								$prifitflag=false;
								$advabnceflag=false;
							}
							else
							{
								if($raw->profit_date <=$todate)// if profit transferd before search date
								$prifitflag=true;
								else
							$advabnceflag=true;
							}
					}
				}
					
						if($prifitflag)// if profit transferd before search date
						{
							$advanceland_module[$raw->res_code]=0;
							$unrealised=$this->re_unrealizeddata($raw->res_code,$todate);
							$costbal_re=$this->costof_sale-$unrealised['re_cost'];
								$costbal_hm=$this->housing_cost-$unrealised['hm_cost'];
								$salebal_re=$this->re_discounted_price-$unrealised['re_sale'];
								$salebal_hm=$this->hm_discounted_price -$unrealised['hm_sale'];
								
								$unsale_module[$raw->res_code]=$salebal_re;
								$uncost_module[$raw->res_code]=$costbal_re;
								
								$unsalehm_module[$raw->res_code]=$salebal_hm;
								$uncosthm_module[$raw->res_code]=$costbal_hm;
								
								$salesincome_module[$raw->res_code]=$unrealised['re_sale'];
								$costsale_module[$raw->res_code]=$unrealised['re_cost'];
								
								$hmsalesincome_module[$raw->res_code]=$unrealised['hm_sale'];
								$hmcostsale_module[$raw->res_code]=$unrealised['hm_cost'];
								$advanceamount=$this->get_advance_data($raw->res_code,$todate);
								
								
								$traddedebbal=$this->discounted_price-$advanceamount;
							
								
									if($raw->pay_type=='Pending' ||  $raw->pay_type=='Outright')
									{
										$tradedebtor_module[$raw->res_code]=$traddedebbal;
									}
									else
									{
										$loandata=$this->get_loandetails($raw->res_code);
									
										if($loandata->confirm_date<$todate)
										{
											$rebate=$this->get_rebate_data($loandata->loan_code,$todate);
											if($rebate)
											{
												$nepdebtor_module[$raw->res_code]=0;
												$zepdebtor_module[$raw->res_code]=0;
												$epbdebtor_module[$raw->res_code]=0;
												$zepstock_module[$raw->res_code]=0;
												$nepstock_module[$raw->res_code]=0;
												
												$unint_module[$raw->res_code]=0;
												$susint_module[$raw->res_code]=0;
											}
											else
											{
										
												$paydata=$this->get_loanpay_amounts($loandata->loan_code,$loandata->reschdue_sqn,$todate);
												if($loandata->loan_type!='EPB')
												{
													$duedata=$this->get_due_amounts($loandata->loan_code,$loandata->reschdue_sqn,$todate);
													$totdata=$this->get_tot_loan_amount($loandata->loan_code,$loandata->reschdue_sqn);
													$unint_module[$raw->res_code]=$totdata['tot_int']-$duedata['due_int'];
													$arrint=$duedata['due_int']-$paydata['pay_int'];
													$crint=0;
													if($arrint<0)
													$crint=$arrint*-1;
													$susint_module[$raw->res_code]=$totdata['tot_int']-$paydata['pay_int']+$crint;
													if($loandata->loan_type=='ZEP')
													{
													$zepstock_module[$raw->res_code]=$totdata['tot_cap']-$duedata['due_cap'];
													$zepdebtor_module[$raw->res_code]=$duedata['due_cap']+$duedata['due_int']-$paydata['pay_int']-$paydata['paycap'];
													}
													if($loandata->loan_type=='NEP')
													{
													$nepstock_module[$raw->res_code]=$totdata['tot_cap']-$duedata['due_cap'];;
													$nepdebtor_module[$raw->res_code]=$duedata['due_cap']+$duedata['due_int']-$paydata['pay_int']-$paydata['paycap'];
													}
													
												}
												else
												{
												$epbdebtor_module[$raw->res_code]=$loandata->loan_amount-$paydata['paycap'];
												}
											}
										}
										else
										{
											$tradedebtor_module[$raw->res_code]=$traddedebbal;
										}
									
									}
									
						}
						if($advabnceflag) // if profit not transferd before search date
						{
						$advanceland_module[$raw->res_code]=$this->get_advance_data($raw->res_code,$todate);
						}
				
				
			}
		}
   
	}
	
	$data['advanceland_module']=$advanceland_module;
	$data['tradedebtor_module']=$tradedebtor_module;
	$data['nepdebtor_module']=$nepdebtor_module;
	$data['zepdebtor_module']=$zepdebtor_module;
	$data['epbdebtor_module']=$epbdebtor_module;
	$data['zepstock_module']=$zepstock_module;
	$data['nepstock_module']=$nepstock_module;
	$data['unsale_module']=$unsale_module;
	$data['uncost_module']=$uncost_module;
	$data['unsalehm_module']=$unsalehm_module;
	$data['uncosthm_module']=$uncosthm_module;
	$data['unint_module']=$unint_module;
	$data['susint_module']=$susint_module;
	$data['intincome_module']=$intincome_module;
	$data['salesincome_module']=$salesincome_module;
	$data['costsale_module']=$costsale_module;
	$data['hmsalesincome_module']=$hmsalesincome_module;
	$data['hmcostsale_module']=$hmcostsale_module;
	$this->load->view('accounts/auditreport/searchdata',$data);
	
}



}
