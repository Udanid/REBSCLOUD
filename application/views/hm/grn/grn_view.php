
<!DOCTYPE HTML>
<html>
<head>

	<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_notsearch");
	?>
	<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
	<script type="text/javascript">

    $(document).ready(function(){
        
            $("#prjid").chosen({
		     allow_single_deselect : true
		    });

		    $("#lotid").chosen({
		     allow_single_deselect : true
		    });

		    $("#poid").chosen({
		     allow_single_deselect : true
		    });


        $("#grn_form").submit(function(e){
		    e.preventDefault();
		    var checkbox_checked_count = $('input[name="grns[]"]:checked').length;
		    var grnnumber = $('#grnnumber').val();
		    var grndate = $('#grndate').val();
		    if(checkbox_checked_count==0){
              alert("Please Enter At least one Purchase Order")  
		    }else{
             
               if(grnnumber=="" || grndate==""){
               	 alert("Please Enter GRN Number And GRN Date")
               }else{
               	 //$('#grn_form').submit();
                 e.currentTarget.submit();
               }
              
		    }
		});

			// cal unit sum
			$('#purchase_table').on('change', '.quantity', function() {
				var price = $(this).closest('tr').find('.price').val();
				var quantity = $(this).closest('tr').find('.quantity').val();

				var tot_price=quantity*price;
				$(this).closest('tr').find('.tot_price').val(tot_price.toFixed(2));
				total_cal();

			});
			$('#purchase_table').on('change', '.price', function() {
				var price = $(this).closest('tr').find('.price').val();
				var quantity = $(this).closest('tr').find('.quantity').val();
				var tot_price=quantity*price;
				$(this).closest('tr').find('.tot_price').val(tot_price.toFixed(2));
				total_cal();
			});
			window.total_cal = function()
			{
				// cal total SUM
				var tot_p=0;
				var tot_q=0;
				var tot_p_q=0;
				$('.price').each(function()
				{
					var val = $.trim( $(this).val().replace(/,/g, "") );
					if ( val ) {
						tot_p=parseFloat(tot_p)+parseFloat(val);
					}
				});
				$('.quantity').each(function()
				{
					var val = $.trim( $(this).val().replace(/,/g, "") );
					if ( val ) {
						tot_q=parseFloat(tot_q)+parseFloat(val);
					}
				});
				$('.tot_price').each(function()
				{
					var val = $.trim( $(this).val().replace(/,/g, "") );
					if ( val ) {
						tot_p_q=parseFloat(tot_p_q)+parseFloat(val);
					}
				});
				$('#tot_un_price').val(tot_p.toFixed(2));
				$('#tot_quantity').val(tot_q);
				$('#tot_tot_price').val(tot_p_q.toFixed(2));
			}
			$( function() {
					$( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
				} );
    });

	$(document).on('click','table td .deleterow', function() {//change .live to .on
		$(this).parent().parent().remove();
		window.total_cal();
	});


	function load_polist_and_project_list(id){
	   $('#loadpoitems').html('');	
       if(id=='all'){
          $("#lotlist").html("");
	      $( "#lotlist" ).append("<label class='control-label'>Site To</label><select name='lotid' id='lotid' class='form-control' required='required' onChange='load_polist(this.value)'><option value='all'>NO Site</option></select>");

	      $("#polists").html("");
	      $( "#polists" ).append("<label class='control-label' >PO Number</label><select name='poid' id='poid' class='form-control' required='required' onChange='load_poItems(this.value)'><option value=''>Select PO</option>\
												<?
                                                 foreach($polist as $pl){
												?>
												 <option value='<?=$pl->poid?>''><?=$pl->po_code?>-<?=$pl->poid?></option>\
												<?
                                                 }
												?>
											</select>");

	        $("#lotid").chosen({
		     allow_single_deselect : true
		    });

		    $("#poid").chosen({
		     allow_single_deselect : true
		    });


       }else{
       	 loading_unitlist(id);
         loading_polist(id);
       }
	}

	function loading_unitlist(id){
     console.log("inside unitlist "+id)
     $("#lotlist").html("");
	 $( "#lotlist" ).load( "<?=base_url()?>hm/hm_grn/get_project_rel_lots/"+id);
	}

    function loading_polist(id){
     $('#loadpoitems').html('');	
     console.log("inside polist "+id)
     $("#polists").html("");
     var lotid = "";
	 $( "#polists" ).load( "<?=base_url()?>hm/hm_grn/get_project_rel_po/"+id+"/"+lotid);
    }

    function load_polist(id){
     $('#loadpoitems').html('');
     if(id=='all'){
     	$("#polists").html("");
	    $( "#polists" ).append("<label class='control-label' >PO Number</label><select name='poid' id='poid' class='form-control' required='required' onChange='load_poItems(this.value)'><option value=''>Select PO</option>\
												<?
                                                 foreach($polist as $pl){
												?>
												 <option value='<?=$pl->poid?>''><?=$pl->po_code?>-<?=$pl->poid?></option>\
												<?
                                                 }
												?>
											</select>");
     }	
     else{
     	$("#polists").html("");
        var prjid = $('#prjid').val();
	    $( "#polists" ).load( "<?=base_url()?>hm/hm_grn/get_project_rel_po/"+prjid+"/"+id);
     }
     
    }

	function load_poItems(id){
      $("#loadpoitems").html("");
      var prjid = $('#prjid').val();
      if(prjid=='all'){
      	var pid = "";
      }else{
      	var pid = prjid;
      }

      var lotid = $('#lotid').val();
      if(lotid=='all'){
      	var lid = "";
      }else{
      	var lid = lotid;
      }
	  $( "#loadpoitems" ).load( "<?=base_url()?>hm/hm_grn/get_poid_rel_data/"+id+"/"+pid+"/"+lid);
	}

	function edit_grn(id){
     $('#popupform').delay(1).fadeIn(600);
     $( "#popupform" ).load( "<?=base_url()?>hm/hm_grn/get_grn_related_data/"+id+"/1/stts");
	}

	function approve_grn(id){
	 console.log(id)
	 document.deletekeyform.deletekey.value=id;
     $('#complexConfirm_confirm').click();
     //grn_appr_disappr(id,1)
	}

    function cancel_grn(id){
     
     document.deletekeyform.deletekey.value=id;
     $('#complexConfirm_subtask').click();
     console.log(id)
     //grn_appr_disappr(id,2)
    }

    function viewgrn(id){
     var res = id.split('_');
     var ids = res[0];
     var stts = res[1];
     console.log(ids+" "+stts)
     $('#popupform').delay(1).fadeIn(600);
     $( "#popupform" ).load( "<?=base_url()?>hm/hm_grn/get_grn_related_data/"+ids+"/2/"+stts);
    }

    function pop_upwindow(id,action)
	{
		$('#popupform').delay(1).fadeIn(600);
		$( "#popupform" ).load( "<?=base_url()?>hm/hm_purchase_orders/edit_view/"+id+"/"+action );
	} 

	function close_edit(id)
	{
			$('#popupform').delay(1).fadeOut(800);
	}

</script>

<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">

		<div class="table">



			<h3 class="title1">New GRN</h3>

			<div class="widget-shadow">
				<ul id="myTabs" class="nav nav-tabs" role="tablist">
					
				  <li role="presentation" class="active"><a href="<?=base_url()?>hm/hm_grn" id="progresslst-tab" role="tab" aria-controls="progresslst" aria-expanded="false">New GRN</a></li>

		          <li role="presentation"><a href="<?=base_url()?>hm/hm_grn/grn_pending_list" id="profile-tab" role="tab" aria-controls="profile" aria-expanded="false">Pending GRN List</a></li>

		          <li role="presentation"><a href="<?=base_url()?>hm/hm_grn/grn_full_list" id="profile-tab" role="tab" aria-controls="profile" aria-expanded="false">GRN List</a></li>

				</ul>
				<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;height:500px;">
					<? $this->load->view("includes/flashmessage");?>

					<div role="tabpanel" class="tab-pane fade  active in" id="profile" aria-labelledby="profile-tab">
						<p>
							<form data-toggle="validator" method="post" id="grn_form" action="<?=base_url()?>hm/hm_grn/add_grn">
								<div class="row">
									<div class=" widget-shadow" data-example-id="basic-forms">
										<div class="form-title">
											<h4>New GRN</h4>
										</div>
										<div class="row">
										<div class="form-group col-md-3">
											<label class="control-label">Project To</label>
											<select name="prjid" id="prjid" class="form-control" onChange="load_polist_and_project_list(this.value)"  >
												<option value="">Select Project To</option>
												<option value="all">Main Stock</option>
												<?
												 if($prjlist){
                                                 foreach($prjlist as $pl){
												?>
												 <option value="<?=$pl->prj_id?>"><?=$pl->project_code?>-<?=$pl->project_name?> stock</option>
												<?
                                                 }
                                                }
												?>
											</select>
										</div>
										<div class="form-group col-md-3" id="lotlist">
											<label class="control-label">Unit To</label>
											<select name="lotid" id="lotid" class="form-control"required="required" onChange="load_polist(this.value)"  >
												<option value="all">NO Unit</option>
											</select>
										</div>		
										<div class="form-group col-md-3">
											<label class="control-label"> GRN Number</label>
											<input type='text' class='form-control' id='grnnumber' name='grnnumber' required="required" value="<?=$newgrnnumber?>" readonly="readonly">
										</div>
										<div class="form-group col-md-3" id="polists">
									 		<label class="control-label" >PO Number</label>
									 		<select name="poid" id="poid" class="form-control"required="required" onChange="load_poItems(this.value)"  >
												<option value="">Select PO</option>
												<?
												 if($polist){
                                                 foreach($polist as $pl){
												?>
												 <option value="<?=$pl->poid?>"><?=$pl->po_code?>-<?=$pl->poid?></option>
												<?
												  }
                                                 }
												?>
											</select>
										</div>
										<div class="form-group col-md-3">
											<label class="control-label">Date</label>
 											<input type='text' class='form-control date' id='grndate' name='grndate' required='required'>
										</div>
										
										<table class="table" id="purchase_table" width="50%">
													<thead>
													<tr>
														<th>Batch Code</th>
														<th>Meterial</th>
														<th>Quantity</th>
														<th >Received Quantity</th>
														<th ></th>
													</tr>
													</thead>
													<tbody id="loadpoitems">
														
												    </tbody>
									</table>
										
									</div>
									
									
													<div><button type="submit" id="grnsubmit" class="btn btn-primary disabled pull-right" >Update GRN</button>
													</div>
													
										</div>
									</div>
								</form>
							</p>

						</div>
					
					</div>
				</div>
			</div>



						<div class="col-md-4 modal-grids">
							<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
							<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
											<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4>
										</div>
										<div class="modal-body" id="checkflagmessage">
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_subtask" name="complexConfirm_subtask"  value="DELETE"></button>
						<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
						
						<form name="deletekeyform">  
							<input name="deletekey" id="deletekey" value="0" type="hidden">
						</form>
						
						<div class="row calender widget-shadow"  style="display:none">
							<h4 class="title">Calender</h4>
							<div class="cal1">

							</div>
						</div>



						<div class="clearfix"> </div>
					</div>
				</div>
				<!--footer-->
		<script type="text/javascript">

			$("#complexConfirm_confirm").confirm({
                title:"GRN confirmation",
                text: "Are You sure you want to confirm This GRN ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                    var id = document.deletekeyform.deletekey.value;
					grn_appr_disappr(id,1);
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });

            $("#complexConfirm_subtask").confirm({
                title:"GRN Cancel",
                text: "Are You sure you want to Cancel This GRN ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var id = document.deletekeyform.deletekey.value;
					grn_appr_disappr(id,2);
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });

			function grn_appr_disappr(id,stts){
		    	$.ajax({
		            cache: false,
		            type: 'GET',
		            url: '<?php echo base_url()?>hm/hm_grn/grn_approve_disapprove_process',
		            data: {'id':id,'stts':stts},
		            success: function(data) {
		               console.log(data)
		               var base = '#actions'+id;
		               $(base).html('');
		               if(stts==1){
		               //	alert("GRN No "+id+" Approved")
                        $(base).append('Confirmed <i class="fa fa-check nav_icon icon_green"></i>');
		               }else{
		               //	alert("GRN No "+id+" Cancelled")
		               	$(base).append('Cancelled <i class="fa fa-times nav_icon icon_red"></i>');
		               }
                       //$("#grntotallist").html('');
		               refresh_grnlist();
		            }
		        });
            }

            function refresh_grnlist(){
              $('#grntotallist').delay(1).fadeIn(600);
              $('#grntotallist').load("<?=base_url()?>hm/hm_grn/totalgrnlist");
              console.log("function works")
            }

</script>

				<?
				$this->load->view("includes/footer");
				?>
