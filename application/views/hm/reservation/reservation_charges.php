 <script type="text/javascript">

   
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}



function load_charges(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#plandata_charges').delay(1).fadeIn(600);
	 			    document.getElementById("plandata_charges").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#plandata_charges" ).load( "<?=base_url()?>hm/reservation/get_chargelist/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#plandata_charges').delay(1).fadeOut(600);
 }
}



 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>hm/reservation/add_charges" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($searchdata){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Reservation</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="load_charges(this.value)" id="res_code_charge" name="res_code_charge" >
                    <option value="">Search here..</option>
                    <?    foreach($chargedata as $row){?>
                    <option value="<?=$row->res_code?>"><?=$row->res_code?> - <?=$row->project_name?>  <?=$row->lot_number ?> - <?=$row->first_name ?> <?=$row->last_name ?>  <?=$row->id_number ?></option>
                    <? }?>
             
					</select> </div>
                          </div><? }?></div>
                          <div id="plandata_charges" style="display:none">
                           
							
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>