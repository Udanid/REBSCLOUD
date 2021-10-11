	<?php ob_start();
ini_set('display_errors', '0');
?> <title><?=solutionname?> - <?=solutionfull?></title>
<meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="<?=base_url()?>media/css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
 <!-- js-->
<script src="<?=base_url()?>media/js/jquery-1.11.1.min.js"></script>
<script src="<?=base_url()?>media/js/modernizr.custom.js"></script>
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<script src="<?=base_url()?>media/js/chosen.jquery.js"></script>
<script src="<?=base_url()?>media/js/jquery.validationEngine.js"></script>
<script src="<?=base_url()?>media/js/chosen.jquery.js"></script>
<script src="<?=base_url()?>media/js/scriptvalidator.js"></script>
<link rel="stylesheet" href="<?=base_url()?>media/css/validationEngine.jquery.css" media="screen" type="text/css" >
<link rel="stylesheet" href="<?=base_url()?>media/css/jquery-ui.min.css">
 <link rel="stylesheet" href="<?=base_url()?>media/css/clndr.css" type="text/css" />
<link rel="stylesheet" href="<?=base_url()?>media/css/chosen.css" type="text/css" />

<link href="<?=base_url()?>media/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="<?=base_url()?>media/js/wow.min.js"></script>
	<script>
		 new WOW().init();
		 
		 
		 
	</script>
<!--//end-animate-->
<!-- chart -->
<script src="<?=base_url()?>media/js/Chart.js"></script>
<!-- //chart -->
<!--Calender-->
<link rel="stylesheet" href="<?=base_url()?>media/css/clndr.css" type="text/css" />
<script src="<?=base_url()?>media/js/underscore-min.js" type="text/javascript"></script>
<script src= "<?=base_url()?>media/js/moment-2.2.1.js" type="text/javascript"></script>
     <script src="<?=base_url()?>media/js/jquery-ui.min.js"></script>
<!--End Calender-->
<!-- Metis Menu -->
<script src="<?=base_url()?>media/js/metisMenu.min.js"></script>
<script src="<?=base_url()?>media/js/custom.js"></script>
<link href="<?=base_url()?>media/css/custom.css" rel="stylesheet">
<link href="<?=base_url()?>media/css/pagination.css" rel="stylesheet">

<!--//Metis Menu -->
<script type="text/javascript">



function closepo()
{
	$('#popupform').delay(1).fadeOut(800);
}
function loadpage(path)
{
	//alert(path)
	$( "#page-wrapper" ).load( "<?=base_url()?>"+path );
}
jQuery(document).ready(function() {
  
$("#input-31").chosen({
     allow_single_deselect : true
    });
 
 
	
});
 
</script>

  <script>
  
  </script>
