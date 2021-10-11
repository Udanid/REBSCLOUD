
<script type="text/javascript">

function load_printscrean1(id,prjid)
{
			window.open( "<?=base_url()?>re/lotdata/print_inquary/"+id+"/"+prjid );
	
}
function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );
			
}
function get_charge_details(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>re/reservation/get_chargerfulldata/"+id );
			
}

</script>
<h4>Followup Details 
       <span style="float:right"> <a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a>
</span></h4>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
 
  
  
        
          
         <? if($followlist){?>
           <table class="table">
       <tr>
     <th colspan="4" class="info">Followup Details</th></tr>
     <tr><td colspan="4" height="10"></td></tr>
          <tbody style="font-size:12px">
   <tr class="active"><th>Date</th><th>Action</th><th>Customer Feedback</th><th>Agreement Code</th><th>Arrears</th><th>Sales Person</th></tr>
     <? foreach($followlist as $raw){?>
     <tr>
     <td><?=$raw->follow_date ?></td>
      <td><?=$raw->sales_feedback  ?></td>
       <td><?=$raw->cus_feedback  ?></td>
       <td><?=$raw->loan_code  ?></td>
         <td><?=$raw->todate_arreas  ?></td>
          <td><?=$raw->initial  ?> <?=$raw->surname  ?></td>
     </tr>
     
         <? }?>
         
         </tbody></table>
         <?
		 
		 
		 }?>
       

    </div> 
</div>