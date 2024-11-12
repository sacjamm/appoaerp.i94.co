<?php

namespace App\Controllers;

use App\Libraries\ItauBoleto;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BoletoController extends BaseController
{
    public function emitir()
    {
        // Definir os dados do boleto com base no exemplo fornecido
        $dados_boleto = [
            'data' => [
                'etapa_processo_boleto' => 'efetivacao',
                'codigo_canal_operacao' => 'API',
                'beneficiario' => [
                    'id_beneficiario' => 'id_beneficiario_aqui'
                ],
                'dado_boleto' => [
                    'descricao_instrumento_cobranca' => 'boleto',
                    'forma_envio' => 'email',
                    'texto_endereco_email' => 'exemplo@itau.com.br',
                    'assunto_email' => 'Assunto do e-mail',
                    'mensagem_email' => 'Texto para enviar ao cliente',
                    'tipo_boleto' => 'a vista',
                    'codigo_carteira' => '109',
                    'valor_titulo' => '00000000000001000',
                    'codigo_especie' => '01',
                    'valor_abatimento' => '000',
                    'data_emissao' => '2024-09-21',
                    'pagamento_parcial' => true,
                    'quantidade_maximo_parcial' => 2,
                    'pagador' => [
                        'pessoa' => [
                            'nome_pessoa' => 'Pessoa teste',
                            'tipo_pessoa' => [
                                'codigo_tipo_pessoa' => 'F',
                                'numero_cadastro_pessoa_fisica' => '12345678909'
                            ]
                        ],
                        'endereco' => [
                            'nome_logradouro' => 'Rua endereço, 71',
                            'nome_bairro' => 'Bairro',
                            'nome_cidade' => 'Cidade',
                            'sigla_UF' => 'PE',
                            'numero_CEP' => '51340540'
                        ]
                    ],
                    'dados_individuais_boleto' => [
                        [
                            'numero_nosso_numero' => '20000000',
                            'data_vencimento' => '2024-10-14',
                            'valor_titulo' => '00000000000119900',
                            'texto_uso_beneficiario' => '2',
                            'texto_seu_numero' => '2'
                        ]
                    ],
                    'multa' => [
                        'codigo_tipo_multa' => '02',
                        'data_multa' => '2024-09-21',
                        'percentual_multa' => '000000100000'
                    ],
                    'juros' => [
                        'codigo_tipo_juros' => 90,
                        'data_juros' => '2024-09-21',
                        'percentual_juros' => '000000100000'
                    ],
                    'recebimento_divergente' => [
                        'codigo_tipo_autorizacao' => '01'
                    ],
                    'instrucao_cobranca' => [
                        [
                            'codigo_instrucao_cobranca' => '2',
                            'quantidade_dias_apos_vencimento' => 10,
                            'dia_util' => false
                        ]
                    ],
                    'protesto' => [
                        'protesto' => true,
                        'quantidade_dias_protesto' => 10
                    ],
                    'desconto_expresso' => false
                ]
            ]
        ];

        // Inicializando a classe ItauBoleto e passando o token da API
        $token = 'seu_token_aqui';
        $itauBoleto = new ItauBoleto($token);

        // Enviando a requisição para emitir o boleto
        $resposta = $itauBoleto->emitirBoleto($dados_boleto);

        // Retornando a resposta como JSON
        return $this->response->setStatusCode($resposta['status'])
                              ->setJSON($resposta['response']);
    }
}

