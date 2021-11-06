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
        <title><?= $title ?></title>

        <link rel="icon" type="image/png" href="<?= site_url('assets/images/bmtc.png') ?>"/>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
        <link href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/plugins/font-awesome/css/all.min.css') ?>" rel="stylesheet">

      
        <!-- Theme Styles -->
        <link href="<?= base_url('assets/css/connect.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/dark_theme.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/plugins/DataTables/datatables.min.css') ?>" rel="stylesheet">

        <script src="<?= base_url('assets/plugins/jquery/jquery-3.4.1.min.js') ?>"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="connect-container align-content-stretch d-flex flex-wrap">
            <div class="page-sidebar">
                <div class="logo-box">
                    <a href="<?= site_url('dashboard') ?>" class="logo-text">BMTC</a>
                    <a href="#" id="sidebar-close"><i class="material-icons">close</i></a> 
                    <a href="#" id="sidebar-state"><i class="material-icons">adjust</i>
                    <i class="material-icons compact-sidebar-icon">panorama_fish_eye</i></a>
                </div>
                <div class="page-sidebar-inner slimscroll">
                    <ul class="accordion-menu">
                        <li class="sidebar-title">
                            Menu
                        </li>
                        <li <?= $navActive == 'dashboard' ? 'class="active-page"' : ''?>>
                            <a href="<?= site_url('dashboard') ?>"><i class="material-icons-outlined">dashboard</i>Dashboard</a>
                        </li>
                        <li <?= $navActive == 'user' ? 'class="active-page"' : ''?>>
                            <a href="<?= site_url('user') ?>"><i class="material-icons-outlined">account_circle</i>User</a>
                        </li>
                        <li <?php if($navActive == 'ongoing-report' || $navActive == 'finished-report' || $navActive == 'canceled-report' || $navActive == 'detail-report') echo 'class="active-page"'?>>
                            <a href=""><i class="material-icons-outlined">summarize</i>Report<i class="material-icons has-sub-menu">add</i></a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="<?= site_url('report') ?>" <?= $navActive == 'ongoing-report' ? 'class="active"' : ''?>>Ongoing Report</a>
                                </li>
                                <li>
                                    <a href="<?= site_url('finished-report') ?>" <?= $navActive == 'finished-report' ? 'class="active"' : ''?>>Finished Report</a>
                                </li>
                                <li>
                                    <a href="<?= site_url('canceled-report') ?>" <?= $navActive == 'canceled-report' ? 'class="active"' : ''?>>Canceled Report</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="page-container">
                <div class="page-header">
                    <nav class="navbar navbar-expand">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <ul class="navbar-nav">
                            <li class="nav-item small-screens-sidebar-link">
                                <a href="#" class="nav-link"><i class="material-icons-outlined">menu</i></a>
                            </li>
                            <li class="nav-item nav-profile dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?= base_url('assets/images/avatars/profile-image-1.png') ?>" alt="profile image">
                                    <span><?= strtok($this->session->userdata('name'), " ") ?></span><i class="material-icons dropdown-icon">keyboard_arrow_down</i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a href="#" class="dropdown-item"><?= $this->session->userdata('name') ?></a>
                                    <a href="#" class="dropdown-item"><?= $this->session->userdata('email') ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= site_url('logout') ?>">Log out</a>
                                </div>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="#" class="nav-link" id="dark-theme-toggle"><i class="material-icons-outlined">brightness_2</i><i class="material-icons">brightness_2</i></a>
                            </li> -->
                        </ul>
                    </nav>
                </div>
                <div class="page-content">
                    <!-- <div class="page-info">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Apps</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </nav>
                    </div> -->