
<script type="text/javascript">

jQuery(document).ready(function() {
	setTimeout(function(){ 
		$("#resale_code").chosen({
   			 allow_single_deselect : true,
	 search_contains: true,
	 width:'100%',
	 no_results_text: "Oops, nothing found!",
	 placeholder_text_single: "Select an Instance"
    	});
	}, 300);
	 
  
	 $("#res_code_set").focus(function() {
	  $("#res_code_set").chosen({
     allow_single_deselect : true
    });
	});

	
});

function load_resaledetails(id)
{
	if(id!="")
	{
		
	var type= document.getElementById("resaletype").value;
		 $('#refunddetails').delay(1).fadeIn(600);
    			  document.getElementById("refunddetails").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		 	  $( "#refunddetails").load( "<?=base_url()?>accounts/generalpayments/get_resaledetails/"+type+'/'+id);
		}
}
</script><br />
<h4>Resale data
</h4><br />
<div class="form-group col-md-4" >
<input type="hidden" value="<?=$resaletype?>" name="resaletype" id="resaletype" />
    <select name="resale_code" id="resale_code" class="form-control" style="width: 100%;"   onchange="load_resaledetails(this.value)" > 
                            <option value="">Select Resale Block</option>
                            <? // print_r($vouchertypes);
                            if($resalelist){
                                foreach ($resalelist as $raw){
                              ?>
                              <option  value="<?=$raw->resale_code?>"><?=$raw->project_name?> - <?=$raw->lot_number?> <?=$raw->first_name?>  <?=$raw->last_name?></option>
                                <? }}?>
                               
                        </select>
                      
                      </div><div class="form-group col-md-6" id="refunddetails" ></div>
                      <br /> <br /> <br />