<?
//echo form_open('paymentvouchers/add','name="myform"');

$fy_start = $this->session->userdata('fy_start');
$fy_end = $this->session->userdata('fy_end');

?>


    <script type="text/javascript">
        $( document ).ready(function() {

            $("#employeename").focus(function() {
                $("#employeename").chosen({
                    allow_single_deselect : true
                });
            });
        });


        $( function() {

            $( "#entry_date" ).datepicker({dateFormat: 'yy-mm-dd',
             minDate: new Date('<?=$this->session->userdata("current_start")?>'),//updated by ticket 3133
			maxDate: '<?=$this->session->userdata("current_end")?>'
            }).attr('readonly','readonly');
            $("#entry_date").datepicker('setDate', new Date());


        } );

        function loadpayeelist(obj)
        {

            val=obj.value;
            //alert(val);
            if(val=='6')
            {
                //document.getElementById("projectlist").style.display='block';
                document.getElementById("subprojectlist").style.display='block';
                setTimeout(function(){
                    $("#subprojectid").chosen({
                        allow_single_deselect : true
                    });}, 300);

                //document.getElementById("common").style.display='none';
            }
            else
            {
                //document.getElementById("projectlist").style.display='none';
                document.getElementById("subprojectlist").style.display='none';
            }
            if(val=='4')
            {

                document.getElementById("subprojectlist").style.display='block';
                setTimeout(function(){
                    $("#subprojectid").chosen({
                        allow_single_deselect : true
                    });}, 300);
            }
        }

    </script>

<form data-toggle="validator" method="post"  action="<?=base_url()?>accounts/paymentvouchers/add"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
            <div class="form-body">
                <div class="form-inline">
                    <div class="form-group col-md-4" style="width: 25%;">Voucher Date<br/>
                        <div class="col-sm-3 has-feedback">
                            <input type="text" class="form-control" name="entry_date" id="entry_date">
                        </div>
                    </div>
                    <div class="form-group col-md-4" style="width: 25%;">Payment Voucher Type<br/>
                        <select name="vouchertype" id="vouchertype" class="form-control" style="width: 100%;" required>
                            <option value="">Select Type</option>
                            <? // print_r($vouchertypes);
                            if($vouchertypes){
                                foreach ($vouchertypes as $raw){
                                    if($raw->typeid!=3){?>
                                    <option value="<?=$raw->typeid?>" ><?=$raw->typename?> </option>
                                <? }}}?>
                        </select>
                    </div>
                    <div class="form-group col-md-4" style="width: 25%;">Document Reference Number<br/>
                        <input type="text" class="form-control" style="width: 100%;" id="refnumber" name="refnumber">
                    </div>
                    <div class="form-group col-md-4" style="width: 25%;">
                        Apply Month<br/>
                        <select name="applymonth" id="applymonth" class="form-control" style="width: 100%;" >
                            <option value="">Select Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    <br/>
                    <br>
                    <div class="clearfix"> </div><br>
                    <div class="form-group col-md-4" style="width: 25%;">
                        Payee Name<br/>
                        <div id="emp">
                            <input type="text" name="payeename" id="payeename" class="form-control" style="width: 100%;" value="<?=$name?>"required>

                        </div>
                    </div>
                    <div class="form-group col-md-4" style="width: 25%;display:none">

                        <div class="form-group col-md-4" id="test" style="display:none"><? //=form_input($payeename)?></div>
                    </div>
                    <div class="form-group col-md-4" style="width: 25%;">
                        Amount<br/>
                        <? //=form_input($amount)?>
                        <input type="text"  onkeydown="return keyispressed(event);" class="form-control number-separator" id="amount" name="amount"  style="width: 100%;" required>
                    </div>
                     <div class="form-group  has-feedback col-md-4">   Branch<br/>
                        <select class="form-control" placeholder="Qick Search.."    id="branch_code" name="branch_code"  required >
                    <option value="">All Branch </option>
                    <?    foreach($branchlist as $row){?>
                    <option value="<?=$row->branch_code?>"><?=$row->branch_name?> </option>
                    <? }?>

					</select>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span> </div>
                    <div class="clearfix"> </div><br>

                    <div class="clearfix"> </div>
                    <div class="form-group  col-md-6" style="width: 50%;">Payment Description <br/>
                        <textarea class="form-control" id="paymentdes" name="paymentdes" style="width: 100%;"><?//=form_textarea($paymentdes)?></textarea>
                    </div>
                    <div class="clearfix"> </div>
                    <div class="form-group col-md-4">
                    <button type="submit"  id="create" class="btn btn-primary " style="width: 70px;">Create</button>
                        <? //=form_submit('submit', 'Create');?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>

<?php
//file create by udani 12-09-2013
////`refnumber`, `entryid`, `payeecode`, `payeename`, `vouchertype`, `paymentdes`, `amount`, `applydate`, `confirmdate`, `paymentdate`, `paymenttype`, `status`, `confirmby`SELECT * FROM `ac_payvoucherdata` WHERE 1


//echo form_close();
