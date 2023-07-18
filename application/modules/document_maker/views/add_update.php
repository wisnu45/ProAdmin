<form action="<?php echo base_url()."document_maker/addedit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($data->document_maker_id)){?><input type="hidden"  name="id" value="<?php echo isset($data->document_maker_id) ?$data->document_maker_id : "";?>"> <?php } ?>
 <div class="box-body">
 <div class="form-group form-float">
<div class="form-line">
<input type="text" class="form-control" id="document_maker_titlea" name="document_maker_titlea" required value="<?php echo isset($data->document_maker_titlea)?$data->document_maker_titlea:"";?>"  >
<label for="document_maker_titlea" class="form-label"><?php echo lang('titlea'); ?> <span class="text-red">*</span></label>
</div>
</div>
<div class="form-group form-float">
<div class="form-line">
<textarea rows="3" class="form-control" id="document_maker_description" name="document_maker_description" ><?php echo isset($data->document_maker_description)?$data->document_maker_description:"";?></textarea>
<label for="document_maker_description" class="form-label"><?php echo lang('description'); ?> </label>
</div>
</div>
<div class="form-group form-float">
<div class="form-line">
<select name="document_maker_status" class="form-control" id="document_maker_status"  required>
<option value=""></option>
<option value="Active" <?php if(isset($data->document_maker_status) && ($data->document_maker_status == "Active")){ echo "selected";}?>><?php echo lang('active'); ?></option>
<option value="Inactive" <?php if(isset($data->document_maker_status) && ($data->document_maker_status == "Inactive")){ echo "selected";}?>><?php echo lang('inactive'); ?></option>
</select>
<label for="document_maker_status" class="form-label"><?php echo lang('status'); ?> <span class="text-red">*</span></label>
</div>
</div>
<div class="form-group form-float">
<label for="document_maker_public" class="form-label"><?php echo lang('public'); ?></label>
<br>
<input type="radio" id="document_maker_public1" name="document_maker_public"  value="Yes" <?php if(isset($data->document_maker_public) && ($data->document_maker_public =='Yes')){echo 'checked="checked"';} if(!isset($data->document_maker_public)) { echo 'checked="checked"'; } ?>>
<label for="document_maker_public1"><?php echo lang('yes'); ?></label>
<input type="radio" id="document_maker_public2" name="document_maker_public"  value="No" <?php if(isset($data->document_maker_public) && ($data->document_maker_public =='No')){echo 'checked="checked"';}?>>
<label for="document_maker_public2"><?php echo lang('no'); ?></label>
</div>


<div class="form-group form-float">
<label for="document_maker_enable_attachment" class="form-label"><?php echo lang('enable_attachment'); ?></label>
<br>
<input type="radio" id="document_maker_enable_attachment1" name="document_maker_enable_attachment"  value="Yes" <?php if(isset($data->document_maker_enable_attachment) && ($data->document_maker_enable_attachment=='Yes')){echo"checked='checked'";}?>>
<label for="document_maker_enable_attachment1"><?php echo lang('yes'); ?></label>
<input type="radio" id="document_maker_enable_attachment2" name="document_maker_enable_attachment"  value="No" <?php if(isset($data->document_maker_enable_attachment) && ($data->document_maker_enable_attachment=='No')){echo"checked='checked'";} if(!isset($data->document_maker_enable_attachment)) { echo 'checked="checked"'; } ?>>
<label for="document_maker_enable_attachment2"><?php echo lang('no'); ?></label>
</div>
        		<?php getCustomFields('document_maker', isset($data->document_maker_id)?$data->document_maker_id:NULL); ?>
        		</div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                  	 <input type="submit" value="<?php echo lang('save'); ?>" name="save" class="btn btn-primary btn-color">
                  </div>
               </form>
            <script>
  				$.AdminBSB.input.activate();
  				$(document).ready(function() {
				  $('.mka-cl').on('click', function() {
				    if($(this).parents('.input-group').first().find('input.mka-pass-field').hasClass('showing')){
				      $(this).parents('.input-group').first().find('input.mka-pass-field').removeClass('showing').attr('type', 'password');
				    } else {
				      $(this).parents('.input-group').first().find('input.mka-pass-field').addClass('showing').attr('type', 'text');
				    }
				  });
				});
			</script>