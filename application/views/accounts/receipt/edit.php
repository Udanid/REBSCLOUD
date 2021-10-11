
<h4>Receipt Bundle <?=$details->RCTBNO?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->RCTBID?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
    <div class="row">
        <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/receipt/editdata">
            <div class="col-md-12 validation-grids widget-shadow" style="width: 100%;" data-example-id="basic-forms">
                <div class="form-body">
                    <div class="col-md-6">
                        <div class="form-group">Bundle No
                            <input type="hidden"  value="<?=$details->RCTBID?>"name="RCTBID" id="RCTBID"  />
                            <input type="text" readonly="readonly" class="form-control" value="<?=$details->RCTBNO?>" name="RCTBNO" id="RCTBNO"  required/>
                        </div>
                        <div class="form-group">Last No
                            <input type="text" class="form-control" readonly="readonly" style="width: 100%;" id="RCTBNNO" name="RCTBNNO" value="<? echo $details->RCTBNNO;?>" placeholder="">
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">First No
                            <input type="text" class="form-control" readonly="readonly" style="width: 100%;" id="RCTBSNO" name="RCTBSNO" value="<? echo $details->RCTBSNO;?>" placeholder="">
                        </div>
                        <div class="form-group">Apply Month
                            <select name="RCTSTATUS" id="RCTSTATUS" class="form-control" style="width: 100%;" >
                                    <option value="QUEUE" <? if($details->RCTSTATUS=="QUEUE"){?> selected="selected"<? }?>>QUEUE</option>
                                    <option value="START" <? if($details->RCTSTATUS=="START"){?> selected="selected"<? }?>>START</option>
                                    <option value="FINISH" <? if($details->RCTSTATUS=="FINISH"){?> selected="selected"<? }?>>FINISH</option>
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