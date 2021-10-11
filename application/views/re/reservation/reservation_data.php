
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	 $.validator.setDefaults({ ignore: ":hidden:not(select)" })
	 $("#myform").validate({
        rules: {cus_code:"required"},
		submitHandler: function(form) { // <- pass 'form' argument in
			$("#submit").attr("disabled", true);
			form.submit(); // <- use 'form' argument here.
		},
    });
	
	$('#prj_id').prop('disabled', true).trigger("chosen:updated");
	
	setTimeout(function(){
		$("#prj_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Project Name"
    	});
    $("#project_id").chosen({
        allow_single_deselect : true,
      search_contains: true,
      no_results_text: "Oops, nothing found!",
      placeholder_text_single: "Project Name",  
      width:100
      });
		$("#cus_code").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select Customer"
    	});
 	}, 800);
});

function check_activeflag(id)
{

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_resevation', id: id,fieldname:'res_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					//$('#popupform').delay(1).fadeIn(600);
					//$( "#popupform" ).load( "<?=base_url()?>re/reservation/add_data/"+id );
					window.location="<?=base_url()?>re/reservation/add_data/"+id;
				}
            }
        });
}


function loadcurrent_block(id)
{
 if(id!=""){

	$('#blocklist').delay(1).fadeIn(600);
    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
	$( "#blocklist" ).load( "<?=base_url()?>re/reservation/get_blocklist/"+id );
	
 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);

 }
}

//Ticket No:3331 Added By Madushan 2021-08-24
function loadcurrent_block_search(id)
{
 if(id!=""){

  $('#blocklist_search').delay(1).fadeIn(600);
    document.getElementById("blocklist_search").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
  $( "#blocklist_search" ).load( "<?=base_url()?>re/reservation/get_blocklist_search/"+id );
  
 }
 else
 {
   $('#blocklist_search').delay(1).fadeOut(600);

 }
}

//Ticket No:3331 Added By Madushan 2021-08-24
function search_res_data(id)
{
  //alert(id)
  var prj_id = $('#project_id').val();
  var lot = $('#lot_id').val();
  var cus_nic = $('#cus_nic').val();

 if(prj_id!="" || lot!="" || cus_nic!=""){
    
    if(prj_id == '')
      prj_id = 'all';
    if(lot == '' || typeof lot == 'undefined')
      lot = 'all';
    if(cus_nic == '')
      cus_nic = 'all';

     $('#res_data_search').delay(1).fadeIn(600);

             $('#res_data_search').delay(1).fadeIn(600);
                  document.getElementById("res_data_search").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
          $( "#res_data_search" ).load( "<?=base_url()?>re/reservation/seach_reservation/"+prj_id+'/'+lot+'/'+cus_nic );
          



 }
 else
 {
   $('#res_data_search').delay(1).fadeOut(600);
 }
}

function load_fulldetails(id)
{
	 if(id!="")
	 {
		 var prj_id= document.getElementById("prj_id").value
		  var branch_code= document.getElementById("branch_code").value;
		  if(branch_code=='')
		  branch_code='ÁLL';
		  else
		   var branch_code = branch_code.split(",")[0];
	 	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; //alert( "<?=base_url()?>re/reservation/get_fulldata/"+id+"/"+prj_id+"/"+branch_code)
		   $( "#fulldata").load( "<?=base_url()?>re/reservation/get_fulldata/"+id+"/"+prj_id+"/"+branch_code);
	 }
}
function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}


