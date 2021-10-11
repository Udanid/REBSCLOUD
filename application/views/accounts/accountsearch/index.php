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
				$('#lotdata').delay(1).fadeIn(600);
						$( "#lotdata" ).load( "<?=base_url()?>accounts/accountsearch/get_blocklist/"+value);
		}
 }

 function check_value_selected()
 {
	
	
	amount=document.getElementById("amount").value;
	project=document.getElementById("project").value;
	rctno=document.getElementById("rctno").value;
	chequeno=document.getElementById("rctno").value;
	payeename=document.getElementById("payeename").value;
	entrynumber=document.getElementById("entrynumber").value;
	ledger_id=document.getElementById("ledger_id").value;
	
	var totstring=amount+project+rctno+chequeno+payeename+entrynumber
	
	
	
	ledger=document.getElementById("ledger_id");
	 var result ='';
  var options = ledger && ledger.options;
  var opt;

  for (var i=0, iLen=options.length; i<iLen; i++) {
    opt = options[i];

    if (opt.selected) {
     
	   result=opt.value+','+result;
    }
  }
  
  

	document.getElementById("ledgervalues").value=result;
	
	
	if( totstring=='')
	{
		  document.getElementById("checkflagmessage").innerHTML='Please select Amount ,Project, Receipt Number, Cheque Number or Payee name to Perform search'; 
					 $('#flagchertbtn').click();
		
	}
	else
	{
			 $('#searchpanelerror').delay(1).fadeOut(600);
		document.getElementById("advsearchform_accounts").submit(); 
	}
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
  <h3 class="title1">Advance Search Panel</h3>
       <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
       <div class="alert alert-danger" style="display:none;" role="alert"></div>
        <div class="form-title">
		<h4><a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</h4>
	</div>
     <form data-toggle="validator" id="advsearchform_accounts" method="post" action="<?=base_url()?>accounts/accountsearch/search"  enctype="multipart/form-data">
       <div class="form-body ">
        
       <div class="form-group">
         

    	<div class="col-sm-8">
        <input type="hidden" name="ledgervalues" id="ledgervalues">
         <label>Select Ledger</label> <br>
                	<select class="form-control"  multiple placeholder="Ledger"  name="ledger_id" id="ledger_id">
                    	  <?
                        foreach($ledgers as $data2){
						  echo '<option value="'.$data2->id.'"';
						 
						  echo '>'.$data2->gname.' - '.$data2->name.'</option>';
						}
						?>
                    </select>
              
                    
                </div>
                <div class="col-sm-4">
                <label>Entry Type</label><br>
                	<select class="form-control"   placeholder="entrytype"  name="type" id="type">
                    <option value=""> Select Entry Type</option>
                        <?
                        foreach($entrytype as $data2){
						  echo '<option value="'.$data2->id.'"';
						 
						  echo '>'.$data2->name.'</option>';
						}
						?>
                    </select>
              
                    
                </div>  <div class="clearfix"> </div><div class="clearfix"> </div><br>

              	<div class="col-sm-2 ">
                    <input type="text" name="fromdate" id="fromdate" placeholder="From Date" value="<?=$this->session->userdata('fy_start')?>"   class="form-control" autocomplete="off" >
                </div>
                <div class="col-sm-2 ">
                    <input type="text" name="todate" id="todate" placeholder="To Date"  class="form-control" autocomplete="off"  value="<?=$this->session->userdata('fy_end')?>" >
                </div>

                <div class="col-sm-2 ">
                    <input type="text" name="amount" id="amount"  placeholder="Amount"  class="form-control" autocomplete="off"  >
                </div>
                <div class="col-sm-4">
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
                <div class="col-sm-2 " id="lotdata">
                    <select class="form-control" placeholder="Lot" disabled name="lot" id="lot">
                    	<option value=""></option>
                    </select>
                </div><div class="clearfix"> </div><div class="clearfix"> </div><br>
                <div class="col-sm-2 ">
                    <input type="text" name="rctno" id="rctno"  placeholder="Receipt number"  class="form-control"  autocomplete="off" >
                </div>
                <div class="col-sm-2 ">
                    <input type="text" name="chequeno" id="chequeno"  placeholder="Cheque number"  class="form-control"  autocomplete="off" >
                </div>
                  <div class="col-sm-2 ">
                    <input type="text" name="payeename" id="payeename"  placeholder="Payee/ RCV Name "  class="form-control"  autocomplete="off" >
                </div>
                  <div class="col-sm-2 ">
                    <input type="text" name="entrynumber" id="entrynumber"  placeholder="Entry Number"  class="form-control"  autocomplete="off" >
                </div>
                <div class="clearfix"> </div><div class="clearfix"> </div><br>
				<div class="col-sm-2 " style="float:right; text-align:right;">
					<button type="button" class="btn btn-primary " onClick="check_value_selected()">Show</button>
                    <button type="button" class="btn btn-success" onClick="clearAll();">Clear</button></div>
				</div>
				<div class="clearfix"> </div><div class="clearfix"> </div>
                
                </div><form><br>
                
                <div > 
                <? if($recieptentrydata){?>
                
                  <div class="form-title">
					<h4>Receipt Details
                                 <span style="float:right"> </span></h4></div>
                
                	
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>No</th>
                            <th>Ledger Account</th>
                            <th>Receipt Number</th>
                             <th>Project Name</th>
                             
                                 <th>Lot Number</th>
                                    <th>customer Name</th>
                         
                            <th style="text-align:right;">Receipt Amount</th>
                           
                           
                            <th colspan="3"></th>
                        </tr>
                        </thead>
						<? $c=0; foreach ($recieptentrydata as $row)
                        {
                            
                            $current_entry_type = entry_type_info($row->entry_type);
                            if(empty($ledgervalues))$amount=$row->cr_total;
                            else $amount=$row->amount;
            
                        ?>
                        <tbody>
                            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
            
                        <?php
                            
                            echo "<td>" . date('Y-m-d',strtotime($row->date)). "</td>";
                            echo "<td>" ;?>
							
							<a href="javascript:load_detailpopup('<?=$current_entry_type['label']?>','<?=$row->id?>')" ><?=full_entry_number($row->entry_type, $row->number)?></a>
							<?  echo"</td>";
            
                            echo "<td>";
                            echo $this->Tag_model->show_entry_tag($row->tag_id);
                            echo $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
                            echo "</td>";
                            echo "<td>" . $row->RCTNO . "</td>";
                              echo "<td>" . $row->project_name . "</td>";
                                echo "<td>" . $row->lot_number . "</td>";
                                 echo "<td>" . $row->rcvname . "</td>";
                          
                            echo "<td align=right>" . number_format($amount, 2, '.', ',') . "</td>";
                            
                            
                            
                            
                            
                            
                            }?>
                          </tbody></table>                           


     <? }?>
   
     <? if($paymentdata){?>
                
                  <div class="form-title success">
					<h4>Payment Details
                                 <span style="float:right"> </span></h4></div>
                
                
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>No</th>
                            <th>Ledger Account</th>
                            <th>Cheque</th>
                             <th>Project Name</th>
                             
                              
                                    <th>Payee Name</th>
                         
                            <th style="text-align:right;">Pay Amount</th>
                           
                           
                            <th colspan="3"></th>
                        </tr>
                        </thead>
						<? $c=0; foreach ($paymentdata as $row)
                        {
                            
                            $current_entry_type = entry_type_info($row->entry_type);
                            if(empty($ledgervalues))$amount=$row->cr_total;
                            else $amount=$row->amount;
            
                        ?>
                        <tbody>
                            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
            
                        <?php
                            
                            echo "<td>" . date('Y-m-d',strtotime($row->date)). "</td>";
                            echo "<td>" ;?>
							
							<a href="javascript:load_detailpopup('<?=$current_entry_type['label']?>','<?=$row->id?>')" ><?=full_entry_number($row->entry_type, $row->number)?></a>
							<?  echo"</td>";
            
            
                            echo "<td>";
                            echo $this->Tag_model->show_entry_tag($row->tag_id);
                            echo $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
                            echo "</td>";
                            echo "<td>" . $row->CHQNO . "</td>";
                              echo "<td>" . $row->project_name . "</td>";
                            
                                 echo "<td>" . $row->payeename . "</td>";
                          
                            echo "<td align=right>" . number_format($amount, 2, '.', ',') . "</td>";
                            
                            
                            
                            
                            
                            
                            }?>
                          </tbody></table>                          


     <? }?>
      <? if($otherdata){?>
                
                  <div class="form-title">
					<h4>Other Entries
                                 <span style="float:right"> </span></h4></div>
                
                
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>No</th>
                            <th>Ledger Account</th>
                            <th>Entry Type</th>
                             <th>Project Name</th>
                             
                              
                                    <th>Lot Number</th>
                         
                            <th style="text-align:right;"> Amount</th>
                           
                           
                            <th colspan="3"></th>
                        </tr>
                        </thead>
						<? $c=0; foreach ($otherdata as $row)
                        {
                            
                            $current_entry_type = entry_type_info($row->entry_type);
                            if(empty($ledgervalues))$amount=$row->cr_total;
                            else $amount=$row->amount;
            
                        ?>
                        <tbody>
                            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
            
                        <?php
                            
                            echo "<td>" . date('Y-m-d',strtotime($row->date)). "</td>";
                             echo "<td>" ;?>
							
							<a href="javascript:load_detailpopup('<?=$current_entry_type['label']?>','<?=$row->id?>')" ><?=full_entry_number($row->entry_type, $row->number)?></a>
							<?  echo"</td>";
            
                            echo "<td>";
                            echo $this->Tag_model->show_entry_tag($row->tag_id);
                            echo $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
                            echo "</td>";
                            echo "<td>" . $row->name . "</td>";
                              echo "<td>" . $row->project_name . "</td>";
                            
                                 echo "<td>" . $row->lot_number . "</td>";
                          
                            echo "<td align=right>" . number_format($amount, 2, '.', ',') . "</td>";
                            
                            
                            
                            
                            
                            
                            }?>
                          </tbody></table>                            


     <? }?>
   
   
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
