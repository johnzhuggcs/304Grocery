<?php
/**
 * Created by PhpStorm.
 * User: johnz
 * Date: 2018-03-26
 * Time: 10:30 PM
 */

class ConnectionController
{
//this tells the system that it's no longer just parsing
//html; it's now parsing PHP

    private static $instance;


    function ConnectionController(){
        global $db_conn, $success;
        $success = True;
        $db_conn = OCILogon("ora_f8s0b", "a40642100", "dbhost.ugrad.cs.ubc.ca:1522/ug");
    }

    public static function getConnectionInstance(){
        if(!isset(self::$instance)){
            echo "recreate Connection";
            self::$instance = new ConnectionController();
        }
        return self::$instance;
    }



}

?>