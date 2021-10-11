
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
		<h4>Rental Arrears (Debtor) Summery report 
       <span style="float:right"> </span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
      <div class="tableFixHead">               
      <table class="table table-bordered">
      <thead><tr class="success"><th >Period (Numbre of Months)</th><th >Number of Contracts</th>
      <th> Debtor Balance</th>
         </tr>
         </thead>
         <tbody>
       
      <tr ><td>0 -3 </td><td><?=$arr['3']['contracts']?></td><td><?=number_format($arr['3']['balance'],2)?></td> </tr>
  	  <tr ><td>3 -6 </td><td><?=$arr['6']['contracts']?></td><td><?=number_format($arr['6']['balance'],2)?></td> </tr>
  	  <tr ><td>6 -12 </td><td><?=$arr['12']['contracts']?></td><td><?=number_format($arr['12']['balance'],2)?></td> </tr>
  	  <tr ><td>over 12</td><td><?=$arr['over12']['contracts']?></td><td><?=number_format($arr['over12']['balance'],2)?></td> </tr>
  	  <tr ><td>Period Over</td><td><?=$arr['overP']['contracts']?></td><td><?=number_format($arr['overP']['balance'],2)?></td> </tr>
      <?
       $totalcontracts = $arr['3']['contracts']+$arr['6']['contracts']+$arr['12']['contracts']+$arr['over12']['contracts']+$arr['overP']['contracts'];
       $totalbedtorbalance = $arr['3']['balance']+$arr['6']['balance']+$arr['12']['balance']+$arr['over12']['balance']+$arr['overP']['balance'];
      ?>
      <tr ><td><strong>Total</strong></td><td><strong><?=$totalcontracts?></strong></td><td><strong><?=number_format($totalbedtorbalance,2)?></strong></td> </tr>
        </tbody>
         </table>
         </div></div>
    </div> 
    
</div>