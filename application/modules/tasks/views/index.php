<!-- start: PAGE CONTENT -->
    <section class="content">
		<div class="container-fluid">
		<!-- Main content -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
						<div class="header tab-card-header">
                           <h2><?php echo "Tasks" ?></h2>
                           		<ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist" style="display: inline-flex;">
						            <li class="nav-item active">
						                <a class="nav-link" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true" aria-expanded="false">List</a>
						            </li>
						            <li class="nav-item">
						                <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false" aria-expanded="true">Kanban</a>
						            </li>
						        </ul>
	                             <ul class="header-dropdown">
	                                <?php if(CheckPermission("ticket", "own_create")){ ?>
	                                <button type="button" class="btn-sm  btn btn-primary waves-effect amDisable modalButton" data-src="" data-width="555" ><i class="material-icons">add</i><?php echo "Add Tasks" ?></button>
	                             <?php }?>
	                             </ul>
                            </div>
                 	 <!-- /.box-header -->
                    <div class="body table-responsive">

<div class="tab-pane fade p-3 active in" id="one" role="tabpanel" aria-labelledby="one-tab">
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
										<th><?php echo "Title" ?></th>
										<th><?php echo "Start Date" ?></th>
										<th><?php echo "Deadline" ?></th>
										<th><?php echo "Project" ?></th>
										<th><?php echo "Assigned To" ?></th>
										<th><?php echo "Collaborators" ?></th>

									<th><?php echo "Status"; ?></th>
									<th><?php echo "Action"; ?></th>
</tr>
									</thead>
									<tbody>
</tbody> 
							</table>
</div>
<div class="tab-pane fade p-3 active in" id="two" role="tabpanel" aria-labelledby="one-tab">
	<div class="row clearfix todo-page">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="card">
					<div class="header bg-amber">
						<h2> <i class="material-icons">warning</i> <?php echo "To do"; ?></h2>
					</div>
					<div class="body">
						<ul class="list-unstyled todo unfinished-todos todos-sortable">
							<li class="padding no-todos hide ui-state-disabled">
								<?php echo "No to do tasks found"; ?>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 text-center padding">
							<a href="#" class="btn btn-default text-center unfinished-loader"><?php echo 'load_more'; ?></a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="card">
					<div class="header bg-light-blue">
						<h2> <i class="material-icons">loop</i> <?php echo "In progress"; ?></h2>
					</div>
					<div class="body">
						<ul class="list-unstyled todo process-todos todos-sortable">
							<li class="padding no-todos hide ui-state-disabled">
								<?php echo "No in progress tasks found"; ?>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 text-center padding">
							<a href="#" class="btn btn-default text-center process-loader">
								<?php echo 'load_more'; ?>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="card">
					<div class="header bg-light-green">
						<h2> <i class="material-icons">check</i> <?php echo "Done"; ?></h2>
					</div>
					<div class="body">
						<ul class="list-unstyled todo finished-todos todos-sortable">
							<li class="padding no-todos hide ui-state-disabled">
								<?php echo "No finished tasks found"; ?>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 text-center padding">
							<a href="#" class="btn btn-default text-center finished-loader">
								<?php echo 'load_more'; ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
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
				  <h4 class="box-title"><?php echo "Tasks"; ?></h4>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div><!--End Modal Crud -->

<script type="text/javascript">
$(document).ready(function(){
	$('#one').show();
	$('#two').hide();
});
$('#one-tab').on('click',function(){
	$('#one').show();
	$('#two').hide();
});
$('#two-tab').on('click',function(){
	$('#two').show();
	$('#one').hide();
});

