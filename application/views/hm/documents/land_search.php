 <script type="text/javascript">

   
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
 


function loadcurrent_land(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#landpanel').delay(1).fadeIn(600);
	 			    document.getElementById("landpanel").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#landpanel" ).load( "<?=base_url()?>hm/documents/land_docs/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#landpanel').delay(1).fadeOut(600);
	 }
}


 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>hm/documents/update_landdoc" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($landlist){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Land</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_land(this.value)" id="land_code" name="land_code" >
                    <option value="">Search here..</option>
                    <?    foreach($landlist as $row){?>
                    <option value="<?=$row->land_code?>"><?=$row->property_name?> - <?=$row->town?></option>
                    <? }?>
             
					</select> </div>
                          </div><? }?></div>
                          <div id="landpanel" style="display:none">
                           
							
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>