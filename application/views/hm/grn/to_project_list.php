<label class="control-label" >To Project</label>
  <select id="prj2" name="prj2" class="form-control" required="required">
    <option value="">select project</option>
      <?
        foreach($prjlist2 as $prj2){
      ?>
        <option value="<?=$prj2->prj_id?>"><?=$prj2->project_name?></option>
      <?
        }
      ?>
  </select>


  <script type="text/javascript">
          
         $('#prj2 option').each(function(){
          var prj1val = "<?=$prjid;?>";
          if ($(this).val() == prj1val){
              $(this).remove();
          }
         });

  </script>