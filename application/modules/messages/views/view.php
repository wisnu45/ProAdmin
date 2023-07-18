<div class="message-container-<?php echo $message_info->id; ?>">
    <?php
    if ($mode === "inbox") {
        if ($is_reply) {
            $user_image = $this->session->get_userdata()['user_details'][0]->profile_pic;
        } else {
            $user_image = $message_info->user_image;
        }
    } if ($mode === "sent_items") {
        if ($is_reply) {
            $user_image = $message_info->user_image;
        } else {
            $user_image = $this->session->get_userdata()['user_details'][0]->profile_pic;
        }
    }
    ?>

    <div class="media b-b p15 m0 bg-white">
        <div class="media-left"> 
            <span class="avatar avatar-sm">
                <img src="<?php echo get_avatar($user_image); ?>" alt="..." />
            </span>
        </div>
        <div class="media-body w100p">
            <div class="media-heading clearfix">
                <?php if ($mode === "sent_items" && $is_reply != "1" || $mode === "inbox" && $is_reply == "1") { ?>
                    <label class="label label-success large"><?php echo lang('to'); ?></label>
                <?php } ?>
                <?php 
                //echo get_team_member_profile_link($message_info->from_user_id, $message_info->user_name, array("class" => "dark strong")); 
                echo js_anchor($message_info->user_name, array("class" => "dark strong"));

                ?>
                <span class="text-off pull-right"><?php echo format_to_relative_time($message_info->created_at); ?></span>

                <span class="pull-right dropdown" style="position: absolute; right: 30px; margin-top: 15px;">
                    <div class="text-off dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true" >
                        <i class="fa fa-chevron-down clickable"></i>
                    </div>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><?php echo ajax_anchor(base_url("messages/deleteMyMessages/$message_info->id"), "<i class='fa fa-times'></i> " . lang('delete'), array("class" => "", "title" => lang('delete'), "data-fade-out-on-success" => ".message-container-$message_info->id")); ?> </li>
                    </ul>
                </span>
            </div>
            <p class="p5 b-b b-turquoise">
                Subject:  <?php echo $message_info->subject; ?>  
            </p>

            <p>
                <?php echo nl2br(link_it($message_info->message)); ?>
            </p>
            <p>
                <?php
                $files = unserialize($message_info->files);
                $total_files = count($files);

                if ($total_files) {
                    $download_caption = 'Download';
                    if ($total_files > 1) {
                        $download_caption = sprintf('Download %s files', $total_files);
                    }
                    echo "<i class='fa fa-paperclip pull-left font-16'></i>";
                    echo anchor(base_url("messages/downloadmessagefiles/" . encode_id($message_info->id, "message_id")), $download_caption, array("class" => "", "title" => $download_caption));

                   
                }
                ?>
            </p>

        </div>
    </div>

    <?php foreach ($replies as $reply_info) { ?>
        <?php $this->load->view("messages/reply_row", array("reply_info" => $reply_info)); ?>
    <?php } ?>

    <div id="reply-form-container" class="pr15">
        <div id="reply-form-dropzone" class="post-dropzone">
            <?php echo form_open(base_url("messages/reply"), array("id" => "message-reply-form", "class" => "general-form", "role" => "form")); ?>
            <div class="p15 box b-b">
                <div class="box-content avatar avatar-md pr15">
                    <img src="<?php echo get_avatar($this->session->get_userdata()['user_details'][0]->profile_pic); ?>" alt="..." />
                </div>
                <div class="box-content form-group">
                    <input type="hidden" name="message_id" value="<?php echo $encrypted_message_id; ?>">
                    <?php
                    echo form_textarea(array(
                        "id" => "reply_message",
                        "name" => "reply_message",
                        "class" => "form-control",
                        "placeholder" => lang('write_a_reply').'...',
                        "required" => true,
                    ));
                    ?>
                    
                    <div class="post-file-dropzone-scrollbar hide">
                        <div class="post-file-previews clearfix b-t"> 
                            <div class="post-file-upload-row dz-image-preview dz-success dz-complete pull-left">
                                <div class="preview" style="width:85px;">
                                    <img data-dz-thumbnail class="upload-thumbnail-sm" />
                                    <span data-dz-remove="" class="delete">×</span>
                                    <div class="progress progress-striped upload-progress-sm active m0" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <footer class="panel-footer b-a clearfix ">
                        <button class="btn btn-default upload-file-button pull-left btn-sm round" type="button" style="color:#7988a2"><i class="material-icons">camera_enhance</i> <?php echo lang('upload_file') ?></button>
                        <button class="btn btn-primary pull-right btn-sm " type="submit"><i class="material-icons">replay</i> <?php echo lang('reply'); ?></button>
                    </footer>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var uploadUrl = "<?php echo base_url("messages/uploadfile"); ?>";
            var validationUrl = "<?php echo base_url("messages/validatemessagefile"); ?>";
            var dropzone = attachDropzoneWithForm("#reply-form-dropzone", uploadUrl, validationUrl);

            var frm = $('#message-reply-form');
            frm.submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: frm.serialize(),
                    dataType: 'json',
                    success: function (result) {
                        console.log(result.data);
                        $("#reply_message").val("");
                        $(result.data).insertBefore("#reply-form-container");

                        appAlert.success(result.message, {duration: 10000});
                        if (dropzone) {
                            dropzone.removeAllFiles();
                        }
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(result);
                    },
                });
            });

        });


    </script>
</div>
