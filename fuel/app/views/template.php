<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email - <?php echo $title; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo Asset::get_file('iconsmind.css', 'fonts'); ?>">
    <?php echo Asset::css('themes/lite-blue.min.css'); ?>
    <?php echo Asset::css('vendor/perfect-scrollbar.css'); ?>
    <link rel="shortcut icon" href="<?php echo Asset::get_file('favicon.png', 'img'); ?>">

    <?php isset($extra_css) && print $extra_css; ?>
</head>

<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large clearfix">
        <!-- header -->
        <?php isset($header) && print $header; ?>
        <!-- end header -->

        <!-- ============ Body content start ============= -->
        <div class="main-content-wrap">
            <!--Mensagens alertas-->
            <?php if (Session::get_flash('success')) : ?>
                <div class="alert alert-card alert-success text-center" role="alert">
                    <?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <?php endif; ?>
            <?php if (Session::get_flash('error')) : ?>
                <div class="alert alert-card alert-danger text-center" role="alert">
                    <?php echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <?php endif; ?>
            <?php if (Session::get_flash('warning')) : ?>
                <div class="alert alert-card alert-warning text-center" role="alert">
                    <?php echo implode('</p><p>', e((array) Session::get_flash('warning'))); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            <?php endif; ?>
            <!--end Mensagens alertas-->

            <?php if (!empty($content)) : ?>
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
    <script>
        var HOST = "<?php echo uri::base(); ?>"
    </script>

    <!-- common js -->
    <?php echo Asset::js('vendor/jquery-3.3.1.min.js'); ?>
    <?php echo Asset::js('vendor/bootstrap.bundle.min.js'); ?>
    <?php echo Asset::js('vendor/perfect-scrollbar.min.js'); ?>
    <?php echo Asset::js('es5/script.min.js'); ?>
    <?php echo Asset::js('es5/sidebar.large.script.min.js'); ?>
    <?php echo Asset::js('jquery.validate.min.js'); ?>

    <!-- plugins -->
    <?php echo Asset::js('plugins/bootstrap-dialog/bootstrap-dialog.js'); ?>

    <!-- global js -->
    <?php echo Asset::js('main.js'); ?>


    <?php isset($extra_js) && print $extra_js; ?>
</body>

</html>