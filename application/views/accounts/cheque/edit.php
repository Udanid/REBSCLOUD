
<h4>Receipt Bundle <?=$details->CHQBNO?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->CHQBID?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
    <div class="row">
        <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cheque/editdata">
            <div class="col-md-12 validation-grids widget-shadow" style="width: 100%;" data-example-id="basic-forms">
                <div class="form-body">
                    <div class="col-md-6">
                        <div class="form-group">Bank Account
                            <input type="hidden"  value="<?=$details->CHQBID?>"name="CHQBID" id="CHQBID"  />
                            <select class="form-control" placeholder="Ledger Account"  id="ledger_id" name="ledger_id"   required >
                                    <? if($ledgerlist){?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($rw->id==$details->ledger_id){?> selected="selected"<? }?>><?=$rw->gname?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }}?>
              
					
					</select></div>
                        <div class="form-group">Last No
                            <input type="text" class="form-control" readonly="readonly" style="width: 100%;" id="CHQBNNO" name="CHQBNNO" value="<? echo $details->CHQBNNO;?>" placeholder="">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">First No
                            <input type="text" class="form-control" readonly="readonly" style="width: 100%;" id="CHQBSNO" name="CHQBSNO" value="<? echo $details->CHQBSNO;?>" placeholder="">
                        </div>
                        <div class="form-group">Apply Month
                            <select name="CHQBSTATUS" id="CHQBSTATUS" class="form-control" style="width: 100%;" >
                                <option value="QUEUE" <? if($details->CHQBSTATUS=="QUEUE"){?> selected="selected"<? }?>>QUEUE</option>
                                <option value="START" <? if($details->CHQBSTATUS=="START"){?> selected="selected"<? }?>>START</option>
                                <option value="FINISH" <? if($details->CHQBSTATUS=="FINISH"){?> selected="selected"<? }?>>FINISH</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bottom">

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary ">Update</button>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                    </div>
                    <div class="clearfix"> </div><br>
                </div>
            </div>
        </form>
    </div>
</div>