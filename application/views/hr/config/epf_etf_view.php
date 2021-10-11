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
     
        <div class="table">
          <h3 class="title1">EPF/ETF</h3>	
          <div class="widget-shadow">
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">EPF/ETF</a>
              </li>
            </ul>
            
            <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
              <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >        
                <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  <table class="table"> 
                    <thead> 
                      <tr> 
                        <th>No</th>
					    <th>EPF/ETF</th>
                        <th>Employee Contribution</th>
                        <th>Employer Contribution</th>
					    <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
				      if($datalist){
				  	    $c = 0;
					    $count = 1;
                  	    foreach($datalist as $row){ ?>
						  <tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
						    <td><?php echo $count; ?></td>
						    <td><?php echo $row->type; ?></td>
						    <td><?php echo $row->employee_contribution; ?> %</td>
						    <td><?php echo $row->employer_contribution; ?> %</td>
						    <td align="right">
						      <div id="checherflag">
							    <a href="javascript:call_edit('<?php echo $row->id;?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
						      </div>
						    </td>
						  </tr>
					      <?php
						  $count++;
			            }
				      } ?>
                    </tbody>
                  </table> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</div>

<script>
	
	function call_edit(id){
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/hr_config/edit_epf_etf/"+id );
	}
	
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}
</script>
