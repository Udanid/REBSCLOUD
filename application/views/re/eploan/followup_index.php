 <script type="text/javascript">

   $( function() {
    $( "#searchdate" ).datepicker({dateFormat: 'yy-mm-dd'});
      

  } );



  function loadcurrent_block(id)
{
 if(id!=""){
	  $('#followdata').delay(1).fadeOut(600);

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
	  $('#followdata').delay(1).fadeOut(600);

							 $('#myloanlist').delay(1).fadeIn(600);
    					    document.getElementById("myloanlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#myloanlist" ).load( "<?=base_url()?>re/eploan/get_lot_loan/"+id );






 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);

 }
}


function loan_fulldata()
{
	var id= document.getElementById("loan_code").value;
	var date=document.getElementById("searchdate").value;

 if(id!=""){



					 $('#followdata').delay(1).fadeIn(600);
	 			    document.getElementById("followdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#followdata" ).load( "<?=base_url()?>re/eploan/get_followupdata/"+id+"/"+date);






 }
 else
 {

	 $('#followdata').delay(1).fadeOut(600);
 }
}

//Ticket No:3067 Added By Madushan 2021-07-12
function loadbranchlist(itemcode,caller)
{ 
	//alert(itemcode);
var code=itemcode.split("-")[0];
//alert("<?=base_url().$searchpath?>/"+code)
if(code!=''){
	//alert(code)
	//$('#popupform').delay(1).fadeIn(600);
	$( "#branch-"+caller ).load( "<?=base_url()?>common/get_bank_branchlist/"+itemcode+"/"+caller );}
	$( "#branch" ).css('display','none');
	$( "#branch-"+caller ).show();
	
}
//Ticket No:3067 Added By Madushan 2021-07-12
function update_bank_details()
{
	var bank = $('#bank1').val();
	var branch = $('#branch1').val();
	var officer = $('#contact_officer').val();
	var bank_contact = $('#contact_name').val();
	var loan_code = $('#loan_code').val();
	if(branch == '')
	{
		branch = $('#branch').val();
	}
	//alert(officer);
	if(bank != '')
	{
		$.ajax({
		cache: false,
		type: 'POST',
		url: '<?php echo base_url().'re/eploan/update_bank_details/';?>',
		data: {loan_code: loan_code, bank1: bank, branch1: branch, contact_name: bank_contact, contact_officer: officer },
		success: function(data) {
			if (data) {
				$('#bank_updated').fadeIn(60);
				document.getElementById('bank_updated').innerHTML = 'Bank Details Updated!';
			}

		}
	});
	}

	

}

 </script>


 <form data-toggle="validator" method="post" action="<?=base_url()?>re/eploan/add_followups" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;">


							<div class="form-body form-horizontal">
                            <? if($searchdata){?>
                          <div class="form-group"> <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value=""></option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>

					</select></div><div class="col-sm-3 " id="blocklist"></div>
                            <div class="col-sm-3 " id="myloanlist">  <select class="form-control" placeholder="Qick Search.."   onchange="loan_fulldata()" id="loan_code" name="loan_code" >
                    <option value=""></option>
                    <?    foreach($searchdata as $row){
						$loanarr=$row->unique_code; ?>
                    <option value="<?=$row->loan_code?>"><?=$row->unique_code?> - <?=$row->first_name?>&nbsp;<?=$row->last_name?> - <?=$row->id_number?></option>
                    <? }?>

					</select> </div>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="searchdate" value="<?=date("Y-m-d")?>"   onchange="loan_fulldata()"   name="searchdate"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>

                          </div><? }?>
                          <div id="followdata" >


                            </div>
                            </div>

</div>
</form>
					<div class="clearfix"> </div>
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