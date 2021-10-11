<!DOCTYPE HTML>
<html>
<head>
  <?php
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
  $this->load->view("includes/topbar_accounts"); ?>

  <!-- main content start-->
  <div id="page-wrapper">
    <div class="main-page">
      <div class="table">
        <h3 class="title1">Loan</h3>
        <div class="widget-shadow">
          <div class="  widget-shadow" data-example-id="basic-forms">
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
              <li role="presentation"   class="active" >
                <a href="#shedule" role="tab" id="main-tab" data-toggle="tab" aria-controls="shedule" aria-expanded="true">Upload Schedule</a>
              </li>
              <li role="presentation"  >
                <a href="#home" role="tab" id="home-tab" data-toggle="tab" aria-controls="home" aria-expanded="true">View Schedule</a>
              </li>
            </ul>

            <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
              <div role="tabpanel" class="tab-pane fade" id="home" aria-labelledby="home-tab">
                <div class="row">
                <from>
                  <div class="col-md-6 validation-grids validation-grids-left">
                <div >
                  <div class="" data-example-id="basic-forms">
                    <div class="form-body">
                      <div class="form-group">
                  <select class="form-control" id="loan_no_shedule" name="loan_no_shedule" data-loan="" required>
                    <option value="">--Select Loan Number--</option>
                    <?php
                    if($datalist){
                      foreach($sheduledatalist as $row){ ?>
                      <option value="<?=$row->id?>" data-loan="<?=$row->loan_number?>"><?=$row->loan_number?></option>
                        <?php
                      }
                    }
                        ?>
                  </select>
                </div>
                </div>
                </div>
                </div>

              </from>
              </div>
              <div class="col-md-6 validation-grids validation-grids-left" id="payment_history">

              </div>
              <div class="row">
                  <table class="table" id="shedule_table">
                    <thead>
                      <tr>
                        <th>Instalment No</th>
                        <th><center>Capital Instalment</center></th>
                        <th><center>Interest Instalment</center></th>
                        <th><center>Total Instalment</center></th>
                        <th><center>Due date</center></th>
                        <th><center>Status</center></th>
                        <th>Cheque Number</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  <div id="pagination-container"></div>
                </div>
                </div>
              </div>
              <!--table end-->

              <!--shedule start-->
              <div  role="tabpanel" class="tab-pane fade  active in" id="shedule" aria-labelledby="shedule-tab">
              <div class="row">
                <? if($this->session->flashdata('msg')){?>
                  <div class="alert alert-success" role="alert">
                    <?=$this->session->flashdata('msg')?>
                  </div><? }?>
                  <? if($this->session->flashdata('error')){?>
                    <div class="alert alert-danger" role="alert">
                      <?=$this->session->flashdata('error')?>
                    </div><? }?>
                <form data-toggle="validator" id="inputform2" name="inputform2" method="post" method="post" action="<?=base_url()?>accounts/loan/add_shedule" enctype="multipart/form-data">
                  <input type="hidden" name="form_submit_type" id="form_submit_type" value="insert" />
                  <div class="form-title">
                    <h4>Upload Schedule </h4>
                  </div>
                  <p><a href="../../uploads/loan/external_loan/excel_format/sample.xls">click here to download excel format.</a></p>
                  <div class="col-md-6 validation-grids validation-grids-left">
                    <div class="" data-example-id="basic-forms">
                      <div class="form-body">
                        <div class="form-group">
                          <label for="loan_type" class="control-label">Loan Number</label>
                          <select class="form-control" id="loan_no" name="loan_no" data-loan="" required>
                            <option value="">--Select Loan Number--</option>
                            <?php
                            if($datalist){
                              foreach($datalist as $row){ ?>
                              <option value="<?=$row->id?>" data-loan="<?=$row->loan_number?>"><?=$row->loan_number?></option>
                                <?php
                              }
                            }
                                ?>
                          </select>
                          <input type="hidden" name="loan_name" id="loan_name" value="" />

                    </div>
                    <div class="form-group">
                      <label for="loan_type" class="control-label">Schedule file on Excel</label>
                      <input type="file" name="shedule_file" id="shedule_file" required>
                    <span class="help-block with-errors" ></span>
                  </div>
                  <div class="bottom validation-grids">

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary disabled">Submit</button>
                    </div>
                    <div class="clearfix"> </div>
                  </div>
                  </div>
                </form>
              </div>
            </div>
                  <div class="col-xs-12"><hr></div>
                </div>
              </div>
              <!--shedule end-->

            </div>
          </div>
        </div>
      </div>
<script>
$(document).ready(function(){

  $( "#loan_no" ).change(function() {
  var id=$( "#loan_no option:selected").attr('data-loan');
  $( "#loan_name" ).val(id);
  });
  $('#loan_no_shedule').change(function(){
    var id=$('#loan_no_shedule').val();
    $( "#shedule_table tbody tr" ).remove();
    var today = '<?=date("Y-m-d");?>';
    var totpaid=0.00;
    var totdue=0.00;
    var totpending=0.00;
      $.ajax({
        headers: {
          Accept: 'application/json'
        },
        type: 'post',
        url: '<?=base_url()?>accounts/loan/get_shedules',
        data: {id: id},
        dataType: "json",
              success: function(result){

                jQuery.each(result, function(index, item) {
                  if(item.pay_status=="PAID"){
                    $( "#shedule_table tbody" ).append('<tr style="color: green;"><th>'+item.instalment+'</th><th class="text-right">'+
                    item.cap_amount+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th class="text-right">'+
                    item.int_amount+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th class="text-right">'+
                    item.tot_instalment+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th class="text-right">'+
                    item.deu_date+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>'+
                    item.pay_status+'</th><th>'+
                    item.cheque_no+'</th></tr>');
                    totpaid= +totpaid + +item.tot_instalment;

                  }else if(item.pay_status=="PENDING" && item.deu_date<=today){
                    $( "#shedule_table tbody" ).append('<tr style="color: red;"><th>'+item.instalment+'</th><th class="text-right">'+
                    item.cap_amount+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th class="text-right">'+
                    item.int_amount+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th class="text-right">'+
                    item.tot_instalment+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th class="text-right">'+
                    item.deu_date+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>'+
                    item.pay_status+'</th><th>'+
                    item.cheque_no+'</th></tr>');
                    totdue=+totdue + +item.tot_instalment;
                  }else{
                    $( "#shedule_table tbody" ).append('<tr><th>'+item.instalment+'</th><th class="text-right">'+
                    item.cap_amount+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th class="text-right">'+
                    item.int_amount+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th class="text-right">'+
                    item.tot_instalment+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th class="text-right">'+
                    item.deu_date+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>'+
                    item.pay_status+'</th><th>'+
                    item.cheque_no+'</th></tr>');
                    totpending=+totpending + +item.tot_instalment;
                  }

              });
              totpaid=totpaid.toFixed(2);
              totdue=totdue.toFixed(2);
              totpending=totpending.toFixed(2);
              $("#payment_history").html("<table><tr><th>Total Paid:</th><th class='text-right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style='color: green;'>"+totpaid+"</b><th></tr>"+
              "<tr><th>Total Due:</th><th class='text-right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style='color: red;'>"+totdue+"</b><th></tr>"+
              "<tr><th>Total Pending:</th><th class='text-right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>"+totpending+"<th></tr></table>")
              },
              error: function() {
                alert("No shedule for this loan");
              }

          });
  });
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
