<!DOCTYPE HTML>
<html>
<head>
<? 
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_accounts");
?>

 <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
 <!-- table sorting-->
   <script type="text/javascript" src="<?=base_url()?>media/js/tableManager.js"></script>
   <script type="text/javascript" src="<?=base_url()?>media/js/tableManager2.js"></script>
   <link href="<?=base_url()?>media/css/tablemanager.css" rel="stylesheet"> 

<script type="text/javascript">
  $(document).ready(function() {
  $("#ledger_id").chosen({
     allow_single_deselect : true,
	 width:'250px'
    });
	 $("#month").chosen({
     allow_single_deselect : true
    });
	
  });
</script>
<script>
function getTransactions(val){
	var checkedValue = $( 'input[name="show_all"]:checked' ).val(); //get checkbox value showall
	var account = document.getElementById("ledger_id").value; //get textbox value ledgerid
	var fromdate = document.getElementById("fromdate").value; //get textbox value fromdate
	var todate = document.getElementById("todate").value; //get textbox value fromdate
	var amount = document.getElementById("amount").value; //get textbox value amount
	var chequeno = document.getElementById("chequeno").value; //get textbox value cheque no
	var entryno = document.getElementById("entryno").value; //get textbox value entryno
	$('.hidetrans').attr('checked', false) //untick hidden transaction checkbox if ticked
	//document.getElementById("show_all").disabled= false; //enable checkbox showall if disabled
	
	  //get all debit values from controller and write html to #debit div
	  $.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/reconciliation/getAlldebit';?>',
            data: {ledger_id:account,showall:checkedValue,fromdate:fromdate,todate:todate,amount:amount,chequeno:chequeno,entryno:entryno },
            success: function(data) {
                $("#debit").html('');
				$("#debit").html(data);
				$('.datepick').each(function(){
				  $(this).datepicker({dateFormat: 'yy-mm-dd'});
			    });
				/*$('.tablemanager').tablemanager({
						firstSort: [[3,0],[2,0],[1,'asc']],
						//disable: ["last"],
						appendFilterby: true,
						dateFormat: [[2,"yyyy-mm-dd"]],
						debug: true,
						//vocabulary: {
						//voc_filter_by: 'Filter By',
						//voc_type_here_filter: 'Filter...',
						//voc_show_rows: 'Rows Per Page'
						//},
						pagination: false,
						//showrows: [5,10,20,50,100],
						disableFilterBy: [1]
				}); */
            }
        });
		
		//get all credit values from controller and write html to #credit div
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/reconciliation/getAllcredit';?>',
            data: {ledger_id:account,showall:checkedValue,fromdate:fromdate,todate:todate,amount:amount,chequeno:chequeno,entryno:entryno },
            success: function(data) {
                $("#credit").html('');
				$("#credit").html(data);
				$('.datepick').each(function(){
				  $(this).datepicker({dateFormat: 'yy-mm-dd'});
			    });
				/*$('.tablemanager2').tablemanager2({
						firstSort: [[3,0],[2,0],[1,'asc']],
						//disable: ["last"],
						appendFilterby: true,
						dateFormat: [[2,"yyyy-mm-dd"]],
						debug: true,
						//vocabulary: {
						//voc_filter_by: 'Filter By',
						//voc_type_here_filter: 'Filter...',
						//voc_show_rows: 'Rows Per Page'
						//},
						pagination: false,
						//showrows: [5,10,20,50,100],
						disableFilterBy: [1]
				}); */
            }
        });
		
		//get updated balances and write html to #balance div
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/reconciliation/getBalances';?>',
            data: {ledger_id:account,showall:checkedValue,fromdate:fromdate,todate:todate,amount:amount,chequeno:chequeno,entryno:entryno },
            success: function(data) {
                $("#balance").html('');
				$("#balance").html(data);
            }
        });

        //get CR and CR
        $.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/reconciliation/getCrdr';?>',
            data: {ledger_id:account,showall:checkedValue,fromdate:fromdate,todate:todate,amount:amount,chequeno:chequeno,entryno:entryno },
            success: function(data) {
                $("#crdr").html('');
                if(checkedValue=='1'){
					$("#crdr").html('');
				}else{
					
					$("#crdr").html(data);
				}
            }
        });
		
		//create refresh button and write html to #refresh div
		$("#refresh").html('');
		$("#refresh").html('<a href="#" onclick="javascript:getTransactions();"><i class="fa fa-refresh" aria-hidden="true"></i></a>');
}

