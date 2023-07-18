<form action="<?php echo base_url()."invoice/add_edit_customers"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($data->customers_id)){?><input type="hidden"  name="id" value="<?php echo isset($data->customers_id) ?$data->customers_id : "";?>"> <?php } ?>
 <div class="box-body"><div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="name" name="name" required value="<?php echo isset($data->name)?$data->name:"";?>"  >
<label for="name" class="form-label"><?php echo lang('name'); ?> <span class="text-red">*</span></label>
</div></div>

        		<?php get_custom_fields('customers', isset($data->customers_id)?$data->customers_id:NULL); ?>
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