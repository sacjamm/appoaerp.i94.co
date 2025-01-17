<?= $this->extend(TEMPLATE.'/layouts/auth'); ?>
<?php echo $this->section('content'); ?> 
<div class="login-box"> 
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="/" class="h1"><b>APPOA</b>ERP</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Esqueceu a senha? Preencha o campo abaixo para recuperar a senha.</p>
            
            <form action="<?php echo base_url(); ?>auth/forgot" method="post">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="E-mail" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Solicitar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <p class="mt-3 mb-1">
                <a href="<?=base_url('auth/login');?>">Login</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<?= $this->endSection() ?>