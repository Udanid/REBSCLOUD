
<? ?>
<title><?=solutionname?> - <?=solutionfull?></title>
<meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
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
<!-- //chart -->
<!--Calender-->
<link rel="stylesheet" href="<?=base_url()?>media/css/clndr.css" type="text/css" />
<script src="<?=base_url()?>media/js/underscore-min.js" type="text/javascript"></script>
<script src= "<?=base_url()?>media/js/moment-2.2.1.js" type="text/javascript"></script>
<script src="<?=base_url()?>media/js/clndr.js" type="text/javascript"></script>
<script src="<?=base_url()?>media/js/site.js" type="text/javascript"></script>
     <script src="<?=base_url()?>media/js/jquery-ui.min.js"></script>
<!--End Calender-->
<!-- Metis Menu -->
<script src="<?=base_url()?>media/js/metisMenu.min.js"></script>
<script src="<?=base_url()?>media/js/custom.js"></script>
<link href="<?=base_url()?>media/css/custom.css" rel="stylesheet">
<link href="<?=base_url()?>media/css/pagination.css" rel="stylesheet">

<!--//Metis Menu -->
<script type="text/javascript">

function loadsearch(itemcode)
{ 
var code=itemcode.split("-")[0];
//alert("<?=base_url().$searchpath?>/"+code)
if(code!=''){
	//alert(code)
	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url().$searchpath?>/"+code );}
	
}
function loadsearch_encript(itemcode)
{
	if(itemcode!=''){
	window.location="<?=base_url().$searchpath?>/"+itemcode;
	}
}
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
            <div class="navbar-collapse"  >
          
				<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1" >
                
					<ul class="nav" id="side-menu" >
						<li>
							<a href="<?=base_url()?>re/home" class="active"><i class="fa fa-home nav_icon"></i>Dashboard</a>
						</li>
						<li>
							<a href="#"><i class="fa fa-cogs nav_icon"></i>Configurations <span class="nav-badge">12</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?=base_url()?>config/branch/showall">Branch Details</a>
								</li>
								<li>
									<a href="<?=base_url()?>config/documents/showall">Document Types</a>
								</li>
                                <li>
									<a href="<?=base_url()?>config/producttasks/showall">Product Tasks</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>config/dplevels/showall">Land Sales DP Levels</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>config/rates/showall">Finance Rates</a>
								</li>
                                  <li>
									<a href="<?=base_url()?>config/rates/loan_rates">Loan Rates</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>config/rates/re_ledgers">Real Estate Ledgers</a>
								</li>
                               
                                 <li>
									<a href="<?=base_url()?>config/supplier/showall">Suppliers</a>
								</li>
							</ul>
							<!-- /nav-second-level -->
						</li>
						<li class="">
							<a href="#"><i class="fa fa-briefcase nav_icon"></i>Real Estate <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="<?=base_url()?>re/introducer/showall">Introducer Data</a>
								</li>
                                
								<li>
									<a href="<?=base_url()?>re/land/showall">Land Details</a>
								</li>
                                <li>
									<a href="<?=base_url()?>re/project/showall">Project Report Creation</a>
								</li>
                                <li style="display:none">
									<a href="<?=base_url()?>re/feasibility/showall">Project Report Creation</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/feasibility/evaluation">Project Reports</a>
								</li>
                               
								<li>
									<a href="<?=base_url()?>re/lotdata/showall">Price List</a>
								</li>
                                <li>
									<a href="<?=base_url()?>re/lotdata/lot_inquiry">Block Inquiry</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/lotdata/edit_lot">Reserved Block Edit</a>
								</li>
                              
								
							</ul>
							<!-- //nav-second-level -->
						</li>
                        <li>
							<a href="#"><i class="fa fa-line-chart nav_icon"></i>Sales<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                             <li>
									<a href="<?=base_url()?>re/sales/po">Project Officers</a>
								</li>
								 <li>
									<a href="<?=base_url()?>re/salesmen/showall">Sales Officers</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/sales/showall">Sales Forcast</a>
								</li>
                                </ul>
                                </li>	
					
						<li>
                          <li>
							<a href="#"><i class="fa fa-users nav_icon"></i>Customer<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
								<li>
									<a href="<?=base_url()?>re/customer/showall">Create Customer </a>
								</li>
                                <li>
									<a href="<?=base_url()?>re/customerletter/showall">Customer Letters </a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/deedtransfer/">Deed Transfer </a>
								</li>
                                </ul>
                                </li>	
					
						<li>
							<a href="#"><i class="fa fa-pencil-square-o nav_icon"></i>Reservation<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
								
                                <li>
									<a href="<?=base_url()?>re/reservation/newreservation">New Reservation </a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/reservation/showall">Payment Plan</a>
								</li>
                               
                                 <li>
									<a href="<?=base_url()?>re/reservation/resale">Reservation Resale </a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/reservation/sold">Outright Settlments </a>
								</li>
                                <li>
									<a href="<?=base_url()?>re/reservation/eploans">Ep Loans </a>
								</li>
								
                              
							</ul>
						</li>
                          <li class="">
							<a href="#"><i class="fa fa-dollar nav_icon"></i>Payments <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								 <li>
									<a href="<?=base_url()?>re/reservation/payments">Advance Payments</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/reservation/chargers">Other Charges</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/eploan/monthly_rental">Rental Payments </a>
								</li>
                              
								
							</ul>
							<!-- //nav-second-level -->
						</li>
                      
						<li>
							<a href="<?=base_url()?>re/eploan/showall" ><i class="fa fa-money nav_icon"></i>Credit<span class="fa arrow"></span></a>
                             <ul class="nav nav-second-level collapse">
								<li>
									<a href="<?=base_url()?>re/eploan/showall">Loan Details</a>
								</li>
                                <li>
									<a href="<?=base_url()?>re/eploan/loan_inquarymain">Loan Inquery</a>
								</li>
                                <li>
									<a href="<?=base_url()?>re/eploan/follow_up">Follow Ups </a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/eploan/reschedule">Reshedule </a>
								</li>
                                <li>
									<a href="<?=base_url()?>re/eploan/rebate">Rebate (Early Settlements )</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/eploan/resale">Reprocess </a>
								</li>
                                 
                               
								
                              
							</ul>
						</li>
                        <li>
							<a href="<?=base_url()?>re/documents/showall" class="chart-nav"><i class="fa fa-file nav_icon"></i>Documents </a>
						</li>
						<li>
							<a href="#" class="chart-nav"><i class="fa fa-bar-chart nav_icon"></i>Reports <span class="fa arrow"></span></a>
                              <ul class="nav nav-second-level collapse">
                              <li>
									<a href="<?=base_url()?>re/report/profit">Profit Realization</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/report/stock">Stock Report</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/report/collection">Collection Report</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/report/provition">Cost  Report</a>
								</li>
                                 <li>
									<a href="<?=base_url()?>re/report/sales">Sales  Report</a>
								</li>
                                </ul>
						</li>
					</ul>
					<!-- //sidebar-collapse -->
				</nav>
			</div>
		</div>
         <div id="popupform" style="display:none"></div>