<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Check if the currently logger in user has the necessary permissions
 * to permform the given action
 *
 * Valid permissions strings are given below :
 *
 * 'view entry'
 * 'create entry'
 * 'edit entry'
 * 'delete entry'
 * 'print entry'
 * 'email entry'
 * 'download entry'
 * 'create ledger'
 * 'edit ledger'
 * 'delete ledger'
 * 'create group'
 * 'edit group'
 * 'delete group'
 * 'create tag'
 * 'edit tag'
 * 'delete tag'
 * 'view reports'
 * 'view log'
 * 'clear log'
 * 'change account settings'
 * 'cf account'
 * 'backup account'
 * 'administer'
 */

if ( ! function_exists('check_access'))
{
	function check_access($action_name)
	{
		$CI =& get_instance();
		$user_role = $CI->session->userdata('usertype');
		$permissions['admin'] = array(
// Accounts Module Privilage list********************************************************************************************************		
			'view entry',
			'create entry',
			'edit entry',
			'delete entry',
			'print entry',
			'email entry',
			'download entry',
			'create ledger',
			'edit ledger',
			'delete ledger',
			'create group',
			'edit group',
			'delete group',
			'create tag',
			'edit tag',
			'delete tag',
			'view reports',
			'view log',
			'clear log',
			'change account ac_settings',
			'change stock ac_settings',
			'cf account',
			'cancel cheque',
			'backup account',
			'create chequebook',//Added By Udani
			'edit chequeboundle',
			'delete chequeboundle',
			'create recieptbook',
			'edit recieptboundle',
			'delete recieptboundle',
			'cancel recieptboundle',
			'cancel entry',
			'confirm entry',
			'add payments',
			'cancel payment',
			'edit paymententry',
			'delete paymententry',
			'add vouchers',
			'edit vouchers',
			'delete vouchers',
			'confirm vouchers',
			'create project',
			'edit project',
			'create sub project',
			'edit sub project',	
			'delete sub project',
			'create projectpayment',
			'monthly report',
			'reprint',
			//Added by Eranga
			'create employee',
			'view employee',
			'view suppliers',
			'create suppliers',
			'view inventory',
			'create inventory',
			'edit inventory',
			'delete inventory',
			'view issuedata',
			'edit issuedata',
			'create issuedata',
			'delete issuedata',
			'view ac_divisions',
			'edit ac_divisions',
			'delete ac_divisions',
			'create ac_divisions',
			'confirm reciept',
			'create monthlyforcast',
			'edit annualbudget',
			'edit annualbudget',
			'create annualbudget',
			'edit annualbudget',
			'create schedules',
			'update schedules',
			'view schedules',
			'create financialstatement',
			'adjust inventory',
			'dispose inventory',
		
// End Accounts module *******************************************************		
			'forms',
			'all_branch',
			'high_auth_comment',
			'manager_comment',
			// person who has this privilage can view details of all branches
			//new ERP development access previlage list
			//configuration main module******************************************************************************************************
		'all_branch',
			//branch configuration data
			'view_branch',
			'add_branch',
			'edit_branch',
			//Document configuration data
			'view_documenttyps',
			'add_documenttyps',
			'edit_documenttyps',
			'delete_documenttyps',
			'confirm_documenttyps',
			//Task configuration data
			'view_producttask',
			'add_producttask',
			'edit_producttask',
			'delete_producttask',
			'confirm_producttask',
			//downpayment configuration data
			'view_dplevels',
			'add_dplevels',
			'edit_dplevels',
			'delete_dplevels',
			'confirm_dplevels',
			// Finance rates
			'view_rates',
			'add_rates',
			'edit_rates',
			'delete_rates',
			'confirm_rates',
			//Real Estate Module******************************************************************************************************
			//Introducer  data
			'view_introducer',
			'add_introducer',
			'edit_introducer',
			'delete_introducer',
			'confirm_introducer',
			'view_supplier',
			'add_supplier',
			'edit_supplier',
			'delete_supplier',
			'confirm_supplier',
			//landdetails  data
			'view_land',
			'add_land',
			'edit_land',
			'delete_land',
			'confirm_land',
			'comment_land',
			//landdetails  data
			'view_project',
			'add_project',
			'edit_project',
			'delete_project',
			'confirm_project',
			'comment_project',
			//feasibility  data
			'view_feasibility',
			'add_feasibility',
			'edit_feasibility',
			'delete_feasibility',
			'confirm_feasibility',
			'comment_feasibility',
			'generate_evereport',
			'view_evereport',
			//project development module
			'add_lotdata',
			//project Payments
			'view_projectpayment',
			'add_projectpayment',
			'edit_projectpayment',
			'delete_projectpayment',
			'confirm_projectpayment',
			'comment_projectpayment',
			'generate_projectpayment',
			//customer  data
			'view_customer',
			'add_customer',
			'edit_customer',
			'delete_customer',
			'confirm_customer',
			//salesmen  data
			'view_salesmen',
			'add_salesmen',
			'edit_salesmen',
			'delete_salesmen',
			'confirm_salesmen',
			//reservation  data
			'view_reservation',
			'add_reservation',
			'edit_reservation',
			'delete_reservation',
			'confirm_reservation',
				//advance payment  data
				'add_advance',
			'delete_advance',
			//reservation  data
			'view_eploan',
			'add_eploan',
			'edit_eploan',
			'delete_eploan',
			'confirm_eploan',
			//edit reserved lot
			'edit_rslot',
			//reservation  data
			'view_documents',
			'edit_documents',
			'settlement_withoutfulldown',
			'view_report',
			'add_banktrn',
				//Fund Transfers
			'view_fundtransfers',
			'add_fundtransfers',
			'edit_fundtransfers',
			'delete_fundtransfers',
			'confirm_fundtransfers',
			'add_banktrn',
			// dead transfers
			'view_deedtrn',
			'add_deedtrn',
			'delete_deedtrn',
			'confirm_deedtrn',
		);
		$permissions['re_manager'] = array(
		'view entry',
			'create entry',
			'edit entry',
			'delete entry',
			'print entry',
			'email entry',
			'download entry',
			'create ledger',
			'edit ledger',
			'delete ledger',
			'create group',
			'edit group',
			'delete group',
			'create tag',
			'edit tag',
			'delete tag',
			'view reports',
			'view log',
			'clear log',
			'change account ac_settings',
			'change stock ac_settings',
			'cf account',
			'cancel cheque',
			'backup account',
			'create chequebook',//Added By Udani
			'edit chequeboundle',
			'delete chequeboundle',
			'create recieptbook',
			'edit recieptboundle',
			'delete recieptboundle',
			'cancel recieptboundle',
			'cancel entry',
			'confirm entry',
			'add payments',
			'cancel payment',
			'edit paymententry',
			'delete paymententry',
			'add vouchers',
			'edit vouchers',
			'delete vouchers',
			'confirm vouchers',
			'create project',
			'edit project',
			'create sub project',
			'edit sub project',	
			'delete sub project',
			'create projectpayment',
			'monthly report',
			'reprint',
			//Added by Eranga
			'create employee',
			'view employee',
			'view suppliers',
			'create suppliers',
			'view inventory',
			'create inventory',
			'edit inventory',
			'delete inventory',
			'view issuedata',
			'edit issuedata',
			'create issuedata',
			'delete issuedata',
			'view ac_divisions',
			'edit ac_divisions',
			'delete ac_divisions',
			'create ac_divisions',
			'confirm reciept',
			'create monthlyforcast',
			'edit annualbudget',
			'edit annualbudget',
			'create annualbudget',
			'edit annualbudget',
			'create schedules',
			'update schedules',
			'view schedules',
			'create financialstatement',
			'adjust inventory',
			'dispose inventory',
			'all_branch',
			//branch configuration data
			'view_branch',
			'add_branch',
			'edit_branch',
			//Document configuration data
			'view_documenttyps',
			'add_documenttyps',
			'edit_documenttyps',
			'delete_documenttyps',
			'confirm_documenttyps',
			//Task configuration data
			'view_producttask',
			'add_producttask',
			'edit_producttask',
			'delete_producttask',
			'confirm_producttask',
			//downpayment configuration data
			'view_dplevels',
			'add_dplevels',
			'edit_dplevels',
			'delete_dplevels',
			'confirm_dplevels',
			// Finance rates
			'view_rates',
			'add_rates',
			'edit_rates',
			'delete_rates',
			'confirm_rates',
			//Real Estate Module******************************************************************************************************
			//Introducer  data
			'view_introducer',
			'add_introducer',
			'edit_introducer',
			'delete_introducer',
			'confirm_introducer',
			'view_supplier',
			'add_supplier',
			'edit_supplier',
			'delete_supplier',
			'confirm_supplier',
			//landdetails  data
			'view_land',
			'add_land',
			'edit_land',
			'delete_land',
			'confirm_land',
			'comment_land',
			//landdetails  data
			'view_project',
			'add_project',
			'edit_project',
			'delete_project',
			'confirm_project',
			'comment_project',
			//feasibility  data
			'view_feasibility',
			'add_feasibility',
			'edit_feasibility',
			'delete_feasibility',
			'confirm_feasibility',
			'comment_feasibility',
			'generate_evereport',
			'view_evereport',
			//project development module
			'add_lotdata',
			//project Payments
			'view_projectpayment',
			'add_projectpayment',
			'edit_projectpayment',
			'delete_projectpayment',
			'confirm_projectpayment',
			'comment_projectpayment',
			'generate_projectpayment',
				//Fund Transfers
			'view_fundtransfers',
			'add_fundtransfers',
			'edit_fundtransfers',
			'delete_fundtransfers',
			'confirm_fundtransfers',
			//customer  data
			'view_customer',
			'add_customer',
			'edit_customer',
			'delete_customer',
			'confirm_customer',
			//salesmen  data
			'view_salesmen',
			'add_salesmen',
			'edit_salesmen',
			'delete_salesmen',
			'confirm_salesmen',
			//reservation  data
			'view_reservation',
			'add_reservation',
			'edit_reservation',
			'delete_reservation',
			'confirm_reservation',
				//advance payment  data
				'add_advance',
			'delete_advance',
			//reservation  data
			'view_eploan',
			'add_eploan',
			'edit_eploan',
			'delete_eploan',
			'confirm_eploan',
			//edit reserved lot
			'edit_rslot',
			//reservation  data
			'view_documents',
			'edit_documents',
			'settlement_withoutfulldown',
			'view_report',
			'add_banktrn',
			// deed transfers
			'view_deedtrn',
			'add_deedtrn',
			'delete_deedtrn',
			'confirm_deedtrn',
			
			'view_lotlist',
			
		);
		$permissions['Project Officer'] = array(
			'view_reservation',
			'view_eploan',
			'view_report'
		
	
		);
		$permissions['Cashier'] = array(
			'view_reservation',
			'view_eploan',
			'add_advance',
			'delete_advance',
			'add_banktrn',
			'edit paymententry',
			'create entry',
			'edit entry',
			'cancel entry',
			'delete entry',
			'confirm reciept',
			'print entry',
			'reprint',
		);
		$permissions['Legal Executive'] = array(
			'view_reservation',
			'view_eploan',
			'view_deedtrn',
			'add_deedtrn',
			'delete_deedtrn',
			'confirm_deedtrn',
			'view_reservation',
			'view_eploan',
			
		);
		$permissions['Directors'] = array(
				'view entry',
			'create entry',
			'edit entry',
			'delete entry',
			'print entry',
			'email entry',
			'download entry',
			'create ledger',
			'edit ledger',
			'delete ledger',
			'create group',
			'edit group',
			'delete group',
			'create tag',
			'edit tag',
			'delete tag',
			'view reports',
			'view log',
			'clear log',
			'change account ac_settings',
			'change stock ac_settings',
			'cf account',
			'cancel cheque',
			'backup account',
			'create chequebook',//Added By Udani
			'edit chequeboundle',
			'delete chequeboundle',
			'create recieptbook',
			'edit recieptboundle',
			'delete recieptboundle',
			'cancel recieptboundle',
			'cancel entry',
			'confirm entry',
			'add payments',
			'cancel payment',
			'edit paymententry',
			'delete paymententry',
			'add vouchers',
			'edit vouchers',
			'delete vouchers',
			'confirm vouchers',
			'create project',
			'edit project',
			'monthly report',
			'reprint',
			//Added by Eranga
			'confirm reciept',
			'create monthlyforcast',
		
// End Accounts module *******************************************************		
			'forms',
			'all_branch',
			'high_auth_comment',
			'manager_comment',
				'settlement_withoutfulldown',
			//branch configuration data
			'view_branch',
			'add_branch',
			'edit_branch',
			//Document configuration data
			'view_documenttyps',
			'add_documenttyps',
			'edit_documenttyps',
			'delete_documenttyps',
			'confirm_documenttyps',
			//Task configuration data
			'view_producttask',
			'add_producttask',
			'edit_producttask',
			'delete_producttask',
			'confirm_producttask',
			//downpayment configuration data
			'view_dplevels',
			'add_dplevels',
			'edit_dplevels',
			'delete_dplevels',
			'confirm_dplevels',
			// Finance rates
			'view_rates',
			'add_rates',
			'edit_rates',
			'delete_rates',
			'confirm_rates',
			//Real Estate Module******************************************************************************************************
			//Introducer  data
			'view_introducer',
			'add_introducer',
			'edit_introducer',
			'delete_introducer',
			'confirm_introducer',
			'view_supplier',
			'add_supplier',
			'edit_supplier',
			'delete_supplier',
			'confirm_supplier',
			//landdetails  data
			'view_land',
			'add_land',
			'edit_land',
			'delete_land',
			'confirm_land',
			'comment_land',
			//landdetails  data
			'view_project',
			'add_project',
			'edit_project',
			'delete_project',
			'confirm_project',
			'comment_project',
			//feasibility  data
			'view_feasibility',
			'add_feasibility',
			'edit_feasibility',
			'delete_feasibility',
			'confirm_feasibility',
			'comment_feasibility',
			'generate_evereport',
			'view_evereport',
			//project development module
			'add_lotdata',
			//project Payments
			'view_projectpayment',
			'add_projectpayment',
			'edit_projectpayment',
			'delete_projectpayment',
			'confirm_projectpayment',
			'comment_projectpayment',
			'generate_projectpayment',
			//customer  data
			'view_customer',
			'add_customer',
			'edit_customer',
			'delete_customer',
			'confirm_customer',
			//salesmen  data
			'view_salesmen',
			'add_salesmen',
			'edit_salesmen',
			'delete_salesmen',
			'confirm_salesmen',
			//reservation  data
			'view_reservation',
			'add_reservation',
			'edit_reservation',
			'delete_reservation',
			'confirm_reservation',
				//advance payment  data
				'add_advance',
			'delete_advance',
			//reservation  data
			'view_eploan',
			'add_eploan',
			'edit_eploan',
			'delete_eploan',
			'confirm_eploan',
			//edit reserved lot
			'edit_rslot',
			//reservation  data
			'view_documents',
			'edit_documents',
		
			'view_report',
			'add_banktrn',
				//Fund Transfers
			'view_fundtransfers',
			'add_fundtransfers',
			'edit_fundtransfers',
			'delete_fundtransfers',
			'confirm_fundtransfers',
			'add_banktrn',
		);
	
	$permissions['Receptionist'] = array(
			'view_reservation',
			'view_eploan',
		
		);
	$permissions['Internal Audit Executive'] = array(
			'view_reservation',
			'view_eploan',
			'RE Reports',
			'view_report',
		);
	$permissions['Account Executive'] = array(
			'view_reservation',
			'view_eploan',
					'view entry',
			'create entry',
			'edit entry',
			'delete entry',
			'print entry',
			'email entry',
			'download entry',
			'create ledger',
			'edit ledger',
			'delete ledger',
			'create group',
			'edit group',
			'delete group',
			'create tag',
			'edit tag',
			'delete tag',
			'view reports',
			'view log',
			'clear log',
			'change account ac_settings',
			'change stock ac_settings',
			'cf account',
			'cancel cheque',
			'backup account',
			'create chequebook',//Added By Udani
			'edit chequeboundle',
			'delete chequeboundle',
			'create recieptbook',
			'edit recieptboundle',
			'delete recieptboundle',
			'cancel recieptboundle',
			'cancel entry',
			'confirm entry',
			'add payments',
			'cancel payment',
			'edit paymententry',
			'delete paymententry',
			'add vouchers',
			'edit vouchers',
			'delete vouchers',
			'confirm vouchers',
			'create project',
			'edit project',
			'monthly report',
			'reprint',
			//Added by Eranga
			'confirm reciept',
			'create monthlyforcast',
				'view_projectpayment',
			'add_projectpayment',
			'edit_projectpayment',
			'delete_projectpayment',
			'confirm_projectpayment',
			'comment_projectpayment',
			'generate_projectpayment',
			'view_fundtransfers',
			'add_fundtransfers',
			'edit_fundtransfers',
			'delete_fundtransfers',
			'confirm_fundtransfers',
			'add_banktrn',
		);
		$permissions['Customer Care Executive'] = array(
			'view_lotlist',
			'add_lotdata',
			'view_reservation',
			'view_eploan',
			'view_salesmen',
			'add_salesmen',
			'add_reservation',
			'add_advance',
			'delete_advance',
			'edit_reservation',
			'confirm_reservation',
			'delete_reservation',
			//customer  data
			'view_customer',
			'add_customer',
			'edit_customer',
			'delete_customer',
			'confirm_customer',
			'view_deedtrn',
			'add_deedtrn',
			'delete_deedtrn',
				'view_report'
			
	
		);
	$permissions['Head of Customer Care'] = array(
				//branch configuration data
			'view_branch',
			'add_branch',
			'edit_branch',
			//Document configuration data
			'view_documenttyps',
			'add_documenttyps',
			'edit_documenttyps',
			'delete_documenttyps',
			'confirm_documenttyps',
			'confirm_discountedreservation',
			//Task configuration data
			'view_producttask',
			'add_producttask',
			'edit_producttask',
			'delete_producttask',
			'confirm_producttask',
			//downpayment configuration data
			'view_dplevels',
			'add_dplevels',
			'edit_dplevels',
			'delete_dplevels',
			'confirm_dplevels',
			// Finance rates
			'view_rates',
			'add_rates',
			'edit_rates',
			'delete_rates',
			'confirm_rates',
			//Real Estate Module******************************************************************************************************
			//Introducer  data
			'view_introducer',
			'add_introducer',
			'edit_introducer',
			'delete_introducer',
			'confirm_introducer',
			'view_supplier',
			'add_supplier',
			'edit_supplier',
			'delete_supplier',
			'confirm_supplier',
			//landdetails  data
			'view_land',
			'add_land',
			'edit_land',
			'delete_land',
			'confirm_land',
			'comment_land',
			//landdetails  data
			'view_project',
			'add_project',
			'edit_project',
			'delete_project',
			'confirm_project',
			'comment_project',
			//feasibility  data
			'view_feasibility',
			'add_feasibility',
			'edit_feasibility',
			'delete_feasibility',
			'confirm_feasibility',
			'comment_feasibility',
			'generate_evereport',
			'view_evereport',
			//project development module
			'add_lotdata',
			//project Payments
			'view_projectpayment',
			'add_projectpayment',
			'edit_projectpayment',
			'delete_projectpayment',
			'confirm_projectpayment',
			'comment_projectpayment',
			'generate_projectpayment',
			//customer  data
			'view_customer',
			'add_customer',
			'edit_customer',
			'delete_customer',
			'confirm_customer',
			//salesmen  data
			'view_salesmen',
			'add_salesmen',
			'edit_salesmen',
			'delete_salesmen',
			'confirm_salesmen',
			//reservation  data
			'view_reservation',
			'add_reservation',
			'edit_reservation',
			'delete_reservation',
			'confirm_reservation',
				//advance payment  data
				'add_advance',
			'delete_advance',
			//reservation  data
			'view_eploan',
			'add_eploan',
			'edit_eploan',
			'delete_eploan',
			'confirm_eploan',
			//edit reserved lot
			'edit_rslot',
			//reservation  data
			'view_documents',
			'edit_documents',
		
			'view_report',
			'add_banktrn',
				//Fund Transfers
			'view_fundtransfers',
			'add_fundtransfers',
			'edit_fundtransfers',
			'delete_fundtransfers',
			'confirm_fundtransfers',
			'add_banktrn',
		);
			$permissions['Head of HR'] = array(
			'HR Configurations',
			'Employee',
			'Leaves',
		);
		$permissions['HR Executive'] = array(
			'Employee',
			'Leaves',
		);
		$permissions['Assistant Manager'] = array(
					//branch configuration data
			'view_branch',
			'add_branch',
			'edit_branch',
			//Document configuration data
			'view_documenttyps',
			'add_documenttyps',
			'edit_documenttyps',
			'delete_documenttyps',
			'confirm_documenttyps',
			//Task configuration data
			'view_producttask',
			'add_producttask',
			'edit_producttask',
			'delete_producttask',
			'confirm_producttask',
			//downpayment configuration data
			'view_dplevels',
			'add_dplevels',
			'edit_dplevels',
			'delete_dplevels',
			'confirm_dplevels',
			// Finance rates
			'view_rates',
			'add_rates',
			'edit_rates',
			'delete_rates',
			'confirm_rates',
			//Real Estate Module******************************************************************************************************
			//Introducer  data
			'view_introducer',
			'add_introducer',
			'edit_introducer',
			'delete_introducer',
			'confirm_introducer',
			'view_supplier',
			'add_supplier',
			'edit_supplier',
			'delete_supplier',
			'confirm_supplier',
			//landdetails  data
			'view_land',
			'add_land',
			'edit_land',
			'delete_land',
			'confirm_land',
			'comment_land',
			//landdetails  data
			'view_project',
			'add_project',
			'edit_project',
			'delete_project',
			'confirm_project',
			'comment_project',
			//feasibility  data
			'view_feasibility',
			'add_feasibility',
			'edit_feasibility',
			'delete_feasibility',
			'confirm_feasibility',
			'comment_feasibility',
			'generate_evereport',
			'view_evereport',
			//project development module
			'add_lotdata',
			//project Payments
			'view_projectpayment',
			'add_projectpayment',
			'edit_projectpayment',
			'delete_projectpayment',
			'confirm_projectpayment',
			'comment_projectpayment',
			'generate_projectpayment',
			//customer  data
			'view_customer',
			'add_customer',
			'edit_customer',
			'delete_customer',
			'confirm_customer',
			//salesmen  data
			'view_salesmen',
			'add_salesmen',
			'edit_salesmen',
			'delete_salesmen',
			'confirm_salesmen',
			//reservation  data
			'view_reservation',
			'add_reservation',
			'edit_reservation',
			'delete_reservation',
			'confirm_reservation',
				//advance payment  data
				'add_advance',
			'delete_advance',
			//reservation  data
			'view_eploan',
			'add_eploan',
			'edit_eploan',
			'delete_eploan',
			'confirm_eploan',
			//edit reserved lot
			'edit_rslot',
			//reservation  data
			'view_documents',
			'edit_documents',
		
			'view_report',
			
				//Fund Transfers
			'view_fundtransfers',
			'add_fundtransfers',
			'edit_fundtransfers',
			'delete_fundtransfers',
			'confirm_fundtransfers',
			'add_banktrn',
		);
		$permissions['Head of finance'] = array(
						'view entry',
			'create entry',
			'edit entry',
			'delete entry',
			'print entry',
			'email entry',
			'download entry',
			'create ledger',
			'edit ledger',
			'delete ledger',
			'create group',
			'edit group',
			'delete group',
			'create tag',
			'edit tag',
			'delete tag',
			'view reports',
			'view log',
			'clear log',
			'change account ac_settings',
			'change stock ac_settings',
			'cf account',
			'cancel cheque',
			'backup account',
			'create chequebook',//Added By Udani
			'edit chequeboundle',
			'delete chequeboundle',
			'create recieptbook',
			'edit recieptboundle',
			'delete recieptboundle',
			'cancel recieptboundle',
			'cancel entry',
			'confirm entry',
			'add payments',
			'cancel payment',
			'edit paymententry',
			'delete paymententry',
			'add vouchers',
			'edit vouchers',
			'delete vouchers',
			'confirm vouchers',
			'create project',
			'edit project',
			'monthly report',
			'reprint',
			//Added by Eranga
			'confirm reciept',
			'create monthlyforcast',
		
// End Accounts module *******************************************************		
			'forms',
			'all_branch',
			'high_auth_comment',
			'manager_comment',
				'settlement_withoutfulldown',
			//branch configuration data
			'view_branch',
			'add_branch',
			'edit_branch',
			//Document configuration data
			'view_documenttyps',
			'add_documenttyps',
			'edit_documenttyps',
			'delete_documenttyps',
			'confirm_documenttyps',
			//Task configuration data
			'view_producttask',
			'add_producttask',
			'edit_producttask',
			'delete_producttask',
			'confirm_producttask',
			//downpayment configuration data
			'view_dplevels',
			'add_dplevels',
			'edit_dplevels',
			'delete_dplevels',
			'confirm_dplevels',
			// Finance rates
			'view_rates',
			'add_rates',
			'edit_rates',
			'delete_rates',
			'confirm_rates',
			//Real Estate Module******************************************************************************************************
			//Introducer  data
			'view_introducer',
			'add_introducer',
			'edit_introducer',
			'delete_introducer',
			'confirm_introducer',
			'view_supplier',
			'add_supplier',
			'edit_supplier',
			'delete_supplier',
			'confirm_supplier',
			//landdetails  data
			'view_land',
			'add_land',
			'edit_land',
			'delete_land',
			'confirm_land',
			'comment_land',
			//landdetails  data
			'view_project',
			'add_project',
			'edit_project',
			'delete_project',
			'confirm_project',
			'comment_project',
			//feasibility  data
			'view_feasibility',
			'add_feasibility',
			'edit_feasibility',
			'delete_feasibility',
			'confirm_feasibility',
			'comment_feasibility',
			'generate_evereport',
			'view_evereport',
			//project development module
			'add_lotdata',
			//project Payments
			'view_projectpayment',
			'add_projectpayment',
			'edit_projectpayment',
			'delete_projectpayment',
			'confirm_projectpayment',
			'comment_projectpayment',
			'generate_projectpayment',
			//customer  data
			'view_customer',
			'add_customer',
			'edit_customer',
			'delete_customer',
			'confirm_customer',
			//salesmen  data
			'view_salesmen',
			'add_salesmen',
			'edit_salesmen',
			'delete_salesmen',
			'confirm_salesmen',
			//reservation  data
			'view_reservation',
			'add_reservation',
			'edit_reservation',
			'delete_reservation',
			'confirm_reservation',
				//advance payment  data
				'add_advance',
			'delete_advance',
			//reservation  data
			'view_eploan',
			'add_eploan',
			'edit_eploan',
			'delete_eploan',
			'confirm_eploan',
			//edit reserved lot
			'edit_rslot',
			//reservation  data
			'view_documents',
			'edit_documents',
		
			'view_report',
			'add_banktrn',
				//Fund Transfers
			'view_fundtransfers',
			'add_fundtransfers',
			'edit_fundtransfers',
			'delete_fundtransfers',
			'confirm_fundtransfers',
			'add_banktrn',
			'confirm_resale'
		);
		$permissions['Assistant Account'] = array(
					'view entry',
			'create entry',
			'edit entry',
			'delete entry',
			'print entry',
			'email entry',
			'download entry',
			'create ledger',
			'edit ledger',
			'delete ledger',
			'create group',
			'edit group',
			'delete group',
			'create tag',
			'edit tag',
			'delete tag',
			'view reports',
			'view log',
			'clear log',
			'change account ac_settings',
			'change stock ac_settings',
			'cf account',
			'cancel cheque',
			'backup account',
			'create chequebook',//Added By Udani
			'edit chequeboundle',
			'delete chequeboundle',
			'create recieptbook',
			'edit recieptboundle',
			'delete recieptboundle',
			'cancel recieptboundle',
			'cancel entry',
			'confirm entry',
			'add payments',
			'cancel payment',
			'edit paymententry',
			'delete paymententry',
			'add vouchers',
			'edit vouchers',
			'delete vouchers',
			'confirm vouchers',
			'create project',
			'edit project',
			'monthly report',
			'reprint',
			//Added by Eranga
			'confirm reciept',
			'create monthlyforcast',
				'view_projectpayment',
			'add_projectpayment',
			'edit_projectpayment',
			'delete_projectpayment',
			'confirm_projectpayment',
			'comment_projectpayment',
			'generate_projectpayment',
			'view_fundtransfers',
			'add_fundtransfers',
			'edit_fundtransfers',
			'delete_fundtransfers',
			'confirm_fundtransfers',
			'add_banktrn',
			'view_reservation',
			'view_eploan',
			'confirm_resale'
		);
		$permissions['Land Sale Manager'] = array(
			'view_reservation',
			'view_eploan',
			'view_report',	
		);

		if ( ! isset($user_role))
			return FALSE;

		/* If user is administrator then always allow access */
		if ($user_role == "administrator")
			return TRUE;
			if ($user_role == "admin")
			return TRUE;
			if ($user_role == "re_manager")
			return TRUE;
				if ($user_role == "Head of finance")
			return TRUE;
			if ($user_role == "Directors")
			return TRUE;

		if ( ! isset($permissions[$user_role]))
			return FALSE;

		if (in_array($action_name, $permissions[$user_role]))
			return TRUE;
		else
			return FALSE;
	}
}
if ( ! function_exists('check_notification'))
{
	function check_notification()
	{
		$CI =& get_instance();
		$user_role = $CI->session->userdata('usertype');
		$permissions['Directors'] = array(
			'cm_tasktype',
			'cm_subtask',
			'cm_doctypes',
			're_introducerms',
			're_landms',
			're_projectms',
			're_eprebate',
			're_epresale',
		);
		$permissions['Head of Customer Care'] = array(
			're_eploan',
			're_resevation',
			'cm_customerms',
			're_epresale',
			're_epreschedule',
			're_adresale'
		);
		$permissions['Head of finance'] = array(
			'ac_entries',
			'ac_payvoucherdata',
			're_eploan',
			're_resevation',
			'cm_customerms',
			're_epresale',
			're_epreschedule',
			're_adresale'
			
		);
		$permissions['Assistant Accountant'] = array(
			'ac_entries',
			'ac_payvoucherdata',
			
		);
	

		if ( ! isset($user_role))
			return FALSE;

		/* If user is administrator then always allow access */
		

		if ( ! isset($permissions[$user_role]))
			return FALSE;

		else
		{
			$CI =& get_instance();
			$CI->load->model('common_model');
			$notifilist=NULL;
			
				
				$new_type = $CI->common_model->get_notification_count($permissions[$user_role]);
	
			return $new_type;
			   
			
		}
	}
}
if ( ! function_exists('check_notification_counter'))
{
	function check_notification_counter()
	{
		$CI =& get_instance();
		$user_role = $CI->session->userdata('usertype');
		$permissions['Directors'] = array(
			'cm_tasktype',
			'cm_subtask',
			'cm_doctypes',
			're_introducerms',
			're_landms',
			're_projectms',
			're_eprebate',
			're_epresale',
		);
		$permissions['Head of Customer Care'] = array(
			're_eploan',
			're_resevation',
			'cm_customerms',
			're_epresale',
			're_epreschedule',
			're_adresale'
		);
		$permissions['Head of finance'] = array(
			'ac_entries',
			'ac_payvoucherdata',
			're_eploan',
			're_resevation',
			'cm_customerms',
			're_epresale',
			're_epreschedule',
			're_adresale'
			
		);
		$permissions['Assistant Accountant'] = array(
			'ac_entries',
			'ac_payvoucherdata',
			
		);
	

		if ( ! isset($user_role))
			return FALSE;

		/* If user is administrator then always allow access */
		

		if ( ! isset($permissions[$user_role]))
			return FALSE;

		else
		{
			$CI =& get_instance();
			$CI->load->model('common_model');
			$notifilist=NULL;
			
				
				$new_type = $CI->common_model->get_notification_alert($permissions[$user_role]);
	
			return $new_type;
			   
			
		}
	}
}

