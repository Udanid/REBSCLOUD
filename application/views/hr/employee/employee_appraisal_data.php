<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<h4><span style="float:right; color:#FFF" ><a href="javascript:close_edit()"><i class="fa fa-times-circle"></i></a></span></h4>
<div name="print_div" id="print_div" class="table widget-shadow">
  <h4 style="background-color: transparent; color: black; text-align: center; display:none;" name="print_title" id="print_title"> <br>Leave Report: <?php echo "Year - ".$year.", Branch - ".ucfirst($branch); ?></h4>
  <button onclick="sent_to_print()" name="print_icon" id="print_icon"><img src="<?php echo base_url(); ?>application/assets/images/icons/print.png" border="0" alt="Re Print Payment Entry"/></button>
  <a href="#"  name="generate_excel_icon" id="generate_excel_icon"><i class="fa fa-file-excel-o"></i></a>
  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
    <table class="table" style="border-collapse:collapse;" border="1">
      <thead>
        <tr bgcolor="LightGray" >
          <th >Category Name</th>
          <th >Score</th>
          <th >Remark</th>
        </tr>

      </thead>
      <tbody>
				<? if($appraisal_data){
					foreach ($appraisal_data as $key => $value) {?>
						<tr>
						<td ><?=$value->performance_category?></td>
	          <td ><?=$value->score?></td>
	          <td ><?=$value->remarks?></td>
					</tr>
				<?	}
				}?>

      </tbody>
    </table>
		<div class="col-md-10"><label>Future Goals Discussed: </label>
			<p><?=$appraisal_commentdata->future_goals?></p></br>
		</div>
		<div class="col-md-10"><label>Supervisor / Appraiser Comments:  </label>
			<p><?=$appraisal_commentdata->supervise_comment?></p></br>
		</div>
		<div class="col-md-10"><label>Employee Comments:  </label>
			<p><?=$appraisal_commentdata->employee_comment?></p></br>
		</div>
  </div>
</div>



<script>

	function close_edit(){
		$('#popupform').delay(1).fadeOut(800);
	}

	function sent_to_print(){
		var restorepage = $('body').html();
		$('#print_title').show();
		$('#print_icon').hide();
		$('#generate_excel_icon').hide();
		var printcontent = $('#print_div').clone();
		$('body').empty().html(printcontent);
		window.print();
		$('#print_title').hide();
		$('#print_icon').show();
		$('#generate_excel_icon').show();
		$('body').html(restorepage);
	}

	$("#generate_excel_icon").click(function (e) {
		var restorepage = $('body').html();
		$('#print_title').show();
		$('#print_icon').empty();
		$('#generate_excel_icon').hide();
		var printcontent = $('#print_div').clone();
		var contents = $('body').empty().html(printcontent);
		//window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=print_div]').html()));
		var result = 'data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=print_div]').html());
        this.href = result;
        this.download = "leave_report.xls";
		$('#print_title').hide();
		$('#print_icon').show();
		$('#generate_excel_icon').show();
		$('body').html(restorepage);
	});

</script>
