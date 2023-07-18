
<form action="javascript:;" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($field_type_id)){?>
 <input type="hidden"  name="id" value="<?php echo isset($data->field_type_id) ?$data->field_type_id : "";?>"> 
 <?php } ?>
 <input type="hidden"  name="formBuider_id" value="<?php echo isset($formBuider_id) ?$formBuider_id : "";?>">
 <div class="box-body">
 
<div class="form-group form-float">
<div class="form-line">
<input type="text" class="form-control" id="title" name="title" required value="<?php echo isset($data->title)?$data->title:"";?>"  >
<label for="title" class="form-label"><?php echo lang('formBuilderTitle'); ?> <span class="text-red">*</span></label>
</div>
</div>

<!-- <div class="form-group form-float">
<div class="form-line">
<input type="text" class="form-control" id="placeholder" name="placeholder"  value="<?php //echo isset($data->placeholder)?$data->placeholder:"";?>"  >
<label for="placeholder" class="form-label"><?php //echo lang('formBuilderPlaceholder'); ?></label>
</div>
</div> -->

<input type="hidden" class="form-control" id="placeholder" name="placeholder"  value="">

<div class="form-group form-float">
<div class="form-line">

<select name="field_type" class="form-control select2" id="field_type" >
<option value="text" <?php if(isset($data->field_type) && ($data->field_type == "text")){ echo "selected";}?>>Text</option>
<option value="textarea" <?php if(isset($data->field_type) && ($data->field_type == "textarea")){ echo "selected";}?>>Textarea</option>
<option value="select" <?php if(isset($data->field_type) && ($data->field_type == "select")){ echo "selected";}?>>Select</option>
<option value="multi_select" <?php if(isset($data->field_type) && ($data->field_type == "multi_select")){ echo "selected";}?>>Multi Select</option>
<option value="email" <?php if(isset($data->field_type) && ($data->field_type == "email")){ echo "selected";}?>>Email</option>
<option value="date" <?php if(isset($data->field_type) && ($data->field_type == "date")){ echo "selected";}?>>Date</option>
<option value="number" <?php if(isset($data->field_type) && ($data->field_type == "number")){ echo "selected";}?>>Number</option>
</select>
<label for="field_type" class="form-label"><?php echo lang('formBuilderFieldType'); ?></label>
</div>
</div>

<div class="form-group form-float"  id="options_container"  style="display: <?php if(isset($data->field_type) && ($data->field_type == "select" || $data->field_type == "multi_select")){ echo "block";}else{ echo "none";}?>; ">
<div class="form-line">
<input type="text" name="options" id="options" class="form-control" value="<?php echo isset($data->options)?$data->options:"";?>" >
<label for="options" class="form-label"><?php echo lang('formBuilderOptions'); ?></label>
</div>
<span style="color:red;"><?php echo lang('used_to_each_option'); ?> ( | )  C </span>
</div>


<div class="form-group form-float">
<div class="form-stacked">
<label for="required" class="form-label"><?php echo lang('formBuilderRequired'); ?></label>
<input type="radio" id="required1" name="required"  value="Yes" <?php if(isset($data->required) && ($data->required=='Yes')){echo"checked";}else{echo "checked=''";}?>>
<label for="required1"><?php echo lang('yes'); ?></label>
<input type="radio" id="required2" name="required"  value="No" <?php if(isset($data->required) && ($data->required=='No')){echo"checked='checked'";}?>>
<label for="required2"><?php echo lang('no'); ?></label>
</div>
</div>



</div>

<!-- /.box-body -->
<div class="box-footer1">
<button type="button" data-dismiss="modal" class="btn btn-danger" aria-label="Close">Close</button>
<input type="submit" value="<?php echo lang('save'); ?>" name="save" class="btn btn-primary btn-color" style="float:right;">
</div>
</form>
<script>
  $.AdminBSB.input.activate();
    $(document).ready(function () {
        $("#field_type").change(function () {
            showHideFieldOptions($(this).val());
        });
    });

    //show the options field only for slect/multi_select type fields
    function showHideFieldOptions(fieldType) {
        if (fieldType === "select" || fieldType === "multi_select") {
            $("#options_container").show();
        } else {
            $("#options_container").hide();
        }
    }

</script>