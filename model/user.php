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
    public function checkUserLogin($cpf, $data_nasc) {
        $obj = MySQL::loadResult('SELECT COUNT(id) FROM radcheck WHERE username = "' . $cpf . '" AND value = "' . md5($data_nasc) . '"');
        return $obj > 0;
    }

}