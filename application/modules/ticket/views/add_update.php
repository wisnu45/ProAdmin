<form action="<?php echo base_url()."ticket/addedit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
  <?php if(isset($data->ticket_id)){?>
    <input type="hidden"  name="id" value="<?php echo isset($data->ticket_id) ?$data->ticket_id : "";?>"> 
  <?php } ?>
  <div class="box-body">
    <div class="form-group form-float">
      <div class="form-line">
        <input type="text" class="form-control" id="ticket_ticket_title" name="ticket_ticket_title" required value="<?php echo isset($data->ticket_ticket_title)?$data->ticket_ticket_title:"";?>"  >
        <label for="ticket_ticket_title" class="form-label"><?php echo lang('ticket_title'); ?> <span class="text-red">*</span></label>
      </div>
    </div>
    <div class="form-group form-float">
      <div class="form-line">
        <label class="form-label"><?php echo lang('client'); ?> <span class="text-red">*</span></label>
        <?php echo selectBoxDynamic("ticket_client","ia_users","name",isset($data->ticket_client) ?$data->ticket_client : "", "required");?>
      </div>
    </div>
    <div class="form-group form-float">
      <div class="form-line">
        <select name="ticket_ticket_type" class="form-control" id="ticket_ticket_type"  required>
          <option value=""></option>
          <option value="General support" <?php if(isset($data->ticket_ticket_type) && ($data->ticket_ticket_type == "General support")){ echo "selected";}?>><?php echo lang('general_support'); ?></option>
        </select>
        <label for="ticket_ticket_type" class="form-label"><?php echo lang('ticket_type'); ?> <span class="text-red">*</span></label>
      </div>
    </div>
    <?php if(!isset($data->ticket_id)) { ?>
    <div class="form-group form-float">
      <div class="form-line">
        <textarea rows="3" class="form-control" id="ticket_description" name="ticket_description" required><?php echo isset($data->ticket_description)?$data->ticket_description:"";?></textarea>
        <label for="ticket_description" class="form-label"><?php echo lang('description'); ?> <span class="text-red">*</span></label>
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
    <input type="hidden" name="ticket_status" value="Open">
    <?php } ?>
    <div class="form-group form-float">
      <?php
        if( isset($data->ticket_upload_document) && !empty($data->ticket_upload_document)){ $req ="";}else{$req ="";}
        if(isset($data->ticket_upload_document)){
          $old_uploads = explode("," , $data->ticket_upload_document);
            foreach ($old_uploads as $old_upload) {
              if($old_upload != '') {
                
      ?>
            <div class="wpb_old_files">
              <input type="hidden"  name="wpb_old_ticket_upload_document[]" value="<?php echo isset($old_upload) ?$old_upload : "";?>" class="check_old">
              <a href="<?php echo iaBase().'assets/images/'.$old_upload ?>" download> <?php echo $old_upload; ?> </a> <span><i class="material-icons remove_old">close</i></span></div>
      <?php 
              }
            }
          } 
      ?>
          <input type="file" data="" placeholder="Upload Document" class="file-upload check_new" id="ticket_upload_document" name="ticket_upload_document[]" <?php echo $req; ?> multiple value="" onchange='validate_fileType(this.value,&quot;ticket_upload_document&quot;,&quot;jpg,pdf,docx,doc,xlsx,xls,png&quot;);' ><p id="error_ticket_upload_document"></p>
</div>

    <?php getCustomFields('ticket', isset($data->ticket_id)?$data->ticket_id:NULL); ?>
  
  <div class="form-group form-float">
    <div class="form-line"><label class="form-label"><?php echo lang('email_notification') ?></label>
      <select class="form-control"  id="repeat_every" name="repeat_every" >
          <option value=""></option>
          <option value="1-week" <?php if(isset($data) && $data->repeat_every == 1 && $data->recurring_type == 'week'){echo 'selected';} ?> >1 <?php echo lang('week'); ?> </option>
          <option value="2-week" <?php if(isset($data) && $data->repeat_every == 2 && $data->recurring_type == 'week'){echo 'selected';} ?>>2 <?php echo lang('week'); ?> </option>
          <option value="1-month" <?php if(isset($data) && $data->repeat_every == 1 && $data->recurring_type == 'month'){echo 'selected';} ?>>1 <?php echo lang('month'); ?> </option>
          <option value="2-month" <?php if(isset($data) && $data->repeat_every == 2 && $data->recurring_type == 'month'){echo 'selected';} ?>>2 <?php echo lang('month'); ?> </option>
          <option value="3-month" <?php if(isset($data) && $data->repeat_every == 3 && $data->recurring_type == 'month'){echo 'selected';} ?>>3 <?php echo lang('month'); ?> </option>
          <option value="6-month" <?php if(isset($data) && $data->repeat_every == 6 && $data->recurring_type == 'month'){echo 'selected';} ?>>6 <?php echo lang('month'); ?> </option>
          <option value="1-year" <?php if(isset($data) && $data->repeat_every == 1 && $data->recurring_type == 'year'){echo 'selected';} ?>>1 <?php echo lang('year'); ?> </option>
          <option value="custom" <?php if(isset($data) && $data->custom_recurring == 1){echo 'selected';} ?>>Custom </option>
        </select>
    </div>
  </div>


  <div class="recurring_custom <?php if((isset($data) && $data->custom_recurring != 1) || (!isset($data))){echo 'hide';} ?>" id="recurring_custom">
  <div class="row">
    <div class="col-md-6">
    <div class="form-group form-float">
    <div class="form-line"><input type="number" class="form-control" id="repeat_every_custom" name="repeat_every_custom" value="<?php echo (isset($data) && $data->custom_recurring == 1 ? $data->repeat_every : ''); ?>">
    <label for="repeat_every_custom" class="form-label"><?php echo lang('value'); ?></label>
    </div>
    </div>
  </div>

    <div class="col-md-6">
    <div class="form-group form-float">
      <div class="form-line"><label class="form-label"><?php echo lang('email_every'); ?></label>
        <select class="form-control"  name="repeat_type_custom" id="repeat_type_custom">
            <option value="day" <?php if(isset($data) && $data->custom_recurring == 1 && $data->recurring_type == 'day'){echo 'selected';} ?>>Day(s) </option>
            <option value="week" <?php if(isset($data) && $data->custom_recurring == 1 && $data->recurring_type == 'week'){echo 'selected';} ?>><?php echo lang('week'); ?>(s) </option>
            <option value="month" <?php if(isset($data) && $data->custom_recurring == 1 && $data->recurring_type == 'month'){echo 'selected';} ?>><?php echo lang('month'); ?>(s) </option>
            <option value="year" <?php if(isset($data) && $data->custom_recurring == 1 && $data->recurring_type == 'year'){echo 'selected';} ?>><?php echo lang('year'); ?>(s) </option>
          </select>
      </div>
    </div>
  </div>

  </div>
</div>

<div class="<?php if(!isset($data) || (isset($data) && $data->recurring == 0)){echo 'hide';}?>" id="recurring_ends_on">
<div class="form-group form-float">
<div class="form-line recurring_ends_on"><input type="date" class="form-control" id="recurring_ends_on" name="recurring_ends_on" value="<?php echo (isset($data) ? $data->recurring_ends_on : 'mm/dd/yyyy'); ?>"  >
<label for="expenses_date" class="form-label"><?php echo lang('ends_on_leave_blank_for_never'); ?></label>
</div>
</div>
</div>


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
</script>