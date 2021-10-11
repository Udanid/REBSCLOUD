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
		$('#extend_date').datepicker('option', 'minDate', selectedDate); //set promiss_date mindate as fromdate
		$('#extend_date').datepicker('setDate', promise_date); //set promiss_date mindate as fromdate
		
	}});
	$( "#extend_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	
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
<h4>Cash Advance Date Extend <span  style="float:right; color:#FFF" ><!--<a href="javascript:load_printscrean1('')"><i class="fa fa-print nav_icon"></i></a>-->&nbsp;&nbsp;<a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>
 <form id="advForm" method="post" action="<?=base_url()?>accounts/cashadvance/edit_settledate" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       
                        <div class="form-body form-horizontal">
                            <input  type="hidden" class="form-control" id="adv_code"    name="adv_code"  value="<?=$details->adv_code?>"   data-error="" required="required"  placeholder="Advance Number" >
                        
                         
                       <div class="form-group">
                       <label class=" control-label col-sm-3 " >Previous Promiss Date</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="apply_date"    name="apply_date"  value="<?=$details->promiss_date?>"   data-error="" required="required"  placeholder="Apply Date" ></div> <label class=" control-label col-sm-3 " >New Settle Date</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="extend_date"    name="extend_date"  value="<?=$details->extend_date?>"   data-error="" required="required"  placeholder="Settle Date" ></div> 
                       </div>       
                        <div class="clearfix"> </div><br>
                       
                         <div class="clearfix"> </div><br>
                          <div class="form-group">
                       <label class=" control-label col-sm-3 " >Description</label><div class="col-sm-3 ">  <textarea   class="form-control" id="extend_reason"    name="extend_reason"  value="<?=$details->extend_reason?>"   data-error="" required="required"  placeholder="Description" ><?=$details->extend_reason?></textarea></div> 
                     </div>
                          <div class="form-group"><div class="col-sm-3"></div>
                            <div id="tasklistdiv" class="col-sm-6"></div>
								<div class="col-sm-3 has-feedback" id="paymentdateid"><input type="hidden" name="adv_id" id="adv_id"  value="<?=$details->adv_id?>"/>
                                <button type="submit" class="btn btn-primary disabled"  >Update</button></div></div></div>
                       
                       </div>
                       
                       </div>
                       </div>
                       
                        
                        
                        
					</form>