<?php 
	$cls = '';
	if(isset($public) && $public == TRUE) {
		$cls = 'pub-content';
	}
?>
<section class="content <?php echo $cls; ?>">
	<div class="container-fluid">
		<div class="card">
			<div class="header">
				<h2><?php echo lang('form_preview'); ?></h2>
			</div>
			<div class="body">
				<form action="<?php echo base_url().'document_maker/requestdoc'; ?>" method="post">
				<?php 
					if(!empty($view_data) && is_array($view_data)){
						foreach($view_data as $key => $value){
							$field_type_id =isset($value->field_type_id)?$value->field_type_id:'';
							$title         =isset($value->title)?$value->title:'';
							$name         =isset($value->title)?str_replace(' ', '_', $value->title):'';
							$placeholder   =isset($value->placeholder)?$value->placeholder:'';
							$field_type    =isset($value->field_type)?$value->field_type:'';
							$options       =isset($value->options)?$value->options:'';
							$requiredIcon  = isset($value->required)?'*':'';
							$required      = isset($value->required)?'required':''; 
				?>

							<div class="form-group form-float">
								<div class="form-line">
									<?php if($field_type == 'textarea') { ?>
									<textarea name="<?php echo $name; ?>" id="" cols="30" class="form-control" <?php echo $required; ?>></textarea>
									<?php } else if($field_type == 'text' || $field_type == 'email' || $field_type == 'number' || $field_type == 'date') { ?>
									<input type="<?php echo $field_type; ?>" name="<?php echo $name; ?>" value="" class="form-control" <?php echo $required; ?>>
									<?php } else if( $field_type == 'select' || $field_type == 'multi_select' ) {
										$multi = '';
										$mk = '';
										if($field_type == 'multi_select') {
											$multi = 'multiple="multiple"'; 
											$mk = '[]';
										}
									?>
									<select name="<?php echo $name.$mk; ?>" id="" <?php echo $multi; ?> class="form-control" <?php echo $required; ?> >
										<option value="" ><?php echo $placeholder;?></option>
										<?php if(!empty($options)){
											foreach( explode("|",$options) as $key =>$value){
											?><option value="<?php echo $value;?>"><?php echo $value;?></option>
										    <?php 
											}
										}?>
									</select>
									<?php } ?>
									<label class="form-label"><?php echo $title; ?> <span class="text-red"><?php echo $requiredIcon; ?></span></label>
								</div>
							</div>
				<?php 
						}
					} 
				?>	

				<div class="form-group">
					<input type="hidden" name="document_id" value="<?php echo $doc_id; ?>">
					<button class="btn btn-primary"><?php echo lang('request_document') ?></button>
					<a href="<?php echo base_url().'document_maker/formBuider/'.$doc_id; ?>" class="btn btn-danger"><?php echo lang('close_preview'); ?></a>
				</div>

				</form>			
			</div>
		</div> 
	</div>
</section>