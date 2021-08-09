<?php

/**
 * Gerenciamento do banco de dados formato MySQL com PDO - PHP Data Object
 *
 * @author Roberto Bento
 */
class MySQL {

    private static $pdo = NULL;
    private static $db_hostname = 'localhost';
    private static $db_database = 'radius';
    private static $db_username = 'danilo';
    private static $db_password = 'unisul1011';

    /**
     * Retorna uma instância do objeto PDO
     * @return type
     */
    public static function instance() {
        if (!self::$pdo) {
            try {
                self::$pdo = new PDO("mysql:host=" . self::$db_hostname . ";dbname=" . self::$db_database, self::$db_username, self::$db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                error_log('Erro ao iniciar objeto PDO: ' . $e->getMessage());
                return FALSE;
            }
        }
        return self::$pdo;
    }

    /**
     * Função privada - Executa um comando no banco de dados
     * @param String $query
     * @param String|Array|Object $params
     * @param Class $pdoInstance
     * @return boolean
     */
    private static function _execute($query, $params, $pdoInstance = NULL) {
        error_log('Chegou: [' . $query . ']');
        //error_log(serialize($params));
        try {
            $pdo = (!isset($pdoInstance) || $pdoInstance === NULL) ? self::instance() : $pdoInstance;
            $stmt = $pdo->prepare($query);
            return self::_bind($stmt, $params);
        } catch (Exception $e) {
            error_log('Falha ao executar comando no PDO: ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * Organiza os parâmetros e executa o comando
     * Acionando via função _execute
     * @param Class $stmt
     * @param String|Array|Object $params
     * @return Object
     */
    private static function _bind($stmt, $params = NULL) {
        if (is_object($params)) {
            // Parâmetro em formato de objeto, com o nome da chave a ser substituída
            foreach ($params as $key => $value) {
                if(is_null($value) || $value==='NULL'){
                    $stmt->bindValue($key, NULL, PDO::PARAM_STR);
                } else {
                    $stmt->bindValue($key, $value);
                }
            }
            $stmt->execute();
        } else if (is_array($params)) {
            // Array de parâmetros, sendo a troca sequencial
            $stmt->execute($params);
        } else {
            // Parametro único / Sem parâmetros
            $stmt->execute(array($params));
        }
        // Comandos de debug - mostra a lista de parâmetros enviados para a execução
        //ob_start();
        //$stmt->debugDumpParams();
        //error_log(ob_get_clean());
        /*         * ******************************** */
        return $stmt;
    }

    /**
     * FUNÇÕES PÚBLICAS E ESTÁTICAS, ACIONADAS PELO USUÁRIO
     */

    /**
     * Retorna a primeira coluna da primeira linha consultada
     * @param String $query
     * @param String|Array|Object $params
     * @return String|Boolean
     */
    public static function loadResult($query, $params = NULL) {
        $stmt = self::_execute($query, $params);
        if ($stmt !== FALSE) {
            try {
                return $stmt->fetchColumn();
            } catch (Exception $e) {
                error_log('[DGSQL::loadResult] Falha ao processar dados: ' . $e->getMessage());
                return FALSE;
            }
        } else {
            error_log('[DGSQL::loadResult] Não foi possível realizar a consulta via PDO');
            return FALSE;
        }
    }

    /**
     * Retorna um objeto com a primeira linha consultada
     * @param String $query
     * @param String|Array|Object $params
     * @return boolean|\stdClass
     */
    public static function loadObject($query, $params = NULL) {
        $stmt = self::_execute($query, $params);
        if ($stmt !== FALSE) {
            try {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $objReturn = new stdClass();
                foreach ($row as $key => $value) {
                    $objReturn->{$key} = $value;
                }
                return $objReturn;
            } catch (Exception $e) {
                error_log('[DGSQL::loadObject] Falha ao processar dados: ' . $e->getMessage());
                return FALSE;
            }
        } else {
            error_log('[DGSQL::loadObject] Não foi possível realizar a consulta via PDO');
            return FALSE;
        }
    }

    /**
     * Retorna um array de dados, com cada linha sendo representada por um objeto
     * @param String $query
     * @param String|Array|Object $params
     * @return boolean|array
     */
    public static function loadObjectList($query, $params = NULL) {
        $stmt = self::_execute($query, $params);
        if ($stmt !== FALSE) {
            try {
                $objReturn = array();
                $objLine = new stdClass();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $objLine = new stdClass();
                    foreach ($row as $key => $value) {
                        $objLine->{$key} = $value;
                    }
                    array_push($objReturn, $objLine);
                }
                return $objReturn;
            } catch (Exception $e) {
                error_log('[DGSQL::loadObjectList] Falha ao processar dados: ' . $e->getMessage());
                return FALSE;
            }
        } else {
            error_log('[DGSQL::loadObjectList] Não foi possível realizar a consulta via PDO');
            return FALSE;
        }
    }

    /**
     * Retorna um array de dados, com cada linha sendo representada por um outro array
     * @param String $query
     * @param String|Array|Object $params
     * @param String $key
     * @return boolean|array
     */
    public static function loadArrayList($query, $params = NULL, $key = NULL) {
        $stmt = self::_execute($query, $params);
        if ($stmt !== FALSE) {
            try {
                $objReturn = array();
                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                    if ($key) {
                        array_push($objReturn[$row[$key]], $row);
                    } else {
                        array_push($objReturn, $row);
                    }
                }
                return $objReturn;
            } catch (Exception $e) {
                error_log('[DGSQL::loadArrayList] Falha ao processar dados: ' . $e->getMessage());
                return FALSE;
            }
        } else {
            error_log('[DGSQL::loadArrayList] Não foi possível realizar a consulta via PDO');
            return FALSE;
        }
    }

    /**
     * Retorna a quantidade de linhas obtidas na consulta
     * @param String $query
     * @param String|Array|Object $params
     * @return boolean|Integer
     */
    public static function loadNumRows($query, $params = NULL) {
        $stmt = self::_execute($query, $params);
        if ($stmt !== FALSE) {
            try {
                $objReturn = 0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $objReturn++;
                }
                return $objReturn;
            } catch (Exception $e) {
                DGLog::add(DGLog::ERROR, '[DGSQL::loadNumRows] Falha ao processar dados: ' . $e->getMessage());
                return FALSE;
            }
        } else {
            DGLog::add(DGLog::ERROR, '[DGSQL::loadNumRows] Não foi possível realizar a consulta via PDO');
            return FALSE;
        }
    }

    /**
     * Executa um comando no banco de dados
     * @param String $query
     * @param String|Array|Object $params
     * @return boolean
     */
    public static function execQuery($query, $params = NULL) {
        $stmt = self::_execute($query, $params);
        if ($stmt !== FALSE) {
            return TRUE;
        } else {
            DGLog::add(DGLog::ERROR, '[DGSQL::execQuery] Não foi possível realizar a consulta via PDO');
            return FALSE;
        }
    }
    
    /**
     * Verifica a existência de uma tabela no banco de dados
     * @param String $table
     * @return boolean
     */
    public static function checkTableExists($table) {
        try {
            return self::loadNumRows('SHOW TABLES FROM ' . ConfigSQL::DATABASE . ' LIKE ?', $table) > 0;
        } catch (Exception $e) {
            DGLog::add(DGLog::ERROR, '[DGSQL::checkTableExists] Falha ao processar dados: ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * Verifica a existência de uma coluna em uma tabela do banco de dados
     * @param String $table
     * @param String $column
     * @return boolean
     */
    public static function checkColumnExist($table, $column) {
        try {
            return self::loadNumRows('SHOW COLUMNS FROM ' . $table . ' LIKE ?', $column) > 0;
        } catch (Exception $e) {
            DGLog::add(DGLog::ERROR, '[DGSQL::checkColumnExist] Falha ao processar dados: ' . $e->getMessage());
            return FALSE;
        }
    }
    
    /**
     * Retorna o último ID auto-increment registrado no banco de dados
     * @return type
     */
    public static function insertId() {
        return self::$pdo->lastInsertId();
    }

}
