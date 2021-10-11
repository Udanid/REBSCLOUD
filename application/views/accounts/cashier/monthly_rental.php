
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
$( function() {
    $( "#paydate" ).datepicker({dateFormat: 'yy-mm-dd' ,
			maxDate: '<?=$this->session->userdata("current_end")?>'});

  } );
jQuery(document).ready(function() {
  $("#prj_id").chosen({
     allow_single_deselect : true
    });

	$("#loan_code").chosen({
     allow_single_deselect : true
    });
	$("#cus_code").chosen({
     allow_single_deselect : true
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
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>re/customer/edit/"+id );
				}
            }
        });
}
 function loadcurrent_block(id)
{
	//alert(id)
 if(id!=""){ $('#fulldata').delay(1).fadeOut(600);

							 $('#blocklist').delay(1).fadeIn(600);
    					    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#blocklist" ).load( "<?=base_url()?>re/eploan/get_blocklist/"+id );

					 $('#myloanlist').delay(1).fadeIn(600);
    					    document.getElementById("myloanlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#myloanlist" ).load( "<?=base_url()?>re/eploan/get_project_loan/"+id );




 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);

 }
}
function load_loanlist(id)
{
 if(id!=""){
	  $('#fulldata').delay(1).fadeOut(600);
							 $('#myloanlist').delay(1).fadeIn(600);
    					    document.getElementById("myloanlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#myloanlist" ).load( "<?=base_url()?>re/eploan/get_lot_loan/"+id );






 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);

 }
}

function loan_fulldata(id)
{//alert('sss');
	 if(id!="")
	 {
		var paydate=document.getElementById("paydate").value;
	 	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		   $( "#fulldata").load( "<?=base_url()?>re/eploan/get_rentalpaydata/"+id+"/"+paydate);
	 }
}

function load_fulldetails(id)
{

	 if(id!="")
	 {var paydate=document.getElementById("paydate").value;

	 	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		   $( "#fulldata").load( "<?=base_url()?>re/eploan/get_rentalpaydata/"+id+"/"+paydate);
	 }
}
function load_detailsagain()
{
	id=document.getElementById("loan_code").value;

 if(id!=""){

	 var paydate=document.getElementById("paydate").value;
	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		   $( "#fulldata").load( "<?=base_url()?>re/eploan/get_rentalpaydata/"+id+"/"+paydate);






 }

}

function call_delete_follow(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_epfollowups', id: id,fieldname:'id' },
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

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">

             <? //transfer_todayint('2018-01-25')?>

      <h3 class="title1">Loan Payments</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">

           <li role="presentation"  <? if(!$this->session->flashdata('tab')){?> class="active"<? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Monthly Instalment</a></li>
             <li role="presentation"  <? if($this->session->flashdata('tab')=='history'){?> class="active"<? }?>><a href="#history" role="tab" id="history-tab" data-toggle="tab" aria-controls="history" aria-expanded="true">Payment History</a></li>



        </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">

            <? $this->load->view("includes/flashmessage");?>

                <div role="tabpanel" class="tab-pane fade <? if(!$this->session->flashdata('tab')){?>active in<? }?>" id="profile" aria-labelledby="profile-tab">


                       <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashier/pay_rental" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms">
                       <div class="form-title">
								<h4>Monthly Instalment </h4>
						</div>
                        <div class="form-body form-horizontal">
                            <? if($loanlist){?>
                          <div class="form-group"><div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value="">Project Name</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>

					</select></div><div class="col-sm-3 " id="blocklist"></div>
                          <div class="col-sm-3 "  id="myloanlist">  <select class="form-control" placeholder="Qick Search.."    id="loan_code" name="loan_code"  onChange="load_fulldetails(this.value)">
                    <option value="">Loan search</option>
                    <?    foreach($loanlist as $row){?>
                    <option value="<?=$row->loan_code?>" ><?=$row->unique_code?> - <?=$row->id_number?> <?=$row->last_name ?></option>
                    <? }?>

					</select></div>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="paydate"    readonly  name="paydate" value="<?=date("Y-m-d")?>"    data-error="" required  onChange="load_detailsagain()" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                         <? }?>
                       </div>
                        <div id="fulldata" style="min-height:100px;"></div>
                          <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>


                       </div>


                       </div>




					</form></p>
                </div>
                    <div role="tabpanel" class="tab-pane fade  <? if($this->session->flashdata('tab')=='history'){?>active in<? }?>" id="history" aria-labelledby="history-tab">
                    <?  $this->load->view("re/eploan/payment_history"); ?>
                    </div>
                     <div role="tabpanel" class="tab-pane fade  <? if($this->session->flashdata('tab')=='followups'){?>active in<? }?> " id="followups" aria-labelledby="followups-tab">
                    <? //  $this->load->view("re/eploan/followup_index"); ?>
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
                    window.location="<?=base_url()?>re/eploan/delete_feedback/"+document.deletekeyform.deletekey.value;
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

                    window.location="<?=base_url()?>re/customer/confirm/"+document.deletekeyform.deletekey.value;
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
