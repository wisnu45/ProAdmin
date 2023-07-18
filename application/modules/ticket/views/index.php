<!-- start: PAGE CONTENT -->
    <section class="content">
		<div class="container-fluid">
		<!-- Main content -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
						<div class="header">
                           <h2><?php echo lang('ticket') ?></h2>
                              <ul class="header-dropdown">
                                 <?php if(CheckPermission("ticket", "own_create")){ ?>
                                 <button type="button" class="btn-sm  btn btn-primary waves-effect amDisable modalButton" data-src="" data-width="555" ><i class="material-icons">add</i><?php echo lang('add_ticket') ?></button>
                              <?php }?>
                              </ul>
                            </div>
                 	 <!-- /.box-header -->
                    <div class="body table-responsive">
<!-- <div class="row com-row">
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	          	<div class="info-box-3 bg-pink hover-zoom-effect EditDeshbord del-only" data-deshbid_id="2411"  data-deshbid_type="info_box_grid" style="background-color: #f77d73 !important;">
	            	<div class="icon">
		                <i class="glyphicon glyphicon-credit-card"></i>
		            </div>
	            	<div class="content">
	            		<div class="text">Open Ticket </div>
	            		<div class="number mka-num" id="ret_0" data-c-fields="[@m@ticket_status@m@]" data-c-operators="[@m@equal_to@m@]" data-c-values="[@m@Open@m@]" data-table="ticket" data-action="count" data-sum-field="" data-relation="[@m@no@m@]" data-relation-table="[@m@@m@]" data-relation-from="[@m@@m@]" data-relation-where="[@m@@m@]" >0</div>
	            	</div> 
	            /.info-box-content
	          	</div>
	          /.info-box
	        </div><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	          	<div class="info-box-3 bg-pink hover-zoom-effect EditDeshbord del-only" data-deshbid_id="2412"  data-deshbid_type="info_box_grid" style="background-color: #a49ae0 !important;">
	            	<div class="icon">
		                <i class="glyphicon glyphicon-adjust"></i>
		            </div>
	            	<div class="content">
	            		<div class="text">On Going</div>
	            		<div class="number mka-num" id="ret_1" data-c-fields="[@m@ticket_status@m@]" data-c-operators="[@m@equal_to@m@]" data-c-values="[@m@Ongoing@m@]" data-table="ticket" data-action="count" data-sum-field="" data-relation="[@m@no@m@]" data-relation-table="[@m@@m@]" data-relation-from="[@m@@m@]" data-relation-where="[@m@@m@]" >0</div>
	            	</div> 
	            /.info-box-content
	          	</div>
	          /.info-box
	        </div><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	          	<div class="info-box-3 bg-pink hover-zoom-effect EditDeshbord del-only" data-deshbid_id="2413"  data-deshbid_type="info_box_grid" style="background-color: #09974e !important;">
	            	<div class="icon">
		                <i class="glyphicon glyphicon-ban-circle"></i>
		            </div>
	            	<div class="content">
	            		<div class="text">Close</div>
	            		<div class="number mka-num" id="ret_2" data-c-fields="[@m@ticket_status@m@]" data-c-operators="[@m@equal_to@m@]" data-c-values="[@m@Close@m@]" data-table="ticket" data-action="count" data-sum-field="" data-relation="[@m@no@m@]" data-relation-table="[@m@@m@]" data-relation-from="[@m@@m@]" data-relation-where="[@m@@m@]" >0</div>
	            	</div> 
	            /.info-box-content
	          	</div>
	          /.info-box
	        </div><div class="col-md-1">
        		<span class="mka-com-add DeshboardModal" data-crud-id="16198"></span>
        	</div>
        </div> -->
  	<div class="row filter-row">
			<?php echo $obj->getFilterHtml();  ?>	
	</div>
