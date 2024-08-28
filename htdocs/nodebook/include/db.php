<?php

class DB
{
    private $_dbh;
    private $_stmt;

    private static $_instance = NULL;

    private function __construct()
    {
        $dsn = 'sqlite:../../database/nodebook.db';
        try {
            $this->_dbh = new PDO($dsn);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public static function getInstance() {
	if (!self::$_instance) {
            self::$_instance = new DB();
    	}
    	return self::$_instance;
    }

    public function sql($sql)
    {
        $this->_stmt = $this->_dbh->prepare($sql);
    }

    public function bind($pos, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->_stmt->bindValue($pos, $value, $type);
    }

    public function execute()
    {
        return $this->_stmt->execute();
    }

    public function resultset()
    {
        $this->execute();
        return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function singlerow()
    {
        $this->execute();
        return $this->_stmt->fetch(PDO::FETCH_ASSOC);
    }

    // returns last insert ID
    //!!!! if called inside a transaction, must call it before closing the transaction!!!!!!
    public function lastInsertId()
    {
        return $this->_dbh->lastInsertId();
    }

    // begin transaction // must be innoDatabase table
    public function beginTransaction()
    {
        return $this->_dbh->beginTransaction();
    }

    // end transaction
    public function endTransaction()
    {
        return $this->_dbh->commit();
    }

    // cancel transaction
    public function cancelTransaction()
    {
        return $this->_dbh->rollBack();
    }

    // returns number of rows updated, deleted, or inserted
    public function rowCount()
    {
        return $this->_stmt->rowCount();
    }

    public function debugDumpParams()
    {
        return $this->_stmt->debugDumpParams();
    }

}
?>
