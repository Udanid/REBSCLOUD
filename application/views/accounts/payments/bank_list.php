 <select class="form-control" name="banks" id="banks"  required >
                                                                <option value="">Select Bank Account</option>
                                                                <? if($banks){foreach($banks as $raw){?>
                                                                    <option value="<?=$raw->id?>" ><?=$raw->ref_id?> - <?=$raw->name?></option>
                                                                <? }}?>
                                                            </select>