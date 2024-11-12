<?= $this->extend(TEMPLATE . '/layouts/auth'); ?>
<?php echo $this->section('content'); ?> 
<div class="login-box">  
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="/" class="h1"><b>APPOA</b>ERP</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Área restrita</p>
            
            <div id="message">
                <!-- Flash messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success'); ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->has('message')): ?>
                    <div class="alert alert-success">
                        <?= session()->get('message') ?>
                    </div>
                <?php endif; ?>

            </div>
            <form action="<?php echo base_url(); ?>auth/login" method="post">

                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="Usuario" placeholder="Usuario" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="SenhaUsuario" placeholder="Senha" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Mantenha-me conectado
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Acessar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <!--            <div class="social-auth-links text-center mt-2 mb-3">
                            <a href="#" class="btn btn-block btn-primary">
                                <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                            </a>
                            <a href="#" class="btn btn-block btn-danger">
                                <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                            </a>
                        </div>-->
            <!-- /.social-auth-links -->

            <p class="mb-1">
                <a href="<?= base_url('auth/forgot'); ?>">Esqueci a senha</a>
            </p>
            <p class="mb-0">
                <a href="<?= base_url('auth/register'); ?>" class="text-center">Cadastre-se</a>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<?= $this->endSection() ?>