
<script type="text/javascript">
	$( function() {
	  $( "#start_date" ).datepicker({dateFormat: 'yy-mm-dd',onSelect: function(selectedDate) {
		  	$('#end_date').datepicker('option', 'minDate', selectedDate); //set todate mindate as fromdate
		 	 date = $(this).datepicker('getDate');
		  	var maxDate = new Date(date.getTime());
		  	maxDate.setMonth(maxDate.getMonth() + 1); //add 31 days to from date
		  	$('#end_date').datepicker('option', 'maxDate', maxDate);
		  	setTimeout(function() { $('#end_date').focus(); }, 0);
	  		}
		});
	   	$( "#end_date" ).datepicker({dateFormat: 'yy-mm-dd'});

	} );

    $(document).ready(function() {

        $("#search_payment").click(function(){

            //var empsearch = document.getElementById('empsearch').value;
            var empsearch = $('#empsearch').val();
            var search = $('#search').val();
            var amountsearch = $('#amountsearch').val();
            //alert(empsearch);

            $.ajax({
                cache: false,
                type: 'POST',
                url: '<?php echo base_url().'accounts/paymentvouchers/search';?>',
                data: {empsearch: empsearch,search:search,amountsearch:amountsearch},
                dataType:'html',
                success: function(data) {

                    if (data) {
//                            $.each(data.ac_projects, function(ac_projects) {
                        console.log(data);
//                            });
                    }
                }

            });
        });

        $("#empsearch").chosen({
            allow_single_deselect : true
        }); 

    });

    $(window).load(function(){
     $("#prj_id").chosen({
            allow_single_deselect : true,
            search_contains: true,
            no_results_text: "Oops, nothing found!",
            placeholder_text_single: "Project Name"
        });
    });

   

    function confirm_payment(id) {
        var r=confirm("Are you sure you want to confirm this payment voucher?")
        if (r==true)
        {
            $.ajax({
                cache: false,
                type: 'POST',
                url: '<?php echo base_url().'accounts/paymentvouchers/confirm';?>',
                data: {id: id },
                success: function(data) {
                    if (data) {
                        alert(data);
                        location.reload();
                        //alert("delete success");
                    }
                    else
                    {
                        alert("confirm failed");
                    }
                }
            });
        }
    }


    function close_edit(id)
    {
        $.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/delete_activflag/';?>',
            data: {table: 'ac_payvoucherdata', id: id,fieldname:'voucherid' },
            success: function(data) {
                if (data) {
                    $('#popupform').delay(1).fadeOut(800);

                    //document.getElementById('mylistkkk').style.display='block';
                }
                else
                {
                    document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin ';
                    $('#mylistkkk').click();

                }
            }
        });
    }

	function generateExcel(){
		var start_date = $('#start_date').val();
		var end_date = $('#end_date').val();
		var name = $('#name').val();
		window.location="<?=base_url()?>accounts/report/download/payments/"+start_date+"/"+end_date+"/"+name;
	}

</script>


    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
            <div class="form-body">
            	<form data-toggle="validator" method="post" action="<?=base_url()?>accounts/payments/search"  enctype="multipart/form-data">
                    <div class="form-inline col-md-7">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name" autocomplete="off" placeholder="Payee Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="entry_no" id="entry_no" autocomplete="off" placeholder="Entry Number">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="amountsearch" id="amountsearch" autocomplete="off" placeholder="Amount">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="cheque_no" id="cheque_no" autocomplete="off" placeholder="Cheque No">
                        </div>

                        <div class="form-group">
                           <select class="form-control" placeholder="Qick Search.." id="prj_id" name="prj_id" >
                                <option value=""></option>
                                <?foreach($prj_list as $row){?>
                                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                                 <? }?>
                             </select>
                        </div>

                        <div class="form-group">
                            <button  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                        </div>
                     </div>
 				</form>
                 <div class="form-inline col-md-5">
                     <div class="form-group">
                        <input type="text" class="form-control" name="start_date" id="start_date" autocomplete="off" placeholder="Start Date">
                    </div>
                     <div class="form-group">
                        <input type="text" class="form-control" name="end_date" id="end_date" autocomplete="off" placeholder="End Date">
                    </div>
                    <div class="form-group">
                        <button  id="generate_excel" onclick="generateExcel();" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Generate Excel Report</button>
                    </div>
                </div>

            </div>
        </div>
    </div>


