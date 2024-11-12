<?= $this->extend(TEMPLATE . '/layouts/app'); ?>
<?php echo $this->section('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Forma de associação</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right"> 
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('formasassociacao'); ?>">Produtos</a></li>
                        <li class="breadcrumb-item active">Adicionar forma de associação</li>
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
                                Adicionar forma de associação</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="<?php echo base_url(); ?>formasassociacao/create" id="formProduto" method="post">
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

                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label for="NomeAssocForma">Descrição</label>
                                                                <input name="NomeAssocForma" type="text" id="NomeAssocForma" class="form-control" placeholder="Descrição da forma de associação" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="ValorPagamentoAssocForma">Valor</label>
                                                                <input name="ValorPagamentoAssocForma" type="tel" id="ValorPagamentoAssocForma" class="form-control valor" placeholder="Valor da forma de associação" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="TipoPagamentoAssocForma">Tipo</label>
                                                                <select name="TipoPagamentoAssocForma" id="TipoPagamentoAssocForma" class="form-control" required="">
                                                                    <option value="N" disabled selected>Selecione uma opção</option>
                                                                    <option value="N">Nenhum</option>
                                                                    <option value="M">Mensal</option>
                                                                    <option value="A">Anual</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="DiaPagamentoAssocForma">Dia</label>
                                                                <input name="DiaPagamentoAssocForma" type="number" id="DiaPagamentoAssocForma" class="form-control" placeholder="Dia de pagamento desta forma de associação" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="MesPagamentoAssocForma">Mês</label>
                                                                <input name="MesPagamentoAssocForma" type="number" id="MesPagamentoAssocForma" class="form-control" placeholder="Mês de pagamento desta forma de associação (obrigatório se for tipo anual)" />
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
                                <a title="Voltar" class="button btn btn-mini btn-warning float-right" href="<?php echo site_url() ?>formasassociacao">
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
        $('#TipoPagamentoAssocForma').change(function (e) {
            e.preventDefault();
            var changed = $(this).val();
            if (changed === 'A') {   
                $('#MesPagamentoAssocForma').attr('required', true);
            } else {
                $('#MesPagamentoAssocForma').attr('required', false);
                $('#MesPagamentoAssocForma').removeAttr('required');
            }
        });
    });
</script>
<?php echo $this->endSection(); ?>
