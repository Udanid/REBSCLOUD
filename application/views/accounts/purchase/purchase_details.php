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
    //function total_cal()
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
      $(".addrow").click(function(){
          $("#purchase_table tbody").append( '<tr><td class="col-sm-6 name"><input type="text" class="form-control" id="name" name="name[]"></td>'+
        '<td ><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="quantity form-control" id="quantity" value="0" name="quantity[]" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>'+
'<span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>'+

          '<td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="price form-control" value="0.00" id="price" name="price[]" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>'+
'<span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>'+

          '<td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_price form-control" id="tot_price" value="0.00" name="tot_price[]" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>'+
'<span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>'+
          '<td><img src="<?=asset_url()?>images/icons/delete.png" border="0" alt="Remove row" class="deleterow"></td></tr>');

      });
  });

  $(document).on('click','table td .deleterow', function() {//change .live to .on
  $(this).parent().parent().remove();
  window.total_cal();

});


</script>
<h4><b>Purchase Order Number</b> : <?=$purchase_list->purchase_number?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <div class="widget-shadow remarks">
    <div class="col-sm-12">
    <b>Suplier Name</b> : <?=$purchase_list->first_name?> <?=$purchase_list->last_name?></br>
    <b>Purchase Date</b> : <?=$purchase_list->purchase_date?></br>
    <b>Purchase Type</b> :
    <? if($purchase_list->purchase_type=='P'){
      echo "Project";
     }elseif($purchase_list->purchase_type=='F'){
      echo "Fixed Asset";
    }elseif($purchase_list->purchase_type=='O'){
      echo "Other";
    }?></br>
</br></br>
  </div>

  <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/purchase/<?=$action?>_purchase" enctype="multipart/form-data">
    <input type='hidden' class='form-control' id='number'    name='number' value="<?=$id?>">
    <table class="tables" id="purchase_table">
      <thead>
      <tr>

        <th>Item Name</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total</th>
        <th ></th>
        <th ></th>
      </tr>
      </thead>
      <div class="form-body form-inline">
    <tbody>
      <? if($purchase_item_list){foreach ($purchase_item_list as $key => $value) {?>

      <tr>
        <td class='col-sm-6 name'><input type='text' class='form-control ' id='name' name='name[]' value="<?=$value->item_name?>" <? if($action=='view' || $action=='approve'){?>readonly<?}?>></td>
      <td class=''><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="quantity form-control" id="quantity" value="<?=$value->quantity?>" name="quantity[]" pattern="[0-9]+([\.][0-9]{0,2})?" <? if($action=='view' || $action=='approve'){?>readonly<?}?>><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>
      <td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="price form-control" value="<?=$value->unit_price?>" id="price" name="price[]" pattern="[0-9]+([\.][0-9]{0,2})?" <? if($action=='view' || $action=='approve'){?>readonly<?}?>><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>

        <td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_price form-control" id="tot_price" value="<?=$value->tot_price?>" name="tot_price[]" pattern="[0-9]+([\.][0-9]{0,2})?" <? if($action=='view' || $action=='approve'){?>readonly<?}?>><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>
          <? if($action!='view' && $action!='approve'){?>
        <td><img src='<?=asset_url()?>images/icons/delete.png' border='0' alt='Remove row' class='deleterow'></td>
        <td><img src='<?=asset_url()?>images/icons/add.png' border='0' alt='Add row' class='addrow'></td>
        <?}?>
        </tr>
      <?  }}else{?>
        <tr>
          <td class='col-sm-6 name'><input type='text' class='form-control ' id='name' name='name[]'></td>
        <td class=''><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="quantity form-control" id="quantity" value="0" name="quantity[]" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>
        <td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="price form-control" value="0.00" id="price" name="price[]" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>

          <td class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_price form-control" id="tot_price" value="0.00" name="tot_price[]" pattern="[0-9]+([\.][0-9]{0,2})?"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></td>
          <td><img src='<?=asset_url()?>images/icons/delete.png' border='0' alt='Remove row' class='deleterow'></td>
          <td><img src='<?=asset_url()?>images/icons/add.png' border='0' alt='Add row' class='addrow'></td>

          </tr>
    <?  }?>
    </tbody>
    </div>

    </table>
    </hr></br></br>
    <table id="tot_table" border="2">
      <tr >
        <th class='col-sm-6 name'>Total</th>
      <th class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_quantity form-control" id="tot_quantity" value="<?=$purchase_list->tot_quantity?>" name="tot_quantity" pattern="[0-9]+([\.][0-9]{0,2})?" <? if($action=='view' || $action=='approve'){?>readonly<?}?>><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></th>
      <th class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_un_price form-control" value="<?=number_format($purchase_list->tot_unit_price,2, '.', '')?>" id="tot_un_price" name="tot_un_price" pattern="[0-9]+([\.][0-9]{0,2})?" <? if($action=='view' || $action=='approve'){?>readonly<?}?>><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></th>

        <th class="text-right"><div class="form-group" style=" padding:0; margin:0" ><input type="text" class="tot_tot_price form-control" id="tot_tot_price" value="<?=number_format($purchase_list->tot_tot_price,2, '.', '')?>" name="tot_tot_price" pattern="[0-9]+([\.][0-9]{0,2})?" <? if($action=='view' || $action=='approve'){?>readonly<?}?>><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <span class="help-block with-errors" style=" padding:0; margin:0"></span></div></th>
        </tr>
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
