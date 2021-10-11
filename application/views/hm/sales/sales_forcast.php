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
					$( "#plandata" ).load( "<?=base_url()?>hm/customerletter/letter_list/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#lotinfomation').delay(1).fadeOut(600);
	 $('#plandata').delay(1).fadeOut(600);
 }
}
function load_fulldetailsf()
{
	
	 var prj_idf= document.getElementById("prj_idf").value;
	 var monthf=document.getElementById("monthf").value;
	  var yearf=document.getElementById("yearf").value;
	 if(prj_idf!="" & monthf!="" & yearf!='')
	 {
		 $('#fulldataf').delay(1).fadeIn(600);
    		  document.getElementById("fulldataf").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		 	  $( "#fulldataf").load( "<?=base_url()?>hm/sales/get_forcast/"+prj_idf+'/'+monthf+'/'+yearf);
		 
	 }
	 else
	 {
			 	 document.getElementById("checkflagmessage").innerHTML='Please Select Project Month And yeaer to get Details'; 
		$('#flagchertbtn').click(); 
	}
}
function check_this_market1()
{

	return true;
}
function format_val(obj)
{
	a=obj.value;
	a=a.replace(/\,/g,'')
	obj.value=parseFloat(a).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}

 </script>
       <form data-toggle="validator" method="post" action="<?=base_url()?>hm/sales/add_forcast"  enctype="multipart/form-data">
 
       <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
            <div class="form-body">
                <div class="form-inline">
                    <div class="form-group">
                    <? if($prjlist){?>
                        <select class="form-control" placeholder="Qick Search.."    id="prj_idf" name="prj_idf" >
                    <option value="">Project Name</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?> - </option>
                    <? }?>
             
					</select> <? }?> </div>
                    <div class="form-group" id="blocklist">
                        <select  name="monthf" id="monthf" class="form-control" >
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
                      <input type="text" name="yearf" id="yearf" value="<?=date('Y')?>"  class="form-control"/>
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="load_fulldetailsf()"  id="search_paymentf" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                   
                </div>
                  
      <div id="fulldataf" style="min-height:100px;"></div>
                     </div>
           
                                           
        </div>
           
  </form> 
   
 <br>    <br />
<br /><br /><br /><br /><br /><br /><br /><br /><br /></p> 
				
				