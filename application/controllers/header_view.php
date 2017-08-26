<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">

        <title>Front end-assignment</title>

        <!--bootstrap-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!--style-->
        <link rel="stylesheet" href="<?= base_url() . 'assets/css/general.css' ?>"/>
        <link rel="stylesheet" type="text/css" href="localhost/mb/public/assets/css/fonts/fonts.css" />

        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="<?= base_url('assets/js/frontend-assignment.min.js'); ?>"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('.menu_title_top').click(function () {
                    $(this).find('.submenu').toggleClass('active_sub');
                });
            });
        </script>
    </head>
    <body>
        <header>
            <div class="container-fluid special_width">
                <?php
                $message = $this->session->flashdata('message');
                $error = $this->session->flashdata('error');
                $validation_errors = validation_errors();

                if (!empty($message)) {
                    ?>
                    <section id="main-content">
                        <section class="wrapper">
                            <div class="">
                                <div class="alert alert-success alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <strong><?php echo $message; ?></strong>
                                </div>
                            </div>
                        </section>
                    </section>
                <?php } ?>
                <?php if (!empty($error)) { ?>
                    <section id="main-content">
                        <section class="wrapper">
                            <div class="">
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <strong><?= $error; ?></strong>
                                </div>
                            </div>
                        </section>
                    </section>
                <?php } ?>
                <?php if (!empty($validation_errors)) { ?>
                    <section id="main-content">
                        <section class="wrapper">
                            <div class="row">
                                <div class="">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h3><?php echo validation_errors(); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </section>
                <?php } ?>

                <div class="header_inner">
                    <div class="row">
                        <div class="row-same-height row-full-height">
                            <div class="col-md-12">
                                <div class="col-md-2 col-xs-height col-full-height">
                                    <a href="<?= base_url('dashboard') ?>">
                                        <img class="img-responsive" src="<?= base_url('assets/images/logos/message-bird-logo.svg') ?>" alt="message-bird-logo"/>  
                                    </a>
                                </div>
                                <div class="col-md-10 col-xs-height col-full-height">
                                    <div class="header_right_side">
                                        <div class="header_right_side_left">
                                            <div class="good_day_user"> 
                                                <span>Good day there!</span>
                                            </div>
                                        </div>
                                        <div class="header_right_side_right">
                                            <div class="header_right_side_right_inner">
                                                <div class="messagebird_setup_guide"> 
                                                    <div class="setup_guide">
                                                        <span> SETUP GUIDE</span>
                                                    </div>
                                                </div>
                                                <div class="messagebird_user_account">
                                                    <span class="user_avatar_image">
                                                        <img class="img-responsive" src="<?= base_url() . 'assets/images/design/default_user.png' ?>" alt="message-bird-user"/>
                                                    </span>
                                                    <span class="user_account_info hidden-xs">
                                                        aim.kelaidi@gmail.com
                                                    </span>
                                                </div>
                                                <a href="<?= base_url('login/logout') ?>">Logout</a>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--end header-->

        <div class="container-fluid special_width clearfix">
            <aside class="sidebar col-md-2 clearfix">
                <div class="col-md-12 no-padding">
                    <nav class="main_menu_left">
                        <ul>
                            <li class="dashboard active menu_title_top">
                                <div class="menu_title">
                                    <i class="fa fa-tachometer" aria-hidden="true"></i>
                                    <a href="<?= base_url('dashboard') ?>">
                                        <span>Dashboard</span>
                                    </a>
                                </div>
                            </li>
                            <li class="sms menu_title_top">
                                <div class="menu_title">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    <span>SMS</span>
                                    <ul class="submenu">
                                        <li class="submenu_item">
                                            <a href="<?= base_url('message/send') ?>">
                                                <div class="submenu_item_title">
                                                    <span>Quick Send</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="submenu_item">
                                            <div class="submenu_item_title">
                                                <span>SMS Overview</span>
                                            </div>
                                        </li>                                                        
                                    </ul>
                                </div>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
            <div class="col-md-10 no-padding">

