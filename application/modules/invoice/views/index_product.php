<?php
	if (CheckPermission("invoice", "own_read")) {
?>
<!-- start: PAGE CONTENT -->
    <section class="content">
		<div class="container-fluid">
		<!-- Main content -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
						<div class="header">
                           <h2><?php echo lang('products') ?></h2>
                              <ul class="header-dropdown">
                                 <?php if(CheckPermission("invoice", "own_create")){ ?>
                                 <button type="button" class="btn-sm  btn btn-primary waves-effect amDisable modalButton" data-src="" data-width="555" ><i class="material-icons">add</i><?php echo lang('add_products') ?></button>
                              <?php }?>
                              </ul>
                            </div>
                 	 <!-- /.box-header -->
                    <div class="body table-responsive">
<div class="row com-row">
<div class="col-md-1">
        		<span class="mka-com-add DeshboardModal" data-crud-id="63355"></span>
        	</div>
        </div>
  	<div class="row filter-row">
			<?php echo $obj->get_filter_html(); ?>
		</div>
<table id="example_products" class="table table-bordered table-striped table-hover delSelTable example_products">
								  <thead>
								 	<tr>
										<th>
											<input type="checkbox" class="selAll" id="basic_checkbox_1mka" />
                    						<label for="basic_checkbox_1mka"></label>
                    					</th>
<th><?php echo lang('product_name') ?></th>
<th><?php echo lang('quantity') ?></th>
<th><?php echo lang('unit_price') ?></th>

									<?php  $cf = get_cf('products');
					                    if(is_array($cf) && !empty($cf)) {
					                      foreach ($cf as $cfkey => $cfvalue) {
					                        echo '<th>'.lang(get_lang($cfvalue->rel_crud).'_'.get_lang($cfvalue->name)).'</th>';
					                      }
					                    }
						            ?>
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

<div class="modal fade" id="nameModal_products"  role="dialog"><!-- Modal Crud Start-->
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				  <h4 class="box-title"><?php echo lang('products'); ?></h4>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div><!--End Modal Crud -->

<script type="text/javascript">
var data_table = function($filter, $search) {
	var url = "<?php echo base_url();?>";
	return table = $("#example_products").DataTable({
		"dom": 'lfBrtip',
				  "buttons": ['copy','excel','pdf','print'],
		"processing": true,
        "serverSide": true,
        "ajax": {
        	"url" : url + "invoice/ajx_data_products",
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
			<?php if(!CheckPermission("invoice", "all_delete") && !CheckPermission("invoice", "own_delete")){ ?>
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
		<?php if(!isset($_COOKIE['products_filter']) || $_COOKIE['products_filter'] == '') { ?>
        ,
        startDate: "<?php echo $sDate = "01-".date("m-Y"); ?>",
        endDate: "<?php echo date("d-m-Y", strtotime($sDate. " + 60 day")); ?>"
        <?php } ?>
    });
}



jQuery(document).ready(function() {
	get_grid_info_box_val('products');
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
        get_grid_info_box_val('products');
        $.post('<?php echo base_url().'invoice/set_filter_cookie_products' ?>', {products_filter: $filter});
    });


	$('body').off('submit', '#form');
	$('body').on('submit', '#form', function(ev) {
		ev.preventDefault();
		$('#nameModal_products').find('input[name="save"]').prop('disabled', true);
		$('#nameModal_products').find('input[name="save"]').after('<span class="mka-loading"><img src="<?php echo mka_base().'assets/images/widget-loader-lg.gif'; ?>" alt="" /><span>');
		var formData = new FormData($(this)[0]);
		$.ajax({
			url: '<?php echo base_url().'invoice/add_edit_products' ?>',
			method: 'POST',
			async: false,
			data: formData,
			cache: false,
        	contentType: false,
        	processData: false
		}).done(function(mka) {
			if(mka > 0) {
				$('#nameModal_products').modal('hide');
				setTimeout(function() {
					if($('.submodule-main-div').length > 0) {
				            $('.custom-tab').each(function() {
				            	if($(this).hasClass('active')) {
				            		$(this).trigger('click');
				            	}
				            })
					} else {
				        $('#example_products').DataTable().ajax.reload();
				        get_grid_info_box_val('products');
				        showNotification('<?php echo lang('your_action_has_been_completed_successfully'); ?>.', 'success');
					}
					$.post('<?php echo base_url().'invoice/get_filter_html_products/1' ?>', function(data) {
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
						$('#example_products').DataTable().ajax.reload();
						get_grid_info_box_val('products');
					}
				});
			});
			showNotification('<?php echo lang('records_deleted_successfully'); ?>.', 'success');
		}, 'json');
	});

} );

( function($) {
$(document).ready(function(){
	var  cjhk = 0;
	<?php if(CheckPermission("invoice", "all_delete") || CheckPermission("invoice", "own_delete")){ ?>
		cjhk = 1;
	<?php } ?>
	setTimeout(function() {
		var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
		//$('.table-date-range').css('right',add_width+'px');

		if(cjhk == 1) {
			$('.dataTables_info').before('<button data-del-url="<?php echo base_url() ?>invoice/delete_products/" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left"> <i class="material-icons col-red">delete</i> </button><br><br>');
		}
	}, 1000);


	$("body").on("click",".modalButton", function(e) {
		var loading = '<img src="<?php echo mka_base() ?>assets/images/loading.gif" />';
		$("#nameModal_products").find(".modal-body").html(loading);
		$("#nameModal_products").find(".modal-body").attr("style","text-align: center");
		$.ajax({
			url : "<?php echo base_url()."invoice/get_modal_products";?>",
			method: "post",
			data : {
			id: $(this).attr("data-src")
			}
			}).done(function(data) {
			$("#nameModal_products").find(".modal-body").removeAttr("style");
			$("#nameModal_products").find(".modal-body").html(data);
			$("#nameModal_products").modal("show");
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

<?php 
	} else {
?>
<section class="content">
	<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 invice">
		<div class="card">
			<div class="header">
                <h2>Products</h2>
            </div>
	    	<div class="body" style="text-align: center;">
				<h5>You do not have permission to view this.</h5>
	    	</div>
        </div>
    	</div>
    </div>
	</div>
</section>
<?php
	}
?>