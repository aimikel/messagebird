<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">

        <!--bootstrap-->        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!--style-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url() . 'assets/css/general.css' ?>"/>
         <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&subset=greek,latin' rel='stylesheet' type='text/css'>

        <title>Front end-assignment</title>
    </head>
    <body>
        <!--section login with api key-->
        <div class="container-fluid special_width">
            <section class="api_key_wrapper">
                <?php
                $message = $this->session->flashdata('message');
                $error = $this->session->flashdata('error');
                $validation_errors = validation_errors();

                if (!empty($message)) {
                    ?>
                <!--error message if there is any-->
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
                <!--end error message if there is any-->
                <?php } ?>
                <?php if (!empty($error)) { ?>
                <!--error message if there is any-->
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
                <!--end error message if there is any-->
                <?php } ?>
                <?php
                if (!empty($validation_errors)) {
                    ?>
                <!--validation error message if there is any-->
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
                <!--validation error message if there is any-->
                <?php } ?>
                <div class="api_key_wrapper_inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="head_title_main">
                                Welcome!
                            </h1>
                        </div>
                    </div>
                    <?php
                    $attributes = array('class' => 'form_to_send_key', 'id' => 'myform');
                    echo form_open('login', $attributes);
                    ?>
                    <!--form for api key input-->
                    <div class="form_to_send_key_inner">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6">
                                <?php
                                $data = array(
                                    'type' => 'text',
                                    'name' => 'api_key',
                                    'id' => 'api_key',
                                    'class' => 'input_item_indx',
                                    'placeholder' => 'Do you have an API key?',
                                    'required' => 'required'
                                );

                                echo form_input($data);
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-offset-5 col-md-2">
                                <div class="button_wrapper">
                                    <div class="button_wrapper_inner">
                                        <button type="submit" class="submit_btn_key btn-block btn-primary btn" value="START PARTY">
                                            START PARTY
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </section>
        </div>
    </body>
</html>

