<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Responsive Admin Dashboard Template">
        <meta name="keywords" content="admin,dashboard">
        <meta name="author" content="stacks">
        <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <!-- Title -->
        <title>Survey Gigi</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
        <link href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/plugins/font-awesome/css/all.min.css') ?>" rel="stylesheet">

      
        <!-- Theme Styles -->
        <link href="<?= base_url('assets/css/connect.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/dark_theme.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="auth-page sign-in">
        <div class="connect-container align-content-stretch d-flex flex-wrap">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="auth-form">
                            <div class="row">
                                <div class="col">
                                    <div class="logo-box"><a href="<?= site_url()?>" class="logo-text">Survey Gigi</a></div>
                                    <form action="<?= site_url('login')?>" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block btn-submit">Sign In</button>
                                    </form>
                                    <br>
                                    <?php 
                                        if ($this->session->tempdata('auth_msg')) {
                                    ?>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <?= $this->session->tempdata('auth_msg') ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php
                                        }
                                     ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block d-xl-block">
                        <div class="auth-image"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Javascripts -->
        <script src="<?= base_url('assets/plugins/jquery/jquery-3.4.1.min.js') ?>"></script>
        <script src="<?= base_url('assets/plugins/bootstrap/popper.min.js') ?>"></script>
        <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/connect.min.js') ?>"></script>
    </body>
</html>