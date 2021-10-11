 <script type="text/javascript">

$( function() {
	var today = new Date();
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();
	var min_date = yyyy+'-'+mm+'-01';

    $( "#request_date" ).datepicker({dateFormat: 'yy-mm-dd' ,minDate: min_date,
			maxDate: '<?=$this->session->userdata("current_end")?>'});
	
  } );

 function loadcurrent_block(id)
{
	//alert(id)
 if(id!=""){
	 $('#plandata').delay(1).fadeOut(600);
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
	 $('#plandata').delay(1).fadeOut(600);

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
{
id=document.getElementById("loan_code").value
date=document.getElementById("request_date").value
 if(id!=""){


					 $('#plandata').delay(1).fadeIn(600);
	 			    document.getElementById("plandata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#plandata" ).load( "<?=base_url()?>re/eploan/get_reschdata/"+id+'/'+date );


					



 }
 else
 {

	 $('#plandata').delay(1).fadeOut(600);
 }
}



 </script>


 <form data-toggle="validator" method="post" action="<?=base_url()?>re/eploan/add_reschedule" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;">


							<div class="form-body form-horizontal">
                            <? if($searchdata){

								?>

                          <div class="form-group"><div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value=""></option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>

					</select></div><div class="col-sm-3 " id="blocklist"></div>
                          <div class="col-sm-3 "  id="myloanlist">   <select class="form-control" placeholder="Qick Search.."   onchange="loan_fulldata(this.value)" id="loan_code" name="loan_code" >
                    <option value=""></option>
                    <?    foreach($searchdata as $row){
						$loanarr=$row->unique_code;
						?>
                    <option value="<?=$row->loan_code?>"> <?=$loanarr?> -  <?=$row->first_name?>&nbsp;<?=$row->last_name?> - <?=$row->id_number?></option>
                    <? }?>

					</select> </div> <div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" name="request_date" readonly="readonly" id="request_date" onchange="loan_fulldata(this.value)"value="<?=date("Y-m-d")?>"  >
                                            </div>
                          </div><? }?></div>
                          <div id="plandata" style="display:none">





                            </div>


</div>
</div>
</form>
