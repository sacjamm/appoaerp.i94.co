<?= $this->extend(TEMPLATE . '/layouts/app'); ?>
<?php echo $this->section('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Centro de custo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right"> 
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('centrodecustos'); ?>">Centro de custos</a></li>
                        <li class="breadcrumb-item active">Editar centro de custo</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <span class="icon">
                                    <i class="fas fa-university"></i>
                                </span> 
                                Editar centro de custo</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="<?php echo base_url(); ?>centrodecustos/edit/<?=$id;?>" id="formCentro" method="post">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="row">
                                        <div class="col-md-12">
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

                                                <?php if (session()->has('error')): ?>
                                                    <div class="alert alert-danger">
                                                        <?= session()->get('error') ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="widget-box">
                                                <div class="widget-content">
                                                                                                     
                                                    <div class="row">
                                                       <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="NomeCentroCusto">Descrição</label>
                                                                <input name="NomeCentroCusto" value="<?=$centro['NomeCentroCusto'];?>" type="text" id="NomeCentroCusto" class="form-control" placeholder="Descrição do centro de custo" /> 
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>                             
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="button btn btn-success">
                                    <span class="button__icon">
                                        <i class='fas fa-save'></i>
                                    </span>
                                    <span class="button__text2">Salvar</span></button>
                                <a title="Voltar" class="button btn btn-mini btn-warning float-right" href="<?php echo site_url() ?>bancos">
                                    <span class="button__icon">
                                        <i class="fas fa-undo-alt"></i>
                                    </span> 
                                    <span class="button__text2">Cancelar</span></a>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript" src="<?php echo base_url('adminlte') ?>js/validate.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
                
    });
</script>
<?php echo $this->endSection(); ?>