if ( ! function_exists('check_mainmenu'))
{
	function check_mainmenu($action_name)
	{
		$CI =& get_instance();
		$user_role = $CI->session->userdata('usertype');
		
		$permissions['Project Officer'] = array(
			'Real Estate',
			'Recovery',
			'RE Reports',
		);
		$permissions['Cashier'] = array(
			'Cashier',
			'Recovery',
			'Real Estate',
		);
		$permissions['Legal Executive'] = array(
			'Customer',
			'Recovery',
			'Real Estate',
		);
		$permissions['Directors'] = array(
			'Real Estate',
			'Sale Staff',
			'Customer',
			'Reservation',
			'Payments',
			'Credit',
			'Recovery',
			'Documents',
			'RE Reports',
			'Employee',
			'Leaves',
			'Cashier',
			'Receipts',
			'Project Payments',
			'Payments',
			'Cancelations',
			'Journal',
			'ACC Reports',
			'Acc Payments'
		);
	
	$permissions['Receptionist'] = array(
			'Real Estate',
			'Recovery',
		
		);
	$permissions['Internal Audit Executive'] = array(
			'Real Estate',
			'Recovery',
			'RE Reports',
		
		);
	$permissions['Account Executive'] = array(
			'Project Payments',
			'Acc Payments',
			'Cancelations',
			'Journal',
			'ACC Reports',
			'Real Estate',
			'Recovery',
			
		);
		$permissions['Customer Care Executive'] = array(
			'Real Estate',
			'Sale Staff',
			'Customer',
			'Reservation',
			'Payments',
			'Credit',
			'Recovery',
			'Documents',
			'RE Reports',
	
		);
	$permissions['Head of Customer Care'] = array(
			'RE Configurations',
			'Real Estate',
			'Sale Staff',
			'Customer',
			'Reservation',
			'Payments',
			'Credit',
			'Recovery',
			'Documents',
			'RE Reports',
		);
			$permissions['Head of HR'] = array(
			'HR Configurations',
			'Employee',
			'Leaves',
		);
		$permissions['HR Executive'] = array(
			'Employee',
			'Leaves',
		);
		$permissions['Assistant Manager'] = array(
			'Real Estate',
			'Sale Staff',
			'Customer',
			'Reservation',
			'Credit',
			'Recovery',
			'Documents',
			'RE Reports',
		);
		$permissions['Head of finance'] = array(
		'RE Configurations',
			'Real Estate',
			'Sale Staff',
			'Customer',
			'Reservation',
			'Payments',
			'Credit',
			'Recovery',
			'Documents',
			'RE Reports',
		
		'HR Configurations',
			'Employee',
			'Leaves',
		
			'ACC Configurations',
			'Cashier',
			'Receipts',
			'Project Payments',
			'Payments',
			'Cancelations',
			'Journal',
			'ACC Reports',
			'Acc Payments',
		);
		$permissions['Assistant Account'] = array(
			'Cashier',
			'Receipts',
			'Project Payments',
			'Payments',
			'Cancelations',
			'Journal',
			'ACC Reports',
			'Recovery',
			'Real Estate',
			'Acc Payments',
		);
		$permissions['Land Sale Manager'] = array(
			'Recovery',
			'Real Estate',
			'Leaves',
		);
		$permissions['Head of IT/ IT Executive'] = array(
			'Employee',
			'Leaves',
		);
		if ( ! isset($user_role))
			return FALSE;

		/* If user is administrator then always allow access */
		if ($user_role == "administrator")
			return TRUE;
			if ($user_role == "re_manager")
			return TRUE;
				if ($user_role == "admin")
			return TRUE;
		if (in_array($action_name, $permissions[$user_role]))
			return TRUE;
			else
			return FALSE;
	}
}

