<style type="text/css">
input {
    text-align: right;
}
.form-control[readonly], fieldset[disabled] .form-control {
  background-color:#f7d9f5 !important;
  opacity: 1;}
</style>
<script type="text/javascript">
$(document).ready(function(){
  // cal unit sum
  $('#purchase_table').on('change', '.quantity', function() {
    var price = $(this).closest('tr').find('.pricecal').val();
    var quantity = $(this).closest('tr').find('.quantity').val();

    var tot_price=quantity*price;
    $(this).closest('tr').find('.tot_price').val(tot_price.toFixed(2));
    total_cal();

  });
  $('#purchase_table').on('change', '.pricecal', function() {
    var price = $(this).closest('tr').find('.pricecal').val();
    var quantity = $(this).closest('tr').find('.quantity').val();
    var tot_price=quantity*price;
    $(this).closest('tr').find('.tot_price').val(tot_price.toFixed(2));
    total_cal();
  });
  window.total_cal = function()
  {
    //alert("ll")
    // cal total SUM
    var tot_p=0;
    var tot_q=0;
    var tot_p_q=0;
    $('.pricecal').each(function()
    {
      var val = $.trim( $(this).val().replace(/,/g, "") );
      if ( val ) {
        tot_p=parseFloat(tot_p)+parseFloat(val);
      }
    });
    $('.quantitycal').each(function()
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
  $('#price'+id).addClass('pricecal');
  $('#quantity'+id).addClass('quantitycal');
  total_cal();
}else{
  $('#price'+id).attr('readonly',true);
  $('#price'+id).val('0');
  $('#price'+id).removeClass('pricecal');
  $('#quantity'+id).removeClass('quantitycal');
  $('#tot_price'+id).val('0');
  total_cal();
}

}
</script>
<table class="table" id="purchase_table">
  <thead>
    <tr>
      <th></th>

      <th>Project Name</th>
      <th>Item Name</th>
      <th>Request Date</th>
      <th>Quantity</th>
      <th></th>
      <th>Unit Price</th>

      <th>Total</th>
      <th></th>
    </tr>
  </thead>
  <div class="form-body form-inline">
    <? if($po_orders){
      $n=0;
      foreach ($po_orders as $key => $value) {
        $n=$n+1;
        ?>
        <tr>
          <td><?=$n?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;<? if($value->prj_id=="" || $value->prj_id==0){ echo "Main stock";}else{ echo get_prjname($value->prj_id); }?>
              </td>
          <td class='name'>
            <input type='hidden' class='form-control ' id='name' name='itemid[]' value="<?=$value->req_id?>">
            <input type='hidden' class='form-control ' id='prj_id' name='prj_id[]' value="<?=$value->prj_id?>">
            <input type='hidden' class='form-control ' id='lot_id' name='lot_id[]' value="<?=$value->lot_id?>">
            <input type='hidden' class='form-control ' id='mat_id' name='mat_id[]' value="<?=$value->mat_id?>">
            <input type='hidden' class='form-control ' id='req_qty' name='req_qty[]' value="<?=$value->qty?>">
            <input type='hidden' class='form-control ' id='name' name='name[]' value="<?=$value->mat_name?>" readonly>
            <?=$value->mat_name?>

          </td>
          <td><?=$value->req_date?></td>
            <td class=''><div class="form-group" style=" padding:0; margin:0" >
              <input type="hidden" class="quantity form-control" id="quantity<?=$value->req_id?>"  name="quantity[]" value="<?=$value->qty?>" pattern="[0-9]+([\.][0-9]{0,2})?" readonly><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>
              <td><b><?=$value->qty?> &nbsp;<?=$value->mt_name?></b>
            </td>

            <td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="price form-control" value="0.00" id="price<?=$value->req_id?>" name="price[]" pattern="[0-9]+([\.][0-9]{0,2})?" readonly><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <span class="help-block with-errors" style=" padding:0; margin:0"></span></div>
            </td>
          <td class="text-right"><div class="form-group" style=" padding:0; margin:0" >
                  <input type="text" class="tot_price form-control" id="tot_price<?=$value->req_id?>" value="0.00" name="tot_price[]" pattern="[0-9]+([\.][0-9]{0,2})?" readonly><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <span class="help-block with-errors" style=" padding:0; margin:0"></span></div>
            </td>
            <td>
              <input type='checkbox' class='form-control' name='check_<?=$value->req_id?>' id='check_<?=$value->req_id?>' value="YES" onchange="edit_price('<?=$value->req_id?>')"></td>



                </tr>
              <?	}
            }?>

            <tr class="info">
              <th class='col-sm-6 name' colspan="5" >Total</th>
               <th class="text-right"><div class="form-group" style=" padding:0; margin:0" >
                 <input type="text" class="tot_quantity form-control" id="tot_quantity" value="0" name="tot_quantity" pattern="[0-9]+([\.][0-9]{0,2})?">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></th>
                <th class="text-right"><div class="form-group" style=" padding:0; margin:0" >
                   <input type="text" class="tot_un_price form-control" value="0.00" id="tot_un_price" name="tot_un_price" pattern="[0-9]+([\.][0-9]{0,2})?">
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></th>

                  <th class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_tot_price form-control" id="tot_tot_price" value="0.00" name="tot_tot_price" pattern="[0-9]+([\.][0-9]{0,2})?" style="text-align:right;"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></th>
                  </tr>

          </tbody>
        </div>

      </table>

    </hr></br></br>
    <table id="tot_table" border="2" class="table">

          </table>
        </br></br></br>
