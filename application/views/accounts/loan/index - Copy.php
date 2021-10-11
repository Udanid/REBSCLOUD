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
                  <a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Loan List</a>
                </li>
                <li role="presentation"  >
                  <a href="#home" role="tab" id="home-tab" data-toggle="tab" aria-controls="home" aria-expanded="true"></a>
                </li>
              </ul>

              <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
                <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">

                </div>
                <div role="tabpanel" class="tab-pane fade " id="home" aria-labelledby="home-tab">
                  <p><? //$this->load->view("accounts/receipt/cancel_receipt");?> </p>
                </div>
              </div>
            </div>
          </div>
        </div>

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

  <div class="form-group">
    <label for="payment_method" class="control-label">Payment Method</label>
    <select class="form-control" id="payment_method" name="payment_method" required>
      <option value="">--Select Payment Method--</option>
      <option value="1" <?if($loan_byid->payment_method=="1"){?>selected="selected"<?}?>>Deduct From Bank</option>
      <option value="2" <?if($loan_byid->payment_method=="2"){?>selected="selected"<?}?>>Dated Cheque Issued</option>
      <option value="3" <?if($loan_byid->payment_method=="3"){?>selected="selected"<?}?>>Post Dated Cheque</option>
    </select>
    <span class="help-block with-errors" ></span>
  </div>
