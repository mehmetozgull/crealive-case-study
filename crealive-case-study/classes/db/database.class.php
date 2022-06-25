<?php
namespace ccs\db;

class Database{
    private $MYSQL_HOST = 'localhost';
    private $MYSQL_USER = 'root';
    private $MYSQL_PASS = '';
    private $MYSQL_DB = 'ccs';
    private $CHARSET = 'utf8';
    private $COLLATION = 'utf8_general_ci';
    private $pdo = null;
    private $stmt = null;
    public $siteName = null;
    private function ConnectDB(){
        $SQL = "mysql:host=" . $this->MYSQL_HOST . ";dbname=" . $this->MYSQL_DB . ";charset=" . $this->CHARSET;
        try {
            $this->pdo = new \PDO($SQL, $this->MYSQL_USER, $this->MYSQL_PASS);
            $this->pdo->exec("SET NAMES '" . $this->CHARSET . "' COLLATE '" . $this->COLLATION . "'");
            $this->pdo->exec("SET CHARACTER SET '" . $this->CHARSET . "'");
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }catch (\PDOException $e){
            die($e->getMessage()); //Veritabanına ulaşılamadı hata!
        }
    }

    public function __construct() {
        $this->ConnectDB();
    }

    private function myQuery($query, $params=null){
        if (is_null($params)){
            $this->stmt = $this->pdo->query($query);
        }else{
            $this->stmt = $this->pdo->prepare($query);
            $this->stmt->execute($params);
        }
        return $this->stmt;
    }

    public function getRows($query, $params=null){
        //çoklu satır verilerini çekmek için
        try {
            return [$this->myQuery($query, $params)->rowCount(), $this->myQuery($query, $params)->fetchAll()];
        }catch (\PDOException $e){
            die($e->getMessage());
        }
    }

    public function getRow($query, $params=null){
        //tek satır veri çekmek için
        try {
            return [$this->myQuery($query, $params)->rowCount(), $this->myQuery($query, $params)->fetch()];
        }catch (\PDOException $e){
            die($e->getMessage());
        }
    }

    public function getColumn($query, $params=null){
        try {
            return $this->myQuery($query, $params)->fetchColumn();
        }catch (\PDOException $e){
            die($e->getMessage());
        }
    }

    public function dbInsert($query, $params=null){
        //kayıt eklemek için
        try {
            $this->myQuery($query, $params);
            return $this->pdo->lastInsertId();
        }catch (\PDOException $e){
            die($e->getMessage());
        }
    }
    public function dbUpdate($query,$params=null){
        //kayıt güncellemek için
        try{
            return $this->myQuery($query,$params)->rowCount();
        }catch(\PDOException $e){
            die($e->getMessage());
        }
    }

    public function dbDelete($query,$params=null){
        //kayıt silmek için
        try{
            return $this->myQuery($query,$params)->rowCount();
        }catch(\PDOException $e){
            die($e->getMessage());
        }
    }

    public function settings($value){
        $settings = $this->getRow("SELECT * FROM settings WHERE id = ? LIMIT ?", [1, 1]);
        return $settings[1][$value];
    }

    public function __destruct() {
        $this->pdo = null; // veritabanı bağlantısını kapat
    }

}
?>
