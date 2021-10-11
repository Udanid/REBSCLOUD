 <script type="text/javascript">

   
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
 


function loadcurrent_list(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#plandata').delay(1).fadeIn(600);
	 			    document.getElementById("plandata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#plandata" ).load( "<?=base_url()?>re/customerletter/letter_list/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#lotinfomation').delay(1).fadeOut(600);
	 $('#plandata').delay(1).fadeOut(600);
 }
}

 function load_printscrean1(id,type_id)
{
			window.open( "<?=base_url()?>re/customerletter/letter_print/"+id+"/"+type_id );
	
}

 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashier/add_advance" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($searchdata){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Letter Type</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_list(this.value)" id="letter_type" name="letter_type" >
                    <option value=""></option>
                    <?    foreach($searchdata as $row){?>
                    <option value="<?=$row->type_id?>"><?=$row->type?></option>
                    <? }?>
             
					</select> </div>
                          </div><? }?></div>
                          <div id="plandata" >
                            <div class="form-title">
		<h4>
     </h4>
	</div><br />
					 <table class="table"> <thead> <tr>  <th>Leter Type</th><th>Customer Name</th> <th>Reservation Code</th> <th>Loan Number</th> <th>Project and Lot</th>  <th>Letter Create Date </th> <th>Amount</th><th></th></tr> </thead>
                      <? if($datalist1){$c=0;
                          foreach($datalist1 as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                          <td><?=$row->type?></td> 
                        <th scope="row"><?=$row->first_name ?> <?=$row->last_name ?></th> <td><?=$row->res_code?></td><td><?=$row->loan_code?></td> <td><?=$row->project_name?>-<?=$row->lot_number?></td>
                        <td><?=$row->create_date?></td> 
                        <td><?=$row->amount ?></td>
                        <td align="right"><div id="checherflag">
                        <a  href="javascript:load_printscrean1('<?=$row->id?>','<?=$row->letter_type?>')" title="Print"><i class="fa fa-print nav_icon"></i></a>
                               </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                            
							
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>