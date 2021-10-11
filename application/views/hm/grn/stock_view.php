
<!DOCTYPE HTML>
<html>
<head>

  <?
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
  $this->load->view("includes/topbar_notsearch");
  ?>
  <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<script type="text/javascript">
  jQuery(document).ready(function() {
  $("#meterials").chosen({
     allow_single_deselect : true
    });

  $("#prjid").chosen({
     allow_single_deselect : true
    });

  $('#prjid').change(function(){
    //$("#meterials").val("");
    $('#meterials').val('').trigger('liszt:updated');
  });
 
   });

  function load_stocks(id){
    console.log(id)
    $("#loadmeterialstock").html("");

    $( "#loadmeterialstock" ).load( "<?=base_url()?>hm/hm_grn/get_current_stock/"+id);
  }

  function load_matvise_stock(id){
     console.log(id)
     var prjid = $('#prjid').val();
     if(prjid=="" || prjid=='allbatch' || prjid=='balqtyall'){
      only_material(id,prjid);
     }else{
      project_rel_materials(id,prjid);
     }
  }

  function only_material(id,prjid){
    $("#loadmeterialstock").html("");
    $( "#loadmeterialstock" ).load( "<?=base_url()?>hm/hm_grn/get_materialvise_stock/"+id+"/"+prjid);
  }

  function project_rel_materials(id,prjid){
    $("#loadmeterialstock").html("");
    $( "#loadmeterialstock" ).load( "<?=base_url()?>hm/hm_grn/get_materialvise_stock_by_project/"+id+"/"+prjid);
  }

  function viewfull(id){
    var matid = id;
    var prjid = $('#prjid').val();
    $('#popupform').delay(1).fadeIn(600);
    $( "#popupform" ).load( "<?=base_url()?>hm/hm_grn/view_full_project_materials/"+matid+"/"+prjid);
  }

</script>
<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
  <div class="main-page">

    <div class="table">



      <h3 class="title1">Stock View</h3><? 
                                           #how many chars will be in the string

                                        ?>
        
         <div class="widget-shadow">
        <ul id="myTabs" class="nav nav-tabs" role="tablist">
          <li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Stock</a></li>
          
        </ul>
        <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;height:500px;">
          <? $this->load->view("includes/flashmessage");?>

          <div role="tabpanel" class="tab-pane fade  active in" id="profile" aria-labelledby="profile-tab">
            <p>


              
                <div class="row">
                  <div class=" widget-shadow" data-example-id="basic-forms">
                    
                    <div class="row">
                    <div class="form-group col-md-3">
                      <label class="control-label">Project</label>
                      <select name="prjid" id="prjid" class="form-control" onChange="load_stocks(this.value)"  >
                        <option value="">Select Project</option>
                        <option value="allbatch">Main Stock (All Batches)</option>
                        <option value="balqtyall">Main Stock (balance Quantity)</option>
                        <?
                        if($prjlist){
                        foreach($prjlist as $pl){
                        ?>
                         <option value="<?=$pl->prj_id?>"><?=$pl->project_code?>-<?=$pl->project_name?> stock</option>
                        <?
                         }
                        }
                        ?>
                      </select>
                    </div>

                    <div class="form-group col-md-3" id="meterialsdiv">
                      <label class="control-label">Meterial</label>
                      <select class="form-control" id="meterials" onChange="load_matvise_stock(this.value)">
                          <option value="">Select Meterial</option>
                          <?
                               if($meterial){
                                  foreach($meterial as $met){
                                    ?>
                                  <option value="<?=$met->mat_id?>"><?=$met->mat_name?></option>
                                    <?
                                  }
                                }  
                          ?>
                        </select>
                    </div>
                    
                    
                    <div id="loadmeterialstock">
