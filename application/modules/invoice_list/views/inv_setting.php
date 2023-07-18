<section class="content">
	<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 invice">
		<div class="card">
			<div class="header">
                <h2> 
 					<?php echo lang('invoice_settings'); ?>                                                 
                </h2>
            </div>
    		<div class="body  table-responsive">
    			<form role="" action="<?php echo base_url().'invoice/setting' ?>" method="post" class="">
    				

<div class="form-group form-float">
<div class="form-line focused">
<input type="text" name="invoice_prefix" value="<?php if(isset($inv_setting[0]->invoice_prefix)){ echo $inv_setting[0]->invoice_prefix; } ?>" class="form-control">
<label class="form-label"><?php echo lang('invoice_prefix'); ?>:</label>
</div>
</div>


<div class="form-group form-float m-t-20">
                        <div class="form-line">
                        <label class="form-label "><?php echo lang('date_format'); ?>:</label>
                          <select name="date_formate" class="form-control m-t-10">
                            <option value="Y-m-d" <?php if(isset($inv_setting[0]->date_formate) && $inv_setting[0]->date_formate == 'Y-m-d'){ echo 'selected'; } ?> >Y-m-d</option>
								<option value="d-m-Y" <?php if(isset($inv_setting[0]->date_formate) && $inv_setting[0]->date_formate == 'd-m-Y'){ echo 'selected'; } ?> >d-m-Y</option>
								<option value="m-d-Y" <?php if(isset($inv_setting[0]->date_formate) && $inv_setting[0]->date_formate == 'm-d-Y'){ echo 'selected'; } ?> >m-d-Y</option>
								<option value="Y/m/d" <?php if(isset($inv_setting[0]->date_formate) && $inv_setting[0]->date_formate == 'Y/m/d'){ echo 'selected'; } ?> >Y/m/d</option>
								<option value="d/m/Y" <?php if(isset($inv_setting[0]->date_formate) && $inv_setting[0]->date_formate == 'd/m/Y'){ echo 'selected'; } ?> >d/m/Y</option>
								<option value="m/d/Y" <?php if(isset($inv_setting[0]->date_formate) && $inv_setting[0]->date_formate == 'm/d/Y'){ echo 'selected'; } ?> >m/d/Y</option>
                          </select>
                        </div>
                      </div>


    			<div class="form-group form-float m-t-20">
                        <div class="form-line">
                        <label class="form-label "><?php echo lang('currency'); ?>:</label>
                          <select name="currency" class="form-control m-t-10">
								<?php echo $currency; ?>
							</select>
                        </div>
                      </div>	
                    


<div class="form-group form-float m-t-20">
                          <div class="form-line focused">
                              <input type="text" class="form-control" name="invoice_status" value="<?php if(isset($inv_setting[0]->invoice_status)){ echo $inv_setting[0]->invoice_status; } ?>">
                              <label class="form-label"><?php echo lang('status'); ?>:</label>
                          </div>
                              <span class=""><?php echo lang('enter_multiple_status_saperated_by_comma'); ?> (,)</span>

