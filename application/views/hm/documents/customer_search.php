 <script type="text/javascript">

   
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
 


function loadcurrent_customer(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#cuspanel').delay(1).fadeIn(600);
	 			    document.getElementById("cuspanel").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#cuspanel" ).load( "<?=base_url()?>hm/documents/land_docs/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#cuspanel').delay(1).fadeOut(600);
 }
}


 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashier/add_advance" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($searchdata){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Customer</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_customer(this.value)" id="cus_code" name="cus_code" >
                    <option value="">Search here..</option>
                    <?    foreach($searchdata as $row){?>
                    <option value="<?=$row->cus_code?>"><?=$row->first_name?>  <?=$row->last_name?> - <?=$row->id_number?></option>
                    <? }?>
             
					</select> </div>
                          </div><? }?></div>
                          <div id="cuspanel" style="display:none">
                           
							
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>