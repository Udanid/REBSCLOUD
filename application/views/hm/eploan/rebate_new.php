 <script type="text/javascript">

   
 jQuery(document).ready(function() {
  

	
	 $("#loan_code").focus(function() {
	$("#loan_code").chosen({
     allow_single_deselect : true
    });
   });
  $("#prj_id").focus(function() {
	$("#prj_id").chosen({
     allow_single_deselect : true
    });
   });
	
});
  function loadcurrent_block(id)
{
	//alert(id)
 if(id!=""){
	 $('#plandata').delay(1).fadeOut(600);
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
	 $('#plandata').delay(1).fadeOut(600);
	 
							 $('#myloanlist').delay(1).fadeIn(600);
    					    document.getElementById("myloanlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#myloanlist" ).load( "<?=base_url()?>hm/eploan/get_lot_loan/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);
	
 }
}

function loan_fulldata(id)
{

 if(id!=""){
	 
	 
	
					 $('#plandata').delay(1).fadeIn(600);
	 			    document.getElementById("plandata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#plandata" ).load( "<?=base_url()?>hm/eploan/get_rebatedata/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	
	 $('#plandata').delay(1).fadeOut(600);
 }
}



 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>hm/eploan/add_rebate" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($searchdata){?>
                           <div class="form-group"><div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value="">Project Name</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>
             
					</select></div><div class="col-sm-3 " id="blocklist"></div> 
                          <div class="col-sm-3 "  id="myloanlist">   <select class="form-control" placeholder="Qick Search.."   onchange="loan_fulldata(this.value)" id="loan_code" name="loan_code" >
                    <option value="">Search here..</option>
                    <?    foreach($searchdata as $row){
						$loanarr=explode('-',$row->unique_code);
						?>
                    
                    <option value="<?=$row->loan_code?>"><?=$row->unique_code?> - <?=$row->first_name?>&nbsp;<?=$row->last_name?></option>
                    <? }?>
             
					</select> </div>
                          </div><? }?></div>
                          <div id="plandata" style="display:none">
                           
							
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>