<!DOCTYPE HTML>
<html>
<head>

<?
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_accounts");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<script type="text/javascript">

 $( function() {
	 /*$( "#start_date" ).datepicker({dateFormat: 'yy-mm-dd',minDate: -364,onSelect: function(selectedDate) {
		$('#end_date').datepicker('option', 'minDate', selectedDate); //set todate mindate as fromdate
		date = $(this).datepicker('getDate');
		var maxDate = new Date(date.getTime());
		maxDate.setDate(maxDate.getDate() + 364); //add 31 days to from date
		$('#end_date').datepicker('option', 'maxDate', maxDate);
		setTimeout(function() { $('#end_date').focus(); }, 0);
	}});*/
	 //$( "#end_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#yearend_submit').click(function(e){
    	e.preventDefault();
		var $form = $( this ),
    	url = $form.attr( "action" );
    	if(confirm("Do you really want process?"))
    		$('#yearend_form').submit();
  		else
    		return false;
	});
	$("#year_switch").chosen({
       allow_single_deselect : true,
	 	search_contains: true,
		width: '100%',
	 	no_results_text: "Oops, nothing found!",
	 	placeholder_text_single: "Switch Year"
    });
  
  });
  
  	function lockAccounts(year){
	  	if(confirm("Are you sure you want lock "+year+" accounts?"))
    		window.location="<?=base_url()?>accounts/yearend/lock_lastyear/"+year;
  		else
    		return false;
	}
  
function changeAccountsYear(val){
	window.location="<?=base_url()?>accounts/yearend/change_year/"+val;
}
</script>
<button type="button" style="display:none; visibility:hidden;" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<div id="page-wrapper">
 <div class="main-page">
  	<h3 class="title1">Year End Process</h3>
    <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
       <div class="form-body ">
       <? if($this->session->flashdata('msg')){?>
       <div class="alert alert-success" role="alert">
                <?=$this->session->flashdata('msg')?>
        </div><? }?>
        <? if($this->session->flashdata('error')){?>
       <div class="alert alert-danger" role="alert">
                <?=$this->session->flashdata('error')?>
        </div>
		<? }?>
		  <?php
          echo form_open('accounts/yearend', array('id' => 'yearend_form'));
          ?>
           <div class="form-group">
           	  <div class="col-sm-2 ">
                 <input type="text" name="year" id="year" placeholder="Year" readonly value="<?=date('Y',strtotime($this->session->userdata('fy_end')))?>" class="form-control" >
              </div>
              <div class="col-sm-2 ">
                 <input type="text" name="start_date" id="start_date" readonly placeholder="Start Date"  value="<?=date('Y-m-d',strtotime($this->session->userdata('fy_start')))?>"  autocomplete="off" class="form-control" >
              </div>
              
              <div class="col-sm-2 ">
                 <input type="text" name="end_date" id="end_date" readonly placeholder="End Date"  value="<?=date('Y-m-d',strtotime($this->session->userdata('fy_end')))?>"  autocomplete="off" class="form-control" >
              </div>
              <? if($this->session->userdata('usertype')=='admin' || $this->session->userdata('usertype')=='Finance'){?>
              <div class="col-sm-1 ">
                  <button type="submit" id="yearend_submit" class="btn btn-primary ">Continue</button> </div>
              </div>
              <? }
               if($this->session->userdata('usertype')=='admin'){?>
              <div class="col-sm-2 ">
              	  <button type="button" onClick="lockAccounts(<?=date('Y',strtotime($this->session->userdata('fy_end').'-1 year'))?>);" <? if ($year_lock=='1' || $year_lock == ''){?> disabled <? }?> id="yearend_submit" class="btn btn-danger ">Lock Database</button> 
              </div>
              <? }
               if($this->session->userdata('usertype')=='admin' || $this->session->userdata('usertype')=='Finance'){?>
              <div class="col-sm-2 ">
                 <select id="year_switch" name="year_switch" onchange="changeAccountsYear(this.value);">
                      <option></option>
                      <? if($years){
                              foreach($years as $row){
                                  echo '<option '; 
                                  if($row->year == date('Y',strtotime($this->session->userdata('fy_end').'-1 year'))){
                                      echo ' selected ';
                                  }
                                  echo ' value="'.$row->year.'">'.$row->year.'</option>';
                              }
                          }
                      ?>
                      <option value="current">Current Year</option>
                  </select>
              </div>
              </div>
              <? }?>
              <div class="clearfix"> </div>
              <div class="clearfix"> </div><br>	
		   </div> 						
    	<?php
		echo form_close();
		?>
	</div>
   </div>
</div>
<!--footer-->
<?php
	$this->load->view("includes/footer");
?>