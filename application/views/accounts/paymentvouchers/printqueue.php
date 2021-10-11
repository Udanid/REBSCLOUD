
<script>
    function printlist()
    {
        window.open('<?=base_url()?>index.php/accounts/paymentvouchers/printlist');
        window.location.reload();

    }
</script>
<table border=0 cellpadding=5 class="simple-table">
    <thead>
    <tr>
        <th>Date</th>
        <th>Ledger Account</th>
        <th>Cheque No</th>
        <th>Cheque Status</th>
        <th>Voucher Amount</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($entry_data->result() as $row)
    {
        $current_entry_type = entry_type_info($row->entry_type);
//print_r($row);
        echo "<tr>";

        echo "<td>" . $row->date . "</td>";

        echo "<td>";
        echo $this->Tag_model->show_entry_tag($row->tag_id);
        echo $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
        echo "</td>";

        echo "<td>". $row->CHQNO."</td>";
        echo "<td>" . $row->CHQSTATUS . "</td>";
        echo "<td>" . $row->amount. "</td>";

        echo"<td>";
        echo "" . anchor('accounts/paymentvouchers/printone/'. $row->entryid , img(array('src' => asset_url() . "images/icons/print.png", 'border' => '0', 'alt' => 'Re Print ' . $current_entry_type['name'] . ' Entry')), array('title' => 'rint  Voucher ' . $row->entryid, 'target' => '_blank')) . "</td> ";


        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<!--<input  type="button" name="print" value="Print List"  onclick="printlist();" />
-->
