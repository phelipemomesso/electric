<?php
class Momesso_Plugins_Boleto extends Zend_Controller_Plugin_Abstract {

    public $documentoFranqueado = '';
    public $agencia = '';
    public $conta = '';
    public $dv = '';
    public $data_vencimento = '';
    public $data_processamento = '';
    public $valor = '';
    public $nosso_numero = '';
    public $doumento = '';
    public $sacado = '';
    public $endereco_sacado1 = '';
    public $endereco_sacado2 = '';

    function Boleto() {

        $taxa_boleto = 0;
        $valor_cobrado = number_format($this->valor, 2, ',', ''); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
        $valor_cobrado = str_replace(",", ".", $valor_cobrado);
        $valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

        $dadosboleto["nosso_numero"] = $this->nosso_numero;  // Nosso numero - REGRA: Máximo de 8 caracteres!
        $dadosboleto["numero_documento"] = $this->nosso_numero; // Num do pedido ou nosso numero
        $dadosboleto["data_vencimento"] = $this->setData($this->data_vencimento, 2); // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
        $dadosboleto["data_documento"] = $this->setData($this->data_processamento, 2); // Data de emissão do Boleto
        $dadosboleto["data_processamento"] = $this->setData($this->data_processamento, 2); // Data de processamento do boleto (opcional)
        $dadosboleto["valor_boleto"] = $valor_boleto;  // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

        // DADOS DO SEU CLIENTE
        $dadosboleto["cpf"] = $this->documento;
        $dadosboleto["sacado"] = $this->sacado;
        $dadosboleto["endereco1"] = $this->endereco_sacado1;
        $dadosboleto["endereco2"] = $this->endereco_sacado2;

        // INFORMACOES PARA O CLIENTE
        $dadosboleto["demonstrativo1"] = "";
        $dadosboleto["demonstrativo2"] = "";
        $dadosboleto["demonstrativo3"] = "";

        $dadosboleto["instrucoes1"] = "- Não receber após 3 dias do vencimento.";
        $dadosboleto["instrucoes2"] = "";
        $dadosboleto["instrucoes3"] = "";
        $dadosboleto["instrucoes4"] = "";

        // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
        $dadosboleto["quantidade"] = "";
        $dadosboleto["valor_unitario"] = "";
        $dadosboleto["aceite"] = "";
        $dadosboleto["uso_banco"] = "";
        $dadosboleto["especie"] = "R$";
        $dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //

        $dadosboleto["agencia"] = '6387'; // Num da agencia, sem digito
        $dadosboleto["conta"] = '01200'; // Num da conta, sem digito
        $dadosboleto["conta_dv"] = '5';  // Digito do Num da conta

        // DADOS PERSONALIZADOS - ITAÚ
        $dadosboleto["carteira"] = "175";  // Código da Carteira

        // SEUS DADOS
        $dadosboleto["identificacao"] = "Electric Ink";
        $dadosboleto["cpf_cnpj"] = '08.244.232/0001-05';
        $dadosboleto["telefone"] = '+55 (34) 3312-8788';
        $dadosboleto["endereco"] = 'Rua Passa Quatro - nº 398 - Bairro Bom Retiro';
        $dadosboleto["cidade_uf"] = 'Uberaba / Minas Gerais';
        $dadosboleto["cedente"] = "Electric Ink";
        $dadosboleto["site"] = "www.electricink.com.br";
        $dadosboleto["email"] = 'contato@electricink.com.br';

        // NAO ALTERAR!
        include("include/funcoes_itau.php");
        include("include/layout_itau.php");
    }

    private function setData($data, $tipo) {

        $date = new Zend_Date($data);

        if ($tipo == 1)
            return $date->toString('YYYY-MM-dd');
        else
            return $date->toString('dd/MM/YYYY');
    }

}

?>
