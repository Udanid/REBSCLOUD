<div class="form-body  form-horizontal" >
  <div class="col-md-6 validation-grids validation-grids-left">
    <div class="" data-example-id="basic-forms">
      <div class="form-body">
        <div id="installment">

          <div class="form-group">
            <label for="loan_type" class="control-label"></label>
            Capital Amount:<input type="number" step="0.01" id="cap_amount" class="form-control" name="cap_amount" value="0.00" onChange="calculate_totpurch()">
            Interest Amount:<input type="number" step="0.01" id="int_amount" class="form-control" name="int_amount" value="0.00" onChange="calculate_totpurch()">
            Total:<input type="text" id="pay_amount" step="0.01" class="form-control" name="pay_amount" value="0.00" readonly>
            <span class="help-block with-errors" ></span>
            <input type="hidden" id="loan_no" name="loan_no" value="<?=$loan_id;?>">
            <input type="hidden" id="leger_id" name="leger_id" value="<?=$leger_id;?>">
              <input type="hidden" id="bank_id" name="bank_id" value="<?=$bank_id;?>">
              <input type="hidden" id="bankname" name="bankname" value="<?=$bankname;?>">
          </div>

        </div>

        <div class="form-group validation-grids" style="float:right">
          <button type="submit" class="btn btn-primary" >Make Payment</button>
        </div>
      </div>

    </div>
  </div>

</div>
<script>
function calculate_totpurch()
{//arc,rds,pcs,extendperch\
var pay_amount=0;
var capital=0;
var interest=0;
	var pay_amount=parseFloat(document.getElementById('pay_amount').value);
	 var capital=parseFloat(document.getElementById('cap_amount').value);
	 var interest=parseFloat(document.getElementById('int_amount').value);
	 pay_amount=capital+interest;
	  document.getElementById('pay_amount').value=pay_amount.toFixed(2);

}
</script>
