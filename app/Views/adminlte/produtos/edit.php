<?= $this->extend(TEMPLATE . '/layouts/app'); ?>
<?php echo $this->section('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Produto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right"> 
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('produtos'); ?>">Produtos</a></li>
                        <li class="breadcrumb-item active">Editar produto</li>
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
                                    <i class="fas fa-plus"></i>
                                </span> 
                                Editar produtos</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="<?php echo base_url(); ?>produtos/edit/<?=$id;?>" id="formProduto" method="post">
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
                                                                <label for="DescricaoProduto">Descrição</label>
                                                                <input name="DescricaoProduto" value="<?=$produto['DescricaoProduto'];?>" type="text" id="DescricaoProduto" class="form-control" placeholder="Descrição do produtos" required />
                                                            </div>
                                                        </div>
                                                    </div>                                               
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="CodigoProdutoGrupo">Grupo</label>
                                                                <select name="CodigoProdutoGrupo" id="CodigoProdutoGrupo" class="form-control" required>
                                                                    <?php
                                                                    if ($grupos) {
                                                                        foreach ($grupos as $group) {
                                                                            ?>
                                                                            <option value="<?= $group['CodigoProdutoGrupo']; ?>" 
                                                                                <?php if(isset($produto['CodigoProdutoGrupo']) && 
                                                                                        $produto['CodigoProdutoGrupo'] === $group['CodigoProdutoGrupo']){ echo 'selected ';}?>><?= $group['NomeProdutoGrupo']; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="UnidadeProduto">Unidade</label>
                                                                <input name="UnidadeProduto" value="<?=$produto['UnidadeProduto'];?>" type="text" id="UnidadeProduto" class="form-control" placeholder="Unidade do produto" />
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
                                <a title="Voltar" class="button btn btn-mini btn-warning float-right" href="<?php echo site_url() ?>produtos"> 
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
