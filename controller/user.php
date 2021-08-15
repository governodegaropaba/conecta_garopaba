<?php
/**
 * 
 * @author Roberto Abreu Bento <dti@garopaba.sc.gov.br>
 *
 * Recebe a solicitação de acesso ou cadastro na plataforma
 * 
 * Mapa de Erros
 * 
 * USR01 - Algum parâmetro obrigatório na consulta não foi informado
 * USR02 - Dados do formulário em um formato inválido
 * USR03 - Algum parâmetro do formulário é inválido ou desconhecido
 * USR04 - Algum parâmetro obrigatório do formulário vazio
 * USR05 - CPF não encontrato na tabela de usuários
 * USR06 - CPF ou Data Nascimento incorretos
 */
session_start();
require('../model/user.php');

/**
 * Leitura dos parâmetros
 */
error_log(serialize($_GET));
error_log(serialize($_POST));

$data = new stdClass();
$data->task = filter_input(INPUT_POST, 'task'); // Função a ser acionada
$data->content = filter_input(INPUT_POST, 'content'); // Dados do formulário preenchido

if (trim($data->content) === '' || trim($data->task) === '') {
    return ret('Ocorreu um erro (Cod.: USR01).');
} else {
    $objContent = json_decode($data->content);
    if (!$objContent) {
        return ret('Ocorreu um erro (Cod.: USR02).');
    }
}

// Inicia uma instância do Model para consulta no BD
$model = new UserModel();

// Realiza o tratamento de acordo com a 'task'
if ($data->task === 'login_user') {
    // Verificando os parâmetros recebidos
    $cpf = "";
    $dataNasc = "";    
    foreach($objContent as $obj) {
        error_log(serialize($obj));
        if ($obj->name === 'cpf') {
            $cpf = $obj->value;
        } else if ($obj->name === 'data_nasc') {
            $dataNasc = $obj->value;
        } else {
            return ret('Ocorreu um erro (Cod.: USR03)');
        }
    }

    if ($cpf === '' || $dataNasc === '') {
        return ret('Ocorreu um erro (Cod.: USR04)');
    }

    // Corrigindo CPF
    $cpf = str_replace(array('.','-'), '', $cpf);
    error_log('CPF: [' . $cpf . '] | Data Nasc: [' . $dataNasc . ']');

    // Verifica se o CPF está cadastrado
    if (!$model->checkIfUserExists($cpf)) {
        return ret('Usuário não cadastrado');
    }
    // Verifica se usuário e senha estão corretos na tabela 'radcheck'
    if (!$model->checkUserLogin($cpf, $dataNasc)) {
        return ret('Dados inválidos');
    }

    // Validação realizada com sucesso. Retorna OK
    return ret('Login realizado com sucesso', 'SUCCESS');
    
} elseif ($data->task === 'create_user') {
    // REALIZA O CADASTRO DE UM USUÁRIO
    // - Recebe nome completo, CPF, e-mail e Data Nascimento
    // - Verifica se já existe o CPF ou e-mail cadastrado
    // - Verifica se o CPF é válido.
    // - Insere os dados no BD
    // - Dispara e-mail de boas vindas
} else {
    ret('Função inválida (usr-03');
}

/**
 * Retorna o objeto de dados para o solicitante
 */
function ret($msgResult,$result = 'ERROR', $format = 'json') {
    error_log('msgResult:'.$msgResult);
    if ($format === 'json') {
        header('Content-Type: application/json');
        echo '{"result":"' . $result . '", "msg_result":"'.$msgResult.'"}';
    } else {
        die($msgResult);
    }
}