<?= $this->extend(TEMPLATE . '/layouts/app'); ?>
<?php echo $this->section('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Empresa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right"> 
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('empresas'); ?>">Empresas</a></li>
                        <li class="breadcrumb-item active">Editar empresa</li>
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
                                Editar empresa</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="<?php echo base_url(); ?>empresas/edit/<?=$id;?>" id="formEmpresa" method="post">
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
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="NomeEmpresa">Nome da empresa</label>
                                                                <input name="NomeEmpresa" value="<?=$empresa['NomeEmpresa'];?>" type="text" id="NomeEmpresa" class="form-control" placeholder="Nome da empresa" required="required" />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="CNPJEmpresa">CNPJ da empresa</label>
                                                                <input name="CNPJEmpresa" value="<?=mask($empresa['CNPJEmpresa'],'##.###.###/####-##');?>" type="tel" id="CICAssoc" class="form-control cnpj" placeholder="CNPJ da empresa" oninput="mascara_checkout(this, 'cnpj')" maxlength="18" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                   
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="CEPEmpresa">CEP</label>
                                                                <input name="CEPEmpresa" value="<?=mask($empresa['CEPEmpresa'],'#####-###');?>" type="tel" id="CEPEmpresa" class="form-control cep" placeholder="CEP da empresa" oninput="mascara_checkout(this, 'cep')" maxlength="9" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="EnderecoEmpresa">Endereço</label>
                                                                <input name="EnderecoEmpresa" value="<?=$empresa['EnderecoEmpresa'];?>" type="text" id="EnderecoEmpresa" class="form-control rua" placeholder="Endereço da empresa"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="BairroEmpresa">Bairro</label>
                                                                <input name="BairroEmpresa" value="<?=$empresa['BairroEmpresa'];?>" type="text" id="BairroEmpresa" class="form-control bairro" placeholder="Bairro da empresa"/>
                                                            </div>
                                                        </div>
                                                
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="CidadeEmpresa">Cidade</label>
                                                                <input name="CidadeEmpresa" value="<?=$empresa['CidadeEmpresa'];?>" type="text" id="CidadeEmpresa" class="form-control cidade" placeholder="Cidade da empresa" />
                                                            </div>
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="FoneEmpresa">Telefone</label>
                                                                <input name="FoneEmpresa" value="<?=$empresa['FoneEmpresa'];?>" type="tel" id="FoneEmpresa" class="form-control " placeholder="Telefone da empresa" oninput="mascara_checkout(this, 'tel')" maxlength="13" />
                                                            </div>
                                                        </div>
                                                       

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="EMailEmpresa">E-mail</label>
                                                                <input name="EMailEmpresa" value="<?=$empresa['EMailEmpresa'];?>" type="email" id="EMailEmpresa" class="form-control " placeholder="E-mail da empresa" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="SiteEmpresa">Site <small class="text-danger">Ex.: https://meusite.com.br</small></label>
                                                                <input name="SiteEmpresa" value="<?=$empresa['SiteEmpresa'];?>" type="url" id="SiteEmpresa" class="form-control " placeholder="Site da empresa" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="card-header bg-primary">
                                                        <h3 class="card-title">
                                                            <span class="icon">
                                                                <i class="fas fa-id-card"></i>
                                                            </span> 
                                                            Contatos</h3>
                                                    </div>     

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="NomeContato">Nome</label>
                                                                <input name="NomeContato" value="<?=$empresa['NomeContato'];?>" type="text" id="NomeContato" class="form-control" placeholder="Nome do contato" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="CelularContato">Fone</label>
                                                                <input name="CelularContato" value="<?=$empresa['CelularContato'];?>" type="tel" id="CelularContato" class="form-control" placeholder="Telefone do contato" oninput="mascara_checkout(this, 'cel')" maxlength="14"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="NomeContato2">Nome</label>
                                                                <input name="NomeContato2" value="<?=$empresa['NomeContato2'];?>" type="text" id="NomeContato2" class="form-control" placeholder="Nome do contato" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="CelularContato2">Fone</label>
                                                                <input name="CelularContato2" value="<?=$empresa['CelularContato2'];?>" type="tel" id="CelularContato2" class="form-control" placeholder="Telefone do contato" oninput="mascara_checkout(this, 'cel')" maxlength="14"/>
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
                                <a title="Voltar" class="button btn btn-mini btn-warning float-right" href="<?php echo site_url() ?>empresas">
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
        $("#formEmpresa").validate({
            rules: {
                NomeEmpresa: {
                    required: true
                }
            },
            messages: {
                NomeEmpresa: {
                    required: 'Campo nome obrigatório'
                }
            }
        });
    });
</script>
<?php echo $this->endSection(); ?>
