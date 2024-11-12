<?= $this->extend(TEMPLATE . '/layouts/app'); ?>
<?php echo $this->section('content'); ?>
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url(TEMPLATE . '/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url(TEMPLATE . '/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Compra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right"> 
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('compras'); ?>">Compras</a></li>
                        <li class="breadcrumb-item active">Editar compra</li>
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
                                    <i class="fas fa-shopping-cart"></i> 
                                </span>  
                                Editar compra</h3>
                            <div class="card-tools">
                                <a href="<?=base_url('compras/produtos/'.$id);?>" class="btn btn-tool btn-default" style="color: #888;">
                                    <i class="fas fa-shopping-cart"></i> Produtos
                                </a>
                                <a href="<?=base_url('compras/parcelas/'.$id);?>" class="btn btn-tool btn-default" style="color: #888;">
                                    <i class="fas fa-dollar-sign"></i> Parcelas
                                </a>
                                <a title="Voltar" class="btn btn-tool btn-danger" href="<?php echo site_url() ?>compras">
                                    <span class="button__icon">
                                        <i class="fas fa-undo-alt"></i>
                                    </span> 
                                    <span class="button__text2">Cancelar</span></a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form action="<?php echo base_url(); ?>compras/edit/<?= $id; ?>" id="formCompra" method="post">
                            <div class="card-body">
                                <div class="table-responsive1">
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
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="NumeroNotaCompra">Nota fiscal</label>
                                                                <input name="NumeroNotaCompra" value="<?= $compra['NumeroNotaCompra']; ?>" type="text" id="NumeroNotaCompra" class="form-control" placeholder="Nota fiscal da compra" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="CodigoEmpresa">Empresa</label>
                                                                <select name="CodigoEmpresa" id="CodigoEmpresa" class="form-control">
                                                                    <?php
                                                                    if ($empresas) {
                                                                        foreach ($empresas as $empresa) {
                                                                            ?>
                                                                            <option value="<?= $empresa['CodigoEmpresa']; ?>" <?php if (!empty($compra['CodigoEmpresa']) && $compra['CodigoEmpresa'] == $empresa['CodigoEmpresa']) {
                                                                        echo ' selected ';
                                                                    } ?>><?= $empresa['NomeEmpresa']; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="CodigoForn">Fornecedor</label>
                                                                <select name="CodigoForn" id="CodigoForn" class="form-control select2">
                                                                    <?php
                                                                    if ($fornecedores) {
                                                                        foreach ($fornecedores as $fornecedor) {
                                                                            ?>
                                                                            <option value="<?= $fornecedor['CodigoForn']; ?>" <?php if (!empty($compra['CodigoForn']) && $compra['CodigoForn'] == $fornecedor['CodigoForn']) {
                                                                        echo ' selected ';
                                                                    } ?>><?= $fornecedor['NomeForn']; ?></option>
        <?php
    }
}
?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="CodigoCentroCusto">Centro de custo</label>
                                                                <select name="CodigoCentroCusto" id="CodigoCentroCusto" class="form-control select2">
                                                                    <?php
                                                                    if ($centros) {
                                                                        foreach ($centros as $centro) {
                                                                            ?>
                                                                            <option value="<?= $centro['CodigoCentroCusto']; ?>" <?php if (!empty($compra['CodigoCentroCusto']) && $compra['CodigoCentroCusto'] == $centro['CodigoCentroCusto']) {
                                                                        echo ' selected ';
                                                                    } ?>><?= $centro['NomeCentroCusto']; ?></option>
        <?php
    }
}
?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="DataCompra">Data Compra</label> 
                                                                <input name="DataCompra" value="<?= date('Y-m-d', strtotime($compra['DataCompra'])); ?>" type="date" id="DataCompra" class="form-control" placeholder="Data da compra" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="ValorCompra">Valor Líquido</label>
                                                                <input name="ValorCompra" type="tel" value="<?= number_format($compra['ValorCompra'],2,".",""); ?>" id="ValorCompra" class="form-control valor" placeholder="Valor total da compra" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="HistoricoCompra">Histórico</label>
                                                                <input name="HistoricoCompra" value="<?= $compra['HistoricoCompra']; ?>" type="text" id="HistoricoCompra" class="form-control" placeholder="Histórico da compra" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="ObservacoesCompra">Observações Compra</label>
                                                                <textarea name="ObservacoesCompra" id="ObservacoesCompra" rows="4" class="form-control" placeholder="Observações da compra"><?= $compra['ObservacoesCompra']; ?></textarea>
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
                                <a title="Voltar" class="button btn btn-mini btn-warning float-right" href="<?php echo site_url() ?>compras">
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
<script src="<?= base_url(TEMPLATE . '/plugins/select2/js/select2.full.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('adminlte') ?>js/validate.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        });

    });

</script>
<?php echo $this->endSection(); ?>
