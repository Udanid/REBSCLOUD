<!DOCTYPE HTML>
<html>
<head>
<?
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_accounts");
?>

<script>
    function load_search_data(obj)
    {

        var value1 =obj.value;
       // alert(value1);

        if(value1=='' ){

            document.getElementById("seachlocator").style.display='none';
            document.getElementById("supplierlocator").style.display='none';

        }
        else if(value1==3)
        {
            var id = value1;
            document.getElementById("supplierlocator").style.display='block';
            document.getElementById("seachlocator").style.display='none';
            //popupdetails("accounts/payments/supplier_list",value,'supplierlocator')
            $('#supplierlocator').load("<?=base_url()?>accounts/payments/supplier_list/");
        }
        else
        {
            //value=value1;
            var id=value1;
            document.getElementById("seachlocator").style.display='block';
            document.getElementById("supplierlocator").style.display='none';
           // popupdetails("accounts/payments/voucher_data",value,'seachlocator')
            $('#seachlocator').load("<?=base_url()?>accounts/payments/voucher_data/"+id);

        }

        
    }
    function load_supplier_data(obj)
    {

        var value1 =obj.value;


        if(value1=='' ){

            document.getElementById("seachlocator").style.display='none';
            //ocument.getElementById("supplierlocator").style.display='none';

        }
        else
        {
            var id=3+'/'+value1;
            document.getElementById("seachlocator").style.display='block';
            //document.getElementById("supplierlocator").style.display='none';
            //popupdetails("payments/supplier_voucher_data",value,'seachlocator')
            $('#seachlocator').load("<?=base_url()?>accounts/payments/supplier_voucher_data/"+id);
        }


    }

    function checkAll(obj)
    {


        var rawmatcount=document.myform.rawmatcount.value;
        if(obj.checked){
            for(i=1; i<=rawmatcount; i++)
            {

                totobj=eval("document.myform.isselect"+i);
                totobj.checked=true;

            }
        }
        else{
            for(i=1; i<=rawmatcount; i++)
            {
//alert("ss")
                totobj=eval("document.myform.isselect"+i);
                totobj.checked=false;
//alert(units+avbunits);
            }
        }
        calculatetot();
    }
    function calculatetot()
    {

        var tot=0;

        var rawmatcount=document.myform.rawmatcount.value;

        for(i=1; i<=rawmatcount; i++)
        {

            totobj=eval("document.myform.isselect"+i);

            amount=eval("document.myform.invoiceamount"+i);

            if(totobj.checked)
            {

                tot=parseFloat(tot)+parseFloat(amount.value);

            }

        }

        if(tot!=0)
        {
            document.myform.amount.value=parseFloat(tot).toFixed(2);
        }
        else
        {
            document.myform.amount.value="";
        }
    }
    function loadpayeelist(obj)
    {
        val=obj.value;
        if(val=='2')
        {
            document.getElementById("emp").style.display='block';
            document.getElementById("supp").style.display='none';
            document.getElementById("common").style.display='none';
        }
        else if(val=='3')
        {
            document.getElementById("emp").style.display='none';
            document.getElementById("supp").style.display='block';
            document.getElementById("common").style.display='none';
        }
        else
        {
            document.getElementById("emp").style.display='none';
            document.getElementById("common").style.display='block';
            document.getElementById("supp").style.display='none';
        }
    }
    function loadpayeename(obj)
    {
        alert(document.myform)
        document.myform.payeename.value=obj.value;
    }
    function myValidator()
    {
        valeu1=document.myform.amount.value;
        if(valeu1=="")
        {
            //alert('false');
            document.getElementById("error-box").style.display='block';
            return false;
        }
        else
        {
            document.getElementById("error-box").style.display='none';
            return true;
        }
    }
</script>

<div id="page-wrapper">
    <div class="main-page">
        <div class="table">
            <h3 class="title1">Cancel Payment Entry</h3>
            <?php $this->load->view("includes/flashmessage");?>
            <div class="widget-shadow">
                <div class="  widget-shadow" data-example-id="basic-forms">
                <form name="myform" action="<?=base_url()?>accounts/payments/cancelation/<?=$entry_id?>" method="post">
				  
                 <div class="row"><br>
							<div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
								<div class="form-body">
                                   <div class="form-group  "><label class="col-sm-3 control-label">Entry Number</label>
										<div class="col-sm-3 " id="taskdata"><? echo $current_entry_type['prefix'] . form_input($entry_number) . $current_entry_type['suffix'];
