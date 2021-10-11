
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
</script>
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Monthend Process</h3>
      <!--search-box-->
      <div class="search-box-cust" id="custsearch">
         
      </div><!--//end-search-box-->
      <br>

      <div class="widget-shadow">

          <ul id="myTabs" class="nav nav-tabs" role="tablist">

           <li role="presentation" class="active">
          	<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" onClick="addTopblock();" aria-expanded="false">Active Period</a></li>
           <li role="presentation"><a href="#profile" onClick="activatechosen();removeTopblock();" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Month list</a></li>
       
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
					<h4>Active Period
                                 <span style="float:right"> </span></h4></div>
                     

                   <div class=" widget-shadow bs-example" id="custtable" data-example-id="contextual-table" >
                   
 <div class="tableFixHead"> 
 
                
 <? if($monthenddata)?>
                        <table class="table"> <thead> <tr style="font-weight:bold"> <td>Start Date :</td><td><?=$monthenddata->period_start?></th> 
                        <td>End Date :</td><td><?=$monthenddata->period_end?></td> <td> <? if($monthenddata->period_end <= date('Y-m-d')){ if($this->session->userdata('username') == '703410758V' || $this->session->userdata('username') == 'accuser'){?>   <button type="button" onClick="call_delete('<?=$monthenddata->id?>')"   id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Close Period</button><? } }?> </td> <tbody> 
                    
                          </tbody></table></div>
                          
                    </div>
                </div>
               
                <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
                   <p>
                   
                 <div class="form-title">
					<h4>Closed Period List
                                 <span style="float:right"> </span></h4></div>
                
                
                    <table class="table">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Period Start date</th>
                            <th>Period End date</th>
                            <th>Period Start By</th>
                             <th>Start date</th>
                             
                              <th>Period End By</th>
                             <th>End date</th>
                               
                          
                            <th colspan="3"></th>
                        </tr>
                        </thead>
                       
                        
                        <? $c=0; 
						if($monthedlist){foreach ($monthedlist as $row)
                        {
                        ?>
                        <tbody>
                            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                            <td><?=$row->id?></td>
                                  <td><?=$row->period_start?></td>
                                    <td><?=$row->period_end?></td>
                                     <td><?=$row->start_by?></td>
                                <td><?=$row->start_date?></td>
                                  <td><?=$row->end_by?></td>
                                <td><?=$row->end_date?></td></tr>
                             
                            
                            
                         <? }?>
                         <? }?>
                    </table>
                   </p>
                </div>
               
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
                text: "Are You sure you want to Close Current Period ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>cm/monthend/close_period/"+document.deletekeyform.deletekey.value;
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
