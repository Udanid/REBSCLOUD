 <script type="text/javascript">

   $( function() {
	 $.validator.setDefaults({ ignore: ":hidden:not(select)" })
	 $("#myform").validate({
		submitHandler: function(form) { // <- pass 'form' argument in
			$("#submit").attr("disabled", true);
			form.submit(); // <- use 'form' argument here.
		},
    });
	   
    $( "#paydate1" ).datepicker({dateFormat: 'yy-mm-dd' ,minDate: '<?=$this->session->userdata("current_start")?>',
			maxDate: '<?=$this->session->userdata("current_end")?>'});

  } );
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
 
 function check_this_totals()
 {  
 	var pendingamount=parseFloat(document.getElementById('pendingamount').value);
   var payamoount=parseFloat(document.getElementById('amount').value);
   if(document.getElementById('task_id').value=="")
   {
	     document.getElementById("checkflagmessage").innerHTML='Please Select Task'; 
		 
					 $('#flagchertbtn').click();
					  document.getElementById('amount').value="";
   }
  
   if(payamoount>pendingamount)
   {
	    document.getElementById("checkflagmessage").innerHTML='Pay Amount exseed Budget Allocation'; 
					 $('#flagchertbtn').click();
					 document.getElementById('amount').value="";
   }
	
	 
 }


function load_subtasklist(id)
{
	 var prj_id= document.getElementById("prj_id").value;
	 if(id!=""){
	 taskid=id.split(",")[0];
	 
	 document.getElementById("pendingamount").value=id.split(",")[1];
	 
						 $('#subtaskdata').delay(1).fadeIn(600);
    					    document.getElementById("subtaskdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#subtaskdata" ).load( "<?=base_url()?>common/get_subtask_list/"+taskid+"/"+ prj_id	);
				
	 
	 
		
 }
	 
}

function loadcurrent_block_new()
{ 
	id=document.getElementById("res_code").value;
	var paydate=document.getElementById("paydate1").value;
	var pay_amount=document.getElementById("pay_amount").value;
 if(id != "" && paydate != ""){
	 
	 
	 
					 $('#plandata').delay(1).fadeIn(600);
	 			    document.getElementById("plandata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
				//	alert("<?=base_url()?>re/reservation/get_advancedata/"+id+'/'+paydate)
					$( "#plandata" ).load( "<?=base_url()?>re/reservation/get_advancedata/"+id+'/'+paydate+'/'+pay_amount );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#lotinfomation').delay(1).fadeOut(600);
	 $('#plandata').delay(1).fadeOut(600);
 }
}

function load_amount(value)
{
	var amount=0;
	if(value!="")
	 amount=value.split(",")[1];
	document.getElementById("amount").value=amount;
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57 ) && charCode != 46) {
        return false;
    }
    return true;
}
 </script>
 
 
 <form id="myform" method="post" action="<?=base_url()?>re/reservation/add_advance" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
					<div class="form-body form-horizontal">
                       <? if($searchdata){?>
                          <div class="form-group">
                     		
                          	<div class="col-sm-4 ">  
                            	<label class="control-label">Select Reservation</label>
                            	<select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block_new()" id="res_code" name="res_code" >
                                  <option value=""></option>
								  <?    foreach($searchdata as $row){
                                      //if($row->pay_type=='Pending'){
                                      ?>
                                  <option value="<?=$row->res_code?>"><?=$row->res_code?> - <?=$row->project_name?>  <?=$row->lot_number ?> - <?=$row->first_name ?> <?=$row->last_name ?>  <?=$row->id_number ?></option>
                                  <?  //}
                                  }?>
             
								</select> 
                             </div> 
                    		<div class="col-sm-4 has-feedback" id="paymentdateid">
                            	<label class="control-label">Current Payment</label>
                                <input  type="text" onkeypress="return isNumber(event)" class="form-control number-separator" id="pay_amount"    name="pay_amount"     data-error=""   required="required"  onblur="loadcurrent_block_new()" >
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<span class="help-block with-errors" ></span>
                            </div>
                    	
                        <div class="col-sm-4 has-feedback" id="paymentdateid">
                        	<label class="control-label">Payment Date</label>
                            <input  type="text" class="form-control" id="paydate1"   readonly="readonly"   name="paydate1" value="<?=date("Y-m-d")?>"    data-error="" required  onChange="loadcurrent_block_new()" >
							<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
							<span class="help-block with-errors" ></span>
                        </div>
                          
                          </div><? }?></div>
                          <div id="plandata" style="display:none">
                           
							
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>