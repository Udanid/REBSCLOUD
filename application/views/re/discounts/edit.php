<script type="text/javascript">
$(document).ready(function () {
    var counter = 0;

    $("#addrow").on("click", function () {

        counter = $('#myTable tr').length - 2;
		var periods = $('#periods').val();
		var levels = parseFloat($('#levels').val());
		var new_periods = parseFloat(periods)+1;
		$('#periods').val('');
		$('#periods').val(new_periods);
		if((counter%2) == 1){
        	var newRow = $("<tr class='info'>");
		}else{
			var newRow = $("<tr>");
		}
        var cols = "";

        cols += '<td><input type="number" onkeypress="return isNumber(event)" required placeholder="Within (Days)" name="period'+ new_periods +'" id="period'+ new_periods +'" class="form-control" /></td>';
		for(x=1;x <= levels; x++){
        	cols += '<td><input type="number" onkeypress="return isNumber(event)" step="0.01" name="rate'+ new_periods + x +'" placeholder="Rate (%)" id="rate'+ new_periods + x +'" class="form-control" /></td>';
		}

        cols += '<td><input type="button" class="ibtnDel btn btn-danger"  value="Delete"></td>';
        newRow.append(cols);
        //if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
        $("table.order-list").append(newRow);
        counter++;
    });

    $("table.order-list").on("change", 'input[name^="price"]', function (event) {
        calculateRow($(this).closest("tr"));
        calculateGrandTotal();                
    });


    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        calculateGrandTotal();
		var periods = $('#periods').val();
        var new_periods = parseFloat(periods)-1;
		$('#periods').val('');
		$('#periods').val(new_periods);
        counter -= 1
        $('#addrow').attr('disabled', false).prop('value', "Add Row");
    });


});

function calculateRow(row) {
    var price = +row.find('input[name^="price"]').val();

}

function calculateGrandTotal() {
    var grandTotal = 0;
    $("table.order-list").find('input[name^="price"]').each(function () {
        grandTotal += +$(this).val();
    });
    $("#grandtotal").text(grandTotal.toFixed(2));
}
</script>
<h4>Project Discount Scheme - <?=$project->project_name?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit(<?=$project->prj_id?>)"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 	<div class="row">
    	<form data-toggle="validator" method="post" id="dicountform" action="<?=base_url()?>re/discounts/edit/<?=$project->prj_id?>" enctype="multipart/form-data">
           <?
		   	$periods = array();
			$levels = array();
           	foreach($project_discount as $row){
				if($row->days){
					if (!in_array($row->days, $periods)) {
						array_push($periods,$row->days);
					}
				}
				if($row->payrate){
					if (!in_array($row->payrate, $levels)) {
						array_push($levels,$row->payrate);
					}
				}	
			}
			echo '<table id="myTable" class="table table-bordered order-list">';
			echo '<tr><th>Payment</th>';
			$y = 1;
			foreach($levels as $data2){
				echo '<th style="text-align:center"><input type="number" required onkeypress="return isNumber(event)" placeholder="Completetion (%)" name="level'.$y.'" id="level'.$y.'" value="'.$data2.'" class="form-control" /></th>';
				$y++;
			}
			echo '</tr>';
			$c = 0;
			foreach($periods as $data1){
				?>
                <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                <?
					echo '<td><input type="number" onkeypress="return isNumber(event)" required placeholder="Within (Days)" name="period'.$c.'" id="period'.$c.'" value="'.$data1.'" class="form-control" /></td>';
					$x = 1;
					foreach($levels as $data2){
						echo '<td align="center">';
							
							foreach($project_discount as $row){
								if($row->payrate == $data2 && $row->days == $data1){
									echo '<input type="number" onkeypress="return isNumber(event)" step="0.01" name="rate'.$c.$x.'" placeholder="Rate (%)" id="rate'.$c.$x.'" value="'.$row->discount.'" class="form-control" />';
								}
							}
						echo '</td>';
						$x++;
					}
				if($c != 1)
				echo '<td><input type="button" class="ibtnDel btn btn-danger"  value="Delete"></td>';
				echo '</tr>';
			$x++;	
			}
			echo '<tfoot>
				<tr>
					<td colspan="'.$y.'" style="text-align: right;">
						<input type="button" class="btn btn-primary" id="addrow" value="Add Row" />
						<input type="submit" class="btn btn-success" value="Update" />
					</td>
				</tr>
			</tfoot>';
			echo '</table>';
		   ?> 
           <input type="hidden" id="levels" name="levels" value="<?=$y-1;?>" />     
           <input type="hidden" id="periods" name="periods" value="<?=$c;?>" /> 
           <input type="hidden" id="name" name="name" value="<?=$project->project_name;?>" /> 
        </form> 
 	</div>
</div> 