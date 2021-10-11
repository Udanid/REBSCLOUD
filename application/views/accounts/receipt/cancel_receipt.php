
<script type="text/javascript">

    $(document).ready(function() {

        $('#RCTBID').change(function () {

            var id = this.value;

            $('#seachlocator').load("<?php echo base_url()?>accounts/receipt/blank_list/"+id);
            
        });
    });

</script>

<form data-toggle="validator"  method="post"  action="<?=base_url()?>accounts/receipt/process_cancel" name="SEARCHFRM" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">
                    <div class="form-group" style="width: 25%;">Bundle No<br/>
                        <select name="RCTBID" id="RCTBID" class="form-control" style="width: 100%;" ">
                        <option value="">Select Bundle No</option>
                        <?
                        if($rcptbooks){
                            foreach ($rcptbooks as $raw){
                                ?>
                                <option value="<?=$raw->RCTBID?>" ><?=$raw->RCTBNO?> <?=$raw->RCTBSNO?>- <?=$raw->RCTBNNO?></option>
                            <? }}?>
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

