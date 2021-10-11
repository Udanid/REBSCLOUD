
<script type="text/javascript">
jQuery(document).ready(function() {
  

	$("#branch<?=$counter?>").chosen({
     allow_single_deselect : true
    });
 
 
	
});</script>
                                    <select class="form-control" placeholder="Document Category"  id="branch<?=$counter?>" name="branch<?=$counter?>"   required >
                    <option value="">Branch List</option>
                    <? foreach ($branclist as $raw){?>
                    <option value="<?=$raw->BRANCHNAME?>" ><?=$raw->BRANCHNAME?></option>
                    <? }?>
              
					
					</select> 
									