<table id="example_ticket" class="table table-bordered table-striped table-hover delSelTable example_ticket">
								  <thead>
								 	<tr>
										<th>
											<!-- <input type="checkbox" class="selAll" id="basic_checkbox_1mka" />
											                    						<label for="basic_checkbox_1mka"></label> -->
											 ID
                    					</th>
										<!-- <th><?php //echo lang('date'); ?></th> -->
									<?php  $cf = getCustomFields('ticket');
					                    
					                    if(is_array($cf) && !empty($cf)) {
					                      foreach ($cf as $cfkey => $cfvalue) {
					                        echo '<th>'.lang(get_lang($cfvalue->rel_crud).'_'.get_lang($cfvalue->name)).'</th>';
					                      } 
					                    }
						            ?>
										<th><?php echo lang('client') ?></th>
										<th><?php echo lang('ticket_title') ?></th>
										<th><?php echo lang('ticket_type') ?></th>
										<th><?php echo lang('description') ?></th>
										<th><?php echo lang('status') ?></th>

									<th><?php echo lang('action'); ?></th>
</tr>
									</thead>
									<tbody>
</tbody> 
							</table>
                           </div>
                           <!-- /.box-body -->
                        </div>
                     <!-- /.box -->
                   </div>
                <!-- /.col -->
              </div>
            <!-- /.row -->
        <!-- /.Main-content -->
      	</div>
    </section>
<!-- /.content-wrapper -->


<div class="modal fade" id="nameModal_ticket"  role="dialog"><!-- Modal Crud Start-->
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				  <h4 class="box-title"><?php echo lang('ticket'); ?></h4>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div><!--End Modal Crud -->

<script type="text/javascript">
var data_table = function($filter, $search) {
	var url = "<?php echo base_url();?>";
	return table = $("#example_ticket").DataTable({
		"dom": 'lfBrtip',
				  "buttons": ["copy","excel","print"],
		"processing": true,
        "serverSide": true,
        "ajax": {
        	"url" : url + "ticket/ajxData",
				"data": function ( d ) {
					if($filter != '') {
						$.each($filter, function(index, val) {
							d[index] = val;
						});
					}
        	<?php if(isset($submodule) && $submodule != '') { ?>
	                d.submodule = '<?php echo $submodule; ?>';
        	<?php } ?>
	            }
        },
        "sPaginationType": "full_numbers",
        "language": {
			"search": "_INPUT_", 
			"searchPlaceholder": "<?php echo lang('search'); ?>",
			"paginate": {
			    "next": '<i class="material-icons">keyboard_arrow_right</i>',
			    "previous": '<i class="material-icons">keyboard_arrow_left</i>',
			    "first": '<i class="material-icons">first_page</i>',
			    "last": '<i class="material-icons">last_page</i>'
			}
		},
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"<?php echo lang('all'); ?>"]],
		"columnDefs" : [
			{
				"orderable": false, 
				"targets": [0]
			}
			<?php if(!CheckPermission("ticket", "all_delete") && !CheckPermission("ticket", "own_delete")){ ?>
			,{
				"targets": [0],
				"visible": false,
				"searchable": false
			}
          	<?php } ?>
		],
		"order": [[1, 'asc']],
		"oSearch": {"sSearch": $search}
	});
}

var date_picker = function() {
   $(".daterange-picker").daterangepicker(
    {
        locale: {
          format: "DD-MM-YYYY"
        }
		<?php if(!isset($_COOKIE['ticket_filter']) || $_COOKIE['ticket_filter'] == '') { ?>
        ,
        startDate: "<?php echo $sDate = "01-".date("m-Y"); ?>",
        endDate: "<?php echo date("d-m-Y", strtotime($sDate. " + 60 day")); ?>"
        <?php } ?>
    });
}



