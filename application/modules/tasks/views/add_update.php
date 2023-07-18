<form action="<?php echo base_url()."tasks/addedit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
  <?php if(isset($data->id)){?>
    <input type="hidden"  name="id" value="<?php echo isset($data->id) ?$data->id : "";?>">
  <?php } ?>
  <div class="box-body">
    <div class="form-group form-float">
      <div class="form-line">
        <input type="text" class="form-control" id="title" name="title" required value="<?php echo isset($data->title)?$data->title:"";?>"  >
        <label for="title" class="form-label"><?php echo "Task Title"; ?> <span class="text-red">*</span></label>
      </div>
    </div>
    <div class="form-group form-float">
      <div class="form-line">
        <label class="form-label"><?php echo "Project"; ?> <span class="text-red">*</span></label>
        <?php echo selectBoxDynamic("project_id","projects","title",isset($data->project_id) ?$data->project_id : "", "");?>
      </div>
    </div>
    <div class="form-group form-float">
      <div class="form-line">
        <label class="form-label"><?php echo "Assigned To"; ?> <span class="text-red">*</span></label>
        <?php echo selectBoxDynamic("assigned_to","ia_users","name",isset($data->assigned_to) ?$data->assigned_to : "", "required");?>
      </div>
    </div>
    <div class="form-group form-float">
      <div class="form-line">
        <input type="text" class="form-control" id="collaborators" name="collaborators" required value="<?php echo isset($data->collaborators)?$data->collaborators:"";?>"  >
        <label for="collaborators" class="form-label"><?php echo "Collaborators"; ?> <span class="text-red">*</span></label>
      </div>
    </div>
    <div class="form-group form-float">
      <div class="form-line">
        <label class="form-label"><?php echo "Status"; ?> <span class="text-red">*</span></label>
        <?php echo selectBoxDynamic("status","task_status","title",isset($data->status_id) ?$data->status_id : "", "required");?>

        <input type="hidden" id="status_id" name="status_id" value="<?php echo isset($data->status_id) ?$data->status_id : "";?>"> 
      </div>
    </div>
    <div class="form-group form-float">
      <div class="form-line">
        <input type="text" class="form-control" id="labels" name="labels" required value="<?php echo isset($data->labels)?$data->labels:"";?>"  >
        <label for="labels" class="form-label"><?php echo "Labels"; ?> <span class="text-red">*</span></label>
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
    <?php if(!isset($data->id)) { ?>
    <div class="form-group form-float">
      <div class="form-line">
        <textarea rows="3" class="form-control" id="description" name="description" required><?php echo isset($data->description)?$data->description:"";?></textarea>
        <label for="description" class="form-label"><?php echo lang('description'); ?> <span class="text-red">*</span></label>
      </div>
    </div>
    <!-- <div class="form-group form-float">
      <div class="form-line">
        <select name="ticket_status" class="form-control" id="ticket_status"  required>
          <option value=""></option>
          <option value="Open" <?php //if(isset($data->ticket_status) && ($data->ticket_status == "Open")){ echo "selected";}?>><?php //echo lang('open'); ?></option>
          <option value="Close" <?php //if(isset($data->ticket_status) && ($data->ticket_status == "Close")){ echo "selected";}?>><?php //echo lang('close'); ?></option>
        </select>
        <label for="ticket_status" class="form-label"><?php //echo lang('status'); ?> <span class="text-red">*</span></label>
      </div>
    </div> -->
    <!-- <input type="hidden" name="ticket_status" value="Open"> -->
    <?php } ?>
    

    <?php getCustomFields('tasks', isset($data->id)?$data->id:NULL); ?>
  
  
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

    $('body').on('change', '[name="repeat_every"]', function() {
      var val = $(this).val();
      if (val == 'custom') {
          $('.recurring_custom').removeClass('hide');
          $('body').find('#recurring_ends_on input').val('');
      } else {
          $('.recurring_custom').addClass('hide');
      }
      if (val != '') {
          $('body').find('#recurring_ends_on').removeClass('hide');
      } else {
          $('body').find('#recurring_ends_on').addClass('hide');
          $('body').find('#recurring_ends_on input').val('');
      }
    });
    $('body').find('.recurring_ends_on').addClass('focused');
    $('body').find('#recurring_ends_on input').blur(function(){
        $('body').find('#recurring_ends_on input').focus();
    });

  });


$( "select#status" )
  .change(function() {
    var str = "";
    $( "select#status option:selected" ).each(function() {
      str += $( this ).val();
    });
    console.log("str->",str);
    $( "#status_id" ).val( str );
  })
  .trigger( "change" );
</script>