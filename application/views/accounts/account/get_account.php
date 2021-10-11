<?php
$this->load->library('accountlist');
?>
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
            <table class="table table2excel" id="acctable">
                <tr valign="top">
                    <?php $asset = new Accountlist(); ?>
                    <td>
                        <?php $asset->init(0); ?>
                        <table class="table account-table">
                            <thead>
                                <tr>
                                    <th>GL Code</th>
                                    <th>Account Name</th>
                                    <th>Type</th>
                                    <th style="text-align:right; padding-right:20px;">O/P Balance D/C</th>
                                    <th style="text-align:right; padding-right:20px;">O/P Balance</th>
                                    <th style="text-align:right; padding-right:20px;">C/L Balance</th>
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <?php $asset->account_st_main(-1); ?>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>


