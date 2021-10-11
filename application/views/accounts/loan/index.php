<!DOCTYPE HTML>
<html>
<head>
  <?php
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
  $this->load->view("includes/topbar_accounts"); ?>
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/multi-select.css">


  <script>

  $(document).ready(function(){
    $('#lots').on('change', function() {
 var selected = $(this).find('option:selected', this);
 //var lotarray = [];
 var totalperch = 0;
 var totalval = 0;
 //$('#arraydiv').html('');
 selected.each(function() {
      var lotsval=$(this).data('lotval');
      totalval =totalval+ $(this).data('lotval');
      totalperch =totalperch+ $(this).data('lotperch');
      //lotarray.push($(this).data('lotval'));
      //c='<input type="text" class="form-control" name="lotvalarray" placeholder="" />';
      //$('#arraydiv').append($(c))


 });

 //alert(lotarray)
 //$('#lotperch').val(totalperch)
 $('#lotval').val(totalval.toFixed(2))
});

    $( "#loan_date" ).datepicker({dateFormat: 'yy-mm-dd',changeMonth: true,
    changeYear: true,
    showButtonPanel: true});

    var loan_date=$( "#loan_date" ).val();
    var loan_payment=$( "#loan_paymentdate" ).datepicker({changeMonth: false,
      changeYear: false,
      showButtonPanel: true,
      dateFormat: 'dd'});

      $("#bank1").chosen({
        allow_single_deselect : true
      });
      $("#branch1").chosen({
        allow_single_deselect : true
      });
      $("#leger_acc").chosen({
        allow_single_deselect : true
      });
      $("#credit_leger_acc").chosen({
        allow_single_deselect : true
      });
      $("#external_freeloan_div").hide();
      $("#external_mortgageloan_div").hide();
      $("#external_leaseloan_div").hide();
      $("#external_loan_div").hide();
      $("#assets_div").hide();
      $("#projects_div").hide();

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
    function sub_loan_type(sub_loan_type){

      if(sub_loan_type == 'fixed_assets'){
        $("#assets_div").show();
        $("#projects_div").hide();
      }else if(sub_loan_type == 'inventory'){
        $("#projects_div").show();
        $("#assets_div").hide();
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
      function call_edit_later(id) {
        $('#popupform').delay(1).fadeIn(600);
        $("#popupform").load( "<?=base_url()?>accounts/loan/editloan_later/"+id );

      }
      function close_edit(id){
        $('#popupform').delay(1).fadeOut(800);
      }
      function get_payment_shedule(id) {
        $('#popupform').delay(1).fadeIn(600);
        $("#popupform").load( "<?=base_url()?>accounts/loan/shedule_view/"+id );
      }
      function call_details(id) {
        $('#popupform').delay(1).fadeIn(600);
        $("#popupform").load( "<?=base_url()?>accounts/loan/view_otherdetails/"+id );
      }
      function loan_fulldata(id)
      {
        if(id!=""){
          $('#loandata').delay(1).fadeIn(600);
          document.getElementById("loandata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
          $( "#loandata" ).load( "<?=base_url()?>accounts/loan/get_loanfulldata/"+id );
        }
        else
        {

          $('#loandata').delay(1).fadeOut(600);
        }
      }


      </script>

      <!-- main content start-->
      <div id="page-wrapper">
        <div class="main-page">
          <div class="table">
            <h3 class="title1">Loan</h3>
            <div class="widget-shadow">
              <div class="  widget-shadow" data-example-id="basic-forms">
                <ul id="myTabs" class="nav nav-tabs" role="tablist">
                  <li role="presentation"   <? if($home_class!='Active'){?>class="active"<?}?> >
                    <a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Create Loan</a>
                  </li>
                  <li role="presentation"  <? if($home_class=='Active'){?>class="active"<?}?>>
                    <a href="#home" role="tab" id="home-tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Loan List</a>
                  </li>
                  <li role="presentation"  >
                    <a href="#loaninquery" role="tab" id="loaninquery-tab" data-toggle="tab" aria-controls="loaninquery" aria-expanded="true">Loan Inquiry</a>
                  </li>
                <!-- <li role="presentation"  >
                    <a href="#loan" role="tab" id="loan-tab" data-toggle="tab" aria-controls="loan" aria-expanded="true">Confirmed Loan List</a>
                  </li>-->
                </ul>

                <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
                  <div role="tabpanel" class="tab-pane fade <? if($home_class=='Active'){?>active in<?}?>" id="home" aria-labelledby="home-tab">
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                      <table class="table">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Loan Number</th>
                            <th>Loan Type</th>
                            <th>Loan Amount</th>
                            <th>Institute</th>
                            <th>Loan Date</th>
                            <th>Rental Date</th>
                            <th>Total Amount Paid</th>
                            <th>Total instalment paid</th>
                            <th>Total amount due</th>
                            <th>Total instalments due</th>
                            <th>Status</th>
                            <th>Edit/View</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if($datalist){
                            $c = 0;
                            $count = 1;
                            $totpay_amount=0.00;
                            $tot_instalment=0.00;
                            $tot_amount_due=0.00;
                            $installment_due=0.00;
                            foreach($datalist as $row){

                                ?>
                                <tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                                  <td><?php echo $count; ?></td>
                                  <td><?php echo $row->loan_number; ?></td>
                                  <td>
                                    <?php
                                    if($row->loan_type == "free"){
                                      $loan_type = "Free Loan";
                                    }else if($row->loan_type == "mortgage"){
                                      $loan_type = "Mortgage";
                                    }else if($row->loan_type == "lease"){
                                      $loan_type = "Lease";
                                    }
                                    echo $loan_type; ?>
                                  </td>
                                  <td class="text-right"><?=number_format($row->loan_amount,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                  <td><?=$banknames[$row->bank_code]->BANKNAME;?></td>
                                  <td><?=$row->loan_date;?></td>
                                  <td><?php
                                  if($row->payment_start_date){
                                    $num=$row->payment_start_date;
                                    $th_val='th';
                                    $num = $num % 100; // protect against large numbers
                                    if($num < 11 || $num > 13){
                                      switch($num % 10){
                                        case 1: $th_val= 'st';
                                        case 2: $th_val= 'nd';
                                        case 3: $th_val= 'rd';
                                      }
                                    }

                                    echo $row->payment_start_date.$th_val." Of Every Month"
                                    ?>
                                    <?}
                                    ?></td>
                                    <td class="text-right"><?=number_format($totpay_amount,2);?></td>
                                    <td class="text-right"><?=number_format($tot_instalment,2);?></td>
                                    <td class="text-right"><?=number_format($tot_amount_due,2);?></td>
                                    <td class="text-right"><?=number_format($pending_shedule[$row->id]->pendinginstalment_count,0);?></td>

                                  <td>
                                    <?php
                                    $status='';
                                    if($row->loan_status == "pending"){
                                      $status = "Pending";
                                    }else if($row->loan_status == "approved"){
                                      $status = "Confirmed";
                                    }else if($row->loan_status == "disapproved"){
                                      $status = "Disapproved";
                                    }
                                    echo $status; ?>
                                  </td>
                                  <td align="right">
                                    <div id="checherflag">

                                      <?php
                                      if($row->loan_status == "pending"){ ?>
                                        <a href="javascript:call_edit('<?php echo $row->id;?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                                        <?php
                                      }else if($row->loan_status == "approved"){?>
                                        <a href="javascript:call_confirm('<?php echo $row->id;?>')" title="Confirmed"><i class="fa fa-check nav_icon icon_green"></i></a>
                                        <a  href="javascript:get_payment_shedule('<?php echo $row->id;?>')" title="Repayment Schedule"><i class="fa fa-calendar nav_icon icon_green"></i></a>
                                        <?php if($row->loan_type == "mortgage" || $row->loan_type == "lease"){?>
                                          <a href="javascript:call_details('<?php echo $row->id;?>')" title="View Details"><i class="fa fa-external-link-square nav_icon icon_blue"></i></a>
                                          <a href="javascript:call_edit_later('<?php echo $row->id;?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>

                                        <?  }?>
                                        <?}
                                        ?>
                                      </div>
                                    </td>
                                  </tr>
                                  <?php
                                  $count++;
                                }
                               }?>
                            </tbody>
                          </table>
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                        </div>
                      </div>
                      <!--table end-->
                      <div role="tabpanel" class="tab-pane fade" id="loan" aria-labelledby="loan-tab">
                        <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                          <table class="table">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Loan Number</th>
                                <th>Institute</th>
                                <th>Loan Amount</th>
                                <th>Loan Date</th>
                                <th>Rental Date</th>
                                <th>Total Amount Paid</th>
                                <th>Total instalment paid</th>
                                <th>Total amount due</th>
                                <th>Total instalments due</th>
                                <th>Type of loan</th>
                                <th>View</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              if($datalist){
                                $c = 0;
                                $count = 1;
                                $totpay_amount=0.00;
                                $tot_instalment=0.00;
                                $tot_amount_due=0.00;
                                $installment_due=0.00;
                                foreach($datalist as $row){
                                  if($row->loan_status == "approved"){
                                    if(!empty($paid_details[$row->id]->totpay_amount)){
                                      $totpay_amount=$paid_details[$row->id]->totpay_amount;
                                    }
                                    if(!empty($paid_shedule[$row->id]->tot_instalment)){
                                      $tot_instalment=$paid_shedule[$row->id]->tot_instalment;
                                    }
                                    $tot_amount_due=$row->loan_amount-$totpay_amount;


                                    ?>
                                    <tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                                      <td><?php echo $count; ?></td>
                                      <td><?php echo $row->loan_number; ?></td>
                                      <td><?=$banknames[$row->bank_code]->BANKNAME;?></td>
                                      <td class="text-right"><?=number_format($row->loan_amount,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                      <td><?=$row->loan_date;?></td>
                                      <td><?php
                                      if($row->payment_start_date){
                                        $num=$row->payment_start_date;
                                        $th_val='th';
                                        $num = $num % 100; // protect against large numbers
                                        if($num < 11 || $num > 13){
                                          switch($num % 10){
                                            case 1: $th_val= 'st';
                                            case 2: $th_val= 'nd';
                                            case 3: $th_val= 'rd';
                                          }
                                        }

                                        echo $row->payment_start_date.$th_val." Of Every Month"
                                        ?>
                                        <?}
                                        ?></td>
                                        <td class="text-right"><?=number_format($totpay_amount,2);?></td>
                                        <td class="text-right"><?=number_format($tot_instalment,2);?></td>
                                        <td class="text-right"><?=number_format($tot_amount_due,2);?></td>
                                        <td class="text-right"><?=number_format($pending_shedule[$row->id]->pendinginstalment_count,0);?></td>
                                        <td>
                                          <?php
                                          if($row->loan_type == "free"){
                                            $loan_type = "Free Loan";
                                          }else if($row->loan_type == "mortgage"){
                                            $loan_type = "Mortgage";
                                          }else if($row->loan_type == "lease"){
                                            $loan_type = "Lease";
                                          }
                                          echo $loan_type; ?>
                                        </td>
                                        <td align="right">
                                          <div id="checherflag">


                                          </div>
                                        </td>
                                      </tr>
                                      <?php
                                      $count++;
                                    }
                                    $totpay_amount=0.00;
                                    $tot_instalment=0.00;
                                    $tot_amount_due=0.00;
                                  } }?>
                                </tbody>
                              </table>
                              <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                            </div>
                          </div>
                          <!--table end-->
                          <!--table end-->
                          <div role="tabpanel" class="tab-pane fade" id="loaninquery" aria-labelledby="loaninquery-tab">
                            <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                              <div class="row">
                                <form data-toggle="validator" id="inputform" name="inputform" method="post" method="post" action="" enctype="multipart/form-data">
                                  <div class="form-title">
                                    <h4>Loan Details</h4>
                                  </div>

                                  <div class="col-md-6 validation-grids validation-grids-left">
                                    <div class="" data-example-id="basic-forms">
                                      <div class="form-body">
                                        <div class="form-group">
                                          <label for="loan_type" class="control-label">Select Loan </label>
                                          <select class="form-control" id="loan_no" name="loan_no" onchange="loan_fulldata(this.value)" required>
                                            <option value="">--Select Loan--</option>
                                            <?php
                                            if($datalist){
                                              foreach ($datalist as $key => $value) {
                                                echo "<option value=".$value->id.">".$value->loan_number."</option>";
                                              }
                                            }
                                            ?>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </form>

                              </div>
                              <div id="loandata" style="display:none">
                              </div>
                            </div>
                          </div>
                          <!--inquiry end-->



                          <!--form start-->
                          <div  role="tabpanel" class="tab-pane fade <? if($home_class!='Active'){?>active in<?}?>" id="main" aria-labelledby="main-tab">
                            <p>
                              <? if($this->session->flashdata('msg')){?>
                                <div class="alert alert-success" role="alert">
                                  <?=$this->session->flashdata('msg')?>
                                </div><? }?>
                                <? if($this->session->flashdata('error')){?>
                                  <div class="alert alert-danger" role="alert">
                                    <?=$this->session->flashdata('error')?>
                                  </div><? }?>
                                  <div class="row">
                                    <form data-toggle="validator" id="inputform" name="inputform" method="post" method="post" action="<?=base_url()?>accounts/loan/add" enctype="multipart/form-data">
                                      <input type="hidden" name="form_submit_type" id="form_submit_type" value="insert" />
                                      <div class="form-title">
                                        <h4>Create Loan</h4>
                                      </div>

                                      <div class="col-md-6 validation-grids validation-grids-left">
                                        <div class="" data-example-id="basic-forms">
                                          <div class="form-body">
                                            <div class="form-group">
                                              <label for="loan_type" class="control-label">Select Loan Type</label>
                                              <select class="form-control" id="loan_type" name="loan_type" onChange="load_loan_type(this.value);" required>
                                                <option value="">--Select Loan Type--</option>
                                                <option value="free">Free Loan</option>
                                                <option value="mortgage">Mortgage/Project Loan</option>
                                                <option value="lease">Lease</option>
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
                                                <input type="text" class="form-control" id="loan_number" name="loan_number" value="" placeholder="Loan Number" min="0" required>
                                                <span class="help-block with-errors" ></span>
                                              </div>
                                              <div class="form-group">
                                                <label for="interest_rate" class="control-label">Interest Rate</label>
                                                <input type="number" step="0.01" class="form-control" id="interest_rate" name="interest_rate" value="" placeholder="Interest Rate" min="0" required>
                                                <span class="help-block with-errors" ></span>
                                              </div>
                                              <div class="form-group">
                                                <label for="monthly_or_maturity" class="control-label">Monthly/Maturity Payment</label>
                                                <select class="form-control" id="monthly_or_maturity" name="monthly_or_maturity" required>
                                                  <option value="">--Select Monthly/Maturity--</option>
                                                  <option value="monthly">Monthly</option>
                                                  <option value="maturity">Maturity</option>
                                                </select>
                                                <span class="help-block with-errors" ></span>
                                              </div>
                                              <div class="form-group">
                                                <label for="grace_period" class="control-label">Grace Period</label>
                                                <input type="number" class="form-control" id="grace_period" name="grace_period" value="" placeholder="Grace Period" min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" required>
                                                <span class="help-block with-errors" ></span>
                                              </div>

                                              <div class="form-group">
                                                <label for="total_period" class="control-label">Total Instalments(Including Grace Period)</label>
                                                <input type="number" class="form-control" id="total_period" name="total_period" value="" placeholder="Total Instalments(Including Grace Period)" min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" required>
                                                <span class="help-block with-errors" ></span>
                                              </div>

                                              <div class="form-group">
                                                <label for="loan_date" class="control-label">Loan Date</label>
                                                <input type="text" class="form-control" id="loan_date" name="loan_date" value="" placeholder="DD/MM/YYYY" required/>
                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                                <span class="help-block with-errors" ></span>
                                              </div>
                                              <div class="form-group">
                                                <label for="fixed_vary_installments" class="control-label">Leger Account</label>
                                                <select class="form-control" id="leger_acc" name="leger_acc" required>
                                                  <option value="">--Select Leger Account--</option>
                                                  <?php
                                                  foreach ($legers as $key => $value) {?>
                                                    <option value="<?=$value->id;?>"><?=$value->id;?> - <?=$value->name;?></option>
                                                  <?php  }
                                                  ?>
                                                </select>
                                                <span class="help-block with-errors" ></span>
                                              </div>
                                              <div class="form-group">
                                                <label for="fixed_vary_installments" class="control-label">Credit Leger Account</label>
                                                <select class="form-control" id="credit_leger_acc" name="credit_leger_acc" required>
                                                  <option value="">--Select other Leger Account--</option>
                                                  <?php
                                                  foreach ($legers as $key => $value) {?>
                                                    <option value="<?=$value->id;?>"><?=$value->id;?> - <?=$value->name;?></option>
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
                                                <input type="number" step="0.01" class="form-control" id="loan_amount" name="loan_amount" value="" placeholder="Loan Amount" min="0" required>
                                                <span class="help-block with-errors" ></span>
                                              </div>
                                              <div class="form-group">
                                                <label for="onetime_charges" class="control-label">One-time Charges</label>
                                                <input type="number" step="0.01" class="form-control" id="onetime_charges" name="onetime_charges" value="" placeholder="One-time Charges" min="0" required>
                                                <span class="help-block with-errors" ></span>
                                              </div>
                                              <div class="form-group">
                                                <label for="grace_period_installment_value" class="control-label">Grace Period Instalment Value</label>
                                                <input type="number" step="0.01" class="form-control" id="grace_period_installment_value" name="grace_period_installment_value" value="" placeholder="Grace Period Installment Value" required>
                                                <span class="help-block with-errors" ></span>
                                              </div>
                                              <div class="form-group">
                                                <label for="loan_installment_value" class="control-label">Instalment Value</label>
                                                <input type="number" step="0.01" class="form-control" id="loan_installment_value" name="loan_installment_value" value="" placeholder="Installment Value" required>
                                                <span class="help-block with-errors" ></span>
                                              </div>
                                              <div class="form-group">
                                                <label for="fixed_vary_installments" class="control-label">Fixed/Vary Instalments</label>
                                                <select class="form-control" id="fixed_vary_installments" name="fixed_vary_installments" required>
                                                  <option value="">--Select Fixed/Vary--</option>
                                                  <option value="fixed">Fixed</option>
                                                  <option value="vary">Vary</option>
                                                </select>
                                                <span class="help-block with-errors" ></span>
                                              </div>
                                              <div class="form-group">
                                                <label for="loan_date" class="control-label">Loan Payment Date</label>
                                                <input type="text" class="form-control" id="loan_paymentdate" name="loan_paymentdate" value="" placeholder="DD" required/>
                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                                <span class="help-block with-errors" ></span>
                                              </div>
                                              <div class="form-group">
                                                <label for="method" class="control-label">Payment Method</label>
                                                <select name="method" id="method" class="form-control" >
                                                  <option value="0">--Select Payment Method--</option>
                                                  <option value="1">Deduct From Bank</option>
                                                  <option value="2">Dated Cheque Issued</option>
                                                  <option value="3">Post Dated Cheque</option>

                                                </select>
                                              </div>
                                              <span class="help-block with-errors" ></span>
                                            </div>

                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-xs-12"><hr></div>
                                    </div>

                                    <div id="external_freeloan_div">
                                      <div class="col-md-6 validation-grids validation-grids-left">

                                      </div>
                                    </div>
                                    <div id="external_mortgageloan_div">
                                      <div class="col-md-12 ">
                                        <div class="" data-example-id="basic-forms">
                                          <div class="form-title">
                                            <h4>Loan Details</h4>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6 validation-grids validation-grids-left">
                                        <div class="" data-example-id="basic-forms">
                                          <div class="form-body">
                                            <div class="form-group">
                                              <label for="projects" class="control-label">Sub Type</label>
                                              <select class="form-control" id="sub_type" name="sub_type" onChange="sub_loan_type(this.value);">
                                                <option value="">-- Select Sub Type --</option>
                                                <option value="inventory">Inventory</option>
                                                <option value="fixed_assets">Fixed Assets</option>

                                              </select>
                                              <span class="help-block with-errors" ></span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="assets_div">

                                        <div class="col-md-6 validation-grids validation-grids-left">
                                          <div class="" data-example-id="basic-forms">
                                            <div class="form-body">
                                              <div class="form-group">
                                                <label for="projects" class="control-label">Assets</label>
                                                <select class="form-control" id="m_assets" name="m_assets" >
                                                  <option value="">-- Assets --</option>
                                                  <?
                                                  foreach ($assetlist as $key => $value) {?>
                                                    <option value="<?=$value->id?>"><?=$value->asset_code?>-<?=$value->asset_name?></option>
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
                                      <div id="projects_div">
                                        <div class="col-md-6 validation-grids">
                                          <div class="" data-example-id="basic-forms">
                                            <div class="form-body">
                                              <div class="form-group">
                                                <label for="projects" class="control-label">Projects</label>
                                                <select class="form-control" id="project" name="project">
                                                  <option value="">-- Projects --</option>
                                                  <?
                                                  foreach ($prjlist as $key => $value) {?>
                                                    <option value="<?=$value->prj_id?>"><?=$value->project_code?>-<?=$value->project_name?></option>
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
                                                <label for="projects" class="control-label">Blocks</label>
                                                <select class="form-control" id="lots" name="lots[]" multiple='multiple'>
                                                  <option value="">-- Lots --</option>
                                                  <option value="1">-- Lots 1</option>
                                                  <option value="2">-- Lots 2</option>
                                                  <option value="3">-- Lots 3</option>
                                                  <option value="4">-- Lots 4</option>

                                                </select>
                                                <span class="help-block with-errors" ></span>
                                              </div>
                                              <div class="form-group">
                                                <label for="lotval" class="control-label">Mortgage Extent</label>
                                                <input name="lotval" id="lotval" class="form-control">
                                                <div id="arraydiv"></div>

                                                <span class="help-block with-errors" ></span>
                                              </div>

                                              <div class="form-group">
                                                <label for="lotval" class="control-label">Value per perch</label>
                                                <input name="lotperch" id="lotperch" type="text" class="form-control">

                                                <span class="help-block with-errors" ></span>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div id="external_leaseloan_div">
                                      <div class="col-md-12 ">
                                        <div class="" data-example-id="basic-forms">
                                          <div class="form-title">
                                            <h4>Loan Details</h4>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6 validation-grids validation-grids-left">
                                        <div class="" data-example-id="basic-forms">
                                          <div class="form-body">
                                            <div class="form-group">
                                              <label for="projects" class="control-label">Assets</label>
                                              <select class="form-control" id="assets" name="assets" >
                                                <option value="">-- Assets --</option>
                                                <?
                                                foreach ($assetlist as $key => $value) {?>
                                                  <option value="<?=$value->id?>"><?=$value->asset_code?>-<?=$value->asset_name?></option>
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
                                        <div class="form-title">
                                          <h4>External Loan</h4>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-xs-12"><hr></div>
                                    <div class="col-md-12 ">
                                      <div class="" data-example-id="basic-forms">
                                        <div class="form-title">
                                          <h4>Bank Account Details</h4>
                                        </div>
                                        <div class="form-body">
                                          <div class="form-inline">
                                            <div class="form-group">
                                              <select name="bank1" id="bank1" class="form-control" placeholder="Bank" onChange="loadbranchlist(this.value,'1')" >
                                                <option value="">Bank</option>
                                                <? foreach ($banklist as $raw){?>
                                                  <option value="<?=$raw->BANKCODE?>" ><?=$raw->BANKNAME?></option>
                                                <? }?>

                                              </select>
                                            </div>&nbsp;<div class="form-group" id="branch-1">
                                              <select name="branch1" id="branch1" class="form-control" placeholder="Bank" >
                                                <option value="">Banch</option>


                                              </select>
                                            </div>
                                            <div class="form-group has-feedback">
                                              <input type="text" class="form-control"name="acc1" id="acc1"   placeholder="Account Number" data-error="" >

                                            </div>
                                          </div>
                                          <br>

                                          <div class="bottom validation-grids">

                                            <div class="form-group">
                                              <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            <div class="clearfix"> </div>
                                          </div>

                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <script src="<?=base_url()?>media/js/jquery.multi-select.js"></script>
                    <script>
                    $(document).ready(function(){

                      $( "#project" ).change(function() {
                        var id=$( "#project" ).val();
                        const selectlots = $("#lots");
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
                            $( "#lots" ).append('<option value="">-- Lots --</option>');
                            jQuery.each(result, function(index, item) {
                              if(item.extend_perch>1){
                              selectlots.append('<option data-lotval="'+item.extend_perch+'" data-lotperch="'+item.price_perch+'" value="'+item.lot_number+'">'+item.lot_number+'</option>');
                            }
                            });
                            selectlots.multiSelect('refresh');
                          },
                          error: function() {
                            alert("some error");
                          }

                        });
                      });

                    });

                    // run callbacks
                    $('#lots').multiSelect({
                      afterSelect: function(values){
                      },
                      afterDeselect: function(values){
                      }
                    });
                    </script>
                    <div class="row calender widget-shadow"  style="display:none">
                      <h4 class="title">Calender</h4>
                      <div class="cal1">

                      </div>
                    </div>

                    <div class="clearfix"> </div>
                  </div>
                </div>

                <!--footer-->
                <?php
                $this->load->view("includes/footer"); ?>
