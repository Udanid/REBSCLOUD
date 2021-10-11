<!DOCTYPE HTML>
<html>
<head>

  <?
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
  $this->load->view("includes/topbar_normal");
  ?>
  <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script>

function call_delete(id)
{
  document.deletekeyform.deletekey.value=id;
  $('#complexConfirm').click();

}

function call_confirm(id)
{
  document.deletekeyform.deletekey.value=id;
  $('#complexConfirm_confirm').click();

}
</script>
  <!-- //header-ends -->
  <!-- main content start-->
  <div id="page-wrapper">
    <div class="main-page">

      <div class="table">



        <h3 class="title1">Fixed Assets Revaluation</h3>

        <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">

            <? if(check_access('fixed_asset')){?> <li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Asset Revaluation</a></li>
          <? }?>
          <? if(check_access('fixed_asset')){?> <li role="presentation"><a href="#transfers" role="tab" id="transfers-tab" data-toggle="tab" aria-controls="transfers" aria-expanded="false">Revaluation list</a></li>
        <? }?>
      </ul>
      <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
        <div role="tabpanel" class="tab-pane fade" id="transfers" aria-labelledby="transfers-tab">


                <h4>Division Transfers</h4>
                <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                      <table class="table"> <thead> <tr>
                        <th>Asset Code</th>
                        <th>Asset Name</th>
                         <th>Purches value</th>
                         <th>Depreciation Amount</th>
                         <th>WDV</th>
                         <th>Revaluation Value</th>
                         <th>Status</th><th></th></tr> </thead>
                        <tbody>
                          <? foreach ($assets as $key => $value) {
                            ?>
                            <tr> <th><?=$value->asset_code;?></th>
                              <th><?=$value->asset_name;?></th>
                              <th class="text-right"><?=number_format($value->purches_value,2);?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                              <th class="text-right"><?=number_format($value->purches_value-$value->asset_value,2);?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                              <th class="text-right"><?=number_format($value->asset_value,2);?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                              <th class="text-right"><?=number_format($value->revaluation_val,2);?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                              <th>
                              <?
                              if($value->statues=="PENDING"){?>
                                <a  href="javascript:call_delete('<?=$value->revalution_id;?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                                <? $CI =& get_instance();
                                $user_role = $CI->session->userdata('usertype');
                                if (  check_access('confirm_revaluation')) {?>
                                <a  href="javascript:call_confirm('<?=$value->revalution_id;?>')" title="Confirm"><i class="fa fa-check nav_icon icon_blue"></i></a>
                                <?}}else if($value->statues=="CONFIRM"){
                                  ?>
                                  CONFIRMED
                                  <?}else {?>
                                    <?=$value->statues?>
                                <?  }?>
                                </th>

                              </tr>
                            <?  }?>
                          </tbody></table>
                          <div id="pagination-container"></div>
                        </div>
      </div></div>
      <div role="tabpanel" class="tab-pane fade active in" id="profile" aria-labelledby="profile-tab">
        <p>	  <? if($this->session->flashdata('msg')){?>
          <div class="alert alert-success" role="alert">
            <?=$this->session->flashdata('msg')?>
          </div><? }?>
          <? if($this->session->flashdata('error')){?>
            <div class="alert alert-danger" role="alert">
              <?=$this->session->flashdata('error')?>
            </div><? }?>

            <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/Fixedasset/asset_revaluation_add" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 validation-grids validation-grids-left widget-shadow" data-example-id="basic-forms">
                  <div class="form-title">
                    <h4>Revaluation Details</h4>
                  </div>
                  <div class="form-body">

										<div class="form-group has-feedback"  id="asset_type">
											<label for="asset_cat" class="control-label">Select Asset Category</label>
											<select name="asset_cat" id="asset_cat" class="form-control" placeholder="Asset Type" required>
												<option value="">--Select Asset Category--</option>

												<?
												foreach ($categories as $key => $value) {?>
													<option value="<?=$value->id?>"><?=$value->asset_category?></option>
													<?
												}
												?>

											</select>
											<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
											<span class="help-block with-errors" ></span>
										</div>
                    <div class="form-group has-feedback"  id="branch">
											<label for="asset" class="control-label">Select Asset	</label>
                      <select name="asset" id="asset" class="form-control" placeholder="Branch" required>
                        <option value="">--Select Asset--</option>
                        <? foreach ($all_assets as $key => $value) {?>
                          <option value="<?=$value->id?>">
                          <?=$value->asset_code?><?=$value->asset_name?></option>
                          <?
                        }
                        ?>

                      </select>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                    <div class="form-group has-feedback">
											<label for="revaluation_date" class="control-label">Date</label>
											<input type="text" class="form-control" name="revaluation_date" id="revaluation_date" placeholder="YYYY-MM-DD" data-error="">
										</div>
										<div class="form-group has-feedback">
											<label for="loan_amount" class="control-label">Revaluation Amount	</label>
											<input type="number" step="0.01" class="form-control" id="amount" name="amount" value="" placeholder="Revaluation Amount" min="0" required>
                      <input type="hidden" class="form-control" name="old_val" id="old_val" >
											<span class="help-block with-errors" ></span>
										</div>

                    <div class="bottom validation-grids">

                      <div class="form-group">
                        <button type="submit" class="btn btn-primary disabled">Submit</button>
                      </div>
                      <div class="clearfix"> </div>
                    </div>
                  </div>
                </div>
								<div class="col-md-6 validation-grids validation-grids-right widget-shadow" data-example-id="basic-forms">
                  <div class="form-title">
                    <h4>Details</h4>
                  </div>

									<div id="details_div">
									</div>
								</div>

              </div>
              <div class="clearfix"> </div>
              <br>

            </form></p>
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

  <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
  <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
  <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm2" name="complexConfirm2"  value="DELETE"></button>
  <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm2" name="complexConfirm_confirm2"  value="DELETE"></button>

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
      window.location="<?=base_url()?>accounts/Fixedasset/delete_revaluation/"+document.deletekeyform.deletekey.value;
    },
    cancel: function(button) {
      button.fadeOut(2000).fadeIn(2000);
      // alert("You aborted the operation.");
    },
    confirmButton: "Yes I am",
    cancelButton: "No"
  });

  $("#complexConfirm_confirm").confirm({
    title:"Record confirmation",
    text: "Are You sure you want to confirm this ?" ,
    headerClass:"modal-header confirmbox_green",
    confirm: function(button) {
      button.fadeOut(2000).fadeIn(2000);
      var code=1

      window.location="<?=base_url()?>accounts/Fixedasset/confirm_revaluation/"+document.deletekeyform.deletekey.value;
    },
    cancel: function(button) {
      button.fadeOut(2000).fadeIn(2000);
      // alert("You aborted the operation.");
    },
    confirmButton: "Yes I am",
    cancelButton: "No"
  });


  $(document).ready(function(){
    $( "#asset_cat" ).change(function() {
      var id=$( "#asset_cat" ).val();
      $( "#asset option" ).remove();
			$("#details_div").html("");

      $.ajax({
        headers: {
          Accept: 'application/json'
        },
        type: 'post',
        url: '<?=base_url()?>accounts/Fixedasset/get_asset_data_bycat',
        data: {id: id},
        dataType: "json",
        success: function(result){
					$( "#asset" ).append('<option value="">--Select Asset--</option>');
          jQuery.each(result, function(index, item) {

            $( "#asset" ).append('<option value="'+item.id+'">'+item.asset_code+'-'+item.asset_name+'</option>');

          });
        },
        error: function() {
          $( "#asset" ).append('<option value="">--Select Asset--</option>');

        }

      });
    });

		$( "#asset" ).change(function() {
			var id=$( "#asset" ).val();
			$("#details_div").html("");
			$.ajax({
				headers: {
					Accept: 'application/json'
				},
				type: 'post',
				url: '<?=base_url()?>accounts/Fixedasset/get_asset_alldata_byid',
				data: {id: id},
				dataType: "json",
				success: function(result){

          var last_date=result.last_date;
					var x = result.purches_value;
					var y = result.dep_val;
          if(y==null){
            y=0;
          }

					var z = x - y;
					$("#details_div").html('<div class="form-body">'+
					'<div class="form-group"><b>Purhased Date	</b>:'+result.year+'</div>'+
					'<table class="table"><tr><th>Purchase Amount:</th><th class="text-right">'+x+'</th><th></th></tr>'+
					'<tr><th>Depreciation Amount:	</th><th class="text-right">'+y+'</th><th></th></tr>'+
					'<tr><th>WDV :</th><th class="text-right">'+z+'</th><th></th></tr></table>'+
					'<div class="form-group"></div></div>');
          $("#old_val").val('');
          $("#old_val").val(result.asset_value);
          var rel_date=$( "#revaluation_date" ).val();
          if(rel_date<=last_date){
              $( "#revaluation_date" ).val('');
              $( "#revaluation_date" ).datepicker({dateFormat: 'yy-mm-dd',minDate: new Date(last_date)});
          }


				},
				error: function() {

				}

			});
		});

  });
  </script>



  <div class="row calender widget-shadow"  style="display:none">
    <h4 class="title">Calender</h4>
    <div class="cal1">
    </div>
  </div>
  <div class="clearfix"> </div>
</div>
</div>
<!--footer-->
<?
$this->load->view("includes/footer");
?>
