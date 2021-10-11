
  <!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>
<style type="text/css">
  #curprogress2{
    padding-left: 35px;
    padding-right: 35px;
  }
</style>
 <script src="<?=base_url()?>media/js/dist/Chart.bundle.js"></script>
    <script src="<?=base_url()?>media/js/utils.js"></script>
 
<script type="text/javascript">
$(function(){

  $("#prjid").chosen({
    allow_single_deselect : true,
	placeholder_text_single: "Select Project",
	width: '100%'
  });
  $("#lotid").chosen({
    allow_single_deselect : true,
	placeholder_text_single: "Select Lot",
	width: '100%'
  });

});

var deleteid="";



function load_lot_list(id){
  console.log("inside unitlist "+id)
   $("#curprogress2").html("");
   $("#lotlist2").html("");
   $( "#lotlist2" ).load( "<?=base_url()?>hm/dashboard/get_project_rel_lots/"+id);
    setTimeout(function(){
	   $("#lotid2").chosen({
		allow_single_deselect : true,
		placeholder_text_single: "Select Lot",
		width: '100%'
	  });
   },500);
}

function load_dashboard(id){
   $("#related_code").val($("#related_code").data("default-value"));
   var lot  = id;
   var proj = $('#prjid').val();
   //alert(lot+" "+proj)
   $("#curprogress2").html("");
 window.location= "<?=base_url()?>hm/dashboard/get_prj_lot_rel_stages_progress/"+proj+"/"+lot;
}

function load_current_progress2(stageid){
  var prjid = $('#prjid').val();
  var lotid = $('#lotid').val();
  if(prjid=="" || lotid==""){
    alert("Please Select Project and LOT")
  }else{
    console.log(stageid+" "+prjid+" "+lotid)
    $("#curprogress2").html("");
    $("#curprogress2" ).load( "<?=base_url()?>hm/dashboard/get_prj_lot_stage_rel_progress/"+prjid+"/"+lotid+"/"+stageid);
  }
}

