<?php
/**
 * 
 * @author Roberto Abreu Bento
 *
 * Recebe a solicitação de acesso ou cadastro na plataforma
 * 
 */
session_start();
ini_set('error_log', __DIR__.'/log/hotspot.log');
require('../model/user.php');

/**
 * Leitura dos parâmetros
 */
error_log(serialize($_GET));
$data = new stdClass();
$data->basedir = dirname(__FILE__).DS;
$data->task = filter_input(INPUT_GET, 'task'); // FUNÇÃO A SER ACIONADA
$data->content = filter_input(INPUT_GET, 'content'); // DADOS DO FORMULÁRIO

if (trim($$data->content) === '' || trim($data->task) === '') {
    error('Faltou parâmetro (usr-01).');
} else {
    $obj_content = json_decode($data->content);
    if (!$obj_content) {
        error('Dados de conteúdo inválidos (usr-02).');
    }
}

// INICIANDO INSTÂNCIA DO MODEL
$model = new UserModel();

// REALIZA O TRATAMENTO DOS DADOS DE ACORDO COM O 'TASK'
if ($data->task === 'login_user') {
    // VALIDA O LOGIN DO USUÁRIO
    // - Recebe dados de CPF e Data de Nascimento
    // - Valida no BD se os dados existem e estão válidos
    // - Retorna OK ou ERRO
} elseif ($data->task === 'create_user') {
    // REALIZA O CADASTRO DE UM USUÁRIO
    // - Recebe nome completo, CPF, e-mail e Data Nascimento
    // - Verifica se já existe o CPF ou e-mail cadastrado
    // - Verifica se o CPF é válido.
    // - Insere os dados no BD
    // - Dispara e-mail de boas vindas
} else {
    error('Função inválida (usr-03');
}
    

function error($msgResult,$format = 'json') {
    error_log('msgResult:'.$msgResult);
    if ($format === 'json') {
        header('Content-Type: application/json');
        echo '{"result":"ERROR", "msg_result":"'.$msgResult.'"}';
    } else {
        die($msgResult);
    }
}