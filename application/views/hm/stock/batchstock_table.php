<style type="text/css">
.form-control[readonly], fieldset[disabled] .form-control {
    background-color:#f7d9f5 !important;
opacity: 1;}
</style>
<script type="text/javascript">
$(document).ready(function(){
  // cal unit sum
  $('#purchase_table').on('change', '.quantity', function() {
    var price = $(this).closest('tr').find('.price').val();
    var quantity = $(this).closest('tr').find('.quantity').val();

    var tot_price=quantity*price;
    $(this).closest('tr').find('.tot_price').val(tot_price.toFixed(2));
    total_cal();

  });
  $('#purchase_table').on('change', '.price', function() {
    var price = $(this).closest('tr').find('.price').val();
    var quantity = $(this).closest('tr').find('.quantity').val();
    var tot_price=quantity*price;
    $(this).closest('tr').find('.tot_price').val(tot_price.toFixed(2));
    total_cal();
  });
  window.total_cal = function()
  {
    // cal total SUM
    var tot_p=0;
    var tot_q=0;
    var tot_p_q=0;
    $('.price').each(function()
    {
      var val = $.trim( $(this).val().replace(/,/g, "") );
      if ( val ) {
        tot_p=parseFloat(tot_p)+parseFloat(val);
      }
    });
    $('.quantity').each(function()
    {
      var val = $.trim( $(this).val().replace(/,/g, "") );
      if ( val ) {
        tot_q=parseFloat(tot_q)+parseFloat(val);
      }
    });
    $('.tot_price').each(function()
    {
      var val = $.trim( $(this).val().replace(/,/g, "") );
      if ( val ) {
        tot_p_q=parseFloat(tot_p_q)+parseFloat(val);
      }
    });
    $('#tot_un_price').val(tot_p.toFixed(2));
    $('#tot_quantity').val(tot_q);
    $('#tot_tot_price').val(tot_p_q.toFixed(2));
  }
  $( function() {
      $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
    } );
});

$(document).on('click','table td .deleterow', function() {//change .live to .on
$(this).parent().parent().remove();
window.total_cal();

});
function edit_price(id)
{ console.log($('#check_'+id).val())
  if($('#check_'+id).is(':checked')){
    $('#price'+id).attr('readonly',false);

  }else{
    $('#price'+id).attr('readonly',true);
  }

}
</script>
<table class="tables" id="purchase_table">
  <thead>
  <tr>
    <th></th>
    <th>Batch Code</th>
    <th>Meterial</th>
    <th>Available Quantity</th>
    <th>Transfer Quantity</th>
    <th ></th>
  </tr>
  </thead>
  <div class="form-body form-inline">
  <? if($stock_batch){
    $n=0;
    foreach ($stock_batch as $key => $value) {
      $n=$n+1;
      ?>
      <tr>
        <td class='col-sm-1'><?=$n?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>
          <input type="hidden" id="stock_<?=$value->stock_id?>" name="stock_<?=$value->stock_id?>" value="<?=$value->stock_id?>">
          <?=$value->batch_code?>
        </td>
        <td class='col-sm-2 name'>
        <input type='hidden' class='form-control ' id='mat_<?=$value->stock_id?>' name='mat_<?=$value->stock_id?>' value="<?=$value->mat_id?>">
         <? $mat_data=get_meterials_all($value->mat_id);
         //print_r($mat_data);
         echo $mat_data->mat_name;

         ?>
       </td>
      <td class='col-sm-2'>
        <input type="hidden" class="qty value" id="qty_<?=$value->stock_id?>" name="qty_<?=$value->stock_id?>" value="<?=$value->rcv_qty-$value->ussed_qty?>">
          <?=$value->rcv_qty-$value->ussed_qty?> &nbsp;<?=$mat_data->mt_name?>

      </td>
      <td class="col-sm-2 text-right">
        <div class="form-group" style=" padding:0; margin:0" >
          <input type="number" max="<?=$value->rcv_qty-$value->ussed_qty?>" class="newqty value form-control" id="newqty_<?=$value->stock_id?>" name="newqty_<?=$value->stock_id?>" pattern="[0-9]+([\.][0-9]{0,2})?" >
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <span class="help-block with-errors" style=" padding:0; margin:0"></span>
        </div>
      </td>

        <td class="col-sm-4 text-center">
          <input type='checkbox' class='form-control chkbox value' name='check_<?=$value->stock_id?>' id='check_<?=$value->batch_id?>' value="YES" onchange="edit_price('<?=$value->stock_id?>')">
        </td>

        </tr>
  <?	}
  }?>
  <script type="text/javascript">
  		$(function(){

  			$('input.value').keyup(function() {

  			  var $row = $(this).closest('tr');
  			      recqty = jQuery('input.newqty', $row).val(),
  			      qty = jQuery('input.qty', $row).val(),

  	              console.log(Number(recqty))
  	              console.log(Number(qty))
  	              if(Number(recqty)>Number(qty)){
  	              	console.log("error")
  	              	jQuery('input.newqty', $(this).closest('tr')).val(qty);
  	              }

  	              if(Number(recqty)>0){

                     jQuery('input.chkbox', $(this).closest('tr')).prop("checked",true);
  	              }else{
  	               //jQuery('input.bthcode', $(this).closest('tr')).val('');
  	               jQuery('input.chkbox', $(this).closest('tr')).prop("checked",false);
  	              }

  		    });
  		});
  </script>


</tbody>
</div>

</table>
<div><button type="submit" class="btn btn-primary disabled pull-right" >Tranfer Stock</button>
</div>

</hr></br></br>

  </br></br></br>
