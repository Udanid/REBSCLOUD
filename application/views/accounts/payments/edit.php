<!DOCTYPE HTML>
<html>
<head>

    <?
    $this->load->view("includes/header_".$this->session->userdata('usermodule'));
    $this->load->view("includes/topbar_accounts");
    ?>
<?php
/* Add row ledger type */
if ($current_entry_type['bank_cash_ledger_restriction'] == '4')
    $add_type = "bankcash";
else if ($current_entry_type['bank_cash_ledger_restriction'] == '5')
    $add_type = "nobankcash";
else
    $add_type = "all";


?>
<script type="text/javascript">

    $(document).ready(function() {

        /* javascript floating point operations */
        var jsFloatOps = function(param1, param2, op) {
            param1 = param1 * 100;
            param2 = param2 * 100;
            param1 = param1.toFixed(0);
            param2 = param2.toFixed(0);
            param1 = Math.floor(param1);
            param2 = Math.floor(param2);
            var result = 0;
            if (op == '+') {
                result = param1 + param2;
                result = result/100;
                return result;
            }
            if (op == '-') {
                result = param1 - param2;
                result = result/100;
                return result;
            }
            if (op == '!=') {
                if (param1 != param2)
                    return true;
                else
                    return false;
            }
            if (op == '==') {
                if (param1 == param2)
                    return true;
                else
                    return false;
            }
            if (op == '>') {
                if (param1 > param2)
                    return true;
                else
                    return false;
            }
            if (op == '<') {
                if (param1 < param2)
                    return true;
                else
                    return false;
            }
        }

        /* Calculating Dr and Cr total */
        //$('.dr-item').live('change', function() {
        $(document).on('change','.dr-item', function() {
            var drTotal = 0;
            $("table tr .dr-item").each(function() {
                //var curDr = $(this).attr('value');
                var curDr = $(this).val();
                curDr = parseFloat(curDr);
                if (isNaN(curDr))
                    curDr = 0;
                drTotal = jsFloatOps(drTotal, curDr, '+');
            });
            $("table tr #dr-total").text(drTotal);
            var crTotal = 0;
            $("table tr .cr-item").each(function() {
                //var curCr = $(this).attr('value');
                var curCr = $(this).val();
                curCr = parseFloat(curCr);
                if (isNaN(curCr))
                    curCr = 0;
                crTotal = jsFloatOps(crTotal, curCr, '+');
            });
            $("table tr #cr-total").text(crTotal);

            if (jsFloatOps(drTotal, crTotal, '==')) {
                $("table tr #dr-total").css("background-color", "#FFFF99");
                $("table tr #cr-total").css("background-color", "#FFFF99");
                $("table tr #dr-diff").text("-");
                $("table tr #cr-diff").text("");
            } else {
                $("table tr #dr-total").css("background-color", "#FFE9E8");
                $("table tr #cr-total").css("background-color", "#FFE9E8");
                if (jsFloatOps(drTotal, crTotal, '>')) {
                    $("table tr #dr-diff").text("");
                    $("table tr #cr-diff").text(jsFloatOps(drTotal, crTotal, '-'));
                } else {
                    $("table tr #dr-diff").text(jsFloatOps(crTotal, drTotal, '-'));
                    $("table tr #cr-diff").text("");
                }
            }
        });

        //$('.cr-item').live('change', function() {
        $(document).on('change','.cr-item', function() {
            var drTotal = 0;
            $("table tr .dr-item").each(function() {
                //var curDr = $(this).attr('value')
                var curDr = $(this).val();
                curDr = parseFloat(curDr);
                if (isNaN(curDr))
                    curDr = 0;
                drTotal = jsFloatOps(drTotal, curDr, '+');
            });
            $("table tr #dr-total").text(drTotal);
            var crTotal = 0;
            $("table tr .cr-item").each(function() {
                var curCr = $(this).val();
                curCr = parseFloat(curCr);
                if (isNaN(curCr))
                    curCr = 0;
                crTotal = jsFloatOps(crTotal, curCr, '+');
            });
            $("table tr #cr-total").text(crTotal);

            if (jsFloatOps(drTotal, crTotal, '==')) {
                $("table tr #dr-total").css("background-color", "#FFFF99");
                $("table tr #cr-total").css("background-color", "#FFFF99");
                $("table tr #dr-diff").text("-");
                $("table tr #cr-diff").text("");
            } else {
                $("table tr #dr-total").css("background-color", "#FFE9E8");
                $("table tr #cr-total").css("background-color", "#FFE9E8");
                if (jsFloatOps(drTotal, crTotal, '>')) {
                    $("table tr #dr-diff").text("");
                    $("table tr #cr-diff").text(jsFloatOps(drTotal, crTotal, '-'));
                } else {
                    $("table tr #dr-diff").text(jsFloatOps(crTotal, drTotal, '-'));
                    $("table tr #cr-diff").text("");
                }
            }
        });

        /* Dr - Cr dropdown changed */
        //$('.dc-dropdown').live('change', function() {
        $(document).on('change','.dc-dropdown', function() {
            var drValue = $(this).parent().next().next().children().attr('value');
            var crValue = $(this).parent().next().next().next().children().attr('value');

            if ($(this).parent().next().children().val() == "0") {
                return;
            }

            drValue = parseFloat(drValue);
            if (isNaN(drValue))
                drValue = 0;

            crValue = parseFloat(crValue);
            if (isNaN(crValue))
                crValue = 0;

            if ($(this).val() == "D") {
                if (drValue == 0 && crValue != 0) {
                    $(this).parent().next().next().children().attr('value', crValue);
                }
                $(this).parent().next().next().next().children().attr('value', "");
                //$(this).parent().next().next().next().children().attr('disabled', 'disabled');
                $(this).parent().next().next().next().children().attr('disabled', true);
                //$(this).parent().next().next().children().attr('disabled', '');
                $(this).parent().next().next().children().attr('disabled', false);
            } else {
                if (crValue == 0 && drValue != 0) {
                    $(this).parent().next().next().next().children().attr('value', drValue);
                }
                $(this).parent().next().next().children().attr('value', "");
                //$(this).parent().next().next().children().attr('disabled', 'disabled');
                $(this).parent().next().next().children().attr('disabled', true);
                //$(this).parent().next().next().next().children().attr('disabled', '');
                $(this).parent().next().next().next().children().attr('disabled', false);
            }
            /* Recalculate Total */
            $('.dr-item:first').trigger('change');
            $('.cr-item:first').trigger('change');
        });

        /* Ledger dropdown changed */
        //$('.ledger-dropdown').live('change', function() {
        $(document).on('change','.ledger-dropdown', function() {
            if ($(this).val() == "0") {
                $(this).parent().next().children().attr('value', "");
                $(this).parent().next().next().children().attr('value', "");
                //$(this).parent().next().children().attr('disabled', 'disabled');
                $(this).parent().next().children().attr('disabled', true);
                $(this).parent().next().next().children().attr('disabled', true);
            } else {
                $(this).parent().next().children().attr('disabled', false);
                $(this).parent().next().next().children().attr('disabled', false);
                $(this).parent().prev().children().trigger('change');
            }
            $(this).parent().next().children().trigger('change');
            $(this).parent().next().next().children().trigger('change');

            var ledgerid = $(this).val();
            var rowid = $(this);
            if (ledgerid != "0") {
                $.ajax({
                    url: <?php echo '\'' . site_url('accounts/ledger/balance') . '/\''; ?> + ledgerid,
                    success: function(data) {
                        var ledger_bal = parseFloat(data);
                        if (isNaN(ledger_bal))
                            ledger_bal = 0;
                        if (jsFloatOps(ledger_bal, 0, '=='))
                            rowid.parent().next().next().next().next().next().children().text("0");
                        else if (jsFloatOps(ledger_bal, 0, '<'))
                            rowid.parent().next().next().next().next().next().children().text("Cr " + -data);
                        else
                            rowid.parent().next().next().next().next().next().children().text("Dr " + data);
                    }
                });
            } else {
                rowid.parent().next().next().next().next().next().children().text("");
            }
        });

        /* Recalculate Total */
        //$('table td .recalculate').live('click', function() {
        $(document).on('click','table td .recalculate', function() {
            /* Recalculate Total */
            $('.dr-item:first').trigger('change');
            $('.cr-item:first').trigger('change');
        });

        /* Delete ledger row */
        //$('table td .deleterow').live('click', function() {
        $(document).on('click','table td .deleterow', function() {
            $(this).parent().parent().remove();
            /* Recalculate Total */
            $('.dr-item:first').trigger('change');
            $('.cr-item:first').trigger('change');
        });

        /* Add ledger row */
        //$('table td .addrow').live('click', function() {
        $(document).on('click','table td .addrow', function() {
            var cur_obj = this;
            var add_image_url = $(cur_obj).attr('src');
            $(cur_obj).attr('src', <?php echo '\'' . asset_url() . 'images/icons/ajax.gif' . '\''; ?>);
            $.ajax({
                url: <?php echo '\'' . site_url('accounts/entry/addrow/' . $add_type) . '\''; ?>,
                success: function(data) {
                    $(cur_obj).parent().parent().after(data);
                    $(cur_obj).attr('src', add_image_url);
                    var config = {
                        '.ledger-dropdown'  : {}
                    }
                    for (var selector in config) {
                        $(selector).chosen(config[selector]);
                    }
                }

            });
        });

        /* On page load initiate all triggers */
        $('.dc-dropdown').trigger('change');
        $('.ledger-dropdown').trigger('change');
        $('.dr-item:first').trigger('change');
        $('.cr-item:first').trigger('change');
    });

    $( function() {

        $("#entry_date" ).datepicker({dateFormat: 'yy-mm-dd',
		<?
		if (!check_user_lock($this->session->userdata('usertype')) ||check_previousyear_lock()){  //these functions are in yearend_helper
		?>
			minDate: '<?=$this->session->userdata("fy_start")?>',
			maxDate: '<?=$this->session->userdata("fy_end")?>',
		<?
		}
		?>
		setDate :new Date()}).attr('readonly','readonly');


        $("#entry_date").datepicker('setDate', new Date());
    });
    function hidechequedata(obj)
    {
        if(obj.value=="CHQ")
        {
            document.getElementById("chquedata").style.display='block';
        }
        else
        {
            document.getElementById("chquedata").style.display='none';
        }
    }</script>

