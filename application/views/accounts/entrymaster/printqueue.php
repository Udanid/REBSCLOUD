
<script>
    function printlist()
    {
        window.open('<?=base_url()?>index.php/accounts/entrymaster/printlist');
        window.location.reload();
        //window.location="<?//base_url()?>index.php/entrymaster/updateprintlist";
    }
</script>
<table class="table" border=0 cellpadding=5>
    <thead>
    <tr>
        <th>Date</th>
        <th>No</th>
        <th>Ledger Account </th>
        <th>Receipt Number</th>
        <th>Reciept Status</th>
        <th>Reciept Amount</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($entry_printdata->result() as $row)
    {
        $current_entry_type = entry_type_info($row->entry_type);
//print_r($row);
        echo "<tr>";

        echo "<td>" . $row->date . "</td>";
        echo "<td>" . anchor('accounts/entrymaster/view/' . $current_entry_type['label'] . "/" . $row->id, full_entry_number($row->entry_type, $row->number), array('title' => 'View ' . $current_entry_type['name'] . ' Entry', 'class' => 'anchor-link-a')) . "</td>";

        echo "<td>";
        echo $this->Tag_model->show_entry_tag($row->tag_id);
        echo $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
        echo "</td>";

        echo "<td>" . $row->RCTNO . "</td>";
        echo "<td>" . $row->RCTSTATUS . "</td>";
        echo "<td>" . $row->cr_total . "</td>";
         ?>
            <td>
                <a href="<? echo base_url().'accounts/entrymaster/printreciepts/'.$row->id;?>" target="_blank"><i class="fa fa-print nav_icon"></i></a>


             
            </td>
            <?
        

        if($row->RCTSTATUS=="PRINT"){
            ?>
            <td>
                <a  href=<?echo base_url().'accounts/entrymaster/cancel/'.$current_entry_type['name'].'/'.$row->id;?>><i
                        class="fa fa-times nav_icon icon_red"></i></a>
            </td>
            <td>
                <a  href=<?echo base_url().'accounts/entrymaster/printpreview/'.$current_entry_type['name'].'/'.$row->id;?>><i
                        class="fa-file-text-o  nav_icon icon_blue"></i></a>
            </td>
    <?
            
        }
        else
        {
            echo"<td>&nbsp;";
        }

        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<input  type="button" name="print" value="Print List"  onclick="printlist();" />
<div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
