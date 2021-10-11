<script type="text/javascript">

$( function() {
    $( "#searchpanel_fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
	 $( "#searchpanel_todate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
jQuery(document).ready(function() {
 	 setTimeout(function(){ 
	  $("#searchpanel_search_list").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Search List"
    	});
		$("#searchpanel_branch_code").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Branch"
    	});
		$("#searchpanel_prj_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Project"
    	});
		$("#searchpanel_cus_code").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Customer"
    	});
	}, 500);
});

function load_searchpanel_fulldetails()
{
	 var month=document.getElementById("searchpanel_search_list").value;
	 
	// alert(month)
	if(month!='')
	 {
		 $('#searchpanelerror').delay(1).fadeOut(600);
		document.getElementById("advsearchform").submit(); 
		
	 }
	  else
	  { 
	  $('#searchpanelerror').delay(1).fadeIn(600);
		   document.getElementById("searchpanelerror").innerHTML='Please Select search list'; 
		 
		  // $('#fulldata').delay(1).fadeOut(600);
	  }
}
function load_searchpanel_loantype()
{
	 var month=document.getElementById("searchpanel_search_list").value;
	 
	// alert(month)
	if(month=='eploan')
	 {
		 $('#searchpanel_loantypelist').delay(1).fadeIn(600);
		
	 }
	  else
	  { 
	  $('#searchpanel_loantypelist').delay(1).fadeOut(600);
		 
		  // $('#fulldata').delay(1).fadeOut(600);
	  }
}
function load_searchpanel_blocklist(id)
{
	
 if(id!=""){
	 
							 $('#searchpanel_block').delay(1).fadeIn(600);
    					    document.getElementById("searchpanel_block").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#searchpanel_block" ).load( "<?=base_url()?>advancesarch/get_blocklist/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#searchpanel_block').delay(1).fadeOut(600);
	
 }
}


</script>



  			       	  <form data-toggle="validator" id="advsearchform" method="post" action="<?=base_url()?>advancesarch/search"  enctype="multipart/form-data">
    <div class="row">
    
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; margin-top:-40px; background-color: #eaeaea;">
          <div class="alert alert-danger" role="alert" id="searchpanelerror" style="display:none">
						
				</div>
            <div class="form-body">
                <div class="form-inline">  <div class="form-group">
                    <select class="form-control" placeholder="Qick Search.."    id="searchpanel_search_list" name="searchpanel_search_list"  onChange="load_searchpanel_loantype(this.value)" >
                    <option value=""></option>
                      <option value="allresvlist">All Sale List</option>
                  <option value="reservation">Reservation List</option>
                  <option value="resale">Reservation Resale List</option>
                   <option value="outright">Outright Settlement List</option>
                  <option value="eploan">Loan List</option>
                   <option value="reshedule">Loan Reshedule List</option>
                   <option value="rebate">Loan Rebate List</option>
                    <option value="lresale">Loan Resale List</option>
              
					</select>  </div>
                    <div class="form-group" id="searchpanel_loantypelist" style="display:none">
                    <select class="form-control" placeholder="Qick Search.."    id="searchpanel_loan_type" name="searchpanel_loan_type"   >
                    <option value=""></option>
                  <option value="NEP">Normal Easy Payment</option>
                  <option value="EPB">Bank Loan</option>
                  <option value="ZEP">Personal Fund</option>
                   
              
					</select>  </div>
                     <div class="form-group">
                    <select class="form-control" placeholder="Qick Search.."    id="searchpanel_branch_code" name="searchpanel_branch_code" >
                    <? if(check_access('all_branch')) {?>
                    <option value="ALL">All Branch</option>
                    <? }?>
                    <?    foreach($searchpanel_branchlist as $row){?>
                    <option value="<?=$row->branch_code?>"><?=$row->branch_name?> </option>
                    <? }?>
             
					</select>  </div>
                     <div class="form-group" >
                         <select class="form-control" placeholder="Qick Search.."    id="searchpanel_prj_id" name="searchpanel_prj_id"  onChange="load_searchpanel_blocklist(this.value)">
                    <option value="">All Projects</option>
                    <?    foreach($searchpanel_prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?> </option>
                    <? }?>
             
					</select>  
                    </div>
                    <div class="form-group" id="searchpanel_block"></div>
                     <div class="form-group">
                         <select class="form-control" placeholder="Qick Search.."    id="searchpanel_cus_code" name="searchpanel_cus_code" >
                    <option value=""></option>
                    <?    foreach($searchpanel_customerlist as $row){?>
                    <option value="<?=$row->cus_code?>"><?=$row->first_name?> <?=$row->last_name?>  <?=$row->id_number?></option>
                    <? }?>
             
					</select>  
                    </div>
                      <div class="form-group">
                       <input type="text" name="searchpanel_fromdate" id="searchpanel_fromdate" placeholder="from Date"  class="form-control" >
                 
                    </div>
                    <div class="form-group">
                       <input type="text" name="searchpanel_todate" id="searchpanel_todate" placeholder="To Date"  class="form-control" >
                 
                    </div>
                  
                    <div class="form-group">
                        <button type="button" onclick="load_searchpanel_fulldetails()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>
             <br><br><br><br><br><br>
        </div>
          
  
    </div>
</form>   	