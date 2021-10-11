
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
			$( "#entry_date" ).datepicker({dateFormat: 'yy-mm-dd',
				<?
				//if (!check_user_lock($this->session->userdata('usertype')) ||check_previousyear_lock()){  //these functions are in yearend_helper
				?>
					minDate: '<?=$this->session->userdata("current_start")?>',
					maxDate: '<?=$this->session->userdata("current_end")?>'
				<?
				//}
				?>
			}).attr('readonly','readonly');

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
            $(document).on('change','.dr-item', function() {
                var drTotal = 0;
                $("table tr .dr-item").each(function() {
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

            $(document).on('change','.cr-item', function() {
                var drTotal = 0;
                $("table tr .dr-item").each(function() {
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
                    $(this).parent().next().next().next().children().attr('disabled', true);
                    $(this).parent().next().next().children().attr('disabled', false);
                } else {
                    if (crValue == 0 && drValue != 0) {
                        $(this).parent().next().next().next().children().attr('value', drValue);
                    }
                    $(this).parent().next().next().children().attr('value', "");
                    $(this).parent().next().next().children().attr('disabled', true);
                    $(this).parent().next().next().next().children().attr('disabled', false);
                }
                /* Recalculate Total */
                $('.dr-item:first').trigger('change');
                $('.cr-item:first').trigger('change');
            });

            /* Ledger dropdown changed */
            $(document).on('change','.ledger-dropdown', function() {
                if ($(this).val() == "0") {
                    $(this).parent().next().children().attr('value', "");
                    $(this).parent().next().next().children().attr('value', "");
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
                if (ledgerid > 0) {
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
            $(document).on('click','table td .recalculate', function() {
                /* Recalculate Total */
                $('.dr-item:first').trigger('change');
                $('.cr-item:first').trigger('change');
            });

            /* Delete ledger row */
            $(document).on('click','table td .deleterow', function() {
                $(this).parent().parent().remove();
                /* Recalculate Total */
                $('.dr-item:first').trigger('change');
                $('.cr-item:first').trigger('change');
            });

            /* Add ledger row */
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

            if(obj.value=="CREDIT CARD" || obj.value=="DEBIT CARD" || obj.value=="DD" || obj.value=="FT")
            {
                document.getElementById("refno").style.display='block';
            }
            else
            {
                document.getElementById("refno").style.display='none';
            }
        }
        function hidevotedata(obj)
        {
            if(obj.value=="CAP")
            {
                document.getElementById("capital").style.display='block';
                document.getElementById("recurent").style.display='none';
            }
            else if(obj.value=="REC")
            {
                document.getElementById("capital").style.display='none';
                document.getElementById("recurent").style.display='block';
            }
            else
            {
                document.getElementById("capital").style.display='none';
                document.getElementById("recurent").style.display='none';
            }
        }

    </script>


    <div id="page-wrapper">
        <div class="main-page">
            <div class="table">
                <h3 class="title1">Edit Receipt Entry</h3>
                <?php $this->load->view("includes/flashmessage");?>
                <div class="widget-shadow">
                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <form name="inputform" action="<?=base_url()?>accounts/entrymaster/edit/<?=$current_entry_type['label']?>/<?=$entry_id;?>" method="post">
                            <div class="row">
                                <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
                                    <div class="form-body">
                                        <div class="form-inline">
                                            <strong>Receipt Details</strong><hr/>
                                            <table class="entry-table">
                                                <tr>
                                                    <td>
                                                        <div class="form-group col-md-4" style="width: 25%;">Receipt Number<br/>
                                                            <div class="col-sm-3 has-feedback">
                                                                <?=form_input($entry_number)?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4" style="width: 25%;">Receipt Date<br/>
                                                            <div class="col-sm-3 has-feedback">
                                                                <?=form_input($entry_date)?>
                                                            </div>
<!--                                                            <span id="tooltip-content-2">Date format is --><?//=$this->config->item('account_date_format') ?><!--</span>-->
                                                        </div>
                                                        <div class="form-group col-md-4" style="width: 25%;">Payment Type<br/>
                                                            <div class="col-sm-3 has-feedback">
                                                                <select name="payment_mode" id="payment_mode"  onchange="hidechequedata(this)">
                                                                    <option value="CHQ" <? if($payment_mode=="CHQ"){?> selected="selected"<? }?> >CHEQUE</option>
                                                                    <option value="CSH" <? if($payment_mode=="CSH"){?> selected="selected"<? }?>>CASH</option>

                                                                     <option value="CREDIT CARD" <? if($payment_mode=="CREDIT CARD"){?> selected="selected"<? }?> >CREDIT CARD</option>
                                                                  

                                                        <option value="DEBIT CARD" <? if($payment_mode=="DEBIT CARD"){?> selected="selected"<? }?> >DEBIT CARD</option>

                                                        <option value="DD" <? if($payment_mode=="DD"){?> selected="selected"<? }?> >DIRECT DEPOSIT</option>

                                                        <option value="FT" <? if($payment_mode=="FT"){?> selected="selected"<? }?> >FUND TRANSFER</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4" style="width: 25%;">Amount<br/>
                                                            <div class="col-sm-3 has-feedback">
                                                                <?=form_input($amount)?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4" style="width: 30%;">Donner Name<br/>
                                                            <div class="col-sm-3 has-feedback">
                                                                <?=form_input($name)?>
                                                            </div>
                                                        </div>
                                                      
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="clearfix"> </div><br/><br/>
                                            <div id="chquedata" <? if($payment_mode=="CSH" || $payment_mode=="CREDIT CARD" || $payment_mode=="DEBIT CARD" || $payment_mode=="DD"){?> style="display:none"<? }?> >
                                                <strong>Cheque Details</strong><hr />
                                                <table class="entry-table">
                                                    <tr>
                                                        <td>
                                                            <div class="form-group col-md-4" style="width: 25%;">Cheque Number<br/>
                                                                <div class="col-sm-3 has-feedback">
                                                                    <?=form_input($cheque_no)?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4" style="width: 25%;">Cheque Date<br/>
                                                                <div class="col-sm-3 has-feedback">
                                                                    <?=form_input($cheque_date)?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4" style="width: 25%;">Bank<br/>
                                                                <div class="col-sm-3 has-feedback">
                                                                    <?=form_input($bank_name)?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4" style="width: 25%;">Branch<br/>
                                                                <div class="col-sm-3 has-feedback">
                                                                    <?=form_input($branch_name)?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="clearfix"> </div><br/><br/>
                                            <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll">
                                                <table class="entry-table table">
                                                    <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Ledger Account</th>
                                                        <th>Dr Amount</th>
                                                        <th>Cr Amount</th>
                                                        <th colspan=2>Actions</th>
                                                        <th colspan=2>Cur Balance</th>
                                                    </tr>
                                                    </thead>
                                                    <?
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

                                                        if ($current_entry_type['bank_cash_ledger_restriction'] == '4')
                                                            echo "<td>" . form_input_ledger('ledger_id[' . $i . ']', isset($ledger_id[$i]) ? $ledger_id[$i] : 0, '', $type = 'bankcash') . "</td>";
                                                        else if ($current_entry_type['bank_cash_ledger_restriction'] == '5')
                                                            echo "<td>" . form_input_ledger('ledger_id[' . $i . ']', isset($ledger_id[$i]) ? $ledger_id[$i] : 0, '', $type = 'nobankcash') . "</td>";
                                                        else
                                                            echo "<td>" . form_input_ledger('ledger_id[' . $i . ']', isset($ledger_id[$i]) ? $ledger_id[$i] : 0) . "</td>";

                                                        echo "<td>" . form_input($dr_amount_item) . "</td>";
                                                        echo "<td>" . form_input($cr_amount_item) . "</td>";

                                                        echo "<td>" . img(array('src' => asset_url() . "images/icons/add.png", 'border' => '0', 'alt' => 'Add Ledger', 'class' => 'addrow')) . "</td>";
                                                        echo "<td>" . img(array('src' => asset_url() . "images/icons/delete.png", 'border' => '0', 'alt' => 'Remove Ledger', 'class' => 'deleterow')) . "</td>";

                                                        echo "<td class=\"ledger-balance\"><div></div></td>";

                                                        echo "</tr>";
                                                    }

                                                    echo "<tr><td colspan=7></td></tr>";
                                                    echo "<tr id=\"total\"><td colspan=2><strong>Total</strong></td><td id=\"dr-total\">0</td><td id=\"cr-total\">0</td><td>" . img(array('src' => asset_url() . "images/icons/gear.png", 'border' => '0', 'alt' => 'Recalculate Total', 'class' => 'recalculate', 'title' => 'Recalculate Total')) . "</td><td></td><td></td></tr>";
                                                    echo "<tr id=\"difference\"><td colspan=2><strong>Difference</strong></td><td id=\"dr-diff\"></td><td id=\"cr-diff\"></td><td></td><td></td><td></td></tr>";
                                                    ?>

                                                </table>
                                            </div>
                                            <?
                                            echo "<p>";
                                            echo form_label('Narration', 'entry_narration');
                                            echo "<br />";
                                            echo form_textarea($entry_narration);
                                            echo "</p>";

                                            echo "<p>";
                                            echo form_label('Tag', 'entry_tag');
                                            echo " ";
                                            echo form_dropdown('entry_tag', $entry_ac_tags, $entry_tag);
                                            echo "</p>";

                                            echo form_hidden('has_reconciliation', $has_reconciliation);

                                            //echo "<p>";
                                            //echo form_submit('submit', 'Update');
                                            ?>
                                            <div class="col-md-12">
                                                <div class="col-md-3" style="width: 15%;"><button  type="submit" class="btn btn-primary ">Update</button></div>
                                                <div class="col-md-3" style="width: 15%;"><a class="btn btn-refresh " href=<?echo base_url().'accounts/entrymaster/edit/'.$current_entry_type['label'].'/'.$entry_id;?>><i
                                                            class="fa fa-refresh nav_icon icon_white"></i>Reload</a></div>
                                                <div class="col-md-3" style="width: 15%;"> <a class="btn btn-back "  href=<?echo base_url().'accounts/entrymaster/show/'.$current_entry_type['label'];?>><i
                                                            class="fa fa-chevron-left nav_icon icon_white"></i>Back</a></div>
                                            </div>
                                            <div class="clearfix"> </div><br/>

                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row calender widget-shadow"  style="display:none">
                        <h4 class="title">Calender</h4>
                        <div class="cal1"></div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </div>


    <?
    $this->load->view("includes/footer");
    ?>



