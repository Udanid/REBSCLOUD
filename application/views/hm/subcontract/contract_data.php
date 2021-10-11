<script type="text/javascript">
jQuery(document).ready(function() {
	setTimeout(function(){
	  	$("#service_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Services"
    	});


	 	$.ajaxSetup ({
    	// Disable caching of AJAX responses
    		cache: false
		});
	}, 800);
});
</script>
 <h4>Sub Contract Task Category<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$contractdata_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
 <div class="table widget-shadow">
   <div class="row">
     <table class="table">
       <tr>
         <th>
           Task Category
         </th>
         <th>
           Task
         </th>
         <th>
           Agreed Amount
         </th>
       </tr>
       <? if($task_data){
         foreach ($task_data as $key => $value) { ?>
           <tr>
             <td>
               <?=$value->subcat_code?> - <?=$value->subcat_name?>
             </td>
             <td>
               <?=$value->description?>
             </td>
             <td align="right">
               <?=number_format($value->agreed_amount,2)?>
             </td>
           </tr>
      <?   }
       }?>

     </table>
   </div>
 </div>