?>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" >Entry Date</label>
										<div class="col-sm-3" id="subtaskdata"><? echo form_input_date_restrict($entry_date);
?>
										</div>
                                        
                                       </div>
                                       <table class="table"><thead><tr><th>Type</th><th>Ledger Account</th><th>Dr Amount</th><th>Cr Amount</th></tr></thead>
                                       <?
                                       
									   foreach ($ledger_dc as $i => $ledger)
{
    $dr_amount_item = array(
        'name' => 'dr_amount[' . $i . ']',
        'id' => 'dr_amount[' . $i . ']',
        'maxlength' => '15',
        'size' => '15',
        'readonly' => 'readonly',
		 'class' => 'form-control',
        'value' => isset($dr_amount[$i]) ? $dr_amount[$i] : "",
       
    );
    $cr_amount_item = array(
        'name' => 'cr_amount[' . $i . ']',
        'id' => 'cr_amount[' . $i . ']',
        'maxlength' => '15',
        'readonly' => 'readonly',
		 'class' => 'form-control',
        'size' => '15',
        'value' => isset($cr_amount[$i]) ? $cr_amount[$i] : "",
       
    );
    $ledgerid = array(
        'name' => 'ledger_id[' . $i . ']',
        'id' => 'ledger_id[' . $i . ']',
        'maxlength' => '15',
        'readonly' => 'readonly',
		 'class' => 'form-control',
        'size' => '15',
        'value' => isset($ledger_id[$i]) ? $ledger_id[$i] : "",
       
    );
    $ledgerdc = array(
        'name' => 'ledger_dc[' . $i . ']',
        'id' => 'ledger_dc[' . $i . ']',
        'maxlength' => '15',
        'readonly' => 'readonly',
		 'class' => 'form-control',
        'size' => '15',
        'value' => isset($ledger_dc[$i]) ? $ledger_dc[$i] : "",
       
    );
    if($ledger_id[$i]){
        echo "<tr>";

        echo "<td>" . form_input($ledgerdc) . "</td>";


        echo "<td>" . form_input($ledgerid). "</td>";

        echo "<td>" . form_input($dr_amount_item) . "</td>";
        echo "<td>" . form_input($cr_amount_item) . "</td>";





        echo "</tr>";}
}


									   
									   
									   ?>
                                       
                                       </table>
                                   <div class="form-group  "><label class="col-sm-3 control-label">Narration</label>
										<div class="col-sm-3 " id="taskdata"><? echo form_textarea($entry_narration);

?>
                                       </div></div>  <div class="clearfix"> </div><br>
                                         <div class="form-group  ">
                                        <label class="col-sm-3 control-label" >Tag</label>
										<div class="col-sm-3" id="subtaskdata"><? echo form_dropdown('entry_tag', $entry_ac_tags, $entry_tag);
										echo form_hidden('has_reconciliation', $has_reconciliation);


?>
										</div>
                                        
                                       </div>
                                     	<div class="col-md-12">
											<div class="col-md-3" style="width: 15%;"><button  type="submit" class="btn btn-primary ">Create</button></div>
											<div class="col-md-3" style="width: 15%;"> <a class="btn btn-success "  href=<?echo base_url().'accounts/Payments/index/'.$current_entry_type['label'];?>><i
														class="fa fa-chevron-left nav_icon icon_white"></i>Back</a></div>
										</div></div><br><br><br>
                           </div>
                    </div>
				</form>
                   


                 </div>
                <div class="row calender widget-shadow"  style="display:none">
                    <h4 class="title">Calender</h4>
                    <div class="cal1"></div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
</div>
<?
$this->load->view("includes/footer");
?>








<?php
//file create by udani 12-09-2013
////`refnumber`, `entryid`, `payeecode`, `payeename`, `vouchertype`, `paymentdes`, `amount`, `applydate`, `confirmdate`, `paymentdate`, `paymenttype`, `status`, `confirmby`SELECT * FROM `ac_payvoucherdata` WHERE 1




