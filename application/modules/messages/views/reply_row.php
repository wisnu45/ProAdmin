<div class="media b-b p15 m0 bg-white">
    <div class="media-left">
        <span class="avatar avatar-sm">
            <img src="<?php echo get_avatar($reply_info->user_image); ?>" alt="..." />
        </span>
    </div>
    <div class="media-body w100p">
        <div class="media-heading">
            <strong><?php
                if ($reply_info->from_user_id === $this->session->get_userdata()['user_details'][0]->ia_users_id) {
                    echo "me";
                } else {
                    echo get_team_member_profile_link($reply_info->from_user_id, $reply_info->user_name, array("class" => "dark strong"));
                }
                ?>
            </strong>
            <span class="text-off pull-right"><?php echo format_to_relative_time($reply_info->created_at); ?></span>
        </div>
        <p><?php echo nl2br(link_it($reply_info->message)); ?></p>

        <p>
            <?php
            $files = unserialize($reply_info->files);
            $total_files = count($files);

            if ($total_files) {
                $download_caption = 'Download';
                if ($total_files > 1) {
                    $download_caption = sprintf('Download %s files', $total_files);
                }
                echo "<i class='fa fa-paperclip pull-left font-16'></i>";
                echo anchor(base_url("messages/downloadmessagefiles/" . encode_id($reply_info->id, "message_id")), $download_caption, array("class" => "", "title" => $download_caption));
            }
            ?>
        </p>
    </div>
</div>