<div class="form-group " ><label class="col-sm-3 control-label">Supplier Name</label>
    <div class="col-sm-3 has-feedback">
        <select class="form-control" name="suppliername" id="suppliername" onchange="load_supplier_data(this)">
            <option value="">Select Type</option>
            <? if($suplier){foreach($suplier as $raw){?>
                <option value="<?=$raw->id?>" <? if($supid==$raw->id){?> selected="selected" <? }?>><?=$raw->name?></option>
            <? }}?>
        </select>
    </div>
</div>
