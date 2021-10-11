<script type="text/javascript">
jQuery(document).ready(function() {

  $("#branch_id").chosen({
    allow_single_deselect : true
  });
  $("#division_id").chosen({
    allow_single_deselect : true
  });
  $("#designation_id").chosen({
    allow_single_deselect : true
  });
  });
    </script>
<div id="page-wrapper">
  <div class="main-page">

	<div class="modal-content">
	  <div class="modal-body">
		<!--block which displays the outcome message-->
		<div id="messageBoard">
			<?php
			if($this->session->flashdata('msg') != ''){ ?>
				<div class="alert alert-success  fade in">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<?php echo $this->session->flashdata('msg'); ?>
				</div>
			<?php
			} ?>
		</div>
    <div id="messageBoard">
			<?php
			if($this->session->flashdata('error') != ''){ ?>
				<div class="alert alert-success  fade in">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<?php echo $this->session->flashdata('error'); ?>
				</div>
			<?php
			} ?>
		</div>
		  <div class="table">
			<h3 class="title1">Employee Confirmation List</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Employee Confirmation List</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
          <form data-toggle="validator" method="post" action="<?=base_url()?>hr/employee/search"  enctype="multipart/form-data">

              <div class="row">
                  <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; background-color: #eaeaea;">
                      <div class="form-body">
                          <div class="form-inline">
                              <div class="form-group">
                                  <input type="text" class="form-control" name="search_val" id="search_val" placeholder="Name / NIC / ETF NO / Employee NO">
                              </div>
                              <?
                              $ci =&get_instance();
                              $ci->load->model('hr/common_hr_model');
                              $branch_list = $ci->common_hr_model->get_branch_list();
                              $division_list = $ci->common_hr_model->get_division_list();
                              $designation_list = $ci->common_hr_model->get_designation_list();
                              ?>
                              <div class="form-group">
                                  <select class="form-control" name="branch_id" id="branch_id">
                                    <option value="">Branch</option>
                                    <? if($branch_list){
                                      foreach ($branch_list as $key => $value) {?>
                                        <option value="<?=$value->branch_code?>"><?=$value->shortcode?> - <?=$value->branch_name?></option>
                                    <?  }
                                    }?>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <select class="form-control" name="division_id" id="division_id">
                                    <option value="">Division</option>
                                    <? if($division_list){
                                      foreach ($division_list as $key => $value) {?>
                                        <option value="<?=$value->id?>"><?=$value->division_name?></option>
                                    <?  }
                                    }?>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <select class="form-control" name="designation_id" id="designation_id">
                                    <option value="">Designation</option>
                                    <? if($designation_list){
                                      foreach ($designation_list as $key => $value) {?>
                                        <option value="<?=$value->id?>"><?=$value->designation?></option>
                                    <?  }
                                    }?>
                                  </select>
                              </div>


                              <div class="form-group">
                                  <button type="submit"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </form>
				  <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
					<table class="table">
					  <thead>
						<tr>
						  <th>Emp No</th>
						  <th>Name</th>
						  <th>Designation</th>
                          <th>Branch</th>
						  <th>Contact Number</th>
						  <th>Status</th>
						  <th></th>
						</tr>
					  </thead>
					  <tbody>
						<?php
						if($datalist){
						  $c = 0;
						  foreach($datalist as $row){
							$ci =&get_instance();
							$ci->load->model('hr/common_hr_model');
							$designation = $ci->common_hr_model->get_designation($row->designation);?>
							<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
							  <th scope="row"><?php echo $row->emp_no; ?></th>
							  <td><?php echo $row->initial.' '.$row->surname; ?></td>
							  <td><?php echo $designation['designation']; ?></td>
                              <td><?php echo get_branchcode_by_empid($row->id); //this function is in custom helper ?></td>
							  <td><?php echo $row->office_mobile ; ?></td>
							  <td>
								<?php
								if($row->status == "P"){
									$status = "Pending";
								}else if($row->status == "A"){
									$status = "Active";
								}else if($row->status == "D"){
									$status = "Deactive";
								}
								echo $status; ?>
							  </td>
							  <td align="right">
								<div id="checherflag">
								  <?php
								  if($row->status == "P"){ ?>
									<a href="<?php echo base_url();?>hr/employee/confirm_user_data/<?php echo $row->id;?>" title="View & Confirm"><i class="fa fa-edit nav_icon icon_blue"></i></a>
								  <?php
								  }else{ ?>
									<a href="<?php echo base_url();?>hr/employee/confirm_user_data/<?php echo $row->id;?>" title="View"><i class="fa fa-file-text-o nav_icon icon_blue"></i></a>
								  <?php
								  } ?>
								</div>
							  </td>
							</tr>
						   <?php
						   }
						} ?>
					  </tbody>
					</table>
					<div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
	  </div>
	</div>

  </div>
</div>
