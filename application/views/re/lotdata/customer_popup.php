
<script type="text/javascript">

function load_printscrean1(id,prjid)
{
			window.open( "<?=base_url()?>re/lotdata/print_inquary/"+id+"/"+prjid );

}
function get_loan_detalis(id)
{

		// var vendor_no = src.value;
//alert(id);


					$('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );

}
function get_charge_details(id)
{

		// var vendor_no = src.value;
//alert(id);


					$('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>re/reservation/get_chargerfulldata/"+id );

}

</script>
<h4>Customer Details
       <span style="float:right"> <a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a>
</span></h4>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">


   <? if($cusdata){?>


     <table class="table">
   <tr>
   <th colspan="2" class="info">Personal Information</th></tr><tr>
   <tbody style="font-size:12px">
    <th>Customer Name</th><td><?=$cusdata->title?> <?=$cusdata->first_name?> <?=$cusdata->last_name?></td></tr>
       <tr><th>Full Name</th><td><?=$cusdata->full_name?></td></tr>
       <tr> <th>Address</th><td><?=$cusdata->address1?>, <?=$cusdata->address2?>, <?=$cusdata->address3?></td></tr>
        <tr><th>Telephone Number</th><td><?=$cusdata->landphone?></td></tr>
          <tr><th>Mobile Number</th><td><?=$cusdata->mobile ?></td></tr>
            <tr><th>Email</th><td><?=$cusdata->email  ?></td></tr>
             <tr><th>NIC Number</th><td><?=$cusdata->id_number  ?></td></tr>

    </tbody>

    </table>
		<div id="nicimg">
			<? $img_val=0;
			if($cusdata->id_copy_front!="" && file_exists("./uploads/customer_ids/".$cusdata->id_copy_front)){?>
				<a href="<?=base_url()?>uploads/customer_ids/<?=$cusdata->id_copy_front?>" title="View NIC" download>
					<img style="max-height:120px;" src="<?=base_url()?>uploads/customer_ids/<?=$cusdata->id_copy_front?>" target="_blank">
				</a>
			<? }else{?>
				NIC Front Image Not Uploaded.
			<?}?>
				<? if($cusdata->id_copy_back!="" && file_exists("./uploads/customer_ids/".$cusdata->id_copy_back)){?>
				<a href="<?=base_url()?>uploads/customer_ids/<?=$cusdata->id_copy_back?>" title="View NIC" download>
					<img style="max-height:120px;" src="<?=base_url()?>uploads/customer_ids/<?=$cusdata->id_copy_back?>" target="_blank"></a>

				<? }else{?>
				</br>NIC Back Image Not Uploaded.
				<?}?>
				<? if(($cusdata->id_copy_back!="" || $cusdata->id_copy_front!="") && (file_exists("./uploads/customer_ids/".$cusdata->id_copy_front) || file_exists("./uploads/customer_ids/".$cusdata->id_copy_back)))
				{
					?>
					<a href="javascript:view_customer_nic('<?=$cusdata->cus_code?>','print')" title="View NIC"><i class="fa fa-print nav_icon "></i></a>

				<?}?>
	</div>
    <? if( $type!='Outright' || $type!='Pending'){?>
      <table class="table">
       <tr>
     <th colspan="4" class="info">Credit Customer Information</th></tr>
     <tr><td colspan="4" height="10"></td></tr>
     <tr style="font-size:14px">

     <th colspan="2" class="active">Employment Details</th>
      <th colspan="2" class="active">Marital Details</th></tr>
          <tbody style="font-size:12px">

      <tr><th>Profession</th><td><?=$cusdata->profession ?></td>
      <th>Marital Status</th><td><?=$cusdata->civil_status ?></td>
      </tr>
       <tr><th>Occupation</th><td><?=$cusdata->occupation ?></td>
      <th>Spouse Name</th><td><?=$cusdata->spause_name ?></td>
      </tr>
       </tr>
       <tr><th>Business Address</th><td><?=$cusdata->business_add ?></td>
      <th>Spouse Income</th><td><?=$cusdata->spause_income ?></td>
      </tr>
       </tr>
       <tr><th>Business Telephone</th><td><?=$cusdata->bussiness_tell ?></td>
      <th>Dependants</th><td><?=$cusdata->dependent  ?></td>
      </tr></tbody>
      <tr style="font-size:14px">

     <th colspan="2" class="active">Income Details</th>
      <th colspan="2" class="active">Property Details</th></tr>
     </tr>
           <tbody style="font-size:12px">

      <tr><th>Monthly Income</th><td><?=$cusdata->monthly_incom ?></td>
      <th>Movable Property</th><td><?=$cusdata->moveable_property ?></td>
      </tr>
       <tr><th>Marital Expenses</th><td><?=$cusdata->monthly_expence ?></td>
      <th>Immovable Property</th><td><?=$cusdata->imovable_property  ?></td>
      </tr>
       </tr>
       <tr><th>Tax Details</th><td><?=$cusdata->tax_details ?></td>
      </tr>
     </tbody>
     </table>

    <? }?>


         <? if($followlist){?>
           <table class="table">
       <tr>
     <th colspan="4" class="info">Followup Details</th></tr>
     <tr><td colspan="4" height="10"></td></tr>
          <tbody style="font-size:12px">
   <tr class="active"><th>Date</th><th>Action</th><th>Agreement Code</th><th>Agreement Code</th><th>Arrears</th><th>Sales Person</th></tr>
     <? foreach($followlist as $raw){?>
     <tr>
     <td><?=$raw->follow_date ?></td>
      <td><?=$raw->sales_feedback  ?></td>
       <td><?=$raw->loan_code  ?></td>
         <td><?=$raw->todate_arreas  ?></td>
          <td><?=$raw->initial  ?> <?=$raw->surname  ?></td>
     </tr>

         <? }?>

         </tbody></table>
         <?


		 }?>
          <table class="table"> <thead>
           <th colspan="11" class="info">All Reservation Summery</th></tr>
            <tr> <th>Reservation Code</th><th>Branch Name</th><th>Project Name</th><th>Lot Number</th> <th>Customer Name </th><th>Reserve Date</th><th>Discount</th><th>Sale Value</th><th>MDP</th><th>Paid Amount</th><th>Reservation Status</th></tr> </thead>
                      <?  $prjes=0;$prjdis=0;$prjsale=0; $prjmdp=0;$prjpaid=0;$prjbmdp=0;
					  $brnes=0;$brndis=0;$brnsale=0; $brnmdp=0;$brnpaid=0;$brnbmdp=0;
					  $prj_id=''; $brid='';
					  if($reservationlist){$c=0;
                          foreach($reservationlist as $row){
							 ?>

                             <tr >
                        <td scope="row"><?=$row->res_code?></td><td scope="row"><?=get_branch_name($row->branch_code)?></td><td> <?=$row->project_name ?></td><td> <?=$row->lot_number ?>-<?=$row->plan_sqid ?></td> <td><?=$row->first_name ?> <?=$row->last_name ?></td> <td><?=$row->res_date?></td>

                           <td><?=number_format($row->discount,2)?></td>
                        <td><?=number_format($row->discounted_price,2)?></td>

                        <td align="right"><?=number_format($row->min_down,2)?></td>
                        <td align="right"><?=number_format($row->down_payment,2)?></td>
                          <td align="right"><?=$row->res_status?></td>
                         </tr>
                             <? }}?>

    <? }?>

		<? if($docdata){?>
			<table class="table">
	<tr>
<th colspan="4" class="info">Followup Details</th></tr>
<tr><td colspan="4" height="10"></td></tr>
		 <tbody style="font-size:12px">
<tr class="active"><th>Document Type</th><th>Document</th></tr>
<? foreach($docdata as $raw){?>
<tr>
<td><?=$raw->document_name ?></td>
 <td><?=$raw->document  ?>
 </br>
 <a href="<?=base_url()?>/uploads/customer_docs/<?=$raw->document?>" target="_blank" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>

 </td>
</tr>
		<? }?>
		</tbody></table>
		<?
}?>
    </div>
</div>
