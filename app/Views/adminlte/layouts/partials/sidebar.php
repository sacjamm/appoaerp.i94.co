<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url(); ?>" class="brand-link">
        <img src="<?= base_url(TEMPLATE . '/dist/img/AdminLTELogo.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">APPOA ERP</span>
    </a> 
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url(TEMPLATE . '/dist/img/user2-160x160.jpg'); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= session()->get('usuario'); ?> - <?= session()->get('NivelUsuario'); ?></a> 
            </div>
        </div>
        <?php $current_url = uri_string(); ?>
        <?php $user_permissions = permissionSerialized(session()->get('user_permissions')) ?? []; ?>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Captura a URI atual -->
                <li class="nav-item">
                    <a href="<?= base_url(); ?>" class="nav-link <?= ($current_url == '' || $current_url == 'dashboard') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-user-circle"></i>
                        <p>
                            Associados
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                     <?php if (is_array($user_permissions) && array_key_exists('sAssociado', $user_permissions) && $user_permissions['sAssociado'] == "1") { ?>
                    <li class="nav-item">
                        <a href="<?= site_url('associados/index') ?>" class="nav-link <?= ($current_url == 'associados/index') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                            <i class="fas fa-users nav-icon" style="font-size: 13px;"></i>
                            <p>Listar Associados</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('associados/tipos') ?>" class="nav-link <?= ($current_url == 'associados/tipos') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                            <i class="fas fa-users-cog nav-icon" style="font-size: 13px;"></i>
                            <p>Tipos de Associados</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('associados/renegociacoes') ?>" class="nav-link <?= ($current_url == 'associados/renegociacoes') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                            <i class="fas fa-credit-card nav-icon" style="font-size: 13px;"></i>
                            <p>Renegociação</p>
                        </a>
                    </li>
                <?php } ?>
                     
                    </ul>
                </li>
                
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-plus-circle"></i>
                        <p>
                            Cadastros
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if (is_array($user_permissions) && array_key_exists('sBanco', $user_permissions) && $user_permissions['sBanco'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('bancos/index') ?>" class="nav-link <?= ($current_url == 'bancos/index') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                                    <i class="nav-icon fas fa-university" style="font-size: 13px;"></i>
                                    <p>Bancos</p>
                                </a>  
                            </li>
                        <?php } ?>
                        <?php if (is_array($user_permissions) && array_key_exists('sCentrodecusto', $user_permissions) && $user_permissions['sCentrodecusto'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('centrodecustos/index') ?>" class="nav-link <?= ($current_url == 'centrodecustos/index') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                                    <i class="nav-icon fas fa-plus" style="font-size: 13px;"></i>
                                    <p>Centro de custos</p>  
                                </a>  
                            </li>
                        <?php } ?>
                        <?php if (is_array($user_permissions) && array_key_exists('sEmpresa', $user_permissions) && $user_permissions['sEmpresa'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('empresas/index') ?>" class="nav-link <?= ($current_url == 'empresas/index') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                                    <i class="nav-icon fas fa-university" style="font-size: 13px;"></i>
                                    <p>Empresas</p>
                                </a>  
                            </li>
                        <?php } ?>
                        <?php if (is_array($user_permissions) && array_key_exists('sProduto', $user_permissions) && $user_permissions['sProduto'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('produtos/index') ?>" class="nav-link <?= $active_produtos = (strpos($current_url, 'produtos/index') !== false) ? 'active' : ''; ?>" style="margin-left: 7px;font-size: 14px;">
                                    <i class="nav-icon fas fa-cart-plus" style="font-size: 13px;"></i>
                                    <p>Produtos</p>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (is_array($user_permissions) && array_key_exists('sGrupodeproduto', $user_permissions) && $user_permissions['sGrupodeproduto'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('grupoprodutos/index') ?>" class="nav-link <?= $active_grupoprodutos = (strpos($current_url, 'grupoprodutos/index') !== false) ? 'active' : ''; ?>" style="margin-left: 7px;font-size: 14px;">
                                    <i class="fas fa-layer-group nav-icon" style="font-size: 13px;"></i>
                                    <p>Grupo de produtos</p>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (is_array($user_permissions) && array_key_exists('sFornecedor', $user_permissions) && $user_permissions['sFornecedor'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('fornecedores/index') ?>" class="nav-link <?= ($current_url == 'fornecedores/index') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                                    <i class="nav-icon fas fa-university" style="font-size: 13px;"></i>
                                    <p>Fornecedores</p>
                                </a>  
                            </li>
                        <?php } ?>
                        <?php if (is_array($user_permissions) && array_key_exists('sFormaassociacao', $user_permissions) && $user_permissions['sFormaassociacao'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('formasassociacao/index') ?>" class="nav-link <?= ($current_url == 'formasassociacao/index') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                                    <i class="nav-icon fas fa-cart-plus" style="font-size: 13px;"></i>
                                    <p>Formas de associação</p>
                                </a>  
                            </li>
                        <?php } ?>
                        <?php if (is_array($user_permissions) && array_key_exists('sCancelamento', $user_permissions) && $user_permissions['sCancelamento'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('cancelamentos/index') ?>" class="nav-link <?= ($current_url == 'cancelamentos/index') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                                    <i class="nav-icon fas fa-stop" style="font-size: 13px;"></i>
                                    <p>Motivos de cancelamento</p>
                                </a>  
                            </li>
                        <?php } ?>
                        <?php if (is_array($user_permissions) && array_key_exists('sEditora', $user_permissions) && $user_permissions['sEditora'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('editoras/index') ?>" class="nav-link <?= ($current_url == 'editoras/index') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                                    <i class="nav-icon fas fa-stop" style="font-size: 13px;"></i>
                                    <p>Editoras</p>
                                </a>  
                            </li>
                        <?php } ?>
                        <?php if (is_array($user_permissions) && array_key_exists('sTipopublicacao', $user_permissions) && $user_permissions['sTipopublicacao'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('tipopublicacao/index') ?>" class="nav-link <?= ($current_url == 'tipopublicacao/index') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                                    <i class="nav-icon fas fa-stop" style="font-size: 13px;"></i>
                                    <p>Tipo de publicação</p>
                                </a>  
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                
                 <?php if (is_array($user_permissions) && array_key_exists('sCompra', $user_permissions) && $user_permissions['sCompra'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('compras/index') ?>" class="nav-link <?= $active_produtos = (strpos($current_url, 'compras/index') !== false) ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>Compras</p>
                                </a>
                            </li>
                        <?php } ?>

                <li class="nav-item has-treeview <?php //echo (strpos($current_url, 'cadastros') !== false) ? 'menu-open' : ''    ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Usuários
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if (is_array($user_permissions) && array_key_exists('sPermissao', $user_permissions) && $user_permissions['sPermissao'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('permissions/index') ?>" class="nav-link <?= ($current_url == 'permissions/index') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                                    <i class="fas fa-lock nav-icon" style="font-size: 13px;"></i>
                                    <p>Níveis de usuários</p>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (is_array($user_permissions) && array_key_exists('sUsuario', $user_permissions) && $user_permissions['sUsuario'] == "1") { ?>
                            <li class="nav-item">
                                <a href="<?= site_url('usuarios/index') ?>" class="nav-link <?= ($current_url == 'usuarios/index') ? 'active' : '' ?>" style="margin-left: 7px;font-size: 14px;">
                                    <i class="fas fa-users nav-icon" style="font-size: 13px;"></i>
                                    <p>Usuários</p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('auth/logout') ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Sair</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
