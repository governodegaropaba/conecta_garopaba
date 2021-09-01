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
    foreach ($objContent as $obj) {
        error_log(serialize($obj));
        if ($obj->name === 'username') {
            $cpf = $obj->value;
        } else if ($obj->name === 'password') {
            $dataNasc = $obj->value;
            //} else {
            //    return ret('Ocorreu um erro (Cod.: USR03)');
        }
    }

    if ($cpf === '' || $dataNasc === '') {
        return ret('Ocorreu um erro (Cod.: USR04)');
    }

    // Registrando dados no log
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
    // Verificando os parâmetros recebidos
    $cpf = "";
    $dataNasc = "";
    $email = "";
    $nome = "";
    foreach ($objContent as $obj) {
        error_log(serialize($obj));
        if ($obj->name === 'username') {
            $cpf = $obj->value;
        } else if ($obj->name === 'password') {
            $dataNasc = $obj->value;
        } else if ($obj->name === 'email') {
            $email = $obj->value;
        } else if ($obj->name === 'name') {
            $nome = $obj->value;
            //} else {
            //    return ret('Ocorreu um erro (Cod.: USR03)');
        }
    }

    if ($cpf === '' || $dataNasc === '' || $email === '' || $nome === '') {
        return ret('Ocorreu um erro (Cod.: USR005)');
    }

    // Registrando dados no log
    error_log('CPF: [' . $cpf . '] | Data Nasc: [' . $dataNasc . '] | Email: [' . $email . '] | Nome: [' . $nome . ']');

    // Verifica se o CPF está cadastrado
    if ($model->checkIfUserExists($cpf)) {
        return ret('Usuário já cadastrado');
    }

    // Verifica se o CPF é válido
    if (!validaCPF($cpf)) {
        return ret('CPF inválido');
    }

    // Realiza o cadastro no BD
    if (!$model->addUser($cpf, $dataNasc, $email, $nome)) {
        return ret('Ocorreu um erro (Cod.: USR006');
    }

    // - @todo: Dispara e-mail de boas vindas

    // Validação realizada com sucesso. Retorna OK
    return ret('Cadastro realizado com sucesso.', 'SUCCESS');
} else {
    ret('Função inválida (usr-03');
}

/**
 * Verifica se um CPF é válido
 * From: https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
 */
function validaCPF($cpf)
{

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

/**
 * Retorna o objeto de dados para o solicitante
 */
function ret($msgResult, $result = 'ERROR', $format = 'json')
{
    error_log('msgResult:' . $msgResult);
    if ($format === 'json') {
        header('Content-Type: application/json');
        echo '{"result":"' . $result . '", "msg_result":"' . $msgResult . '"}';
    } else {
        die($msgResult);
    }
}
