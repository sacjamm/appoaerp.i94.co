<?= $this->extend(TEMPLATE . '/layouts/app'); ?>

<?php echo $this->section('content'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gerenciar Acompanhamentos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Associados</li>
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
                                <a href="<?= base_url('associados/create_acompanhamento/' . $id); ?>" class="btn btn-success btn-xs">
                                    <i class="fa fa-plus"></i> Novo
                                </a> 
                                Gerencie os acompanhamentos
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_acompanhamentos" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Observação</th>
                                            <th>Data</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($acompanhamentos) {  
                                            foreach ($acompanhamentos as $acompanhamento) {
                                                $button_edit = $button_edit_acompanhamento ? '<a href="' . base_url('associados/edit_acompanhamento/' . $acompanhamento['CodigoAcompanhamento'].'/'.$id) . '" class="dropdown-item text-primary"><i class="fas fa-edit"></i> Editar</a>' : '';
                                                $button_delete = $button_delete_acompanhamento ? '<a href="#" class="dropdown-item text-danger delete-btn" data-associd="'.$id.'" data-id="' . $acompanhamento['CodigoAcompanhamento'] . '"><i class="fas fa-trash"></i> Excluir</a>' : '';
                                                $button_actions = '<div class="btn-group">
                    <button type="button" class="btn btn-info">Ações</button>
                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu" style="">
                      ' . $button_edit . $button_delete . '
                    </div>
                  </div>';
                                                ?>
                                                <tr class="tr_<?= $acompanhamento['CodigoAcompanhamento']; ?>">
                                                    <td><?= $acompanhamento['CodigoAcompanhamento']; ?></td>
                                                    <td><?= $acompanhamento['ObservacaoAcompanhamento']; ?></td>
                                                    <td><?= date('d/m/Y', strtotime($acompanhamento['DataAcompanhamento'])); ?></td>  
                                                    <td>
                                                        <?= $button_actions; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <!-- Data will be populated by DataTables -->
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
        var associd;

        function loadTable() {
            $('#table_associados').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [[0, 'desc']],
                "ajax": {
                    "url": "<?= base_url('associados/getData') ?>",
                    "type": "POST"
                },
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "dom": 'Bfrtip'
            }).buttons().container().appendTo('#table_associados_wrapper .col-md-6:eq(0)');
        }

        loadTable();

        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            deleteId = $(this).data('id');
            associd = $(this).data('associd');
            modal.show();
        });

        $('#confirmDelete').on('click', function () {
            $.ajax({
                url: '<?= base_url('associados/delete_acompanhamento') ?>',
                method: 'POST',
                data: {id: deleteId,assocId:associd},
                success: function (response) {
                    modal.hide();
                    $('.tr_'+response.id).remove();
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
