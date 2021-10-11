<h4>  <?=$emp_data['initial']." ".$emp_data['surname']?> Appraisal<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?=base_url()?>hr/employee/addemp_appraisal_comment" enctype="multipart/form-data">
      <input type="hidden" name="app_id" id="app_id" value="<?=$appraisal_data->id?>">

      <div class="widget-shadow" data-example-id="basic-forms">
        <div class="form-title">
          <h5 style="background-color:none;">Appraisal Comments</h5>
        </div>
        <div class="form-body">

          <label>Employee Comment</label>
          <textarea class="form-control" id="comment" name="comment"  > </textarea>
        </div>

        <div class="bottom ">

          <div class="form-group">
            <button type="submit" class="btn btn-primary disabled">Update</button>
          </div>
          <div class="clearfix"> </div>
        </div>
      </div>

      <div class="clearfix"> </div>
      <br>




    </form></div>





    <br /><br /><br /><br /></div>
