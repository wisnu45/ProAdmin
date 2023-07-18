<style type="text/css">
    
<?php 
    $this->load->view('fullcalendar/fullcalendar.min.css');
?>
</style>

<?php
$client = "";
if (isset($client_id)) {
    $client = $client_id;
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <?php if ($client) { ?>
                            <h2><?php echo lang("events");?></h2>
                        <?php } else { ?>
                            <h2><?php echo lang("event_calendar");?></h2>
                        <?php } ?>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                            <?php if(CheckPermission('events', "own_create")){ ?>
                                <a href="#" data-act="ajax-modal" data-title="<?php echo lang("add_event");?>" data-action-url="<?php echo base_url('events/modalform'); ?>" class="btn btn-primary waves-effect" title="<?php echo lang("add_event");?>" data-post-client_id="<?php echo $client; ?>"> <i class='fa fa-plus-circle'></i> <?php echo lang("add_event");?> </a>
                            
                                <a href="#" data-act="ajax-modal" id="add_event_hidden" data-action-url="<?php echo base_url('events/modalform'); ?>" class="hide" data-post-client_id="<?php echo $client; ?>" title="<?php echo lang("add_event");?>" data-title="<?php echo lang("add_event");?>"></a>
                            <?php } ?>
                                <a href="#" id="show_event_hidden" data-act="ajax-modal" data-action-url="<?php echo base_url('events/view'); ?>" class="hide" title="<?php echo lang("event_details");?>" data-title="<?php echo lang("event_details");?>" data-post-client_id="<?php echo $client; ?>" data-post-editable="1"></a>                     
                            </li>
                        </ul>                        
                    </div>
                    <div class="body">
                        <div id="event-calendar"></div>
                    </div>                            
                </div>
            </div>           
        </div>           
    </div> 
</section>

<!-- Modal -->
<div class="modal" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="ajaxModal" aria-hidden="true">
    <div class="modal-dialog mini-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ajaxModalTitle" data-title="<?php echo lang("events");?>"></h4>
            </div>
            <div id="ajaxModalContent">

            </div>
            <div id='ajaxModalOriginalContent' class='hide'>
                <div class="original-modal-body">
                    <div class="circle-loader"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#event-calendar").fullCalendar({
            lang: '<?php echo lang('language_locale'); ?>',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: "<?php echo base_url("events/calendarEvents/".$client); ?>",
            dayClick: function (date, jsEvent, view) {
                $("#add_event_hidden").attr("data-post-start_date", date.format("YYYY-MM-DD"));
                var startTime = date.format("HH:mm:ss");
                if (startTime === "00:00:00") {
                    startTime = "";
                }
                $("#add_event_hidden").attr("data-post-start_time", startTime);
                var endDate = date.add(1, 'hours');

                $("#add_event_hidden").attr("data-post-end_date", endDate.format("YYYY-MM-DD"));
                var endTime = "";
                if (startTime != "") {
                    endTime = endDate.format("HH:mm:ss");
                }

                $("#add_event_hidden").attr("data-post-end_time", endTime);
                $("#add_event_hidden")[0].click();
            },
            eventClick: function (calEvent, jsEvent, view) {
                $("#show_event_hidden").attr("data-post-id", calEvent.encrypted_event_id);
                $("#show_event_hidden")[0].click();
            },
            eventRender: function (event, element) {
                if (event.icon) {
                    element.find(".fc-title").prepend("<i class='fa " + event.icon + "'></i> ");
                }
            },
            firstDay: 0

        });

        var client = "<?php echo $client; ?>";
        if (client) {
            setTimeout(function () {
                $('#event-calendar').fullCalendar('today');
            });
        }
        
        
        //autoload the event popover
        var encrypted_event_id = "<?php echo isset($encrypted_event_id)? $encrypted_event_id:'';?>";
       
        if(encrypted_event_id){
            $("#show_event_hidden").attr("data-post-id", encrypted_event_id);
            $("#show_event_hidden").trigger("click"); 
        }
        

    });

    $('body').on('click', '[data-act=ajax-modal]', function () {
        var data = {ajaxModal: 1},
        url = $(this).attr('data-action-url'),
        isLargeModal = $(this).attr('data-modal-lg'),
        title = $(this).attr('data-title');
        if (!url) {
            console.log('<?php echo lang('ajax_modal:_set_data-action-url!'); ?>');
            return false;
        }
        if (title) {
            $("#ajaxModalTitle").html(title);
        } else {
            $("#ajaxModalTitle").html($("#ajaxModalTitle").attr('data-title'));
        }

        $("#ajaxModalContent").html($("#ajaxModalOriginalContent").html());
        $("#ajaxModalContent").find(".original-modal-body").removeClass("original-modal-body").addClass("modal-body");
        $("#ajaxModal").modal('show');

        $(this).each(function () {
            $.each(this.attributes, function () {
                if (this.specified && this.name.match("^data-post-")) {
                    var dataName = this.name.replace("data-post-", "");
                    data[dataName] = this.value;
                }
            });
        });
        ajaxModalXhr = $.ajax({
            url: url,
            data: data,
            cache: false,
            type: 'POST',
            success: function (response) {
                $("#ajaxModal").find(".modal-dialog").removeClass("mini-modal");
                if (isLargeModal === "1") {
                    $("#ajaxModal").find(".modal-dialog").addClass("modal-lg");
                }
                $("#ajaxModalContent").html(response);

                var $scroll = $("#ajaxModalContent").find(".modal-body"),
                        height = $scroll.height(),
                        maxHeight = $(window).height() - 200;
                if (height > maxHeight) {
                    height = maxHeight;
                    if ($.fn.mCustomScrollbar) {
                        $scroll.mCustomScrollbar({setHeight: height, theme: "minimal-dark", autoExpandScrollbar: true});
                    }
                }
            },
            statusCode: {
                404: function () {
                    $("#ajaxModalContent").find('.modal-body').html("");
                    appAlert.error("404: Page not found.", {container: '.modal-body', animate: false});
                }
            },
            error: function () {
                $("#ajaxModalContent").find('.modal-body').html("");
                appAlert.error("500: Internal Server Error.", {container: '.modal-body', animate: false});
            }
        });
        return false;
    });

    //abort ajax request on modal close.
    $('#ajaxModal').on('hidden.bs.modal', function (e) {
        ajaxModalXhr.abort();
        $("#ajaxModal").find(".modal-dialog").removeClass("modal-lg");
        $("#ajaxModal").find(".modal-dialog").addClass("mini-modal");

        $("#ajaxModalContent").html("");
    });

    $(document).on('click', '.fc-day-grid-event', function(){
        var time = $(this).find('span.fc-time').text();
        var title = $(this).find('span.fc-title').text();

    });
</script>

<style type="text/css">
    .fc-content {
        cursor: pointer;
    }
</style>

<script type="text/javascript">
<?php 
    $this->load->view('fullcalendar/fullcalendar.min.js');
    $this->load->view('fullcalendar/lang-all.js');
?>
</script>
