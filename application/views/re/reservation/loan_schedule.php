
<script type="text/javascript">

function load_printscrean1(id)
{
			window.open( "<?=base_url()?>re/eploan/print_repayment_schedule/"+id );
	
}

</script>
<script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
</script>
<style>
	.tableFixHead { overflow-y: auto; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
</style>
 <h4>Repayment Schedule of <?=$details->loan_code ?> <span  style="float:right; color:#FFF" ><a href="javascript:load_printscrean1('<?=$details->loan_code ?>')"><i class="fa fa-print nav_icon"></i></a>&nbsp;&nbsp;<a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
<div class="tableFixHead">
<table class="table"> <thead> <tr> <th> Instalment</th> <th>Capital Amount</th> <th>Interest Amount</th> <th>Monthly  Rental</th><th>Due Date</th><th>Paid Capital</th><th>Paid Interest</th><th>Total Payment</th><th>Pay Date</th><th>Pay Status</th></tr> </thead>
                      <? if($dataset){$c=0;
                          foreach($dataset as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->instalment?></th> <td><?=number_format($row->cap_amount,2)?></td> <td><?=number_format($row->int_amount,2) ?></td>
                         <td><?=number_format($row->tot_instalment,2) ?></td> 
                          <td><?=$row->deu_date ?></td> 
                          
                          <td><?=number_format($row->paid_cap,2) ?></td> 
                          <td><?=number_format($row->paid_int,2) ?></td> 
                          <td><?=number_format($row->tot_payment,2) ?></td> 
                            <td><?=$row->pay_date ?></td> 
                      <td><?=$row->pay_status ?></td> 
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
</div>


				            
                                    
                                 <br /></div>