<form action="" id="form_advanced_validation" class="events-form" role="form" method="post" accept-charset="utf-8">

<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group form-float p-r-15 p-l-15">
        <div class="form-line">
            <input type="text" id="title" class="form-control" name="title" required value="<?php echo $model_info->title; ?>" autofocus="1">
            <label class="form-label"><?php echo lang("title");?></label>
        </div>
        
    </div>
    <div class="form-group form-float p-r-15 p-l-15">
        <div class="form-line">
            <textarea rows="7" required class="form-control no-resize auto-growth" id="description" name="description"><?php echo $model_info->description; ?></textarea>
            <label class="form-label"><?php echo lang("description");?></label>
        </div>
        
    </div>
    <div class="form-group form-float p-r-15 p-l-15">
        <div class="form-line">
            <input type="text" id="start_date" class="start_datepicker form-control" name="start_date" required value="<?php echo $model_info->start_date; ?>">
            <label class="form-label"><?php echo lang("start_date");?></label>
        </div>
        
    </div>
    <?php
    $start_time = $model_info->start_time ? $model_info->start_time : "";
    if ($time_format_24_hours) {
        $start_time = $start_time ? date("H:i", strtotime($start_time)) : "";
    } else {
        $start_time = $start_time ? convert_time_to_12hours_format(date("H:i:s", strtotime($start_time))) : "";
    }
    ?>
    <div class="form-group form-float p-r-15 p-l-15">
        <div class="form-line">
            <input type="text" id="start_time" class="timepicker form-control" name="start_time" required value="<?php echo $start_time; ?>" >
            <label class="form-label"><?php echo lang("start_time");?></label>
        </div>
        
    </div>
    <div class="form-group form-float p-r-15 p-l-15">
        <div class="form-line">
            <input type="text" id="end_date" class="end_datepicker form-control" name="end_date" required value="<?php echo $model_info->end_date; ?>">
            <label class="form-label"><?php echo lang("end_date");?></label>
        </div>
        
    </div>
    <?php
    $end_time = $model_info->end_time ? $model_info->end_time : "";

    if ($time_format_24_hours) {
        $end_time = $end_time ? date("H:i", strtotime($end_time)) : "";
    } else {
        $end_time = $end_time ? convert_time_to_12hours_format(date("H:i:s", strtotime($end_time))) : "";
    }
    ?>
    <div class="form-group form-float p-r-15 p-l-15">
        <div class="form-line">
            <input type="text" id="end_time" class="timepicker form-control" name="end_time" required value="<?php echo $end_time; ?>">
            <label class="form-label"><?php echo lang("end_time");?></label>
        </div>
        
    </div>

    <div class="form-group form-float p-r-15 p-l-15">
        <div class="form-line">
            <input type="text" id="location" class="form-control" name="location" required value="<?php echo $model_info->location; ?>">
            <label class="form-label"><?php echo lang("location");?></label>
        </div>
        
    </div>

    <div class="form-group form-float p-r-15 p-l-15">
        <div class="form-line">
            <input type="text" id="event_labels" class="form-control" name="labels" required value="<?php echo $model_info->labels; ?>">
            <label class="form-label"><?php echo lang("labels");?></label>
        </div>
        
    </div>
    

    <div class="form-group form-float p-r-15 p-l-15">
        <div class="color-palet col-md-9">
            <?php
            $selected_color = $model_info->color ? $model_info->color : "#83c340";
            $colors = array("#83c340", "#29c2c2", "#2d9cdb", "#aab7b7", "#f1c40f", "#e18a00", "#e74c3c", "#d43480", "#ad159e", "#34495e", "#dbadff");
            foreach ($colors as $color) {
                $active_class = "";
                if ($selected_color === $color) {
                    $active_class = "active";
                }
                echo "<span style='background-color:" . $color . "' class='color-tag clickable mr15 " . $active_class . "' data-color='" . $color . "'></span>";
            }
            ?> 
            <input id="color" type="hidden" name="color" value="<?php echo $selected_color; ?>" />
        </div>
        <label for="location" class=" col-md-3"></label>
    </div>



</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang("close");?></button>
    <button type="submit" id="save_btn" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang("save");?></button>
</div>
</form>

<script type="text/javascript">
    $.AdminBSB.input.activate();
    $(document).ready(function () {
        $(".color-palet span").click(function () {
            $(".color-palet").find(".active").removeClass("active");
            $(this).addClass("active");
            $("#color").val($(this).attr("data-color"));
        });

        $("#title").focus();

         $('.start_datepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: true,
            weekStart: 1,
            time: false
        });
        $('.end_datepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: true,
            weekStart: 1,
            time: false
        });
         $('.timepicker').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            clearButton: true,
            date: false
        });

        $(document).on('change', '.end_datepicker', function(){
            $('.start_datepicker').bootstrapMaterialDatePicker('setMaxDate', $(this).val());
            $(this).focus();
        });

        $(document).on('change', '.start_datepicker', function(){
            $('.end_datepicker').bootstrapMaterialDatePicker('setMinDate', $(this).val());
            $(this).focus();
        });

        $(document).on('change', '.timepicker', function(){
            $(this).focus();
        });

        $('#form_advanced_validation').validate({
            rules: {
                'date': {
                    customdate: true
                },
                'creditcard': {
                    creditcard: true
                }
            },
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            }
        });

        function save_ajax(){
            var chk = 0;
            $('div.form-line').each(function(){
                if($(this).hasClass('error')){
                    chk = 1;
                }else{
                    
                }
            });
            
            if(chk == 0){
                console.log($('.events-form').serialize());
                $.ajax({
                    url: '<?php echo base_url('events/save'); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: $('.events-form').serialize(),
                    success: function (result) {
                        if (result.success) {
                            $('#ajaxModal').modal('hide');
                            $("#event-calendar").fullCalendar('refetchEvents');
                        } else {
                            
                        }
                    }
                });
            }else{
                
            }
        }

        $('#form_advanced_validation').on('submit', function(e) {
            e.preventDefault();
            setTimeout(save_ajax, 200);
        });

    });
</script>

<style type="text/css">
    .color-tag{
        display: inline-block;
        width: 15px;
        height: 15px;
        margin: 2px 10px 0 0;
        transition: all 0.1s;
        cursor: pointer;
    }
    .color-tag.active {
        border-radius: 50%;
    }
</style>