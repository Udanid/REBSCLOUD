<script>

$(document).ready(function(){

  $("#external_freeloan_div").hide();
  $("#external_mortgageloan_div").hide();
  $("#external_leaseloan_div").hide();
  $("#external_loan_div").hide();
<?if($loan_byid->loan_type!=''){?>
  var loan_type='<?=$loan_byid->loan_type;?>';
  load_loan_type(loan_type);
<?}?>
  //when succes close button pressed
  $(document).on('click','#close-btn', function(){
    location.reload();
  });

});

function load_loan_type(loan_type){

  if(loan_type == 'free'){
    $("#external_freeloan_div").show();
    $("#external_mortgageloan_div").hide();
    $("#external_leaseloan_div").hide();
    $("#external_loan_div").hide();
  }else if(loan_type == 'mortgage'){
    $("#external_freeloan_div").hide();
    $("#external_mortgageloan_div").show();
    $("#external_leaseloan_div").hide();
    $("#external_loan_div").hide();
  }else if(loan_type == 'lease'){
    $("#external_freeloan_div").hide();
    $("#external_mortgageloan_div").hide();
    $("#external_leaseloan_div").show();
    $("#external_loan_div").hide();
  }else if(loan_type == ''){
    $("#external_freeloan_div").hide();
    $("#external_mortgageloan_div").hide();
    $("#external_leaseloan_div").hide();
    $("#external_loan_div").show();
  }
}

$(document).on('click','#close-btn', function(){
  location.reload();
});