var data_table = function($filter, $search) {
	var url = "<?php echo base_url();?>";
	return table = $("#example_ticket").DataTable({
		"dom": 'lfBrtip',
				  "buttons": ["copy","excel","print"],
		"processing": true,
        "serverSide": true,
        "ajax": {
        	"url" : url + "tasks/ajxData",
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
			url: '<?php echo base_url().'tasks/addedit' ?>',
			method: 'POST',
			async: false,
			data: formData,
			cache: false,
        	contentType: false,
        	processData: false
		}).done(function(mka) {
			mdata = $.parseJSON(mka);
			if (mdata[0].status == "to_do") {
				$('.unfinished-todos').append(render_li_items(0, mdata[0]));
			} else if (mdata[0].status == "in_progress") {
				$('.process-todos').append(render_li_items(0, mdata[0]));
			} else {
				$('.finished-todos').append(render_li_items(0, mdata[0]));
			}
			if(mdata[0].id > 0) {
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
					console.log("data->",data);
				$ob = $(this);
				$dom_val = $ob.find('td').first().find('input').val();
				$('#cnfrm_delete').modal('hide');
				$.each(data, function(index, val) {
					$('#example_ticket').DataTable().ajax.reload();
					get_grid_info_box_val('tasks');
				});
			});
			console.log("data[0]->",data[0]);
			var item = $('#mka'+data[0]);
			$(item).parents('li').remove();
			update_todo_items();
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
			url : "<?php echo base_url()."tasks/getmodal";?>",
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
<?php echo $this->user_type; ?>
<script>
	var own_update_permissions = '<?php echo CheckPermission("todo", "own_update") ?>';
	var own_delete_permissions = '<?php echo CheckPermission("todo", "own_delete") ?>';
	var user_type = '<?php echo $this->user_type; ?>';
	$(function(){
	    var total_pages_unfinished = '<?php echo $total_pages_unfinished; ?>';
	    var total_pages_finished = '<?php echo $total_pages_finished; ?>';
	    var total_pages_process = '<?php echo $total_pages_process; ?>';
	    var page_unfinished = 0;
	    var page_finished = 0;
	    var page_process = 0;
	    $('.unfinished-loader').on('click', function(e) {
	        e.preventDefault();
	        if (page_unfinished <= total_pages_unfinished) {
	            $.post(window.location.href, {
	                status: 'to_do',
	                todo_page: page_unfinished
	            }).done(function(response) {
	                response = JSON.parse(response);

	                if (response.length == 0) {
	                    $('.unfinished-todos .no-todos').removeClass('hide');
	                }

	                $.each(response, function(i, obj) {
	                    $('.unfinished-todos').append(render_li_items(0, obj));
	                });
	                page_unfinished++;
	            });
	            if (page_unfinished >= (total_pages_unfinished - 1)) {
	                $(".unfinished-loader").addClass("disabled");
	            }
	        }
	    });

	    $('.process-loader').on('click', function(e) {
	        e.preventDefault();
	        if (page_process <= total_pages_process) {
	            $.post(window.location.href, {
	                status: 'in_progress',
	                todo_page: page_process
	            }).done(function(response) {
	                response = JSON.parse(response);

	                if (response.length == 0) {
	                    $('.process-todos .no-todos').removeClass('hide');
	                }

	                $.each(response, function(i, obj) {
	                    $('.process-todos').append(render_li_items(0, obj));
	                });
	                page_process++;
	            });
	            if (page_process >= (total_pages_process - 1)) {
	                $(".process-loader").addClass("disabled");
	            }
	        }
	    });

	    $('.finished-loader').on('click', function(e) {
	        e.preventDefault();
	        if (page_finished <= total_pages_finished) {
	            $.post(window.location.href, {
	                status: 'done',
	                todo_page: page_unfinished
	            }).done(function(response) {
	                response = JSON.parse(response);
	                if (response.length == 0) {
	                    $('.finished-todos .no-todos').removeClass('hide');
	                }
	                $.each(response, function(i, obj) {
	                    $('.finished-todos').append(render_li_items(1, obj));
	                });

	                page_finished++;
	            });

	            if (page_finished >= total_pages_finished - 1) {
	                $(".finished-loader").addClass("disabled");
	            }
	        }
	    });
	    $('.unfinished-loader').click();
	    $('.process-loader').click();
	    $('.finished-loader').click();


	    $('#add_new_todo_item').on('submit', function(e) {
	    	e.preventDefault();
	    	$fm = $(this).serialize();
    		$('#add_new_todo_item')[0].reset();
	    	$.ajax({
	    		url: $(this).attr('action'),
	    		type: 'POST',
	    		dataType: 'json',
	    		data: $fm
	    	}).done(function(obj) {
	    		if($('#add_new_todo_item').find('input[name="todo_id"]').val() != '') {
	    			$cl = 'finished-todos';
	    			if(obj.finished == 0){
	    				$cl = 'unfinished-todos';
	    			}
    				$('ul.' + $cl).find('li').each(function() {
    					$o = $(this);
    					if($o.find('input[name="todo_id"]').val() == obj.todo_id) {
    						$o.find('span.todo-description span').text(obj.description);
    					}
    				})
    				$('#add_new_todo_item').find('input[name="todo_id"]').val('');
	    		} else {
	    			$('.unfinished-todos').append(render_li_items(0, obj));
	    			if($('.unfinished-todos').find('li.no-todos').is(':visible')) {
	    				$('.unfinished-todos').find('li.no-todos').addClass('hide');
	    			}
	    		}
	    	});
    		if($('input[name="todo_id"]').val() != '') {
    			$('#add_new_todo_item').find('button').text('Add New Todo');
    		}
	    	
	    });


        var todos_sortable = $(".todos-sortable");
	    if (todos_sortable.length > 0) {
	        // Makes todos sortable
	        todos_sortable = todos_sortable.sortable({
	        	items: "li",
	        	connectWith: ".todo",
	        	handle: '.dragger',
	        	update: function(event, ui) {
	                if (this === ui.item.parent()[0]) {
	                    update_todo_items();
	                }
	            }
	        });
	    }

	    // Todo status change checkbox click
	    $('body').on('change', '.todo input[type="checkbox"]', function() {
	    	$obj = $(this);
	        var finished = $(this).prop('checked') === true ? 'done' : 'to_do';
	        var a = 0;
	        $.post($('body').attr('data-base-url') + 'tasks/changeTaskStatus/' + $(this).val() + '/' + finished , function(data) {
	        	if(data) {
	        		$htm = '<li class="mkaTmp">'+$obj.parents('li').first().html()+'</li>';	
	        		$obj.parents('li').first().fadeOut('slow');
	        		$cl = 'unfinished';
	        		if(finished == 'done') {
	        			a = 1;
	        			$cl = 'finished';
	        		}
        			$('ul.'+ $cl +'-todos').append($htm);
	        		$('.mkaTmp').hide();
	        		$('.mkaTmp').find('input[type="checkbox"]').prop('checked', a);
	        		setTimeout(function() {
		        		if($('ul.'+ $cl +'-todos').find('li.no-todos').is(':visible')) {
		        			$('ul.'+ $cl +'-todos').find('li.no-todos').addClass('hide');
		        		}
        				$('.mkaTmp').fadeIn('slow');
	        			$('.mkaTmp').removeClass('mkaTmp');
	        			if($obj.parents('ul').first().find('li').length <= 2) {
	        				$obj.parents('ul').find('li.no-todos').removeClass('hide');
	        			}
	        			$obj.parents('li').first().remove();
	        		}, 800)

	        	}
	        });
	      
	    });


	});

	function render_li_items(finished, obj) {
	    var todo_finished_class = '';
	    var checked = '';
	    var status = "to_do";
	    if (finished == 1) {
	        todo_finished_class = ' line-throught';
	        checked = 'checked';
	        status = "done";
	    } else if (finished == 2) {
	    	todo_finished_class = ' line-throught';
	        status = "done";
	    }
	    if (user_type=="user") {
			if (own_update_permissions&&own_delete_permissions) {
		    	return '<li><div class="dragger todo-dragger" style="padding:15px;"><input type="hidden" value="' + status + '" name="finished"><input type="hidden" value="' + obj.item_order + '" name="todo_order"><div class="checkbox checkbox-default todo-checkbox" style="display:none;"><input type="checkbox" name="todo_id" value="' + obj.todo_id + '" '+checked+' id="mka'+obj.todo_id+'"><label for="mka'+obj.todo_id+'"></label></div><span class="todo-description' + todo_finished_class + '"><span>' + obj.description + '</span><a data-toggle="modal" style="cursor:pointer;" data-target="#cnfrm_delete" title="Delete" onclick="setId(' + obj.id + ', \'tasks\')" class="pull-right text-muted"><i class="material-icons bg-red">delete</i></a><a href="javascript:;" onclick="edit_todo_item('+obj.todo_id+'); return false;" class="pull-right text-muted mright5"><i class="material-icons bg-blue">mode_edit</i></a></span><small class="todo-date">' + t_date + '</small></div></li>';
		    }
		    else if (own_update_permissions) {
		    	return '<li><div class="dragger todo-dragger" style="padding:15px;"><input type="hidden" value="' + status + '" name="finished"><input type="hidden" value="' + obj.item_order + '" name="todo_order"><div class="checkbox checkbox-default todo-checkbox" style="display:none;"><input type="checkbox" name="todo_id" value="' + obj.todo_id + '" '+checked+' id="mka'+obj.todo_id+'"><label for="mka'+obj.todo_id+'"></label></div><span class="todo-description' + todo_finished_class + '"><span>' + obj.description + '</span><a href="javascript:;" onclick="edit_todo_item('+obj.todo_id+'); return false;" class="pull-right text-muted mright5"><i class="material-icons bg-blue">mode_edit</i></a></span><small class="todo-date">' + t_date + '</small></div></li>';
		    }
		    else if (own_delete_permissions) {
		    	return '<li><div class="dragger todo-dragger" style="padding:15px;"><input type="hidden" value="' + status + '" name="finished"><input type="hidden" value="' + obj.item_order + '" name="todo_order"><div class="checkbox checkbox-default todo-checkbox" style="display:none;"><input type="checkbox" name="todo_id" value="' + obj.todo_id + '" '+checked+' id="mka'+obj.todo_id+'"><label for="mka'+obj.todo_id+'"></label></div><span class="todo-description' + todo_finished_class + '"><span>' + obj.description + '</span><a data-toggle="modal" style="cursor:pointer;" data-target="#cnfrm_delete" title="Delete" onclick="setId(' + obj.id + ', \'tasks\')" class="pull-right text-muted"><i class="material-icons bg-red">delete</i></a></span><small class="todo-date">' + t_date + '</small></div></li>';
		    }
		    else {
		    	return '<li><div class="dragger todo-dragger" style="padding:15px;"><input type="hidden" value="' + status + '" name="finished"><input type="hidden" value="' + obj.item_order + '" name="todo_order"><div class="checkbox checkbox-default todo-checkbox" style="display:none;"><input type="checkbox" name="todo_id" value="' + obj.todo_id + '" '+checked+' id="mka'+obj.todo_id+'"><label for="mka'+obj.todo_id+'"></label></div><span class="todo-description' + todo_finished_class + '"><span>' + obj.description + '</span></span><small class="todo-date">' + t_date + '</small></div></li>';
		    }
	    }
	    else {
	    	return '<li><div class="dragger todo-dragger" style="padding:15px;"><input type="hidden" value="' + status + '" name="finished"><input type="hidden" value="' + obj.item_order + '" name="todo_order"><div class="checkbox checkbox-default todo-checkbox" style="display:none;"><input type="checkbox" name="id" value="' + obj.id + '" '+checked+' id="mka'+obj.id+'"><label for="mka'+obj.id+'"></label></div><span class="todo-description' + todo_finished_class + '"><span>' + obj.title + '</span><a data-toggle="modal" style="cursor:pointer;" data-target="#cnfrm_delete" title="Delete" onclick="setId(' + obj.id + ', \'tasks\')" class="pull-right text-muted"><i class="material-icons bg-red">delete</i></a><a href="javascript:;" onclick="edit_todo_item('+obj.id+'); return false;" class="pull-right text-muted mright5"><i class="material-icons bg-blue">mode_edit</i></a></span><br><small class="todo-date">' + obj.deadline + '</small></div></li>';
	    }
	    
	    
	}

	// Edit todo item
	function edit_todo_item(id) {
		    $.get($('body').attr('data-base-url') + 'todo/getById/' + id, function(response) {
		    	console.log(response);
		        var todo_modal = $('#add_new_todo_item');
		        todo_modal.find('input[name="todo_id"]').val(response.todo_id);
		        todo_modal.find('input[name="description"]').val(response.description);
		        todo_modal.find('button').text('Update Todo');
		        //todo_modal.modal('show');
		        $('html, body').animate({
				        scrollTop: $("html").offset().top
				    }, 'slow');
		    }, 'json');
	}

	// Update todo items when drop happen
	function update_todo_items() {
	    var unfinished_items = $('.unfinished-todos li:not(.no-todos)');
	    var process_items = $('.process-todos li:not(.no-todos)');
	    var finished = $('.finished-todos li:not(.no-todos)');
	    var i = 1;
	    // Refresh orders
	    $.each(unfinished_items, function() {
	        $(this).find('input[name="todo_order"]').val(i);
	        $(this).find('input[name="finished"]').val('to_do');
	        i++;
	    });
	    if (unfinished_items.length == 0) {
	        $('.nav-total-todos').addClass('hide');
	        $('.unfinished-todos li.no-todos').removeClass('hide');
	    } else if (unfinished_items.length > 0) {
	        if (!$('.unfinished-todos li.no-todos').hasClass('hide')) {
	            $('.unfinished-todos li.no-todos').addClass('hide');
	        }
	        $('.nav-total-todos').removeClass('hide');
	        $('.nav-total-todos').html(unfinished_items.length);
	    }

	    var y = 1;
	    // Refresh orders
	    $.each(process_items, function() {
	        $(this).find('input[name="todo_order"]').val(y);
	        $(this).find('input[name="finished"]').val('in_progress');
	        y++;
	    });
	    if (process_items.length == 0) {
	        $('.process-todos li.no-todos').removeClass('hide');
	    } else if (process_items.length > 0) {
	        if (!$('.process-todos li.no-todos').hasClass('hide')) {
	            $('.process-todos li.no-todos').addClass('hide');
	        }
	        $('.nav-total-todos').removeClass('hide');
	        $('.nav-total-todos').html(process_items.length);
	    }

	    x = 1;
	    $.each(finished, function() {
	        $(this).find('input[name="todo_order"]').val(x);
	        $(this).find('input[name="finished"]').val('done');
	        $(this).find('input[type="checkbox"]').prop('checked', true);
	        i++;
	        x++;
	    });
	    if (finished.length == 0) {
	        $('.finished-todos li.no-todos').removeClass('hide');
	    } else if (finished.length > 0) {
	        if (!$('.finished-todos li.no-todos').hasClass('hide')) {
	            $('.finished-todos li.no-todos').addClass('hide');
	        }
	    }
	    var update = [];
	    $.each(unfinished_items, function() {
	        var todo_id = $(this).find('input[name="id"]').val();
	        var order = $(this).find('input[name="todo_order"]').val();
	        var finished = $(this).find('input[name="finished"]').val();
	        var description = $(this).find('.todo-description');
	        if (description.hasClass('line-throught')) {
	            description.removeClass('line-throught')
	        }
	        $(this).find('input[type="checkbox"]').prop('checked', false);
	        update.push([todo_id, order, finished])
	    });
	    $.each(process_items, function() {
	        var todo_id = $(this).find('input[name="id"]').val();
	        var order = $(this).find('input[name="todo_order"]').val();
	        var finished = $(this).find('input[name="finished"]').val();
	        var description = $(this).find('.todo-description');
	        if (description.hasClass('line-throught')) {
	            description.removeClass('line-throught')
	        }
	        $(this).find('input[type="checkbox"]').prop('checked', false);
	        update.push([todo_id, order, finished])
	    });
	    $.each(finished, function() {
	        var todo_id = $(this).find('input[name="id"]').val();
	        var order = $(this).find('input[name="todo_order"]').val();
	        var finished = $(this).find('input[name="finished"]').val();
	        var description = $(this).find('.todo-description');
	        if (!description.hasClass('line-throught')) {
	            description.addClass('line-throught')
	        }
	        update.push([todo_id, order, finished])
	    });
	    data = {};
	    data.data = update;
	    console.log('data->',data);
	    $.post($('body').attr('data-base-url') + 'tasks/updateTaskItemsOrder', data);
	}
</script>