//when tick on check boxes
function updateCheckedval(val){
	var checkedstatus = document.getElementById(val).checked; //get each checked trasaction
	var account = document.getElementById("ledger_id").value; //get the value of text field ledger_id
	var hideTrans = $( 'input[name="show_month"]:checked' ).val(); //get the status of checkbox show_month
	
	//update checked transactions and redirect to other functions, depend on hide or not hide
	$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/reconciliation/updateCheckedval';?>',
            data: {entry_item_id:val,checkedval:checkedstatus,ledger_id:account },
            success: function(data) {
               //  alert(data);
			   if(hideTrans==1){ //if hide transactions check box is checked
				   hideTransactions();
				}else{
					getTransactions();
				}
			   
            }
        });
	return false;
}

//when hide transactions check box is checked
function hideTransactions(){
	
	var checkedValue = $( 'input[name="show_all"]:checked' ).val(); //get checkbox value showall
	var account = document.getElementById("ledger_id").value; //get textbox value ledgerid
	var hideTrans = $( 'input[name="show_month"]:checked' ).val(); //get the status of checkbox show_month
	
	if (hideTrans==1){ //if hide transactions check box is checked
		
		document.getElementById("show_all").disabled= true; //disable show_all checkbox
		
		//get all debit transactions for this month only
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/reconciliation/getAlldebit/thismonth';?>',
            data: {ledger_id:account,showall:checkedValue },
            success: function(data) {
                $("#debit").html('');
				$("#debit").html(data);
				/* $('.tablemanager').tablemanager({
						firstSort: [[3,0],[2,0],[1,'asc']],
						//disable: ["last"],
						appendFilterby: true,
						dateFormat: [[2,"yyyy-mm-dd"]],
						debug: true,
						//vocabulary: {
						//voc_filter_by: 'Filter By',
						//voc_type_here_filter: 'Filter...',
						//voc_show_rows: 'Rows Per Page'
						//},
						pagination: false,
						//showrows: [5,10,20,50,100],
						disableFilterBy: [1]
				});*/
            }
        });
		
		//get all credit transactions for this month only
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/reconciliation/getAllcredit/thismonth';?>',
            data: {ledger_id:account,showall:checkedValue },
            success: function(data) {
                $("#credit").html('');
				$("#credit").html(data);
				/*$('.tablemanager2').tablemanager2({
						firstSort: [[3,0],[2,0],[1,'asc']],
						//disable: ["last"],
						appendFilterby: true,
						dateFormat: [[2,"yyyy-mm-dd"]],
						debug: true,
						//vocabulary: {
						//voc_filter_by: 'Filter By',
						//voc_type_here_filter: 'Filter...',
						//voc_show_rows: 'Rows Per Page'
						//},
						pagination: false,
						//showrows: [5,10,20,50,100],
						disableFilterBy: [1]
				});*/
            }
        });
		
		//get all balances
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/reconciliation/getBalances';?>',
            data: {ledger_id:account,showall:checkedValue },
            success: function(data) {
                $("#balance").html('');
				$("#balance").html(data);
            }
        });
		
	}else{
		//if hide transactions check box is unchecked
		document.getElementById("show_all").disabled= false; //enable show all checkbox
		getTransactions(); 
	}
	
}

