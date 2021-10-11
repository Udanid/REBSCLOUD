
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

$("#selectDr1").chosen({
     allow_single_deselect : true,
	 width:'75%'
    });
	$("#selectCr1").chosen({
     allow_single_deselect : true,
width:'75%'
    });

	$("#selectDr27").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr27").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr2").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr2").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr6").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr6").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr7").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr7").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr28").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr28").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr10").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr10").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr11").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr11").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr9").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr9").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr12").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr12").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr20").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr20").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr19").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr19").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr3").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr3").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr4").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr4").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr26").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr26").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr18").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr18").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr13").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr13").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr14").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr14").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr15").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr15").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr22").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr22").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr23").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr23").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr29").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr29").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectDr30").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr30").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	
	$("#selectDr34").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr34").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	
	$("#selectDr35").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr35").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	
	$("#selectDr36").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr36").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	
	$("#selectDr37").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	$("#selectCr37").chosen({
     allow_single_deselect : true,
width:'75%'
    });
	
});

function check_activeflag(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_rates', id: id,fieldname:'rate_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>config/rates/edit/"+id );
				}
            }
        });
}
function close_edit(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'cm_rates', id: id,fieldname:'rate_id' },
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

</script>

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Rates & other</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Rates & other</a></li>
        </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
               <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
               <br>
             <? 
			 $ledgerlist=get_master_acclist();
			 $type = 're';
							  
			 $raw1=get_account_set_config('Project Conformation',$type);
			 $selectCr1= $raw1->Cr_account;
			 $selectDr1= $raw1->Dr_account;
			// echo $selectDr1;
			 $raw2=get_account_set_config('Advanced Payment',$type);
			 $selectCr2= $raw2->Cr_account;
			 $selectDr2= $raw2->Dr_account;
			 $raw3=get_account_set_config('EP Rental',$type);
			 $selectCr3= $raw3->Cr_account;
			 $selectDr3= $raw3->Dr_account;
			 $raw4=get_account_set_config('EP Interest',$type);
			 $selectCr4= $raw4->Cr_account;
			 $selectDr4= $raw4->Dr_account;
			  $raw5=get_account_set_config('VAT Income',$type);
			 $selectCr5= $raw5->Cr_account;
			 $selectDr5= $raw5->Dr_account;
			  $raw6=get_account_set_config('Legal Fee',$type);
			 $selectCr6= $raw6->Cr_account;
			 $selectDr6= $raw6->Dr_account;
			  $raw7=get_account_set_config('Documentation Charge',$type);
			 $selectCr7= $raw7->Cr_account;
			 $selectDr7= $raw7->Dr_account;
			  $raw8=get_account_set_config('Delay Interest',$type);
			 $selectCr8= $raw8->Cr_account;
			 $selectDr8= $raw8->Dr_account;
			  $raw9=get_account_set_config('Advance Payment After Profit',$type);
			 $selectCr9= $raw9->Cr_account;
			 $selectDr9= $raw9->Dr_account;
			  $raw10=get_account_set_config('Transfer Sale',$type);
			 $selectCr10= $raw10->Cr_account;
			 $selectDr10= $raw10->Dr_account;
			   $raw11=get_account_set_config('Transfer Cost',$type);
			 $selectCr11= $raw11->Cr_account;
			 $selectDr11= $raw11->Dr_account;
			   $raw12=get_account_set_config('EP creation',$type);
			 $selectCr12= $raw12->Cr_account;
			 $selectDr12= $raw12->Dr_account;
			   $raw13=get_account_set_config('EP Reprocess Cost of Sale Reversal',$type);
			 $selectCr13= $raw13->Cr_account;
			 $selectDr13= $raw13->Dr_account;
			   $raw14=get_account_set_config('Ep Reprocess Sale Revesal',$type);
			 $selectCr14= $raw14->Cr_account;
			 $selectDr14= $raw14->Dr_account;
			   $raw15=get_account_set_config('EP Reprocess Pay Capital Reversal',$type);
			 $selectCr15= $raw15->Cr_account;
			 $selectDr15= $raw15->Dr_account;
			   $raw18=get_account_set_config('EP DI Income',$type);
			 $selectCr18= $raw18->Cr_account;
			 $selectDr18= $raw18->Dr_account;
			  $raw19=get_account_set_config('EP DP Transfer',$type);
			 $selectCr19= $raw19->Cr_account;
			 $selectDr19= $raw19->Dr_account;
			  $raw20=get_account_set_config('EP Creation Interest',$type);
			 $selectCr20= $raw20->Cr_account;
			 $selectDr20= $raw20->Dr_account;
			  $raw22=get_account_set_config('EP Reschedule Balance Int',$type);
			 $selectCr22= $raw22->Cr_account;
			 $selectDr22= $raw22->Dr_account;
			  $raw23=get_account_set_config('EP Reschedule New Int',$type);
			 $selectCr23= $raw23->Cr_account;
			 $selectDr23= $raw23->Dr_account;
			  $raw25=get_account_set_config('External Fund Transfer',$type);
			 $selectCr25= $raw25->Cr_account;
			 $selectDr25= $raw25->Dr_account;
			  $raw26=get_account_set_config('EPB Interest',$type);
			 $selectCr26= $raw26->Cr_account;
			 $selectDr26= $raw26->Dr_account;
			  $raw27=get_account_set_config('Price List Confirmation',$type);
			 $selectCr27= $raw27->Cr_account;
			 $selectDr27= $raw27->Dr_account;
			  $raw28=get_account_set_config('Stamp Duty',$type);
			 $selectCr28= $raw28->Cr_account;
			 $selectDr28= $raw28->Dr_account;
			  $raw29=get_account_set_config('Block Resale Income',$type);
			 $selectCr29= $raw29->Cr_account;
			 $selectDr29= $raw29->Dr_account;
			  $raw30=get_account_set_config('Checque Return Charge',$type);
			 $selectCr30= $raw30->Cr_account;
			 $selectDr30= $raw30->Dr_account;
			 
			  $raw34=get_account_set_config('ZEP Creation',$type);
			 $selectCr34= $raw34->Cr_account;
			 $selectDr34= $raw34->Dr_account;
			 
			  $raw35=get_account_set_config('EPB Creation',$type);
			 $selectCr35= $raw35->Cr_account;
			 $selectDr35= $raw35->Dr_account;
			  $raw36=get_account_set_config('ZEP Rental',$type);
			 $selectCr36= $raw36->Cr_account;
			 $selectDr36= $raw36->Dr_account;
			 
			  $raw37=get_account_set_config('EPB Rental',$type);
			 $selectCr37= $raw37->Cr_account;
			 $selectDr37= $raw37->Dr_account;


			 $this->load->view("includes/flashmessage");?>
                 <form data-toggle="validator" method="post" action="<?=base_url()?>config/rates/update_reledger" enctype="multipart/form-data">

              <input type="hidden" name="selectCr5" id="selectCr5" value="<?=$selectCr5?>">
              <input type="hidden" name="selectDr5" id="selectDr5" value="<?=$selectDr5?>">
               <input type="hidden" name="selectCr8" id="selectCr8" value="<?=$selectCr8?>">
              <input type="hidden" name="selectDr8" id="selectDr8" value="<?=$selectDr8?>">

                    <div class=" widget-shadow col-md-12   bs-example" data-example-id="contextual-table" >

                        <table class="table table-bordered"> <thead> <tr> <th >Name</th> <th >Cr Account</th><th >Dr Account</th></tr>
                      </thead>
                    <tr class="active" style="font-weight:bold"><td align="center" colspan="3" >Project Confirmation and Project Payment Related Accounts</td></tr>
                    <tr><td>Project Conformation</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr1" name="selectCr1"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr1==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr1" name="selectDr1"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr1==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                        <tr><td>Price List Conformation</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr27" name="selectCr27"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr27==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr27" name="selectDr27"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr27==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                      <tr style="display:none"><td>External Fund Transfers</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr25" name="selectCr25"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr25==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr25" name="selectDr25"   required >
                                    <? if($ledgerlist){?>
                    <option value=""></option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr25==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                            <tr class="active" style="font-weight:bold"><td align="center" colspan="3" >Customer Advance Payment And Other payments Accounts</td></tr>

             <tr><td>Advanced Payment</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr2" name="selectCr2"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr2==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr2" name="selectDr2"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr2==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                     <tr><td>Legal Fee</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr6" name="selectCr6"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr6==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr6" name="selectDr6"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr6==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                      <tr><td>Documentation Charge</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr7" name="selectCr7"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr7==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr7" name="selectDr7"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr7==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                      <tr><td>Stamp Duty</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr28" name="selectCr28"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr28==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr28" name="selectDr28"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr28==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                      <tr><td>Cheque Return Charges</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr30" name="selectCr30"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr30==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr30" name="selectDr30"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr30==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                    <tr class="active" style="font-weight:bold"><td align="center" colspan="3" >Profit Transfer Related Accounts</td></tr>
             <tr><td>Transfer Sale</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr10" name="selectCr10"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr10==$rw->id){?> selected<? }?>> <?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr10" name="selectDr10"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr10==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                      <tr><td>Transfer Cost</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr11" name="selectCr11"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr11==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr11" name="selectDr11" required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr11==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                      <tr><td>Advance Payment After Profit</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr9" name="selectCr9"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr9==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr9" name="selectDr9" required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr9==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                             <tr class="active" style="font-weight:bold"><td align="center" colspan="3" >NEP Creation Related Accounts</td></tr>
       <tr><td>EP creation</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr12" name="selectCr12"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr12==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr12" name="selectDr12"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr12==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                          <tr><td> EP Creation Interest</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr20" name="selectCr20"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr20==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr20" name="selectDr20"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr20==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                     <tr><td> EP DP Transfer</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr19" name="selectCr19"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr19==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr19" name="selectDr19"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr19==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                     <tr><td>Rental Payment</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr3" name="selectCr3"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr3==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr3" name="selectDr3"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr3==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                    <tr><td>Interest Income</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr4" name="selectCr4"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr4==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr4" name="selectDr4"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr4==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                     <tr><td>EPB Interest Income</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr26" name="selectCr26"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr26==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr26" name="selectDr26"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr26==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                     <tr><td>Delay Interest Income</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr18" name="selectCr18"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr18==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr18" name="selectDr18"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr18==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
 <tr class="active" style="font-weight:bold"><td align="center" colspan="3" >Loan Reshedule and Reprocess Related Accounts</td></tr>

            <tr><td>EP Reprocess Cost of Sale Reversal</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr13" name="selectCr13"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr13==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr13" name="selectDr13"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr13==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                     <tr><td>Ep Reprocess Sale Revesal</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr14" name="selectCr14"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr14==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr14" name="selectDr14"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr14==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                      <tr><td>EP Reprocess Pay Capital Reversal</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr15" name="selectCr15"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr15==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr15" name="selectDr15"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr15==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                       <tr><td>EP Reschedule Balance Int</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr22" name="selectCr22"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr22==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr22" name="selectDr22"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr22==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                       <tr><td>EP Reschedule New Int</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr23" name="selectCr23"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr23==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr23" name="selectDr23"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr23==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                      <tr><td>Block Resale Income</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr29" name="selectCr29"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr29==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr29" name="selectDr29"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr29==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                    
                               <tr><td>ZEP Creation</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr34" name="selectCr34"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr34==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr34" name="selectDr34"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr34==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                    
                    <tr><td>EPB Creation</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr35" name="selectCr35"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr35==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr35" name="selectDr35"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr35==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                         <tr><td>ZEP Rental</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr36" name="selectCr36"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr36==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr36" name="selectDr36"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr36==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                    
                    <tr><td>EPB Rental</td><td><select class="form-control" placeholder="Ledger Account"  id="selectCr37" name="selectCr37"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Cr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectCr37==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td>
                    <td><select class="form-control" placeholder="Ledger Account"  id="selectDr37" name="selectDr37"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Dr Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($selectDr37==$rw->id){?> selected<? }?>><?=$rw->id?> - <?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>


					</select> </td></tr>
                    
                          </tbody></table>
                          <div class="form-group validation-grids">
												<button type="submit" class="btn btn-primary" style="width:25%;">Update</button>
											</div>

                    </div>  </form>
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
									<div class="modal-body" id="checkflagmessage"> Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
									</div>
								</div>
							</div>
						</div>
					</div>

<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_subtask" name="complexConfirm_subtask"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm_subtask" name="complexConfirm_confirm_subtask"  value="DELETE"></button>

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
                    window.location="<?=base_url()?>config/producttasks/delete/"+document.deletekeyform.deletekey.value;
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

                    window.location="<?=base_url()?>config/producttasks/confirm/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			$("#complexConfirm_subtask").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>config/producttasks/delete_subtask/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });

              $("#complexConfirm_confirm_subtask").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1

                    window.location="<?=base_url()?>config/producttasks/confirm_subtask/"+document.deletekeyform.deletekey.value;
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
