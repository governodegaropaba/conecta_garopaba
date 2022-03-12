<?php
require('classes/class.MySQL.php');

class UserModel {

    private static $_pdo = NULL;

    public function __construct() {
        self::$_pdo = MySQL::instance();
    }

    /**
     * Verifica se o CPF está cadastrado na tabela 'users'
     */
    public function checkIfUserExists($cpf) {
        $obj = MySQL::loadResult('SELECT COUNT(cpf) FROM users WHERE cpf = "' . $cpf . '"');
        return $obj > 0;
    }

    /**
     * Verifica se os dados de login estão corretos na tabela 'radcheck'
     */
    public function checkUserLogin($cpf, $dataNasc) {
        $obj = MySQL::loadResult('SELECT COUNT(id) FROM radcheck WHERE username = "' . $cpf . '" AND value = "' . md5($dataNasc) . '"');
        return $obj > 0;
    }

    /**
     * Cadastra um usuário
     */
    public function addUser($cpf, $dataNasc, $email, $nome) {
        return 
            MySQL::execQuery('INSERT INTO users (cpf, name, datanasc, email, createdate) VALUES ("' . $cpf . '", "' . $nome . '", "' . $dataNasc . '", "' . $email . '", NOW())') &&
            MySQL::execQuery('INSERT INTO radcheck (username, attribute, op, value) VALUES ("' . $cpf . '", "MD5-Password", ":=", "' . md5($dataNasc) . '")');
    }
}