//when click on reconsile button
function recosiletransactions(){
	
	var account = document.getElementById("ledger_id").value; //get textbox value ledgerid
	var date = document.getElementById("date").value; //report date
	var checkedValue = $( 'input[name="show_all"]:checked' ).val(); //get checkbox value showall
	var hideTrans = $( 'input[name="show_month"]:checked' ).val(); //get the status of checkbox show_month
	
	var clearedtotal = document.getElementById("clearedtotal").value;
	var totaltoclear = document.getElementById("totaltoclear").value;
	
	var bankBalance = document.getElementById("bankbalance").value; //get textbox value bankbalance
	bankBalance = bankBalance.replace(/\,/g,'')
	//alert(clearedtotal);	
	//alert(totaltoclear);
	if(clearedtotal!=totaltoclear){
		alert('Cleared total must be equal to total to clear!');
		return;
	}
	
	if (hideTrans==1){ //if hide transactions checked
		document.getElementById("reconsile_butn").disabled = true;
		//reconsile all transactions for this month and update transactions tables
		$.ajax({
			  cache: false,
			  type: 'POST',
			  url: '<?php echo base_url().'accounts/reconciliation/reconsileSelected/thismonth';?>',
			  data: {ledger_id:account,showall:checkedValue,date:date,bankBalance:bankBalance },
			  success: function(data) {
				  $("#debit").html('');
				  $("#debit").html(data);
				  /*$('.tablemanager').tablemanager({
						firstSort: [[3,0],[2,0],[1,'asc']],
						//disable: ["last"],
						appendFilterby: true,
						dateFormat: [[2,"yyyy-mm-dd"]],
						debug: true,
						//vocabulary: {
						//voc_filter_by: 'Filter By',
						//voc_type_here_filter: 'Filter...',
						//voc_show_rows: 'Rows Per Page'
						//},
						pagination: false,
						//showrows: [5,10,20,50,100],
						disableFilterBy: [1]
				});*/
				  //get all credit transactions for this month only
				  $.ajax({
					  cache: false,
					  type: 'POST',
					  url: '<?php echo base_url().'accounts/reconciliation/getAllcredit/thismonth';?>',
					  data: {ledger_id:account,showall:checkedValue },
					  success: function(data) {
						  $("#credit").html('');
						  $("#credit").html(data);
						  /*$('.tablemanager2').tablemanager2({
								  firstSort: [[3,0],[2,0],[1,'asc']],
								  //disable: ["last"],
								  appendFilterby: true,
								  dateFormat: [[2,"yyyy-mm-dd"]],
								  debug: true,
								  //vocabulary: {
								  //voc_filter_by: 'Filter By',
								  //voc_type_here_filter: 'Filter...',
								  //voc_show_rows: 'Rows Per Page'
								  //},
								  pagination: false,
								  //showrows: [5,10,20,50,100],
								  disableFilterBy: [1]
						  });*/
						   //get all balances
						  $.ajax({
							  cache: false,
							  type: 'POST',
							  url: '<?php echo base_url().'accounts/reconciliation/getBalances/';?>',
							  data: {ledger_id:account,showall:checkedValue,date:date },
							  success: function(data) {
								  $("#balance").html('');
								  $("#balance").html(data);
								  //show completed status with time delay
								  $("#complete").html('<a href="#" onclick="javascript:hideTransactions()">Completed</a>');
								  document.getElementById("reconsile_butn").disabled = false;
							  }
						  });
					  }
				  });
			  }
		  });
		  
	}else{
		document.getElementById("reconsile_butn").disabled = true;
		
		//reconsile all  transactions and update transactions tables
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/reconciliation/reconsileSelected/no';?>',
            data: {ledger_id:account,showall:checkedValue,date:date,bankBalance:bankBalance },
            success: function(data) {
				//alert(data);
                $("#debit").html('');
				$("#debit").html(data);
				/* $('.tablemanager').tablemanager({
						firstSort: [[3,0],[2,0],[1,'asc']],
						//disable: ["last"],
						appendFilterby: true,
						dateFormat: [[2,"yyyy-mm-dd"]],
						debug: true,
						//vocabulary: {
						//voc_filter_by: 'Filter By',
						//voc_type_here_filter: 'Filter...',
						//voc_show_rows: 'Rows Per Page'
						//},
						pagination: false,
						//showrows: [5,10,20,50,100],
						disableFilterBy: [1]
				}); */
				//get all credit transactions for this month only
				$.ajax({
					cache: false,
					type: 'POST',
					url: '<?php echo base_url().'accounts/reconciliation/getAllcredit';?>',
					data: {ledger_id:account,showall:checkedValue },
					success: function(data) {
						$("#credit").html('');
						$("#credit").html(data);
						/*$('.tablemanager2').tablemanager2({
								  firstSort: [[3,0],[2,0],[1,'asc']],
								  //disable: ["last"],
								  appendFilterby: true,
								  dateFormat: [[2,"yyyy-mm-dd"]],
								  debug: true,
								  //vocabulary: {
								  //voc_filter_by: 'Filter By',
								  //voc_type_here_filter: 'Filter...',
								  //voc_show_rows: 'Rows Per Page'
								  //},
								  pagination: false,
								  //showrows: [5,10,20,50,100],
								  disableFilterBy: [1]
						  });*/
						 //get all balances
						  $.ajax({
							  cache: false,
							  type: 'POST',
							  url: '<?php echo base_url().'accounts/reconciliation/getBalances/';?>',
							  data: {ledger_id:account,showall:checkedValue,date:date },
							  success: function(data) {
								  $("#balance").html('');
								  $("#balance").html(data);
								  //show completed status with time delay
								  $("#complete").html('<a href="#" onclick="javascript:hideTransactions()">Completed</a>');
								  document.getElementById("reconsile_butn").disabled = false;
							  }
						  });
					}
				});
            }
        });	
	}
		
}

