<?
	$this->load->view("includes/header");
$this->load->view("includes/topbar_normal");
?>
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="row-one">
					<div class="col-md-4 widget">
						<div class="stats-left ">
							<h5>Today Sales</h5>
							<h4>Cash </h4>
						</div>
						<div class="stats-right">
                        
							<label> <?=number_format($cashcount,2)?></label>
						</div>
						<div class="clearfix"> </div>	
					</div>
					<div class="col-md-4 widget states-mdl">
						<div class="stats-left">
							<h5>Today Sales</h5>
							<h4>Credit </h4>
						</div>
						<div class="stats-right">
							<label> <?=number_format($creditcount,2)?></label>
						</div>
						<div class="clearfix"> </div>	
					</div>
					<div class="col-md-4 widget states-last">
						<div class="stats-left">
							<h5>Today</h5>
							<h4>PO Total</h4>
						</div>
						<div class="stats-right">
							<label><?=number_format($posum,2)?></label>
						</div>
						<div class="clearfix"> </div>	
					</div>
					<div class="clearfix"> </div>	
				</div>
				
			
				<div class="row calender widget-shadow">
					<h4 class="title">Calender</h4>
					<div class="cal1">
						
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>