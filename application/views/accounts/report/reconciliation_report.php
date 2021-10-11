<!DOCTYPE HTML>
<html>
<head>
 

<? 
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_accounts");
?>

 <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
  $("#ledger_id").chosen({
     allow_single_deselect : true
    });
	 $("#date").chosen({
     allow_single_deselect : true
    });
  });
</script>
<script>

function getFiles(){
	var account = document.getElementById("ledger_id").value; //get textbox value ledgerid
	
	//get a list of pdf files
	$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/report/getReports';?>',
            data: {ledger_id:account },
            success: function(data) {
                $("#dates").html('');
				$("#dates").html(data);
            }
        });
}

function getReport(val){
	var account = document.getElementById("ledger_id").value; //get textbox value ledgerid
	var date = val;
	//generate pdf link
	$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/report/reconciliationReport';?>',
            data: {ledger_id:account,date:date },
            success: function(data) {
                $("#download").html('');
				$("#download").html(data);
            }
        });
}
</script>
<!-- start wrapper -->                      
<div id="page-wrapper">
	<!-- start mainpage -->   
	<div class="main-page">
  		<h3 class="title1">Bank Reconciliation Report</h3>
        <!-- start widget --> 	
        <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
        	<div class="form-title">

			</div>
      		<? $this->load->view("includes/flashmessage");?>
            <!-- start form body --> 
       		<div class="form-body ">
       			<div class="form-group">
          			<div class="col-sm-6"> 
                    	<div class="row">
                        	<div class="col-sm-3 ">
                            	 <? $js = 'id="ledger_id" onchange="javascript:getFiles();"';
									echo form_input_ledger('ledger_id', '', $js, $type = 'reconciliation');?>
                            </div> 
                        </div>
                        <div class="row">
                        	<div class="col-sm-4 ">
                            	<span id="dates">
									<select class="form-control"   placeholder="Select Date" name="date" id="date" onchange="javascript:getReport();">
                                            <option value="">Select Date</option>
                                    </select>
                                
                                </span>
                                <br>
                                <span id="download"></span>
                            </div>
                        </div>
					</div> 
                       
                </div>
            </div>                                
			<div class="clearfix"> </div><div class="clearfix"> </div>	
	
            <div class="clearfix"> </div><br><br>
            <div class="row">
            	<span id="report"></span>
            </div>
    
         <!-- finish widget --> 
         </div>
        <div class="clearfix"> </div>
        <!-- finish mainpage --> 
    </div>
   <!-- finish wrapper --> 
</div>
		<!--footer-->
<?php
	$this->load->view("includes/footer");
?>
										
                                    
                              
											
						
                        
                        
                        
			