if ( ! function_exists('check_submenu'))
{
	function check_submenu($action_name)
	{
		$CI =& get_instance();
		$user_role = $CI->session->userdata('usertype');
		$permissions['All'] = array(
			'Branch Details',
			'Document Types',
			'Product Tasks',
			'Land Sales DP Levels',
			'Finance Rates',
			'Loan Rates',
			'Real Estate Ledgers',
			'Suppliers',
			'Introducer Data',
			'Land Details',
			'Project Report Creation',
			'Project Reports',
			'Price List',
			'Block Inquiry',
			'Reserved Block Edit',
			'Project Officers',
			'Sales Officers',
			'Sales Forcast',
			'Create Customer',
			'Customer Letters',
			'Deed Transfer',
			'New Reservation',
			'Agreement Creation',
			'Reservation Resale',
			'Outright Settlments',
			'Ep Loans',
			'Advance Payments',
			'Other Charges',
			'Rental Payments',
			'Loan Details',
			'Reshedule',
			'Rebate',
			'Reprocess',
			'Loan Inquery',
			'Follow Ups',
			'Profit Realization',
			'Stock Report',
			'Collection Report',
			'Cost  Report',
			'Sales  Report',
			'Employment Type',
			'Designations',
			'Divisions',
			'Leave Category',
			'Allowances',
			'Deductions',
			'Company Loans',
			'EPF/ETF',
			'Paye',
			'Equipment Categories',
			'Divisonal Head',
			'Create Employee',
			'Employee List',
			'Employee Confirmation',
			'Equipment',
			'Transaction',
			'Salary',
			'Salary Changes',
			'Loan',
			'Payroll',
			'Leave List',
			'Income Entry',
			'Bank Deposits',
			'Advance Payments',
			'Other Charges',
			'Rental  Payments',
			'View Receipts',
			'Add New Receipts',
			'Project Payments',
			'Fund Transfers',
			'Make Payment',
			'Aproval',
			'Print',
			'View Journal',
			'Add New Journal',
			'Receipt Bundles',
			'Accounts',
			'Add Ledger',
			'Ledger Group',
			'confirm_resale'
		
			
		);
		$permissions['Project Officer'] = array(
			'Block Inquiry',
			'Loan Inquery',
			'Follow Ups',
			'Profit Realization',
			'Stock Report',
			'Collection Report',
			'Cost  Report',
			'Sales  Report',
			
		);
		$permissions['Cashier'] = array(
			'Block Inquiry',
			'Loan Inquery',
			'Income Entry',
			'Bank Deposits',
			'Advance Payments',
			'Other Charges',
			'Rental  Payments',
			'View Receipts',
			'Add New Receipts',
		);
		$permissions['Legal Executive'] = array(
	
			'Block Inquiry',
			'Deed Transfer',
			'Loan Inquery',
		);
		$permissions['Directors'] = array(
			'Introducer Data',
			'Land Details',
			'Project Report Creation',
			'Project Reports',
			'Price List',
			'Block Inquiry',
			'Reserved Block Edit',
			'Project Officers',
			'Sales Officers',
			'Sales Forcast',
			'Create Customer',
			'Customer Letters',
			'Deed Transfer',
			'New Reservation',
			'Agreement Creation',
			'Reservation Resale',
			'Outright Settlments',
			'Ep Loans',
			'Advance Payments',
			'Other Charges',
			'Rental Payments',
			'Loan Details',
			'Reshedule',
			'Rebate',
			'Reprocess',
			'Loan Inquery',
			'Follow Ups',
			'Profit Realization',
			'Stock Report',
			'Collection Report',
			'Cost  Report',
			'Sales  Report',
			'Employment Type',
			'Designations',
			'Divisions',
			'Leave Category',
			'Allowances',
			'Deductions',
			'Company Loans',
			'EPF/ETF',
			'Paye',
			'Equipment Categories',
			'Divisonal Head',
			'Create Employee',
			'Employee List',
			'Employee Confirmation',
			'Equipment',
			'Transaction',
			'Salary',
			'Salary Changes',
			'Loan',
			'Payroll',
			'Leave List',
			'Income Entry',
			'Bank Deposits',
			'Advance Payments',
			'Other Charges',
			'Rental  Payments',
			'View Receipts',
			'Add New Receipts',
			'Project Payments',
			'Fund Transfers',
			'Make Payment',
			'Aproval',
			'Print',
			'View Journal',
			'Add New Journal',
			'Receipt Bundles',
			'Accounts',
			'Add Ledger',
			'Ledger Group',
			'confirm_resale'
		);
	
	$permissions['Receptionist'] = array(
			'Block Inquiry',
			'Loan Inquery',
			'Follow Ups',
		);
	$permissions['Internal Audit Executive'] = array(
			'Block Inquiry',
			'Loan Inquery',
			'Follow Ups',
			'Profit Realization',
			'Stock Report',
			'Collection Report',
			'Cost  Report',
			'Sales  Report',
		
		);
	$permissions['Account Executive'] = array(
			'Block Inquiry',
			'Loan Inquery',
			'Project Payments',
			'Fund Transfers',
			'Make Payment',
			'Aproval',
			'Print',
			'View Journal',
			'Add New Journal',
			
		);
		$permissions['Customer Care Executive'] = array(
		
			'Price List',
			'Block Inquiry',
			'Sales Forcast',
			'Create Customer',
			'Customer Letters',
			'Deed Transfer',
			'New Reservation',
			'Agreement Creation',
			'Reservation Resale',
			'Outright Settlments',
			'Ep Loans',
			'Advance Payments',
			'Other Charges',
			'Rental Payments',
			'Loan Details',
			'Reshedule',
			'Rebate',
			'Reprocess',
			'Loan Inquery',
			'Follow Ups',
			'Profit Realization',
			'Stock Report',
			'Collection Report',
			'Cost  Report',
			'Sales  Report',
			
		
	
		);
	$permissions['Head of Customer Care'] = array(
				'Branch Details',
			'Document Types',
			'Product Tasks',
			'Land Sales DP Levels',
			'Finance Rates',
			'Loan Rates',
			'Real Estate Ledgers',
			'Suppliers',
			'Introducer Data',
			'Land Details',
			'Project Report Creation',
			'Project Reports',
			'Price List',
			'Block Inquiry',
			'Reserved Block Edit',
			'Project Officers',
			'Sales Officers',
			'Sales Forcast',
			'Create Customer',
			'Customer Letters',
			'Deed Transfer',
			'New Reservation',
			'Agreement Creation',
			'Reservation Resale',
			'Outright Settlments',
			'Ep Loans',
			'Advance Payments',
			'Other Charges',
			'Rental Payments',
			'Loan Details',
			'Reshedule',
			'Rebate',
			'Reprocess',
			'Loan Inquery',
			'Follow Ups',
			'Profit Realization',
			'Stock Report',
			'Collection Report',
			'Cost  Report',
			'Sales  Report',
			'confirm_resale'
			
		
		);
			$permissions['Head of HR'] = array(
	
			'Employment Type',
			'Designations',
			'Divisions',
			'Leave Category',
			'Allowances',
			'Deductions',
			'Company Loans',
			'EPF/ETF',
			'Paye',
			'Equipment Categories',
			'Divisonal Head',
			'Create Employee',
			'Employee List',
			'Employee Confirmation',
			'Equipment',
			'Transaction',
			'Salary',
			'Salary Changes',
			'Loan',
			'Payroll',
			'Leave List',
		
		
		);
		$permissions['HR Executive'] = array(
			
			'Create Employee',
			'Employee List',
			'Employee Confirmation',
			'Equipment',
			'Transaction',
			'Salary',
			'Salary Changes',
			'Loan',
			'Payroll',
			'Leave List',
		);
		$permissions['Assistant Manager'] = array(
			
			'Introducer Data',
			'Land Details',
			'Project Report Creation',
			'Project Reports',
			'Price List',
			'Block Inquiry',
			'Reserved Block Edit',
			'Project Officers',
			'Sales Officers',
			'Sales Forcast',
			'Create Customer',
			'Customer Letters',
			'Deed Transfer',
			'New Reservation',
			'Agreement Creation',
			'Reservation Resale',
			'Outright Settlments',
			'Ep Loans',
			'Advance Payments',
			'Other Charges',
			'Rental Payments',
			'Loan Details',
			'Reshedule',
			'Rebate',
			'Reprocess',
			'Loan Inquery',
			'Follow Ups',
			'Profit Realization',
			'Stock Report',
			'Collection Report',
			'Cost  Report',
			'Sales  Report',
			
		
		);
		$permissions['Head of finance'] = array(
		
				'Branch Details',
			'Document Types',
			'Product Tasks',
			'Land Sales DP Levels',
			'Finance Rates',
			'Loan Rates',
			'Real Estate Ledgers',
			'Suppliers',
			'Introducer Data',
			'Land Details',
			'Project Report Creation',
			'Project Reports',
			'Price List',
			'Block Inquiry',
			'Reserved Block Edit',
			'Project Officers',
			'Sales Officers',
			'Sales Forcast',
			'Create Customer',
			'Customer Letters',
			'Deed Transfer',
			'New Reservation',
			'Agreement Creation',
			'Reservation Resale',
			'Outright Settlments',
			'Ep Loans',
			'Advance Payments',
			'Other Charges',
			'Rental Payments',
			'Loan Details',
			'Reshedule',
			'Rebate',
			'Reprocess',
			'Loan Inquery',
			'Follow Ups',
			'Profit Realization',
			'Stock Report',
			'Collection Report',
			'Cost  Report',
			'Sales  Report',//customer care Head privilages
		
			'Employment Type',
			'Designations',
			'Divisions',
			'Leave Category',
			'Allowances',
			'Deductions',
			'Company Loans',
			'EPF/ETF',
			'Paye',
			'Equipment Categories',
			'Divisonal Head',
			'Create Employee',
			'Employee List',
			'Employee Confirmation',
			'Equipment',
			'Transaction',
			'Salary',
			'Salary Changes',
			'Loan',
			'Payroll',
			'Leave List',//HR head previlages
		
		
			'Income Entry',
			'Bank Deposits',
			'Advance Payments',
			'Other Charges',
			'Rental  Payments',
			'View Receipts',
			'Add New Receipts',
			'Project Payments',
			'Fund Transfers',
			'Make Payment',
			'Aproval',
			'Print',
			'View Journal',
			'Add New Journal',
			'Receipt Bundles',
			'Accounts',
			'Add Ledger',
			'Ledger Group',
			'confirm_resale'
		
		);
		$permissions['Assistant Account'] = array(
				'Income Entry',
			'Bank Deposits',
			'Advance Payments',
			'Other Charges',
			'Rental  Payments',
			'View Receipts',
			'Add New Receipts',
			'Project Payments',
			'Fund Transfers',
			'Make Payment',
			'Aproval',
			'Print',
			'View Journal',
			'Add New Journal',
			'Receipt Bundles',
			'Accounts',
			'Add Ledger',
			'Ledger Group',
				'Block Inquiry',
			'Loan Inquery',
			
		);
		$permissions['Land Sale Manager'] = array(
			'Recovery',
			'Real Estate',
			'Leaves',
		);
		$permissions['Head of IT/ IT Executive'] = array(
			'Create Employee',
			'Employee List',
			'Employee Confirmation',
		);
		if ( ! isset($user_role))
			return FALSE;

		/* If user is administrator then always allow access */
		if ($user_role == "administrator")
			return TRUE;

	if ($user_role == "re_manager")
			return TRUE;
				if ($user_role == "admin")
			return TRUE;
		if (in_array($action_name, $permissions[$user_role]))
			return TRUE;
			else
			return FALSE;
	}
}


/* End of file access_helper.php */
/* Location: ./system/application/helpers/access_helper.php */
