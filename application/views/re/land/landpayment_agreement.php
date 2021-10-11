<!--//Ticket No:2385-->
<!DOCTYPE HTML>
<html>
<head>

<?
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">

  $( function() {
    $( "#search_agdate" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );
  
  function call_confirm(id)
  {
     document.deletekeyform.deletekey.value=id;
    $('#complexConfirm_confirm').click();
         
  }

  function call_delete(id)
  {
     document.deletekeyform.deletekey.value=id;
    $('#complexConfirm_delete').click();
         
  }

  function viewplan(id){

  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>re/landpayment_agreement/view/"+id );

}

  function editplan(id){

  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>re/landpayment_agreement/edit/"+id);

}

function close_view(){
  $('#popupform').delay(1).fadeOut(800);
}
       
</script>
    <!-- //header-ends -->
    <!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">All Agreements</h3>
          
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
          
          <li role="presentation"  class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Agreement List</a></li> 
            <li role="presentation" >
          <a href="#block" id="block-tab" role="tab" data-toggle="tab" aria-controls="block" aria-expanded="false">Add Agreement</a></li> 
        </ul> 
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          
               <div role="tabpanel" class="tab-pane fade  active in" id="home" aria-labelledby="home-tab" >
               <br>
         <? if($this->session->flashdata('msg')){?>
         <div class="alert alert-success" role="alert">
          <?=$this->session->flashdata('msg')?>
        </div><? }?>
        <? if($this->session->flashdata('error')){?>
        <div class="alert alert-danger" role="alert">
          <?=$this->session->flashdata('error')?>
        </div><? }?>




        <div class="form-title">
          <h4>All Payment Plans</h4>
        </div>
        <br>
        <form data-toggle="validator" method="post" action="<?php echo base_url('index.php/re/landpayment_agreement/search');?>"  enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; margin-top:-40px; background-color: #eaeaea;">


              <div class="form-body">
                <div class="form-inline">

                  <div class="form-group col-sm-3">
                    <select class="form-control" placeholder="Qick Search.." id="search_agno" name="search_agno" >
                      <option value="">Agreement No</option>
                      <?    foreach($allagreements as $row){?>
                      <option value="<?=$row['agreement_no']?>"><?=$row['agreement_no']?></option>
                      <? }?>
                    </select>  </div>

                    <div class="form-group col-sm-3" >
                     <select class="form-control" placeholder="Qick Search.." id="search_landid" name="search_landid" >
                      <option value="">Land Code</option>
                      <?    foreach($allagreements as $row){?>
                      <option value="<?=$row['land_id']?>"><?=$row['land_id']?></option>
                      <? }?>

                    </select>  </div>
                    <div class="form-group col-sm-3" id="blocklist">
                      <input type="text" name="search_agdate" id="search_agdate" placeholder="Agreement Date"  class="form-control" autocomplete="off" >
                    </div>
                    <div class="form-group col-sm-3">
                      <input type="submit" name="submit" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;" value="Search">
                    </div>

                  </div>

                </div>

              </div>
              
            </div>
          </form>
          <br>

          <table class="table">
            <tr>
              <th>Agreement No</th>
              <th>Agreement Date</th>
              <th>Land Code</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>Confirmed By</th>
              <th>Confirmed At</th>
              <th>Status</th>
            </tr>
            <?php foreach($allagreements as $agreements)
            {
              echo '<tr>';
              echo '<td>'.$agreements['agreement_no'].'</td>';
              echo '<td>'.$agreements['agreement_date'].'</td>';
              echo '<td>'.$agreements['land_id'].'</td>';
              echo '<td>'.$agreements['created_by'].'</td>';
              echo '<td>'.$agreements['created_at'].'</td>';
              echo '<td>'.$agreements['confirmed_by'].'</td>';
              echo '<td>'.$agreements['confirmed_at'].'</td>';
              echo '<td>'.$agreements['status'].'</td>';

              if($agreements['status'] == 'PENDING')
              {
                 echo '<td><a href="javascript:call_confirm('.$agreements['agreement_id'].')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>';
              }
              if($agreements['status'] == 'PENDING')
              {
              echo '<td><a href="javascript:call_delete('.$agreements['agreement_id'].')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a></a>';
              }
              // if($agreements['status'] == 'PENDING') //Remove the edit form
              // {
              //  echo '<td><a href="javascript:editplan('.$agreements['agreement_id'].')"  title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a></a>';
              // }

             echo '<td><a href="javascript:viewplan('.$agreements['agreement_id'].')"  title="View"><i class="fa fa-eye nav_icon icon_green"></i></a></a>';
              
              
              echo '</td>';
            }
            ?>
          </table>
          <button type="button" style="display:none; visibility:hidden;" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
          <button type="button" style="display:none; visibility:hidden;" class="btn btn-delete" id="complexConfirm_delete" name="complexConfirm_delete"  value="DELETE"></button>
          <form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
          </form>
        </div>
             <div role="tabpanel" class="tab-pane fade " id="block" aria-labelledby="block-tab" >
               <br>
               <?

                $data = array();
                $data['alllands'] = $alllands;
                // foreach($alllands as $land)
                // {
                //   echo $land['land_code'].'-'.$land['property_name'].'<br>';
                // }
               ?>
               <? $this->load->view("re/land/addpayment.php",$data);?>
               </div>
             
            </div>
         </div>
      </div>
    </div>
  </div>

      <script type="text/javascript">
        $("#complexConfirm_confirm").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
        headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
          var code=1
                  window.location="<?=base_url()?>re/landpayment_agreement/confirm/"+document.deletekeyform.deletekey.value;
                    
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });

        $("#complexConfirm_delete").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
        headerClass:"modal-header confirmbox_danger",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
          var code=1
                  window.location="<?=base_url()?>re/landpayment_agreement/delete/"+document.deletekeyform.deletekey.value;
                    
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
      </script>
        
    <!--footer-->
<?
  $this->load->view("includes/footer");
?>