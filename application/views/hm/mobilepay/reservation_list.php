
<!DOCTYPE HTML>
<html>
<head>


    <?
    $this->load->view("includes/header_".$this->session->userdata('usermodule'));

    $this->load->view("includes/topbar_accounts");
    ?>
    <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {


            $("#land_code").chosen({
                allow_single_deselect : true
            });

            $("#bank2").chosen({
                allow_single_deselect : true
            });
            $("#branch2").chosen({
                allow_single_deselect : true
            });



        });

        function check_is_exsit(src)
        {
            var number=src.value.length;
            val=$('input[name=idtype]:checked').val();
            //alert(val);
            document.getElementById("id_type").value=val;
            if(val=='NIC')
            {

                var pattern = /\d\d\d\d\d\d\d\d\d\V|X|Z|v|x|z/;
                var id=src.value;
                var code="";

                if ((id.length == 0))
                {
                    code='Nic Cannot be Blank';
                    //obj.focus();
                }
                else if ((id.match(pattern) == null) || (id.length != 10))
                {
                    //alert(' Please enter a valid NIC.\n');
                    code='Invalid NIC';

                }

                // document.getElementById("myerrorcode").innerHTML=code;

                if (code!="") {
                    //	 alert(data);

                    document.getElementById("id_number").focus();
                    document.getElementById("id_number").setAttribute("placeholder", data);
                    document.getElementById("id_number").setAttribute("error", data);
                    src.value="";
                    document.getElementById("id_type").value=val;

                    document.getElementById("short_description").focus();
                }


            }
        }
        function check_activeflag(id)
        {

            // var vendor_no = src.value;
//alert(id);

            $.ajax({
                cache: false,
                type: 'GET',
                url: '<?php echo base_url().'common/activeflag_cheker/';?>',
                data: {table: 're_projectms', id: id,fieldname:'prj_id' },
                success: function(data) {
                    if (data) {
                        // alert(data);
                        document.getElementById("checkflagmessage").innerHTML=data;
                        $('#flagchertbtn').click();

                        //document.getElementById('mylistkkk').style.display='block';
                    }
                    else
                    {
                        $('#popupform').delay(1).fadeIn(600);
                        $( "#popupform" ).load( "<?=base_url()?>re/project/edit/"+id );
                    }
                }
            });
        }
        function loadlandadata(id)
        {

            if(id!=""){
                $('#landinfomation').delay(1).fadeIn(600);
                document.getElementById("landinfomation").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
                $.ajax({
                    cache: false,
                    type: 'GET',
                    url: '<?php echo base_url().'common/activeflag_cheker/';?>',
                    data: {table: 're_landms', id: id,fieldname:'land_code' },
                    success: function(data) {
                        if (data) {
                            // alert(data);
                            document.getElementById("checkflagmessage").innerHTML=data;
                            $('#flagchertbtn').click();

                            $('#landinfomation').delay(1).fadeOut(600);
                            //document.getElementById('mylistkkk').style.display='block';
                        }
                        else
                        {

                            $( "#landinfomation" ).load( "<?=base_url()?>re/project/landinformation/"+id );
                        }
                    }
                });
            }
            else
            {
                $('#landinfomation').delay(1).fadeOut(600);
            }
        }
        function call_comment(id)
        {
            $('#popupform').delay(1).fadeIn(600);
            $( "#popupform" ).load( "<?=base_url()?>re/project/comments/"+id );
        }
        function close_edit(id)
        {

            // var vendor_no = src.value;
//alert(id);

            $.ajax({
                cache: false,
                type: 'GET',
                url: '<?php echo base_url().'common/delete_activflag/';?>',
                data: {table: 're_projectms', id: id,fieldname:'prj_id' },
                success: function(data) {
                    if (data) {
                        $('#popupform').delay(1).fadeOut(800);

                        //document.getElementById('mylistkkk').style.display='block';
                    }
                    else
                    {
                        document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin ';
                        $('#flagchertbtn').click();

                    }
                }
            });
        }
        var deleteid="";
        function call_delete(id)
        {
            document.deletekeyform.deletekey.value=id;
            $.ajax({
                cache: false,
                type: 'GET',
                url: '<?php echo base_url().'common/activeflag_cheker/';?>',
                data: {table: 're_projectms', id: id,fieldname:'prj_id' },
                success: function(data) {
                    if (data) {
                        // alert(data);
                        document.getElementById("checkflagmessage").innerHTML=data;
                        $('#flagchertbtn').click();

                        //document.getElementById('mylistkkk').style.display='block';
                    }
                    else
                    {
                        $('#complexConfirm').click();
                    }
                }
            });


//alert(document.testform.deletekey.value);

        }

        function call_confirm(id)
        {
            document.deletekeyform.deletekey.value=id;
            $.ajax({
                cache: false,
                type: 'GET',
                url: '<?php echo base_url().'common/activeflag_cheker/';?>',
                data: {table: 're_projectms', id: id,fieldname:'prj_id' },
                success: function(data) {
                    if (data) {
                        // alert(data);
                        document.getElementById("checkflagmessage").innerHTML=data;
                        $('#flagchertbtn').click();

                        //document.getElementById('mylistkkk').style.display='block';
                    }
                    else
                    {
                        $('#complexConfirm_confirm').click();
                    }
                }
            });


//alert(document.testform.deletekey.value);

        }
        function loadbranchlist(itemcode,caller)
        {
            var code=itemcode.split("-")[0];
//alert("<?=base_url().$searchpath?>/"+code)
            if(code!=''){
                //alert(code)
                //$('#popupform').delay(1).fadeIn(600);
                $( "#branch-"+caller ).load( "<?=base_url()?>common/get_bank_branchlist/"+itemcode+"/"+caller );}

        }



        function  calculate_arc(val)
        {
            if(val>0)
            {
                var arc=val/160;
                document.getElementById('project_arc').value=arc;
            }
            else
                document.getElementById('project_arc').value=0.00;
        }
        function  calculate_tot(val)
        {

            var unselabletot=parseFloat(document.getElementById('road_ways').value)+parseFloat(document.getElementById('other_res').value)+parseFloat(document.getElementById('open_space').value)+parseFloat(document.getElementById('unselable_area').value);
            var seleble=parseFloat(document.getElementById('land_extend').value)-unselabletot;
            document.getElementById('selable_area').value=seleble;
            //alert(seleble);


        }
    </script>

    <!-- //header-ends -->
    <!-- main content start-->
    <div id="page-wrapper">
        <div class="main-page">

            <div class="table">
                <h3 class="title1">Mobile Reservation Requests</h3>

                <div class="widget-shadow">

                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <div class="clearfix"> </div>

                        <ul id="myTabs" class="nav nav-tabs" role="tablist">
                         <?php $this->load->view("includes/flashmessage");?>
                            <li role="presentation"   class="active" >
                                <a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Payments</a></li>
                            <!--                            <li role="presentation"  >-->
                            <!--                                <a href="#home" role="tab" id="home-tab" data-toggle="tab" aria-controls="home" aria-expanded="true">New Payment Entry</a></li>-->
                            <!--          <li role="presentation">-->
                            <!--          <a href="#value" id="value-tab" role="tab" data-toggle="tab" aria-controls="value" aria-expanded="false">Add Supplier Payment Voucher</a></li>-->
