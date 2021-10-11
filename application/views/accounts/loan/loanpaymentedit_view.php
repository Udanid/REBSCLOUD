<script>
function close_edit(id){
  $('#popupform').delay(1).fadeOut(800);
}



</script>
<h4>Loan No:  <?=$loanname;?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$paydata->pay_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<form data-toggle="validator" id="inputform" name="inputform" method="post" action="<?=base_url()?>accounts/loan/editpayments/<?=$paydata->pay_id?>" enctype="multipart/form-data">
  <input type="hidden" name="form_submit_type" id="form_submit_type" value="insert" />
  <div class="form-title">
    <h5>Edit Payment</h5>
  </div>

  <div class="col-md-6 validation-grids validation-grids-left">
    <div class="" data-example-id="basic-forms">
      <div class="form-body">
        <div class="form-group">
          
          <label for="loan_type" class="control-label">Payment Amount</label>
            <input class="form-control" type="text" id="pay_amount" name="pay_amount" value="<?=$payamount;?>">
            <input class="form-control" type="hidden" id="loan_no" name="loan_no" value="<?=$loan_no;?>">
            <input class="form-control" type="hidden" id="pay_id" name="pay_id" value="<?=$paydata->pay_id;?>">
          <span class="help-block with-errors" ></span>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>




  <div class="col-xs-12"><hr></div>

</form>
