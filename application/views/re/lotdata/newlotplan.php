 <script type="text/javascript">
  $( function() {
	 $( "#drown_date" ).datepicker({dateFormat: 'yy-mm-dd'});
  } );
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
  function calculate_salestot(i)
  {
	  var salevalue=parseFloat(document.getElementById('perches_count'+i).value)*parseFloat(document.getElementById('price'+i).value);
	  document.getElementById('subtotprice'+i).value=salevalue;

	   oldcount=document.getElementById("oldblockcount").value;

	   //alert(oldcount);
	    if(oldcount==0)
	   {
		    count=parseFloat(document.getElementById("blockout_count").value);
	  		 j=1;
	   }
	   else
	   {
		    j=oldcount;
			 count=parseFloat(document.getElementById("blockout_count").value)+parseFloat(oldcount-1);


	   }
	  var netotal=0;
	  var netpurch=0

	  for(t=1; t<=count; t++)
		{
		 if(!document.getElementById('isselect'+t).checked)
		 {
			if( document.getElementById('subtotprice'+t).value!="")
			netotal=netotal+parseFloat(document.getElementById('subtotprice'+t).value)
			if( document.getElementById('perches_count'+t).value!="")
			netpurch=netpurch+parseFloat(document.getElementById('perches_count'+t).value)
		 }

		}
		//alert(netotal);
	   document.getElementById('netpurch').value=netpurch;
	   document.getElementById('nettotal').value=netotal;
  }
 function check_this_totals()
 { //alert(document.getElementById('estimatecost').value)
	// if(document.getElementById('nettotal').value<document.getElementById('estimatecost').value)
	// document.getElementById('nettotal').value="";
	 // if(document.getElementById('netpurch').value!=document.getElementById('totalextend').value)
	//  document.getElementById('netpurch').value="";

 }
function loadlotlist()
{
count=document.getElementById("blockout_count").value;
 oldcount=document.getElementById("oldblockcount").value;

	  // alert(oldcount);
	   if(oldcount==0)
	   {
		    count=parseFloat(document.getElementById("blockout_count").value);
	  		 j=1;
	   }
	   else
	   {

			 j=oldcount;
			 count=parseFloat(document.getElementById("blockout_count").value)+parseFloat(oldcount-1);



	   }

if(count>=1)
{	
	$('#blocks_upload').delay(1).fadeOut(600);

	$('#lotlist').delay(1).fadeIn(600);
	//alert(j)
	if(j>1 && j<13)
	t=parseFloat(j)
	else if(j>=13)
	t=parseFloat(j);
	else
	t=1;

	code='  <table class="table"> <thead> <tr> <th >Lot Number</th> <th >Lot Extent</th>  <th >Perch Price</th><th width="30%">Sales Price </th></tr> </thead>';
	for(i=j; i<=count; i++)
	{

	//if(t==13) t=t+1;
	t=zeroPad(t, 2);
	code=code+' <tr> <td><input type="hidden"    style="width:70px; padding:3px;" class="form-control" id="lot_id'+i+'" name="lot_id'+i+'" value="" required="required" ">';
	code=code+'<input type="text"    style="width:70px; padding:3px;" class="form-control" id="lot_number'+i+'" name="lot_number'+i+'" value="'+t+'" required="required" "></td>';
	code=code+'<td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="perches_count'+i+'" id="perches_count'+i+'" value="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>';

	code=code+'<span class="help-block with-errors" ></span>';
	code=code+'</div></td>';
	code=code+' <td> <div class="form-group has-feedback" ><input type="text"  class="form-control number-separator" name="price'+i+'" id="price'+i+'" onblur="calculate_salestot('+i+')"  value=""required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>';
	code=code+'</div></td>'
    code=code+'<td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="subtotprice'+i+'"  id="subtotprice'+i+'" pattern="[0-9]+([\.][0-9]{0,3})?" value=""  readonly="readonly"><span class="glyphicon form-control-feedback"   aria-hidden="true"></span>';
	code=code+'<span class="help-block with-errors" ></span></div></td>';
    code=code+'	</div></td>';
	 code=code+'<td align="right"><input type="checkbox" value="YES" name="isselect'+i+'"  id="isselect'+i+'" disabled><input type="hidden" name="plansq'+i+'" id="plansq'+i+'" value=""></td></tr>';

	t++;
	}
	code=code+'<tr class="active"><td>Total</td><td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="netpurch"  id="netpurch"  value="0" data-error="Incorrect Value for total seleble area"  required><span class="glyphicon form-control-feedback"   aria-hidden="true"></span>';
code=code+'<span class="help-block with-errors" ></span></div></td>';
	    code=code+'<td ></td><td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="nettotal"  id="nettotal"  value="0"  data-error="Total selling price couldnt be less than estimated price" required><span class="glyphicon form-control-feedback"   aria-hidden="true"></span>';
code=code+'<span class="help-block with-errors" ></span></div></td>';

	//alert( code)
	code=code+'</tr></table>'

	 document.getElementById("lotlist").innerHTML=code;

}
}


