<?php 

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

//auth
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/login', 'Auth::loginAuth');

$routes->get('/auth/forgot', 'Auth::forgot');
$routes->post('/auth/forgot', 'Auth::forgotAuth');

$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::registerAuth'); 

//dashboard
$routes->get('/', 'Auth::login');
//$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/dashboard/(:any)/(:any)', 'Dashboard::index/$1/$2');

//$routes->get('/add-column', 'DatabaseController::addColumn');
 
//associados
$routes->get('/associados', 'Associados::index'); 
$routes->get('/associados/index', 'Associados::index');

$routes->get('/associados/edit/(:num)', 'Associados::edit/$1');
$routes->post('/associados/edit/(:num)', 'Associados::edit/$1');
$routes->get('/associados/create', 'Associados::create');
$routes->post('/associados/create', 'Associados::create');
$routes->get('/associados/getData', 'Associados::getData');
$routes->post('/associados/getData', 'Associados::getData');
$routes->post('/associados/delete', 'Associados::delete');

$routes->get('/associados/getTableData', 'Associados::getTableData');
$routes->post('/associados/getTableData', 'Associados::getTableData');

$routes->get('/associados/acompanhamentos/(:num)', 'Associados::acompanhamentos/$1');
$routes->post('/associados/acompanhamentos/(:num)', 'Associados::acompanhamentos/$1');

$routes->get('/associados/create_acompanhamento/(:num)', 'Associados::create_acompanhamento/$1');
$routes->post('/associados/create_acompanhamento/(:num)?', 'Associados::create_acompanhamento/$1');

$routes->get('/associados/edit_acompanhamento/(:num)/(:num)', 'Associados::edit_acompanhamento/$1/$2');
$routes->post('/associados/edit_acompanhamento/(:num)/(:num)', 'Associados::edit_acompanhamento/$1/$2');

$routes->post('/associados/delete_acompanhamento', 'Associados::delete_acompanhamento');

//tipos de associados 
  
$routes->get('/associados/tipos', 'Associados::tiposAssociados');
$routes->get('/associados/getTableDataTiposAssociado', 'Associados::getTableDataTiposAssociado');
$routes->post('/associados/getTableDataTiposAssociado', 'Associados::getTableDataTiposAssociado');
$routes->get('/associados/edit_tipo/(:num)', 'Associados::edit_tipos/$1');
$routes->post('/associados/edit_tipo/(:num)', 'Associados::edit_tipos/$1');
$routes->get('/associados/create_tipo', 'Associados::create_tipos');
$routes->post('/associados/create_tipo', 'Associados::create_tipos');
$routes->get('/associados/delete_tipo', 'Associados::delete_tipo');
$routes->post('/associados/delete_tipo', 'Associados::delete_tipo');

//renegociação

$routes->get('/associados/renegociacoes', 'Associados::renegociacoes');
$routes->get('/associados/getTableDataRenegociacao', 'Associados::getTableDataRenegociacao');
$routes->post('/associados/getTableDataRenegociacao', 'Associados::getTableDataRenegociacao');
$routes->get('/associados/edit_renegociacao/(:num)', 'Associados::edit_renegociacao/$1');
$routes->post('/associados/edit_renegociacao/(:num)', 'Associados::edit_renegociacao/$1');
$routes->get('/associados/create_renegociacao', 'Associados::create_renegociacao');
$routes->post('/associados/create_renegociacao', 'Associados::create_renegociacao');
$routes->get('/associados/delete_renegociacao', 'Associados::delete_renegociacao');
$routes->post('/associados/delete_renegociacao', 'Associados::delete_renegociacao');

//usuarios
$routes->get('/usuarios', 'Users::index'); 
$routes->get('/usuarios/index', 'Users::index');
$routes->get('/usuarios/edit/(:num)', 'Users::edit/$1');
$routes->post('/usuarios/edit/(:num)', 'Users::edit/$1');
$routes->get('/usuarios/create', 'Users::create');
$routes->post('/usuarios/create', 'Users::create');
$routes->post('/usuarios/delete', 'Users::delete');

