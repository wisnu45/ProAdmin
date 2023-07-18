
<section class="content">
  <div class="container-fluid">
    <div class="block-header">
      <h2><?php echo lang('timeline'); ?></h2>
    </div>
    <?php if(CheckPermission("timeline", "own_create")){ ?>
    <div class="card">
      <div class="body">
        <!-- Post row start here -->
        <?php //print_r($u_data); ?>
          <div class="row">
            <div class="col-md-1">
              <img src="<?php echo iaBase().'assets/images/'.$u_data[0]->profile_pic; ?>" class="img-circle img-responsive mka-img-sm" alt="Profile Image">
            </div>                
            <div class="col-md-11">
              <form action="" method="post" id="post_form" enctype="multipart/form-data">
                <div class="form-group form-float">
                  <div class="form-line">
                    <textarea name="post" required id="" cols="30" rows="4" class="form-control" placeholder="What is in your mind."></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary pull-right">Save Post</button>
                  <select name="share_with" class="pull-right" id="">
                    <option value="0"><?php echo lang('all'); ?></option>
                    <?php 
                    if(is_array($u_type) && !empty($u_type)) {
                      foreach ($u_type as $key => $value) {
                        echo '<option value="'.$value->id.'">'.$value->user_type.'</option>';
                      }
                    }
                    ?>
                  </select>
                  <input type="file" name="post_files[]" multiple="true">
                </div>
              </form>
            </div>
          </div>
        <!-- Post row end here -->

        

      </div>
    </div>
    <?php } ?>
        <!--==============================================
        =            Comments Start form here            =
        ===============================================-->
      <?php $this->load->view('posts'); ?>
  </div>
</section>
