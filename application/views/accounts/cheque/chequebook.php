<script type="text/javascript">
    function delete_chequebook(id){
        var r=confirm("Are you sure you want to delete this Cheque Book?")
        if (r==true){
            $.ajax({
                cache: false,
                type: 'POST',
                url: '<?php echo base_url().'accounts/cheque/delete';?>',
                data: {id: id },
                success: function(data) {
                    if (data){
                        location.reload();
                    }else{
                        alert("delete failed");
                    }
                }
            });
        }
    }

    function check_activeflag(id){
        $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_chequebookdata', id: id,fieldname:'CHQBID' },
            success: function(data) {
                if (data){
                    document.getElementById("checkflagmessage").innerHTML=data;
                    $('#mylistkkk').click();
                }else{
                    $('#popupform').delay(1).fadeIn(600);
                    $( "#popupform" ).load( "<?=base_url()?>accounts/cheque/edit/"+id );
                }
            }
        });
    }

    function close_edit(id){
        $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'ac_chequebookdata', id: id,fieldname:'CHQBID' },
            success: function(data) {
                if (data){
                    $('#popupform').delay(1).fadeOut(800);
                }else{
                    document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin ';
                    $('#mylistkkk').click();
                }
            }
        });
    }


    // Added By Kalum 2020.02.06 Ticket No 1140

   function pause_bundle(CHQBID){
        var ledger_id= document.getElementById('pause_ledger_id'+CHQBID).value;

        var dataString = 'CHQBID='+CHQBID+'&ledger_id='+ledger_id;
		window.location="<?=base_url()?>accounts/cheque/pause_bundle/"+CHQBID+"/"+ledger_id;
       
    }

    function start_bundle(CHQBID){
        var ledger_id= document.getElementById('strat_ledger_id'+CHQBID).value;

        var dataString = 'CHQBID='+CHQBID+'&ledger_id='+ledger_id;
		window.location="<?=base_url()?>accounts/cheque/start_bundle/"+CHQBID+"/"+ledger_id;
       
    }

    // End Ticket 1140
</script>

<form data-toggle="validator"  method="post"  action="<?=base_url()?>accounts/cheque/add" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">
                    <div class="form-group" style="width: 30%;">Bundle No<br>
                        <input type="text" class="form-control" style="width: 100%;" id="CHQBNO" name="CHQBNO" required value="<? //echo $refnumber;?>" placeholder="">
                    </div>

                    <div class="form-group" style="width: 50%;">Bank Account<br>
                       <select class="form-control" placeholder="Ledger Account"  id="ledger_id" name="ledger_id"   required >
                            <? if($ledgerlist){?>
                                <option value=""></option><? ?>
                                <? foreach ($ledgerlist as $rw){?>
                                <option value="<?=$rw->id?>"><?=$rw->gname?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                            <? }}?>					
					   </select> 
                    </div><br>
                    
                    <div class="form-group" style="width: 30%;">First No<br>
                        <input type="number" class="form-control" style="width: 100%;" id="CHQBSNO" name="CHQBSNO" required value="<? //echo $refnumber;?>" placeholder="">
                    </div>

                    <div class="form-group" style="width: 30%;">Last No<br>
                        <input type="number" class="form-control" style="width: 100%;" id="CHQBNNO" name="CHQBNNO" required value="<? //echo $refnumber;?>" placeholder="">
                        <input type="hidden"  name="CHQBSTATUS" id="CHQBSTATUS"  value="QUEUE" />
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
                    <th>Bundle No</th>
                    <th>Bank Account</th>
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
                <th scope="row"><?=$row->CHQBNO?></th>
                <th scope="row"><?=$row->name?></th>
                <td ><?=$row->CHQBSNO ?></td>
                <td> <?=$row->CHQBNNO ?></td>
                <td> <?=$row->CHQBSTATUS ?></td>

                <?php if($row->CHQBSTATUS=="START"){ ?>
                    <td>
                        <a href="javascript:pause_bundle('<? echo $row->CHQBID; ?>')" title="Pause"><i class="fa fa-pause nav_icon icon_blue"></i></a> 
                        <input type="hidden" name="ledger_id" id="pause_ledger_id<?=$row->CHQBID ?>" value="<?= $row->ledger_id; ?>">                   
                    </td>
                <?php } ?>

                <?php if($row->CHQBSTATUS=="PAUSE"){ ?>
                    <td>
                        <a href="javascript:start_bundle('<? echo $row->CHQBID; ?>')" title="Start"><i class="fa fa-play nav_icon icon_blue"></i></a> 
                        <input type="hidden" name="ledger_id" id="strat_ledger_id<?=$row->CHQBID ?>" value="<?= $row->ledger_id; ?>">                   
                    </td>
                <?php } ?>

                <?php if($row->CHQBSTATUS=="QUEUE"){ ?>
                    <td>
                        <a href="javascript:check_activeflag('<? echo $row->CHQBID; ?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                        <a  href="javascript:call_delete('<?=$row->CHQBID?>')" title="Delete"><i class="fa fa-trash-o nav_icon icon_blue"></i></a>
                    </td>
                <?php } ?>
            </tr>
            <? }} ?>
            </tbody>
        </table>
    </div>
</div>

  