</script>
<h4>Loan No:  <?=$loan_byid->loan_number?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$loan_byid->id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<form data-toggle="validator" id="inputform" name="inputform" method="post" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="form_submit_type" id="form_submit_type" value="insert" />
  <div class="form-title">
    <h5>View Loan</h5>
  </div>

  <div class="col-md-6 validation-grids validation-grids-left">
    <div class="" data-example-id="basic-forms">
      <div class="form-body">
        <div class="form-group">
          <label for="loan_type" class="control-label">Select Loan Type</label>
            <input class="form-control" id="loan_type" name="loan_type" value="<?=$loan_byid->loan_type;?>" readonly>
          <span class="help-block with-errors" ></span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xs-12"><hr></div>

  <div id="loan_div_common" >
    <div class="col-md-6 validation-grids validation-grids-left">
      <div class="" data-example-id="basic-forms">
        <div class="form-body">
          <div class="form-group">
            <label for="loan_number" class="control-label">Loan Number</label>
            <input type="text" class="form-control" id="loan_number" name="loan_number" value="<?=$loan_byid->loan_number?>" placeholder="Loan Number" min="0" readonly>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="interest_rate" class="control-label">Interest Rate</label>
            <input type="number" step="0.01" class="form-control" id="interest_rate" name="interest_rate" value="<?=$loan_byid->interest_rate?>" placeholder="Interest Rate" min="0" readonly>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="monthly_or_maturity" class="control-label">Monthly/Maturity Payment</label>
            <input class="form-control" id="monthly_or_maturity" name="monthly_or_maturity" value="<?=$loan_byid->monthly_or_maturity;?>" readonly>

            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="grace_period" class="control-label">Grace Period</label>
            <input type="number" class="form-control" id="grace_period" name="grace_period" value="<?=$loan_byid->grace_period?>" placeholder="Grace Period" min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" readonly>
            <span class="help-block with-errors" ></span>
          </div>

          <div class="form-group">
            <label for="total_period" class="control-label">Total Instalments(Including Grace Period)</label>
            <input type="number" class="form-control" id="total_period" name="total_period" value="<?=$loan_byid->total_period?>" placeholder="Total Instalments(Including Grace Period)" min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" readonly>
            <span class="help-block with-errors" ></span>
          </div>

          <div class="form-group">
            <label for="loan_date" class="control-label">Loan Date</label>
            <input type="text" class="form-control" id="loan_date" name="loan_date" value="<?=$loan_byid->loan_date?>" placeholder="DD/MM/YYYY" readonly/>
            <span class="add-on"><i class="icon-calendar"></i></span>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="total_period" class="control-label">Leger Account</label>
            <input class="form-control" id="leger_acc" name="leger_acc" value="<?=$loan_byid->leger_account_no;?>" readonly>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="total_period" class="control-label">Credit Leger Account</label>
            <input class="form-control" id="credit_leger_acc" name="credit_leger_acc" value="<?=$loan_byid->credit_leger_acc;?>" readonly>
            <span class="help-block with-errors" ></span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 validation-grids validation-grids-left">
      <div class="" data-example-id="basic-forms">
        <div class="form-body">
          <div class="form-group">
            <label for="loan_amount" class="control-label">Loan Amount</label>
            <input type="number" step="0.01" class="form-control" id="loan_amount" name="loan_amount" value="<?=$loan_byid->loan_amount?>" placeholder="Loan Amount" min="0" readonly>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="onetime_charges" class="control-label">One-time Charges</label>
            <input type="number" step="0.01" class="form-control" id="onetime_charges" name="onetime_charges" value="<?=$loan_byid->onetime_charges?>" placeholder="One-time Charges" min="0" readonly>
            <span class="help-block with-errors" ></span>
          </div>

          <div class="form-group">
            <label for="fixed_vary_installments" class="control-label">Fixed/Vary Installments</label>
              <input class="form-control" id="fixed_vary_installments" name="fixed_vary_installments" value="<?=$loan_byid->fixed_vary_installments;?>" readonly>

          </div>
          <div class="form-group">
            <label for="grace_period_installment_value" class="control-label">Grace Period Installment Value</label>
            <input type="number" step="0.01" class="form-control" id="grace_period_installment_value" name="grace_period_installment_value" value="<?=$loan_byid->grace_period_installment_value?>" placeholder="Grace Period Installment Value" readonly>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="loan_installment_value" class="control-label">Installment Value</label>
            <input type="number" step="0.01" class="form-control" id="loan_installment_value" name="loan_installment_value" value="<?=$loan_byid->loan_installment_value?>" placeholder="Installment Value" readonly>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="loan_date" class="control-label">Loan Payment Date</label>
            <input type="text" class="form-control" id="loan_paymentdate" name="loan_paymentdate" value="<?=$loan_byid->payment_start_date?>th Of Every Month" placeholder="DD" readonly/>
            <span class="add-on"><i class="icon-calendar"></i></span>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
              <label for="method" class="control-label">Payment Method</label>

              <?if($loan_byid->payment_method=="1"){?>
              <input name="method" id="method" class="form-control" value="Deduct From Bank" readonly>
              <?}else if($loan_byid->payment_method=="2"){?>
              <input name="method" id="method" class="form-control" value="Dated Cheque Issued" readonly>
              <?}else if($loan_byid->payment_method=="3"){?>
              <input name="method" id="method" class="form-control" value="Post Dated Cheque" readonly>
              <?}?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-12"><hr></div>
  </div>
  <div class="col-md-12 ">
    <div class="" data-example-id="basic-forms">
      <div class="form-title">
        <h5>Loan Details</h5>
      </div>
    </div>
  </div>
  <div id="external_freeloan_div">
    <div class="col-md-6 validation-grids validation-grids-left">

    </div>
  </div>
  <div id="external_mortgageloan_div">

    <div class="col-md-6 validation-grids">
      <div class="" data-example-id="basic-forms">
        <div class="form-body">
          <div class="form-group">
            <label for="projects" class="control-label">Projects</label>

            <?
            if($prjName[$loan_byid->asset_id]!=''){ ?>
            <input class="form-control" id="project" name="project" value="<?=$prjName[$loan_byid->asset_id]->land_code;?> - <?=$prjName[$loan_byid->asset_id]->project_name;?>" readonly>
            <?
            } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 validation-grids">
      <div class="" data-example-id="basic-forms">
        <div class="form-body">
          <div class="form-group">
            <label for="projects" class="control-label">Blocks</label>
            <?php
            foreach ($blockList[$loan_byid->asset_id] as $key => $value) { ?>
            <input class="form-control" id="lots" name="lots" value="<?=$value->lot_no;?>" readonly>
            <?
            } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="external_leaseloan_div">
    <div class="col-md-6 validation-grids validation-grids-left">
      <div class="" data-example-id="basic-forms">
        <div class="form-body">
          <div class="form-group">
            <label for="projects" class="control-label">Assets</label>
            <?
            if($assetName[$loan_byid->asset_id]!=''){ ?>
            <input class="form-control" id="assets" name="assets" value="<?=$assetName[$loan_byid->asset_id]->asset_code;?> - <?=$assetName[$loan_byid->asset_id]->asset_name;?>" readonly>
            <?
            } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="external_loan_div">
    <div class="col-md-6 validation-grids validation-grids-left">
      <div class="form-title">
        <h5>External Loan</h5>
      </div>
    </div>
  </div>
  <div class="col-xs-12"><hr></div>
  <div class="col-md-12 ">
    <div class="" data-example-id="basic-forms">
    <div class="form-title">
      <h5>Bank Account Details</h5>
    </div>
    <div class="form-body">
      <div class="form-inline">
        <div class="form-group">
          <input type="text" name="bank1" id="bank1" class="form-control" placeholder="Bank" value="<?=$banknames[$loan_byid->bank_code]->BANKNAME?>" readonly>

        </div>&nbsp;<div class="form-group" id="branch-1">
          <input type="text" name="branch1" id="branch1" class="form-control" placeholder="Bank" value="<?=$loan_byid->branch_id?>" readonly>

        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control"name="acc1" id="acc1" value="<?=$loan_byid->bank_account_no;?>"  placeholder="Account Number" data-error="" readonly>

        </div>
      </div>
      <br>


      </div>
    </div>
  </div>
</form>

<script>
$(document).ready(function(){

  $( "#project" ).change(function() {
  var id=$( "#project" ).val();
  $( "#lots option" ).remove();
    $.ajax({
      headers: {
        Accept: 'application/json'
      },
      type: 'post',
      url: '<?=base_url()?>accounts/Loan/get_blocks',
      data: {id: id},
      dataType: "json",
            success: function(result){
              $( "#lots" ).append('<option value="">-- Lots --</option>');
              jQuery.each(result, function(index, item) {

                $( "#lots").append('<option value="'+item.lot_number+'">'+item.lot_number+'</option>');
            });
            },
            error: function() {
              alert("some error");
            }

        });
  });

});
</script>
