<table class="table"> 
	<thead> 
		<tr> 
			<th>Project Name</th>
			<th>Task Name</th>
            <th>Created By</th>
            <th>Assignee</th>
			<th>Duration </th> 
			<th>Start Date </th>
			<th>End Date </th>
			<th>Progress</th> 
			<th></th>
			<th>Status</th>
			<th></th>
		</tr> 
	</thead> 
	<tbody> 
                                                                  
   	<? if($taskdetails){
        $c=0;
        $checkuser=$this->session->userdata('userid');
        $taskid=''; 
        $subt_assign='';  
		$today=date("Y-m-d");              
        foreach($taskdetails as $row){
			
			$task_progress=0;
					if(get_task_progress($row->task_id)){ //this function is in WIP helper
						$task_progress = get_task_progress($row->task_id);
					}
					
					

					if($row->task_sdate <= $today && ($row->task_createby==$checkuser || $row->task_assign==$checkuser || is_user_have_subtasks($checkuser,$row->task_id) /*wip helper funtion*/ || is_project_owner($checkuser,$row->prj_id)/* wip helper function*/) && $row->task_status != 'pending'){ 
						$subtasks = get_subtasks_by_taskid($row->task_id,$checkuser); //wip helper function
						$color = '';
					    if($row->task_status == 'pending'){
						$color = '#ECB35B';   
				    ?>
                    	<tr class="bg-orange-200" style="border-top:5px solid #ECB35B;">
                    <? }
						if($row->task_status == 'processing'){
						$color = '#91cc87';
					?>
                        <tr class="bg-green-200" style="border-top:5px solid #9BCE93;">
                    <? }
						if($row->task_status == 'expired'){
						$color = '#999';
					?>
                    	<tr class="bg-grey-400" style="border-top:5px solid #999;">
					<? }
						if($row->task_status == 'completed'){
						$color = '#75BAFF';
					?>
                         <tr class="bg-blue-200" style="border-top:5px solid #75BAFF;">
                    <? }?>
                            <td><?=$row->prj_name?></td> 
                            <td><?=$row->task_name?></td>
                            <td><?=get_user_fullname_id($row->task_createby) //re_account helper funtion?></td>
                            <td><?=get_user_fullname_id($row->task_assign) //re_account helper funtion?></td>
                            <td><?=$row->task_duration?> Days</td>
                            <td><?=$row->task_sdate?></td>
                            <td><span 
                      <? 
						
						//we show different colors depend on time remains for the task
						if($row->task_status != 'completed'){
							$task_duration = $row->task_duration;
							$end_date = strtotime(date('Y-m-d'));
							$start_date = strtotime($row->task_sdate);
							$datediff = $end_date - $start_date;
							$datediff = round($datediff / (60 * 60 * 24));
							$task_duration_todate = $datediff;
							$task_duration_used = ($task_duration_todate / $task_duration) * 100;
							
							if($row->task_status == 'expired'){
								echo ' class="white-bg bg-grey-600"';
							}else if ($task_duration_used >= 90){
								echo ' class="white-bg bg-red-600"';   
							}
							else if ($task_duration_used >= 75 && $task_duration_used <= 90){
								echo ' class="white-bg bg-orange-800"';
							}
							else if ($task_duration_used >= 50 && $task_duration_used <= 75){
								echo ' class="white-bg bg-orange-500"';
							}
							else if ( $task_duration_used <= 50){
								echo ' class="white-bg bg-green-600"';
							}
						}else{
							echo ' class="white-bg bg-blue-600"';
						}
					  ?> > <?=$row->task_edate?></span></td>
                          <td>
                            <div id="progress" class="progress progress-striped active">
                            <?php if($task_progress == 100){ ?>
                                <div class="bar blue" style="width: <?=$task_progress?>%"></div>
                             <? }else if($task_progress >= 75 && $task_progress < 100){ ?>
                                <div class="bar green" style="width: <?=$task_progress?>%"></div>
                             <? }else if($task_progress >= 50 && $task_progress < 75){ ?>
                                <div class="bar yellow" style="width:<?=$task_progress?>%;"></div>
                             <? }else if($task_progress >= 30 && $task_progress < 50){ ?>
                                <div class="bar orange" style="width:<?=$task_progress?>%;"></div>
                             <? }else{ ?>
                                <div class="bar red" style="width:<?=$task_progress?>%;"></div>
                             <? } ?>                         
                            </div>
                          </td>
                      
                      <td><?=$task_progress?>%</td>
                      <? if($row->task_status == 'pending'){?>
                          <td >Pending Acceptence</td>
                      <? } ?>
                      <? if($row->task_status == 'processing'){?>
                          <td>Ongoing</td>
                      <? } ?>
                      <? if($row->task_status == 'completed'){?>
                          <td>Completed</td>
                      <? } ?>
                      <? if($row->task_status == 'expired'){?>
                          <td>Expired</td>
                      <? } ?>

                      <td align="right"><div id="checherflag">

                        <? $checkuser=$this->session->userdata('userid');
                          if($row->task_createby==$checkuser && $row->task_assign==$checkuser){ ?>

                         	<a  href="javascript:view('<?=$row->task_id?>')" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>

                         <? } ?>

                         <? $checkuser=$this->session->userdata('userid');
                          if($row->task_createby==$checkuser && $row->task_progress!=100 || ($row->task_assign==$checkuser && $row->task_accepted_status!=0 && $row->task_progress!=100)){
							if($row->task_status != 'expired'){ ?>
                            	<a  href="javascript:check_activeflag('<?=$row->task_id?>')" title="Edit"> <i class="fa fa-edit nav_icon icon_blue"></i></a>
						<?	
							}
						 } ?>
                    
                         <?
                         $current_date=date("Y-m-d");
                          if($row->task_accepted_status==0 && $row->task_assign==$checkuser && $row->task_sdate <= $current_date){
                           ?>
                            <a  href="javascript:call_accept('<?=$row->task_id?>')" title="Accept Task"><i class="fa fa-check nav_icon icon_green"></i></a>
                        <? } ?>

                        <?
                          if($row->task_createby==$checkuser && $row->task_progress==0){ ?>
                              <a  href="javascript:call_delete('<?=$row->task_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>               
                         <? } ?>                                      
                      </div></td>
                    </tr>
                 

                 <? if(!empty($subtasks)){
				 ?>
                 		<thead>
                            <tr> 
                                <th colspan="11" style="background:<?=$color;?>">Sub Tasks</th>
                            </tr> 
                        </thead>
                 <?
						foreach($subtasks as $data){
							if($data->subt_hold_edate <= $today && ($row->task_createby==$checkuser || $row->task_assign==$checkuser || $data->subt_createby==$checkuser || $data->subt_assign==$checkuser || is_project_owner($checkuser,$row->prj_id)/* wip helper function*/)){
                  ?>
                                
                                <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                                  <td></td> 
                                  <td><?=$data->subt_name?></td>
                                  <td><?=get_user_fullname_id($data->subt_createby) //re_account helper funtion?></td>
                                  <td><?=get_user_fullname_id($data->subt_assign) //re_account helper funtion?></td>
                                  <td><?=$data->subt_duration?> Days</td>
                                  <td><?=$data->subt_sdate?></td>
                                  <td style="padding-left:30px;"><span 
                                  <? 
                                    
                                    //we show different colors depend on time remains for the task
                                    if($row->task_status != 'completed' && $data->subt_status != 'pending'){
                                        $task_duration = $data->subt_duration;
                                        $end_date = strtotime(date('Y-m-d'));
                                        $start_date = strtotime($data->subt_sdate);
                                        $datediff = $end_date - $start_date;
                                        $datediff = round($datediff / (60 * 60 * 24));
                                        $task_duration_todate = $datediff;
                                        $task_duration_used = ($task_duration_todate / $task_duration) * 100;
                                        
                                        
                                        if($row->task_status != 'expired'){
                                            if($data->subt_status == 'completed'){
                                                
                                                echo ' class="dark-bg bg-blue-500"';
                                                
                                            }else if($data->subt_status == 'expired'){
                                                
                                                echo ' class="dark-bg bg-grey-500"';
                                                
                                            }else{
                                                if ($task_duration_used >= 90){
                                                    echo ' class="dark-bg bg-red-400"';   
                                                }
                                                else if ($task_duration_used >= 75 && $task_duration_used <= 90){
                                                    echo ' class="dark-bg bg-orange-600"';
                                                }
                                                else if ($task_duration_used >= 50 && $task_duration_used <= 75){
                                                    echo ' class="dark-bg bg-orange-400"';
                                                }
                                                else if ( $task_duration_used <= 50){
                                                    echo ' class="dark-bg bg-green-500"';
                                                }
                                            }
                                        }else{
                                            if($data->subt_status == 'completed'){
                                                
                                                echo ' class="dark-bg bg-blue-500"';
                                                
                                            }else{
                                                echo ' class="dark-bg bg-grey-500"';
                                            }
                                        }
                                    }
                                    
                                  ?> > <?=$data->subt_edate?></span></td>
                                  <td>
                                    <div id="progress" class="progress progress-striped active">
                                    <?php if($data->subt_progress == 100){ ?>
                                        <div class="bar blue" style="width: <?=$data->subt_progress?>%"></div>
                                     <? }else if($data->subt_progress >= 75 && $data->subt_progress < 100){ ?>
                                        <div class="bar green" style="width: <?=$data->subt_progress?>%"></div>
                                     <? }else if($data->subt_progress >= 50 && $data->subt_progress < 75){ ?>
                                        <div class="bar yellow" style="width:<?=$data->subt_progress?>%;"></div>
                                     <? }else if($data->subt_progress >= 30 && $data->subt_progress < 50){ ?>
                                        <div class="bar orange" style="width:<?=$data->subt_progress?>%;"></div>
                                     <? }else{ ?>
                                        <div class="bar red" style="width:<?=$data->subt_progress?>%;"></div>
                                     <? } ?>                         
                                    </div>
                                  </td>
                                  <td><?=$data->subt_progress?>%</td>
                                  <?
                                  if($row->task_status != 'expired'){
                                   if($data->subt_status  == 'pending'){?>
                                      <td><span class="bg-orange-700 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Pending Acceptence</span></td>
                                  <? } ?>
                                  <? if($data->subt_status  == 'processing'){?>
                                      <td><span class="bg-green-600 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Ongoing</span></td>
                                  <? } ?>
                                  <? if($data->subt_status  == 'completed'){?>
                                      <td><span class="bg-blue-600 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Completed</span></td>
                                  <? }?>
                                  <? if($data->subt_status  == 'expired'){?>
                                      <td><span class="bg-grey-500 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Expired</span></td>
                                  <? }
                                  }else{
                                      if($data->subt_status  == 'completed'){
                                  ?>
                                        <td><span class="bg-blue-600 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Completed</span></td>
                                  <?
                                      }else{
                                    ?>
                                        <td><span class="bg-grey-500 dark-bg text-center rounded" style="padding:5px; color:white; border-radius:5px;">Expired</span></td>
                                  <?
                                      }
                                  }?>
                    
            
                            
                                  <td align="right"><div id="checherflag">
                                    <? $checkuser=$this->session->userdata('userid');
                                    if(($data->subt_assign==$checkuser && $row->task_accepted_status==1) || $data->subt_createby==$checkuser || is_project_owner($checkuser,$row->prj_id)/* wip helper function*/){ ?>
            
                                        <a  href="javascript:viewsubtask('<?=$data->subt_id?>')" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>
                                    <? } ?>
            
                                    <? if($data->subt_assign==$checkuser && $data->subt_accepted_status==0 && $row->task_accepted_status == 1){ ?>
                                        
                                        <a  href="javascript:call_accept_sub('<?=$data->subt_id?>')" title="Accept"><i class="fa fa-check nav_icon icon_green"></i></a>                                               
                                    <? } ?>
            
                                      <? if($data->subt_assign==$checkuser && $row->task_accepted_status==1 && $data->subt_accepted_status==1 && $data->subt_status != 'completed' && $data->subt_status != 'expired' && $row->task_status != 'expired' && check_access('view_progress')){ ?>
            
                                         <a href="javascript:updateprograss('<?=$data->subt_id?>')" title="Update Progress"><i class="fa fa-spinner nav_icon blue-500"></i></a>
            
                                      <? } ?>
            
                                      <? if($data->subt_assign==$checkuser && $row->task_accepted_status==1 && $data->subt_accepted_status==1 && $data->subt_status != 'completed'){ ?>
            
                                         <a href="javascript:sub_extend('<?=$data->subt_id?>')" title="Extend Days"><i class="fa fa-plus-square nav_icon icon_green"></i></a>
            
                                      <? } ?>
            
                                       <?
                                      
                                      if($data->subt_createby==$checkuser && $data->subt_progress==0){ ?>
            
                                      <a  href="javascript:call_delete_sub('<?=$data->subt_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
            
                                      <? } ?>                                     
            
                                  </div></td>
                                  <td></td>
                                </tr>                 
                 		<? }
				 			}//check permision
                 
				  		}//subtask foreack
               		 }//check subtask id
                	$taskid=$row->task_id;
              	}//end foreach
            }else{//check is set rows?>
            	<tr>
                	<td colspan="11">No Tasks!</td>
                </tr>
            <? }?>
            </tbody>
          </table>
