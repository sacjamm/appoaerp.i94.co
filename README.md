# CodeIgniter 4 Framework

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds the distributable version of the framework.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Contributing

We welcome contributions from the community.

Please read the [*Contributing to CodeIgniter*](https://github.com/codeigniter4/CodeIgniter4/blob/develop/CONTRIBUTING.md) section in the development repository.

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> The end of life date for PHP 7.4 was November 28, 2022.
> The end of life date for PHP 8.0 was November 26, 2023.
> If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> The end of life date for PHP 8.1 will be November 25, 2024.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Adicionar campo 'id' na tabela de usuario com auto increment
criar novas tabelas no banco de dados

-- Tabela para armazenar os papéis de usuário
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela para armazenar as permissões
CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    permission_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela intermediária para relacionar papéis com permissões
CREATE TABLE role_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

-- Tabela intermediária para associar usuários aos papéis
CREATE TABLE user_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

criar campo id primary auto_increment na tabela usuarios e criar novos campos:
created_at, updated_at, deleted_at, permissao_id, permissoes
alterar tipodo campo senha para text


tornar campo CodigoEmpresa da tabela empresa auto_increment, e adicionar novos campos:
NumeroEmpresa, ComplementoEmpresa,BairroEmpresa, CidadeEmpresa

tornar campo CodigoCentroCusto da tabela centrodecusto auto_increment

tornar campo CodigoProdutoGrupo da tabela produtogrupo auto_increment

tornar campo CodigoProduto da tabela produto auto_increment

tornar campo CodigoForn da tabela fornecedor auto_increment
criar campos CidadeForn e BairroForn na tabela fornecedor

tornar o campo CodigoAssocForma da tabela assocforma auto_increment

tornar o campo CodigoMotivoCancel da tabela motivocancel auto_increment 

tornar o campo CodigoCompra da tabela compra auto_increment 

tornar o campo CodigoPublicacaoTipo da publicacaotipo motivocancel auto_increment 
e colocar o tipo AssinaturaTipo como definido = 0

tornar o campo CodigoEditora  da tabela editora auto_increment
tornar o campo CodigoAssocTipo  da tabela assoctipo auto_increment


remover chaves primarias da tabela compraproduto e criar um novo campo 'id' auto_increment chave primaria
remover chaves primarias da tabela compraparcela e criar um novo campo 'id' auto_increment chave primaria

roda esse comando para centro de custo: ALTER TABLE `centrocusto` CHANGE `NomeCentroCusto` `NomeCentroCusto` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

tornar campo CodigoAssoc na tabela associado, chave primaria e auto_increment
criar novos campos na tabela associado, BairroAssoc, CidadeAssoc, BairroRemAssoc, CidadeRemAssoc
criar campo id primary auto_increment na tabela de banco
criar tabela permissoes:
CREATE TABLE `permissoes` (
  `idPermissao` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `permissoes` text,
  `situacao` tinyint(1) DEFAULT NULL,
  `data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
