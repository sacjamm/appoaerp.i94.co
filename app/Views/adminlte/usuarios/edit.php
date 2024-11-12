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
                        <li class="breadcrumb-item active">Editar usuário</li>
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
                                Editar usuário</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="<?php echo base_url(); ?>usuarios/edit/<?= $id; ?>" id="formUsuario" method="post">

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
                                                                <input name="Usuario" type="text" id="Usuario" class="form-control" placeholder="Digite o nome do usuário" required="required" value="<?= $user->Usuario; ?>" />
                                                            </div>
                                                        </div>                                                         
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="EmailUsuario">E-mail do usuário</label>
                                                                <input name="EmailUsuario" type="email" id="EmailUsuario" class="form-control" value="<?= $user->EmailUsuario; ?>" placeholder="Digite o e-mail do usuário" required="required" />
                                                            </div>
                                                        </div>                                                         
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="SenhaUsuario">Senha do usuário <small class="text-danger">Mínimo de 6 caracteres e máximo de 10 caracteres</small></label>
                                                                <div class="input-group">
                                                                    <input name="SenhaUsuario" type="text" id="SenhaUsuario" class="form-control" placeholder="Digite a senha do usuário" required="required" disabled />
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary" type="button" id="toggleSenha">Habilitar</button>
                                                                    </div>
                                                                </div>
                                                                <small id="senhaErro" class="text-danger"></small>
                                                            </div>
                                                        </div>                                                         
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="permissao_id">Nível do usuário</label>
                                                                <select name="permissao_id" class="form-control" id="permissao_id" required="required">

                                                                    <?php
                                                                    if ($permissoes) {
                                                                        foreach ($permissoes as $permissions) {
                                                                            ?>
                                                                            <option value="<?= $permissions['idPermissao']; ?>" <?php
                                                                            if (!empty($user->permissao_id) && $user->permissao_id == $permissions['idPermissao'] || $user->permissao_id === $permissions['idPermissao']) {
                                                                                echo ' selected ';
                                                                            }
                                                                            ?>><?= $permissions['nome']; ?></option>
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
                                                                                        <input name="<?= $sigla . $tela ?>" class="marcar" type="checkbox" value="1" 
                                                                                               <?= isset($permission[$sigla . $tela]) && ($permission[$sigla . $tela] === 1 || $permission[$sigla . $tela] === '1') ? 'checked' : ''; ?> />
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
    document.getElementById('toggleSenha').addEventListener('click', function () {
        var senhaInput = document.getElementById('SenhaUsuario');
        var button = this;

        if (senhaInput.disabled) {
            senhaInput.disabled = false;
            button.textContent = 'Desabilitar'; // Muda o texto do botão para 'Desabilitar'
        } else {
            senhaInput.disabled = true;
            button.textContent = 'Habilitar'; // Muda o texto do botão para 'Habilitar'
        }
    });
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
                permissao_id: {
                    required: 'Campo nível obrigatório'
                }
            }
        });
    });
</script>
<?php echo $this->endSection(); ?>
