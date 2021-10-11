<script>

 function calculate_salesval(i)
 {

	 subtot=parseFloat(document.getElementById('tot_amt'+i).value);
	 var mytot=0;
   var budget=$('#tot_budget').val();
   alert(budget)
	  //document.getElementById('tot'+i).value=subtot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	 for(t=1; t<= <?=$details->numof_units?>; t++)
	{
		 subtot=parseFloat(document.getElementById('tot_amt'+t).value);

		mytot=parseFloat(mytot)+parseFloat(subtot);
	}
	//alert(mytot)

    document.getElementById('totalsales').value=mytot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");


 }
function check_this_totals()
{
  var mytot=$('#totalsales').val();
  var budget=$('#tot_budget').val();
  if(budget>mytot){
    document.getElementById("checkflagmessage").innerHTML='Your budget is over than your sales value';
    $('#flagchertbtn').click();
    $("input[id*='tot_amt']").val('0');
    document.getElementById('totalsales').value='0.00';
  }else{
    document.getElementById('totalsales').value=mytot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  }
}
</script>
 <? $this->load->view("includes/flashmessage");?>
<form data-toggle="validator"  method="post" action="<?=base_url()?>hm/feasibility/add_price" enctype="multipart/form-data">
                       <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                       <input type="hidden"  class="form-control" name="num_of_unit" id="num_of_unit" value="<?=$details->numof_units?>" >
                        <div class="row">
						  <div class="  widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h4>Unit Price</h4>
							</div>
					              <div class="form-body">

                                   <table class="table gridexample"> <thead> <tr> <th >ID</th> <th >Unit Name</th><th width="30%">Sales Value </th></tr> </thead>
                                     <? $count=1; $tot=0; if($unit_design){
  									  foreach($unit_design as $raw) {

                      $saleval=0;
                      if($raw->sale_val=="" || $raw->sale_val==Null)
                      {
                        $saleval=0;
                      }else{
                        $saleval=$raw->sale_val;
                      }
                      $tot=$tot+$saleval;
									   ?>
                     <tr> <td><?=$count?></td>

                       <td> <div class="form-group has-feedback" >
                         <input type="hidden"  class="form-control" name="unit_id<?=$count?>" id="unit_id<?=$count?>" value="<?=$raw->lot_id?>" >

                         <input type="text"  class="form-control" name="unit_name<?=$count?>" id="unit_name<?=$count?>" value="<?=$raw->lot_number?>" readonly ><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                         <span class="help-block with-errors" ></span>
                       </div></td>

                       <td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="tot<?=$count?>" id="tot_amt<?=$count?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=$saleval?>" onblur="calculate_salesval('<?=$count?>')"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                         <span class="help-block with-errors" ></span>
                       </div>
                     </td>
                   </tr>
                                   <?  $count++; }


                 } ?>

                                   <tr> <td><strong>Total</strong></td>
                                   <? $tot=$tot_budget->amouts+$tot_budget->budget?>
                                   <td></td><input type="hidden" value="<?=$tot?>" name="tot_budget" id="tot_budget"><td></td>
                                    <td> <div class="form-group has-feedback" ><input type="text"    class="form-control" name="totalsales" id="totalsales"   pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=number_format($tot,2)?>"  data-error="Total Ep rates Must euql to 100" readonly="readonly"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                    </tr></table>

								  <br />
                                   <? if($details->status=='PENDING'){?>
                                    <div class="bottom ">

											<div class="form-group validation-grids" style="float:right">
												<button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()">Update</button>
											</div>
											<div class="clearfix"> </div>
										</div>
                                        <? }?>

						</div>

                        </div>
                        <div class="clearfix"> </div></div>



					</form>
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
