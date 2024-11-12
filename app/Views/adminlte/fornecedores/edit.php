<?= $this->extend(TEMPLATE . '/layouts/app'); ?>
<?php echo $this->section('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Fornecedor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right"> 
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('fornecedores'); ?>">Fornecedores</a></li>
                        <li class="breadcrumb-item active">Editar fornecedor</li>
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
                                Editar fornecedor</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="<?php echo base_url(); ?>fornecedores/edit/<?=$id;?>" id="formForn" method="post">
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
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="NomeForn">Nome </label>
                                                                <input name="NomeForn" value="<?=$fornecedor['NomeForn'];?>" type="text" id="NomeForn" class="form-control" placeholder="Nome do fornececor" required="required" />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="CNPJForn">CNPJ</label>
                                                                <input name="CNPJForn" value="<?=mask($fornecedor['CNPJForn'],'##.###.###/####-##');?>" type="tel" id="CNPJForn" class="form-control cnpj" placeholder="CNPJ do fornecedor" oninput="mascara_checkout(this, 'cnpj')" maxlength="18" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="CICForn">CPF</label>
                                                                <input name="CICForn" value="<?=mask($fornecedor['CICForn'],'###.###.###-##');?>" type="tel" id="CICForn" class="form-control cpf" placeholder="CPF do fornecedor" oninput="mascara_checkout(this, 'cpf')" maxlength="14" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                   
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="CEPForn">CEP</label>
                                                                <input name="CEPForn" value="<?=mask($fornecedor['CEPForn'],'#####-###');?>" type="tel" id="CEPForn" class="form-control cep" placeholder="CEP do fornecedor" oninput="mascara_checkout(this, 'cep')" maxlength="9" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="EnderecoForn">Endereço</label>
                                                                <input name="EnderecoForn" value="<?=$fornecedor['EnderecoForn'];?>" type="text" id="EnderecoForn" class="form-control rua" placeholder="Endereço do fornecedor"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="BairroForn">Bairro</label>
                                                                <input name="BairroForn" value="<?=$fornecedor['BairroForn'];?>" type="text" id="BairroForn" class="form-control bairro" placeholder="Bairro do fornecedor"/>
                                                            </div>
                                                        </div>
                                                
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="CidadeForn">Cidade</label>
                                                                <input name="CidadeForn" value="<?=$fornecedor['CidadeForn'];?>" type="text" id="CidadeForn" class="form-control cidade" placeholder="Cidade do fornecedor" />
                                                            </div>
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="FoneForn">Telefone</label>
                                                                <input name="FoneForn" value="<?=$fornecedor['FoneForn'];?>" type="tel" id="FoneForn" class="form-control " placeholder="Telefone do fornecedor" oninput="mascara_checkout(this, 'tel')" maxlength="13" />
                                                            </div>
                                                        </div>
                                                       

                                                        <div class="col-md-4">
                                                            <div class="form-floating form-group">
                                                                <label for="EMailForn">E-mail</label>
                                                                <input name="EMailForn" value="<?=$fornecedor['EMailForn'];?>" type="email" id="EMailForn" class="form-control " placeholder="E-mail do fornecedor" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-floating form-group">
                                                                <label for="SiteForn">Site <small class="text-danger">Ex.: https://meusite.com.br</small></label>
                                                                <input name="SiteForn" value="<?=$fornecedor['SiteForn'];?>" type="url" id="SiteForn" class="form-control " placeholder="Site do fornecedor" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-floating form-group">
                                                                <label for="CodigoBancoForn">Banco</label>
                                                                <select name="CodigoBancoForn" id="CodigoBancoForn" class="form-control">
                                                                    <option value="" selected disabled>Selecione uma opção</option>
                                                                    <?php 
                                                                    if($bancos){
                                                                        foreach($bancos as $banco){
                                                                            ?>
                                                                    <option value="<?=$banco['id'];?>" <?php if(isset($fornecedor['CodigoBancoForn']) && $fornecedor['CodigoBancoForn'] == $banco['id']){ echo ' selected '; }?>><?=$banco['NomeBanco'];?></option>
                                                                                <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating form-group">
                                                                <label for="TipoPagto">Tipo Pagto.</label>
                                                                <select name="TipoPagto" id="TipoPagto" class="form-control">
                                                                    <option value="N" <?php if(isset($fornecedor['TipoPagto']) && $fornecedor['TipoPagto'] === 'N'){ echo ' selected '; }?>>Nota</option>
                                                                    <option value="R" <?php if(isset($fornecedor['TipoPagto']) && $fornecedor['TipoPagto'] === 'R'){ echo ' selected '; }?>>RPA</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="AgenciaForn">Agência</label>
                                                                <input name="AgenciaForn" value="<?=$fornecedor['AgenciaForn'];?>" type="text" id="AgenciaForn" class="form-control" placeholder="Agência para pagamento do fornecedor" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="ContaForn">Conta</label>
                                                                <input name="ContaForn" value="<?=$fornecedor['ContaForn'];?>" type="text" id="ContaForn" class="form-control" placeholder="Conta para pagamento do fornecedor"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="PercINSS">Perc. INSS</label>
                                                                <input name="PercINSS" value="<?=$fornecedor['PercINSS'];?>" type="tel" id="PercINSS" class="form-control valor" placeholder="Percentual de cálculo de INSS na RPA"/>
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
                                                                <input name="NomeContato" value="<?=$fornecedor['NomeContato'];?>" type="text" id="NomeContato" class="form-control" placeholder="Nome do contato" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="CelularContato">Fone</label>
                                                                <input name="CelularContato" value="<?=$fornecedor['CelularContato'];?>" type="tel" id="CelularContato" class="form-control" placeholder="Telefone do contato" oninput="mascara_checkout(this, 'cel')" maxlength="14"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="NomeContato2">Nome</label>
                                                                <input name="NomeContato2" value="<?=$fornecedor['NomeContato2'];?>" type="text" id="NomeContato2" class="form-control" placeholder="Nome do contato" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="CelularContato2">Fone</label>
                                                                <input name="CelularContato2" value="<?=$fornecedor['CelularContato2'];?>" type="tel" id="CelularContato2" class="form-control" placeholder="Telefone do contato" oninput="mascara_checkout(this, 'cel')" maxlength="14"/>
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
                                <a title="Voltar" class="button btn btn-mini btn-warning float-right" href="<?php echo site_url() ?>fornecedores">
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
        $("#formForn").validate({
            rules: {
                NomeForn: {
                    required: true
                }
            },
            messages: {
                NomeForn: {
                    required: 'Campo nome obrigatório'
                }
            }
        });
    });
</script>
<?php echo $this->endSection(); ?>
