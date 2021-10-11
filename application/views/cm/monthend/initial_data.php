
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
    $( "#init_mnth_e" ).datepicker({dateFormat: 'yy-mm-dd'});
	$( "#init_mnth_s" ).datepicker({dateFormat: 'yy-mm-dd'});
	$( "#init_y_s" ).datepicker({dateFormat: 'yy-mm-dd'});
	$( "#init_y_e" ).datepicker({dateFormat: 'yy-mm-dd'});

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
function change_lastdate(obj)
{
	var value=obj.value;
	dates=value.split("-")
	var newdate=dates[0]+'-'+dates[1]+'-30';
	obj.value=newdate
}
function change_firstdate(obj)
{
	var value=obj.value;
	dates=value.split("-")
	var newdate=dates[0]+'-'+dates[1]+'-01';
	obj.value=newdate
}
</script>
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Initial Finance Period </h3>
      <!--search-box-->
      <div class="search-box-cust" id="custsearch">
         
      </div><!--//end-search-box-->
      <br>

      <div class="widget-shadow">

          <ul id="myTabs" class="nav nav-tabs" role="tablist">

           <li role="presentation" class="active">
          	<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" onClick="addTopblock();" aria-expanded="false">Defin Initial Finance Period</a></li>
        
       
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




            
                                <br>
                     

                   <div class=" widget-shadow bs-example" id="custtable" data-example-id="contextual-table" >
                   
                    <div class="form-title">
					<h4>Initial Period
                                 <span style="float:right"> </span></h4></div>
 
 <? if($monthenddata)?>
                        <table class="table"> <thead> <tr style="font-weight:bold"> <td>Initial Month Start Date :</td>
                      <td><input type="text" name="init_mnth_s"  id="init_mnth_s" class="form-control" onChange="change_firstdate(this)" value="<?=$monthenddata->start_date?>"></td>
                         <td>End Date:</td><td><input type="text" name="init_mnth_e"  id="init_mnth_e" class="form-control" onChange="change_lastdate(this)" value="<?=$monthenddata->end_date?>"></td>
                         <td>  <? if(!$monthenddata->init_update_status){?><button type="button" onClick="call_delete('1')"   id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Update</button> <? }?></td> <tbody> 
                    
                          </tbody></table><br><br><div class="form-title">
                          <h4>Initial Finance Year
                                 <span style="float:right"> </span></h4></div>
 <div class="tableFixHead"> 
 <? if($monthenddata)?>
 <span style=" color:#F00">  Start date should be the  Ledger Opening Balance Date</span><br>
 
 <? 
 
 $year='';
	  $start_date='';
	   $end_date='';
 if($finaceyear)
 {
	 $year=$finaceyear->year;
	  $start_date=$finaceyear->start_date;
	   $end_date=$finaceyear->end_date;
 }?>
                        <table class="table"> <thead> <tr style="font-weight:bold">
                          <td>Year:</td><td><input type="text" name="init_y_y"  id="init_y_y" class="form-control"  value="<?=$year?>"></td>
                         <td> Start Date :</td>
                      <td><input type="text" name="init_y_s"  id="init_y_s" class="form-control" onChange="change_firstdate(this)" value="<?=$start_date?>"></td>
                         <td>End Date:</td><td><input type="text" name="init_y_e"  id="init_y_e" class="form-control" onChange="change_lastdate(this)" value="<?=$end_date?>"></td>
                         
                         <td>  <? if(!$finaceyear){?><button type="button" onClick="call_confirm('1')"   id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Update</button> <? }?></td> <tbody> 
                    
                          </tbody></table></div>
                          
                    </div>
                </div>
               
                <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
                   <p>
                   
                
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
                text: "Are You sure you want to Update Inital FinanceMonth?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					var sdate=document.getElementById("init_mnth_s").value;
					var edate=document.getElementById("init_mnth_e").value;
                    window.location="<?=base_url()?>cm/monthend/init_period/"+sdate+"/"+edate;
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
                text: "Are You sure you want to Update Inital Finance Year ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					var year=document.getElementById("init_y_y").value;
					var sdate=document.getElementById("init_y_s").value;
					var edate=document.getElementById("init_y_e").value;
                    window.location="<?=base_url()?>cm/monthend/init_finance_year/"+year+"/"+sdate+"/"+edate;
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
