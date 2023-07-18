    <?php if(isset($posts) && is_array($posts) && !empty($posts)) { ?>
    <?php foreach ($posts as $postkey => $postvalue) {  //print_r($postvalue);
      $obj->setReadPost($postvalue->id);
    ?>

      <div class="body mka-post-div">
        <div class="row">
          <div class="col-md-1 mka-padding-0">
            <img src="<?php echo iaBase().'assets/images/'.$postvalue->profile_pic; ?>" alt="User Image" class="img-circle img-responsive mka-img-sm">   
          </div>
          <div class="col-md-10">
            <p><span> <strong> <?php echo ucfirst($postvalue->user_name); ?> </strong> </span></p>
            <p>  <span class="comm-time"><i class="material-icons">access_time</i><?php echo date('d.m.Y H:i:s', strtotime($postvalue->created_at)); ?> <i class="material-icons">visibility</i> <strong>visible by:</strong> <?=  $postvalue->user_type != '' ? $postvalue->user_type: lang('all'); ?> </span> </p>
          </div>
          <?php if($postvalue->created_by === $u_data[0]->ia_users_id) { ?>
          <div class="col-md-1">
            <ul class="header-dropdown m-r--5 pull-right">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                        <i class="material-icons">more_vert</i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="javascript:void(0);" class="waves-effect waves-block delete-post" rel="<?php echo $postvalue->id; ?>">Delete</a></li>
                    </ul>
                </li>
            </ul>
          </div>
          <?php } ?>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p><?php echo $postvalue->description; ?></p>
          </div>
        </div>
        <div class="row">
        <?php 
        $img = json_decode($postvalue->files); 
        if(is_array($img) && !empty($img)) {
          foreach ($img as $imgkey => $imgvalue) {
        ?>
          <div class="col-md-3">
            <img src="<?php echo iaBase().'assets/images/'.$imgvalue ?>" class="img-responsive mka_image_preview " alt="Post Image">
          </div>
        <?php } } ?>
        </div>
        <div class="row btn-row">
          <div class="col-md-12">
            <button class="btn btn-default rply-btn"><i class="material-icons">reply</i> Reply</button>
            <?php 
              $comm_count = $obj->commentCount($postvalue->id); 
              if($comm_count > 0) {
            ?>
            <span class="v-rply" rel="<?php echo $postvalue->id; ?>"> <i class="material-icons">insert_comment</i> View <span class="mka-count"><?php echo $comm_count; ?></span> Reply</span>
            <?php } ?>
          </div>
        </div>
        <div class="commenet-row blind">
          <div class="row show-comm">
            <div class="col-md-12">
              <ul class="list-group">
                  <!-- <li class="list-group-item">Cras justo odio</li> -->
              </ul>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-1 mka-padding-0">
                <img src="<?php echo iaBase().'assets/images/'.$u_data[0]->profile_pic; ?>" class="img-responsive img-circle mka-img-sm" alt="User Image">
              </div>
              <div class="col-md-11">
                <div class="form-group">
                  <div class="form-line">
                    <textarea name="comm_rply"  rows="2" class="form-control" placeholder="Write your comment here.."></textarea>
                    <input type="hidden" name="post_id" value="<?php echo $postvalue->id; ?>">
                  </div>
                </div>
                <button class="btn btn-primary pull-right comment-rply-btn"><i class="material-icons">reply</i> Reply Post</button>
              </div>
            </div>
          </div>
        </div>

      </div>

    <?php } ?>
    <?php } ?>
<script>
  $.AdminBSB.input.activate();
</script>