<script>
    function load_search_data(obj)
    {

        var value1 =obj.value;


        if(value1!="" ){

            value=value1;
            document.getElementById("seachlocator").style.display='block';

            popupdetails("paymentvouchers/supplier_invices",value,'seachlocator')
        }
        else
        {
            document.getElementById("seachlocator").style.display='none';
        }


    }
    function checkAll(obj)
    {


        var rawmatcount=document.myform.rawmatcount.value;
        if(obj.checked){
            for(i=1; i<=rawmatcount; i++)
            {

                totobj=eval("document.myform.isselect"+i);
                totobj.checked=true;

            }
        }
        else{
            for(i=1; i<=rawmatcount; i++)
            {
//alert("ss")
                totobj=eval("document.myform.isselect"+i);
                totobj.checked=false;
//alert(units+avbunits);
            }
        }
        calculatetot();
    }
    function calculatetot()
    {

        var tot=0;

        var rawmatcount=document.myform.rawmatcount.value;
        //alert(rawmatcount);
        for(i=1; i<=rawmatcount; i++)
        {

            totobj=eval("document.myform.isselect"+i);

            amount=eval("document.myform.invoiceamount"+i);

            if(totobj.checked)
            {

                tot=parseFloat(tot)+parseFloat(amount.value);

            }

        }
        if(tot!=0)
        {
            document.myform.amount.value=tot;
        }
        else
        {
            document.myform.amount.value="";
        }
    }
    function loadpayeelist(obj)
    {
        val=obj.value;
        if(val=='2')
        {
            document.getElementById("emp").style.display='block';
            document.getElementById("supp").style.display='none';
            document.getElementById("common").style.display='none';
        }
        else if(val=='3')
        {
            document.getElementById("emp").style.display='none';
            document.getElementById("supp").style.display='block';
            document.getElementById("common").style.display='none';
        }
        else
        {
            document.getElementById("emp").style.display='none';
            document.getElementById("common").style.display='block';
            document.getElementById("supp").style.display='none';
        }
    }
    function loadpayeename(obj)
    {
        alert(document.myform)
        document.myform.payeename.value=obj.value;
    }
