
<!DOCTYPE HTML>
<html>
<head>

  <?
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
  $this->load->view("includes/topbar_normal");
  ?>
  <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
  <script type="text/javascript">
  jQuery(document).ready(function() {


    $("#leger_acc").chosen({
      allow_single_deselect : true
    });
    $("#depre_acc").chosen({
      allow_single_deselect : true
    });
    $("#provi_acc").chosen({
      allow_single_deselect : true
    });
    $("#dispo_acc").chosen({
      allow_single_deselect : true
    });



  });

  function check_activeflag(id)
  {

    $('#popupform').delay(1).fadeIn(600);
    $( "#popupform" ).load( "<?=base_url()?>accounts/Fixedasset/edit_category/"+id );

  }
  function close_edit(id)
  {

    // var vendor_no = src.value;
    //alert(id);

    $.ajax({
      cache: false,
      type: 'GET',
      url: '<?php echo base_url().'common/delete_activflag/';?>',
      data: {table: 'cm_supplierms', id: id,fieldname:'sup_code' },
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
  var deleteid="";
  function call_delete(id)
  {
    document.deletekeyform.deletekey.value=id;
    $.ajax({
      cache: false,
      type: 'GET',
      url: '<?php echo base_url().'common/activeflag_cheker/';?>',
      data: {table: 'cm_supplierms', id: id,fieldname:'sup_code' },
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


    //alert(document.testform.deletekey.value);

  }

  function call_confirm(id)
  {
    document.deletekeyform.deletekey.value=id;
    $.ajax({
      cache: false,
      type: 'GET',
      url: '<?php echo base_url().'common/activeflag_cheker/';?>',
      data: {table: 'cm_supplierms', id: id,fieldname:'sup_code' },
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


    //alert(document.testform.deletekey.value);

  }
  function loadbranchlist(itemcode,caller)
  {
    var code=itemcode.split("-")[0];
    if(code!=''){
      //alert(code)
      //$('#popupform').delay(1).fadeIn(600);
      $( "#branch-"+caller ).load( "<?=base_url()?>common/get_bank_branchlist/"+itemcode+"/"+caller );}

    }
    </script>

    <!-- //header-ends -->
    <!-- main content start-->
    <div id="page-wrapper">
      <div class="main-page">

        <div class="table">



          <h3 class="title1">New Institute</h3>

          <div class="widget-shadow">
            <ul id="myTabs" class="nav nav-tabs" role="tablist">

              <li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add New Institute</a></li>
              <li role="presentation"  class=""><a href="#sub_category" role="tab" id="sub_category-tab" data-toggle="tab" aria-controls="sub_category" aria-expanded="true">Add Institute New Branch</a></li>
              <li role="presentation"  class=""><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Institute List</a></li>
              </ul>
              <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">

                <div role="tabpanel" class="tab-pane fade   <? if(check_access('fixed_asset')){?><? }else {?>active in<? }?>" id="home" aria-labelledby="home-tab" >
                  <br>
                  <? if($this->session->flashdata('msg')){?>
                    <div class="alert alert-success" role="alert">
                      <?=$this->session->flashdata('msg')?>
                    </div><? }?>
                    <? if($this->session->flashdata('error')){?>
                      <div class="alert alert-danger" role="alert">
                        <?=$this->session->flashdata('error')?>
                      </div><? }?>

                      <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                        <table class="table"> <thead> <tr> <th>No</th> <th>Institute Code</th> <th>Institute Name </th></tr> </thead>
                          <tbody>
                            <?php
                            $i=0;
                            foreach ($bankname as $key => $value) {
                              $i++;
                              ?>
                            </tr>
                            <th><?=$i?></th>
                            <th><?=$value->BANKCODE?></th>
                            <th><?=$value->BANKNAME?></th>
                          </tr>
                            <?php }?>
                          </tbody></table>
                            <div id="pagination-container"></div>
                          </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="sub_category" aria-labelledby="sub_category-tab" >
                          <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                            <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/Institute/addbranch" enctype="multipart/form-data">
                              <div class="row">
                                <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
                                  <div class="form-title">
                                    <h4>Institute Branch Details</h4>
                                  </div>
                                  <div class="form-body">
                                    <div class="form-group has-feedback"  id="asset_type">
                                      <select name="bank" id="bank" class="form-control" placeholder="" required>
                                        <option value="">--Select Institute--</option>
                                        <?php foreach ($bankname as $key => $value) {?>
                                          <option value="<?=$value->BANKCODE?>"><?=$value->BANKNAME?></option>
                                        <?php }?>

                                      </select>
                                    </div>
                                    <div class="form-group has-feedback">
                                      <input type="number" class="form-control" name="branch_code" id="branch_code" placeholder="New Branch Code" data-error="" required>
                                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                      <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                      <input type="text" class="form-control" name="branch_name" id="branch_name" placeholder="New Branch name" data-error="" required>
                                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                      <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="bottom validation-grids">

                                      <div class="form-group">
                                        <button type="submit" class="btn btn-primary disabled">Submit</button>
                                      </div>
                                      <div class="clearfix"> </div>
                                    </div>

                                  </div>
                                </div>
                              </div>
                            </form>
                          </br></br></br>
                          <table class="table" id="subassaet_table">
                            <thead>
                              <tr><th></th><th>Branch Code</th><th>Branch Name</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                          <div id="pagination-container"></div>
                        </div>
                      </div>
                      <? if(check_access('fixed_asset')){?>
                        <div role="tabpanel" class="tab-pane fade active in" id="profile" aria-labelledby="profile-tab">
                          <p>	  <? if($this->session->flashdata('msg')){?>
                            <div class="alert alert-success" role="alert">
                              <?=$this->session->flashdata('msg')?>
                            </div><? }?>
                            <? if($this->session->flashdata('error')){?>
                              <div class="alert alert-danger" role="alert">
                                <?=$this->session->flashdata('error')?>
                              </div><? }?>

                              <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/Institute/add" enctype="multipart/form-data">
                                <div class="row">
                                  <div class="col-md-6 validation-grids validation-grids-right">
                                    <div class="widget-shadow" data-example-id="basic-forms">
                                      <div class="form-title">
                                        <h4>Institute Details:</h4>
                                      </div>
                                      <div class="form-body">
                                        <div class="form-group has-feedback">
                                          <input type="number" class="form-control" name="bank_code" id="bank_code" placeholder="New Institute Code" data-error="" required>
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                          <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="New Institute name" data-error="" required>
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                        </div>
                                        <div class="bottom validation-grids">

                                          <div class="form-group">
                                            <button type="submit" class="btn btn-primary disabled">Submit</button>
                                          </div>
                                          <div class="clearfix"> </div>
                                        </div>

                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="clearfix"> </div>
                                <br>

                              </form></p>
                            </div>
                          <? }?>
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
                    <form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
                    </form>
                    <script>

                    $(document).ready(function(){

                      $( "#bank" ).change(function() {
                        var id=$( "#bank").val();
                        $( "#subassaet_table tbody tr" ).remove();
                        $.ajax({
                          headers: {
                            Accept: 'application/json'
                          },
                          type: 'post',
                          url: '<?=base_url()?>accounts/Institute/branch_data',
                          data: {id: id},
                          dataType: "json",
                          success: function(result){

                            jQuery.each(result, function(index, item) {
                              $( "#subassaet_table tbody" ).append('<tr><th></th><th>'+item.BRANCHCODE+'</th><th>'+item.BRANCHNAME+'</th></tr>');

                            });
                          },
                          error: function() {
                            $( "#subassaet_table tbody" ).append('<tr><th></th><th></th><th></th></tr>');

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
