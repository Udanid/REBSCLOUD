
<!DOCTYPE HTML>
<html>
<head>

  <?
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
  $this->load->view("includes/topbar_notsearch");
  ?>
  <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
  <script type="text/javascript">
  $(function(){
     $("#prj2").chosen({
       allow_single_deselect : true
     });
  });

   
   //$('#prj2').refresh();
   

/*$  ('#met').change(function(){
    //$('#qty').val('');
    alert("trsfsad")
     //var trnsqty = $(this).find(':selected').attr('data-qty');
     console.log("qty "+trnsqty)
     //$('#qty').val(trnsqty);
   });  */

   function get_materials(id){
    $("#loadmeterial").html("");
    $("#loadsitestocks").html("");
    $("#loadmeterial" ).load( "<?=base_url()?>hm/hm_grn/get_meterials_byprjkt/"+id);
   }

   function load_sitestockmat(id){
      var prj1 = $('#prj1').val();
      //alert(prj1+" "+id)
      $("#loadsitestocks").html("");
      $("#loadsitestocks" ).load( "<?=base_url()?>hm/hm_grn/get_meterialsid_rel_sitestocks/"+id+"/"+prj1);
   }

  function load_balanceqty(id){
    $('#loadbalanceqty').html('');
     var res = id.split('_');
     var site_stockid = res[0];
     var balqty = res[1];
     var prvtransqty = res[2];
     var unitprices = res[3];
     console.log(site_stockid)
     console.log(balqty)
     $('#loadbalanceqty').append('<tr>\
        <td><input type="hidden" name="unitprice" value="'+unitprices+'"><input type="hidden" name="rtnqtysiteid" value="'+site_stockid+'"><input type="hidden" name="prevtransqty" value="'+prvtransqty+'">Available Quantity : <input class="form-control" type="text" id="availbalqty" name="availbalqty" value="'+balqty+'" readonly="readonly"></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>\
          <td>&nbsp;&nbsp;&nbsp;&nbsp; Transfer Quantity : <input class="form-control" type="number" name="transqty" id="transqty" onkeyup="qtychk(this.value)" required="required"><p id="qtyerrmsg"></p></td>\
      </tr>');
  }

  function qtychk(id){
    $('#qtyerrmsg').html("");
    var availqty = parseInt($('#availbalqty').val());
    var enterqty = id;
    console.log("available "+availqty)
    console.log("entered "+enterqty)
   if(enterqty>availqty){
      console.log(id+">"+availqty)
      $('#qtyerrmsg').html("<font color='red'><b>Entered Quantity Cannot be Greater Than Available Quantity</b></font>");
      $('#transqty').val(availqty);
   }
  }

  function approve(id){
   /*var rtnqty="";
   var totalrtnqty = "";
   var sitestockid = "";

   $('#tbldata'+id).html("CONFIRMED");*/
   document.deletekeyform.deletekey.value=id;
   $('#complexConfirm_confirm').click();
   
   //ajax_for_approve_disapprove(id,'CONFIRMED',rtnqty,totalrtnqty,sitestockid);
  }

  function disapprove(id){

   /*var res = id.split('_');
   var rtnstkid = res[0];
   var rtnqty = res[1];
   var totalrtnqty = res[2];
   var sitestockid = res[3];
   $('#tbldata'+rtnstkid).html("CANCELLED");*/
   document.deletekeyform.deletekey.value=id;
   $('#complexConfirm_subtask').click();
   //ajax_for_approve_disapprove(rtnstkid,'CANCELLED',rtnqty,totalrtnqty,sitestockid);
  }

  //created 2019-12-27 by terance perera
  function getpoRequestRelmeterials(id){
      $("#Requestmeterials").html("");
      $("#Requestmeterials" ).load( "<?=base_url()?>hm/hm_grn/get_project_related_poreq_materials/"+id);
  }
    

</script>

