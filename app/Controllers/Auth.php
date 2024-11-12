<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Cookie\Cookie;

class Auth extends BaseController {

    public function login() {

        if (session()->get('loggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view(TEMPLATE . '/auth/login');
    }

    public function loginAuth() {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('Usuario');
            $senha = $this->request->getPost('SenhaUsuario');

            $authModel = new \App\Models\Auth();

            // Verifica as credenciais do usuário
            $auth = $authModel->verifyUser($email, $senha);

            if ($auth) {
                // Cria a sessão do usuário
                session()->set('loggedIn', true);
                session()->set('userId', $auth->id);
                session()->set('usuario', $auth->Usuario);
                session()->set('nivel', $auth->TipoUsuario);
                session()->set('NivelUsuario', $auth->NivelUsuario);

                $this->getPermissions($auth->permissoes); // Função que retorna as permissões do usuário
                // Criar um cookie para manter o login ativo por 7 dias
                $cookie = [
                    'name' => 'rememberLogin',
                    'value' => json_encode([
                        'userId' => $auth->id,
                        'usuario' => $auth->Usuario,
                        'nivel' => $auth->TipoUsuario,
                        'NivelUsuario' => $auth->NivelUsuario,
                        'permissoes' => $auth->permissoes,
                    ]),
                    'expire' => 60 * 60 * 24 * 30, // 7 dias
                    'path' => '/',
                    'secure' => true, // true se o site usar HTTPS
                    'httponly' => true
                ];
                $this->response->setCookie($cookie['name'], $cookie['value'], $cookie['expire'], $cookie['path'], $cookie['httponly'], $cookie['secure']);

                return redirect()->to('/dashboard'); // Redireciona para o painel de controle ou página inicial
            } else {
                $data['error'] = 'Credenciais inválidas';
                session()->setFlashdata('error', 'Dados inválidos.');
                return redirect()->to(site_url('auth/login'));
            }
        }

        echo view('login', $data ?? []);
    }

    public function checkLogin() {
        if (!session()->get('loggedIn')) {
            $rememberLogin = $this->request->getCookie('rememberLogin');
            if ($rememberLogin) {
                // Restaurar sessão a partir do cookie
                $userData = json_decode($rememberLogin, true);
                session()->set('loggedIn', true);
                session()->set('userId', $userData['userId']);
                session()->set('usuario', $userData['usuario']);
                session()->set('nivel', $userData['nivel']);
                session()->set('NivelUsuario', $userData['NivelUsuario']);

                $this->getPermissions($userData['permissoes']); // Função que retorna as permissões do usuário

                return redirect()->to('/dashboard');
            } else {
                return redirect()->to('/auth/login');
            }
        }
    }

    public function forgot() {
        return view(TEMPLATE . '/auth/forgot');
    }

    public function forgotAuth() {
        echo 'forgot';
    }

    public function register() {
        return view(TEMPLATE . '/auth/register');
    }

    public function registerAuth() {
        echo 'register';
    }

    public function createPassword($password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getPermissions($permissoes) {
        // Verifica se a permissao existe
        if ($permissoes) {
            session()->set('user_permissions', $permissoes);
            return unserialize($permissoes);
        }
        // Retorna falso caso o usuário não exista ou não tenha permissões
        return false;
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
