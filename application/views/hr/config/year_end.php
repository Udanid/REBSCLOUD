<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
	function load_printscrean1()
{
			window.open( "<?=base_url()?>hr/employee/emp_leave_list_excel");

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
              $('#messageBoard').html('');
							$('#messageBoard').append('<div class="alert alert-success  fade in"><button type="button" class="close" data-dismiss="alert" aria-label="Close">\
									<span aria-hidden="true">&times;</span></button>HR Year End Successfully Processed.</div>')
							$('#year_end').hide();
						},
						error: function(e) {
              $('#messageBoard').html('');
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
			<h3 class="title1">Year End</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Year End</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >

					<div class=" widget-shadow bs-example" data-example-id="contextual-table" >
            <button type="button" onclick="call_year_end()" id="year_end" class="btn btn-danger btn-lg" >Run HR Year End</button>

					</div>
				</div>

			  </div>
			</div>
		  </div>
	  </div>
	</div>

  </div>
</div>

<script>

	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}

</script>
