<script type="text/javascript">
function view_confirm(id){
	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>re/reservation/view_chargers_transfer/"+id );

}

function close_view(){
  $('#popupform').delay(1).fadeOut(800);
}

function call_confirm_transfer(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_landms', id: id,fieldname:'land_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirmTransfer_confirm').click();
				}
            }
        });

}

function call_delete_transfer(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_landms', id: id,fieldname:'land_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexDeleteTransfer_confirm').click();
				}
            }
        });

}


</script>
<div class=" widget-shadow bs-example" data-example-id="contextual-table" >
	<table class="table">
		<thead>
			<th>Transfer ID</th>
			<th>From</th>
			<th>To</th>
			<th>Status</th>
			<th>Date</th>
			<th>Transfer By</th>
			<th>Confirm By</th>
			<th>Confirm Date</th>
			<th colspan="3"></th>
		</thead>
		<tbody>
			<?if($transfer_list){foreach($transfer_list as $row){?>
				<td><?=$row->id?></td>
				<td><?=$row->from_res?></td>
				<td><?=$row->to_res?></td>
				<td><?=$row->status?></td>
				<td><?=$row->date?></td>
				<td><?=$row->transfer_by?></td>
				<td><?=$row->confirm_by?></td>
				<td><?=$row->confirm_date?></td>
				<td><a  href="javascript:view_confirm('<?=$row->id?>')" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a></td>
				<?if($row->status == 'PENDING'){?>
					<td><a  href="javascript:call_confirm_transfer('<?=$row->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
					<a  href="javascript:call_delete_transfer('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
					</td>
				<?}?>
				<?}}?>
		</tbody>
	</table>
</div>

<button type="button" style="display:none" class="btn btn-delete" id="complexConfirmTransfer_confirm" name="complexConfirmTransfer_confirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexDeleteTransfer_confirm" name="complexDeleteTransfer_confirm"  value="DELETE"></button>

<script type="text/javascript">
	   $("#complexConfirmTransfer_confirm").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1

                    window.location="<?=base_url()?>re/reservation/confirm_transfer/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });

	    $("#complexDeleteTransfer_confirm").confirm({
                title:"Record Delete",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header confirmbox_red",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1

                    window.location="<?=base_url()?>re/reservation/delete_transfer/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
</script>