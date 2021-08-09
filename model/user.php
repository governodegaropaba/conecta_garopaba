<?php
require('classes/class.MySQL.php');

class UserModel {

    private static $_pdo = NULL;

    public function __construct() {
        self::$_pdo = MySQL::instance();
    }
}