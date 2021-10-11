<!DOCTYPE HTML>
<html>
<head>

<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

$("#selectDr1").chosen({
     allow_single_deselect : true,
	 width:'75%'
    });
	$("#selectCr1").chosen({
     allow_single_deselect : true,
width:'75%'
    });

});

function check_activeflag(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_rates', id: id,fieldname:'rate_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>config/rates/edit/"+id );
				}
            }
        });
}
function close_edit(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'cm_rates', id: id,fieldname:'rate_id' },
            success: function(data) {
                if (data) {
					 $('#popupform').delay(1).fadeOut(800);

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					 document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin ';
					 $('#flagchertbtn').click();

				}
            }
        });
}
var deleteid="";

</script>

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">HR Legers</h3>

      <div class="widget-shadow" >
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">HR Legers</a></li>
        </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
               <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
               <br>
             <? $ledgerlist=get_master_acclist();//call in reaccounthelpr

			 $this->load->view("includes/flashmessage");?>
                 <form data-toggle="validator" method="post" action="<?=base_url()?>hr/gratuity_compute/update_ledger" enctype="multipart/form-data">


                    <div class=" widget-shadow col-md-12   bs-example" data-example-id="contextual-table" style="margin-bottom:14%">

                        <table class="table table-bordered"> <thead> <tr> <th >Name</th> <th >Cr Account</th><th >Dr Account</th></tr>
                      </thead>
                    <tr class="active" style="font-weight:bold"><td align="center" colspan="3" >Gratuvity Ledgers</td></tr>
                    <tr><td>Gratuvity Ledgers</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr1" name="selectCr1"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account </option><? }?>
                    <? foreach ($ledgerlist as $rw){
                      $id_withcode=$this->session->userdata('accshortcode').$rw->id;?>
                    <option value="<?=$rw->id?>"
                      <? if($gratuityleger){if($gratuityleger->cr_acc==$id_withcode){?> selected<? }}?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr1" name="selectDr1"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account </option><? }?>
                    <? foreach ($ledgerlist as $rw){
                      $id_withcode=$this->session->userdata('accshortcode').$rw->id;
                      ?>
                    <option value="<?=$rw->id?>" <? if($gratuityleger){if($gratuityleger->dr_acc==$id_withcode){?> selected<? }}?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>

                          </tbody></table>
                          <div class="form-group validation-grids">
												<button type="submit" class="btn btn-primary" style="width:25%;">Update</button>

											</div>


                    </div>  </form>

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
	//$this->load->view("includes/footer");
?>
