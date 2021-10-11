<!doctype html>
<html lang="en">	<?php ob_start();
ini_set('display_errors', '0');
?> <title><?=solutionname?> - <?=solutionfull?></title>
<meta name="robots" content="noindex">
<meta name="googlebot" content="noindex">
<meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<link href="<?=base_url()?>media/css/material-color.css" rel="stylesheet">
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
<script src="<?=base_url()?>media/js/jquery.dropdown.js"> </script>
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
      <div class="navbar-collapse"  style="z-index:2000px;" >
      
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1" style="overflow:scroll;">
		
          <div id="remenu" class="topmenubar" style="margin-top:-15px;">
            <?
				 $dataset=get_user_modules($this->session->userdata('usertype'));
				 $width=100/count($dataset);
				
				  if($dataset){ foreach($dataset as $raw){?>
               
                <a  href="<?=base_url()?>menu_call/showdata/<?=$raw->menu_name?>" class="topmenuitem <? if($this->session->userdata('usermodule')==$raw->menu_name) {?> topmenuitem_active<? }?>" style=" width:<?=$width?>%;"><?=$raw->short_code?></a>
                    <? }}?>
             </div>

            <ul class="nav" id="side-menu">
               <?
				$CI =& get_instance();
				$CI->load->model('accesshelper_model');
			  $mainmenu=$CI->accesshelper_model->get_module_main_menu_module_code($this->session->userdata('usermodule'));?>
					<ul class="nav" id="side-menu" >
                        <? if($mainmenu){
						foreach($mainmenu as $raw){ 
							if (check_mainmenu($raw->main_id)){
								if($raw->url!='#') $url=base_url().$raw->url;
								else $url=$raw->url;?>
                        <li>
							<a href="<?=$url?>"><i class="<?=$raw->color?> fa <?=$raw->icon?> nav_icon"></i><?=$raw->menu_name?> <? if($url=='#') echo'<span class="fa arrow"></span>';?></a>
                            <? 
							$sublist=$CI->accesshelper_model->get_main_sub_menu($raw->main_id);
							if($sublist){?>
                            <ul class="nav nav-second-level collapse">
                            <?
								foreach($sublist as $subraw){
									if($subraw->url!='#') $url=base_url().$subraw->url;
								else $url=$subraw->url;
								if (check_submenu($subraw->sub_id)){?>
							<li>
									<a href="<?=$url?>"><?=$subraw->sub_name?></a>
								</li>
							
							
                            <? }}?> </ul><? }?>
						</li>
                        
                    <?  }}}?>

        </ul><br><br><br><br>
        <!-- //sidebar-collapse -->
      </nav>
    </div>
  </div>
  <div id="popupform" style="display:none"></div>
   <script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
</script>
<style>
	.tableFixHead { overflow-y: auto; height: 600px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     {  }
</style>