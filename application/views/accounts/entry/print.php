
<?



$date=$this->config->item('account_fy_start');
$year= substr($date,0,4);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Print -Entry Number</title>
    <?php echo link_tag(asset_url() . 'images/favicon.ico', 'shortcut icon', 'image/ico'); ?>
    <link type="text/css" rel="stylesheet" href="<?php echo asset_url(); ?>css/printentry.css">
</head>
<script>
    function printfunction()
    {
        window.print() ;

        //window.close();
    }
</script>
<style>
    #receipt{


    }
    .address{
        font-size:10px;
    }
</style>

<body onload="printfunction()">
<div id="receipt" style="width:1000px;height:650px;text-align:center;">
    <table width="900" align="center"  border="0" cellpadding="0" cellspacing="0">
        <tr><td rowspan="3"><h3><?=companyname?></h3>
                <br /><strong>Entry Voucher</strong>
        <tr></tr>
    </table>
    <hr />
    <br />
    <table width="80%" style="font-weight:bold" align="center"><tr><td align="left">Entry No : <?php echo full_entry_number($entry_type_id, $cur_entry->number); ?></td>
            <td align="right"> Date :  <?php echo $cur_entry->date; ?></td></tr>
        <tr><td align="left">Type : <? echo $current_entry_type['label']; //print_r($current_entry_type);?></td><td align="right"> Amount:  Rs. <?=number_format($entry_fulldata->dr_total, 2, '.', ',')?></td></tr>

    </table><br /><br />


    <table width="80%"  align="center" border="1" cellpadding="0" cellspacing="0">
        <thead><tr><th>Type</th><th>Ledger Account</th><th>Dr Amount</th><th>Cr Amount</th></tr></thead>
        <?php
        $odd_even = "odd";
        foreach ($cur_entry_ac_ledgers->result() as $row)
        {
            echo "<tr class=\"tr-" . $odd_even . "\">";
            echo "<td align=left'>" . convert_dc($row->dc) . "</td>";
            echo "<td align=left'>" .$row->ledger_id.'-'. $this->Ledger_model->get_name($row->ledger_id) . "</td>";
            if ($row->dc == "D")
            {
                echo "<td align=right'>Dr " . $row->amount . "</td>";
                echo "<td></td>";
            } else {
                echo "<td></td>";
                echo "<td align=right'>Cr " . $row->amount . "</td>";
            }
            echo "</tr>";
            $odd_even = ($odd_even == "odd") ? "even" : "odd";
        }
        ?>
        <tr class="entry-total"><td colspan=2><strong>Total</strong></td><td id=dr-total>Dr <?php echo $cur_entry->dr_total; ?></td><td id=cr-total>Cr <?php echo $cur_entry->cr_total; ?></td></tr>
        <?php
        if ($cur_entry->dr_total != $cur_entry->cr_total)
        {
            $difference = $cur_entry->dr_total - $cur_entry->cr_total;
            if ($difference < 0)
                echo "<tr class=\"entry-difference\"><td colspan=2><strong>Difference</strong></td><td id=\"dr-diff\"></td><td id=\"cr-diff\">" . $cur_entry->cr_total . "</td></tr>";
            else
                echo "<tr class=\"entry-difference\"><td colspan=2><strong>Difference</strong></td><td id=\"dr-diff\">" .  $cur_entry->dr_total .  "</td><td id=\"cr-diff\"></td></tr>";
        }
        ?>
    </table>
    <br />
    <table  width="80%"  align="center"  border="0" cellpadding="0" cellspacing="0">
        <tr><td colspan="10" align="left">Narration :
                <span class="bold"><?php echo $cur_entry->narration; ?></span>

            </td></tr></table>
    <br />

    <table  border="1" align="center" width="80%"  cellpadding="0" cellspacing="0"><tr style="font-weight:bold">
            <td>Generate By</td><td>Prepared By</td><td>Checked By</td></tr>
        <tr height="40"><td><?=ucfirst($this->session->userdata('user_name'))?></td><td>&nbsp;</td><td>&nbsp;</td></tr></table>

</div>