$( function() {
	
	 $('#fromdate').datepicker({dateFormat: 'yy-mm-dd',onSelect: function(selectedDate) {
		 var account = document.getElementById("ledger_id").value; //get textbox value ledgerid
		 document.getElementById("show_all").checked= false;
		 if(account!='0'){
            $('#todate').datepicker('option', 'minDate', selectedDate); //set todate mindate as fromdate
			date = $(this).datepicker('getDate');
        	var maxDate = new Date(date.getTime());
        	maxDate.setDate(maxDate.getDate() + 31); //add 31 days to from date
			$('#todate').datepicker('option', 'maxDate', maxDate);
            setTimeout(function() { $('#todate').focus(); }, 0);
		 }else{
			alert ('Please select a ledger account!'); 
			document.getElementById("fromdate").value= '';
		 }
      }});
      $('#todate').datepicker({dateFormat: 'yy-mm-dd',onSelect: function(selectedDate) {
		  	document.getElementById("show_all").checked= false;
            //$('#fromdate').datepicker('option', 'maxDate', selectedDate);
			document.getElementById("show_all").disabled= false; //enable checkbox
      }});
	  
	  $('#date').datepicker({dateFormat: 'yy-mm-dd'});
	  
});

function updateBankbalance(){
	var bankBalance = document.getElementById("bankbalance").value; //get textbox value bankbalance
	bankBalance = bankBalance.replace(/\,/g,'')
	var account = document.getElementById("ledger_id").value; //get textbox value ledgerid
	var bankopbalance = document.getElementById("bankopbalance").value;
	var totaltoclear = bankopbalance-bankBalance;
	//Update bank balance for ledger account
	$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/reconciliation/updateBankbalance';?>',
            data: {ledger_id:account,bankbalance:bankBalance },
            success: function(data) {
                document.getElementById("totaltoclear").value = data;
            }
        });
}

function enableshow(val){

	if(val != ''){
		document.getElementById("show_all").checked= false;
		document.getElementById("show_all").disabled= false; //enable checkbox
	}else{
		document.getElementById("show_all").checked= false;
		document.getElementById("show_all").disabled= true; //enable checkbox

	}
}

