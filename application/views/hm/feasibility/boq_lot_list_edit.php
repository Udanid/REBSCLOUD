<script>

</script>
 <? $this->load->view("includes/flashmessage");?>
<h4>Boq Unit Details of Project <?=$projname?>-> Unit <?=$unitid?> Edit<span  style="float:right; color:#FFF" ><a href="javascript:close_edit(2)"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
<form action="<?=base_url()?>hm/feasibility/update_unitboq" method="post">
  <input type="hidden" name="prj_id" value="<?=$prj_id?>">
  <input type="hidden" name="lotid" value="<?=$unitid?>">
  <input type="hidden" name="designid" value="<?=$designid?>">
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
                        $total_tot=0;
                          foreach($sub_cat_data_boq as $row){
                            $c++;
                            $tot=0;
                            ?>

                            <tr class="warning"><th colspan="7"><?=$c?> - <?=$row->cat_name?></th></tr>
                            <tr class="success"><th colspan="7"><?=$row->subcat_name?></th></tr>

                            <? if($datalist[$row->boqsubcat_id]){ $n=0;
                              foreach ($datalist[$row->boqsubcat_id] as $key => $value) {
                                $n++;
                                $tot=$tot+$value->amount;
                                $total_tot=$total_tot+$tot;
                                ?>
                              <tr class="edrows<?=$c?>">
                                <input type="hidden" id="rowsetid" name="rowsetid" class="value rowsetid" value="<?=$c?>">

                                <input type="hidden" name="<?=$value->boqtask_id?>subcatid" id="subcatid" value="<?=$value->boqsubcat_id?>">
                                <td scope="row"><?=$c?>.<?=$n?></td>
                                <td><textarea name="<?=$value->boqtask_id?>desk" rows="3" cols="60"><?=$value->description ?></textarea></td>
                                <td><input type="text" size="6" class="value quantity" name="<?=$value->boqtask_id?>qty" value="<?=$value->qty ?>"></td>
                                <td><input type="text" size="6" name="<?=$value->boqtask_id?>unit" value="<?=$value->unit?>"></td>
                                <td align="right"><input type="text" class="value price" name="<?=$value->boqtask_id?>rate" value="<?=$value->rate?>"></td>
                                <td align="right"><input type="text" class="total totalval<?=$c?>" name="<?=$value->boqtask_id?>amt" value="<?=$value->amount?>">
                                   <input type="hidden" class="total2 totals<?=$c?><?=$n?>" name="<?=$value->boqtask_id?>" value="<?=$value->amount?>"></td>


                                 </tr>
                            <?  } ?>

                            <tr class="info"><th colspan="5">Sub total carried out to summary</th><td class="subtotal2<?=$c?>" align="right"><?=number_format($tot,2)?><input type="hidden" class="subtotal<?=$c?>" value="<?=$tot?>"></td></tr>
                            <tr><th colspan="6"></th></th></tr>
                          <?  } }?>
                          <tr class="info total_total"><th colspan="5">Total</th><td align="right"><?=number_format($total_tot,2)?></td></tr>

                          <? } ?>
                          </tbody></table>
                          <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                        </div>
                      </div>

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
          console.log("inside function row id "+rowsetid)
      var rows= $('#boqtbls tr.edrows'+rowsetid).length;
         console.log("rows count "+rows)
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