<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
  <div class="main-page">

    <div class="table">



      <h3 class="title1">Stock Transfer</h3>

      <div class="widget-shadow">
        <ul id="myTabs" class="nav nav-tabs" role="tablist">
          <li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Stock Transfer</a></li>
          <li role="presentation" ><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Transfer Confirmation</a></li>
          <li role="presentation" ><a href="#listall" role="tab" id="listall-tab" data-toggle="tab" aria-controls="listall" aria-expanded="true">Transfer Stock List</a></li>
        </ul>
        <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;height:500px;">
          <? $this->load->view("includes/flashmessage");?>

            <div role="tabpanel" class="tab-pane fade  active in" id="profile" aria-labelledby="profile-tab">
             <!--stock transfer form-->
              
                <div class="row">
                  <div class=" widget-shadow" data-example-id="basic-forms">
                    <div class="form-title">
                      <h4>Stock Transfer</h4>
                    </div>
                    <div class="row">
                    
                    <div class="form-group col-md-3" id="toproject">
                      <label class="control-label" >Request project</label>
                      <select id="prj2" name="prj2" class="form-control" onChange="getpoRequestRelmeterials(this.value)">
                        <option value="">Request project</option>
                          <?
                            foreach($prjlist2 as $prj2){
                          ?>
                            <option value="<?=$prj2->prj_id?>"><?=$prj2->project_name?></option>
                          <?
                            }
                          ?>
                      </select>
                    </div>
                    
                    <br><hr><br>
                    <div class="form-group col-md-12" id="Requestmeterials">
                         
                      <?
                       if($finarr){
                        //print_r($finarr);
                         ?>
                         <table class="table" id="purchase_table" width="50%" >
                         <thead>
                          <tr>
                            <th></th>
                            <th>Request Project</th>
                            <th>Meterial</th>
                            <th>Request Quantity</th>
                            <th></th>
                          </tr>
                         </thead>
                         <tbody>
                         <?
                         $i=1;
                         foreach($finarr as $key => $value){
                          if($i % 2 == 0){
                            $clr = "#d9edf7";
                          }else{
                            $clr = "#FFFFFF";
                          }
                          
                           ?>
                           <tr bgcolor="<?=$clr?>">
                              <td><?=$i?></td>
                              <td><strong><?=$value['project']?></strong></td>
                              <td><strong><?=$value['meterial']?></strong></td>
                              <td><strong><?=$value['req_qty']?></strong></td>
                              <td>
                              <?
                               //echo sizeof($value['batches']);
                               //print_r($value['batches']);
                               if(count(array_filter($value['batches']))>0){
                              ?>
                              <a data-toggle="collapse" id="btn<?=$value['mat_id']?>" data-target="#transfer<?=$value['mat_id']?><?=$value['prj_id']?>" title="View Full"><span id="ico<?=$value['mat_id']?>"><i class="fa fa-exchange"></i></span></a>
                              <?
                               }
                              ?>
                              </td>
                           </tr>
                           <tr id="transfer<?=$value['mat_id']?><?=$value['prj_id']?>" class="collapse">
                             <td colspan="4">
                                
                                <table class="table">
                                    <tr>
                                      <th>Project/batch code</th>
                                      <th>Available Quantity</th>
                                      <th>Requested Quantity</th>
                                      <th></th>
                                    </tr>
                                    <?
                                     foreach($value['batches'] as $avlqty){
                                       ?>
                                       
                                       <tr>
                                        <td><?=$avlqty->project_name?>/<?=$avlqty->batch_code?></td>
                                        <td><?=$avlqty->balanceqty?></td>
                                        <td><input type="text" name="transqty" readonly value="<?=$value['req_qty']?>"></td>
                                        <td>
                                        <form action="<?=base_url()?>hm/hm_grn/transfer_stock_process" method="post">
                                        <input type="hidden" name="fromprj" value="<?=$avlqty->prj_id?>">
                                        <input type="hidden" name="toprj" value="<?=$value['prj_id']?>">
                                        <input type="hidden" name="transferqty" value="<?=$value['req_qty']?>">
                                        <input type="hidden" name="materialid" value="<?=$value['mat_id']?>">
                                        <input type="hidden" name="stockid" value="<?=$avlqty->stock_id?>">
                                        <input type="hidden" name="price" value="<?=$avlqty->siteprice?>">
                                        <input type="hidden" name="sitestockid" value="<?=$avlqty->site_stockid?>">
                                        <input type="hidden" name="porequestid" value="<?=$value['req_id']?>">
                                        <input type="hidden" name="transqty" value="<?=$avlqty->trans_qty?>">
                                        <button type="submit" class="btn btn-primary btn-sm">Transfer</button>
                                        </form>
                                        </td>
                                       </tr>
                                       
                                       <?
                                     }
                                    ?>
                                </table>
                             </td>
                           </tr>
                           <?
                           $i++;
                         }
                       }
                      ?>
                       </tbody>
                      </table>
                    </div>
                         
                  </div>
                   
                          
                    </div>
                  </div>
                
             <!--stock Transfer form-->
            </div>
            <div role="tabpanel" class="tab-pane fade" id="list" aria-labelledby="list-tab">
                 <table class="table" id="" width="90%">
                            <thead>
                              <tr>
                              <th>#</th>
                              <th>From Project</th>
                              <th>To Project</th>
                              <th>Site Stock</th>
                              <th>Meterial</th>
                              <th>Transfer Quantity</th>
                              <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?
                              if($trans_stock){
                               $i2=1;
                               foreach($trans_stock as $ts){
                               if($i2 % 2 == 0){
                                  $clr = "#d9edf7";
                                }else{
                                  $clr = "#FFFFFF";
                                }
                              ?>
                              <tr bgcolor="<?=$clr?>">
                                <td><?=$i2?></td>
                                <td><?=$ts->frmprjname?></td>
                                <td><?=$ts->toprjname?></td>
                                <td>GRN <?=$ts->grn_id?> - site Stock <?=$ts->site_stockid?></td>
                                <td><?=$ts->mat_name?></td>
                                <td><?=$ts->trn_qty?></td>
                                <td id="tbldata<?=$ts->transfer_id?>">
                                  <?
                                  if(check_access('stktransfer'))//call from access_helper
                                  {
                                  ?>
                                    <a href="javascript:approve('<?=$ts->transfer_id?>')" title="Confirm This"><i class="fa fa-check nav_icon icon_green"></i></a>
                                    <a href="javascript:disapprove('<?=$ts->transfer_id?>_<?=$ts->trn_qty?>_<?=$ts->trans_qty?>_<?=$ts->site_stockid?>')" title="Reject This"><i class="fa fa-close nav_icon icon_red"></i></a>
                                  <?
                                  } 
                                  ?>
                                </td>
                              </tr>
                              <?
                              $i2++;
                                

                               }
                              }
                              ?>
                            </tbody>
                </table> 
                <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="listall" aria-labelledby="listall-tab">
                <table class="table" id="" width="90%">
                            <thead>
                              <tr>
                              <th>#</th>
                              <th>From Project</th>
                              <th>To Project</th>
                              <th>Site Stock</th>
                              <th>Material</th>
                              <th>Transfer Quantity</th>
                              <th>Status</th>
                              <th>Confirmed/Cancelled by</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?
                              if($trans_stock_all){
                              $i=1;
                               foreach($trans_stock_all as $tsa){
                                if($i % 2 == 0){
                                  $clr = "#d9edf7";
                                }else{
                                  $clr = "#FFFFFF";
                                }
                              ?>
                              <tr bgcolor="<?=$clr?>">
                                <td><?=$i?></td>
                                <td><?=$tsa->frmprjname?></td>
                                <td><?=$tsa->toprjname?></td>
                                <td>GRN <?=$tsa->grn_id?> - site Stock <?=$tsa->site_stockid?></td>
                                <td><?=$tsa->mat_name?></td>
                                <td><?=$tsa->trn_qty?></td>
                                <td>
                                  <?=$tsa->status?>                                  
                                </td>
                                <td><?=$tsa->transconfdate?> by <?=$tsa->initial?> <?=$tsa->surname?></td>
                              </tr>
                              <?
                              $i++;
                               }
                              }
                              ?>
                            </tbody>
                </table>
                <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
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
            
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_subtask" name="complexConfirm_subtask"  value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
            
            <form name="deletekeyform">  
              <input name="deletekey" id="deletekey" value="0" type="hidden">
            </form>
            
            <div class="row calender widget-shadow"  style="display:none">
              <h4 class="title">Calender</h4>
              <div class="cal1">

              </div>
            </div>



            <div class="clearfix"> </div>
          </div>
        </div>
        <!--footer-->
    <script type="text/javascript">

      $('#prj1').change(function(){
         var prj1val = $('#prj1').val();
         load_to_project(prj1val);
      });

       function load_to_project(prj1val){
        $("#toproject").html("");
        $("#toproject" ).load( "<?=base_url()?>hm/hm_grn/get_Project_lists/"+prj1val);
       }


       $("#complexConfirm_confirm").confirm({
                title:"Stock Transfer confirmation",
                text: "Are You sure you want to confirm This Stock Transfer ?" ,
                headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                    var id = document.deletekeyform.deletekey.value;
                    var rtnstkid = "";// left return stock id : right hand side rtnst kid.
                     var rtnqty = "";
                     var totalrtnqty = "";
                     var sitestockid = "";
                    ajax_for_approve_disapprove(id,'CONFIRMED',rtnqty,totalrtnqty,sitestockid)

                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });

            $("#complexConfirm_subtask").confirm({
                title:"Stock Transfer Cancel",
                text: "Are You sure you want to Cancel This Stock Transfer ?" ,
                headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                    var id = document.deletekeyform.deletekey.value;
                     var res = id.split('_');
                     var rtnstkid = res[0];
                     var rtnqty = res[1];
                     var totalrtnqty = res[2];
                     var sitestockid = res[3];
                    ajax_for_approve_disapprove(rtnstkid,'CANCELLED',rtnqty,totalrtnqty,sitestockid)
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });

      function ajax_for_approve_disapprove(id,stts,rtnqty,totalrtnqty,sitestockid){
    //console.log("<?php echo base_url()?>hm/hm_inventry/request_meterial_stts")
    $.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url()?>hm/hm_grn/confirm_or_reject_stock_transfer',
            data: {'id':id,'stts':stts,'rtnqty':rtnqty,'totalrtnqty':totalrtnqty,'sitestockid':sitestockid},
            success: function(data){
              console.log(data)
              alert(data)
              $('#tbldata'+id).html(data);
            }
    });
} 
    </script>

        <?
        $this->load->view("includes/footer");
        ?>
