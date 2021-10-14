
<!DOCTYPE HTML>
<html>
<head>
<title><?=solutionname?> <?=solutionfull?></title>
<meta name="robots" content="noindex">
<meta name="googlebot" content="noindex">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css'/>
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<link href="<?php echo base_url();?>media/images/favicon.png" rel="shortcut icon" rev="shortcut icon">
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
		<div class="sticky-header header-section ">
      <!--  <h3  style=" position:absolute; width:100%; text-align:center; top:20px;">Inventory and Sales Management System</h3>
      -->
			<div class="header-left" >
				<!--toggle button start-->
				<button id="showLeftPush"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<!--logo -->
				<div class="logo">
					<a href="index.php">
						<img src="<?=base_url()?>media/images/logo2.png" />
					</a>
				</div>

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
			<div class="main-page login-page " style="margin-top:100px; margin-bottom:100px;" >
            
            <?  
			
			if($logo!='' || $logo!=NULL){ ?>
				<h3 class="title1"><img src="<?=base_url()?>uploads/company_logo/<?=$logo?>" style="width:250px;"> </h3>
               <? }  else { ?>
               
               	<h3 class="title1"><img src="<?=base_url()?>media/images/rebslogo.jpg"> </h3>
           
               <? }?>
            
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
						<form action="<?=base_url()?>login/login_initialte" style="font-size:15px;" method="post" id="login-form">
                        <input type="hidden"  value="<?=$company_code?>" id="companycode" name="companycode" placeholder="Companycode" required autocomplete="off">
							<input type="text" class="user" id="username" style="color:#666;" name="username" placeholder="Username" value="<?=$this->session->userdata('thisusername');?>" required autocomplete="off">
                            
							<input type="password" name="password" id="password" style="color:#666;" class="lock" value="<?=$this->session->userdata('password');?>" placeholder="Password">
                      		<?php //echo $widget;?>
							<?php //echo $script;?>
							<input type="submit" name="Sign In" value="Sign In" id='submit'>
                         
							<div class="forgot-grid">
								<!--/*<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>Remember me</label>*/-->
								<div class="forgot">
									<a href="<?=base_url()?>login/recover">Forgot password?</a>
								</div>
								<div class="clearfix"> </div>
							</div>
						</form>
					</div>
				</div>


			</div>
		</div>
		<!--footer-->
		<div class="footer"  style="background-color:#000; height:75px; position:fixed; bottom:0;" >
		   <p>&copy; <?=date('Y')?> <?=solutionname?> <?=solutionfull?>. All Rights Reserved | Powered by <a href="http://rebserp.com/" target="_blank"><?=provider?></a> | Customised for <?=companyname?> </p>
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
</body>
</html>
