<?php

if($ac_projects) {
    foreach($ac_projects as $rowdata) {
        ?>
        <tr>
            <td class="tr-ledger"><?php echo $rowdata->voucherid;?></td>
            <td class="tr-ledger"><?php echo $rowdata->refnumber;?></td>
            <td class="tr-ledger"><?php echo $rowdata->applymonth;?></td>
            <td class="tr-ledger"><?php echo $rowdata->payeename;?></td>
            <td class="tr-ledger"><?php echo $rowdata->typename;?></td>
            <td class="tr-ledger" align="right"><?php echo number_format($rowdata->amount, 2, '.', ',');?></td>
            <td class="tr-ledger"><?php echo $rowdata->applydate;?></td>
            <td class="tr-ledger"><?php echo $rowdata->status;?></td>
            <td class="tr-ledger"><?php echo $rowdata->CHQNO;?></td>
            <td>
            <?php
            if($rowdata->status=="PENDING"){
                if($rowdata->typeid=='3')
                {
                    echo anchor('accounts/paymentvouchers/editsupp/' . $rowdata->voucherid  , "Edit", array('title' => 'Edit Project', 'class' => 'red-link'));
                }
                else
                {
                    echo anchor('accounts/paymentvouchers/edit/' . $rowdata->voucherid  , "Edit", array('title' => 'Edit Project', 'class' => 'red-link'));
                }
                echo " &nbsp;" . anchor('accounts/paymentvouchers/delete/' . $rowdata->voucherid , img(array('src' => asset_url() . "images/icons/delete.png", 'border' => '0', 'alt' => 'Delete  Entry', 'class' => "confirmClick", 'title' => "Delete Payment Voucher")), array('title' => 'Delete  Entry')) . " ";
                echo " &nbsp;" . anchor('accounts/paymentvouchers/confirm/' . $rowdata->voucherid , img(array('src' => asset_url() . "images/icons/match.png", 'border' => '0', 'alt' => 'Confirm  Entry', 'class' => "confirmClick", 'title' => "Confirm entry")), array('title' => 'Cinfirmed  Voucher')) . " ";
            }
            if($this->session->userdata('user_role')=='manager' & $rowdata->status=="CONFIRMED" )
            {
                if($rowdata->typeid=='3')
                {
                    echo anchor('accounts/paymentvouchers/editsupp/' . $rowdata->voucherid  , "Edit", array('title' => 'Edit Project', 'class' => 'red-link'));
                }
                else
                {
                    echo anchor('accounts/paymentvouchers/edit/' . $rowdata->voucherid  , "Edit", array('title' => 'Edit Project', 'class' => 'red-link'));
                }
            }
            if($rowdata->status=="PAID")
            {
                echo "" . anchor('accounts/paymentvouchers/printone/'. $rowdata->voucherid , img(array('src' => asset_url() . "images/icons/print.png", 'border' => '0', 'alt' => 'Re Print Payment Voucher Entry')), array('title' => 'Reprint  Voucher ' . $rowdata->voucherid, 'target' => '_blank'));
            }
            ?>
            </td>
        </tr>
        <?
    }
}
?>