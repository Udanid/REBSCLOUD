 <script type="text/javascript">

   
 function load_printscrean1(id,type_id)
{
			window.open( "<?=base_url()?>re/customerletter/letter_print/"+id+"/"+type_id );
	
}


 </script>
 <style type="text/css">
 
 
 </style>
 
  <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

    <br />
					 <table class="table"> <thead> <tr> <th width="60">Type</th> <th>Document Number</th> <th>Drawn/Attest By</th>  <th>Drawn/Attest Date </th> <th>Document</th><th width="110"></th></tr> </thead>
                      <? if($details){$c=0;
                          foreach($details as $row){?>
                     <tr><th>Plan</th>
                     <td><input type="text" class="form-control" id="plan_no<?=$row->id?>" name="plan_no<?=$row->id?>"  placeholder="Attest By" value="<?=$row->plan_no?>" /></td>
                     <td><input type="text" class="form-control" id="drawn_by<?=$row->id?>" name="drawn_by<?=$row->id?>"  placeholder="Attest By" value="<?=$row->drawn_by?>" /></td>
                     <td><input type="text" class="form-control" id="drawn_date<?=$row->id?>" name="drawn_date<?=$row->id?>"  placeholder="Attest By" value="<?=$row->drawn_date?>" /></td>
                     <td><input type="file" class=" form-control" id="plan_copy<?=$row->id?>" name="plan_copy<?=$row->id?>"  placeholder="plan_copy By" value="<?=$row->plan_no?>" /></td>
                     <td  valign="bottom"><? if($row->plan_copy){?> <a  href="<?=base_url()?>uploads/land/documents/<?=$row->plan_copy?>" target="_blank"><i class="fa fa-download nav_icon"></i><?=$row->plan_copy?></a><? }?></td>
                    
                      </tr>
                       <tr><th>Deed</th>
                     <td><input type="text" class="form-control" id="deed_no<?=$row->id?>" name="deed_no<?=$row->id?>"  placeholder="Attest By" value="<?=$row->deed_no?>" /></td>
                     <td><input type="text" class="form-control" id="attest_by<?=$row->id?>" name="attest_by<?=$row->id?>"  placeholder="Attest By" value="<?=$row->attest_by?>" /></td>
                     <td><input type="text" class="form-control" id="attest_date<?=$row->id?>" name="attest_date<?=$row->id?>"  placeholder="Attest By" value="<?=$row->attest_date?>" /></td>
                     <td><input type="file" class="form-control" id="deed_copy<?=$row->id?>" name="deed_copy<?=$row->id?>"  placeholder="plan_copy By" value="<?=$row->deed_copy?>" /></td>
                     <td  valign="bottom"><? if($row->deed_copy){?> <a  href="<?=base_url()?>uploads/land/documents/<?=$row->deed_copy?>" target="_blank"><i class="fa fa-download nav_icon"></i><?=$row->deed_copy?></a><? }?></td>
                    
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
