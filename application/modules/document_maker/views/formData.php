<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="header">
				<h2><?php echo lang('form_data'); ?></h2>
			</div>
			<?php //print_r($form_data); ?>
			<div class="body">
				<div class="row">
					<div class="col-md-12">
						<?php 
						if(isset($form_data) && is_array($form_data) && !empty($form_data)) {
						?>
						<div class="table-responsive">
							<table class="table table-bordered dataTable table-hover">
								<thead>
									<tr>
										<?php foreach ($form_data[0] as $fkey => $fvalue) {
											echo '<th><strong>'.str_replace('_', ' ', $fkey).'</strong></th>';
										} ?>
									</tr>
								</thead>
								<tbody>
									
									<?php 
										foreach ($form_data as $fdkey => $fdvalue) {
											echo '<tr>';
											foreach ($fdvalue as $mka_val) {
												if(is_array($mka_val)) {
													$mka_val = implode(',', $mka_val);
												}
												echo '<td>'.$mka_val.'</td>';
											}
											echo '</tr>';
										}
									?>
									
								</tbody>
							</table>
						</div>
						<?php } else {

							echo '<h5 class="text-center"> '.lang('no_data_to_show').' </h5>';
						} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	$(document).ready(function() {
		$('.dataTable').dataTable();
	});
</script>