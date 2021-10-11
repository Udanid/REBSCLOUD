
<?php
$fy_start = $this->session->userdata('fy_start');
$fy_end = $this->session->userdata('fy_end');
?>


<script>

  /*  $( function() {

        $( "#entry_date" ).datepicker({dateFormat: 'yy-mm-dd',
            minDate: new Date('<?php echo $fy_start; ?>'),
            maxDate: new Date('<?php echo $fy_end; ?>')
        });

    } );*/
    </script>
<h4>Payment Voucher <?=$details->voucherid?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->voucherid?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
    <div class="row">
        <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/paymentvouchers/editdata">
            <div class="col-md-12 validation-grids widget-shadow" style="width: 100%;" data-example-id="basic-forms">
                <div class="form-body">
                    <div class="col-md-6">
                        <div class="form-group">Voucher Data
                            <input type="hidden"  value="<?=$details->voucherid?>"name="voucherid" id="voucherid"  />
                            <input type="text" class="form-control" value="<?=$details->applydate?>" name="entry_date" id="entry_date" placeholder="Voucher Date" readonly required>
                        </div>
                        <div class="form-group">Document Reference Number
                            <input type="text" class="form-control" style="width: 100%;" id="refnumber" name="refnumber" value="<? echo $details->refnumber;?>" placeholder="">
                        </div>
                        <div class="form-group">Payee Name
                         <input type="text" id="payeename"  name="payeename"value="<?=$details->payeename?>" class="form-control" style="width: 100%;" onchange="loadpayeename(this)" required>
                              
                        </div>
                          <div class="form-group">   Branch<br/>
                        <select class="form-control" placeholder="Qick Search.."    id="branch_code" name="branch_code"  required >
                    <option value="">All Branch </option>
                    <?    foreach($branchlist as $row){?>
                    <option value="<?=$row->branch_code?>" <? if($details->branch_code==$row->branch_code) {?> selected="selected"<? }?>><?=$row->branch_name?> </option>
                    <? }?>
             
					</select> 
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span> </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">Payment Voucher Type
                            <select name="vouchertype" id="vouchertype" class="form-control" style="width: 100%;">
                                <option value="">Select Type</option>
                                <? // print_r($vouchertypes);
                                if($vouchertypes){
                                    foreach ($vouchertypes as $raw){
                                        if($raw->typeid!=3){
                                            if($raw->typeid == $details->vouchertype)
                                            {
                                                ?>
                                                <option selected value="<?=$raw->typeid?>" ><?=$raw->typename?> </option>
                                                <?php

                                            }
                                            ?>

                                            <option value="<?=$raw->typeid?>" ><?=$raw->typename?> </option>
                                        <? }}}?>
                            </select>
                        </div>
                        <div class="form-group">Apply Month
                            <select name="applymonth" id="applymonth" class="form-control" style="width: 100%;" >
                                <?php
                                if($details->applymonth)
                                {
                                    ?>
                                    <option selected value="<?php echo $details->applymonth;?>"><?php echo $details->applymonth;?></option>
                                <?php

                                }
                                ?>
                                <option value="">Select Month</option>
                                <option value="January" <? if($details->applymonth=="January"){?> selected="selected"<? }?>>January</option>
                                <option value="February" <? if($details->applymonth=="February"){?> selected="selected"<? }?>>February</option>
                                <option value="March" <? if($details->applymonth=="March"){?> selected="selected"<? }?>>March</option>
                                <option value="April" <? if($details->applymonth=="April"){?> selected="selected"<? }?>>April</option>
                                <option value="May" <? if($details->applymonth=="May"){?> selected="selected"<? }?>>May</option>
                                <option value="June" <? if($details->applymonth=="June"){?> selected="selected"<? }?>>June</option>
                                <option value="July" <? if($details->applymonth=="July"){?> selected="selected"<? }?>>July</option>
                                <option value="August" <? if($details->applymonth=="August"){?> selected="selected"<? }?>>August</option>
                                <option value="September" <? if($details->applymonth=="September"){?> selected="selected"<? }?>>September</option>
                                <option value="October" <? if($details->applymonth=="October"){?> selected="selected"<? }?>>October</option>
                                <option value="November" <? if($details->applymonth=="November"){?> selected="selected"<? }?>>November</option>
                                <option value="December" <? if($details->applymonth=="December"){?> selected="selected"<? }?>>December</option>
                            </select>
                        </div>
                        <div class="form-group">Amount
                            <input type="text"  onkeydown="return keyispressed(event);" class="form-control number-separator" style="width: 100%;" id="amount" name="amount" value="<? echo $details->amount;?>" placeholder="">
                        </div>
                        
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group"><textarea name="paymentdes" maxlength="150"   id="paymentdes"  class="form-control" placeholder="Short Description About the branch" required><?=$details->paymentdes?></textarea>
                            <span class="help-block">Maximum of 150 characters</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bottom">

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary ">Update</button>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                    </div>
                    <div class="clearfix"> </div><br>
                </div>
            </div>
        </form>
    </div>
</div>