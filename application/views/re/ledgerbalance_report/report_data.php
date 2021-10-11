<script src="<?=base_url()?>media/js/dist/Chart.bundle.js"></script>
  								  <script src="<?=base_url()?>media/js/utils.js"></script>
  
<script type="text/javascript">

function load_printscrean1(month,prjid)
{
			window.open( "<?=base_url()?>re/report/get_stock_all_print/"+month);
	
}
function load_lotdetails(id)
{
	$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>re/lotdata/search/"+id );
}
</script>
 <?
 $heading2=' Ledger Balances 	 ';
 
 ?>
 
