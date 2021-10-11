 <script type="text/javascript">

   
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}



function load_paid_chargers()
{
	id = $('#resale_lots').val();
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#transfer_charges').delay(1).fadeIn(600);
	 			    document.getElementById("plandata_charges").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#transfer_charges" ).load( "<?=base_url()?>re/reservation/get_resale_chargelist/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#plandata_charges').delay(1).fadeOut(600);
 }
}

setTimeout(function(){ 
	  	$("#resale_lots").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		width:200
    	});
	}, 500);

setTimeout(function(){ 
	  	$("#reservation_data").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		width:200
    	});
	}, 500);

 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>re/reservation/transfer_chargers" enctype="multipart/form-data">
                      
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 


						<div class="form-body form-horizontal">
                           

                          <div class="row">
                          	<div class="col-sm-6">
                          		<label>Transfer From</label>
                            <select class="form-control" placeholder="Qick Search.."  id="resale_lots" name="resale_lots" >
                    		<option value=""></option>
                    		<?    foreach($resale_lots as $row){//custom_helper
                    			if(charges_paid($row->res_code)){?>
                    		<option value="<?=$row->res_code?>"><?=$row->res_code?> - <?=$row->project_name?>  <?=$row->lot_number ?></option>
                    			<? }}?>
							</select>
                          	</div>
                          	<div class="col-sm-6">
                          		<label>To</label>
                            <select class="form-control" placeholder="Qick Search.." id="reservation_data" name="reservation_data"  onchange="load_paid_chargers()">
                    		<option value=""></option>
                    		<?    foreach($chargedata as $row){?>
                    		<option value="<?=$row->res_code?>"><?=$row->res_code?> - <?=$row->project_name?>  <?=$row->lot_number ?> - <?=$row->first_name ?> <?=$row->last_name ?>  <?=$row->id_number ?></option>
                    			<? }?>
							</select>
                          	</div>
                          </div>
                          </div>
                          <div id="transfer_charges" style="display:none">
                           
							
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>