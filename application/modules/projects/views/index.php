<!-- start: PAGE CONTENT -->
    <section class="content">
		<div class="container-fluid">
		<!-- Main content -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
						<div class="header">
<h2><?php echo "Projects"; ?> <div align="center" style="width:60%;float: right;text-align: -webkit-left;"><?php echo "List Of Projects"; ?></div></h2>

  <ul class="header-dropdown">
     <?php if(CheckPermission("document_maker", "own_create")){ ?>
     <button type="button" class="btn-sm  btn btn-primary waves-effect amDisable modalButton" data-src="" data-width="555" ><i class="material-icons">add</i><?php echo "Add New Project"; ?></button>
  <?php }?>
  </ul>
</div>
                 	 <!-- /.box-header -->
                    <div class="body table-responsive">
<div class="row com-row">
<div class="col-md-1">
        		<span class="mka-com-add DeshboardModal" data-crud-id="16214"></span>
        	</div>
        </div>
    <div class="row filter-row">
    <?php echo $obj->getFilterHtml(); ?>
    </div>
    <table id="example_document_maker" class="table table-bordered table-striped table-hover delSelTable example_document_maker">
    <thead>
    <tr>
    <th>
    <input type="checkbox" class="selAll" id="basic_checkbox_1mka" />
    <label for="basic_checkbox_1mka"></label>
    </th>
    <th><?php echo "Title"; ?></th>
    <th><?php echo "Client"; ?></th>
    <th><?php echo "Price"; ?></th>
    <th><?php echo "Start Date"; ?></th>
    <th><?php echo "Deadline"; ?></th>
    <!-- <th><?php echo "Progress"; ?></th> -->
    <th><?php echo "Status"; ?></th>
    
    <?php  $cf = getCustomFields('document_maker');
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

<div class="modal fade" id="nameModal_document_maker"  role="dialog"><!-- Modal Crud Start-->
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				  <h4 class="box-title"  id="titleForm"><?php echo "Add Project"; ?></h4>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div><!--End Modal Crud -->

<script type="text/javascript">
var data_table = function($filter, $search) {
	var url = "<?php echo base_url();?>";
	return table = $("#example_document_maker").DataTable({
		"dom": 'lfBrtip',
				  "buttons": ['copy','excel','print'],
		"processing": true,
        "serverSide": true,
        "ajax": {
        	"url" : url + "projects/ajxData",
				"data": function ( d ) {
					console.log('data->>',d);
					if($filter != '') {
						$.each($filter, function(index, val) {
							d[index] = val;
							console.log('data2->>',d);
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
			<?php if(!CheckPermission("document_maker", "all_delete") && !CheckPermission("document_maker", "own_delete")){ ?>
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
		<?php if(!isset($_COOKIE['project_filter']) || $_COOKIE['project_filter'] == '') { ?>
        ,
        startDate: "<?php echo $sDate = "01-".date("m-Y"); ?>",
        endDate: "<?php echo date("d-m-Y", strtotime($sDate. " + 60 day")); ?>"
        <?php } ?>
    });
}



jQuery(document).ready(function() {
	//getGridInfoBoxVal('document_maker');
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
      		console.log('$filter->',$filter);
		});
      	var dateRange = $(this).val();
      	console.log('$filter->',$filter);
        data_table($filter, $sVal);
        //getGridInfoBoxVal('document_maker');
        $.post('<?php echo base_url().'projects/setFilterCookie' ?>', {Projects_filter: $filter});
    });

	
	$('body').off('submit', '#form');
	$('body').on('submit', '#form', function(ev) {
		ev.preventDefault();
		$('#nameModal_document_maker').find('input[name="save"]').prop('disabled', true);
		$('#nameModal_document_maker').find('input[name="save"]').after('<span class="mka-loading"><img src="<?php echo iaBase().'assets/images/widget-loader-lg.gif'; ?>" alt="" /><span>');
		var formData = new FormData($(this)[0]);
		$.ajax({
			url: '<?php echo base_url().'projects/addedit' ?>',
			method: 'POST',
			async: false,
			data: formData,
			cache: false,
        	contentType: false,
        	processData: false
		}).done(function(mka) {
			console.log(mka);
			if(mka > 0) {
				$('#nameModal_document_maker').modal('hide');
				setTimeout(function() {
			        $('#example_document_maker').DataTable().ajax.reload();
			        //getGridInfoBoxVal('document_maker');
			        showNotification('<?php echo lang('your_action_has_been_completed_successfully'); ?>.', 'success');
					
					$.post('<?php echo base_url().'projects/getFilterHtml/1' ?>', function(data) {
						$('.filter-row').html(data);
						$("select").selectpicker("refresh");
						date_picker();
						$.AdminBSB.input.activate();
					});
				}, 300);
			} else {
				$('#nameModal_document_maker').modal('hide');
				showNotification('<?php echo "Error found"; ?>.', 'danger');
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
						$('#example_document_maker').DataTable().ajax.reload();
						//getGridInfoBoxVal('document_maker');
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
	<?php if(CheckPermission("document_maker", "all_delete") || CheckPermission("document_maker", "own_delete")){ ?>
		cjhk = 1;
	<?php } ?>
	setTimeout(function() {
		var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
		//$('.table-date-range').css('right',add_width+'px');

		if(cjhk == 1) {
			$('.dataTables_info').before('<button data-del-url="<?php echo base_url() ?>document_maker/delete/" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left"> <i class="material-icons col-red">delete</i> </button><br><br>');
		}
	}, 1000);


	$("body").on("click",".modalButton", function(e) {  
		var loading = '<img src="<?php echo iaBase() ?>assets/images/loading.gif" />';
		$("#nameModal_document_maker").find(".modal-body").html(loading);
		$("#nameModal_document_maker").find(".modal-body").attr("style","text-align: center");    
		$.ajax({
			url : "<?php echo base_url()."projects/getmodal";?>",
			method: "post", 
			data : {
			id: $(this).attr("data-src")
			}
			}).done(function(data) {
			$("#nameModal_document_maker").find(".modal-body").removeAttr("style");  
			$("#nameModal_document_maker").find(".modal-body").html(data);
			$("#nameModal_document_maker").modal("show");
			
var document_maker_titlea = $("#document_maker_titlea").val();
if(document_maker_titlea !=''){
	$("#titleForm").html('<?php echo "Edit Project"; ?>');
} else{
	$("#titleForm").html('<?php echo "Add Project"; ?>');
}
					  
					  
					  
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


	/*$('body').on('click', '.show-doc-data', function() {
		alert($(this).attr('rel'));
	});*/
});
} ) ( jQuery );
</script>