$routes->get('/usuarios/getTableData', 'Users::getTableData');
$routes->post('/usuarios/getTableData', 'Users::getTableData');

//usuarios
$routes->get('/permissions', 'Permissions::index'); 
$routes->get('/permissions/index', 'Permissions::index');
$routes->get('/permissions/edit/(:num)', 'Permissions::edit/$1');
$routes->post('/permissions/edit/(:num)', 'Permissions::edit/$1');
$routes->post('/permissions/create', 'Permissions::create');
$routes->get('/permissions/create', 'Permissions::create');
$routes->post('/permissions/delete', 'Permissions::delete');

$routes->get('/permissions/getTableData', 'Permissions::getTableData');
$routes->post('/permissions/getTableData', 'Permissions::getTableData');

//usuarios
$routes->get('/bancos', 'Bancos::index'); 
$routes->get('/bancos/index', 'Bancos::index');
$routes->get('/bancos/edit/(:num)', 'Bancos::edit/$1');
$routes->post('/bancos/edit/(:num)', 'Bancos::edit/$1');
$routes->post('/bancos/create', 'Bancos::create');
$routes->get('/bancos/create', 'Bancos::create');
$routes->post('/bancos/delete', 'Bancos::delete');

$routes->get('/bancos/getTableData', 'Bancos::getTableData');
$routes->post('/bancos/getTableData', 'Bancos::getTableData');

//empresas
$routes->get('/empresas', 'Empresas::index'); 
$routes->get('/empresas/index', 'Empresas::index');
$routes->get('/empresas/edit/(:num)', 'Empresas::edit/$1');
$routes->post('/empresas/edit/(:num)', 'Empresas::edit/$1');
$routes->post('/empresas/create', 'Empresas::create');
$routes->get('/empresas/create', 'Empresas::create');
$routes->post('/empresas/delete', 'Empresas::delete');
$routes->post('/empresas/getData', 'Empresas::getData');
$routes->post('/empresas/delete', 'Empresas::delete');

$routes->get('/empresas/getTableData', 'Empresas::getTableData');
$routes->post('/empresas/getTableData', 'Empresas::getTableData');

//fornecedores
$routes->get('/fornecedores', 'Fornecedores::index'); 
$routes->get('/fornecedores/index', 'Fornecedores::index');
$routes->get('/fornecedores/edit/(:num)', 'Fornecedores::edit/$1');
$routes->post('/fornecedores/edit/(:num)', 'Fornecedores::edit/$1');
$routes->post('/fornecedores/create', 'Fornecedores::create');
$routes->get('/fornecedores/create', 'Fornecedores::create');
$routes->post('/fornecedores/delete', 'Fornecedores::delete');
$routes->post('/fornecedores/getData', 'Fornecedores::getData');
$routes->post('/fornecedores/delete', 'Fornecedores::delete');

$routes->get('/fornecedores/getTableData', 'Fornecedores::getTableData');
$routes->post('/fornecedores/getTableData', 'Fornecedores::getTableData');

//usuarios
$routes->get('/centrodecustos', 'Centrodecustos::index'); 
$routes->get('/centrodecustos/index', 'Centrodecustos::index');
$routes->get('/centrodecustos/edit/(:num)', 'Centrodecustos::edit/$1');
$routes->post('/centrodecustos/edit/(:num)', 'Centrodecustos::edit/$1');
$routes->post('/centrodecustos/create', 'Centrodecustos::create');
$routes->get('/centrodecustos/create', 'Centrodecustos::create');
$routes->post('/centrodecustos/delete', 'Centrodecustos::delete');

$routes->get('/centrodecustos/getTableData', 'Centrodecustos::getTableData');
$routes->post('/centrodecustos/getTableData', 'Centrodecustos::getTableData');

