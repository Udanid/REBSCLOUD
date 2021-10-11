 <h4><?=$remark->customer_name;?>'s <?=$remark->added_date;?> Remark<span  style="float:right; color:#FFF" ><a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">  <div class="form-title">
                                    <h5>Call Sheet Details </h5>
                                </div>
                    
						<div class="col-md-12" data-example-id="basic-forms">

							<div class="form-body">
                <div class="form-group">
                <table  class="table" ><tr>
                <td>Customer Name :</td> <td><?=$remark->customer_name?></td>
                  <td>Location :</td>       <td><?=$remark->location?></td></tr><tr>
                   <td>Project Name :</td>        <td><?=$remark->project_name?></td>
                      <td>Telephone :</td>    <td><?=$remark->phone?></td></tr><tr>
                         <td>Remark:</td>  <td><?=$remark->remark?></td>
                         <td>Referance:</td>  <td><?=$remark->ref_data?></td> </tr><tr>
                         <td>Added Date:</td><td><?=$remark->added_date?></td>
                         <td>Added By:</td><td><?=$remark->initial?> <?=$remark->surname?></td>
                
                </tr></table>
                 </div>
                  <div class="form-title">
                                    <h5>Follow up Data</h5>
                                </div>
                 <table class="table table-bordered"> <thead> <tr> <th>Date</th> <th>Action </th><th>Customer Feedback</th><th>Officer Feedback</th><th>Create By</th><th></th></tr> </thead>
                      <? if($loanfollow){$c=0;
                          foreach($loanfollow as $row){?>
							 
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                       <td><?=$row->follow_date  ?></td>
                         <td><?=$row->contact_media  ?> </td> 
                         <td><?=$row->cus_feedback?></td>
                         <td><?=$row->sales_feedback?></td>
                     <td align="right"><?=get_user_fullname($row->create_by)?></td>
                       <td>  
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table> 

							</div>
						</div>
    		</div>
</div>