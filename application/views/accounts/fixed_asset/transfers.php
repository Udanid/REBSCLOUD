<!DOCTYPE HTML>
<html>
<head>

  <?
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
  $this->load->view("includes/topbar_normal");
  ?>
  <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script>
function call_delete(id)
{
  document.deletekeyform.deletekey.value=id;
  $.ajax({
    cache: false,
    type: 'GET',
    url: '<?php echo base_url().'common/activeflag_cheker/';?>',
    data: {table: 'ac_fixedassets', id: id,fieldname:'id' },
    success: function(data) {
      if (data) {
        // alert(data);
        document.getElementById("checkflagmessage").innerHTML=data;
        $('#flagchertbtn').click();

        //document.getElementById('mylistkkk').style.display='block';
      }
      else
      {
        $('#complexConfirm').click();
      }
    }
  });

}
function call_delete2(id)
{
  document.deletekeyform.deletekey.value=id;
  $('#complexConfirm2').click();


}
function call_confirm2(id)
{
  document.deletekeyform.deletekey.value=id;
  $('#complexConfirm_confirm2').click();

}
function call_confirm(id)
{
  document.deletekeyform.deletekey.value=id;
  $.ajax({
    cache: false,
    type: 'GET',
    url: '<?php echo base_url().'common/activeflag_cheker/';?>',
    data: {table: 'ac_fixedassets', id: id,fieldname:'id' },
    success: function(data) {
      if (data) {
        // alert(data);
        document.getElementById("checkflagmessage").innerHTML=data;
        $('#flagchertbtn').click();

        //document.getElementById('mylistkkk').style.display='block';
      }
      else
      {
        $('#complexConfirm_confirm').click();
      }
    }
  });
}
</script>
  <!-- //header-ends -->
  <!-- main content start-->
  <div id="page-wrapper">
    <div class="main-page">

      <div class="table">



        <h3 class="title1">Fixed Assets Transfers</h3>

        <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">

            <? if(check_access('fixed_asset')){?> <li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Asset Transfers</a></li>
          <? }?>
          <? if(check_access('fixed_asset')){?> <li role="presentation"><a href="#transfers" role="tab" id="transfers-tab" data-toggle="tab" aria-controls="transfers" aria-expanded="false">Transfer list</a></li>
        <? }?>
      </ul>
      <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
        <div role="tabpanel" class="tab-pane fade" id="transfers" aria-labelledby="transfers-tab">
          <h4>Catogory Transfers</h4>
        <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

          <table class="table"> <thead> <tr> <th>Asset Code</th><th>Asset Name</th> <th>Exist Asset Category</th><th>Exist Sub Asset Category</th><th>Asset Category Tranfer To</th><th>Sub Asset Category Tranfer To</th> <th>Status</th><th></th></tr> </thead>
            <tbody>
              <? foreach ($transfers as $key => $value) {?>
                <tr> <th><?=$asset_name[$value->asset_id]->asset_code;?></th>
                  <th><?=$asset_name[$value->asset_id]->asset_name;?></th> <th>
                    <?
                    if($value->old_category_id!=""){echo $category_name_old[$value->old_category_id]->asset_category;}
                    ?>
                  </th>

                  <th>
                    <?
                    if($value->old_subcategory_id!=""){echo $Subcategory_name_old[$value->old_subcategory_id]->sub_cat_name;}
                    ?>
                  </th>
                  <th>
                    <?
                    if($value->transferto_category_id!=""){echo $category_name_new[$value->transferto_category_id]->asset_category;}
                    ?>
                  </th>

                  <th>
                    <?
                    if($value->transferto_subcategory_id!=""){echo $Subcategory_name_new[$value->transferto_subcategory_id]->sub_cat_name;}
                    ?>
                  </th>
                  <th>
                  <?
                  if($value->statues=="PENDING"){?>
                    <a  href="javascript:call_delete('<?=$value->tranfer_id;?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? $CI =& get_instance();
                    $user_role = $CI->session->userdata('usertype');
                   if (  check_access('confirm_fixed_asset_transfers')) {?>
                    <a  href="javascript:call_confirm('<?=$value->tranfer_id;?>')" title="Confirm"><i class="fa fa-check nav_icon icon_blue"></i></a>
                    <?}}else if($value->statues=="CONFIRM"){
                      ?>
                      CONFIRMED
                      <?}?>
                    </th>

                  </tr>
                <? }?>
              </tbody></table>
              <div id="pagination-container"></div>
            </div>
            <h4>Branch Transfers</h4>
            <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

              <table class="table"> <thead> <tr> <th>Asset Code</th><th>Asset Name</th> <th>Exist Branch</th><th>Asset Branch Tranfer To</th><th>Status</th><th></th></tr> </thead>
                <tbody>
                  <? foreach ($transfer_other as $key => $value) {
                    $type=$value->tranfer_category;
                    if($type=="Branch"){
                    ?>
                    <tr> <th><?=$asset_name[$value->asset_id]->asset_code;?></th>
                      <th><?=$asset_name[$value->asset_id]->asset_name;?></th>
                      <th>
                        <?
                        echo $value->old_value.' - ';
                        if($value->old_value!=""){echo $oldval[$value->old_value]->branch_name;}
                        ?>
                      </th>

                      <th>
                        <?
                        echo $value->new_value.' - ';
                        if($value->new_value!=""){echo $newval[$value->new_value]->branch_name;}
                        ?>
                      </th>

                      <th>
                      <?
                      if($value->statues=="PENDING"){?>
                        <a  href="javascript:call_delete2('<?=$value->tranfer_id;?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                        <? $CI =& get_instance();
                        $user_role = $CI->session->userdata('usertype');
                       if (  check_access('confirm_fixed_asset_transfers')) {?>
                        <a  href="javascript:call_confirm2('<?=$value->tranfer_id;?>')" title="Confirm"><i class="fa fa-check nav_icon icon_blue"></i></a>
                        <?}}else if($value->statues=="CONFIRM"){
                          ?>
                          CONFIRMED
                          <?}?>
                        </th>

                      </tr>
                    <? }}?>
                  </tbody></table>
                  <div id="pagination-container"></div>
                </div>
                <h4>Division Transfers</h4>
                <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                  <table class="table"> <thead> <tr> <th>Asset Code</th><th>Asset Name</th> <th>Exist Division</th><th>Asset Division Tranfer To</th><th>Status</th><th></th></tr> </thead>
                    <tbody>
                      <? foreach ($transfer_other as $key => $value) {
                        $type=$value->tranfer_category;
                        if($type=="Division"){
                        ?>
                        <tr> <th><?=$asset_name[$value->asset_id]->asset_code;?></th>
                          <th><?=$asset_name[$value->asset_id]->asset_name;?></th>
                          <th>
                            <?
                            if($value->old_value!=""){echo $oldval[$value->old_value]->division_name;}
                            ?>
                          </th>

                          <th>
                            <?
                            if($value->new_value!=""){echo $newval[$value->new_value]->division_name;}
                            ?>
                          </th>

                          <th>
                          <?
                          if($value->statues=="PENDING"){?>
                            <a  href="javascript:call_delete2('<?=$value->tranfer_id;?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                            <? $CI =& get_instance();
                            $user_role = $CI->session->userdata('usertype');
                            if (  check_access('confirm_fixed_asset_transfers')) {?>
                            <a  href="javascript:call_confirm2('<?=$value->tranfer_id;?>')" title="Confirm"><i class="fa fa-check nav_icon icon_blue"></i></a>
                            <?}}else if($value->statues=="CONFIRM"){
                              ?>
                              CONFIRMED
                              <?}?>
                            </th>

                          </tr>
                        <? } }?>
                      </tbody></table>
                      <div id="pagination-container"></div>
                    </div>
                    <h4>User Transfers</h4>
                    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                      <table class="table"> <thead> <tr> <th>Asset Code</th><th>Asset Name</th> <th>Exist User</th><th>Asset User Tranfer To</th><th>Status</th><th></th></tr> </thead>
                        <tbody>
                          <? foreach ($transfer_other as $key => $value) {
                            $type=$value->tranfer_category;
                            if($type=="User"){
                            ?>
                            <tr> <th><?=$asset_name[$value->asset_id]->asset_code;?></th>
                              <th><?=$asset_name[$value->asset_id]->asset_name;?></th>
                              <th>
                                <?
                                if($value->old_value!=""){echo $oldval[$value->old_value]->initial;echo $oldval[$value->old_value]->surname;}
                                ?>
                              </th>

                              <th>
                                <?
                                if($value->new_value!=""){echo $newval[$value->new_value]->initial;echo $newval[$value->new_value]->surname;}
                                ?>
                              </th>

                              <th>
                              <?
                              if($value->statues=="PENDING"){?>
                                <a  href="javascript:call_delete2('<?=$value->tranfer_id;?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                                <? $CI =& get_instance();
                                $user_role = $CI->session->userdata('usertype');
                                if (  check_access('confirm_fixed_asset_transfers')) {?>
                                <a  href="javascript:call_confirm2('<?=$value->tranfer_id;?>')" title="Confirm"><i class="fa fa-check nav_icon icon_blue"></i></a>
                                <?}}else if($value->statues=="CONFIRM"){
                                  ?>
                                  CONFIRMED
                                  <?}?>
                                </th>

                              </tr>
                            <? } }?>
                          </tbody></table>
                          <div id="pagination-container"></div>
                        </div>
      </div>
      <div role="tabpanel" class="tab-pane fade active in" id="profile" aria-labelledby="profile-tab">
        <p>	  <? if($this->session->flashdata('msg')){?>
          <div class="alert alert-success" role="alert">
            <?=$this->session->flashdata('msg')?>
          </div><? }?>
          <? if($this->session->flashdata('error')){?>
            <div class="alert alert-danger" role="alert">
              <?=$this->session->flashdata('error')?>
            </div><? }?>

            <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/Fixedasset/transfer_asset" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
                  <div class="form-title">
                    <h4>Transfer Details</h4>
                  </div>
                  <div class="form-body">
                    <div class="form-group has-feedback"  id="branch">
                      <select name="tranfer_id" id="tranfer_id" class="form-control" placeholder="Branch" required>
                        <option value="">--Select Asset--</option>
                        <? foreach ($assets as $key => $value) {?>
                          <option value="<?=$value->id?>"
                            data-catid="<?=$value->category_id;?>"
                            data-subcatid="<?=$value->sub_cat_id;?>"
                            data-cat="<?if($value->category_id!=""){echo $category_name[$value->category_id]->asset_category;}?>"
                            data-subcat="<?if($value->sub_cat_id!=""){echo $subcategory_name[$value->sub_cat_id]->sub_cat_name;}?>"
                            data-user="<?if($value->user!=""){echo $user_name[$value->user]->initial;echo $user_name[$value->user]->surname;}?>"
                            data-userid="<?if($value->user!=""){echo $value->user;}?>"
                            data-division="<?if($value->division!=""){echo $division_name[$value->division]->division_name;}?>"
                            data-divisionid="<?if($value->division!=""){echo $value->division;}?>"
                            data-branch="<?if($value->branch!=""){echo $branch_name[$value->branch]->branch_name;}?>"
                            data-branchid="<?if($value->branch!=""){echo $value->branch;}?>"
                          >
                          <?=$value->asset_code?><?=$value->asset_name?></option>
                          <?
                        }
                        ?>

                      </select>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                    <div class="form-group has-feedback"  id="tranfers">
                      <select name="tranfer_type" id="tranfer_type" class="form-control" placeholder="tranfers" required>
                        <option value="">--Select Type--</option>
                        <option value="Category">Category Transfer</option>
                        <option value="Branch">Branch Transfer</option>
                        <option value="Division">Division Transfer</option>
                        <option value="User">User Transfer</option>

                      </select>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                    <div id="category_div">
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" name="old_category" id="old_category" placeholder="Exist Category" data-error="" readonly>
                      <input type="hidden" class="form-control" name="old_categoryval" id="old_categoryval" placeholder="Exist Category" data-error="" readonly>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" name="old_subcategory" id="old_subcategory" placeholder="Exist Sub Category" data-error="" readonly>
                      <input type="hidden" class="form-control" name="old_subcategoryval" id="old_subcategoryval" placeholder="Exist Sub Category" data-error="" readonly>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                    <div class="form-group has-feedback"  id="asset_type">
                      <select name="asset_cat" id="asset_cat" class="form-control" placeholder="Asset Type" required>
                        <option value="">--Asset Category Transfer To--</option>

                        <?
                        foreach ($categories as $key => $value) {?>
                          <option value="<?=$value->id?>"><?=$value->asset_category?></option>
                          <?
                        }
                        ?>

                      </select>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                    <div class="form-group has-feedback"  id="asset_type">
                      <select name="assetsub_cat" id="assetsub_cat" class="form-control" placeholder="Asset Type" required>
                        <option value="">--Select Sub Asset Category Transfer To--</option>

                      </select>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                  </div>
                  <div id="branch_div">
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" name="old_branch" id="old_branch" placeholder="Exist Sub Category" data-error="" readonly>
                      <input type="hidden" class="form-control" name="old_branchval" id="old_branchval" placeholder="Exist Sub Category" data-error="" readonly>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                    <div class="form-group has-feedback"  id="new_branches">
                      <select name="new_branch" id="new_branch" class="form-control" placeholder="Branch" required>
                        <option value="">--Asset Branch Transfer To--</option>

                        <?
                        foreach ($branches as $key => $value) {?>
                          <option value="<?=$value->branch_code?>"><?=$value->branch_name?></option>
                          <?
                        }
                        ?>

                      </select>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                  </div>
                  <div id="user_div">
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" name="old_user" id="old_user" placeholder="Exist User" data-error="" readonly>
                      <input type="hidden" class="form-control" name="old_userval" id="old_userval" placeholder="Exist User" data-error="" readonly>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                    <div class="form-group has-feedback"  id="new_users">
                      <select name="new_user" id="new_user" class="form-control" placeholder="Users" required>
                        <option value="">--Asset User Transfer To--</option>

                        <?
                        foreach ($employees as $key => $value) {?>
                          <option value="<?=$value->id?>"><?=$value->initial?> <?=$value->surname?></option>
                          <?
                        }
                        ?>

                      </select>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                  </div>
                  <div id="division_div">
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" name="old_division" id="old_division" placeholder="Exist Division" data-error="" readonly>
                      <input type="hidden" class="form-control" name="old_divisionval" id="old_divisionval" placeholder="Exist Division" data-error="" readonly>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                    <div class="form-group has-feedback"  id="new_divisions">
                      <select name="new_division" id="new_division" class="form-control" placeholder="Division" required>
                        <option value="">--Asset Division Transfer To--</option>

                        <?
                        foreach ($division as $key => $value) {?>
                          <option value="<?=$value->id?>"><?=$value->division_name?></option>
                          <?
                        }
                        ?>

                      </select>
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      <span class="help-block with-errors" ></span>
                    </div>
                  </div>
                    <div class="bottom validation-grids">

                      <div class="form-group">
                        <button type="submit" class="btn btn-primary disabled">Transfer</button>
                      </div>
                      <div class="clearfix"> </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="clearfix"> </div>
              <br>

            </form></p>
          </div>
      </div>
    </div>
  </div>



  <div class="col-md-4 modal-grids">
    <button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
    <div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4>
          </div>
          <div class="modal-body" id="checkflagmessage">
          </div>
        </div>
      </div>
    </div>
  </div>

  <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
  <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
  <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm2" name="complexConfirm2"  value="DELETE"></button>
  <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm2" name="complexConfirm_confirm2"  value="DELETE"></button>

  <form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
  </form>
  <script>
  $("#complexConfirm").confirm({
    title:"Delete confirmation",
    text: "Are You sure you want to delete this ?" ,
    headerClass:"modal-header",
    confirm: function(button) {
      button.fadeOut(2000).fadeIn(2000);
      var code=1
      window.location="<?=base_url()?>accounts/Fixedasset/delete_transfer/"+document.deletekeyform.deletekey.value;
    },
    cancel: function(button) {
      button.fadeOut(2000).fadeIn(2000);
      // alert("You aborted the operation.");
    },
    confirmButton: "Yes I am",
    cancelButton: "No"
  });
  $("#complexConfirm2").confirm({
    title:"Delete confirmation",
    text: "Are You sure, you want to delete this ?" ,
    headerClass:"modal-header",
    confirm: function(button) {
      button.fadeOut(2000).fadeIn(2000);
      var code=1
      window.location="<?=base_url()?>accounts/Fixedasset/delete_transfer_other/"+document.deletekeyform.deletekey.value;
    },
    cancel: function(button) {
      button.fadeOut(2000).fadeIn(2000);
      // alert("You aborted the operation.");
    },
    confirmButton: "Yes I am",
    cancelButton: "No"
  });
  $("#complexConfirm_confirm").confirm({
    title:"Record confirmation",
    text: "Are You sure you want to confirm this ?" ,
    headerClass:"modal-header confirmbox_green",
    confirm: function(button) {
      button.fadeOut(2000).fadeIn(2000);
      var code=1

      window.location="<?=base_url()?>accounts/Fixedasset/confirm_transfer/"+document.deletekeyform.deletekey.value;
    },
    cancel: function(button) {
      button.fadeOut(2000).fadeIn(2000);
      // alert("You aborted the operation.");
    },
    confirmButton: "Yes I am",
    cancelButton: "No"
  });
  $("#complexConfirm_confirm2").confirm({
    title:"Record confirmation",
    text: "Are You sure, you want to confirm this?" ,
    headerClass:"modal-header confirmbox_green",
    confirm: function(button) {
      button.fadeOut(2000).fadeIn(2000);
      var code=1

      window.location="<?=base_url()?>accounts/Fixedasset/confirm_transfer_other/"+document.deletekeyform.deletekey.value;
    },
    cancel: function(button) {
      button.fadeOut(2000).fadeIn(2000);
      // alert("You aborted the operation.");
    },
    confirmButton: "Yes I am",
    cancelButton: "No"
  });

  $(document).ready(function(){
    $("#branch_div").hide();
    $("#division_div").hide();
    $("#user_div").hide();
    $("#category_div").hide();
    $("#tranfer_type").change(function(){
      var type=$("#tranfer_type").val();
      if(type=="Division"){
        $("#branch_div").hide();
        $("#division_div").show();
        $("#user_div").hide();
        $("#category_div").hide();
      }else if(type=="User"){
        $("#branch_div").hide();
        $("#division_div").hide();
        $("#user_div").show();
        $("#category_div").hide();
      }else if(type=="Branch"){
        $("#branch_div").show();
        $("#division_div").hide();
        $("#user_div").hide();
        $("#category_div").hide();
      }else if(type=="Category"){
        $("#branch_div").hide();
        $("#division_div").hide();
        $("#user_div").hide();
        $("#category_div").show();
      }
    });
    $("#tranfer_id").change(function(){
      var type=$("#tranfer_id").find('option:selected').data('cat');
      var subtype=$("#tranfer_id").find('option:selected').data('subcat');
      var typeid=$("#tranfer_id").find('option:selected').data('catid');
      var subtypeid=$("#tranfer_id").find('option:selected').data('subcatid');
      var branch=$("#tranfer_id").find('option:selected').data('branch');
      var branchid=$("#tranfer_id").find('option:selected').data('branchid');
      var division=$("#tranfer_id").find('option:selected').data('division');
      var divisionid=$("#tranfer_id").find('option:selected').data('divisionid');
      var user=$("#tranfer_id").find('option:selected').data('user');
      var userid=$("#tranfer_id").find('option:selected').data('userid');
      $("#old_category").val(type);
      $("#old_subcategory").val(subtype);
      $("#old_categoryval").val(typeid);
      $("#old_subcategoryval").val(subtypeid);
      $("#old_branch").val(branch);
      $("#old_branchval").val(branchid);
      $("#old_division").val(division);
      $("#old_divisionval").val(divisionid);
      $("#old_user").val(user);
      $("#old_userval").val(userid);
    });
    $( "#asset_cat" ).change(function() {
      var id=$( "#asset_cat" ).val();
      $( "#assetsub_cat option" ).remove();
      $.ajax({
        headers: {
          Accept: 'application/json'
        },
        type: 'post',
        url: '<?=base_url()?>accounts/Fixedasset/sub_asset_data',
        data: {id: id},
        dataType: "json",
        success: function(result){
          $( "#assetsub_cat" ).append('<option value="">--Select Sub Asset Category--</option>');
          jQuery.each(result, function(index, item) {

            $( "#assetsub_cat" ).append('<option value="'+item.sub_cat_id+'">'+item.sub_cat_name+'-'+item.sub_cat_code+'</option>');

          });
        },
        error: function() {
          $( "#assetsub_cat" ).append('<option></option>');

        }

      });
    });

  });
  </script>



  <div class="row calender widget-shadow"  style="display:none">
    <h4 class="title">Calender</h4>
    <div class="cal1">
    </div>
  </div>
  <div class="clearfix"> </div>
</div>
</div>
<!--footer-->
<?
$this->load->view("includes/footer");
?>
