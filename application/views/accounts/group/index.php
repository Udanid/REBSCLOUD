
<!DOCTYPE HTML>
<html>
<head>


    <?
	$this->load->model('Ledger_model');
    $this->load->view("includes/header_".$this->session->userdata('usermodule'));

    $this->load->view("includes/topbar_accounts");
    ?>
    <script src="<?=base_url()?>media/js/jquery.confirm.js"></script>


    <script type="text/javascript">

        var deleteid="";
      function call_delete(id)
{
		//alert(document.getElementById("deletekey").value);
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 're_eprebate', id: id,fieldname:'rebate_code' },
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


        $(document).ready(function() {
            /* Show and Hide affects_gross */
            $('.group-parent').change(function() {
                if ($(this).val() == "3" || $(this).val() == "4") {
                    $('.affects-gross').show();
                } else {
                    $('.affects-gross').hide();
                }
            });
            $('.group-parent').trigger('change');
        });
		
		function updateOrder(field,id){
			var order = field.value;
			$.ajax({
				cache: false,
				type: 'POST',
				url: '<?php echo base_url().'accounts/group/update_order/';?>',
				data: {id:id, order:order },
				success: function(data) {
					if (data) {
						
					} 
				}
			});
		}
    </script>
    <!-- //header-ends -->
    <!-- main content start-->
    <div id="page-wrapper">
        <div class="main-page">
            <div class="table">
                <h3 class="title1">Ledger Group </h3>
                <?php $this->load->view("includes/flashmessage");?>
                <div class="widget-shadow">
                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <ul id="myTabs" class="nav nav-tabs" role="tablist">
                            <li role="presentation"   class="active" >
                                <a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Group</a></li>
                            <li role="presentation"  >
                                <a href="#home" role="tab" id="home-tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Add Group</a></li>
                        </ul>

                        <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
                            <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                                <p><?  //$this->load->view("accounts/group/get_groups");?> </p>
                                <div class="row">
                                    <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Parent ID</th>
                                                <th>Name</th>
                                                <th>Affect Gross</th>
                                                <th>Listing Order</th>
                                                <th colspan="3"></th>
                                            </tr>
                                            </thead>
                                            <?php

                                            if ($entry_data){
                                            $c=0;
                                            foreach($entry_data as $rowdata){
                                            ?>
                                            <tbody>
                                            <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                                                <th scope="row"><?=$rowdata->id?></th>
                                                <td align="center"><?=$rowdata->parent_id ?></td>
                                                <td> <?=$rowdata->name ?></td>
                                                <td> <?=$rowdata->affects_gross ?></td>
												<td><input type="number" value="<?=$rowdata->group_order?>" name="order<?=$rowdata->id?>"  onKeyUp="updateOrder(this,<?=$rowdata->id?>)" ></td>
                                                <td>
                                                		
                                                    <div id="checher_flag">
                                                    	<a  href="<?=base_url()?>accounts/group/edit/<?=$rowdata->id?>" title="Edit"><i class="fa fa-pencil-square-o nav_icon icon_red"></i></a>
                                                    	<? 	
															$data = $this->Ledger_model->checkLedgersBygroup($rowdata->id);
															$data2 = $this->Ledger_model->getAccgroups($rowdata->id);
															if(!$data2 && !$data){
														?>
                                                    	
                                                        <a  href="javascript:call_delete('<?=$rowdata->id?>')" title="Delete"><i class="fa fa-trash-o nav_icon icon_blue"></i></a>
                                                        <!--                        <a onclick="return confirm('Are you sure you want to delete this Group?');" href="--><?//= base_url() ?><!--accounts/group/delete_group/--><?// echo $rowdata->id ?><!--">-->
                                                        <!--                            <i class="fa fa-trash-o nav_icon icon_blue"></i>-->
                                                        <!-- 
                                                                               </a>-->
                                                        <? }?>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                            <?
                                            }}
                                            ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                               
                            </div>
                            <div role="tabpanel" class="tab-pane fade " id="home" aria-labelledby="home-tab">
                                <p><?   //$this->load->view("accounts/group/add");?> </p>
                                <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/group/add"  enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #ffffff;">
                                            <div class="form-body">
                                                <div class="form-inline">
                                                    <div class="form-group col-md-4" >Group name
                                                        <? echo form_input($group_name); ?>
                                                    </div>
                                                    <div class="form-group col-md-4">Parent Group
                                                        <? echo form_dropdown('group_parent', $group_parent, $group_parent_active, "class = \"group-parent\""); ?>
                                                    </div>
                                                    <?
                                                    echo "<p class=\"affects-gross\">";
                                                    echo "<span id=\"tooltip-target-1\">";
                                                    echo form_checkbox('affects_gross', 1, $affects_gross) . " Affects Gross Profit/Loss Calculations";
                                                    echo "</span>";
                                                    echo "<span id=\"tooltip-content-1\">If selected the Group account will affect Gross Profit and Loss calculations, otherwise it will affect only Net Profit and Loss calculations.</span>";
                                                    echo "</p>";
                                                    ?>
                                                    <div class="clearfix"> </div><br>
                                                    <div class="form-group col-md-4" style="width: 15%;">
                                                        <button  type="submit" class="btn btn-primary ">Create</button>
                                                    </div>
                                                    <div class="clearfix"> </div><br>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>
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
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_advdelete" name="complexConfirm_advdelete"  value="DELETE"></button>
                   
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<form name="deletekeyform" id="deletekeyform"><input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>accounts/group/delete_group/"+document.deletekeyform.deletekey.value;
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