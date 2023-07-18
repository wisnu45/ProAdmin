<style><?php $this->load->view('assets/css/todo.css'); ?></style>
<section class="content">
	<div class="container-fluid">
		<?php if(CheckPermission("todo", "own_create")){ ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="header">
						<!-- <h2><?php //echo lang('to_do'); ?></h2> -->
						<!-- <ul class="header-dropdown">
							<a href="#__todo" data-toggle="modal" class="btn btn-primary">
								<?php //echo lang('new_todo'); ?>
							</a>
						</ul> -->

						<form action="<?php echo base_url().'todo/todo/todo' ?>" id="add_new_todo_item" method="post"> 
			                <div class="modal-body">
			                    <div class="row">
			                        <input type="hidden" name="todo_id" value="">
			                        <div class="col-md-8 col-md-offset-2">
			                            <div class="col-md-9">
			                                <div class="">
			                                	<input type="text" required placeholder="Enter New To Do Here" name="description" id="description" class="form-control">
			                                </div>
			                            </div>
			                            <div class="col-md-3">
			                            	<button type="submit" class="btn btn-info"><?php echo lang('todo_add_title'); ?></button>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			                <!-- <div class="modal-footer">
			                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
			                    <button type="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
			                </div> -->
			            </form>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="row clearfix todo-page">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="card">
					<div class="header bg-deep-orange">
						<h2> <i class="material-icons">warning</i> <?php echo lang('unfinished_todos_title'); ?></h2>
					</div>
					<div class="body">
						<ul class="list-unstyled todo unfinished-todos todos-sortable">
							<li class="padding no-todos hide ui-state-disabled">
								<?php echo lang('no_unfinished_todos_found'); ?>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 text-center padding">
							<a href="#" class="btn btn-default text-center unfinished-loader"><?php echo lang('load_more'); ?></a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="card">
					<div class="header bg-light-blue">
						<h2> <i class="material-icons">check</i> <?php echo lang('finished_todos_title'); ?></h2>
					</div>
					<div class="body">
						<ul class="list-unstyled todo finished-todos todos-sortable">
							<li class="padding no-todos hide ui-state-disabled">
								<?php echo lang('no_finished_todos_found'); ?>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 text-center padding">
							<a href="#" class="btn btn-default text-center finished-loader">
								<?php echo lang('load_more'); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php //$this->load->view('_todo.php'); ?>
<script>
	var own_update_permissions = '<?php echo CheckPermission("todo", "own_update") ?>';
	var own_delete_permissions = '<?php echo CheckPermission("todo", "own_delete") ?>';
	var user_type = '<?php echo $this->user_type; ?>';
	$(function(){
	    var total_pages_unfinished = '<?php echo $total_pages_unfinished; ?>';
	    var total_pages_finished = '<?php echo $total_pages_finished; ?>';
	    var page_unfinished = 0;
	    var page_finished = 0;
	    $('.unfinished-loader').on('click', function(e) {
	        e.preventDefault();
	        if (page_unfinished <= total_pages_unfinished) {
	            $.post(window.location.href, {
	                finished: 0,
	                todo_page: page_unfinished
	            }).done(function(response) {
	            	console.log("response->",response);
	                response = JSON.parse(response);

	                if (response.length == 0) {
	                    $('.unfinished-todos .no-todos').removeClass('hide');
	                }

	                $.each(response, function(i, obj) {
	                	// console.log("obj->",render_li_items(0, obj));
	                    $('.unfinished-todos').append(render_li_items(0, obj));
	                });
	                page_unfinished++;
	            });
	            console.log("page_unfinished->",page_unfinished);
	            console.log("total_pages_unfinished->",total_pages_unfinished);
	            if (page_unfinished >= (total_pages_unfinished - 1)) {
	                $(".unfinished-loader").addClass("disabled");
	            }
	        }
	    });

	    $('.finished-loader').on('click', function(e) {
	        e.preventDefault();
	        if (page_finished <= total_pages_finished) {
	            $.post(window.location.href, {
	                finished: 1,
	                todo_page: page_finished
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
	        var finished = $(this).prop('checked') === true ? 1 : 0;
	        $.post($('body').attr('data-base-url') + 'todo/changeTodoStatus/' + $(this).val() + '/' + finished , function(data) {
	        	if(data) {
	        		$htm = '<li class="mkaTmp">'+$obj.parents('li').first().html()+'</li>';	
	        		$obj.parents('li').first().fadeOut('slow');
	        		$cl = 'unfinished';
	        		if(finished == 1) {
	        			$cl = 'finished';
	        		}
        			$('ul.'+ $cl +'-todos').append($htm);
	        		$('.mkaTmp').hide();
	        		$('.mkaTmp').find('input[type="checkbox"]').prop('checked', finished);
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
	    var t_date = obj.dateadded;
	    if (finished == 1) {
	        todo_finished_class = ' line-throught';
	        checked = 'checked';
	        t_date = obj.datefinished;
	    }
	    if (user_type=="user") {
			if (own_update_permissions&&own_delete_permissions) {
		    	return '<li><div class="dragger todo-dragger"><i class="material-icons">more_vert</i></div> <input type="hidden" value="' + finished + '" name="finished"><input type="hidden" value="' + obj.item_order + '" name="todo_order"><div class="checkbox checkbox-default todo-checkbox"><input type="checkbox" name="todo_id" value="' + obj.todo_id + '" '+checked+' id="mka'+obj.todo_id+'"><label for="mka'+obj.todo_id+'"></label></div><span class="todo-description' + todo_finished_class + '"><span>' + obj.description + '</span><a href="javascript:;" onclick="deleteTodoItem(this,' + obj.todo_id + ')" class="pull-right text-muted"><i class="material-icons bg-red">delete</i></a><a href="javascript:;" onclick="edit_todo_item('+obj.todo_id+'); return false;" class="pull-right text-muted mright5"><i class="material-icons bg-blue">mode_edit</i></a></span><small class="todo-date">' + t_date + '</small></li>';
		    }
		    else if (own_update_permissions) {
		    	return '<li><div class="dragger todo-dragger"><i class="material-icons">more_vert</i></div> <input type="hidden" value="' + finished + '" name="finished"><input type="hidden" value="' + obj.item_order + '" name="todo_order"><div class="checkbox checkbox-default todo-checkbox"><input type="checkbox" name="todo_id" value="' + obj.todo_id + '" '+checked+' id="mka'+obj.todo_id+'"><label for="mka'+obj.todo_id+'"></label></div><span class="todo-description' + todo_finished_class + '"><span>' + obj.description + '</span><a href="javascript:;" onclick="edit_todo_item('+obj.todo_id+'); return false;" class="pull-right text-muted mright5"><i class="material-icons bg-blue">mode_edit</i></a></span><small class="todo-date">' + t_date + '</small></li>';
		    }
		    else if (own_delete_permissions) {
		    	return '<li><div class="dragger todo-dragger"><i class="material-icons">more_vert</i></div> <input type="hidden" value="' + finished + '" name="finished"><input type="hidden" value="' + obj.item_order + '" name="todo_order"><div class="checkbox checkbox-default todo-checkbox"><input type="checkbox" name="todo_id" value="' + obj.todo_id + '" '+checked+' id="mka'+obj.todo_id+'"><label for="mka'+obj.todo_id+'"></label></div><span class="todo-description' + todo_finished_class + '"><span>' + obj.description + '</span><a href="javascript:;" onclick="deleteTodoItem(this,' + obj.todo_id + ')" class="pull-right text-muted"><i class="material-icons bg-red">delete</i></a></span><small class="todo-date">' + t_date + '</small></li>';
		    }
		    else {
		    	return '<li><div class="dragger todo-dragger"><i class="material-icons">more_vert</i></div> <input type="hidden" value="' + finished + '" name="finished"><input type="hidden" value="' + obj.item_order + '" name="todo_order"><div class="checkbox checkbox-default todo-checkbox"><input type="checkbox" name="todo_id" value="' + obj.todo_id + '" '+checked+' id="mka'+obj.todo_id+'"><label for="mka'+obj.todo_id+'"></label></div><span class="todo-description' + todo_finished_class + '"><span>' + obj.description + '</span></span><small class="todo-date">' + t_date + '</small></li>';
		    }
	    }
	    else {
	    	return '<li><div class="dragger todo-dragger"><i class="material-icons">more_vert</i></div> <input type="hidden" value="' + finished + '" name="finished"><input type="hidden" value="' + obj.item_order + '" name="todo_order"><div class="checkbox checkbox-default todo-checkbox"><input type="checkbox" name="todo_id" value="' + obj.todo_id + '" '+checked+' id="mka'+obj.todo_id+'"><label for="mka'+obj.todo_id+'"></label></div><span class="todo-description' + todo_finished_class + '"><span>' + obj.description + '</span><a href="javascript:;" onclick="deleteTodoItem(this,' + obj.todo_id + ')" class="pull-right text-muted"><i class="material-icons bg-red">delete</i></a><a href="javascript:;" onclick="edit_todo_item('+obj.todo_id+'); return false;" class="pull-right text-muted mright5"><i class="material-icons bg-blue">mode_edit</i></a></span><small class="todo-date">' + t_date + '</small></li>';
	    }
	    
	    
	}

	// Delete single todo item
	function deleteTodoItem(list, id) {
		$.get($('body').attr('data-base-url')+'todo/getUserType/'+id, function(response) {
			if (user_type=="admin") {
				if (confirm("Are you sure?")) {
				    $.get($('body').attr('data-base-url') + 'todo/deleteTodoItem/' + id, function(response) {
				        if (response.success == true) {
				            $(list).parents('li').remove();
				            update_todo_items();
				        }
				    }, 'json');
				} 
			}
			else if (user_type==response) {
				if (confirm("Are you sure?")) {
				    $.get($('body').attr('data-base-url') + 'todo/deleteTodoItem/' + id, function(response) {
				        if (response.success == true) {
				            $(list).parents('li').remove();
				            update_todo_items();
				        }
				    }, 'json');
				} 
			}
			else {
				if (confirm("OOPS! You don't have permission to delete it.")) {
				    $.get($('body').attr('data-base-url') + 'todo/deleteTodoItem/' + id, function(response) {
				        if (response.success == true) {
				            $(list).parents('li').remove();
				            update_todo_items();
				        }
				    }, 'json');
				} 
			}
		}, 'json');
		
		return false;
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
	    var finished = $('.finished-todos li:not(.no-todos)');
	    var i = 1;
	    // Refresh orders
	    $.each(unfinished_items, function() {
	        $(this).find('input[name="todo_order"]').val(i);
	        $(this).find('input[name="finished"]').val(0);
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
	    x = 1;
	    $.each(finished, function() {
	        $(this).find('input[name="todo_order"]').val(x);
	        $(this).find('input[name="finished"]').val(1);
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
	        var todo_id = $(this).find('input[name="todo_id"]').val();
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
	        var todo_id = $(this).find('input[name="todo_id"]').val();
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
	    $.post($('body').attr('data-base-url') + 'todo/updateTodoItemsOrder', data);
	}
</script>

