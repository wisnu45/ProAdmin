<form action="<?php echo base_url()."products/add_edit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($data->products_id)){?><input type="hidden"  name="id" value="<?php echo isset($data->products_id) ?$data->products_id : "";?>"> <?php } ?>
 <div class="box-body"><div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="product_name" name="product_name" required value="<?php echo isset($data->product_name)?$data->product_name:"";?>"  >
<label for="product_name" class="form-label"><?php echo lang('product_name'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="number" class="form-control" id="quantity" name="quantity" required value="<?php echo isset($data->quantity)?$data->quantity:"";?>"  >
<label for="quantity" class="form-label"><?php echo lang('quantity'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="number" class="form-control" id="unit_price" name="unit_price" required value="<?php echo isset($data->unit_price)?$data->unit_price:"";?>"  >
<label for="unit_price" class="form-label"><?php echo lang('unit_price'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><textarea rows="3" class="form-control" id="product_details" name="product_details" ><?php echo isset($data->product_details)?$data->product_details:"";?></textarea>
<label for="product_details" class="form-label"><?php echo lang('product_details'); ?> </label>
</div></div>
<div class="form-group form-float">
<?php
                        if( isset($data->product_image) && !empty($data->product_image)){ $req ="";}else{$req ="";}
						if(isset($data->product_image))
						{
							$old_uploads = explode("," , $data->product_image);
							foreach ($old_uploads as $old_upload) {
							?>
							<div class="wpb_old_files">
							<input type="hidden"  name="wpb_old_product_image[]" value="<?php echo isset($old_upload) ?$old_upload : "";?>" class="check_old">
							<a href="<?php echo base_url().'assets/images/'.$old_upload ?>" download> <?php echo $old_upload; ?> </a> <span><i class="material-icons remove_old">close</i></span></div>
						<?php
							}
						}
						?>
						<input type="file" data="" placeholder="Product Image" class="file-upload check_new" id="product_image" name="product_image[]" <?php echo $req; ?>  value="" onchange='validate_fileType(this.value,&quot;product_image&quot;,&quot;pdf,jpg,png,jpeg&quot;);' ><p id="error_product_image"></p>
</div>

        		<?php get_custom_fields('products', isset($data->products_id)?$data->products_id:NULL); ?>
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