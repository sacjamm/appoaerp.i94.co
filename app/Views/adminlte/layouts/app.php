<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?? 'Admin Panel' ?></title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url(TEMPLATE . '/plugins/fontawesome-free/css/all.min.css'); ?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="<?= base_url(TEMPLATE . '/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); ?>">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= base_url(TEMPLATE . '/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
        <!-- JQVMap -->
        <link rel="stylesheet" href="<?= base_url(TEMPLATE . '/plugins/jqvmap/jqvmap.min.css'); ?>">

        <!-- DataTables -->
        <link rel="stylesheet" href="<?= base_url(TEMPLATE . '/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url(TEMPLATE . '/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url(TEMPLATE . '/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url(TEMPLATE . '/dist/css/adminlte.min.css'); ?>">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="<?= base_url(TEMPLATE . '/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); ?>">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?= base_url(TEMPLATE . '/plugins/daterangepicker/daterangepicker.css'); ?>">
        <!-- summernote -->
        <link rel="stylesheet" href="<?= base_url(TEMPLATE . '/plugins/summernote/summernote-bs4.min.css'); ?>">
        <style>
            /* Efeito de brilho reluzente */
            .btn-brilho-reluzente {
                position: relative;
                display: inline-block;

                background-color: #007bff; /* Cor de fundo do botão */
                color: white;
                border: none;
                border-radius: 5px;
                font-size: 16px;
                cursor: pointer;
                box-shadow: 0 0 20px rgba(0, 123, 255, 0.5); /* Brilho externo inicial */
                overflow: hidden;
                transition: background-color 0.3s, box-shadow 0.3s;
            }

            .btn-brilho-reluzente::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.3), transparent 70%);
                transform: rotate(45deg);
                animation: reluzente 2s infinite linear;
            }

            @keyframes reluzente {
                0% {
                    transform: translateX(-100%) translateY(-100%) rotate(45deg);
                }
                100% {
                    transform: translateX(100%) translateY(100%) rotate(45deg);
                }
            }

            .btn-brilho-reluzente:hover {
                background-color: #0056b3;
                box-shadow: 0 0 30px rgba(0, 123, 255, 0.8);
            }

        </style>
        <!-- jQuery -->
        <script src="<?= base_url(TEMPLATE . '/plugins/jquery/jquery.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/js/jquery.maskMoney.js'); ?>"></script>
        <script>
            $(document).ready(function () {
                $('.valor').maskMoney({
                    thousands: '',
                    decimal: '.'
                });
            });
            function formatDateGlobal(dateString) {
                // Converte o string de data para o formato brasileiro dd/mm/yyyy
                var date = new Date(dateString);
                var day = ("0" + date.getDate()).slice(-2); // Adiciona zero à esquerda
                var month = ("0" + (date.getMonth() + 1)).slice(-2); // Meses começam em 0
                var year = date.getFullYear();

                return year + "-" + month + "-" + day;
            }
            function formatDateBrazil(dateString) {
                // Converte o string de data para o formato brasileiro dd/mm/yyyy
                var date = new Date(dateString);
                var day = ("0" + date.getDate()).slice(-2); // Adiciona zero à esquerda
                var month = ("0" + (date.getMonth() + 1)).slice(-2); // Meses começam em 0
                var year = date.getFullYear();

                return day + "/" + month + "/" + year;
            }
            function formatCurrency(value) {
                return new Intl.NumberFormat('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                }).format(value);
            }

            function mascara_checkout(i, t) {
                let v = i.value.replace(/\D/g, ''); // Remove tudo que não for dígito

                if (t === "cnpj") {
                    i.setAttribute("maxlength", "18"); // Define o limite máximo de caracteres com máscara

                    // Aplica a máscara de CNPJ conforme o número de caracteres digitados
                    if (v.length > 2 && v.length <= 5) {
                        v = v.replace(/(\d{2})(\d+)/, "$1.$2"); // Aplica o primeiro ponto após dois dígitos
                    } else if (v.length > 5 && v.length <= 8) {
                        v = v.replace(/(\d{2})(\d{3})(\d+)/, "$1.$2.$3"); // Aplica o segundo ponto após cinco dígitos
                    } else if (v.length > 8 && v.length <= 12) {
                        v = v.replace(/(\d{2})(\d{3})(\d{3})(\d+)/, "$1.$2.$3/$4"); // Aplica a barra após oito dígitos
                    } else if (v.length > 12) {
                        v = v.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d+)/, "$1.$2.$3/$4-$5"); // Aplica o hífen após doze dígitos
                    }

                    i.value = v; // Atualiza o valor do input com a máscara aplicada
                }

                if (t === "cpf") {
                    i.setAttribute("maxlength", "14");

                    if (v.length > 3 && v.length <= 6) {
                        v = v.replace(/(\d{3})(\d+)/, "$1.$2");
                    } else if (v.length > 6 && v.length <= 9) {
                        v = v.replace(/(\d{3})(\d{3})(\d+)/, "$1.$2.$3");
                    } else if (v.length > 9) {
                        v = v.replace(/(\d{3})(\d{3})(\d{3})(\d+)/, "$1.$2.$3-$4");
                    }

                    i.value = v;
                }

                if (t === "data") {
                    i.setAttribute("maxlength", "10");
                    if (v.length >= 2 && v.length < 4) {
                        v = v.replace(/(\d{2})(\d+)/, "$1/$2");
                    } else if (v.length >= 4) {
                        v = v.replace(/(\d{2})(\d{2})(\d+)/, "$1/$2/$3");
                    }
                    i.value = v;
                }

                if (t === "tel") {
                    if (v.length > 0) {
                        v = v.replace(/(\d{2})(\d{4})(\d*)/, "($1)$2-$3");
                    }
                    i.value = v.substring(0, 13); // Limita a string para o tamanho máximo
                }
                if (t === "cel") {
                    if (v.length > 0) {
                        v = v.replace(/(\d{2})(\d{5})(\d*)/, "($1)$2-$3");
                    }
                    i.value = v.substring(0, 14); // Limita a string para o tamanho máximo
                }
                if (t === "cep") {
                    if (v.length > 0) {
                        v = v.replace(/(\d{5})(\d*)/, "$1-$2");
                    }
                    i.value = v.substring(0, 9); // Limita a string para o tamanho máximo
                }
            }
        </script>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <?php if (SPINNER) { ?>
                <?= $this->include(TEMPLATE . '/layouts/partials/spinner'); ?>
            <?php } ?>
            <!-- Navbar -->
            <?= $this->include(TEMPLATE . '/layouts/partials/menu'); ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <?= $this->include(TEMPLATE . '/layouts/partials/sidebar'); ?>
            <?= $this->renderSection('content'); ?>
            <!-- ./wrapper -->

            <?= $this->include(TEMPLATE . '/layouts/partials/footer'); ?>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>


        <!-- jQuery UI 1.11.4 -->
        <script src="<?= base_url(TEMPLATE . '/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="<?= base_url(TEMPLATE . '/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
        <!-- ChartJS -->
        <script src="<?= base_url(TEMPLATE . '/plugins/chart.js/Chart.min.js'); ?>"></script>
        <!-- Sparkline -->
        <script src="<?= base_url(TEMPLATE . '/plugins/sparklines/sparkline.js'); ?>"></script>
        <!-- JQVMap -->
        <script src="<?= base_url(TEMPLATE . '/plugins/jqvmap/jquery.vmap.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/jqvmap/maps/jquery.vmap.usa.js'); ?>"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?= base_url(TEMPLATE . '/plugins/jquery-knob/jquery.knob.min.js'); ?>"></script>
        <!-- daterangepicker -->
        <script src="<?= base_url(TEMPLATE . '/plugins/moment/moment.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="<?= base_url(TEMPLATE . '/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); ?>"></script>
        <!-- Summernote -->
        <script src="<?= base_url(TEMPLATE . '/plugins/summernote/summernote-bs4.min.js'); ?>"></script>
        <!-- overlayScrollbars -->
        <script src="<?= base_url(TEMPLATE . '/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>
        <!-- DataTables  & Plugins -->
        <script src="<?= base_url(TEMPLATE . '/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/jszip/jszip.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/pdfmake/pdfmake.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/pdfmake/vfs_fonts.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
        <script src="<?= base_url(TEMPLATE . '/plugins/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?= base_url(TEMPLATE . '/dist/js/adminlte.js'); ?>"></script> 
        <script>

            $(document).ready(function () {
                setTimeout(function () {
                    $('#message').html('');
                }, 5000);
                $("#example1").DataTable({
                    "order": [[0, 'desc']], "ordering": true,
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

                function limpa_formulário_cep() {
                    // Limpa valores do formulário de cep.
                    $(".rua").val("");
                    $(".bairro").val("");
                    $(".cidade").val("");
                }
                function limpa_formulário_cepC() {
                    // Limpa valores do formulário de cep.
                    $(".ruaC").val("");
                    $(".bairroC").val("");
                    $(".cidadeC").val("");
                }

                //Quando o campo cep perde o foco.
                $(".cep").blur(function () {

                    //Nova variável "cep" somente com dígitos.
                    var cep = $(this).val().replace(/\D/g, '');

                    //Verifica se campo cep possui valor informado.
                    if (cep != "") {

                        //Expressão regular para validar o CEP.
                        var validacep = /^[0-9]{8}$/;

                        //Valida o formato do CEP.
                        if (validacep.test(cep)) {

                            //Preenche os campos com "..." enquanto consulta webservice.
                            $(".rua").val("...");
                            $(".bairro").val("...");
                            $(".cidade").val("...");
                            $(".uf").val("...");

                            //Consulta o webservice viacep.com.br/
                            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                                if (!("erro" in dados)) {
                                    //Atualiza os campos com os valores da consulta.
                                    $(".rua").val(dados.logradouro);
                                    $(".bairro").val(dados.bairro);
                                    $(".cidade").val(dados.localidade);
                                    $(".uf").val(dados.uf);
                                } //end if.
                                else {
                                    //CEP pesquisado não foi encontrado.
                                    limpa_formulário_cep();

                                    $('#message').html('<div class="alert alert-danger">CEP não encontrado.</div>');
                                    // Remove the alert after 3 seconds
                                    setTimeout(function () {
                                        $('#message').html('');
                                    }, 5000);
                                }
                            });
                        } //end if.
                        else {
                            //cep é inválido.
                            limpa_formulário_cep();
                            $('#message').html('<div class="alert alert-danger">Formato de CEP inválido.</div>');
                            // Remove the alert after 3 seconds
                            setTimeout(function () {
                                $('#message').html('');
                            }, 5000);
                        }
                    } //end if.
                    else {
                        //cep sem valor, limpa formulário.
                        limpa_formulário_cep();
                    }
                });

                $(".cepC").blur(function () {

                    //Nova variável "cep" somente com dígitos.
                    var cep = $(this).val().replace(/\D/g, '');

                    //Verifica se campo cep possui valor informado.
                    if (cep != "") {

                        //Expressão regular para validar o CEP.
                        var validacep = /^[0-9]{8}$/;

                        //Valida o formato do CEP.
                        if (validacep.test(cep)) {

                            //Preenche os campos com "..." enquanto consulta webservice.
                            $(".ruaC").val("...");
                            $(".bairroC").val("...");
                            $(".cidadeC").val("...");

                            //Consulta o webservice viacep.com.br/
                            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                                if (!("erro" in dados)) {
                                    //Atualiza os campos com os valores da consulta.
                                    $(".ruaC").val(dados.logradouro);
                                    $(".bairroC").val(dados.bairro);
                                    $(".cidadeC").val(dados.localidade);
                                } //end if.
                                else {
                                    //CEP pesquisado não foi encontrado.
                                    limpa_formulário_cepC();

                                    $('#message').html('<div class="alert alert-danger">CEP não encontrado.</div>');
                                    // Remove the alert after 3 seconds
                                    setTimeout(function () {
                                        $('#message').html('');
                                    }, 5000);
                                }
                            });
                        } //end if.
                        else {
                            //cep é inválido.
                            limpa_formulário_cepC();
                            $('#message').html('<div class="alert alert-danger">Formato de CEP inválido.</div>');
                            // Remove the alert after 3 seconds
                            setTimeout(function () {
                                $('#message').html('');
                            }, 5000);
                        }
                    } //end if.
                    else {
                        //cep sem valor, limpa formulário.
                        limpa_formulário_cepC();
                    }
                });
            });
        </script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    </body>
</html>