function updateBankeddate(entry_id,date){
	$.ajax({
		cache: false,
		type: 'POST',
		url: '<?php echo base_url().'accounts/reconciliation/updateBankeddate';?>',
		data: {entry_id:entry_id,date:date },
		success: function(data) {
		}
	});
}
</script>
<!-- start wrapper -->                      
<div id="page-wrapper">
	<!-- start mainpage -->   
	<div class="main-page">
  		<h3 class="title1">Bank Reconciliation </h3>
        <!-- start widget --> 	
        <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
        	<div class="form-title">
			<h4><a href="<?=base_url()?>accounts/report/download/ac_ledgerst/<?=$ledger_id?>"> <i class="fa fa-file-excel-o nav_icon"></i></a></h4>
			</div>
      		<? $this->load->view("includes/flashmessage");?>
            <!-- start form body --> 
       		<div class="form-body ">
              <?php
				$page_count = 0;
				
				echo form_open('accounts/report/reconciliation/' . $reconciliation_type . '/' . $ledger_id);
			  ?>
       			<div class="form-group">
          			<div class="col-sm-5"> 
				<?			
				$js = 'id="ledger_id" onchange="javascript:getTransactions(this.value);"';
				echo form_input_ledger('ledger_id', $ledger_id, $js, $type = 'reconciliation');
				echo "&nbsp;&nbsp;&nbsp;<span id='refresh'></span>";
				?> </div> 
                	<div class="col-sm-7 ">
                    	
                        	<div class="col-sm-1 "></div>
                            
                            <div class="col-sm-4 ">
                            	<input type="text" name="date" id="date" autocomplete="off" placeholder="Reconciliation Date" class="form-control" >
                            </div>
                            <div class="col-sm-5 ">
                            			<? 
											//create hide transactions checkbox
											$js1 = 'onchange="javascript:hideTransactions(this.value);" class="hidetrans"'; 
											echo form_checkbox('show_month', 1, FALSE,$js1) . " Hide Transactions After This Date";?>

											<? 
								  //create show_all anchor tag
								  $data = array(
									  'name'        => 'show_all',
									  'id'          => 'show_all',
									  'value'       => 1,
									  'checked'     => false,
									  'disabled'		=> true,
									  'onchange'	  => 'javascript:getTransactions(this.value)'
									  );
								  
								  echo form_checkbox($data). " Filter Transactions";
								  ?>
							</div>
                                  
					</div>
					<div class="clearfix"> </div>
					<br>
					<div class="col-sm-3 ">
                        <input type="text" name="fromdate" id="fromdate" autocomplete="off" placeholder="From Date"  class="form-control" >
                    </div>
                    <div class="col-sm-3 ">
                        <input type="text" name="todate" id="todate" autocomplete="off" placeholder="To Date" class="form-control" >
                    </div>
                    <div class="col-sm-2 ">
                        <input type="number" name="amount" id="amount" onkeyup="enableshow(this.value);" autocomplete="off" placeholder="Amount" class="form-control" >
                    </div>
                    <div class="col-sm-2 ">
                        <input type="number" name="chequeno" id="chequeno" onkeyup="enableshow(this.value);" autocomplete="off" placeholder="Cheque No" class="form-control" >
                    </div>
                    <div class="col-sm-2 ">
                        <input type="number" name="entryno" id="entryno" onkeyup="enableshow(this.value);" autocomplete="off" placeholder="Entry No" class="form-control" >
                    </div>
                    
                    <div class="clearfix"> </div>
					<br>
					<div class="col-sm-4" id="crdr">
						
					</div>
                </div>
                                            
				<div class="clearfix"> </div>
								
    <?php
		
		echo form_close();
//	}

	/* Pagination configuration */
	?>
  			
   			<div class="row">
        		<div class="col-sm-6" style="max-height:420px; background:#FFFFFF; overflow-y:scroll;" id="debit"></div>
        		<div class="col-sm-6" style="max-height:420px; background:#FFFFFF; overflow-y:scroll;" id="credit"></div>
            </div>
            <div class="clearfix"> </div><br><br>
            <div class="row">
            	<span id="balance"></span>
            </div>
    
    

<?

if ($ledger_id != "0")
	{ echo form_open_multipart('accounts/report/do_upload');?>
<br /><br />
<strong>Upload Bank Statement</strong><br /><br />
<input type="file" name="userfile" id="userfile" >
<input type="hidden" name="bank_code" id="bank_code" value="<?=get_account_bank_code($ledger_id)?>"><input type="submit" value="Upload" />

<?     ;echo  form_close();?>
<?php
	}
  //$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
//  echo "<a href='$url'>Back</a>"; 
?>
			<!-- finish form body --> 
			</div> 
         <!-- finish widget --> 
         </div>
        <div class="row calender widget-shadow"  style="display:none">
            <h4 class="title">Calender</h4>
            <div class="cal1">
                
            </div>
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
										
                                    
                              
											
						
                        
                        
                        
			