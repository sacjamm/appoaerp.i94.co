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
                    <h1>Produtos da compra #<?= $compra['CodigoCompra']; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right"> 
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('compras'); ?>">Compras</a></li>
                        <li class="breadcrumb-item active">Adicionar/Editar produto compra</li>
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
                                Adicionar/Editar produto compra</h3>
                            <div class="card-tools">
                                <a href="<?= base_url('compras/edit/' . $id); ?>" class="btn btn-tool btn-warning"> 
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="javascript:;" class="btn btn-tool btn-success active" disabled style="color: white;">
                                    <i class="fas fa-shopping-cart"></i> Produtos
                                </a>
                                <a href="<?= base_url('compras/parcelas/' . $id); ?>" class="btn btn-tool btn-default" style="color: #888;">
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
                        <form action="<?php echo base_url(); ?>compras/produtos/<?= $id; ?>" id="formCompra" method="post">
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
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <select name="Produtos" id="Produtos" class="form-control select2">
                                                                    <option value="" selected disabled>Selecione o produto</option>
                                                                    <?php
                                                                    if ($produtos) {
                                                                        foreach ($produtos as $produto) {
                                                                            ?>
                                                                            <option value="<?= $produto['CodigoProduto']; ?>"><?= $produto['DescricaoProduto']; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input name="ValorUnitario" type="tel" class="form-control valor" placeholder="Valor Unitário" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input name="Quantidade" type="number" class="form-control" placeholder="Quantidade" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input name="ValorCompra" type="tel" class="form-control valor" placeholder="Valor da compra" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <button type="button" onclick="return addProduto();return false;" class="btn btn-primary btn-block btn-add"><i class="fas fa-plus"></i> Adicionar</button>
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
                                Listar produtos da compra</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body"> 
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="example1">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th>Quantidade</th>
                                            <th>Valor Unitário</th>
                                            <th>Valor Total</th>
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

                                                                    function addProduto() {
                                                                        var formData = $('#formCompra').serialize();

                                                                        $.ajax({
                                                                            url: '<?= base_url("compras/addProduto/" . $id); ?>', // URL do controller
                                                                            type: 'POST',
                                                                            data: formData,
                                                                            success: function (response) {
                                                                                if (response.success) {
                                                                                    alert(response.message);
                                                                                    listarProdutos(); // Atualiza a lista após adicionar
                                                                                } else {
                                                                                    alert(response.message);
                                                                                }
                                                                            },
                                                                            error: function () {
                                                                                alert('Erro ao adicionar o produto');
                                                                            }
                                                                        });
                                                                    }

                                                                    function listarProdutos() {
                                                                        $.ajax({
                                                                            url: '<?= base_url("compras/listarProdutos/" . $id); ?>',
                                                                            type: 'GET',
                                                                            success: function (response) {
                                                                                var produtosHtml = '';

                                                                                response.forEach(function (produto) {
                                                                                    produtosHtml += '<tr>';
                                                                                    produtosHtml += '<td>' + produto.DescricaoProduto + '</td>';
                                                                                    produtosHtml += '<td>' + produto.Quantidade + '</td>';
                                                                                    produtosHtml += '<td>' + formatCurrency(produto.ValorUnitario) + '</td>';
                                                                                    produtosHtml += '<td>' + formatCurrency(produto.ValorTotal) + '</td>';
                                                                                    produtosHtml += '<td>\n\
                                                                                <a href="#" onclick="return editProdutoCompra(' + produto.id + ');return false;" class="btn btn-primary"><i class="fas fa-edit"></i></a>\n\
                                                                                <a href="#" onclick="return removeProdutoCompra(' + produto.id + ');return false;" class="btn btn-danger"><i class="fas fa-trash"></i></a>\n\
                                                                                </td>';
                                                                                    produtosHtml += '</tr>';
                                                                                });

                                                                                $('#example1 tbody').html(produtosHtml);
                                                                            },
                                                                            error: function () {
                                                                                alert('Erro ao listar os produtos');
                                                                            }
                                                                        });
                                                                    }

                                                                    listarProdutos();

                                                                    function editProdutoCompra(id) {
                                                                        // Fazer uma requisição AJAX para buscar os dados do produto pelo ID
                                                                        $.ajax({
                                                                            url: '<?= base_url("compras/getProdutoCompra/"); ?>' + id, // Rota para buscar o produto
                                                                            type: 'GET',
                                                                            success: function (response) {

                                                                                var valorUnitarioFormatado = parseFloat(response.ValorUnitario).toFixed(2);
                                                                                var valorTotalFormatado = parseFloat(response.ValorTotal).toFixed(2);
                                                                                // Preencher os campos do formulário com os dados recebidos
                                                                                $('#Produtos').val(response.CodigoProduto).trigger('change'); // Selecionar o produto
                                                                                $('input[name="ValorUnitario"]').val(valorUnitarioFormatado).focus(); // Preencher valor unitário
                                                                                $('input[name="Quantidade"]').val(response.Quantidade); // Preencher quantidade
                                                                                $('input[name="ValorCompra"]').val(valorTotalFormatado); // Preencher valor total

                                                                                // Trocar o botão de adicionar por um botão de salvar as alterações
                                                                                $('.btn-add').addClass('btn-md').addClass('btn-brilho-reluzente').html('<i class="fas fa-save"></i> Salvar').attr('onclick', 'return updateProdutoCompra(' + id + ');');
                                                                            },
                                                                            error: function () {
                                                                                alert('Erro ao buscar o produto');
                                                                            }
                                                                        });

                                                                        return false;
                                                                    }

                                                                    function updateProdutoCompra(id) {
                                                                        // Pegar os valores dos campos do formulário
                                                                        var produtoId = $('#Produtos').val();
                                                                        var valorUnitario = $('input[name="ValorUnitario"]').val();
                                                                        var quantidade = $('input[name="Quantidade"]').val();
                                                                        var valorCompra = $('input[name="ValorCompra"]').val();

                                                                        // Enviar os dados via AJAX para atualizar o produto
                                                                        $.ajax({
                                                                            url: '<?= base_url("compras/updateProdutoCompra/"); ?>' + id,
                                                                            type: 'POST',
                                                                            data: {
                                                                                CodigoProduto: produtoId,
                                                                                ValorUnitario: valorUnitario,
                                                                                Quantidade: quantidade,
                                                                                ValorTotal: valorCompra
                                                                            },
                                                                            success: function (response) {
                                                                                if (response.status === 'success') {
                                                                                    alert(response.message);
                                                                                    $('#Produtos').val('').trigger('change');  // Limpa o select
                                                                                    $('input[name="ValorUnitario"]').val('');   // Limpa campo Valor Unitário
                                                                                    $('input[name="Quantidade"]').val('');      // Limpa campo Quantidade
                                                                                    $('input[name="ValorCompra"]').val('');     // Limpa campo Valor Compra

                                                                                    // Atualiza a lista de produtos (chama novamente a função de listar)
                                                                                    listarProdutos();
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

                                                                    function removeProdutoCompra(id) {
                                                                        if (confirm("Tem certeza que deseja remover este produto?")) {
                                                                            $.ajax({
                                                                                url: '<?= base_url("compras/removeProdutoCompra/"); ?>' + id,
                                                                                type: 'DELETE',
                                                                                success: function (response) {
                                                                                    if (response.status === 'success') {
                                                                                        alert(response.message);
                                                                                        listarProdutos(); // Recarregar a lista de produtos
                                                                                    } else {
                                                                                        alert(response.message);
                                                                                    }
                                                                                },
                                                                                error: function () {
                                                                                    alert('Erro ao tentar remover o produto.');
                                                                                }
                                                                            });
                                                                        }
                                                                        return false;
                                                                    }
</script>
<?php echo $this->endSection(); ?>
