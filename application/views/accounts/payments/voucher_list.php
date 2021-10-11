<?
$counter=0; if($voucherdata){?>
    <table >
        <tr>
            <th>Voucher Number</th>
            <th width="100">Document Number</th>
            <th width="200">CODE/VOTE</th>
            <th width="200">&nbsp; Payee Name</th>
            <th>Discription</th>
            <th>Amount</th>
            <th><input class="form-control" type="checkbox" value="Yes" name="selectall" onclick="checkAll(this)" /></th>
        </tr>
        <? foreach($voucherdata as $row){ $counter++;?>
            <tr>
                <td><input class="form-control" type="text" name="voucherid<?=$counter?>" id="voucherid<?=$counter?>" readonly="readonly" value="<?=$row->voucherid?>" /></td>
                <td><input  class="form-control" type="text" name="refnumber<?=$counter?>" id="refnumber<?=$counter?>" readonly="readonly" value="<?=$row->refnumber?>" /></td>
                <input  class="form-control" type="hidden" name="ledger_id<?=$counter?>" id="ledger_id<?=$counter?>" readonly="readonly" value="<?=$row->ledger_id?>" /></td>
                 <input  class="form-control" type="hidden" name="paymentdes<?=$counter?>" id="paymentdes<?=$counter?>" readonly="readonly" value="<?=$row->paymentdes?>" /></td>
              
                <td><input style="width: 100%;" class="form-control" type="text" name="payeecode<?=$counter?>" id="payeecode<?=$counter?>" readonly="readonly" value="<?=$row->ledger_id?>" /></td>
                <td><input class="form-control" type="text" name="payeename<?=$counter?>" id="payeename<?=$counter?>" readonly="readonly" value="<?=$row->payeename?>" /></td>
                <td><?=$row->paymentdes?></td>
                <td><input class="form-control" type="text" name="invoiceamount<?=$counter?>" id="invoiceamount<?=$counter?>" readonly="readonly" value="<?=$row->amount ?>" /></td>
                <td><input class="form-control" type="checkbox" value="Yes" name="isselect<?=$counter?>" id="isselect<?=$counter?>"  onclick="calculatetot()"/></td>
            </tr>
        <? }?>
        <tr><td height="20px;"></td></tr>
        <tr class="tr-group" style="background-color:#FFFFE6;">
            <td colspan="4 ">Total</td>
            <td><?=form_input($amount)?><input type="hidden" name="rawmatcount" id="rawmatcount" value="<?=$counter?>" /></td>
        </tr>
    </table>
    <br />
    <table>
        <tr>
            <td>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary ">Make Payment</button>
                </div>
                <?//=form_submit('submit', 'Make Payment');?>
            </td>
        </tr>
    </table>

<? }

else{
    echo "No Confirmed Payment Vouchers available ";

}
?>