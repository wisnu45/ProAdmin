<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php $setting = getSetting();?>
    <title><?php echo (getSetting('website'))?getSetting('website'):'Dasboard';?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo getSetting('favicon')?iaBase().'assets/images/'.getSetting('favicon'):'assets/images/favicon.ico';?>" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo iaBase(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo iaBase(); ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="<?php echo iaBase(); ?>assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Dropzone Css -->
    <link href="<?php echo iaBase(); ?>assets/plugins/dropzone/dropzone.css" rel="stylesheet">

    <!-- Animation Css -->
    <link href="<?php echo iaBase(); ?>assets/plugins/animate-css/animate.min.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo iaBase(); ?>assets/css/style.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="<?php echo iaBase(); ?>assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <!-- Bootstrap Material Datetime Picker Css -->
    <link rel="stylesheet" type="text/css" href="<?php echo iaBase().'assets/css/daterangepicker.css'; ?>" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo iaBase(); ?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <link href="<?php echo iaBase(); ?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Sweet Alert Css -->
    <link href="<?php echo iaBase(); ?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo iaBase(); ?>assets/css/jquery-ui.css">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo iaBase(); ?>assets/css/themes/all-themes.css" rel="stylesheet" />
    <link href="<?php echo iaBase(); ?>assets/css/custom.css" rel="stylesheet" />

    <script src="<?php echo iaBase(); ?>assets/js/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo iaBase(); ?>assets/js/jquery-ui.min.js"></script>
    <script src='<?php echo iaBase(); ?>assets/js/moment.min.js'></script>

<style> ?>
.lagAm .btn-group.bootstrap-select {margin-top: 8%;}
#rightsidebar .slimScrollDiv{height: 540px !important;}
#rightsidebar .slimScrollDiv ul{height: 540px !important;}
.sidebar .menu .list a{width: 83% !important;}
.sidebar .menu .list a.right0{width: 13% !important; right: 0;}
</style>
</head>
<?php 
    $this->load->helper('cookie');
    $cookie= get_cookie('theme_color');
    if((!isset($cookie)) || (isset($cookie) && empty($cookie))){ $cookie = 'theme-blue'; } 
?>
<body class="<?php echo $cookie; ?>" data-base-url="<?php echo base_url(); ?>">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p><?php echo lang('please_wait'); ?>...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons"><?php echo lang("search");?></i>
        </div>
        <input type="text" placeholder="<?php echo lang("StartTyping");?>">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <?php $logo = (getSetting('logo'))?getSetting('logo'):'logo.png'; ?>
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><span class="logo-lg"><img src="<?php echo iaBase().'assets/images/'.$logo; ?>" id="logo"></span></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- #END# Call Search -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar" style="display: none;">
            <!-- Menu -->

            <div class="menu">
                <ul class="list" style="height: 500px;">
                    <li class="active" style="display: none;">
                        <a href="<?php // echo base_url('profile'); ?>">
                        <i class="material-icons">person</i>
                        <span><?php // echo lang("profile"); ?></span></a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
        </aside>
        <!-- #END# Left Sidebar -->

        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="blue" class="<?php if(isset($cookie) && $cookie == 'theme-blue'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="red" class="<?php if(isset($cookie) && $cookie == 'theme-red'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink" class="<?php if(isset($cookie) && $cookie == 'theme-pink'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple" class="<?php if(isset($cookie) && $cookie == 'theme-purple'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple" class="<?php if(isset($cookie) && $cookie == 'theme-deep-purple'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo" class="<?php if(isset($cookie) && $cookie == 'theme-indigo'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="light-blue" class="<?php if(isset($cookie) && $cookie == 'theme-light-blue'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan" class="<?php if(isset($cookie) && $cookie == 'theme-cyan'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal" class="<?php if(isset($cookie) && $cookie == 'theme-teal'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green" class="<?php if(isset($cookie) && $cookie == 'theme-green'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green" class="<?php if(isset($cookie) && $cookie == 'theme-light-green'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime" class="<?php if(isset($cookie) && $cookie == 'theme-lime'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow" class="<?php if(isset($cookie) && $cookie == 'theme-yellow'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber" class="<?php if(isset($cookie) && $cookie == 'theme-amber'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange" class="<?php if(isset($cookie) && $cookie == 'theme-orange'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange" class="<?php if(isset($cookie) && $cookie == 'theme-deep-orange'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown" class="<?php if(isset($cookie) && $cookie == 'theme-brown'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey" class="<?php if(isset($cookie) && $cookie == 'theme-grey'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey" class="<?php if(isset($cookie) && $cookie == 'theme-blue-grey'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black" class="<?php if(isset($cookie) && $cookie == 'theme-black'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>