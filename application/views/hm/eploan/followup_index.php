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
					$( "#blocklist" ).load( "<?=base_url()?>hm/eploan/get_blocklist/"+id );
				
					 $('#myloanlist').delay(1).fadeIn(600);
    					    document.getElementById("myloanlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#myloanlist" ).load( "<?=base_url()?>hm/eploan/get_project_loan/"+id );
				
	 
	 
		
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
					$( "#myloanlist" ).load( "<?=base_url()?>hm/eploan/get_lot_loan/"+id );
				
					
				
	 
	 
		
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
					$( "#followdata" ).load( "<?=base_url()?>hm/eploan/get_followupdata/"+id+"/"+date);
				
					
				
	 
	 
		
 }
 else
 {
	
	 $('#followdata').delay(1).fadeOut(600);
 }
}



 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>hm/eploan/add_followups" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($searchdata){?>
                          <div class="form-group"> <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value="">Project Name</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>
             
					</select></div><div class="col-sm-3 " id="blocklist"></div> 
                            <div class="col-sm-3 " id="myloanlist">  <select class="form-control" placeholder="Qick Search.."   onchange="loan_fulldata()" id="loan_code" name="loan_code" >
                    <option value="">Search Loan.</option>
                    <?    foreach($searchdata as $row){
						$loanarr=$row->unique_code ?>
                    <option value="<?=$row->loan_code?>"><?=$row->unique_code?> - <?=$row->first_name?>&nbsp;<?=$row->last_name?></option>
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
</div>
</form>