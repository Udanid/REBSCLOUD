
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

                        $('#popupform').delay(1).fadeIn(600);
                        $( "#popupform" ).load( "<?=base_url()?>hm/cashier/search_entry/"+id );
                  
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
       


        
    </script>

    <!-- //header-ends -->
    <!-- main content start-->
    <div id="page-wrapper">
        <div class="main-page">

            <div class="table">
                <h3 class="title1">Bank Deposits </h3>

                <div class="widget-shadow">

                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <div class="clearfix"> </div>

                        <ul id="myTabs" class="nav nav-tabs" role="tablist">
                            <li role="presentation"   class="active" >
                                <a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Bank Transfer List</a></li>
                                                    <li role="presentation"  >
                                                          <a href="#home" role="tab" id="home-tab" data-toggle="tab" aria-controls="home" aria-expanded="true">New Fund Transfer</a></li>
                            <!--          <li role="presentation">-->
                            <!--          <a href="#value" id="value-tab" role="tab" data-toggle="tab" aria-controls="value" aria-expanded="false">Add Supplier Payment Voucher</a></li>-->
<!--                            <li role="presentation">-->
<!--                                <a href="#budget" id="budget-tab" role="tab" data-toggle="tab" aria-controls="budget" aria-expanded="false">Cheque Printer Queue</a></li>-->
                        </ul>

                        <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
                            <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                                <p><?  $this->load->view("accounts/banktrn/banktrn_list");?> </p>
                            </div>
                       <div role="tabpanel" class="tab-pane fade " id="home" aria-labelledby="home-tab">
                          <p><?  $this->load->view("accounts/banktrn/banktrn_new");?> </p>
                                                    </div>
                          

                            

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
                            <div class="modal-body" id="checkflagmessage">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_cancel" name="complexConfirm_cancel"  value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_cancelCheque" name="complexConfirm_cancelCheque"  value="DELETE"></button>
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
                        window.location="<?=base_url()?>hm/cashier/delete_entry/"+document.deletekeyform.deletekey.value;
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

                        window.location="<?=base_url()?>hm/payments/confirm/"+document.deletekeyform.deletekey.value;
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

                        window.location="<?=base_url()?>hm/payments/cancelation/"+document.deletekeyform.deletekey.value;
                    },
                    cancel: function(button) {
                        button.fadeOut(2000).fadeIn(2000);
                        // alert("You aborted the operation.");
                    },
                    confirmButton: "Yes I am",
                    cancelButton: "No"
                });
                $("#complexConfirm_cancelCheque").confirm({
                    title:"Record confirmation",
                    text: "Are You sure you want to cancel this ?" ,
                    headerClass:"modal-header",
                    confirm: function(button) {
                        button.fadeOut(2000).fadeIn(2000);
                        var code=1

                        window.location="<?=base_url()?>hm/payments/cancelation_cheque/"+document.deletekeyform.deletekey.value;
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