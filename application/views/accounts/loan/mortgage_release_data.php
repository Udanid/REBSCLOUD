<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/multi-select.css">
<div class="col-md-12">
<form data-toggle="validator" id="inputform" name="inputform" method="post" action="<?=base_url()?>accounts/loan/mortgage_update/<?=$loan_byid->id?>" enctype="multipart/form-data">
<input type="hidden" name="loan_id" id="loan_id" value="<?=$loan_byid->id?>" />
<input type="hidden" name="prj_id" id="prj_id" value="<?=$loan_byid->asset_id?>" />
<div class="col-md-6">
<div class="" data-example-id="basic-forms">
  <div class="form-body">
    <div class="form-group">
      <label for="loan_number" class="control-label">Loan Number</label>
      <input type="text" class="form-control" id="loan_number" name="loan_number" value="<?=$loan_byid->loan_number?>" readonly>
      <span class="help-block with-errors" ></span>
    </div>
    <div class="form-group">
      <label for="loan_number" class="control-label">Project Name</label>
      <input type="text" class="form-control" id="prj" name="prj" value="<?=$prj->project_name?>" readonly>
      <span class="help-block with-errors" ></span>
    </div>

        <div class="form-group">
      <label for="lots" class="control-label">Blocks</label>
      <select class="form-control" id="lots2" name="lots2[]" multiple='multiple' >

        <?

        foreach ($lots_no as $key2 => $value2) {

          ?>
            <option data-lotval="<?=$value2->mortgage_extend;?>" data-lotperch="<?=$value2->value_per_perch;?>" value="<?=$value2->lot_no;?>"><?=$value2->lot_no;?></option>
        <?
      }
  ?>
      </select>
      <span class="help-block with-errors" ></span>
    </div>
    </div>
    </div></div>
<div class="col-md-6">
      <div class="form-group">
    <label for="lots" class="control-label">Released Blocks</label>

    </select>
    <table class="table" id="lottable">
      <thead>
        <tr>
          <th>Lot No</th>
          <th>Perch Extend</th>
          <th>Perch Value</th>
          <th>Total Value</th>
        </tr>
      </thead>

      <tbody>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
    <span class="help-block with-errors" ></span>
  </div>
  </div>

    <div class="bottom validation-grids">

      <div class="form-group">
        <button type="submit" class="btn btn-primary">Release Block</button>
      </div>
      <div class="clearfix"> </div>
    </div>
  </div>
</div>
</form>
</div>
<script src="<?=base_url()?>media/js/jquery.multi-select.js"></script>
<script>
$('#lots2').multiSelect();
$(document).ready(function(){
  $('#lots2').on('change', function() {
var selected = $(this).find('option:selected', this);
//var lotarray = [];
var totalperch = 0;
var totalval = 0;
var tot_tot = 0;
$('#lottable tbody').html('');
$('#lottable tfoot').html('');
selected.each(function() {
    var val=$(this).data('lotval');
    var perch=$(this).data('lotperch');
    var tot=val*perch;
    tot_tot=tot_tot+tot;
    totalval =totalval+ $(this).data('lotval');
    totalperch =totalperch+ parseInt($(this).data('lotperch'));
    //lotarray.push($(this).data('lotval'));
    $('#lottable tbody').append('<tr><td>'+$(this).val()+'</td><td>'+$(this).data('lotval')+'</td><td>'+$(this).data('lotperch')+'</td><td>'+tot+'</td><tr/>')


});

//alert(lotarray)
//$('#lotperch').val(totalperch)
$('#lottable tfoot').append('<tr><th></th><th>'+totalval+'</th><th>'+totalperch.toFixed(2)+'</th><th>'+tot_tot.toFixed(2)+'</th><tr/>')
});
});
</script>
