 <script type="text/javascript">

   
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
 


function loadcurrent_list_printed(id1)
{
	
	
	  var type=document.getElementById("letter_type_printed").value;
	 var id=document.getElementById("cus_code").value;
 if(id!="" & type!=""){
	 
	
					 $('#plandata_printed').delay(1).fadeIn(600);
	 			    document.getElementById("plandata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#plandata_printed" ).load( "<?=base_url()?>re/customerletter/printed_letter_list/"+type+'/'+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#lotinfomation').delay(1).fadeOut(600);
	 $('#plandata').delay(1).fadeOut(600);
 }
}


 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashier/add_advance" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($searchdata){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Letter Type</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.." onchange="loadcurrent_list_printed(this.value)"   id="letter_type_printed" name="letter_type_printed" >
                    <option value=""></option>
                    <?    foreach($searchdata as $row){?>
                    <option value="<?=$row->type_id?>"><?=$row->type?></option>
                    <? }?>
             
					</select> </div>
                    <label class="col-sm-3 control-label">Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_list_printed(this.value)" id="cus_code" name="cus_code" >
                    <option value=""></option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?>&nbsp;</option>
                    <? }?>
             
					</select> </div>
                          </div><? }?></div>
                          <div id="plandata_printed" style="display:none">
                           
							
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>