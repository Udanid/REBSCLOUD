 <script type="text/javascript">

    $( function() {
    $( "#pay_date" ).datepicker({

		dateFormat: 'yy-mm-dd',minDate: '<?=$this->session->userdata("fy_start")?>',
			maxDate: '<?=$this->session->userdata("current_end")?>'

	});

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

function loadcurrent_block(id)
{

	//alert(id)
	 var rescode= document.getElementById("res_code").value;
 if(id!="" & rescode!=""){



					 $('#plandata').delay(1).fadeIn(600);
	 			    document.getElementById("plandata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#plandata" ).load( "<?=base_url()?>accounts/cashier/get_chargedata/"+id+"/"+rescode );






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

 </script>


 <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashier/add_charges" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;">


							<div class="form-body form-horizontal">
                            <? if($searchdata){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Reservation</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."    id="res_code" name="res_code" onchange="loadcurrent_block(this.Value)" >
                    <option value="">Search here..</option>
                    <?    foreach($searchdata as $row){?>
                    <option value="<?=$row->res_code?>"><?=$row->res_code?> - <?=$row->project_name?> - <?=$row->lot_number ?> - <?=$row->first_name ?> <?=$row->last_name ?> - <?=$row->id_number ?></option>
                    <? }?>

					</select> </div><label class="col-sm-3 control-label">payment Date</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="pay_date" readonly="readonly"    name="pay_date" value="<?=date("Y-m-d")?>"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                          </div>><? }?></div>
                          <div id="plandata" style="display:none">





                            </div>


</div>
</div>
</form>
