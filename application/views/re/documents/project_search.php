 <script type="text/javascript">

   
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
 


function loadcurrent_project(id)
{
	
 if(id!=""){
	 
	 
	
					 $('#projectpanel').delay(1).fadeIn(600);
	 			    document.getElementById("projectpanel").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#projectpanel" ).load( "<?=base_url()?>re/documents/project_docs/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#projectpanel').delay(1).fadeOut(600);
 }
}


 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>re/documents/update_projectdocs" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($prjlist){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_project(this.value)" id="prj_id" name="prj_id" >
                    <option value="">Search here..</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?> - <?=$row->town?></option>
                    <? }?>
             
					</select> </div>
                          </div><? }?></div>
                          <div id="projectpanel" style="display:none">
                           
							
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>