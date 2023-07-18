<div class="modal-body">
    <div class="table-responsive mb15">
        <div class="col-md-12">
            <h4 class="mt0">
                <?php
                echo "<span style='color:" . $model_info->color . "' class='pull-left mr10'><i class='fa $event_icon'></i></span> " . $model_info->title;
                ?>
            </h4>

        </div>
        <div class="col-md-12 pb10 ">
            
            <i class="material-icons">watch_later</i>
            <?php
            $this->load->view("events/event_time");
            ?>
        </div>

        <div class="col-md-12 pb10">
            <?php echo $labels; ?>
        </div>

        <div class="col-md-12">
            <blockquote class="font-14 text-justify" style="<?php echo "border-color:" . $model_info->color; ?>"><?php echo nl2br($model_info->description); ?></blockquote>
        </div>


        <?php if ($model_info->location) { ?>
            <div class="col-md-12 mt5">
                <div class="font-14"><i class="material-icons">add_location</i>   <?php echo nl2br($model_info->location); ?></div>
            </div>
        <?php }
        ?>

        <div class="col-md-12 p-t-10">
            <?php
            $image_url = iaBase() . "/assets/images/" .$model_info->created_by_avatar;
            echo "Created by - <span class='avatar avatar-xs mr10'><img src='$image_url' alt='' height='20' width='20' style='margin-top: 11px;'></span> <span style='padding-left:inherit;'> ".$model_info->created_by_name."</span>";
            ?>
        </div>

    </div>
</div>

<div class="modal-footer">
    <?php
    if (CheckPermission('events', "all_delete")) {
    ?>
      <a href="#" class="btn btn-danger btn-xs pull-left waves-effect" id= "delete_event" data-encrypted_event_id ="<?php echo $encrypted_event_id; ?>" data-toggle="modal" data-target="#cnfrm_delete"> <i class='fa fa-times-circle-o'></i> <?php echo lang("delete_event");?> </a>
    <?php
    } else if (CheckPermission('events', "own_delete")) {
        if (isset($editable) && $editable === "1" && ($this->user_id == $model_info->created_by)) {
    ?>
        <a href="#" class="btn btn-danger btn-xs pull-left waves-effect" id= "delete_event" data-encrypted_event_id ="<?php echo $encrypted_event_id; ?>" data-toggle="modal" data-target="#cnfrm_delete"> <i class='fa fa-times-circle-o'></i> <?php echo lang("delete_event");?> </a>
    <?php   
        }
    }
    
    if (CheckPermission('events', "all_update")) {
    ?>
        
        <a href="#" data-act="ajax-modal" data-title="<?php echo lang("edit_event");?>" data-action-url="<?php echo base_url('events/modalform'); ?>" class="btn btn-primary btn-xs waves-effect" title="<?php echo lang("edit_event");?>"  data-post-encrypted_event_id ="<?php echo $encrypted_event_id; ?>"> <i class='fa fa-pencil'></i> <?php echo lang("edit_event");?> </a>
        
    <?php
    } else if (CheckPermission('events', "own_update")) {
        if (isset($editable) && $editable === "1" && ($this->user_id == $model_info->created_by)) {
    ?>
        <a href="#" data-act="ajax-modal" data-title="<?php echo lang("edit_event");?>" data-action-url="<?php echo base_url('events/modalform'); ?>" class="btn btn-primary btn-xs waves-effect" title="<?php echo lang("edit_event");?>"  data-post-encrypted_event_id ="<?php echo $encrypted_event_id; ?>"> <i class='fa fa-pencil'></i> <?php echo lang("edit_event");?> </a>
    <?php   
        }
    }
    ?>
    <button type="button" class="btn btn-info close-modal" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang("close");?> </button>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#delete_event').on('click', function(){
            var url =  $('body').attr('data-base-url');
            var id = $(this).attr('data-encrypted_event_id');
            $("#cnfrm_delete").find("a.yes-btn").attr("href","javascript:void(0);");
            $("#cnfrm_delete").find("a.yes-btn").attr("requested_url",url+"events/delete");
            $("#cnfrm_delete").find("a.yes-btn").attr("data-encrypted_event_id",id);
            $("#cnfrm_delete").find("a.yes-btn").addClass("events_delete");
        });
    });

    $(document).on('click', '.events_delete', function(){
        $.ajax({
            url: $(this).attr('requested_url'),
            type: 'POST',
            dataType: 'json',
            data: {encrypted_event_id: $(this).attr('data-encrypted_event_id')},
            success: function (result) {
                if (result.success) {
                    $('#cnfrm_delete').modal('hide');
                    $('#ajaxModal').modal('hide');
                    $("#event-calendar").fullCalendar('refetchEvents');
                } else {
                    
                }
            }
        });
    });
</script>    

<style type="text/css">
    blockquote{
        background: rgba(242, 242, 242, 0.42);
    }
    img{
        border-radius: 10px;
    }
    .material-icons{
        font-size: 19px;
        vertical-align: bottom;
    }
</style>
