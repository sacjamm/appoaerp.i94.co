<?= $this->extend(TEMPLATE.'/layouts/auth_register'); ?>
<?php echo $this->section('content'); ?> 
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="/" class="h1"><b>APPOA</b>ERP</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Cadastre-se</p>

      <form action="<?php echo base_url(); ?>auth/register" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nome completo" required>  
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span> 
            </div> 
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="E-mail" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Senha" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Re-digite a senha" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="agreeTerms" value="agree" required>
              <label for="agreeTerms" style="font-size:12px;font-weight: 400;">
               Li e aceito os <a href="#">termos</a> do site
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

<!--      <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>-->

      <a href="<?= base_url('/auth/login'); ?>" class="text-center">Login</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<?= $this->endSection() ?>