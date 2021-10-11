
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>

<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<!--For webcam capture-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script> -->
<style type="text/css">
    #results { padding:10px; border:1px solid #CCC; background:#fff; }
</style>
<!--//for webcam capture-->
<script type="text/javascript">
$( function() {
    $( "#cus_dob_search" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );
</script>
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Customer Data</h3>
      <!--search-box-->
      <div class="search-box-cust" id="custsearch">
          <form class="input">
          <select class="sb-search-input input__field--madoka" placeholder="Qick Search.."  id="seach" name="seach"   onChange="getCustomerbyID(this.value)">
          <option value=""></option>

          <?=$searchlist?>
          </select>

           <button type="submit"  class="search-box_submit">SEARCH</button>

          </form>

      </div><!--//end-search-box-->
      <br>

      <div class="widget-shadow">

          <ul id="myTabs" class="nav nav-tabs" role="tablist">

           <li role="presentation" class="active">
          	<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" onClick="addTopblock();" aria-expanded="false">Customer List</a></li>
           <? if(check_access('add_customer')){?> <li role="presentation"><a href="#profile" onClick="activatechosen();removeTopblock();" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add New customer</a></li>
          <? }?>
        </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">

               <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
               <br>
              <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>




              <div class="form-title">
								<h4>All Customers<span style="float:right"> <a href="javascript:load_printscrean2()"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span>
								</h4></div>
                                <br>
                                	  <form data-toggle="validator" method="post" action="<?=base_url()?>cm/customer/search_report"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; margin-top:-40px; background-color: #eaeaea;">


            <div class="form-body">
                <div class="form-inline">

                    <div class="form-group col-sm-3">
                        <select class="form-control" placeholder="Qick Search.."    id="prj_id_search" name="prj_id_search" >
                    <option value="">All Projects </option>
                    <?    foreach($re_prjlist as $row){?>
                    <option value="re,<?=$row->prj_id?>"><?=$row->project_name?> </option>
                    <? }?>
              <?    foreach($hm_prjlist as $row){?>
                    <option value="hm,<?=$row->prj_id?>"><?=$row->project_name?> </option>
                    <? }?>
					</select>  </div>

                      <div class="form-group col-sm-3" >
                       <select class="form-control" placeholder="Qick Search.."    id="cus_id_search" name="cus_id_search" >
                    <option value="">Customer </option>
                    <?    foreach($searchdata as $row){?>
                    <option value="<?=$row->cus_code?>"><?=strtoupper($row->first_name)?>  <?=strtoupper($row->last_name)?>  <?=strtoupper($row->id_number)?> <?=strtoupper($row->mobile)?></option>
                    <? }?>

					</select>  </div>
                     <div class="form-group col-sm-3" id="blocklist">
                      <input type="text" name="cus_dob_search" id="cus_dob_search" placeholder="DOB"  class="form-control" >
                    </div>
                    <div class="form-group col-sm-3">
                        <button type="submit"   id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>

        </div>


    </div>
</form>


                   <div class=" widget-shadow bs-example" id="custtable" data-example-id="contextual-table" >
 <div class="tableFixHead"> 
 <? if($monthenddata)?>
                        <table class="table"> <thead> <tr class="active"> <th>Start Date</th><th><?=$monthenddata->period_start?></th> 
                        <th>End Date</th><th><?=$monthenddata->period_end?></th> <th>Mobile </th> <th>E mail</th> <th>Status</th><th></th></tr> </thead><tbody> 
                    
                          </tbody></table></div>
                          
                    </div>
                </div>
               <? if(check_access('add_customer')){?>
                <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
                   <p></p>
                </div>
                <? }?>
            </div>
         </div>
      </div>
      <!-- The blueimp Gallery widget -->
     


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

<button type="button" style="display:none; visibility:hidden;" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none; visibility:hidden;" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>cm/customer/delete/"+document.deletekeyform.deletekey.value;
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

                    window.location="<?=base_url()?>cm/customer/confirm/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
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
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->

<!--footer-->
<?
	$this->load->view("includes/footer");
?>
