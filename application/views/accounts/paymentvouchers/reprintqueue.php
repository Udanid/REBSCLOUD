
<script>
    function printlist()
    {
        window.open('<?=base_url()?>index.php/accounts/paymentvouchers/printlist');
        window.location.reload();

    }
	function runScript(e,val) {
		//detect enter key and run the function
		if (e.keyCode == 13) {
			var tb = document.getElementById("search");
			//eval(tb.value);
			$.ajax({
				cache: false,
				type: 'POST',
				url: '<?php echo base_url().'accounts/paymentvouchers/searchReprint';?>',
				data: {string:val },
				success: function(data) {
					$("#result").html('');
					$("#result").html(data);
				}
			});
		}
	}
</script>

<style>
.search { position: relative; }
.search input { text-indent: 20px;}
.search .fa-search { 
  position: absolute;
  top: 10px;
  left: 7px;
  font-size: 15px;
}
</style>


<br />
<div class="search">
  <span class="fa fa-search"></span>
  <input type="text" name="search" id="search" class="form-control" autocomplete="off" onkeypress="return runScript(event,this.value)" placeholder="Date,Cheque No or Voucher No" style="width: 20%;" required>
</div>
<br />
<div id="result">
<table border=0 cellpadding=5 class="table">
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

    foreach ($entry_datar->result() as $row)
    {
        $current_entry_type = entry_type_info($row->entry_type);
//print_r($row);
        echo "<tr>";

        echo "<td>" . date('Y-m-d',strtotime($row->date)) . "</td>";

        echo "<td>";
        echo $this->Tag_model->show_entry_tag($row->tag_id);
        echo $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
        echo "</td>";

        echo "<td>". $row->CHQNO."</td>";
        echo "<td>" . $row->CHQSTATUS . "</td>";
        echo "<td>" . number_format($row->amount, 2, '.', ','). "</td>";

        echo"<td>";
        echo "" . anchor('accounts/paymentvouchers/printone/'. $row->entryid , img(array('src' => asset_url() . "images/icons/print.png", 'border' => '0', 'alt' => 'Re Print ' . $current_entry_type['name'] . ' Entry')), array('title' => 'rint  Voucher ' . $row->entryid, 'target' => '_blank')) . "</td> ";


        echo "</tr>";
    }
    ?>
    </tbody>
</table>
</div>
<!--<input  type="button" name="print" value="Print List"  onclick="printlist();" />
-->
