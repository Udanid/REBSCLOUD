 <script type="text/javascript">

   
 
 

function loan_payhis(id)
{

 if(id!=""){
	 
	 
	
					 $('#plandata').delay(1).fadeIn(600);
	 			    document.getElementById("plandata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#plandata" ).load( "<?=base_url()?>hm/eploan/get_paymenthistory/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	
	 $('#plandata').delay(1).fadeOut(600);
 }
}



 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>hm/reservation/add_advance" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($searchdata){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Loan </label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loan_payhis(this.value)" id="loan_code_his" name="loan_code_his" >
                    <option value="">Search here..</option>
                    <?    foreach($searchdata as $row){?>
                    <option value="<?=$row->loan_code?>"><?=$row->unique_code?>- <?=$row->first_name?>&nbsp;<?=$row->last_name?></option>
                    <? }?>
             
					</select> </div>
                          </div><? }?></div>
                          <div id="plandata" style="display:none">
                           
							
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>