
<script type="text/javascript">

    function reprintprintlist_cheque(id,chqno)
    {
	 //alert(chqno)
		if(chqno!="")
		{
				
			 window.open('<?=base_url()?>index.php/accounts/payments/printone/'+id+'/'+chqno+'/reprint');
			  setTimeout(function(){
           window.location = '<?php echo current_url();?>';
     	   }, 2000);
			 
		}
		
        //window.location.reload();

      
        //window.location="<?//base_url()?>index.php/entrymaster/updateprintlist";
    }
	function runScript2(e,val) {
		//detect enter key and run the function
		if (e.keyCode == 13) {
			var tb = document.getElementById("search");
			//eval(tb.value);
			$.ajax({
				cache: false,
				type: 'POST',
				url: '<?php echo base_url().'accounts/payments/searchReprint';?>',
				data: {string:val },
				success: function(data) {
					$("#result2").html('');
					$("#result2").html(data);
				}
			});
		}
	}
function change_chequenumber(entryid,CHQID,maxnum)
{
	var val = document.getElementById("chqno"+entryid).value;
	var maxnum = document.getElementById("maxnumber"+entryid).value;
		//alert(val)
	
	if (val!="")
	 {
		
		if(parseInt(maxnum)< parseInt(val))
		{
			 document.getElementById("checkflagmessage").innerHTML='You cant Assign unprinted number to this entry';
                        $('#flagchertbtn').click();
		}
		else
		{
			$.ajax({
				cache: false,
				type: 'POST',
				url: '<?php echo base_url().'accounts/payments/change_chequenumber';?>',
				data: {chqno: val, CHQID:CHQID},
				success: function(data) {
					//alert(data);
					  window.location = '<?php echo current_url();?>';
     	  		 }
				
			});
		}
			
			
	}
	else
	{
	 document.getElementById("checkflagmessage").innerHTML='Please Enter the cheque Number first';
					$('#flagchertbtn').click();
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
  <input type="text" name="search" id="search" class="form-control" autocomplete="off" onkeypress="return runScript2(event,this.value)" placeholder="Date or Cheque No" style="width: 20%;" required>
</div>
<br />

<div class="row">
    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
    	<div id="result2">
        <table class="table">
            <thead>
            <tr>
                <th>Date</th>
                <th>No</th>
                <th>Narration</th>
                <th>Cheque No</th>
                <th>Amount</th>
                <th>Cheque Status</th>
                <th colspan="3"></th>
            </tr>
            </thead>
            <tbody>
            <?
            $c=0;
		    foreach ($entry_reprint->result() as $row)
            {
                $current_entry_type = entry_type_info($row->entry_type);
            ?>
                <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                    <td><? echo date('Y-m-d',strtotime($row->date)); ?></td>
                    <? echo "<td>" . anchor('accounts/payments/view/' . $current_entry_type['label'] . "/" . $row->id, full_entry_number($row->entry_type, $row->number), array('title' => 'View ' . $current_entry_type['name'] . ' Entry', 'class' => 'anchor-link-a')) . "</td>";
                    echo "<td>";
                    echo $this->Tag_model->show_entry_tag($row->tag_id);
                    echo  $row->narration;
                    echo "</td>";
                    ?>
                    <td><? echo $row->CHQNO; ?></td>
                    <td align=right><? echo number_format($row->dr_total, 2, '.', ','); ?></td>

                  <?  echo"<td>" ?><a href="javascript:reprintprintlist_cheque('<?=$row->id?>','<?=$row->CHQBID?>')"><i class="fa fa-print nav_icon icon_blue"></i></a><?
      ?>
                </tr>
            <?
            }
	        ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

