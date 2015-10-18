<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 15/10/15
 * Time: 12:33
 */

class Dbase{


    private $_host = "localhost";
    private $_user = "root";
    private $_password = "123456";
    private $_dbname = "ecommerce";

    private $_conndb = false;
    public $_last_query = null;
    public $_affected_rows = 0;

    public $_insert_keys = array();
    public $_insert_values = array();
    public $_update_sets = array();

    public $_id;



    public function __construct(){

        $this -> connect();
    }


    private function connect(){

        $this -> _conndb = mysqli_connect($this -> _host, $this -> _user, $this -> _password);

        if(!$this -> _conndb) {
            die("Database connection failed: <BR /> " . mysqli_error());

        }
        else{
            $_select = mysqli_select_db($this -> _dbname, $this -> _conndb);

            if(!$_select){
                die("Database selection failed:<BR />" . mysqli_error());
            }

        }
        mysqli_set_charset("utf8", $this -> _conndb);

    }

    public function close(){

        if(!mysqli_close($this -> _conndb)) {

            die("Closing connection failed");
        }

    }

    public function escape($value){

        if(function_exists("mysqli_real_escape_string")){

            if(get_magic_quotes_gpc()){
                $value = stripslashes($value);
            }
            $value = mysqli_real_escape_string($value);

        }
        else{
            if(!get_magic_quotes_gpc()){
                $value = addcslashes($value);
            }
        }

        return $value;

    }

    public function query($sql){
        $this -> _last_query = $sql;

        $result = mysqli_query($sql, $this -> _conndb);

        $this -> displayQuery($result);

        return $result;
    }

    public function displayQuery($result){
        if(!$result){
            $output = "Database query failed:" . mysqli_error() . "<BR />";
            $output .= "Last SQL query was: " . $this -> _last_query;
            die($output);

        }
        else{

            $this -> _affected_rows = mysqli_affected_rows($this -> _conndb);
        }
    }

    public function fetchAll($sql){
        $result = $this->query($sql);
        $out = array();

        while($row = mysqli_fetch_assoc($result)){

            $out[] = $row;
        }
        mysqli_free_result($result);
        return $out;


    }

    public function fetchOne($sql){
        $out = $this->fetchAll($sql);
        return array_shift($out);
    }

    public function lastId(){

        return mysqli_insert_id($this -> _conndb);

}

}