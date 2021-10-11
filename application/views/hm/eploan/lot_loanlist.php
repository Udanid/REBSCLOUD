
<script type="text/javascript">

jQuery(document).ready(function() {
  

	 $("#loan_code").focus(function() {
	  $("#loan_code").chosen({
     allow_single_deselect : true
    });
	});
 
 
	
});
</script>
                                    <select class="form-control" placeholder="Qick Search.." onchange="loan_fulldata(this.value)" id="loan_code" name="loan_code" >
                    <option value="">Loan Code</option>
                    <?  if($loanlist){  foreach($loanlist as $row){
						if($row->loan_status=='CONFIRMED'){?>
                    <? $loanarr=$row->unique_code?>
                    <option value="<?=$row->loan_code?>">
					<?=$row->unique_code?> <?=$row->first_name?>&nbsp;<?=$row->last_name?></option>
                    <? } }}?>
             
					</select> 
									