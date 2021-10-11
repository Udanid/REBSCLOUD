<!DOCTYPE HTML>
<html>
<head>
  <?php
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
  $this->load->view("includes/topbar_accounts"); ?>
<script type="text/javascript">
$(document).ready(function(){

  $('#loan_no').on('change', function() {
var id=$('#loan_no').val();
 if(id!=""){
					 $('#plandata').delay(1).fadeIn(600);
	 			    document.getElementById("plandata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#plandata" ).load( "<?=base_url()?>accounts/loan/mortgage_release_data/"+id );

 }
 else
 {
	 $('#plandata').delay(1).fadeOut(600);
 }
});
});
</script>
  <!-- main content start-->
  <div id="page-wrapper">
    <div class="main-page">
      <div class="table">
        <h3 class="title1">Mortgage Release</h3>
        <div class="widget-shadow">
          <div class="  widget-shadow" data-example-id="basic-forms">
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
              <li role="presentation"   class="active" >
                <a href="#release" role="tab" id="release-tab" data-toggle="tab" aria-controls="release" aria-expanded="true">Mortgage Release</a>
              </li>
              <li role="presentation"  >
                <a href="#home" role="tab" id="home-tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Mortgage Release list</a>
              </li>
            </ul>

            <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
              <div  role="tabpanel" class="tab-pane fade  active in" id="release" aria-labelledby="release-tab">
                <div class="row">
                  <? if($this->session->flashdata('msg')){?>
                    <div class="alert alert-success" role="alert">
                      <?=$this->session->flashdata('msg')?>
                    </div><? }?>
                    <? if($this->session->flashdata('error')){?>
                      <div class="alert alert-danger" role="alert">
                        <?=$this->session->flashdata('error')?>
                      </div><? }?>
                <from>
                  <div class="col-md-6 validation-grids validation-grids-left">
                <div >
                  <div class="" data-example-id="basic-forms">
                    <div class="form-body">
                      <div class="form-group">
                  <select class="form-control" id="loan_no" name="loan_no" data-loan="" required>
                    <option value="">--Select Loan Number--</option>
                    <?php
                    if($datalist){
                      foreach($datalist as $row){ ?>
                      <option value="<?=$row->id?>" data-loan="<?=$row->loan_number?>"><?=$row->loan_number?></option>
                        <?php
                      }
                    }
                        ?>
                  </select>
                </div>
                </div>
                </div>

                </div>

              </from>

              </div>
              <div id="plandata"></div>
              <div class="col-md-6 validation-grids validation-grids-left" id="payment_history">

              </div>
            </div>
          </div>
              <div  role="tabpanel" class="tab-pane fade" id="home" aria-labelledby="home-tab">
              <div class="row">

                  <table class="table table-striped" id="shedule_table">
                    <thead>
                      <tr>
                        <th>Loan No</th>
                        <th><center>Project Name</center></th>
                        <th><center>Released Lots</center></th>
                        <th><center>All Lots</center></th>


                      </tr>
                    </thead>
                    <tbody>
                      <?
					  if($released_mortgage)
                      foreach ($released_mortgage as $key => $value) {?>
                        <tr>
                        <td><?=$value->loan_number;?></td>
                        <td><?=$prj[$value->id]->project_name;?></td>
                        <td><?
                        $i=0;
                        foreach ($lots_no[$value->id] as $key2 => $value2) {
                          $i=$i+1;
                          if($value2->statues_active==0){
            								echo " ".$value2->lot_no." , ";
                            if($i % 20 == 0){
                              echo "</br>";
                            }
            							}
                        }
                        ?></td>
                        <td>
                          <?
                          $i=0;
                          foreach ($lots_no[$value->id] as $key2 => $value2) {
                            $i=$i+1;
                            echo " ".$value2->lot_no." , ";
                            if($i % 20 == 0){
                              echo "</br>";
                            }
                          }
                          ?>
                        </td>

                        </tr>
                      <? }
                      ?>

                    </tbody>
                  </table>
                  <div id="pagination-container"></div>
                </div>
                </div>
              </div>
              <!--table end-->

              <!--shedule start-->


              </div>
              <!--shedule end-->

            </div>
          </div>
        </div>
      </div>
<script>
$(document).ready(function(){

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
  <?php
  $this->load->view("includes/footer"); ?>
