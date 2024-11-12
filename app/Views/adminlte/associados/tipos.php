<?= $this->extend(TEMPLATE . '/layouts/app'); ?>

<?php echo $this->section('content'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gerenciar Tipos de Associados</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Tipos de Associados</li>
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

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="<?= base_url('associados/create_tipo'); ?>" class="btn btn-success btn-xs">
                                    <i class="fa fa-plus"></i> Novo
                                </a> 
                                Gerencie os tipos de associados
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive" id="permissionsTable">
                                <table id="table_tipos" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome Tipo Associado</th>
                                            <th>Uso Sistema</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($tipos) {
                                            foreach ($tipos as $tipo) {
                                                $button_edit = '<a href="' . base_url('associados/edit_tipo/' . $tipo['CodigoAssocTipo']) . '" class=" btn-link text-primary"><i class="fas fa-edit"></i></a>';
                                                if (!hasPermission($userPermissions, 'eAssociado')) {
                                                    $button_edit = '';
                                                }
                                                $button_delete = '<a href="#" class=" btn-link text-danger delete-btn" data-id="' . $tipo['CodigoAssocTipo'] . '"><i class="fas fa-trash"></i></a>';
                                                if (!hasPermission($userPermissions, 'dAssociado')) {
                                                    $button_delete = '';
                                                }
                                                ?>
                                                <tr id="<?= $tipo['CodigoAssocTipo']; ?>">
                                                    <td><?= $tipo['CodigoAssocTipo']; ?></td>
                                                    <td><?= $tipo['NomeAssocTipo']; ?></td>
                                                    <td><?= $tipo['AssociacaoTipo']; ?></td>
                                                    <td>
                                                        <?= $button_edit . $button_delete; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
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

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja remover esse registro?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirmDelete" class="btn btn-warning">Deletar</button>
                <button type="button" id="cancelDelete" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        var deleteId;

        function loadTable() {
            // Carregar a tabela com AJAX e reinicializar o DataTables
            $('#permissionsTable').load('<?= base_url('associados/getTableDataTiposAssociado'); ?>', function () {
                // Reinicializar o DataTables após o carregamento da tabela
                $('#table_tipos').DataTable({
                    "order": [[0, 'desc']],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#table_tipos_wrapper .col-md-6:eq(0)');
            });
        }
        // Carrega a tabela quando a página for carregada
        loadTable();

        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            deleteId = $(this).data('id');
            modal.show();
        });

        $('#confirmDelete').on('click', function () { 
            $.ajax({
                url: '<?= base_url('associados/delete_tipo') ?>',
                method: 'POST',
                data: {id: deleteId},
                success: function (response) {
                    modal.hide();
                    //$('#table_tipos').DataTable().ajax.reload();
                    $('#'+response.id).remove();
                    $('#message').html('<div class="alert alert-' + (response.status === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>');
                    // Remove the alert after 3 seconds
                    setTimeout(function () {
                        $('#message').html('');
                    }, 3000);
                }
            });
        });

        $('#cancelDelete').on('click', function () {
            modal.hide();
        });
    });
</script>



<?php echo $this->endSection(); ?>
