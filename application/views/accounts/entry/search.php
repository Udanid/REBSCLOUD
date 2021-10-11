<!DOCTYPE HTML>
<html>
<head>


    <?
    $this->load->view("includes/header_".$this->session->userdata('usermodule'));
    $this->load->view("includes/topbar_accounts");
    ?>
<script type="text/javascript">
$( function() {
    
	 $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});
	  $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
 
});
jQuery(document).ready(function() {
  

	$("#project_id").chosen({
     allow_single_deselect : true
    });
 
 
	
});
function load_blocklist(id)
{
	
 if(id!=""){
	 
							 $('#blocklist').delay(1).fadeIn(600);
    					    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#blocklist" ).load( "<?=base_url()?>accounts/entry/get_blocklist_search/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);
	
 }
}
function load_detailpopup(type,id)
{

				$('#popupform').delay(1).fadeIn(600);
				$( "#popupform" ).load( "<?=base_url()?>accounts/entry/view_popup/"+type+"/"+ id);

}
function closepo()
{
	$('#popupform').delay(1).fadeOut(600);
}
</script>
    <div id="page-wrapper">
        <div class="main-page">
            <div class="table">
                <h3 class="title1">Journal Entry</h3>
                <?php $this->load->view("includes/flashmessage");?>
                <div class="widget-shadow">
                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/entry/search"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
                                    <div class="form-body">
                                        <div class="form-inline">
                                            <div class="form-group">
                        <input type="number" step="0.01" class="form-control" name="amountsearch" id="amountsearch" placeholder="Amount">
                          <input type="hidden"  class="form-control" name="entry_type_id" id="entry_type_id" value="<?=$entry_type_id?>">
                           <input type="hidden"  class="form-control" name="entry_type" id="entry_type" value="<?=$entry_type?>">
                          
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="entry_no" id="entry_no" placeholder="Entry No">
                    </div>
                    <? if($entry_type_id!=7){?>
                    	 <div class="form-group">
                        <select name="project_id" id="project_id" class="form-control"  onchange="load_blocklist(this.value)">
 						<option value="">Project Name</option>
						 <? if($prjlist){
                                foreach($prjlist as $dataraw)
                        {
                                        ?>
                                <option value="<?=$dataraw->prj_id?>"><?=$dataraw->project_name?> </option>
                         <? }}?>

 						</select></div>
                        <div  class="form-group" id="blocklist"></div>
                        <? }else {?>
                         <div class="form-group">
                        <select name="bank_data" id="bank_data" class="form-control" >
 						
						 <option value="ALL">Select Bank Account</option>
                        <? if($banks){foreach($banks as $raw){?>
                            <option value="<?=$raw->id?>" ><?=$raw->ref_id?> - <?=$raw->name?></option>
                        <? }}?>

 						</select></div>
                        
                          <div class="form-group">
                      <input type="text" name="fromdate" id="fromdate" placeholder="From Date" autocomplete="off"  class="form-control" >
                    	</div>
                   	   <div class="form-group">
                      <input type="text" name="todate" id="todate" placeholder="To Date"  autocomplete="off" class="form-control" >
                   		 </div>
                    <? }?>
                                            <div class="form-group">
                                                <button type="submit"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div  class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>No</th>
                                        <th>Ledger Account</th>
                                        <th>Type</th>
                                        <th>Cheque No</th>
                                         <th>Narration</th>
                                        <th>Status</th>
                                        <th>DR Amount</th>
                                        <th>CR Amount</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <?php
                                    $c=0;
                                    foreach ($entry_data->result() as $row)
                                    {
										$ledgername=$this->Ledger_model->get_entry_name($row->id, $row->entry_type);
										if($ledgername!='Audit Dummy Account'){
                                        $current_entry_type = entry_type_info($row->entry_type);
                                    ?>
                                    <tbody>
                                    <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                                        <?

                                        echo "<td>" . $row->date . "</td>";
                                        echo "<td>";?>
	<a href="javascript:load_detailpopup('<?=$current_entry_type['label']?>','<?=$row->id?>')" ><?=$row->id?></a>
                                      <?   echo "<td>";
                                        echo $this->Tag_model->show_entry_tag($row->tag_id);
                                        echo $ledgername;
                                        echo "</td>";

                                        echo "<td>" . $current_entry_type['name'] . "</td>";
                                        echo "<td>" . $row->CHQNO . "</td>";
										 echo "<td>" . $row->narration . "</td>";
                                        echo "<td>" . $row->status . "</td>";
                                        echo "<td align=right>" . number_format($row->dr_total, 2, '.', ',') . "</td>";
                                        echo "<td align=right>" . number_format($row->cr_total, 2, '.', ',') . "</td>";
                                        if($row->status!="CONFIRM")
                                        {
                                            if($current_entry_type['label']=='journal'|| $current_entry_type['label']=='recon'){
                                                ?>
                                                <td>
                                                    <a href=<?echo base_url().'accounts/entry/edit/'.$current_entry_type['label'].'/'.$row->id;?>><i
                                                            class="fa fa-edit nav_icon icon_blue"></i></a>
                                                    <a onclick="return confirm('Are you sure you want to delete this journal Entry?');" href=<?echo base_url().'accounts/entry/delete/'.$current_entry_type['label'].'/'.$row->id;?>><i
                                                            class="fa fa-trash-o nav_icon icon_blue"></i></a>
                                                    <a onclick="return confirm('Are you sure you want to confirm this Journal Entry?');" href=<?echo base_url().'accounts/entry/confirm/'.$current_entry_type['label'].'/'.$row->id;?>><i
                                                            class="fa fa-check-square-o nav_icon icon_blue"></i></a>

                                                </td>
                                                <?
                                            }}
                                        else{
                                            ?><td><?
                                            echo " &nbsp;" . anchor_popup('accounts/entry/print_entry/' . $current_entry_type['label'] . "/" . $row->id , img(array('src' => asset_url() . "images/icons/print.png", 'border' => '0', 'alt' => 'Print ' . $current_entry_type['name'] . ' Entry')), array('title' => 'Print ' . $current_entry_type['name']. ' Entry', 'width' => '600', 'height' => '600')) . " ";
                                            if($row->prj_id==NULL && $row->lot_id==NULL){
					
											?>
												<a onclick="return confirm('Are you sure you want to delete this journal Entry?');" href=<? echo base_url().'accounts/entry/delete/'.$current_entry_type['label'].'/'.$row->id;?>><i class="fa fa-trash-o nav_icon icon_red"></i></a>
											<?
											}
											?>
                                            
                                            </td><?
                                        }

                                        echo "</tr>";
                                    }}
                                    ?>
                                    </tbody>
                                </table>
                                <div id="pagination-container"><?php  //echo $this->pagination->create_links(); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row calender widget-shadow"  style="display:none">
                        <h4 class="title">Calender</h4>
                        <div class="cal1"></div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </div>

    <?
    $this->load->view("includes/footer");
    ?>

