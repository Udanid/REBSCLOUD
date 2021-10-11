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
	window.print() ;
	window.close();
}
</script>
<body <? if($type=="print"){?>onload="print_function()"<?}?>>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">


		<? if($cusdata){
 		 if($cusdata->id_copy_front!="" && file_exists("./uploads/customer_ids/".$cusdata->id_copy_front)){?>

 		<img style="max-height:377px;" src="<?=base_url()?>uploads/customer_ids/<?=$cusdata->id_copy_front?>" download>
 		<?}?>
 			<? if($cusdata->id_copy_back!="" && file_exists("./uploads/customer_ids/".$cusdata->id_copy_back)){?>

 		<img style="max-height:377px;" src="<?=base_url()?>uploads/customer_ids/<?=$cusdata->id_copy_back?>" download>

 	<? }}?>

</div>
</body>
