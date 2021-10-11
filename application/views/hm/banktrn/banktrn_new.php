
<script type="text/javascript">
$( function() {
    $( "#trndate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );

    $(document).ready(function() {
        
        $("#empsearch").chosen({
            allow_single_deselect : true
        });

    });


    
function loadcurrent_block(id)
{

 if(id!=""){
	 
							 $('#incomelist').delay(1).fadeIn(600);
    					    document.getElementById("incomelist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#incomelist" ).load( "<?=base_url()?>hm/cashier/search_branch_income/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);
	
 }
}

</script>
<form data-toggle="validator" name="myform" method="post" action="<?=base_url()?>hm/cashier/transfer_list"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">
                    <div class="form-group">
                        <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="branch_code" name="branch_code" >
                    <option value="">Select Branch</option>
                    <? if(check_access('all_branch')){   foreach($searchdata as $row){?>
                    
                    <option value="<?=$row->branch_code?>"><?=$row->branch_name?></option>
                    <? }}
					else {?>
                     <option value="<?=$this->session->userdata('branchid')?>"><?=$this->session->userdata('branchname')?></option>
                    <? }?>
             
					</select>  </div>
                    <div class="form-group" >
                                                             <select class="form-control" name="banks" id="banks" required >
                                                                <option value="">Select Bank Account</option>
                                                                <? if($banks){foreach($banks as $raw){?>
                                                                    <option value="<?=$raw->id?>" ><?=$raw->ref_id?> - <?=$raw->name?></option>
                                                                <? }}?>
                                                            </select>
                                                      
                    </div>
                    <div class="form-group" >
                                                  <input type="text" class="form-control" name="trndate" id="trndate" value="<?=date("Y-m-d")?>"  placeholder="Transfer Date" required="required" />
                                                      
                    </div>
                   
                </div>
                
              
                
                
                
            </div>
        </div>
    </div>
      <div class="row">
    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;" id="incomelist">
</div></div>
</form>

