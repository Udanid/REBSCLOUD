<!DOCTYPE HTML>
<html>
<head>

<?
$this->load->model('Ledger_model');
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_accounts");

?>
<link rel="stylesheet" href="<?=base_url()?>media/css/yearpicker.css" />
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<script type="text/javascript">

 $( function() {
    $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
	 $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );
  $(document).ready(function() {
  $("#ledger_id").chosen({
     allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select an Instance"
    });
	 $("#type").chosen({
     allow_single_deselect : true,
	 width: '100%',
    });
	$("#project").chosen({
     allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select a Project"
    });
	$("#lot").chosen({
     allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select a Lot"
    });
  });
  function clearAll(){
	$("#month").val('').trigger("chosen:updated");
	$('#fromdate').val('');
	$('#todate').val('');
	$('#amount').val('');
	$('#project').val('');
	$('#rctno').val('');
	$('#chequeno').val('');
	$('#payeename').val('');
}
function load_detailpopup(type,id)
{

				$('#popupform').delay(1).fadeIn(600);
				alert("<?=base_url()?>accounts/entry/view_popup/"+type+"/"+ id);
				$( "#popupform" ).load( "<?=base_url()?>accounts/entry/view_popup/"+type+"/"+ id);

}

</script>
<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>
<script>
$(document).ready(function(){
      $('#create_excel').click(function(){

		
		   $("#ledger_table").find("tr.ledgername").first().children("th:nth-child(1)").text(string);

           $(".table2excel").table2excel({
                exclude: ".noExl",
                name: "Ledger Statement",
                filename: "Ledger_Statement.xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });

			$('.ledgername').html('');

      });

	

	/*var availableTags2 = [];

	  $( "#project" ).autocomplete({
      		source: availableTags2
    	});*/


 });

function getLedgerReportall(){
	var month = $('#month').val();
	var year = $('#year').val();
	if(month == '00'){
		$('.alert').css('display', 'block');
		$('.alert').html('Please Select Month');
	}else{
		$('.alert').css('display', 'none');
		window.open( "<?=base_url()?>accounts/report/all_ledgerst/"+year+"/"+month );
	}
}

 function loadLots(value){
	// alert(value)
		if(value!='')
		{
			lot=document.getElementById("lot").value;
				$('#lotdata').delay(1).fadeIn(600);
						$( "#lotdata" ).load( "<?=base_url()?>accounts/auditreport/get_blocklist/"+value);
						$('#resdata').delay(1).fadeIn(600);
						$( "#resdata" ).load( "<?=base_url()?>accounts/auditreport/get_reservation/"+value+'/'+lot);
		}
 }
 function loadreservations(){
	// alert(value)
	project=document.getElementById("project").value;
	lot=document.getElementById("lot").value;
		if(project!='')
		{
				$('#resdata').delay(1).fadeIn(600);
						$( "#resdata" ).load( "<?=base_url()?>accounts/auditreport/get_reservation/"+project+'/'+lot);
		}
 }

 function check_value_selected()
 {
	
	project=document.getElementById("project").value;
	lot=document.getElementById("lot").value;
	res_code=document.getElementById("res_code").value;
	todate=document.getElementById("todate").value;
	
	
	alert(res_code);
	$('#searchdtetails_audit').delay(1).fadeIn(600);
	$( "#searchdtetails_audit" ).load( "<?=base_url()?>accounts/auditreport/search/"+project+"/"+lot+"/"+res_code+"/"+todate);
	
	
 }
</script>
<style>
	.tableFixHead { overflow-y: auto; height: 400px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
</style>
<div id="page-wrapper">
 <div class="main-page">
  <h3 class="title1">Real Estate Audit Report</h3>
       <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
       <div class="alert alert-danger" style="display:none;" role="alert"></div>
        <div class="form-title">
		<h4><a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</h4>
	</div>
     <form data-toggle="validator" id="advsearchform_accounts" method="post" action="<?=base_url()?>accounts/accountsearch/search"  enctype="multipart/form-data">
       <div class="form-body ">
        
       <div class="form-group">
         

    	
                <div class="col-sm-3">
                	<select class="form-control" placeholder="Project" onChange="loadLots(this.value);" name="project" id="project">
                    	<option value=""> Select Project</option>
                        <?
                        foreach($projects as $data2){
						  echo '<option value="'.$data2->prj_id.'"';
						
						  echo '>'.$data2->project_name.'</option>';
						}
						?>
                    </select>
                </div>
                <div class="col-sm-3 " id="lotdata">
                    <select class="form-control" placeholder="Lot"  name="lot" id="lot">
                    	<option value="ALL"></option>
                    </select>
                </div>
                 <div class="col-sm-3 " id="resdata">
                    <select class="form-control" placeholder="Reservation"  name="res_code" id="res_code">
                    	<option value="ALL">Select Reservation</option>
                    </select>
                </div>
                <div class="col-sm-3 ">
                    <input type="text" name="todate" id="todate" placeholder="To Date" readonly  class="form-control" autocomplete="off"  value="<?=date('Y-m-d')?>" >
                </div>
            	<div class="col-sm-3 " >
					<button type="button" class="btn btn-primary " onClick="check_value_selected()">Search</button>
              </div>
				</div>
				<div class="clearfix"> </div><div class="clearfix"> </div>
                
                </div><form><br>
                <div id="searchdtetails_audit"></div>
                
               
   
   </div>
   
   
   
    <div class="col-md-4 modal-grids">
						<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
						<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-sm">
								<div class="modal-content"> 
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
										<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4> 
									</div> 
									<div class="modal-body" id="checkflagmessage">
									</div>
								</div>
							</div>
						</div>
					</div>
                    
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>re/customer/delete/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            
              $("#complexConfirm_confirm").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					
                    window.location="<?=base_url()?>re/customer/confirm/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            </script> 
   
   
   
</div> </div>
        <div class="row calender widget-shadow"  style="display:none">
            <h4 class="title">Calender</h4>
            <div class="cal1">

            </div>
        </div>



        <div class="clearfix"> </div>
    </div>
</div>

<script src="<?=base_url()?>media/js/yearpicker.js"></script>
<script>
  $(document).ready(function() {
	$(".yearpicker").yearpicker({
	  year: <?=date('Y')?>,
	  startYear: 2017,
	});
  });
</script>
<script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
	</script>
		<!--footer-->
<?php
	$this->load->view("includes/footer");
?>
