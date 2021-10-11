 <script type="text/javascript">

   
 function load_printscrean1(id,type_id)
{
			window.open( "<?=base_url()?>re/customerletter/letter_print/"+id+"/"+type_id );
	
}


 </script>
 
 
  <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

    <div class="form-title">
		<h4><?=$type_name?>
     </h4>
	</div><br />
					 <table class="table"> <thead> <tr> <th>Customer Name</th> <th>Reservation Code</th> <th>Project and Lot</th>  <th>Letter Create Date </th><th>Print Status </th> <th>Print Date</th><th></th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->first_name ?> <?=$row->last_name ?></th> <td><?=$row->res_code?></td> <td><?=$row->project_name?>-<?=$row->lot_number?></td>
                        <td><?=$row->create_date?></td> 
                         <td><?=$row->print_status?></td> 
                        <td><?=$row->print_date ?></td>
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:load_printscrean1('<?=$row->id?>','<?=$type_id?>')" title="Reprint"><i class="fa fa-print nav_icon"></i></a>
                               </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                            
                          
</div>
</div>
