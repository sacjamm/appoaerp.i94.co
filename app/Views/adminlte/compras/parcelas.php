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
                    <h1>Parcelas da compra #<?= $compra['CodigoCompra']; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right"> 
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('compras'); ?>">Compras</a></li>
                        <li class="breadcrumb-item active">Adicionar/Editar parcela compra</li>
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
                                Adicionar/Editar parcela compra</h3>
                            <div class="card-tools">
                                <a href="<?= base_url('compras/edit/' . $id); ?>" class="btn btn-tool btn-warning"> 
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="<?= base_url('compras/produtos/' . $id); ?>" class="btn btn-tool btn-default" style="color: #888;">
                                    <i class="fas fa-shopping-cart"></i> Produtos
                                </a>
                                <a href="javascript:;" class="btn btn-tool btn-success active" disabled style="color: white;">
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
                        <form action="<?php echo base_url(); ?>compras/parcelas/<?= $id; ?>" id="formCompra" method="post">
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
                                                    <div class="row field-row">

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="Fornecedor">Fornecedor</label>
                                                                <input name="Fornecedor" disabled id="Fornecedor" type="text" class="form-control" value="<?= $fornecedor['NomeForn']; ?>" />
                                                            </div>
                                                        </div>                                                 
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="QtdParcela">Quantidade de parcela</label>
                                                                <input name="QtdParcela" id="QtdParcela" type="number" min="1" max="<?= $LimiteMaximoParcelasDisponiveis; ?>" class="form-control" value="1" placeholder="Quantidade de parcelas" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="DataParcela">Data de vencimento</label>
                                                                <input name="DataParcela" id="DataParcela" type="date" class="form-control" placeholder="Data de vencimento da parcela" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="ValorParcela">Valor parcela</label>
                                                                <input name="ValorParcela" id="ValorParcela" type="tel" class="form-control valor" placeholder="Valor da parcela" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <button type="button" onclick="return addParcela();return false;" class="btn btn-primary btn-block btn-add"><i class="fas fa-plus"></i> Adicionar</button>
                                                            </div>
                                                        </div>
                                                    </div>                                               
                                                </div>
                                            </div>
                                        </div>
                                    </div>                             
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->


                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <span class="icon">
                                    <i class="fas fa-list"></i>
                                </span> 
                                Listar parcelas da compra</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body"> 
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="example1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Vencimento</th>
                                            <th>Valor</th>
                                            <th>Ações</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Os produtos serão inseridos dinamicamente via JS -->
                                    </tbody>
                                </table>                     
                            </div>
                        </div>

                    </div>
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
<script type="text/javascript">
                                                                    $(document).ready(function () {
                                                                        $('.select2').select2({
                                                                            theme: 'bootstrap4'
                                                                        });
                                                                    });

                                                                    // Seleciona o campo de input para quantidade de parcelas
                                                                    const qtdParcelaInput = document.getElementById('QtdParcela');

                                                                    qtdParcelaInput.addEventListener('input', function () {
                                                                        let value = parseInt(this.value);
                                                                        if (value < 1) {
                                                                            this.value = 1;
                                                                        }
                                                                        if (value > <?= $LimiteMaximoParcelasDisponiveis; ?>) {
                                                                            this.value = <?= $LimiteMaximoParcelasDisponiveis; ?>;
                                                                        }
                                                                    });

                                                                    function addParcela() {
                                                                        var qtdParcela = $('#QtdParcela').val();
                                                                        var dataParcela = $('#DataParcela').val();
                                                                        var valorParcela = $('#ValorParcela').val();

                                                                        if (qtdParcela && dataParcela && valorParcela) {
                                                                            $.ajax({
                                                                                url: '<?= base_url("compras/addParcela/".$id) ?>', // URL do método no controlador
                                                                                type: 'POST',
                                                                                data: {
                                                                                    qtdParcela: qtdParcela,
                                                                                    dataParcela: dataParcela,
                                                                                    valorParcela: valorParcela
                                                                                },
                                                                                success: function (response) {
                                                                                    if (response.success) {
                                                                                        alert('Parcelas cadastradas com sucesso!');
                                                                                        listarParcelas();
                                                                                    } else {
                                                                                        alert('Erro ao cadastrar as parcelas!');
                                                                                    }
                                                                                },
                                                                                error: function () {
                                                                                    alert('Erro ao processar a requisição.');
                                                                                }
                                                                            });
                                                                        } else {
                                                                            alert('Preencha todos os campos antes de adicionar.');
                                                                        }
                                                                    }

                                                                    function listarParcelas() {
                                                                        $.ajax({
                                                                            url: '<?= base_url("compras/listarParcelas/" . $id); ?>',
                                                                            type: 'GET',
                                                                            success: function (response) {
                                                                                var parcelasHtml = '';

                                                                                response.forEach(function (parcela) {
                                                                                    parcelasHtml += '<tr>';
                                                                                    parcelasHtml += '<td>' + parcela.id + '</td>';
                                                                                    parcelasHtml += '<td>' + formatDateBrazil(parcela.DataParcela) + '</td>';
                                                                                    parcelasHtml += '<td>' + formatCurrency(parcela.ValorParcela) + '</td>';
                                                                                    parcelasHtml += '<td>\n\
                                                                                <a href="#" onclick="return editParcelaCompra(' + parcela.id + ');return false;" class="btn btn-primary"><i class="fas fa-edit"></i></a>\n\
                                                                                <a href="#" onclick="return removeParcelaCompra(' + parcela.id + ');return false;" class="btn btn-danger"><i class="fas fa-trash"></i></a>\n\
                                                                                </td>';
                                                                                    parcelasHtml += '</tr>';
                                                                                });

                                                                                $('#example1 tbody').html(parcelasHtml);
                                                                            },
                                                                            error: function () {
                                                                                alert('Erro ao listar as parcelas');
                                                                            }
                                                                        });
                                                                    }

                                                                    listarParcelas();

                                                                    function editParcelaCompra(id) {
                                                                        // Fazer uma requisição AJAX para buscar os dados do produto pelo ID
                                                                        $.ajax({
                                                                            url: '<?= base_url("compras/getParcelaCompra/"); ?>' + id, // Rota para buscar o produto
                                                                            type: 'GET',
                                                                            success: function (response) {

                                                                                var valorParcelaFormatado = parseFloat(response.ValorParcela).toFixed(2);
                                                                                $('#QtdParcela').attr('disabled',true).val('1');
                                                                                $('#DataParcela').val(formatDateGlobal(response.DataParcela)); // Selecionar o produto
                                                                                $('#DataParcela').attr('dataBrazil', formatDateBrazil(response.DataParcela)); // Selecionar o produto
                                                                                $('#ValorParcela').val(valorParcelaFormatado).focus(); // Selecionar o produto
                          
                                                                                // Trocar o botão de adicionar por um botão de salvar as alterações
                                                                                $('.btn-add').addClass('btn-md').addClass('btn-brilho-reluzente').html('<i class="fas fa-save"></i> Salvar').attr('onclick', 'return updateParcelaCompra(' + response.id + ');');
                                                                            },
                                                                            error: function () {
                                                                                alert('Erro ao buscar a parcela');
                                                                            }
                                                                        });

                                                                        return false;
                                                                    }

                                                                    function updateParcelaCompra(id) {
                                                                        // Pegar os valores dos campos do formulário
                                                                        var qtdParcela = $('#QtdParcela').val();
                                                                        var dataParcela = $('#DataParcela').val();
                                                                        var valorParcela = $('#ValorParcela').val();
                                                                        
                                                                        // Enviar os dados via AJAX para atualizar o produto
                                                                        $.ajax({
                                                                            url: '<?= base_url("compras/updateParcelaCompra/"); ?>' + id,
                                                                            type: 'POST',
                                                                            data: {
                                                                                qtdParcela: qtdParcela,
                                                                                dataParcela: dataParcela,
                                                                                valorParcela: valorParcela
                                                                            },
                                                                            success: function (response) {
                                                                                if (response.status === 'success') {
                                                                                    alert(response.message);
                                                                                    $('#QtdParcela').val('1');  // Limpa o select
                                                                                    $('input[name="DataParcela"]').val('');   // Limpa campo Valor Unitário
                                                                                    $('input[name="ValorParcela"]').val('');      // Limpa campo Quantidade
                                                                                    $('#QtdParcela').removeAttr('disabled');
                                                                                    // Atualiza a lista de produtos (chama novamente a função de listar)
                                                                                    listarParcelas();
                                                                                    // Restaurar o botão para o estado original
                                                                                    $('.btn-add').removeClass('btn-brilho-reluzente').html('<i class="fas fa-plus"></i> Adicionar').attr('onclick', 'return addProduto();');
                                                                                } else {
                                                                                    alert(response.message);
                                                                                }
                                                                            },
                                                                            error: function () {
                                                                                alert('Erro ao atualizar o produto.');
                                                                            }
                                                                        });

                                                                        return false;
                                                                    }

                                                                    function removeParcelaCompra(id) {
                                                                        if (confirm("Tem certeza que deseja remover esta parcela?")) {
                                                                            $.ajax({
                                                                                url: '<?= base_url("compras/removeParcelaCompra/"); ?>' + id,
                                                                                type: 'DELETE',
                                                                                success: function (response) {
                                                                                    if (response.status === 'success') {
                                                                                        alert(response.message);
                                                                                        listarParcelas(); // Recarregar a lista de produtos
                                                                                    } else {
                                                                                        alert(response.message);
                                                                                    }
                                                                                },
                                                                                error: function () {
                                                                                    alert('Erro ao tentar remover a parcela.');
                                                                                }
                                                                            });
                                                                        }
                                                                        return false;
                                                                    }
</script>
<?php echo $this->endSection(); ?> 
