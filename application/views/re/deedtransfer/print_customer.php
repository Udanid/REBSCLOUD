<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<style type="text/css">
body{width:70%;
font-size:90%;
}
.row{
	font-size:80%;
}
.table{
	font-size:100%;
}
</style>
<script type="text/javascript">

function print_function()
{
	window.print();
	//window.close();
}
</script>
<body onLoad="print_function()">

<?
//echo project_expence($details->prj_id);

?>
 <div class="table-responsive bs-example widget-shadow"  >
  <div class="form-title">
		<h4>Customer Reservation Details
      </h4>
	</div>
     <table class="table">
    <tr>
    <th>Customer Name</th><td><?=$current_res->first_name?> <?=$current_res->last_name?></td>
    <th>NIC Number</th><td><?=$cus_data->id_number?></td>
     <th>Telephone</th><td><?=$cus_data->mobile?></td>
   
    </tr>
   
    </table>
    <div class="form-title">
								<h4>Deed Details </h4>
							</div>
   <div class=" widget-shadow " data-example-id="basic-forms"> 
                         
   <table class="table">
    <tr>
    <th >Attest By </th><td colspan="2"> <?=$deed_data->attest_by?></td></tr>
    <tr> <th >Deed Number </th><td> <?=$deed_data->deed_number?></td> <th >Plan Number </th><td> <?=$deed_data->plan_number?></td></tr>
    <tr> <th >Deed Date	 </th><td> <?=$deed_data->deed_date?></td> <th >Land Registry Date </th><td> <?=$deed_data->landr_date?></td></tr>
   <tr> <th >Recieve Date	 </th><td> <?=$deed_data->rcv_date?></td> <th >Hand Over Date </th><td> <?=$deed_data->handover_date?>
   
    </td></tr>
  
 <tr><td colspan="5" align="right">.................................................
 <br>Customer Signature</td></tr>
    </table>
</div>

