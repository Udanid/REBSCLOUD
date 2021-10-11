
<script type="text/javascript">

    $(document).ready(function() {

        $("#empsearch").chosen({
            allow_single_deselect : true
        });

    });


    function delete_payment(id)
    {
        var r=confirm("Are you sure you want to delete this payment voucher?")
        if (r==true)
        {
            $.ajax({
                cache: false,
                type: 'POST',
                url: '<?php echo base_url().'accounts/paymentvouchers/delete';?>',
                data: {id: id },
                success: function(data) {
                    if (data) {
                        alert(data);
                        location.reload();
                        //alert("delete success");
                    }
                    else
                    {
                        alert("delete failed");
                    }
                }
            });
        }
    }

    function confirm_payment(id) {
        var r=confirm("Are you sure you want to confirm this payment voucher?")
        if (r==true)
        {
            $.ajax({
                cache: false,
                type: 'POST',
                url: '<?php echo base_url().'accounts/paymentvouchers/confirm';?>',
                data: {id: id },
                success: function(data) {
                    if (data) {
                        alert(data);
                        location.reload();
                        //alert("delete success");
                    }
                    else
                    {
                        alert("confirm failed");
                    }
                }
            });
        }
    }

    function check_activeflag(id)
    {
        $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_payvoucherdata', id: id,fieldname:'voucherid' },
            success: function(data) {
                if (data) {
                    // alert(data);
                    document.getElementById("checkflagmessage").innerHTML=data;
                    $('#mylistkkk').click();

                    //document.getElementById('mylistkkk').style.display='block';
                }
                else
                {
                    $('#popupform').delay(1).fadeIn(600);
                    $( "#popupform" ).load( "<?=base_url()?>accounts/paymentvouchers/edit/"+id );
                }
            }
        });
    }

    function close_edit(id)
    {
        $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'ac_payvoucherdata', id: id,fieldname:'voucherid' },
            success: function(data) {
                if (data) {
                    $('#popupform').delay(1).fadeOut(800);

                    //document.getElementById('mylistkkk').style.display='block';
                }
                else
                {
                    document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin ';
                    $('#mylistkkk').click();

                }
            }
        });
    }
function loadcurrent_block(id)
{
//	alert(id)
 if(id!=""){

							 $('#blocklist').delay(1).fadeIn(600);
    					    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
					$( "#blocklist" ).load( "<?=base_url()?>accounts/income/get_blocklist/"+id );






 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);

 }
}
function load_fulldetails()
{
	 var prj_id= document.getElementById("prj_id").value;
	 var block_val=document.getElementById("lot_id").value;

	 if(block_val!="")
	 {//alert('block_val')

	 	 $('#datalist').delay(1).fadeIn(600);
    	  document.getElementById("datalist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		   $( "#datalist").load( "<?=base_url()?>accounts/income/get_fulldata_lotid/"+block_val);
	 }
	 else if(prj_id!="")
	 {//alert(prj_id)

	 	 $('#datalist').delay(1).fadeIn(600);
    	  document.getElementById("datalist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		   $( "#datalist").load( "<?=base_url()?>accounts/income/get_fulldata_project/"+prj_id);
	 }
	 else
	 {

	 	 $('#datalist').delay(1).fadeIn(600);
    	  document.getElementById("datalist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		   $( "#datalist").load( "<?=base_url()?>accounts/income/get_fulldata/");
	 }
}
</script>


<div class="row">
    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;" id="datalist">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Temp Codeee</th>
                <th>Income Type</th>
                 <th>Project Name</th>
                  <th>Lot Number</th>
                   <th>Pay Type</th>
                    <th>Cheque Num</th>
                <th>Amount</th>

                 <th>DI </th>
                <th>Income Date</th>
                <th>Status</th>
                <th colspan="3"></th>
            </tr>
            </thead>
            <?php
		$ci =&get_instance();
			$ci->load->model('hm_mobilepay_model');
            if ($ac_incomes){
            $c=0;
            foreach($ac_incomes as $rowdata){
				$bank_code = $ci->hm_mobilepay_model->get_project_payment_data_by_code($rowdata->loanId);
				$mydate=date('Y-m-d',$rowdata->timestmp);
            ?>
            <tbody>
            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                <th scope="row"><?=$rowdata->tempId?></th>
                <td align="center"><?=$rowdata->loanId ?></td>

                <td> <?=$bank_code['pay_type'] ?></td>
                 <td> <?=$bank_code['project_name'] ?></td>
                  <td> <?=$bank_code['lot_number'] ?></td>
                    <td align=right ><?=$rowdata->paytype?></td>
                      <td align=right ><?=$rowdata->chq_no?></td>
                <td align=right ><?=number_format($rowdata->amt, 2, '.', ',')?></td>
                 <td align="center"><?=number_format(get_loan_date_di($rowdata->loanId,$mydate),2)?></td>
                <td> <?=date('Y-m-d',$rowdata->timestmp)?></td>
                <td> <?=$rowdata->status?></td>

                        <td>
                            <div id="checher_flag">
                            <? if($bank_code['pay_type']=='Advance Payment'){?>
                                <a href="<?= base_url() ?>hm/mobilepay/advancepay/<? echo $rowdata->tempId ?>">
                                    <i class="fa fa-plus-square-o nav_icon icon_blue"></i>
                                </a>
                                <? }?>
                                 <? if($bank_code['pay_type']=='Rental Payment'){?>
                                <a href="<?= base_url() ?>hm/mobilepay/rentalpay/<? echo $rowdata->tempId ?>">
                                    <i class="fa fa-plus-square-o nav_icon icon_blue"></i>
                                </a>
                                <? }?>
                            </div>
                        </td>

<!--                        <td>-->
<!--                            <a href="javascript:delete_payment('--><?// echo $rowdata->id; ?><!--')"><i-->
<!--                                    class="fa fa-trash-o nav_icon icon_blue"></i></a>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <a href="javascript:confirm_payment('--><?// echo $rowdata->id; ?><!--')"><i-->
<!--                                    class="fa fa-check-square-o nav_icon icon_blue"></i></a>-->
<!--                        </td>-->

            </tr>
            <?
            }}
            ?>
            </tbody>
        </table>

    </div>
</div><div id="get_paymentvoucherdata" ></div>
<div class="col-md-4 modal-grids">
    <button type="button" style="display:none" class="btn btn-primary"  id="mylistkkk"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
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
