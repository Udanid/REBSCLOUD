
<script>
    function printlist_cheque(id,bookid)
    {
	
	
	
	
	
		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accounts/payments/check_current_bookactive/';?>',
            data: {id: id },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					 window.open('<?=base_url()?>index.php/accounts/payments/printone/'+id+'/'+bookid);
					  setTimeout(function(){
         			  window.location = '<?php echo current_url();?>';
     	 			  }, 2000);
				}
            }
        });		
		//var chqno= document.getElementById("chqno"+id).value;
		
        //window.location.reload();

      
        //window.location="<?//base_url()?>index.php/entrymaster/updateprintlist";
    }
    function printall()
    {
        window.open('<?=base_url()?>index.php/accounts/payments/printlist');
        //window.location.reload();

        setTimeout(function(){
            window.location = '<?php echo current_url();?>';
        }, 2000);
        //window.location="<?//base_url()?>index.php/entrymaster/updateprintlist";
    }

</script>
<table border=0 cellpadding=5 class="simple-table">
    <thead>
    <tr>
        <th>Date</th>
        <th>No</th>
        <th>Ledger Account</th>
       <th>Cheque Status</th>
        <th>Cheque Amount</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($entry_pdata->result() as $row)
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

       echo "<td>" . $row->CHQSTATUS . "</td>";
        echo "<td>" . $row->cr_total . "</td>"; ?>
	<?

        echo"<td>" ?><a href="javascript:printlist_cheque('<?=$row->id?>','<?=$row->CHQBID?>')"><i class="fa fa-print nav_icon icon_blue"></i></a><?
        echo "" . "</td> ";


        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<!--<input  type="button" name="print" value="Print List"  onclick="printall();" />
-->
