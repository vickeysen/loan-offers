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
        <!-- About us -->
        <section>
            <div class="container">
                <?php echo form_open('/personal-loan/primary-bank/process'); ?>
                <div class="row m-b-60">
                    <div class="col-12">
                        <h1 class="text-center">Choose Anual Income</h1>
                        <p class="lead text-center">Nulla varius consequat magna, id molestie ipsum volutpat quis. A true story, that never been told!. Fusce id mi diam, non ornare. Fusce id mi diam, non ornare orci. Pellentesque ipsum erat, facilisis ut venenatis eu.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <label class="btn btn-dark btn-outline btn-roundeded w-100 d-flex">
                            <img src="/images/bank-logos/sbi.png" width="50px"/>
                            Sate bank of india
                            <input type="radio" value="Sate bank of india" name="primaryBank"/>
                        </label>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="btn btn-dark btn-outline btn-roundeded w-100">
                            <img src="/images/bank-logos/yes-bank.jpg" width="50px"/>
                            Yes bank
                            <input type="radio" value="Yes bank" name="primaryBank"/>
                        </label>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="btn btn-dark btn-outline btn-roundeded w-100">
                            <img src="/images/bank-logos/union-bank.png" width="50px"/>
                            Union bank
                            <input type="radio" value="Union bank" name="primaryBank"/>
                        </label>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="btn btn-dark btn-outline btn-roundeded w-100">
                            <img src="/images/bank-logos/federal-bank.jpg" width="50px"/>
                            Fedral bank
                            <input type="radio" value="Fedral bank" name="primaryBank"/>
                        </label>
                    </div>
                    <div class="col-12">
                        <?php if (session()->has('errors')) : ?>
                            <div class="alert alert-danger">
                                <?php foreach (session('errors') as $error) : ?>\
                                    <p><?= $error ?></p>
                                    <?php endforeach ?>
                                </div>
                                <?php endif ?>
                                <?= $mobile ?>
                        <button type="submit" class="btn m-t-30 mt-3">Proceed</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </section>
    </div>
    <script src="js/jquery.js"></script>
</body>
</html>