</div>



                    
                    <div class="form-group m-b-i-20">
                    	<div class="col-md-10 col-md-offset-2">
                    		<div class="row form-inline">
								<div class="col-md-12">
									<label for="" class="control-label col-md-2 m-t-10"></label>
									<div class="col-md-3">
										<label for=""><?php echo lang('name'); ?></label>
									</div>
									<div class="col-md-3" style="float:inherit;">
										<label for=""><?php echo lang('percentage'); ?></label>
									</div>
									<div class="col-md-3">
										<label for=""><?php echo lang('calculate_On'); ?></label>
									</div>
								</div>
							</div>
                    	</div>
                    </div>
                    <?php $taxes = json_decode($inv_setting[0]->taxes);	?>
                    <div class="form-group">
                      	<label class="control-label col-sm-2 p-l-0" for=""><?php echo lang('tax_fields'); ?>:</label>
						<div class="col-sm-10">
							<div class="row form-inline mka-row">
								<div class="col-md-12">
									<label for="" class="control-label col-md-2 m-t-10"><?php echo lang('tax'); ?>1:</label>
									<div class="col-md-3">
									 <div class="form-group form-float">
                                       <div class="form-line focused">
										<input type="text" name="tax_key[]" value="<?php if(isset($taxes[0]->tax_key)) { echo $taxes[0]->tax_key; } ?>" class="form-control" placeholder="Label">
									</div>
									</div>
									</div>
									<div class="col-md-3" style="float:inherit;">
									<div class="form-group form-float">
                                       <div class="form-line focused">	
										<input type="text" name="tax_value[]" value="<?php if(isset($taxes[0]->tax_value)) { echo $taxes[0]->tax_value; } ?>" class="form-control">
										</div>
										</div>
										<span class="percentagecl" id="basic-addon1">%</span>
									</div>
									
									<div class="col-md-3">
									  <div class="form-group form-float">
                                        <div class="form-line">
										<select name="calculate_on[]" class="form-control">
											<option value="sub_total" <?php if(isset($taxes[0]->calculate_on) && $taxes[0]->calculate_on == 'sub_total') { echo 'selected'; } ?> ><?php echo lang('sub_total'); ?></option>
										</select>
									</div>
									</div>
									</div>
								</div>
							</div>
							<div class="row form-inline mka-row">
								<div class="col-md-12">
									<label for="" class="control-label col-md-2 m-t-10"><?php echo lang('tax'); ?>2:</label>
									<div class="col-md-3">
										<div class="form-group form-float">
                                       <div class="form-line focused">
										<input type="text" name="tax_key[]" value="<?php if(isset($taxes[1]->tax_key)) { echo $taxes[1]->tax_key; } ?>" class="form-control width-100" placeholder="<?php echo lang('label'); ?>">
									</div>
									</div>
									</div>
									<div class="col-md-3"  style="float:inherit;">
										<div class="form-group form-float">
                                       <div class="form-line focused">
										<input type="text" name="tax_value[]" value="<?php if(isset($taxes[1]->tax_value)) { echo $taxes[1]->tax_value; } ?>" class="form-control">
										
									</div>
									</div>
									<span class="percentagecl" id="basic-addon1">%</span>
									</div>
									<div class="col-md-3">
										<div class="form-group form-float">
                                       <div class="form-line focused">
										<select name="calculate_on[]" class="form-control">
											<option value="sub_total" <?php if(isset($taxes[1]->calculate_on) && $taxes[1]->calculate_on == 'sub_total') { echo 'selected'; } ?> ><?php echo lang('sub_total'); ?></option>
											<option value="tax1" <?php if(isset($taxes[1]->calculate_on) && $taxes[1]->calculate_on == 'tax1') { echo 'selected'; } ?> ><?php echo lang('tax'); ?>1</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row form-inline mka-row">
								<div class="col-md-12">
									<label for="" class="control-label col-md-2 m-t-10"><?php echo lang('tax') ?>3:</label>
									<div class="col-md-3">
										<div class="form-group form-float">
                                       <div class="form-line focused">
										<input type="text" name="tax_key[]" value="<?php if(isset($taxes[2]->tax_key)) { echo $taxes[2]->tax_key; } ?>" class="form-control width-100" placeholder="<?php echo lang('label'); ?>">
									</div>
									</div>
									</div>
									<div class="col-md-3" style="float:inherit;">
										<div class="form-group form-float">
                                       <div class="form-line focused">
										<input type="text" name="tax_value[]" value="<?php if(isset($taxes[2]->tax_value)) { echo $taxes[2]->tax_value; } ?>" class="form-control">
										
									</div>
									</div>
									<span class="percentagecl" id="basic-addon1">%</span>
									</div>
									<div class="col-md-3">
										<div class="form-group form-float">
                                       <div class="form-line focused">
										<select name="calculate_on[]" class="form-control width-100">
											<option value="sub_total" <?php if(isset($taxes[2]->calculate_on) && $taxes[2]->calculate_on == 'sub_total') { echo 'selected'; } ?> ><?php echo lang('sub_total'); ?></option>
											<option value="tax1" <?php if(isset($taxes[2]->calculate_on) && $taxes[2]->calculate_on == 'tax1') { echo 'selected'; } ?> ><?php echo lang('tax'); ?>1</option>
											<option value="tax2" <?php if(isset($taxes[2]->calculate_on) && $taxes[2]->calculate_on == 'tax2') { echo 'selected'; } ?> ><?php echo lang('tax'); ?>2</option>
										</select>
									</div>
									</div>
									</div>
								</div>
							</div>
							<div class="row form-inline mka-row">
								<div class="col-md-12">
									<label for="" class="control-label col-md-2 m-t-10"><?php echo lang('tax'); ?>4:</label>
									<div class="col-md-3">
										<div class="form-group form-float">
                                       <div class="form-line focused">
										<input type="text" name="tax_key[]" value="<?php if(isset($taxes[3]->tax_key)) { echo $taxes[3]->tax_key; } ?>" class="form-control width-100" placeholder="<?php echo lang('label'); ?>">
									</div>
									</div>
									</div>
									<div class="col-md-3" style="float:inherit;">
										<div class="form-group form-float">
                                       <div class="form-line focused">
										<input type="text" name="tax_value[]" value="<?php if(isset($taxes[3]->tax_value)) { echo $taxes[3]->tax_value; } ?>" class="form-control">
									</div>
									</div>
										<span class="percentagecl" id="basic-addon1">%</span>
									</div>
									<div class="col-md-3">
										<div class="form-group form-float">
                                       <div class="form-line focused">
										<select name="calculate_on[]" class="form-control width-100">
											<option value="sub_total" <?php if(isset($taxes[3]->calculate_on) && $taxes[3]->calculate_on == 'sub_total') { echo 'selected'; } ?> ><?php echo lang('sub_total'); ?></option>
											<option value="tax1" <?php if(isset($taxes[3]->calculate_on) && $taxes[3]->calculate_on == 'tax1') { echo 'selected'; } ?> ><?php echo lang('tax'); ?>1</option>
											<option value="tax2" <?php if(isset($taxes[3]->calculate_on) && $taxes[3]->calculate_on == 'tax2') { echo 'selected'; } ?> ><?php echo lang('tax'); ?>2</option>
											<option value="tax3" <?php if(isset($taxes[3]->calculate_on) && $taxes[3]->calculate_on == 'tax3') { echo 'selected'; } ?> ><?php echo lang('Tax'); ?>3</option>
										</select>
									</div>
									</div>
									</div>
								</div>
							</div>
							
						</div>
                    </div>
                    </div>
    				<div class="form-group template-vars">
						<label for="help-variables " class="control-label col-sm-2 p-l-0"><?php echo lang('template_variables'); ?></label>
						<div class="col-sm-10">
							<div class="help-variables-div">
								<p class="line">
									<span class="col-md-4">
										<code>{invoice_id}</code>
									</span>
									<span class="col-md-7">
										<strong>: <?php echo lang('invoice_id'); ?></strong>
									</span>
								</p>
								<p class="line">
									<span class="col-md-4">
										<code>{order_date}</code>
									</span>
									<span class="col-md-7">
										<strong>: <?php echo lang('order_date'); ?></strong>
									</span>
								</p>
								<p class="line">
									<span class="col-md-4">
										<code>{due_date}</code>
									</span>
									<span class="col-md-7">
										<strong>: <?php echo lang('due_date'); ?></strong>
									</span>
								</p>
								<p class="line">
									<span class="col-md-4">
										<code>{order_status}</code>
									</span>
									<span class="col-md-7">
										<strong>: <?php echo lang('order_status'); ?></strong>
									</span>
								</p>
								<p class="line">
									<span class="col-md-4">
										<code>{user_name}</code>
									</span>
									<span class="col-md-7">
										<strong>: <?php echo lang('user_customer_name'); ?></strong>
									</span>
								</p>
							</div>
						</div>
					</div>
    				<div class="form-group">
                      	<label class="control-label col-sm-2" for=""><?php echo lang('header'); ?>:</label>
						<div class="col-sm-10">
							<textarea name="header" rows="3" class="form-control ckeditor"><?php if(isset($inv_setting[0]->header)){ echo $inv_setting[0]->header; } ?></textarea>
						</div>
                    </div>
                    <div class="form-group">
                      	<label class="control-label col-sm-2" for=""><?php echo lang('content'); ?>:</label>
						<div class="col-sm-10">
							<textarea name="contant" rows="3" class="form-control ckeditor"><?php if(isset($inv_setting[0]->contant)){ echo $inv_setting[0]->contant; } ?></textarea>
						</div>
                    </div>
                    <div class="form-group">
                      	<label class="control-label col-sm-2" for=""><?php echo lang('footer'); ?>:</label>
						<div class="col-sm-10">
							<textarea name="footer" rows="3" class="form-control ckeditor"><?php if(isset($inv_setting[0]->footer)){ echo $inv_setting[0]->footer; } ?></textarea>
						</div>
                    </div>
                    <div class="form-group">
                    	<div class="col-md-6 col-md-offset-2">
                    		<input type="hidden" name="id" value="<?php if(isset($inv_setting[0]->id)){ echo $inv_setting[0]->id; } ?>">
                    		<button class="btn btn-primary" type="submit"> <?php echo lang('update'); ?> </button>
                    	</div>
                    </div>
    			</form>
    		</div>
    	</div>
    </div>
</div>
</section>
<script>
	$(document).ready(function() {
		CKEDITOR.config.allowedContent = true;
	})
</script>