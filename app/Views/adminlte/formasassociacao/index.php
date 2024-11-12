<?= $this->extend(TEMPLATE . '/layouts/app'); ?>
<?php echo $this->section('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gerenciar formas de associação</h1> 
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Formas de associação</li>
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
                                <a href="<?= base_url('formasassociacao/create'); ?>" class="btn btn-success btn-xs">
                                    <i class="fa fa-plus"></i> Novo
                                </a> 
                                Gerencie as formas de associação </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body"> 
                            <div class="table-responsive" id="permissionsTable">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Forma de Associação</th>
                                            <th>Tipo Pagamento</th>
                                            <th>Dia Pagamento</th>
                                            <th>Mês Pagamento</th>
                                            <th>Valor Pagamento</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($formas as $forma) {
                                            $button_edit = '<a href="' . base_url('formasassociacao/edit/' . $forma['CodigoAssocForma']) . '" class=" btn-link text-primary"><i class="fas fa-edit"></i></a>';
                                            if (!hasPermission($userPermissions, 'eFormaassociacao')) {
                                                $button_edit = '';
                                            }
                                            $button_delete = '<a href="#" class=" btn-link text-danger delete-btn" data-id="' . $forma['CodigoAssocForma'] . '"><i class="fas fa-trash"></i></a>';
                                            if (!hasPermission($userPermissions, 'dFormaassociacao')) {
                                                $button_delete = '';
                                            }
                                            if(!empty($forma['TipoPagamentoAssocForma']) && $forma['TipoPagamentoAssocForma'] ==='A'){
                                                $TipoPagamentoAssocForma='<span class="badge badge-primary">Anual</span>';
                                            }elseif(!empty($forma['TipoPagamentoAssocForma']) && $forma['TipoPagamentoAssocForma'] ==='M'){
                                                $TipoPagamentoAssocForma='<span class="badge badge-info">Mensal</span>';
                                            }else{
                                                $TipoPagamentoAssocForma='<span class="badge badge-danger">Nenhuma</span>';
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $forma['CodigoAssocForma']; ?></td> 
                                                <td><?= $forma['NomeAssocForma']; ?></td>
                                                <td><?= $TipoPagamentoAssocForma; ?></td>
                                                <td><?= $forma['DiaPagamentoAssocForma']; ?></td>
                                                <td><?= $forma['MesPagamentoAssocForma']; ?></td>
                                                <td><?= number_format($forma['ValorPagamentoAssocForma'],2,",","."); ?></td>
                                                <td>
                                                    <?= $button_edit . $button_delete; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Forma de Associação</th>
                                            <th>Tipo Pagamento</th>
                                            <th>Dia Pagamento</th>
                                            <th>Mês Pagamento</th>
                                            <th>Valor Pagamento</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>
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
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja remover esse registro?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirmDelete" class="btn btn-warning">Deletar</button>
                <button type="button" id="cancelDelete" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = $('#confirmModal');
        var deleteId;

        function timeout_page(response, time) {
            setTimeout(function () {
                response;

            }, time);
        }
        function loadTable() {
            // Carregar a tabela com AJAX e reinicializar o DataTables
            $('#permissionsTable').load('<?= base_url('formasassociacao/getTableData'); ?>', function () {
                // Reinicializar o DataTables após o carregamento da tabela
                $('#example1').DataTable({
                    "order": [[0, 'desc']],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        }
        // Carrega a tabela quando a página for carregada
        //loadTable();
        // Abrir o modal ao clicar no botão de deletar
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            deleteId = $(this).data('id');
            modal.modal('show');
        });
        // Confirmar a exclusão
        $('#confirmDelete').on('click', function () {
            $.ajax({
                url: '<?= site_url('formasassociacao/delete') ?>',
                type: 'POST', 
                data: {
                    id: deleteId,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                    } else {
                        $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                    //loadTable();
                    modal.modal('hide');
                    // Remove the alert after 3 seconds

                    setTimeout(function () {
                        //$('#message').html('');
                        window.location.reload();
                    }, 3000);
                },
                error: function (xhr, status, error) {
                    $('#message').html('<div class="alert alert-danger">Ocorreu um erro ao tentar deletar o registro.</div>');
                    modal.modal('hide');
                    setTimeout(function () {
                        $('#message').html('');
                    }, 3000);
                }
            });
        });
    });
</script>

<?php echo $this->endSection(); ?>