</script>

<div id="page-wrapper">
    <div class="table">
        <h3 class="title1">Edit Payment Entry</h3>
        <?php $this->load->view("includes/flashmessage");?>
        <div class="widget-shadow">
            <div class="  widget-shadow" data-example-id="basic-forms">
                <?
                echo form_open('accounts/payments/edit/'.$entry_id,'name="myform"');
                ?>
                <div class="row">
                    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
                        <div class="form-body">
                            <div class="form-inline">
                                <table class="entry-table">
                                    <tr>
                                        <td>
                                            <div class="form-group col-md-4" style="width: 100%;">Cheque Date<br/>
                                                <?=form_hidden($entry_number)?>
                                                <?=form_input_date_restrict($entry_date)?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group col-md-4" style="width: 100%;">Payment Type<br/>
                                                <select class="form-control" name="payment_mode" id="payment_mode">
                                                <option value="CHQ" <? if($payment_mode=="CHQ"){?> selected="selected"<? }?> >CHEQUE</option>
                                                <option value="CSH" <? if($payment_mode=="CSH"){?> selected="selected"<? }?>>CASH</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group col-md-4" style="width: 100%;">Amount<br/>
                                                <?=form_input($amount)?>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <div class="form-group col-md-4" style="width: 100%;">Cheque Drown To<br/>
                                                <?=form_input($chequename)?>
                                                <input type="hidden" name="rawmatcount" id="rawmatcount" value="<?=$count?>" />
                                            </div>
                                        </td>
                                    </tr>
                                      <tr><td>  Account Pay &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value="YES" name="pay_mode"  id="pay_mode" <? if($pay_mode=='YES') {?> checked<? }?>/></td><td colspan="2">  Authorized Only &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value="YES" name="authorized_only"  id="authorized_only" <? if($authorized_only=='YES') {?> checked<? }?> /></td></tr>
                                </table>
                                <br/>
                                <h4 style="color: #25b700;">Voucher Details</h4><hr/>
                                <table cellpadding="simple-table account-table">
                                    <tr>
                                        <th>Voucher Number</th>
                                        <th>Document Number</th>
                                        <th>Payee Name</th>
                                            <th>Project Name</th>
                                        <th>Amount</th>
                                    </tr>
                                    <? if($voucherlist){ for($i=1; $i<=$count; $i++){?>
                                        <tr>
                                            <td><input class="form-control" type="text" name="voucherid<?=$i?>" id="voucherid<?=$i?>" readonly value="<?=$voucherlist[$i]['voucherid']?>" /></td>
                                            <td><input class="form-control" type="text" name="refnumber<?=$i?>" id="refnumber<?=$i?>" readonly value="<?=$voucherlist[$i]['refnumber']?>" /></td>
                                            <td><input class="form-control" type="text" name="payeename<?=$i?>" id="payeename<?=$i?>" readonly value="<?=$voucherlist[$i]['payeename']?>" /></td>
                                              <td><input class="form-control" type="text" name="myprjname<?=$i?>" id="myprjname<?=$i?>" readonly value="<?=projectname_by_voucherid($voucherlist[$i]['voucherid'])?>" /></td>
                                            <td><input class="form-control" type="text" name="invoiceamount<?=$i?>" id="invoiceamount<?=$i?>" readonly value="<?=$voucherlist[$i]['invoiceamount']?>"/></td>
                                        </tr>
                                    <? }}?>
                                </table>
                                <br />
                                <div class="clearfix"> </div><br/><br/>
                                <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll">
                                <table class="entry-table">
                                    <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Ledger Account</th>
                                        <th>Dr Amount</th>
                                        <th>Cr Amount</th>
                                        <th colspan=2></th>
                                        <th colspan=2>Cur Balance</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    $counter=0;
                                    foreach ($ledger_dc as $i => $ledger)
                                    {
                                        $dr_amount_item = array(
                                            'name' => 'dr_amount[' . $i . ']',
                                            'id' => 'dr_amount[' . $i . ']',
                                            'maxlength' => '15',
                                            'size' => '15',
                                            'value' => isset($dr_amount[$i]) ? $dr_amount[$i] : "",
                                            'class' => 'dr-item',
                                        );
                                        $cr_amount_item = array(
                                            'name' => 'cr_amount[' . $i . ']',
                                            'id' => 'cr_amount[' . $i . ']',
                                            'maxlength' => '15',
                                            'size' => '15',
                                            'value' => isset($cr_amount[$i]) ? $cr_amount[$i] : "",
                                            'class' => 'cr-item',
                                        );
                                        echo "<tr>";

                                        echo "<td>" . form_dropdown_dc('ledger_dc[' . $i . ']', isset($ledger_dc[$i]) ? $ledger_dc[$i] : "D") . "</td>";
                                        if($counter==0)
                                            echo "<td style=\"font-size:10px\"> ". form_input_ledger('ledger_id[' . $i . ']', isset($ledger_id[$i]) ? $ledger_id[$i] : 0, '','') . "</td>";

                                        else
                                            echo "<td>" . form_input_ledger('ledger_id[' . $i . ']', isset($ledger_id[$i]) ? $ledger_id[$i] : 0, '', '') . "</td>";

                                        echo "<td>" . form_input($dr_amount_item) . "</td>";
                                        echo "<td>" . form_input($cr_amount_item) . "</td>";

                                        echo "<td>" . img(array('src' => asset_url() . "images/icons/add.png", 'border' => '0', 'alt' => 'Add Ledger', 'class' => 'addrow')) . "</td>";
                                        echo "<td>" . img(array('src' => asset_url() . "images/icons/delete.png", 'border' => '0', 'alt' => 'Remove Ledger', 'class' => 'deleterow')) . "</td>";

                                        echo "<td class=\"ledger-balance\"><div></div></td>";

                                        echo "</tr>";
                                        $counter++;
                                    }

                                    echo "<tr><td colspan=\"7\"></td></tr>";
                                    echo "<tr id=\"entry-total\"><td colspan=2><strong>Total</strong></td><td id=\"dr-total\">0</td><td id=\"cr-total\">0</td><td>" . img(array('src' => asset_url() . "images/icons/gear.png", 'border' => '0', 'alt' => 'Recalculate Total', 'class' => 'recalculate', 'title' => 'Recalculate Total')) . "</td><td></td><td></td></tr>";
                                    echo "<tr id=\"entry-difference\"><td colspan=2><strong>Difference</strong></td><td id=\"dr-diff\"></td><td id=\"cr-diff\"></td><td></td><td></td><td></td></tr>";

                                    echo "</table>";

                                    echo "<p>";
                                    echo form_label('Narration', 'entry_narration');
                                    echo "<br />";
                                    echo form_textarea($entry_narration);
                                    echo "</p>";
                                    echo "<p>";
                                    echo form_submit('submit', 'Create');
                                    echo " ";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <? echo form_close(); ?>
            </div>
            <div class="row calender widget-shadow"  style="display:none">
                <h4 class="title">Calender</h4>
                <div class="cal1"></div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
</div>





<?php
$this->load->view("includes/footer");
//file create by udani 12-09-2013
////`refnumber`, `entryid`, `payeecode`, `payeename`, `vouchertype`, `paymentdes`, `amount`, `applydate`, `confirmdate`, `paymentdate`, `paymenttype`, `status`, `confirmby`SELECT * FROM `ac_payvoucherdata` WHERE 1