//grupo de produtos
$routes->get('/grupoprodutos', 'Grupoprodutos::index'); 
$routes->get('/grupoprodutos/index', 'Grupoprodutos::index');
$routes->get('/grupoprodutos/edit/(:num)', 'Grupoprodutos::edit/$1');
$routes->post('/grupoprodutos/edit/(:num)', 'Grupoprodutos::edit/$1');
$routes->post('/grupoprodutos/create', 'Grupoprodutos::create');
$routes->get('/grupoprodutos/create', 'Grupoprodutos::create');
$routes->post('/grupoprodutos/delete', 'Grupoprodutos::delete');

$routes->get('/grupoprodutos/getTableData', 'Grupoprodutos::getTableData');
$routes->post('/grupoprodutos/getTableData', 'Grupoprodutos::getTableData');

//Produtos
$routes->get('/produtos', 'Produtos::index'); 
$routes->get('/produtos/index', 'Produtos::index');
$routes->get('/produtos/edit/(:num)', 'Produtos::edit/$1');
$routes->post('/produtos/edit/(:num)', 'Produtos::edit/$1');
$routes->post('/produtos/create', 'Produtos::create');
$routes->get('/produtos/create', 'Produtos::create');
$routes->post('/produtos/delete', 'Produtos::delete');

$routes->get('/produtos/getTableData', 'Produtos::getTableData');
$routes->post('/produtos/getTableData', 'Produtos::getTableData');

//Formas de assoiação
$routes->get('/formasassociacao', 'Formasassociacao::index'); 
$routes->get('/formasassociacao/index', 'Formasassociacao::index');
$routes->get('/formasassociacao/edit/(:num)', 'Formasassociacao::edit/$1');
$routes->post('/formasassociacao/edit/(:num)', 'Formasassociacao::edit/$1');
$routes->post('/formasassociacao/create', 'Formasassociacao::create');
$routes->get('/formasassociacao/create', 'Formasassociacao::create');
$routes->post('/formasassociacao/delete', 'Formasassociacao::delete');

$routes->get('/formasassociacao/getTableData', 'Formasassociacao::getTableData');
$routes->post('/formasassociacao/getTableData', 'Formasassociacao::getTableData');

//cancelamentos
$routes->get('/cancelamentos', 'Motivocancelamentos::index'); 
$routes->get('/cancelamentos/index', 'Motivocancelamentos::index');
$routes->get('/cancelamentos/edit/(:num)', 'Motivocancelamentos::edit/$1');
$routes->post('/cancelamentos/edit/(:num)', 'Motivocancelamentos::edit/$1');
$routes->post('/cancelamentos/create', 'Motivocancelamentos::create');
$routes->get('/cancelamentos/create', 'Motivocancelamentos::create');
$routes->post('/cancelamentos/delete', 'Motivocancelamentos::delete');

$routes->get('/cancelamentos/getTableData', 'Motivocancelamentos::getTableData');
$routes->post('/cancelamentos/getTableData', 'Motivocancelamentos::getTableData');

//editoras
$routes->get('/editoras', 'Editoras::index'); 
$routes->get('/editoras/index', 'Editoras::index');
$routes->get('/editoras/edit/(:num)', 'Editoras::edit/$1');
$routes->post('/editoras/edit/(:num)', 'Editoras::edit/$1');
$routes->post('/editoras/create', 'Editoras::create');
$routes->get('/editoras/create', 'Editoras::create');
$routes->post('/editoras/delete', 'Editoras::delete');

$routes->get('/editoras/getTableData', 'Editoras::getTableData');
$routes->post('/editoras/getTableData', 'Editoras::getTableData');

//tipos de publicação
$routes->get('/tipopublicacao', 'Tipopublicacoes::index'); 
$routes->get('/tipopublicacao/index', 'Tipopublicacoes::index');
$routes->get('/tipopublicacao/edit/(:num)', 'Tipopublicacoes::edit/$1');
$routes->post('/tipopublicacao/edit/(:num)', 'Tipopublicacoes::edit/$1');
$routes->post('/tipopublicacao/create', 'Tipopublicacoes::create');
$routes->get('/tipopublicacao/create', 'Tipopublicacoes::create');
$routes->post('/tipopublicacao/delete', 'Tipopublicacoes::delete');

