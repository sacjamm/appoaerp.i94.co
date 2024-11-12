<?= $this->extend(TEMPLATE . '/layouts/app'); ?>
<?php echo $this->section('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Usuário</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('usuarios'); ?>">Usuários</a></li>
                        <li class="breadcrumb-item active">Adicionar usuário</li>
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
                                Adicionar usuário</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="<?php echo base_url(); ?>usuarios/create" id="formUsuario" method="post">
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
                                                                <label for="Usuario">Nome do usuário</label>
                                                                <input name="Usuario" type="text" id="Usuario" class="form-control" placeholder="Digite o nome do usuário" required="required" />
                                                            </div>
                                                        </div>                                                         
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="EmailUsuario">E-mail do usuário</label>
                                                                <input name="EmailUsuario" type="email" id="EmailUsuario" class="form-control" placeholder="Digite o e-mail do usuário" required="required" />
                                                            </div>
                                                        </div>                                                         
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="SenhaUsuario">Senha do usuário <small class="text-danger">Mínimo de 6 caracteres e máximo de 10 caracteres</small></label>
                                                                <input name="SenhaUsuario" type="text" id="SenhaUsuario" class="form-control" placeholder="Digite a senha do usuário" required="required" />
                                                                <small id="senhaErro" class="text-danger"></small>
                                                            </div>
                                                        </div>                                                         
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="permissao_id">Nível do usuário</label>
                                                                <select name="permissao_id" class="form-control" id="permissao_id" required="required">
                                                                    <option selected disabled value="">Selecione uma opção</option>
                                                                    <?php
                                                                    if ($permissoes) {
                                                                        foreach ($permissoes as $permission) {
                                                                            ?>
                                                                            <option value="<?= $permission['idPermissao']; ?>"><?= $permission['nome']; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>                                                         
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 ">
                                                            <label>Marque esta opção para selecionar todas as permissões</label>
                                                            <div class="form-group">
                                                                <label>
                                                                    <input name="marcarTodos" type="checkbox" value="1" id="marcarTodos" class="checkbox" />
                                                                    <span class="lbl"> Marcar Todos</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div> 

                                                    <div class="widget-content">

                                                        <?php if (isset($telas) && is_array($telas)): ?>
                                                            <table class="table table-bordered table-condensed">
                                                                <tbody>
                                                                    <?php foreach ($telas as $tela => $permissoesSerialized): ?>
                                                                        <tr>
                                                                            <?php foreach ($permissoesSerialized as $sigla => $descricao): ?>
                                                                                <td>
                                                                                    <label>
                                                                                        <input name="<?= $sigla . $tela ?>" class="marcar" type="checkbox" value="1" />
                                                                                        <span class="lbl"><?= $descricao ?></span>
                                                                                    </label>
                                                                                </td>
                                                                            <?php endforeach; ?>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        <?php endif; ?>

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
                                    <span class="button__text2">Salvar</span>
                                </button>
                                <a title="Voltar" class="button btn btn-mini btn-warning float-right" href="<?php echo site_url() ?>usuarios">
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
        $("#marcarTodos").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });
        $("#formUsuario").validate({
            rules: {
                Usuario: {
                    required: true
                },
                EmailUsuario: {
                    required: true,
                    email: true
                },
                SenhaUsuario: {
                    required: true,
                    minlength: 6,
                    maxlength: 10
                },
                permissao_id: {
                    required: true
                }
            },
            messages: {
                Usuario: {
                    required: 'Campo usuário obrigatório'
                },
                EmailUsuario: {
                    required: 'Campo e-mail obrigatório',
                    email: 'Digite um e-mail válido'
                },
                SenhaUsuario: {
                    required: 'Campo senha obrigatório',
                    minlength: 'A senha deve ter pelo menos 6 caracteres',
                    maxlength: 'A senha deve ter no máximo 10 caracteres'
                },
                permissao_id: {
                    required: 'Campo nível obrigatório'
                }
            }
        });
    });
</script>
<?php echo $this->endSection(); ?>
