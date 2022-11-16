<!DOCTYPE html>
<html lang="en" dir="">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>BMS Tecnologia</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo Asset::get_file('iconsmind.css', 'fonts'); ?>">
        <?php echo Asset::css('themes/lite-purple.min.css'); ?>
        <?php echo Asset::css('vendor/perfect-scrollbar.css'); ?>

        <?php isset($extra_css) && print $extra_css; ?>
    </head>

    <body class="text-left">
        <div class="app-admin-wrap layout-sidebar-large clearfix">
            <!-- header -->
            <?php isset($header) && print $header; ?>
            <!-- end header -->

            <!--=============== Left side Start ================-->
            <?php isset($side) && print $side; ?>
            <!--=============== Left side End ================-->

            <!-- ============ Body content start ============= -->
            <div class="main-content-wrap sidenav-open d-flex flex-column">

                <?php if (!empty($content)): ?>
                    <?php echo $content; ?>
                <?php endif; ?>

                <!-- Footer Start -->
                <?php isset($footer) && print $footer; ?>
                <!-- fotter end -->
            </div>
            <!-- ============ Body content End ============= -->
        </div>
        <!--=============== End app-admin-wrap ================-->

        <!-- ============ Search UI Start ============= -->
        <?php isset($search) && print $search; ?>
        <!-- ============ Search UI End ============= -->

        <?php echo Asset::js('vendor/jquery-3.3.1.min.js'); ?>
        <?php echo Asset::js('vendor/bootstrap.bundle.min.js'); ?>
        <?php echo Asset::js('vendor/perfect-scrollbar.min.js'); ?>
        <?php echo Asset::js('es5/script.min.js'); ?>
        <?php echo Asset::js('es5/sidebar.large.script.min.js'); ?>

        <?php isset($extra_js) && print $extra_js; ?>
    </body>
</html>
