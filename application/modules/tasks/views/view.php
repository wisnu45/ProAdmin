<!-- start: PAGE CONTENT -->
    <section class="content">
		<div class="container-fluid">
		<!-- Main content -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
						<div class="header">
                           <h2><?php echo lang('ticket') ?>: #<?php echo $ticket_details[0]->ticket_id.' -'. $ticket_details[0]->ticket_ticket_title ?></h2>
                              <ul class="header-dropdown">
                                 <?php if( $this->session->get_userdata()['user_details'][0]->user_type == 'admin' ) {
                                    $btnt = lang('open_ticket');
                                    $cl = 'add';
                                    $chnageto = 'Open';
                                    if($ticket_details[0]->ticket_status == 'Open' || $ticket_details[0]->ticket_status == 'Ongoing') { 
                                        $btnt = lang('close_ticket');
                                        $cl = 'close';
                                        $chnageto = 'Close';
                                    } 
                                ?>

                                
                                 <button type="button" class="btn-sm  btn btn-primary waves-effect close-ticket" data-change-to="<?php echo $chnageto; ?>" rel="<?php echo $ticket_details[0]->ticket_id; ?>"><i class="material-icons"><?php echo $cl; ?></i><?php echo $btnt; ?></button>
                              <?php } ?>
                              </ul>
                            </div>
                 	 <!-- /.box-header -->
                 	 		<div class="body">
                                <div class="info-section row">
                                    <div class="col-md-8">
                                        <strong><?php echo lang('status'); ?> : </strong><?php echo $ticket_details[0]->ticket_status; ?>
                                        <strong><?php echo lang('created'); ?> : </strong><?php echo date('d.m.Y H:i:s', strtotime($ticket_details[0]->created)); ?>
                                        <strong><?php echo lang('par'); ?> : </strong> <?php echo $ctr_object->getusetnamebyid($ticket_details[0]->user_id);  ?>
                                        <strong><?php echo lang('ticket_type'); ?> : </strong><?php echo $ticket_details[0]->ticket_ticket_type; ?>
                                    </div>
                                    <?php if($ticket_details[0]->ticket_status == 'Close') { ?>
                                    <div class="col-md-4">
                                        <strong><?php echo lang('closed_by'); ?> : </strong><?php echo $ctr_object->getusetnamebyid($ticket_details[0]->close_by); ?>
                                        <strong><?php echo lang('closed_date'); ?> : </strong><?php echo $ticket_details[0]->close_date; ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <hr>
                                <div class="info-section row">
                                    <?php $usr_info = $ctr_object->getUserDetails($ticket_details[0]->user_id); ?>
                                <?php //print_r($ticket_details); ?>
                                    <div class="col-md-1">
                                        <img src="<?php echo iaBase().'assets/images/'.$usr_info[0]->profile_pic; ?>" class="img-circle" alt="Image" width="70">        
                                    </div>
                                    <div class="col-md-10">
                                        <p><strong> <?php echo $usr_info[0]->name; ?> </strong> <?php echo $ticket_details[0]->created; ?></p>
                                        <p>
                                            <?php echo $ticket_details[0]->ticket_description; ?>
                                        </p>
                                        <?php if(isset($ticket_details[0]->ticket_upload_document) && $ticket_details[0]->ticket_upload_document != ''){ 
                                            $files = explode(',', $ticket_details[0]->ticket_upload_document);
                                            foreach ($files as $fkey => $fvalue) {
                                                $fvalue = strtolower(str_replace(' ', '_', $fvalue));
                                                echo '<p><img width="300" src="'.iaBase().'assets/images/'.$fvalue.'" alt="Image"><br>
                                                <a href="'.iaBase().'assets/images/'.$fvalue.'" download>'.lang('download').'</a></p>';
                                            }
                                        ?>

                                        <?php } ?>
                                    </div>
                                </div>
                 	 			<?php   foreach ($comments as $key => $value) {
                 	 				$usr = $ctr_object->getUserDetails($value->created_by);
                 	 				//print_r($usr);
                 	 			?>
                 	 			<hr>
	                 	 			<div class="comment row">
	                 	 				<div class="col-md-1">
	                 	 					<img src="<?php echo iaBase().'assets/images/'.$usr[0]->profile_pic; ?>" class="img-circle" alt="Image" width="70">		
	                 	 				</div>
	                 	 				<div class="col-md-10">
	                 	 					<p><strong> <?php echo $usr[0]->name; ?> </strong> <?php echo $value->created_at; ?></p>
	                 	 					<p>
	                 	 						<?php echo $value->description; ?>
	                 	 					</p>
	                 	 					<?php if(isset($value->files) && $value->files != ''){ 
                 	 							$files = json_decode($value->files, true);
                 	 							foreach ($files as $fkey => $fvalue) {
                 	 								echo '<p><img width="300" src="'.iaBase().'assets/images/comment/'.$fvalue.'" alt=""><br>
                 	 								<a href="'.iaBase().'assets/images/comment/'.$fvalue.'" download>Download</a></p>';
                 	 							}
                 	 						?>

                 	 						<?php } ?>
	                 	 				</div>
	                 	 			</div> 	 			
                 	 			<?php } ?>

                 	 			<hr>
	                 	 			<div class="comment row">
	                 	 				<div class="col-md-2">
	                 	 					<?php 
	                 	 					$usr1 = $ctr_object->getUserDetails($this->session->get_userdata()['user_details'][0]->user_id);

	                 	 					?>
	                 	 					<img src="<?php echo iaBase().'assets/images/'.$usr1[0]->profile_pic; ?>" class="img-circle" alt="Cinque Terre" width="110">	
	                 	 				</div>
	                 	 				<div class="col-md-10">
	                 	 					<form action="<?php echo base_url().'ticket/savecomment' ?>" method="post" enctype="multipart/form-data">
		                 	 					<div class="form-group form-float">
		                 	 						<div class="form-line">
		                 	 							<textarea name="comment" class="form-control" id="" rows="5" placeholder="Enter Your Comment"></textarea>
		                 	 						</div>
		                 	 					</div>
		                 	 					<div class="form-group">
		                 	 						<input type="file" class="pull-left" name="comm_files" >
		                 	 						<input type="hidden" name="ticket_id" value="<?php echo $ticket_details[0]->ticket_id; ?>">
		                 	 						<button class="btn btn-primary pull-right"><?php echo lang('post_comment'); ?></button>
		                 	 					</div>
	                 	 					</form>
	                 	 				</div>
	                 	 			</div>
                 	 			<!-- <div id="ticket-comment-dropzone" class="post-dropzone box-content form-group">
                 	 						                        <input type="hidden" name="ticket_id" value="102">
                 	 						                        <textarea name="description" cols="40" rows="10" id="description" class="form-control" placeholder="Write a comment..." data-rule-required="1" data-msg-required="This field is required." aria-required="true"></textarea>
                 	 					                        	<div class="post-file-dropzone-scrollbar hide">
                 	 							    					<div class="post-file-previews clearfix b-t" id="hrjrgwlqavwsphr"> 
                 	 							        
                 	 												    </div>
                 	 									</div>                
                 	 							                    </div> -->
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
<script>
	$(document).ready(function() {
		$('.close-ticket').on('click', function(){
            $o = $(this);
            $o.prop('disabled', true).html('<div class="preloader pl-size-xs">'+
                                    '<div class="spinner-layer pl-red-grey">'+
                                        '<div class="circle-clipper left">'+
                                            '<div class="circle"></div>'+
                                        '</div>'+
                                        '<div class="circle-clipper right">'+
                                            '<div class="circle"></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
			$.post('<?php echo base_url() ?>' + 'ticket/closeticket', {id: $(this).attr('rel'), chnageto: $(this).attr('data-change-to')}, function(data) {
				if(data) {
					window.location.reload();
				}
			});
		});
	});
</script>
<!-- /.content-wrapper -->