<?php
require('classes/class.MySQL.php');

class UserModel {

    private static $_pdo = NULL;

    public function __construct() {
        self::$_pdo = MySQL::instance();
    }

    public function checkIfUserExists($cpf) {
        $obj = MySQL::loadResult('SELECT COUNT(cpf) FROM users WHERE cpf = "' . $cpf . '"');
        return $obj > 0;
        
    }
}