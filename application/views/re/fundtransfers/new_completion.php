 <script type="text/javascript">
 $( function() {
    $( "#trndate_ex" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
function load_external(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#plandata_ex').delay(1).fadeIn(600);
	 
							    document.getElementById("plandata_ex").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
							//	alert("<?=base_url()?>re/fundtransfers/get_complete_tasklist/"+id )
					$( "#plandata_ex" ).load( "<?=base_url()?>re/fundtransfers/get_complete_tasklist/"+id );
					
				
	 
	 
		
 }
 else
 {
	 $('#lotinfomation').delay(1).fadeOut(600);
	 $('#plandata').delay(1).fadeOut(600);
 }
}



 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>re/fundtransfers/add_completion" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
                        <input type="hidden" name="trn_type_ex" id="trn_type_ex" value="External">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($prjlist){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="load_external(this.value)" id="prj_id_ex" name="prj_id_ex" >
                    <option value="">Search here..</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>
             
					</select> </div><label class="col-sm-3 control-label">Complete Date</label>
                          <div class="col-sm-3 "> <input type="text" class="form-control"   id="trndate_ex"  value="<?=date('Y-m-d')?>" name="trndate_ex"  required> </div>
                          </div><? }?></div>
                          <div id="plandata_ex" style="display:none">
                           
							
								
							</div>
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>