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
function load_fulldetails()
{
	
	 var month=document.getElementById("month").value;
	  var year=document.getElementById("year").value;
	   var branch_code=document.getElementById("branch_code").value;
	     var type=document.getElementById("type").value;
	  
	  if(type!="") 
	  {
		 if( month!="" & year!='')
		 {
			 $('#fulldata').delay(1).fadeIn(600);
				  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
				  if(type=='01')
				  {
				  $( "#fulldata").load( "<?=base_url()?>re/sales/get_target_po/"+month+'/'+year+'/'+branch_code);
				  }
				  if(type=='02')
				  {
					//   alert( "<?=base_url()?>re/sales/get_officer_sales/"+month+'/'+year+'/'+branch_code)
			
				    $( "#fulldata").load( "<?=base_url()?>re/sales/get_officer_sales/"+month+'/'+year+'/'+branch_code);
				  }
				
			 
		 }
		 else
		 {
					 document.getElementById("checkflagmessage").innerHTML='Please Select  Month And yeaer to get Details'; 
			$('#flagchertbtn').click(); 
		}
	  }
	  else
	  {
		  	 document.getElementById("checkflagmessage").innerHTML='Please Select  Type first'; 
			$('#flagchertbtn').click();
	  }
}
function check_this_market()
{

	return true;
}

 </script>
       <form data-toggle="validator" method="post" action="<?=base_url()?>re/sales/add_target_po"  enctype="multipart/form-data">
 
       <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
            <div class="form-body">
                <div class="form-inline">
                <div class="form-group" id="blocklist">
                        <select  name="type" id="type" class="form-control" >
                         <option value="">Select Type</option>
                        <option value="01">Project Forcast</option>
                        <option value="02">Officer Forcast</option>
                      
                        </select>
                    </div>
                    <div class="form-group" id="blocklist">
                          <select class="form-control" placeholder="Qick Search.."    id="branch_code" name="branch_code" o>
                    <? if(check_access('all_branch')){?>
                    <option value="ALL">All Branch</option>
                     <?    foreach($branchlist as $row){?>
                    <option value="<?=$row->branch_code?>" <? ?>><?=$row->branch_name?> </option>
                    <? }?>
                    <? } else {?>
                    <?    foreach($branchlist as $row){if($this->session->userdata('branchid')==$row->branch_code){?>
                    <option value="<?=$row->branch_code?>" <? ?>><?=$row->branch_name?> </option>
                    <? }} }?>
             
             
					</select>
                    </div>
                    <div class="form-group" id="blocklist">
                        <select  name="month" id="month" class="form-control" >
                         <option value="">Select Month</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                        </select>
                    </div>
                  <div class="form-group" id="blocklist">
                      <input type="text" name="year" id="year" value="<?=date('Y')?>"  class="form-control"/>
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="load_fulldetails()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
                <div id="fulldata" style="min-height:100px;"></div>
            </div>
            
        </div>
     </form> 
 <br>    <br />
<br /><br /><br /><br /><br /><br /><br /><br /><br /></p> 
				
				