<script type="text/javascript">
function expoet_excel(prjid)
{
		
		
				window.open( "<?=base_url()?>re/stampfee/report_fulldata_excel/"+prjid);
}
</script>
<script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
</script>
<style>
	.tableFixHead { overflow-y: auto; height: 600px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
</style>
 <div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
    <div class="form-title">
		<h4>Deed Report 
       <span style="float:right"> <a href="javascript:expoet_excel('<?=$prj_id?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
  <div class="table-responsive bs-example widget-shadow">
    <div class="tableFixHead">            
      <table class="table table-bordered">  <thead> <tr > <th rowspan="2">Project Name</th> <th rowspan="2">Lot Number</th> <th rowspan="2">Instruction Received Date </th> 
  <th colspan="4">Stamp Fees</th><th colspan="7">Deed Details</th><th colspan="3">Informed Details</th><th colspan="4">Deed Issued Details</th></tr>
                  <tr><th>Payable Amount </th> <th>Amount</th> <th>Request Date</th> <th>Paid Date</th><th>Lawyer</th><th>Deed Date</th>
                  <th> Deed No</th> <th>LR Date</th> <th> Daybook no.</th> <th> Received Date</th> <th>Registed Porlio</th> <th>Date</th> <th> By</th><th> Method</th><th> Date</th><th> Issued By</th><th> Issued to</th><th> Remark</th></tr> </thead>
                      <? $list=''; if($blocklist){$c=0;$list='';$prj_name='';
                          foreach($blocklist as $row){ ?>
                      <? if($prj_name!='' & $prj_name!=$row->project_name){?>
                      <tr><td colspan="21" class="danger">&nbsp;</td></tr>
                      <? } $prj_name=$row->project_name;?>
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->project_name?></th> <td><?=$row->lot_number?></td> 
                        <td><?=$row->form_confirm_date?></td>
                        <td align="right"><?=number_format($row->stamp_duty,2)?>
                        
                        </td> 
                        <td align="right"><?=number_format($row->full_amount,2)?>
                        
                        </td> 
                          <td><?=$row->need_date?></td>
                          <td><?=$row->paymend_dondate?></td>
                          
                           <td><?=$row->attest_by?></td>
                           <td><?=$row->deed_date?></td>
                           <td><?=$row->deed_number?></td>
                           <td><?=$row->landr_date?></td>
                           <td><?=$row->day_book_no?></td>
                            <td><?=$row->rcv_date?></td>
                           <td><?=$row->register_portfolio?></td>
                           
                           <td><?=$row->informed_date?></td>    
                            <td><?=get_user_fullname_id($row->inform_by)?></td> 
                             <td><?=$row->informed_method?></td>  
                      
                      
                      <td><?=$row->issue_date?></td>    
                            <td><?=get_user_fullname_id($row->inform_by)?></td> 
                             <td><?=$row->issue_to?></td>  
                               <td><?=$row->remark?></td>  
                        <td></td>
                         </tr> 
                        
                                <? }} ?>
                                
                          </tbody></table></div></div></div></div>