<script type="text/javascript">
    AppHelper = {};
    AppHelper.baseUrl = "<?php echo iaBase(); ?>";
    AppHelper.assetsDirectory = "<?php echo iaBase() . "assets/"; ?>";
    AppHelper.settings = {};
    AppHelper.settings.firstDayOfWeek =0 || 0;
    AppHelper.settings.currencySymbol = "$";
    AppHelper.settings.currencyPosition = "" || "left";
    AppHelper.settings.decimalSeparator = ".";
    AppHelper.settings.displayLength = "";
    AppHelper.settings.timeFormat = "small";
    AppHelper.settings.scrollbar = "";
</script>

<script type="text/javascript">
    AppLanugage = {};
    /*AppLanugage.locale = "en";

    //AppLanugage.days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    AppLanugage.daysShort = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
    AppLanugage.daysMin = ["Su","Mo","Tu","We","Th","Fr","Sa"];

    AppLanugage.months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    AppLanugage.monthsShort = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

    AppLanugage.today = "Today";
    AppLanugage.yesterday = "Yesterday";
    AppLanugage.tomorrow = "Tomorrow";

    AppLanugage.search = "Search";
    AppLanugage.noRecordFound = "No record found.";
    AppLanugage.print = "Print";
    AppLanugage.excel = "Excel";
    AppLanugage.printButtonTooltip = "Press escape when finished.";

    AppLanugage.fileUploadInstruction = "Drag-and-drop documents here <br /> (or click to browse...)";
    AppLanugage.fileNameTooLong = "Filename is too long.";
    
    AppLanugage.custom = "Custom";
    AppLanugage.clear = "Clear";*/


</script>
<!-- <link href="<?php //echo iaBase(); ?>assets/style2.css" rel="stylesheet"> -->
<style>
  <?php $this->load->view('assets/style2.css'); ?>
  <?php $this->load->view('assets/select2/select2.css'); ?>
</style>

<section class="content">
  <div class="container-fluid">
    <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header">

          <button type="button" class="btn btn-primary waves-effect modalButton" data-src=""><i class="material-icons">mode_edit</i> <?php echo lang('compose'); ?></button>


          <?php echo anchor(base_url("messages/inbox"), "<i class='material-icons'>inbox</i> " . lang('inbox'), array("class" => "btn btn-primary waves-effect", "title" => lang('inbox'))); ?>

          <?php echo anchor(base_url("messages/sentitems"), "<i class='material-icons'>send</i> " . lang('sent_items'), array("class" => "btn btn-primary waves-effect", "title" => lang('sent_items'))); ?>
        </div>
      </div>
    </div>
    </div>


    <div class="row clearfix">
        <!-- Default Example -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        <?php
                          if ($mode === "inbox") {
                              echo "<i class='material-icons'>inbox</i> " . lang('inbox');
                          } else if ($mode === "sent_items") {
                              echo "<i class='material-icons'>send</i> " . lang('sent_items');
                          }
                        ?>
                        <div class="pull-right">
                          <input type="text" id="search-messages" class="datatable-search" placeholder="<?php echo lang('search'); ?>">
                        </div>
                    </h2>
                </div>
                <div class="body">
                    <div class="clearfix m-b-20">
                        <div class="table-responsive">
                            <table id="message-table" class="display no-thead no-padding clickable" cellspacing="0" width="100%">            
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

          <div id="message-details-section" class="panel panel-default"> 
              <div id="empty-message" class="text-center mb15 box">
                  <div class="box-content" style="vertical-align: middle; height: 100%"> 
                      <h4><div><?php echo lang('select_a_message_to_view'); ?></div></h4>
                      <i class="material-icons" style="font-size: 1450%; color:#f6f8f8">email</i>
                  </div>
              </div>
          </div>
        </div>
        <!-- #END# Default Example -->
    </div>
  </div>
</section>

<div class="modal fade" id="nameModal_expenses"  role="dialog"><!-- Modal Crud Start-->
  <div class="modal-dialog">
    <div class="modal-content" >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo lang('send_messages'); ?></h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div><!--End Modal Crud -->


<script type="text/javascript">
  
  $("body").on("click",".modalButton", function(e) {  
    var loading = '<img src="<?php echo iaBase() ?>assets/images/loading.gif" />';
    $("#nameModal_expenses").find(".modal-body").html(loading);
    $("#nameModal_expenses").find(".modal-body").attr("style","text-align: center");    
    $.ajax({
      url : "<?php echo base_url()."messages/getModal";?>",
      method: "post", 
      data : {
      id: $(this).attr("data-src")
      }
      }).done(function(data) {
      $("#nameModal_expenses").find(".modal-body").removeAttr("style");  
      $("#nameModal_expenses").find(".modal-body").html(data);
      $("#nameModal_expenses").modal("show");
      $(".form_check").each(function() {
          $p_obj = $(this);
          $res = 1;
          if($p_obj.find(".check_box").hasClass("required")) {
            if($p_obj.find(".check_box").is(":checked")) {
              $res = "0";
            }
          }
          if($res == 0) {
            $(".check_box").prop("required", false);
          }
        }) 
    })
  });

</script>

<style type="text/css">
    .datatable-tools:first-child {
        display:  none;
    }


</style>

<script type="text/javascript">
    $(document).ready(function () {
        var autoSelectIndex = "<?php echo $auto_select_index; ?>";
        $("#message-table").appTable({
            source: "<?php echo base_url("messages/listData/". $mode);?>",
            order: [[1, "desc"]],
            columns: [
                {title: "message"},
                {targets: [1], visible: false},
                {targets: [2], visible: false}
            ],
            onInitComplete: function () {
                if (autoSelectIndex) {
                    //automatically select the message
                    var $tr = $("[data-index=" + autoSelectIndex + "]").closest("tr");
                    if ($tr.length)
                        $tr.trigger("click");
                }

                var $message_list = $("#message-list-box"),
                        $empty_message = $("#empty-message");
                if ($empty_message.length && $message_list.length) {
                    $empty_message.height($message_list.height());
                }
            }
        });

        var messagesTable = $('#message-table').DataTable();
        $('#search-messages').keyup(function () {
            messagesTable.search($(this).val()).draw();
        })


        /*load a message details*/
        $("body").on("click", "tr", function () {
            //remove unread class
            $(this).find(".unread").removeClass("unread");

            //don't load this message if already has selected.
            if (!$(this).hasClass("active")) {
                var message_id = $(this).find(".message-row").attr("data-id"),
                        reply = $(this).find(".message-row").attr("data-reply");
                if (message_id) {
                    $("tr.active").removeClass("active");
                    $(this).addClass("active");
                    
                    $.ajax({
                        url: "<?php echo base_url("messages/view/");?>" + message_id + "/<?php echo $mode ?>/" + reply,
                        dataType: "json",
                        success: function (result) {
                            if (result.success) {
                                $("#message-details-section").html(result.data);
                            } else {
                                appAlert.error(result.message);
                            }
                        }
                    });
                }

                //add index with tr for dlete the message
                $(this).addClass("message-container-" + $(this).find(".message-row").attr("data-index"));

            }
        });

    });
</script>
<script>
  <?php $this->load->view('assets/app.js'); ?>
  <?php $this->load->view('assets/general_helper.js'); ?>
  <?php $this->load->view('assets/select2/select2.js'); ?>
</script>
