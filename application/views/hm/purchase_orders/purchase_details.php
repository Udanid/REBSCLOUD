<style type="text/css">
.newtext {
  background-color:#f7d9f5 !important;
  opacity: 1;}
</style>
<script type="text/javascript">
$(document).ready(function(){
  // cal unit sum
  $('#purchase_table').on('change', '.quantity', function() {
    var price = $(this).closest('tr').find('.pricecal2').val();
    var quantity = $(this).closest('tr').find('.quantitycal2').val();

    var tot_price=quantity*price;
    $(this).closest('tr').find('.tot_price').val(tot_price.toFixed(2));
    total_cal();

  });
  $('#purchase_table').on('change', '.pricecal2', function() {
    var price = $(this).closest('tr').find('.pricecal2').val();
    var quantity = $(this).closest('tr').find('.quantitycal2').val();
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
    $('.pricecal2').each(function()
    {
      var val = $.trim( $(this).val().replace(/,/g, "") );
      if ( val ) {
        tot_p=parseFloat(tot_p)+parseFloat(val);
      }
    });
    $('.quantitycal2').each(function()
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
function edit_price2(id)
{
  if($('#check_2'+id).is(':checked')){
    $('#price2'+id).removeClass('newtext')
    $('#price2'+id).attr('readonly',false);
    $('#price2'+id).addClass('pricecal2');
    $('#quantity'+id).addClass('quantitycal2');
    total_cal();
  }else{
    $('#price2'+id).attr('readonly',true);
    $('#price2'+id).val('0.00');
    $('#price2'+id).removeClass('pricecal2');
    $('#quantity'+id).removeClass('quantitycal2');
    $('#tot_price'+id).val('0.00');
    total_cal();
  }
  console.log($('#price2'+id).val())

}
</script>
<h4><b>Purchase Order Number</b> : <?=$purchase_list->po_code?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <div class="widget-shadow remarks">
      <div class="col-sm-12">
        <b>Suplier Name</b> : <?=$purchase_list->first_name?> <?=$purchase_list->last_name?></br>
        <b>Purchase Date</b> : <?=$purchase_list->send_date?></br>
      </br>
    </br></br>
  </div>

  <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_purchase_orders/<?=$action?>_purchase" enctype="multipart/form-data">
    <input type='hidden' class='form-control' id='number' name='number' value="<?=$id?>">
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
        <tbody>

          <? if($purchase_item_list){
            $n=0;
            foreach ($purchase_item_list as $key => $value) {
              $n=$n+1;
              ?>

              <tr>
                <td><?=$n?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                <td>&nbsp;&nbsp;&nbsp;&nbsp;<? if($value->prj_id=="" || $value->prj_id==0){ echo "Main stock";}else{ echo get_prjname($value->prj_id); }?></td>
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
                    <input type="hidden" class="quantity quantitycal2 form-control" id="quantity<?=$value->req_id?>" value="<?=$value->qty?>" name="quantity[]" pattern="[0-9]+([\.][0-9]{0,2})?" readonly><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>
                    <td><b><?=$value->qty?> &nbsp<?=$value->mt_name?></b></td>

                    <td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="price pricecal2 form-control" value="<?=$value->buying_price?>" id="price2<?=$value->req_id?>" name="price[]" pattern="[0-9]+([\.][0-9]{0,2})?"  <? if($action=='view' || $action=='approve'){?>readonly<?}?>><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>

                    <td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_price form-control" id="tot_price<?=$value->req_id?>" value="<?=$value->qty*$value->buying_price?>" name="tot_price[]" pattern="[0-9]+([\.][0-9]{0,2})?" readonly><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>
                    <td><input type='checkbox' checked="checked" class='form-control' name='check_<?=$value->req_id?>' id='check_2<?=$value->req_id?>' value="YES" onchange="edit_price2('<?=$value->req_id?>')" <? if($action!='edit'){?> disabled="disabled" <?}?>>
                          &nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                      </tr>
                    <?  }}?>

                    <?
                    if($action=='edit'){
                      if($po_orders){
                        $n=0;
                        foreach ($po_orders as $key => $value) {
                          $n=$n+1;
                          ?>
                          <tr>
                            <td><?=$n?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<? if($value->prj_id=="" || $value->prj_id==0){ echo "Main stock";}else{ echo get_prjname($value->prj_id); }?></td>
                            <td class='name'>
                              <input type='hidden' class='form-control ' id='name' name='itemid[]' value="<?=$value->req_id?>">
                              <input type='hidden' class='form-control ' id='prj_id' name='prj_id[]' value="<?=$value->prj_id?>">
                              <input type='hidden' class='form-control ' id='lot_id' name='lot_id[]' value="<?=$value->lot_id?>">
                              <input type='hidden' class='form-control ' id='mat_id' name='mat_id[]' value="<?=$value->mat_id?>">
                              <input type='hidden' class='form-control ' id='req_qty' name='req_qty[]' value="<?=$value->qty?>">
                              <input type='hidden' class='form-control newtext' id='name' name='name[]' value="<?=$value->mat_name?>" readonly>
                              <?=$value->mat_name?>
                            </td>
                            <td><?=$value->req_date?></td>
                              <td class=''><div class="form-group" style=" padding:0; margin:0" ><input type="hidden" class="quantity form-control newtext" id="quantity<?=$value->req_id?>"  name="quantity[]" value="<?=$value->qty?>" pattern="[0-9]+([\.][0-9]{0,2})?" readonly><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>
                                <td><b><?=$value->qty?> &nbsp;<?=$value->mt_name?></b></td>

                                <td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="price form-control newtext" value="0.00" id="price2<?=$value->req_id?>" name="price[]" pattern="[0-9]+([\.][0-9]{0,2})?" readonly><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>

                                  <td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_price form-control newtext" id="tot_price<?=$value->req_id?>" value="0.00" name="tot_price[]" pattern="[0-9]+([\.][0-9]{0,2})?" readonly><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>

                                  <td>
                                    <input type='checkbox' class='form-control' name='check_<?=$value->req_id?>' id='check_2<?=$value->req_id?>' value="YES" onchange="edit_price2('<?=$value->req_id?>')">
                                      &nbsp;&nbsp;&nbsp;&nbsp;
                                  </td>
                                  </tr>
                                <?	}
                              }}?>
                              <tr class="info">
                                <th class='col-sm-6 name' colspan="5">Total</th>
                                <th class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_quantity form-control" id="tot_quantity" value="<?=$purchase_list->tot_quantity?>" name="tot_quantity" pattern="[0-9]+([\.][0-9]{0,2})?" <? if($action=='view' || $action=='approve'){?>readonly<?}?>><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></th>
                                  <th class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_un_price form-control" value="<?=number_format($purchase_list->tot_unit_price,2, '.', '')?>" id="tot_un_price" name="tot_un_price" pattern="[0-9]+([\.][0-9]{0,2})?" <? if($action=='view' || $action=='approve'){?>readonly<?}?>><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></th>

                                    <th class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_tot_price form-control" id="tot_tot_price" value="<?=number_format($purchase_list->tot_price,2, '.', '')?>" name="tot_tot_price" pattern="[0-9]+([\.][0-9]{0,2})?" <? if($action=='view' || $action=='approve'){?>readonly<?}?>><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                      <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></th>
                                    </tr>
                            </tbody>
                          </div>

                        </table>
                      </hr></br></br>
                      <table id="tot_table" border="2">

                            </table>
                          </br></br></br>
                          <? if($action=='approve'){?>
                            <div ><button type="submit" class="btn btn-primary pull-right" >Approve Purchase Order</button>
                            </br></br></br></div>
                            <?}elseif($action=='edit'){?>
                              <div ><button type="submit" class="btn btn-primary pull-right" >Update Purchase Order</button>
                              </br></br></br></div>
                              <?}?>
                            </form>
                          </div></div>
                          <br /><br /><br /><br /></div>
