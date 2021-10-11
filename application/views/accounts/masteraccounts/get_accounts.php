<?php
$this->load->library('master_accountlist');
?>
<div class="row">
    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
        <table class="table">
            <tr valign="top">
                <?php $asset = new Master_accountlist(); ?>
                <td>
                    <?php $asset->init(0); ?>
                    <table class="table account-table">
                        <thead>
                        <tr>
                            <th>GL Code</th>
                            <th>Account Name</th>
                            <th>Type</th>
                            <th>O/P Balance</th>
                            <th>C/L Balance</th>
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