</head>
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!--left-fixed -navigation-->
		<div class=" sidebar" role="navigation" >
            <div class="navbar-collapse" >
				<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
                
                 <div id="remenu" class="topmenubar">  
                <a href="<?=base_url()?>menu_call/showdata/re" class="topmenuitem ">RE</a>
                <a href="<?=base_url()?>menu_call/showdata/hr" class="topmenuitem">HR</a>
                 <a href="<?=base_url()?>menu_call/showdata/accounts" class="topmenuitem  topmenuitem_active">ACCOUNTS</a></div>
                
					<ul class="nav" id="side-menu">
						<li>
							<a href="<?=base_url()?>user/" class="active"><i class="fa fa-home nav_icon"></i>Dashboard</a>
						</li>
						
                       <? if (check_mainmenu('Cashier')){?>  <li>
							<a href="#"><i class="fa fa-file-text-o nav_icon"></i>Cashier <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
                             <li>
									<a href="<?=base_url()?>accounts/income">Income Entry</a>
								</li>
                                <li>
									<a href="<?=base_url()?>accounts/cashier/banktransfers">Bank Deposits</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>accounts/cashier/showall_reservation">Advance Payments</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>accounts/cashier/reservation_charges">Other Charges</a>
								</li>
                               
								<li>
									<a href="<?=base_url()?>accounts/cashier/monthly_rental">Rental  Payments</a>
								</li>
								
                               
                               
								
							</ul>
							<!-- /nav-second-level -->
						</li><? }?>
                      <? if (check_mainmenu('Receipts')){?>   <li>
							<a href="#"><i class="fa fa-file-text-o nav_icon"></i>Receipts <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?=base_url()?>accounts/entrymaster/index">View Receipts</a>
								</li>
								<li>
									<a href="<?=base_url()?>accounts/entrymaster/addreceipt/receipt">Add New Receipts</a>
								</li>
								<li>
									<a href="<?=base_url()?>accounts/receipt/cancel">Cancel Blank Receipt</a>
								</li>
								

							</ul>
							<!-- /nav-second-level -->
						</li><? }?>
                        <? if (check_mainmenu('Receipts')){?>   <li>
							<a href="#"><i class="fa fa-file-text-o nav_icon"></i>Cash Advance<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?=base_url()?>accounts/cashadvance/cashbooks">Cash Books</a>
								</li>
                                <li>
									<a href="<?=base_url()?>accounts/cashadvance/advancelist">Cash Advance</a>
								</li>
								<li>
									<a href="<?=base_url()?>accounts/cashadvance/settlement/">Advance Settlements</a>
								</li>
								<li>
									<a href="<?=base_url()?>accounts/receipt/cancel">External Settelment</a>
								</li>
								

							</ul>
							<!-- /nav-second-level -->
						</li><? }?>
                       <? if (check_mainmenu('Project Payments')){?>  <li>
							<a href="#"><i class="fa fa-file-text-o nav_icon"></i>Project Payments <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?=base_url()?>re/projectpayments/showall">Project Payments</a>
								</li>
                                <li>
									<a href="<?=base_url()?>re/fundtransfers/showall"> Fund Transfers</a>
								</li>
								

							</ul>
							<!-- /nav-second-level -->
						</li><? }?>
						
						
					<? if (check_mainmenu('Payments')){?> 	<li class="">
							<a href="#"><i class="fa fa-credit-card  nav_icon"></i>Payments<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
                            <li>
									<a href="<?=base_url()?>accounts/payments/add">Make Payment</a>
								</li>
                                <li>
									<a href="<?=base_url()?>accounts/payments">Approval</a>
								</li>
								<li>
									<a href="<?=base_url()?>accounts/paymentvouchers">Print</a>
								</li>
								
								

                                
								
							</ul>
							<!-- /nav-second-level -->
						</li><? }?>
                        </li><? }?>
						<? if (check_mainmenu('Fixed Asset')){?> 	<li class="">
							<a href="#"><i class="fa fa-credit-card  nav_icon"></i>Fixed Asset<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?=base_url()?>accounts/Fixedasset">Fixed Asset Category</a>
								</li>
								<li>
									<a href="<?=base_url()?>accounts/Fixedasset/fixedasset_item">Fixed Assets</a>
								</li>

							</ul>
							<!-- /nav-second-level -->
						</li><? }?>
						<? if (check_mainmenu('Payments')){?>
							<li class="">
								<a href="#"><i class="fa fa-credit-card  nav_icon"></i>External Loans<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level collapse">
									<li>
										<a href="<?=base_url()?>accounts/loan">Loan</a>
									</li>
									<li>
										<a href="<?=base_url()?>accounts/loan/approval">Loan Approvals</a>
									</li>
									<li>
										<a href="<?=base_url()?>accounts/loan/shedule">Loan shedule</a>
									</li>
									<li>
										<a href="<?=base_url()?>accounts/loan/due_installment">Due Installments</a>
									</li>
									<li>
										<a href="<?=base_url()?>accounts/loan/payment">Loan payment</a>
									</li>

								</ul>
								<!-- /nav-second-level -->
							</li><? }?>
						<? if (check_mainmenu('Cancelations')){?> <li>
							<a href="<?=base_url()?>accounts/entry/index/cancel"><i class="fa fa-file-text-o nav_icon"></i>Cancellations </a>
							
							<!-- /nav-second-level -->
						</li><? }?>
                        	<? if (check_mainmenu('Cancelations')){?> <li>
							<a href="<?=base_url()?>accounts/report/reconciliation/all"><i class="fa fa-file-text-o nav_icon"></i>Bank Reconciliation </a>
							
							<!-- /nav-second-level -->
						</li><? }?><? if (check_mainmenu('Payments')){?> 
                           <li>
									<a href="<?=base_url()?>config/supplier/showall"><i class="fa fa-file-text-o nav_icon"></i>Vendor Creation</a>
								</li><? }?>
                      <? if (check_mainmenu('Journal')){?>   <li>
							<a href="#"><i class="fa fa-file-text-o nav_icon"></i>Journal <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?=base_url()?>accounts/entry/index/journal">View Journal</a>
								</li>
								<li>
									<a href="<?=base_url()?>accounts/entry/add/journal">Add New Journal</a>
								</li>

							</ul>
							<!-- /nav-second-level -->
						</li><? }?>
                       
						<? if (check_mainmenu('ACC Configurations')){?> <li>
							<a href="#"><i class="fa fa-cog nav_icon"></i>Settings<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?=base_url()?>accounts/receipt">Receipt Bundles</a>
								</li>
								<!--<li>
									<a href="< ?=base_url()?>accounts/cheque">Cheque Bundle</a>
								</li>-->
                                <li>
									<a href="<?=base_url()?>accounts/account">Accounts</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>accounts/cashadvance/showall">Cash Book Configuration</a>
								</li>
                               <!-- <li>
									<a href="< ?=base_url()?>accounts/masteraccounts"> Master Accounts</a>
								</li>-->
								<li>
									<a href="<?=base_url()?>accounts/ledger">Add Ledger</a>
								</li>
								<li>
									<a href="<?=base_url()?>accounts/group">Ledger Group</a>
								</li>
							</ul>
							<!-- //nav-second-level -->
						</li><? }?>
					
					
						
						<? if (check_mainmenu('ACC Reports')){?> <li>
							<a href="#"><i class="fa fa-bar-chart nav_icon"></i>Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
								<li>
									<a href="<?=base_url()?>accounts/report/ac_ledgerst">Ledger Statement </a>
								</li>
                                <li>
									<a href="<?=base_url()?>accounts/report/balancesheet">Balance Sheet</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>accounts/report/trialbalance">Trial Balance</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>accounts/report/profitandloss">Profit and  Loss</a>
								</li>
                                </ul>
						</li><? }?>
					</ul>
					<!-- //sidebar-collapse -->
				</nav>
			</div>
		</div>
         <div id="popupform" style="display:none"></div>