<div class="row">
    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
        <table class="table">
            <thead>
            <tr>
                <th>Date</th>
                <th>No</th>
                 <th>Payee Name</th>
                 <th>Project Name</th>
                <th>Narration</th>
                 <th>Bank</th>
                <th>Cheque No</th>
                <th>Voucher No</th>
                <th>Amount</th>
                 <th>Confirmed By</th>
                <th>Cheque Status</th>

                <th colspan="3"></th>
            </tr>
            </thead>
            <tbody>
            <?
            $c=0;
		    foreach ($entry_data->result() as $row)
            {
                $current_entry_type = entry_type_info($row->entry_type);
            ?>
                <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                    <td><? echo $row->date; ?></td>
                    <? echo "<td>" . anchor('accounts/payments/view/' . $current_entry_type['label'] . "/" . $row->id, full_entry_number($row->entry_type, $row->number), array('title' => 'View ' . $current_entry_type['name'] . ' Entry', 'class' => 'anchor-link-a')) . "</td>";
                    echo "<td>";
                 	echo $row->CHQNAME;
					echo "</td><td>";
					echo get_voucher_by_entry($row->id);
 					echo "</td><td>";
				 	echo $this->Tag_model->show_entry_tag($row->tag_id);

                    echo  $row->narration;
                    echo "</td>";
					echo "<td>";
                 echo $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
                echo "</td>";
                    ?>
                    <td><? echo $row->CHQNO; ?></td>
                      <td><? echo get_voucher_ncode($row->id); ?></td>
                    <td align=right><? echo number_format($row->dr_total, 2, '.', ','); ?></td>
                     <td align=right><? echo get_user_fullname_id($row->confirm_by); ?></td>

                    <?
                    echo "<td align='center'>" ;if($row->CHQSTATUS)echo $row->CHQSTATUS; else echo $row->status ;echo "</td>";
                    if( $row->CHQSTATUS=="QUEUE" || $row->status=="PENDING") {
                        ?>
                        <td>
                            <a href="<?= base_url() ?>accounts/payments/edit/<? echo $row->id ?>">
                                <i class="fa fa-edit nav_icon icon_blue"></i>
                            </a>
<!--                            <a onclick="return confirm('Are you sure you want to delete this Payment Entry?');" href="--><?//= base_url() ?><!--accounts/payments/delete/--><?// echo $row->id ?><!--"-->
<!--                               class="confirmClick">-->
<!--                                <i class="fa fa-trash-o nav_icon icon_blue"></i>-->
<!--                            </a>-->
                            <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-trash-o nav_icon icon_blue"></i></a>
<!--                            <a onclick="return confirm('Are you sure you want to confirm this Payment Entry?');" href="--><?//= base_url() ?><!--accounts/payments/confirm/--><?// echo $row->id ?><!--"-->
<!--                               class="confirmClick">-->
<!--                                <i class="fa fa-check-square-o nav_icon icon_blue"></i>-->
<!--                            </a>-->
  				<? if ( check_access('confirm vouchers'))

                    { ?>
                            <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check-square-o nav_icon icon_blue"></i></a>
					<? }?>
                        </td>
                    <?
                    }
                    if( $row->CHQSTATUS=="PRINT"){
                        ?>
                        <td>
<!--                            <a onclick="return confirm('Are you sure you want to cancel this Payment Entry?');" title="Cancel" href="--><?//= base_url() ?><!--accounts/payments/cancelation/--><?// echo $row->id ?><!--">-->
<!--                                <i class="fa fa-times nav_icon icon_red"></i>-->
<!--                            </a>-->
                            <a  href="javascript:call_cancel('<?=$row->id?>')" title="Cancel Payment"><i class="fa fa-times nav_icon icon_red"></i></a>
                            <a  href="javascript:call_cancel_cheque('<?=$row->id?>')" title="Cancel Cheque"><i class="fa fa-times nav_icon icon_blue"></i></a>
<!--                            <a onclick="return confirm('Are you sure you want to cancel cheque?');" title="Cancel Cheque" href="--><?//= base_url() ?><!--accounts/payments/cancelation_cheque/--><?// echo $row->id ?><!--">-->
<!--                                <i class="fa fa-times nav_icon icon_blue"></i>-->
<!--                            </a>-->
                            <?
                        //    echo "" . anchor('accounts/payments/printpreview/'. $row->id , img(array('src' => asset_url() . "images/icons/print.png", 'border' => '0', 'alt' => 'Re Print ' . $current_entry_type['name'] . ' Entry')), array('title' => 'Reprint  Cheque ' . $row->CHQNO, 'target' => '_blank')) ;
                            ?>
														<? if($this->session->userdata('usertype')=='admin' || $this->session->userdata('usertype')=='Account_Executive And HR' || $this->session->userdata('usertype')=='SENIOR ACCOUNTANT'){?>
														<a href="<?= base_url() ?>accounts/payments/edit/<? echo $row->id ?>">
																<i class="fa fa-edit nav_icon icon_blue"></i>
														</a>
													<? }?>
                        </td>
                    <?
                        }
                    if($this->session->userdata('user_role')=='manager' & $row->CHQSTATUS=="CONFIRM")
                    {
                        ?>
                        <td>
                            <a href="<?= base_url() ?>accounts/payments/edit/<? echo $row->id ?>">
                                <i class="fa fa-edit nav_icon icon_red"></i>
                            </a>
                        </td>
                    <?
                    }
                    ?>
                </tr>
            <?
            }
	        ?>
            </tbody>
        </table>
         <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>

    </div>
</div>
