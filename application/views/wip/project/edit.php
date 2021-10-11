<h4>Project Details<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->prj_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    
    <form data-toggle="validator" method="post" action="<?=base_url()?>wip/project/editdata" enctype="multipart/form-data">
  
  	<div class="row">
		<div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
		    <div class="form-body">
        	<input type="hidden" class="form-control" name="prj_id" id="prj_id" data-error="" value="<?=$details->prj_id?>">
		      <div class="col-md-6 form_padding">
		        <div class="form-group has-feedback">
					<input type="text" class="form-control" name="project_mame" id="project_name"   placeholder="Project Name" data-error=""  autocomplete="off" required value="<?=$details->prj_name?>">
					<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					<span class="help-block with-errors"></span>
				</div>
		      </div>
                 
		      <div class="col-md-6 form_padding">       
		        <div class="form-group has-feedback">
		          <textarea class="form-control" id="prj_description" name="prj_description" rows="8" placeholder="Description"><?=$details->prj_description?></textarea>
		          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
		          <span class="help-block with-errors"></span>
		        </div>
		      </div>


		      <div class="col-md-6 form_padding">  
		      <div class="bottom validation-grids">                      
		        <div class="form-group">
		          <button type="submit" class="btn btn-primary">Submit</button>
		        </div>
		        <br><br><div class="clearfix"> </div>
		      </div>
		    </div>

	   </div>
		
	</div>

    </div>
    <div class="clearfix"></div>  
		</form></div>

<br /><br /><br /><br /></div>