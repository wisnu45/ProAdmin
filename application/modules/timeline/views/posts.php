<style>
  span.comm-time {
    position: relative;
    top: -7px;
    background-color: #00b393;
    padding: 5px 11px 4px 10px;
    color: #fff;
    border-radius: 13px;
    font-size: smaller;
  }
  .row.btn-row {
    margin-bottom: -20px;
  }

  span.v-rply {
    padding: 5px 14px 5px 11px;
    border-radius: 47px;
    cursor: pointer;
    margin-left: 5px;
    border: 1px solid #ece5e5;
    box-shadow: #bfbdbd -1px 2px 4px 0px;
  }

  span.v-rply i {
    position: relative;
    top: 4px;
    font-size: medium;
  }

  li.list-group-item.mka-active {
    background-color: aliceblue;
  }

  .card.mka-card {
    border-radius: 50px;
    padding: 16px;
    text-align: center;
    background-color: rgb(95, 184, 247);
    color: aliceblue;
    font-size: larger;
    cursor: pointer;
  }

  .card.mka-card:hover{
    background-color: rgb(46, 153, 228);
  }

  span.comm-time i.material-icons {
    position: relative;
    top: 2px;
    font-size: 16px;
    font-weight: 500;
    color: #676564;
    margin-right: 6px;
  }

  .timeline-body .mka-padding-0{
    padding: 0;
  }

  .body.mka-post-div {
    border: 1px solid #ececec;
  }

  .body.mka-post-div:hover {
    background: red ;
  }
  .body.mka-post-div:hover {
    background: rgba(245, 245, 245, 0.47);
  }
  img.mka-img-sm {
    width: 45px;
  }
</style>


    <div class="post-main-div card"></div>

    <div class="row load-more-btn blind">
      <div class="col-md-6 col-md-offset-3">
        <div class="card mka-card" data-offset="0" data-limit="0"> 
          <div class="col-md-12">
            Load more posts
          </div>
        </div>
      </div>
    </div>


<script>
  $(document).ready(function() {
  
    $('body').on('click', '.rply-btn', function() {
      $(this).parents('.btn-row').first().siblings('.commenet-row').slideToggle();
    });

    $('body').on('click', '.comment-rply-btn', function() {
      $o = $(this);
      $comm = $o.siblings('.form-group').first().find('textarea[name="comm_rply"]').val();
      $post_id = $o.siblings('.form-group').first().find('input[name="post_id"]').val();
      if($comm == '') {
        alert('Write somthing in comment section');
      } else {
        $.ajax({
          url: $('body').attr('data-base-url') + 'timeline/comment',
          type: 'POST',
          data: {
            comment: $comm,
            post_id: $post_id
          }
        }).done(function(mka) {
          console.log(mka);
          if(mka) {
            $o.siblings('.form-group').first().find('textarea[name="comm_rply"]').val('');
            $t = $o.parents('.commenet-row').first().siblings('.btn-row').find('span.v-rply');
            if($t.length <= 0) {
              $o.parents('.commenet-row').first().siblings('.btn-row').find('.rply-btn').after('<span class="v-rply" rel="'+$post_id+'"> <i class="material-icons">insert_comment</i> View <span class="mka-count">1</span> Reply</span>');
              $o.parents('.commenet-row').first().siblings('.btn-row').find('span.v-rply').trigger('click');
            } else {
              $t.trigger('click');
              $old_count = $t.find('span.mka-count').text();
              $t.find('span.mka-count').text(parseInt($old_count) + 1);
            }
          }
        });
        
      }
    });


    $('body').on('click', '.v-rply', function() {
      $o = $(this);
      $post_id = $o.attr('rel');
      $m = getComments($post_id);
      $m.done(function(mka) {
        console.log(mka);
        if(mka) {
          $o.parents('.btn-row').first().siblings('.commenet-row').find('ul.list-group').html(mka);
          if(!$o.parents('.btn-row').first().siblings('.commenet-row').is(':visible')) {
            $o.parents('.btn-row').first().siblings('.commenet-row').slideDown();
          }
        } 
        console.log(mka);
      });
      
    });

    $('body').on('click', '.delete-post', function() {
      $o = $(this);
      $post_id = $o.attr('rel');
      if($post_id != '') {
        $.post($('body').attr('data-base-url') + 'timeline/deletepost', {post_id: $post_id}, function(mka) {
          if(mka == 1) {
            $o.parents('.card').first().fadeOut('slow');
            showNotification('Post removed.', 'success');
          }
        });
      }
    });

    getPosts(0, 4);


    chkLoadMoreBtn();

    $('.mka-card').on('click', function() {
      $o = $(this);
      getPosts($o.attr('data-offset'), $o.attr('data-limit'));
    });
    
  });


  var getComments = function(post) {
    return $.ajax({
      url: $('body').attr('data-base-url') + 'timeline/getComments',
      type: 'POST',
      data: { post_id: $post_id },
    });
  }

  var getPosts = function(offset, limit) {
    $.ajax({
      url: $('body').attr('data-base-url') + 'timeline/getPosts',
      type: 'POST',
      data: {
        offset: offset,
        limit : limit
      },
    }).done(function(mka) {
      if(mka != '') {
        $('.post-main-div').append(mka);
        chkLoadMoreBtn();
      }
    });
    
  }

  var chkLoadMoreBtn = function() {
    $.post($('body').attr('data-base-url') + 'timeline/checkPostCount', function(data) {
      $('.load-more-btn').hide();
      if($('.mka-post-div').length < data) {
        $('.load-more-btn').show();
        $('.load-more-btn').find('.mka-card').attr('data-offset', $('.mka-post-div').length);
        $('.load-more-btn').find('.mka-card').attr('data-limit', 2);
      } 
    });
  }
</script>