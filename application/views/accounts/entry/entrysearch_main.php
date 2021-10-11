<!DOCTYPE HTML>
<html>
<head>

    <script src="<?=base_url()?>media/js/dist/Chart.bundle.js"></script>
    <script src="<?=base_url()?>media/js/utils.js"></script>

<?

	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
<script type="text/javascript">

     $( function() {
    $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
	 $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );
jQuery(document).ready(function() {


	$("#prj_id").focus(function() { $("#prj_id").chosen({
     allow_single_deselect : true
    }); });


$("#ledger_id").chosen({
     allow_single_deselect : true,
     search_contains: true,
     width:'100%',
     no_results_text: "Oops, nothing found!",
     placeholder_text_single: "Select an Instance"
    });

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
    var fromdate=document.getElementById("fromdate").value;
	  var todate=document.getElementById("todate").value;
	  var ledger=(document.getElementById("ledger_id").value).replace(/ /g, "");
	  var amount=document.getElementById("amount").value;
    var discription=document.getElementById("discription").value;
    var prj_id=document.getElementById("prj_id").value;
    
    //alert(ledger);
    if(fromdate == '')
      fromdate = 'all';
    if(todate == '')
      todate = 'all';
    if(ledger == '0')
      ledger = 'all';
    if(amount == '')
      amount = 'all';
    if(discription == '')
      discription = 'all';
	// alert(month)
     if(prj_id != "all"){
        var lot_id=document.getElementById("lot_id").value;
        if(lot_id == '')
          lot_id = 'all';
        if(lot_id!='all')
        {
             $('#fulldata').delay(1).fadeIn(600);
              document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
              $( "#fulldata").load( "<?=base_url()?>accounts/entrysearch/search_entries/"+fromdate+'/'+todate+'/'+ledger+'/'+amount+'/'+discription+'/'+prj_id+'/'+lot_id);

         }
         else{
          document.getElementById("checkflagmessage").innerHTML='Please Select a lot';
           $('#flagchertbtn').click();
         }
     }
     else
        {
          if(todate !='all' && fromdate !='all'){
            lot_id = 'all';
             $('#fulldata').delay(1).fadeIn(600);
              document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
              $( "#fulldata").load( "<?=base_url()?>accounts/entrysearch/search_entries/"+fromdate+"/"+todate+"/"+ledger+"/"+amount+"/"+discription+"/"+prj_id+"/"+lot_id);

          }
          else
          {
             document.getElementById("checkflagmessage").innerHTML='Please Select date range';
           $('#flagchertbtn').click();
          }
       
        }

}

function load_blocklist(id)
{
  
 if(id!="all"){
   
               $('#blocklist').delay(1).fadeIn(600);
                  document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
          $( "#blocklist" ).load( "<?=base_url()?>accounts/entry/get_blocklist_search/"+id );
          
           $('#fromdate').val('');
           $('#todate').val('');
          $('#fromdate').css('display','none');
           $('#todate').css('display','none');
        
   
   
    
 }
 else
 {
   $('#blocklist').delay(1).fadeOut(600);
    $('#fromdate').show();
    $('#todate').show();
 }
}


</script>

<style type="text/css">

@media(max-width:1920px){
	.topup{
	margin-top:0px;
}
}
@media(max-width:360px){
	.topup{
	margin-top:0px;
}
}
@media(max-width:790px){
	.topup{
	margin-top:100px;
}
}
@media(max-width:768px){
	.topup{
	margin-top:-10px;
}
}
</style>

   <div id="page-wrapper"  >
			<div class="main-page  topup" >
				<div class="row-one">
                 	  <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/income/search"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; margin-top:-40px; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">

                    <div class="form-group">

                      <? echo form_input_ledger('ledger_id', $ledger_id);?>
                    </div>

                     <div class="form-group">
                        <select class="form-control" placeholder="Qick Search.."    id="prj_id" name="prj_id" onchange="load_blocklist(this.value)">
                        <option value="all">Select Project</option>
                         <option value="all">All</option>
                     <?  if($prjlist){foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>" <? ?>><?=$row->project_name?> </option>
                    <? }}?>

                    </select>  </div>

                    <div class="form-group" id="blocklist" style="display:none"></div>

                     <div class="form-group" >
                      <input type="text" name="discription" id="discription" placeholder="Discription" value=""  class="form-control" >
                    </div>

                    <div class="form-group" >
                      <input type="text" name="amount" id="amount" placeholder="Amount" value=""  class="form-control" >
                    </div>

                    <div class="form-group" >
                      <input type="text" name="fromdate" id="fromdate" placeholder="From Date" value=""  class="form-control" autocomplete="off">
                    </div>
                      <div class="form-group" id="blocklist">
                      <input type="text" name="todate" id="todate" placeholder="To Date"  class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="load_fulldetails()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>

        </div>


    </div>
</form>   <div class="clearfix"> </div><br><div id="fulldata" style="min-height:100px;"></div>    <br />
<br /><br /><br /><br /><br /><br /><br /><br /><br /></p>

				</div>



                 <div class="col-md-4 modal-grids">
						<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
						<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header"  style="background-color:#339">
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
                    window.location="<?=base_url()?>re/project/delete/"+document.deletekeyform.deletekey.value;
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

                    window.location="<?=base_url()?>re/lotdata/confirm_price/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            </script>


				<div class="row calender widget-shadow" style="display:none">
					<h4 class="title">Calender</h4>
					<div class="cal1" >

					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>