function call_confirm(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm_confirm').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}
function load_branchproject(id)
{
			 document.getElementById("prjlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; var res = id.split(",")[0];
		//	 alert("<?=base_url()?>re/reservation/get_branch_projectlist/"+res)
			  $( "#prjlist").load( "<?=base_url()?>re/reservation/get_branch_projectlist/"+res);



}
function close_view(){
	$('#popupform').delay(1).fadeOut(800);
}
function viewCustomer(cus_code){

	$('#popupform').delay(1).fadeIn(600);
	$( "#popupform" ).load( "<?=base_url()?>cm/customer/view/"+cus_code );

}

function enableProjects(val){
	if(val != ''){
		$('#prj_id').prop('disabled', false).trigger("chosen:updated");
	}else{
		$('#prj_id').prop('disabled', true).trigger("chosen:updated");
	}
}
</script>

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">New Reservation</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">

           <li role="presentation" <? if($tab==''){?> class="active" <? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Reservation Data</a></li>
           <li role="presentation" <? if($tab=='list'){?> class="active" <? }?>><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Reservation List</a></li>


        </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">


                 <? $this->load->view("includes/flashmessage");?>
                <div role="tabpanel" class="tab-pane fade <? if($tab==''){?> active in <? }?>" id="profile" aria-labelledby="profile-tab">


                       <form id="myform" method="post" action="<?=base_url()?>re/reservation/add" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms">
                       <div class="form-title">
								<h4>Basic Information </h4>
						</div>
                        <div class="form-body form-horizontal">
                            <? if($prjlist){?>
                          <div class="form-group">
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."  <? if(! check_access('all_branch')){?> disabled <? }?>  id="branch_code" name="branch_code" onChange="load_branchproject(this.value)" >
                    <option value="">Search here..</option>
                    <?    foreach($branchlist as $row){?>
                    <option value="<?=$row->branch_code?>,<?=$row->shortcode?>" <? if($row->branch_code==$this->session->userdata('branchid')){?> selected<? }?>><?=$row->branch_name?></option>
                    <? }?>

					</select> </div>
                    <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   id="sale_type" name="sale_type" >
                    <option value="1">Sales Division</option>
                     <option value="2">Marketing  Division </option>


					</select> </div>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."  required id="cus_code" name="cus_code" onChange="enableProjects(this.value);" >
                    <option value=""></option>
                    <?    foreach($cuslist as $row){?>
                    <option value="<?=$row->cus_code?>"><?=$row->id_number?> - <?=$row->first_name?> <?=$row->last_name?></option>
                    <? }?>

					</select> </div>
                                       <div class="clearfix"> </div> <br />
                    <div class="col-sm-3 " id="prjlist">  <select class="form-control" placeholder="Qick Search.." required  onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value=""></option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>

					</select> </div>
                     <div class="col-sm-3 " id="blocklist">   </div>
                          </div><? }?></div>


                       </div></div>
                       <div id="fulldata" style="min-height:100px;"></div>



					</form></p>
                </div>
                <div role="tabpanel" class="tab-pane fade  <? if($tab=='list'){?> active in <? }?> " id="list" aria-labelledby="list-tab">
                       <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; margin-top:-40px; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">
                  
                     
                     <div class="form-group">
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."  onchange="loadcurrent_block_search(this.value)" id="project_id" name="project_id" >
                            <option value=""></option>
                            <?   foreach($prjlist as $row){?>
                            <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                            <? }?>

                          </select> </div>
                          </div>

                           <div class="form-group">
                           <div id='blocklist_search'></div>
                          </div>

                 
                      <div class="form-group">
                            <input type="text" name="cus_nic" id="cus_nic" class="form-control" placeholder="Customer NIC">
                      </div>
                  
                    <div class="form-group">
                        <button type="button" onclick="search_res_data()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>
            
        </div>

                        <div id="res_data_search">
                        <table class="table"> <thead> <tr> <th>Project Name</th><th>Lot Number</th> <th>Customer Name </th> <th>Customer NIC </th ><th>Reserve Date </th ><th style="text-align:right;">Sale Value</th><th style="text-align:right;">Discount</th><th style="text-align:right;">Discounted Price</th><th style="text-align:right;">Minimum Down Payment</th><th style="text-align:center;">DP Completion Date</th><th>Create By </th><th>Confirm By </th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->project_name ?></td><td> <?=$row->lot_number ?>-<?=$row->plan_sqid ?></td> <td><a  href="javascript:viewCustomer('<?=$row->cus_code?>')" title="View Customer Info"><?=$row->first_name ?> <?=$row->last_name ?></a></td> <td><?=$row->id_number ?></td><td><?=$row->res_date?></td>
                          <td align="right"><?=number_format($row->seling_price,2)?></td> 
                             <td align="right"><?=number_format($row->discount,2)?></td>
                              <td align="right"><?=number_format($row->discounted_price,2)?></td>
                        <td align="right"><?=number_format($row->min_down,2)?></td>
                        <td align="center"><?=$row->dp_cmpldate?></td>
                         <td><?=get_user_fullname($row->apply_by)?></td>
                               <td><?=get_user_fullname($row->confirm_by)?></td>

                        <td align="right"><div id="checherflag">


                        <? if($row->res_status=='PENDING'){?>
                         <a  href="javascript:check_activeflag('<?=$row->res_code?>')" title="Confirm"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                             <a  href="javascript:call_confirm('<?=$row->res_code?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                             <a  href="javascript:call_delete('<?=$row->res_code?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr>

                                <? }} ?>
                          </tbody></table>
                          <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                        </div>
                    </div>
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
                    window.location="<?=base_url()?>re/reservation/delete/"+document.deletekeyform.deletekey.value;
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

                    window.location="<?=base_url()?>re/reservation/confirm/"+document.deletekeyform.deletekey.value;
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
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>
