<form action="<?php echo base_url()."projects/addedit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($data->id)){?><input type="hidden"  name="id" value="<?php echo isset($data->id) ?$data->id : "";?>"> <?php } ?>
 <input type="hidden" name="created_by" value="<?php echo $this->user_id; ?>">
 <div class="box-body">
 <div class="form-group form-float">
<div class="form-line">
<input type="text" class="form-control" id="title" name="title" required value="<?php echo isset($data->title)?$data->title:"";?>"  >
<label for="title" class="form-label"><?php echo "Title"; ?> <span class="text-red">*</span></label>
</div>
</div>
<div class="form-group form-float">
  <div class="form-line">
    <label class="form-label"><?php echo "Client"; ?> <span class="text-red">*</span></label>
    <?php echo selectBoxDynamic("client_id","clients","company_name",isset($data->client_id) ?$data->client_id : "", "");?>
  </div>
</div>
<div class="form-group form-float">
<div class="form-line">
<textarea rows="3" class="form-control" id="description" name="description" ><?php echo isset($data->description)?$data->description:"";?></textarea>
<label for="description" class="form-label"><?php echo "description"; ?> </label>
</div>
</div>
  <div class="form-group form-float">
    <div class="form-line recurring_ends_on focused"><input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo isset($data->start_date)?$data->start_date:"mm/dd/yyyy";?>">
    <label for="expenses_date" class="form-label">Start Date</label>
    </div>
  </div>
  <div class="form-group form-float">
    <div class="form-line recurring_ends_on focused"><input type="date" class="form-control" id="deadline" name="deadline" value="<?php echo isset($data->deadline)?$data->deadline:"mm/dd/yyyy";?>">
    <label for="expenses_date" class="form-label">Start Date</label>
    </div>
  </div>
<div class="form-group form-float">
<div class="form-line">
<input type="text" class="form-control" id="price" name="price" required value="<?php echo isset($data->price)?$data->price:"";?>"  >
<label for="price" class="form-label"><?php echo "Price"; ?> <span class="text-red">*</span></label>
</div>
</div>
<div class="form-group form-float">
<div class="form-line">
<input type="text" class="form-control" id="labels" name="labels" required value="<?php echo isset($data->labels)?$data->labels:"";?>"  >
<label for="labels" class="form-label"><?php echo "Label"; ?> <span class="text-red">*</span></label>
</div>
</div>
<?php if (isset($data->id)) { ?>
<div class="form-group form-float">
<div class="form-line">
<select name="status" class="form-control" id="status"  required>
<option value=""></option>
<option value="open" <?php if(isset($data->status) && ($data->status == "open")){ echo "selected";}?>><?php echo "Open"; ?></option>
<option value="completed" <?php if(isset($data->status) && ($data->status == "completed")){ echo "selected";}?>><?php echo "Completed"; ?></option>
<option value="hold" <?php if(isset($data->status) && ($data->status == "hold")){ echo "selected";}?>><?php echo "Hold"; ?></option>
<option value="cancelled" <?php if(isset($data->status) && ($data->status == "cancelled")){ echo "selected";}?>><?php echo "Cancelled"; ?></option>
</select>
</div>
</div>
<?php } ?>

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