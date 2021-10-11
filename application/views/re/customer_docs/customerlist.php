
<script type="text/javascript">

jQuery(document).ready(function() {


	$("#cus_id").chosen({
     allow_single_deselect : true
    });



});
</script>
  <select class="form-control" placeholder="Customer"  id="cus_id" name="cus_id" onchange="load_fulldetails(this.value)"   required >
                    <option value="">Customer</option>
                    <? if($cuslist){foreach ($cuslist as $raw){?>

                    <option value="<?=$raw->res_code?>" ><?=$raw->first_name?> - <?=$raw->last_name?></option>
									<? }}?>


					</select>
