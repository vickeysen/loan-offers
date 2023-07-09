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
                                <h3>Check your eligiblity for personal loan</h3>
                                <p>Please verify your mobile number and just provide a few details to check persional loan offers for you based on your profile.</p>
                                <?php echo form_open('/personal-loan/send-otp'); ?>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="email">Mobile number</label>
                                            <!-- <input type="number" class="form-control" name="mobile" step="1" placeholder="Enter Mobile No." value="<?= $mobile ?>">
                                             -->
                                            <input type="number" class="form-control" name="mobile" step="1" placeholder="Enter Mobile No." value="9352803269">
                                        </div>
                                    </div>
                                    <?php if (session()->has('errors')) : ?>
                                        <div class="alert alert-danger">
                                            <?php foreach (session('errors') as $error) : ?>
                                                <p><?= $error ?></p>
                                            <?php endforeach ?>
                                        </div>
                                    <?php endif ?>
                                    <div class="form-check">
                                        <input type="checkbox" name="terms_conditions" id="terms_conditions" class="form-check-input" value="1" required>
                                        <label class="form-check-label" for="terms_conditions">By checking this option, you agree to acceot with the <a href="#">Terms and Conditions</a>.</label>
                                    </div>
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