function loadcurrent_block(id)
{
	//alert(id)
 if(id!=""){


	 $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_prjacblockplane', id: id,fieldname:'prj_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					 $('#plandata').delay(1).fadeIn(600);
					

						 $('#lotinfomation').delay(1).fadeIn(600);
    					    document.getElementById("lotinfomation").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#lotinfomation" ).load( "<?=base_url()?>re/lotdata/pending_lots/"+id );
						$( "#laodfinancost" ).load( "<?=base_url()?>re/lotdata/thisfinance_cost/"+id );
				}
            }
        });



 }
 else
 {
	 $('#lotinfomation').delay(1).fadeOut(600);
	 $('#plandata').delay(1).fadeOut(600);
 }
}

function upload_file(){
	 var file = document.getElementById('block_file').value;
	  $.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'re/lotdata/test/';?>',
            data: {block_file: file},
            success: function(data) {
              $('#upload_btn').attr('disabled', 'disabled');
            }
        });

	//alert('ok');
}
 </script>


 <form data-toggle="validator" method="post" action="<?=base_url()?>re/lotdata/add" enctype="multipart/form-data">
                       <input type="hidden" name="product_code" id="product_code" value="<?=$product_code?>">
                       <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:300px;">


							<div class="form-body form-horizontal">
                          <div class="form-group"><label class="col-sm-3 control-label">Select Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."  onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value=""></option>
                    <?   foreach($searchdata as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>

					</select> </div>
                          </div></div>
                          <div id="plandata" style="display:none">
                            <div class="form-title">
								<h4>Plan Details (Perch) :</h4>
							</div>
							<div class="form-body form-horizontal" >
                                    <div class="form-group"><label class="col-sm-3 control-label">Plan No</label>
										<div class="col-sm-3 "><input type="text" class="form-control"   id="plan_no"  value="" name="plan_no"  required>
                                       </div>

                                        <label class="col-sm-3 control-label" >Number of Blocks</label>
										<div class="col-sm-3"><input type="text" class="form-control" id="blockout_count" value="0" name="blockout_count" onblur="loadlotlist()"    data-error=""  required>
										</div></div>

                                     <div class="form-group"><label class="col-sm-3 control-label">Drawn By</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="drown_by"  value=""name="drown_by"    data-error=""  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-sm-3 control-label">Drawn Date</label>
										<div class="col-sm-3 has-feedback"><input  type="text" autocomplete="off" class="form-control" id="drown_date"    name="drown_date"     data-error=""   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
                                       <div class="form-group"><label class="col-sm-3 control-label">Upload Plan</label>
										<div class="col-sm-3 has-feedback"><input type="file" class="form-control" id="plan1"   name="plan1"  data-error=""  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-sm-3 control-label"><!--Finance Cost--></label>
                                    <div class="col-sm-3 has-feedback"><div id="laodfinancost"><input  type="hidden" step="0.01" class="form-control" id="finance_cost"    name="finance_cost"     data-error=""   ></div>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
										<div class="col-sm-3 validation-grids">
 									</div>
									</div>


							</div>
						
								

                              <div id="lotinfomation"></div>
                            <div id="lotlist"></div>

                            <div class="bottom validation-grids validation-grids-right ">

											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()">Update</button>
											</div>
											<div class="clearfix"> </div>
										</div>

                            
                           


</div>
</div>
 </div>


</form>

		
