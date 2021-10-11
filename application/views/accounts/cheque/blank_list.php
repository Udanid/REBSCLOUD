<div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
    <div class="form-body">
        <div class="col-md-6">
            <div class="form-inline">
                <div class="form-group">From
                    <input type="text" readonly="readonly" name="CHQBSNO" id="CHQBSNO" value="<?=$minval?>" class="form-control longtext validate[required,custom[onlyNumberSp],max[<?=$maxval?>],min[<?=$minval?>]] text-input"  />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-inline">
                <div class="form-group">To
                    <input type="number" name="CHQBNNO" id="CHQBNNO" value="<?=$minval?>" class="form-control longtext validate[required,custom[onlyNumberSp],max[<?=$maxval?>],min[<?=$minval?>]] text-input"/>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div><br/>
        <div class="col-md-6" style="width: 50%;">
                <div class="form-group">Reason
                    <textarea class="form-control" name="reason" id="reason" required="required" style="width: 100%;"></textarea>
                </div>
        </div>
        <div class="clearfix"> </div>
        <div class="col-md-2" align="right">
            <div class="form-group">
                <button type="submit"  id="create" class="btn btn-primary " style="margin-left: 5px; width: 200px;margin-top: 30px;">Cancel Cheque</button>
            </div>
        </div>
    </div>
</div>