$routes->get('/tipopublicacao/getTableData', 'Tipopublicacoes::getTableData');
$routes->post('/tipopublicacao/getTableData', 'Tipopublicacoes::getTableData');

//compras
$routes->get('/compras', 'Compras::index'); 
$routes->get('/compras/index', 'Compras::index');
$routes->get('/compras/edit/(:num)', 'Compras::edit/$1');
$routes->post('/compras/edit/(:num)', 'Compras::edit/$1');

$routes->get('/compras/produtos/(:num)', 'Compras::produtos/$1');
$routes->post('/compras/produtos/(:num)', 'Compras::produtos/$1');
 
$routes->get('/compras/addProduto/(:num)', 'Compras::addProdutoCompra/$1');
$routes->post('/compras/addProduto/(:num)', 'Compras::addProdutoCompra/$1');
 
$routes->get('/compras/listarProdutos/(:num)', 'Compras::listarProdutos/$1');
$routes->post('/compras/listarProdutos/(:num)', 'Compras::listarProdutos/$1');

$routes->delete('compras/removeProdutoCompra/(:num)', 'Compras::removeProdutoCompra/$1');

$routes->post('compras/getProdutoCompra/(:num)', 'Compras::getProdutoCompra/$1');
$routes->get('compras/getProdutoCompra/(:num)', 'Compras::getProdutoCompra/$1');

$routes->post('compras/updateProdutoCompra/(:num)', 'Compras::updateProdutoCompra/$1');
$routes->get('compras/updateProdutoCompra/(:num)', 'Compras::updateProdutoCompra/$1');

$routes->get('/compras/parcelas/(:num)', 'Compras::parcelas/$1');
$routes->post('/compras/parcelas/(:num)', 'Compras::parcelas/$1');

$routes->get('/compras/addParcela/(:num)', 'Compras::addParcelaCompra/$1');
$routes->post('/compras/addParcela/(:num)', 'Compras::addParcelaCompra/$1');
 
$routes->get('/compras/listarParcelas/(:num)', 'Compras::listarParcelas/$1');
$routes->post('/compras/listarParcelas/(:num)', 'Compras::listarParcelas/$1');

$routes->delete('compras/removeParcelaCompra/(:num)', 'Compras::removeParcelaCompra/$1');

$routes->post('compras/getParcelaCompra/(:num)', 'Compras::getParcelaCompra/$1');
$routes->get('compras/getParcelaCompra/(:num)', 'Compras::getParcelaCompra/$1');

$routes->post('compras/updateParcelaCompra/(:num)', 'Compras::updateParcelaCompra/$1');
$routes->get('compras/updateParcelaCompra/(:num)', 'Compras::updateParcelaCompra/$1');

$routes->post('/compras/create', 'Compras::create');
$routes->get('/compras/create', 'Compras::create');
$routes->post('/compras/delete', 'Compras::delete');

$routes->get('/compras/getData', 'Compras::getData');
$routes->post('/compras/getData', 'Compras::getData');

//emissao de boletos
$routes->post('emitir-boleto', 'Boletos::emitir');
$routes->get('emitir-boleto', 'Boletos::emitir');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('associados', 'Associados::index');
    $routes->get('usuarios', 'Users::index');
    $routes->get('permissions', 'Permissions::index');
    $routes->get('bancos', 'Bancos::index');
    $routes->get('empresas', 'Empresas::index');
    $routes->get('centrodecustos', 'Centrodecustos::index');
    $routes->get('grupoprodutos', 'Grupoprodutos::index');
    $routes->get('produtos', 'Produtos::index'); 
    $routes->get('fornecedores', 'Fornecedores::index');
    $routes->get('formasassociacao', 'Formasassociacao::index');
    $routes->get('cancelamentos', 'Cancelamentos::index');
    $routes->get('compras', 'Compras::index');
    // Outras rotas protegidas...
});
 