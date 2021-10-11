<!DOCTYPE HTML>
<html>
<head>
<?
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script>
jQuery(document).ready(function() {
	
	$("#project2").chosen({
     allow_single_deselect : true,
	 search_contains: true,
	 width: '100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select Project"
    });
});


function loadcurrent_block2(id)
{
	if(id!=""){
		$('#blocklist2').delay(1).fadeIn(600);
    	document.getElementById("blocklist2").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		$( "#blocklist2" ).load( "<?=base_url()?>hm/hm_housing/get_blocklist_reserved/"+id );
 	}
 	else
 	{
	 	$('#blocklist2').delay(1).fadeOut(600);
 	}
}

function load_housedetails(val){
	window.location="<?=base_url()?>hm/hm_housing/search_housing/"+val;
}




</script>
<div id="page-wrapper">
 <div class="main-page">
  <div class="table">
      <h3 class="title1">Housing Search</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">

          <li role="presentation"  <? if($tab=='list'){?> class="active" <? }?>>
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Housing List</a></li>
             </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px; min-height:300px;">
 		
               <div role="tabpanel" class="tab-pane fade <? if($tab=='list'){?> active in <? }?> " id="home" aria-labelledby="home-tab" >
               <br>
              <?php $this->load->view("includes/flashmessage");?>

                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                    <br>
						<div class="form-group">
                          <div class="col-sm-3">
                              <select class="form-control" name="project2" id="project2" onchange="loadcurrent_block2(this.value)">
                                  <option value=""></option>
                                  <? if($prjlist){foreach($prjlist as $raw){ ?>
                                      <option value="<?=$raw->prj_id?>"><?=$raw->project_name?></option>
                                  <? }}?>
                                   
                              </select>
                          </div>
                          <div class="col-sm-3 " id="blocklist2"></div>
                      </div>
                      <br><br>
                        <table class="table"> <thead> <tr> <th>Project</th> <th>Lot</th>  <th>House Design</th> <th>Estimated Budget</th> <th>Estimated Selling Price</th><th>Estimated Profit</th><th>Status</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->project_name?></th> <td><?=$row->lot_number ?></td> 
                        <td><?=$row->design_name?></td>
                        <td><?=number_format($row->estimate_budget,2) ?></td>
                         <td><?=number_format($row->selling_price,2) ?></td>
                          <td><?=number_format($row->selling_price-$row->estimate_budget,2) ?></td>
                        <td><?=$row->status ?></td>
                        <td align="right"><div id="checherflag">
													
                        <? if($row->status=='PENDING' ){?>
                             <a  href="javascript:call_confirm('<?=$row->lot_id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                             <a  href="javascript:call_delete('<?=$row->lot_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                      <? }?>
                        </div></td>
                         </tr>

                                <? }} ?>
                          </tbody></table>
                          
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
                text: "Are you sure you want to delete this?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>hm/hm_housing/delete/"+document.deletekeyform.deletekey.value;
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
                text: "Are you sure you want to confirm this?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1

                    window.location="<?=base_url()?>hm/hm_housing/confirm/"+document.deletekeyform.deletekey.value;
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
