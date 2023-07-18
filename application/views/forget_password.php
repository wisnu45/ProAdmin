<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <title>Sign In | Igniter Admin</title>
      <!-- Favicon-->
      <link rel="icon" href="<?php echo iaBase(); ?>assets/images/favicon.ico" type="image/x-icon">

      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

      <!-- Bootstrap Core Css -->
      <link href="<?php echo iaBase(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

      <!-- Waves Effect Css -->
      <link href="<?php echo iaBase(); ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />

      <!-- Animation Css -->
      <link href="<?php echo iaBase(); ?>assets/plugins/animate-css/animate.min.css" rel="stylesheet" />

      <!-- Custom Css -->
      <link href="<?php echo iaBase(); ?>assets/css/style.css" rel="stylesheet">
  </head>
<?php
$this->load->helper('cookie');
$cookie = get_cookie('theme_color');
if ((!isset($cookie)) || (isset($cookie) && empty($cookie))) {$cookie = 'theme-blue';}
?>
  <body class="hold-transition fp-page <?php echo $cookie; ?>1" style="background-color: <?php
               if($cookie == 'theme-blue') {
                echo '#2196F3';
               } elseif($cookie == 'theme-red') {
                echo '#F44336';
               } elseif($cookie == 'theme-pink') {
                echo '#E91E63';
               } elseif($cookie == 'theme-purple') {
                echo '#9C27B0';
               } elseif($cookie == 'theme-deep-purple') {
                echo '#673AB7';
               } elseif($cookie == 'theme-indigo') {
                echo '#3F51B5';
               } elseif($cookie == 'theme-light-blue') {
                echo '#03A9F4';
               } elseif($cookie == 'theme-cyan') {
                echo '#00BCD4';
               } elseif($cookie == 'theme-teal') {
                echo '#009688';
               } elseif($cookie == 'theme-green') {
                echo '#4CAF50';
               } elseif($cookie == 'theme-light-green') {
                echo '#8BC34A';
               } elseif($cookie == 'theme-lime') {
                echo '#CDDC39';
               } elseif($cookie == 'theme-yellow') {
                echo '#FFEB3B';
               } elseif($cookie == 'theme-amber') {
                echo '#FFC107';
               } elseif($cookie == 'theme-orange') {
                echo '#FF9800';
               } elseif($cookie == 'theme-deep-orange') {
                echo '#FF5722';
               } elseif($cookie == 'theme-brown') {
                echo '#795548';
               } elseif ($cookie == 'theme-grey') {
                echo "#9E9E9E";
               } elseif ($cookie == 'theme-blue-grey') {
                echo "#607D8B";
               } else {
                echo "#000";
               }
              ?>">
    <div class="fp-box">
      <div class="logo ia-front-logo">
                    <?php
$logo = getSetting('logo');
if ($logo != '') {
    ?>
        <img src="<?php echo iaBase() . 'assets/images/' . $logo; ?>" id="logo">
<?php } else {?>
        <h2>
          <strong>  <?php echo getSetting('website'); ?> </strong>
        </h2>
<?php }?>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="body">
          <p class="login-box-msg"><?php echo lang('forget_pass_msg'); ?>.</p>
          <?php if ($this->session->flashdata('forgotpassword')): ?>
            <div class="callout callout-success">
              <h5 style='color:red;' class="fa fa-close">  <?php echo $this->session->flashdata('forgotpassword'); ?></h5>
            </div>
          <?php endif?>
          <form action="<?php echo base_url() . 'user/forgetpassword' ?>" method="post">

            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">email</i>
              </span>
              <div class="form-line">
                <input type="email" name="email" class="form-control" placeholder="<?php echo lang('email'); ?>" data-validation="email" />
              </div>
            </div>

            <div class="row">
              <!-- /.col -->
              <div class="col-xs-12">
                <button type="submit" style="width: 100%" class="btn btn-primary btn-lg bg-grey waves-effect"><?php echo lang('get_new_password'); ?></button>
              </div>
              <div class="text-center">
                <span class="glyph-icon-back glyphicon glyphicon-circle-arrow-left" style="cursor:pointer" onclick="window.history.back()" title="Back"></span>
              </div>
              <!-- /.col -->
            </div>
          </form>
          <div class="social-auth-links text-center">
          </div>
          <!-- /.social-auth-links -->
        </div>
      </div>
      <!-- /.login-box-body -->
    </div>
  <!-- /.login-box -->
  <!-- Jquery Core Js -->
  <script src="<?php echo iaBase(); ?>assets/plugins/jquery/jquery.min.js"></script>

  <!-- Bootstrap Core Js -->
  <script src="<?php echo iaBase(); ?>assets/plugins/bootstrap/js/bootstrap.js"></script>

  <!-- Waves Effect Plugin Js -->
  <script src="<?php echo iaBase(); ?>assets/plugins/node-waves/waves.js"></script>

  <!-- Validation Plugin Js -->
  <script src="<?php echo iaBase(); ?>assets/plugins/jquery-validation/jquery.validate.js"></script>

  <!-- Custom Js -->
  <script src="<?php echo iaBase(); ?>assets/js/admin.js"></script>
  <script src="<?php echo iaBase(); ?>assets/js/pages/examples/sign-in.js"></script>
  </body>
</html>
