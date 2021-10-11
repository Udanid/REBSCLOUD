<link rel="stylesheet" type="text/css" href="<?=base_url()?>media/css/jquery.dataTables.css"/>

<script type="text/javascript" src="<?=base_url()?>media/js/jquery.dataTables.js"></script>
<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
	function call_delete(id)
	{
		document.deletekeyform.deletekey.value=id;
		$('#complexConfirm').click();

	}
	function load_printscrean1()
{
			window.open( "<?=base_url()?>hr/employee_extend/emp_leave_list_excel_sys");

}

	function call_year_end(){
		var siteUrl = '<?php echo base_url(); ?>';
		var d = new Date();
    var n = d.getFullYear();
		$.ajax({
			headers: {
				Accept: 'application/json'
			},
			type: 'post',
			url: '<?=base_url()?>hr/hr_config/hr_year_end',
			data: {n: n},
			dataType: "json",
						success: function(result){
							$('#messageBoard').append('<div class="alert alert-success  fade in"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
									<span aria-hidden="true">&times;</span></button>HR Year End Successfully Processed.</div>')
							$('#year_end').hide();
						},
						error: function(e) {
							$('#messageBoard').append('<div class="alert alert-danger  fade in"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
									<span aria-hidden="true">&times;</span></button>Something Went Wrong.</div>')
							$('#year_end').hide();
						console.log(e);

						}

				});
	}
</script>
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div id="page-wrapper">
  <div class="main-page">

	<div class="modal-content">
	  <div class="modal-body">
		<!--block which displays the outcome message-->
		<div id="messageBoard">
			<?php
			if($this->session->flashdata('msg') != ''){ ?>
				<div class="alert alert-success  fade in">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<?php echo $this->session->flashdata('msg'); ?>
				</div>
			<?php
			} ?>
	   </div>

		  <div class="table">
			<h3 class="title1">System Pending Leave List</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Leave List</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >

					<a href="javascript:load_printscrean1()" style="margin-left: 95%;" name="generate_excel_icon" id="generate_excel_icon"><i class="fa fa-file-excel-o"></i></a>

					<div class=" widget-shadow bs-example" data-example-id="contextual-table" >

					<table class="table" id="myTable">
					  <thead>
						<tr>
						  <th>No</th>
						  <th>Employee</th>
						  <th>Pending Leave Date</th>
							<th>updated Time</th>
						  <th>Delete</th>
						</tr>
					  </thead>
					  <tbody>
						<?php
						if($datalist){
						  $c = 0;
						  $count = 1;
						  $ci =&get_instance();
						  $ci->load->model('hr/employee_model');
						  foreach($datalist as $row){ ?>
							<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
							  <td><?php echo $count; ?></td>
							  <td>
								<?php
								$empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);
								echo $empDetails['epf_no'].' - '.$empDetails['initial'].' '.$empDetails['surname'];
								?>
							  </td>
							  <td><?php echo $row->start_date; ?></td>
							  <td><?php echo $row->lastupdate; ?></td>
								<td><a  href="javascript:call_delete('<?=$row->id;?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
								</td>


							</tr>
						  <?php
							$count++;
						  }
						} ?>
					  </tbody>
					</table>

				</div>

			  </div>
			</div>
		  </div>
	  </div>
	</div>

  </div>
</div>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
<script>
$("#complexConfirm").confirm({
	title:"Delete confirmation",
	text: "Are You sure you want to delete this ?" ,
	headerClass:"modal-header",
	confirm: function(button) {
		button.fadeOut(2000).fadeIn(2000);
		var code=1
		window.location="<?=base_url()?>hr/employee_extend/delete_pending_leave/"+document.deletekeyform.deletekey.value;
	},
	cancel: function(button) {
		button.fadeOut(2000).fadeIn(2000);
		// alert("You aborted the operation.");
	},
	confirmButton: "Yes I am",
	cancelButton: "No"
});
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}
	$(document).ready( function () {
    $('#myTable').DataTable({
			"lengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]]
		});
} );

</script>
