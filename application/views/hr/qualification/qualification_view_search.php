<style type="text/css">
  .tableFixHead { overflow-y: auto; height: 350px; }
  table  { border-collapse: collapse; width: 100%; }
  th, td { padding: 8px 16px; }
  th     { background:#eee; }
</style>

<script>
  $(document).ready(function(){
      //when succes close button pressed
      $(document).on('click','#close-btn', function(){
        location.reload();
      });

  });
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<h4>Employee Qualification Report: <span style="float:right; color:#FFF" ><a href="javascript:close_edit()"><i class="fa fa-times-circle"></i></a></span></h4>
<div name="print_div" id="print_div" class="table widget-shadow">
  <h4 style="background-color: transparent; color: black; text-align: center; display:none;" name="print_title" id="print_title"> <br>Employee Qualification Report</h4>
  <button onclick="sent_to_print()" name="print_icon" id="print_icon"><img src="<?php echo base_url(); ?>application/assets/images/icons/print.png" border="0" alt="Re Print Payment Entry"/></button>
  <a href="#"  name="generate_excel_icon" id="generate_excel_icon"><i class="fa fa-file-excel-o"></i></a>
  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
  <div id="loader" class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
      <div class="tableFixHead">
           <table class="table">
            <thead>
            <tr>
              <th>Epf No</th>
              <th>Name</th>
              <th></th>
              <th></th>
              <th>Date of join</th>
             <th>O/L Qualification</th>
             <th>A/L Qualification</th>

              <th>Other Qualification</th>
              <th>Working Experince</th>
             <th></th>
            </tr>

            </thead>
            <tbody>
            <?php
            if($employee_details){
              $c = 0;
              foreach($employee_details as $row){?>


                <? $fullname=$row->initials_full;
                    $disname=$row->display_name;


                                 if($disname!="")
                                 {
                                    $value =$disname;
                                 }
                                 else
                                 {
                                  $value=$fullname;
                                 }?>


              <tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                <td><?php echo $row->epf_no; ?></td>
                <td><?php echo $value; ?></td>
                <td></td>
                <td></td>
                <td><?php echo $row->joining_date; ?></td>

                    <td><? $ol_counter = 0;?>
                        <? $ol_results=unserialize($row->olresults);?>
                           <table>
                         <?if (isset($ol_results) && is_array($ol_results)) {?>


                                  <tr>
                                    <?foreach ($ol_results as $ol_result_row) { ?>
                                   <td><?php  echo $ol_result_row['subject']."-"; ?>

                                    <?php echo $ol_result_row['grade']; ?></td>
                                  <!--   <td style="text-align: center;">-</td> -->

                                  </tr>




                                    <? $ol_counter++;?>


                                    <?}

                              }?>


                            </table>


                  </td>


                  <td><? $al_counter = 0;?>
                        <? $al_results=unserialize($row->alresult);?>
                           <table>
                         <?if (isset($al_results) && is_array($al_results)) {?>


                                  <tr>
                                    <?foreach ($al_results as $al_result_row) { ?>
                                   <td><?php  echo $al_result_row['subject']."-"; ?> <?php echo $al_result_row['grade']; ?></td></tr>

                                    <? $al_counter++;?>


                                    <?}

                              }?>


                            </table>


                  </td>


                  <td><? $qualification_details_counter = 0;?>
                        <? $qualification_details_counter=unserialize($row->qualification_details);?>
                           <table>
                         <?if (isset($qualification_details_counter) && is_array($qualification_details_counter)) {?>


                                  <tr>
                                    <?foreach ($qualification_details_counter as $qualification_details_row) { ?>
                                   <td><?php  echo $qualification_details_row['institute']."-"; ?> <?php echo $qualification_details_row['grade']; ?>


                                   <?php echo $qualification_details_row['from']; ?><br>

                                    <?php echo $qualification_details_row['additionalInfo']; ?>

                                   </td></tr>

                                    <? $qualification_details_counter++;?>


                                    <?}

                              }?>


                            </table>


                  </td>



                    <td><? $experience_details_counter = 0;?>
                        <? $experience_details_counter=unserialize($row->experience_details);?>
                           <table>
                         <?if (isset($experience_details_counter) && is_array($experience_details_counter)) {?>


                                  <tr>
                                    <?foreach ($experience_details_counter as $experience_details_row) { ?>
                                   <td><?php  echo $experience_details_row['job']."-"; ?> <?php echo $experience_details_row['company']; ?>
                                   <?php echo $experience_details_row['location']; ?>


                                   <?php echo $experience_details_row['from']; ?><br>

                                    <?php echo $experience_details_row['additionalInfo']; ?>

                                   </td>
                                 </tr>

                                    <? $qualification_details_counter++;?>


                                    <?}

                              }?>


                            </table>


                  </td>


                </tr>

              <?php
              }
            } ?>
            </tbody>
          </table>
        </div>
      </div>
      </div></div>
      <script>
        var $th = $('.tableFixHead').find('thead th')
        $('.tableFixHead').on('scroll', function() {
          $th.css('transform', 'translateY('+ this.scrollTop +'px)');
        });
        </script>


      <script>

        function close_edit(){
          $('#popupform').delay(1).fadeOut(800);
        }

        function sent_to_print(){
          var restorepage = $('body').html();
          $('#print_title').show();
          $('#print_icon').hide();
          $('#generate_excel_icon').hide();
          var printcontent = $('#print_div').clone();
          $('body').empty().html(printcontent);
          window.print();
          $('#print_title').hide();
          $('#print_icon').show();
          $('#generate_excel_icon').show();
          $('body').html(restorepage);
        }

        $("#generate_excel_icon").click(function (e) {
          var restorepage = $('body').html();
          $('#print_title').show();
          $('#print_icon').empty();
          $('#generate_excel_icon').hide();
          var printcontent = $('#print_div').clone();
          var contents = $('body').empty().html(printcontent);
          //window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=print_div]').html()));
          var result = 'data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=print_div]').html());
              this.href = result;
              this.download = "Qualification_Report.xls";
          $('#print_title').hide();
          $('#print_icon').show();
          $('#generate_excel_icon').show();
          $('body').html(restorepage);
        });

      </script>