<!--                            <li role="presentation">-->
<!--                                <a href="#budget" id="budget-tab" role="tab" data-toggle="tab" aria-controls="budget" aria-expanded="false">Cheque Printer Queue</a></li>-->
                        </ul>

                        <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
                            <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                                <p><div class="row">
    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;" id="datalist">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Project Name</th>
                <th>Lot Number</th>
                 <th>Customer Name</th>
                  <th>NIC</th>
                   <th>Pay Amount</th>
                    <th>Reservation Date</th>
               
                <th>Status</th>
                <th colspan="3"></th>
            </tr>
            </thead>
            <?php
		$ci =&get_instance();
			$ci->load->model('mobilepay_model');
            if ($ac_incomes){
            $c=0;
            foreach($ac_incomes as $rowdata){
			//	$bank_code = $ci->mobilepay_model->get_project_payment_data_by_code($rowdata->loanId);
				$mydate=date('Y-m-d',strtotime($rowdata->timestamp));
            ?>
            <tbody>
            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                <th scope="row"><?=$rowdata->res_id?></th>
                <td align="center"><?=$rowdata->project_name ?></td>
                
                    <td align=right ><?=$rowdata->lot_number?></td>
                      <td align=right ><?=$rowdata->customer_name?></td>
                <td align=right ><?=$rowdata->nic?></td>
                 <td align="center"><?=number_format($rowdata->amt,2)?></td>
                <td> <?=$mydate?></td>
                <td> <?=$rowdata->status?></td>

                        <td>
                            <div id="checher_flag">
                         
                                 <? if($rowdata->status=='PENDING'){?>
                                <a href="javascript:call_confirm('<?=$rowdata->res_id?>')">
                                    <i class="fa fa-plus-square-o nav_icon icon_blue"></i>
                                </a>
                                <? }?>
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
</div> </p>
                            </div>
                            <!--                            <div role="tabpanel" class="tab-pane fade " id="home" aria-labelledby="home-tab">-->
                            <!--                                <p>--><?//  //$this->load->view("accounts/paymentvouchers/add");?><!-- </p>-->
                            <!--                            </div>-->
                          


                          

                        </div>
                    </div>
                </div>
            </div>

<div class="col-md-4 modal-grids">
                <button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
                <div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4>
                            </div>
                            <div class="modal-body" id="checkflagmessage"> Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_cancel" name="complexConfirm_cancel"  value="DELETE"></button>
            <form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
            </form>
            <script>
                $("#complexConfirm").confirm({
                    title:"Delete confirmation",
                    text: "Are You sure you want to delete this ?" ,
                    headerClass:"modal-header",
                    confirm: function(button) {
                        button.fadeOut(2000).fadeIn(2000);
                        var code=1
                        window.location="<?=base_url()?>accounts/entrymaster/delete/"+document.deletekeyform.deletekey.value;
                    },
                    cancel: function(button) {
                        button.fadeOut(2000).fadeIn(2000);
                        // alert("You aborted the operation.");
                    },
                    confirmButton: "Yes I am",
                    cancelButton: "No"
                });

                $("#complexConfirm_confirm").confirm({
                    title:"Record confirmation",
                    text: "Are You sure you want to confirm this ?" ,
                    headerClass:"modal-header confirmbox_green",
                    confirm: function(button) {
                        button.fadeOut(2000).fadeIn(2000);
                        var code=1

                        window.location="<?=base_url()?>accounts/mobilepay/confirm_res/"+document.deletekeyform.deletekey.value;
                    },
                    cancel: function(button) {
                        button.fadeOut(2000).fadeIn(2000);
                        // alert("You aborted the operation.");
                    },
                    confirmButton: "Yes I am",
                    cancelButton: "No"
                });
                $("#complexConfirm_cancel").confirm({
                    title:"Record confirmation",
                    text: "Are You sure you want to cancel this ?" ,
                    headerClass:"modal-header",
                    confirm: function(button) {
                        button.fadeOut(2000).fadeIn(2000);
                        var code=1

                        window.location="<?=base_url()?>accounts/entrymaster/cancel/"+document.deletekeyform.deletekey.value;
                    },
                    cancel: function(button) {
                        button.fadeOut(2000).fadeIn(2000);
                        // alert("You aborted the operation.");
                    },
                    confirmButton: "Yes I am",
                    cancelButton: "No"
                });
            </script>







            <div class="row calender widget-shadow"  style="display:none">
                <h4 class="title">Calender</h4>
                <div class="cal1">

                </div>
            </div>



            <div class="clearfix"> </div>
        </div>
    </div>
    <!--footer-->
<?
$this->load->view("includes/footer");
?>