jQuery(document).ready(function() {

	$('body').on('click', '.show-attach', function() {
		$files = $(this).attr('date-d');
		$files = $files.split(',');
		$html = '<div class="row">';
		$.each($files, function(k, v){
			$html += '<p><a href="<?php echo iaBase() ?>'+'assets/images/'+v+'" download>'+v+'</a></p>';
		});
		$html += '</div>';
		$m = $('#nameModal_ticket');
		$m.find('.box-title').text('<?php echo lang('attachment'); ?>');
		$m.find('.modal-body').html($html);
		$m.modal('show');
	});


	get_grid_info_box_val('ticket');
	if($('.filter-row').find('.filter-field').length > 0){
		setTimeout(function() {
			$('.filter-row').find('.filter-field').first().trigger('change');
		}, 500);
	} else {
		data_table('', '');
	}
	date_picker();

	$("body").on("change", '.filter-field', function() {
		$sVal = $('.dataTables_filter').find('input[type="search"]').val();
      	if(typeof(table) != "undefined" && table !== null) {
      		table.destroy();
		}
		$filter = {};
		$('select.filter-field, input.filter-field').each(function(){
			$filter[$(this).attr('name')] = $(this).val();
		});
      	var dateRange = $(this).val();
      	console.log("$filter->",$filter);
        data_table($filter, $sVal);
        get_grid_info_box_val('ticket');
        $.post('<?php echo base_url().'ticket/setFilterCookie' ?>', {ticket_filter: $filter});
    });

	
	$('body').off('submit', '#form');
	$('body').on('submit', '#form', function(ev) {
		$('#nameModal_ticket').find('input[name="save"]').prop('disabled', true);
		$('#nameModal_ticket').find('input[name="save"]').after('<span class="mka-loading"><img src="<?php echo iaBase().'assets/images/widget-loader-lg.gif'; ?>" alt="" /><span>');
		ev.preventDefault();
		var formData = new FormData($(this)[0]);
		$.ajax({
			url: '<?php echo base_url().'ticket/addedit' ?>',
			method: 'POST',
			async: false,
			data: formData,
			cache: false,
        	contentType: false,
        	processData: false
		}).done(function(mka) {
			if(mka > 0) {
				$('#nameModal_ticket').modal('hide');
				setTimeout(function() {
					if($('.submodule-main-div').length > 0) {
				            $('.custom-tab').each(function() {
				            	if($(this).hasClass('active')) {
				            		$(this).trigger('click');
				            	}
				            })
					} else {
				        $('#example_ticket').DataTable().ajax.reload();
				        get_grid_info_box_val('ticket');
				        showNotification('<?php echo lang('your_action_has_been_completed_successfully'); ?>.', 'success');
					}
					$.post('<?php echo base_url().'ticket/getFilterHtml/1' ?>', function(data) {
						$('.filter-row').html(data);
						$("select").selectpicker("refresh");
						date_picker();
						$.AdminBSB.input.activate();
					});
				}, 300);
			}
		});
	});

	$('body').off('click', '.yes-btn');
	$('body').on('click', '.yes-btn', function(e) {
		e.preventDefault();
		$.post($(this).attr('href'), function(data) {
			$('tbody').find('tr').each(function() {
				$ob = $(this);
				$dom_val = $ob.find('td').first().find('input').val();
				$('#cnfrm_delete').modal('hide');
				$.each(data, function(index, val) {
					if($dom_val == val) {
						$('#example_ticket').DataTable().ajax.reload();
						get_grid_info_box_val('ticket');
					}
				});
			});
			showNotification('<?php echo lang('records_deleted_successfully'); ?>.', 'success');
		}, 'json');
	});

} );

( function($) {
$(document).ready(function(){
	//var  cjhk = 0;
	<?php /*if(CheckPermission("ticket", "all_delete") || CheckPermission("ticket", "own_delete")){ ?>
		cjhk = 1;
	<?php }*/ ?>
	/*setTimeout(function() {
		var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
		//$('.table-date-range').css('right',add_width+'px');

		if(cjhk == 1) {
			$('.dataTables_info').before('<button data-del-url="<?php //echo base_url() ?>ticket/delete/" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left"> <i class="material-icons col-red">delete</i> </button><br><br>');
		}
	}, 1000);*/


	$("body").on("click",".modalButton", function(e) {  
		var loading = '<img src="<?php echo iaBase() ?>assets/images/loading.gif" />';
		$("#nameModal_ticket").find(".modal-body").html(loading);
		$("#nameModal_ticket").find(".modal-body").attr("style","text-align: center");    

		$.ajax({
			url : "<?php echo base_url()."ticket/getmodal";?>",
			method: "post", 
			data : {
			id: $(this).attr("data-src")
			}
			}).done(function(data) {
			$("#nameModal_ticket").find(".modal-body").removeAttr("style");  
			$("#nameModal_ticket").find(".modal-body").html(data);
			$("#nameModal_ticket").modal("show");
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
});
} ) ( jQuery );
</script>
