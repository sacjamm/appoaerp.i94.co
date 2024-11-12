<?php

if (!function_exists('hasPermission')) {

    function hasPermissionss($userPermissions, $requiredPermission) {
       
        $permissions = unserialize($userPermissions); // Deserializa as permissões armazenadas

        return isset($permissions[$requiredPermission]) && $permissions[$requiredPermission] == true;
    }

    function hasPermission($permissions, $requiredPermission) {
        // Verifica se permissões são uma string serializada
        
        if (is_string($permissions)) {
            $permissions = unserialize($permissions);
        }
        return isset($permissions[$requiredPermission]) && $permissions[$requiredPermission] == true;
        // Checa se permissões estão como array e se contém a permissão requerida
        //return is_array($permissions) && in_array($requiredPermission, $permissions);
    }

}
if (!function_exists('permissionSerialized')) {

    function permissionSerialized($userPermissions) {
        $permissions = unserialize($userPermissions); // Deserializa as permissões armazenadas
        return $permissions;
    }

}

if (!function_exists('is_admin')) {

    function is_admin() {
        $tipoUsuario = session()->get('nivel');
        return ($tipoUsuario === 'A');
    }

}

if (!function_exists('is_user')) {

    function is_user() {
        $tipoUsuario = session()->get('nivel');
        return ($tipoUsuario === 'U');
    }

}

function mask($val, $mask) {
    $maskared = '';
    $k = 0;
    for ($i = 0;
            $i <= strlen($mask) - 1;
            $i++) {
        if ($mask[$i] == '#') {
            if (isset($val[$k]))
                $maskared .= $val[$k++];
        } else {
            if (isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

function tiraMoeda($string) {

    $pontos = array(",", ".");

    $result = str_replace($pontos, "", $string);

    return $result;
}

function RemoveArroba($string) {

    $pontos = array("@");

    $result = str_replace($pontos, "", $string);

    return $result;
}

function RemoveBarra($string) {

    $pontos = array("/");

    $result = str_replace($pontos, "", $string);

    return $result;
}

function corta_string($string = "", $inicio = 0, $tamanho = 0) {

    if (isset($tamanho) && $tamanho > 0) {

        return substr($string, $inicio, $tamanho);
    } else {

        return substr($string, $inicio);
    }
}

function conta_caracteres($string) {

    return strlen($string);
}

function validaCPF($cpf) {

    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

function validaemail($email) {
    //verifica se e-mail esta no formato correto de escrita
    /* if (!ereg('^([a-zA-Z0-9.-_])*([@])([a-z0-9]).([a-z]{2,3})', $email)) {
      $mensagem = 'E-mail Inv&aacute;lido!';
      return false;
      } else {
      //Valida o dominio
      $dominio = explode('@', $email);
      if (!checkdnsrr($dominio[1], 'A')) {

      return false;
      } else {
      return true;
      } // Retorno true para indicar que o e-mail é valido
      } */
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function PT_limpaCPF_CNPJ($valor) {

    $valor = trim($valor);

    $valor = str_replace(".", "", $valor);

    $valor = str_replace(",", "", $valor);

    $valor = str_replace("-", "", $valor);

    $valor = str_replace("_", "", $valor);

    $valor = str_replace("/", "", $valor);

    $valor = str_replace("(", "", $valor);

    $valor = str_replace(")", "", $valor);

    $valor = str_replace(" ", "", $valor);

    return $valor;
}

function PT_tira_ponto($valor) {

    $valor = trim($valor);

    $valor = str_replace(".", "", $valor);

    $valor = str_replace(" ", "", $valor);

    return $valor;
}

function troca_virgula_por_ponto($valor) {
    return str_replace(",", ".", $valor);
}

function transformaMoeda($valor) {

    $novoValor = number_format($valor / 100, 2, ".", "");

    return $novoValor;
}
