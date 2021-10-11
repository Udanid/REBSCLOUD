  <?
  $leger_id='0';$leger_name='';$depre_acc_id='0';$depre_acc_name='';$provi_acc_id='0';$provi_acc_name='';$dispo_acc_id='0';$dispo_acc_name='';
  if($details->leger_acc){
  $leger_id=$leger_acc[$details->leger_acc]->id;
  $leger_name=$leger_acc[$details->leger_acc]->name;
  }
  if($details->depreciation_acc){
  $depre_acc_id=$depre_acc[$details->depreciation_acc]->id;
  $depre_acc_name=$depre_acc[$details->depreciation_acc]->name;
  }
  if($details->provision_acc){
  $provi_acc_id=$provi_acc[$details->provision_acc]->id;
  $provi_acc_name=$provi_acc[$details->provision_acc]->name;
  }
  if($details->disposal_acc){
  $dispo_acc_id=$dispo_acc[$details->disposal_acc]->id;
  $dispo_acc_name=$dispo_acc[$details->disposal_acc]->name;
  }

  ?>
  <h4>Asset Category:  <?=$details->asset_category?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
  <div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/Fixedasset/update_category" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
          <div class="form-title">
            <h5>Category Details</h5>
          </div>
          <div class="form-body">
            <div class="form-group"  id="asset_type">
              <input type="hidden" id="asset_cat_id" name="asset_cat_id" value="<?=$details->id;?>">
              <label >Asset Type</label >
              <select name="asset_type" id="asset_type" class="form-control" placeholder="Asset Type" >
                <option value="">--Select Asset Type--</option>
                <option value="0" <? if($details->intangible_flag==0){?> selected="selected"<? }?>>Fixed Asset</option>
                <option value="1"<? if($details->intangible_flag==1){?> selected="selected"<? }?>>Intangible Asset</option>


              </select>
            </div>
            <div class="form-group has-feedback">
              <label >Asset category name</label >
              <input type="text" class="form-control" name="asset_cat_name" id="asset_cat_name" placeholder="Asset category name" value="<?=$details->asset_category;?>" required>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <span class="help-block with-errors" ></span>
            </div>
            <div class="form-group">
              <label >Asset depreciation presantage</label >
              <input type="number" class="form-control" name="dep_presantage" id="dep_presantage" placeholder="Asset depreciation presantage" value="<?=$details->depreciation_presantage;?>">
            </div>
            </div>
          </div>
          <div class="col-md-6 validation-grids validation-grids-right">
            <div class="widget-shadow" data-example-id="basic-forms">
              <div class="form-title">
                <h5>Account Details:</h5>
              </div>
              <div class="form-body">


                <div class="form-group">
                  <label >Leger Account</label >
                  <select name="leger_acc" id="leger_acc" class="form-control" placeholder="Leger Account" >
                    <option value="">-- Leger Account --</option>
                    <?
                    foreach ($legers as $key => $value) {?>
                      <option value="<?=$value->id?>" <? if($leger_id==$value->id){?> selected="selected"<? }?>><?=$value->id?>-<?=$value->name?></option>
                      <?
                    }
                    ?>

                  </select>
                </div>
                <div class="form-group">
                  <label >Depreciation Account</label >
                  <select name="depre_acc" id="depre_acc" class="form-control" placeholder="Depreciation Account" >
                    <option value="">--Depreciation Account--</option>
                    <?
                    foreach ($legers as $key => $value) {?>
                      <option value="<?=$value->id?>" <? if($depre_acc_id==$value->id){?> selected="selected"<? }?>><?=$value->id?>-<?=$value->name?></option>
                      <?
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label >Provision Account</label >
                  <select name="provi_acc" id="provi_acc" class="form-control" placeholder="Provision Account" >
                    <option value="">--Provision Account--</option>
                    <?
                    foreach ($legers as $key => $value) {?>
                      <option value="<?=$value->id?>" <? if($provi_acc_id==$value->id){?> selected="selected"<? }?>><?=$value->id?>-<?=$value->name?></option>
                      <?
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label >Disposal Account</label >
                  <select name="dispo_acc" id="dispo_acc" class="form-control" placeholder="Disposal Account" >
                    <option value="">--Disposal Account--</option>
                    <?
                    foreach ($legers as $key => $value) {?>
                      <option value="<?=$value->id?>" <? if($dispo_acc_id==$value->id){?> selected="selected"<? }?>><?=$value->id?>-<?=$value->name?></option>
                      <?
                    }
                    ?>
                  </select>
                </div>
                <div class="bottom validation-grids">

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  <div class="clearfix"> </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"> </div>
        <br>

      </form>
  </div>
  <br /><br /><br /><br /></div>
