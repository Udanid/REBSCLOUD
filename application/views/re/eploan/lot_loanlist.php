
<script type="text/javascript">

jQuery(document).ready(function() {


	setTimeout(function(){
	  $("#loan_code").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Loan Code"
    	});
	}, 500);



});
</script>
                                    <select class="form-control" placeholder="Qick Search.." onchange="loan_fulldata(this.value)" id="loan_code" name="loan_code" >
                    <option value=""></option>
                    <?  if($loanlist){  foreach($loanlist as $row){
						if($row->loan_status=='CONFIRMED'){?>
                    <? $loanarr=$row->unique_code?>
                    <option value="<?=$row->loan_code?>">
					<?=$row->unique_code?> <?=$row->first_name?>&nbsp;<?=$row->last_name?> - <?=$row->id_number?></option>
                    <? } }}?>

					</select>