function viewprogressimages(id){
  
  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>hm/hm_work_progress/view_progress_images/"+id);
}
function get_bloackdetails(id,lotid)
{

        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>re/lotdata/get_fulldata_popup/"+lotid+'/'+id );
			
}
function closepo()
{
	$('#popupform').delay(1).fadeOut(800);
}
function close_edit()
{
	$('#popupform').delay(1).fadeOut(800);
}
</script>
<link rel="stylesheet" href="<?=base_url()?>media/css/jquery.fileupload.css">
<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">
      <h3 class="title1">Housing Dashboard</h3>
    <div class="widget-shadow">
     <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
        <div class="row">
              <div class="col-md-3">
                 <div class="form-body">
                    <label>Project</label>
                       <div class="form-group">
                        <select class="form-control" name="prjid" id="prjid" onChange="load_lot_list(this.value)">
                          <option></option>
                          <? if($prjlist){
                            foreach ($prjlist as $key => $pl) {?>
                              <option value="<?=$pl->prj_id?>"> <?=$pl->project_name?></option>
                          <?  }
                          }?>
                        </select>

                     </div>

                </div>
             </div>
            <div class="col-md-3">
              <div class="form-body">
                 <div class="form-group" id="lotlist2">
                    <label>Lot</label>
                    <select class="form-control" name="lotid" id="lotid">
                      
                    </select>

                  </div>
              </div>
            </div>  

     </div>	
 </div>
       
          
  <link rel="stylesheet" href="<?=base_url()?>media/dist/css/normalize.min.css">
  <link rel="stylesheet" href="<?=base_url()?>media/dist/css/gallery.min.css">
  <div class="row">  
   <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms"> 
    <div class="form-title">
        <h4>House Design:</h4>
    </div>
    <div class="form-body">
        <div class="main wrapper clearfix">
           <section>
             
              <div id="mygallery" class="gallery">
                 <?

					 if($designtypeimgs){
			
						foreach($designtypeimgs as $dtimg){
							?>
			
						<div> <img class="img-fluid" width="50%" src="<?=base_url()?>uploads/design_type/<?=$dtimg->designtype_image?>" ></div><br />
			
							<?
							break;
						}
					 }else{
						$imgnames = '';
					 }
					 ?>
			
			
			<table class="table">
			  <tr>
				<td >Project Type </td>
				<td >&nbsp;&nbsp;:</td>
				<td ><?=$details->short_code?> - <?=$details->prjtype_name?></td>
			  </tr>
			  <tr>
				<td >Number of floors</td>
				<td >&nbsp;&nbsp;:</td>
				<td ><?=$details->num_of_floors?></td>
			  </tr>
			  <tr>
				<td >Total Extend </td>
				<td >&nbsp;&nbsp;:</td>
				<td ><?=$details->tot_ext?>(ft&#178;)</td>
			  </tr>
			  <tr>
				<td >Description </td>
				<td >&nbsp;&nbsp;:</td>
				<td ><?=$details->description?></td>
			
			  </tr>
			</table>
			<br />
			<div id="floordata">
			  <? if($floors){?>
			
			  <?  $divid=0;
				foreach ($floors as $key => $fl) {?>
				  <div class="eachfloor">
				  <h4><?=ucwords($fl->floor_name)?> - &nbsp;&nbsp;:&nbsp;&nbsp; Total Floor Extend : <?=$fl->tot_ext?>(ft&#178;)</h4>
				  <table class="table floortable">
					<tr>
					  <th><center><i class="fa fa-bed roomicon" aria-hidden="true"></i></center></th>
					  <th><center><i class="fa fa-bath roomicon" aria-hidden="true"></i></center></th>
			
					</tr>
					<tr>
					  <th><center>Number of Bedrooms</center></th>
					  <th><center>Number of Bathrooms</center></th>
					<tr>
					  <tr>
						<th><center><?=$fl->num_of_bedrooms?></center></th>
						<th><center><?=$fl->num_of_bathrooms?></center></th>
					  <tr>
						<!--floor rooms data --->
			
			
				  </table>
			
			
						<div class="floorroomsdiv">
								<? if($rooms[$fl->floor_id]){?>
								  <table class="table">
									<tr class="success">
									  <th>Room type</th>
									  <th>Room Width(ft)</th>
									  <th>Room Height(ft)</th>
									  <th>Room Length(ft)</th>
									  <th>Total Extent (ft&#178;)</th>
									  <th>Doors</th>
									  <th>Windows</th>
									</tr>
									<?
								  foreach ($rooms[$fl->floor_id] as $key => $roomdata) {?>
			
			
										<th ><h5><?=$roomdata->roomtype_name?></h5></th>
			
										<td><?=$roomdata->width?></td>
										<td><?=$roomdata->height?></td>
										<td><?=$roomdata->length?></td>
										<td><?=$roomdata->tot_extent?></td>
										<td><?=$roomdata->doors?></td>
										<td><?=$roomdata->windows?></td>
									  </tr>
			
			
								<?  }?>
								</table>
								<?
								}?>
						</div>
			
						
							  </div>
			  <?  $divid=$divid+1;}
				}?> 
              </div>
            </section>
       	</div> 
   </div> 
   
    <script src="<?=base_url()?>media/bower_components/hammerjs/hammer.min.js"></script>
  	<script src="<?=base_url()?>media/dist/js/gallery.min.js"></script>
  	<script src="<?=base_url()?>media/dist/js/main.min.js"></script>
  </div>
     
      <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms"> 
		<div class="form-title">
			<h4>House Details:</h4>
		</div>
        <div class="form-body">
                            
        <table class="table">
        <tr>
        <th>Block Number</th><td><?=$lotdetail->lot_number?>-<?=$lotdetail->plan_sqid?></td>
       
        </tr>
        <tr>
        <th>Selling Price</th><td><?=number_format($lotdetail->housing_sale,2)?></td> </tr>
         <tr> <th>Cost of Sale</th><td><?=number_format($lotdetail->housing_cost,2)?></td></tr>
          <tr> <th>Profit</th><td><?=number_format($lotdetail->housing_sale-$lotdetail->housing_cost,2)?></td>
       
        </tr>
         <tr>
        <th>Block Status</th><td><?=$lotdetail->status?>
        
        <? if($lotdetail->status!='Pending'){ ?>
         <a href="javascript:get_bloackdetails('<?=$lotdetail->prj_id?>','<?=$lotdetail->lot_id?>')"><span class="label label-success">Full Data</span></a>
         <? }?>
         </td>
       
        </tr>
        </table>
                     <? if($current_rescode){?>
       
         <table class="table">
        <tr>
        <th>Customer Name</th><td><?=$current_res->first_name?>-<?=$current_res->last_name?></td></tr>
           <tr>
            <th>Current Selling Price</th><td><?=number_format($current_res->seling_price,2)?></td></tr>
        <tr> <th>Discount</th><td><?=$current_res->discount?></td></tr>
         <tr> <th>Discounted Price</th><td><?=number_format($current_res->discounted_price,2)?></td></tr>
         <tr> <th>Actual Profit</th><td><?=number_format($current_res->discounted_price-$lotdetail->costof_sale,2)?></td></tr>
       
        
        
        </table>
		<? }?>            
	 </div>
   	</div>
<? if($finarr){?>
<div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms"> 
        <div class="form-title">
            <h4>House Progress :</h4>
        </div>
        <div class="form-body">
<?
	
		foreach($finarr as $key => $value){
		$shortcode = $value['short_code'];
		$prgress = $value['progressvalue'];
		
			$heading = $value['short_code'] .'- Period  : '. $value['start_date'] .' - '. $value['end_date'];
			$warning='';
			if($prgress < 100 & $value['end_date']<date('Y-m-d'))
			$warning='Time Exceeded !';
		
		if($prgress>=60) $class='green'; else if($prgress<60 && $prgress>=50)  $class='blue'; else if($prgress<50 && $prgress>=25)  $class='yellow'; else $class='red';?>
			
			<div class="task-info" >
          
                  <span class="task-desc "><strong><?=$heading?><span  style="color:#F00; float:right" ><?=$warning?></span></strong></span><span class="percentage"><?= number_format($prgress,2)?>% &nbsp;&nbsp;<a data-toggle="collapse" class="success" id="btn<?=$value['prj_id']?><?=$value['lot_id']?>" data-target="#demo<?=$value['prj_id']?><?=$value['lot_id']?><?=$value['code_id']?>" title="Expand"><span id="ico<?=$value['prj_id']?><?=$value['lot_id']?>"><i class="fa fa-plus-circle"></i></span></a></span>
                     <div class="clearfix"></div> 
                  </div>
                  <div class="progress progress-striped active">
                     <div class="bar <?=$class?>" style="width:<?=$prgress?>%;"></div>
                  </div>
			
			  <div id="demo<?=$value['prj_id']?><?=$value['lot_id']?><?=$value['code_id']?>" class="collapse">
			  <table class="table" width="80%">
				<tr>
					<th>#</th>
					<th width="50%">Remark</th>
					<th width="10%">Created Date</th>
					<th width="10%">Created by</th>
					<th width="10%">Confirm Date</th>
					<th width="10%">Confirm by</th>
					<th width="10%"></th>
				</tr>
				<tbody>
					<?
					$i=1;
					if($value['progressstages'])
					{
					foreach($value['progressstages'] as $prgprj){
					?>
					<tr>
					  <td><?=$i?></td>
					  <td width="50%"><?=$prgprj->progress?></td>
					  <td width="10%"><?=$prgprj->update_date?></td>
					  <td width="10%"><?=get_user_fullname_id($prgprj->updated_by)?></td>
					  <td width="10%"><?=$prgprj->confirm_date?></td>
					  <td width="10%"><?=get_user_fullname_id($prgprj->confirm_by)?></td>
					  <td width="10%"><a href="javascript:viewprogressimages(<?=$prgprj->id?>)"><i class="fa fa-eye" title="View Progress images"></i></a></td>
					</tr>
					<?
					 $i++;
					 }
					}
					?>
				</tbody>
			  </table>
                  </div>
                  <hr>
                  <?
		}

		?>
        </div>
    




            </div>
</div>
<? }?>
  
  
  
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
									<div class="modal-body" id="checkflagmessage"> Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
									</div>
								</div>
							</div>
						</div>
					</div>

<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_subtask" name="complexConfirm_subtask"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm_subtask" name="complexConfirm_confirm_subtask"  value="DELETE"></button>

<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
<script>
//.........................end file upload process jquery ............................................

            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>hm/hm_config/designtypes_delete/"+document.deletekeyform.deletekey.value;
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

