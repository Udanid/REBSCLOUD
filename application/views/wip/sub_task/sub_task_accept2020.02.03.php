
<!DOCTYPE HTML>
<html>
<head>

<?
  $this->load->view("includes/header_".$this->session->userdata('usermodule'));
  $this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<style type="text/css">
  .form_padding{
    padding-left: 0px;
  }
</style>

</head>

<!-- //header-ends -->
<!-- main content start-->

<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

    <h3 class="title1">Sub Task Details</h3>
          
    
    </div>
</div>


<div class="table widget-shadow">
 <div class="row">
                    
<form data-toggle="validator" method="post" action="<?=base_url()?>wip/subtask/accept_notification" enctype="multipart/form-data">  
  <div class="row">
    <div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
      <input type="hidden" class="form-control" name="subt_id" id="subt_id" data-error="" value="<?=$details->subt_id?>">

      <input type="hidden" class="form-control" name="task_id" id="task_id" data-error="" value="<?=$details->task_id?>">

      <input type="hidden" class="form-control" name="subt_duration" id="subt_duration" data-error="" value="<?=$details->subt_duration?>">

      <div class="form-body">
        <div class="col-md-12 form_padding"> 
          <div class="form-group">
            <p>Project Name : <?=$details->prj_name?></p>           
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Task Name : <?=$details->task_name?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Sub Task Name : <?=$details->subt_name?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding"> 
          <div class="form-group">
            <p>Assignee : <?=$details->initials_full?></p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Duration : <?=$details->subt_duration?> Days</p>
          </div>
        </div>

        <div class="col-md-6 form_padding">
          <div class="form-group has-feedback">
            <p>Description : <?=$details->sub_description?></p>
          </div>
        </div>

      <div class="col-md-6 form_padding">  
      <div class="bottom validation-grids">                      
        <div class="form-group">
          <button type="submit" class="btn btn-primary disabled">Accept</button>
        </div>
        <br><br><div class="clearfix"> </div>
      </div>
    </div>

    <br><br><br>
    </div>
  </div>
  
  </div>
</div>
<div class="clearfix"></div>  
</form> 
</div>
 <br /><br /><br /><br />
</div>

</html>
    <!--footer-->
<?
  $this->load->view("includes/footer");
?>