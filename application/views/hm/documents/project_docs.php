 <script type="text/javascript">

   
 function load_printscrean1(id,type_id)
{
			window.open( "<?=base_url()?>hm/customerletter/letter_print/"+id+"/"+type_id );
	
}


 </script>
 <style type="text/css">
 
 
 </style>
 
  <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

    <br />
					 <table class="table"> <thead> <tr> <th>Document Name</th> <th>Document</th> </tr> </thead>
                      <?  if($typelist){$c=0;
                          foreach($typelist as $row){?>
                   <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                     <td><?=$c?></td>
                      <td><?=$row->document_name?></td>
                     <td><input type="file" class="form-control" id="document<?=$row->doctype_id?>" name="document<?=$row->doctype_id?>"  placeholder="plan_copy By"/></td>
                     <td  valign="bottom"><? if($doclist[$row->doctype_id]!='' ){?> <a  href="<?=base_url()?>uploads/project/<?=$doclist[$row->doctype_id]?>" target="_blank"><i class="fa fa-download nav_icon"></i><?=$doclist[$row->doctype_id]?></a><? }?></td>
                    
                      </tr>
                    
                     
                      
                                <? }} ?>
                          </tbody></table>  
                            <div class="bottom  " style="float:right; margin-right:10px;">
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled">Update</button>
											</div>
											<div class="clearfix"> </div>
										</div>
                          
</div>
</div>
