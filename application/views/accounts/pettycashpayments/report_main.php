
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_customer");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">

     $( function() {
    $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
	 $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );
jQuery(document).ready(function() {


	$("#prj_id").focus(function() { $("#prj_id").chosen({
     allow_single_deselect : true
    }); });




});

function load_currentchart(id)
{
	var list=document.getElementById('projectlist').value;
	var res = list.split(",");
	//alert(document.getElementById('estimate'+id).value)

			//$('#canvas'+res[i]).delay(1).fadeIn(1000);
			 document.getElementById("chartset").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';

			$( "#chartset" ).load( "<?=base_url()?>re/home/mychart/"+id );
			$( "#chartset2" ).load( "<?=base_url()?>re/home/mychart/"+id );

}
function load_projectdata(code)
{
	if(code=='03')
	{
		$('#projectdata').delay(1).fadeOut(600);
	}
	else
	$('#projectdata').delay(1).fadeIn(600);
}
function load_fulldetails()
{
	  var todate=document.getElementById("todate").value;
	   var bookid=document.getElementById("bookid").value;
	// alert(month)

     if(bookid!='' && todate!='')
       {//alert("<?=base_url()?>accounts/cashadvance/report_data/"+todate+'/'+bookid)

			 $('#fulldata').delay(1).fadeIn(600);
    		  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';

		 	  $( "#fulldata").load( "<?=base_url()?>accounts/pettycashpayments/report_data/"+todate+'/'+bookid);

       }
	  else
	  {
		   document.getElementById("checkflagmessage").innerHTML='Please Select Cash Book and Date to generate report';
		   $('#flagchertbtn').click();
		  // $('#fulldata').delay(1).fadeOut(600);
	  }
}
function call_confirm(id,ddate)
{
	//var tot_val=$('#reim_amount').val();
	var tot_amt=$('#reim_amount').val();
	var tot_bal=$('#ledger_bal').val();
	var tot_val=parseFloat(tot_amt)+parseFloat(tot_bal);
	if(tot_val<=500000)
	{
	 document.deletekeyform.deletekey.value=id;
	 document.deletekeyform.deletedate.value=ddate;

					$('#complexConfirm_confirm').click();
				}else{
					document.getElementById("checkflagmessage").innerHTML='You cannot Reimberse more than Rs.500000';
					$('#flagchertbtn').click();
				}

//alert(document.testform.deletekey.value);

}
function loadbranchlist(itemcode,caller)
{
var code=itemcode.split("-")[0];
//alert("<?=base_url().$searchpath?>/"+code)
if(code!=''){
	//alert(code)
	//$('#popupform').delay(1).fadeIn(600);
	$( "#branch-"+caller ).load( "<?=base_url()?>common/get_bank_branchlist/"+itemcode+"/"+caller );}

}
function load_printscrean2()
{

			window.open( "<?=base_url()?>re/customer/excel_cusdata/");

}
</script>

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Cash Reimbursement  Report</h3>
     			<br>
      <div class="widget-shadow">
      <ul id="myTabs" class="nav nav-tabs" role="tablist">
           <li role="presentation" <? if($list==''){?> class="active"<? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Reimbursement Report</a></li>
           <li role="presentation" <? if($list=='book'){?> class="active"<? }?>><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Reimbursement  List</a></li>

        </ul>
          <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
           <div role="tabpanel" class="tab-pane fade <? if($list==''){?>  active in <? }?>" id="profile" aria-labelledby="profile-tab">
            <div class="row">
       <div class="row-one">
                 	  <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/income/search"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; margin-top:-40px; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">

                    <div class="form-group">
                        <select class="form-control" placeholder="Qick Search.."    id="bookid" name="bookid" >
                    <option value="">Select Cash Book </option>
                    <?    foreach($datalist as $row){?>
                    <option value="<?=$row->id?>"><?=$row->type_name?> <?=$row->name?></option>
                    <? }?>

					</select>  </div>

                      <div class="form-group" id="blocklist">
                      <input type="text" name="todate" id="todate" placeholder="As ar Date"  class="form-control" >
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="load_fulldetails()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>

        </div>


    </div>
</form>   <div class="clearfix"> </div><br><div id="fulldata" style="min-height:100px;"></div>    <br />
<br /><br /><br /><br /><br /><br /><br /><br /><br /></p> </div></div></div> <div role="tabpanel" class="tab-pane fade  <? if($list=='book'){?>  active in <? }?> " id="list" aria-labelledby="list-tab">
                <?  $this->load->view("accounts/pettycashpayments/reimbursement_list");?>
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
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm1" name="complexConfirm_confirm1"  value="DELETE"></button>


<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
<input name="deletedate" id="deletedate" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>accounts/pettycashpayments/delete_reimbersment/"+document.deletekeyform.deletekey.value;
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
                text: "Are You sure you want to apply Reimbersement ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					//var code=1
					 var amount=document.getElementById('reim_amount').value;
                    window.location="<?=base_url()?>accounts/pettycashpayments/apply_reimbersment/"+document.deletekeyform.deletekey.value+'/'+document.deletekeyform.deletedate.value+'/'+amount;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			 $("#complexConfirm_confirm1").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm Reimbersement ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					//var code=1

                    window.location="<?=base_url()?>accounts/pettycashpayments/confirm_reimbersment/"+document.deletekeyform.deletekey.value;
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
