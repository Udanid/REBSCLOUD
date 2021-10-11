
<script type="text/javascript">

    $(document).ready(function() {

        $('#CHQBID').change(function () {
            
            var id = this.value;
            //seachlocator
			if(id!=="")
            $('#seachlocator').load("<?php echo base_url()?>accounts/cheque/blank_list/"+id);
            //alert("<?php //echo base_url()?>accounts/cheque/blank_list/"+id);
            
        });
    });
    
</script>

<form data-toggle="validator"  method="post"  action="<?=base_url()?>accounts/cheque/process_cancel" name="SEARCHFRM" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">
                    <div class="form-group" style="width: 25%;">Bundle No<br/>
                        <select name="CHQBID" id="CHQBID" class="form-control" style="width: 100%;">
                            <option value="">Select Bundle No</option>
                            <? 
                            if($rcptbooks){
                                foreach ($rcptbooks as $raw){
									if($raw->CHQBSTATUS=='START'){
                                   ?>
                                        <option value="<?=$raw->CHQBID?>" ><?=$raw->CHQBNO?> <?=$raw->CHQBSNO?>- <?=$raw->CHQBNNO?> </option>
                                    <? }}}?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="row">
    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
        <div id="seachlocator">
        </div>
       

    </div>
</div>
</form>

  