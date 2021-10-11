<script type="text/javascript">
function calculate_total(name,value,count)
{
	var tot=parseFloat(value)*parseFloat(count);
	document.getElementById(name+'totv').value=tot;
	document.getElementById(name+'tot').value=tot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;;
	var total=parseFloat(document.getElementById('N5000totv').value)+parseFloat(document.getElementById('N2000totv').value)+parseFloat(document.getElementById('N1000totv').value)+parseFloat(document.getElementById('N500totv').value)+parseFloat(document.getElementById('N100totv').value)+parseFloat(document.getElementById('N50totv').value)+parseFloat(document.getElementById('N20totv').value)+parseFloat(document.getElementById('N10totv').value)+parseFloat(document.getElementById('C10totv').value)+parseFloat(document.getElementById('C5totv').value)+parseFloat(document.getElementById('C2totv').value)+parseFloat(document.getElementById('C2totv').value)+parseFloat(document.getElementById('CC50totv').value)+parseFloat(document.getElementById('CC25totv').value)
	document.getElementById('totalv').value=total;
	var advancetot=document.getElementById('outbal').value;
	var ledgerbal=document.getElementById('ledgerbal').value;
	var cashbal=parseFloat(total)+parseFloat(advancetot);
	var variance=parseFloat(ledgerbal)-parseFloat(cashbal);
	document.getElementById("cashbookbal").innerHTML=cashbal.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
; document.getElementById("vari").innerHTML=variance.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
; 

	document.getElementById('total').value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById('variance').value=variance;
	
	
	
	
}
$( function() {
	$.validator.setDefaults({ ignore: ":hidden:not(.select)" });
	
	//set validation options
    $("#advForm").validate();
    $( "#apply_date" ).datepicker({dateFormat: 'yy-mm-dd',onSelect: function(selectedDate) {
		var promise_date = updateDatesNew(selectedDate);
		$('#promiss_date').datepicker('option', 'minDate', selectedDate); //set promiss_date mindate as fromdate
		$('#promiss_date').datepicker('setDate', promise_date); //set promiss_date mindate as fromdate
		
	}});
	$( "#promiss_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	
 });
</script>
<style type="text/css">
.denomiform_sm {
	 border: 1px solid #ccc;
	 text-align:right;
	  padding: 2px 2px;
	width:30px;
	height:20px;
	padding:0;
	}
	.denomiform_md {
		 border: 1px solid #ccc;
	 text-align:right;
	  padding: 2px 2px;
	   background:#e8e3de;
	width:60px;
	height:20px;
	padding:0;
	}
</style>
<? 
?>
<h4>Cash Book Details <span  style="float:right; color:#FFF" ><!--<a href="javascript:load_printscrean1('')"><i class="fa fa-print nav_icon"></i></a>-->&nbsp;&nbsp;<a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>
 <form id="advForm" method="post" action="<?=base_url()?>accounts/cashadvance/edit_advancedata" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       <div class="form-title">
								<h4>Edit Cash Advance </h4>
						</div>
                        <div class="form-body form-horizontal">
                            <input  type="hidden" class="form-control" id="adv_code"    name="adv_code"  value="<?=$details->adv_code?>"   data-error="" required="required"  placeholder="Advance Number" >
                          <div class="form-group"> <label class=" control-label col-sm-3 " >Advance Type</label> 
                         <div class="col-sm-3 "><select name="adv_type" id="adv_type" class="form-control"required="required" onChange="load_prjlist(this.value)"  >
                         <option value=""> Advance type</option>
                          <option value="Project" <? if($details->adv_type=='Project'){?> selected="selected"<? }?>> Project</option>
                           <option value="Other" <? if($details->adv_type=='Other'){?> selected="selected"<? }?>> Other</option>
                         </select>
                          </div>
                           <label class=" control-label col-sm-3 " >Expence Type</label> 
                         <div class="col-sm-3 "><select name="expence_type" id="expence_type" class="form-control"required="required" >
                         <option value=""> Expence type</option>
                          <option value="Material" <? if($details->expence_type=='Material'){?> selected="selected"<? }?>> Material</option>
                           <option value="Machinery" <? if($details->expence_type=='Machinery'){?> selected="selected"<? }?>> Machinery</option>
                              <option value="Labour" <? if($details->expence_type=='Labour'){?> selected="selected"<? }?>> Labour</option>
                             <option value="Other" <? if($details->expence_type=='Other'){?> selected="selected"<? }?>> Other</option>
                             
                               <?  if($pay_type!='CHQ'){
								  ?>
                               <option value="Telephone SLT"<? if($details->expence_type=='Telephone SLT'){?> selected="selected"<? }?> >  Telephone SLT</option>	
                               <option value="Telephone Mobitel"<? if($details->expence_type=='Telephone Mobitel'){?> selected="selected"<? }?>>   Telephone Mobitel</option>	
                               <option value="Electricity Expenses"<? if($details->expence_type=='Electricity Expenses'){?> selected="selected"<? }?>>Electricity Expenses</option>	
                                <option value="Water Expenses American Premium"<? if($details->expence_type=='Water Expenses American Premium'){?> selected="selected"<? }?>>Water Expenses American Premium</option>	
                                <option value="Water Expenses NWSDB"<? if($details->expence_type=='Water Expenses NWSDB'){?> selected="selected"<? }?>> Water Expenses NWSDB</option>	
                               <option value="Consultants payments"<? if($details->expence_type=='Consultants payments'){?> selected="selected"<? }?>>Consultants' payments</option>	
                               <option value="Office Cleaning"<? if($details->expence_type=='Office Cleaning'){?> selected="selected"<? }?>>Office Cleaning</option>	
                               <option value="Postage & Courier"<? if($details->expence_type=='Postage & Courier'){?> selected="selected"<? }?>>Postage & Courier</option>	
                               <option value="Printing & Stationery"<? if($details->expence_type=='Printing & Stationery'){?> selected="selected"<? }?>> Printing & Stationery</option>	
                                <option value="Advertising Expenses - (Jobs & notices)"<? if($details->expence_type=='Advertising Expenses - (Jobs & notices)'){?> selected="selected"<? }?>>Advertising Expenses - (Jobs & notices)</option>							<option value="Meeting Expenses"> Meeting Expenses</option>	
                               <option value="Refreshments & Tea"<? if($details->expence_type=='Refreshments & Tea'){?> selected="selected"<? }?>>Refreshments & Tea</option>	
                               <option value="Equipment Repairs & Maintenance"<? if($details->expence_type=='Equipment Repairs & Maintenance'){?> selected="selected"<? }?>>Equipment Repairs & Maintenance</option>	
                               <option value="Office Repairs & Maintenance"<? if($details->expence_type=='Office Repairs & Maintenance'){?> selected="selected"<? }?>>Office Repairs & Maintenance</option>	
                               <option value="Building Rent"<? if($details->expence_type=='Building Rent'){?> selected="selected"<? }?>>Building Rent</option>	
                               <option value="Rates & Licenses"<? if($details->expence_type=='Rates & Licenses'){?> selected="selected"<? }?>>Rates & Licenses</option>	
                               <option value="Donations"<? if($details->expence_type=='Donations'){?> selected="selected"<? }?>>Donations</option>	
                                <option value="Accounting Fees"<? if($details->expence_type=='Accounting Fees'){?> selected="selected"<? }?>>Accounting Fees</option>	
                                 <option value="Office Renovation Expenses"<? if($details->expence_type=='Office Renovation Expenses'){?> selected="selected"<? }?>>Office Renovation Expenses</option>	
                                 <option value="Fines & Surcharges"<? if($details->expence_type=='Fines & Surcharges'){?> selected="selected"<? }?>>Fines & Surcharges</option>	
                                <option value="Secretarial Charges"<? if($details->expence_type=='Secretarial Charges'){?> selected="selected"<? }?>>Secretarial Charges</option>	 
                                <option value="Annual Subscriptions"<? if($details->expence_type=='Annual Subscriptions'){?> selected="selected"<? }?>>Annual Subscriptions</option>	
                                <option value="Audit Fees"<? if($details->expence_type=='Audit Fees'){?> selected="selected"<? }?>>Audit Fees</option>	
                                 <option value="Travelling"<? if($details->expence_type=='Travelling'){?> selected="selected"<? }?>>Travelling</option>	
                                  <option value="Training Expenses"<? if($details->expence_type=='Training Expenses'){?> selected="selected"<? }?>>Training Expenses</option>	
                                  <option value="Janitorial"<? if($details->expence_type=='Janitorial'){?> selected="selected"<? }?>>Janitorial</option>	
                                 <option value="Vehicle Rent"<? if($details->expence_type=='Vehicle Rent'){?> selected="selected"<? }?>>Vehicle Rent</option>	
                                 <option value="Fuel Expenses"<? if($details->expence_type=='Fuel Expenses'){?> selected="selected"<? }?>>Fuel Expenses</option>	
                                 <? } ?>
                         </select>
                          </div>
                          </div>
                          
                           <div class="form-group">
                          <label class=" control-label col-sm-3 " >Cash Book</label>
                             <div class="col-sm-3 "><select name="book_id" id="book_id" class="form-control"required="required"  >
                              <option value=""> Cash Book</option>
                         <? if($datalist){
							 foreach($datalist as $dataraw)
							 {
							 ?>
                        <option value="<?=$dataraw->id?>" <? if($details->book_id==$dataraw->id){?> selected="selected"<? }?>><?=$dataraw->type_name?> <?=$dataraw->name?></option>
                         <? }}?>
                         
                         </select></div>
                         <label class=" control-label col-sm-3 " >Amount</label><div class="col-sm-3 ">  <input  type="text" class="form-control number-separator" id="amount"    name="amount"  value="<?=$details->amount?>"   data-error="" required="required"  placeholder="Amount" ></div></div>
                         
                       <div class="form-group">
                       <label class=" control-label col-sm-3 " >Apply Date</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="apply_date"    name="apply_date"  value="<?=$details->apply_date?>"   data-error="" required="required"  placeholder="Apply Date" ></div> <label class=" control-label col-sm-3 " >Settle Date</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="promiss_date"    name="promiss_date"  value="<?=$details->promiss_date?>"   data-error="" required="required"  placeholder="Settle Date" ></div> 
                       </div>       
                        <div class="form-group">
                       <label class=" control-label col-sm-3 " >Description</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="description"    name="description"  value="<?=$details->description?>"   data-error="" required="required"  placeholder="Description" ></div> 
                       <div id="prjlistdiv" <? if($details->adv_type!='Project'){?>style="display:none"<? }?>>   <label class=" control-label col-sm-3 " >Project</label>
                             <div class="col-sm-3 "><select name="project_id" id="project_id" class="form-control" onChange="load_tasklist(this.value)"  >
                              <option value=""> Select Project</option>
                         <? if($prjlist){
							 foreach($prjlist as $raw)
							 {
							 ?>
                        <option value="<?=$raw->prj_id?>" <? if($details->project_id==$raw->prj_id){?> selected="selected"<? }?>><?=$raw->project_name?></option>
                         <? }}?>
                         
                         </select></div></div>  <div class="clearfix"> </div><br>
                       
                         <div class="clearfix"> </div><br>
                          <div class="form-group"><div class="col-sm-3"></div>
                            <div id="tasklistdiv" class="col-sm-6"></div>
								<div class="col-sm-3 has-feedback" id="paymentdateid"><input type="hidden" name="adv_id" id="adv_id"  value="<?=$details->adv_id?>"/>
                                <button type="submit" class="btn btn-primary disabled"  >Update Advance</button></div></div></div>
                       
                       </div>
                       
                       </div>
                       </div>
                       
                        
                        
                        
					</form>