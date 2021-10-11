 <script type="text/javascript">

   $( function() {
    $( "#searchdateadvance" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );

function loadcurrent_block_advance(id)
{
 if(id!=""){
	  $('#advancefollowdata').delay(1).fadeOut(600);

							 $('#advanceblocklist').delay(1).fadeIn(600);
    					    document.getElementById("advanceblocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#advanceblocklist" ).load( "<?=base_url()?>re/eploan/get_advanceblocklist/"+id );

 }
 else
 {
	 $('#advanceblocklist').delay(1).fadeOut(600);

 }
}



function advance_fulldata()
{
	var id= document.getElementById("advance_lot_id").value;
	var date=document.getElementById("searchdateadvance").value;

 if(id!=""){



					 $('#advancefollowdata').delay(1).fadeIn(600);
	 			    document.getElementById("advancefollowdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#advancefollowdata" ).load( "<?=base_url()?>re/eploan/get_followupdata_adavance/"+id+"/"+date);






 }
 else
 {

	 $('#advancefollowdata').delay(1).fadeOut(600);
 }
}



 </script>


 <form data-toggle="validator" method="post" action="<?=base_url()?>re/eploan/add_followups_advance" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;">


							<div class="form-body form-horizontal">
                            <? if($searchdata){?>
                          <div class="form-group"> <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block_advance(this.value)" id="project_id" name="project_id" >
                    <option value=""></option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>

					</select></div><div class="col-sm-3 " id="advanceblocklist"></div>
               
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="searchdateadvance" value="<?=date("Y-m-d")?>"   onchange="advance_fulldata()"   name="searchdateadvance"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>

                          </div><? }?>
                          <div id="advancefollowdata" >


                            </div>
                            </div>

</div>
</form>
