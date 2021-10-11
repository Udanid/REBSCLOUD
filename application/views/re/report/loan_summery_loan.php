
<script type="text/javascript">



</script>
<script>
var $th = $('.tableFixHead').find('thead th')
$('.tableFixHead').on('scroll', function() {
  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
});
</script>
<style>
.tableFixHead { overflow-y: auto; height: 500px; }

/* Just common table stuff. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#eee; }
</style> 
 
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>Loan Summery report 
       <span style="float:right"> </span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
      <div class="tableFixHead">               
      <table class="table table-bordered">
     
         <tbody>
       
      <tr ><td>(NEP) Normal Easy payment</td><td><?=$countNEP?></td> </tr>
  	  <tr ><td>(EPZ) Interest Fre  loan</td><td><?=$countZEP?></td> </tr>
  	  <tr ><td>(EPB) Bank loan contracts</td><td><?=$countEPB?></td></tr>
  	  <tr ><td>No Of Settle Contracts</td><td><?=$settled?></td> </tr>
       <tr height="30" ><td></td><td></td> </tr>
       <tr height="30"  class="danger"><td>Current Month Renral Due</td><td><?=number_format($rental,2)?></td> </tr>
         <tr height="30"  class="danger"><td>Debtor Balance</td><td><?=number_format($balance,2)?></td> </tr>
  	 
        </tbody>
         </table>
         </div></div>
    </div> 
    
</div>