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
                                <h3>Enter your redidence</h3>
                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                                <?php echo form_open('/personal-loan/residence/process'); ?>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label for="inputStreet">House No.</label>
                                            <input type="text" class="form-control" name="houseNo" placeholder="Enter house no." required>
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label for="inputStreet">Street</label>
                                            <input type="text" class="form-control" name="street" placeholder="Enter street" required>
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label for="inputStreet">Land mark</label>
                                            <input type="text" class="form-control" name="landMark" placeholder="Enter land mark" required>
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label for="inputStreet">City</label>
                                            <input type="text" class="form-control" name="city" placeholder="Enter city" required>
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label for="inputStreet">State</label>
                                            <input type="text" class="form-control" name="state" placeholder="Enter state" required>
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label for="inputStreet">PIN code</label>
                                            <input type="number" maxlength="6" minlength="6" maxlength="999999" min="100000" step="1" class="form-control" name="pinCode" placeholder="Enter PIN code" required>
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