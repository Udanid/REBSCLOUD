<!DOCTYPE HTML>
<html>
<head>

<script src="<?=base_url()?>media/js/dist/Chart.bundle.js"></script>
<script src="<?=base_url()?>media/js/utils.js"></script>
<?
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
<script type="text/javascript">
jQuery(document).ready(function() {
 	$("#prj_id").chosen({
     allow_single_deselect : true
    });
});
function load_currentchart(id)
{
	var list=document.getElementById('projectlist').value;
	var res = list.split(",");
	//alert(document.getElementById('estimate'+id).value)
	//$('#canvas'+res[i]).delay(1).fadeIn(1000);
	document.getElementById("chartset").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
	$( "#chartset" ).load( "<?=base_url()?>re/home/mychart/"+id );
}
</script>

<style type="text/css">

@media(max-width:1920px){
	.topup{
	margin-top:0px;
}
}
@media(max-width:360px){
	.topup{
	margin-top:0px;
}
}
@media(max-width:790px){
	.topup{
	margin-top:100px;
}
}
@media(max-width:768px){
	.topup{
	margin-top:-10px;
}
}
</style> 

<div id="page-wrapper" >
	<div class="main-page container-fluid" >
        <!-- Begin Page Content -->

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h3 class="title1">Dashboard</h3>
          </div>

          <!-- Content Row -->
          <div class="row">
			<? if(get_task_status_percentage($this->session->userdata('userid'),'completed')){?>
            <div class="col-xl-3 col-md-6 mb-4">
              <? if(get_task_status_percentage($this->session->userdata('userid'),'completed') <= 30){?>
                  <div class="card border-left-danger shadow h-100 py-2">
              <? }else if (get_task_status_percentage($this->session->userdata('userid'),'completed') <= 50){?>
                  <div class="card border-left-warning shadow h-100 py-2">
              <? }else if (get_task_status_percentage($this->session->userdata('userid'),'completed') <= 70){?>
                  <div class="card border-left-info shadow h-100 py-2">
              <? }else if (get_task_status_percentage($this->session->userdata('userid'),'completed') < 100){?>
                  <div class="card border-left-success shadow h-100 py-2">
             <? }else if (get_task_status_percentage($this->session->userdata('userid'),'completed') == 100){?>
                  <div class="card border-left-primary shadow h-100 py-2">
              <? }?>
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <? if(get_task_status_percentage($this->session->userdata('userid'),'completed') <= 30){?>
                          <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Task Completion</div>
                      <? }else if (get_task_status_percentage($this->session->userdata('userid'),'completed') <= 50){?>
                          <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Task Completion</div>
                      <? }else if (get_task_status_percentage($this->session->userdata('userid'),'completed') <= 70){?>
                          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Task Completion</div>
                      <? }else if (get_task_status_percentage($this->session->userdata('userid'),'completed') < 100){?>
                          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Task Completion</div>
                     <? }else if (get_task_status_percentage($this->session->userdata('userid'),'completed') == 100){?>
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Task Completion</div>
                      <? }?>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=get_task_status_percentage($this->session->userdata('userid'),'completed'); //wip helper funtion?>%</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                          	<? if(get_task_status_percentage($this->session->userdata('userid'),'completed') <= 30){?>
                            	<div class="progress-bar bg-danger" role="progressbar" style="width: <?=get_task_status_percentage($this->session->userdata('userid'),'completed'); //wip helper funtion?>%" aria-valuenow="<?=get_task_status_percentage($this->session->userdata('userid'),'completed'); //wip helper funtion?>" aria-valuemin="0" aria-valuemax="100"></div>
                            <? }else if (get_task_status_percentage($this->session->userdata('userid'),'completed') <= 50){?>
                            	<div class="progress-bar bg-warning" role="progressbar" style="width: <?=get_task_status_percentage($this->session->userdata('userid'),'completed'); //wip helper funtion?>%" aria-valuenow="<?=get_task_status_percentage($this->session->userdata('userid'),'completed'); //wip helper funtion?>" aria-valuemin="0" aria-valuemax="100"></div>
                            <? }else if (get_task_status_percentage($this->session->userdata('userid'),'completed') <= 70){?>
                            	<div class="progress-bar bg-info" role="progressbar" style="width: <?=get_task_status_percentage($this->session->userdata('userid'),'completed'); //wip helper funtion?>%" aria-valuenow="<?=get_task_status_percentage($this->session->userdata('userid'),'completed'); //wip helper funtion?>" aria-valuemin="0" aria-valuemax="100"></div>
                            <? }else if (get_task_status_percentage($this->session->userdata('userid'),'completed') < 100){?>
                            	<div class="progress-bar bg-success" role="progressbar" style="width: <?=get_task_status_percentage($this->session->userdata('userid'),'completed'); //wip helper funtion?>%" aria-valuenow="<?=get_task_status_percentage($this->session->userdata('userid'),'completed'); //wip helper funtion?>" aria-valuemin="0" aria-valuemax="100"></div>
                           <? }else if (get_task_status_percentage($this->session->userdata('userid'),'completed') == 100){?>
                           		<div class="progress-bar bg-primary" role="progressbar" style="width: <?=get_task_status_percentage($this->session->userdata('userid'),'completed'); //wip helper funtion?>%" aria-valuenow="<?=get_task_status_percentage($this->session->userdata('userid'),'completed'); //wip helper funtion?>" aria-valuemin="0" aria-valuemax="100"></div>
                            <? }?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <? }?>
            
             <? if(get_expired_tasks($this->session->userdata('userid'))){?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Expired Tasks</div>
                      <div class="h5 mb-0 font-weight-bold red-800"><?=get_expired_tasks($this->session->userdata('userid')); //wip helper funtion?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<? }?>
            
            <? if(get_pending_task_aaprovals($this->session->userdata('userid'))){?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Incoming Task Approvals</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=get_pending_task_aaprovals($this->session->userdata('userid')); //wip helper funtion?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<? }?>
            
            <? if(get_pending_tasks($this->session->userdata('userid'))){?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pending Outgoing Task Approvals</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=get_pending_tasks($this->session->userdata('userid')); //wip helper funtion?></div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
            <? }?>
          </div>
		
          <!-- Content Row -->

          <div class="row">
			
             <div class="col-xl-8 col-lg-7">

              <!-- Project Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Project Wise Task Completion</h6>
                </div>
                <div class="card-body">
                  <? if($task_projects){
						foreach($task_projects as $data){  
							$completion = get_project_task_completion($this->session->userdata('userid'),$data->prj_id); //wip helper function
							if($completion != 0){
				  ?>
                  				<h4 class="small font-weight-bold"><?=$data->prj_name?> <span class="float-right"><?=$completion?>%</span></h4>
                            	<div class="progress mb-4">
                                	<? if($completion <= 30){?>
                              			<div class="progress-bar bg-danger" role="progressbar" style="width: <?=$completion?>%" aria-valuenow="<?=$completion?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    <? }else if($completion <= 50){?>
                                    	<div class="progress-bar bg-warning" role="progressbar" style="width: <?=$completion?>%" aria-valuenow="<?=$completion?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    <? }else if($completion <= 70){?>
                                    	<div class="progress-bar" role="progressbar" style="width: <?=$completion?>%" aria-valuenow="<?=$completion?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    <? }else if($completion < 100){?>
                                    	<div class="progress-bar bg-info" role="progressbar" style="width: <?=$completion?>%" aria-valuenow="<?=$completion?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    <? }else if($completion == 100){?>
                                    	<div class="progress-bar bg-success" role="progressbar" style="width: <?=$completion?>%" aria-valuenow="<?=$completion?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    <? }?>
                            	</div>
                  <?
							}
						}
				     }
				  ?>
                </div>
              </div>
           </div>
            
            <?
            //Pie Chart data
			$completed = get_task_status_percentage($this->session->userdata('userid'),'completed'); //wip helper function
			$ongoing = get_task_status_percentage($this->session->userdata('userid'),'processing'); //wip helper function
			$pending = get_task_status_percentage($this->session->userdata('userid'),'pending'); //wip helper function
			$expired = get_task_status_percentage($this->session->userdata('userid'),'expired'); //wip helper function
			?>
            
            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Task Summary</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Completed
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Ongoing
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Pending
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-dark"></i> Expired
                    </span>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
     </div>
</div>
      <!-- End of Main Content -->
 <link href="<?=base_url()?>media/css/sb-admin-2.css" rel="stylesheet">
  <!-- Core plugin JavaScript-->
  <script src="<?=base_url()?>media/js/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?=base_url()?>media/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?=base_url()?>media/js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?=base_url()?>media/js/chart-area-demo.js"></script>
  <script>
	  // Set new default font family and font color to mimic Bootstrap's default styling
	  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
	  Chart.defaults.global.defaultFontColor = '#858796';
	  
	  // Pie Chart Example
	  var ctx = document.getElementById("myPieChart");
	  var myPieChart = new Chart(ctx, {
		type: 'doughnut',
		data: {
		  labels: ["Completed", "Ongoing", "Pending", "Expired"],
		  datasets: [{
			data: [<?=$completed?>, <?=$ongoing?>, <?=$pending?>,<?=$expired?>],
			backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#666666'],
			hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#333333'],
			hoverBorderColor: "rgba(234, 236, 244, 1)",
		  }],
		},
		options: {
		  maintainAspectRatio: false,
		  tooltips: {
			backgroundColor: "rgb(255,255,255)",
			bodyFontColor: "#858796",
			borderColor: '#dddfeb',
			borderWidth: 1,
			xPadding: 15,
			yPadding: 15,
			displayColors: false,
			caretPadding: 10,
		  },
		  legend: {
			display: false
		  },
		  cutoutPercentage: 80,
		},
	  });
  </script>
<!--footer-->
<?
	$this->load->view("includes/footer");
?>
