<script type="text/javascript">

$( function() {
    $( "#dob_fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
   $( "#dob_todate" ).datepicker({dateFormat: 'yy-mm-dd'});
     $( "#joining_fromdate" ).datepicker({dateFormat: 'yy-mm-dd'});
   $( "#joining_todate" ).datepicker({dateFormat: 'yy-mm-dd'});
     $( "#turn_from" ).datepicker({dateFormat: 'yy-mm-dd'});
      $( "#turn_to" ).datepicker({dateFormat: 'yy-mm-dd'});
  } );
// jQuery(document).ready(function() {
//     setTimeout(function(){
//    $("#nationallity").chosen({
//          allow_single_deselect : true,
//      search_contains: true,
//      no_results_text: "Oops, nothing found!",
//      placeholder_text_single: "Nationallity"
//      });
//    $("#religion").chosen({
//          allow_single_deselect : true,
//      search_contains: true,
//      no_results_text: "Oops, nothing found!",
//      placeholder_text_single: "Branch"
//      });
//    $("#race").chosen({
//          allow_single_deselect : true,
//      search_contains: true,
//      no_results_text: "Oops, nothing found!",
//      placeholder_text_single: "Project"
//      });
//     $("#martial_status").chosen({
//         allow_single_deselect : true,
//       search_contains: true,
//       no_results_text: "Oops, nothing found!",
//       placeholder_text_single: "Martial Status"
//       });
//    $("#searchpanel_cus_code").chosen({
//          allow_single_deselect : true,
//      search_contains: true,
//      no_results_text: "Oops, nothing found!",
//      placeholder_text_single: "Customer"
//      });
//  }, 500);
// });

// function load_searchpanel_fulldetails()
// {
//   var month=document.getElementById("searchpanel_search_list").value;

//  // alert(month)
//  if(month!='')
//   {
//     $('#searchpanelerror').delay(1).fadeOut(600);
//    document.getElementById("advsearchform").submit();

//   }
//    else
//    {
//    $('#searchpanelerror').delay(1).fadeIn(600);
//       document.getElementById("searchpanelerror").innerHTML='Please Select search list';

//      // $('#fulldata').delay(1).fadeOut(600);
//    }
// }

function load_searchpanel_blocklist(id)
{

 if(id!=""){

               $('#searchpanel_block').delay(1).fadeIn(600);
                  document.getElementById("searchpanel_block").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
          $( "#searchpanel_block" ).load( "<?=base_url()?>advancesarch/get_blocklist/"+id );






 }
 else
 {
   $('#searchpanel_block').delay(1).fadeOut(600);

 }
}

function load_higher_education(id)
{
  if(id == 3)
  {
    $("#higher_education").show();
  }
  else
  {
     $("#higher_education").css('display','none');
  }
}

function load_higher_education_area(id)
{
  if(id != "")
  {
    $("#higher_education_area").show();
  }
  else
  {
     $("#higher_education_area").css('display','none');
  }
}

function load_search_menu(id)
{
  if(id == "1")
    {
      $('#personal_info_search').show();
       $('#employement_info_search').css('display','none');
        $('#educational_info_search').css('display','none');
         $('#turnover_rate').css('display','none');
    }
  else if(id == "2")
    {
      $('#employement_info_search').show();
      $('#personal_info_search').css('display','none');
        $('#educational_info_search').css('display','none');
         $('#turnover_rate').css('display','none');
    }
  else if(id == "3")
    {
      $('#educational_info_search').show();
      $('#personal_info_search').css('display','none');
        $('#employement_info_search').css('display','none');
        $('#turnover_rate').css('display','none');

    }
    else if(id == "4" || id == "6")
    {
     $('#turnover_rate').css('display','none');
      $('#personal_info_search').css('display','none');
        $('#employement_info_search').css('display','none');
         $('#educational_info_search').css('display','none');
    }
   else if(id == "5")
    {
      $('#turnover_rate').show();
      $('#personal_info_search').css('display','none');
        $('#employement_info_search').css('display','none');
         $('#educational_info_search').css('display','none');
    }
}


</script>



                  <form data-toggle="validator" id="advsearchform" method="post" action="<?=base_url()?>hr/advancesarch/search"  enctype="multipart/form-data">
    <div class="row">

        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; margin-top:-40px; background-color: #eaeaea;">
          <div class="alert alert-danger" role="alert" id="searchpanelerror" style="display:none">

        </div>
            <div class="form-body">
              <div class="form-inline">
              <div class="form-group">
                    <select class="form-control" placeholder="Qick Search.."    id="search_list" name="search_list" onchange="load_search_menu(this.value)" required>
                      <option value="">Search by</option>
                      <option value="1">Personal Information</option>
                      <option value="2">Employeement Details</option>
                      <option value="3">Educational Details</option>
                      <!-- Ticket No:2828 Added by Madushan 2021.05.13 -->
                      <option value="4">Age analysis report</option>
                       <option value="5">Employee Turnover rate</option>
                        <!-- Ticket No:2840 Added by Madushan 2021.05.14 -->
                      <option value="6">Gender analysis</option>

            </select>  </div>

              <div class="form-group">
                <select class="form-control" placeholder="Qick Search.."    id="branch" name="branch" >
                    <option value="">Branch</option>
                     <option value="ALL">All</option>
                    <?php
                    foreach($branches as $branch_row){ ?>
                      <option value=<?php echo $branch_row->branch_code; ?>><?php echo $branch_row->branch_name; ?></option>
                    <?php
                    } ?>


                </select>
                </div>
                <div class="form-group">
               <select class="form-control" placeholder="Qick Search.."    id="division" name="division" >
          <option value="">Division</option>
          <?php
          foreach($divisions as $division_row){ ?>
            <option value=<?php echo $division_row->id; ?>><?php echo $division_row->division_name; ?></option>
          <?php
          } ?>


</select>
          </div>

            </div>
            <br>
            <div id="personal_info_search" style="display: none">
              <h5>Search by Personal Information</h5>
                <div class="form-inline">
                  <div class="form-group">
                 <select class="form-control" id="nationallity" name="nationallity">
                  <option value="">Nationallity</option>
                <?php
                foreach($countryList as $key=>$value){?>
                  <option value=<?php echo $key; ?>><?php echo $value['nationality']; ?></option>
               <? } ?>
            </select>  </div>
                    <div class="form-group" id="martial_status">
                    <select class="form-control" placeholder="Qick Search.."    id="martial_status" name="martial_status"   >
                      <option value="">Martial Status</option>
                   <?php
                      foreach($maritalStatus as $key=>$value){ ?>
                        <option value=<?php echo $key; ?>><?php echo $value; ?></option>
                      <?php
                      } ?>
            </select>  </div>
                     <div class="form-group">
                    <select class="form-control" placeholder="Qick Search.."    id="religion" name="religion" >
                    <option value="">Religion</option>
                      <?php
                    foreach($religion as $religion_row){ ?>
                      <option value=<?php echo $religion_row->id; ?>><?php echo $religion_row->religion_name; ?></option>
                    <?php
                    } ?>

          </select>  </div>
                     <div class="form-group" >
                         <select class="form-control" placeholder="Qick Search.."    id="race" name="race" >
                    <option value="">Race</option>
                     <?php
                    foreach($race as $race_row){ ?>
                      <option value=<?php echo $race_row->id; ?>><?php echo $race_row->race_name; ?></option>
                    <?php
                    } ?>

          </select>
                    </div>
                     <div class="form-group">
                         <select class="form-control" placeholder="Qick Search.."    id="blood_group" name="blood_group" >
                          <option value="">Blood Group</option>
                               <?php
                        foreach($bloodGroup as $key=>$value){ ?>
                          <option value=<?php echo $key; ?>><?php echo $value; ?></option>
                        <?php
                        } ?>
          </select>
                    </div>
                      <div class="form-group" style="margin-left:20px; ">
                        <label><small>DOB</small></label>
                       <input type="text" name="dob_fromdate" id="dob_fromdate" placeholder="from Date"  class="form-control" >

                    </div>
                    <div class="form-group">
                       <input type="text" name="dob_todate" id="dob_todate" placeholder="To Date"  class="form-control" >

                    </div>
                  </div>
                </div>
                 <div id="employement_info_search" style="display: none">
                      <h5>Search by Employement Information</h5>
                      <div class="form-inline">
                       <div class="form-group">
                         <select class="form-control" placeholder="Qick Search.."    id="emp_type" name="emp_type" >
                    <option value="">Employment Type</option>
                    <?php
                    foreach($employment_types as $employment_type_row){ ?>
                      <option value=<?php echo $employment_type_row->id; ?>><?php echo $employment_type_row->employment_type; ?></option>
                    <?php
                    } ?>


          </select>
                    </div>

                     <div class="form-group" style="margin-left:20px; ">
                        <label><small>Joining Date</small></label>
                       <input type="text" name="joining_fromdate" id="joining_fromdate" placeholder="from Date"  class="form-control" >

                    </div>
                    <div class="form-group">
                       <input type="text" name="joining_todate" id="joining_todate" placeholder="To Date"  class="form-control" >

                    </div>

                          <div class="form-group">
                         <select class="form-control" placeholder="Qick Search.."    id="designation" name="designation" >
                    <option value="">Designation</option>
                    <?php
                    foreach($designations as $designation_row){ ?>
                      <option value=<?php echo $designation_row->id; ?>><?php echo $designation_row->designation; ?></option>
                    <?php
                    } ?>


          </select>
                    </div>




                          <div class="form-group">
                         <select class="form-control" placeholder="Qick Search.."    id="immediate_manager" name="immediate_manager" >
                    <option value="">Immediate Manager</option>
                    <?php
                    if($employee_list){
                    foreach($employee_list as $employee_list_row){ ?>
                      <option value=<?php echo $employee_list_row->id; ?>><?php echo $employee_list_row->epf_no.' - '.$employee_list_row->initial.' '.$employee_list_row->surname; ?></option>
                    <?php
                  }} ?>

          </select>
                    </div>

                    <div class="form-group">
                      <input type="text" class="form-control" name="town" placeholder="Town">
                    </div>

                          <div class="form-group">
                         <select class="form-control" placeholder="Qick Search.."    id="province" name="province" >
                    <option value="">Province</option>
                    <?php
                    foreach($province as $key=>$value){ ?>
                      <option value=<?php echo $key; ?>><?php echo $value; ?></option>
                    <?php
                    } ?>


          </select>
                    </div>
                  </div>
                </div>

                       <div id="educational_info_search" style="display: none">
                     <h5>Search by Educational Details</h5>
                     <div class="form-inline">
                          <div class="form-group">
                         <select class="form-control" placeholder="Qick Search.."    id="education" name="education" onchange="load_higher_education(this.value)">
                    <option value="">Education</option>
                    <option value="1">G.C.E A/L</option>
                    <option value="2">G.C.E O/L</option>
                    <option value="3">Higher Education</option>


          </select>
                    </div>

                          <div class="form-group">
                         <select class="form-control" placeholder="Qick Search.."    id="higher_education" name="higher_education" onchange="load_higher_education_area(this.value)" style="display: none;">
                    <option value="">Level</option>
                        <?php
                    foreach($higher_qlfct as $higher_qlfc_row){ ?>
                      <option value=<?php echo $higher_qlfc_row->id; ?>><?php echo $higher_qlfc_row->education_qualification_name; ?></option>
                    <?php
                    } ?>

          </select>
                    </div>


                          <div class="form-group">
                         <select class="form-control" placeholder="Qick Search.."    id="higher_education_area" name="higher_education_area" style="display: none;">
                    <option value="">Select Area</option>
                      <?php
                    foreach($qlfct_field as $qlfct_field_row){ ?>
                      <option value=<?php echo $qlfct_field_row->id; ?>><?php echo $qlfct_field_row->qualification_field_name; ?></option>
                    <?php
                    } ?>


          </select>
                    </div>
                  </div>
                </div>

                <div id="turnover_rate" style="display: none;">
                   <h5>Turnover Rate Report</h5>
                     <div class="form-inline">
                        <div class="form-group">
                          <input type="text" class="form-control" name="turn_from" id="turn_from" placeholder="From" autocomplete="off">
                        </div>
                        <div class="form-group">
                          <input type="text" class="form-control" name="turn_to" id="turn_to" placeholder="To" autocomplete="off">
                        </div>
                     </div>
                </div>

                <div class="form-inline">
                    <div class="form-group">
                        <button type="submit" id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>

            </div>
             <br><br><br><br><br><br>
        </div>


    </div>
</form>
