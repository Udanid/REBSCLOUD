<!DOCTYPE HTML>
<html>
<head>
  <?php
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
  $this->load->view("includes/topbar_accounts"); ?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
  <script>

  $(document).ready(function(){
    $("#bank1").chosen({
      allow_single_deselect : true
    });
    $("#branch1").chosen({
      allow_single_deselect : true
    });


    //when succes close button pressed
    $(document).on('click','#close-btn', function(){
      location.reload();
    });

  });

  function loadbranchlist(itemcode,caller)
  {
    var code=itemcode.split("-")[0];
    if(code!=''){
      //alert(code)
      //$('#popupform').delay(1).fadeIn(600);
      $( "#branch-"+caller ).load( "<?=base_url()?>common/get_bank_branchlist/"+itemcode+"/"+caller );}

    }
    function call_edit(id) {
      $('#popupform').delay(1).fadeIn(600);
      $("#popupform").load( "<?=base_url()?>accounts/loan/loanapprovals_view/"+id );

    }
    function close_edit(id){
      $('#popupform').delay(1).fadeOut(800);
    }
    function call_confirm(id)
    {

      document.deletekeyform.deletekey.value=id;
      $('#complexConfirm').click();

    }
    </script>

    <!-- main content start-->
    <div id="page-wrapper">
      <div class="main-page">
        <div class="table">
          <h3 class="title1">Loan</h3>
          <div class="widget-shadow">
            <div class="  widget-shadow" data-example-id="basic-forms">
              <ul id="myTabs" class="nav nav-tabs" role="tablist">
                <li role="presentation"   class="active" >
                  <a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Pending Loan list</a>
                </li>
              </ul>

              <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
                <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
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
                    <table class="table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Loan Number</th>
                          <th>Loan Type</th>
                          <th>Loan Amount</th>
                          <th>Bank</th>
                          <th>Status</th>
                          <th>Approval</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if($datalist){
                          $c = 0;
                          $count = 1;
                          foreach($datalist as $row){ ?>
                            <tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                              <td><?php echo $count; ?></td>
                              <td><?php echo $row->loan_number; ?></td>
                              <td>
                                <?php
                                if($row->loan_type == "free"){
                                  $loan_type = "Free Loan";
                                }else if($row->loan_type == "mortgage"){
                                  $loan_type = "Mortgage";
                                }else if($row->loan_type == "lease"){
                                  $loan_type = "Lease";
                                }
                                echo $loan_type; ?>
                              </td>
                              <td class="text-right"><?=number_format($row->loan_amount,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                              <td><?=$banknames[$row->bank_code]->BANKNAME;?></td>
                              <td>
                                <?php
                                $status='';
                                if($row->loan_status == "pending"){
                                  $status = "Pending";
                                }else if($row->loan_status == "approved"){
                                  $status = "Confirmed";
                                }else if($row->loan_status == "disapproved"){
                                  $status = "Disapproved";
                                }
                                echo $status; ?>
                              </td>
                              <td align="right">
                                <div id="checherflag">
                                  <a href="javascript:call_edit('<?php echo $row->id;?>')" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>
                                  <?php
                                  if($row->loan_status == "pending"){ ?>
                                    <a href="javascript:call_confirm('<?php echo $row->id;?>')"><i class="fa fa-check nav_icon icon_blue"></i></a>
                                    <?php
                                  }
                                  ?>
                                </div>
                              </td>
                            </tr>
                            <?php
                            $count++;
                          }
                        } ?>
                      </tbody>
                    </table>
                    <div id="pagination-container"></div>
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
              </div>
            </div>
          </div>
        </div>
        <script>
        $(document).ready(function(){

          $( "#project" ).change(function() {
            var id=$( "#project" ).val();
            $( "#lots option" ).remove();
            $.ajax({
              headers: {
                Accept: 'application/json'
              },
              type: 'post',
              url: '<?=base_url()?>accounts/Loan/get_blocks',
              data: {id: id},
              dataType: "json",
              success: function(result){
                $( "#lots" ).append('<option value="">-- Lots --</option>');
                jQuery.each(result, function(index, item) {

                  $( "#lots").append('<option value="'+item.lot_number+'">'+item.lot_number+'</option>');
                });
              },
              error: function() {
                alert("some error");
              }

            });
          });

        });
        </script>
        <script>
        $("#complexConfirm").confirm({

          title:"Record confirmation",
          text: "Are You sure you want to confirm this ?" ,
  headerClass:"modal-header confirmbox_green",
          confirm: function(button) {
              button.fadeOut(2000).fadeIn(2000);
    var code=1

              window.location="<?=base_url()?>accounts/loan/confirm/"+document.deletekeyform.deletekey.value;
          },
          cancel: function(button) {
              button.fadeOut(2000).fadeIn(2000);
             // alert("You aborted the operation.");
          },
          confirmButton: "Yes I am",
          cancelButton: "No"
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
