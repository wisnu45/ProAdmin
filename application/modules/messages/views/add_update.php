<!-- <link href="<?php //echo mka_base(); ?>assets/style2.css" rel="stylesheet"> -->
<style>
  <?php $this->load->view('assets/style2.css'); ?>
  <?php $this->load->view('assets/select2/select2.css'); ?>
</style>

<div id="new-message-dropzone" class="post-dropzone">
<?php echo form_open(base_url("messages/sendmessage"), array("id" => "message-form", "class" => "general-form", "role" => "form")); ?>
 
<div class="modal-body clearfix">

	 <div class="form-group">

    <label for="to_user_id" class=" col-md-2"><?php echo lang('to'); ?></label>
    <div class="col-md-10">
        <select class="form-control"  id="to_user_id" name="to_user_id" required="required">
          <option value=""><?php echo lang('select_user'); ?> </option>
          <?php 
          foreach ($users_dropdown2 as $user) { ?>
            <option value="<?php echo $user->ia_users_id;?>" > <?php echo $user->name;?> </option>
          <?php } ?>
        </select>
    </div>
  </div> 

<div class="form-group form-float">
    <label for="subject" class=" col-md-2"><?php echo lang('subject'); ?></label>
    <div class=" col-md-10">
        <?php
        echo form_input(array(
            "id" => "subject",
            "name" => "subject",
            "class" => "form-control",
            "placeholder" => lang('Subject'),
            "required" => 'required',
        ));
        ?>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <?php
        echo form_textarea(array(
            "id" => "message",
            "name" => "message",
            "class" => "form-control",
            "placeholder" => lang('write_a_message'),
            "required" => 'required',
            "style" => "min-height:200px;"
        ));
        ?>
    </div>
</div>

<div class="form-group">
            <div class="col-md-12">
                
                <div class="post-file-dropzone-scrollbar hide">
                    <div class="post-file-previews clearfix b-t"> 
                        <div class="post-file-upload-row dz-image-preview dz-success dz-complete pull-left">
                            <div class="preview" style="width:85px;">
                                <img data-dz-thumbnail class="upload-thumbnail-sm" />
                                <span data-dz-remove="" class="delete">×</span>
                                <div class="progress progress-striped upload-progress-sm active m0" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
</div>



        		</div>
                  <!-- /.box-body -->
                  <div class="modal-footer">

                  	<button class="btn btn-default upload-file-button pull-left btn-sm round" type="button" style="color:#7988a2"><i class="material-icons">camera_enhance</i> <?php echo lang('upload_file'); ?></button>

                  	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="material-icons">close</i> <?php echo lang('close'); ?></button>

                  	 <button type="submit" class="btn btn-primary"><i class="material-icons">send</i> <?php echo lang('send'); ?> </button>

                  </div>
               <?php echo form_close(); ?>
</div>
            <script>
  		
<?php $this->load->view('assets/app.js'); ?>
<?php $this->load->view('assets/general_helper.js'); ?>
<?php $this->load->view('assets/select2/select2.js'); ?>


			
			</script>

			<script type="text/javascript">
			    $(document).ready(function() {
			        var uploadUrl = "<?php echo base_url(). "messages/uploadfile";?>";
			        var validationUrl = "<?php echo base_url(). "messages/validatemessagefile";?>";

			        var dropzone = attachDropzoneWithForm("#new-message-dropzone", uploadUrl, validationUrl);

			        /*$("#message-form").appForm({
			            onSuccess: function(result) {
			        	alert('ss');
			                //$("#message-table").appTable({newData: result.data, dataId: result.id});
			                appAlert.success(result.message, {duration: 10000});
			            }
			        });*/

			        $("#message-form .select2").select2();
			    });
			</script> 