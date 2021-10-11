
<script type="text/javascript">

    $(document).ready(function() {
        
        $("#empsearch").chosen({
            allow_single_deselect : true
        });

    });


  
function load_fulldetails()
{
	 var prj_id= document.getElementById("prj_id").value;
	 
	 
	 if(prj_id!="")
	 {
		
	 	 $('#datalist').delay(1).fadeIn(600);
    	  document.getElementById("datalist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		   $( "#datalist").load( "<?=base_url()?>hm/cashier/search_banktrn/"+prj_id);
	 }
	
}
</script>
<form data-toggle="validator" method="post" action="<?=base_url()?>hm/income/search"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">
                    <div class="form-group">
                        <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value="">Branch Name</option>
                    <?    foreach($searchdata as $row){?>
                    <option value="<?=$row->branch_code?>"><?=$row->branch_name?></option>
                    <? }?>
             
					</select>  </div>
                   
                    <div class="form-group">
                        <button type="button" onclick="load_fulldetails()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;" id="datalist">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Entry ID</th>
                <th>Bank</th>
                <th>Narration</th>
                <th>Transfer Amount</th>
                <th>Transfer  Date</th>
                 <th colspan="3"></th>
            </tr>
            </thead>
            <?php

            if ($ac_incomes){
            $c=0;
            foreach($ac_incomes as $rowdata){
            ?>
            <tbody>
            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                <th scope="row"><?=$c?></th>
                <td align="center"><?=$rowdata->trn_entryid ?></td>
                <td> <?=$rowdata->trn_bank ?></td>
                   <td> <?=$rowdata->narration ?></td>
                <td align=right ><?=number_format($rowdata->amount, 2, '.', ',')?></td>
                <td> <?=$rowdata->date ?></td>
         
                        <td>
                            <div id="checher_flag">
                                   <a  href="javascript:check_activeflag('<?=$rowdata->trn_entryid?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                                      <a  href="javascript:call_delete('<?=$rowdata->trn_entryid?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
             
                            </div>
                        </td>

<!--                        <td>-->
<!--                            <a href="javascript:delete_payment('--><?// echo $rowdata->id; ?><!--')"><i-->
<!--                                    class="fa fa-trash-o nav_icon icon_blue"></i></a>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <a href="javascript:confirm_payment('--><?// echo $rowdata->id; ?><!--')"><i-->
<!--                                    class="fa fa-check-square-o nav_icon icon_blue"></i></a>-->
<!--                        </td>-->

            </tr>
            <?
            }}
            ?>
            </tbody>
        </table>

    </div>
</div>