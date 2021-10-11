<script>

$(document).ready(function(){
  $("#bank1").chosen({
    allow_single_deselect : true
  });
  $("#branch1").chosen({
    allow_single_deselect : true
  });
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
function loadbranchlist(itemcode,caller)
{
  var code=itemcode.split("-")[0];
  if(code!=''){
    //alert(code)
    //$('#popupform').delay(1).fadeIn(600);
    $( "#branch-"+caller ).load( "<?=base_url()?>common/get_bank_branchlist/"+itemcode+"/"+caller );}

  }
function call_edit(id) {
  $('#popupform').delay(1).fadeIn(600);
  $("#popupform").load( "<?=base_url()?>accounts/loan/editloan/"+id );

}


</script>
<h4>Loan No:  <?=$loan_byid->loan_number?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$loan_byid->id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<form data-toggle="validator" id="inputform" name="inputform" method="post" method="post" action="<?=base_url()?>accounts/loan/editloan_update/<?=$loan_byid->id?>" enctype="multipart/form-data">
  <input type="hidden" name="form_submit_type" id="form_submit_type" value="insert" />
  <div class="form-title">
    <h5>Edit Loan</h5>
  </div>

  <div class="col-md-6 validation-grids validation-grids-left">
    <div class="" data-example-id="basic-forms">
      <div class="form-body">
        <div class="form-group">
          <label for="loan_type" class="control-label">Select Loan Type</label>
          <select class="form-control" id="loan_type" name="loan_type" onChange="load_loan_type(this.value);" required>
            <option value="">--Select Loan Type--</option>
            <option value="free" <?if($loan_byid->loan_type=="free"){?>selected="selected"<?}?>>Free Loan</option>
            <option value="mortgage" <?if($loan_byid->loan_type=="mortgage"){?>selected="selected"<?}?>>Mortgage/Project Loan</option>
            <option value="lease" <?if($loan_byid->loan_type=="lease"){?>selected="selected"<?}?>>Lease</option>
          </select>
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
            <input type="text" class="form-control" id="loan_number" name="loan_number" value="<?=$loan_byid->loan_number?>" placeholder="Loan Number" min="0" required>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="interest_rate" class="control-label">Interest Rate</label>
            <input type="number" step="0.01" class="form-control" id="interest_rate" name="interest_rate" value="<?=$loan_byid->interest_rate?>" placeholder="Interest Rate" min="0" required>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="monthly_or_maturity" class="control-label">Monthly/Maturity Payment</label>
            <select class="form-control" id="monthly_or_maturity" name="monthly_or_maturity" required>
              <option value="">--Select Monthly/Maturity--</option>
              <option value="monthly" <?if($loan_byid->monthly_or_maturity=="monthly"){?>selected="selected"<?}?>>Monthly</option>
              <option value="maturity" <?if($loan_byid->monthly_or_maturity=="maturity"){?>selected="selected"<?}?>>Maturity</option>
            </select>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="grace_period" class="control-label">Grace Period</label>
            <input type="number" class="form-control" id="grace_period" name="grace_period" value="<?=$loan_byid->grace_period?>" placeholder="Grace Period" min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" required>
            <span class="help-block with-errors" ></span>
          </div>

          <div class="form-group">
            <label for="total_period" class="control-label">Total Instalments(Including Grace Period)</label>
            <input type="number" class="form-control" id="total_period" name="total_period" value="<?=$loan_byid->total_period?>" placeholder="Total Instalments(Including Grace Period)" min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" required>
            <span class="help-block with-errors" ></span>
          </div>

          <div class="form-group">
            <label for="loan_date" class="control-label">Loan Date</label>
            <input type="date" class="form-control" id="loan_date" name="loan_date" value="<?=$loan_byid->loan_date?>" placeholder="DD/MM/YYYY" required/>
            <span class="add-on"><i class="icon-calendar"></i></span>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="fixed_vary_installments" class="control-label">Leger Account</label>
            <select class="form-control" id="leger_acc" name="leger_acc" required>
              <option value="">--Select Leger Account--</option>
              <?php
              foreach ($legers as $key => $value) {?>
                <option value="<?=$value->id;?>" <?if($loan_byid->leger_account_no==$value->id){?>selected="selected"<?}?>><?=$value->id;?> - <?=$value->name;?></option>
            <?php  }
              ?>
            </select>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="fixed_vary_installments" class="control-label">Credit Leger Account</label>
            <select class="form-control" id="credit_leger_acc" name="credit_leger_acc" required>
              <option value="">--Select Credit Leger Account--</option>
              <?php
              foreach ($legers as $key => $value) {?>
                <option value="<?=$value->id;?>" <?if($loan_byid->credit_leger_acc==$value->id){?>selected="selected"<?}?>><?=$value->id;?> - <?=$value->name;?></option>
            <?php  }
              ?>
            </select>
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
            <input type="number" step="0.01" class="form-control" id="loan_amount" name="loan_amount" value="<?=$loan_byid->loan_amount?>" placeholder="Loan Amount" min="0" required>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="onetime_charges" class="control-label">One-time Charges</label>
            <input type="number" step="0.01" class="form-control" id="onetime_charges" name="onetime_charges" value="<?=$loan_byid->onetime_charges?>" placeholder="One-time Charges" min="0" required>
            <span class="help-block with-errors" ></span>
          </div>

          <div class="form-group">
            <label for="fixed_vary_installments" class="control-label">Fixed/Vary Installments</label>
            <select class="form-control" id="fixed_vary_installments" name="fixed_vary_installments" required>
              <option value="">--Select Fixed/Vary--</option>
              <option value="fixed" <?if($loan_byid->fixed_vary_installments=="fixed"){?>selected="selected"<?}?>>Fixed</option>
              <option value="vary" <?if($loan_byid->fixed_vary_installments=="vary"){?>selected="selected"<?}?>>Vary</option>
            </select>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="grace_period_installment_value" class="control-label">Grace Period Installment Value</label>
            <input type="number" step="0.01" class="form-control" id="grace_period_installment_value" name="grace_period_installment_value" value="<?=$loan_byid->grace_period_installment_value?>" placeholder="Grace Period Installment Value" required>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="loan_installment_value" class="control-label">Installment Value</label>
            <input type="number" step="0.01" class="form-control" id="loan_installment_value" name="loan_installment_value" value="<?=$loan_byid->loan_installment_value?>" placeholder="Installment Value" required>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="loan_date" class="control-label">Loan Payment Date</label>
            <input type="text" class="form-control" id="loan_paymentdate" name="loan_paymentdate" value="<?=$loan_byid->payment_start_date?>" placeholder="DD" required/>
            <span class="add-on"><i class="icon-calendar"></i></span>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
              <label for="method" class="control-label">Payment Method</label>
              <select name="method" id="method" class="form-control" >
                <option value="0">--Select Payment Method--</option>
                <option value="1" <?if($loan_byid->payment_method=="1"){?>selected="selected"<?}?>>Deduct From Bank</option>
                <option value="2" <?if($loan_byid->payment_method=="2"){?>selected="selected"<?}?>>Dated Cheque Issued</option>
                <option value="3" <?if($loan_byid->payment_method=="3"){?>selected="selected"<?}?>>Post Dated Cheque</option>

              </select>
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
<input type="hidden" class="form-control" id="sub_type" name="sub_type" value="<?=$loan_byid->sub_loan_type?>" />
    <div class="col-md-6 validation-grids">
      <div class="" data-example-id="basic-forms">
        <div class="form-body">
          <div class="form-group">
            <label for="projects" class="control-label">Projects</label>
            <select class="form-control" id="project" name="project">
              <option value="">-- Projects --</option>
              <?
              foreach ($prjlist as $key => $value) {?>
                <option value="<?=$value->prj_id?>" <?if($loan_byid->asset_id==$value->prj_id){?>selected="selected"<?}?>><?=$value->project_code?>-<?=$value->project_name?></option>
                <?
              }
              ?>
            </select>
            <span class="help-block with-errors" ></span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 validation-grids">
      <div class="" data-example-id="basic-forms">
        <div class="form-body">
          <div class="form-group">
            <?
            $lotval=0;
            $lotper_perch=0;
            function searcharray($value, $key, $array) {
              foreach ($array as $k => $val) {
                if ($val->$key == $value) {
                  return $k;
                }
              }
              return null;
            }
              ?>
            <label for="lots" class="control-label">Blocks</label>
            <select class="form-control" id="lots2" name="lots2[]" multiple='multiple' >
              <?
              $lotval=0;
              $lotper_perch=0;

              foreach ($lots_no[$loan_byid->asset_id] as $key2 => $value2) {
                $lotval=$lotval+$value2->mortgage_extend;
                $lotper_perch=$value2->value_per_perch;
                $results = searcharray($value2->lot_no, 'lot_number', $blocks_prj);
                //print $results;
                unset($blocks_prj[$results]);
                ?>
                  <option data-lotval="<?=$value2->mortgage_extend;?>" data-lotperch="<?=$value2->value_per_perch;?>" value="<?=$value2->lot_no;?>" selected><?=$value2->lot_no;?></option>
              <?
              }


                foreach ($blocks_prj as $key => $value) {
                  if($value->extend_perch>1){
                  ?>
                  <option data-lotval="<?=$value->extend_perch;?>" data-lotperch="<?=$value->price_perch;?>" value="<?=$value->lot_number;?>"><?=$value->lot_number;?></option>
              <?
            }}
              ?>

            </select>
            <span class="help-block with-errors" ></span>
          </div>
          <div class="form-group">
            <label for="lotval" class="control-label">Mortgage Extent</label>
            <input name="lotval" id="lotval" class="form-control" value="<?=$lotval?>">
            <div id="arraydiv"></div>

            <span class="help-block with-errors" ></span>
          </div>

          <div class="form-group">
            <label for="lotval" class="control-label">Value per perch</label>
            <input name="lotperch" id="lotperch" type="text" class="form-control" value="<?=$lotper_perch?>">

            <span class="help-block with-errors" ></span>
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
            <select class="form-control" id="assets" name="assets" >
              <option value="">-- Assets --</option>
              <?
              foreach ($assetlist as $key => $value) {?>
                <option value="<?=$value->id?>"<?if($loan_byid->asset_id==$value->id){?>selected="selected"<?}?>><?=$value->asset_code?>-<?=$value->asset_name?></option>
              <?
            }
              ?>

            </select>
            <span class="help-block with-errors" ></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="external_loan_div">
    <div class="col-md-6 validation-grids validation-grids-left">

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
          <select name="bank1" id="bank1" class="form-control" placeholder="Bank" onChange="loadbranchlist(this.value,'1')" >
            <option value="">Bank</option>
            <? foreach ($banklist as $raw){?>
              <option value="<?=$raw->BANKCODE?>" <?if($loan_byid->bank_code==$raw->BANKCODE){?>selected="selected"<?}?>><?=$raw->BANKNAME?></option>
            <? }?>

          </select>
        </div>&nbsp;<div class="form-group" id="branch-1">
          <select name="branch1" id="branch1" class="form-control" placeholder="Bank" >
            <option value="<?=$loan_byid->branch_id?>"><?=$loan_byid->branch_id?></option>


          </select>
        </div>
        <div class="form-group has-feedback">
          <input type="text" class="form-control"name="acc1" id="acc1" value="<?=$loan_byid->bank_account_no;?>"  placeholder="Account Number" data-error="" >

        </div>
      </div>
      <br>

      <div class="bottom validation-grids">

        <div class="form-group">
          <button type="submit" class="btn btn-primary disabled">Submit</button>
        </div>
        <div class="clearfix"> </div>
      </div>

      </div>
    </div>
  </div>
</form>

<script>
$(document).ready(function(){


    $('#lots2').on('change', function() {
  var selected = $(this).find('option:selected', this);
  var totalperch = 0;
  var totalval = 0;
  selected.each(function() {
      var lotsval=$(this).data('lotval');
      totalval =totalval+ $(this).data('lotval');
      totalperch =totalperch+ $(this).data('lotperch');
  });

  $('#lotval').val(totalval.toFixed(2))



  });
  $( "#project" ).change(function() {
    var id=$( "#project" ).val();
    const selectlots = $("#lots2");
       selectlots.empty();
      $.ajax({
        headers: {
          Accept: 'application/json'
        },
        type: 'post',
        url: '<?=base_url()?>accounts/loan/get_blocks',
        data: {id: id},
        dataType: "json",
              success: function(result){
                $( "#lots2" ).append('<option value="">-- Lots --</option>');
                jQuery.each(result, function(index, item) {

                  selectlots.append('<option data-lotval="'+item.extend_perch+'" data-lotperch="'+item.price_perch+'" value="'+item.lot_number+'">'+item.lot_number+'</option>');

              });
              selectlots.multiSelect('refresh');
              },
              error: function() {
                alert("some error");
              }

          });
    });

});
$('#lots2').multiSelect();
</script>
