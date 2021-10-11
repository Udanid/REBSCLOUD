<!DOCTYPE HTML>
<html>
<head>

  <?
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
  $this->load->view("includes/topbar_normal");
  ?>
  <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script>

</script>
  <!-- //header-ends -->
  <!-- main content start-->
  <div id="page-wrapper">
    <div class="main-page">

      <div class="table">



        <h3 class="title1">Fixed Asset Register</h3>

        <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
            <? if(check_access('fixed_asset')){?> <li role="presentation" class="active"><a href="#transfers" role="tab" id="transfers-tab" data-toggle="tab" aria-controls="transfers" aria-expanded="false">Fixed Asset Register</a></li>
        <? }?>
      </ul>
      <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
        <div role="tabpanel" class="tab-pane fade active in" id="transfers" aria-labelledby="transfers-tab">
        <div class=" widget-shadow bs-example" data-example-id="contextual-table" name="print_div" id="print_div">
        </br><a href="#" style="margin-left: 95%;" name="generate_excel_icon" id="generate_excel_icon"><i class="fa fa-file-excel-o fa-lg"></i></a>
          </br></br>
          <table class="table" border="1"> <thead>
            <tr bgcolor="LightGray">
              <th rowspan="2">NO</th>
              <th colspan="6"><center>Product Details</center></th>
              <th colspan="3"><center>Invoice Details</center></th>
              <th colspan="3"><center>Asset Location</center></th>
              <th colspan="3"><center>Depreciation Details</center></th>
              <th colspan="3"><center>Disposal Details</center></th>
              <th colspan="3"><center>Transfer Details</center></th>
            </tr>
            <tr bgcolor="LightGray">
              <th>Asset Code</th>
              <th>Asset Name</th>
               <th>Purchase Date</th>
               <th>Brand</th>
               <th>Serial/ Ref. Number</th>
               <th>Remark</th>
                <th>Supplier Name</th>
                <th>Invoice No. </th>
                <th> Cost </th>
                <th>User</th>
                <th>Division</th>
                <th>Branch</th>
                <th> Dep. For the Year </th>
                <th> Acc. Dep. </th>
                <th> WDV</th>
                <th>Date</th>
                <th> Amount</th>
                <th> Profit/ (Loss)</th>
                <th> Date</th>
                <th> Transfer From</th>
                <th> Transfer To</th>
              </tr> </thead>
            <tbody>
              <?php
              if($assets){
                $i=0;
                foreach ($assets as $key => $value) {
                  $i=$i+1;
                  $rowcount=$tranfercount[$value->id]->tranfercount;
                  if($rowcount==0){$rowcount=1;}

                  ?>
                  <tr>
                    <td rowspan="<?=$rowcount;?>"><?=$i?></td>
                    <td rowspan="<?=$rowcount;?>"><?=$value->asset_code;?></td>
                    <td rowspan="<?=$rowcount;?>"><?=$value->asset_name;?></td>
                    <td rowspan="<?=$rowcount;?>"><?=$value->year?></td>
                    <td rowspan="<?=$rowcount;?>"><?=$value->brand?></td>
                    <td rowspan="<?=$rowcount;?>"><?=$value->serial_no?></td>
                    <td rowspan="<?=$rowcount;?>"><?=$value->remarks?></td>
                    <!--  -->
                    <?php if(!empty($invoice[$value->id]->inv_no)){?>
                      <td rowspan="<?=$rowcount;?>"><?=$invoice[$value->id]->first_name;?><?=$invoice[$value->id]->last_name;?></td>
                      <td rowspan="<?=$rowcount;?>"><?=$invoice[$value->id]->inv_no;?></td>
                      <td rowspan="<?=$rowcount;?>" align="right"><?=number_format($value->purches_value,2);?></td>
                    <?}else{?>
                      <td rowspan="<?=$rowcount;?>">-</td>
                      <td rowspan="<?=$rowcount;?>">-</td>
                      <td rowspan="<?=$rowcount;?>" align="right"><?=number_format($value->purches_value,2);?></td>
                    <?}?>

                    <!--Asset Location  -->
                    <td rowspan="<?=$rowcount;?>"><? if($value->user){echo $user_name[$value->user]->initial;echo $user_name[$value->user]->surname;}?></td>
                    <td rowspan="<?=$rowcount;?>"><? if($value->division){echo $division_name[$value->division]->division_name;}?></td>
                    <td rowspan="<?=$rowcount;?>"><? if($value->branch){echo $branch_name[$value->branch]->branch_name;}?></td>
                    <!--Depreciation Details  -->
                    <?php
                    $dep_For_the_Year=0.00;
                    $acc_dep=0.00;
                    $wdv=0.00;
                    if($value->statues!="DISPOSAL"){
                      $dep_For_the_Year=($category_name[$value->category_id]->depreciation_presantage/100)*$value->purches_value;
                      if($depreciation){$acc_dep= $depreciation[$value->id]->depreciation_value;}
                      $wdv=$value->purches_value-$acc_dep;
                    }
                    ?>
                    <td rowspan="<?=$rowcount;?>" align="right"><?=number_format($dep_For_the_Year,2);?></td>
                    <td rowspan="<?=$rowcount;?>" align="right"><?=number_format($acc_dep,2);?></td>
                    <td rowspan="<?=$rowcount;?>" align="right"><?=number_format($wdv,2);?></td>
                    <!-- Disposal Details -->
                    <?php
                    if($value->statues=="DISPOSAL"){?>
                      <td rowspan="<?=$rowcount;?>"><?=$value->disposal_at?></td>
                      <td rowspan="<?=$rowcount;?>" align="right"><?=number_format($value->disposal_value,2);?></td>
                      <td rowspan="<?=$rowcount;?>" align="right"><?=number_format($value->purches_value-$value->disposal_value,2);?></td>
                  <?  }else{?>
                    <td rowspan="<?=$rowcount;?>">-</td>
                    <td rowspan="<?=$rowcount;?>">-</td>
                    <td rowspan="<?=$rowcount;?>">-</td>
                <?  }
                    ?>
                    <?php
                    if($tranfercount[$value->id]->tranfercount==0){?>
                      <td rowspan="<?=$rowcount;?>">-</td>
                      <td rowspan="<?=$rowcount;?>">-</td>
                      <td rowspan="<?=$rowcount;?>">-</td>
                    <? }else{
                      $m=0;
                  foreach ($transfer_other as $key2 => $value2) {
                    $m=$m+1;
                    if($rowcount>1 && $m>1){?>
                      <tr>
                      <?php }
                    if($value->id==$value2->asset_id){
                      $type=$value2->tranfer_category;
                      if($type=="Branch"){?>

                        <td><?=$value2->tranfer_date;?></td>
                        <td>
                          <?
                          echo $value2->old_value.' - ';
                          if($value2->old_value!=""){echo $oldval[$value2->old_value]->branch_name;}
                          ?>
                        </td>

                        <td>
                          <?
                          echo $value2->new_value.' - ';
                          if($value2->new_value!=""){echo $newval[$value2->new_value]->branch_name;}
                          ?>
                        </td>

                    <?  }elseif($type=="Division"){
                    ?>
                      <td><?=$value2->tranfer_date;?></td>
                      <td>
                        <?
                        if($value2->old_value!=""){echo $oldval[$value2->old_value]->division_name;}
                        ?>
                      </td>

                      <td>
                        <?
                        if($value2->new_value!=""){echo $newval[$value2->new_value]->division_name;}
                        ?>
                      </td>


                  <?}elseif($type=="User"){
                  ?>
                  <td><?=$value2->tranfer_date;?></td>
                    <td>
                      <?
                      if($value2->old_value!=""){echo $oldval[$value2->old_value]->initial;echo $oldval[$value2->old_value]->surname;}
                      ?>
                    </td>

                    <td>
                      <?
                      if($value2->new_value!=""){echo $newval[$value2->new_value]->initial;echo $newval[$value2->new_value]->surname;}
                      ?>
                    </td>
                  <?}  }
                    if($rowcount>1 && $m>1){?>
                    </tr>
                    <?php }

                  }
                }
                    ?>

                  </tr>
              <?php  }
              }
              ?>

              </tbody></table>
              <div id="pagination-container"></div>
            </div>

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

  <script>
  $("#generate_excel_icon").click(function (e) {
		var restorepage = $('body').html();
		$('#print_title').show();
		$('#print_icon').empty();
		$('#generate_excel_icon').hide();
		var printcontent = $('#print_div').clone();
		var contents = $('body').empty().html(printcontent);
		//window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=print_div]').html()));
		var result = 'data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=print_div]').html());
        this.href = result;
        this.download = "Fixed_Asset_Register.xls";
		$('#print_title').hide();
		$('#print_icon').show();
		$('#generate_excel_icon').show();
		$('body').html(restorepage);
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
