
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_normal");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<script type="text/javascript">
  $( function() {
    $( "#start_date" ).datepicker({dateFormat: 'yy-mm-dd'});
    $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});
  
  } );

</script>

<script type="text/javascript">
    jQuery(document).ready(function() {
  setTimeout(function(){ 
    
    $("#client_id").chosen({
        allow_single_deselect : true,
      search_contains: true,
      no_results_text: "Oops, nothing found!",
      placeholder_text_single: "Client Name"
      });
  }, 800);
});

</script>

<script type="text/javascript">
  function check_activeflag(id){
        
  $.ajax({
        cache: false,
        type: 'GET',
        url: '<?php echo base_url().'common/activeflag_cheker/';?>',
        data: {table: 'wip_project', id: id,fieldname:'prj_id' },
        success: function(data) {
        if (data) {
          document.getElementById("checkflagmessage").innerHTML=data; 
          $('#flagchertbtn').click();
         
        } 
      else
      {
        $('#popupform').delay(1).fadeIn(600);
        $( "#popupform" ).load( "<?=base_url()?>wip/project/edit/"+id );
      }
        }
    });
}
</script>

<script type="text/javascript">
  function close_edit(id){         
    $.ajax({
          cache: false,
          type: 'GET',
          url: '<?php echo base_url().'common/delete_activflag/';?>',
          data: {table: 'wip_project', id: id,fieldname:'prj_id' },
          success: function(data) {
              if (data) {
           $('#popupform').delay(1).fadeOut(800);
           
          //document.getElementById('mylistkkk').style.display='block';
              } 
        else
        {
           document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin '; 
           $('#flagchertbtn').click();
          
        }
          }
      });
    }


    var deleteid="";

  function call_delete(id)
  {
    document.deletekeyform.deletekey.value=id;
    $.ajax({
        cache: false,
        type: 'GET',
        url: '<?php echo base_url().'common/activeflag_cheker/';?>',
        data: {table: 'wip_project', id: id,fieldname:'prj_id' },
        success: function(data) {
        if (data) {
          document.getElementById("checkflagmessage").innerHTML=data; 
          $('#flagchertbtn').click();         
        
        }else{
          $('#complexConfirm').click();
        }
      }
    }); 
  }

  function call_confirm(id)
  {
    document.deletekeyform.deletekey.value=id;
    $.ajax({
          cache: false,
          type: 'GET',
          url: '<?php echo base_url().'common/activeflag_cheker/';?>',
          data: {table: 'wip_project', id: id,fieldname:'cus_code' },
          success: function(data) {
          if (data) {
            document.getElementById("checkflagmessage").innerHTML=data; 
            $('#flagchertbtn').click();
           
          }else{
           $('#complexConfirm_confirm').click();
          }
        }
      });
      
  }

</script>

<script>
  $( function() {
    var availableTags = [
    <?
    foreach($projectsnames as $data){
      echo '"'.$data->prj_name.'",';
    }
    ?>
    ];
    $( "#project_name" ).autocomplete({
      source: availableTags
    });
  } );
  </script>


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

    <h3 class="title1">Project Data</h3>
     			
    <div class="widget-shadow">
        <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
          
          <li role="presentation" class="active">
          <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Project List</a></li>

           <? if(check_access('view_project')){?> <li role="presentation" class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add New Project</a></li> 
          <? }?> 
        </ul>	
           
    <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
        <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
          <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
            <?=$this->session->flashdata('msg')?>
        </div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
            <?=$this->session->flashdata('error')?>
        </div><? }?>

        <br>              
        <div class="form-title">
  				<h4>Pojects List
            
  				</h4>
        </div>     

       	<div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
            <table class="table"> 
              <thead> 
                <tr> 
                  <th>Project Names</th> 
                  <th>Created Date</th>
                  <th>Created By</th>
                  <th></th><th></th><th></th>
                </tr>
              </thead>                                          
                
              <? if($datalist){$c=0;
                foreach($datalist as $row){?>                     
                  <tbody> 
                    <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                    	<td><?=$row->prj_name?></td> 
                    	<td><?=$row->prj_create_date?></td>
                      <td><?=get_user_fullname_id($row->prj_createby)?></td>
                    	
                      <td align="right"><div id="checherflag">

                      <? $checkuser=$this->session->userdata('userid');
                      if($row->prj_createby==$checkuser){ ?>               	
                        <a  href="javascript:check_activeflag('<?=$row->prj_id?>')" title="Edit"> <i class="fa fa-edit nav_icon icon_blue"></i></a>
                                     
                        <a  href="javascript:call_delete('<?=$row->prj_id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>

                      <? } ?>
                	</div></td>
                </tr>  

                <?}}?>

              </tbody>
            </table> 
            <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div> 
        </div>  
      </div> 

<div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
    <form data-toggle="validator" method="post" action="<?=base_url()?>wip/project/add" enctype="multipart/form-data">
  
  <div class="row">
		<div class="col-md-12 widget-shadow" data-example-id="basic-forms"> 
			<div class="form-body">
        
      <div class="col-md-6 form_padding">
        <div class="form-group has-feedback">
					<input type="text" class="form-control" name="project_mame" id="project_name"   placeholder="Project Name" data-error="" autocomplete="off"  required>
					<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
					<span class="help-block with-errors"></span>
				</div>
      </div>
                 
      <div class="col-md-6 form_padding">       
        <div class="form-group has-feedback">
          <textarea class="form-control" id="prj_description" name="prj_description" rows="8" placeholder="Description"></textarea>
          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <span class="help-block with-errors"></span>
        </div>
      </div>


      <div class="col-md-6 form_padding">  
      <div class="bottom validation-grids">                      
        <div class="form-group">
          <button type="submit" class="btn btn-primary disabled">Submit</button>
        </div>
        <br><br><div class="clearfix"> </div>
      </div>
    </div>

	   </div>
		</div>

    </div>
    <div class="clearfix"></div>  
		</form>   
    </div>
    </div>
  </div>
</div>

    <div class="col-md-4 modal-grids">
		<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
		<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-sm">
				<div class="modal-content"> 
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4> 
					</div> 
					<div class="modal-body" id="checkflagmessage">
					</div>
				</div>
			</div>
		</div>
	</div>
                    
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>wip/project/delete/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            
              $("#complexConfirm_confirm").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					
                    window.location="<?=base_url()?>wip/project/confirm/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            </script> 

        <div class="row calender widget-shadow"  style="display:none">
            <h4 class="title">Calender</h4>
            <div class="cal1">
                
            </div>
        </div>

        <div class="clearfix"> </div>
    </div>
</div></html>
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>