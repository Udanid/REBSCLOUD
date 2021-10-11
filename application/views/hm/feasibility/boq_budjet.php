<script>

</script>
 <? $this->load->view("includes/flashmessage");?>

<form action="<?=base_url()?>hm/feasibility/add_unitboq" method="post">
	<input type="hidden" name="prj_id" value="<?=$prj_id?>">
<div class=" widget-shadow bs-example boqtbl" data-example-id="contextual-table" >

                        <table class="table" id="boqtbls"> <thead> <tr>
													<th>No</th>
													<th>Description</th>
													<th>Qty</th>
													<th>Unit</th>
													<th>Rate</th>
													<th>Amount</th>
													<th></th>
												</tr> </thead>
												<tbody>
											<? if($sub_cat_data_boq){$c=0;
                          foreach($sub_cat_data_boq as $row){
														$c++;
														$tot=0;
														?>

														<tr class="warning"><th colspan="7"><?=$c?> - <?=$row->cat_name?></th></tr>
														<tr class="success"><th colspan="7"><?=$row->subcat_name?></th></tr>
                                                        
														<? if($datalist){ $n=0;
															foreach ($datalist[$row->boqsubcat_id] as $key => $value) {
																$n++;
																$tot=$tot+$value->amount;
																?>
															<tr class="rows<?=$c?>">
																<td scope="row"><?=$c?>.<?=$n?>
															<input type="hidden" id="rowsetid" name="rowsetid" class="value rowsetid" value="<?=$c?>"><input type="hidden" id="rowid" name="rowid" class="value rowid" value="<?=$n?>">
                                                            <input type="hidden" name="<?=$value->boqtask_id?>subcatid" id="subcatid" value="<?=$row->boqsubcat_id?>">
														</td>
																<td><textarea name="<?=$value->boqtask_id?>desk" rows="3" cols="60"><?=$value->description?></textarea></td>
																<td><input type="text" class="value quantity" name="<?=$value->boqtask_id?>qty" value="<?=$value->qty?>"></td>
																<td><input type="text" name="<?=$value->boqtask_id?>unit" value="<?=$value->unit?>"></td>
																<td align="right"><input type="text" class="value price" name="<?=$value->boqtask_id?>rate" value="<?=$value->rate?>"></td>
																<td align="right">
																	<input type="text" class="total totalval<?=$c?><?=$n?>" name="<?=$value->boqtask_id?>amt" value="<?=$value->amount?>">
																	<input type="hidden" class="total2 totals<?=$c?><?=$n?>" name="<?=$value->boqtask_id?>" value="<?=$value->amount?>"></td>
																
				                         </tr>
														<?	} ?>
                                                         
														<tr class="info"><th colspan="6">Sub total carried out to summary</th><th class="subtotal2<?=$c?>"><?=number_format($tot,2)?><input type="hidden" class="subtotal<?=$c?>" value="<?=$tot?>"></th></tr>
														<tr><th colspan="6"></th></th></tr>
													<?	} }?>
													<? } ?>
                          </tbody></table>
                     <button type="submit" class="btn btn-primary">Update</button>
                    </div>
</form>

<script type="text/javascript">
	$(function(){
		$('input.value').keyup(function() {
  
		  var $row = $(this).closest('tr');
		      $output = jQuery('input.total', $row),
		      $output2 = jQuery('input.total2', $row),
		      quantity = jQuery('input.quantity', $row).val(),
		      price = jQuery('input.price', $row).val(),
		      total = quantity * price;
          //append new quentity*price value..
		  $output.val(total);
		  $output2.val(total);
          if($output.val(total)){
          	  
			  var rowsetid = jQuery('input.rowsetid', $row).val();
			  cal_subamount(rowsetid);
          }
 
		});

		function cal_subamount(rowsetid){
          console.log("inside function"+rowsetid)
		  var rows= $('#boqtbls tr.rows'+rowsetid).length;
		  console.log(rows)
          var tot = 0;
          var i;
			for (i=1; i< rows+1; i++) {
             
             var totalnew = parseInt(jQuery('.totals'+rowsetid+i).val());
             console.log(totalnew)

             tot = tot+totalnew;
		} 

         //console.log(tot)
		  $('.subtotal2'+rowsetid).html(tot+'<input type="hidden" class="subtotal'+rowsetid+'" value="'+tot+'">');

         

		}
	});
</script>                    