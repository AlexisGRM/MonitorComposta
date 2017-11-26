<?php
    class MySqlConnection{
        public static function getConnection(){
            //connection parameters
            $server = 'localhost';
            $user = 'root';
            $password = '';
            $database = 'testdatos';

            //create connection
            $connection = mysql_connect($server,$user,$password,$database);
            //return connection
            return $connection;
        }
    }
?>