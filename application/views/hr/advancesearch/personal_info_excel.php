<?
$b='';
$b=$b.'

                        <table  border="1" > <thead> <tr> <th>Emp No</th><th>Name</th>
                        <th>Full Name</th>
                        <th>Joining Date</th>
                        <th>Designation</th>
                        <th>Branch</th> <th>Division</th><th>Mobile No</th>
                        <th>Personal Mobile No</th>
                        <th>Telephone No</th>
                        <th>Email</th>
                        <th>Date Of Birth</th>
                        <th>Nic</th>
                        <th>Religion</th>
                        <th>Race</th>
                        <th>Nationality</th>
                        <th>Address</th>
                        <th>Town</th>
                        <th>Province</th>
                        <th>Living Statues</th>
                        <th>Gender</th>
                        <th>Employeement Type</th>
                        <th>Contract Start Date</th>
                        <th>Contract End Date</th>
                        </tr></thead>';
					  if($searchpanel_searchdata){$c=0;
                          foreach($searchpanel_searchdata as $row){


                                   /*ticket no:2892 */
                                  $fullname=$row->initials_full;
                                   $disname=$row->display_name;


                                 if($disname!="")
                                 {
                                    $value =$disname;
                                 }
                                 else
                                 {
                                  $value=$fullname;
                                 }







                        $b=$b.'  <tbody>';
                       $b=$b.'<tr > ';
                       $b=$b.'  <td>'.$row->epf_no.'</td>';
                        $b=$b.'   <td>'.$value.'</td>';
                        $b=$b.'   <td>'.$fullname.' '.$row->surname.'</td>';
                        $b=$b.'   <td>'.$row->joining_date.'</td>';
                       $b=$b.' <td>'.$row->designation.'</td>';
                       $b=$b.' <td>'.$row->branch_name.'</td>';
                       $b=$b.' <td>'.$row->division_name.'</td>';
                       $b=$b.' <td>'.$row->office_mobile.'</td>';
                       $b=$b.' <td>'.$row->tel_mob.'</td>';
                       $b=$b.' <td>'.$row->tel_home.'</td>';
                       $b=$b.' <td>'.$row->email.'</td>';
                       $b=$b.' <td>'.$row->dob.'</td>';
                       $b=$b.' <td>'.$row->nic_no.'</td>';
                       $b=$b.' <td>'.$row->religion.'</td>';
                       $b=$b.' <td>'.$row->race.'</td>';

                       $nationality="";
                       if($row->nationality=="209")
                       {
                         $nationality="Sri Lankan";
                       }

                       $b=$b.' <td>'.$nationality.'</td>';
                       $b=$b.' <td>'.$row->addr1.','.$row->addr2.'</td>';
                       $b=$b.' <td>'.$row->town.'</td>';
                       $province=province();
                       $province_name="";
                       foreach($province as $key=>$value){
                         if($key == $row->province){
                         $province_name=$value;
                       }
           						}
                       $b=$b.' <td>'.$province_name.'</td>';
                       $living_statues="";
                       if($row->living_status=="1")
                       {
                         $living_statues="Married";
                       }elseif($row->living_status=="0")
                       {
                         $living_statues="Single";
                       }
                       elseif($row->living_status=="2")
                       {
                         $living_statues="Divorced";
                       }
                       elseif($row->living_status=="3")
                       {
                         $living_statues="Widowed";
                       }


                       $b=$b.' <td>'.$living_statues.'</td>';
                       $b=$b.' <td>'.$row->gender.'</td>';
                       $b=$b.' <td>'.$row->emp_type.'</td>';
                       $start_date="";
                       $end_date="";
                       if($row->contrat_start_date!="0000-00-00" && $row->contrat_start_date!="")
                       {
                         $start_date=$row->contrat_start_date;
                       }
                       if($row->contrat_end_date!="0000-00-00" && $row->contrat_end_date!="")
                       {
                         $end_date=$row->contrat_start_date;
                       }
                       $b=$b.' <td>'.$start_date.'</td>';
                       $b=$b.' <td>'.$end_date.'</td>';
                        $b=$b.'  </tr> ';
								  }}

                         $b=$b.' </tbody></table> ';
               	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Employee_search.xls");
	echo $b;
