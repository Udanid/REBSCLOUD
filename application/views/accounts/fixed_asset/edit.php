<h4>Asset:  <?=$details->asset_name?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/Fixedasset/edit_asset" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
          <div class="form-title">
            <h5>Asset Details:</h5>
          </div>
          <div class="form-body">
            <div class="form-group has-feedback"  id="branch">
              <label >Select Branch</label >
              <select name="branch_code" id="branch_code" class="form-control" placeholder="Branch" required>
                <option value="">--Select Branch--</option>

                <?
                foreach ($branches as $key => $value) {?>
                  <option value="<?=$value->branch_code?>" <? if($details->branch==$value->branch_code){?> selected="selected"<? }?>><?=$value->branch_code?>-<?=$value->branch_name?></option>
                  <?
                }
                ?>

              </select>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <span class="help-block with-errors" ></span>
            </div>
            <div class="form-group has-feedback"  id="division">
              <label >Select Division</label >
              <select name="division_code" id="division_code" class="form-control" placeholder="Division" required>
                <option value="">--Select Division--</option>

                <?
                foreach ($division as $key => $value) {?>
                  <option value="<?=$value->id?>"<? if($details->division==$value->id){?> selected="selected"<? }?>><?=$value->division_name?></option>
                  <?
                }
                ?>

              </select>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <span class="help-block with-errors" ></span>
            </div>
            <div class="form-group"  id="asset_type">
              <label >Asset Category</label >
                <input type="hidden" name="asset_id" id="asset_id" value="<?=$details->id?>">
                <select name="asset_cat" id="asset_cat" class="form-control" placeholder="Asset Type" >
                  <option value="">--Select Asset Category--</option>

                  <?
                  foreach ($categories as $key => $value) {?>
                    <option value="<?=$value->id?>" <? if($category_name->id==$value->id){?> selected="selected"<? }?>><?=$value->asset_category?></option>
                    <?
                  }
                  ?>

                </select>
              </div>
              <div class="form-group has-feedback">
                <label >Asset code</label >
                  <input type="text" class="form-control" name="asset_code" id="asset_code" placeholder="Asset Name" value="<?=$details->asset_code?>">
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <span class="help-block with-errors" ></span>
                </div>
                <div class="form-group has-feedback">
                  <label >Asset Name</label >
                    <input type="text" class="form-control" name="asset_name" id="asset_name" placeholder="Asset Name" value="<?=$details->asset_name?>">
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <span class="help-block with-errors" ></span>
                  </div>
                  <div class="form-group has-feedback">
                    <label >Brand</label >
                      <input type="text" class="form-control" name="asset_brand" id="asset_brand" placeholder="Brand" value="<?=$details->brand?>">
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                    <div class="form-group has-feedback">
                      <label >Serial Number</label >
                        <input type="text" class="form-control" name="serial_no" id="serial_no" placeholder="Serial No" value="<?=$details->serial_no?>">
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block with-errors" ></span>
                      </div>
                  <div class="form-group has-feedback">
                    <label >Asset Value</label >
                      <input type="text" class="form-control" name="asset_val" id="asset_val" placeholder="Asset Value" value="<?=$details->asset_value?>">
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>

                    <div class="form-group">
                      <label >Year</label >
                        <input type="date" class="form-control" name="year" id="year" placeholder="Year" value="<?=date('Y-m-d',strtotime($details->year));?>">
                      </div>
                      <!--
                      <div class="form-group">
                      <input type="text" class="form-control" name="quantity" id="quantity" placeholder="Quantity" data-error="">
                    </div>
                  -->
                  <div class="form-group has-feedback"  id="user">
                    <label >Select User</label >
                    <select name="user_code" id="user_code" class="form-control" placeholder="User" required>
                      <option value="">--Select User--</option>

                      <?
                      foreach ($employees as $key => $value) {?>
                        <option value="<?=$value->id?>" <? if($details->user==$value->id){?> selected="selected"<? }?>><?=$value->initial?> <?=$value->surname?></option>
                        <?
                      }
                      ?>

                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <span class="help-block with-errors" ></span>
                  </div>
                  <div class="form-group has-feedback"  id="asset_type">
                    <select name="purchase" id="purchase" class="form-control" placeholder="Purchase Type" required>
                      <option value="">--Select Purchase Method--</option>
                      <option value="Credit" <? if($details->	purchase_by=="Credit"){?> selected="selected"<? }?>>Purchase By Credit</option>
                      <option value="Cash" <? if($details->	purchase_by=="Cash"){?> selected="selected"<? }?>>Purchase by Cash</option>
                      <option value="Lease" <? if($details->	purchase_by=="Lease"){?> selected="selected"<? }?>>Purchase by Lease</option>

                    </select>
                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <span class="help-block with-errors" ></span>
                  </div>
                  <div class="form-group">
                    <label >Remarks</label >
                      <textarea class="form-control" name="remarks" id="remarks" placeholder="Remarks" value="<?=$details->remarks?>"><?=$details->remarks?></textarea>
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
              <div class="clearfix"> </div>
              <br>

            </form>
          </div>
          <br /><br /><br /><br /></div>
