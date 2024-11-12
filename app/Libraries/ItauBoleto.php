<?php

namespace App\Libraries;

class ItauBoleto {

    private $api_url = 'https://api.itau.com.br/cash_management/v2/boletos'; // URL de emissão de boletos (produção ou sandbox)
    private $token = ''; // O token de autenticação para acessar a API

    // Construtor para inicializar a classe com o token de API
    public function __construct($token) {
        $this->token = $token;
    }

    // Função para emitir o boleto
    public function emitirBoleto($dados_boleto) {
        // Configuração da requisição cURL
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $this->token, // Token de autenticação
                "Content-Type: application/json"
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($dados_boleto), // Corpo da requisição em JSON
        ]);

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Código de resposta HTTP

        if (curl_errno($curl)) {
            return ['error' => curl_error($curl)];
        }

        curl_close($curl);

        // Tratamento da resposta da API
        return [
            'status' => $http_code,
            'response' => json_decode($response, true)
        ];
    }
}
