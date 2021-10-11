
<script type="text/javascript">

    $(document).ready(function() {

        $("#empsearch").chosen({
            allow_single_deselect : true
        });

    });


    
    function check_activeflag(id)
    {
        $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_recieptbookdata', id: id,fieldname:'RCTBID' },
            success: function(data) {
                if (data) {
                    // alert(data);
                    document.getElementById("checkflagmessage").innerHTML=data;
                    $('#flagchertbtn').click();

                    //document.getElementById('mylistkkk').style.display='block';
                }
                else
                {
                    $('#popupform').delay(1).fadeIn(600);
                    $( "#popupform" ).load( "<?=base_url()?>accounts/receipt/edit/"+id );
                }
            }
        });
    }

    function close_edit(id)
    {
        $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'ac_recieptbookdata', id: id,fieldname:'RCTBID' },
            success: function(data) {
                if (data) {
                    $('#popupform').delay(1).fadeOut(800);

                    //document.getElementById('mylistkkk').style.display='block';
                }
                else
                {
                    document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin ';
                    $('#flagchertbtn').click();

                }
            }
        });
    }

</script>
<form data-toggle="validator"  method="post"  action="<?=base_url()?>accounts/receipt/add" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">
                  <div class="form-group" style="width: 20%;">
                                       Branch<br/>
                                         <select class="form-control" placeholder="Qick Search.."  <? if(! check_access('all_branch')){?> disabled <? }?>  id="branch_code" name="branch_code" >
                    <option value="">Search here..</option>
                    <? if($branchlist) {  foreach($branchlist as $row){?>
                    <option value="<?=$row->branch_code?>" <? if($row->branch_code==$this->session->userdata('branchid')){?> selected<? }?>><?=$row->branch_name?></option>
                    <? }}?> 
					</select> 
										
									</div>
                    <div class="form-group" style="width: 20%;">Bundle No<br/>
                        <input type="text" class="form-control" style="width: 100%;" id="RCTBNO" name="RCTBNO" required value="<? //echo $refnumber;?>" placeholder="">
                    </div>
                    <div class="form-group" style="width: 25%;">First No<br/>
                        <input type="number" class="form-control" style="width: 100%;" id="RCTBSNO" name="RCTBSNO" required value="<? //echo $refnumber;?>" placeholder="">
                    </div>
                    <div class="form-group" style="width: 25%;">Last No<br/>
                        <input type="number" class="form-control" style="width: 100%;" id="RCTBNNO" name="RCTBNNO" required value="<? //echo $refnumber;?>" placeholder="">
                        <input type="hidden"  name="RCTSTATUS" id="RCTSTATUS"  value="QUEUE" />
                    </div>
                    <div class="form-group">
                        <button type="submit"  id="create" class="btn btn-primary " style="margin-left: 5px;">Create</button>
                        <?//=form_submit('submit', 'Create');?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
        <table class="table">
            <thead>
            <tr>
            <th>Branch Code</th>
                <th>Bundle No</th>
                <th>First No</th>
                <th>Last No</th>
                <th>Status</th>
                <th colspan="3"></th>
            </tr>
            </thead>
            <?php

            if ($rcptbooks){
            $c=0;
            foreach($rcptbooks as $row){
            ?>
            <tbody>
                <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                  <th scope="row"><?=$row->branch_code?></th>
                    <th scope="row"><?=$row->RCTBNO?></th>
                    <td ><?=$row->RCTBSNO ?></td>
                    <td> <?=$row->RCTBNNO ?></td>
                    <td> <?=$row->RCTSTATUS ?></td>

                    <?php
                    if($row->RCTSTATUS!="START") {
                        ?>
                        <td>
<!--                            <a href="javascript:check_receiptbook('--><?// echo $row->RCTBID; ?><!--')"><i-->
<!--                                            class="fa fa-edit nav_icon icon_blue"></i></a>-->
                            <a href="javascript:check_activeflag('<? echo $row->RCTBID; ?>')"><i
                                    class="fa fa-edit nav_icon icon_blue"></i></a>

                            <a  href="javascript:call_delete('<?=$row->RCTBID?>')" title="Delete"><i class="fa fa-trash-o nav_icon icon_blue"></i></a>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
                <td>
                <?
                }}
                ?>
            </tbody>
        </table>
    </div>
</div>

  