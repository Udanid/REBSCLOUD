<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript">
    function remove_space(value)
    {

        str = value.replace(/\s/g,'');
        $('#ledger_id').val(str);
    }
</script>

    <?
    $this->load->view("includes/header_".$this->session->userdata('usermodule'));
    $this->load->view("includes/topbar_accounts");
    ?>

    <div id="page-wrapper">
        <div class="main-page">
            <div class="table">
                <h3 class="title1">Add Ledger</h3>
                <?php $this->load->view("includes/flashmessage");?>
                <div class="widget-shadow">
                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/ledger/add"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #ffffff;">
                                    <div class="form-body">
                                        <div class="form-inline">
                                           
                                            <div class="form-group col-md-4" >Reference Code
                                                <? echo form_input($ref_id); ?>
                                            </div>
                                            <div class="form-group col-md-4" >Ledger Name
                                                <? echo form_input($ledger_name); ?>
                                            </div>
                                            <div class="clearfix"> </div><br>
                                            <div class="form-group col-md-4" >
                                                <table>
                                                    <tr><td>Parent Group</td></tr>
                                                    <tr>
                                                        <td>
                                                            <? echo form_dropdown('ledger_group_id', $ledger_group_id, $ledger_group_active); ?>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                            <div class="form-group col-md-6">
                                                <table>
                                                    <tr><td colspan="2">Opening Balance</td></tr>
                                                    <tr>
                                                        <td>
                                                            <?
                                                            echo form_dropdown_dc('op_balance_dc', $op_balance_dc);
                                                            ?>
                                                        </td>
                                                        <td>&nbsp;
                                                            <?  echo form_input($op_balance); ?>
                                                        </td>
                                                        <td>
                                                            <? echo "<span >&nbsp;&nbsp;Assets / Expenses => Dr. Balance<br />&nbsp;&nbsp;Liabilities / Incomes => Cr. Balance</span>"; ?>

                                                        </td>
                                                    </tr>
                                                </table>
                                                <br/>
                                                </div>

                                            <div class="clearfix"> </div><br>
                                            <div class="form-group col-md-12">
                                                <?
                                                echo "<span id=\"tooltip-target-2\">";
                                                echo form_checkbox('ledger_type_cashbank', 1, $ledger_type_cashbank) . " Bank or Cash Account";
                                                echo "</span>";

                                                echo "<br/>";
                                                echo "<span id=\"tooltip-content-2\">Select if Ledger account is a Bank account or a Cash account.</span>";
                                                ?>
                                            </div>
                                            <div class="clearfix"> </div><br>
                                            <div class="form-group col-md-12">
                                                <?php
                                                echo "<span id=\"tooltip-target-3\">";
                                                echo form_checkbox('reconciliation', 1, $reconciliation) . " Reconciliation";
                                                echo "</span>";
                                                echo "<br/>";
                                                echo "<span id=\"tooltip-content-3\">If enabled account can be reconciled from Reports > Reconciliation</span>";
                                                ?>
                                            </div>
                                            <div class="clearfix"> </div><br>
                                            <div class="form-group col-md-4" style="width: 15%;">
                                                <button  type="submit" class="btn btn-primary ">Create</button>
                                            </div>
                                            <div class="clearfix"> </div><br>
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
