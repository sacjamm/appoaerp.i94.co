<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?? 'Admin Panel' ?></title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css');?>">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="<?= base_url('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css');?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css');?>">
    </head>
    <body class="hold-transition register-page">
       
        <!-- /.login-box -->
        <?=$this->renderSection('content');?>
        <!-- jQuery -->
        <script src="<?= base_url('adminlte/plugins/jquery/jquery.min.js');?>"></script>
        <!-- Bootstrap 4 -->
        <script src="<?= base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
        <!-- AdminLTE App -->
        <script src="<?= base_url('adminlte/dist/js/adminlte.min.js');?>"></script>
    </body>
</html>
