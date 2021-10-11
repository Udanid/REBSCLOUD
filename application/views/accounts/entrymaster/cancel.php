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
                    }
                });
            });

            /* On page load initiate all triggers */
            $('.dc-dropdown').trigger('change');
            $('.ledger-dropdown').trigger('change');
            $('.dr-item:first').trigger('change');
            $('.cr-item:first').trigger('change');
        });

    </script>

    <div id="page-wrapper">
        <div class="main-page">
            <div class="table">
                <h3 class="title1">Cancel Receipt Entry</h3>
                <?php $this->load->view("includes/flashmessage");?>
                <div class="widget-shadow">
                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <form name="inputform" action="<?=base_url()?>accounts/entrymaster/cancel/<?=$entry_id;?>" method="post">
                            <div class="row">
                                <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
                                    <div class="form-body">
                                        <div class="form-inline">
                                            <table class="entry-table">
                                                <tr>
                                                    <td>
                                                        <div class="form-group col-md-4" style="width: 50%;">Entry Number<br/>
                                                            <div class="col-sm-3 has-feedback">
                                                                <?php echo $current_entry_type['prefix'] . form_input($entry_number) . $current_entry_type['suffix']; ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4" style="width: 50%;">Entry Date<br/>
                                                            <div class="col-sm-3 has-feedback">
                                                                <?=form_input($entry_date) ; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="clearfix"> </div><br/><br/>
                                            <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll">
                                                <table class="entry-table table">
                                                    <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Ledger Account</th>
                                                        <th>Dr Amount</th>
                                                        <th>Cr Amount</th>
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
                                                            'readonly' => 'readonly',
                                                            'value' => isset($dr_amount[$i]) ? $dr_amount[$i] : "",
                                                            'class' => 'dr-item',
                                                        );
                                                        $cr_amount_item = array(
                                                            'name' => 'cr_amount[' . $i . ']',
                                                            'id' => 'cr_amount[' . $i . ']',
                                                            'maxlength' => '15',
                                                            'readonly' => 'readonly',
                                                            'size' => '15',
                                                            'value' => isset($cr_amount[$i]) ? $cr_amount[$i] : "",
                                                            'class' => 'cr-item',
                                                        );
                                                        $ledgerid = array(
                                                            'name' => 'ledger_id[' . $i . ']',
                                                            'id' => 'ledger_id[' . $i . ']',
                                                            'maxlength' => '15',
                                                            'readonly' => 'readonly',
                                                            'size' => '15',
                                                            'value' => isset($ledger_id[$i]) ? $ledger_id[$i] : "",
                                                            'class' => 'cr-item',
                                                        );
                                                        $ledgerdc = array(
                                                            'name' => 'ledger_dc[' . $i . ']',
                                                            'id' => 'ledger_dc[' . $i . ']',
                                                            'maxlength' => '15',
                                                            'readonly' => 'readonly',
                                                            'size' => '15',
                                                            'value' => isset($ledger_dc[$i]) ? $ledger_dc[$i] : "",
                                                            'class' => 'cr-item',
                                                        );
                                                        if($ledger_id[$i]){
                                                            echo "<tr>";

                                                            echo "<td>" . form_input($ledgerdc) . "</td>";


                                                            echo "<td>" . form_input($ledgerid). "</td>";

                                                            echo "<td>" . form_input($dr_amount_item) . "</td>";
                                                            echo "<td>" . form_input($cr_amount_item) . "</td>";





                                                            echo "</tr>";}
                                                    }

                                                    echo "<tr><td colspan=6></td></tr>";
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

                                            echo "<p>";
                                                echo " ";
                                            ?>
                                            <button style="width: 10%;" type="submit" class="btn btn-primary ">Cancel</button>
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