<!-- **********************************************batchwise stock list*****************************************-->
<table class="table" id="purchase_table" width="50%" >
<?

 if(!empty($finarr)){
 ?>
 <thead>
    <tr>
        <th>#</th>
        <th>Meterial</th>
        <th>Batch No</th>
        <th>Quantity</th>
        <th>Quantity (balance)</th>
        <th>Price</th>
        <th>Stock Received Date</th>
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
       <td><strong><?=$i?></strong></td>
       <td><strong><?=$value['meterial']?></strong></td>
       <td><strong><?=$value['batchno']?> </strong></td>
       <td><strong><?=$value['quantity']?></strong></td>
       <td><strong><?=$value['balquantity']?></strong></td>
       <td><strong><?=$value['price']?></strong></td>
       <td><strong><?=$value['confirmdate']?></strong></td>
       <td>
        <?
        if(sizeof($value['stockdispach'])>0){
        ?>
        <a data-toggle="collapse" class="success" id="btn<?=$value['mat_id']?>" data-target="#demo<?=$value['mat_id']?><?=$value['batch_code']?>" title="Expand"><span id="ico<?=$value['mat_id']?>"><i class="fa fa-plus-circle"></i></span></a> &nbsp;&nbsp;
        <?
        }

        if(sizeof($value['porequests'])>0){
          ?>
          <a data-toggle="collapse" id="btn<?=$value['mat_id']?>" data-target="#dispache<?=$value['mat_id']?><?=$value['batch_code']?>" title="Dispatch"><span id="ico<?=$value['mat_id']?>"><i class="fa fa-exchange"></i></span></a>
          <?

        }
        ?>

      </td>
  </tr>
  <tr id="demo<?=$value['mat_id']?><?=$value['batch_code']?>" class="collapse">
      <td colspan="6">
        <table class="table">
          <?
            
          ?>
          <tr bgcolor="#5bc0de">
            <td>Project</td>
            <td>Total Quantity</td>
            <td>Used Qty</td>
            <td>Transfer Qty</td>
            <td>Processed Type</td>
          </tr>

          <?
          if($value['stockdispach']){
          foreach($value['stockdispach'] as $pmatfull){
            ?>
            <tr bgcolor="#5bc0de">
              <td><?=get_prjname($pmatfull->prj_id)?></td>
              <td><?=$pmatfull->rcv_qty?></td>
              <td><?=$pmatfull->ussed_qty?></td>
              <td><?=$pmatfull->trans_qty?></td>
              <td><?=$pmatfull->transfer?></td>
            </tr>
            <?
             }
           }
          ?>
        <tr><td colspan="5"><hr></td></tr>
        </table>
      </td>
  </tr>

  <tr id="dispache<?=$value['mat_id']?><?=$value['batch_code']?>" class="collapse">
      <td colspan="6">
        <table class="table">
          <?
            
          ?>
          <tr bgcolor="#5cb85c">
            <td>Project</td>
            <td>Request Quantity</td>
            <td></td>
          </tr>

          <?
          foreach($value['porequests'] as $prlist){
            ?>

             <tr bgcolor="#5cb85c">
              <td><?=get_prjname($prlist->prj_id)?></td>
              <td>
                <input type="text" name="req_qty" id="req_qty" value="<?=$prlist->qty-$prlist->dispatched_qty?>" readonly="readonly">
            </td>
              <td><!--<input type="submit" class="btn btn-default" name="dispatch" value="Dispatch">-->
                <form action="<?=base_url()?>hm/hm_grn/add_dispatch" method="post">
                  <input type="hidden" name="req_qty" id="req_qty" value="<?=$prlist->qty-$prlist->dispatched_qty?>" readonly="readonly">
                  <input type="hidden" name="ussed_qty" id="ussed_qty" value="<?=$value['ussedmainstock']?>" readonly="readonly">
                  <input type="hidden" name="req_id" id="req_id" value="<?=$prlist->req_id?>" readonly="readonly">
                  <input type="hidden" name="prj_id" id="prj_id" value="<?=$prlist->prj_id?>" readonly="readonly">
                  <input type="hidden" name="lot_id" id="lot_id" value="<?=$prlist->lot_id?>" readonly="readonly">
                  <input type="hidden" name="mat_id" id="mat_id" value="<?=$prlist->mat_id?>" readonly="readonly">
                  <input type="hidden" name="stock_id" id="stock_id" value="<?=$value['stock_id']?>" readonly="readonly">
                  <input type="hidden" name="price" id="price" value="<?=$value['buyprice']?>" readonly="readonly">
              <button type="submit" class="btn btn-primary">Dispatch</button></form></td>
            </tr>

            <?
             }
          ?>
        <tr><td colspan="5"><hr></td></tr>
        </table>
      </td>
  </tr>
  <?
  $i++;
   }
  ?>
 </tbody>
 <?

 }

?>

</table>
<div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
<!-- ************************************************batchwise stock list**************************************** -->
                    </div>
                      
                    </div>
                  </div>
                
              </p>

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


        <?
        $this->load->view("includes/footer");
        ?>
