<?php
helper('form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="INSPIRO" />
    <meta name="description" content="Themeforest Template Polo, html template">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Document title -->
    <title>POLO | The Multi-Purpose HTML5 Template</title>
    <!-- Stylesheets & Fonts -->
    <link href="/css/plugins.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Body Inner -->
    <div class="body-inner">
        <!-- Section -->
        <section class="pt-5 pb-5" data-bg-image="images/pages/1.jpg">
            <div class="container-fluid d-flex flex-column">
                <div class="row align-items-center min-vh-100">
                    <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                        <div class="card shadow-lg">
                            <div class="card-body py-5 px-sm-5">
                                <h3>Enter your employer name</h3>
                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                                <?php echo form_open('/personal-loan/employer/process'); ?>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="email">Employer Name</label>
                                            <input type="text" class="form-control" name="employer" placeholder="Enter Employer Name" >
                                        </div>
                                    </div>
                                    <?php if (session()->has('errors')) : ?>
                                        <div class="alert alert-danger">
                                            <?php foreach (session('errors') as $error) : ?>
                                                <p><?= $error ?></p>
                                            <?php endforeach ?>
                                        </div>
                                    <?php endif ?>
                                    <button type="submit" class="btn m-t-30 mt-3">Proceed</button>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end: Section -->
    </div>
    <!-- end: Body Inner -->
    <!-- Scroll top -->
    <a id="scrollTop"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a>
    <!--Plugins-->
    <script src="js/jquery.js"></script>
</body>
</html>