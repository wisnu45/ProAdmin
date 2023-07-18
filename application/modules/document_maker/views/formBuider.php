<style>
.formFields .form-control { background: #ececec; padding: 5px 10px !important;}
.formFields button.btn.dropdown-toggle.btn-default {
    background: #ececec !important;
}
.actionAll {  vertical-align: middle !important;}
</style>   
<section class="content">
	<div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
					<div class="header">
                       <h2><?php echo isset($form_data->document_maker_titlea)?$form_data->document_maker_titlea:lang('formBuilder');?><br />
                       <p style="margin: 5px 0 0 0;font-size: 13px;color: #5a5959;"><?php echo isset($form_data->document_maker_description)?$form_data->document_maker_description:'';?></p></h2>
                          	<ul class="header-dropdown">
                            
                         	<a href="<?php echo base_url()."document_maker/form/$form_id" ?>" class="btn-sm  btn btn-default waves-effect amDisable modalButton" target="_BLANK"><i class='glyphicon glyphicon-eye-open'></i><?php echo lang('form_makerPrivew') ?></a>
                          	</ul>
                        </div>
             	 <!-- /.box-header -->
<div class="body table-responsive">
<table id="" class="table example_product_category">
<thead style="display:none;">
<tr>
<th style="width:80%;"><?php echo lang('formBuilderTitle') ?></th>
<th style="width:20%;"><?php echo lang('action'); ?></th>
</tr>
</thead>
<tbody id="estimate-form-table-sortable" class="formFields">
<?php if(!empty($view_data) && is_array($view_data)){
	foreach($view_data as $key => $value){
		$field_type_id =isset($value->field_type_id)?$value->field_type_id:'';
		$title =isset($value->title)?$value->title:'';
		$placeholder =isset($value->placeholder)?$value->placeholder:'';
		$field_type =isset($value->field_type)?$value->field_type:'';
		$options =isset($value->options)?$value->options:'';
		$requiredIcon = isset($value->required)?'*':'';
		$required = isset($value->required)?'required':'';
 ?>
    
<tr role="row"  draggable="false">
<td><label data-id="1" class="field-row"><?php echo $title;?>?  <?php echo $requiredIcon;?></label>
<div class="form-group">
	<?php if($field_type=='text'){	?>
	<input type="text" name="title" value="" id="title" class="form-control" placeholder="<?php echo $placeholder;?>"  <?php echo $required;?>>
	<?php } ?>
	<?php if($field_type=='textarea'){	?>
	<textarea name="title" cols="20" rows="5" id="title" class="form-control" placeholder="<?php echo $placeholder;?>"  <?php echo $required;?>></textarea>
	<?php } ?>
	<?php if($field_type=='email'){	?>
	<input type="email" name="title" value="" id="title" class="form-control" placeholder="<?php echo $placeholder;?>"  <?php echo $required;?>>
	<?php } ?>
	<?php if($field_type=='date'){	?>
	<input type="date" name="title" value="" id="title" class="form-control" placeholder="<?php echo $placeholder;?>"  <?php echo $required;?>>
	<?php } ?>
	<?php if($field_type=='number'){	?>
	<input type="number" name="title" value="" id="title" class="form-control" placeholder="<?php echo $placeholder;?>"  <?php echo $required;?>>
	<?php } ?>
	<?php if($field_type=='select'){	?>
	<select name="title" class="form-control select2" id="title" placeholder="<?php echo $placeholder;?>"  <?php echo $required;?>>
	<option value="" ><?php echo $placeholder;?></option>
	<?php if(!empty($options)){
		foreach( explode("|",$options) as $key =>$value){
		?><option value="<?php echo $value;?>"><?php echo $value;?></option>
	    <?php 
		}
	}?>
	</select>
	<?php } ?>
	<?php if($field_type=='multi_select'){	?>
	<select name="title" class="form-control select2" multiple="multiple" id="title" placeholder="<?php echo $placeholder;?>"  <?php echo $required;?>>
	<option value="" ><?php echo $placeholder;?></option>
	<?php if(!empty($options)){
		foreach( explode("|",$options) as $key =>$value){
		?><option value="<?php echo $value;?>"><?php echo $value;?></option>
	    <?php 
		}
	}?>
	</select>
	<?php } ?></div>
</td>
<td class=" text-right actionAll"><a sty id="btnEditRow" class="modalButtonfield mClass"  href="javascript:;" type="button" data-src="<?php echo $field_type_id;?>" title="<?php echo $title;?>"><i class="material-icons">mode_edit</i></a>
<a href="<?php echo base_url().'document_maker/delFormField/'.$field_type_id; ?>" class="mClass" style="cursor:pointer;" onclick=" if(!confirm('Are you sure')) { return false; }" title="delete" ><i class="material-icons col-red font-20">delete</i></a>
</td>
</tr>


	<?php
		}
	}?>
</tbody>
</table>
<div class="" align="center">
<button type="button" class="btn-sm  btn btn-default waves-effect amDisable modalButton modalButtonfield" field_type_id='' data-src="" data-width="555" ><i class="material-icons">add</i><?php echo lang('formBuildeAddField'); ?></button>
</div>
        <hr>
        <div class="form-group">
        	<textarea name="document_template" id="document_template" class="ckeditor"><?= isset($form_data->document_template)?$form_data->document_template:''; ?></textarea>
        </div>
        <div class="form-group form-float">
        	<div class="form-line">
        		<label class="form-label"><?php echo lang('email'); ?> <span class="text-red">*</span> </label>
        		<input type="text" name="user_email" required class="form-control" value="<?= isset($form_data->user_email)?$form_data->user_email:''; ?>">
        	</div>
        </div>
        <div class="form-group">
        	<button class="btn btn-primary save-template" rel="<?php echo isset($form_id)?$form_id:'';?>">Save Template</button>
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
<div class="modal fade" id="nameModal_document_makerfield"  role="dialog"><!-- Modal Crud Start-->
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				  <h4 class="box-title"  id="titleForm"><?php echo lang('add_maker');?></h4>
			</div>
			<div class="modal-body">
            </div>
		</div>
	</div>
</div><!--End Modal Crud -->

<script type="text/javascript">



jQuery(document).ready(function() {

	$('.save-template').on('click', function() {
		var _the = $(this);
		var form_id = _the.attr('rel');
		if(form_id == '' || form_id <= 0) {
			alert('<?php echo lang("unable_to_identify_document"); ?>.');
		} else {
			$.ajax({
				url: $('body').attr('data-base-url') + 'document_maker/savetemplate',
				type: 'POST',
				data: {
					form_id: form_id,
					template: _the.parents('.body').first().find('#document_template').val(),
					user_email: _the.parents('.body').first().find('input[name="user_email"]').val(),
				},
			}).done(function(mka) {
				if(mka) {
					showNotification('<?php echo lang("template_successfully_saved"); ?>.', 'success');
				}
			});
			
		}
	});





	var tt = $('textarea.ckeditor').ckeditor();
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.config.extraPlugins = 'imageuploader';
	$('body').off('submit', '#form');
	$('body').on('submit', '#form', function(ev) {
		//ev.preventDefault();
		$('#nameModal_document_makerfield').find('input[name="save"]').prop('disabled', true);
		$('#nameModal_document_makerfield').find('input[name="save"]').after('<span class="mka-loading"><img src="<?php echo iaBase().'assets/images/widget-loader-lg.gif'; ?>" alt="" /><span>');
		var formData = new FormData($(this)[0]);
		$.ajax({
			url: '<?php echo base_url().'document_maker/addEditField' ?>',
			method: 'POST',
			async: false,
			data: formData,
			cache: false,
        	contentType: false,
        	processData: false
		}).done(function(mka) {
			if(mka) {
				window.location.reload();
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
	$("body").on("click",".modalButtonfield", function(e) {  
	    var id=$(this).attr("data-src");
		var formBuider_id='<?php echo isset($form_id)?$form_id:'';?>';
		//alert(id+'='+formBuider_id);
		var loading = '<img src="<?php echo iaBase() ?>assets/images/loading.gif" />';
		$("#nameModal_document_makerfield").find(".modal-body").html(loading);
		$("#nameModal_document_makerfield").find(".modal-body").attr("style","text-align: center");    
		$.ajax({
			url : "<?php echo base_url()."document_maker/getModalField";?>",
			method: "post", 
			data : {id: id,formBuider_id: formBuider_id}
			}).done(function(data) {
			$("#nameModal_document_makerfield").find(".modal-body").removeAttr("style");  
			$("#nameModal_document_makerfield").find(".modal-body").html(data);
			$("#nameModal_document_makerfield").modal("show");
			var document_maker_titlea = $("#document_maker_titlea").val();
			if(document_maker_titlea !=''){
				$("#titleForm").html('<?php echo lang('formBuildeEditField'); ?>');
			} else{
				$("#titleForm").html('<?php echo lang('formBuildeAddField'); ?>');
			}
		})
	});
});
}) ( jQuery );

</script>