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
<body onLoad="print_function()">
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
 <h4>Repayment Schedule of <?=$details->loan_code ?> <span  style="float:right; color:#FFF" ><a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a><a href="javascript:load_printscrean1('<?=$details->loan_code ?>')"><i class="fa fa-print nav_icon"></i></a></span></h4>
<div class="table widget-shadow">
<table class="table"> <thead> <tr> <th> Instalment</th> <th>Capital Amount</th> <th>Interest Amount</th> <th>Monthly  Rental</th><th>Due Date</th><th>pay Status</th></tr> </thead>
                      <? if($dataset){$c=0;
                          foreach($dataset as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->instalment?></th> <td><?=number_format($row->cap_amount,2)?></td> <td><?=number_format($row->int_amount,2) ?></td>
                         <td><?=number_format($row->tot_instalment,2) ?></td> 
                          <td><?=$row->deu_date ?></td> 
                          <td><?=$row->pay_status ?></td> 
                      
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  



				            
                                    
                                 <br /></div></div></div></body>