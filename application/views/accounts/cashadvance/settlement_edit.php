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
<h4>Advance Settlment Details <span  style="float:right; color:#FFF" ><!--<a href="javascript:load_printscrean1('')"><i class="fa fa-print nav_icon"></i></a>-->&nbsp;&nbsp;<a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>
  <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashadvance/add_settlment" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                      
                        <div class="form-body form-horizontal">
                           
                          <div class="form-group"><label class=" control-label col-sm-3 " >Advance Number</label><div class="col-sm-3 "> <select name="adv_id" id="adv_id" class="form-control"required="required" onChange="load_advancebalance(this.value)"  >
                           <? if($advlist){
							 foreach($advlist as $dataraw)
							 {
							 ?>
                        <option value="<?=$dataraw->adv_id?>-<?=$dataraw->totpay?>-<?=$dataraw->amount?>" <? if($dataraw->adv_id==$settledata->adv_id){?> selected="selected"<? }?> > <?=$dataraw->adv_code?> - <?=$dataraw->initial?> <?=$dataraw->surname?>-<?=$dataraw->totpay?></option>
                         <? }}?>
                         </select></div> <label class=" control-label col-sm-3 " >Invoice</label> 
                         <div class="col-sm-3 "><select name="invoice_id" id="invoice_id" class="form-control"required="required" onChange="load_invoice_balance(this.value)"  >
                         <option value="">Select Invoice</option>
                          <? if($invoice){
							 foreach($invoice as $dataraw)
							 {
							 ?>
                        <option value="<?=$dataraw->id?>-<?=$dataraw->totpay?>-<?=$dataraw->total?>" <? if($dataraw->id==$settledata->invoice_id){?> selected="selected"<? }?>  > <?=$dataraw->total?> - <?=$dataraw->first_name?> <?=$dataraw->last_name?></option>
                         <? }}?>
                         </select>
                          </div></div>
                           <div class="form-group">
                          <label class=" control-label col-sm-3 " >Advance Balance Amount</label>
                             <div class="col-sm-3 "><input  type="text" class="form-control" id="advance_bal"    name="advance_bal"  value=""   data-error="" required="required"   readonly placeholder="Advance Number" ></div>
                         <label class=" control-label col-sm-3 " >Invoice Balance Amount</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="invoice_bal"    name="invoice_bal"  value=""   data-error=""  readonly placeholder="Advance Number" >
                          <input  type="hidden"  id="invoice_balv"    name="invoice_balv"  value="0"  >
                          <input  type="hidden"  id="advance_balv"    name="advance_balv"  value="0"  ></div></div>
                         
                       <div class="form-group">
                       <label class=" control-label col-sm-3 " >Pay Amount</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="settleamount"    name="settleamount"  value="<?=$settledata->settleamount?>"   data-error="" required="required" onChange="validate_amount()"  placeholder="Advance Number" ></div> <label class=" control-label col-sm-3 " >Settle Date</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="settledate"    name="settledate"  value="<?=$settledata->settledate?>"   data-error="" required="required"  placeholder="Advance Number" ></div> 
                       </div>       
                      
                          <div class="form-group"> <label class=" control-label col-sm-3 " >Discription</label>
                            <div id="tasklistdiv" class="col-sm-6"><input  type="text" class="form-control" id="note"    name="note"  value="<?=$settledata->note?>"   data-error=""  placeholder="" ></div>
								</div></div>
                       
                       </div>
                       
                       </div>
                      
                       
                        
                        
                        
					</form>
                   