
<!DOCTYPE HTML>
<html>
<head>
<title><?=solutionname?>-<?=solutionfull?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<link rel='shortcut icon' rev="shortcut icon" href="<?=base_url()?>media/images/favicon.png">
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
<link href="<?=base_url()?>media/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="<?=base_url()?>media/js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- Metis Menu -->
<script src="<?=base_url()?>media/js/metisMenu.min.js"></script>
<script src="<?=base_url()?>media/js/custom.js"></script>
<link href="<?=base_url()?>media/css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
<style>
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
    color:#888;
    opacity: 0.5; /* Firefox */
}
</style>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!--left-fixed -navigation-->
	<!--	<div class=" sidebar" role="navigation">
            <div class="navbar-collapse">
				<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
					
					<div class="clearfix"> </div>
					
				</nav>
			</div>
		</div>-->
		<!--left-fixed -navigation-->
		<!-- header-starts -->
		<div class="sticky-header header-section" style="background:#09F;">
      <!--  <h3  style=" position:absolute; width:100%; text-align:center; top:20px;">Inventory and Sales Management System</h3>
      -->   
			<div class="header-left">
				<!--toggle button start-->
				
				<!--toggle button end-->
				<!--logo -->
				
                 
				<!--//logo-->
				<!--search-box-->
              
				<!--//end-search-box-->
				<div class="clearfix"> </div>
			</div><br>
            
			<div class="header-right">
				
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper2">
			<div class="main-page login-page " style="margin-top:5%; margin-bottom:100px; width:30%;" >
				<div align="center" style="padding:20px;"><a href="" target="_blank"><img class="img-responsive" src="<?=base_url()?>media/images/logo.png"></a></div>
				<div class="widget-shadow">
					<div class="login-body">
					  <div id="messageBoard">
						<?php 
						if($this->session->flashdata('msg') != ''){ ?>
							<div class="alert alert-success  fade in">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<?php echo $this->session->flashdata('msg'); ?>
							</div>
						<?php
						$this->session->sess_destroy();
						} ?>
						<?php 
						if($this->session->flashdata('error') != ''){ ?>
							<div class="alert alert-danger  fade in">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<?php echo $this->session->flashdata('error'); ?>
							</div>
						<?php
						} ?>
                        
					  </div>
						<form action="<?=base_url()?>login/recover" style="font-size:15px;" method="post" id="login-form">
							<input type="text" class="user" name="username" style="color:#666;" id="username" placeholder="Provide Username Here" value="<?=$this->session->userdata('thisusername');?>" required autocomplete="off">
                      		<?php //echo $widget;?>
							<?php //echo $script;?>
							<input type="submit" value="RESET">
							<div class="forgot-grid">
								<!--/*<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>Remember me</label>*/-->
								<div class="forgot">
									<a href="<?=base_url()?>login"><< Back to Login</a>
								</div>
								<div class="clearfix"> </div>
						</form>
					</div>
				</div>
				
				
			</div>
		</div>
		<!--footer-->
		<div class="footer"  style="background-color:#333; height:75px; font-size:14px; position:fixed; bottom:0px;">
		   <p style="color:#fff; padding-top:10px;">&copy; <?=date('Y')?> <?=solutionname?> <?=solutionfull?>. All Rights Reserved | Developed by <a href="http://beit.lk/" target="_blank"><?=provider?></a> | Customised for <?=companyname?></p>
		</div>
        
        <!--//footer-->
	</div>
    
	<!-- Classie -->
		<script src="<?=base_url()?>media/js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			
			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!--scrolling js-->
	<script src="<?=base_url()?>media/js/jquery.nicescroll.js"></script>
	<script src="<?=base_url()?>media/js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="<?=base_url()?>media/js/bootstrap.js"> </script>
   <script>
	$( document ).ready(function() {
		var username = document.getElementById("username").value;
		if(username!=''){
			document.getElementById("password").focus();
		}else{
			document.getElementById("username").focus();
		}
	});
	</script>
</body>
</html>