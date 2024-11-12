<?= $this->extend(TEMPLATE . '/layouts/app'); ?>
<?php echo $this->section('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Associado</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right"> 
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('associados'); ?>">Associados</a></li>
                        <li class="breadcrumb-item active">Adicionar associado</li>
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
                                    <i class="fas fa-user"></i>
                                </span> 
                                Adicionar associado</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="<?php echo base_url(); ?>associados/create" id="formAssociado" method="post">
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
                                                                <label for="NomeAssoc">Nome do associado</label>
                                                                <input name="NomeAssoc" type="text" id="NomeAssoc" class="form-control" placeholder="Nome do associado" required="required" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="CICAssoc">CPF do associado</label>
                                                                <input name="CICAssoc" type="tel" id="CICAssoc" class="form-control cpf" placeholder="CPF do associado" oninput="mascara_checkout(this, 'cpf')" maxlength="14" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="PISAssoc">PIS</label>
                                                                <input name="PISAssoc" type="tel" id="PISAssoc" class="form-control" placeholder="PIS do associado" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="CRPAssoc">CRP</label>
                                                                <input name="CRPAssoc" type="text" id="CRPAssoc" class="form-control " placeholder="CRP do associado" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="CodigoBancoAssoc">Tipo de Cobrança (Banco e Secretaria) remover as opções do select </label>
                                                                <select name="CodigoBancoAssoc" id="CodigoBancoAssoc" class="form-control">
                                                                    <option value="" disabled selected>Selecione uma opção</option>
                                                                    <?php
                                                                    if ($bancos) {
                                                                        foreach ($bancos as $banco) {
                                                                            ?>
                                                                            <option value="<?= $banco['CodigoBanco']; ?>"><?= $banco['NomeBanco']; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="CEPAssoc">CEP</label>
                                                                <input name="CEPAssoc" type="tel" id="CEPAssoc" class="form-control cep" placeholder="CEP do associado" oninput="mascara_checkout(this, 'cep')" maxlength="9" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="EnderecoAssoc">Endereço</label>
                                                                <input name="EnderecoAssoc" type="text" id="EnderecoAssoc" class="form-control rua" placeholder="Endereço do associado"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="BairroAssoc">Bairro</label>
                                                                <input name="BairroAssoc" type="text" id="BairroAssoc" class="form-control bairro" placeholder="Bairro do associado"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="CidadeAssoc">Cidade</label>
                                                                <input name="CidadeAssoc" type="text" id="CidadeAssoc" class="form-control cidade" placeholder="Cidade do associado" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="DataNascAssoc">Data Nascimento</label>
                                                                <input name="DataNascAssoc" type="tel" id="DataNascAssoc" class="form-control " placeholder="Data de nascimento do associado" oninput="mascara_checkout(this, 'data')" maxlength="10" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="FoneAssoc">Telefone</label>
                                                                <input name="FoneAssoc" type="tel" id="FoneAssoc" class="form-control " placeholder="Telefone do associado" oninput="mascara_checkout(this, 'tel')" maxlength="13" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="CelularAssoc">Celular</label>
                                                                <input name="CelularAssoc" type="tel" id="CelularAssoc" class="form-control " placeholder="Celular do associado" oninput="mascara_checkout(this, 'cel')" maxlength="14" />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="EMailAssoc">E-mail</label>
                                                                <input name="EMailAssoc" type="email" id="EMailAssoc" class="form-control " placeholder="E-mail do associado" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="SiteAssoc">Site <small class="text-danger">Ex.: https://meusite.com.br</small></label>
                                                                <input name="SiteAssoc" type="url" id="SiteAssoc" class="form-control " placeholder="Site do associado" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="PercINSS">Perc. INSS</label>
                                                                <input name="PercINSS" type="number" id="PercINSS" class="form-control " placeholder="Percentual de cálculo de INSS na RPA" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="PercDesc">Perc. Desconto</label>
                                                                <input name="PercDesc" type="number" id="PercDesc" class="form-control " placeholder="Percentual de desconto do associado" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="TipoPagamento">Tipo Pagto Instrutor</label>
                                                                <select name="TipoPagamento" id="TipoPagamento" class="form-control ">
                                                                    <option value="R">RPA</option>
                                                                    <option value="N">Nota</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label for="RespAcolhimento">Acolhimento</label>
                                                                <input name="RespAcolhimento" type="text" id="RespAcolhimento" class="form-control " placeholder="Responsável pelo acolhimento" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="TipoEndRemAssoc">Endereço remessa</label>
                                                                <select name="TipoEndRemAssoc" id="TipoEndRemAssoc" class="form-control ">
                                                                    <option value="C">Consultório</option>
                                                                    <option value="R">Residência</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-header bg-primary">
                                                        <h3 class="card-title">
                                                            <span class="icon">
                                                                <i class="fas fa-map"></i>
                                                            </span> 
                                                            Endereço Consultório</h3>
                                                    </div>     

                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="CEPRemaAssoc">CEP</label>
                                                                <input name="CEPRemaAssoc" type="tel" id="CEPRemaAssoc" class="form-control cepC" placeholder="CEP do consultório" oninput="mascara_checkout(this, 'cep')" maxlength="9" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="EnderecoRemAssoc">Endereço</label>
                                                                <input name="EnderecoRemAssoc" type="text" id="EnderecoRemAssoc" class="form-control ruaC" placeholder="Endereço do consultório"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="BairroRemAssoc">Bairro</label>
                                                                <input name="BairroRemAssoc" type="text" id="BairroRemAssoc" class="form-control bairroC" placeholder="Bairro do consultório"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="CidadeRemAssoc">Cidade</label>
                                                                <input name="CidadeRemAssoc" type="text" id="CidadeRemAssoc" class="form-control cidadeC" placeholder="Cidade do consultório" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="FAXAssoc">Fone</label>
                                                                <input name="FAXAssoc" type="tel" id="FAXAssoc" class="form-control " placeholder="Telefone do consultório" oninput="mascara_checkout(this, 'cel')" maxlength="14" />
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
                                <a title="Voltar" class="button btn btn-mini btn-warning float-right" href="<?php echo site_url() ?>associados">
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
<script type="text/javascript" src="<?php echo base_url('adminlte') ?>/js/validate.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#formAssociado").validate({
            rules: {
                NomeAssoc: {
                    required: true
                }
            },
            messages: {
                NomeAssoc: {
                    required: 'Campo nome obrigatório'
                }
            }
        });
    });
</script>
<?php echo $this->endSection(); ?>
